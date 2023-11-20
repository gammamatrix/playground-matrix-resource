@php $playground_matrix_resource = config('playground-matrix-resource'); @endphp

@extends($playground_matrix_resource['layout'])

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

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card my-1">
                <div class="card-header">
                    <h1>Matrix</h1>
                </div>
                <div class="card-body">

                    <div class="row">

                        <div class="col-sm-6">
                            <div class="card m-1">
                                <div class="card-body">
                                    <h5 class="card-title">Backlogs</h5>
                                    <h6 class="card-subtitle mb-2 text-muted">Manage backlogs</h6>
                                    <p class="card-text"></p>
                                    <a class="card-link" href="{{ route('playground.matrix.resource.backlogs') }}">View Backlogs</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="card m-1">
                                <div class="card-body">
                                    <h5 class="card-title">Boards</h5>
                                    <h6 class="card-subtitle mb-2 text-muted">Manage boards</h6>
                                    <p class="card-text"></p>
                                    <a class="card-link" href="{{ route('playground.matrix.resource.boards') }}">View Boards</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="card m-1">
                                <div class="card-body">
                                    <h5 class="card-title">Epics</h5>
                                    <h6 class="card-subtitle mb-2 text-muted">Manage epics</h6>
                                    <p class="card-text"></p>
                                    <a class="card-link" href="{{ route('playground.matrix.resource.epics') }}">View Epics</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="card m-1">
                                <div class="card-body">
                                    <h5 class="card-title">Flows</h5>
                                    <h6 class="card-subtitle mb-2 text-muted">Manage flows</h6>
                                    <p class="card-text"></p>
                                    <a class="card-link" href="{{ route('playground.matrix.resource.flows') }}">View Flows</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="card m-1">
                                <div class="card-body">
                                    <h5 class="card-title">Milestones</h5>
                                    <h6 class="card-subtitle mb-2 text-muted">Manage milestones</h6>
                                    <p class="card-text"></p>
                                    <a class="card-link" href="{{ route('playground.matrix.resource.milestones') }}">View Milestones</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="card m-1">
                                <div class="card-body">
                                    <h5 class="card-title">Notes</h5>
                                    <h6 class="card-subtitle mb-2 text-muted">Manage notes</h6>
                                    <p class="card-text"></p>
                                    <a class="card-link" href="{{ route('playground.matrix.resource.notes') }}">View Notes</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="card m-1">
                                <div class="card-body">
                                    <h5 class="card-title">Projects</h5>
                                    <h6 class="card-subtitle mb-2 text-muted">Manage projects</h6>
                                    <p class="card-text"></p>
                                    <a class="card-link" href="{{ route('playground.matrix.resource.projects') }}">View Projects</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="card m-1">
                                <div class="card-body">
                                    <h5 class="card-title">Releases</h5>
                                    <h6 class="card-subtitle mb-2 text-muted">Manage releases</h6>
                                    <p class="card-text"></p>
                                    <a class="card-link" href="{{ route('playground.matrix.resource.releases') }}">View Releases</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="card m-1">
                                <div class="card-body">
                                    <h5 class="card-title">Roadmaps</h5>
                                    <h6 class="card-subtitle mb-2 text-muted">Manage roadmaps</h6>
                                    <p class="card-text"></p>
                                    <a class="card-link" href="{{ route('playground.matrix.resource.roadmaps') }}">View Roadmaps</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="card m-1">
                                <div class="card-body">
                                    <h5 class="card-title">Sources</h5>
                                    <h6 class="card-subtitle mb-2 text-muted">Manage sources</h6>
                                    <p class="card-text"></p>
                                    <a class="card-link" href="{{ route('playground.matrix.resource.sources') }}">View Sources</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="card m-1">
                                <div class="card-body">
                                    <h5 class="card-title">Sprints</h5>
                                    <h6 class="card-subtitle mb-2 text-muted">Manage sprints</h6>
                                    <p class="card-text"></p>
                                    <a class="card-link" href="{{ route('playground.matrix.resource.sprints') }}">View Sprints</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="card m-1">
                                <div class="card-body">
                                    <h5 class="card-title">Tags</h5>
                                    <h6 class="card-subtitle mb-2 text-muted">Manage tags</h6>
                                    <p class="card-text"></p>
                                    <a class="card-link" href="{{ route('playground.matrix.resource.tags') }}">View Tags</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="card m-1">
                                <div class="card-body">
                                    <h5 class="card-title">Teams</h5>
                                    <h6 class="card-subtitle mb-2 text-muted">Manage teams</h6>
                                    <p class="card-text"></p>
                                    <a class="card-link" href="{{ route('playground.matrix.resource.teams') }}">View Teams</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="card m-1">
                                <div class="card-body">
                                    <h5 class="card-title">Tickets</h5>
                                    <h6 class="card-subtitle mb-2 text-muted">Manage tickets</h6>
                                    <p class="card-text"></p>
                                    <a class="card-link" href="{{ route('playground.matrix.resource.tickets') }}">View Tickets</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="card m-1">
                                <div class="card-body">
                                    <h5 class="card-title">Versions</h5>
                                    <h6 class="card-subtitle mb-2 text-muted">Manage versions</h6>
                                    <p class="card-text"></p>
                                    <a class="card-link" href="{{ route('playground.matrix.resource.versions') }}">View Versions</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
