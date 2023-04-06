<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShipmentContactAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'company',
        'phone',
        'streetLines',
        'city',
        'stateOrProvinceCode',
        'zip',
        'countryCode',
        'email',
        'private',
    ];

    public function shipment()
    {
        return $this->belongsTo(Shipment::class);
    }

}
