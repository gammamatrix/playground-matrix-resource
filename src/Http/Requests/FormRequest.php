<?php
/**
 * Playground
 */

namespace Playground\Matrix\Resource\Http\Requests;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Http\FormRequest as BaseFormRequest;

/**
 * \Playground\Matrix\Resource\Http\Requests\FormRequest
 */
abstract class FormRequest extends BaseFormRequest
{
    public const RULES = [];

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // return true;
        $user = $this->user();

        if (empty($user)) {
            return false;
        }

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $rules = is_array(static::RULES) ? static::RULES : [];

        return $rules;
    }

    public function userHasAdminPrivileges(Authenticatable $user = null): bool
    {
        $admin = false;
        if (!empty($user)) {
            if (method_exists($user, 'isAdmin')) {
                $admin = $user->isAdmin();
            } else {
                // standard user, no roles or privileges
                $admin = true;
            }
        }
        return $admin;
    }
}
