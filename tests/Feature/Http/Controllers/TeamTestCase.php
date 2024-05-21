<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Tests\Feature\Playground\Matrix\Resource\Http\Controllers;

use PHPUnit\Framework\Attributes\CoversClass;
use Playground\Matrix\Resource\Http\Controllers\TeamController;
use Playground\Matrix\Resource\Http\Requests;
use Playground\Matrix\Resource\Http\Resources;
use Playground\Matrix\Resource\Policies\TeamPolicy;

/**
 * \Tests\Feature\Playground\Matrix\Resource\Http\Controllers\TeamTestCase
 */
#[CoversClass(TeamController::class)]
#[CoversClass(TeamPolicy::class)]
#[CoversClass(Requests\Team\CreateRequest::class)]
#[CoversClass(Requests\Team\DestroyRequest::class)]
#[CoversClass(Requests\Team\EditRequest::class)]
#[CoversClass(Requests\Team\IndexRequest::class)]
#[CoversClass(Requests\Team\LockRequest::class)]
#[CoversClass(Requests\Team\RestoreRequest::class)]
#[CoversClass(Requests\Team\ShowRequest::class)]
#[CoversClass(Requests\Team\StoreRequest::class)]
#[CoversClass(Requests\Team\UnlockRequest::class)]
#[CoversClass(Requests\Team\UpdateRequest::class)]
#[CoversClass(Resources\Team::class)]
#[CoversClass(Resources\TeamCollection::class)]
class TeamTestCase extends TestCase
{
    public string $fqdn = \Playground\Matrix\Models\Team::class;

    /**
     * @var array<string, string>
     */
    public array $packageInfo = [
        'model_attribute' => 'title',
        'model_label' => 'Team',
        'model_label_plural' => 'Teams',
        'model_route' => 'playground.matrix.resource.teams',
        'model_slug' => 'team',
        'model_slug_plural' => 'teams',
        'module_label' => 'Matrix',
        'module_label_plural' => 'Matrices',
        'module_route' => 'playground.matrix.resource',
        'module_slug' => 'matrix',
        'privilege' => 'playground-matrix-resource:team',
        'table' => 'matrix_teams',
        'view' => 'playground.matrix.resource::team',
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
        'team_type',
        'backlog_id',
        'board_id',
        'epic_id',
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
        'retired',
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
