<?php

namespace Tests\Feature\Fedex;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use \App\Http\Transporters\Services\Fedex\Rate\Example;

class RatesTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_the_rates_endpoint_returns_a_successful_response()
    {
        $request = new Example();
        $jsonres = $request->getRates();
        $this->assertArrayHasKey('output', $jsonres);
    }
}
