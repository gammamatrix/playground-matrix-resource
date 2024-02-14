<?php
/**
 * Playground
 */
namespace Playground\Matrix\Resource\Http\Requests\Contracts;

/**
 * \Playground\Matrix\Resource\Http\Requests\Contracts\PaginationDates
 */
interface PaginationDates
{
    /**
     * @return array<string, mixed>
     */
    public function getPaginationDates(): array;

    /**
     * @param array<string, mixed> $rules
     */
    public function rules_filters_dates(array &$rules): void;

    /**
     * @return ?array<string, mixed>
     */
    public function prepareForValidationForDates(): ?array;
}
