<?php
/**
 * Playground
 */

namespace Playground\Matrix\Resource\Http\Requests\Epic;

use Playground\Matrix\Resource\Http\Requests\FormRequest;

/**
 * \Playground\Matrix\Resource\Http\Requests\Epic\UnlockRequest
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
