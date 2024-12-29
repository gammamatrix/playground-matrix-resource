<div class="card">

    <div class="card-header">
        @if(!empty($modelColumn) && !empty($modelLabel))
        <a class="btn btn-info float-end" href="{{route('playground.matrix.resource.boards.create', [$modelColumn => $data->id, '_return_url' => $routeShow])}}" alt=" {{ __('Create a new board for the :model_label', ['model_label' => $modelLabel]) }}">
            {{ __('Create') }}
        </a>
        @endif
        <h2>{{ __('Board') }}</h2>
    </div>

    @if($data->board_id)

    @php $board = $data->board()->first() @endphp

    @if($board)
    <div class="card-body">
        <a href="{{route('playground.matrix.resource.boards.show', ['board' => $board->id])}}" alt="{{$board->description}}">
            {{$board->title}}
        </a>
    </div>
    @if($board->board_type)
    <div class="card-footer">
        {{$board->board_type}}
    </div>
    @endif
    @endif

    @elseif(!$data->locked && $routePatch)

    @php $boards = Playground\Matrix\Models\Board::all() @endphp

    <div class="card-body">
        <form method="POST" action="{{ $routePatch }}" novalidate class="needs-validation">
            @csrf
            @method('patch')
            <div class="btn-toolbar mb-3" role="toolbar" aria-label="{{ __('Board Form') }}">
                <div class="input-group w-100">
                    <select class="form-select" aria-label="{{ __('set the board') }}" name="board_id" required>
                        <option selected value="">{{ __('Create') }}</option>
                        @foreach ($boards as $board)
                        <option value="{{$board->id}}">{{$board->title ?: $board->label }}</option>
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