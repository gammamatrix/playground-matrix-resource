@extends($package_config['layout'], [
    'withFormInfo' => 'playground-matrix-resource::ticket/form-info',
    'withFormStatus' => 'playground-matrix-resource::ticket/form-status',
])

@section('form-tertiary')
@include('playground-matrix-resource::ticket/form-publishing')
@endsection
