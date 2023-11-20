<?php
/**
 * GammaMatrix
 */

namespace GammaMatrix\Playground\Matrix\Resource\Http\Controllers;

use GammaMatrix\Playground\Http\Controllers\Controller;
use GammaMatrix\Playground\Matrix\Models\Ticket;
use GammaMatrix\Playground\Matrix\Resource\Http\Requests\Ticket\CreateRequest;
use GammaMatrix\Playground\Matrix\Resource\Http\Requests\Ticket\DestroyRequest;
use GammaMatrix\Playground\Matrix\Resource\Http\Requests\Ticket\EditRequest;
use GammaMatrix\Playground\Matrix\Resource\Http\Requests\Ticket\IndexRequest;
use GammaMatrix\Playground\Matrix\Resource\Http\Requests\Ticket\LockRequest;
use GammaMatrix\Playground\Matrix\Resource\Http\Requests\Ticket\RestoreRequest;
use GammaMatrix\Playground\Matrix\Resource\Http\Requests\Ticket\ShowRequest;
use GammaMatrix\Playground\Matrix\Resource\Http\Requests\Ticket\StoreRequest;
use GammaMatrix\Playground\Matrix\Resource\Http\Requests\Ticket\UnlockRequest;
use GammaMatrix\Playground\Matrix\Resource\Http\Requests\Ticket\UpdateRequest;
use GammaMatrix\Playground\Matrix\Resource\Http\Resources\Ticket\Ticket as TicketResource;
use GammaMatrix\Playground\Matrix\Resource\Http\Resources\Ticket\TicketCollection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * \GammaMatrix\Playground\Matrix\Resource\Http\Controllers\TicketController
 */
class TicketController extends Controller
{
    public array $packageInfo = [
        'model_attribute'     => 'label',
        'model_label'         => 'Ticket',
        'model_label_plural'  => 'Tickets',
        'model_route'         => 'playground.matrix.resource.tickets',
        'model_slug'          => 'ticket',
        'model_slug_plural'   => 'tickets',
        'module_label'        => 'Matrix',
        'module_label_plural' => 'Matrices',
        'module_route'        => 'playground.matrix.resource',
        'module_slug'         => 'matrix',
        'privilege'           => 'playground-matrix-resource:ticket',
        'table'               => 'matrix_tickets',
        'view'                => 'playground-matrix-resource::ticket',
    ];

    /**
     * CREATE the Ticket resource in storage.
     *
     * @route GET /resource/matrix/tickets/create playground.matrix.resource.tickets.create
     */
    public function create(
        CreateRequest $request
    ): JsonResponse|View {
        $validated = $request->validated();

        $user = $request->user();

        $ticket = new Ticket($validated);

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
            'data' => $ticket,
            'meta' => $meta,
            '_method' => 'post',
        ];

        if ($request->expectsJson()) {
            return response()->json($data);
        }

        $flash = $ticket->toArray();

        if (!empty($validated['_return_url'])) {
            $flash['_return_url'] = $validated['_return_url'];
            $data['_return_url'] = $validated['_return_url'];
        }

        if (!$request->session()->has('errors')) {
            session()->flashInput($flash);
        }

