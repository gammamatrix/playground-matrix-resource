<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Tests\Feature\Playground\Matrix\Resource\Http\Controllers;

use PHPUnit\Framework\Attributes\CoversClass;
use Playground\Matrix\Resource\Http\Controllers\SourceController;
use Playground\Matrix\Resource\Http\Requests;
use Playground\Matrix\Resource\Http\Resources;
use Playground\Matrix\Resource\Policies\SourcePolicy;

/**
 * \Tests\Feature\Playground\Matrix\Resource\Http\Controllers\SourceTestCase
 */
#[CoversClass(SourceController::class)]
#[CoversClass(SourcePolicy::class)]
#[CoversClass(Requests\Source\CreateRequest::class)]
#[CoversClass(Requests\Source\DestroyRequest::class)]
#[CoversClass(Requests\Source\EditRequest::class)]
#[CoversClass(Requests\Source\IndexRequest::class)]
#[CoversClass(Requests\Source\LockRequest::class)]
#[CoversClass(Requests\Source\RestoreRequest::class)]
#[CoversClass(Requests\Source\ShowRequest::class)]
#[CoversClass(Requests\Source\StoreRequest::class)]
#[CoversClass(Requests\Source\UnlockRequest::class)]
#[CoversClass(Requests\Source\UpdateRequest::class)]
#[CoversClass(Resources\Source::class)]
#[CoversClass(Resources\SourceCollection::class)]
class SourceTestCase extends TestCase
{
    public string $fqdn = \Playground\Matrix\Models\Source::class;

    /**
     * @var array<string, string>
     */
    public array $packageInfo = [
        'model_attribute' => 'title',
        'model_label' => 'Source',
        'model_label_plural' => 'Sources',
        'model_route' => 'playground.matrix.resource.sources',
        'model_slug' => 'source',
        'model_slug_plural' => 'sources',
        'module_label' => 'Matrix',
        'module_label_plural' => 'Matrices',
        'module_route' => 'playground.matrix.resource',
        'module_slug' => 'matrix',
        'privilege' => 'playground-matrix-resource:source',
        'table' => 'matrix_sources',
        'view' => 'playground.matrix.resource::source',
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
        'source_type',
        'matrix_id',
        'tag_id',
        'team_id',
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
        'meta',
        'notes',
        'options',
        'sources',
    ];
}
