<?php
/**
 * Playground
 */
namespace Playground\Matrix\Resource\Http\Requests\Concerns;

/**
 * \Playground\Matrix\Resource\Http\Requests\Concerns\PaginationFlags
 */
trait PaginationFlags
{
    /**
     * @var array<string, mixed>
     */
    protected array $paginationFlags = [
        'active' => ['label' => 'Active'],
        'flagged' => ['label' => 'Flagged'],
        'locked' => ['label' => 'Locked'],
    ];

    /**
     * @return array<string, mixed>
     */
    public function getPaginationFlags(): array
    {
        return $this->paginationFlags;
    }

    /**
     * @param array<string, mixed> $rules
     */
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
