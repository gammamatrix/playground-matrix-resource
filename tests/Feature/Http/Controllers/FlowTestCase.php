<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Tests\Feature\Playground\Matrix\Resource\Http\Controllers;

use PHPUnit\Framework\Attributes\CoversClass;
use Playground\Matrix\Resource\Http\Controllers\FlowController;
use Playground\Matrix\Resource\Http\Requests;
use Playground\Matrix\Resource\Http\Resources;
use Playground\Matrix\Resource\Policies\FlowPolicy;

/**
 * \Tests\Feature\Playground\Matrix\Resource\Http\Controllers\FlowTestCase
 */
#[CoversClass(FlowController::class)]
#[CoversClass(FlowPolicy::class)]
#[CoversClass(Requests\Flow\CreateRequest::class)]
#[CoversClass(Requests\Flow\DestroyRequest::class)]
#[CoversClass(Requests\Flow\EditRequest::class)]
#[CoversClass(Requests\Flow\IndexRequest::class)]
#[CoversClass(Requests\Flow\LockRequest::class)]
#[CoversClass(Requests\Flow\RestoreRequest::class)]
#[CoversClass(Requests\Flow\ShowRequest::class)]
#[CoversClass(Requests\Flow\StoreRequest::class)]
#[CoversClass(Requests\Flow\UnlockRequest::class)]
#[CoversClass(Requests\Flow\UpdateRequest::class)]
#[CoversClass(Resources\Flow::class)]
#[CoversClass(Resources\FlowCollection::class)]
class FlowTestCase extends TestCase
{
    public string $fqdn = \Playground\Matrix\Models\Flow::class;

    /**
     * @var array<string, string>
     */
    public array $packageInfo = [
        'model_attribute' => 'title',
        'model_label' => 'Flow',
        'model_label_plural' => 'Flows',
        'model_route' => 'playground.matrix.resource.flows',
        'model_slug' => 'flow',
        'model_slug_plural' => 'flows',
        'module_label' => 'Matrix',
        'module_label_plural' => 'Matrices',
        'module_route' => 'playground.matrix.resource',
        'module_slug' => 'matrix',
        'privilege' => 'playground-matrix-resource:flow',
        'table' => 'matrix_flows',
        'view' => 'playground.matrix.resource::flow',
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
        'flow_type',
        'matrix_id',
        'note_id',
        'tag_id',
        'team_id',
        'created_at',
        'updated_at',
        'deleted_at',
        'start_at',
        'planned_start_at',
        'end_at',
        'planned_end_at',
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
