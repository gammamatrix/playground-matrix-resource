<?php

/**
 * Playground
 */

declare(strict_types=1);

namespace Tests\Unit\Playground\Matrix\Resource\Policies\ReleasePolicy;

use PHPUnit\Framework\Attributes\CoversClass;
use Playground\Matrix\Resource\Policies\ReleasePolicy;
use Tests\Unit\Playground\Matrix\Resource\TestCase;

/**
 * \Tests\Unit\Playground\Matrix\Resource\Policies\ReleasePolicy\PolicyTest
 */
#[CoversClass(ReleasePolicy::class)]
class PolicyTest extends TestCase
{
    public function test_policy_instance(): void
    {
        $instance = new ReleasePolicy;

        /** @phpstan-ignore method.alreadyNarrowedType */
        $this->assertInstanceOf(ReleasePolicy::class, $instance);
    }
}
