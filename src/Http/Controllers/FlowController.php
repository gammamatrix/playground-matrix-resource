<?php
/**
 * GammaMatrix
 */

namespace GammaMatrix\Playground\Matrix\Resource\Http\Controllers;

use GammaMatrix\Playground\Http\Controllers\Controller;
use GammaMatrix\Playground\Matrix\Models\Flow;
use GammaMatrix\Playground\Matrix\Resource\Http\Requests\Flow\CreateRequest;
use GammaMatrix\Playground\Matrix\Resource\Http\Requests\Flow\DestroyRequest;
use GammaMatrix\Playground\Matrix\Resource\Http\Requests\Flow\EditRequest;
use GammaMatrix\Playground\Matrix\Resource\Http\Requests\Flow\IndexRequest;
use GammaMatrix\Playground\Matrix\Resource\Http\Requests\Flow\LockRequest;
use GammaMatrix\Playground\Matrix\Resource\Http\Requests\Flow\RestoreRequest;
use GammaMatrix\Playground\Matrix\Resource\Http\Requests\Flow\ShowRequest;
use GammaMatrix\Playground\Matrix\Resource\Http\Requests\Flow\StoreRequest;
use GammaMatrix\Playground\Matrix\Resource\Http\Requests\Flow\UnlockRequest;
use GammaMatrix\Playground\Matrix\Resource\Http\Requests\Flow\UpdateRequest;
use GammaMatrix\Playground\Matrix\Resource\Http\Resources\Flow as FlowResource;
use GammaMatrix\Playground\Matrix\Resource\Http\Resources\FlowCollection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * \GammaMatrix\Playground\Matrix\Resource\Http\Controllers\FlowController
 */
class FlowController extends Controller
{
    public array $packageInfo = [
        'model_attribute'     => 'label',
        'model_label'         => 'Flow',
        'model_label_plural'  => 'Flows',
        'model_route'         => 'playground.matrix.resource.flows',
        'model_slug'          => 'flow',
        'model_slug_plural'   => 'flows',
        'module_label'        => 'Matrix',
        'module_label_plural' => 'Matrices',
        'module_route'        => 'playground.matrix.resource',
        'module_slug'         => 'matrix',
        'privilege'           => 'playground-matrix-resource:flow',
        'table'               => 'matrix_flows',
        'view'                => 'playground-matrix-resource::flow',
    ];

    /**
     * CREATE the Flow resource in storage.
     *
     * @route GET /resource/matrix/flows/create playground.matrix.resource.flows.create
     */
    public function create(
        CreateRequest $request
    ): JsonResponse|View {
        $validated = $request->validated();

        $user = $request->user();

        $flow = new Flow($validated);

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
            'data' => $flow,
            'meta' => $meta,
            '_method' => 'post',
        ];

        if ($request->expectsJson()) {
            return response()->json($data);
        }

        $flash = $flow->toArray();

        if (!empty($validated['_return_url'])) {
            $flash['_return_url'] = $validated['_return_url'];
            $data['_return_url'] = $validated['_return_url'];
        }

        if (!$request->session()->has('errors')) {
            session()->flashInput($flash);
        }

