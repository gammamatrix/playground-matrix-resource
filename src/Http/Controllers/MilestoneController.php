<?php
/**
 * Playground
 */
namespace Playground\Matrix\Resource\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\View\View;
use Playground\Matrix\Models\Milestone;
use Playground\Matrix\Resource\Http\Requests\Milestone\CreateRequest;
use Playground\Matrix\Resource\Http\Requests\Milestone\DestroyRequest;
use Playground\Matrix\Resource\Http\Requests\Milestone\EditRequest;
use Playground\Matrix\Resource\Http\Requests\Milestone\IndexRequest;
use Playground\Matrix\Resource\Http\Requests\Milestone\LockRequest;
use Playground\Matrix\Resource\Http\Requests\Milestone\RestoreRequest;
use Playground\Matrix\Resource\Http\Requests\Milestone\ShowRequest;
use Playground\Matrix\Resource\Http\Requests\Milestone\StoreRequest;
use Playground\Matrix\Resource\Http\Requests\Milestone\UnlockRequest;
use Playground\Matrix\Resource\Http\Requests\Milestone\UpdateRequest;
use Playground\Matrix\Resource\Http\Resources\Milestone as MilestoneResource;
use Playground\Matrix\Resource\Http\Resources\MilestoneCollection;

/**
 * \Playground\Matrix\Resource\Http\Controllers\MilestoneController
 */
class MilestoneController extends Controller
{
    /**
     * @var array<string, string>
     */
    public array $packageInfo = [
        'model_attribute' => 'label',
        'model_label' => 'Milestone',
        'model_label_plural' => 'Milestones',
        'model_route' => 'playground.matrix.resource.milestones',
        'model_slug' => 'milestone',
        'model_slug_plural' => 'milestones',
        'module_label' => 'Matrix',
        'module_label_plural' => 'Matrices',
        'module_route' => 'playground.matrix.resource',
        'module_slug' => 'matrix',
        'privilege' => 'playground-matrix-resource:milestone',
        'table' => 'matrix_milestones',
        'view' => 'playground-matrix-resource::milestone',
    ];

    /**
     * CREATE the Milestone resource in storage.
     *
     * @route GET /resource/matrix/milestones/create playground.matrix.resource.milestones.create
     */
    public function create(
        CreateRequest $request
    ): JsonResponse|View {
        $validated = $request->validated();

        $user = $request->user();

        $milestone = new Milestone($validated);

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
            'data' => $milestone,
            'meta' => $meta,
            '_method' => 'post',
        ];

        if ($request->expectsJson()) {
            return response()->json($data);
        }

        $flash = $milestone->toArray();

        if (! empty($validated['_return_url'])) {
            $flash['_return_url'] = $validated['_return_url'];
            $data['_return_url'] = $validated['_return_url'];
        }

        if (! $request->session()->has('errors')) {
            session()->flashInput($flash);
        }

