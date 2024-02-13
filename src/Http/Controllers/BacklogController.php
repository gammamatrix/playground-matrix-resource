<?php
/**
 * Playground
 */

namespace Playground\Matrix\Resource\Http\Controllers;

use Playground\Matrix\Models\Backlog;
use Playground\Matrix\Resource\Http\Requests\Backlog\CreateRequest;
use Playground\Matrix\Resource\Http\Requests\Backlog\DestroyRequest;
use Playground\Matrix\Resource\Http\Requests\Backlog\EditRequest;
use Playground\Matrix\Resource\Http\Requests\Backlog\IndexRequest;
use Playground\Matrix\Resource\Http\Requests\Backlog\LockRequest;
use Playground\Matrix\Resource\Http\Requests\Backlog\RestoreRequest;
use Playground\Matrix\Resource\Http\Requests\Backlog\ShowRequest;
use Playground\Matrix\Resource\Http\Requests\Backlog\StoreRequest;
use Playground\Matrix\Resource\Http\Requests\Backlog\UnlockRequest;
use Playground\Matrix\Resource\Http\Requests\Backlog\UpdateRequest;
use Playground\Matrix\Resource\Http\Resources\Backlog as BacklogResource;
use Playground\Matrix\Resource\Http\Resources\BacklogCollection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

/**
 * \Playground\Matrix\Resource\Http\Controllers\BacklogController
 */
class BacklogController extends Controller
{
    /**
     * @var array<string, string>
     */
    public array $packageInfo = [
        'model_attribute'     => 'label',
        'model_label'         => 'Backlog',
        'model_label_plural'  => 'Backlogs',
        'model_route'         => 'playground.matrix.resource.backlogs',
        'model_slug'          => 'backlog',
        'model_slug_plural'   => 'backlogs',
        'module_label'        => 'Matrix',
        'module_label_plural' => 'Matrices',
        'module_route'        => 'playground.matrix.resource',
        'module_slug'         => 'matrix',
        'privilege'           => 'playground-matrix-resource:backlog',
        'table'               => 'matrix_backlogs',
        'view'                => 'playground-matrix-resource::backlog',
    ];

    /**
     * CREATE the Backlog resource in storage.
     *
     * @route GET /resource/matrix/backlogs/create playground.matrix.resource.backlogs.create
     */
    public function create(
        CreateRequest $request
    ): JsonResponse|View {
        $validated = $request->validated();

        $user = $request->user();

        $backlog = new Backlog($validated);

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
            'data' => $backlog,
            'meta' => $meta,
            '_method' => 'post',
        ];

        if ($request->expectsJson()) {
            return response()->json($data);
        }

        $flash = $backlog->toArray();

        if (!empty($validated['_return_url'])) {
            $flash['_return_url'] = $validated['_return_url'];
            $data['_return_url'] = $validated['_return_url'];
        }

        if (!$request->session()->has('errors')) {
            session()->flashInput($flash);
        }