        return view(
            'playground-matrix-resource::ticket/form',
            $data
        );
    }

    /**
     * Edit the Ticket resource in storage.
     *
     * @route GET /resource/matrix/tickets/edit playground.matrix.resource.tickets.edit
     */
    public function edit(
        Ticket $ticket,
        EditRequest $request
    ): JsonResponse|View {
        $validated = $request->validated();

        $user = $request->user();

        $meta = [
            'session_user_id' => $user->id,
            'id'              => $ticket->id,
            'timestamp'       => Carbon::now()->toJson(),
            'validated'       => $validated,
            'info'            => $this->packageInfo,
        ];

        $meta['input'] = $request->input();
        $meta['validated'] = $request->validated();

        $data = [
            'data' => $ticket,
            'meta' => $meta,
            '_method' => 'patch',
        ];

        if ($request->expectsJson()) {
            return response()->json($data);
        }

        $flash = $ticket->toArray();

        if (!empty($validated['_return_url'])) {
            $flash['_return_url'] = $validated['_return_url'];
            $data['_return_url'] = $validated['_return_url'];
        }

        session()->flashInput($flash);

        return view(
            'playground-matrix-resource::ticket/form',
            $data
        );
    }

    /**
     * Remove the Ticket resource from storage.
     *
     * @route DELETE /resource/matrix/{ticket} playground.matrix.resource.tickets.destroy
     */
    public function destroy(
        Ticket $ticket,
        DestroyRequest $request
    ): Response|RedirectResponse {
        $validated = $request->validated();

        if (empty($validated['force'])) {
            $ticket->delete();
        } else {
            $ticket->forceDelete();
        }

        if ($request->expectsJson()) {
            return response()->noContent();
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl) {
            return redirect($returnUrl);
        }

        return redirect(route('playground.matrix.resource.tickets'));
    }

    /**
     * Lock the Ticket resource in storage.
     *
     * @route PUT /resource/matrix/{ticket} playground.matrix.resource.tickets.lock
     */
    public function lock(
        Ticket $ticket,
        LockRequest $request
    ): JsonResponse|RedirectResponse {
        $validated = $request->validated();

        $user = $request->user();

        $ticket->locked = true;

        $ticket->save();

        $meta = [
            'session_user_id' => $user->id,
            'id'              => $ticket->id,
            'timestamp'       => Carbon::now()->toJson(),
            'info'            => $this->packageInfo,
        ];

        if ($request->expectsJson()) {
            return new TicketResource($ticket);
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl) {
            return redirect($returnUrl);
        }

        return redirect(route('playground.matrix.resource.tickets.show', ['ticket' => $ticket->id]));
    }

    /**
     * Display a listing of Ticket resources.
     *
     * @route GET /resource/matrix playground.matrix.resource.tickets
     */
    public function index(
        IndexRequest $request
    ): JsonResponse|View {
        $user = $request->user();

        $validated = $request->validated();

        $query = Ticket::addSelect(sprintf('%1$s.*', $this->packageInfo['table']));

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
            return (new TicketCollection($paginator))->additional(['meta' => [
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
            'playground-matrix-resource::ticket/index',
            $data
        );
    }

    /**
     * Restore the Ticket resource from the trash.
     *
     * @route PUT /resource/matrix/restore/{ticket} playground.matrix.resource.tickets.restore
     */
    public function restore(
        Ticket $ticket,
        RestoreRequest $request
    ): JsonResponse|RedirectResponse {
        $validated = $request->validated();

        $user = $request->user();

        $ticket->restore();

        if ($request->expectsJson()) {
            return new TicketResource($ticket);
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl) {
            return redirect($returnUrl);
        }

        return redirect(route('playground.matrix.resource.tickets.show', ['ticket' => $ticket->id]));
    }

    /**
     * Display the Ticket resource.
     *
     * @route GET /resource/matrix/{ticket} playground.matrix.resource.tickets.show
     */
    public function show(
        Ticket $ticket,
        ShowRequest $request
    ): JsonResponse|View {
        $validated = $request->validated();

        $user = $request->user();

        $meta = [
            'session_user_id' => $user->id,
            'id'              => $ticket->id,
            'timestamp'       => Carbon::now()->toJson(),
            'validated'       => $validated,
            'info'            => $this->packageInfo,
        ];

        if ($request->expectsJson()) {
            return new TicketResource($ticket);
        }

        $meta['input'] = $request->input();
        $meta['validated'] = $request->validated();

        $data = [
            'data' => $ticket,
            'meta' => $meta,
        ];

        return view(
            'playground-matrix-resource::ticket/detail',
            $data
        );
    }

   /**
     * Store a newly created API Ticket resource in storage.
     *
     * @route POST /resource/matrix playground.matrix.resource.tickets.post
     */
    public function store(
        StoreRequest $request
    ): Response|JsonResponse|RedirectResponse {
        $validated = $request->validated();

        $user = $request->user();

        $ticket = new Ticket($validated);

        $ticket->save();

        if ($request->expectsJson()) {
            return new TicketResource($ticket);
        }

        $returnUrl = $validated['return_url'] ?? '';

        if ($returnUrl) {
            return redirect($returnUrl);
        }

        return redirect(route('playground.matrix.resource.tickets.show', ['ticket' => $ticket->id]));
    }

    /**
     * Unlock the Ticket resource in storage.
     *
     * @route DELETE /resource/matrix/lock/{ticket} playground.matrix.resource.tickets.unlock
     */
    public function unlock(
        Ticket $ticket,
        UnlockRequest $request
    ): JsonResponse|RedirectResponse {
        $validated = $request->validated();

        $user = $request->user();

        $ticket->locked = false;

        $ticket->save();

        if ($request->expectsJson()) {
            return new TicketResource($ticket);
        }

        $returnUrl = $validated['return_url'] ?? '';

        if ($returnUrl) {
            return redirect($returnUrl);
        }

        return redirect(route('playground.matrix.resource.tickets.show', ['ticket' => $ticket->id]));
    }

    /**
     * Update the Ticket resource in storage.
     *
     * @route PATCH /resource/matrix/{ticket} playground.matrix.resource.tickets.patch
     */
    public function update(
        Ticket $ticket,
        UpdateRequest $request
    ): JsonResponse|RedirectResponse {
        $validated = $request->validated();

        $user = $request->user();

        $ticket->update($validated);

        if ($request->expectsJson()) {
            return new TicketResource($ticket);
        }

        $returnUrl = $validated['return_url'] ?? '';

        if ($returnUrl) {
            return redirect($returnUrl);
        }

        return redirect(route('playground.matrix.resource.tickets.show', ['ticket' => $ticket->id]));
    }
}
