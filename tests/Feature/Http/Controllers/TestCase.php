<?php
/**
 * Playground
 */
namespace Tests\Feature\Playground\Matrix\Resource\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Playground\Test\Feature\Http\Controllers\Resource;
use Tests\Feature\Playground\Matrix\Resource\TestCase as BaseTestCase;

/**
 * \Tests\Feature\Playground\Matrix\Resource\Http\Controllers\TestCase
 */
class TestCase extends BaseTestCase
{
    use Resource\Playground\CreateJsonTrait;
    use Resource\Playground\CreateTrait;
    use Resource\Playground\DestroyJsonTrait;
    use Resource\Playground\DestroyTrait;
    use Resource\Playground\EditJsonTrait;
    use Resource\Playground\EditTrait;
    use Resource\Playground\IndexJsonTrait;
    use Resource\Playground\IndexTrait;
    use Resource\Playground\LockJsonTrait;
    use Resource\Playground\LockTrait;
    use Resource\Playground\RestoreJsonTrait;
    use Resource\Playground\RestoreTrait;
    use Resource\Playground\ShowJsonTrait;
    use Resource\Playground\ShowTrait;
    use Resource\Playground\UnlockJsonTrait;
    use Resource\Playground\UnlockTrait;

    /**
     * @var array<string, string>
     */
    public array $packageInfo = [
        'model_attribute' => 'label',
        'model_label' => '',
        'model_label_plural' => '',
        'model_route' => '',
        'model_slug' => '',
        'model_slug_plural' => '',
        'module_label' => 'Matrix',
        'module_label_plural' => 'Matrices',
        'module_route' => 'playground.matrix.resource',
        'module_slug' => 'matrix',
        'privilege' => '',
        'table' => '',
        'view' => '',
    ];

    /**
     * @var class-string<Model>
     */
    public string $fqdn = Model::class;

    /**
     * @var array<int, string>
     */
    protected $structure_model = [
        'id',
    ];

    /**
     * @return class-string<Model>
     */
    public function getGetFqdn(): string
    {
        return $this->fqdn;
    }

    /**
     * @return array<string, string>
     */
    public function getPackageInfo(): array
    {
        return $this->packageInfo;
    }

    /**
     * @return array<string, mixed>
     */
    public function getStructureCreate(): array
    {
        return [
            'data' => array_diff($this->structure_model, [
                'id',
            ]),
            'meta' => [
                'timestamp',
            ],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function getStructureData(): array
    {
        return [
            'data' => $this->structure_model,
            'meta' => [
                'timestamp',
            ],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function getStructureEdit(): array
    {
        return [
            'data' => $this->structure_model,
            'meta' => [
                'timestamp',
            ],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function getStructureIndex(): array
    {
        return [
            'data' => [
                '*' => $this->structure_model,
            ],
            'meta' => [
                'session_user_id',
                'sortable',
                'timestamp',
                'validated' => [
                    'perPage',
                    'page',
                ],
                // 'pagination' => [
                //     'count',
                //     'current_page',
                //     'links' => [
                //         'first',
                //         'last',
                //         'next',
                //         'path',
                //         'previous',
                //     ],
                //     'from',
                //     'last_page',
                //     'next_page',
                //     'per_page',
                //     'prev_page',
                //     'to',
                //     'total',
                //     'total_pages',
                // ],
            ],

        ];
    }
}
