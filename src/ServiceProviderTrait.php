<?php
/**
 * GammaMatrix
 */

namespace GammaMatrix\Playground\Matrix\Resource;

use Illuminate\Support\Facades\Gate;

/**
 * \GammaMatrix\Playground\Matrix\Resource\ServiceProviderTrait
 *
 * NOTE We could enforce a pattern policy_namespace.
 * TODO Do some tests with invalid input such as an array or the model class for the namespace.
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

    public function registerPolicies_getRegister(string $policy): string
    {
        $register = $policy;

        if (!empty($this->policy_namespace)) {
            // TODO test slashes with policies in App\Policies or another namespace.
            $register = str_replace(
                'GammaMatrix\\Playground\\Matrix\\Resource',
                $this->policy_namespace,
                $policy
            );
        }

        return $register;
    }

    /**
     * Register the application's policies.
     *
     * @return void
     */
    public function registerPolicies()
    {
        foreach ($this->policies() as $model => $policy) {

            $register = null;

            if ($policy && is_string($policy)) {
                $register = $this->registerPolicies_getRegister($policy);
            }

            // dd([
            //     '__METHOD__' => __METHOD__,
            //     '$model' => $model,
            //     '$register' => $register,
            //     '$this->policy_namespace' => $this->policy_namespace,
            // ]);

            if ($register) {
                Gate::policy($model, $register);
            }
        }
    }
}
