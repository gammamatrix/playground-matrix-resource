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
use Playground\Matrix\Models\Sprint;
use Playground\Matrix\Resource\Http\Requests;
use Playground\Matrix\Resource\Http\Resources;

/**
 * \Playground\Matrix\Resource\Http\Controllers\SprintController
 */
class SprintController extends Controller
{
    /**
     * @var array<string, string>
     */
    public array $packageInfo = [
        'model_attribute' => 'title',
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
     * Create the Sprint resource in storage.
     *
     * @route GET /resource/matrix/sprints/create playground.matrix.resource.sprints.create
     */
    public function create(
        Requests\Sprint\CreateRequest $request
    ): JsonResponse|View|Resources\Sprint {

        $packageInfo = $this->packageInfo();

        $validated = $request->validated();

        $sprint = new Sprint($validated);

        if ($request->expectsJson()) {
            return new Resources\Sprint($sprint)->additional(['meta' => [
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
            'data' => $sprint,
            'meta' => $meta,
            '_method' => 'post',
        ];

        $flash = $sprint->toArray();

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
     * Edit the Sprint resource in storage.
     *
     * @route GET /resource/matrix/sprints/edit/{sprint} playground.matrix.resource.sprints.edit
     */
    public function edit(
        Sprint $sprint,
        Requests\Sprint\EditRequest $request
    ): JsonResponse|View|Resources\Sprint {

        $packageInfo = $this->packageInfo();

        $validated = $request->validated();

        if ($request->expectsJson()) {
            return new Resources\Sprint($sprint)->additional(['meta' => [
                'info' => $packageInfo,
            ]])->response($request);
        }

        $user = $request->user();

        $flash = $sprint->toArray();

        if (! empty($validated['_return_url'])) {
            $flash['_return_url'] = $validated['_return_url'];
        }

        $meta = [
            'session_user_id' => $user?->id,
            'id' => $sprint->id,
            'timestamp' => Carbon::now()->toJson(),
            'info' => $packageInfo,
        ];

        $data = [
            'data' => $sprint,
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
     * Remove the Sprint resource from storage.
     *
     * @route DELETE /resource/matrix/sprints/{sprint} playground.matrix.resource.sprints.destroy
     */
    public function destroy(
        Sprint $sprint,
        Requests\Sprint\DestroyRequest $request
    ): Response|RedirectResponse {

        $packageInfo = $this->packageInfo();

        $validated = $request->validated();

        $user = $request->user();

        if ($user?->id) {
            $sprint->modified_by_id = $user->id;
        }

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

        return redirect(route($packageInfo->model_route()));
    }

    /**
     * Lock the Sprint resource in storage.
     *
     * @route PUT /resource/matrix/sprints/{sprint} playground.matrix.resource.sprints.lock
     */
    public function lock(
        Sprint $sprint,
        Requests\Sprint\LockRequest $request
    ): JsonResponse|RedirectResponse|Resources\Sprint {

        $packageInfo = $this->packageInfo();

        $validated = $request->validated();

        $user = $request->user();

        if ($user?->id) {
            $sprint->modified_by_id = $user->id;
        }

        $sprint->locked = true;

        $sprint->save();

        if ($request->expectsJson()) {
            return new Resources\Sprint($sprint)->additional(['meta' => [
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
        ), ['sprint' => $sprint->id]));
    }

    /**
     * Display a listing of Sprint resources.
     *
     * @route GET /resource/matrix/sprints playground.matrix.resource.sprints
     */
    public function index(
        Requests\Sprint\IndexRequest $request
    ): JsonResponse|View|Resources\SprintCollection {

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

        $query = Sprint::addSelect(sprintf('%1$s.*', $packageInfo->table()));

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
            return new Resources\SprintCollection($paginator)->response($request);
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
     * Restore the Sprint resource from the trash.
     *
     * @route PUT /resource/matrix/sprints/restore/{sprint} playground.matrix.resource.sprints.restore
     */
    public function restore(
        Sprint $sprint,
        Requests\Sprint\RestoreRequest $request
    ): JsonResponse|RedirectResponse|Resources\Sprint {

        $packageInfo = $this->packageInfo();

        $validated = $request->validated();

        $user = $request->user();

        $sprint->modified_by_id = $user?->id;

        $sprint->restore();

        if ($request->expectsJson()) {
            return new Resources\Sprint($sprint)->additional(['meta' => [
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
        ), ['sprint' => $sprint->id]));
    }

    /**
     * Display the Sprint resource.
     *
     * @route GET /resource/matrix/sprints/{sprint} playground.matrix.resource.sprints.show
     */
    public function show(
        Sprint $sprint,
        Requests\Sprint\ShowRequest $request
    ): JsonResponse|View|Resources\Sprint {

        $packageInfo = $this->packageInfo();

        if ($request->expectsJson()) {
            return new Resources\Sprint($sprint)->additional(['meta' => [
                'info' => $packageInfo,
            ]])->response($request);
        }

        $user = $request->user();

        $meta = [
            'session_user_id' => $user?->id,
            'id' => $sprint->id,
            'timestamp' => Carbon::now()->toJson(),
            'info' => $packageInfo,
        ];

        $data = [
            'data' => $sprint,
            'meta' => $meta,
        ];

        /**
         * @var view-string $view
         */
        $view = sprintf('%1$s/detail', $packageInfo->view());

        return view($view, $data);
    }

    /**
     * Store a newly created API Sprint resource in storage.
     *
     * @route POST /resource/matrix/sprints playground.matrix.resource.sprints.post
     */
    public function store(
        Requests\Sprint\StoreRequest $request
    ): Response|JsonResponse|RedirectResponse|Resources\Sprint {

        $packageInfo = $this->packageInfo();

        $validated = $request->validated();

        $user = $request->user();

        $sprint = new Sprint($validated);

        $sprint->created_by_id = $user?->id;

        $sprint->save();

        if ($request->expectsJson()) {
            return new Resources\Sprint($sprint)->additional(['meta' => [
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
        ), ['sprint' => $sprint->id]));
    }

    /**
     * Unlock the Sprint resource in storage.
     *
     * @route DELETE /resource/matrix/sprints/lock/{sprint} playground.matrix.resource.sprints.unlock
     */
    public function unlock(
        Sprint $sprint,
        Requests\Sprint\UnlockRequest $request
    ): JsonResponse|RedirectResponse|Resources\Sprint {

        $packageInfo = $this->packageInfo();

        $validated = $request->validated();

        $user = $request->user();

        $sprint->locked = false;

        $sprint->modified_by_id = $user?->id;

        $sprint->save();

        if ($request->expectsJson()) {
            return new Resources\Sprint($sprint)->additional(['meta' => [
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
        ), ['sprint' => $sprint->id]));
    }

    /**
     * Update the Sprint resource in storage.
     *
     * @route PATCH /resource/matrix/sprints/{sprint} playground.matrix.resource.sprints.patch
     */
    public function update(
        Sprint $sprint,
        Requests\Sprint\UpdateRequest $request
    ): JsonResponse|RedirectResponse|Resources\Sprint {

        $packageInfo = $this->packageInfo();

        $validated = $request->validated();

        $user = $request->user();

        $sprint->modified_by_id = $user?->id;

        $sprint->update($validated);

        if ($request->expectsJson()) {
            return new Resources\Sprint($sprint)->additional(['meta' => [
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
        ), ['sprint' => $sprint->id]));
    }
}
