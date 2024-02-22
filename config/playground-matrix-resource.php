<?php

return [
    'middleware' => [
        'default' => env('PLAYGROUND_MATRIX_RESOURCE_MIDDLEWARE_DEFAULT', ['web']),
        'auth' => env('PLAYGROUND_MATRIX_RESOURCE_MIDDLEWARE_AUTH', ['web', 'auth']),
        'guest' => env('PLAYGROUND_MATRIX_RESOURCE_MIDDLEWARE_GUEST', ['web']),
    ],
    'policies' => [
        Playground\Matrix\Models\Backlog::class => Playground\Matrix\Resource\Policies\BacklogPolicy::class,
        Playground\Matrix\Models\Board::class => Playground\Matrix\Resource\Policies\BoardPolicy::class,
        Playground\Matrix\Models\Epic::class => Playground\Matrix\Resource\Policies\EpicPolicy::class,
        Playground\Matrix\Models\Flow::class => Playground\Matrix\Resource\Policies\FlowPolicy::class,
        Playground\Matrix\Models\Milestone::class => Playground\Matrix\Resource\Policies\MilestonePolicy::class,
        Playground\Matrix\Models\Note::class => Playground\Matrix\Resource\Policies\NotePolicy::class,
        Playground\Matrix\Models\Project::class => Playground\Matrix\Resource\Policies\ProjectPolicy::class,
        Playground\Matrix\Models\Release::class => Playground\Matrix\Resource\Policies\ReleasePolicy::class,
        Playground\Matrix\Models\Roadmap::class => Playground\Matrix\Resource\Policies\RoadmapPolicy::class,
        Playground\Matrix\Models\Source::class => Playground\Matrix\Resource\Policies\SourcePolicy::class,
        Playground\Matrix\Models\Sprint::class => Playground\Matrix\Resource\Policies\SprintPolicy::class,
        Playground\Matrix\Models\Tag::class => Playground\Matrix\Resource\Policies\TagPolicy::class,
        Playground\Matrix\Models\Team::class => Playground\Matrix\Resource\Policies\TeamPolicy::class,
        Playground\Matrix\Models\Ticket::class => Playground\Matrix\Resource\Policies\TicketPolicy::class,
        Playground\Matrix\Models\Version::class => Playground\Matrix\Resource\Policies\VersionPolicy::class,
    ],
    'load' => [
        'policies' => (bool) env('PLAYGROUND_MATRIX_RESOURCE_LOAD_POLICIES', true),
        'routes' => (bool) env('PLAYGROUND_MATRIX_RESOURCE_LOAD_ROUTES', true),
        'views' => (bool) env('PLAYGROUND_MATRIX_RESOURCE_LOAD_VIEWS', true),
    ],
    'routes' => [
        'matrix' => (bool) env('PLAYGROUND_MATRIX_RESOURCE_ROUTES_MATRIX', true),
        'backlogs' => (bool) env('PLAYGROUND_MATRIX_RESOURCE_ROUTES_BACKLOGS', true),
        'boards' => (bool) env('PLAYGROUND_MATRIX_RESOURCE_ROUTES_BOARDS', true),
        'epics' => (bool) env('PLAYGROUND_MATRIX_RESOURCE_ROUTES_EPICS', true),
        'flows' => (bool) env('PLAYGROUND_MATRIX_RESOURCE_ROUTES_FLOWS', true),
        'milestones' => (bool) env('PLAYGROUND_MATRIX_RESOURCE_ROUTES_MILESTONES', true),
        'notes' => (bool) env('PLAYGROUND_MATRIX_RESOURCE_ROUTES_NOTES', true),
        'projects' => (bool) env('PLAYGROUND_MATRIX_RESOURCE_ROUTES_PROJECTS', true),
        'releases' => (bool) env('PLAYGROUND_MATRIX_RESOURCE_ROUTES_RELEASES', true),
        'roadmaps' => (bool) env('PLAYGROUND_MATRIX_RESOURCE_ROUTES_ROADMAPS', true),
        'sources' => (bool) env('PLAYGROUND_MATRIX_RESOURCE_ROUTES_SOURCES', true),
        'sprints' => (bool) env('PLAYGROUND_MATRIX_RESOURCE_ROUTES_SPRINTS', true),
        'tags' => (bool) env('PLAYGROUND_MATRIX_RESOURCE_ROUTES_TAGS', true),
        'teams' => (bool) env('PLAYGROUND_MATRIX_RESOURCE_ROUTES_TEAMS', true),
        'tickets' => (bool) env('PLAYGROUND_MATRIX_RESOURCE_ROUTES_TICKETS', true),
        'versions' => (bool) env('PLAYGROUND_MATRIX_RESOURCE_ROUTES_VERSIONS', true),
    ],
    'sitemap' => [
        'enable' => (bool) env('PLAYGROUND_MATRIX_RESOURCE_SITEMAP_ENABLE', true),
        'guest' => (bool) env('PLAYGROUND_MATRIX_RESOURCE_SITEMAP_GUEST', true),
        'user' => (bool) env('PLAYGROUND_MATRIX_RESOURCE_SITEMAP_USER', true),
        'view' => env('PLAYGROUND_MATRIX_RESOURCE_SITEMAP_VIEW', 'playground-matrix-resource::sitemap'),
    ],
    'blade' => env('PLAYGROUND_MATRIX_RESOURCE_BLADE', 'playground-matrix-resource::'),

    'abilities' => [
        'admin' => [
            'playground-matrix-resource:*',
        ],
        'manager' => [
            'playground-matrix-resource:backlog:*',
            'playground-matrix-resource:board:*',
            'playground-matrix-resource:epic:*',
            'playground-matrix-resource:flow:*',
            'playground-matrix-resource:milestone:*',
            'playground-matrix-resource:note:*',
            'playground-matrix-resource:project:*',
            'playground-matrix-resource:release:*',
            'playground-matrix-resource:roadmap:*',
            'playground-matrix-resource:source:*',
            'playground-matrix-resource:sprint:*',
            'playground-matrix-resource:tag:*',
            'playground-matrix-resource:team:*',
            'playground-matrix-resource:ticket:*',
            'playground-matrix-resource:version:*',
        ],
        'user' => [
            'playground-matrix-resource:backlog:view',
            'playground-matrix-resource:backlog:viewAny',
            'playground-matrix-resource:board:view',
            'playground-matrix-resource:board:viewAny',
            'playground-matrix-resource:epic:view',
            'playground-matrix-resource:epic:viewAny',
            'playground-matrix-resource:flow:view',
            'playground-matrix-resource:flow:viewAny',
            'playground-matrix-resource:milestone:view',
            'playground-matrix-resource:milestone:viewAny',
            'playground-matrix-resource:note:view',
            'playground-matrix-resource:note:viewAny',
            'playground-matrix-resource:project:view',
            'playground-matrix-resource:project:viewAny',
            'playground-matrix-resource:release:view',
            'playground-matrix-resource:release:viewAny',
            'playground-matrix-resource:roadmap:view',
            'playground-matrix-resource:roadmap:viewAny',
            'playground-matrix-resource:source:view',
            'playground-matrix-resource:source:viewAny',
            'playground-matrix-resource:sprint:view',
            'playground-matrix-resource:sprint:viewAny',
            'playground-matrix-resource:tag:view',
            'playground-matrix-resource:tag:viewAny',
            'playground-matrix-resource:team:view',
            'playground-matrix-resource:team:viewAny',
            'playground-matrix-resource:ticket:view',
            'playground-matrix-resource:ticket:viewAny',
            'playground-matrix-resource:ticket:create',
            'playground-matrix-resource:ticket:edit',
            'playground-matrix-resource:ticket:store',
            'playground-matrix-resource:ticket:update',
            'playground-matrix-resource:version:view',
            'playground-matrix-resource:version:viewAny',
        ],
        // 'guest' => [
        //     'deny',
        // ],
        // 'guest' => [
        //     'app:view',

        //     'playground:view',

        //     'playground-auth:logout',
        //     'playground-auth:reset-password',

        //     'playground-matrix-resource:backlog:view',
        //     'playground-matrix-resource:backlog:viewAny',
        //     'playground-matrix-resource:board:view',
        //     'playground-matrix-resource:board:viewAny',
        //     'playground-matrix-resource:epic:view',
        //     'playground-matrix-resource:epic:viewAny',
        //     'playground-matrix-resource:flow:view',
        //     'playground-matrix-resource:flow:viewAny',
        //     'playground-matrix-resource:milestone:view',
        //     'playground-matrix-resource:milestone:viewAny',
        //     'playground-matrix-resource:note:view',
        //     'playground-matrix-resource:note:viewAny',
        //     'playground-matrix-resource:project:view',
        //     'playground-matrix-resource:project:viewAny',
        //     'playground-matrix-resource:release:view',
        //     'playground-matrix-resource:release:viewAny',
        //     'playground-matrix-resource:roadmap:view',
        //     'playground-matrix-resource:roadmap:viewAny',
        //     'playground-matrix-resource:source:view',
        //     'playground-matrix-resource:source:viewAny',
        //     'playground-matrix-resource:sprint:view',
        //     'playground-matrix-resource:sprint:viewAny',
        //     'playground-matrix-resource:tag:view',
        //     'playground-matrix-resource:tag:viewAny',
        //     'playground-matrix-resource:team:view',
        //     'playground-matrix-resource:team:viewAny',
        //     'playground-matrix-resource:ticket:view',
        //     'playground-matrix-resource:ticket:viewAny',
        //     'playground-matrix-resource:version:view',
        //     'playground-matrix-resource:version:viewAny',
        // ],
    ],
];