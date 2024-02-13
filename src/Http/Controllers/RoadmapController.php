<?php
/**
 * Playground
 */

namespace Playground\Matrix\Resource\Http\Controllers;

use Playground\Matrix\Models\Roadmap;
use Playground\Matrix\Resource\Http\Requests\Roadmap\CreateRequest;
use Playground\Matrix\Resource\Http\Requests\Roadmap\DestroyRequest;
use Playground\Matrix\Resource\Http\Requests\Roadmap\EditRequest;
use Playground\Matrix\Resource\Http\Requests\Roadmap\IndexRequest;
use Playground\Matrix\Resource\Http\Requests\Roadmap\LockRequest;
use Playground\Matrix\Resource\Http\Requests\Roadmap\RestoreRequest;
use Playground\Matrix\Resource\Http\Requests\Roadmap\ShowRequest;
use Playground\Matrix\Resource\Http\Requests\Roadmap\StoreRequest;
use Playground\Matrix\Resource\Http\Requests\Roadmap\UnlockRequest;
use Playground\Matrix\Resource\Http\Requests\Roadmap\UpdateRequest;
use Playground\Matrix\Resource\Http\Resources\Roadmap as RoadmapResource;
use Playground\Matrix\Resource\Http\Resources\RoadmapCollection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * \Playground\Matrix\Resource\Http\Controllers\RoadmapController
 */
class RoadmapController extends Controller
{
    /**
     * @var array<string, string>
     */
    public array $packageInfo = [
        'model_attribute'     => 'label',
        'model_label'         => 'Roadmap',
        'model_label_plural'  => 'Roadmaps',
        'model_route'         => 'playground.matrix.resource.roadmaps',
        'model_slug'          => 'roadmap',
        'model_slug_plural'   => 'roadmaps',
        'module_label'        => 'Matrix',
        'module_label_plural' => 'Matrices',
        'module_route'        => 'playground.matrix.resource',
        'module_slug'         => 'matrix',
        'privilege'           => 'playground-matrix-resource:roadmap',
        'table'               => 'matrix_roadmaps',
        'view'                => 'playground-matrix-resource::roadmap',
    ];

    /**
     * CREATE the Roadmap resource in storage.
     *
     * @route GET /resource/matrix/roadmaps/create playground.matrix.resource.roadmaps.create
     */
    public function create(
        CreateRequest $request
    ): JsonResponse|View {
        $validated = $request->validated();

        $user = $request->user();

        $roadmap = new Roadmap($validated);

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
            'data' => $roadmap,
            'meta' => $meta,
            '_method' => 'post',
        ];

        if ($request->expectsJson()) {
            return response()->json($data);
        }

        $flash = $roadmap->toArray();

        if (!empty($validated['_return_url'])) {
            $flash['_return_url'] = $validated['_return_url'];
            $data['_return_url'] = $validated['_return_url'];
        }

        if (!$request->session()->has('errors')) {
            session()->flashInput($flash);
        }

