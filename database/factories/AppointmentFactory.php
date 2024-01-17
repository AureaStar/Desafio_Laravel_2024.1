<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Specialty;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Appointment>
 */
class AppointmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'procedure_start' => $this->faker->dateTime(),
            'procedure_end' => $this->faker->dateTime(),
            'price' => $this->faker->randomFloat(2, 0, 8),
            'status' => $this->faker->randomElement(['scheduled', 'canceled', 'completed']),
            'patient_id' => Patient::factory(),
            'doctor_id' => Doctor::factory(),
            'specialty_id' => Specialty::factory(),
        ];
    }
}
