<?php

return [
    'layout' => env('PLAYGROUND_MATRIX_RESOURCE_LAYOUT', 'playground::layouts.resource.layout'),
    'middleware' => [
        'default' => env('PLAYGROUND_MATRIX_RESOURCE_MIDDLEWARE_DEFAULT', 'web'),
        'auth' => env('PLAYGROUND_MATRIX_RESOURCE_MIDDLEWARE_AUTH', ['web', 'auth']),
        'guest' => env('PLAYGROUND_MATRIX_RESOURCE_MIDDLEWARE_GUEST', 'web'),
    ],
    'policy_namespace' => env('PLAYGROUND_MATRIX_RESOURCE_POLICY_NAMESPACE', ''),
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
    'view' => env('PLAYGROUND_MATRIX_RESOURCE_VIEW', 'playground-matrix-resource::'),
];
