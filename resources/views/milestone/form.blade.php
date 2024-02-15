@extends('playground::layouts.resource.form', [
    'withFormInfo' => 'playground-matrix-resource::milestone/form-info',
    'withFormStatus' => 'playground-matrix-resource::milestone/form-status',
])

@section('form-tertiary')
@include('playground-matrix-resource::milestone/form-publishing')
@endsection
