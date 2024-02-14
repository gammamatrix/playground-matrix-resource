@extends($package_config['layout'], [
    'withFormInfo' => 'playground-matrix-resource::backlog/form-info',
    'withFormStatus' => 'playground-matrix-resource::backlog/form-status',
])

@section('form-tertiary')
@include('playground-matrix-resource::backlog/form-publishing')
@endsection
