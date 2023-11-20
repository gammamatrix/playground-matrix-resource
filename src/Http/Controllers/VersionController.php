<?php
/**
 * GammaMatrix
 */

namespace GammaMatrix\Playground\Matrix\Resource\Http\Controllers;

use GammaMatrix\Playground\Http\Controllers\Controller;
use GammaMatrix\Playground\Matrix\Models\Version;
use GammaMatrix\Playground\Matrix\Resource\Http\Requests\Version\CreateRequest;
use GammaMatrix\Playground\Matrix\Resource\Http\Requests\Version\DestroyRequest;
use GammaMatrix\Playground\Matrix\Resource\Http\Requests\Version\EditRequest;
use GammaMatrix\Playground\Matrix\Resource\Http\Requests\Version\IndexRequest;
use GammaMatrix\Playground\Matrix\Resource\Http\Requests\Version\LockRequest;
use GammaMatrix\Playground\Matrix\Resource\Http\Requests\Version\RestoreRequest;
use GammaMatrix\Playground\Matrix\Resource\Http\Requests\Version\ShowRequest;
use GammaMatrix\Playground\Matrix\Resource\Http\Requests\Version\StoreRequest;
use GammaMatrix\Playground\Matrix\Resource\Http\Requests\Version\UnlockRequest;
use GammaMatrix\Playground\Matrix\Resource\Http\Requests\Version\UpdateRequest;
use GammaMatrix\Playground\Matrix\Resource\Http\Resources\Version\Version as VersionResource;
use GammaMatrix\Playground\Matrix\Resource\Http\Resources\Version\VersionCollection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * \GammaMatrix\Playground\Matrix\Resource\Http\Controllers\VersionController
 */
class VersionController extends Controller
{
    public array $packageInfo = [
        'model_attribute'     => 'label',
        'model_label'         => 'Version',
        'model_label_plural'  => 'Versions',
        'model_route'         => 'playground.matrix.resource.versions',
        'model_slug'          => 'version',
        'model_slug_plural'   => 'versions',
        'module_label'        => 'Matrix',
        'module_label_plural' => 'Matrices',
        'module_route'        => 'playground.matrix.resource',
        'module_slug'         => 'matrix',
        'privilege'           => 'playground-matrix-resource:version',
        'table'               => 'matrix_versions',
        'view'                => 'playground-matrix-resource::version',
    ];

    /**
     * CREATE the Version resource in storage.
     *
     * @route GET /resource/matrix/versions/create playground.matrix.resource.versions.create
     */
    public function create(
        CreateRequest $request
    ): JsonResponse|View {
        $validated = $request->validated();

        $user = $request->user();

        $version = new Version($validated);

        $meta = [
            'session_user_id' => $user->id,
            'id'              => null,
            'timestamp'       => Carbon::now()->toJson(),
            'validated'       => $validated,
            'info'            => $this->packageInfo,
        ];

        $meta['input'] = $request->input();
        $meta['validated'] = $request->validated();

        $data = [
            'data' => $version,
            'meta' => $meta,
            '_method' => 'post',
        ];

        if ($request->expectsJson()) {
            return response()->json($data);
        }

        $flash = $version->toArray();

        if (!empty($validated['_return_url'])) {
            $flash['_return_url'] = $validated['_return_url'];
            $data['_return_url'] = $validated['_return_url'];
        }

        if (!$request->session()->has('errors')) {
            session()->flashInput($flash);
        }

        return view(
            'playground-matrix-resource::version/form',
            $data
        );
    }

    /**
     * Edit the Version resource in storage.
     *
     * @route GET /resource/matrix/versions/edit playground.matrix.resource.versions.edit
     */
    public function edit(
        Version $version,
        EditRequest $request
    ): JsonResponse|View {
        $validated = $request->validated();

        $user = $request->user();

        $meta = [
            'session_user_id' => $user->id,
            'id'              => $version->id,
            'timestamp'       => Carbon::now()->toJson(),
            'validated'       => $validated,
            'info'            => $this->packageInfo,
        ];

        $meta['input'] = $request->input();
        $meta['validated'] = $request->validated();

        $data = [
            'data' => $version,
            'meta' => $meta,
            '_method' => 'patch',
        ];

        if ($request->expectsJson()) {
            return response()->json($data);
        }

        $flash = $version->toArray();

        if (!empty($validated['_return_url'])) {
            $flash['_return_url'] = $validated['_return_url'];
            $data['_return_url'] = $validated['_return_url'];
        }

        session()->flashInput($flash);

        return view(
            'playground-matrix-resource::version/form',
            $data
        );
    }

    /**
     * Remove the Version resource from storage.
     *
     * @route DELETE /resource/matrix/{version} playground.matrix.resource.versions.destroy
     */
    public function destroy(
        Version $version,
        DestroyRequest $request
    ): Response|RedirectResponse {
        $validated = $request->validated();

        if (empty($validated['force'])) {
            $version->delete();
        } else {
            $version->forceDelete();
        }

        if ($request->expectsJson()) {
            return response()->noContent();
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl) {
            return redirect($returnUrl);
        }

        return redirect(route('playground.matrix.resource.versions'));
    }

