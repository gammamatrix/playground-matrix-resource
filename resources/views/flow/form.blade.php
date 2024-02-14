@extends($package_config['layout'], [
    'withFormInfo' => 'playground-matrix-resource::flow/form-info',
    'withFormStatus' => 'playground-matrix-resource::flow/form-status',
])

@section('form-tertiary')
@include('playground-matrix-resource::flow/form-publishing')
@endsection
