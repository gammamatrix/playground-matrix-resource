<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Tests\Feature\Playground\Matrix\Resource\Http\Controllers;

use PHPUnit\Framework\Attributes\CoversClass;
use Playground\Matrix\Resource\Http\Controllers\RoadmapController;
use Playground\Matrix\Resource\Http\Requests;
use Playground\Matrix\Resource\Http\Resources;
use Playground\Matrix\Resource\Policies\RoadmapPolicy;

/**
 * \Tests\Feature\Playground\Matrix\Resource\Http\Controllers\RoadmapTestCase
 */
#[CoversClass(RoadmapController::class)]
#[CoversClass(RoadmapPolicy::class)]
#[CoversClass(Requests\Roadmap\CreateRequest::class)]
#[CoversClass(Requests\Roadmap\DestroyRequest::class)]
#[CoversClass(Requests\Roadmap\EditRequest::class)]
#[CoversClass(Requests\Roadmap\IndexRequest::class)]
#[CoversClass(Requests\Roadmap\LockRequest::class)]
#[CoversClass(Requests\Roadmap\RestoreRequest::class)]
#[CoversClass(Requests\Roadmap\ShowRequest::class)]
#[CoversClass(Requests\Roadmap\StoreRequest::class)]
#[CoversClass(Requests\Roadmap\UnlockRequest::class)]
#[CoversClass(Requests\Roadmap\UpdateRequest::class)]
#[CoversClass(Resources\Roadmap::class)]
#[CoversClass(Resources\RoadmapCollection::class)]
class RoadmapTestCase extends TestCase
{
    public string $fqdn = \Playground\Matrix\Models\Roadmap::class;

    /**
     * @var array<string, string>
     */
    public array $packageInfo = [
        'model_attribute' => 'title',
        'model_label' => 'Roadmap',
        'model_label_plural' => 'Roadmaps',
        'model_route' => 'playground.matrix.resource.roadmaps',
        'model_slug' => 'roadmap',
        'model_slug_plural' => 'roadmaps',
        'module_label' => 'Matrix',
        'module_label_plural' => 'Matrices',
        'module_route' => 'playground.matrix.resource',
        'module_slug' => 'matrix',
        'privilege' => 'playground-matrix-resource:roadmap',
        'table' => 'matrix_roadmaps',
        'view' => 'playground.matrix.resource::roadmap',
    ];

    /**
     * @var array<int, string>
     */
    protected $structure_model = [
        'id',
        'created_by_id',
        'modified_by_id',
        'owned_by_id',
        'parent_id',
        'roadmap_type',
        'backlog_id',
        'board_id',
        'epic_id',
        'flow_id',
        'matrix_id',
        'milestone_id',
        'note_id',
        'project_id',
        'release_id',
        'source_id',
        'sprint_id',
        'tag_id',
        'team_id',
        'ticket_id',
        'version_id',
        'created_at',
        'updated_at',
        'deleted_at',
        'start_at',
        'planned_start_at',
        'end_at',
        'planned_end_at',
        'canceled_at',
        'closed_at',
        'embargo_at',
        'postponed_at',
        'published_at',
        'released_at',
        'resumed_at',
        'suspended_at',
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
        'flagged',
        'internal',
        'locked',
        'pending',
        'planned',
        'problem',
        'published',
        'released',
        'suspended',
        'unknown',
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
        'meta',
        'notes',
        'options',
        'roadmap',
        'sources',
    ];
}
