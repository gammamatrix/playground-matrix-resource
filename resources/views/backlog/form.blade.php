@extends('playground::layouts.resource.form', [
    'withFormInfo' => 'playground-matrix-resource::backlog/form-info',
    'withFormStatus' => 'playground-matrix-resource::backlog/form-flags',
])

@section('form-tertiary')
@include('playground-matrix-resource::backlog/form-dates')
@endsection

@section('fieldset-content')
@endsection
