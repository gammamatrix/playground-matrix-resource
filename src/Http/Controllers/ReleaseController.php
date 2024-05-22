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
use Playground\Matrix\Models\Release;
use Playground\Matrix\Resource\Http\Requests;
use Playground\Matrix\Resource\Http\Resources;

/**
 * \Playground\Matrix\Resource\Http\Controllers\ReleaseController
 */
class ReleaseController extends Controller
{
    /**
     * @var array<string, string>
     */
    public array $packageInfo = [
        'model_attribute' => 'title',
        'model_label' => 'Release',
        'model_label_plural' => 'Releases',
        'model_route' => 'playground.matrix.resource.releases',
        'model_slug' => 'release',
        'model_slug_plural' => 'releases',
        'module_label' => 'Matrix',
        'module_label_plural' => 'Matrices',
        'module_route' => 'playground.matrix.resource',
        'module_slug' => 'matrix',
        'privilege' => 'playground-matrix-resource:release',
        'table' => 'matrix_releases',
        'view' => 'playground-matrix-resource::release',
    ];

    /**
     * Create the Release resource in storage.
     *
     * @route GET /resource/matrix/releases/create playground.matrix.resource.releases.create
     */
    public function create(
        Requests\Release\CreateRequest $request
    ): JsonResponse|View|Resources\Release {

        $validated = $request->validated();

        $user = $request->user();

        $release = new Release($validated);

        if ($request->expectsJson()) {
            return (new Resources\Release($release))->additional(['meta' => [
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
            'data' => $release,
            'meta' => $meta,
            '_method' => 'post',
        ];

        $flash = $release->toArray();

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
     * Edit the Release resource in storage.
     *
     * @route GET /resource/matrix/releases/edit playground.matrix.resource.releases.edit
     */
    public function edit(
        Release $release,
        Requests\Release\EditRequest $request
    ): JsonResponse|View|Resources\Release {

        $validated = $request->validated();

        $user = $request->user();

        if ($request->expectsJson()) {
            return (new Resources\Release($release))->additional(['meta' => [
                'info' => $this->packageInfo,
            ]])->response($request);
        }

        $flash = $release->toArray();

        if (! empty($validated['_return_url'])) {
            $flash['_return_url'] = $validated['_return_url'];
            $data['_return_url'] = $validated['_return_url'];
        }

        $meta = [
            'session_user_id' => $user?->id,
            'id' => $release->id,
            'timestamp' => Carbon::now()->toJson(),
            'validated' => $validated,
            'info' => $this->packageInfo,
        ];

        $meta['input'] = $request->input();
        $meta['validated'] = $request->validated();

        $data = [
            'data' => $release,
            'meta' => $meta,
            '_method' => 'patch',
        ];

        session()->flashInput($flash);

        return view(sprintf('%1$s/form', $this->packageInfo['view']), $data);
    }

    /**
     * Remove the Release resource from storage.
     *
     * @route DELETE /resource/matrix/{release} playground.matrix.resource.releases.destroy
     */
    public function destroy(
        Release $release,
        Requests\Release\DestroyRequest $request
    ): Response|RedirectResponse {

        $validated = $request->validated();

        $user = $request->user();

        if ($user?->id) {
            $release->modified_by_id = $user->id;
        }

        if (empty($validated['force'])) {
            $release->delete();
        } else {
            $release->forceDelete();
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
     * Lock the Release resource in storage.
     *
     * @route PUT /resource/matrix/{release} playground.matrix.resource.releases.lock
     */
    public function lock(
        Release $release,
        Requests\Release\LockRequest $request
    ): JsonResponse|RedirectResponse|Resources\Release {

        $validated = $request->validated();

        $user = $request->user();

        if ($user?->id) {
            $release->modified_by_id = $user->id;
        }

        $release->locked = true;

        $release->save();

        $meta = [
            'session_user_id' => $user?->id,
            'id' => $release->id,
            'timestamp' => Carbon::now()->toJson(),
            'info' => $this->packageInfo,
        ];

        if ($request->expectsJson()) {
            return (new Resources\Release($release))->additional(['meta' => [
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
        ), ['release' => $release->id]));
    }

    /**
     * Display a listing of Release resources.
     *
     * @route GET /resource/matrix playground.matrix.resource.releases
     */
    public function index(
        Requests\Release\IndexRequest $request
    ): JsonResponse|View|Resources\ReleaseCollection {

        $user = $request->user();

        $validated = $request->validated();

        $query = Release::addSelect(sprintf('%1$s.*', $this->packageInfo['table']));

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
            return (new Resources\ReleaseCollection($paginator))->response($request);
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
     * Restore the Release resource from the trash.
     *
     * @route PUT /resource/matrix/restore/{release} playground.matrix.resource.releases.restore
     */
    public function restore(
        Release $release,
        Requests\Release\RestoreRequest $request
    ): JsonResponse|RedirectResponse|Resources\Release {

        $validated = $request->validated();

        $user = $request->user();

        if ($user?->id) {
            $release->modified_by_id = $user->id;
        }

        $release->restore();

        if ($request->expectsJson()) {
            return (new Resources\Release($release))->additional(['meta' => [
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
        ), ['release' => $release->id]));
    }

    /**
     * Display the Release resource.
     *
     * @route GET /resource/matrix/{release} playground.matrix.resource.releases.show
     */
    public function show(
        Release $release,
        Requests\Release\ShowRequest $request
    ): JsonResponse|View|Resources\Release {

        $validated = $request->validated();

        $user = $request->user();

        $meta = [
            'session_user_id' => $user?->id,
            'id' => $release->id,
            'timestamp' => Carbon::now()->toJson(),
            'validated' => $validated,
            'info' => $this->packageInfo,
        ];

        if ($request->expectsJson()) {
            return (new Resources\Release($release))->additional(['meta' => [
                'info' => $this->packageInfo,
            ]])->response($request);
        }

        $meta['input'] = $request->input();
        $meta['validated'] = $request->validated();

        $data = [
            'data' => $release,
            'meta' => $meta,
        ];

        return view(sprintf('%1$s/detail', $this->packageInfo['view']), $data);
    }

    /**
     * Store a newly created API Release resource in storage.
     *
     * @route POST /resource/matrix playground.matrix.resource.releases.post
     */
    public function store(
        Requests\Release\StoreRequest $request
    ): Response|JsonResponse|RedirectResponse|Resources\Release {

        $validated = $request->validated();

        $user = $request->user();

        $release = new Release($validated);

        if ($user?->id) {
            $release->created_by_id = $user->id;
        }

        $release->save();

        if ($request->expectsJson()) {
            return (new Resources\Release($release))->additional(['meta' => [
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
        ), ['release' => $release->id]));
    }

    /**
     * Unlock the Release resource in storage.
     *
     * @route DELETE /resource/matrix/lock/{release} playground.matrix.resource.releases.unlock
     */
    public function unlock(
        Release $release,
        Requests\Release\UnlockRequest $request
    ): JsonResponse|RedirectResponse|Resources\Release {

        $validated = $request->validated();

        $user = $request->user();

        $release->locked = false;

        if ($user?->id) {
            $release->modified_by_id = $user->id;
        }

        $release->save();

        if ($request->expectsJson()) {
            return (new Resources\Release($release))->additional(['meta' => [
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
        ), ['release' => $release->id]));
    }

    /**
     * Update the Release resource in storage.
     *
     * @route PATCH /resource/matrix/{release} playground.matrix.resource.releases.patch
     */
    public function update(
        Release $release,
        Requests\Release\UpdateRequest $request
    ): JsonResponse|RedirectResponse|Resources\Release {

        $validated = $request->validated();

        $user = $request->user();

        $release->update($validated);

        if ($user?->id) {
            $release->modified_by_id = $user->id;
        }

        if ($request->expectsJson()) {
            return (new Resources\Release($release))->additional(['meta' => [
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
        ), ['release' => $release->id]));
    }
}
