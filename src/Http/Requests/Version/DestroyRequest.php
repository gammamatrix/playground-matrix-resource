<?php
/**
 * GammaMatrix
 */

namespace GammaMatrix\Playground\Matrix\Resource\Http\Requests\Version;

use GammaMatrix\Playground\Matrix\Resource\Http\Requests\FormRequest;

/**
 * \GammaMatrix\Playground\Matrix\Resource\Http\Requests\Version\DestroyRequest
 */
class DestroyRequest extends FormRequest
{
    /**
     * @var array RULES The validation rules.
     */
    public const RULES = [
        '_return_url' => ['nullable', 'url'],
    ];

    public function rules(): array
    {
        $rules = parent::rules();

        $user = $this->user();

        if ($this->userHasAdminPrivileges($user)) {
            $rules['force'] = ['boolean'];
        }

        return $rules;
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        if (method_exists($this, 'prepareForValidationForSlug')) {
            $this->prepareForValidationForSlug();
        }
    }
}
