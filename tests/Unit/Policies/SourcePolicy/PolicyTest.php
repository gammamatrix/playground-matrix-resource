<?php

/**
 * Playground
 */

declare(strict_types=1);

namespace Tests\Unit\Playground\Matrix\Resource\Policies\SourcePolicy;

use PHPUnit\Framework\Attributes\CoversClass;
use Playground\Matrix\Resource\Policies\SourcePolicy;
use Tests\Unit\Playground\Matrix\Resource\TestCase;

/**
 * \Tests\Unit\Playground\Matrix\Resource\Policies\SourcePolicy\PolicyTest
 */
#[CoversClass(SourcePolicy::class)]
class PolicyTest extends TestCase
{
    public function test_policy_instance(): void
    {
        $instance = new SourcePolicy;

        /** @phpstan-ignore method.alreadyNarrowedType */
        $this->assertInstanceOf(SourcePolicy::class, $instance);
    }
}
