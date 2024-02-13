<?php
/**
 * Playground
 */

namespace Playground\Matrix\Resource\Http\Requests;

use Illuminate\Support\Str;

/**
 * \Playground\Matrix\Resource\Http\Requests\StoreSlugTrait
 */
trait StoreSlugTrait
{
    protected string $slug_table = '';

    public function rules_store_slug_create(array &$rules): void
    {
        $rules['slug'] = [
            'nullable',
            'string',
        ];

        if ($this->slug_table) {
            $rules['slug'][] = sprintf('unique:%1$s', $this->slug_table);
        }
    }

    public function rules_store_slug_update(array &$rules): void
    {
        $rules['slug'] = [
            'nullable',
            'string',
        ];

        if ($this->slug_table) {
            $rules['slug'][] = sprintf('unique:%1$s,id,%2$s', $this->slug_table, $this->id);
        }
    }

    public function prepareForValidationForSlug(): array
    {
        $slug = $this->get('slug');
        $title = $this->get('title');
        $label = $this->get('label');

        $merge = false;

        if (empty($slug) && (!empty($label) || !empty($title))) {
            if (!empty($title)) {
                $merge = true;
                $slug = Str::of($title)->slug('-')->toString();
            } elseif (!empty($label)) {
                $merge = true;
                $slug = Str::of($label)->slug('-')->toString();
            }
        } elseif (!empty($slug)) {
            $merge = true;
            $slug = Str::of($slug)->slug('-')->toString();
        }

        // dd([
        //     '__METHOD__' => __METHOD__,
        //     '__FILE__' => __FILE__,
        //     '__LINE__' => __LINE__,
        //     '$merge' => $merge,
        //     '$slug' => $slug,
        //     '$title' => $title,
        //     '$label' => $label,
        // ]);

        if ($merge) {
            $this->merge([
                'slug' => $slug,
            ]);
        }

        return [
            'slug' => $slug,
            'label' => $label,
            'title' => $title,
        ];
    }
}
