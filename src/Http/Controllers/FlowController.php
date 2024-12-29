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
use Playground\Matrix\Models\Flow;
use Playground\Matrix\Resource\Http\Requests;
use Playground\Matrix\Resource\Http\Resources;

/**
 * \Playground\Matrix\Resource\Http\Controllers\FlowController
 */
class FlowController extends Controller
{
    /**
     * @var array<string, string>
     */
    public array $packageInfo = [
        'model_attribute' => 'title',
        'model_label' => 'Flow',
        'model_label_plural' => 'Flows',
        'model_route' => 'playground.matrix.resource.flows',
        'model_slug' => 'flow',
        'model_slug_plural' => 'flows',
        'module_label' => 'Matrix',
        'module_label_plural' => 'Matrices',
        'module_route' => 'playground.matrix.resource',
        'module_slug' => 'matrix',
        'privilege' => 'playground-matrix-resource:flow',
        'table' => 'matrix_flows',
        'view' => 'playground-matrix-resource::flow',
    ];

    /**
     * Create the Flow resource in storage.
     *
     * @route GET /resource/matrix/flows/create playground.matrix.resource.flows.create
     */
    public function create(
        Requests\Flow\CreateRequest $request
    ): JsonResponse|View|Resources\Flow {

        $validated = $request->validated();

        $user = $request->user();

        $flow = new Flow($validated);

        if ($request->expectsJson()) {
            return (new Resources\Flow($flow))->additional(['meta' => [
                'info' => $this->packageInfo,
            ]])->response($request);
        }

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
            'data' => $flow,
            'meta' => $meta,
            '_method' => 'post',
        ];

        $flash = $flow->toArray();

        if (! empty($validated['_return_url'])) {
            $flash['_return_url'] = $validated['_return_url'];
            $data['_return_url'] = $validated['_return_url'];
        }

        if (! $request->session()->has('errors')) {
            session()->flashInput($flash);
        }

