<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Tests\Feature\Playground\Matrix\Resource\Http\Controllers;

use PHPUnit\Framework\Attributes\CoversClass;
use Playground\Matrix\Resource\Http\Controllers\ProjectController;
use Playground\Matrix\Resource\Http\Requests;
use Playground\Matrix\Resource\Http\Resources;
use Playground\Matrix\Resource\Policies\ProjectPolicy;

/**
 * \Tests\Feature\Playground\Matrix\Resource\Http\Controllers\ProjectTestCase
 */
#[CoversClass(ProjectController::class)]
#[CoversClass(ProjectPolicy::class)]
#[CoversClass(Requests\Project\CreateRequest::class)]
#[CoversClass(Requests\Project\DestroyRequest::class)]
#[CoversClass(Requests\Project\EditRequest::class)]
#[CoversClass(Requests\Project\IndexRequest::class)]
#[CoversClass(Requests\Project\LockRequest::class)]
#[CoversClass(Requests\Project\RestoreRequest::class)]
#[CoversClass(Requests\Project\ShowRequest::class)]
#[CoversClass(Requests\Project\StoreRequest::class)]
#[CoversClass(Requests\Project\UnlockRequest::class)]
#[CoversClass(Requests\Project\UpdateRequest::class)]
#[CoversClass(Resources\Project::class)]
#[CoversClass(Resources\ProjectCollection::class)]
class ProjectTestCase extends TestCase
{
    public string $fqdn = \Playground\Matrix\Models\Project::class;

    /**
     * @var array<string, string>
     */
    public array $packageInfo = [
        'model_attribute' => 'title',
        'model_label' => 'Project',
        'model_label_plural' => 'Projects',
        'model_route' => 'playground.matrix.resource.projects',
        'model_slug' => 'project',
        'model_slug_plural' => 'projects',
        'module_label' => 'Matrix',
        'module_label_plural' => 'Matrices',
        'module_route' => 'playground.matrix.resource',
        'module_slug' => 'matrix',
        'privilege' => 'playground-matrix-resource:project',
        'table' => 'matrix_projects',
        'view' => 'playground.matrix.resource::project',
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
        'project_type',
        'backlog_id',
        'board_id',
        'epic_id',
        'flow_id',
        'matrix_id',
        'milestone_id',
        'note_id',
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
        'flagged',
        'internal',
        'locked',
        'pending',
        'planned',
        'problem',
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
        'key',
        'code_name',
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
