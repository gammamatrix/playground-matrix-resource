<?php
/**
 * Playground
 */
namespace Playground\Matrix\Resource\Http\Requests\Version;

use Playground\Matrix\Resource\Http\Requests\FormRequest;

/**
 * \Playground\Matrix\Resource\Http\Requests\Version\RestoreRequest
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
