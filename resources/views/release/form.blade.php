@extends('playground::layouts.resource.form', [
    'withFormInfo' => 'playground-matrix-resource::release/form-info',
    'withFormStatus' => 'playground-matrix-resource::release/form-flags',
])

@section('form-tertiary')
@include('playground-matrix-resource::release/form-dates')
@endsection

@section('fieldset-content')
@endsection
