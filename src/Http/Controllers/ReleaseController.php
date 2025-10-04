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

        $packageInfo = $this->packageInfo();

        $validated = $request->validated();

        $release = new Release($validated);

        if ($request->expectsJson()) {
            return new Resources\Release($release)->additional(['meta' => [
                'info' => $packageInfo,
            ]])->response($request);
        }

        $user = $request->user();

        $meta = [
            'session_user_id' => $user?->id,
            'id' => null,
            'timestamp' => Carbon::now()->toJson(),
            'info' => $packageInfo,
        ];

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

        /**
         * @var view-string $view
         */
        $view = sprintf('%1$s/form', $packageInfo->view());

        return view($view, $data);
    }

    /**
     * Edit the Release resource in storage.
     *
     * @route GET /resource/matrix/releases/edit/{release} playground.matrix.resource.releases.edit
     */
    public function edit(
        Release $release,
        Requests\Release\EditRequest $request
    ): JsonResponse|View|Resources\Release {

        $packageInfo = $this->packageInfo();

        $validated = $request->validated();

        if ($request->expectsJson()) {
            return new Resources\Release($release)->additional(['meta' => [
                'info' => $packageInfo,
            ]])->response($request);
        }

        $user = $request->user();

        $flash = $release->toArray();

        if (! empty($validated['_return_url'])) {
            $flash['_return_url'] = $validated['_return_url'];
        }

        $meta = [
            'session_user_id' => $user?->id,
            'id' => $release->id,
            'timestamp' => Carbon::now()->toJson(),
            'info' => $packageInfo,
        ];

        $data = [
            'data' => $release,
            'meta' => $meta,
            '_method' => 'patch',
        ];

        if (! empty($validated['_return_url'])) {
            $data['_return_url'] = $validated['_return_url'];
        }

        session()->flashInput($flash);

        /**
         * @var view-string $view
         */
        $view = sprintf('%1$s/form', $packageInfo->view());

        return view($view, $data);
    }

    /**
     * Remove the Release resource from storage.
     *
     * @route DELETE /resource/matrix/releases/{release} playground.matrix.resource.releases.destroy
     */
    public function destroy(
        Release $release,
        Requests\Release\DestroyRequest $request
    ): Response|RedirectResponse {

        $packageInfo = $this->packageInfo();

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

        return redirect(route($packageInfo->model_route()));
    }

    /**
     * Lock the Release resource in storage.
     *
     * @route PUT /resource/matrix/releases/{release} playground.matrix.resource.releases.lock
     */
    public function lock(
        Release $release,
        Requests\Release\LockRequest $request
    ): JsonResponse|RedirectResponse|Resources\Release {

        $packageInfo = $this->packageInfo();

        $validated = $request->validated();

        $user = $request->user();

        if ($user?->id) {
            $release->modified_by_id = $user->id;
        }

        $release->locked = true;

        $release->save();

        if ($request->expectsJson()) {
            return new Resources\Release($release)->additional(['meta' => [
                'info' => $packageInfo,
            ]])->response($request);
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl && is_string($returnUrl)) {
            return redirect($returnUrl);
        }

        return redirect(route(sprintf(
            '%1$s.show',
            $packageInfo->model_route()
        ), ['release' => $release->id]));
    }

    /**
     * Display a listing of Release resources.
     *
     * @route GET /resource/matrix/releases playground.matrix.resource.releases
     */
    public function index(
        Requests\Release\IndexRequest $request
    ): JsonResponse|View|Resources\ReleaseCollection {

        $packageInfo = $this->packageInfo();

        /**
         * @var array{
         *     sort: string|array<mixed>,
         *     filter: array{
         *         trash: string
         *     },
         *     perPage: int
         * } $validated
         */
        $validated = $request->validated();

        $query = Release::addSelect(sprintf('%1$s.*', $packageInfo->table()));

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
            return new Resources\ReleaseCollection($paginator)->response($request);
        }

        $user = $request->user();

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
            'info' => $packageInfo,
        ];

        $data = [
            'paginator' => $paginator,
            'meta' => $meta,
        ];

        /**
         * @var view-string $view
         */
        $view = sprintf('%1$s/index', $packageInfo->view());

        return view($view, $data);
    }

    /**
     * Restore the Release resource from the trash.
     *
     * @route PUT /resource/matrix/releases/restore/{release} playground.matrix.resource.releases.restore
     */
    public function restore(
        Release $release,
        Requests\Release\RestoreRequest $request
    ): JsonResponse|RedirectResponse|Resources\Release {

        $packageInfo = $this->packageInfo();

        $validated = $request->validated();

        $user = $request->user();

        $release->modified_by_id = $user?->id;

        $release->restore();

        if ($request->expectsJson()) {
            return new Resources\Release($release)->additional(['meta' => [
                'info' => $packageInfo,
            ]])->response($request);
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl && is_string($returnUrl)) {
            return redirect($returnUrl);
        }

        return redirect(route(sprintf(
            '%1$s.show',
            $packageInfo->model_route()
        ), ['release' => $release->id]));
    }

    /**
     * Display the Release resource.
     *
     * @route GET /resource/matrix/releases/{release} playground.matrix.resource.releases.show
     */
    public function show(
        Release $release,
        Requests\Release\ShowRequest $request
    ): JsonResponse|View|Resources\Release {

        $packageInfo = $this->packageInfo();

        if ($request->expectsJson()) {
            return new Resources\Release($release)->additional(['meta' => [
                'info' => $packageInfo,
            ]])->response($request);
        }

        $user = $request->user();

        $meta = [
            'session_user_id' => $user?->id,
            'id' => $release->id,
            'timestamp' => Carbon::now()->toJson(),
            'info' => $packageInfo,
        ];

        $data = [
            'data' => $release,
            'meta' => $meta,
        ];

        /**
         * @var view-string $view
         */
        $view = sprintf('%1$s/detail', $packageInfo->view());

        return view($view, $data);
    }

    /**
     * Store a newly created API Release resource in storage.
     *
     * @route POST /resource/matrix/releases playground.matrix.resource.releases.post
     */
    public function store(
        Requests\Release\StoreRequest $request
    ): Response|JsonResponse|RedirectResponse|Resources\Release {

        $packageInfo = $this->packageInfo();

        $validated = $request->validated();

        $user = $request->user();

        $release = new Release($validated);

        $release->created_by_id = $user?->id;

        $release->save();

        if ($request->expectsJson()) {
            return new Resources\Release($release)->additional(['meta' => [
                'info' => $packageInfo,
            ]])->response($request)->setStatusCode(201);
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl && is_string($returnUrl)) {
            return redirect($returnUrl);
        }

        return redirect(route(sprintf(
            '%1$s.show',
            $packageInfo->model_route()
        ), ['release' => $release->id]));
    }

    /**
     * Unlock the Release resource in storage.
     *
     * @route DELETE /resource/matrix/releases/lock/{release} playground.matrix.resource.releases.unlock
     */
    public function unlock(
        Release $release,
        Requests\Release\UnlockRequest $request
    ): JsonResponse|RedirectResponse|Resources\Release {

        $packageInfo = $this->packageInfo();

        $validated = $request->validated();

        $user = $request->user();

        $release->locked = false;

        $release->modified_by_id = $user?->id;

        $release->save();

        if ($request->expectsJson()) {
            return new Resources\Release($release)->additional(['meta' => [
                'info' => $packageInfo,
            ]])->response($request);
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl && is_string($returnUrl)) {
            return redirect($returnUrl);
        }

        return redirect(route(sprintf(
            '%1$s.show',
            $packageInfo->model_route()
        ), ['release' => $release->id]));
    }

    /**
     * Update the Release resource in storage.
     *
     * @route PATCH /resource/matrix/releases/{release} playground.matrix.resource.releases.patch
     */
    public function update(
        Release $release,
        Requests\Release\UpdateRequest $request
    ): JsonResponse|RedirectResponse|Resources\Release {

        $packageInfo = $this->packageInfo();

        $validated = $request->validated();

        $user = $request->user();

        $release->modified_by_id = $user?->id;

        $release->update($validated);

        if ($request->expectsJson()) {
            return new Resources\Release($release)->additional(['meta' => [
                'info' => $packageInfo,
            ]])->response($request);
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl && is_string($returnUrl)) {
            return redirect($returnUrl);
        }

        return redirect(route(sprintf(
            '%1$s.show',
            $packageInfo->model_route()
        ), ['release' => $release->id]));
    }
}
