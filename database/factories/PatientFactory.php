<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Health_plan;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Patient>
 */
class PatientFactory extends Factory
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
            'image' => $this->faker->imageUrl(),
            'blood_type' => $this->faker->randomElement(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-']),
            'registration_status' => $this->faker->randomElement(['complete', 'incomplete']),
            'user_id' => User::factory(),
            'health_plan_id' => Health_plan::factory(),
        ];
    }
}
