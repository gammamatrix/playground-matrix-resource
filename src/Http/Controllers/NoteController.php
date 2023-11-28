<?php
/**
 * GammaMatrix
 */

namespace GammaMatrix\Playground\Matrix\Resource\Http\Controllers;

use GammaMatrix\Playground\Http\Controllers\Controller;
use GammaMatrix\Playground\Matrix\Models\Note;
use GammaMatrix\Playground\Matrix\Resource\Http\Requests\Note\CreateRequest;
use GammaMatrix\Playground\Matrix\Resource\Http\Requests\Note\DestroyRequest;
use GammaMatrix\Playground\Matrix\Resource\Http\Requests\Note\EditRequest;
use GammaMatrix\Playground\Matrix\Resource\Http\Requests\Note\IndexRequest;
use GammaMatrix\Playground\Matrix\Resource\Http\Requests\Note\LockRequest;
use GammaMatrix\Playground\Matrix\Resource\Http\Requests\Note\RestoreRequest;
use GammaMatrix\Playground\Matrix\Resource\Http\Requests\Note\ShowRequest;
use GammaMatrix\Playground\Matrix\Resource\Http\Requests\Note\StoreRequest;
use GammaMatrix\Playground\Matrix\Resource\Http\Requests\Note\UnlockRequest;
use GammaMatrix\Playground\Matrix\Resource\Http\Requests\Note\UpdateRequest;
use GammaMatrix\Playground\Matrix\Resource\Http\Resources\Note\Note as NoteResource;
use GammaMatrix\Playground\Matrix\Resource\Http\Resources\Note\NoteCollection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * \GammaMatrix\Playground\Matrix\Resource\Http\Controllers\NoteController
 */
class NoteController extends Controller
{
    public array $packageInfo = [
        'model_attribute'     => 'label',
        'model_label'         => 'Note',
        'model_label_plural'  => 'Notes',
        'model_route'         => 'playground.matrix.resource.notes',
        'model_slug'          => 'note',
        'model_slug_plural'   => 'notes',
        'module_label'        => 'Matrix',
        'module_label_plural' => 'Matrices',
        'module_route'        => 'playground.matrix.resource',
        'module_slug'         => 'matrix',
        'privilege'           => 'playground-matrix-resource:note',
        'table'               => 'matrix_notes',
        'view'                => 'playground-matrix-resource::note',
    ];

    /**
     * CREATE the Note resource in storage.
     *
     * @route GET /resource/matrix/notes/create playground.matrix.resource.notes.create
     */
    public function create(
        CreateRequest $request
    ): JsonResponse|View {
        $validated = $request->validated();

        $user = $request->user();

        $note = new Note($validated);

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
            'data' => $note,
            'meta' => $meta,
            '_method' => 'post',
        ];

        if ($request->expectsJson()) {
            return response()->json($data);
        }

        $flash = $note->toArray();

        if (!empty($validated['_return_url'])) {
            $flash['_return_url'] = $validated['_return_url'];
            $data['_return_url'] = $validated['_return_url'];
        }

        if (!$request->session()->has('errors')) {
            session()->flashInput($flash);
        }

