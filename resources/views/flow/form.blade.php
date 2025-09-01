@extends('playground::layouts.resource.form', [
    'withFormInfo' => 'playground-matrix-resource::flow/form-info',
    'withFormStatus' => 'playground-matrix-resource::flow/form-flags',
])

@section('form-tertiary')
@include('playground-matrix-resource::flow/form-dates')
@endsection

@section('fieldset-content')
@endsection
