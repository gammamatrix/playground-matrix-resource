<?php
/**
 * GammaMatrix
 */

namespace GammaMatrix\Playground\Matrix\Resource\Http\Controllers;

use GammaMatrix\Playground\Http\Controllers\Controller;
use GammaMatrix\Playground\Matrix\Models\Release;
use GammaMatrix\Playground\Matrix\Resource\Http\Requests\Release\CreateRequest;
use GammaMatrix\Playground\Matrix\Resource\Http\Requests\Release\DestroyRequest;
use GammaMatrix\Playground\Matrix\Resource\Http\Requests\Release\EditRequest;
use GammaMatrix\Playground\Matrix\Resource\Http\Requests\Release\IndexRequest;
use GammaMatrix\Playground\Matrix\Resource\Http\Requests\Release\LockRequest;
use GammaMatrix\Playground\Matrix\Resource\Http\Requests\Release\RestoreRequest;
use GammaMatrix\Playground\Matrix\Resource\Http\Requests\Release\ShowRequest;
use GammaMatrix\Playground\Matrix\Resource\Http\Requests\Release\StoreRequest;
use GammaMatrix\Playground\Matrix\Resource\Http\Requests\Release\UnlockRequest;
use GammaMatrix\Playground\Matrix\Resource\Http\Requests\Release\UpdateRequest;
use GammaMatrix\Playground\Matrix\Resource\Http\Resources\Release\Release as ReleaseResource;
use GammaMatrix\Playground\Matrix\Resource\Http\Resources\Release\ReleaseCollection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * \GammaMatrix\Playground\Matrix\Resource\Http\Controllers\ReleaseController
 */
class ReleaseController extends Controller
{
    public array $packageInfo = [
        'model_attribute'     => 'label',
        'model_label'         => 'Release',
        'model_label_plural'  => 'Releases',
        'model_route'         => 'playground.matrix.resource.releases',
        'model_slug'          => 'release',
        'model_slug_plural'   => 'releases',
        'module_label'        => 'Matrix',
        'module_label_plural' => 'Matrices',
        'module_route'        => 'playground.matrix.resource',
        'module_slug'         => 'matrix',
        'privilege'           => 'playground-matrix-resource:release',
        'table'               => 'matrix_releases',
        'view'                => 'playground-matrix-resource::release',
    ];

    /**
     * CREATE the Release resource in storage.
     *
     * @route GET /resource/matrix/releases/create playground.matrix.resource.releases.create
     */
    public function create(
        CreateRequest $request
    ): JsonResponse|View {
        $validated = $request->validated();

        $user = $request->user();

        $release = new Release($validated);

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
            'data' => $release,
            'meta' => $meta,
            '_method' => 'post',
        ];

        if ($request->expectsJson()) {
            return response()->json($data);
        }

        $flash = $release->toArray();

        if (!empty($validated['_return_url'])) {
            $flash['_return_url'] = $validated['_return_url'];
            $data['_return_url'] = $validated['_return_url'];
        }

        if (!$request->session()->has('errors')) {
            session()->flashInput($flash);
        }

