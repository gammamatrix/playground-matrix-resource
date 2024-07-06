<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Tests\Feature\Playground\Matrix\Resource\Http\Controllers;

use PHPUnit\Framework\Attributes\CoversClass;
use Playground\Matrix\Resource\Http\Controllers\EpicController;
use Playground\Matrix\Resource\Http\Requests;
use Playground\Matrix\Resource\Http\Resources;
use Playground\Matrix\Resource\Policies\EpicPolicy;

/**
 * \Tests\Feature\Playground\Matrix\Resource\Http\Controllers\EpicTestCase
 */
#[CoversClass(EpicController::class)]
#[CoversClass(EpicPolicy::class)]
#[CoversClass(Requests\Epic\CreateRequest::class)]
#[CoversClass(Requests\Epic\DestroyRequest::class)]
#[CoversClass(Requests\Epic\EditRequest::class)]
#[CoversClass(Requests\Epic\IndexRequest::class)]
#[CoversClass(Requests\Epic\LockRequest::class)]
#[CoversClass(Requests\Epic\RestoreRequest::class)]
#[CoversClass(Requests\Epic\ShowRequest::class)]
#[CoversClass(Requests\Epic\StoreRequest::class)]
#[CoversClass(Requests\Epic\UnlockRequest::class)]
#[CoversClass(Requests\Epic\UpdateRequest::class)]
#[CoversClass(Resources\Epic::class)]
#[CoversClass(Resources\EpicCollection::class)]
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
        'created_by_id',
        'modified_by_id',
        'owned_by_id',
        'parent_id',
        'epic_type',
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
        'start_at',
        'planned_start_at',
        'end_at',
        'planned_end_at',
        'canceled_at',
        'closed_at',
        'embargo_at',
        'fixed_at',
        'postponed_at',
        'published_at',
        'released_at',
        'resumed_at',
        'resolved_at',
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
