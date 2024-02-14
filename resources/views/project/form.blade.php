@extends($package_config['layout'], [
    'withFormInfo' => 'playground-matrix-resource::project/form-info',
    'withFormStatus' => 'playground-matrix-resource::project/form-status',
])

@section('form-tertiary')
@include('playground-matrix-resource::project/form-publishing')
@endsection
