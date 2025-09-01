@extends('playground::layouts.resource.form', [
    'withFormInfo' => 'playground-matrix-resource::sprint/form-info',
    'withFormStatus' => 'playground-matrix-resource::sprint/form-flags',
])

@section('form-tertiary')
@include('playground-matrix-resource::sprint/form-dates')
@endsection

@section('fieldset-content')
@endsection
