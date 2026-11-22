@extends ("playground::layouts.resource.form", [
    "withFormInfo" => "playground-matrix-resource::ticket/form-info",
        "withFormAccess" => true,
])

@section ("fieldset-content")
    <x-playground::forms.column-editor column="actual" label="Actual" />
    <x-playground::forms.column-editor column="expected" label="Expected" />
    <x-playground::forms.column-editor column="story" label="Story" />
    <x-playground::forms.column-editor column="steps" label="Steps" />
    <x-playground::forms.column-editor column="criteria" label="Criteria" />
    <x-playground::forms.column-editor column="reproducibility" label="Reproducibility" />
@endsection

@section("form-scripts")
if (typeof playground === 'object') {
    playground.forms.editor('#form-input-actual');
    playground.forms.editor('#form-input-expected');
    playground.forms.editor('#form-input-criteria');
    playground.forms.editor('#form-input-story');
    playground.forms.editor('#form-input-steps');
    playground.forms.editor('#form-input-reproducibility');
}
@endsection
