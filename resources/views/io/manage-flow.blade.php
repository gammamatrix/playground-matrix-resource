<div class="card">
    <div class="card-header">
        @if (! empty($modelColumn) && ! empty($modelLabel))
            <a
                class="btn btn-info float-end"
                href="{{ route("playground.matrix.resource.flows.create", [$modelColumn => $data->id, "_return_url" => $routeShow]) }}"
                alt=" {{ __("Create a new flow for the :model_label", ["model_label" => $modelLabel]) }}"
            >
                {{ __("Create") }}
            </a>
        @endif

        <h2>Flow</h2>
    </div>

    @if ($data->flow_id)
        @php
            $flow = $data->flow()->first();
        @endphp

        @if ($flow)
            <div class="card-body">
                <a
                    href="{{ route("playground.matrix.resource.flows.show", ["flow" => $flow->id]) }}"
                    alt="{{ $flow->description }}"
                >
                    {{ $flow->title }}
                </a>
            </div>
            @if ($flow->flow_type)
                <div class="card-footer">
                    {{ $flow->flow_type }}
                </div>
            @endif
        @endif
    @elseif (! $data->locked && $routePatch)
        @php
            $flows = Playground\Matrix\Models\Flow::all();
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
                    aria-label="Flow Form"
                >
                    <div class="input-group w-100">
                        <select
                            class="form-select"
                            aria-label="Set the flow"
                            name="flow_id"
                            required
                        >
                            <option selected value="">set the flow</option>
                            @foreach ($flows as $flow)
                                <option value="{{ $flow->id }}">
                                    {{ $flow->title ?: $flow->label }}
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
