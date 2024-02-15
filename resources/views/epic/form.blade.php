@extends('playground::layouts.resource.form', [
    'withFormInfo' => 'playground-matrix-resource::epic/form-info',
    'withFormStatus' => 'playground-matrix-resource::epic/form-status',
])

@section('form-tertiary')
@include('playground-matrix-resource::epic/form-publishing')
@endsection
