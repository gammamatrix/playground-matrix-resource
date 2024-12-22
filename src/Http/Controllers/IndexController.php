<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Matrix\Resource\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;

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
        // dd([
        //     '__METHOD__' => __METHOD__,
        //     'config' => config('playground-matrix-resource'),
        // ]);

        if (!empty(config('playground-matrix-resource.load.matrix'))) {
            $data['dashboard'] = $this->loadMatrix(
                $request,
                'playground.matrix.resource',
            );
        }
        return view('playground-matrix-resource::index', $data);
    }
}
