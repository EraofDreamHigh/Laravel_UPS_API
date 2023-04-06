<?php

namespace App\Http\Transporters\Requests;

use Illuminate\Support\Str;

abstract class TransporterRequestAbstract implements TransporterRequestInterface
{
    /**
     * @var array
     */
    private $transactionId;

    /**
     * TransportTransformerAbstract constructor.
     */
    public function __construct() {
        $this->transactionId = Str::random(32);
    }

    /**
     * @return array|string
     */
    public function getTransactionId() {
        return $this->transactionId;
    }

}
