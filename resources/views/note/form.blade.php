@extends('playground::layouts.resource.form', [
    'withFormInfo' => 'playground-matrix-resource::note/form-info',
    'withFormStatus' => 'playground-matrix-resource::note/form-flags',
])

@section('form-tertiary')
@include('playground-matrix-resource::note/form-dates')
@endsection

@section('fieldset-content')
@endsection
