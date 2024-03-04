<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@starlight.com',
            'user_type' => 'admin',
        ]);
        $this->call([
            HealthPlanSeeder::class,
            SpecialtySeeder::class,
            DoctorSeeder::class,
            PatientSeeder::class,
        ]);
    }
}
