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
use Playground\Matrix\Models\Board;
use Playground\Matrix\Resource\Http\Requests;
use Playground\Matrix\Resource\Http\Resources;

/**
 * \Playground\Matrix\Resource\Http\Controllers\BoardController
 */
class BoardController extends Controller
{
    /**
     * @var array<string, string>
     */
    public array $packageInfo = [
        'model_attribute' => 'title',
        'model_label' => 'Board',
        'model_label_plural' => 'Boards',
        'model_route' => 'playground.matrix.resource.boards',
        'model_slug' => 'board',
        'model_slug_plural' => 'boards',
        'module_label' => 'Matrix',
        'module_label_plural' => 'Matrices',
        'module_route' => 'playground.matrix.resource',
        'module_slug' => 'matrix',
        'privilege' => 'playground-matrix-resource:board',
        'table' => 'matrix_boards',
        'view' => 'playground-matrix-resource::board',
    ];

    /**
     * Create the Board resource in storage.
     *
     * @route GET /resource/matrix/boards/create playground.matrix.resource.boards.create
     */
    public function create(
        Requests\Board\CreateRequest $request
    ): JsonResponse|View|Resources\Board {

        $packageInfo = $this->packageInfo();

        $validated = $request->validated();

        $user = $request->user();

        $board = new Board($validated);

        if ($request->expectsJson()) {
            return new Resources\Board($board)->additional(['meta' => [
                'info' => $packageInfo,
            ]])->response($request);
        }

        $meta = [
            'session_user_id' => $user?->id,
            'id' => null,
            'timestamp' => Carbon::now()->toJson(),
            'info' => $packageInfo,
        ];

        $data = [
            'data' => $board,
            'meta' => $meta,
            '_method' => 'post',
        ];

        $flash = $board->toArray();

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
     * Edit the Board resource in storage.
     *
     * @route GET /resource/matrix/boards/edit/{board} playground.matrix.resource.boards.edit
     */
    public function edit(
        Board $board,
        Requests\Board\EditRequest $request
    ): JsonResponse|View|Resources\Board {

        $packageInfo = $this->packageInfo();

        $validated = $request->validated();

        $user = $request->user();

        if ($request->expectsJson()) {
            return new Resources\Board($board)->additional(['meta' => [
                'info' => $packageInfo,
            ]])->response($request);
        }

        $flash = $board->toArray();

        if (! empty($validated['_return_url'])) {
            $flash['_return_url'] = $validated['_return_url'];
        }

        $meta = [
            'session_user_id' => $user?->id,
            'id' => $board->id,
            'timestamp' => Carbon::now()->toJson(),
            'info' => $packageInfo,
        ];

        $data = [
            'data' => $board,
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
     * Remove the Board resource from storage.
     *
     * @route DELETE /resource/matrix/boards/{board} playground.matrix.resource.boards.destroy
     */
    public function destroy(
        Board $board,
        Requests\Board\DestroyRequest $request
    ): Response|RedirectResponse {

        $packageInfo = $this->packageInfo();

        $validated = $request->validated();

        $user = $request->user();

        if ($user?->id) {
            $board->modified_by_id = $user->id;
        }

        if (empty($validated['force'])) {
            $board->delete();
        } else {
            $board->forceDelete();
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
     * Lock the Board resource in storage.
     *
     * @route PUT /resource/matrix/boards/{board} playground.matrix.resource.boards.lock
     */
    public function lock(
        Board $board,
        Requests\Board\LockRequest $request
    ): JsonResponse|RedirectResponse|Resources\Board {

        $packageInfo = $this->packageInfo();

        $validated = $request->validated();

        $user = $request->user();

        if ($user?->id) {
            $board->modified_by_id = $user->id;
        }

        $board->locked = true;

        $board->save();

        if ($request->expectsJson()) {
            return new Resources\Board($board)->additional(['meta' => [
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
        ), ['board' => $board->id]));
    }

    /**
     * Display a listing of Board resources.
     *
     * @route GET /resource/matrix/boards playground.matrix.resource.boards
     */
    public function index(
        Requests\Board\IndexRequest $request
    ): JsonResponse|View|Resources\BoardCollection {

        $packageInfo = $this->packageInfo();

        $user = $request->user();

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

        $query = Board::addSelect(sprintf('%1$s.*', $packageInfo->table()));

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
            return new Resources\BoardCollection($paginator)->response($request);
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
     * Restore the Board resource from the trash.
     *
     * @route PUT /resource/matrix/boards/restore/{board} playground.matrix.resource.boards.restore
     */
    public function restore(
        Board $board,
        Requests\Board\RestoreRequest $request
    ): JsonResponse|RedirectResponse|Resources\Board {

        $packageInfo = $this->packageInfo();

        $validated = $request->validated();

        $user = $request->user();

        if ($user?->id) {
            $board->modified_by_id = $user->id;
        }

        $board->restore();

        if ($request->expectsJson()) {
            return new Resources\Board($board)->additional(['meta' => [
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
        ), ['board' => $board->id]));
    }

    /**
     * Display the Board resource.
     *
     * @route GET /resource/matrix/boards/{board} playground.matrix.resource.boards.show
     */
    public function show(
        Board $board,
        Requests\Board\ShowRequest $request
    ): JsonResponse|View|Resources\Board {

        $packageInfo = $this->packageInfo();

        $validated = $request->validated();

        $user = $request->user();

        $meta = [
            'session_user_id' => $user?->id,
            'id' => $board->id,
            'timestamp' => Carbon::now()->toJson(),
            'info' => $packageInfo,
        ];

        if ($request->expectsJson()) {
            return new Resources\Board($board)->additional(['meta' => [
                'info' => $packageInfo,
            ]])->response($request);
        }

        $data = [
            'data' => $board,
            'meta' => $meta,
        ];

        /**
         * @var view-string $view
         */
        $view = sprintf('%1$s/detail', $packageInfo->view());

        return view($view, $data);
    }

    /**
     * Store a newly created API Board resource in storage.
     *
     * @route POST /resource/matrix/boards playground.matrix.resource.boards.post
     */
    public function store(
        Requests\Board\StoreRequest $request
    ): Response|JsonResponse|RedirectResponse|Resources\Board {

        $packageInfo = $this->packageInfo();

        $validated = $request->validated();

        $user = $request->user();

        $board = new Board($validated);

        if ($user?->id) {
            $board->created_by_id = $user->id;
        }

        $board->save();

        if ($request->expectsJson()) {
            return new Resources\Board($board)->additional(['meta' => [
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
        ), ['board' => $board->id]));
    }

    /**
     * Unlock the Board resource in storage.
     *
     * @route DELETE /resource/matrix/boards/lock/{board} playground.matrix.resource.boards.unlock
     */
    public function unlock(
        Board $board,
        Requests\Board\UnlockRequest $request
    ): JsonResponse|RedirectResponse|Resources\Board {

        $packageInfo = $this->packageInfo();

        $validated = $request->validated();

        $user = $request->user();

        $board->locked = false;

        if ($user?->id) {
            $board->modified_by_id = $user->id;
        }

        $board->save();

        if ($request->expectsJson()) {
            return new Resources\Board($board)->additional(['meta' => [
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
        ), ['board' => $board->id]));
    }

    /**
     * Update the Board resource in storage.
     *
     * @route PATCH /resource/matrix/boards/{board} playground.matrix.resource.boards.patch
     */
    public function update(
        Board $board,
        Requests\Board\UpdateRequest $request
    ): JsonResponse|RedirectResponse|Resources\Board {

        $packageInfo = $this->packageInfo();

        $validated = $request->validated();

        $user = $request->user();

        if ($user?->id) {
            $board->modified_by_id = $user->id;
        }

        $board->update($validated);

        if ($request->expectsJson()) {
            return new Resources\Board($board)->additional(['meta' => [
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
        ), ['board' => $board->id]));
    }
}
