@extends('playground::layouts.resource.form', [
    'withFormInfo' => 'playground-matrix-resource::flow/form-info',
    'withFormStatus' => 'playground-matrix-resource::flow/form-status',
])

@section('form-tertiary')
@include('playground-matrix-resource::flow/form-publishing')
@endsection
