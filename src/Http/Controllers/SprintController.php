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
use Playground\Matrix\Models\Sprint;
use Playground\Matrix\Resource\Http\Requests\Sprint\CreateRequest;
use Playground\Matrix\Resource\Http\Requests\Sprint\DestroyRequest;
use Playground\Matrix\Resource\Http\Requests\Sprint\EditRequest;
use Playground\Matrix\Resource\Http\Requests\Sprint\IndexRequest;
use Playground\Matrix\Resource\Http\Requests\Sprint\LockRequest;
use Playground\Matrix\Resource\Http\Requests\Sprint\RestoreRequest;
use Playground\Matrix\Resource\Http\Requests\Sprint\ShowRequest;
use Playground\Matrix\Resource\Http\Requests\Sprint\StoreRequest;
use Playground\Matrix\Resource\Http\Requests\Sprint\UnlockRequest;
use Playground\Matrix\Resource\Http\Requests\Sprint\UpdateRequest;
use Playground\Matrix\Resource\Http\Resources\Sprint as SprintResource;
use Playground\Matrix\Resource\Http\Resources\SprintCollection;

/**
 * \Playground\Matrix\Resource\Http\Controllers\SprintController
 */
class SprintController extends Controller
{
    /**
     * @var array<string, string>
     */
    public array $packageInfo = [
        'model_attribute' => 'label',
        'model_label' => 'Sprint',
        'model_label_plural' => 'Sprints',
        'model_route' => 'playground.matrix.resource.sprints',
        'model_slug' => 'sprint',
        'model_slug_plural' => 'sprints',
        'module_label' => 'Matrix',
        'module_label_plural' => 'Matrices',
        'module_route' => 'playground.matrix.resource',
        'module_slug' => 'matrix',
        'privilege' => 'playground-matrix-resource:sprint',
        'table' => 'matrix_sprints',
        'view' => 'playground-matrix-resource::sprint',
    ];

    /**
     * CREATE the Sprint resource in storage.
     *
     * @route GET /resource/matrix/sprints/create playground.matrix.resource.sprints.create
     */
    public function create(
        CreateRequest $request
    ): JsonResponse|View {
        $validated = $request->validated();

        $user = $request->user();

        $sprint = new Sprint($validated);

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
            'data' => $sprint,
            'meta' => $meta,
            '_method' => 'post',
        ];

        if ($request->expectsJson()) {
            return response()->json($data);
        }

        $flash = $sprint->toArray();

        if (! empty($validated['_return_url'])) {
            $flash['_return_url'] = $validated['_return_url'];
            $data['_return_url'] = $validated['_return_url'];
        }

        if (! $request->session()->has('errors')) {
            session()->flashInput($flash);
        }

