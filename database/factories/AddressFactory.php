<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Address>
 */
class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = \Faker\Factory::create('pt_BR');

        $stateInitials = [
            'AC', 'AL', 'AM', 'AP', 'BA', 'CE', 'DF', 'ES', 'GO', 'MA','MG', 'MS', 'MT', 'PA', 
            'PB', 'PE', 'PI', 'PR', 'RJ', 'RN','RO', 'RR', 'RS', 'SC', 'SE', 'SP', 'TO'
        ];

        return [
            'street' => $faker->streetAddress(),
            'neighbourhood' => $faker->word(),
            'city' => $faker->city(),
            'state' => $faker->randomElement($stateInitials),
            'zip_code' => $faker->postcode(),
            'house_number' => $faker->numberBetween(1, 500),
            'complement' => $faker->optional()->word,
        ];
    }
}
