<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Matrix\Resource\Http\Requests\Version;

use Playground\Http\Requests\StoreRequest as BaseStoreRequest;

/**
 * \Playground\Matrix\Resource\Http\Requests\Version\StoreRequest
 */
class StoreRequest extends BaseStoreRequest
{
    /**
     * @var array<string, string|array<mixed>>
     */
    public const RULES = [
        'owned_by_id' => ['nullable', 'uuid'],
        'parent_id' => ['nullable', 'uuid'],
        'version_type' => ['nullable', 'string'],
        'matrix_id' => ['nullable', 'uuid'],
        'gids' => ['integer'],
        'po' => ['integer'],
        'pg' => ['integer'],
        'pw' => ['integer'],
        'only_admin' => ['boolean'],
        'only_user' => ['boolean'],
        'only_guest' => ['boolean'],
        'allow_public' => ['boolean'],
        'status' => ['integer'],
        'rank' => ['integer'],
        'size' => ['integer'],
        'matrix' => ['array'],
        'x' => ['integer'],
        'y' => ['integer'],
        'z' => ['integer'],
        'r' => ['float'],
        'theta' => ['float'],
        'rho' => ['float'],
        'phi' => ['float'],
        'elevation' => ['float'],
        'latitude' => ['float'],
        'longitude' => ['float'],
        'active' => ['boolean'],
        'flagged' => ['boolean'],
        'internal' => ['boolean'],
        'locked' => ['boolean'],
        'retired' => ['boolean'],
        'unknown' => ['boolean'],
        'label' => ['string'],
        'title' => ['string'],
        'byline' => ['string'],
        'slug' => ['nullable', 'string'],
        'url' => ['string'],
        'description' => ['string'],
        'introduction' => ['string'],
        'content' => ['nullable', 'string'],
        'summary' => ['nullable', 'string'],
        'icon' => ['string'],
        'image' => ['string'],
        'avatar' => ['string'],
        'ui' => ['nullable', 'array'],
        'assets' => ['nullable', 'array'],
        'meta' => ['nullable', 'array'],
        'options' => ['nullable', 'array'],
        'sources' => ['nullable', 'array'],
        '_return_url' => ['nullable', 'url'],
    ];

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        parent::prepareForValidation();

        $input = [];

        $this->filterContentFields($input);
        $this->filterCommonFields($input);
        $this->filterStatus($input);
        $this->filterSystemFields($input);

        if (! empty($input)) {
            $this->merge($input);
        }
    }
}
