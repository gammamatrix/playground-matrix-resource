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
use Playground\Matrix\Models\Project;
use Playground\Matrix\Resource\Http\Requests\Project\CreateRequest;
use Playground\Matrix\Resource\Http\Requests\Project\DestroyRequest;
use Playground\Matrix\Resource\Http\Requests\Project\EditRequest;
use Playground\Matrix\Resource\Http\Requests\Project\IndexRequest;
use Playground\Matrix\Resource\Http\Requests\Project\LockRequest;
use Playground\Matrix\Resource\Http\Requests\Project\RestoreRequest;
use Playground\Matrix\Resource\Http\Requests\Project\ShowRequest;
use Playground\Matrix\Resource\Http\Requests\Project\StoreRequest;
use Playground\Matrix\Resource\Http\Requests\Project\UnlockRequest;
use Playground\Matrix\Resource\Http\Requests\Project\UpdateRequest;
use Playground\Matrix\Resource\Http\Resources\Project as ProjectResource;
use Playground\Matrix\Resource\Http\Resources\ProjectCollection;

/**
 * \Playground\Matrix\Resource\Http\Controllers\ProjectController
 */
class ProjectController extends Controller
{
    /**
     * @var array<string, string>
     */
    public array $packageInfo = [
        'model_attribute' => 'label',
        'model_label' => 'Project',
        'model_label_plural' => 'Projects',
        'model_route' => 'playground.matrix.resource.projects',
        'model_slug' => 'project',
        'model_slug_plural' => 'projects',
        'module_label' => 'Matrix',
        'module_label_plural' => 'Matrices',
        'module_route' => 'playground.matrix.resource',
        'module_slug' => 'matrix',
        'privilege' => 'playground-matrix-resource:project',
        'table' => 'matrix_projects',
        'view' => 'playground-matrix-resource::project',
    ];

    /**
     * CREATE the Project resource in storage.
     *
     * @route GET /resource/matrix/projects/create playground.matrix.resource.projects.create
     */
    public function create(
        CreateRequest $request
    ): JsonResponse|View {
        $validated = $request->validated();

        $user = $request->user();

        $project = new Project($validated);

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
            'data' => $project,
            'meta' => $meta,
            '_method' => 'post',
        ];

        if ($request->expectsJson()) {
            return response()->json($data);
        }

        $flash = $project->toArray();

        if (! empty($validated['_return_url'])) {
            $flash['_return_url'] = $validated['_return_url'];
            $data['_return_url'] = $validated['_return_url'];
        }

        if (! $request->session()->has('errors')) {
            session()->flashInput($flash);
        }

