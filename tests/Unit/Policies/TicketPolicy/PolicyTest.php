<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Tests\Unit\Playground\Matrix\Resource\Policies\TicketPolicy;

use PHPUnit\Framework\Attributes\CoversClass;
use Playground\Matrix\Resource\Policies\TicketPolicy;
use Tests\Unit\Playground\Matrix\Resource\TestCase;

/**
 * \Tests\Unit\Playground\Matrix\Resource\Policies\TicketPolicy\PolicyTest
 */
#[CoversClass(TicketPolicy::class)]
class PolicyTest extends TestCase
{
    public function test_policy_instance(): void
    {
        $instance = new TicketPolicy;

        $this->assertInstanceOf(TicketPolicy::class, $instance);
    }
}
