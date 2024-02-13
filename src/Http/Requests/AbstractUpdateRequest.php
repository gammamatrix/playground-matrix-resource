<?php
/**
 * Playground
 */

namespace Playground\Matrix\Resource\Http\Requests;

/**
 * \Playground\Matrix\Resource\Http\Requests\AbstractUpdateRequest
 */
abstract class AbstractUpdateRequest extends FormRequest
{
    use StoreContentTrait;
    use StoreSlugTrait;
    use StoreFilterTrait;

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            // 'slug.unique' => 'The :attribute has already been taken: :input',
            'slug.unique' => __('playground::validation.slug.unique'),
        ];
    }

    public function rules(): array
    {
        $rules = parent::rules();

        if (method_exists($this, 'rules_store_slug_update')) {
            $this->rules_store_slug_update($rules);
        }
        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '__FILE__' => __FILE__,
        //     '__LINE__' => __LINE__,
        //     '$rules' => $rules,
        // ]);

        // \Log::debug(__METHOD__, [
        //     '$action' => $action,
        //     '$rules' => $rules,
        // ]);
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
        // dd([
        //     '__METHOD__' => __METHOD__,
        //     '__FILE__' => __FILE__,
        //     '__LINE__' => __LINE__,
        //     'method_exists' => method_exists($this, 'prepareForValidationForSlug'),
        // ]);
    }
}