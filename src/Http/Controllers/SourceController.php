<?php
/**
 * GammaMatrix
 */

namespace GammaMatrix\Playground\Matrix\Resource\Http\Controllers;

use GammaMatrix\Playground\Http\Controllers\Controller;
use GammaMatrix\Playground\Matrix\Models\Source;
use GammaMatrix\Playground\Matrix\Resource\Http\Requests\Source\CreateRequest;
use GammaMatrix\Playground\Matrix\Resource\Http\Requests\Source\DestroyRequest;
use GammaMatrix\Playground\Matrix\Resource\Http\Requests\Source\EditRequest;
use GammaMatrix\Playground\Matrix\Resource\Http\Requests\Source\IndexRequest;
use GammaMatrix\Playground\Matrix\Resource\Http\Requests\Source\LockRequest;
use GammaMatrix\Playground\Matrix\Resource\Http\Requests\Source\RestoreRequest;
use GammaMatrix\Playground\Matrix\Resource\Http\Requests\Source\ShowRequest;
use GammaMatrix\Playground\Matrix\Resource\Http\Requests\Source\StoreRequest;
use GammaMatrix\Playground\Matrix\Resource\Http\Requests\Source\UnlockRequest;
use GammaMatrix\Playground\Matrix\Resource\Http\Requests\Source\UpdateRequest;
use GammaMatrix\Playground\Matrix\Resource\Http\Resources\Source as SourceResource;
use GammaMatrix\Playground\Matrix\Resource\Http\Resources\SourceCollection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * \GammaMatrix\Playground\Matrix\Resource\Http\Controllers\SourceController
 */
class SourceController extends Controller
{
    public array $packageInfo = [
        'model_attribute'     => 'label',
        'model_label'         => 'Source',
        'model_label_plural'  => 'Sources',
        'model_route'         => 'playground.matrix.resource.sources',
        'model_slug'          => 'source',
        'model_slug_plural'   => 'sources',
        'module_label'        => 'Matrix',
        'module_label_plural' => 'Matrices',
        'module_route'        => 'playground.matrix.resource',
        'module_slug'         => 'matrix',
        'privilege'           => 'playground-matrix-resource:source',
        'table'               => 'matrix_sources',
        'view'                => 'playground-matrix-resource::source',
    ];

    /**
     * CREATE the Source resource in storage.
     *
     * @route GET /resource/matrix/sources/create playground.matrix.resource.sources.create
     */
    public function create(
        CreateRequest $request
    ): JsonResponse|View {
        $validated = $request->validated();

        $user = $request->user();

        $source = new Source($validated);

        $meta = [
            'session_user_id' => $user?->id,
            'id'              => null,
            'timestamp'       => Carbon::now()->toJson(),
            'validated'       => $validated,
            'info'            => $this->packageInfo,
        ];

        $meta['input'] = $request->input();
        $meta['validated'] = $request->validated();

        $data = [
            'data' => $source,
            'meta' => $meta,
            '_method' => 'post',
        ];

        if ($request->expectsJson()) {
            return response()->json($data);
        }

        $flash = $source->toArray();

        if (!empty($validated['_return_url'])) {
            $flash['_return_url'] = $validated['_return_url'];
            $data['_return_url'] = $validated['_return_url'];
        }

        if (!$request->session()->has('errors')) {
            session()->flashInput($flash);
        }

        return view(
            'playground-matrix-resource::source/form',
            $data
        );
    }

    /**
     * Edit the Source resource in storage.
     *
     * @route GET /resource/matrix/sources/edit playground.matrix.resource.sources.edit
     */
    public function edit(
        Source $source,
        EditRequest $request
    ): JsonResponse|View {
        $validated = $request->validated();

        $user = $request->user();

        $meta = [
            'session_user_id' => $user?->id,
            'id'              => $source->id,
            'timestamp'       => Carbon::now()->toJson(),
            'validated'       => $validated,
            'info'            => $this->packageInfo,
        ];

        $meta['input'] = $request->input();
        $meta['validated'] = $request->validated();

        $data = [
            'data' => $source,
            'meta' => $meta,
            '_method' => 'patch',
        ];

        if ($request->expectsJson()) {
            return response()->json($data);
        }

        $flash = $source->toArray();

        if (!empty($validated['_return_url'])) {
            $flash['_return_url'] = $validated['_return_url'];
            $data['_return_url'] = $validated['_return_url'];
        }

        session()->flashInput($flash);

        return view(
            'playground-matrix-resource::source/form',
            $data
        );
    }

    /**
     * Remove the Source resource from storage.
     *
     * @route DELETE /resource/matrix/{source} playground.matrix.resource.sources.destroy
     */
    public function destroy(
        Source $source,
        DestroyRequest $request
    ): Response|RedirectResponse {
        $validated = $request->validated();

        if (empty($validated['force'])) {
            $source->delete();
        } else {
            $source->forceDelete();
        }

        if ($request->expectsJson()) {
            return response()->noContent();
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl) {
            return redirect($returnUrl);
        }

        return redirect(route('playground.matrix.resource.sources'));
    }

