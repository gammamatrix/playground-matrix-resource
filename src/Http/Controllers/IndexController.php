<?php

/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Matrix\Resource\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * \Playground\Matrix\Resource\Http\Controllers\IndexController
 */
class IndexController extends Controller
{
    use Concerns\Loading;

    /**
     * Show the index.
     */
    public function index(Request $request): View
    {
        $data = [];

        if (! empty(config('playground-matrix-resource.load.matrix'))) {
            $data['dashboard'] = $this->loadMatrix(
                $request,
                'playground.matrix.resource',
            );
        }

        return view('playground-matrix-resource::index/index', $data);
    }
}
