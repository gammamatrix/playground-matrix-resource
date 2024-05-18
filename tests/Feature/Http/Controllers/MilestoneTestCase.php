<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Tests\Feature\Playground\Matrix\Resource\Http\Controllers;

use PHPUnit\Framework\Attributes\CoversClass;
use Playground\Matrix\Resource\Http\Controllers\MilestoneController;
use Playground\Matrix\Resource\Http\Requests;
use Playground\Matrix\Resource\Http\Resources;
use Playground\Matrix\Resource\Policies\BacklogPolicy;

/**
 * \Tests\Feature\Playground\Matrix\Resource\Http\Controllers\MilestoneTestCase
 */
#[CoversClass(MilestoneController::class)]
#[CoversClass(Requests\Backlog\CreateRequest::class)]
#[CoversClass(Requests\Backlog\DestroyRequest::class)]
#[CoversClass(Requests\Backlog\EditRequest::class)]
#[CoversClass(Requests\Backlog\IndexRequest::class)]
#[CoversClass(Requests\Backlog\LockRequest::class)]
#[CoversClass(Requests\Backlog\RestoreRequest::class)]
#[CoversClass(Requests\Backlog\ShowRequest::class)]
#[CoversClass(Requests\Backlog\StoreRequest::class)]
#[CoversClass(Requests\Backlog\UnlockRequest::class)]
#[CoversClass(Requests\Backlog\UpdateRequest::class)]
#[CoversClass(Resources\Backlog::class)]
#[CoversClass(Resources\BacklogCollection::class)]
#[CoversClass(BacklogPolicy::class)]
class MilestoneTestCase extends TestCase
{
    public string $fqdn = \Playground\Matrix\Models\Milestone::class;

    /**
     * @var array<string, string>
     */
    public array $packageInfo = [
        'model_attribute' => 'title',
        'model_label' => 'Milestone',
        'model_label_plural' => 'Milestones',
        'model_route' => 'playground.matrix.resource.milestones',
        'model_slug' => 'milestone',
        'model_slug_plural' => 'milestones',
        'module_label' => 'Matrix',
        'module_label_plural' => 'Matrices',
        'module_route' => 'playground.matrix.resource',
        'module_slug' => 'matrix',
        'privilege' => 'playground-matrix-resource:milestone',
        'table' => 'matrix_milestones',
        'view' => 'playground.matrix.resource::milestone',
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
        'milestone_type',
        'backlog_id',
        'board_id',
        'epic_id',
        'flow_id',
        'matrix_id',
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
        'duplicate',
        'fixed',
        'flagged',
        'internal',
        'locked',
        'pending',
        'planned',
        'problem',
        'published',
        'released',
        'retired',
        'resolved',
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
