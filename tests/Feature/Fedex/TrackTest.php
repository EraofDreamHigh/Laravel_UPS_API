<?php

namespace Tests\Feature\Fedex;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use \App\Http\Transporters\Services\Fedex\Track\Example;

class TrackTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_the_tracking_endpoint_returns_a_successful_response()
    {
        $request = new Example();
        $jsonres = $request->getTrack();
        $this->assertArrayHasKey('output', $jsonres);
    }
}
