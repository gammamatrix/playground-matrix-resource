<div class="card">
    <div class="card-header">
        @if (! empty($modelColumn) && ! empty($modelLabel))
            <a
                class="btn btn-info float-end"
                href="{{ route("playground.matrix.resource.sources.create", [$modelColumn => $data->id, "_return_url" => $routeShow]) }}"
                alt=" {{ __("Create a new source for the :model_label", ["model_label" => $modelLabel]) }}"
            >
                {{ __("Create") }}
            </a>
        @endif

        <h2>{{ __("Source") }}</h2>
    </div>

    @if ($data->source_id)
        @php
            $source = $data->source()->first();
        @endphp

        @if ($source)
            <div class="card-body">
                <a
                    href="{{ route("playground.matrix.resource.sources.show", ["source" => $source->id]) }}"
                    alt="{{ $source->description }}"
                >
                    {{ $source->title }}
                </a>
            </div>
            @if ($source->source_type)
                <div class="card-footer">
                    {{ $source->source_type }}
                </div>
            @endif
        @endif
    @elseif (! $data->locked && $routePatch)
        @php
            $sources = Playground\Matrix\Models\Source::all();
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
                    aria-label="{{ __("Source Form") }}"
                >
                    <div class="input-group w-100">
                        <select
                            class="form-select"
                            aria-label="{{ __("set the source") }}"
                            name="source_id"
                            required
                        >
                            <option selected value="">
                                {{ __("set the source") }}
                            </option>
                            @foreach ($sources as $source)
                                <option value="{{ $source->id }}">
                                    {{ $source->title ?: $source->label }}
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
