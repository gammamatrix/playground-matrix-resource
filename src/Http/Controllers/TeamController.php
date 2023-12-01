<?php
/**
 * GammaMatrix
 */

namespace GammaMatrix\Playground\Matrix\Resource\Http\Controllers;

use GammaMatrix\Playground\Http\Controllers\Controller;
use GammaMatrix\Playground\Matrix\Models\Team;
use GammaMatrix\Playground\Matrix\Resource\Http\Requests\Team\CreateRequest;
use GammaMatrix\Playground\Matrix\Resource\Http\Requests\Team\DestroyRequest;
use GammaMatrix\Playground\Matrix\Resource\Http\Requests\Team\EditRequest;
use GammaMatrix\Playground\Matrix\Resource\Http\Requests\Team\IndexRequest;
use GammaMatrix\Playground\Matrix\Resource\Http\Requests\Team\LockRequest;
use GammaMatrix\Playground\Matrix\Resource\Http\Requests\Team\RestoreRequest;
use GammaMatrix\Playground\Matrix\Resource\Http\Requests\Team\ShowRequest;
use GammaMatrix\Playground\Matrix\Resource\Http\Requests\Team\StoreRequest;
use GammaMatrix\Playground\Matrix\Resource\Http\Requests\Team\UnlockRequest;
use GammaMatrix\Playground\Matrix\Resource\Http\Requests\Team\UpdateRequest;
use GammaMatrix\Playground\Matrix\Resource\Http\Resources\Team as TeamResource;
use GammaMatrix\Playground\Matrix\Resource\Http\Resources\TeamCollection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * \GammaMatrix\Playground\Matrix\Resource\Http\Controllers\TeamController
 */
class TeamController extends Controller
{
    public array $packageInfo = [
        'model_attribute'     => 'label',
        'model_label'         => 'Team',
        'model_label_plural'  => 'Teams',
        'model_route'         => 'playground.matrix.resource.teams',
        'model_slug'          => 'team',
        'model_slug_plural'   => 'teams',
        'module_label'        => 'Matrix',
        'module_label_plural' => 'Matrices',
        'module_route'        => 'playground.matrix.resource',
        'module_slug'         => 'matrix',
        'privilege'           => 'playground-matrix-resource:team',
        'table'               => 'matrix_teams',
        'view'                => 'playground-matrix-resource::team',
    ];

    /**
     * CREATE the Team resource in storage.
     *
     * @route GET /resource/matrix/teams/create playground.matrix.resource.teams.create
     */
    public function create(
        CreateRequest $request
    ): JsonResponse|View {
        $validated = $request->validated();

        $user = $request->user();

        $team = new Team($validated);

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
            'data' => $team,
            'meta' => $meta,
            '_method' => 'post',
        ];

        if ($request->expectsJson()) {
            return response()->json($data);
        }

        $flash = $team->toArray();

        if (!empty($validated['_return_url'])) {
            $flash['_return_url'] = $validated['_return_url'];
            $data['_return_url'] = $validated['_return_url'];
        }

        if (!$request->session()->has('errors')) {
            session()->flashInput($flash);
        }

