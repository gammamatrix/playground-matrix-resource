@extends("playground::layouts.resource.layout")

@section("title", "Dashboard: Matrix")

@section("breadcrumbs")
    <nav aria-label="breadcrumb" class="container-fluid mt-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">
                <a href="{{ route("playground.matrix.resource") }}">Matrix</a>
            </li>
        </ol>
    </nav>
@endsection

<?php
$user = \Illuminate\Support\Facades\Auth::user();

?>

@section("content")
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card my-1">
                    <div class="card-header">
                        <h1>Matrix Dashboard</h1>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @include("playground-matrix-resource::index/index-projects")
                            @include("playground-matrix-resource::index/index-matrices")
                        </div>
                        <div class="row">
                            @include("playground-matrix-resource::index/index-boards")
                            @include("playground-matrix-resource::index/index-sprints")
                        </div>
                        <div class="row">
                            @include("playground-matrix-resource::index/index-tickets")
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card my-1">
                    <div class="card-header">
                        <h2>Project and Release Management</h2>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @include("playground-matrix-resource::index/index-milestones")
                            @include("playground-matrix-resource::index/index-versions")
                        </div>
                        <div class="row">
                            @include("playground-matrix-resource::index/index-releases")
                            @include("playground-matrix-resource::index/index-roadmaps")
                        </div>
                        <div class="row">
                            @include("playground-matrix-resource::index/index-teams")
                        </div>
                        <div class="row">
                            @include("playground-matrix-resource::index/index-flows")
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card my-1">
                    <div class="card-header">
                        <h2>Project Components</h2>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @include("playground-matrix-resource::index/index-epics")
                            @include("playground-matrix-resource::index/index-tags")
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card my-1">
                    <div class="card-header">
                        <h2>Sources and Notes</h2>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @include("playground-matrix-resource::index/index-notes")
                            @include("playground-matrix-resource::index/index-sources")
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
