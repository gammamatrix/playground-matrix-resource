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
use Playground\Matrix\Concerns\Creating;
use Playground\Matrix\Models\Ticket;
use Playground\Matrix\Resource\Http\Requests;
use Playground\Matrix\Resource\Http\Resources;

/**
 * \Playground\Matrix\Resource\Http\Controllers\TicketController
 */
class TicketController extends Controller
{
    use Creating;

    /**
     * @var array<string, string>
     */
    public array $packageInfo = [
        'model_attribute' => 'title',
        'model_label' => 'Ticket',
        'model_label_plural' => 'Tickets',
        'model_route' => 'playground.matrix.resource.tickets',
        'model_slug' => 'ticket',
        'model_slug_plural' => 'tickets',
        'module_label' => 'Matrix',
        'module_label_plural' => 'Matrices',
        'module_route' => 'playground.matrix.resource',
        'module_slug' => 'matrix',
        'privilege' => 'playground-matrix-resource:ticket',
        'table' => 'matrix_tickets',
        'view' => 'playground-matrix-resource::ticket',
    ];

    /**
     * Create the Ticket resource in storage.
     *
     * @route GET /resource/matrix/tickets/create playground.matrix.resource.tickets.create
     */
    public function create(
        Requests\Ticket\CreateRequest $request
    ): JsonResponse|View|Resources\Ticket {

        $packageInfo = $this->packageInfo();

        $validated = $request->validated();

        $ticket = new Ticket($validated);

        if ($request->expectsJson()) {
            return new Resources\Ticket($ticket)->additional(['meta' => [
                'info' => $packageInfo,
            ]])->response($request);
        }

        $user = $request->user();

        $meta = [
            'session_user_id' => $user?->id,
            'id' => null,
            'timestamp' => Carbon::now()->toJson(),
            'info' => $packageInfo,
        ];

        $data = [
            'data' => $ticket,
            'meta' => $meta,
            '_method' => 'post',
        ];

        $flash = $ticket->toArray();

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
     * Edit the Ticket resource in storage.
     *
     * @route GET /resource/matrix/tickets/edit/{ticket} playground.matrix.resource.tickets.edit
     */
    public function edit(
        Ticket $ticket,
        Requests\Ticket\EditRequest $request
    ): JsonResponse|View|Resources\Ticket {

        $packageInfo = $this->packageInfo();

        $validated = $request->validated();

        if ($request->expectsJson()) {
            return new Resources\Ticket($ticket)->additional(['meta' => [
                'info' => $packageInfo,
            ]])->response($request);
        }

        $user = $request->user();

        $flash = $ticket->toArray();

        if (! empty($validated['_return_url'])) {
            $flash['_return_url'] = $validated['_return_url'];
        }

        $meta = [
            'session_user_id' => $user?->id,
            'id' => $ticket->id,
            'timestamp' => Carbon::now()->toJson(),
            'info' => $packageInfo,
        ];

        $data = [
            'data' => $ticket,
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
     * Remove the Ticket resource from storage.
     *
     * @route DELETE /resource/matrix/tickets/{ticket} playground.matrix.resource.tickets.destroy
     */
    public function destroy(
        Ticket $ticket,
        Requests\Ticket\DestroyRequest $request
    ): Response|RedirectResponse {

        $packageInfo = $this->packageInfo();

        $validated = $request->validated();

        $user = $request->user();

        if ($user?->id) {
            $ticket->modified_by_id = $user->id;
        }

        if (empty($validated['force'])) {
            $ticket->delete();
        } else {
            $ticket->forceDelete();
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
     * Lock the Ticket resource in storage.
     *
     * @route PUT /resource/matrix/tickets/{ticket} playground.matrix.resource.tickets.lock
     */
    public function lock(
        Ticket $ticket,
        Requests\Ticket\LockRequest $request
    ): JsonResponse|RedirectResponse|Resources\Ticket {

        $packageInfo = $this->packageInfo();

        $validated = $request->validated();

        $user = $request->user();

        if ($user?->id) {
            $ticket->modified_by_id = $user->id;
        }

        $ticket->locked = true;

        $ticket->save();

        if ($request->expectsJson()) {
            return new Resources\Ticket($ticket)->additional(['meta' => [
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
        ), ['ticket' => $ticket->id]));
    }

    /**
     * Display a listing of Ticket resources.
     *
     * @route GET /resource/matrix/tickets playground.matrix.resource.tickets
     */
    public function index(
        Requests\Ticket\IndexRequest $request
    ): JsonResponse|View|Resources\TicketCollection {

        $packageInfo = $this->packageInfo();

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

        $query = Ticket::addSelect(sprintf('%1$s.*', $packageInfo->table()));

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
            return new Resources\TicketCollection($paginator)->response($request);
        }

        $user = $request->user();

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
     * Restore the Ticket resource from the trash.
     *
     * @route PUT /resource/matrix/tickets/restore/{ticket} playground.matrix.resource.tickets.restore
     */
    public function restore(
        Ticket $ticket,
        Requests\Ticket\RestoreRequest $request
    ): JsonResponse|RedirectResponse|Resources\Ticket {

        $packageInfo = $this->packageInfo();

        $validated = $request->validated();

        $user = $request->user();

        $ticket->modified_by_id = $user?->id;

        $ticket->restore();

        if ($request->expectsJson()) {
            return new Resources\Ticket($ticket)->additional(['meta' => [
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
        ), ['ticket' => $ticket->id]));
    }

    /**
     * Display the Ticket resource.
     *
     * @route GET /resource/matrix/tickets/{ticket} playground.matrix.resource.tickets.show
     */
    public function show(
        Ticket $ticket,
        Requests\Ticket\ShowRequest $request
    ): JsonResponse|View|Resources\Ticket {

        $packageInfo = $this->packageInfo();

        if ($request->expectsJson()) {
            return new Resources\Ticket($ticket)->additional(['meta' => [
                'info' => $packageInfo,
            ]])->response($request);
        }

        $user = $request->user();

        $meta = [
            'session_user_id' => $user?->id,
            'id' => $ticket->id,
            'timestamp' => Carbon::now()->toJson(),
            'info' => $packageInfo,
        ];

        $data = [
            'data' => $ticket,
            'meta' => $meta,
        ];

        /**
         * @var view-string $view
         */
        $view = sprintf('%1$s/detail', $packageInfo->view());

        return view($view, $data);
    }

    /**
     * Store a newly created API Ticket resource in storage.
     *
     * @route POST /resource/matrix/tickets playground.matrix.resource.tickets.post
     */
    public function store(
        Requests\Ticket\StoreRequest $request
    ): Response|JsonResponse|RedirectResponse|Resources\Ticket {

        $packageInfo = $this->packageInfo();

        $validated = $request->validated();

        $user = $request->user();

        $ticket = new Ticket($validated);

        $ticket->created_by_id = $user?->id;

        $this->handleTicketCode($ticket);

        $ticket->save();

        if ($request->expectsJson()) {
            return new Resources\Ticket($ticket)->additional(['meta' => [
                'info' => $packageInfo,
            ]])->response($request)->setStatusCode(201);
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl && is_string($returnUrl)) {
            return redirect($returnUrl);
        }

        return redirect(route(sprintf(
            '%1$s.show',
            $packageInfo->model_route()
        ), ['ticket' => $ticket->id]));
    }

    /**
     * Unlock the Ticket resource in storage.
     *
     * @route DELETE /resource/matrix/tickets/lock/{ticket} playground.matrix.resource.tickets.unlock
     */
    public function unlock(
        Ticket $ticket,
        Requests\Ticket\UnlockRequest $request
    ): JsonResponse|RedirectResponse|Resources\Ticket {

        $packageInfo = $this->packageInfo();

        $validated = $request->validated();

        $user = $request->user();

        $ticket->locked = false;

        $ticket->modified_by_id = $user?->id;

        $ticket->save();

        if ($request->expectsJson()) {
            return new Resources\Ticket($ticket)->additional(['meta' => [
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
        ), ['ticket' => $ticket->id]));
    }

    /**
     * Update the Ticket resource in storage.
     *
     * @route PATCH /resource/matrix/tickets/{ticket} playground.matrix.resource.tickets.patch
     */
    public function update(
        Ticket $ticket,
        Requests\Ticket\UpdateRequest $request
    ): JsonResponse|RedirectResponse|Resources\Ticket {

        $packageInfo = $this->packageInfo();

        $validated = $request->validated();

        $user = $request->user();

        $ticket->modified_by_id = $user?->id;

        $ticket->update($validated);

        if ($request->expectsJson()) {
            return new Resources\Ticket($ticket)->additional(['meta' => [
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
        ), ['ticket' => $ticket->id]));
    }
}
