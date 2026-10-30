<?php

/**
 * Playground
 */

declare(strict_types=1);

namespace Tests\Feature\Playground\Matrix\Resource\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Playground\Matrix\Models\Tagged;

/**
 * \Tests\Feature\Playground\Matrix\Resource\Http\Controllers\TaggedTestCase
 */
class TaggedTestCase extends TestCase
{
    /**
     * @var class-string<Model>
     */
    public string $fqdn = Tagged::class;

    /**
     * @var array<string, string>
     */
    public array $packageInfo = [
        'model_attribute' => 'tag_id',
        'model_camel' => 'tagged',
        'model_camels' => 'tagged',
        'model_kebab' => 'tagged',
        'model_kebabs' => 'tagged',
        'model_lower' => 'tagged',
        'model_lowers' => 'tagged',
        'model_label' => 'Tagged',
        'model_label_plural' => 'Tagged',
        'model_labels' => 'Tagged',
        'model_route' => 'playground.matrix.resource.tagged',
        'model_route_param' => 'tagged',
        'model_slug' => 'tagged',
        'model_slugs' => 'tagged',
        'model_slug_plural' => 'tagged',
        'model_snake' => 'tagged',
        'model_snakes' => 'tagged',
        'model_studly' => 'Tagged',
        'model_studlies' => 'Tagged',
        'model_variable' => 'tagged',
        'model_variables' => 'tagged',
        'model_variable_plural' => 'tagged',
        'module_label' => 'Matrix',
        'module_label_plural' => 'Matrices',
        'module_route' => 'playground.matrix.resource',
        'module_slug' => 'matrix',
        'module_slugs' => 'matrices',
        'privilege' => 'playground-matrix-resource:tagged',
        'table' => 'matrix_tagged',
        'view' => 'playground.matrix.resource::tagged',
    ];

    /**
     * @var array<int, string>
     */
    protected $structure_model = [
        'id',
        'created_by_id',
        'tag_id',
        'matrix_id',
        'backlog_id',
        'board_id',
        'epic_id',
        'flow_id',
        'milestone_id',
        'note_id',
        'project_id',
        'release_id',
        'roadmap_id',
        'source_id',
        'sprint_id',
        'team_id',
        'ticket_id',
        'version_id',
        'created_at',
    ];
}
