<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DoctorSeeder extends Seeder
{

    
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::factory(30)->create(
            [
                'user_type' => 'doctor',
            ]
            )->pluck('id');

        foreach ($users as $user) {
            Doctor::factory()->create(
                [
                    'user_id' => $user,
                ]
            );
        }
    }

}