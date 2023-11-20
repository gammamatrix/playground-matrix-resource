<?php
/**
 * GammaMatrix
 *
 */

namespace GammaMatrix\Playground\Matrix\Resource\Http\Controllers;

use GammaMatrix\Playground\Http\Controllers\Controller;

/**
 * \GammaMatrix\Playground\Matrix\Resource\Http\Controllers\IndexController
 *
 */
class IndexController extends Controller
{
    /**
     * Show the index.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('playground-matrix-resource::index');
    }
}