        return view(
            'playground-matrix-resource::release/form',
            $data
        );
    }

    /**
     * Edit the Release resource in storage.
     *
     * @route GET /resource/matrix/releases/edit playground.matrix.resource.releases.edit
     */
    public function edit(
        Release $release,
        EditRequest $request
    ): JsonResponse|View {
        $validated = $request->validated();

        $user = $request->user();

        $meta = [
            'session_user_id' => $user->id,
            'id'              => $release->id,
            'timestamp'       => Carbon::now()->toJson(),
            'validated'       => $validated,
            'info'            => $this->packageInfo,
        ];

        $meta['input'] = $request->input();
        $meta['validated'] = $request->validated();

        $data = [
            'data' => $release,
            'meta' => $meta,
            '_method' => 'patch',
        ];

        if ($request->expectsJson()) {
            return response()->json($data);
        }

        $flash = $release->toArray();

        if (!empty($validated['_return_url'])) {
            $flash['_return_url'] = $validated['_return_url'];
            $data['_return_url'] = $validated['_return_url'];
        }

        session()->flashInput($flash);

        return view(
            'playground-matrix-resource::release/form',
            $data
        );
    }

    /**
     * Remove the Release resource from storage.
     *
     * @route DELETE /resource/matrix/{release} playground.matrix.resource.releases.destroy
     */
    public function destroy(
        Release $release,
        DestroyRequest $request
    ): Response|RedirectResponse {
        $validated = $request->validated();

        if (empty($validated['force'])) {
            $release->delete();
        } else {
            $release->forceDelete();
        }

        if ($request->expectsJson()) {
            return response()->noContent();
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl) {
            return redirect($returnUrl);
        }

        return redirect(route('playground.matrix.resource.releases'));
    }

    /**
     * Lock the Release resource in storage.
     *
     * @route PUT /resource/matrix/{release} playground.matrix.resource.releases.lock
     */
    public function lock(
        Release $release,
        LockRequest $request
    ): JsonResponse|RedirectResponse {
        $validated = $request->validated();

        $user = $request->user();

        $release->locked = true;

        $release->save();

        $meta = [
            'session_user_id' => $user->id,
            'id'              => $release->id,
            'timestamp'       => Carbon::now()->toJson(),
            'info'            => $this->packageInfo,
        ];

        if ($request->expectsJson()) {
            return new ReleaseResource($release);
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl) {
            return redirect($returnUrl);
        }

        return redirect(route('playground.matrix.resource.releases.show', ['release' => $release->id]));
    }

    /**
     * Display a listing of Release resources.
     *
     * @route GET /resource/matrix playground.matrix.resource.releases
     */
    public function index(
        IndexRequest $request
    ): JsonResponse|View {
        $user = $request->user();

        $validated = $request->validated();

        $query = Release::addSelect(sprintf('%1$s.*', $this->packageInfo['table']));

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
            return (new ReleaseCollection($paginator))->additional(['meta' => [
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
            'playground-matrix-resource::release/index',
            $data
        );
    }

    /**
     * Restore the Release resource from the trash.
     *
     * @route PUT /resource/matrix/restore/{release} playground.matrix.resource.releases.restore
     */
    public function restore(
        Release $release,
        RestoreRequest $request
    ): JsonResponse|RedirectResponse {
        $validated = $request->validated();

        $user = $request->user();

        $release->restore();

        if ($request->expectsJson()) {
            return new ReleaseResource($release);
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl) {
            return redirect($returnUrl);
        }

        return redirect(route('playground.matrix.resource.releases.show', ['release' => $release->id]));
    }

    /**
     * Display the Release resource.
     *
     * @route GET /resource/matrix/{release} playground.matrix.resource.releases.show
     */
    public function show(
        Release $release,
        ShowRequest $request
    ): JsonResponse|View {
        $validated = $request->validated();

        $user = $request->user();

        $meta = [
            'session_user_id' => $user->id,
            'id'              => $release->id,
            'timestamp'       => Carbon::now()->toJson(),
            'validated'       => $validated,
            'info'            => $this->packageInfo,
        ];

        if ($request->expectsJson()) {
            return new ReleaseResource($release);
        }

        $meta['input'] = $request->input();
        $meta['validated'] = $request->validated();

        $data = [
            'data' => $release,
            'meta' => $meta,
        ];

        return view(
            'playground-matrix-resource::release/detail',
            $data
        );
    }

   /**
     * Store a newly created API Release resource in storage.
     *
     * @route POST /resource/matrix playground.matrix.resource.releases.post
     */
    public function store(
        StoreRequest $request
    ): Response|JsonResponse|RedirectResponse {
        $validated = $request->validated();

        $user = $request->user();

        $release = new Release($validated);

        $release->save();

        if ($request->expectsJson()) {
            return new ReleaseResource($release);
        }

        $returnUrl = $validated['return_url'] ?? '';

        if ($returnUrl) {
            return redirect($returnUrl);
        }

        return redirect(route('playground.matrix.resource.releases.show', ['release' => $release->id]));
    }

    /**
     * Unlock the Release resource in storage.
     *
     * @route DELETE /resource/matrix/lock/{release} playground.matrix.resource.releases.unlock
     */
    public function unlock(
        Release $release,
        UnlockRequest $request
    ): JsonResponse|RedirectResponse {
        $validated = $request->validated();

        $user = $request->user();

        $release->locked = false;

        $release->save();

        if ($request->expectsJson()) {
            return new ReleaseResource($release);
        }

        $returnUrl = $validated['return_url'] ?? '';

        if ($returnUrl) {
            return redirect($returnUrl);
        }

        return redirect(route('playground.matrix.resource.releases.show', ['release' => $release->id]));
    }

    /**
     * Update the Release resource in storage.
     *
     * @route PATCH /resource/matrix/{release} playground.matrix.resource.releases.patch
     */
    public function update(
        Release $release,
        UpdateRequest $request
    ): JsonResponse|RedirectResponse {
        $validated = $request->validated();

        $user = $request->user();

        $release->update($validated);

        if ($request->expectsJson()) {
            return new ReleaseResource($release);
        }

        $returnUrl = $validated['return_url'] ?? '';

        if ($returnUrl) {
            return redirect($returnUrl);
        }

        return redirect(route('playground.matrix.resource.releases.show', ['release' => $release->id]));
    }
}
