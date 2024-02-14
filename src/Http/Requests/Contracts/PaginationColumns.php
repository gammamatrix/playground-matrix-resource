<?php
/**
 * Playground
 */
namespace Playground\Matrix\Resource\Http\Requests\Contracts;

/**
 * \Playground\Matrix\Resource\Http\Requests\Contracts\PaginationColumns
 */
interface PaginationColumns
{
    /**
     * @return array<string, mixed>
     */
    public function getPaginationColumns(): array;

    /**
     * @param array<string, mixed> $rules
     */
    public function rules_filters_columns(array &$rules): void;
}
