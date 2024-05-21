<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Tests\Feature\Playground\Matrix\Resource\Http\Controllers;

use PHPUnit\Framework\Attributes\CoversClass;
use Playground\Matrix\Resource\Http\Controllers\NoteController;
use Playground\Matrix\Resource\Http\Requests;
use Playground\Matrix\Resource\Http\Resources;
use Playground\Matrix\Resource\Policies\NotePolicy;

/**
 * \Tests\Feature\Playground\Matrix\Resource\Http\Controllers\NoteTestCase
 */
#[CoversClass(NoteController::class)]
#[CoversClass(NotePolicy::class)]
#[CoversClass(Requests\Note\CreateRequest::class)]
#[CoversClass(Requests\Note\DestroyRequest::class)]
#[CoversClass(Requests\Note\EditRequest::class)]
#[CoversClass(Requests\Note\IndexRequest::class)]
#[CoversClass(Requests\Note\LockRequest::class)]
#[CoversClass(Requests\Note\RestoreRequest::class)]
#[CoversClass(Requests\Note\ShowRequest::class)]
#[CoversClass(Requests\Note\StoreRequest::class)]
#[CoversClass(Requests\Note\UnlockRequest::class)]
#[CoversClass(Requests\Note\UpdateRequest::class)]
#[CoversClass(Resources\Note::class)]
#[CoversClass(Resources\NoteCollection::class)]
class NoteTestCase extends TestCase
{
    public string $fqdn = \Playground\Matrix\Models\Note::class;

    /**
     * @var array<string, string>
     */
    public array $packageInfo = [
        'model_attribute' => 'title',
        'model_label' => 'Note',
        'model_label_plural' => 'Notes',
        'model_route' => 'playground.matrix.resource.notes',
        'model_slug' => 'note',
        'model_slug_plural' => 'notes',
        'module_label' => 'Matrix',
        'module_label_plural' => 'Matrices',
        'module_route' => 'playground.matrix.resource',
        'module_slug' => 'matrix',
        'privilege' => 'playground-matrix-resource:note',
        'table' => 'matrix_notes',
        'view' => 'playground.matrix.resource::note',
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
        'note_type',
        'matrix_id',
        'tag_id',
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
        'canceled',
        'closed',
        'completed',
        'flagged',
        'internal',
        'locked',
        'pending',
        'planned',
        'problem',
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
