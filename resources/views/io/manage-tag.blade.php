<div class="card">

    <div class="card-header">
        @if(!empty($modelColumn) && !empty($modelLabel))
        <a class="btn btn-info float-end" href="{{route('playground.matrix.resource.tags.create', [$modelColumn => $data->id, '_return_url' => $routeShow])}}" alt=" {{ __('Create a new tag for the :model_label', ['model_label' => $modelLabel]) }}">
            {{ __('Create') }}
        </a>
        @endif
        <h2>{{ __('Tag') }}</h2>
    </div>

    @if($data->tag_id)

    @php $tag = $data->tag()->first() @endphp

    @if($tag)
    <div class="card-body">
        <a href="{{route('playground.matrix.resource.tags.show', ['tag' => $tag->id])}}" alt="{{$tag->description}}">
            {{$tag->title}}
        </a>
    </div>
    @if($tag->tag_type)
    <div class="card-footer">
        {{$tag->tag_type}}
    </div>
    @endif
    @endif

    @elseif(!$data->locked && $routePatch)

    @php $tags = Playground\Matrix\Models\Tag::all() @endphp

    <div class="card-body">
        <form method="POST" action="{{ $routePatch }}" novalidate class="needs-validation">
            @csrf
            @method('patch')
            <div class="btn-toolbar mb-3" role="toolbar" aria-label="{{ __('Tag Form') }}">
                <div class="input-group w-100">
                    <select class="form-select" aria-label="{{ __('set the tag') }}" name="tag_id" required>
                        <option selected value="">{{ __('set the tag') }}</option>
                        @foreach ($tags as $tag)
                        <option value="{{$tag->id}}">{{$tag->title ?: $tag->label }}</option>
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