        return view(
            'playground-matrix-resource::flow/form',
            $data
        );
    }

    /**
     * Edit the Flow resource in storage.
     *
     * @route GET /resource/matrix/flows/edit playground.matrix.resource.flows.edit
     */
    public function edit(
        Flow $flow,
        EditRequest $request
    ): JsonResponse|View {
        $validated = $request->validated();

        $user = $request->user();

        $meta = [
            'session_user_id' => $user?->id,
            'id'              => $flow->id,
            'timestamp'       => Carbon::now()->toJson(),
            'validated'       => $validated,
            'info'            => $this->packageInfo,
        ];

        $meta['input'] = $request->input();
        $meta['validated'] = $request->validated();

        $data = [
            'data' => $flow,
            'meta' => $meta,
            '_method' => 'patch',
        ];

        if ($request->expectsJson()) {
            return response()->json($data);
        }

        $flash = $flow->toArray();

        if (!empty($validated['_return_url'])) {
            $flash['_return_url'] = $validated['_return_url'];
            $data['_return_url'] = $validated['_return_url'];
        }

        session()->flashInput($flash);

        return view(
            'playground-matrix-resource::flow/form',
            $data
        );
    }

    /**
     * Remove the Flow resource from storage.
     *
     * @route DELETE /resource/matrix/{flow} playground.matrix.resource.flows.destroy
     */
    public function destroy(
        Flow $flow,
        DestroyRequest $request
    ): Response|RedirectResponse {
        $validated = $request->validated();

        if (empty($validated['force'])) {
            $flow->delete();
        } else {
            $flow->forceDelete();
        }

        if ($request->expectsJson()) {
            return response()->noContent();
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl) {
            return redirect($returnUrl);
        }

        return redirect(route('playground.matrix.resource.flows'));
    }

    /**
     * Lock the Flow resource in storage.
     *
     * @route PUT /resource/matrix/{flow} playground.matrix.resource.flows.lock
     */
    public function lock(
        Flow $flow,
        LockRequest $request
    ): JsonResponse|RedirectResponse|FlowResource {
        $validated = $request->validated();

        $user = $request->user();

        $flow->locked = true;

        $flow->save();

        $meta = [
            'session_user_id' => $user?->id,
            'id'              => $flow->id,
            'timestamp'       => Carbon::now()->toJson(),
            'info'            => $this->packageInfo,
        ];

        if ($request->expectsJson()) {
            return (new FlowResource($flow))->response($request);
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl) {
            return redirect($returnUrl);
        }

        return redirect(route('playground.matrix.resource.flows.show', ['flow' => $flow->id]));
    }

    /**
     * Display a listing of Flow resources.
     *
     * @route GET /resource/matrix playground.matrix.resource.flows
     */
    public function index(
        IndexRequest $request
    ): JsonResponse|View {
        $user = $request->user();

        $validated = $request->validated();

        $query = Flow::addSelect(sprintf('%1$s.*', $this->packageInfo['table']));

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
            return (new FlowCollection($paginator))->additional(['meta' => [
                'session_user_id' => $user?->id,
                'validated'       => $validated,
            ]]);
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
            'playground-matrix-resource::flow/index',
            $data
        );
    }

    /**
     * Restore the Flow resource from the trash.
     *
     * @route PUT /resource/matrix/restore/{flow} playground.matrix.resource.flows.restore
     */
    public function restore(
        Flow $flow,
        RestoreRequest $request
    ): JsonResponse|RedirectResponse|FlowResource {
        $validated = $request->validated();

        $user = $request->user();

        $flow->restore();

        if ($request->expectsJson()) {
            return (new FlowResource($flow))->response($request);
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl) {
            return redirect($returnUrl);
        }

        return redirect(route('playground.matrix.resource.flows.show', ['flow' => $flow->id]));
    }

    /**
     * Display the Flow resource.
     *
     * @route GET /resource/matrix/{flow} playground.matrix.resource.flows.show
     */
    public function show(
        Flow $flow,
        ShowRequest $request
    ): JsonResponse|View|FlowResource {
        $validated = $request->validated();

        $user = $request->user();

        $meta = [
            'session_user_id' => $user?->id,
            'id'              => $flow->id,
            'timestamp'       => Carbon::now()->toJson(),
            'validated'       => $validated,
            'info'            => $this->packageInfo,
        ];

        if ($request->expectsJson()) {
            return (new FlowResource($flow))->response($request);
        }

        $meta['input'] = $request->input();
        $meta['validated'] = $request->validated();

        $data = [
            'data' => $flow,
            'meta' => $meta,
        ];

        return view(
            'playground-matrix-resource::flow/detail',
            $data
        );
    }

    /**
      * Store a newly created API Flow resource in storage.
      *
      * @route POST /resource/matrix playground.matrix.resource.flows.post
      */
    public function store(
        StoreRequest $request
    ): Response|JsonResponse|RedirectResponse|FlowResource {
        $validated = $request->validated();

        $user = $request->user();

        $flow = new Flow($validated);

        $flow->save();

        if ($request->expectsJson()) {
            return (new FlowResource($flow))->response($request);
        }

        $returnUrl = $validated['return_url'] ?? '';

        if ($returnUrl) {
            return redirect($returnUrl);
        }

        return redirect(route('playground.matrix.resource.flows.show', ['flow' => $flow->id]));
    }

    /**
     * Unlock the Flow resource in storage.
     *
     * @route DELETE /resource/matrix/lock/{flow} playground.matrix.resource.flows.unlock
     */
    public function unlock(
        Flow $flow,
        UnlockRequest $request
    ): JsonResponse|RedirectResponse|FlowResource {
        $validated = $request->validated();

        $user = $request->user();

        $flow->locked = false;

        $flow->save();

        if ($request->expectsJson()) {
            return (new FlowResource($flow))->response($request);
        }

        $returnUrl = $validated['return_url'] ?? '';

        if ($returnUrl) {
            return redirect($returnUrl);
        }

        return redirect(route('playground.matrix.resource.flows.show', ['flow' => $flow->id]));
    }

    /**
     * Update the Flow resource in storage.
     *
     * @route PATCH /resource/matrix/{flow} playground.matrix.resource.flows.patch
     */
    public function update(
        Flow $flow,
        UpdateRequest $request
    ): JsonResponse|RedirectResponse|FlowResource {
        $validated = $request->validated();

        $user = $request->user();

        $flow->update($validated);

        if ($request->expectsJson()) {
            return (new FlowResource($flow))->response($request);
        }

        $returnUrl = $validated['return_url'] ?? '';

        if ($returnUrl) {
            return redirect($returnUrl);
        }

        return redirect(route('playground.matrix.resource.flows.show', ['flow' => $flow->id]));
    }
}
