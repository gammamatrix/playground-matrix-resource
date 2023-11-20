<?php
/**
 * GammaMatrix
 */

namespace GammaMatrix\Playground\Matrix\Resource\Http\Requests\Version;

use GammaMatrix\Playground\Matrix\Resource\Http\Requests\FormRequest;

/**
 * \GammaMatrix\Playground\Matrix\Resource\Http\Requests\Version\RestoreRequest
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
