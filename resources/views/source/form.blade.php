@extends($package_config['layout'], [
    'withFormInfo' => 'playground-matrix-resource::source/form-info',
    'withFormStatus' => 'playground-matrix-resource::source/form-status',
])

@section('form-tertiary')
@include('playground-matrix-resource::source/form-publishing')
@endsection
