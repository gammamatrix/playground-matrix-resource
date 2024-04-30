<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Matrix\Resource\Http\Requests\Note;

use Playground\Matrix\Resource\Http\Requests\FormRequest;

/**
 * \Playground\Matrix\Resource\Http\Requests\Note\CreateRequest
 */
class CreateRequest extends FormRequest
{
    /**
     * @var array<string, string|array<mixed>>
     */
    public const RULES = [
        'owned_by_id' => ['nullable', 'uuid'],
        'parent_id' => ['nullable', 'uuid'],
        'note_type' => ['nullable', 'string'],
        'matrix_id' => ['nullable', 'uuid'],
        'tag_id' => ['nullable', 'uuid'],
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
        'canceled' => ['boolean'],
        'closed' => ['boolean'],
        'completed' => ['boolean'],
        'flagged' => ['boolean'],
        'internal' => ['boolean'],
        'locked' => ['boolean'],
        'pending' => ['boolean'],
        'planned' => ['boolean'],
        'problem' => ['boolean'],
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
}