    /**
     * Lock the Version resource in storage.
     *
     * @route PUT /resource/matrix/{version} playground.matrix.resource.versions.lock
     */
    public function lock(
        Version $version,
        LockRequest $request
    ): JsonResponse|RedirectResponse {
        $validated = $request->validated();

        $user = $request->user();

        $version->locked = true;

        $version->save();

        $meta = [
            'session_user_id' => $user->id,
            'id'              => $version->id,
            'timestamp'       => Carbon::now()->toJson(),
            'info'            => $this->packageInfo,
        ];

        if ($request->expectsJson()) {
            return new VersionResource($version);
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl) {
            return redirect($returnUrl);
        }

        return redirect(route('playground.matrix.resource.versions.show', ['version' => $version->id]));
    }

    /**
     * Display a listing of Version resources.
     *
     * @route GET /resource/matrix playground.matrix.resource.versions
     */
    public function index(
        IndexRequest $request
    ): JsonResponse|View {
        $user = $request->user();

        $validated = $request->validated();

        $query = Version::addSelect(sprintf('%1$s.*', $this->packageInfo['table']));

        $query->sort($validated['sort'] ?? null);

        if (!empty($validated['filter']) && is_array($validated['filter'])) {
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

        $paginator = $query->paginate($validated['perPage'] ?? null);

        $paginator->appends($validated);

        if ($request->expectsJson()) {
            return (new VersionCollection($paginator))->additional(['meta' => [
                'session_user_id' => $user->id,
                'validated'       => $validated,
            ]]);
        }

        $meta = [
            'session_user_id' => $user->id,
            'columns'         => $request->getPaginationColumns(),
            'dates'           => $request->getPaginationDates(),
            'flags'           => $request->getPaginationFlags(),
            'ids'             => $request->getPaginationIds(),
            'rules'           => $request->rules(),
            'sortable'        => $request->getSortable(),
            'timestamp'       => Carbon::now()->toJson(),
            'validated'       => $validated,
            'info'            => $this->packageInfo,
        ];

        $data = [
            'paginator' => $paginator,
            'meta' => $meta,
        ];

        return view(
            'playground-matrix-resource::version/index',
            $data
        );
    }

    /**
     * Restore the Version resource from the trash.
     *
     * @route PUT /resource/matrix/restore/{version} playground.matrix.resource.versions.restore
     */
    public function restore(
        Version $version,
        RestoreRequest $request
    ): JsonResponse|RedirectResponse {
        $validated = $request->validated();

        $user = $request->user();

        $version->restore();

        if ($request->expectsJson()) {
            return new VersionResource($version);
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl) {
            return redirect($returnUrl);
        }

        return redirect(route('playground.matrix.resource.versions.show', ['version' => $version->id]));
    }

    /**
     * Display the Version resource.
     *
     * @route GET /resource/matrix/{version} playground.matrix.resource.versions.show
     */
    public function show(
        Version $version,
        ShowRequest $request
    ): JsonResponse|View {
        $validated = $request->validated();

        $user = $request->user();

        $meta = [
            'session_user_id' => $user->id,
            'id'              => $version->id,
            'timestamp'       => Carbon::now()->toJson(),
            'validated'       => $validated,
            'info'            => $this->packageInfo,
        ];

        if ($request->expectsJson()) {
            return new VersionResource($version);
        }

        $meta['input'] = $request->input();
        $meta['validated'] = $request->validated();

        $data = [
            'data' => $version,
            'meta' => $meta,
        ];

        return view(
            'playground-matrix-resource::version/detail',
            $data
        );
    }

   /**
     * Store a newly created API Version resource in storage.
     *
     * @route POST /resource/matrix playground.matrix.resource.versions.post
     */
    public function store(
        StoreRequest $request
    ): Response|JsonResponse|RedirectResponse {
        $validated = $request->validated();

        $user = $request->user();

        $version = new Version($validated);

        $version->save();

        if ($request->expectsJson()) {
            return new VersionResource($version);
        }

        $returnUrl = $validated['return_url'] ?? '';

        if ($returnUrl) {
            return redirect($returnUrl);
        }

        return redirect(route('playground.matrix.resource.versions.show', ['version' => $version->id]));
    }

    /**
     * Unlock the Version resource in storage.
     *
     * @route DELETE /resource/matrix/lock/{version} playground.matrix.resource.versions.unlock
     */
    public function unlock(
        Version $version,
        UnlockRequest $request
    ): JsonResponse|RedirectResponse {
        $validated = $request->validated();

        $user = $request->user();

        $version->locked = false;

        $version->save();

        if ($request->expectsJson()) {
            return new VersionResource($version);
        }

        $returnUrl = $validated['return_url'] ?? '';

        if ($returnUrl) {
            return redirect($returnUrl);
        }

        return redirect(route('playground.matrix.resource.versions.show', ['version' => $version->id]));
    }

    /**
     * Update the Version resource in storage.
     *
     * @route PATCH /resource/matrix/{version} playground.matrix.resource.versions.patch
     */
    public function update(
        Version $version,
        UpdateRequest $request
    ): JsonResponse|RedirectResponse {
        $validated = $request->validated();

        $user = $request->user();

        $version->update($validated);

        if ($request->expectsJson()) {
            return new VersionResource($version);
        }

        $returnUrl = $validated['return_url'] ?? '';

        if ($returnUrl) {
            return redirect($returnUrl);
        }

        return redirect(route('playground.matrix.resource.versions.show', ['version' => $version->id]));
    }
}
