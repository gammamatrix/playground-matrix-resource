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
use Playground\Matrix\Models\Note;
use Playground\Matrix\Resource\Http\Requests;
use Playground\Matrix\Resource\Http\Resources;

/**
 * \Playground\Matrix\Resource\Http\Controllers\NoteController
 */
class NoteController extends Controller
{
    /**
     * @var array<string, string>
     */
    public array $packageInfo = [
        'model_attribute' => 'label',
        'model_label' => 'Note',
        'model_label_plural' => 'Notes',
        'model_route' => 'playground.matrix.resource.notes',
        'model_slug' => 'note',
        'model_slug_plural' => 'notes',
        'module_label' => 'Matrix',
        'module_label_plural' => 'Matrices',
        'module_route' => 'playground.matrix.resource',
        'module_slug' => 'matrix',
        'privilege' => 'playground-matrix-resource:note',
        'table' => 'matrix_notes',
        'view' => 'playground-matrix-resource::note',
    ];

    /**
     * CREATE the Note resource in storage.
     *
     * @route GET /resource/matrix/notes/create playground.matrix.resource.notes.create
     */
    public function create(
        Requests\Note\CreateRequest $request
    ): JsonResponse|View {

        $validated = $request->validated();

        $user = $request->user();

        $note = new Note($validated);

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
            'data' => $note,
            'meta' => $meta,
            '_method' => 'post',
        ];

        if ($request->expectsJson()) {
            return response()->json($data);
        }

        $flash = $note->toArray();

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
     * Edit the Note resource in storage.
     *
     * @route GET /resource/matrix/notes/edit playground.matrix.resource.notes.edit
     */
    public function edit(
        Note $note,
        Requests\Note\EditRequest $request
    ): JsonResponse|View {

        $validated = $request->validated();

        $user = $request->user();

        $meta = [
            'session_user_id' => $user?->id,
            'id' => $note->id,
            'timestamp' => Carbon::now()->toJson(),
            'validated' => $validated,
            'info' => $this->packageInfo,
        ];

        $meta['input'] = $request->input();
        $meta['validated'] = $request->validated();

        $data = [
            'data' => $note,
            'meta' => $meta,
            '_method' => 'patch',
        ];

        if ($request->expectsJson()) {
            return response()->json($data);
        }

        $flash = $note->toArray();

        if (! empty($validated['_return_url'])) {
            $flash['_return_url'] = $validated['_return_url'];
            $data['_return_url'] = $validated['_return_url'];
        }

        session()->flashInput($flash);

        return view(sprintf('%1$s/form', $this->packageInfo['view']), $data);
    }

