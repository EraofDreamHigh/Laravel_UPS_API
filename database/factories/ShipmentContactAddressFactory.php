<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\ShipmentContactAddress;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ShipmentContactAddress>
 */
class ShipmentContactAddressFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ShipmentContactAddress::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'company' => $this->faker->company,
            'phone' => $this->faker->phoneNumber,
            'streetLines' => $this->faker->streetAddress,
            'city' => $this->faker->city,
            'stateOrProvinceCode' => $this->faker->stateAbbr,
            'zip' => $this->faker->postcode,
            'countryCode' => $this->faker->countryCode,
            'email' => $this->faker->email,
            'private' => $this->faker->boolean(50),
        ];
    }
}
