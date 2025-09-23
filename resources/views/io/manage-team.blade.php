<div class="card">
    <div class="card-header">
        @if (! empty($modelColumn) && ! empty($modelLabel))
            <a
                class="btn btn-info float-end"
                href="{{ route("playground.matrix.resource.teams.create", [$modelColumn => $data->id, "_return_url" => $routeShow]) }}"
                alt=" {{ __("Create a new team for the :model_label", ["model_label" => $modelLabel]) }}"
            >
                {{ __("Create") }}
            </a>
        @endif

        <h2>{{ __("Team") }}</h2>
    </div>

    @if ($data->team_id)
        @php
            $team = $data->team()->first();
        @endphp

        @if ($team)
            <div class="card-body">
                <a
                    href="{{ route("playground.matrix.resource.teams.show", ["team" => $team->id]) }}"
                    alt="{{ $team->description }}"
                >
                    {{ $team->title }}
                </a>
            </div>
            @if ($team->team_type)
                <div class="card-footer">
                    {{ $team->team_type }}
                </div>
            @endif
        @endif
    @elseif (! $data->locked && $routePatch)
        @php
            $teams = Playground\Matrix\Models\Team::all();
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
                    aria-label="{{ __("Team Form") }}"
                >
                    <div class="input-group w-100">
                        <select
                            class="form-select"
                            aria-label="{{ __("set the team") }}"
                            name="team_id"
                            required
                        >
                            <option selected value="">
                                {{ __("set the team") }}
                            </option>
                            @foreach ($teams as $team)
                                <option value="{{ $team->id }}">
                                    {{ $team->title ?: $team->label }}
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
