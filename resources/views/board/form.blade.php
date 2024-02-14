@extends($package_config['layout'], [
    'withFormInfo' => 'playground-matrix-resource::board/form-info',
    'withFormStatus' => 'playground-matrix-resource::board/form-status',
])

@section('form-tertiary')
@include('playground-matrix-resource::board/form-publishing')
@endsection
