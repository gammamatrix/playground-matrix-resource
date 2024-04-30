<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Matrix\Resource\Http\Requests\Matrix;

use Playground\Http\Requests\IndexRequest as BaseIndexRequest;

/**
 * \Playground\Matrix\Resource\Http\Requests\Matrix\IndexRequest
 */
class IndexRequest extends BaseIndexRequest
{
    /**
     * @var array<string, array<string, mixed>>
     */
    protected array $paginationDates = [
        'start_at' => ['column' => 'start_at', 'label' => 'Start At', 'nullable' => true],
        'planned_start_at' => ['column' => 'planned_start_at', 'label' => 'Planned Start At', 'nullable' => true],
        'end_at' => ['column' => 'end_at', 'label' => 'End At', 'nullable' => true],
        'planned_end_at' => ['column' => 'planned_end_at', 'label' => 'Planned End At', 'nullable' => true],
        'canceled_at' => ['column' => 'canceled_at', 'label' => 'Canceled At', 'nullable' => true],
        'closed_at' => ['column' => 'closed_at', 'label' => 'Closed At', 'nullable' => true],
        'embargo_at' => ['column' => 'embargo_at', 'label' => 'Embargo At', 'nullable' => true],
        'postponed_at' => ['column' => 'postponed_at', 'label' => 'Postponed At', 'nullable' => true],
        'resumed_at' => ['column' => 'resumed_at', 'label' => 'Resumed At', 'nullable' => true],
        'suspended_at' => ['column' => 'suspended_at', 'label' => 'Suspended At', 'nullable' => true],
    ];

    /**
     * @var array<string, array<string, mixed>>
     */
    protected array $paginationFlags = [
        'active' => ['column' => 'active', 'label' => 'Active', 'icon' => 'fa-solid fa-person-running'],
        'canceled' => ['column' => 'canceled', 'label' => 'Canceled', 'icon' => 'fa-solid fa-ban text-warning'],
        'closed' => ['column' => 'closed', 'label' => 'Closed', 'icon' => 'fa-solid fa-xmark'],
        'completed' => ['column' => 'completed', 'label' => 'Completed', 'icon' => 'fa-solid fa-check'],
        'cron' => ['column' => 'cron', 'label' => 'Cron', 'icon' => 'fa-regular fa-clock'],
        'flagged' => ['column' => 'flagged', 'label' => 'Flagged', 'icon' => 'fa-solid fa-flag'],
        'internal' => ['column' => 'internal', 'label' => 'Internal', 'icon' => 'fa-solid fa-server'],
        'locked' => ['column' => 'locked', 'label' => 'Locked', 'icon' => 'fa-solid fa-lock text-warning'],
        'pending' => ['column' => 'pending', 'label' => 'Pending', 'icon' => 'fa-solid fa-circle-pause text-warning'],
        'planned' => ['column' => 'planned', 'label' => 'Planned', 'icon' => 'fa-solid fa-circle-pause text-success'],
        'problem' => ['column' => 'problem', 'label' => 'Problem', 'icon' => 'fa-solid fa-triangle-exclamation text-danger'],
        'retired' => ['column' => 'retired', 'label' => 'Retired', 'icon' => 'fa-solid fa-chair text-success'],
        'suspended' => ['column' => 'suspended', 'label' => 'Suspended', 'icon' => 'fa-solid fa-hand text-danger'],
        'unknown' => ['column' => 'unknown', 'label' => 'Unknown', 'icon' => 'fa-solid fa-question text-warning'],
    ];

    /**
     * @var array<string, array<string, mixed>>
     */
    protected array $paginationIds = [
        'matrix_id' => ['column' => 'matrix_id', 'label' => 'Matrix id', 'type' => 'uuid', 'nullable' => true],
        'matrix_type' => ['column' => 'matrix_type', 'label' => 'Matrix type', 'type' => 'string', 'nullable' => true],
        'owned_by_id' => ['column' => 'owned_by_id', 'label' => 'Owned by id', 'type' => 'uuid', 'nullable' => true],
    ];

