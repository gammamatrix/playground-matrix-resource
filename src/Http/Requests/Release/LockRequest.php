<?php
/**
 * GammaMatrix
 */

namespace GammaMatrix\Playground\Matrix\Resource\Http\Requests\Release;

use GammaMatrix\Playground\Matrix\Resource\Http\Requests\FormRequest;

/**
 * \GammaMatrix\Playground\Matrix\Resource\Http\Requests\Release\LockRequest
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
