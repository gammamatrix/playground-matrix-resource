<?php

/**
 * Playground
 */

declare(strict_types=1);
namespace Tests\Feature\Playground\Matrix\Resource\Http\Controllers;

/**
 * \Tests\Feature\Playground\Matrix\Resource\Http\Controllers\EpicTestCase
 */
class EpicTestCase extends TestCase
{
    public string $fqdn = \Playground\Matrix\Models\Epic::class;

    /**
     * @var array<string, string>
     */
    public array $packageInfo = [
        'model_attribute' => 'title',
        'model_label' => 'Epic',
        'model_label_plural' => 'Epics',
        'model_route' => 'playground.matrix.resource.epics',
        'model_slug' => 'epic',
        'model_slug_plural' => 'epics',
        'module_label' => 'Matrix',
        'module_label_plural' => 'Matrices',
        'module_route' => 'playground.matrix.resource',
        'module_slug' => 'matrix',
        'privilege' => 'playground-matrix-resource:epic',
        'table' => 'matrix_epics',
        'view' => 'playground.matrix.resource::epic',
    ];

    /**
     * @var array<int, string>
     */
    protected $structure_model = [
        'id',
        'epic_type',
        'created_by_id',
        'modified_by_id',
        'owned_by_id',
        'parent_id',
        'backlog_id',
        'board_id',
        'flow_id',
        'matrix_id',
        'milestone_id',
        'note_id',
        'project_id',
        'release_id',
        'roadmap_id',
        'source_id',
        'sprint_id',
        'tag_id',
        'team_id',
        'ticket_id',
        'version_id',
        'created_at',
        'updated_at',
        'deleted_at',
        'canceled_at',
        'closed_at',
        'embargo_at',
        'planned_end_at',
        'planned_start_at',
        'postponed_at',
        'published_at',
        'resolved_at',
        'resumed_at',
        'suspended_at',
        'timer_end_at',
        'timer_start_at',
        'gids',
        'po',
        'pg',
        'pw',
        'only_admin',
        'only_user',
        'only_guest',
        'allow_public',
        'status',
        'rank',
        'size',
        'matrix',
        'x',
        'y',
        'z',
        'r',
        'theta',
        'rho',
        'phi',
        'elevation',
        'latitude',
        'longitude',
        'active',
        'canceled',
        'closed',
        'completed',
        'cron',
        'featured',
        'flagged',
        'internal',
        'locked',
        'pending',
        'planned',
        'prioritized',
        'problem',
        'published',
        'released',
        'retired',
        'special',
        'suspended',
        'unknown',
        'locale',
        'label',
        'title',
        'byline',
        'slug',
        'url',
        'description',
        'introduction',
        'content',
        'summary',
        'icon',
        'image',
        'avatar',
        'ui',
        'assets',
        'backlog',
        'board',
        'flow',
        'history',
        'meta',
        'notes',
        'options',
        'roadmap',
        'sources',
    ];
}