        return view(
            'playground-matrix-resource::roadmap/form',
            $data
        );
    }

    /**
     * Edit the Roadmap resource in storage.
     *
     * @route GET /resource/matrix/roadmaps/edit playground.matrix.resource.roadmaps.edit
     */
    public function edit(
        Roadmap $roadmap,
        EditRequest $request
    ): JsonResponse|View {
        $validated = $request->validated();

        $user = $request->user();

        $meta = [
            'session_user_id' => $user?->id,
            'id'              => $roadmap->id,
            'timestamp'       => Carbon::now()->toJson(),
            'validated'       => $validated,
            'info'            => $this->packageInfo,
        ];

        $meta['input'] = $request->input();
        $meta['validated'] = $request->validated();

        $data = [
            'data' => $roadmap,
            'meta' => $meta,
            '_method' => 'patch',
        ];

        if ($request->expectsJson()) {
            return response()->json($data);
        }

        $flash = $roadmap->toArray();

        if (!empty($validated['_return_url'])) {
            $flash['_return_url'] = $validated['_return_url'];
            $data['_return_url'] = $validated['_return_url'];
        }

        session()->flashInput($flash);

        return view(
            'playground-matrix-resource::roadmap/form',
            $data
        );
    }

    /**
     * Remove the Roadmap resource from storage.
     *
     * @route DELETE /resource/matrix/{roadmap} playground.matrix.resource.roadmaps.destroy
     */
    public function destroy(
        Roadmap $roadmap,
        DestroyRequest $request
    ): Response|RedirectResponse {
        $validated = $request->validated();

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

        return redirect(route('playground.matrix.resource.roadmaps'));
    }

    /**
     * Lock the Roadmap resource in storage.
     *
     * @route PUT /resource/matrix/{roadmap} playground.matrix.resource.roadmaps.lock
     */
    public function lock(
        Roadmap $roadmap,
        LockRequest $request
    ): JsonResponse|RedirectResponse|RoadmapResource {
        $validated = $request->validated();

        $user = $request->user();

        $roadmap->setAttribute('locked', true);

        $roadmap->save();

        $meta = [
            'session_user_id' => $user?->id,
            'id'              => $roadmap->id,
            'timestamp'       => Carbon::now()->toJson(),
            'info'            => $this->packageInfo,
        ];

        if ($request->expectsJson()) {
            return (new RoadmapResource($roadmap))->response($request);
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl && is_string($returnUrl)) {
            return redirect($returnUrl);
        }

        return redirect(route('playground.matrix.resource.roadmaps.show', ['roadmap' => $roadmap->id]));
    }

    /**
     * Display a listing of Roadmap resources.
     *
     * @route GET /resource/matrix playground.matrix.resource.roadmaps
     */
    public function index(
        IndexRequest $request
    ): JsonResponse|View|RoadmapCollection {
        $user = $request->user();

        $validated = $request->validated();

        $query = Roadmap::addSelect(sprintf('%1$s.*', $this->packageInfo['table']));

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
            return (new RoadmapCollection($paginator))->response($request);
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
            'playground-matrix-resource::roadmap/index',
            $data
        );
    }

    /**
     * Restore the Roadmap resource from the trash.
     *
     * @route PUT /resource/matrix/restore/{roadmap} playground.matrix.resource.roadmaps.restore
     */
    public function restore(
        Roadmap $roadmap,
        RestoreRequest $request
    ): JsonResponse|RedirectResponse|RoadmapResource {
        $validated = $request->validated();

        $user = $request->user();

        $roadmap->restore();

        if ($request->expectsJson()) {
            return (new RoadmapResource($roadmap))->response($request);
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl && is_string($returnUrl)) {
            return redirect($returnUrl);
        }

        return redirect(route('playground.matrix.resource.roadmaps.show', ['roadmap' => $roadmap->id]));
    }

    /**
     * Display the Roadmap resource.
     *
     * @route GET /resource/matrix/{roadmap} playground.matrix.resource.roadmaps.show
     */
    public function show(
        Roadmap $roadmap,
        ShowRequest $request
    ): JsonResponse|View|RoadmapResource {
        $validated = $request->validated();

        $user = $request->user();

        $meta = [
            'session_user_id' => $user?->id,
            'id'              => $roadmap->id,
            'timestamp'       => Carbon::now()->toJson(),
            'validated'       => $validated,
            'info'            => $this->packageInfo,
        ];

        if ($request->expectsJson()) {
            return (new RoadmapResource($roadmap))->response($request);
        }

        $meta['input'] = $request->input();
        $meta['validated'] = $request->validated();

        $data = [
            'data' => $roadmap,
            'meta' => $meta,
        ];

        return view(
            'playground-matrix-resource::roadmap/detail',
            $data
        );
    }

    /**
      * Store a newly created API Roadmap resource in storage.
      *
      * @route POST /resource/matrix playground.matrix.resource.roadmaps.post
      */
    public function store(
        StoreRequest $request
    ): Response|JsonResponse|RedirectResponse|RoadmapResource {
        $validated = $request->validated();

        $user = $request->user();

        $roadmap = new Roadmap($validated);

        $roadmap->save();

        if ($request->expectsJson()) {
            return (new RoadmapResource($roadmap))->response($request);
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl && is_string($returnUrl)) {
            return redirect($returnUrl);
        }

        return redirect(route('playground.matrix.resource.roadmaps.show', ['roadmap' => $roadmap->id]));
    }

    /**
     * Unlock the Roadmap resource in storage.
     *
     * @route DELETE /resource/matrix/lock/{roadmap} playground.matrix.resource.roadmaps.unlock
     */
    public function unlock(
        Roadmap $roadmap,
        UnlockRequest $request
    ): JsonResponse|RedirectResponse|RoadmapResource {
        $validated = $request->validated();

        $user = $request->user();

        $roadmap->setAttribute('locked', false);

        $roadmap->save();

        if ($request->expectsJson()) {
            return (new RoadmapResource($roadmap))->response($request);
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl && is_string($returnUrl)) {
            return redirect($returnUrl);
        }

        return redirect(route('playground.matrix.resource.roadmaps.show', ['roadmap' => $roadmap->id]));
    }

    /**
     * Update the Roadmap resource in storage.
     *
     * @route PATCH /resource/matrix/{roadmap} playground.matrix.resource.roadmaps.patch
     */
    public function update(
        Roadmap $roadmap,
        UpdateRequest $request
    ): JsonResponse|RedirectResponse|RoadmapResource {
        $validated = $request->validated();

        $user = $request->user();

        $roadmap->update($validated);

        if ($request->expectsJson()) {
            return (new RoadmapResource($roadmap))->response($request);
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl && is_string($returnUrl)) {
            return redirect($returnUrl);
        }

        return redirect(route('playground.matrix.resource.roadmaps.show', ['roadmap' => $roadmap->id]));
    }
}