        return view(sprintf('%1$s/form', $this->packageInfo['view']), $data);
    }

    /**
     * Edit the Flow resource in storage.
     *
     * @route GET /resource/matrix/flows/edit/{flow} playground.matrix.resource.flows.edit
     */
    public function edit(
        Flow $flow,
        Requests\Flow\EditRequest $request
    ): JsonResponse|View|Resources\Flow {

        $validated = $request->validated();

        $user = $request->user();

        if ($request->expectsJson()) {
            return (new Resources\Flow($flow))->additional(['meta' => [
                'info' => $this->packageInfo,
            ]])->response($request);
        }

        $flash = $flow->toArray();

        if (! empty($validated['_return_url'])) {
            $flash['_return_url'] = $validated['_return_url'];
            $data['_return_url'] = $validated['_return_url'];
        }

        $meta = [
            'session_user_id' => $user?->id,
            'id' => $flow->id,
            'timestamp' => Carbon::now()->toJson(),
            'validated' => $validated,
            'info' => $this->packageInfo,
        ];

        $meta['input'] = $request->input();
        $meta['validated'] = $request->validated();

        $data = [
            'data' => $flow,
            'meta' => $meta,
            '_method' => 'patch',
        ];

        session()->flashInput($flash);

        return view(sprintf('%1$s/form', $this->packageInfo['view']), $data);
    }

    /**
     * Remove the Flow resource from storage.
     *
     * @route DELETE /resource/matrix/flows/{flow} playground.matrix.resource.flows.destroy
     */
    public function destroy(
        Flow $flow,
        Requests\Flow\DestroyRequest $request
    ): Response|RedirectResponse {

        $validated = $request->validated();

        $user = $request->user();

        if ($user?->id) {
            $flow->modified_by_id = $user->id;
        }

        if (empty($validated['force'])) {
            $flow->delete();
        } else {
            $flow->forceDelete();
        }

        if ($request->expectsJson()) {
            return response()->noContent();
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl && is_string($returnUrl)) {
            return redirect($returnUrl);
        }

        return redirect(route($this->packageInfo['model_route']));
    }

    /**
     * Lock the Flow resource in storage.
     *
     * @route PUT /resource/matrix/flows/{flow} playground.matrix.resource.flows.lock
     */
    public function lock(
        Flow $flow,
        Requests\Flow\LockRequest $request
    ): JsonResponse|RedirectResponse|Resources\Flow {

        $validated = $request->validated();

        $user = $request->user();

        if ($user?->id) {
            $flow->modified_by_id = $user->id;
        }

        $flow->locked = true;

        $flow->save();

        $meta = [
            'session_user_id' => $user?->id,
            'id' => $flow->id,
            'timestamp' => Carbon::now()->toJson(),
            'info' => $this->packageInfo,
        ];

        if ($request->expectsJson()) {
            return (new Resources\Flow($flow))->additional(['meta' => [
                'info' => $this->packageInfo,
            ]])->response($request);
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl && is_string($returnUrl)) {
            return redirect($returnUrl);
        }

        return redirect(route(sprintf(
            '%1$s.show',
            $this->packageInfo['model_route']
        ), ['flow' => $flow->id]));
    }

    /**
     * Display a listing of Flow resources.
     *
     * @route GET /resource/matrix/flows playground.matrix.resource.flows
     */
    public function index(
        Requests\Flow\IndexRequest $request
    ): JsonResponse|View|Resources\FlowCollection {

        $user = $request->user();

        $validated = $request->validated();

        $query = Flow::addSelect(sprintf('%1$s.*', $this->packageInfo['table']));

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
            return (new Resources\FlowCollection($paginator))->response($request);
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

        return view(sprintf('%1$s/index', $this->packageInfo['view']), $data);
    }

    /**
     * Restore the Flow resource from the trash.
     *
     * @route PUT /resource/matrix/flows/restore/{flow} playground.matrix.resource.flows.restore
     */
    public function restore(
        Flow $flow,
        Requests\Flow\RestoreRequest $request
    ): JsonResponse|RedirectResponse|Resources\Flow {

        $validated = $request->validated();

        $user = $request->user();

        if ($user?->id) {
            $flow->modified_by_id = $user->id;
        }

        $flow->restore();

        if ($request->expectsJson()) {
            return (new Resources\Flow($flow))->additional(['meta' => [
                'info' => $this->packageInfo,
            ]])->response($request);
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl && is_string($returnUrl)) {
            return redirect($returnUrl);
        }

        return redirect(route(sprintf(
            '%1$s.show',
            $this->packageInfo['model_route']
        ), ['flow' => $flow->id]));
    }

    /**
     * Display the Flow resource.
     *
     * @route GET /resource/matrix/flows/{flow} playground.matrix.resource.flows.show
     */
    public function show(
        Flow $flow,
        Requests\Flow\ShowRequest $request
    ): JsonResponse|View|Resources\Flow {

        $validated = $request->validated();

        $user = $request->user();

        $meta = [
            'session_user_id' => $user?->id,
            'id' => $flow->id,
            'timestamp' => Carbon::now()->toJson(),
            'validated' => $validated,
            'info' => $this->packageInfo,
        ];

        if ($request->expectsJson()) {
            return (new Resources\Flow($flow))->additional(['meta' => [
                'info' => $this->packageInfo,
            ]])->response($request);
        }

        $meta['input'] = $request->input();
        $meta['validated'] = $request->validated();

        $data = [
            'data' => $flow,
            'meta' => $meta,
        ];

        return view(sprintf('%1$s/detail', $this->packageInfo['view']), $data);
    }

    /**
     * Store a newly created API Flow resource in storage.
     *
     * @route POST /resource/matrix/flows playground.matrix.resource.flows.post
     */
    public function store(
        Requests\Flow\StoreRequest $request
    ): Response|JsonResponse|RedirectResponse|Resources\Flow {

        $validated = $request->validated();

        $user = $request->user();

        $flow = new Flow($validated);

        if ($user?->id) {
            $flow->created_by_id = $user->id;
        }

        $flow->save();

        if ($request->expectsJson()) {
            return (new Resources\Flow($flow))->additional(['meta' => [
                'info' => $this->packageInfo,
            ]])->response($request);
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl && is_string($returnUrl)) {
            return redirect($returnUrl);
        }

        return redirect(route(sprintf(
            '%1$s.show',
            $this->packageInfo['model_route']
        ), ['flow' => $flow->id]));
    }

    /**
     * Unlock the Flow resource in storage.
     *
     * @route DELETE /resource/matrix/flows/lock/{flow} playground.matrix.resource.flows.unlock
     */
    public function unlock(
        Flow $flow,
        Requests\Flow\UnlockRequest $request
    ): JsonResponse|RedirectResponse|Resources\Flow {

        $validated = $request->validated();

        $user = $request->user();

        $flow->locked = false;

        if ($user?->id) {
            $flow->modified_by_id = $user->id;
        }

        $flow->save();

        if ($request->expectsJson()) {
            return (new Resources\Flow($flow))->additional(['meta' => [
                'info' => $this->packageInfo,
            ]])->response($request);
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl && is_string($returnUrl)) {
            return redirect($returnUrl);
        }

        return redirect(route(sprintf(
            '%1$s.show',
            $this->packageInfo['model_route']
        ), ['flow' => $flow->id]));
    }

    /**
     * Update the Flow resource in storage.
     *
     * @route PATCH /resource/matrix/flows/{flow} playground.matrix.resource.flows.patch
     */
    public function update(
        Flow $flow,
        Requests\Flow\UpdateRequest $request
    ): JsonResponse|RedirectResponse|Resources\Flow {

        $validated = $request->validated();

        $user = $request->user();

        $flow->update($validated);

        if ($user?->id) {
            $flow->modified_by_id = $user->id;
        }

        if ($request->expectsJson()) {
            return (new Resources\Flow($flow))->additional(['meta' => [
                'info' => $this->packageInfo,
            ]])->response($request);
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl && is_string($returnUrl)) {
            return redirect($returnUrl);
        }

        return redirect(route(sprintf(
            '%1$s.show',
            $this->packageInfo['model_route']
        ), ['flow' => $flow->id]));
    }
}
