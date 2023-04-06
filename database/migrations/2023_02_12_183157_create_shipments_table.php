<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();
            $table->string('shipment_date');
            $table->string('shipment_currency');
            $table->string('shipment_collies');
            $table->string('shipment_colli');
            $table->string('shipment_insurance_value');
            $table->foreignId('shipment_shipper_id')->constrained('shipment_contact_addresses');
            $table->foreignId('shipment_recipient_id')->constrained('shipment_contact_addresses');
            $table->string('shipment_exw_address');
            $table->string('shipment_reference');
            $table->string('shipment_invoice_reference');
            $table->string('shipment_is_custom_duty');
            $table->string('shipment_document_content');
            $table->string('shipment_custom_value_amount');
            $table->string('shipment_description');
            $table->string('shipment_service');
            $table->string('shipment_type');
            $table->string('shipment_tracking');
            $table->string('shipment_pickup_option');
            $table->string('shipment_pickup_location');
            $table->string('shipment_pickup_time_start');
            $table->string('shipment_pickup_time_until');
            $table->string('shipment_pickup_date');
            $table->string('shipment_pickup_instructions');
            $table->string('company_id');
            $table->string('labels');
            $table->string('label_template');
            $table->string('dimension_length_limit');
            $table->string('dimension_width_limit');
            $table->string('dimension_height_limit');
            $table->string('dimension_weight_limit');
            $table->string('dimension_volume_limit');
            $table->string('tailgate_weight_limit');
            $table->string('rate');
            $table->string('invoice_base64_file');
            $table->string('invoice_file_name');
            $table->string('invoice_reference');
            $table->string('invoice_origin_country_code');
            $table->string('invoice_destination_country_code');
            $table->string('service_collection_code');
            $table->string('service_collection_surcharge');
            $table->string('service_delivery_code');
            $table->string('service_delivery_surcharge');
            $table->string('lifts');
            $table->string('total_distance');
            $table->string('total_duration');
            $table->string('exw');
            $table->string('exw_account');
            $table->string('document_id');
            $table->string('shipment_status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shipments');
    }
};
