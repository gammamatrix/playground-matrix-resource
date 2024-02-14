<?php
/**
 * Playground
 */
namespace Playground\Matrix\Resource\Http\Requests\Contracts;

/**
 * \Playground\Matrix\Resource\Http\Requests\Contracts\PaginationFlags
 */
interface PaginationFlags
{
    /**
     * @return array<string, mixed>
     */
    public function getPaginationFlags(): array;

    /**
     * @param array<string, mixed> $rules
     */
    public function rules_filters_flags(array &$rules): void;
}
