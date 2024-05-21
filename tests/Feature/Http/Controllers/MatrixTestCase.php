<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Tests\Feature\Playground\Matrix\Resource\Http\Controllers;

use PHPUnit\Framework\Attributes\CoversClass;
use Playground\Matrix\Resource\Http\Controllers\MatrixController;
use Playground\Matrix\Resource\Http\Requests;
use Playground\Matrix\Resource\Http\Resources;
use Playground\Matrix\Resource\Policies\MatrixPolicy;

/**
 * \Tests\Feature\Playground\Matrix\Resource\Http\Controllers\MatrixTestCase
 */
#[CoversClass(MatrixController::class)]
#[CoversClass(MatrixPolicy::class)]
#[CoversClass(Requests\Matrix\CreateRequest::class)]
#[CoversClass(Requests\Matrix\DestroyRequest::class)]
#[CoversClass(Requests\Matrix\EditRequest::class)]
#[CoversClass(Requests\Matrix\IndexRequest::class)]
#[CoversClass(Requests\Matrix\LockRequest::class)]
#[CoversClass(Requests\Matrix\RestoreRequest::class)]
#[CoversClass(Requests\Matrix\ShowRequest::class)]
#[CoversClass(Requests\Matrix\StoreRequest::class)]
#[CoversClass(Requests\Matrix\UnlockRequest::class)]
#[CoversClass(Requests\Matrix\UpdateRequest::class)]
#[CoversClass(Resources\Matrix::class)]
#[CoversClass(Resources\MatrixCollection::class)]
class MatrixTestCase extends TestCase
{
    public string $fqdn = \Playground\Matrix\Models\Matrix::class;

    /**
     * @var array<string, string>
     */
    public array $packageInfo = [
        'model_attribute' => 'title',
        'model_label' => 'Matrix',
        'model_label_plural' => 'Matrices',
        'model_route' => 'playground.matrix.resource.matrices',
        'model_slug' => 'matrix',
        'model_slug_plural' => 'matrices',
        'module_label' => 'Matrix',
        'module_label_plural' => 'Matrices',
        'module_route' => 'playground.matrix.resource',
        'module_slug' => 'matrix',
        'privilege' => 'playground-matrix-resource:matrix',
        'table' => 'matrix_matrices',
        'view' => 'playground.matrix.resource::matrix',
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
        'matrix_type',
        'matrix_id',
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
        'meta',
        'notes',
        'options',
        'sources',
    ];
}
