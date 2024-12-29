<?php

/**
 * Playground
 */

declare(strict_types=1);
namespace Tests\Unit\Playground\Matrix\Resource\Http\Requests\Note;

use Tests\Unit\Playground\Matrix\Resource\Http\Requests\RequestTestCase;

/**
 * \Tests\Unit\Playground\Matrix\Resource\Http\Requests\Note\RestoreRequestTest
 */
class RestoreRequestTest extends RequestTestCase
{
    protected string $requestClass = \Playground\Matrix\Resource\Http\Requests\Note\RestoreRequest::class;
}