        return view($this->getPackageViewPathFromConfig(
            $this->package_config_matrix_resource,
            'backlog',
            'form'
        ), [
            'package_config_site_blade' => $this->package_config_matrix_resource,
        ]);
    }

    /**
     * Edit the Backlog resource in storage.
     *
     * @route GET /resource/matrix/backlogs/edit playground.matrix.resource.backlogs.edit
     */
    public function edit(
        Backlog $backlog,
        EditRequest $request
    ): JsonResponse|View {
        $validated = $request->validated();

        $user = $request->user();

        $meta = [
            'session_user_id' => $user?->id,
            'id'              => $backlog->id,
            'timestamp'       => Carbon::now()->toJson(),
            'validated'       => $validated,
            'info'            => $this->packageInfo,
        ];

        $meta['input'] = $request->input();
        $meta['validated'] = $request->validated();

        $data = [
            'data' => $backlog,
            'meta' => $meta,
            '_method' => 'patch',
        ];

        if ($request->expectsJson()) {
            return response()->json($data);
        }

        $flash = $backlog->toArray();

        if (!empty($validated['_return_url'])) {
            $flash['_return_url'] = $validated['_return_url'];
            $data['_return_url'] = $validated['_return_url'];
        }

        session()->flashInput($flash);

        return view(
            'playground-matrix-resource::backlog/form',
            $data
        );
    }

    /**
     * Remove the Backlog resource from storage.
     *
     * @route DELETE /resource/matrix/{backlog} playground.matrix.resource.backlogs.destroy
     */
    public function destroy(
        Backlog $backlog,
        DestroyRequest $request
    ): Response|RedirectResponse {
        $validated = $request->validated();

        if (empty($validated['force'])) {
            $backlog->delete();
        } else {
            $backlog->forceDelete();
        }

        if ($request->expectsJson()) {
            return response()->noContent();
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl && is_string($returnUrl)) {
            return redirect($returnUrl);
        }

        return redirect(route('playground.matrix.resource.backlogs'));
    }

    /**
     * Lock the Backlog resource in storage.
     *
     * @route PUT /resource/matrix/{backlog} playground.matrix.resource.backlogs.lock
     */
    public function lock(
        Backlog $backlog,
        LockRequest $request
    ): JsonResponse|RedirectResponse|BacklogResource {
        $validated = $request->validated();

        $user = $request->user();

        $backlog->setAttribute('locked', true);

        $backlog->save();

        $meta = [
            'session_user_id' => $user?->id,
            'id'              => $backlog->id,
            'timestamp'       => Carbon::now()->toJson(),
            'info'            => $this->packageInfo,
        ];
        // dump($request);

        if ($request->expectsJson()) {
            return (new BacklogResource($backlog))->response($request);
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl && is_string($returnUrl)) {
            return redirect($returnUrl);
        }

        return redirect(route('playground.matrix.resource.backlogs.show', ['backlog' => $backlog->id]));
    }

    /**
     * Display a listing of Backlog resources.
     *
     * @route GET /resource/matrix playground.matrix.resource.backlogs
     */
    public function index(
        IndexRequest $request
    ): JsonResponse|View|BacklogCollection {
        $user = $request->user();

        $validated = $request->validated();

        $query = Backlog::addSelect(sprintf('%1$s.*', $this->packageInfo['table']));

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

        $perPage = ! empty($validated['perPage']) && is_integer($validated['perPage']) ? $validated['perPage'] : null;
        $paginator = $query->paginate( $perPage);

        $paginator->appends($validated);

        if ($request->expectsJson()) {
            return (new BacklogCollection($paginator))->response($request);
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
            'playground-matrix-resource::backlog/index',
            $data
        );
    }

    /**
     * Restore the Backlog resource from the trash.
     *
     * @route PUT /resource/matrix/restore/{backlog} playground.matrix.resource.backlogs.restore
     */
    public function restore(
        Backlog $backlog,
        RestoreRequest $request
    ): JsonResponse|RedirectResponse|BacklogResource {
        $validated = $request->validated();

        $user = $request->user();

        $backlog->restore();

        if ($request->expectsJson()) {
            return (new BacklogResource($backlog))->response($request);
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl && is_string($returnUrl)) {
            return redirect($returnUrl);
        }

        return redirect(route('playground.matrix.resource.backlogs.show', ['backlog' => $backlog->id]));
    }

    /**
     * Display the Backlog resource.
     *
     * @route GET /resource/matrix/{backlog} playground.matrix.resource.backlogs.show
     */
    public function show(
        Backlog $backlog,
        ShowRequest $request
    ): JsonResponse|View|BacklogResource {
        $validated = $request->validated();

        $user = $request->user();

        $meta = [
            'session_user_id' => $user?->id,
            'id'              => $backlog->id,
            'timestamp'       => Carbon::now()->toJson(),
            'validated'       => $validated,
            'info'            => $this->packageInfo,
        ];

        if ($request->expectsJson()) {
            return (new BacklogResource($backlog))->response($request);
        }

        $meta['input'] = $request->input();
        $meta['validated'] = $request->validated();

        $data = [
            'data' => $backlog,
            'meta' => $meta,
        ];

        return view(
            'playground-matrix-resource::backlog/detail',
            $data
        );
    }

    /**
      * Store a newly created API Backlog resource in storage.
      *
      * @route POST /resource/matrix playground.matrix.resource.backlogs.post
      */
    public function store(
        StoreRequest $request
    ): Response|JsonResponse|RedirectResponse|BacklogResource {
        $validated = $request->validated();

        $user = $request->user();

        $backlog = new Backlog($validated);

        $backlog->save();

        if ($request->expectsJson()) {
            return (new BacklogResource($backlog))->response($request);
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl && is_string($returnUrl)) {
            return redirect($returnUrl);
        }

        return redirect(route('playground.matrix.resource.backlogs.show', ['backlog' => $backlog->id]));
    }

    /**
     * Unlock the Backlog resource in storage.
     *
     * @route DELETE /resource/matrix/lock/{backlog} playground.matrix.resource.backlogs.unlock
     */
    public function unlock(
        Backlog $backlog,
        UnlockRequest $request
    ): JsonResponse|RedirectResponse|BacklogResource {
        $validated = $request->validated();

        $user = $request->user();

        $backlog->setAttribute('locked', false);

        $backlog->save();

        if ($request->expectsJson()) {
            return (new BacklogResource($backlog))->response($request);
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl && is_string($returnUrl)) {
            return redirect($returnUrl);
        }

        return redirect(route('playground.matrix.resource.backlogs.show', ['backlog' => $backlog->id]));
    }

    /**
     * Update the Backlog resource in storage.
     *
     * @route PATCH /resource/matrix/{backlog} playground.matrix.resource.backlogs.patch
     */
    public function update(
        Backlog $backlog,
        UpdateRequest $request
    ): JsonResponse|RedirectResponse|BacklogResource {
        $validated = $request->validated();

        $user = $request->user();

        $backlog->update($validated);

        if ($request->expectsJson()) {
            return (new BacklogResource($backlog))->response($request);
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl && is_string($returnUrl)) {
            return redirect($returnUrl);
        }

        return redirect(route('playground.matrix.resource.backlogs.show', ['backlog' => $backlog->id]));
    }
}
