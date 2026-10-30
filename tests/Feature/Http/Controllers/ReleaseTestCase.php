<?php

/**
 * Playground
 */

declare(strict_types=1);

namespace Tests\Feature\Playground\Matrix\Resource\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Playground\Matrix\Models\Release;

/**
 * \Tests\Feature\Playground\Matrix\Resource\Http\Controllers\ReleaseTestCase
 */
class ReleaseTestCase extends PlaygroundCase
{
    /**
     * @var class-string<Model>
     */
    public string $fqdn = Release::class;

    /**
     * @var array<string, string>
     */
    public array $packageInfo = [
        'model_attribute' => 'title',
        'model_camel' => 'release',
        'model_camels' => 'releases',
        'model_kebab' => 'release',
        'model_kebabs' => 'releases',
        'model_lower' => 'release',
        'model_lowers' => 'releases',
        'model_label' => 'Release',
        'model_label_plural' => 'Releases',
        'model_labels' => 'Releases',
        'model_route' => 'playground.matrix.resource.releases',
        'model_route_param' => 'release',
        'model_slug' => 'release',
        'model_slugs' => 'releases',
        'model_slug_plural' => 'releases',
        'model_snake' => 'release',
        'model_snakes' => 'releases',
        'model_studly' => 'Release',
        'model_studlies' => 'Releases',
        'model_variable' => 'release',
        'model_variables' => 'releases',
        'model_variable_plural' => 'releases',
        'module_label' => 'Matrix',
        'module_label_plural' => 'Matrices',
        'module_route' => 'playground.matrix.resource',
        'module_slug' => 'matrix',
        'module_slugs' => 'matrices',
        'privilege' => 'playground-matrix-resource:release',
        'table' => 'matrix_releases',
        'view' => 'playground.matrix.resource::release',
    ];

    /**
     * @var array<int, string>
     */
    protected $structure_model = [
        'id',
        'release_type',
        'created_by_id',
        'modified_by_id',
        'owned_by_id',
        'parent_id',
        'matrix_id',
        'backlog_id',
        'board_id',
        'epic_id',
        'flow_id',
        'milestone_id',
        'note_id',
        'project_id',
        'roadmap_id',
        'source_id',
        'sprint_id',
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
