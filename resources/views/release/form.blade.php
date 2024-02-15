@extends('playground::layouts.resource.form', [
    'withFormInfo' => 'playground-matrix-resource::release/form-info',
    'withFormStatus' => 'playground-matrix-resource::release/form-status',
])

@section('form-tertiary')
@include('playground-matrix-resource::release/form-publishing')
@endsection
