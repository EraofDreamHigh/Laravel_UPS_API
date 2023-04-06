<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Shipment;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Shipment>
 */
class ShipmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Shipment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $this->faker->addProvider(new Faker\Provider\en_AU\Address($faker));

        return [
            'shipment_date' => $this->faker->dateTimeBetween('-1 years', 'now'),
            'shipment_currency' => $this->faker->currencyCode,
            'shipment_collies' => $this->faker->numberBetween(1, 10),
            'shipment_colli' => $this->faker->numberBetween(1, 10),
            'shipment_insurance_value' => $this->faker->numberBetween(1, 1000),
            'shipment_shipper_id' => $this->faker->numberBetween(1, 50),
            'shipment_recipient_id' => $this->faker->numberBetween(1, 50),
            'shipment_exw_address' => $this->faker->address,
            'shipment_reference' => $this->faker->sentence(3),
            'shipment_invoice_reference' => $this->faker->sentence(3),
            'shipment_is_custom_duty' => $this->faker->boolean(50),
            'shipment_document_content' => $this->faker->sentence(3),
            'shipment_custom_value_amount' => $this->faker->numberBetween(1, 1000),
            'shipment_description' => $this->faker->sentence(3),
            'shipment_service' => $this->faker->sentence(3),
            'shipment_type' => $this->faker->sentence(3),
            'shipment_tracking' => $this->faker->sentence(3),
            'shipment_pickup_option' => $this->faker->sentence(3),
            'shipment_pickup_location' => $this->faker->sentence(3),
            'shipment_pickup_time_start' => $this->faker->time(),
            'shipment_pickup_time_until' => $this->faker->time(),
            'shipment_pickup_date' => $this->faker->dateTimeBetween('-1 years', 'now'),
            'shipment_pickup_instructions' => $this->faker->sentence(3),
            'company_id' => $this->faker->numberBetween(1, 10),
            'labels' => $this->faker->sentence(3),
            'label_template' => $this->faker->sentence(3),
            'dimension_length_limit' => $this->faker->numberBetween(1, 1000),
            'dimension_width_limit' => $this->faker->numberBetween(1, 1000),
            'dimension_height_limit' => $this->faker->numberBetween(1, 1000),
            'dimension_weight_limit' => $this->faker->numberBetween(1, 1000),
            'dimension_volume_limit' => $this->faker->numberBetween(1, 1000),
            'tailgate_weight_limit' => $this->faker->numberBetween(1, 1000),
            'rate' => $this->faker->numberBetween(1, 1000),
            'invoice_base64_file' => $this->faker->sentence(3),
            'invoice_file_name' => $this->faker->sentence(3),
            'invoice_reference' => $this->faker->sentence(3),
            'invoice_origin_country_code' => $this->faker->countryCode,
            'invoice_destination_country_code' => $this->faker->countryCode,
            'service_collection_code' => $this->faker->sentence(3),
            'service_collection_surcharge' => $this->faker->numberBetween(1, 1000),
            'service_delivery_code' => $this->faker->sentence(3),
            'service_delivery_surcharge' => $this->faker->numberBetween(1, 1000),
            'lifts' => $this->faker->numberBetween(1, 1000),
            'total_distance' => $this->faker->numberBetween(1, 1000),
            'total_duration' => $this->faker->numberBetween(1, 1000),
            'exw' => $this->faker->numberBetween(1, 1000),
            'exw_account' => $this->faker->numberBetween(1, 1000),
            'document_id' => $this->faker->numberBetween(1, 1000),
            'shipment_status' => $this->faker->sentence(3),
        ];
    }
}
