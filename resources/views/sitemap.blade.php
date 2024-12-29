<?php
$user = \Illuminate\Support\Facades\Auth::user();

$viewBacklogs = \Playground\Auth\Facades\Can::access($user, [
    'allow' => false,
    'any' => true,
    'privilege' => 'playground-matrix-resource:backlog:viewAny',
    'roles' => ['admin', 'manager', 'publisher'],
])->allowed();

$viewBoards = \Playground\Auth\Facades\Can::access($user, [
    'allow' => false,
    'any' => true,
    'privilege' => 'playground-matrix-resource:board:viewAny',
    'roles' => ['admin', 'manager', 'publisher'],
])->allowed();

$viewEpics = \Playground\Auth\Facades\Can::access($user, [
    'allow' => false,
    'any' => true,
    'privilege' => 'playground-matrix-resource:epic:viewAny',
    'roles' => ['admin', 'manager', 'publisher'],
])->allowed();

$viewFlows = \Playground\Auth\Facades\Can::access($user, [
    'allow' => false,
    'any' => true,
    'privilege' => 'playground-matrix-resource:flow:viewAny',
    'roles' => ['admin', 'manager', 'publisher'],
])->allowed();

$viewMatrices = \Playground\Auth\Facades\Can::access($user, [
    'allow' => false,
    'any' => true,
    'privilege' => 'playground-matrix-resource:matrix:viewAny',
    'roles' => ['admin', 'manager', 'publisher'],
])->allowed();

$viewMilestones = \Playground\Auth\Facades\Can::access($user, [
    'allow' => false,
    'any' => true,
    'privilege' => 'playground-matrix-resource:milestone:viewAny',
    'roles' => ['admin', 'manager', 'publisher'],
])->allowed();

$viewNotes = \Playground\Auth\Facades\Can::access($user, [
    'allow' => false,
    'any' => true,
    'privilege' => 'playground-matrix-resource:note:viewAny',
    'roles' => ['admin', 'manager', 'publisher'],
])->allowed();

$viewProjects = \Playground\Auth\Facades\Can::access($user, [
    'allow' => false,
    'any' => true,
    'privilege' => 'playground-matrix-resource:project:viewAny',
    'roles' => ['admin', 'manager', 'publisher'],
])->allowed();

$viewReleases = \Playground\Auth\Facades\Can::access($user, [
    'allow' => false,
    'any' => true,
    'privilege' => 'playground-matrix-resource:release:viewAny',
    'roles' => ['admin', 'manager', 'publisher'],
])->allowed();

$viewRoadmaps = \Playground\Auth\Facades\Can::access($user, [
    'allow' => false,
    'any' => true,
    'privilege' => 'playground-matrix-resource:roadmap:viewAny',
    'roles' => ['admin', 'manager', 'publisher'],
])->allowed();

$viewSources = \Playground\Auth\Facades\Can::access($user, [
    'allow' => false,
    'any' => true,
    'privilege' => 'playground-matrix-resource:source:viewAny',
    'roles' => ['admin', 'manager', 'publisher'],
])->allowed();

$viewSprints = \Playground\Auth\Facades\Can::access($user, [
    'allow' => false,
    'any' => true,
    'privilege' => 'playground-matrix-resource:sprint:viewAny',
    'roles' => ['admin', 'manager', 'publisher'],
])->allowed();

$viewTags = \Playground\Auth\Facades\Can::access($user, [
    'allow' => false,
    'any' => true,
    'privilege' => 'playground-matrix-resource:tag:viewAny',
    'roles' => ['admin', 'manager', 'publisher'],
])->allowed();

$viewTeams = \Playground\Auth\Facades\Can::access($user, [
    'allow' => false,
    'any' => true,
    'privilege' => 'playground-matrix-resource:team:viewAny',
    'roles' => ['admin', 'manager', 'publisher'],
])->allowed();

$viewTickets = \Playground\Auth\Facades\Can::access($user, [
    'allow' => false,
    'any' => true,
    'privilege' => 'playground-matrix-resource:ticket:viewAny',
    'roles' => ['admin', 'manager', 'publisher'],
])->allowed();

