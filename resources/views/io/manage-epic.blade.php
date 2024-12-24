<div class="card">

    <div class="card-header">
        @if(!empty($modelColumn) && !empty($modelLabel))
        <a class="btn btn-info float-end" href="{{route('playground.matrix.resource.epics.create', [$modelColumn => $data->id, '_return_url' => $routeShow])}}" alt=" {{ __('Create a new epic for the :model_label', ['model_label' => $modelLabel]) }}">
            {{ __('Create') }}
        </a>
        @endif
        <h2>{{ __('Epic') }}</h2>
    </div>

    @if($data->epic_id)

    @php $epic = $data->epic()->first() @endphp

    @if($epic)
    <div class="card-body">
        <a href="{{route('playground.matrix.resource.epics.show', ['epic' => $epic->id])}}" alt="{{$epic->description}}">
            {{$epic->title}}
        </a>
    </div>
    @if($epic->epic_type)
    <div class="card-footer">
        {{$epic->epic_type}}
    </div>
    @endif
    @endif

    @elseif(!$data->locked && $routePatch)

    @php $epics = Playground\Matrix\Models\Epic::all() @endphp

    <div class="card-body">
        <form method="POST" action="{{ $routePatch }}" novalidate class="needs-validation">
            @csrf
            @method('patch')
            <div class="btn-toolbar mb-3" role="toolbar" aria-label="{{ __('Epic Form') }}">
                <div class="input-group w-100">
                    <select class="form-select" aria-label="{{ __('set the epic') }}" name="epic_id" required>
                        <option selected value="">{{ __('set the epic') }}</option>
                        @foreach ($epics as $epic)
                        <option value="{{$epic->id}}">{{$epic->title ?: $epic->label }}</option>
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