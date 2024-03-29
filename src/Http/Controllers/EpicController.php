<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Playground\Matrix\Resource\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\View\View;
use Playground\Matrix\Models\Epic;
use Playground\Matrix\Resource\Http\Requests\Epic\CreateRequest;
use Playground\Matrix\Resource\Http\Requests\Epic\DestroyRequest;
use Playground\Matrix\Resource\Http\Requests\Epic\EditRequest;
use Playground\Matrix\Resource\Http\Requests\Epic\IndexRequest;
use Playground\Matrix\Resource\Http\Requests\Epic\LockRequest;
use Playground\Matrix\Resource\Http\Requests\Epic\RestoreRequest;
use Playground\Matrix\Resource\Http\Requests\Epic\ShowRequest;
use Playground\Matrix\Resource\Http\Requests\Epic\StoreRequest;
use Playground\Matrix\Resource\Http\Requests\Epic\UnlockRequest;
use Playground\Matrix\Resource\Http\Requests\Epic\UpdateRequest;
use Playground\Matrix\Resource\Http\Resources\Epic as EpicResource;
use Playground\Matrix\Resource\Http\Resources\EpicCollection;

/**
 * \Playground\Matrix\Resource\Http\Controllers\EpicController
 */
class EpicController extends Controller
{
    /**
     * @var array<string, string>
     */
    public array $packageInfo = [
        'model_attribute' => 'label',
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
     * CREATE the Epic resource in storage.
     *
     * @route GET /resource/matrix/epics/create playground.matrix.resource.epics.create
     */
    public function create(
        CreateRequest $request
    ): JsonResponse|View {
        $validated = $request->validated();

        $user = $request->user();

        $epic = new Epic($validated);

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

        if ($request->expectsJson()) {
            return response()->json($data);
        }

        $flash = $epic->toArray();

        if (! empty($validated['_return_url'])) {
            $flash['_return_url'] = $validated['_return_url'];
            $data['_return_url'] = $validated['_return_url'];
        }

        if (! $request->session()->has('errors')) {
            session()->flashInput($flash);
        }

        return view(
            'playground-matrix-resource::epic/form',
            $data
        );
    }

    /**
     * Edit the Epic resource in storage.
     *
     * @route GET /resource/matrix/epics/edit playground.matrix.resource.epics.edit
     */
    public function edit(
        Epic $epic,
        EditRequest $request
    ): JsonResponse|View {
        $validated = $request->validated();

        $user = $request->user();

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

        if ($request->expectsJson()) {
            return response()->json($data);
        }

        $flash = $epic->toArray();

        if (! empty($validated['_return_url'])) {
            $flash['_return_url'] = $validated['_return_url'];
            $data['_return_url'] = $validated['_return_url'];
        }

        session()->flashInput($flash);

        return view(
            'playground-matrix-resource::epic/form',
            $data
        );
    }

    /**
     * Remove the Epic resource from storage.
     *
     * @route DELETE /resource/matrix/{epic} playground.matrix.resource.epics.destroy
     */
    public function destroy(
        Epic $epic,
        DestroyRequest $request
    ): Response|RedirectResponse {
        $validated = $request->validated();

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

        return redirect(route('playground.matrix.resource.epics'));
    }

    /**
     * Lock the Epic resource in storage.
     *
     * @route PUT /resource/matrix/{epic} playground.matrix.resource.epics.lock
     */
    public function lock(
        Epic $epic,
        LockRequest $request
    ): JsonResponse|RedirectResponse|EpicResource {
        $validated = $request->validated();

        $user = $request->user();

        $epic->setAttribute('locked', true);

        $epic->save();

        $meta = [
            'session_user_id' => $user?->id,
            'id' => $epic->id,
            'timestamp' => Carbon::now()->toJson(),
            'info' => $this->packageInfo,
        ];

        if ($request->expectsJson()) {
            return (new EpicResource($epic))->response($request);
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl && is_string($returnUrl)) {
            return redirect($returnUrl);
        }

        return redirect(route('playground.matrix.resource.epics.show', ['epic' => $epic->id]));
    }

    /**
     * Display a listing of Epic resources.
     *
     * @route GET /resource/matrix playground.matrix.resource.epics
     */
    public function index(
        IndexRequest $request
    ): JsonResponse|View|EpicCollection {
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
        $paginator = $query->paginate( $perPage);

        $paginator->appends($validated);

        if ($request->expectsJson()) {
            return (new EpicCollection($paginator))->response($request);
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

        return view(
            'playground-matrix-resource::epic/index',
            $data
        );
    }

    /**
     * Restore the Epic resource from the trash.
     *
     * @route PUT /resource/matrix/restore/{epic} playground.matrix.resource.epics.restore
     */
    public function restore(
        Epic $epic,
        RestoreRequest $request
    ): JsonResponse|RedirectResponse|EpicResource {
        $validated = $request->validated();

        $user = $request->user();

        $epic->restore();

        if ($request->expectsJson()) {
            return (new EpicResource($epic))->response($request);
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl && is_string($returnUrl)) {
            return redirect($returnUrl);
        }

        return redirect(route('playground.matrix.resource.epics.show', ['epic' => $epic->id]));
    }

    /**
     * Display the Epic resource.
     *
     * @route GET /resource/matrix/{epic} playground.matrix.resource.epics.show
     */
    public function show(
        Epic $epic,
        ShowRequest $request
    ): JsonResponse|View|EpicResource {
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
            return (new EpicResource($epic))->response($request);
        }

        $meta['input'] = $request->input();
        $meta['validated'] = $request->validated();

        $data = [
            'data' => $epic,
            'meta' => $meta,
        ];

        return view(
            'playground-matrix-resource::epic/detail',
            $data
        );
    }

    /**
     * Store a newly created API Epic resource in storage.
     *
     * @route POST /resource/matrix playground.matrix.resource.epics.post
     */
    public function store(
        StoreRequest $request
    ): Response|JsonResponse|RedirectResponse|EpicResource {
        $validated = $request->validated();

        $user = $request->user();

        $epic = new Epic($validated);

        $epic->save();

        if ($request->expectsJson()) {
            return (new EpicResource($epic))->response($request);
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl && is_string($returnUrl)) {
            return redirect($returnUrl);
        }

        return redirect(route('playground.matrix.resource.epics.show', ['epic' => $epic->id]));
    }

    /**
     * Unlock the Epic resource in storage.
     *
     * @route DELETE /resource/matrix/lock/{epic} playground.matrix.resource.epics.unlock
     */
    public function unlock(
        Epic $epic,
        UnlockRequest $request
    ): JsonResponse|RedirectResponse|EpicResource {
        $validated = $request->validated();

        $user = $request->user();

        $epic->setAttribute('locked', false);

        $epic->save();

        if ($request->expectsJson()) {
            return (new EpicResource($epic))->response($request);
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl && is_string($returnUrl)) {
            return redirect($returnUrl);
        }

        return redirect(route('playground.matrix.resource.epics.show', ['epic' => $epic->id]));
    }

    /**
     * Update the Epic resource in storage.
     *
     * @route PATCH /resource/matrix/{epic} playground.matrix.resource.epics.patch
     */
    public function update(
        Epic $epic,
        UpdateRequest $request
    ): JsonResponse|RedirectResponse|EpicResource {
        $validated = $request->validated();

        $user = $request->user();

        $epic->update($validated);

        if ($request->expectsJson()) {
            return (new EpicResource($epic))->response($request);
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl && is_string($returnUrl)) {
            return redirect($returnUrl);
        }

        return redirect(route('playground.matrix.resource.epics.show', ['epic' => $epic->id]));
    }
}
