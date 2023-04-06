<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\ShipmentColli;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ShipmentColli>
 */
class ShipmentColliFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ShipmentColli::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'shipment_id' => $this->faker->numberBetween(1, 10),
            'length' => $this->faker->numberBetween(1, 1000),
            'width' => $this->faker->numberBetween(1, 1000),
            'height' => $this->faker->numberBetween(1, 1000),
            'weight' => $this->faker->numberBetween(1, 1000),
            'amount' => $this->faker->numberBetween(1, 1000),
            'sequence_number' => $this->faker->numberBetween(1, 1000),
            'stackable' => $this->faker->boolean(50),
            'description' => $this->faker->sentence(3),
            'code' => $this->faker->sentence(3),
            'type' => $this->faker->sentence(3),
            'insurance' => $this->faker->numberBetween(1, 1000),
            'boxes' => $this->faker->numberBetween(1, 1000),
        ];
    }
}