        return view(
            'playground-matrix-resource::team/form',
            $data
        );
    }

    /**
     * Edit the Team resource in storage.
     *
     * @route GET /resource/matrix/teams/edit playground.matrix.resource.teams.edit
     */
    public function edit(
        Team $team,
        EditRequest $request
    ): JsonResponse|View {
        $validated = $request->validated();

        $user = $request->user();

        $meta = [
            'session_user_id' => $user?->id,
            'id'              => $team->id,
            'timestamp'       => Carbon::now()->toJson(),
            'validated'       => $validated,
            'info'            => $this->packageInfo,
        ];

        $meta['input'] = $request->input();
        $meta['validated'] = $request->validated();

        $data = [
            'data' => $team,
            'meta' => $meta,
            '_method' => 'patch',
        ];

        if ($request->expectsJson()) {
            return response()->json($data);
        }

        $flash = $team->toArray();

        if (!empty($validated['_return_url'])) {
            $flash['_return_url'] = $validated['_return_url'];
            $data['_return_url'] = $validated['_return_url'];
        }

        session()->flashInput($flash);

        return view(
            'playground-matrix-resource::team/form',
            $data
        );
    }

    /**
     * Remove the Team resource from storage.
     *
     * @route DELETE /resource/matrix/{team} playground.matrix.resource.teams.destroy
     */
    public function destroy(
        Team $team,
        DestroyRequest $request
    ): Response|RedirectResponse {
        $validated = $request->validated();

        if (empty($validated['force'])) {
            $team->delete();
        } else {
            $team->forceDelete();
        }

        if ($request->expectsJson()) {
            return response()->noContent();
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl) {
            return redirect($returnUrl);
        }

        return redirect(route('playground.matrix.resource.teams'));
    }

    /**
     * Lock the Team resource in storage.
     *
     * @route PUT /resource/matrix/{team} playground.matrix.resource.teams.lock
     */
    public function lock(
        Team $team,
        LockRequest $request
    ): JsonResponse|RedirectResponse|TeamResource {
        $validated = $request->validated();

        $user = $request->user();

        $team->locked = true;

        $team->save();

        $meta = [
            'session_user_id' => $user?->id,
            'id'              => $team->id,
            'timestamp'       => Carbon::now()->toJson(),
            'info'            => $this->packageInfo,
        ];

        if ($request->expectsJson()) {
            return (new TeamResource($team))->response($request);
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl) {
            return redirect($returnUrl);
        }

        return redirect(route('playground.matrix.resource.teams.show', ['team' => $team->id]));
    }

    /**
     * Display a listing of Team resources.
     *
     * @route GET /resource/matrix playground.matrix.resource.teams
     */
    public function index(
        IndexRequest $request
    ): JsonResponse|View|TeamCollection {
        $user = $request->user();

        $validated = $request->validated();

        $query = Team::addSelect(sprintf('%1$s.*', $this->packageInfo['table']));

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
            return (new TeamCollection($paginator))->response($request);
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
            'playground-matrix-resource::team/index',
            $data
        );
    }

    /**
     * Restore the Team resource from the trash.
     *
     * @route PUT /resource/matrix/restore/{team} playground.matrix.resource.teams.restore
     */
    public function restore(
        Team $team,
        RestoreRequest $request
    ): JsonResponse|RedirectResponse|TeamResource {
        $validated = $request->validated();

        $user = $request->user();

        $team->restore();

        if ($request->expectsJson()) {
            return (new TeamResource($team))->response($request);
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl) {
            return redirect($returnUrl);
        }

        return redirect(route('playground.matrix.resource.teams.show', ['team' => $team->id]));
    }

    /**
     * Display the Team resource.
     *
     * @route GET /resource/matrix/{team} playground.matrix.resource.teams.show
     */
    public function show(
        Team $team,
        ShowRequest $request
    ): JsonResponse|View|TeamResource {
        $validated = $request->validated();

        $user = $request->user();

        $meta = [
            'session_user_id' => $user?->id,
            'id'              => $team->id,
            'timestamp'       => Carbon::now()->toJson(),
            'validated'       => $validated,
            'info'            => $this->packageInfo,
        ];

        if ($request->expectsJson()) {
            return (new TeamResource($team))->response($request);
        }

        $meta['input'] = $request->input();
        $meta['validated'] = $request->validated();

        $data = [
            'data' => $team,
            'meta' => $meta,
        ];

        return view(
            'playground-matrix-resource::team/detail',
            $data
        );
    }

    /**
      * Store a newly created API Team resource in storage.
      *
      * @route POST /resource/matrix playground.matrix.resource.teams.post
      */
    public function store(
        StoreRequest $request
    ): Response|JsonResponse|RedirectResponse|TeamResource {
        $validated = $request->validated();

        $user = $request->user();

        $team = new Team($validated);

        $team->save();

        if ($request->expectsJson()) {
            return (new TeamResource($team))->response($request);
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl) {
            return redirect($returnUrl);
        }

        return redirect(route('playground.matrix.resource.teams.show', ['team' => $team->id]));
    }

    /**
     * Unlock the Team resource in storage.
     *
     * @route DELETE /resource/matrix/lock/{team} playground.matrix.resource.teams.unlock
     */
    public function unlock(
        Team $team,
        UnlockRequest $request
    ): JsonResponse|RedirectResponse|TeamResource {
        $validated = $request->validated();

        $user = $request->user();

        $team->locked = false;

        $team->save();

        if ($request->expectsJson()) {
            return (new TeamResource($team))->response($request);
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl) {
            return redirect($returnUrl);
        }

        return redirect(route('playground.matrix.resource.teams.show', ['team' => $team->id]));
    }

    /**
     * Update the Team resource in storage.
     *
     * @route PATCH /resource/matrix/{team} playground.matrix.resource.teams.patch
     */
    public function update(
        Team $team,
        UpdateRequest $request
    ): JsonResponse|RedirectResponse|TeamResource {
        $validated = $request->validated();

        $user = $request->user();

        $team->update($validated);

        if ($request->expectsJson()) {
            return (new TeamResource($team))->response($request);
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl) {
            return redirect($returnUrl);
        }

        return redirect(route('playground.matrix.resource.teams.show', ['team' => $team->id]));
    }
}
