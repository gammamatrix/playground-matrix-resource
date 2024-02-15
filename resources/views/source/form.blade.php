@extends('playground::layouts.resource.form', [
    'withFormInfo' => 'playground-matrix-resource::source/form-info',
    'withFormStatus' => 'playground-matrix-resource::source/form-status',
])

@section('form-tertiary')
@include('playground-matrix-resource::source/form-publishing')
@endsection
