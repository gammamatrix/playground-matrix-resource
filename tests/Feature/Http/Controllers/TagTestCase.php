<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Tests\Feature\Playground\Matrix\Resource\Http\Controllers;

use PHPUnit\Framework\Attributes\CoversClass;
use Playground\Matrix\Resource\Http\Controllers\TagController;
use Playground\Matrix\Resource\Http\Requests;
use Playground\Matrix\Resource\Http\Resources;
use Playground\Matrix\Resource\Policies\TagPolicy;

/**
 * \Tests\Feature\Playground\Matrix\Resource\Http\Controllers\TagTestCase
 */
#[CoversClass(TagController::class)]
#[CoversClass(TagPolicy::class)]
#[CoversClass(Requests\Tag\CreateRequest::class)]
#[CoversClass(Requests\Tag\DestroyRequest::class)]
#[CoversClass(Requests\Tag\EditRequest::class)]
#[CoversClass(Requests\Tag\IndexRequest::class)]
#[CoversClass(Requests\Tag\LockRequest::class)]
#[CoversClass(Requests\Tag\RestoreRequest::class)]
#[CoversClass(Requests\Tag\ShowRequest::class)]
#[CoversClass(Requests\Tag\StoreRequest::class)]
#[CoversClass(Requests\Tag\UnlockRequest::class)]
#[CoversClass(Requests\Tag\UpdateRequest::class)]
#[CoversClass(Resources\Tag::class)]
#[CoversClass(Resources\TagCollection::class)]
class TagTestCase extends TestCase
{
    public string $fqdn = \Playground\Matrix\Models\Tag::class;

    /**
     * @var array<string, string>
     */
    public array $packageInfo = [
        'model_attribute' => 'title',
        'model_label' => 'Tag',
        'model_label_plural' => 'Tags',
        'model_route' => 'playground.matrix.resource.tags',
        'model_slug' => 'tag',
        'model_slug_plural' => 'tags',
        'module_label' => 'Matrix',
        'module_label_plural' => 'Matrices',
        'module_route' => 'playground.matrix.resource',
        'module_slug' => 'matrix',
        'privilege' => 'playground-matrix-resource:tag',
        'table' => 'matrix_tags',
        'view' => 'playground.matrix.resource::tag',
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
        'tag_type',
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
