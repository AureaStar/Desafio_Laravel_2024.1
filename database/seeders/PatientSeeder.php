<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Patient;
use App\Models\User;
use Dflydev\DotAccessData\Data;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::factory(30)->create(
            [
                'user_type' => 'patient',
            ]
            );

            $userIds = $users->pluck('id');
        
            foreach ($userIds as $userid) {
                Patient::factory()->create(
                    [
                        'user_id' => $userid,
                    ]
                );
            }

    }
}