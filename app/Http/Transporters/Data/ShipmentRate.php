<?php

namespace App\Http\Transporters\Data;

class ShipmentRate
{

    private $service = null;

    private $price = 0;

    private $distance = 0;

    private $duration = 0;

    private $pickup_distance = 0;

    private $pickup_duration = 0;

    private $delivery_at = null;

    public function setService( string $service ){
        $this->service = $service;
    }

    public function setPrice( float $price ){
        $this->price = toPrice($price);
    }

    public function setDistance( int $distance ){
        $this->distance = $distance;
    }

    public function setPickupDistance( int $pickup_distance ){
        $this->pickup_distance = $pickup_distance;
    }

    public function setPickupDuration( int $pickup_duration ){
        $this->pickup_duration = $pickup_duration;
    }

    public function setDuration( float $duration ){
        $this->duration = $duration;
    }

    public function setDeliveryAt( string $delivery_at ){
        $this->delivery_at = isoDateTime($delivery_at);
    }

    public function getRate(){

        $rate = (object) [
            'service' => $this->service,
            'price' => $this->price,
            'distance' => $this->distance,
            'duration' => $this->duration,
            'pickup_distance' => $this->pickup_distance,
            'pickup_duration' => $this->pickup_duration,
            'delivery_at' => $this->delivery_at,
        ];

        return $rate;

    }

}
