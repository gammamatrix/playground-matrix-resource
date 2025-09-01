@extends('playground::layouts.resource.form', [
    'withFormInfo' => 'playground-matrix-resource::matrix/form-info',
    'withFormStatus' => 'playground-matrix-resource::matrix/form-flags',
])

@section('form-tertiary')
@include('playground-matrix-resource::matrix/form-dates')
@endsection

@section('fieldset-content')
@endsection
