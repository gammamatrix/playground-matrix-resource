<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Matrix\Resource\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\View\View;
use Playground\Matrix\Models\Backlog;
use Playground\Matrix\Resource\Http\Requests;
use Playground\Matrix\Resource\Http\Resources;

/**
 * \Playground\Matrix\Resource\Http\Controllers\BacklogController
 */
class BacklogController extends Controller
{
    /**
     * @var array<string, string>
     */
    public array $packageInfo = [
        'model_attribute' => 'title',
        'model_label' => 'Backlog',
        'model_label_plural' => 'Backlogs',
        'model_route' => 'playground.matrix.resource.backlogs',
        'model_slug' => 'backlog',
        'model_slug_plural' => 'backlogs',
        'module_label' => 'Matrix',
        'module_label_plural' => 'Matrices',
        'module_route' => 'playground.matrix.resource',
        'module_slug' => 'matrix',
        'privilege' => 'playground-matrix-resource:backlog',
        'table' => 'matrix_backlogs',
        'view' => 'playground-matrix-resource::backlog',
    ];

    /**
     * Create the Backlog resource in storage.
     *
     * @route GET /resource/matrix/backlogs/create playground.matrix.resource.backlogs.create
     */
    public function create(
        Requests\Backlog\CreateRequest $request
    ): JsonResponse|View|Resources\Backlog {

        $validated = $request->validated();

        $user = $request->user();

        $backlog = new Backlog($validated);

        if ($request->expectsJson()) {
            return (new Resources\Backlog($backlog))->additional(['meta' => [
                'info' => $this->packageInfo,
            ]])->response($request);
        }

        $meta = [
            'session_user_id' => $user?->id,
            'id' => null,
            'timestamp' => Carbon::now()->toJson(),
            'validated' => $validated,
            'info' => $this->packageInfo,
        ];

        $meta['input'] = $request->input();
        $meta['validated'] = $request->validated();

        $data = [
            'data' => $backlog,
            'meta' => $meta,
            '_method' => 'post',
        ];

        $flash = $backlog->toArray();

        if (! empty($validated['_return_url'])) {
            $flash['_return_url'] = $validated['_return_url'];
            $data['_return_url'] = $validated['_return_url'];
        }

        if (! $request->session()->has('errors')) {
            session()->flashInput($flash);
        }

        return view(sprintf('%1$s/form', $this->packageInfo['view']), $data);
    }

    /**
     * Edit the Backlog resource in storage.
     *
     * @route GET /resource/matrix/backlogs/edit playground.matrix.resource.backlogs.edit
     */
    public function edit(
        Backlog $backlog,
        Requests\Backlog\EditRequest $request
    ): JsonResponse|View|Resources\Backlog {

        $validated = $request->validated();

        $user = $request->user();

        if ($request->expectsJson()) {
            return (new Resources\Backlog($backlog))->additional(['meta' => [
                'info' => $this->packageInfo,
            ]])->response($request);
        }

        $flash = $backlog->toArray();

        if (! empty($validated['_return_url'])) {
            $flash['_return_url'] = $validated['_return_url'];
            $data['_return_url'] = $validated['_return_url'];
        }

        $meta = [
            'session_user_id' => $user?->id,
            'id' => $backlog->id,
            'timestamp' => Carbon::now()->toJson(),
            'validated' => $validated,
            'info' => $this->packageInfo,
        ];

        $meta['input'] = $request->input();
        $meta['validated'] = $request->validated();

        $data = [
            'data' => $backlog,
            'meta' => $meta,
            '_method' => 'patch',
        ];

        session()->flashInput($flash);

        return view(sprintf('%1$s/form', $this->packageInfo['view']), $data);
    }

