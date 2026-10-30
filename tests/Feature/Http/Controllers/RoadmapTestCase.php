<?php

/**
 * Playground
 */

declare(strict_types=1);

namespace Tests\Feature\Playground\Matrix\Resource\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Playground\Matrix\Models\Roadmap;

/**
 * \Tests\Feature\Playground\Matrix\Resource\Http\Controllers\RoadmapTestCase
 */
class RoadmapTestCase extends PlaygroundCase
{
    /**
     * @var class-string<Model>
     */
    public string $fqdn = Roadmap::class;

    /**
     * @var array<string, string>
     */
    public array $packageInfo = [
        'model_attribute' => 'title',
        'model_camel' => 'roadmap',
        'model_camels' => 'roadmaps',
        'model_kebab' => 'roadmap',
        'model_kebabs' => 'roadmaps',
        'model_lower' => 'roadmap',
        'model_lowers' => 'roadmaps',
        'model_label' => 'Roadmap',
        'model_label_plural' => 'Roadmaps',
        'model_labels' => 'Roadmaps',
        'model_route' => 'playground.matrix.resource.roadmaps',
        'model_route_param' => 'roadmap',
        'model_slug' => 'roadmap',
        'model_slugs' => 'roadmaps',
        'model_slug_plural' => 'roadmaps',
        'model_snake' => 'roadmap',
        'model_snakes' => 'roadmaps',
        'model_studly' => 'Roadmap',
        'model_studlies' => 'Roadmaps',
        'model_variable' => 'roadmap',
        'model_variables' => 'roadmaps',
        'model_variable_plural' => 'roadmaps',
        'module_label' => 'Matrix',
        'module_label_plural' => 'Matrices',
        'module_route' => 'playground.matrix.resource',
        'module_slug' => 'matrix',
        'module_slugs' => 'matrices',
        'privilege' => 'playground-matrix-resource:roadmap',
        'table' => 'matrix_roadmaps',
        'view' => 'playground.matrix.resource::roadmap',
    ];

    /**
     * @var array<int, string>
     */
    protected $structure_model = [
        'id',
        'roadmap_type',
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
        'release_id',
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
        'sources',
    ];
}
