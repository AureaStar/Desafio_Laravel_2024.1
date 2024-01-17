<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Specialty;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Doctor>
 */
class DoctorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'address' => $this->faker->address(),
            'phone' => $this->faker->phoneNumber(),
            'birth_date' => $this->faker->date(),
            'cpf' => $this->faker->numerify('###.###.###-##'),
            'work_period' => $this->faker->randomElement(['morning', 'afternoon', 'night', 'dawn']),
            'crm' => $this->faker->randomNumber(),
            'image' => $this->faker->imageUrl(),
            'user_id' => User::factory(),
            'specialty_id' => Specialty::factory(),
        ];
    }
}
