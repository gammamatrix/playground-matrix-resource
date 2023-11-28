<?php
/**
 * GammaMatrix
 */

namespace GammaMatrix\Playground\Matrix\Resource\Http\Controllers;

use GammaMatrix\Playground\Http\Controllers\Controller;
use GammaMatrix\Playground\Matrix\Models\Board;
use GammaMatrix\Playground\Matrix\Resource\Http\Requests\Board\CreateRequest;
use GammaMatrix\Playground\Matrix\Resource\Http\Requests\Board\DestroyRequest;
use GammaMatrix\Playground\Matrix\Resource\Http\Requests\Board\EditRequest;
use GammaMatrix\Playground\Matrix\Resource\Http\Requests\Board\IndexRequest;
use GammaMatrix\Playground\Matrix\Resource\Http\Requests\Board\LockRequest;
use GammaMatrix\Playground\Matrix\Resource\Http\Requests\Board\RestoreRequest;
use GammaMatrix\Playground\Matrix\Resource\Http\Requests\Board\ShowRequest;
use GammaMatrix\Playground\Matrix\Resource\Http\Requests\Board\StoreRequest;
use GammaMatrix\Playground\Matrix\Resource\Http\Requests\Board\UnlockRequest;
use GammaMatrix\Playground\Matrix\Resource\Http\Requests\Board\UpdateRequest;
use GammaMatrix\Playground\Matrix\Resource\Http\Resources\Board\Board as BoardResource;
use GammaMatrix\Playground\Matrix\Resource\Http\Resources\Board\BoardCollection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * \GammaMatrix\Playground\Matrix\Resource\Http\Controllers\BoardController
 */
class BoardController extends Controller
{
    public array $packageInfo = [
        'model_attribute'     => 'label',
        'model_label'         => 'Board',
        'model_label_plural'  => 'Boards',
        'model_route'         => 'playground.matrix.resource.boards',
        'model_slug'          => 'board',
        'model_slug_plural'   => 'boards',
        'module_label'        => 'Matrix',
        'module_label_plural' => 'Matrices',
        'module_route'        => 'playground.matrix.resource',
        'module_slug'         => 'matrix',
        'privilege'           => 'playground-matrix-resource:board',
        'table'               => 'matrix_boards',
        'view'                => 'playground-matrix-resource::board',
    ];

    /**
     * CREATE the Board resource in storage.
     *
     * @route GET /resource/matrix/boards/create playground.matrix.resource.boards.create
     */
    public function create(
        CreateRequest $request
    ): JsonResponse|View {
        $validated = $request->validated();

        $user = $request->user();

        $board = new Board($validated);

        $meta = [
            'session_user_id' => $user->id,
            'id'              => null,
            'timestamp'       => Carbon::now()->toJson(),
            'validated'       => $validated,
            'info'            => $this->packageInfo,
        ];

        $meta['input'] = $request->input();
        $meta['validated'] = $request->validated();

        $data = [
            'data' => $board,
            'meta' => $meta,
            '_method' => 'post',
        ];

        if ($request->expectsJson()) {
            return response()->json($data);
        }

        $flash = $board->toArray();

        if (!empty($validated['_return_url'])) {
            $flash['_return_url'] = $validated['_return_url'];
            $data['_return_url'] = $validated['_return_url'];
        }

        if (!$request->session()->has('errors')) {
            session()->flashInput($flash);
        }

        return view(
            'playground-matrix-resource::board/form',
            $data
        );
    }

    /**
     * Edit the Board resource in storage.
     *
     * @route GET /resource/matrix/boards/edit playground.matrix.resource.boards.edit
     */
    public function edit(
        Board $board,
        EditRequest $request
    ): JsonResponse|View {
        $validated = $request->validated();

        $user = $request->user();

        $meta = [
            'session_user_id' => $user->id,
            'id'              => $board->id,
            'timestamp'       => Carbon::now()->toJson(),
            'validated'       => $validated,
            'info'            => $this->packageInfo,
        ];

        $meta['input'] = $request->input();
        $meta['validated'] = $request->validated();

        $data = [
            'data' => $board,
            'meta' => $meta,
            '_method' => 'patch',
        ];

        if ($request->expectsJson()) {
            return response()->json($data);
        }

        $flash = $board->toArray();

        if (!empty($validated['_return_url'])) {
            $flash['_return_url'] = $validated['_return_url'];
            $data['_return_url'] = $validated['_return_url'];
        }

        session()->flashInput($flash);

        return view(
            'playground-matrix-resource::board/form',
            $data
        );
    }

    /**
     * Remove the Board resource from storage.
     *
     * @route DELETE /resource/matrix/{board} playground.matrix.resource.boards.destroy
     */
    public function destroy(
        Board $board,
        DestroyRequest $request
    ): Response|RedirectResponse {
        $validated = $request->validated();

        if (empty($validated['force'])) {
            $board->delete();
        } else {
            $board->forceDelete();
        }

        if ($request->expectsJson()) {
            return response()->noContent();
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl) {
            return redirect($returnUrl);
        }

        return redirect(route('playground.matrix.resource.boards'));
    }

