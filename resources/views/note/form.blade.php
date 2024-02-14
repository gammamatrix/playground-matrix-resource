@extends($package_config['layout'], [
    'withFormInfo' => 'playground-matrix-resource::note/form-info',
    'withFormStatus' => 'playground-matrix-resource::note/form-status',
])

@section('form-tertiary')
@include('playground-matrix-resource::note/form-publishing')
@endsection
