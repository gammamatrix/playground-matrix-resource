@extends('playground::layouts.resource.form', [
    'withFormInfo' => 'playground-matrix-resource::ticket/form-info',
    'withFormStatus' => 'playground-matrix-resource::ticket/form-flags',
])

@section('form-tertiary')
@include('playground-matrix-resource::ticket/form-dates')
@endsection

@section('fieldset-content')
@endsection
