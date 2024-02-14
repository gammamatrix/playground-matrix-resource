<?php
/**
 * Playground
 */
namespace Playground\Matrix\Resource\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
// use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

/**
 * \Playground\Matrix\Resource\Http\Controllers\Controller
 */
abstract class Controller extends BaseController
{
    use AuthorizesRequests;
    use ValidatesRequests;
    // use DispatchesJobs;

    /**
     * @var array<string, mixed>
     */
    protected ?array $package_config = null;

    public function __construct()
    {
        $this->init();
    }

    protected function init(Request $request = null): void
    {
        $package_config = config('playground-matrix-resource');
        if (is_array($package_config)) {
            $this->package_config = $package_config;
        }
    }

    public function getViewPath(
        string $controller = '',
        string $view = ''
    ): string {

        $basePath = '';
        if (! empty($this->package_config['view'])
            && is_string($this->package_config['view'])
        ) {
            $basePath = $this->package_config['view'];
        }

        return sprintf(
            '%1$s%2$s%3$s%4$s',
            $basePath,
            $controller,
            $view ? '/' : '',
            $view
        );
    }
}
