<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'Nom' => $this->faker->name(),
            'Telephone' => $this->faker->numerify('06########'),
            'Adresse'   => $this->faker->address,
            'NumeroPPR'     => $this->faker->bothify('?#?#'),
        ];
    }
}
