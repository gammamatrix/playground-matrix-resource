@extends('playground::layouts.resource.form', [
    'withFormInfo' => 'playground-matrix-resource::matrix/form-info',
    'withFormStatus' => 'playground-matrix-resource::matrix/form-status',
])

@section('form-tertiary')
@include('playground-matrix-resource::matrix/form-publishing')
@endsection
