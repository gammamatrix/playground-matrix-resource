<?php
/**
 * GammaMatrix
 */

namespace GammaMatrix\Playground\Matrix\Resource\Http\Requests;

/**
 * \GammaMatrix\Playground\Matrix\Resource\Http\Requests\PaginationFlagsTrait
 */
trait PaginationFlagsTrait
{
    protected array $paginationFlags = [
        'active' => ['label' => 'Active'],
        'flagged' => ['label' => 'Flagged'],
        'locked' => ['label' => 'Locked'],
    ];

    public function getPaginationFlags(): array
    {
        return $this->paginationFlags;
    }

    public function rules_filters_flags(array &$rules): void
    {
        foreach ($this->getPaginationFlags() as $column => $meta) {
            if (empty($column) || ! is_string($column)) {
                continue;
            }

            $rule_key = sprintf('filter.%1$s', $column);

            $nullable = array_key_exists('nullable', $meta) && is_bool($meta['nullable']) ? $meta['nullable'] : true;

            $set_rules = [];

            if ($nullable) {
                $set_rules[] = 'nullable';
            }

            $set_rules[] = 'boolean';

            $rules[$rule_key] = $set_rules;
        }
    }
}
