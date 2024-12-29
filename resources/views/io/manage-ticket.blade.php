<div class="card">

    <div class="card-header">
        @if(!empty($modelColumn) && !empty($modelLabel))
        <a class="btn btn-info float-end" href="{{route('playground.matrix.resource.tickets.create', [$modelColumn => $data->id, '_return_url' => $routeShow])}}" alt=" {{ __('Create a new ticket for the :model_label', ['model_label' => $modelLabel]) }}">
            {{ __('Create') }}
        </a>
        @endif
        <h2>{{ __('Ticket') }}</h2>
    </div>

    @if($data->ticket_id)

    @php $ticket = $data->ticket()->first() @endphp

    @if($ticket)
    <div class="card-body">
        <a href="{{route('playground.matrix.resource.tickets.show', ['ticket' => $ticket->id])}}" alt="{{$ticket->description}}">
            {{$ticket->title}}
        </a>
    </div>
    @if($ticket->ticket_type)
    <div class="card-footer">
        {{$ticket->ticket_type}}
    </div>
    @endif
    @endif

    @elseif(!$data->locked && $routePatch)

    @php $tickets = Playground\Matrix\Models\Ticket::all() @endphp

    <div class="card-body">
        <form method="POST" action="{{ $routePatch }}" novalidate class="needs-validation">
            @csrf
            @method('patch')
            <div class="btn-toolbar mb-3" role="toolbar" aria-label="{{ __('Ticket Form') }}">
                <div class="input-group w-100">
                    <select class="form-select" aria-label="{{ __('set the ticket') }}" name="ticket_id" required>
                        <option selected value="">{{ __('set the ticket') }}</option>
                        @foreach ($tickets as $ticket)
                        <option value="{{$ticket->id}}">{{$ticket->title ?: $ticket->label }}</option>
                        @endforeach
                    </select>
                    <button class="btn btn-success" role="button">
                        {{ __('Save') }}
                    </button>
                </div>
            </div>
        </form>
    </div>

    @endif
</div>