    /**
     * Lock the Board resource in storage.
     *
     * @route PUT /resource/matrix/{board} playground.matrix.resource.boards.lock
     */
    public function lock(
        Board $board,
        LockRequest $request
    ): JsonResponse|RedirectResponse {
        $validated = $request->validated();

        $user = $request->user();

        $board->locked = true;

        $board->save();

        $meta = [
            'session_user_id' => $user->id,
            'id'              => $board->id,
            'timestamp'       => Carbon::now()->toJson(),
            'info'            => $this->packageInfo,
        ];

        if ($request->expectsJson()) {
            return new BoardResource($board);
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl) {
            return redirect($returnUrl);
        }

        return redirect(route('playground.matrix.resource.boards.show', ['board' => $board->id]));
    }

    /**
     * Display a listing of Board resources.
     *
     * @route GET /resource/matrix playground.matrix.resource.boards
     */
    public function index(
        IndexRequest $request
    ): JsonResponse|View {
        $user = $request->user();

        $validated = $request->validated();

        $query = Board::addSelect(sprintf('%1$s.*', $this->packageInfo['table']));

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
            return (new BoardCollection($paginator))->additional(['meta' => [
                'session_user_id' => $user->id,
                'validated'       => $validated,
            ]]);
        }

        $meta = [
            'session_user_id' => $user->id,
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
            'playground-matrix-resource::board/index',
            $data
        );
    }

    /**
     * Restore the Board resource from the trash.
     *
     * @route PUT /resource/matrix/restore/{board} playground.matrix.resource.boards.restore
     */
    public function restore(
        Board $board,
        RestoreRequest $request
    ): JsonResponse|RedirectResponse {
        $validated = $request->validated();

        $user = $request->user();

        $board->restore();

        if ($request->expectsJson()) {
            return new BoardResource($board);
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl) {
            return redirect($returnUrl);
        }

        return redirect(route('playground.matrix.resource.boards.show', ['board' => $board->id]));
    }

    /**
     * Display the Board resource.
     *
     * @route GET /resource/matrix/{board} playground.matrix.resource.boards.show
     */
    public function show(
        Board $board,
        ShowRequest $request
    ): JsonResponse|View {
        $validated = $request->validated();

        $user = $request->user();

        $meta = [
            'session_user_id' => $user->id,
            'id'              => $board->id,
            'timestamp'       => Carbon::now()->toJson(),
            'validated'       => $validated,
            'info'            => $this->packageInfo,
        ];

        if ($request->expectsJson()) {
            return new BoardResource($board);
        }

        $meta['input'] = $request->input();
        $meta['validated'] = $request->validated();

        $data = [
            'data' => $board,
            'meta' => $meta,
        ];

        return view(
            'playground-matrix-resource::board/detail',
            $data
        );
    }

    /**
      * Store a newly created API Board resource in storage.
      *
      * @route POST /resource/matrix playground.matrix.resource.boards.post
      */
    public function store(
        StoreRequest $request
    ): Response|JsonResponse|RedirectResponse {
        $validated = $request->validated();

        $user = $request->user();

        $board = new Board($validated);

        $board->save();

        if ($request->expectsJson()) {
            return new BoardResource($board);
        }

        $returnUrl = $validated['return_url'] ?? '';

        if ($returnUrl) {
            return redirect($returnUrl);
        }

        return redirect(route('playground.matrix.resource.boards.show', ['board' => $board->id]));
    }

    /**
     * Unlock the Board resource in storage.
     *
     * @route DELETE /resource/matrix/lock/{board} playground.matrix.resource.boards.unlock
     */
    public function unlock(
        Board $board,
        UnlockRequest $request
    ): JsonResponse|RedirectResponse {
        $validated = $request->validated();

        $user = $request->user();

        $board->locked = false;

        $board->save();

        if ($request->expectsJson()) {
            return new BoardResource($board);
        }

        $returnUrl = $validated['return_url'] ?? '';

        if ($returnUrl) {
            return redirect($returnUrl);
        }

        return redirect(route('playground.matrix.resource.boards.show', ['board' => $board->id]));
    }

    /**
     * Update the Board resource in storage.
     *
     * @route PATCH /resource/matrix/{board} playground.matrix.resource.boards.patch
     */
    public function update(
        Board $board,
        UpdateRequest $request
    ): JsonResponse|RedirectResponse {
        $validated = $request->validated();

        $user = $request->user();

        $board->update($validated);

        if ($request->expectsJson()) {
            return new BoardResource($board);
        }

        $returnUrl = $validated['return_url'] ?? '';

        if ($returnUrl) {
            return redirect($returnUrl);
        }

        return redirect(route('playground.matrix.resource.boards.show', ['board' => $board->id]));
    }
}
