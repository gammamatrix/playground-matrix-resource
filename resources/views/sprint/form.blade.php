@extends('playground::layouts.resource.form', [
    'withFormInfo' => 'playground-matrix-resource::sprint/form-info',
    'withFormStatus' => 'playground-matrix-resource::sprint/form-status',
])

@section('form-tertiary')
@include('playground-matrix-resource::sprint/form-publishing')
@endsection
