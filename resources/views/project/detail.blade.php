<?php

$routePatch = !$data ? '' : route(sprintf('%1$s.patch', $meta['info']['model_route']), [$meta['info']['model_slug'] => $data->getAttributeValue('id')]);
$routeShow = !$data ? '' : route(sprintf('%1$s.show', $meta['info']['model_route']), [$meta['info']['model_slug'] => $data->getAttributeValue('id')]);
$modelLabel = $meta['info']['model_label'];
$modelColumn = 'project_id';
$modulelLabel = $meta['info']['module_label'];

$flags = [
    'active' => ['column' => 'active', 'label' => 'Active', 'icon' => 'fa-solid fa-person-running', 'badge' => 'text-bg-success'],
    'canceled' => ['column' => 'canceled', 'label' => 'Canceled', 'icon' => 'fa-solid fa-ban text-warning'],
    'closed' => ['column' => 'closed', 'label' => 'Closed', 'icon' => 'fa-solid fa-xmark'],
    'completed' => ['column' => 'completed', 'label' => 'Completed', 'icon' => 'fa-solid fa-check'],
    'cron' => ['column' => 'cron', 'label' => 'Cron', 'icon' => 'fa-regular fa-clock'],
    'duplicate' => ['column' => 'duplicate', 'label' => 'Duplicate', 'icon' => 'fa-solid fa-clone'],
    'featured' => ['column' => 'featured', 'label' => 'Featured', 'icon' => 'fa-solid fa-star text-warning'],
    'fixed' => ['column' => 'fixed', 'label' => 'Fixed', 'icon' => 'fa-solid fa-wrench'],
    'flagged' => ['column' => 'flagged', 'label' => 'Flagged', 'icon' => 'fa-solid fa-flag'],
    'internal' => ['column' => 'internal', 'label' => 'Internal', 'icon' => 'fa-solid fa-server'],
    'locked' => ['column' => 'locked', 'label' => 'Locked', 'icon' => 'fa-solid fa-lock text-warning'],
    'pending' => ['column' => 'pending', 'label' => 'Pending', 'icon' => 'fa-solid fa-circle-pause text-warning'],
    'planned' => ['column' => 'planned', 'label' => 'Planned', 'icon' => 'fa-solid fa-circle-pause text-success'],
    'prioritized' => ['column' => 'prioritized', 'label' => 'Prioritized', 'icon' => 'fa-solid fa-triangle-exclamation text-success'],
    'problem' => ['column' => 'problem', 'label' => 'Problem', 'icon' => 'fa-solid fa-triangle-exclamation text-danger'],
    'published' => ['column' => 'published', 'label' => 'Published', 'icon' => 'fa-solid fa-book'],
    'released' => ['column' => 'released', 'label' => 'Released', 'icon' => 'fa-solid fa-dove'],
    'resolved' => ['column' => 'resolved', 'label' => 'Resolved', 'icon' => 'fa-solid fa-check-double text-success'],
    'retired' => ['column' => 'retired', 'label' => 'Retired', 'icon' => 'fa-solid fa-chair text-success'],
    'special' => ['column' => 'special', 'label' => 'Special', 'icon' => 'fa-solid fa-star text-success'],
    'suspended' => ['column' => 'suspended', 'label' => 'Suspended', 'icon' => 'fa-solid fa-hand text-danger'],
    'unknown' => ['column' => 'unknown', 'label' => 'Unknown', 'icon' => 'fa-solid fa-question text-warning'],
];
?>
@extends('playground::layouts.resource.detail', [
    'withInfo' => false,
    'withAccordion' => true,
    'withCard' => false,
])

@section('detail-information-flags')
@include('playground::layouts.resource.detail-flags')
@endsection

@section('detail-accordion-body-header')
<div class="row mb-3">
    <div class="col-sm-6 col-md-4 mb-3">
        @include('playground-matrix-resource::io/manage-sprint')
    </div>
    <div class="col-sm-6 col-md-4 mb-3">
        @include('playground-matrix-resource::io/manage-epic')
    </div>
    <div class="col-sm-6 col-md-4 mb-3">
        @include('playground-matrix-resource::io/manage-ticket')
    </div>
    <div class="col-sm-6 col-md-4 mb-3">
        @include('playground-matrix-resource::io/manage-version')
    </div>
    <div class="col-sm-6 col-md-4 mb-3">
        @include('playground-matrix-resource::io/manage-milestone')
    </div>
    <div class="col-sm-6 col-md-4 mb-3">
        @include('playground-matrix-resource::io/manage-board')
    </div>
    <div class="col-sm-6 col-md-4 mb-3">
        @include('playground-matrix-resource::io/manage-backlog')
    </div>
    <div class="col-sm-6 col-md-4 mb-3">
        @include('playground-matrix-resource::io/manage-roadmap')
    </div>
    <div class="col-sm-6 col-md-4 mb-3">
        @include('playground-matrix-resource::io/manage-flow')
    </div>
    <div class="col-sm-6 col-md-4 mb-3">
        @include('playground-matrix-resource::io/manage-matrix')
    </div>
    <div class="col-sm-6 col-md-4 mb-3">
        @include('playground-matrix-resource::io/manage-release')
    </div>
    <div class="col-sm-6 col-md-4 mb-3">
        @include('playground-matrix-resource::io/manage-tag')
    </div>
    <div class="col-sm-6 col-md-4 mb-3">
        @include('playground-matrix-resource::io/manage-team')
    </div>
    <div class="col-sm-6 col-md-4 mb-3">
        @include('playground-matrix-resource::io/manage-source')
    </div>
    <div class="col-sm-6 col-md-4 mb-3">
        @include('playground-matrix-resource::io/manage-note')
    </div>
</div>
@endsection

@section('section-primary')
<div class="my-3">
    @include('playground-matrix-resource::io/list-tickets', [
        'headerLabel' => 'Project Tickets',
        'tickets' => Playground\Matrix\Models\Ticket::where('project_id', $data->id)->get(),
        'withProject' => false,
    ])
</div>
@endsection
