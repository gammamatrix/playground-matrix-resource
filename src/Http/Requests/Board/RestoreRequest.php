<?php
/**
 * Playground
 */
namespace Playground\Matrix\Resource\Http\Requests\Board;

use Playground\Matrix\Resource\Http\Requests\FormRequest;

/**
 * \Playground\Matrix\Resource\Http\Requests\Board\RestoreRequest
 */
class RestoreRequest extends FormRequest
{
    /**
     * @var array<string, string|array<mixed>>
     */
    public const RULES = [
        '_return_url' => ['nullable', 'url'],
    ];
}
