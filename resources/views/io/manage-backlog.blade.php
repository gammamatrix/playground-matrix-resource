<div class="card">
    <div class="card-header">
        @if (! empty($modelColumn) && ! empty($modelLabel))
            <a
                class="btn btn-info float-end"
                href="{{ route("playground.matrix.resource.backlogs.create", [$modelColumn => $data->id, "_return_url" => $routeShow]) }}"
                alt=" {{ __("Create a new backlog for the :model_label", ["model_label" => $modelLabel]) }}"
            >
                {{ __("Create") }}
            </a>
        @endif

        <h2>{{ __("Backlog") }}</h2>
    </div>

    @if ($data->backlog_id)
        @php
            $backlog = $data->backlog()->first();
        @endphp

        @if ($backlog)
            <div class="card-body">
                <a
                    href="{{ route("playground.matrix.resource.backlogs.show", ["backlog" => $backlog->id]) }}"
                    alt="{{ $backlog->description }}"
                >
                    {{ $backlog->title }}
                </a>
            </div>
            @if ($backlog->backlog_type)
                <div class="card-footer">
                    {{ $backlog->backlog_type }}
                </div>
            @endif
        @endif
    @elseif (! $data->locked && $routePatch)
        @php
            $backlogs = Playground\Matrix\Models\Backlog::all();
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
                    aria-label=" {{ __("Backlog Form") }}"
                >
                    <div class="input-group w-100">
                        <select
                            class="form-select"
                            aria-label=" {{ __("set the backlog") }}"
                            name="backlog_id"
                            required
                        >
                            <option selected value="">
                                {{ __("set the backlog") }}
                            </option>
                            @foreach ($backlogs as $backlog)
                                <option value="{{ $backlog->id }}">
                                    {{ $backlog->title ?: $backlog->label }}
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
