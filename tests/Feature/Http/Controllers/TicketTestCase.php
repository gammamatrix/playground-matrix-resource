<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Tests\Feature\Playground\Matrix\Resource\Http\Controllers;

use PHPUnit\Framework\Attributes\CoversClass;
use Playground\Matrix\Resource\Http\Controllers\TicketController;
use Playground\Matrix\Resource\Http\Requests;
use Playground\Matrix\Resource\Http\Resources;
use Playground\Matrix\Resource\Policies\TicketPolicy;

/**
 * \Tests\Feature\Playground\Matrix\Resource\Http\Controllers\TicketTestCase
 */
#[CoversClass(TicketController::class)]
#[CoversClass(TicketPolicy::class)]
#[CoversClass(Requests\Ticket\CreateRequest::class)]
#[CoversClass(Requests\Ticket\DestroyRequest::class)]
#[CoversClass(Requests\Ticket\EditRequest::class)]
#[CoversClass(Requests\Ticket\IndexRequest::class)]
#[CoversClass(Requests\Ticket\LockRequest::class)]
#[CoversClass(Requests\Ticket\RestoreRequest::class)]
#[CoversClass(Requests\Ticket\ShowRequest::class)]
#[CoversClass(Requests\Ticket\StoreRequest::class)]
#[CoversClass(Requests\Ticket\UnlockRequest::class)]
#[CoversClass(Requests\Ticket\UpdateRequest::class)]
#[CoversClass(Resources\Ticket::class)]
#[CoversClass(Resources\TicketCollection::class)]
class TicketTestCase extends TestCase
{
    public string $fqdn = \Playground\Matrix\Models\Ticket::class;

    /**
     * @var array<string, string>
     */
    public array $packageInfo = [
        'model_attribute' => 'title',
        'model_label' => 'Ticket',
        'model_label_plural' => 'Tickets',
        'model_route' => 'playground.matrix.resource.tickets',
        'model_slug' => 'ticket',
        'model_slug_plural' => 'tickets',
        'module_label' => 'Matrix',
        'module_label_plural' => 'Matrices',
        'module_route' => 'playground.matrix.resource',
        'module_slug' => 'matrix',
        'privilege' => 'playground-matrix-resource:ticket',
        'table' => 'matrix_tickets',
        'view' => 'playground.matrix.resource::ticket',
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
        'ticket_type',
        'backlog_id',
        'board_id',
        'completed_by_id',
        'duplicate_id',
        'epic_id',
        'fixed_by_id',
        'flow_id',
        'matrix_id',
        'milestone_id',
        'note_id',
        'project_id',
        'release_id',
        'reported_by_id',
        'roadmap_id',
        'source_id',
        'sprint_id',
        'tag_id',
        'team_id',
        'version_fixed_id',
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
        'prioritized',
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
        'handler',
        'key',
        'code',
        'key_code_hash',
        'priority',
        'severity',
        'resolution',
        'step',
        'state',
        'workflow_type',
        'points',
        'actual',
        'expected',
        'story',
        'steps',
        'criteria',
        'reproducibility',
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
