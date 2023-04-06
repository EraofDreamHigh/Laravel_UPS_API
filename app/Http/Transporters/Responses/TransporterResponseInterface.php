<?php

namespace App\Http\Transporters\Responses;

interface TransporterResponseInterface {

    public function isSuccess(): bool;

    public function getMessage(): string;

    public function getStatusCode(): int;

}
