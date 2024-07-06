<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Tests\Unit\Playground\Matrix\Resource\Http\Requests\Backlog;

use PHPUnit\Framework\Attributes\CoversClass;
use Playground\Matrix\Resource\Http\Requests\Backlog\CreateRequest;
use Tests\Unit\Playground\Matrix\Resource\Http\Requests\RequestTestCase;

/**
 * \Tests\Unit\Playground\Matrix\Resource\Http\Requests\Backlog\CreateRequestTest
 */
#[CoversClass(CreateRequest::class)]
class CreateRequestTest extends RequestTestCase
{
    protected string $requestClass = CreateRequest::class;
}
