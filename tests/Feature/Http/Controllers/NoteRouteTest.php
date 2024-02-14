<?php
/**
 * Playground
 */
namespace Tests\Feature\Playground\Matrix\Resource\Http\Controllers;

use Playground\Test\Feature\Http\Controllers\Resource;
use Tests\Feature\Playground\Matrix\Resource\TestCase;

/**
 * \Tests\Feature\Playground\Matrix\Resource\Http\Controllers\NoteRouteTest
 */
class NoteRouteTest extends TestCase
{
    use Resource\CreateTrait;
    use Resource\DestroyTrait;
    use Resource\EditTrait;
    use Resource\IndexTrait;
    use Resource\LockTrait;
    use Resource\RestoreTrait;
    use Resource\ShowTrait;
    use Resource\UnlockTrait;

    public string $fqdn = \Playground\Matrix\Models\Note::class;

    /**
     * @var array<string, string>
     */
    public array $packageInfo = [
        'model_attribute' => 'label',
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
        'view' => 'playground-matrix-resource::note',
    ];

    /**
     * @var array<string, mixed>
     */
    protected $structure_data = [
        'data' => [
            'id',
            'created_by_id',
            'modified_by_id',
            'owned_by_id',
            'parent_id',
            'note_type',
            // 'backlog_id',
            // 'board_id',
            // 'epic_id',
            // 'flow_id',
            // 'milestone_id',
            // 'project_id',
            // 'release_id',
            // 'roadmap_id',
            // 'source_id',
            // 'sprint_id',
            // 'tag_id',
            // 'team_id',
            // 'ticket_id',
            // 'version_id',
            'created_at',
            'deleted_at',
            'updated_at',
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
            'active',
            'canceled',
            'closed',
            'completed',
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
            'options',
            'roadmap',
            'sources',
        ],
        'meta' => [
            'id',
            'rules',
            'session_user_id',
            'timestamp',
            'validated',
        ],
    ];

    /**
     * @var array<string, mixed>
     */
    protected $structure_index = [
        'data' => [
            // This can be overriden with $structure_data
            '*' => [
                'id',
                'label',
                'title',
                'active',
                'locked',
                'created_at',
                'deleted_at',
                'updated_at',
            ],
        ],
        'meta' => [
            'session_user_id',
            'sortable',
            'timestamp',
            'validated' => [
                'per_page',
                'page',
            ],
            'pagination' => [
                'count',
                'current_page',
                'links' => [
                    'first',
                    'last',
                    'next',
                    'path',
                    'previous',
                ],
                'from',
                'last_page',
                'next_page',
                'per_page',
                'prev_page',
                'to',
                'total',
                'total_pages',
            ],
        ],
    ];
}