        return view(
            'playground-matrix-resource::milestone/form',
            $data
        );
    }

    /**
     * Edit the Milestone resource in storage.
     *
     * @route GET /resource/matrix/milestones/edit playground.matrix.resource.milestones.edit
     */
    public function edit(
        Milestone $milestone,
        EditRequest $request
    ): JsonResponse|View {
        $validated = $request->validated();

        $user = $request->user();

        $meta = [
            'session_user_id' => $user?->id,
            'id' => $milestone->id,
            'timestamp' => Carbon::now()->toJson(),
            'validated' => $validated,
            'info' => $this->packageInfo,
        ];

        $meta['input'] = $request->input();
        $meta['validated'] = $request->validated();

        $data = [
            'data' => $milestone,
            'meta' => $meta,
            '_method' => 'patch',
        ];

        if ($request->expectsJson()) {
            return response()->json($data);
        }

        $flash = $milestone->toArray();

        if (! empty($validated['_return_url'])) {
            $flash['_return_url'] = $validated['_return_url'];
            $data['_return_url'] = $validated['_return_url'];
        }

        session()->flashInput($flash);

        return view(
            'playground-matrix-resource::milestone/form',
            $data
        );
    }

    /**
     * Remove the Milestone resource from storage.
     *
     * @route DELETE /resource/matrix/{milestone} playground.matrix.resource.milestones.destroy
     */
    public function destroy(
        Milestone $milestone,
        DestroyRequest $request
    ): Response|RedirectResponse {
        $validated = $request->validated();

        if (empty($validated['force'])) {
            $milestone->delete();
        } else {
            $milestone->forceDelete();
        }

        if ($request->expectsJson()) {
            return response()->noContent();
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl && is_string($returnUrl)) {
            return redirect($returnUrl);
        }

        return redirect(route('playground.matrix.resource.milestones'));
    }

    /**
     * Lock the Milestone resource in storage.
     *
     * @route PUT /resource/matrix/{milestone} playground.matrix.resource.milestones.lock
     */
    public function lock(
        Milestone $milestone,
        LockRequest $request
    ): JsonResponse|RedirectResponse|MilestoneResource {
        $validated = $request->validated();

        $user = $request->user();

        $milestone->setAttribute('locked', true);

        $milestone->save();

        $meta = [
            'session_user_id' => $user?->id,
            'id' => $milestone->id,
            'timestamp' => Carbon::now()->toJson(),
            'info' => $this->packageInfo,
        ];

        if ($request->expectsJson()) {
            return (new MilestoneResource($milestone))->response($request);
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl && is_string($returnUrl)) {
            return redirect($returnUrl);
        }

        return redirect(route('playground.matrix.resource.milestones.show', ['milestone' => $milestone->id]));
    }

    /**
     * Display a listing of Milestone resources.
     *
     * @route GET /resource/matrix playground.matrix.resource.milestones
     */
    public function index(
        IndexRequest $request
    ): JsonResponse|View|MilestoneCollection {
        $user = $request->user();

        $validated = $request->validated();

        $query = Milestone::addSelect(sprintf('%1$s.*', $this->packageInfo['table']));

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
            return (new MilestoneCollection($paginator))->response($request);
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
            'playground-matrix-resource::milestone/index',
            $data
        );
    }

    /**
     * Restore the Milestone resource from the trash.
     *
     * @route PUT /resource/matrix/restore/{milestone} playground.matrix.resource.milestones.restore
     */
    public function restore(
        Milestone $milestone,
        RestoreRequest $request
    ): JsonResponse|RedirectResponse|MilestoneResource {
        $validated = $request->validated();

        $user = $request->user();

        $milestone->restore();

        if ($request->expectsJson()) {
            return (new MilestoneResource($milestone))->response($request);
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl && is_string($returnUrl)) {
            return redirect($returnUrl);
        }

        return redirect(route('playground.matrix.resource.milestones.show', ['milestone' => $milestone->id]));
    }

    /**
     * Display the Milestone resource.
     *
     * @route GET /resource/matrix/{milestone} playground.matrix.resource.milestones.show
     */
    public function show(
        Milestone $milestone,
        ShowRequest $request
    ): JsonResponse|View|MilestoneResource {
        $validated = $request->validated();

        $user = $request->user();

        $meta = [
            'session_user_id' => $user?->id,
            'id' => $milestone->id,
            'timestamp' => Carbon::now()->toJson(),
            'validated' => $validated,
            'info' => $this->packageInfo,
        ];

        if ($request->expectsJson()) {
            return (new MilestoneResource($milestone))->response($request);
        }

        $meta['input'] = $request->input();
        $meta['validated'] = $request->validated();

        $data = [
            'data' => $milestone,
            'meta' => $meta,
        ];

        return view(
            'playground-matrix-resource::milestone/detail',
            $data
        );
    }

    /**
     * Store a newly created API Milestone resource in storage.
     *
     * @route POST /resource/matrix playground.matrix.resource.milestones.post
     */
    public function store(
        StoreRequest $request
    ): Response|JsonResponse|RedirectResponse|MilestoneResource {
        $validated = $request->validated();

        $user = $request->user();

        $milestone = new Milestone($validated);

        $milestone->save();

        if ($request->expectsJson()) {
            return (new MilestoneResource($milestone))->response($request);
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl && is_string($returnUrl)) {
            return redirect($returnUrl);
        }

        return redirect(route('playground.matrix.resource.milestones.show', ['milestone' => $milestone->id]));
    }

    /**
     * Unlock the Milestone resource in storage.
     *
     * @route DELETE /resource/matrix/lock/{milestone} playground.matrix.resource.milestones.unlock
     */
    public function unlock(
        Milestone $milestone,
        UnlockRequest $request
    ): JsonResponse|RedirectResponse|MilestoneResource {
        $validated = $request->validated();

        $user = $request->user();

        $milestone->setAttribute('locked', false);

        $milestone->save();

        if ($request->expectsJson()) {
            return (new MilestoneResource($milestone))->response($request);
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl && is_string($returnUrl)) {
            return redirect($returnUrl);
        }

        return redirect(route('playground.matrix.resource.milestones.show', ['milestone' => $milestone->id]));
    }

    /**
     * Update the Milestone resource in storage.
     *
     * @route PATCH /resource/matrix/{milestone} playground.matrix.resource.milestones.patch
     */
    public function update(
        Milestone $milestone,
        UpdateRequest $request
    ): JsonResponse|RedirectResponse|MilestoneResource {
        $validated = $request->validated();

        $user = $request->user();

        $milestone->update($validated);

        if ($request->expectsJson()) {
            return (new MilestoneResource($milestone))->response($request);
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl && is_string($returnUrl)) {
            return redirect($returnUrl);
        }

        return redirect(route('playground.matrix.resource.milestones.show', ['milestone' => $milestone->id]));
    }
}
