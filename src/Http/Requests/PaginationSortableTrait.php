<?php
/**
 * GammaMatrix
 */

namespace GammaMatrix\Playground\Matrix\Resource\Http\Requests;

/**
 * \GammaMatrix\Playground\Matrix\Resource\Http\Requests\PaginationSortableTrait
 */
trait PaginationSortableTrait
{
    protected array $sortable = [
        'label' => ['label' => 'Label', 'type' => 'string'],
        // 'rank' => ['label' => 'Rank', 'type' => 'numeric'],
        // 'slug' => ['label' => 'Slug', 'type' => 'string'],
        // 'active' => ['label' => 'Active', 'type' => 'boolean'],
        // 'flagged' => ['label' => 'Flagged', 'type' => 'boolean'],
        // 'locked' => ['label' => 'Locked', 'type' => 'boolean'],
    ];

    public function getSortable(): array
    {
        return $this->sortable;
    }

    public function rules_sortable(array &$rules): void
    {
        $sortable = $this->getSortable();

        if (!empty($sortable)) {
            $rules['sort.*'] = [
                'string'
            ];
            $rules['sort.*'][] = sprintf('in:%1$s', sprintf(
                '%1$s,-%2$s',
                implode(',', array_keys($sortable)),
                implode(',-', array_keys($sortable))
            ));
        }
    }

    public function prepareForValidationSort(): void
    {
        $sortable = [];

        $sort = $this->input('sort');

        if (!empty($sort)) {
            if (is_string($sort)) {
                // Convert sort to array
                $sortable = explode(',', $sort);
            } elseif (is_array($sort)) {
                $sortable = $sort;
            }
        }

        $this->merge([
            'sort' => $sortable,
        ]);
    }
}
