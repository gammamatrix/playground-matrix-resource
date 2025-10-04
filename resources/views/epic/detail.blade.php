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
        "Expecting data and package info for resources/views/epic/detail.blade.php",
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
    "canceled" => [
        "column" => "canceled",
        "label" => "Canceled",
        "icon" => "fa-solid fa-ban text-warning",
        "badge" => "",
    ],
    "closed" => [
        "column" => "closed",
        "label" => "Closed",
        "icon" => "fa-solid fa-xmark",
        "badge" => "",
    ],
    "completed" => [
        "column" => "completed",
        "label" => "Completed",
        "icon" => "fa-solid fa-check",
        "badge" => "",
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
    "pending" => [
        "column" => "pending",
        "label" => "Pending",
        "icon" => "fa-solid fa-circle-pause text-warning",
        "badge" => "text-bg-info",
    ],
    "planned" => [
        "column" => "planned",
        "label" => "Planned",
        "icon" => "fa-solid fa-circle-pause text-success",
        "badge" => "",
    ],
    "prioritized" => [
        "column" => "prioritized",
        "label" => "Prioritized",
        "icon" => "fa-solid fa-triangle-exclamation text-success",
        "badge" => "",
    ],
    "problem" => [
        "column" => "problem",
        "label" => "Problem",
        "icon" => "fa-solid fa-triangle-exclamation text-danger",
        "badge" => "text-bg-success",
    ],
    "published" => [
        "column" => "published",
        "label" => "Published",
        "icon" => "fa-solid fa-book",
        "badge" => "",
    ],
    "released" => [
        "column" => "released",
        "label" => "Released",
        "icon" => "fa-solid fa-dove",
        "badge" => "",
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
    "suspended" => [
        "column" => "suspended",
        "label" => "Suspended",
        "icon" => "fa-solid fa-hand text-danger",
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
            @include("playground-matrix-resource::io/manage-backlog")
        </div>
        <div class="col-sm-6 col-md-4 mb-3">
            @include("playground-matrix-resource::io/manage-board")
        </div>
        <div class="col-sm-6 col-md-4 mb-3">
            @include("playground-matrix-resource::io/manage-flow")
        </div>
        <div class="col-sm-6 col-md-4 mb-3">
            @include("playground-matrix-resource::io/manage-matrix")
        </div>
        <div class="col-sm-6 col-md-4 mb-3">
            @include("playground-matrix-resource::io/manage-milestone")
        </div>
        <div class="col-sm-6 col-md-4 mb-3">
            @include("playground-matrix-resource::io/manage-note")
        </div>
        <div class="col-sm-6 col-md-4 mb-3">
            @include("playground-matrix-resource::io/manage-project")
        </div>
        <div class="col-sm-6 col-md-4 mb-3">
            @include("playground-matrix-resource::io/manage-release")
        </div>
        <div class="col-sm-6 col-md-4 mb-3">
            @include("playground-matrix-resource::io/manage-roadmap")
        </div>
        <div class="col-sm-6 col-md-4 mb-3">
            @include("playground-matrix-resource::io/manage-source")
        </div>
        <div class="col-sm-6 col-md-4 mb-3">
            @include("playground-matrix-resource::io/manage-sprint")
        </div>
        <div class="col-sm-6 col-md-4 mb-3">
            @include("playground-matrix-resource::io/manage-tag")
        </div>
        <div class="col-sm-6 col-md-4 mb-3">
            @include("playground-matrix-resource::io/manage-team")
        </div>
        <div class="col-sm-6 col-md-4 mb-3">
            @include("playground-matrix-resource::io/manage-ticket")
        </div>
        <div class="col-sm-6 col-md-4 mb-3">
            @include("playground-matrix-resource::io/manage-version")
        </div>
    </div>
@endsection
