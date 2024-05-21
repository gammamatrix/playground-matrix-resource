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
use Playground\Matrix\Models\Epic;
use Playground\Matrix\Resource\Http\Requests;
use Playground\Matrix\Resource\Http\Resources;

/**
 * \Playground\Matrix\Resource\Http\Controllers\EpicController
 */
class EpicController extends Controller
{
    /**
     * @var array<string, string>
     */
    public array $packageInfo = [
        'model_attribute' => 'title',
        'model_label' => 'Epic',
        'model_label_plural' => 'Epics',
        'model_route' => 'playground.matrix.resource.epics',
        'model_slug' => 'epic',
        'model_slug_plural' => 'epics',
        'module_label' => 'Matrix',
        'module_label_plural' => 'Matrices',
        'module_route' => 'playground.matrix.resource',
        'module_slug' => 'matrix',
        'privilege' => 'playground-matrix-resource:epic',
        'table' => 'matrix_epics',
        'view' => 'playground-matrix-resource::epic',
    ];

    /**
     * Create the Epic resource in storage.
     *
     * @route GET /resource/matrix/epics/create playground.matrix.resource.epics.create
     */
    public function create(
        Requests\Epic\CreateRequest $request
    ): JsonResponse|View|Resources\Epic {

        $validated = $request->validated();

        $user = $request->user();

        $epic = new Epic($validated);

        if ($request->expectsJson()) {
            return (new Resources\Epic($epic))->additional(['meta' => [
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
            'data' => $epic,
            'meta' => $meta,
            '_method' => 'post',
        ];

        $flash = $epic->toArray();

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
     * Edit the Epic resource in storage.
     *
     * @route GET /resource/matrix/epics/edit playground.matrix.resource.epics.edit
     */
    public function edit(
        Epic $epic,
        Requests\Epic\EditRequest $request
    ): JsonResponse|View|Resources\Epic {

        $validated = $request->validated();

        $user = $request->user();

        if ($request->expectsJson()) {
            return (new Resources\Epic($epic))->additional(['meta' => [
                'info' => $this->packageInfo,
            ]])->response($request);
        }

        $flash = $epic->toArray();

        if (! empty($validated['_return_url'])) {
            $flash['_return_url'] = $validated['_return_url'];
            $data['_return_url'] = $validated['_return_url'];
        }

        $meta = [
            'session_user_id' => $user?->id,
            'id' => $epic->id,
            'timestamp' => Carbon::now()->toJson(),
            'validated' => $validated,
            'info' => $this->packageInfo,
        ];

        $meta['input'] = $request->input();
        $meta['validated'] = $request->validated();

        $data = [
            'data' => $epic,
            'meta' => $meta,
            '_method' => 'patch',
        ];

        session()->flashInput($flash);

        return view(sprintf('%1$s/form', $this->packageInfo['view']), $data);
    }

    /**
     * Remove the Epic resource from storage.
     *
     * @route DELETE /resource/matrix/{epic} playground.matrix.resource.epics.destroy
     */
    public function destroy(
        Epic $epic,
        Requests\Epic\DestroyRequest $request
    ): Response|RedirectResponse {

        $validated = $request->validated();

        $user = $request->user();

        if ($user?->id) {
            $epic->modified_by_id = $user->id;
        }

        if (empty($validated['force'])) {
            $epic->delete();
        } else {
            $epic->forceDelete();
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
     * Lock the Epic resource in storage.
     *
     * @route PUT /resource/matrix/{epic} playground.matrix.resource.epics.lock
     */
    public function lock(
        Epic $epic,
        Requests\Epic\LockRequest $request
    ): JsonResponse|RedirectResponse|Resources\Epic {

        $validated = $request->validated();

        $user = $request->user();

        if ($user?->id) {
            $epic->modified_by_id = $user->id;
        }

        $epic->locked = true;

        $epic->save();

        $meta = [
            'session_user_id' => $user?->id,
            'id' => $epic->id,
            'timestamp' => Carbon::now()->toJson(),
            'info' => $this->packageInfo,
        ];

        if ($request->expectsJson()) {
            return (new Resources\Epic($epic))->response($request);
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl && is_string($returnUrl)) {
            return redirect($returnUrl);
        }

        return redirect(route(sprintf(
            '%1$s.show',
            $this->packageInfo['model_route']
        ), ['epic' => $epic->id]));
    }

    /**
     * Display a listing of Epic resources.
     *
     * @route GET /resource/matrix playground.matrix.resource.epics
     */
    public function index(
        Requests\Epic\IndexRequest $request
    ): JsonResponse|View|Resources\EpicCollection {

        $user = $request->user();

        $validated = $request->validated();

        $query = Epic::addSelect(sprintf('%1$s.*', $this->packageInfo['table']));

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
            return (new Resources\EpicCollection($paginator))->response($request);
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
     * Restore the Epic resource from the trash.
     *
     * @route PUT /resource/matrix/restore/{epic} playground.matrix.resource.epics.restore
     */
    public function restore(
        Epic $epic,
        Requests\Epic\RestoreRequest $request
    ): JsonResponse|RedirectResponse|Resources\Epic {

        $validated = $request->validated();

        $user = $request->user();

        if ($user?->id) {
            $epic->modified_by_id = $user->id;
        }

        $epic->restore();

        if ($request->expectsJson()) {
            return (new Resources\Epic($epic))->response($request);
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl && is_string($returnUrl)) {
            return redirect($returnUrl);
        }

        return redirect(route(sprintf(
            '%1$s.show',
            $this->packageInfo['model_route']
        ), ['epic' => $epic->id]));
    }

    /**
     * Display the Epic resource.
     *
     * @route GET /resource/matrix/{epic} playground.matrix.resource.epics.show
     */
    public function show(
        Epic $epic,
        Requests\Epic\ShowRequest $request
    ): JsonResponse|View|Resources\Epic {

        $validated = $request->validated();

        $user = $request->user();

        $meta = [
            'session_user_id' => $user?->id,
            'id' => $epic->id,
            'timestamp' => Carbon::now()->toJson(),
            'validated' => $validated,
            'info' => $this->packageInfo,
        ];

        if ($request->expectsJson()) {
            return (new Resources\Epic($epic))->response($request);
        }

        $meta['input'] = $request->input();
        $meta['validated'] = $request->validated();

        $data = [
            'data' => $epic,
            'meta' => $meta,
        ];

        return view(sprintf('%1$s/detail', $this->packageInfo['view']), $data);
    }

    /**
     * Store a newly created API Epic resource in storage.
     *
     * @route POST /resource/matrix playground.matrix.resource.epics.post
     */
    public function store(
        Requests\Epic\StoreRequest $request
    ): Response|JsonResponse|RedirectResponse|Resources\Epic {

        $validated = $request->validated();

        $user = $request->user();

        $epic = new Epic($validated);

        if ($user?->id) {
            $epic->created_by_id = $user->id;
        }

        $epic->save();

        if ($request->expectsJson()) {
            return (new Resources\Epic($epic))->response($request);
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl && is_string($returnUrl)) {
            return redirect($returnUrl);
        }

        return redirect(route(sprintf(
            '%1$s.show',
            $this->packageInfo['model_route']
        ), ['epic' => $epic->id]));
    }

    /**
     * Unlock the Epic resource in storage.
     *
     * @route DELETE /resource/matrix/lock/{epic} playground.matrix.resource.epics.unlock
     */
    public function unlock(
        Epic $epic,
        Requests\Epic\UnlockRequest $request
    ): JsonResponse|RedirectResponse|Resources\Epic {

        $validated = $request->validated();

        $user = $request->user();

        $epic->locked = false;

        if ($user?->id) {
            $epic->modified_by_id = $user->id;
        }

        $epic->save();

        if ($request->expectsJson()) {
            return (new Resources\Epic($epic))->response($request);
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl && is_string($returnUrl)) {
            return redirect($returnUrl);
        }

        return redirect(route(sprintf(
            '%1$s.show',
            $this->packageInfo['model_route']
        ), ['epic' => $epic->id]));
    }

    /**
     * Update the Epic resource in storage.
     *
     * @route PATCH /resource/matrix/{epic} playground.matrix.resource.epics.patch
     */
    public function update(
        Epic $epic,
        Requests\Epic\UpdateRequest $request
    ): JsonResponse|RedirectResponse|Resources\Epic {

        $validated = $request->validated();

        $user = $request->user();

        $epic->update($validated);

        if ($user?->id) {
            $epic->modified_by_id = $user->id;
        }

        if ($request->expectsJson()) {
            return (new Resources\Epic($epic))->response($request);
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl && is_string($returnUrl)) {
            return redirect($returnUrl);
        }

        return redirect(route(sprintf(
            '%1$s.show',
            $this->packageInfo['model_route']
        ), ['epic' => $epic->id]));
    }
}
