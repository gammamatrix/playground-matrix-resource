<?php
/**
 * Playground
 */

namespace Playground\Matrix\Resource\Http\Requests\Backlog;

use Playground\Matrix\Resource\Http\Requests\AbstractUpdateRequest;

/**
 * \Playground\Matrix\Resource\Http\Requests\Backlog\UpdateRequest
 */
class UpdateRequest extends AbstractUpdateRequest
{
    /**
     * @var array RULES The validation rules.
     */
    public const RULES = [
        'owned_by_id' => ['nullable', 'uuid'],
        'parent_id' => ['nullable', 'uuid'],
        'backlog_type' => ['nullable', 'string'],
        'board_id' => ['nullable', 'uuid'],
        'epic_id' => ['nullable', 'uuid'],
        'flow_id' => ['nullable', 'uuid'],
        'milestone_id' => ['nullable', 'uuid'],
        'note_id' => ['nullable', 'uuid'],
        'project_id' => ['nullable', 'uuid'],
        'release_id' => ['nullable', 'uuid'],
        'roadmap_id' => ['nullable', 'uuid'],
        'source_id' => ['nullable', 'uuid'],
        'sprint_id' => ['nullable', 'uuid'],
        'tag_id' => ['nullable', 'uuid'],
        'team_id' => ['nullable', 'uuid'],
        'ticket_id' => ['nullable', 'uuid'],
        'version_id' => ['nullable', 'uuid'],
        'start_at' => ['nullable', 'string'],
        'planned_start_at' => ['nullable', 'string'],
        'end_at' => ['nullable', 'string'],
        'planned_end_at' => ['nullable', 'string'],
        'canceled_at' => ['nullable', 'string'],
        'closed_at' => ['nullable', 'string'],
        'embargo_at' => ['nullable', 'string'],
        'fixed_at' => ['nullable', 'string'],
        'postponed_at' => ['nullable', 'string'],
        'published_at' => ['nullable', 'string'],
        'released_at' => ['nullable', 'string'],
        'resumed_at' => ['nullable', 'string'],
        'resolved_at' => ['nullable', 'string'],
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
        'active' => ['boolean'],
        'canceled' => ['boolean'],
        'closed' => ['boolean'],
        'completed' => ['boolean'],
        'duplicate' => ['boolean'],
        'fixed' => ['boolean'],
        'flagged' => ['boolean'],
        'internal' => ['boolean'],
        'locked' => ['boolean'],
        'pending' => ['boolean'],
        'planned' => ['boolean'],
        'problem' => ['boolean'],
        'published' => ['boolean'],
        'released' => ['boolean'],
        'retired' => ['boolean'],
        'resolved' => ['boolean'],
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

    protected string $slug_table = 'matrix_backlogs';

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        parent::prepareForValidation();

        $input = [];

        if ($this->filled('content')) {
            $input['content'] = $this->purify($this->input('content'));
        }

        if ($this->filled('summary')) {
            $input['summary'] = $this->purify($this->input('summary'));
        }

        if ($this->filled('description')) {
            $input['description'] = $this->exorcise($this->input('description'));
        } elseif ($this->has('description')) {
            $input['description'] = '';
        }

        if ($this->filled('introduction')) {
            $input['introduction'] = $this->exorcise($this->input('introduction'));
        } elseif ($this->has('introduction')) {
            $input['introduction'] = '';
        }

        if (!empty($input)) {
            $this->merge($input);
        }
    }

    //    /**
    //      * Handle a passed validation attempt.
    //      *
    //      * @return void
    //      */
    //     protected function passedValidation()
    //     {
    //
    //     }
}
