<?php

namespace App\Http\Transporters;

use App\Http\Transporters\Services\DPD\DPD;
use App\Http\Transporters\Services\UPS\UPS;
use App\Http\Transporters\Services\TNT\TNT;
use App\Http\Transporters\Services\DHL\DHL;
use App\Http\Transporters\Services\Fedex\Fedex;
use App\Http\Transporters\Services\Courier\Courier;
use App\Http\Transporters\Services\Palletways\Palletways;

/**
 * Class ScrapeService
 * @package App\Service
 */
class TransporterService
{
    /**
     * @var object
     */
    public $transporter;

    /**
     * Transporter service classes
     */
    const SERVICES = [
        'tnt' => TNT::class,
        'dhl' => DHL::class,
        'ups' => UPS::class,
        'fedex' => Fedex::class,
        'courier' => Courier::class,
        'pallet' => Palletways::class,
	    'dpd' => DPD::class,
    ];

    /**
     * TransporterService constructor.
     * @param string $service
     * @throws Exception
     */
    public function __construct(string $service) {
        $this->transporter = $this->getServiceClass($service);
    }

    /**
     * @param string $service
     * @return mixed
     * @throws Exception
     */
    private function getServiceClass(string $service) {
        $class = self::SERVICES[$service] ?? null;

        if (empty($class) || !class_exists($class)) {
            throw new \Exception('No service class found for: ' . $service);
        }

        return new $class();
    }
}