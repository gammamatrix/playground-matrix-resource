<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Matrix\Resource\Http\Requests\Ticket;

use Playground\Http\Requests\StoreRequest as BaseStoreRequest;

/**
 * \Playground\Matrix\Resource\Http\Requests\Ticket\StoreRequest
 */
class StoreRequest extends BaseStoreRequest
{
    /**
     * @var array<string, string|array<mixed>>
     */
    public const RULES = [
        'owned_by_id' => ['nullable', 'uuid'],
        'parent_id' => ['nullable', 'uuid'],
        'ticket_type' => ['nullable', 'string'],
        'backlog_id' => ['nullable', 'uuid'],
        'board_id' => ['nullable', 'uuid'],
        'completed_by_id' => ['nullable', 'uuid'],
        'duplicate_id' => ['nullable', 'uuid'],
        'epic_id' => ['nullable', 'uuid'],
        'fixed_by_id' => ['nullable', 'uuid'],
        'flow_id' => ['nullable', 'uuid'],
        'matrix_id' => ['nullable', 'uuid'],
        'milestone_id' => ['nullable', 'uuid'],
        'note_id' => ['nullable', 'uuid'],
        'project_id' => ['nullable', 'uuid'],
        'release_id' => ['nullable', 'uuid'],
        'reported_by_id' => ['nullable', 'uuid'],
        'roadmap_id' => ['nullable', 'uuid'],
        'source_id' => ['nullable', 'uuid'],
        'sprint_id' => ['nullable', 'uuid'],
        'tag_id' => ['nullable', 'uuid'],
        'team_id' => ['nullable', 'uuid'],
        'version_fixed_id' => ['nullable', 'uuid'],
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
        'canceled' => ['boolean'],
        'closed' => ['boolean'],
        'completed' => ['boolean'],
        'cron' => ['boolean'],
        'duplicate' => ['boolean'],
        'fixed' => ['boolean'],
        'flagged' => ['boolean'],
        'internal' => ['boolean'],
        'locked' => ['boolean'],
        'pending' => ['boolean'],
        'planned' => ['boolean'],
        'prioritized' => ['boolean'],
        'problem' => ['boolean'],
        'published' => ['boolean'],
        'released' => ['boolean'],
        'retired' => ['boolean'],
        'resolved' => ['boolean'],
        'suspended' => ['boolean'],
        'unknown' => ['boolean'],
        'label' => ['string'],
        'title' => ['string', 'required'],
        'byline' => ['string'],
        'slug' => ['nullable', 'string'],
        'url' => ['string'],
        'description' => ['string'],
        'introduction' => ['string'],
        'content' => ['nullable', 'string'],
        'summary' => ['nullable', 'string'],
        'handler' => ['string'],
        'priority' => ['string'],
        'severity' => ['string'],
        'resolution' => ['string'],
        'step' => ['string'],
        'state' => ['string'],
        'workflow_type' => ['string'],
        'points' => ['integer'],
        'actual' => ['nullable', 'string'],
        'expected' => ['nullable', 'string'],
        'story' => ['nullable', 'string'],
        'steps' => ['nullable', 'string'],
        'criteria' => ['nullable', 'string'],
        'reproducibility' => ['nullable', 'decimal'],
        'icon' => ['string'],
        'image' => ['string'],
        'avatar' => ['string'],
        'ui' => ['nullable', 'array'],
        'assets' => ['nullable', 'array'],
        'backlog' => ['nullable', 'array'],
        'board' => ['nullable', 'array'],
        'flow' => ['nullable', 'array'],
        'history' => ['nullable', 'array'],
        'meta' => ['nullable', 'array'],
        'options' => ['nullable', 'array'],
        'roadmap' => ['nullable', 'array'],
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

        if ($this->exists('handler')) {
            $input['handler'] = $this->filterHtml($this->input('handler'));
        }

        if ($this->exists('priority')) {
            $input['priority'] = $this->filterHtml($this->input('priority'));
        }

        if ($this->exists('resolution')) {
            $input['resolution'] = $this->filterHtml($this->input('resolution'));
        }

        if ($this->exists('severity')) {
            $input['severity'] = $this->filterHtml($this->input('severity'));
        }

        if ($this->exists('step')) {
            $input['step'] = $this->filterHtml($this->input('step'));
        }

        if ($this->exists('state')) {
            $input['state'] = $this->filterHtml($this->input('state'));
        }

        if ($this->exists('workflow_type')) {
            $input['workflow_type'] = $this->filterHtml($this->input('workflow_type'));
        }

        if ($this->filled('actual')) {
            $input['actual'] = $this->purify($this->input('actual'));
        }

        if ($this->filled('expected')) {
            $input['expected'] = $this->purify($this->input('expected'));
        }

        if ($this->filled('steps')) {
            $input['steps'] = $this->purify($this->input('steps'));
        }

        if ($this->filled('story')) {
            $input['story'] = $this->purify($this->input('story'));
        }

        if ($this->filled('criteria')) {
            $input['criteria'] = $this->purify($this->input('criteria'));
        }

        if (! empty($input)) {
            $this->merge($input);
        }
    }
}
