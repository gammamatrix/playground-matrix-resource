@extends($package_config['layout'], [
    'withFormInfo' => 'playground-matrix-resource::version/form-info',
    'withFormStatus' => 'playground-matrix-resource::version/form-status',
])

@section('form-tertiary')
@include('playground-matrix-resource::version/form-publishing')
@endsection