    /**
     * Lock the Source resource in storage.
     *
     * @route PUT /resource/matrix/{source} playground.matrix.resource.sources.lock
     */
    public function lock(
        Source $source,
        LockRequest $request
    ): JsonResponse|RedirectResponse|SourceResource {
        $validated = $request->validated();

        $user = $request->user();

        $source->locked = true;

        $source->save();

        $meta = [
            'session_user_id' => $user?->id,
            'id'              => $source->id,
            'timestamp'       => Carbon::now()->toJson(),
            'info'            => $this->packageInfo,
        ];

        if ($request->expectsJson()) {
            return (new SourceResource($source))->response($request);
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl) {
            return redirect($returnUrl);
        }

        return redirect(route('playground.matrix.resource.sources.show', ['source' => $source->id]));
    }

    /**
     * Display a listing of Source resources.
     *
     * @route GET /resource/matrix playground.matrix.resource.sources
     */
    public function index(
        IndexRequest $request
    ): JsonResponse|View|SourceCollection {
        $user = $request->user();

        $validated = $request->validated();

        $query = Source::addSelect(sprintf('%1$s.*', $this->packageInfo['table']));

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
            return (new SourceCollection($paginator))->response($request);
        }

        $meta = [
            'session_user_id' => $user?->id,
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
            'playground-matrix-resource::source/index',
            $data
        );
    }

    /**
     * Restore the Source resource from the trash.
     *
     * @route PUT /resource/matrix/restore/{source} playground.matrix.resource.sources.restore
     */
    public function restore(
        Source $source,
        RestoreRequest $request
    ): JsonResponse|RedirectResponse|SourceResource {
        $validated = $request->validated();

        $user = $request->user();

        $source->restore();

        if ($request->expectsJson()) {
            return (new SourceResource($source))->response($request);
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl) {
            return redirect($returnUrl);
        }

        return redirect(route('playground.matrix.resource.sources.show', ['source' => $source->id]));
    }

    /**
     * Display the Source resource.
     *
     * @route GET /resource/matrix/{source} playground.matrix.resource.sources.show
     */
    public function show(
        Source $source,
        ShowRequest $request
    ): JsonResponse|View|SourceResource {
        $validated = $request->validated();

        $user = $request->user();

        $meta = [
            'session_user_id' => $user?->id,
            'id'              => $source->id,
            'timestamp'       => Carbon::now()->toJson(),
            'validated'       => $validated,
            'info'            => $this->packageInfo,
        ];

        if ($request->expectsJson()) {
            return (new SourceResource($source))->response($request);
        }

        $meta['input'] = $request->input();
        $meta['validated'] = $request->validated();

        $data = [
            'data' => $source,
            'meta' => $meta,
        ];

        return view(
            'playground-matrix-resource::source/detail',
            $data
        );
    }

    /**
      * Store a newly created API Source resource in storage.
      *
      * @route POST /resource/matrix playground.matrix.resource.sources.post
      */
    public function store(
        StoreRequest $request
    ): Response|JsonResponse|RedirectResponse|SourceResource {
        $validated = $request->validated();

        $user = $request->user();

        $source = new Source($validated);

        $source->save();

        if ($request->expectsJson()) {
            return (new SourceResource($source))->response($request);
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl) {
            return redirect($returnUrl);
        }

        return redirect(route('playground.matrix.resource.sources.show', ['source' => $source->id]));
    }

    /**
     * Unlock the Source resource in storage.
     *
     * @route DELETE /resource/matrix/lock/{source} playground.matrix.resource.sources.unlock
     */
    public function unlock(
        Source $source,
        UnlockRequest $request
    ): JsonResponse|RedirectResponse|SourceResource {
        $validated = $request->validated();

        $user = $request->user();

        $source->locked = false;

        $source->save();

        if ($request->expectsJson()) {
            return (new SourceResource($source))->response($request);
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl) {
            return redirect($returnUrl);
        }

        return redirect(route('playground.matrix.resource.sources.show', ['source' => $source->id]));
    }

    /**
     * Update the Source resource in storage.
     *
     * @route PATCH /resource/matrix/{source} playground.matrix.resource.sources.patch
     */
    public function update(
        Source $source,
        UpdateRequest $request
    ): JsonResponse|RedirectResponse|SourceResource {
        $validated = $request->validated();

        $user = $request->user();

        $source->update($validated);

        if ($request->expectsJson()) {
            return (new SourceResource($source))->response($request);
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl) {
            return redirect($returnUrl);
        }

        return redirect(route('playground.matrix.resource.sources.show', ['source' => $source->id]));
    }
}
