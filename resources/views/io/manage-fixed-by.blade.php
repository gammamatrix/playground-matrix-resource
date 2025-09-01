<div class="card">

    <div class="card-header">
        <h2> {{ __('Fixed By') }}</h2>
    </div>

    @if($data->fixed_by_id)

        @php $fixedBy = $data->fixedBy()->first() @endphp

        @if($fixedBy)
            <div class="card-body">
                {{$fixedBy->name}}
            </div>
        @endif

    @elseif(!$data->locked && $routePatch)

        @php $fixers = [] @endphp

        <div class="card-body">
            <form method="POST" action="{{ $routePatch }}" novalidate class="needs-validation">
                @csrf
                @method('patch')
                <div class="btn-toolbar mb-3" role="toolbar" aria-label=" {{ __('Owner Form') }}">
                    <div class="input-group w-100">
                        <select class="form-select" aria-label=" {{ __('set the owner') }}" name="owned_by_id" required>
                            <option selected value=""> {{ __('set the owner') }}</option>
                            @foreach ($fixers as $fixer)
                                <option value="{{$fixer->id}}">{{$fixer->name }}</option>
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
