@php $playground_matrix_resource = config('playground-matrix-resource'); @endphp

@extends(sprintf('%1$s%2$s', $playground_matrix_resource['view'], 'layouts.resource.form'), [
    'withFormInfo' => 'playground-matrix-resource::version/form-info',
    'withFormStatus' => 'playground-matrix-resource::version/form-status',
])

@section('form-tertiary')
@include('playground-matrix-resource::version/form-publishing')
@endsection