        return view(
            'playground-matrix-resource::note/form',
            $data
        );
    }

    /**
     * Edit the Note resource in storage.
     *
     * @route GET /resource/matrix/notes/edit playground.matrix.resource.notes.edit
     */
    public function edit(
        Note $note,
        EditRequest $request
    ): JsonResponse|View {
        $validated = $request->validated();

        $user = $request->user();

        $meta = [
            'session_user_id' => $user->id,
            'id'              => $note->id,
            'timestamp'       => Carbon::now()->toJson(),
            'validated'       => $validated,
            'info'            => $this->packageInfo,
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

        if (!empty($validated['_return_url'])) {
            $flash['_return_url'] = $validated['_return_url'];
            $data['_return_url'] = $validated['_return_url'];
        }

        session()->flashInput($flash);

        return view(
            'playground-matrix-resource::note/form',
            $data
        );
    }

    /**
     * Remove the Note resource from storage.
     *
     * @route DELETE /resource/matrix/{note} playground.matrix.resource.notes.destroy
     */
    public function destroy(
        Note $note,
        DestroyRequest $request
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

        if ($returnUrl) {
            return redirect($returnUrl);
        }

        return redirect(route('playground.matrix.resource.notes'));
    }

    /**
     * Lock the Note resource in storage.
     *
     * @route PUT /resource/matrix/{note} playground.matrix.resource.notes.lock
     */
    public function lock(
        Note $note,
        LockRequest $request
    ): JsonResponse|RedirectResponse {
        $validated = $request->validated();

        $user = $request->user();

        $note->locked = true;

        $note->save();

        $meta = [
            'session_user_id' => $user->id,
            'id'              => $note->id,
            'timestamp'       => Carbon::now()->toJson(),
            'info'            => $this->packageInfo,
        ];

        if ($request->expectsJson()) {
            return new NoteResource($note);
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl) {
            return redirect($returnUrl);
        }

        return redirect(route('playground.matrix.resource.notes.show', ['note' => $note->id]));
    }

    /**
     * Display a listing of Note resources.
     *
     * @route GET /resource/matrix playground.matrix.resource.notes
     */
    public function index(
        IndexRequest $request
    ): JsonResponse|View {
        $user = $request->user();

        $validated = $request->validated();

        $query = Note::addSelect(sprintf('%1$s.*', $this->packageInfo['table']));

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
            return (new NoteCollection($paginator))->additional(['meta' => [
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
            'playground-matrix-resource::note/index',
            $data
        );
    }

    /**
     * Restore the Note resource from the trash.
     *
     * @route PUT /resource/matrix/restore/{note} playground.matrix.resource.notes.restore
     */
    public function restore(
        Note $note,
        RestoreRequest $request
    ): JsonResponse|RedirectResponse {
        $validated = $request->validated();

        $user = $request->user();

        $note->restore();

        if ($request->expectsJson()) {
            return new NoteResource($note);
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl) {
            return redirect($returnUrl);
        }

        return redirect(route('playground.matrix.resource.notes.show', ['note' => $note->id]));
    }

    /**
     * Display the Note resource.
     *
     * @route GET /resource/matrix/{note} playground.matrix.resource.notes.show
     */
    public function show(
        Note $note,
        ShowRequest $request
    ): JsonResponse|View {
        $validated = $request->validated();

        $user = $request->user();

        $meta = [
            'session_user_id' => $user->id,
            'id'              => $note->id,
            'timestamp'       => Carbon::now()->toJson(),
            'validated'       => $validated,
            'info'            => $this->packageInfo,
        ];

        if ($request->expectsJson()) {
            return new NoteResource($note);
        }

        $meta['input'] = $request->input();
        $meta['validated'] = $request->validated();

        $data = [
            'data' => $note,
            'meta' => $meta,
        ];

        return view(
            'playground-matrix-resource::note/detail',
            $data
        );
    }

    /**
      * Store a newly created API Note resource in storage.
      *
      * @route POST /resource/matrix playground.matrix.resource.notes.post
      */
    public function store(
        StoreRequest $request
    ): Response|JsonResponse|RedirectResponse {
        $validated = $request->validated();

        $user = $request->user();

        $note = new Note($validated);

        $note->save();

        if ($request->expectsJson()) {
            return new NoteResource($note);
        }

        $returnUrl = $validated['return_url'] ?? '';

        if ($returnUrl) {
            return redirect($returnUrl);
        }

        return redirect(route('playground.matrix.resource.notes.show', ['note' => $note->id]));
    }

    /**
     * Unlock the Note resource in storage.
     *
     * @route DELETE /resource/matrix/lock/{note} playground.matrix.resource.notes.unlock
     */
    public function unlock(
        Note $note,
        UnlockRequest $request
    ): JsonResponse|RedirectResponse {
        $validated = $request->validated();

        $user = $request->user();

        $note->locked = false;

        $note->save();

        if ($request->expectsJson()) {
            return new NoteResource($note);
        }

        $returnUrl = $validated['return_url'] ?? '';

        if ($returnUrl) {
            return redirect($returnUrl);
        }

        return redirect(route('playground.matrix.resource.notes.show', ['note' => $note->id]));
    }

    /**
     * Update the Note resource in storage.
     *
     * @route PATCH /resource/matrix/{note} playground.matrix.resource.notes.patch
     */
    public function update(
        Note $note,
        UpdateRequest $request
    ): JsonResponse|RedirectResponse {
        $validated = $request->validated();

        $user = $request->user();

        $note->update($validated);

        if ($request->expectsJson()) {
            return new NoteResource($note);
        }

        $returnUrl = $validated['return_url'] ?? '';

        if ($returnUrl) {
            return redirect($returnUrl);
        }

        return redirect(route('playground.matrix.resource.notes.show', ['note' => $note->id]));
    }
}