        return view(
            'playground-matrix-resource::project/form',
            $data
        );
    }

    /**
     * Edit the Project resource in storage.
     *
     * @route GET /resource/matrix/projects/edit playground.matrix.resource.projects.edit
     */
    public function edit(
        Project $project,
        EditRequest $request
    ): JsonResponse|View {
        $validated = $request->validated();

        $user = $request->user();

        $meta = [
            'session_user_id' => $user?->id,
            'id' => $project->id,
            'timestamp' => Carbon::now()->toJson(),
            'validated' => $validated,
            'info' => $this->packageInfo,
        ];

        $meta['input'] = $request->input();
        $meta['validated'] = $request->validated();

        $data = [
            'data' => $project,
            'meta' => $meta,
            '_method' => 'patch',
        ];

        if ($request->expectsJson()) {
            return response()->json($data);
        }

        $flash = $project->toArray();

        if (! empty($validated['_return_url'])) {
            $flash['_return_url'] = $validated['_return_url'];
            $data['_return_url'] = $validated['_return_url'];
        }

        session()->flashInput($flash);

        return view(
            'playground-matrix-resource::project/form',
            $data
        );
    }

    /**
     * Remove the Project resource from storage.
     *
     * @route DELETE /resource/matrix/{project} playground.matrix.resource.projects.destroy
     */
    public function destroy(
        Project $project,
        DestroyRequest $request
    ): Response|RedirectResponse {
        $validated = $request->validated();

        if (empty($validated['force'])) {
            $project->delete();
        } else {
            $project->forceDelete();
        }

        if ($request->expectsJson()) {
            return response()->noContent();
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl && is_string($returnUrl)) {
            return redirect($returnUrl);
        }

        return redirect(route('playground.matrix.resource.projects'));
    }

    /**
     * Lock the Project resource in storage.
     *
     * @route PUT /resource/matrix/{project} playground.matrix.resource.projects.lock
     */
    public function lock(
        Project $project,
        LockRequest $request
    ): JsonResponse|RedirectResponse|ProjectResource {
        $validated = $request->validated();

        $user = $request->user();

        $project->setAttribute('locked', true);

        $project->save();

        $meta = [
            'session_user_id' => $user?->id,
            'id' => $project->id,
            'timestamp' => Carbon::now()->toJson(),
            'info' => $this->packageInfo,
        ];

        if ($request->expectsJson()) {
            return (new ProjectResource($project))->response($request);
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl && is_string($returnUrl)) {
            return redirect($returnUrl);
        }

        return redirect(route('playground.matrix.resource.projects.show', ['project' => $project->id]));
    }

    /**
     * Display a listing of Project resources.
     *
     * @route GET /resource/matrix playground.matrix.resource.projects
     */
    public function index(
        IndexRequest $request
    ): JsonResponse|View|ProjectCollection {
        $user = $request->user();

        $validated = $request->validated();

        $query = Project::addSelect(sprintf('%1$s.*', $this->packageInfo['table']));

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
            return (new ProjectCollection($paginator))->response($request);
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
            'playground-matrix-resource::project/index',
            $data
        );
    }

    /**
     * Restore the Project resource from the trash.
     *
     * @route PUT /resource/matrix/restore/{project} playground.matrix.resource.projects.restore
     */
    public function restore(
        Project $project,
        RestoreRequest $request
    ): JsonResponse|RedirectResponse|ProjectResource {
        $validated = $request->validated();

        $user = $request->user();

        $project->restore();

        if ($request->expectsJson()) {
            return (new ProjectResource($project))->response($request);
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl && is_string($returnUrl)) {
            return redirect($returnUrl);
        }

        return redirect(route('playground.matrix.resource.projects.show', ['project' => $project->id]));
    }

    /**
     * Display the Project resource.
     *
     * @route GET /resource/matrix/{project} playground.matrix.resource.projects.show
     */
    public function show(
        Project $project,
        ShowRequest $request
    ): JsonResponse|View|ProjectResource {
        $validated = $request->validated();

        $user = $request->user();

        $meta = [
            'session_user_id' => $user?->id,
            'id' => $project->id,
            'timestamp' => Carbon::now()->toJson(),
            'validated' => $validated,
            'info' => $this->packageInfo,
        ];

        if ($request->expectsJson()) {
            return (new ProjectResource($project))->response($request);
        }

        $meta['input'] = $request->input();
        $meta['validated'] = $request->validated();

        $data = [
            'data' => $project,
            'meta' => $meta,
        ];

        return view(
            'playground-matrix-resource::project/detail',
            $data
        );
    }

    /**
     * Store a newly created API Project resource in storage.
     *
     * @route POST /resource/matrix playground.matrix.resource.projects.post
     */
    public function store(
        StoreRequest $request
    ): Response|JsonResponse|RedirectResponse|ProjectResource {
        $validated = $request->validated();

        $user = $request->user();

        $project = new Project($validated);

        $project->save();

        if ($request->expectsJson()) {
            return (new ProjectResource($project))->response($request);
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl && is_string($returnUrl)) {
            return redirect($returnUrl);
        }

        return redirect(route('playground.matrix.resource.projects.show', ['project' => $project->id]));
    }

    /**
     * Unlock the Project resource in storage.
     *
     * @route DELETE /resource/matrix/lock/{project} playground.matrix.resource.projects.unlock
     */
    public function unlock(
        Project $project,
        UnlockRequest $request
    ): JsonResponse|RedirectResponse|ProjectResource {
        $validated = $request->validated();

        $user = $request->user();

        $project->setAttribute('locked', false);

        $project->save();

        if ($request->expectsJson()) {
            return (new ProjectResource($project))->response($request);
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl && is_string($returnUrl)) {
            return redirect($returnUrl);
        }

        return redirect(route('playground.matrix.resource.projects.show', ['project' => $project->id]));
    }

    /**
     * Update the Project resource in storage.
     *
     * @route PATCH /resource/matrix/{project} playground.matrix.resource.projects.patch
     */
    public function update(
        Project $project,
        UpdateRequest $request
    ): JsonResponse|RedirectResponse|ProjectResource {
        $validated = $request->validated();

        $user = $request->user();

        $project->update($validated);

        if ($request->expectsJson()) {
            return (new ProjectResource($project))->response($request);
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl && is_string($returnUrl)) {
            return redirect($returnUrl);
        }

        return redirect(route('playground.matrix.resource.projects.show', ['project' => $project->id]));
    }
}
