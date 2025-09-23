<div class="card">
    <div class="card-header">
        <h2>{{ __("Version Fixed") }}</h2>
    </div>

    @if ($data->version_fixed_id)
        {{-- TODO add verion fixed --}}
        @php
            $version = $data->version()->first();
        @endphp

        @if ($version)
            <div class="card-body">
                <a
                    href="{{ route("playground.matrix.resource.versions.show", ["version" => $version->id]) }}"
                    alt="{{ $version->description }}"
                >
                    {{ $version->title }}
                </a>
            </div>
            @if ($version->version_type)
                <div class="card-footer">
                    {{ $version->version_type }}
                </div>
            @endif
        @endif
    @elseif (! $data->locked && $routePatch)
        @php
            $versions = Playground\Matrix\Models\Version::all();
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
                    aria-label="{{ __("Version Fixed Form") }}"
                >
                    <div class="input-group w-100">
                        <select
                            class="form-select"
                            aria-label="{{ __("set the version fixed") }}"
                            name="version_fixed_id"
                            required
                        >
                            <option selected value="">
                                {{ __("set the version") }}
                            </option>
                            @foreach ($versions as $version)
                                <option value="{{ $version->id }}">
                                    {{ $version->title ?: $version->label }}
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
