<?php
/**
 * Playground
 */

namespace Playground\Matrix\Resource\Http\Requests\Release;

use Playground\Matrix\Resource\Http\Requests\FormRequest;

/**
 * \Playground\Matrix\Resource\Http\Requests\Release\RestoreRequest
 */
class RestoreRequest extends FormRequest
{
    /**
     * @var array RULES The validation rules.
     */
    public const RULES = [
        '_return_url' => ['nullable', 'url'],
    ];
}
