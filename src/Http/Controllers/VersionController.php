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
use Playground\Matrix\Models\Version;
use Playground\Matrix\Resource\Http\Requests;
use Playground\Matrix\Resource\Http\Resources;

/**
 * \Playground\Matrix\Resource\Http\Controllers\VersionController
 */
class VersionController extends Controller
{
    /**
     * @var array<string, string>
     */
    public array $packageInfo = [
        'model_attribute' => 'title',
        'model_label' => 'Version',
        'model_label_plural' => 'Versions',
        'model_route' => 'playground.matrix.resource.versions',
        'model_slug' => 'version',
        'model_slug_plural' => 'versions',
        'module_label' => 'Matrix',
        'module_label_plural' => 'Matrices',
        'module_route' => 'playground.matrix.resource',
        'module_slug' => 'matrix',
        'privilege' => 'playground-matrix-resource:version',
        'table' => 'matrix_versions',
        'view' => 'playground-matrix-resource::version',
    ];

    /**
     * Create the Version resource in storage.
     *
     * @route GET /resource/matrix/versions/create playground.matrix.resource.versions.create
     */
    public function create(
        Requests\Version\CreateRequest $request
    ): JsonResponse|View|Resources\Version {

        $validated = $request->validated();

        $user = $request->user();

        $version = new Version($validated);

        if ($request->expectsJson()) {
            return (new Resources\Version($version))->additional(['meta' => [
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
            'data' => $version,
            'meta' => $meta,
            '_method' => 'post',
        ];

        $flash = $version->toArray();

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
     * Edit the Version resource in storage.
     *
     * @route GET /resource/matrix/versions/edit/{version} playground.matrix.resource.versions.edit
     */
    public function edit(
        Version $version,
        Requests\Version\EditRequest $request
    ): JsonResponse|View|Resources\Version {

        $validated = $request->validated();

        $user = $request->user();

        if ($request->expectsJson()) {
            return (new Resources\Version($version))->additional(['meta' => [
                'info' => $this->packageInfo,
            ]])->response($request);
        }

        $flash = $version->toArray();

        if (! empty($validated['_return_url'])) {
            $flash['_return_url'] = $validated['_return_url'];
            $data['_return_url'] = $validated['_return_url'];
        }

        $meta = [
            'session_user_id' => $user?->id,
            'id' => $version->id,
            'timestamp' => Carbon::now()->toJson(),
            'validated' => $validated,
            'info' => $this->packageInfo,
        ];

        $meta['input'] = $request->input();
        $meta['validated'] = $request->validated();

        $data = [
            'data' => $version,
            'meta' => $meta,
            '_method' => 'patch',
        ];

        session()->flashInput($flash);

        return view(sprintf('%1$s/form', $this->packageInfo['view']), $data);
    }

    /**
     * Remove the Version resource from storage.
     *
     * @route DELETE /resource/matrix/versions/{version} playground.matrix.resource.versions.destroy
     */
    public function destroy(
        Version $version,
        Requests\Version\DestroyRequest $request
    ): Response|RedirectResponse {

        $validated = $request->validated();

        $user = $request->user();

        if ($user?->id) {
            $version->modified_by_id = $user->id;
        }

        if (empty($validated['force'])) {
            $version->delete();
        } else {
            $version->forceDelete();
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
     * Lock the Version resource in storage.
     *
     * @route PUT /resource/matrix/versions/{version} playground.matrix.resource.versions.lock
     */
    public function lock(
        Version $version,
        Requests\Version\LockRequest $request
    ): JsonResponse|RedirectResponse|Resources\Version {

        $validated = $request->validated();

        $user = $request->user();

        if ($user?->id) {
            $version->modified_by_id = $user->id;
        }

        $version->locked = true;

        $version->save();

        $meta = [
            'session_user_id' => $user?->id,
            'id' => $version->id,
            'timestamp' => Carbon::now()->toJson(),
            'info' => $this->packageInfo,
        ];

        if ($request->expectsJson()) {
            return (new Resources\Version($version))->additional(['meta' => [
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
        ), ['version' => $version->id]));
    }

    /**
     * Display a listing of Version resources.
     *
     * @route GET /resource/matrix/versions playground.matrix.resource.versions
     */
    public function index(
        Requests\Version\IndexRequest $request
    ): JsonResponse|View|Resources\VersionCollection {

        $user = $request->user();

        $validated = $request->validated();

        $query = Version::addSelect(sprintf('%1$s.*', $this->packageInfo['table']));

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
            return (new Resources\VersionCollection($paginator))->response($request);
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
     * Restore the Version resource from the trash.
     *
     * @route PUT /resource/matrix/versions/restore/{version} playground.matrix.resource.versions.restore
     */
    public function restore(
        Version $version,
        Requests\Version\RestoreRequest $request
    ): JsonResponse|RedirectResponse|Resources\Version {

        $validated = $request->validated();

        $user = $request->user();

        if ($user?->id) {
            $version->modified_by_id = $user->id;
        }

        $version->restore();

        if ($request->expectsJson()) {
            return (new Resources\Version($version))->additional(['meta' => [
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
        ), ['version' => $version->id]));
    }

    /**
     * Display the Version resource.
     *
     * @route GET /resource/matrix/versions/{version} playground.matrix.resource.versions.show
     */
    public function show(
        Version $version,
        Requests\Version\ShowRequest $request
    ): JsonResponse|View|Resources\Version {

        $validated = $request->validated();

        $user = $request->user();

        $meta = [
            'session_user_id' => $user?->id,
            'id' => $version->id,
            'timestamp' => Carbon::now()->toJson(),
            'validated' => $validated,
            'info' => $this->packageInfo,
        ];

        if ($request->expectsJson()) {
            return (new Resources\Version($version))->additional(['meta' => [
                'info' => $this->packageInfo,
            ]])->response($request);
        }

        $meta['input'] = $request->input();
        $meta['validated'] = $request->validated();

        $data = [
            'data' => $version,
            'meta' => $meta,
        ];

        return view(sprintf('%1$s/detail', $this->packageInfo['view']), $data);
    }

    /**
     * Store a newly created API Version resource in storage.
     *
     * @route POST /resource/matrix/versions playground.matrix.resource.versions.post
     */
    public function store(
        Requests\Version\StoreRequest $request
    ): Response|JsonResponse|RedirectResponse|Resources\Version {

        $validated = $request->validated();

        $user = $request->user();

        $version = new Version($validated);

        if ($user?->id) {
            $version->created_by_id = $user->id;
        }

        $version->save();

        if ($request->expectsJson()) {
            return (new Resources\Version($version))->additional(['meta' => [
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
        ), ['version' => $version->id]));
    }

    /**
     * Unlock the Version resource in storage.
     *
     * @route DELETE /resource/matrix/versions/lock/{version} playground.matrix.resource.versions.unlock
     */
    public function unlock(
        Version $version,
        Requests\Version\UnlockRequest $request
    ): JsonResponse|RedirectResponse|Resources\Version {

        $validated = $request->validated();

        $user = $request->user();

        $version->locked = false;

        if ($user?->id) {
            $version->modified_by_id = $user->id;
        }

        $version->save();

        if ($request->expectsJson()) {
            return (new Resources\Version($version))->additional(['meta' => [
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
        ), ['version' => $version->id]));
    }

    /**
     * Update the Version resource in storage.
     *
     * @route PATCH /resource/matrix/versions/{version} playground.matrix.resource.versions.patch
     */
    public function update(
        Version $version,
        Requests\Version\UpdateRequest $request
    ): JsonResponse|RedirectResponse|Resources\Version {

        $validated = $request->validated();

        $user = $request->user();

        $version->update($validated);

        if ($user?->id) {
            $version->modified_by_id = $user->id;
        }

        if ($request->expectsJson()) {
            return (new Resources\Version($version))->additional(['meta' => [
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
        ), ['version' => $version->id]));
    }
}
