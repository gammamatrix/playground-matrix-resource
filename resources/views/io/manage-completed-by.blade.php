<div class="card">
    <div class="card-header">
        <h2>{{ __("Completed By") }}</h2>
    </div>

    @if ($data->completed_by_id)
        @php
            $completedBy = $data->completedBy()->first();
        @endphp

        @if ($completedBy)
            <div class="card-body">
                {{ $completedBy->name }}
            </div>
        @endif
    @elseif (! $data->locked && $routePatch)
        @php
            $completers = [];
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
                    aria-label=" {{ __("Owner Form") }}"
                >
                    <div class="input-group w-100">
                        <select
                            class="form-select"
                            aria-label=" {{ __("set the owner") }}"
                            name="owned_by_id"
                            required
                        >
                            <option selected value="">
                                {{ __("set the owner") }}
                            </option>
                            @foreach ($completers as $completer)
                                <option value="{{ $completer->id }}">
                                    {{ $completer->name }}
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
