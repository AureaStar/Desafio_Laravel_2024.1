<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\User;
use App\Models\Specialty;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DoctorSeeder extends Seeder
{

    
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $specialtyIds = Specialty::pluck('id');

        $users = User::factory(10)->create(
            [
                'user_type' => 'doctor',
            ]
            )->pluck('id');

        foreach ($users as $user) {
            Doctor::factory()->create(
                [
                    'user_id' => $user,
                    'specialty_id' => $specialtyIds->random(),
                ]
            );
        }
    }

}