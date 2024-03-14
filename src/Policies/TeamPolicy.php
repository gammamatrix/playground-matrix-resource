<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Playground\Matrix\Resource\Policies;

use Playground\Auth\Policies\ModelPolicy;

/**
 * \Playground\Matrix\Resource\Policies\TeamPolicy
 */
class TeamPolicy extends ModelPolicy
{
    protected string $package = 'playground-matrix-resource';

    /**
     * @var array<int, string> The roles allowed to view the MVC.
     */
    protected $rolesToView = [
        'user',
        'staff',
        'publisher',
        'manager',
        'admin',
        'root',
    ];

    /**
     * @var array<int, string> The roles allowed for actions in the MVC.
     */
    protected $rolesForAction = [
        'publisher',
        'manager',
        'admin',
        'root',
    ];
}
