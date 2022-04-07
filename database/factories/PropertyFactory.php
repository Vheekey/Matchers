<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Property>
 */
class PropertyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->sentence(),
            'address' => $this->faker->address(),
            'propertyType' => $this->faker->randomElement(['d44d0090-a2b5-47f7-80bb-d6e6f85fca90', 'd44d0090-a2b5-47f7-80bb-d6e6f85fca90', $this->faker->uuid()]),
            'area' => $this->faker->randomNumber(3),
            'yearOfConstruction' => $this->faker->year(),
            'rooms' => $this->faker->randomDigitNotZero(),
            'heatingType' => $this->faker->randomElement(['gas','coal']),
            'parking' => $this->faker->boolean(),
            'returnActual' => $this->faker->randomNumber(2),
            'price' => $this->faker->randomNumber(3),
            'returnPotential' => $this->faker->randomNumber(3),
        ];
    }
}
