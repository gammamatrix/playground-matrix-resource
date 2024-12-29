<?php

/**
 * Playground
 */

declare(strict_types=1);
namespace Tests\Unit\Playground\Matrix\Resource\Http\Requests\Tag;

use Tests\Unit\Playground\Matrix\Resource\Http\Requests\RequestTestCase;

/**
 * \Tests\Unit\Playground\Matrix\Resource\Http\Requests\Tag\CreateRequestTest
 */
class CreateRequestTest extends RequestTestCase
{
    protected string $requestClass = \Playground\Matrix\Resource\Http\Requests\Tag\CreateRequest::class;
}
