<?php

namespace App\Http\Transporters\Rules;

interface TransporterMustTransformInterface
{
    /**
     * @return array
     */
    public function transform(): array;
}