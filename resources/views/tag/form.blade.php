@extends('playground::layouts.resource.form', [
    'withFormInfo' => 'playground-matrix-resource::tag/form-info',
    'withFormStatus' => 'playground-matrix-resource::tag/form-flags',
])

@section('form-tertiary')
@include('playground-matrix-resource::tag/form-dates')
@endsection

@section('fieldset-content')
@endsection
