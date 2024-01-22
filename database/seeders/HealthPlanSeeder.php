<?php

namespace Database\Seeders;

use App\Models\Health_plan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HealthPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Health_plan::factory()->create([
            'name' => 'Unimed',
            'description' => 'Plano de saúde Unimed',
            'discount' => '10.00'
        ]);
        Health_plan::factory()->create([
            'name' => 'SulAmérica',
            'description' => 'Plano de saúde SulAmérica',
            'discount' => '20.00'
        ]);
        Health_plan::factory()->create([
            'name' => 'Bradesco',
            'description' => 'Plano de saúde Bradesco',
            'discount' => '30.00'
        ]);
        Health_plan::factory()->create([
            'name' => 'Amil',
            'description' => 'Plano de saúde Amil',
            'discount' => '40.00'
        ]);
        Health_plan::factory()->create([
            'name' => 'Hapvida',
            'description' => 'Plano de saúde Hapvida',
            'discount' => '50.00'
        ]);
        Health_plan::factory()->create([
            'name' => 'São Francisco',
            'description' => 'Plano de saúde São Francisco',
            'discount' => '60.00'
        ]);
        Health_plan::factory()->create([
            'name' => 'Unimed Fortaleza',
            'description' => 'Plano de saúde Unimed Fortaleza',
            'discount' => '70.00'
        ]);
        Health_plan::factory()->create([
            'name' => 'Unimed Belém',
            'description' => 'Plano de saúde Unimed Belém',
            'discount' => '80.00'
        ]);
        Health_plan::factory()->create([
            'name' => 'Unimed Recife',
            'description' => 'Plano de saúde Unimed Recife',
            'discount' => '90.00'
        ]);
        Health_plan::factory()->create([
            'name' => 'SUS',
            'description' => 'Sistema Único de Saúde',
            'discount' => '100.00'
        ]);
        Health_plan::factory()->create([
            'name' => 'Unimed São Paulo',
            'description' => 'Plano de saúde Unimed São Paulo',
            'discount' => '65.00'
        ]);

    }
}
