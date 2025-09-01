@extends('playground::layouts.resource.form', [
    'withFormInfo' => 'playground-matrix-resource::source/form-info',
    'withFormStatus' => 'playground-matrix-resource::source/form-flags',
])

@section('form-tertiary')
@include('playground-matrix-resource::source/form-dates')
@endsection

@section('fieldset-content')
@endsection
