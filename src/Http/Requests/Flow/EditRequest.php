<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Matrix\Resource\Http\Requests\Flow;

use Playground\Matrix\Resource\Http\Requests\FormRequest;

/**
 * \Playground\Matrix\Resource\Http\Requests\Flow\EditRequest
 */
class EditRequest extends FormRequest
{
    /**
     * @var array<string, string|array<mixed>>
     */
    public const RULES = [
        'owned_by_id' => ['nullable', 'uuid'],
        'parent_id' => ['nullable', 'uuid'],
        'flow_type' => ['nullable', 'string'],
        'matrix_id' => ['nullable', 'uuid'],
        'note_id' => ['nullable', 'uuid'],
        'tag_id' => ['nullable', 'uuid'],
        'team_id' => ['nullable', 'uuid'],
        'start_at' => ['nullable', 'string'],
        'planned_start_at' => ['nullable', 'string'],
        'end_at' => ['nullable', 'string'],
        'planned_end_at' => ['nullable', 'string'],
        'embargo_at' => ['nullable', 'string'],
        'postponed_at' => ['nullable', 'string'],
        'resumed_at' => ['nullable', 'string'],
        'suspended_at' => ['nullable', 'string'],
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
        'matrix' => ['nullable', 'array'],
        'x' => ['nullable', 'integer'],
        'y' => ['nullable', 'integer'],
        'z' => ['nullable', 'integer'],
        'r' => ['nullable', 'numeric'],
        'theta' => ['nullable', 'numeric'],
        'rho' => ['nullable', 'numeric'],
        'phi' => ['nullable', 'numeric'],
        'elevation' => ['nullable', 'numeric'],
        'latitude' => ['nullable', 'numeric'],
        'longitude' => ['nullable', 'numeric'],
        'active' => ['boolean'],
        'cron' => ['boolean'],
        'flagged' => ['boolean'],
        'internal' => ['boolean'],
        'locked' => ['boolean'],
        'pending' => ['boolean'],
        'planned' => ['boolean'],
        'problem' => ['boolean'],
        'retired' => ['boolean'],
        'suspended' => ['boolean'],
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
        'backlog' => ['nullable', 'array'],
        'board' => ['nullable', 'array'],
        'flow' => ['nullable', 'array'],
        'meta' => ['nullable', 'array'],
        'options' => ['nullable', 'array'],
        'roadmap' => ['nullable', 'array'],
        'sources' => ['nullable', 'array'],
        '_return_url' => ['nullable', 'url'],
    ];
}
