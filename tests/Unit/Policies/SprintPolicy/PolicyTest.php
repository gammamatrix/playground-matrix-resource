<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Tests\Unit\Playground\Matrix\Resource\Policies\SprintPolicy;

use PHPUnit\Framework\Attributes\CoversClass;
use Playground\Matrix\Resource\Policies\SprintPolicy;
use Tests\Unit\Playground\Matrix\Resource\TestCase;

/**
 * \Tests\Unit\Playground\Matrix\Resource\Policies\SprintPolicy\PolicyTest
 */
#[CoversClass(SprintPolicy::class)]
class PolicyTest extends TestCase
{
    public function test_policy_instance(): void
    {
        $instance = new SprintPolicy;

        $this->assertInstanceOf(SprintPolicy::class, $instance);
    }
}
