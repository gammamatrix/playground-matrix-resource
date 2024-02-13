<?php
/**
 * Playground
 *
 */

namespace Playground\Matrix\Resource\Http\Controllers;

use Illuminate\View\View;

/**
 * \Playground\Matrix\Resource\Http\Controllers\IndexController
 *
 */
class IndexController extends Controller
{
    /**
     * Show the index.
     *
     */
    public function index(): View
    {
        return view('playground-matrix-resource::index');
    }
}
