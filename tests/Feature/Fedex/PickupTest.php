<?php

namespace Tests\Feature\Fedex;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use \App\Http\Transporters\Services\Fedex\Pickup\Example;

class PickupTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_the_pickup_endpoint_returns_a_successful_response()
    {
        $request = new Example();
        $jsonres = $request->createPickup();
        $this->assertArrayHasKey('output', $jsonres);
    }
}
