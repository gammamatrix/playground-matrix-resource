@extends('playground::layouts.resource.form', [
    'withFormInfo' => 'playground-matrix-resource::team/form-info',
    'withFormStatus' => 'playground-matrix-resource::team/form-flags',
])

@section('form-tertiary')
@include('playground-matrix-resource::team/form-dates')
@endsection

@section('fieldset-content')
@endsection
