<?php

/**
 * Playground
 */

declare(strict_types=1);
use Illuminate\Database\Eloquent\Model;
use Playground\Auth\Policies\Policy;
use Playground\Matrix\Models\Backlog;
use Playground\Matrix\Models\Board;
use Playground\Matrix\Models\Epic;
use Playground\Matrix\Models\Flow;
use Playground\Matrix\Models\Matrix;
use Playground\Matrix\Models\Milestone;
use Playground\Matrix\Models\Note;
use Playground\Matrix\Models\Project;
use Playground\Matrix\Models\Release;
use Playground\Matrix\Models\Roadmap;
use Playground\Matrix\Models\Source;
use Playground\Matrix\Models\Sprint;
use Playground\Matrix\Models\Tag;
use Playground\Matrix\Models\Team;
use Playground\Matrix\Models\Ticket;
use Playground\Matrix\Models\Version;
use Playground\Matrix\Resource\Policies\BacklogPolicy;
use Playground\Matrix\Resource\Policies\BoardPolicy;
use Playground\Matrix\Resource\Policies\EpicPolicy;
use Playground\Matrix\Resource\Policies\FlowPolicy;
use Playground\Matrix\Resource\Policies\MatrixPolicy;
use Playground\Matrix\Resource\Policies\MilestonePolicy;
use Playground\Matrix\Resource\Policies\NotePolicy;
use Playground\Matrix\Resource\Policies\ProjectPolicy;
use Playground\Matrix\Resource\Policies\ReleasePolicy;
use Playground\Matrix\Resource\Policies\RoadmapPolicy;
use Playground\Matrix\Resource\Policies\SourcePolicy;
use Playground\Matrix\Resource\Policies\SprintPolicy;
use Playground\Matrix\Resource\Policies\TagPolicy;
use Playground\Matrix\Resource\Policies\TeamPolicy;
use Playground\Matrix\Resource\Policies\TicketPolicy;
use Playground\Matrix\Resource\Policies\VersionPolicy;

/**
 * Playground: Matrix Resource Configuration and Environment Variables
 *
 * @return array{
 *       about: bool,
 *       layout: string,
 *       load: array{
 *           policies: bool,
 *           routes: bool,
 *           translations: bool,
 *           views: bool
 *       },
 *       middleware: array{
 *           default: string|string[],
 *           auth: string|string[],
 *           guest: string|string[]
 *       },
 *       policies: array<
 *           class-string<Model>,
 *           class-string<Policy>
 *       >,
 *       routes: array{
 *           matrix: bool,
 *           backlogs: bool,
 *           boards: bool,
 *           epics: bool,
 *           flows: bool,
 *           matrices: bool,
 *           milestones: bool,
 *           notes: bool,
 *           projects: bool,
 *           releases: bool,
 *           roadmaps: bool,
 *           sources: bool,
 *           sprints: bool,
 *           tags: bool,
 *           teams: bool,
 *           tickets: bool,
 *           versions: bool,
 *       },
 *       blade: string,
 *       abilities: array<string, string[]>,
 *       sitemap: array{
 *            enable: bool,
 *            guest: bool,
 *            user: bool,
 *            view: string
 *       }
 *   }
 */
