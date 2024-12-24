<div class="card">

    <div class="card-header">
        @if(!empty($modelColumn) && !empty($modelLabel))
        <a class="btn btn-info float-end" href="{{route('playground.matrix.resource.milestones.create', [$modelColumn => $data->id, '_return_url' => $routeShow])}}" alt=" {{ __('Create a new milestone for the :model_label', ['model_label' => $modelLabel]) }}">
            {{ __('Create') }}
        </a>
        @endif
        <h2>Milestone</h2>
    </div>

    @if($data->milestone_id)

    @php $milestone = $data->milestone()->first() @endphp

    @if($milestone)
    <div class="card-body">
        <a href="{{route('playground.matrix.resource.milestones.show', ['milestone' => $milestone->id])}}" alt="{{$milestone->description}}">
            {{$milestone->title}}
        </a>
    </div>
    @if($milestone->milestone_type)
    <div class="card-footer">
        {{$milestone->milestone_type}}
    </div>
    @endif
    @endif

    @elseif(!$data->locked && $routePatch)

    @php $milestones = Playground\Matrix\Models\Milestone::all() @endphp

    <div class="card-body">
        <form method="POST" action="{{ $routePatch }}" novalidate class="needs-validation">
            @csrf
            @method('patch')
            <div class="btn-toolbar mb-3" role="toolbar" aria-label="Milestone Form">
                <div class="input-group w-100">
                    <select class="form-select" aria-label="Set the milestone" name="milestone_id" required>
                        <option selected value="">set the milestone</option>
                        @foreach ($milestones as $milestone)
                        <option value="{{$milestone->id}}">{{$milestone->title ?: $milestone->label }}</option>
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