    /**
     * Remove the Backlog resource from storage.
     *
     * @route DELETE /resource/matrix/{backlog} playground.matrix.resource.backlogs.destroy
     */
    public function destroy(
        Backlog $backlog,
        Requests\Backlog\DestroyRequest $request
    ): Response|RedirectResponse {

        $validated = $request->validated();

        $user = $request->user();

        if ($user?->id) {
            $backlog->modified_by_id = $user->id;
        }

        if (empty($validated['force'])) {
            $backlog->delete();
        } else {
            $backlog->forceDelete();
        }

        if ($request->expectsJson()) {
            return response()->noContent();
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl && is_string($returnUrl)) {
            return redirect($returnUrl);
        }

        return redirect(route($this->packageInfo['model_route']));
    }

    /**
     * Lock the Backlog resource in storage.
     *
     * @route PUT /resource/matrix/{backlog} playground.matrix.resource.backlogs.lock
     */
    public function lock(
        Backlog $backlog,
        Requests\Backlog\LockRequest $request
    ): JsonResponse|RedirectResponse|Resources\Backlog {

        $validated = $request->validated();

        $user = $request->user();

        if ($user?->id) {
            $backlog->modified_by_id = $user->id;
        }

        $backlog->locked = true;

        $backlog->save();

        $meta = [
            'session_user_id' => $user?->id,
            'id' => $backlog->id,
            'timestamp' => Carbon::now()->toJson(),
            'info' => $this->packageInfo,
        ];

        if ($request->expectsJson()) {
            return (new Resources\Backlog($backlog))->additional(['meta' => [
                'info' => $this->packageInfo,
            ]])->response($request);
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl && is_string($returnUrl)) {
            return redirect($returnUrl);
        }

        return redirect(route(sprintf(
            '%1$s.show',
            $this->packageInfo['model_route']
        ), ['backlog' => $backlog->id]));
    }

    /**
     * Display a listing of Backlog resources.
     *
     * @route GET /resource/matrix playground.matrix.resource.backlogs
     */
    public function index(
        Requests\Backlog\IndexRequest $request
    ): JsonResponse|View|Resources\BacklogCollection {

        $user = $request->user();

        $validated = $request->validated();

        $query = Backlog::addSelect(sprintf('%1$s.*', $this->packageInfo['table']));

        $query->sort($validated['sort'] ?? null);

        if (! empty($validated['filter']) && is_array($validated['filter'])) {

            $query->filterTrash($validated['filter']['trash'] ?? null);

            $query->filterIds(
                $request->getPaginationIds(),
                $validated
            );

            $query->filterFlags(
                $request->getPaginationFlags(),
                $validated
            );

            $query->filterDates(
                $request->getPaginationDates(),
                $validated
            );

            $query->filterColumns(
                $request->getPaginationColumns(),
                $validated
            );
        }

        $perPage = ! empty($validated['perPage']) && is_int($validated['perPage']) ? $validated['perPage'] : null;
        $paginator = $query->paginate($perPage);

        $paginator->appends($validated);

        if ($request->expectsJson()) {
            return (new Resources\BacklogCollection($paginator))->response($request);
        }

        $meta = [
            'session_user_id' => $user?->id,
            'columns' => $request->getPaginationColumns(),
            'dates' => $request->getPaginationDates(),
            'flags' => $request->getPaginationFlags(),
            'ids' => $request->getPaginationIds(),
            'rules' => $request->rules(),
            'sortable' => $request->getSortable(),
            'timestamp' => Carbon::now()->toJson(),
            'validated' => $validated,
            'info' => $this->packageInfo,
        ];

        $data = [
            'paginator' => $paginator,
            'meta' => $meta,
        ];

        return view(sprintf('%1$s/index', $this->packageInfo['view']), $data);
    }

    /**
     * Restore the Backlog resource from the trash.
     *
     * @route PUT /resource/matrix/restore/{backlog} playground.matrix.resource.backlogs.restore
     */
    public function restore(
        Backlog $backlog,
        Requests\Backlog\RestoreRequest $request
    ): JsonResponse|RedirectResponse|Resources\Backlog {

        $validated = $request->validated();

        $user = $request->user();

        if ($user?->id) {
            $backlog->modified_by_id = $user->id;
        }

        $backlog->restore();

        if ($request->expectsJson()) {
            return (new Resources\Backlog($backlog))->additional(['meta' => [
                'info' => $this->packageInfo,
            ]])->response($request);
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl && is_string($returnUrl)) {
            return redirect($returnUrl);
        }

        return redirect(route(sprintf(
            '%1$s.show',
            $this->packageInfo['model_route']
        ), ['backlog' => $backlog->id]));
    }

