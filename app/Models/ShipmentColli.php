<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShipmentColli extends Model
{
    use HasFactory;

    protected $fillable = [
        'shipment_id',
        'length',
        'width',
        'height',
        'weight',
        'amount',
        'sequence_number',
        'stackable',
        'description',
        'code',
        'type',
        'insurance',
        'boxes',
    ];

    public function shipment()
    {
        return $this->belongsTo(Shipment::class);
    }

}
