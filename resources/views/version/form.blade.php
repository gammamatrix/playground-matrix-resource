@extends('playground::layouts.resource.form', [
    'withFormInfo' => 'playground-matrix-resource::version/form-info',
    'withFormStatus' => 'playground-matrix-resource::version/form-flags',
])

@section('form-tertiary')
@include('playground-matrix-resource::version/form-dates')
@endsection

@section('fieldset-content')
@endsection
