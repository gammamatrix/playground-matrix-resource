<?php
/**
 * GammaMatrix
 */

namespace GammaMatrix\Playground\Matrix\Resource\Policies;

use GammaMatrix\Playground\Policies\ModelPolicy;

/**
 * \GammaMatrix\Playground\Matrix\Resource\Policies\SprintPolicy
 */
class SprintPolicy extends ModelPolicy
{
    protected string $package = 'playground-matrix-resource';

    /**
     * @var array $rolesToView The roles allowed to view the MVC.
     */
    protected $rolesToView = [
        'user',
        'staff',
        'publisher',
        'manager',
        'admin',
        'root'
    ];

    /**
     * @var array $rolesForAction The roles allowed for actions in the MVC.
     */
    protected $rolesForAction = [
        'publisher',
        'manager',
        'admin',
        'root'
    ];
}
