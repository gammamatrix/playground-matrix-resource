<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Tests\Feature\Playground\Matrix\Resource\Http\Controllers;

use PHPUnit\Framework\Attributes\CoversClass;
use Playground\Matrix\Resource\Http\Controllers\ReleaseController;
use Playground\Matrix\Resource\Http\Requests;
use Playground\Matrix\Resource\Http\Resources;
use Playground\Matrix\Resource\Policies\ReleasePolicy;

/**
 * \Tests\Feature\Playground\Matrix\Resource\Http\Controllers\ReleaseTestCase
 */
#[CoversClass(ReleaseController::class)]
#[CoversClass(ReleasePolicy::class)]
#[CoversClass(Requests\Release\CreateRequest::class)]
#[CoversClass(Requests\Release\DestroyRequest::class)]
#[CoversClass(Requests\Release\EditRequest::class)]
#[CoversClass(Requests\Release\IndexRequest::class)]
#[CoversClass(Requests\Release\LockRequest::class)]
#[CoversClass(Requests\Release\RestoreRequest::class)]
#[CoversClass(Requests\Release\ShowRequest::class)]
#[CoversClass(Requests\Release\StoreRequest::class)]
#[CoversClass(Requests\Release\UnlockRequest::class)]
#[CoversClass(Requests\Release\UpdateRequest::class)]
#[CoversClass(Resources\Release::class)]
#[CoversClass(Resources\ReleaseCollection::class)]
class ReleaseTestCase extends TestCase
{
    public string $fqdn = \Playground\Matrix\Models\Release::class;

    /**
     * @var array<string, string>
     */
    public array $packageInfo = [
        'model_attribute' => 'title',
        'model_label' => 'Release',
        'model_label_plural' => 'Releases',
        'model_route' => 'playground.matrix.resource.releases',
        'model_slug' => 'release',
        'model_slug_plural' => 'releases',
        'module_label' => 'Matrix',
        'module_label_plural' => 'Matrices',
        'module_route' => 'playground.matrix.resource',
        'module_slug' => 'matrix',
        'privilege' => 'playground-matrix-resource:release',
        'table' => 'matrix_releases',
        'view' => 'playground.matrix.resource::release',
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
        'release_type',
        'backlog_id',
        'board_id',
        'epic_id',
        'flow_id',
        'matrix_id',
        'milestone_id',
        'note_id',
        'project_id',
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
