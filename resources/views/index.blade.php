@extends('playground::layouts.resource.layout')

@section('title', 'Matrix')

@section('breadcrumbs')
<div class="container-fluid mt-3">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('playground.matrix.resource') }}">Matrix</a></li>
        </ol>
    </nav>
</div>
@endsection
<?php
// $hasMatrices = !empty($matrices) && $matrices instanceof \Illuminate\Database\Eloquent\Collection
?>
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card my-1">
                <div class="card-header">
                    <h1>Matrix Dashboard</h1>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="card m-1">
                                <div class="card-body">
                                    <h5 class="card-title">Backlogs</h5>
                                    <h6 class="card-subtitle mb-2 text-muted">
                                        Manage backlogs
                                        <span class="badge rounded-pill text-bg-primary">
                                            <?= $dashboard->getCount('Backlog') ?>
                                        </span>
                                    </h6>
                                    <p class="card-text"></p>
                                    <a class="card-link" href="{{ route('playground.matrix.resource.backlogs') }}">View Backlogs</a>
                                </div>
                                @if ($dashboard->hasLinks('Backlog'))
                                <ul class="list-group list-group-flush">
                                    @foreach ($dashboard->getLinks('Backlog') as $link)
                                    <li class="list-group-item">
                                        <a href="{{$link->uri}}" alt="{{$link->description ?? ''}}">
                                            {{$link->label}}
                                        </a>
                                    </li>
                                    @endforeach
                                </ul>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="card m-1">
                                <div class="card-body">
                                    <h5 class="card-title">Boards</h5>
                                    <h6 class="card-subtitle mb-2 text-muted">
                                        Manage boards
                                        <span class="badge rounded-pill text-bg-primary">
                                            <?= $dashboard->getCount('Board') ?>
                                        </span>
                                    </h6>
                                    <p class="card-text"></p>
                                    <a class="card-link" href="{{ route('playground.matrix.resource.boards') }}">View Boards</a>
                                </div>
                                @if ($dashboard->hasLinks('Board'))
                                <ul class="list-group list-group-flush">
                                    @foreach ($dashboard->getLinks('Board') as $link)
                                    <li class="list-group-item">
                                        <a href="{{$link->uri}}" alt="{{$link->description ?? ''}}">
                                            {{$link->label}}
                                        </a>
                                    </li>
                                    @endforeach
                                </ul>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="card m-1">
                                <div class="card-body">
                                    <h5 class="card-title">Epics</h5>
                                    <h6 class="card-subtitle mb-2 text-muted">
                                        Manage epics
                                        <span class="badge rounded-pill text-bg-primary">
                                            <?= $dashboard->getCount('Epic') ?>
                                        </span>
                                    </h6>
                                    <p class="card-text"></p>
                                    <a class="card-link" href="{{ route('playground.matrix.resource.epics') }}">View Epics</a>
                                </div>
                                @if ($dashboard->hasLinks('Epic'))
                                <ul class="list-group list-group-flush">
                                    @foreach ($dashboard->getLinks('Epic') as $link)
                                    <li class="list-group-item">
                                        <a href="{{$link->uri}}" alt="{{$link->description ?? ''}}">
                                            {{$link->label}}
                                        </a>
                                    </li>
                                    @endforeach
                                </ul>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="card m-1">
                                <div class="card-body">
                                    <h5 class="card-title">Flows</h5>
                                    <h6 class="card-subtitle mb-2 text-muted">
                                        Manage flows
                                        <span class="badge rounded-pill text-bg-primary">
                                            <?= $dashboard->getCount('Flow') ?>
                                        </span>
                                    </h6>
                                    <p class="card-text"></p>
                                    <a class="card-link" href="{{ route('playground.matrix.resource.flows') }}">View Flows</a>
                                </div>
                                @if ($dashboard->hasLinks('Flow'))
                                <ul class="list-group list-group-flush">
                                    @foreach ($dashboard->getLinks('Flow') as $link)
                                    <li class="list-group-item">
                                        <a href="{{$link->uri}}" alt="{{$link->description ?? ''}}">
                                            {{$link->label}}
                                        </a>
                                    </li>
                                    @endforeach
                                </ul>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="card m-1">
                                <div class="card-body">
                                    <h5 class="card-title">Matrices</h5>
                                    <h6 class="card-subtitle mb-2 text-muted">
                                        Manage matrices
                                        <span class="badge rounded-pill text-bg-primary">
                                            <?= $dashboard->getCount('Matrix') ?>
                                        </span>
                                    </h6>
                                    <p class="card-text"></p>
                                    <a class="card-link" href="{{ route('playground.matrix.resource.matrices') }}">View Matrices</a>
                                </div>
                                @if ($dashboard->hasLinks('Matrix'))
                                <ul class="list-group list-group-flush">
                                    @foreach ($dashboard->getLinks('Matrix') as $link)
                                    <li class="list-group-item">
                                        <a href="{{$link->uri}}" alt="{{$link->description ?? ''}}">
                                            {{$link->label}}
                                        </a>
                                    </li>
                                    @endforeach
                                </ul>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="card m-1">
                                <div class="card-body">
                                    <h5 class="card-title">Milestones</h5>
                                    <h6 class="card-subtitle mb-2 text-muted">
                                        Manage milestones
                                        <span class="badge rounded-pill text-bg-primary">
                                            <?= $dashboard->getCount('Milestone') ?>
                                        </span>
                                    </h6>
                                    <p class="card-text"></p>
                                    <a class="card-link" href="{{ route('playground.matrix.resource.milestones') }}">View Milestones</a>
                                </div>
                                @if ($dashboard->hasLinks('Milestone'))
                                <ul class="list-group list-group-flush">
                                    @foreach ($dashboard->getLinks('Milestone') as $link)
                                    <li class="list-group-item">
                                        <a href="{{$link->uri}}" alt="{{$link->description ?? ''}}">
                                            {{$link->label}}
                                        </a>
                                    </li>
                                    @endforeach
                                </ul>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="card m-1">
                                <div class="card-body">
                                    <h5 class="card-title">Notes</h5>
                                    <h6 class="card-subtitle mb-2 text-muted">
                                        Manage notes
                                        <span class="badge rounded-pill text-bg-primary">
                                            <?= $dashboard->getCount('Note') ?>
                                        </span>
                                    </h6>
                                    <p class="card-text"></p>
                                    <a class="card-link" href="{{ route('playground.matrix.resource.notes') }}">View Notes</a>
                                </div>
                                @if ($dashboard->hasLinks('Note'))
                                <ul class="list-group list-group-flush">
                                    @foreach ($dashboard->getLinks('Note') as $link)
                                    <li class="list-group-item">
                                        <a href="{{$link->uri}}" alt="{{$link->description ?? ''}}">
                                            {{$link->label}}
                                        </a>
                                    </li>
                                    @endforeach
                                </ul>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="card m-1">
                                <div class="card-body">
                                    <h5 class="card-title">Projects</h5>
                                    <h6 class="card-subtitle mb-2 text-muted">
                                        Manage projects
                                        <span class="badge rounded-pill text-bg-primary">
                                            <?= $dashboard->getCount('Project') ?>
                                        </span>
                                    </h6>
                                    <p class="card-text"></p>
                                    <a class="card-link" href="{{ route('playground.matrix.resource.projects') }}">View Projects</a>
                                </div>
                                @if ($dashboard->hasLinks('Project'))
                                <ul class="list-group list-group-flush">
                                    @foreach ($dashboard->getLinks('Project') as $link)
                                    <li class="list-group-item">
                                        <a href="{{$link->uri}}" alt="{{$link->description ?? ''}}">
                                            {{$link->label}}
                                        </a>
                                    </li>
                                    @endforeach
                                </ul>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="card m-1">
                                <div class="card-body">
                                    <h5 class="card-title">Releases</h5>
                                    <h6 class="card-subtitle mb-2 text-muted">
                                        Manage releases
                                        <span class="badge rounded-pill text-bg-primary">
                                            <?= $dashboard->getCount('Release') ?>
                                        </span>
                                    </h6>
                                    <p class="card-text"></p>
                                    <a class="card-link" href="{{ route('playground.matrix.resource.releases') }}">View Releases</a>
                                </div>
                                @if ($dashboard->hasLinks('Release'))
                                <ul class="list-group list-group-flush">
                                    @foreach ($dashboard->getLinks('Release') as $link)
                                    <li class="list-group-item">
                                        <a href="{{$link->uri}}" alt="{{$link->description ?? ''}}">
                                            {{$link->label}}
                                        </a>
                                    </li>
                                    @endforeach
                                </ul>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="card m-1">
                                <div class="card-body">
                                    <h5 class="card-title">Roadmaps</h5>
                                    <h6 class="card-subtitle mb-2 text-muted">
                                        Manage roadmaps
                                        <span class="badge rounded-pill text-bg-primary">
                                            <?= $dashboard->getCount('Roadmap') ?>
                                        </span>
                                    </h6>
                                    <p class="card-text"></p>
                                    <a class="card-link" href="{{ route('playground.matrix.resource.roadmaps') }}">View Roadmaps</a>
                                </div>
                                @if ($dashboard->hasLinks('Roadmap'))
                                <ul class="list-group list-group-flush">
                                    @foreach ($dashboard->getLinks('Roadmap') as $link)
                                    <li class="list-group-item">
                                        <a href="{{$link->uri}}" alt="{{$link->description ?? ''}}">
                                            {{$link->label}}
                                        </a>
                                    </li>
                                    @endforeach
                                </ul>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="card m-1">
                                <div class="card-body">
                                    <h5 class="card-title">Sources</h5>
                                    <h6 class="card-subtitle mb-2 text-muted">
                                        Manage sources
                                        <span class="badge rounded-pill text-bg-primary">
                                            <?= $dashboard->getCount('Source') ?>
                                        </span>
                                    </h6>
                                    <p class="card-text"></p>
                                    <a class="card-link" href="{{ route('playground.matrix.resource.sources') }}">View Sources</a>
                                </div>
                                @if ($dashboard->hasLinks('Source'))
                                <ul class="list-group list-group-flush">
                                    @foreach ($dashboard->getLinks('Source') as $link)
                                    <li class="list-group-item">
                                        <a href="{{$link->uri}}" alt="{{$link->description ?? ''}}">
                                            {{$link->label}}
                                        </a>
                                    </li>
                                    @endforeach
                                </ul>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="card m-1">
                                <div class="card-body">
                                    <h5 class="card-title">Sprints</h5>
                                    <h6 class="card-subtitle mb-2 text-muted">
                                        Manage sprints
                                        <span class="badge rounded-pill text-bg-primary">
                                            <?= $dashboard->getCount('Sprint') ?>
                                        </span>
                                    </h6>
                                    <p class="card-text"></p>
                                    <a class="card-link" href="{{ route('playground.matrix.resource.sprints') }}">View Sprints</a>
                                </div>
                                @if ($dashboard->hasLinks('Sprint'))
                                <ul class="list-group list-group-flush">
                                    @foreach ($dashboard->getLinks('Sprint') as $link)
                                    <li class="list-group-item">
                                        <a href="{{$link->uri}}" alt="{{$link->description ?? ''}}">
                                            {{$link->label}}
                                        </a>
                                    </li>
                                    @endforeach
                                </ul>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="card m-1">
                                <div class="card-body">
                                    <h5 class="card-title">Tags</h5>
                                    <h6 class="card-subtitle mb-2 text-muted">
                                        Manage tags
                                        <span class="badge rounded-pill text-bg-primary">
                                            <?= $dashboard->getCount('Tag') ?>
                                        </span>
                                    </h6>
                                    <p class="card-text"></p>
                                    <a class="card-link" href="{{ route('playground.matrix.resource.tags') }}">View Tags</a>
                                </div>
                                @if ($dashboard->hasLinks('Tag'))
                                <ul class="list-group list-group-flush">
                                    @foreach ($dashboard->getLinks('Tag') as $link)
                                    <li class="list-group-item">
                                        <a href="{{$link->uri}}" alt="{{$link->description ?? ''}}">
                                            {{$link->label}}
                                        </a>
                                    </li>
                                    @endforeach
                                </ul>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="card m-1">
                                <div class="card-body">
                                    <h5 class="card-title">Teams</h5>
                                    <h6 class="card-subtitle mb-2 text-muted">
                                        Manage teams
                                        <span class="badge rounded-pill text-bg-primary">
                                            <?= $dashboard->getCount('Team') ?>
                                        </span>
                                    </h6>
                                    <p class="card-text"></p>
                                    <a class="card-link" href="{{ route('playground.matrix.resource.teams') }}">View Teams</a>
                                </div>
                                @if ($dashboard->hasLinks('Team'))
                                <ul class="list-group list-group-flush">
                                    @foreach ($dashboard->getLinks('Team') as $link)
                                    <li class="list-group-item">
                                        <a href="{{$link->uri}}" alt="{{$link->description ?? ''}}">
                                            {{$link->label}}
                                        </a>
                                    </li>
                                    @endforeach
                                </ul>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="card m-1">
                                <div class="card-body">
                                    <h5 class="card-title">Tickets</h5>
                                    <h6 class="card-subtitle mb-2 text-muted">
                                        Manage tickets
                                        <span class="badge rounded-pill text-bg-primary">
                                            <?= $dashboard->getCount('Ticket') ?>
                                        </span>
                                    </h6>
                                    <p class="card-text"></p>
                                    <a class="card-link" href="{{ route('playground.matrix.resource.tickets') }}">View Tickets</a>
                                </div>
                                @if ($dashboard->hasLinks('Ticket'))
                                <ul class="list-group list-group-flush">
                                    @foreach ($dashboard->getLinks('Ticket') as $link)
                                    <li class="list-group-item">
                                        <a href="{{$link->uri}}" alt="{{$link->description ?? ''}}">
                                            {{$link->label}}
                                        </a>
                                    </li>
                                    @endforeach
                                </ul>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="card m-1">
                                <div class="card-body">
                                    <h5 class="card-title">Versions</h5>
                                    <h6 class="card-subtitle mb-2 text-muted">
                                        Manage versions
                                        <span class="badge rounded-pill text-bg-primary">
                                            <?= $dashboard->getCount('Version') ?>
                                        </span>
                                    </h6>
                                    <p class="card-text"></p>
                                    <a class="card-link" href="{{ route('playground.matrix.resource.versions') }}">View Versions</a>
                                </div>
                                @if ($dashboard->hasLinks('Version'))
                                <ul class="list-group list-group-flush">
                                    @foreach ($dashboard->getLinks('Version') as $link)
                                    <li class="list-group-item">
                                        <a href="{{$link->uri}}" alt="{{$link->description ?? ''}}">
                                            {{$link->label}}
                                        </a>
                                    </li>
                                    @endforeach
                                </ul>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
