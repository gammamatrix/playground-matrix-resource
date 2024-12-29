<div class="card">

    <div class="card-header">
        @if(!empty($modelColumn) && !empty($modelLabel))
        <a class="btn btn-info float-end" href="{{route('playground.matrix.resource.notes.create', [$modelColumn => $data->id, '_return_url' => $routeShow])}}" alt=" {{ __('Create a new note for the :model_label', ['model_label' => $modelLabel]) }}">
            {{ __('Create') }}
        </a>
        @endif
        <h2>Note</h2>
    </div>

    @if($data->note_id)

    @php $note = $data->note()->first() @endphp

    @if($note)
    <div class="card-body">
        <a href="{{route('playground.matrix.resource.notes.show', ['note' => $note->id])}}" alt="{{$note->description}}">
            {{$note->title}}
        </a>
    </div>
    @if($note->note_type)
    <div class="card-footer">
        {{$note->note_type}}
    </div>
    @endif
    @endif

    @elseif(!$data->locked && $routePatch)

    @php $notes = Playground\Matrix\Models\Note::all() @endphp

    <div class="card-body">
        <form method="POST" action="{{ $routePatch }}" novalidate class="needs-validation">
            @csrf
            @method('patch')
            <div class="btn-toolbar mb-3" role="toolbar" aria-label="Note Form">
                <div class="input-group w-100">
                    <select class="form-select" aria-label="Set the note" name="note_id" required>
                        <option selected value="">set the note</option>
                        @foreach ($notes as $note)
                        <option value="{{$note->id}}">{{$note->title ?: $note->label }}</option>
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