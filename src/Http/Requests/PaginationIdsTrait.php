<?php
/**
 * GammaMatrix
 */

namespace GammaMatrix\Playground\Matrix\Resource\Http\Requests;

/**
 * \GammaMatrix\Playground\Matrix\Resource\Http\Requests\PaginationIdsTrait
 */
trait PaginationIdsTrait
{
    protected array $paginationIds = [
        'id' => ['label' => 'ID', 'type' => 'uuid'],
        // 'created_by_id' => ['label' => 'Created By', 'type' => 'uuid'],
        // 'modified_by_id' => ['label' => 'Modified By', 'type' => 'uuid'],
        // 'owned_by_id' => ['label' => 'Owner', 'type' => 'uuid'],
        // 'parent_id' => ['label' => 'Parent', 'type' => 'uuid'],
    ];

    public function getPaginationIds(): array
    {
        return $this->paginationIds;
    }

    public function rules_filters_ids(array &$rules): void
    {
        foreach ($this->getPaginationIds() as $column => $meta) {
            if (empty($column) || !is_string($column)) {
                continue;
            }

            $rule_key = sprintf('filter.%1$s', $column);

            $rules[$rule_key] = 'nullable';
        }
    }

    public function prepareForValidationIds(): ?array
    {
        $filter = $this->input('filter');

        $merge = false;

        foreach ($this->getPaginationIds() as $column => $meta) {
            if (!empty($filter[$column])) {
                $id = [];
                if (is_array($filter[$column])) {
                    foreach ($filter[$column] as $key => $value) {
                        if (!empty($meta['type']) && 'integer' === $meta['type']) {
                            if (is_numeric($value) && $value > 0) {
                                $id[] = intval($value);
                            }
                        } else {
                            if (is_string($value) && $value) {
                                $id[] = $value;
                            }
                        }
                    }
                } elseif (is_numeric($filter[$column]) && $filter[$column] > 0) {
                    $id[] = intval($filter[$column]);
                } elseif (is_string($filter[$column]) && $filter[$column]) {
                    $id[] = $filter[$column];
                }
                $filter[$column] = $id;
                $merge = true;
            }
        }

        if ($merge) {
            $this->merge([
                'filter' => $filter,
            ]);
        }

        return $filter;
    }
}