    /**
     * Display the Backlog resource.
     *
     * @route GET /resource/matrix/{backlog} playground.matrix.resource.backlogs.show
     */
    public function show(
        Backlog $backlog,
        Requests\Backlog\ShowRequest $request
    ): JsonResponse|View|Resources\Backlog {

        $validated = $request->validated();

        $user = $request->user();

        $meta = [
            'session_user_id' => $user?->id,
            'id' => $backlog->id,
            'timestamp' => Carbon::now()->toJson(),
            'validated' => $validated,
            'info' => $this->packageInfo,
        ];

        if ($request->expectsJson()) {
            return (new Resources\Backlog($backlog))->additional(['meta' => [
                'info' => $this->packageInfo,
            ]])->response($request);
        }

        $meta['input'] = $request->input();
        $meta['validated'] = $request->validated();

        $data = [
            'data' => $backlog,
            'meta' => $meta,
        ];

        return view(sprintf('%1$s/detail', $this->packageInfo['view']), $data);
    }

    /**
     * Store a newly created API Backlog resource in storage.
     *
     * @route POST /resource/matrix playground.matrix.resource.backlogs.post
     */
    public function store(
        Requests\Backlog\StoreRequest $request
    ): Response|JsonResponse|RedirectResponse|Resources\Backlog {

        $validated = $request->validated();

        $user = $request->user();

        $backlog = new Backlog($validated);

        if ($user?->id) {
            $backlog->created_by_id = $user->id;
        }

        $backlog->save();

        if ($request->expectsJson()) {
            return (new Resources\Backlog($backlog))->additional(['meta' => [
                'info' => $this->packageInfo,
            ]])->response($request);
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl && is_string($returnUrl)) {
            return redirect($returnUrl);
        }

        return redirect(route(sprintf(
            '%1$s.show',
            $this->packageInfo['model_route']
        ), ['backlog' => $backlog->id]));
    }

    /**
     * Unlock the Backlog resource in storage.
     *
     * @route DELETE /resource/matrix/lock/{backlog} playground.matrix.resource.backlogs.unlock
     */
    public function unlock(
        Backlog $backlog,
        Requests\Backlog\UnlockRequest $request
    ): JsonResponse|RedirectResponse|Resources\Backlog {

        $validated = $request->validated();

        $user = $request->user();

        $backlog->locked = false;

        if ($user?->id) {
            $backlog->modified_by_id = $user->id;
        }

        $backlog->save();

        if ($request->expectsJson()) {
            return (new Resources\Backlog($backlog))->additional(['meta' => [
                'info' => $this->packageInfo,
            ]])->response($request);
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl && is_string($returnUrl)) {
            return redirect($returnUrl);
        }

        return redirect(route(sprintf(
            '%1$s.show',
            $this->packageInfo['model_route']
        ), ['backlog' => $backlog->id]));
    }

    /**
     * Update the Backlog resource in storage.
     *
     * @route PATCH /resource/matrix/{backlog} playground.matrix.resource.backlogs.patch
     */
    public function update(
        Backlog $backlog,
        Requests\Backlog\UpdateRequest $request
    ): JsonResponse|RedirectResponse|Resources\Backlog {

        $validated = $request->validated();

        $user = $request->user();

        $backlog->update($validated);

        if ($user?->id) {
            $backlog->modified_by_id = $user->id;
        }

        if ($request->expectsJson()) {
            return (new Resources\Backlog($backlog))->additional(['meta' => [
                'info' => $this->packageInfo,
            ]])->response($request);
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl && is_string($returnUrl)) {
            return redirect($returnUrl);
        }

        return redirect(route(sprintf(
            '%1$s.show',
            $this->packageInfo['model_route']
        ), ['backlog' => $backlog->id]));
    }
}
