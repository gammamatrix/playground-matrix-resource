<?php
/**
 * Playground
 */
namespace Playground\Matrix\Resource\Http\Requests\Project;

use Playground\Matrix\Resource\Http\Requests\FormRequest;

/**
 * \Playground\Matrix\Resource\Http\Requests\Project\RestoreRequest
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
