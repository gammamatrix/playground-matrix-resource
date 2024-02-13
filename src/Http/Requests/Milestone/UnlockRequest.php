<?php
/**
 * Playground
 */

namespace Playground\Matrix\Resource\Http\Requests\Milestone;

use Playground\Matrix\Resource\Http\Requests\FormRequest;

/**
 * \Playground\Matrix\Resource\Http\Requests\Milestone\UnlockRequest
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
