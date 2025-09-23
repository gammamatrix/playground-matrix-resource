<?php
$packageInfo =
    ! empty($meta) && is_array($meta) && ! empty($meta["info"])
        ? $meta["info"]
        : null;
$data = $data ?? null;
if (
    ! ($packageInfo instanceof \Playground\PackageInfo) ||
    ! ($data instanceof \Illuminate\Database\Eloquent\Model)
) {
    throw new RuntimeException(
        "Expecting data and package info for resources/views/tag/detail.blade.php",
        500,
    );
}

$routePatch = route(sprintf('%1$s.patch', $packageInfo->model_route()), [
    $packageInfo->model_slug() => $data->getAttributeValue("id"),
]);
$routeShow = route(sprintf('%1$s.show', $packageInfo->model_route()), [
    $packageInfo->model_slug() => $data->getAttributeValue("id"),
]);

$flags = [
    "active" => [
        "column" => "active",
        "label" => "Active",
        "icon" => "fa-solid fa-person-running",
        "badge" => "text-bg-success",
    ],
    "cron" => [
        "column" => "cron",
        "label" => "Cron",
        "icon" => "fa-regular fa-clock",
        "badge" => "",
    ],
    "featured" => [
        "column" => "featured",
        "label" => "Featured",
        "icon" => "fa-solid fa-star text-warning",
        "badge" => "",
    ],
    "flagged" => [
        "column" => "flagged",
        "label" => "Flagged",
        "icon" => "fa-solid fa-flag",
        "badge" => "",
    ],
    "internal" => [
        "column" => "internal",
        "label" => "Internal",
        "icon" => "fa-solid fa-server",
        "badge" => "",
    ],
    "locked" => [
        "column" => "locked",
        "label" => "Locked",
        "icon" => "fa-solid fa-lock text-warning",
        "badge" => "text-bg-warning",
    ],
    "retired" => [
        "column" => "retired",
        "label" => "Retired",
        "icon" => "fa-solid fa-chair text-success",
        "badge" => "",
    ],
    "special" => [
        "column" => "special",
        "label" => "Special",
        "icon" => "fa-solid fa-star text-success",
        "badge" => "",
    ],
    "unknown" => [
        "column" => "unknown",
        "label" => "Unknown",
        "icon" => "fa-solid fa-question text-warning",
        "badge" => "text-bg-success",
    ],
];
?>

@extends(
    "playground::layouts.resource.detail",
    [
        "withInfo" => false,
        "withAccordion" => true,
        "withCard" => false,
    ]
)

@section("detail-information-flags")
    @include("playground::layouts.resource.detail-flags")
@endsection

@section("detail-card-body-header")
    
@endsection

@section("detail-accordion-body-header")
    <div class="row mb-3">
        <div class="col-sm-6 col-md-4 mb-3">
            @include("playground-matrix-resource::io/manage-owner")
        </div>
        <div class="col-sm-6 col-md-4 mb-3">
            @include("playground-matrix-resource::io/manage-parent")
        </div>
        <div class="col-sm-6 col-md-4 mb-3">
            @include("playground-matrix-resource::io/manage-matrix")
        </div>
    </div>
@endsection
