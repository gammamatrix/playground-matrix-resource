<div class="card">

    <div class="card-header">
        @if(!empty($modelColumn) && !empty($modelLabel))
        <a class="btn btn-info float-end" href="{{route('playground.matrix.resource.releases.create', [$modelColumn => $data->id, '_return_url' => $routeShow])}}" alt=" {{ __('Create a new release for the :model_label', ['model_label' => $modelLabel]) }}">
            {{ __('Create') }}
        </a>
        @endif
        <h2>{{ __('Release') }}</h2>
    </div>

    @if($data->release_id)

    @php $release = $data->release()->first() @endphp

    @if($release)
    <div class="card-body">
        <a href="{{route('playground.matrix.resource.releases.show', ['release' => $release->id])}}" alt="{{$release->description}}">
            {{$release->title}}
        </a>
    </div>
    @if($release->release_type)
    <div class="card-footer">
        {{$release->release_type}}
    </div>
    @endif
    @endif

    @elseif(!$data->locked && $routePatch)

    @php $releases = Playground\Matrix\Models\Release::all() @endphp

    <div class="card-body">
        <form method="POST" action="{{ $routePatch }}" novalidate class="needs-validation">
            @csrf
            @method('patch')
            <div class="btn-toolbar mb-3" role="toolbar" aria-label="{{ __('Release Form') }}">
                <div class="input-group w-100">
                    <select class="form-select" aria-label="{{ __('set the release') }}" name="release_id" required>
                        <option selected value="">{{ __('set the release') }}</option>
                        @foreach ($releases as $release)
                        <option value="{{$release->id}}">{{$release->title ?: $release->label }}</option>
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