<?php
/**
 * GammaMatrix
 */

namespace GammaMatrix\Playground\Matrix\Resource;

use Illuminate\Support\Facades\Gate;

/**
 * \GammaMatrix\Playground\Matrix\Resource\ServiceProviderTrait
 */
trait ServiceProviderTrait
{
    protected string $policy_namespace = '';

    public function setPolicyNamespace(array $config): string
    {
        // $pattern = '/(?:\\{1,2}\w+|\w+\\{1,2})(?:\w+\\{0,2}\w+)/';

        if (!empty($config['policy_namespace'])
            && is_string($config['policy_namespace'])
            // TODO Should we enforce a regex with a Log message?
            // && preg_match($pattern, $config['policy_namespace'])
        ) {
            $this->policy_namespace = $config['policy_namespace'];
        }

        return $this->policy_namespace;
    }

    /**
     * Register the application's policies.
     *
     * @return void
     */
    public function registerPolicies()
    {
        foreach ($this->policies() as $model => $policy) {

            if (empty($this->policy_namespace)) {
                $register = $policy;
            } else {
                // TODO test slashes with policies in App\Policies or another namespace.
                $register = str_replace(
                    'GammaMatrix\\Playground\\Matrix\\Resource',
                    $this->policy_namespace,
                    $policy
                );
            }
            // dd([
            //     '__METHOD__' => __METHOD__,
            //     '$model' => $model,
            //     '$register' => $register,
            //     '$this->policy_namespace' => $this->policy_namespace,
            // ]);

            Gate::policy($model, $register);
        }
    }
}
