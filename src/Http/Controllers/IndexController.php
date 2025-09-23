<?php

/**
 * Playground
 */

declare(strict_types=1);

namespace Playground\Matrix\Resource\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Playground\Matrix\Resource\Http\Controllers\Concerns\Loading;

/**
 * \Playground\Matrix\Resource\Http\Controllers\IndexController
 */
class IndexController extends Controller
{
    use Loading;

    /**
     * @var array<string, string>
     */
    public array $packageInfo = [
        'module_label' => 'Matrix',
        'module_label_plural' => 'Matrices',
        'module_route' => 'playground.matrix.resource',
        'module_slug' => 'matrix',
        'privilege' => 'playground-matrix-resource',
        'view' => 'playground-matrix-resource',
    ];

    /**
     * Show the index.
     */
    public function index(Request $request): View
    {
        $packageInfo = $this->packageInfo();

        /**
         * @var view-string $view
         */
        $view = sprintf('%1$s::index', $packageInfo->view());

        return view($view, [
            'packageInfo' => $packageInfo,
            'dashboard' => $this->loadMatrix($request, $packageInfo->module_route()),
        ]);
    }
}