    /**
     * Remove the Note resource from storage.
     *
     * @route DELETE /resource/matrix/{note} playground.matrix.resource.notes.destroy
     */
    public function destroy(
        Note $note,
        Requests\Note\DestroyRequest $request
    ): Response|RedirectResponse {

        $validated = $request->validated();

        if (empty($validated['force'])) {
            $note->delete();
        } else {
            $note->forceDelete();
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
     * Lock the Note resource in storage.
     *
     * @route PUT /resource/matrix/{note} playground.matrix.resource.notes.lock
     */
    public function lock(
        Note $note,
        Requests\Note\LockRequest $request
    ): JsonResponse|RedirectResponse|Resources\Note {

        $validated = $request->validated();

        $user = $request->user();

        $note->locked = true;

        $note->save();

        $meta = [
            'session_user_id' => $user?->id,
            'id' => $note->id,
            'timestamp' => Carbon::now()->toJson(),
            'info' => $this->packageInfo,
        ];

        if ($request->expectsJson()) {
            return (new Resources\Note($note))->response($request);
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl && is_string($returnUrl)) {
            return redirect($returnUrl);
        }

        return redirect(route(sprintf(
            '%1$s.show',
            $this->packageInfo['model_route']
        ), ['note' => $note->id]));
    }

    /**
     * Display a listing of Note resources.
     *
     * @route GET /resource/matrix playground.matrix.resource.notes
     */
    public function index(
        Requests\Note\IndexRequest $request
    ): JsonResponse|View|Resources\NoteCollection {

        $user = $request->user();

        $validated = $request->validated();

        $query = Note::addSelect(sprintf('%1$s.*', $this->packageInfo['table']));

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
            return (new Resources\NoteCollection($paginator))->response($request);
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
     * Restore the Note resource from the trash.
     *
     * @route PUT /resource/matrix/restore/{note} playground.matrix.resource.notes.restore
     */
    public function restore(
        Note $note,
        Requests\Note\RestoreRequest $request
    ): JsonResponse|RedirectResponse|Resources\Note {

        $validated = $request->validated();

        $user = $request->user();

        $note->restore();

        if ($request->expectsJson()) {
            return (new Resources\Note($note))->response($request);
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl && is_string($returnUrl)) {
            return redirect($returnUrl);
        }

        return redirect(route(sprintf(
            '%1$s.show',
            $this->packageInfo['model_route']
        ), ['note' => $note->id]));
    }

    /**
     * Display the Note resource.
     *
     * @route GET /resource/matrix/{note} playground.matrix.resource.notes.show
     */
    public function show(
        Note $note,
        Requests\Note\ShowRequest $request
    ): JsonResponse|View|Resources\Note {

        $validated = $request->validated();

        $user = $request->user();

        $meta = [
            'session_user_id' => $user?->id,
            'id' => $note->id,
            'timestamp' => Carbon::now()->toJson(),
            'validated' => $validated,
            'info' => $this->packageInfo,
        ];

        if ($request->expectsJson()) {
            return (new Resources\Note($note))->response($request);
        }

        $meta['input'] = $request->input();
        $meta['validated'] = $request->validated();

        $data = [
            'data' => $note,
            'meta' => $meta,
        ];

        return view(sprintf('%1$s/detail', $this->packageInfo['view']), $data);
    }

    /**
     * Store a newly created API Note resource in storage.
     *
     * @route POST /resource/matrix playground.matrix.resource.notes.post
     */
    public function store(
        Requests\Note\StoreRequest $request
    ): Response|JsonResponse|RedirectResponse|Resources\Note {

        $validated = $request->validated();

        $user = $request->user();

        $note = new Note($validated);

        $note->save();

        if ($request->expectsJson()) {
            return (new Resources\Note($note))->response($request);
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl && is_string($returnUrl)) {
            return redirect($returnUrl);
        }

        return redirect(route(sprintf(
            '%1$s.show',
            $this->packageInfo['model_route']
        ), ['note' => $note->id]));
    }

    /**
     * Unlock the Note resource in storage.
     *
     * @route DELETE /resource/matrix/lock/{note} playground.matrix.resource.notes.unlock
     */
    public function unlock(
        Note $note,
        Requests\Note\UnlockRequest $request
    ): JsonResponse|RedirectResponse|Resources\Note {

        $validated = $request->validated();

        $user = $request->user();

        $note->locked = false;

        $note->save();

        if ($request->expectsJson()) {
            return (new Resources\Note($note))->response($request);
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl && is_string($returnUrl)) {
            return redirect($returnUrl);
        }

        return redirect(route(sprintf(
            '%1$s.show',
            $this->packageInfo['model_route']
        ), ['note' => $note->id]));
    }

    /**
     * Update the Note resource in storage.
     *
     * @route PATCH /resource/matrix/{note} playground.matrix.resource.notes.patch
     */
    public function update(
        Note $note,
        Requests\Note\UpdateRequest $request
    ): JsonResponse|RedirectResponse|Resources\Note {

        $validated = $request->validated();

        $user = $request->user();

        $note->update($validated);

        if ($request->expectsJson()) {
            return (new Resources\Note($note))->response($request);
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl && is_string($returnUrl)) {
            return redirect($returnUrl);
        }

        return redirect(route(sprintf(
            '%1$s.show',
            $this->packageInfo['model_route']
        ), ['note' => $note->id]));
    }
}
