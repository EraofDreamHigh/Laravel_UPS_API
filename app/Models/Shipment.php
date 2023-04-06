<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'shipment_date',
        'shipment_currency',
        'shipment_collies',
        'shipment_colli',
        'shipment_insurance_value',
        'shipment_shipper',
        'shipment_recipient',
        'shipment_exw_address',
        'shipment_reference',
        'shipment_invoice_reference',
        'shipment_is_custom_duty',
        'shipment_document_content',
        'shipment_custom_value_amount',
        'shipment_description',
        'shipment_service',
        'shipment_type',
        'shipment_tracking',
        'shipment_pickup_option',
        'shipment_pickup_location',
        'shipment_pickup_time_start',
        'shipment_pickup_time_until',
        'shipment_pickup_date',
        'shipment_pickup_instructions',
        'company_id',
        'labels',
        'label_template',
        'dimension_length_limit',
        'dimension_width_limit',
        'dimension_height_limit',
        'dimension_weight_limit',
        'dimension_volume_limit',
        'tailgate_weight_limit',
        'rate',
        'invoice_base64_file',
        'invoice_file_name',
        'invoice_reference',
        'invoice_origin_country_code',
        'invoice_destination_country_code',
        'service_collection_code',
        'service_collection_surcharge',
        'service_delivery_code',
        'service_delivery_surcharge',
        'lifts',
        'total_distance',
        'total_duration',
        'exw',
        'exw_account',
        'document_id',
        'shipment_status',
    ];

    public function collies()
    {
        return $this->hasMany(ShipmentColli::class);
    }

    public function shipper()
    {
        return $this->belongsTo(ShipmentContactAddress::class, 'shipment_shipper_id');
    }

    public function recipient()
    {
        return $this->belongsTo(ShipmentContactAddress::class, 'shipment_recipient_id');
    }

}
