<div class="card">
    <div class="card-header">
        <h2>{{ __("Duplicate") }}</h2>
    </div>

    @if ($data->ticket_id)
        @php
            $ticket = $data->duplicate()->first();
        @endphp

        @if ($ticket)
            <div class="card-body">
                <a
                    href="{{ route("playground.matrix.resource.tickets.show", ["ticket" => $ticket->id]) }}"
                    alt="{{ $ticket->description }}"
                >
                    {{ $ticket->title }}
                </a>
            </div>
            @if ($ticket->ticket_type)
                <div class="card-footer">
                    {{ $ticket->ticket_type }}
                </div>
            @endif
        @endif
    @elseif (! $data->locked && $routePatch)
        @php
            $duplicates = Playground\Matrix\Models\Ticket::all();
        @endphp

        <div class="card-body">
            <form
                method="POST"
                action="{{ $routePatch }}"
                novalidate
                class="needs-validation"
            >
                @csrf
                @method("patch")
                <div
                    class="btn-toolbar mb-3"
                    role="toolbar"
                    aria-label="{{ __("Ticket Form") }}"
                >
                    <div class="input-group w-100">
                        <select
                            class="form-select"
                            aria-label="{{ __("set the duplicate") }}"
                            name="duplicate_id"
                            required
                        >
                            <option selected value="">
                                {{ __("set the ticket") }}
                            </option>
                            @foreach ($duplicates as $duplicate)
                                <option value="{{ $duplicate->id }}">
                                    {{ $duplicate->title ?: $duplicate->label }}
                                </option>
                            @endforeach
                        </select>
                        <button class="btn btn-success" role="button">
                            {{ __("Save") }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    @endif
</div>
