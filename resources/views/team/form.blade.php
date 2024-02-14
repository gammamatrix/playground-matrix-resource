@extends($package_config['layout'], [
    'withFormInfo' => 'playground-matrix-resource::team/form-info',
    'withFormStatus' => 'playground-matrix-resource::team/form-status',
])

@section('form-tertiary')
@include('playground-matrix-resource::team/form-publishing')
@endsection
