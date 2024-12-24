<div class="card">

    <div class="card-header">
        @if(!empty($modelColumn) && !empty($modelLabel))
        <a class="btn btn-info float-end" href="{{route('playground.matrix.resource.sprints.create', [$modelColumn => $data->id, '_return_url' => $routeShow])}}" alt=" {{ __('Create a new sprint for the :model_label', ['model_label' => $modelLabel]) }}">
            {{ __('Create') }}
        </a>
        @endif
        <h2>{{ __('Sprint') }}</h2>
    </div>

    @if($data->sprint_id)

    @php $sprint = $data->sprint()->first() @endphp

    @if($sprint)
    <div class="card-body">
        <a href="{{route('playground.matrix.resource.sprints.show', ['sprint' => $sprint->id])}}" alt="{{$sprint->description}}">
            {{$sprint->title}}
        </a>
    </div>
    @if($sprint->sprint_type)
    <div class="card-footer">
        {{$sprint->sprint_type}}
    </div>
    @endif
    @endif

    @elseif(!$data->locked && $routePatch)

    @php $sprints = Playground\Matrix\Models\Sprint::all() @endphp

    <div class="card-body">
        <form method="POST" action="{{ $routePatch }}" novalidate class="needs-validation">
            @csrf
            @method('patch')
            <div class="btn-toolbar mb-3" role="toolbar" aria-label="{{ __('Sprint Form') }}">
                <div class="input-group w-100">
                    <select class="form-select" aria-label="{{ __('set the sprint') }}" name="sprint_id" required>
                        <option selected value="">{{ __('set the sprint') }}</option>
                        @foreach ($sprints as $sprint)
                        <option value="{{$sprint->id}}">{{$sprint->title ?: $sprint->label }}</option>
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