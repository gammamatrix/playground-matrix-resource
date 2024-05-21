<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Tests\Feature\Playground\Matrix\Resource\Http\Controllers;

use PHPUnit\Framework\Attributes\CoversClass;
use Playground\Matrix\Resource\Http\Controllers\BoardController;
use Playground\Matrix\Resource\Http\Requests;
use Playground\Matrix\Resource\Http\Resources;
use Playground\Matrix\Resource\Policies\BoardPolicy;

/**
 * \Tests\Feature\Playground\Matrix\Resource\Http\Controllers\BoardTestCase
 */
#[CoversClass(BoardController::class)]
#[CoversClass(BoardPolicy::class)]
#[CoversClass(Requests\Board\CreateRequest::class)]
#[CoversClass(Requests\Board\DestroyRequest::class)]
#[CoversClass(Requests\Board\EditRequest::class)]
#[CoversClass(Requests\Board\IndexRequest::class)]
#[CoversClass(Requests\Board\LockRequest::class)]
#[CoversClass(Requests\Board\RestoreRequest::class)]
#[CoversClass(Requests\Board\ShowRequest::class)]
#[CoversClass(Requests\Board\StoreRequest::class)]
#[CoversClass(Requests\Board\UnlockRequest::class)]
#[CoversClass(Requests\Board\UpdateRequest::class)]
#[CoversClass(Resources\Board::class)]
#[CoversClass(Resources\BoardCollection::class)]
class BoardTestCase extends TestCase
{
    public string $fqdn = \Playground\Matrix\Models\Board::class;

    /**
     * @var array<string, string>
     */
    public array $packageInfo = [
        'model_attribute' => 'title',
        'model_label' => 'Board',
        'model_label_plural' => 'Boards',
        'model_route' => 'playground.matrix.resource.boards',
        'model_slug' => 'board',
        'model_slug_plural' => 'boards',
        'module_label' => 'Matrix',
        'module_label_plural' => 'Matrices',
        'module_route' => 'playground.matrix.resource',
        'module_slug' => 'matrix',
        'privilege' => 'playground-matrix-resource:board',
        'table' => 'matrix_boards',
        'view' => 'playground.matrix.resource::board',
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
        'board_type',
        'backlog_id',
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
