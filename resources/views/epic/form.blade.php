@extends('playground::layouts.resource.form', [
    'withFormInfo' => 'playground-matrix-resource::epic/form-info',
    'withFormStatus' => 'playground-matrix-resource::epic/form-flags',
])

@section('form-tertiary')
@include('playground-matrix-resource::epic/form-dates')
@endsection

@section('fieldset-content')
@endsection
