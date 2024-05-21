<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Tests\Feature\Playground\Matrix\Resource\Http\Controllers;

use PHPUnit\Framework\Attributes\CoversClass;
use Playground\Matrix\Resource\Http\Controllers\VersionController;
use Playground\Matrix\Resource\Http\Requests;
use Playground\Matrix\Resource\Http\Resources;
use Playground\Matrix\Resource\Policies\VersionPolicy;

/**
 * \Tests\Feature\Playground\Matrix\Resource\Http\Controllers\VersionTestCase
 */
#[CoversClass(VersionController::class)]
#[CoversClass(VersionPolicy::class)]
#[CoversClass(Requests\Version\CreateRequest::class)]
#[CoversClass(Requests\Version\DestroyRequest::class)]
#[CoversClass(Requests\Version\EditRequest::class)]
#[CoversClass(Requests\Version\IndexRequest::class)]
#[CoversClass(Requests\Version\LockRequest::class)]
#[CoversClass(Requests\Version\RestoreRequest::class)]
#[CoversClass(Requests\Version\ShowRequest::class)]
#[CoversClass(Requests\Version\StoreRequest::class)]
#[CoversClass(Requests\Version\UnlockRequest::class)]
#[CoversClass(Requests\Version\UpdateRequest::class)]
#[CoversClass(Resources\Version::class)]
#[CoversClass(Resources\VersionCollection::class)]
class VersionTestCase extends TestCase
{
    public string $fqdn = \Playground\Matrix\Models\Version::class;

    /**
     * @var array<string, string>
     */
    public array $packageInfo = [
        'model_attribute' => 'title',
        'model_label' => 'Version',
        'model_label_plural' => 'Versions',
        'model_route' => 'playground.matrix.resource.versions',
        'model_slug' => 'version',
        'model_slug_plural' => 'versions',
        'module_label' => 'Matrix',
        'module_label_plural' => 'Matrices',
        'module_route' => 'playground.matrix.resource',
        'module_slug' => 'matrix',
        'privilege' => 'playground-matrix-resource:version',
        'table' => 'matrix_versions',
        'view' => 'playground.matrix.resource::version',
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
        'version_type',
        'matrix_id',
        'created_at',
        'updated_at',
        'deleted_at',
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
        'flagged',
        'internal',
        'locked',
        'retired',
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
