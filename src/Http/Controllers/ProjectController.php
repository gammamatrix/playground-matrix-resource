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
use Playground\Matrix\Models\Project;
use Playground\Matrix\Resource\Http\Requests;
use Playground\Matrix\Resource\Http\Resources;

/**
 * \Playground\Matrix\Resource\Http\Controllers\ProjectController
 */
class ProjectController extends Controller
{
    /**
     * @var array<string, string>
     */
    public array $packageInfo = [
        'model_attribute' => 'title',
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
     * Create the Project resource in storage.
     *
     * @route GET /resource/matrix/projects/create playground.matrix.resource.projects.create
     */
    public function create(
        Requests\Project\CreateRequest $request
    ): JsonResponse|View|Resources\Project {

        $packageInfo = $this->packageInfo();

        $validated = $request->validated();

        $project = new Project($validated);

        if ($request->expectsJson()) {
            return new Resources\Project($project)->additional(['meta' => [
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
            'data' => $project,
            'meta' => $meta,
            '_method' => 'post',
        ];

        $flash = $project->toArray();

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
     * Edit the Project resource in storage.
     *
     * @route GET /resource/matrix/projects/edit/{project} playground.matrix.resource.projects.edit
     */
    public function edit(
        Project $project,
        Requests\Project\EditRequest $request
    ): JsonResponse|View|Resources\Project {

        $packageInfo = $this->packageInfo();

        $validated = $request->validated();

        if ($request->expectsJson()) {
            return new Resources\Project($project)->additional(['meta' => [
                'info' => $packageInfo,
            ]])->response($request);
        }

        $user = $request->user();

        $flash = $project->toArray();

        if (! empty($validated['_return_url'])) {
            $flash['_return_url'] = $validated['_return_url'];
        }

        $meta = [
            'session_user_id' => $user?->id,
            'id' => $project->id,
            'timestamp' => Carbon::now()->toJson(),
            'info' => $packageInfo,
        ];

        $data = [
            'data' => $project,
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
     * Remove the Project resource from storage.
     *
     * @route DELETE /resource/matrix/projects/{project} playground.matrix.resource.projects.destroy
     */
    public function destroy(
        Project $project,
        Requests\Project\DestroyRequest $request
    ): Response|RedirectResponse {

        $packageInfo = $this->packageInfo();

        $validated = $request->validated();

        $user = $request->user();

        if ($user?->id) {
            $project->modified_by_id = $user->id;
        }

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

        return redirect(route($packageInfo->model_route()));
    }

    /**
     * Lock the Project resource in storage.
     *
     * @route PUT /resource/matrix/projects/{project} playground.matrix.resource.projects.lock
     */
    public function lock(
        Project $project,
        Requests\Project\LockRequest $request
    ): JsonResponse|RedirectResponse|Resources\Project {

        $packageInfo = $this->packageInfo();

        $validated = $request->validated();

        $user = $request->user();

        if ($user?->id) {
            $project->modified_by_id = $user->id;
        }

        $project->locked = true;

        $project->save();

        if ($request->expectsJson()) {
            return new Resources\Project($project)->additional(['meta' => [
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
        ), ['project' => $project->id]));
    }

    /**
     * Display a listing of Project resources.
     *
     * @route GET /resource/matrix/projects playground.matrix.resource.projects
     */
    public function index(
        Requests\Project\IndexRequest $request
    ): JsonResponse|View|Resources\ProjectCollection {

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

        $query = Project::addSelect(sprintf('%1$s.*', $packageInfo->table()));

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
            return new Resources\ProjectCollection($paginator)->response($request);
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
     * Restore the Project resource from the trash.
     *
     * @route PUT /resource/matrix/projects/restore/{project} playground.matrix.resource.projects.restore
     */
    public function restore(
        Project $project,
        Requests\Project\RestoreRequest $request
    ): JsonResponse|RedirectResponse|Resources\Project {

        $packageInfo = $this->packageInfo();

        $validated = $request->validated();

        $user = $request->user();

        $project->modified_by_id = $user?->id;

        $project->restore();

        if ($request->expectsJson()) {
            return new Resources\Project($project)->additional(['meta' => [
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
        ), ['project' => $project->id]));
    }

    /**
     * Display the Project resource.
     *
     * @route GET /resource/matrix/projects/{project} playground.matrix.resource.projects.show
     */
    public function show(
        Project $project,
        Requests\Project\ShowRequest $request
    ): JsonResponse|View|Resources\Project {

        $packageInfo = $this->packageInfo();

        if ($request->expectsJson()) {
            return new Resources\Project($project)->additional(['meta' => [
                'info' => $packageInfo,
            ]])->response($request);
        }

        $user = $request->user();

        $meta = [
            'session_user_id' => $user?->id,
            'id' => $project->id,
            'timestamp' => Carbon::now()->toJson(),
            'info' => $packageInfo,
        ];

        $data = [
            'data' => $project,
            'meta' => $meta,
        ];

        /**
         * @var view-string $view
         */
        $view = sprintf('%1$s/detail', $packageInfo->view());

        return view($view, $data);
    }

    /**
     * Store a newly created API Project resource in storage.
     *
     * @route POST /resource/matrix/projects playground.matrix.resource.projects.post
     */
    public function store(
        Requests\Project\StoreRequest $request
    ): Response|JsonResponse|RedirectResponse|Resources\Project {

        $packageInfo = $this->packageInfo();

        $validated = $request->validated();

        $user = $request->user();

        $project = new Project($validated);

        $project->created_by_id = $user?->id;

        $project->save();

        if ($request->expectsJson()) {
            return new Resources\Project($project)->additional(['meta' => [
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
        ), ['project' => $project->id]));
    }

    /**
     * Unlock the Project resource in storage.
     *
     * @route DELETE /resource/matrix/projects/lock/{project} playground.matrix.resource.projects.unlock
     */
    public function unlock(
        Project $project,
        Requests\Project\UnlockRequest $request
    ): JsonResponse|RedirectResponse|Resources\Project {

        $packageInfo = $this->packageInfo();

        $validated = $request->validated();

        $user = $request->user();

        $project->locked = false;

        $project->modified_by_id = $user?->id;

        $project->save();

        if ($request->expectsJson()) {
            return new Resources\Project($project)->additional(['meta' => [
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
        ), ['project' => $project->id]));
    }

    /**
     * Update the Project resource in storage.
     *
     * @route PATCH /resource/matrix/projects/{project} playground.matrix.resource.projects.patch
     */
    public function update(
        Project $project,
        Requests\Project\UpdateRequest $request
    ): JsonResponse|RedirectResponse|Resources\Project {

        $packageInfo = $this->packageInfo();

        $validated = $request->validated();

        $user = $request->user();

        $project->modified_by_id = $user?->id;

        $project->update($validated);

        if ($request->expectsJson()) {
            return new Resources\Project($project)->additional(['meta' => [
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
        ), ['project' => $project->id]));
    }
}
