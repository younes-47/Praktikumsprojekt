<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EquipementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'Modele' => $this->faker->bothify('???? - ##???###'),
            'Type' => $this->faker->randomElement(['Imprimante', 'Ordinateur', 'Ecran', 'Scanner', 'Chaise', 'Bureau', 'Paquet de Papiers', 'Telephone Fixe', 'Désinfectants Hydroalcoolique', 'Bavettes']),
            'details' => $this->faker->text(100),
        ];
    }
}
