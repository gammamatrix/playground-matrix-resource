@extends('playground::layouts.resource.form', [
    'withFormInfo' => 'playground-matrix-resource::board/form-info',
    'withFormStatus' => 'playground-matrix-resource::board/form-flags',
])

@section('form-tertiary')
@include('playground-matrix-resource::board/form-dates')
@endsection

@section('fieldset-content')
@endsection
