<?php
/**
 * GammaMatrix
 */

namespace GammaMatrix\Playground\Matrix\Resource\Http\Requests;

/**
 * \GammaMatrix\Playground\Matrix\Resource\Http\Requests\PaginationColumnsTrait
 */
trait PaginationColumnsTrait
{
    protected array $paginationColumns = [
        'label' => ['label' => 'Label', 'type' => 'string'],
        // 'slug' => ['label' => 'Slug', 'type' => 'string'],
        // 'byline' => ['label' => 'Byline', 'type' => 'string'],
        // 'content' => ['label' => 'Content', 'type' => 'string'],
        // 'description' => ['label' => 'Description', 'type' => 'string'],
        // 'introduction' => ['label' => 'Introduction', 'type' => 'string'],
        // 'summary' => ['label' => 'Summary', 'type' => 'string'],
        // 'url' => ['label' => 'URL', 'type' => 'string'],
        // 'rank' => ['label' => 'Rank', 'type' => 'integer'],
    ];

    public function getPaginationColumns(): array
    {
        return $this->paginationColumns;
    }

    public function rules_filters_columns(array &$rules): void
    {
        foreach ($this->getPaginationColumns() as $column => $meta) {
            if (empty($column) || !is_string($column)) {
                continue;
            }

            $rule_key = sprintf('filter.%1$s', $column);

            $nullable = array_key_exists('nullable', $meta) && is_bool($meta['nullable']) ? $meta['nullable'] : true;

            $set_rules = [];

            if ($nullable) {
                $set_rules[] = 'nullable';
            } else {
                // sometimes does not work here
                $set_rules[] = 'nullable';
            }

            if (!empty($meta['type'])
                && is_string($meta['type'])
            ) {
                // Dates
                if (in_array($meta['type'], [
                    'date',
                    'datetime',
                ])) {
                    $set_rules[] = 'datetime';
                } elseif (in_array($meta['type'], [
                    'float',
                    'decimal',
                ])) {
                    $set_rules[] = 'float';
                } elseif (in_array($meta['type'], [
                    'integer',
                ])) {
                    $set_rules[] = 'integer';
                } elseif (in_array($meta['type'], [
                    'string',
                ])) {
                    $set_rules[] = 'string';
                }
            }

            $rules[$rule_key] = $set_rules;
        }
    }
}
