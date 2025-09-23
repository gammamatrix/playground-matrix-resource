<div class="card">
    <div class="card-header">
        @if (! empty($modelColumn) && ! empty($modelLabel))
            <a
                class="btn btn-info float-end"
                href="{{ route("playground.matrix.resource.roadmaps.create", [$modelColumn => $data->id, "_return_url" => $routeShow]) }}"
                alt=" {{ __("Create a new roadmap for the :model_label", ["model_label" => $modelLabel]) }}"
            >
                {{ __("Create") }}
            </a>
        @endif

        <h2>{{ __("Roadmap") }}</h2>
    </div>

    @if ($data->roadmap_id)
        @php
            $roadmap = $data->roadmap()->first();
        @endphp

        @if ($roadmap)
            <div class="card-body">
                <a
                    href="{{ route("playground.matrix.resource.roadmaps.show", ["roadmap" => $roadmap->id]) }}"
                    alt="{{ $roadmap->description }}"
                >
                    {{ $roadmap->title }}
                </a>
            </div>
            @if ($roadmap->roadmap_type)
                <div class="card-footer">
                    {{ $roadmap->roadmap_type }}
                </div>
            @endif
        @endif
    @elseif (! $data->locked && $routePatch)
        @php
            $roadmaps = Playground\Matrix\Models\Roadmap::all();
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
                    aria-label="{{ __("Roadmap Form") }}"
                >
                    <div class="input-group w-100">
                        <select
                            class="form-select"
                            aria-label="{{ __("v") }}"
                            name="roadmap_id"
                            required
                        >
                            <option selected value="">
                                {{ __("set the roadmap") }}
                            </option>
                            @foreach ($roadmaps as $roadmap)
                                <option value="{{ $roadmap->id }}">
                                    {{ $roadmap->title ?: $roadmap->label }}
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