return [

    /*
    |--------------------------------------------------------------------------
    | About Information
    |--------------------------------------------------------------------------
    |
    | By default, information will be displayed about this package when using:
    |
    | `artisan about`
    |
    */

    'about' => (bool) env('PLAYGROUND_MATRIX_RESOURCE_ABOUT', true),

    /*
    |--------------------------------------------------------------------------
    | Loading
    |--------------------------------------------------------------------------
    |
    | By default, translations and views are loaded.
    |
    */

    'load' => [
        'policies' => (bool) env('PLAYGROUND_MATRIX_RESOURCE_LOAD_POLICIES', true),
        'routes' => (bool) env('PLAYGROUND_MATRIX_RESOURCE_LOAD_ROUTES', true),
        'translations' => (bool) env('PLAYGROUND_MATRIX_RESOURCE_LOAD_TRANSLATIONS', true),
        'views' => (bool) env('PLAYGROUND_MATRIX_RESOURCE_LOAD_VIEWS', true),
    ],

    /*
    |--------------------------------------------------------------------------
    | Middleware
    |--------------------------------------------------------------------------
    |
    |
    */

    'middleware' => [
        'default' => env('PLAYGROUND_MATRIX_RESOURCE_MIDDLEWARE_DEFAULT', ['web']),
        'auth' => env('PLAYGROUND_MATRIX_RESOURCE_MIDDLEWARE_AUTH', ['web', 'auth']),
        'guest' => env('PLAYGROUND_MATRIX_RESOURCE_MIDDLEWARE_GUEST', ['web']),
    ],

    /*
    |--------------------------------------------------------------------------
    | Policies
    |--------------------------------------------------------------------------
    |
    |
    */

    'policies' => [
        Backlog::class => BacklogPolicy::class,
        Board::class => BoardPolicy::class,
        Epic::class => EpicPolicy::class,
        Flow::class => FlowPolicy::class,
        Matrix::class => MatrixPolicy::class,
        Milestone::class => MilestonePolicy::class,
        Note::class => NotePolicy::class,
        Project::class => ProjectPolicy::class,
        Release::class => ReleasePolicy::class,
        Roadmap::class => RoadmapPolicy::class,
        Source::class => SourcePolicy::class,
        Sprint::class => SprintPolicy::class,
        Tag::class => TagPolicy::class,
        Team::class => TeamPolicy::class,
        Ticket::class => TicketPolicy::class,
        Version::class => VersionPolicy::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Routes
    |--------------------------------------------------------------------------
    |
    |
    */

    'routes' => [
        'matrix' => (bool) env('PLAYGROUND_MATRIX_RESOURCE_ROUTES_MATRIX', true),
        'backlogs' => (bool) env('PLAYGROUND_MATRIX_RESOURCE_ROUTES_BACKLOGS', true),
        'boards' => (bool) env('PLAYGROUND_MATRIX_RESOURCE_ROUTES_BOARDS', true),
        'epics' => (bool) env('PLAYGROUND_MATRIX_RESOURCE_ROUTES_EPICS', true),
        'flows' => (bool) env('PLAYGROUND_MATRIX_RESOURCE_ROUTES_FLOWS', true),
        'matrices' => (bool) env('PLAYGROUND_MATRIX_RESOURCE_ROUTES_MATRICES', true),
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

    /*
    |--------------------------------------------------------------------------
    | Sitemap
    |--------------------------------------------------------------------------
    |
    |
    */

    'sitemap' => [
        'enable' => (bool) env('PLAYGROUND_MATRIX_RESOURCE_SITEMAP_ENABLE', true),
        'guest' => (bool) env('PLAYGROUND_MATRIX_RESOURCE_SITEMAP_GUEST', true),
        'user' => (bool) env('PLAYGROUND_MATRIX_RESOURCE_SITEMAP_USER', true),
        'view' => env('PLAYGROUND_MATRIX_RESOURCE_SITEMAP_VIEW', 'playground-matrix-resource::sitemap'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Templates
    |--------------------------------------------------------------------------
    |
    |
    */

    'blade' => env('PLAYGROUND_MATRIX_RESOURCE_BLADE', 'playground-matrix-resource::'),

    /*
    |--------------------------------------------------------------------------
    | Abilities
    |--------------------------------------------------------------------------
    |
    |
    */

    'abilities' => [
        'admin' => [
            'playground-matrix-resource:*',
        ],
        'manager' => [
            'playground-matrix-resource:backlog:*',
            'playground-matrix-resource:board:*',
            'playground-matrix-resource:epic:*',
            'playground-matrix-resource:flow:*',
            'playground-matrix-resource:matrix:*',
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
            'playground-matrix-resource:matrix:view',
            'playground-matrix-resource:matrix:viewAny',
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
            'playground-matrix-resource:version:view',
            'playground-matrix-resource:version:viewAny',
        ],
    ],
];
