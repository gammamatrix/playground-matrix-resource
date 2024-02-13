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
use Illuminate\Support\Carbon;

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
    protected array $package_config_matrix_resource;

    public function getPackageViewPathFromConfig(
        mixed $config,
        string $controller,
        string $view
    ): string {
        $basePath = '';
        if (! empty($config)
            && is_array($config)
            && ! empty($config['view'])
            && is_string($config['view'])
        ) {
            $basePath = $config['view'];
        }

        return sprintf('%1$s%2$s/%3$s', $basePath, $controller, $view);
        // return sprintf('%1$s%2$s.%3$s', $basePath, $controller, $view);
    }

    protected function init(Request $request = null): void
    {
        $package_config_matrix_resource = config('playground-matrix-resource');
        if (is_array($package_config_matrix_resource)) {
            $this->package_config_matrix_resource = $package_config_matrix_resource;
        }
    }
}
