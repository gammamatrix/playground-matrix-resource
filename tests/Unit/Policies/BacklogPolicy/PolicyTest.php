<?php
/**
 * Playground
 *
 */

namespace Tests\Unit\Playground\Matrix\Resource\Policies\BacklogPolicy;

use Playground\Matrix\Resource\Policies\BacklogPolicy;
use Tests\Unit\Playground\Matrix\Resource\TestCase;

/**
 * \ests\Unit\Playground\Matrix\Resource\Policies\BacklogPolicy\PolicyTest
 *
 */
class PolicyTest extends TestCase
{
    public function test_policy_instance(): void
    {
        $instance = new BacklogPolicy;

        $this->assertInstanceOf(BacklogPolicy::class, $instance);
    }
}
