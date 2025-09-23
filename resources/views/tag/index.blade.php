<?php
$packageInfo =
    ! empty($meta) && is_array($meta) && ! empty($meta["info"])
        ? $meta["info"]
        : null;
if (! ($packageInfo instanceof \Playground\PackageInfo)) {
    throw new RuntimeException(
        "Expecting package info for resources/views/tag/index.blade.php",
        500,
    );
}

$sort = empty($sort) || ! is_array($sort) ? [] : $sort;

$filters = empty($filters) || ! is_array($filters) ? [] : $filters;

$validated = empty($validated) || ! is_array($validated) ? [] : $validated;

$columnsViewable = [
    "tag_type" => [
        "hide-sm" => false,
        "label" => "Tag Type",
    ],
    "created_by_id" => [
        "hide-sm" => true,
        "label" => "Created by id",
    ],
    "modified_by_id" => [
        "hide-sm" => true,
        "label" => "Modified by id",
    ],
    "owned_by_id" => [
        "hide-sm" => true,
        "label" => "Owned by id",
    ],
    "parent_id" => [
        "hide-sm" => true,
        "label" => "Parent id",
    ],
    "matrix_id" => [
        "hide-sm" => true,
        "label" => "Matrix id",
    ],
    "locale" => [
        "hide-sm" => true,
        "linkType" => null,
        "linkRoute" => null,
        "label" => "Locale",
    ],
    "label" => [
        "hide-sm" => false,
        "linkType" => null,
        "linkRoute" => null,
        "label" => "Label",
    ],
    "title" => [
        "hide-sm" => false,
        "linkType" => "id",
        "linkRoute" => sprintf('%1$s.show', $packageInfo->model_route()),
        "label" => "Title",
    ],
    "byline" => [
        "hide-sm" => true,
        "linkType" => null,
        "linkRoute" => null,
        "label" => "Byline",
    ],
    "slug" => [
        "hide-sm" => false,
        "linkType" => null,
        "linkRoute" => null,
        "label" => "Slug",
    ],
    "url" => [
        "hide-sm" => true,
        "linkType" => null,
        "linkRoute" => null,
        "label" => "Url",
    ],
    "description" => [
        "hide-sm" => false,
        "linkType" => null,
        "linkRoute" => null,
        "label" => "Description",
    ],
    "introduction" => [
        "hide-sm" => true,
        "linkType" => null,
        "linkRoute" => null,
        "label" => "Introduction",
    ],
    "icon" => [
        "hide-sm" => true,
        "label" => "Icon",
    ],
    "image" => [
        "hide-sm" => true,
        "label" => "Image",
    ],
    "avatar" => [
        "hide-sm" => true,
        "label" => "Avatar",
    ],
    "active" => [
        "hide-sm" => true,
        "flag" => true,
        "label" => "Active",
        "onTrueClass" => "fa-solid fa-person-running",
    ],
    "cron" => [
        "hide-sm" => true,
        "flag" => true,
        "label" => "Cron",
        "onTrueClass" => "fa-regular fa-clock",
    ],
    "featured" => [
        "hide-sm" => true,
        "flag" => true,
        "label" => "Featured",
        "onTrueClass" => "fa-solid fa-star text-warning",
    ],
    "flagged" => [
        "hide-sm" => true,
        "flag" => true,
        "label" => "Flagged",
        "onTrueClass" => "fa-solid fa-flag",
    ],
    "internal" => [
        "hide-sm" => true,
        "flag" => true,
        "label" => "Internal",
        "onTrueClass" => "fa-solid fa-server",
    ],
    "locked" => [
        "hide-sm" => true,
        "flag" => true,
        "label" => "Locked",
        "onTrueClass" => "fa-solid fa-lock text-warning",
    ],
    "retired" => [
        "hide-sm" => true,
        "flag" => true,
        "label" => "Retired",
        "onTrueClass" => "fa-solid fa-chair text-success",
    ],
    "special" => [
        "hide-sm" => true,
        "flag" => true,
        "label" => "Special",
        "onTrueClass" => "fa-solid fa-star text-success",
    ],
    "unknown" => [
        "hide-sm" => true,
        "flag" => true,
        "label" => "Unknown",
        "onTrueClass" => "fa-solid fa-question text-warning",
    ],
    "created_at" => [
        "hide-sm" => true,
        "label" => "Created at",
    ],
    "updated_at" => [
        "hide-sm" => true,
        "label" => "Updated at",
    ],
    "gids" => [
        "hide-sm" => true,
        "label" => "Gids",
        "onTrueClass" => "",
    ],
    "po" => [
        "hide-sm" => true,
        "label" => "Po",
        "onTrueClass" => "",
    ],
    "pg" => [
        "hide-sm" => true,
        "label" => "Pg",
        "onTrueClass" => "",
    ],
    "pw" => [
        "hide-sm" => true,
        "label" => "Pw",
        "onTrueClass" => "",
    ],
    "only_admin" => [
        "hide-sm" => true,
        "label" => "Only admin",
        "onTrueClass" => "fa-solid fa-user-gear",
    ],
    "only_user" => [
        "hide-sm" => true,
        "label" => "Only user",
        "onTrueClass" => "fa-solid fa-user",
    ],
    "only_guest" => [
        "hide-sm" => true,
        "label" => "Only guest",
        "onTrueClass" => "fa-solid fa-person-rays",
    ],
    "allow_public" => [
        "hide-sm" => true,
        "label" => "Allow public",
        "onTrueClass" => "fa-solid fa-users-line",
    ],
    "status" => [
        "hide-sm" => true,
        "label" => "Status",
    ],
    "rank" => [
        "hide-sm" => true,
        "label" => "Rank",
    ],
    "size" => [
        "hide-sm" => true,
        "label" => "Size",
    ],
];

$columnsMobile = ["title", "tag_type", "slug", "description", "published"];

$columnsStandard = [
    "title",
    "tag_type",
    "slug",
    "label",
    "description",
    "published",
    "revision",
    "created_at",
    "updated_at",
];

$viewableColumns =
    ! empty($validated["columns"]) &&
    is_string($validated["columns"]) &&
    in_array($validated["columns"], ["all", "standard", "mobile"])
        ? $validated["columns"]
        : "standard";

if ($viewableColumns === "all") {
    $columns = $columnsViewable;
} elseif ($viewableColumns === "mobile") {
    $columns = Illuminate\Support\Arr::only($columnsViewable, $columnsMobile);
} else {
    $columns = Illuminate\Support\Arr::only($columnsViewable, $columnsStandard);
}

?>

@extends(
    "playground::layouts.resource.index",
    [
        "withTableColumns" => $columns,
    ]
)
