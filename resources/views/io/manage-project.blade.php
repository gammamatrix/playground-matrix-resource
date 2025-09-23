<div class="card">
    <div class="card-header">
        @if (! empty($modelColumn) && ! empty($modelLabel))
            <a
                class="btn btn-info float-end"
                href="{{ route("playground.matrix.resource.projects.create", [$modelColumn => $data->id, "_return_url" => $routeShow]) }}"
                alt=" {{ __("Create a new project for the :model_label", ["model_label" => $modelLabel]) }}"
            >
                {{ __("Create") }}
            </a>
        @endif

        <h2>Project</h2>
    </div>

    @if ($data->project_id)
        @php
            $project = $data->project()->first();
        @endphp

        @if ($project)
            <div class="card-body">
                <a
                    href="{{ route("playground.matrix.resource.projects.show", ["project" => $project->id]) }}"
                    alt="{{ $project->description }}"
                >
                    {{ $project->title }}
                </a>
            </div>
            @if ($project->project_type)
                <div class="card-footer">
                    {{ $project->project_type }}
                </div>
            @endif
        @endif
    @elseif (! $data->locked && $routePatch)
        @php
            $projects = Playground\Matrix\Models\Project::all();
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
                    aria-label="Project Form"
                >
                    <div class="input-group w-100">
                        <select
                            class="form-select"
                            aria-label="Set the project"
                            name="project_id"
                            required
                        >
                            <option selected value="">set the project</option>
                            @foreach ($projects as $project)
                                <option value="{{ $project->id }}">
                                    {{ $project->title ?: $project->label }}
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
