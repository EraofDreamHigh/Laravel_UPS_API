<?php

namespace Tests\Feature\Fedex;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use \App\Http\Transporters\Services\Fedex\Shipment\Example;

class ShipmentTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_the_shipment_endpoint_returns_a_successful_response()
    {
        $request = new Example();
        $jsonres = $request->createShipment();
        $this->assertArrayHasKey('output', $jsonres);
    }
}
