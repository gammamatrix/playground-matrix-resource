@extends($package_config['layout'], [
    'withFormInfo' => 'playground-matrix-resource::tag/form-info',
    'withFormStatus' => 'playground-matrix-resource::tag/form-status',
])

@section('form-tertiary')
@include('playground-matrix-resource::tag/form-publishing')
@endsection
