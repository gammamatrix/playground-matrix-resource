<?php
/**
 * Playground
 */

namespace Playground\Matrix\Resource\Http\Requests\Board;

use Playground\Matrix\Resource\Http\Requests\FormRequest;

/**
 * \Playground\Matrix\Resource\Http\Requests\Board\LockRequest
 */
class LockRequest extends FormRequest
{
    /**
     * @var array RULES The validation rules.
     */
    public const RULES = [
        '_return_url' => ['nullable', 'url'],
    ];
}