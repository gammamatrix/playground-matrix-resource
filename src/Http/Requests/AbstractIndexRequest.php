<?php
/**
 * Playground
 */

namespace Playground\Matrix\Resource\Http\Requests;

/**
 * \Playground\Matrix\Resource\Http\Requests\AbstractIndexRequest
 */
abstract class AbstractIndexRequest extends FormRequest
{
    use PaginationDatesTrait;
    use PaginationFlagsTrait;
    use PaginationIdsTrait;
    use PaginationColumnsTrait;
    use PaginationSortableTrait;

    /**
     * The number of models to return for pagination.
     *
     * @var int
     */
    protected $perPage = 15;

    /**
     * The maximum number of models to return for pagination.
     *
     * @var int
     */
    protected $perPageMax = 100;

    public const RULES = [
        'perPage' => [
            'nullable',
            'integer',
        ],
        'page' => [
            'nullable',
            'integer',
        ],
        'sort' => [
            'nullable',
        ],
        'filter' => [
            'nullable',
            'array',
        ],
        // Trashed
        'filter.trash' => [
            'nullable',
            'in:hide,with,only',
        ],
    ];

    /**
     * @return array<string, mixed>
     */
    public function getPaginationOperators(): array
    {
        return [
            '|' => [],
            '&' => [],
            '=' => [],
            '!=' => [],
            '<>' => [],
            '<=>' => [],
            '<' => [],
            '<=' => [],
            '>=' => [],
            'NULL' => [],
            'NOTNULL' => [],
            'LIKE' => [],
            'NOTLIKE' => [],
            'BETWEEN' => [],
            'NOTBETWEEN' => [],
        ];
    }

    public function rules(): array
    {
        $rules = parent::rules();

        $this->rules_filters($rules);
        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '__FILE__' => __FILE__,
        //     '__LINE__' => __LINE__,
        //     '$rules' => $rules,
        // ]);

        // \Log::debug(__METHOD__, [
        //     '$action' => $action,
        //     '$rules' => $rules,
        // ]);
        return $rules;
    }

    public function rules_filters(array &$rules): void
    {
        if (method_exists($this, 'rules_filters_flags')) {
            $this->rules_filters_flags($rules);
        }
        if (method_exists($this, 'rules_filters_dates')) {
            $this->rules_filters_dates($rules);
        }
        if (method_exists($this, 'rules_filters_ids')) {
            $this->rules_filters_ids($rules);
        }
        if (method_exists($this, 'rules_filters_columns')) {
            $this->rules_filters_columns($rules);
        }
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '__FILE__' => __FILE__,
        //     '__LINE__' => __LINE__,
        //     '$this->input()' => $this->input(),
        // ]);

        $this->prepareForValidationPagination();

        if (method_exists($this, 'prepareForValidationForDates')) {
            $this->prepareForValidationForDates();
        }

        if (method_exists($this, 'prepareForValidationSort')) {
            $this->prepareForValidationSort();
        }
    }

    /**
     * Handle a passed validation attempt.
     *
     * @return void
     */
    protected function passedValidation()
    {
        // NOTE sort could be converted back to a string
    }

    public function prepareForValidationPagination(): array
    {
        $page = $this->get('page');
        $page = is_numeric($page) ? (int) abs($page) : null;
        $perPage = $this->get('perPage');
        $perPage = is_numeric($perPage) ? (int) abs($perPage) : $this->perPage;
        $perPage = $perPage > $this->perPageMax ? $this->perPageMax : $perPage;

        $this->merge([
            'page' => $page,
            'perPage' => $perPage,
        ]);

        return [
            'page' => $page,
            'perPage' => $perPage,
        ];
    }
}
