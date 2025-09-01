@extends('playground::layouts.resource.form', [
    'withFormInfo' => 'playground-matrix-resource::milestone/form-info',
    'withFormStatus' => 'playground-matrix-resource::milestone/form-flags',
])

@section('form-tertiary')
@include('playground-matrix-resource::milestone/form-dates')
@endsection

@section('fieldset-content')
@endsection
