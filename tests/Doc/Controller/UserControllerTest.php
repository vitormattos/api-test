<?php

namespace Tests\Doc\Controller;

use ByJG\ApiTools\ApiRequester;
use Tests\Doc\ApiTestCase;

final class UserControllerTest extends ApiTestCase
{
    public function testRequestGetWithEmptyDatabase(): void
    {
        $request = new ApiRequester();
        $request
            ->withMethod('GET')
            ->withPath('/user')
            ->assertResponseCode(204);
        $this->assertRequest($request);
    }

    public function testRequestGetWithOneEntry(): void
    {
        $request = new ApiRequester();
        $request
            ->withMethod('POST')
            ->withPath('/user')
            ->withRequestHeader([
                'Content-Type' => 'application/json'
            ])
            ->withRequestBody([
                'id' => 1,
                'name' => 'User1'
            ])
            ->assertResponseCode(201);
        $this->assertRequest($request);

        $request = new ApiRequester();
        $request
            ->withMethod('GET')
            ->withPath('/user')
            ->assertResponseCode(200);
        $this->assertRequest($request);
    }
}
