<?php
/**
 * GammaMatrix
 */

namespace Tests\Feature\GammaMatrix\Playground\Matrix\Resource\Http\Controllers;

use GammaMatrix\Playground\Test\Feature\Http\Controllers\Resource;
use Tests\Feature\GammaMatrix\Playground\Matrix\Resource\TestCase;

/**
 * \Tests\Feature\GammaMatrix\Playground\Matrix\Resource\Http\Controllers\NoteRouteTest
 *
 */
class NoteRouteTest extends TestCase
{
    use Resource\CreateTrait;
    use Resource\EditTrait;
    use Resource\DestroyTrait;

    public string $fqdn = \GammaMatrix\Playground\Matrix\Models\Note::class;

    public array $packageInfo = [
        'model_attribute'     => 'label',
        'model_label'         => 'Note',
        'model_label_plural'  => 'Notes',
        'model_route'         => 'playground.matrix.resource.notes',
        'model_slug'          => 'note',
        'model_slug_plural'   => 'notes',
        'module_label'        => 'Matrix',
        'module_label_plural' => 'Matrices',
        'module_route'        => 'playground.matrix.resource',
        'module_slug'         => 'matrix',
        'privilege'           => 'playground-matrix-resource:note',
        'table'               => 'matrix_notes',
        'view'                => 'playground-matrix-resource::note',
    ];

    protected $structure_data = [
        'data' => [
        ],
        'meta' => [
            'id',
            'session_user_id',
            'timestamp',
            'validated',
            'info' => [
                'model_attribute',
                'model_label',
                'model_label_plural',
                'model_route',
                'model_slug_plural',
                'module_label',
                'module_label_plural',
                'module_route',
                'privilege',
                'table',
                'view',
            ],
            'input',
        ],
        '_method',
    ];

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
