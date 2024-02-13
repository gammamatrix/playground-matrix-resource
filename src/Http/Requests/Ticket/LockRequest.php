<?php
/**
 * Playground
 */

namespace Playground\Matrix\Resource\Http\Requests\Ticket;

use Playground\Matrix\Resource\Http\Requests\FormRequest;

/**
 * \Playground\Matrix\Resource\Http\Requests\Ticket\LockRequest
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