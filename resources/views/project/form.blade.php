@extends('playground::layouts.resource.form', [
    'withFormInfo' => 'playground-matrix-resource::project/form-info',
    'withFormStatus' => 'playground-matrix-resource::project/form-flags',
])

@section('form-tertiary')
@include('playground-matrix-resource::project/form-dates')
@endsection

@section('fieldset-content')
@endsection
