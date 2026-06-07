<?php

/**
 * Playground
 */

declare(strict_types=1);

namespace Tests\Unit\Playground\Matrix\Resource\Http\Requests\Ticket;

use Playground\Matrix\Resource\Http\Requests\Ticket\DestroyRequest;
use Tests\Unit\Playground\Matrix\Resource\Http\Requests\RequestTestCase;

/**
 * \Tests\Unit\Playground\Matrix\Resource\Http\Requests\Ticket\DestroyRequestTest
 */
class DestroyRequestTest extends RequestTestCase
{
    protected string $requestClass = DestroyRequest::class;
}
