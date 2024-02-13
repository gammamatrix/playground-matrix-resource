<?php
/**
 * Playground
 */

namespace Playground\Matrix\Resource\Http\Requests\Team;

use Playground\Matrix\Resource\Http\Requests\FormRequest;

/**
 * \Playground\Matrix\Resource\Http\Requests\Team\UnlockRequest
 */
class UnlockRequest extends FormRequest
{
    /**
     * @var array RULES The validation rules.
     */
    public const RULES = [
        '_return_url' => ['nullable', 'url'],
    ];
}