    /**
     * @var array<string, array<string, mixed>>
     */
    protected array $paginationColumns = [
        'label' => ['column' => 'label', 'label' => 'Label', 'type' => 'string', 'nullable' => true],
        'title' => ['column' => 'title', 'label' => 'Title', 'type' => 'string', 'nullable' => true],
        'byline' => ['column' => 'byline', 'label' => 'Byline', 'type' => 'string', 'nullable' => true],
        'slug' => ['column' => 'slug', 'label' => 'Slug', 'type' => 'string', 'nullable' => true],
        'url' => ['column' => 'url', 'label' => 'Url', 'type' => 'string', 'nullable' => true],
        'description' => ['column' => 'description', 'label' => 'Description', 'type' => 'string', 'nullable' => true],
        'introduction' => ['column' => 'introduction', 'label' => 'Introduction', 'type' => 'string', 'nullable' => true],
        'content' => ['column' => 'content', 'label' => 'Content', 'type' => 'mediumText', 'nullable' => true],
        'summary' => ['column' => 'summary', 'label' => 'Summary', 'type' => 'mediumText', 'nullable' => true],
    ];

    /**
     * @var array<string, array<string, mixed>>
     */
    protected array $sortable = [
        'created_by_id' => ['column' => 'created_by_id', 'label' => 'Created by id', 'type' => 'string'],
        'modified_by_id' => ['column' => 'modified_by_id', 'label' => 'Modified by id', 'type' => 'string'],
        'owned_by_id' => ['column' => 'owned_by_id', 'label' => 'Owned by id', 'type' => 'string'],
        'parent_id' => ['column' => 'parent_id', 'label' => 'Parent id', 'type' => 'string'],
        'matrix_type' => ['column' => 'matrix_type', 'label' => 'Matrix type', 'type' => 'string'],
        'matrix_id' => ['column' => 'matrix_id', 'label' => 'Matrix id', 'type' => 'string'],
        'created_at' => ['column' => 'created_at', 'label' => 'Created At', 'type' => 'string'],
        'updated_at' => ['column' => 'updated_at', 'label' => 'Updated At', 'type' => 'string'],
        'deleted_at' => ['column' => 'deleted_at', 'label' => 'Deleted At', 'type' => 'string'],
        'start_at' => ['column' => 'start_at', 'label' => 'Start at', 'type' => 'string'],
        'planned_start_at' => ['column' => 'planned_start_at', 'label' => 'Planned start at', 'type' => 'string'],
        'end_at' => ['column' => 'end_at', 'label' => 'End at', 'type' => 'string'],
        'planned_end_at' => ['column' => 'planned_end_at', 'label' => 'Planned end at', 'type' => 'string'],
        'canceled_at' => ['column' => 'canceled_at', 'label' => 'Canceled at', 'type' => 'string'],
        'closed_at' => ['column' => 'closed_at', 'label' => 'Closed at', 'type' => 'string'],
        'embargo_at' => ['column' => 'embargo_at', 'label' => 'Embargo at', 'type' => 'string'],
        'postponed_at' => ['column' => 'postponed_at', 'label' => 'Postponed at', 'type' => 'string'],
        'resumed_at' => ['column' => 'resumed_at', 'label' => 'Resumed at', 'type' => 'string'],
        'suspended_at' => ['column' => 'suspended_at', 'label' => 'Suspended at', 'type' => 'string'],
        'gids' => ['column' => 'gids', 'label' => 'Gids', 'type' => 'integer'],
        'po' => ['column' => 'po', 'label' => 'Po', 'type' => 'integer'],
        'pg' => ['column' => 'pg', 'label' => 'Pg', 'type' => 'integer'],
        'pw' => ['column' => 'pw', 'label' => 'Pw', 'type' => 'integer'],
        'only_admin' => ['column' => 'only_admin', 'label' => 'Only admin', 'type' => 'boolean'],
        'only_user' => ['column' => 'only_user', 'label' => 'Only user', 'type' => 'boolean'],
        'only_guest' => ['column' => 'only_guest', 'label' => 'Only guest', 'type' => 'boolean'],
        'allow_public' => ['column' => 'allow_public', 'label' => 'Allow public', 'type' => 'boolean'],
        'status' => ['column' => 'status', 'label' => 'Status', 'type' => 'integer'],
        'rank' => ['column' => 'rank', 'label' => 'Rank', 'type' => 'integer'],
        'size' => ['column' => 'size', 'label' => 'Size', 'type' => 'integer'],
        'matrix' => ['column' => 'matrix', 'label' => 'Matrix', 'type' => 'JSON_OBJECT'],
        'x' => ['column' => 'x', 'label' => 'X', 'type' => 'integer'],
        'y' => ['column' => 'y', 'label' => 'Y', 'type' => 'integer'],
        'z' => ['column' => 'z', 'label' => 'Z', 'type' => 'integer'],
        'r' => ['column' => 'r', 'label' => 'R', 'type' => 'float'],
        'theta' => ['column' => 'theta', 'label' => 'Theta', 'type' => 'float'],
        'rho' => ['column' => 'rho', 'label' => 'Rho', 'type' => 'float'],
        'phi' => ['column' => 'phi', 'label' => 'Phi', 'type' => 'float'],
        'elevation' => ['column' => 'elevation', 'label' => 'Elevation', 'type' => 'float'],
        'latitude' => ['column' => 'latitude', 'label' => 'Latitude', 'type' => 'float'],
        'longitude' => ['column' => 'longitude', 'label' => 'Longitude', 'type' => 'float'],
        'active' => ['column' => 'active', 'label' => 'Active', 'type' => 'boolean'],
        'canceled' => ['column' => 'canceled', 'label' => 'Canceled', 'type' => 'boolean'],
        'closed' => ['column' => 'closed', 'label' => 'Closed', 'type' => 'boolean'],
        'completed' => ['column' => 'completed', 'label' => 'Completed', 'type' => 'boolean'],
        'cron' => ['column' => 'cron', 'label' => 'Cron', 'type' => 'boolean'],
        'flagged' => ['column' => 'flagged', 'label' => 'Flagged', 'type' => 'boolean'],
        'internal' => ['column' => 'internal', 'label' => 'Internal', 'type' => 'boolean'],
        'locked' => ['column' => 'locked', 'label' => 'Locked', 'type' => 'boolean'],
        'pending' => ['column' => 'pending', 'label' => 'Pending', 'type' => 'boolean'],
        'planned' => ['column' => 'planned', 'label' => 'Planned', 'type' => 'boolean'],
        'problem' => ['column' => 'problem', 'label' => 'Problem', 'type' => 'boolean'],
        'retired' => ['column' => 'retired', 'label' => 'Retired', 'type' => 'boolean'],
        'suspended' => ['column' => 'suspended', 'label' => 'Suspended', 'type' => 'boolean'],
        'unknown' => ['column' => 'unknown', 'label' => 'Unknown', 'type' => 'boolean'],
        'label' => ['column' => 'label', 'label' => 'Label', 'type' => 'string'],
        'title' => ['column' => 'title', 'label' => 'Title', 'type' => 'string'],
        'byline' => ['column' => 'byline', 'label' => 'Byline', 'type' => 'string'],
        'slug' => ['column' => 'slug', 'label' => 'Slug', 'type' => 'string'],
        'url' => ['column' => 'url', 'label' => 'Url', 'type' => 'string'],
        'description' => ['column' => 'description', 'label' => 'Description', 'type' => 'string'],
        'introduction' => ['column' => 'introduction', 'label' => 'Introduction', 'type' => 'string'],
        'content' => ['column' => 'content', 'label' => 'Content', 'type' => 'string'],
        'summary' => ['column' => 'summary', 'label' => 'Summary', 'type' => 'string'],
        'icon' => ['column' => 'icon', 'label' => 'Icon', 'type' => 'string'],
        'image' => ['column' => 'image', 'label' => 'Image', 'type' => 'string'],
        'avatar' => ['column' => 'avatar', 'label' => 'Avatar', 'type' => 'string'],
        'ui' => ['column' => 'ui', 'label' => 'Ui', 'type' => 'JSON_OBJECT'],
        'assets' => ['column' => 'assets', 'label' => 'Assets', 'type' => 'JSON_OBJECT'],
        'meta' => ['column' => 'meta', 'label' => 'Meta', 'type' => 'JSON_OBJECT'],
        'notes' => ['column' => 'notes', 'label' => 'Notes', 'type' => 'JSON_ARRAY'],
        'options' => ['column' => 'options', 'label' => 'Options', 'type' => 'JSON_OBJECT'],
        'sources' => ['column' => 'sources', 'label' => 'Sources', 'type' => 'JSON_OBJECT'],
    ];
}
