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
use Playground\Matrix\Models\Roadmap;
use Playground\Matrix\Resource\Http\Requests;
use Playground\Matrix\Resource\Http\Resources;

/**
 * \Playground\Matrix\Resource\Http\Controllers\RoadmapController
 */
class RoadmapController extends Controller
{
    /**
     * @var array<string, string>
     */
    public array $packageInfo = [
        'model_attribute' => 'title',
        'model_label' => 'Roadmap',
        'model_label_plural' => 'Roadmaps',
        'model_route' => 'playground.matrix.resource.roadmaps',
        'model_slug' => 'roadmap',
        'model_slug_plural' => 'roadmaps',
        'module_label' => 'Matrix',
        'module_label_plural' => 'Matrices',
        'module_route' => 'playground.matrix.resource',
        'module_slug' => 'matrix',
        'privilege' => 'playground-matrix-resource:roadmap',
        'table' => 'matrix_roadmaps',
        'view' => 'playground-matrix-resource::roadmap',
    ];

    /**
     * Create the Roadmap resource in storage.
     *
     * @route GET /resource/matrix/roadmaps/create playground.matrix.resource.roadmaps.create
     */
    public function create(
        Requests\Roadmap\CreateRequest $request
    ): JsonResponse|View|Resources\Roadmap {

        $packageInfo = $this->packageInfo();

        $validated = $request->validated();

        $roadmap = new Roadmap($validated);

        if ($request->expectsJson()) {
            return new Resources\Roadmap($roadmap)->additional(['meta' => [
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
            'data' => $roadmap,
            'meta' => $meta,
            '_method' => 'post',
        ];

        $flash = $roadmap->toArray();

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
     * Edit the Roadmap resource in storage.
     *
     * @route GET /resource/matrix/roadmaps/edit/{roadmap} playground.matrix.resource.roadmaps.edit
     */
    public function edit(
        Roadmap $roadmap,
        Requests\Roadmap\EditRequest $request
    ): JsonResponse|View|Resources\Roadmap {

        $packageInfo = $this->packageInfo();

        $validated = $request->validated();

        if ($request->expectsJson()) {
            return new Resources\Roadmap($roadmap)->additional(['meta' => [
                'info' => $packageInfo,
            ]])->response($request);
        }

        $user = $request->user();

        $flash = $roadmap->toArray();

        if (! empty($validated['_return_url'])) {
            $flash['_return_url'] = $validated['_return_url'];
        }

        $meta = [
            'session_user_id' => $user?->id,
            'id' => $roadmap->id,
            'timestamp' => Carbon::now()->toJson(),
            'info' => $packageInfo,
        ];

        $data = [
            'data' => $roadmap,
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
     * Remove the Roadmap resource from storage.
     *
     * @route DELETE /resource/matrix/roadmaps/{roadmap} playground.matrix.resource.roadmaps.destroy
     */
    public function destroy(
        Roadmap $roadmap,
        Requests\Roadmap\DestroyRequest $request
    ): Response|RedirectResponse {

        $packageInfo = $this->packageInfo();

        $validated = $request->validated();

        $user = $request->user();

        if ($user?->id) {
            $roadmap->modified_by_id = $user->id;
        }

        if (empty($validated['force'])) {
            $roadmap->delete();
        } else {
            $roadmap->forceDelete();
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
     * Lock the Roadmap resource in storage.
     *
     * @route PUT /resource/matrix/roadmaps/{roadmap} playground.matrix.resource.roadmaps.lock
     */
    public function lock(
        Roadmap $roadmap,
        Requests\Roadmap\LockRequest $request
    ): JsonResponse|RedirectResponse|Resources\Roadmap {

        $packageInfo = $this->packageInfo();

        $validated = $request->validated();

        $user = $request->user();

        if ($user?->id) {
            $roadmap->modified_by_id = $user->id;
        }

        $roadmap->locked = true;

        $roadmap->save();

        if ($request->expectsJson()) {
            return new Resources\Roadmap($roadmap)->additional(['meta' => [
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
        ), ['roadmap' => $roadmap->id]));
    }

    /**
     * Display a listing of Roadmap resources.
     *
     * @route GET /resource/matrix/roadmaps playground.matrix.resource.roadmaps
     */
    public function index(
        Requests\Roadmap\IndexRequest $request
    ): JsonResponse|View|Resources\RoadmapCollection {

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

        $query = Roadmap::addSelect(sprintf('%1$s.*', $packageInfo->table()));

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
            return new Resources\RoadmapCollection($paginator)->response($request);
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
     * Restore the Roadmap resource from the trash.
     *
     * @route PUT /resource/matrix/roadmaps/restore/{roadmap} playground.matrix.resource.roadmaps.restore
     */
    public function restore(
        Roadmap $roadmap,
        Requests\Roadmap\RestoreRequest $request
    ): JsonResponse|RedirectResponse|Resources\Roadmap {

        $packageInfo = $this->packageInfo();

        $validated = $request->validated();

        $user = $request->user();

        $roadmap->modified_by_id = $user?->id;

        $roadmap->restore();

        if ($request->expectsJson()) {
            return new Resources\Roadmap($roadmap)->additional(['meta' => [
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
        ), ['roadmap' => $roadmap->id]));
    }

    /**
     * Display the Roadmap resource.
     *
     * @route GET /resource/matrix/roadmaps/{roadmap} playground.matrix.resource.roadmaps.show
     */
    public function show(
        Roadmap $roadmap,
        Requests\Roadmap\ShowRequest $request
    ): JsonResponse|View|Resources\Roadmap {

        $packageInfo = $this->packageInfo();

        if ($request->expectsJson()) {
            return new Resources\Roadmap($roadmap)->additional(['meta' => [
                'info' => $packageInfo,
            ]])->response($request);
        }

        $user = $request->user();

        $meta = [
            'session_user_id' => $user?->id,
            'id' => $roadmap->id,
            'timestamp' => Carbon::now()->toJson(),
            'info' => $packageInfo,
        ];

        $data = [
            'data' => $roadmap,
            'meta' => $meta,
        ];

        /**
         * @var view-string $view
         */
        $view = sprintf('%1$s/detail', $packageInfo->view());

        return view($view, $data);
    }

    /**
     * Store a newly created API Roadmap resource in storage.
     *
     * @route POST /resource/matrix/roadmaps playground.matrix.resource.roadmaps.post
     */
    public function store(
        Requests\Roadmap\StoreRequest $request
    ): Response|JsonResponse|RedirectResponse|Resources\Roadmap {

        $packageInfo = $this->packageInfo();

        $validated = $request->validated();

        $user = $request->user();

        $roadmap = new Roadmap($validated);

        $roadmap->created_by_id = $user?->id;

        $roadmap->save();

        if ($request->expectsJson()) {
            return new Resources\Roadmap($roadmap)->additional(['meta' => [
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
        ), ['roadmap' => $roadmap->id]));
    }

    /**
     * Unlock the Roadmap resource in storage.
     *
     * @route DELETE /resource/matrix/roadmaps/lock/{roadmap} playground.matrix.resource.roadmaps.unlock
     */
    public function unlock(
        Roadmap $roadmap,
        Requests\Roadmap\UnlockRequest $request
    ): JsonResponse|RedirectResponse|Resources\Roadmap {

        $packageInfo = $this->packageInfo();

        $validated = $request->validated();

        $user = $request->user();

        $roadmap->locked = false;

        $roadmap->modified_by_id = $user?->id;

        $roadmap->save();

        if ($request->expectsJson()) {
            return new Resources\Roadmap($roadmap)->additional(['meta' => [
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
        ), ['roadmap' => $roadmap->id]));
    }

    /**
     * Update the Roadmap resource in storage.
     *
     * @route PATCH /resource/matrix/roadmaps/{roadmap} playground.matrix.resource.roadmaps.patch
     */
    public function update(
        Roadmap $roadmap,
        Requests\Roadmap\UpdateRequest $request
    ): JsonResponse|RedirectResponse|Resources\Roadmap {

        $packageInfo = $this->packageInfo();

        $validated = $request->validated();

        $user = $request->user();

        $roadmap->modified_by_id = $user?->id;

        $roadmap->update($validated);

        if ($request->expectsJson()) {
            return new Resources\Roadmap($roadmap)->additional(['meta' => [
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
        ), ['roadmap' => $roadmap->id]));
    }
}