$viewVersions = \Playground\Auth\Facades\Can::access($user, [
    'allow' => false,
    'any' => true,
    'privilege' => 'playground-matrix-resource:version:viewAny',
    'roles' => ['admin', 'manager', 'publisher'],
])->allowed();


if (!$viewBacklogs && !$viewBoards && !$viewEpics && !$viewFlows && !$viewMatrices && !$viewMilestones && !$viewNotes && !$viewProjects && !$viewReleases && !$viewRoadmaps && !$viewSources && !$viewSprints && !$viewTags && !$viewTeams && !$viewTickets && !$viewVersions) {
    return;
}
?>
<div class="card my-1">
    <div class="card-body">

        <h2>Matrix</h2>

        <div class="row">

            <div class="col-sm-6 mb-3">
                <div class="card">
                    <div class="card-header">
                        <small class="text-muted">backlogs, boards, epics, flows, matrices, milestones, notes, projects, releases, roadmaps, sources, sprints, tags, teams, tickets and versions</small>
                    </div>
                    <ul class="list-group list-group-flush">

                        <a href="{{ route('playground.matrix.resource') }}" class="list-group-item list-group-item-action">
                            Matrix Index
                        </a>

                        @if ($viewBacklogs)
                        <a href="{{ route('playground.matrix.resource.backlogs') }}" class="list-group-item list-group-item-action">
                            Backlogs
                        </a>
                        @endif

                        @if ($viewBoards)
                        <a href="{{ route('playground.matrix.resource.boards') }}" class="list-group-item list-group-item-action">
                            Boards
                        </a>
                        @endif

                        @if ($viewEpics)
                        <a href="{{ route('playground.matrix.resource.epics') }}" class="list-group-item list-group-item-action">
                            Epics
                        </a>
                        @endif

                        @if ($viewFlows)
                        <a href="{{ route('playground.matrix.resource.flows') }}" class="list-group-item list-group-item-action">
                            Flows
                        </a>
                        @endif

                        @if ($viewMatrices)
                        <a href="{{ route('playground.matrix.resource.matrices') }}" class="list-group-item list-group-item-action">
                            Matrices
                        </a>
                        @endif

                        @if ($viewMilestones)
                        <a href="{{ route('playground.matrix.resource.milestones') }}" class="list-group-item list-group-item-action">
                            Milestones
                        </a>
                        @endif

                        @if ($viewNotes)
                        <a href="{{ route('playground.matrix.resource.notes') }}" class="list-group-item list-group-item-action">
                            Notes
                        </a>
                        @endif

                        @if ($viewProjects)
                        <a href="{{ route('playground.matrix.resource.projects') }}" class="list-group-item list-group-item-action">
                            Projects
                        </a>
                        @endif

                        @if ($viewReleases)
                        <a href="{{ route('playground.matrix.resource.releases') }}" class="list-group-item list-group-item-action">
                            Releases
                        </a>
                        @endif

                        @if ($viewRoadmaps)
                        <a href="{{ route('playground.matrix.resource.roadmaps') }}" class="list-group-item list-group-item-action">
                            Roadmaps
                        </a>
                        @endif

                        @if ($viewSources)
                        <a href="{{ route('playground.matrix.resource.sources') }}" class="list-group-item list-group-item-action">
                            Sources
                        </a>
                        @endif

                        @if ($viewSprints)
                        <a href="{{ route('playground.matrix.resource.sprints') }}" class="list-group-item list-group-item-action">
                            Sprints
                        </a>
                        @endif

                        @if ($viewTags)
                        <a href="{{ route('playground.matrix.resource.tags') }}" class="list-group-item list-group-item-action">
                            Tags
                        </a>
                        @endif

                        @if ($viewTeams)
                        <a href="{{ route('playground.matrix.resource.teams') }}" class="list-group-item list-group-item-action">
                            Teams
                        </a>
                        @endif

                        @if ($viewTickets)
                        <a href="{{ route('playground.matrix.resource.tickets') }}" class="list-group-item list-group-item-action">
                            Tickets
                        </a>
                        @endif

                        @if ($viewVersions)
                        <a href="{{ route('playground.matrix.resource.versions') }}" class="list-group-item list-group-item-action">
                            Versions
                        </a>
                        @endif

                    </ul>
                </div>
            </div>

        </div>

    </div>
</div>