        return view(
            'playground-matrix-resource::sprint/form',
            $data
        );
    }

    /**
     * Edit the Sprint resource in storage.
     *
     * @route GET /resource/matrix/sprints/edit playground.matrix.resource.sprints.edit
     */
    public function edit(
        Sprint $sprint,
        EditRequest $request
    ): JsonResponse|View {
        $validated = $request->validated();

        $user = $request->user();

        $meta = [
            'session_user_id' => $user?->id,
            'id' => $sprint->id,
            'timestamp' => Carbon::now()->toJson(),
            'validated' => $validated,
            'info' => $this->packageInfo,
        ];

        $meta['input'] = $request->input();
        $meta['validated'] = $request->validated();

        $data = [
            'data' => $sprint,
            'meta' => $meta,
            '_method' => 'patch',
        ];

        if ($request->expectsJson()) {
            return response()->json($data);
        }

        $flash = $sprint->toArray();

        if (! empty($validated['_return_url'])) {
            $flash['_return_url'] = $validated['_return_url'];
            $data['_return_url'] = $validated['_return_url'];
        }

        session()->flashInput($flash);

        return view(
            'playground-matrix-resource::sprint/form',
            $data
        );
    }

    /**
     * Remove the Sprint resource from storage.
     *
     * @route DELETE /resource/matrix/{sprint} playground.matrix.resource.sprints.destroy
     */
    public function destroy(
        Sprint $sprint,
        DestroyRequest $request
    ): Response|RedirectResponse {
        $validated = $request->validated();

        if (empty($validated['force'])) {
            $sprint->delete();
        } else {
            $sprint->forceDelete();
        }

        if ($request->expectsJson()) {
            return response()->noContent();
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl && is_string($returnUrl)) {
            return redirect($returnUrl);
        }

        return redirect(route('playground.matrix.resource.sprints'));
    }

    /**
     * Lock the Sprint resource in storage.
     *
     * @route PUT /resource/matrix/{sprint} playground.matrix.resource.sprints.lock
     */
    public function lock(
        Sprint $sprint,
        LockRequest $request
    ): JsonResponse|RedirectResponse|SprintResource {
        $validated = $request->validated();

        $user = $request->user();

        $sprint->setAttribute('locked', true);

        $sprint->save();

        $meta = [
            'session_user_id' => $user?->id,
            'id' => $sprint->id,
            'timestamp' => Carbon::now()->toJson(),
            'info' => $this->packageInfo,
        ];

        if ($request->expectsJson()) {
            return (new SprintResource($sprint))->response($request);
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl && is_string($returnUrl)) {
            return redirect($returnUrl);
        }

        return redirect(route('playground.matrix.resource.sprints.show', ['sprint' => $sprint->id]));
    }

    /**
     * Display a listing of Sprint resources.
     *
     * @route GET /resource/matrix playground.matrix.resource.sprints
     */
    public function index(
        IndexRequest $request
    ): JsonResponse|View|SprintCollection {
        $user = $request->user();

        $validated = $request->validated();

        $query = Sprint::addSelect(sprintf('%1$s.*', $this->packageInfo['table']));

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
            return (new SprintCollection($paginator))->response($request);
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
            'playground-matrix-resource::sprint/index',
            $data
        );
    }

    /**
     * Restore the Sprint resource from the trash.
     *
     * @route PUT /resource/matrix/restore/{sprint} playground.matrix.resource.sprints.restore
     */
    public function restore(
        Sprint $sprint,
        RestoreRequest $request
    ): JsonResponse|RedirectResponse|SprintResource {
        $validated = $request->validated();

        $user = $request->user();

        $sprint->restore();

        if ($request->expectsJson()) {
            return (new SprintResource($sprint))->response($request);
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl && is_string($returnUrl)) {
            return redirect($returnUrl);
        }

        return redirect(route('playground.matrix.resource.sprints.show', ['sprint' => $sprint->id]));
    }

    /**
     * Display the Sprint resource.
     *
     * @route GET /resource/matrix/{sprint} playground.matrix.resource.sprints.show
     */
    public function show(
        Sprint $sprint,
        ShowRequest $request
    ): JsonResponse|View|SprintResource {
        $validated = $request->validated();

        $user = $request->user();

        $meta = [
            'session_user_id' => $user?->id,
            'id' => $sprint->id,
            'timestamp' => Carbon::now()->toJson(),
            'validated' => $validated,
            'info' => $this->packageInfo,
        ];

        if ($request->expectsJson()) {
            return (new SprintResource($sprint))->response($request);
        }

        $meta['input'] = $request->input();
        $meta['validated'] = $request->validated();

        $data = [
            'data' => $sprint,
            'meta' => $meta,
        ];

        return view(
            'playground-matrix-resource::sprint/detail',
            $data
        );
    }

    /**
     * Store a newly created API Sprint resource in storage.
     *
     * @route POST /resource/matrix playground.matrix.resource.sprints.post
     */
    public function store(
        StoreRequest $request
    ): Response|JsonResponse|RedirectResponse|SprintResource {
        $validated = $request->validated();

        $user = $request->user();

        $sprint = new Sprint($validated);

        $sprint->save();

        if ($request->expectsJson()) {
            return (new SprintResource($sprint))->response($request);
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl && is_string($returnUrl)) {
            return redirect($returnUrl);
        }

        return redirect(route('playground.matrix.resource.sprints.show', ['sprint' => $sprint->id]));
    }

    /**
     * Unlock the Sprint resource in storage.
     *
     * @route DELETE /resource/matrix/lock/{sprint} playground.matrix.resource.sprints.unlock
     */
    public function unlock(
        Sprint $sprint,
        UnlockRequest $request
    ): JsonResponse|RedirectResponse|SprintResource {
        $validated = $request->validated();

        $user = $request->user();

        $sprint->setAttribute('locked', false);

        $sprint->save();

        if ($request->expectsJson()) {
            return (new SprintResource($sprint))->response($request);
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl && is_string($returnUrl)) {
            return redirect($returnUrl);
        }

        return redirect(route('playground.matrix.resource.sprints.show', ['sprint' => $sprint->id]));
    }

    /**
     * Update the Sprint resource in storage.
     *
     * @route PATCH /resource/matrix/{sprint} playground.matrix.resource.sprints.patch
     */
    public function update(
        Sprint $sprint,
        UpdateRequest $request
    ): JsonResponse|RedirectResponse|SprintResource {
        $validated = $request->validated();

        $user = $request->user();

        $sprint->update($validated);

        if ($request->expectsJson()) {
            return (new SprintResource($sprint))->response($request);
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl && is_string($returnUrl)) {
            return redirect($returnUrl);
        }

        return redirect(route('playground.matrix.resource.sprints.show', ['sprint' => $sprint->id]));
    }
}
