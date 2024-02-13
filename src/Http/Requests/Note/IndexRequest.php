<?php
/**
 * Playground
 */

namespace Playground\Matrix\Resource\Http\Requests\Note;

use Playground\Matrix\Resource\Http\Requests\AbstractIndexRequest;

/**
 * \Playground\Matrix\Resource\Http\Requests\Note\IndexRequest
 */
class IndexRequest extends AbstractIndexRequest
{
    protected array $paginationDates = [
        'created_at' => ['column' => 'created_at', 'label' => 'Created At', 'nullable' => false],
        'updated_at' => ['column' => 'updated_at', 'label' => 'Updated At', 'nullable' => false],
        'deleted_at' => ['column' => 'deleted_at', 'label' => 'Deleted At', 'nullable' => true],
        'start_at' => ['column' => 'start_at', 'label' => 'Start At', 'nullable' => true],
        'planned_start_at' => ['column' => 'planned_start_at', 'label' => 'Planned Start At', 'nullable' => true],
        'end_at' => ['column' => 'end_at', 'label' => 'End At', 'nullable' => true],
        'planned_end_at' => ['column' => 'planned_end_at', 'label' => 'Planned End At', 'nullable' => true],
        'canceled_at' => ['column' => 'canceled_at', 'label' => 'Canceled At', 'nullable' => true],
        'closed_at' => ['column' => 'closed_at', 'label' => 'Closed At', 'nullable' => true],
        'embargo_at' => ['column' => 'embargo_at', 'label' => 'Embargo At', 'nullable' => true],
        'fixed_at' => ['column' => 'fixed_at', 'label' => 'Fixed At', 'nullable' => true],
        'postponed_at' => ['column' => 'postponed_at', 'label' => 'Postponed At', 'nullable' => true],
        'published_at' => ['column' => 'published_at', 'label' => 'Published At', 'nullable' => true],
        'released_at' => ['column' => 'released_at', 'label' => 'Released At', 'nullable' => true],
        'resumed_at' => ['column' => 'resumed_at', 'label' => 'Resumed At', 'nullable' => true],
        'resolved_at' => ['column' => 'resolved_at', 'label' => 'Resolved At', 'nullable' => true],
        'suspended_at' => ['column' => 'suspended_at', 'label' => 'Suspended At', 'nullable' => true],
    ];

    protected array $paginationFlags = [
        'active' => ['column' => 'active', 'label' => 'Active', 'icon' => 'fa-solid fa-person-running'],
        'canceled' => ['column' => 'canceled', 'label' => 'Canceled', 'icon' => 'fa-solid fa-ban text-warning'],
        'closed' => ['column' => 'closed', 'label' => 'Closed', 'icon' => 'fa-solid fa-xmark'],
        'completed' => ['column' => 'completed', 'label' => 'Completed', 'icon' => 'fa-solid fa-check'],
        'duplicate' => ['column' => 'duplicate', 'label' => 'Duplicate', 'icon' => 'fa-solid fa-clone'],
        'fixed' => ['column' => 'fixed', 'label' => 'Fixed', 'icon' => 'fa-solid fa-wrench'],
        'flagged' => ['column' => 'flagged', 'label' => 'Flagged', 'icon' => 'fa-solid fa-flag'],
        'internal' => ['column' => 'internal', 'label' => 'Internal', 'icon' => 'fa-solid fa-server'],
        'locked' => ['column' => 'locked', 'label' => 'Locked', 'icon' => 'fa-solid fa-lock text-warning'],
        'pending' => ['column' => 'pending', 'label' => 'Pending', 'icon' => 'fa-solid fa-circle-pause text-warning'],
        'planned' => ['column' => 'planned', 'label' => 'Planned', 'icon' => 'fa-solid fa-circle-pause text-success'],
        'problem' => ['column' => 'problem', 'label' => 'Problem', 'icon' => 'fa-solid fa-triangle-exclamation text-danger'],
        'published' => ['column' => 'published', 'label' => 'Published', 'icon' => 'fa-solid fa-book'],
        'released' => ['column' => 'released', 'label' => 'Released', 'icon' => 'fa-solid fa-dove'],
        'retired' => ['column' => 'retired', 'label' => 'Retired', 'icon' => 'fa-solid fa-chair text-success'],
        'resolved' => ['column' => 'resolved', 'label' => 'Resolved', 'icon' => 'fa-solid fa-check-double text-success'],
        'suspended' => ['column' => 'suspended', 'label' => 'Suspended', 'icon' => 'fa-solid fa-hand text-danger'],
        'unknown' => ['column' => 'unknown', 'label' => 'Unknown', 'icon' => 'fa-solid fa-question text-warning'],
        'only_admin' => ['column' => 'only_admin', 'label' => 'Only Admin', 'icon' => 'fa-solid fa-user-gear'],
        'only_user' => ['column' => 'only_user', 'label' => 'Only User', 'icon' => 'fa-solid fa-user'],
        'only_guest' => ['column' => 'only_guest', 'label' => 'Only Guest', 'icon' => 'fa-solid fa-person-rays'],
        'allow_public' => ['column' => 'allow_public', 'label' => 'Allow Public', 'icon' => 'fa-solid fa-users-line'],
    ];

    protected array $paginationIds = [
        'id' => ['column' => 'id', 'label' => 'Id', 'type' => 'uuid', 'nullable' => false],
        'owned_by_id' => ['column' => 'owned_by_id', 'label' => 'Owned By Id', 'type' => 'uuid', 'nullable' => false],
        'parent_id' => ['column' => 'parent_id', 'label' => 'Parent Id', 'type' => 'uuid', 'nullable' => false],
        'note_type' => ['column' => 'note_type', 'label' => 'Note Type', 'type' => 'string', 'nullable' => true],
    ];

    protected array $paginationColumns = [
        'label' => ['column' => 'label', 'label' => 'Label', 'type' => 'string', 'nullable' => false],
        'byline' => ['column' => 'byline', 'label' => 'Byline', 'type' => 'string', 'nullable' => false],
        'slug' => ['column' => 'slug', 'label' => 'Slug', 'type' => 'string', 'nullable' => false],
        'url' => ['column' => 'url', 'label' => 'Url', 'type' => 'string', 'nullable' => false],
        'description' => ['column' => 'description', 'label' => 'Description', 'type' => 'string', 'nullable' => false],
        'introduction' => ['column' => 'introduction', 'label' => 'Introduction', 'type' => 'string', 'nullable' => false],
        'content' => ['column' => 'content', 'label' => 'Content', 'type' => 'string', 'nullable' => false],
        'summary' => ['column' => 'summary', 'label' => 'Summary', 'type' => 'string', 'nullable' => false],
    ];
}
