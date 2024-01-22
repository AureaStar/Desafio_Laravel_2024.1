<?php

namespace Database\Seeders;

use App\Models\Specialty;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SpecialtySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Specialty::factory()->create([
            'name' => 'Cardiología',
            'description' => 'Tratamento de enfermidades do coração',
            'value' => '100.00'
        ]);
        Specialty::factory()->create([
            'name' => 'Dermatología',
            'description' => 'Tratamento de enfermidades da pele',
            'value' => '150.00'
        ]);
        Specialty::factory()->create([
            'name' => 'Endocrinología',
            'description' => 'Tratamento de enfermidades do sistema endócrino',
            'value' => '200.00'
        ]);
        Specialty::factory()->create([
            'name' => 'Gastroenterología',
            'description' => 'Tratamento de enfermidades do sistema digestivo',
            'value' => '250.00'
        ]);
        Specialty::factory()->create([
            'name' => 'Ginecología',
            'description' => 'Tratamento de enfermidades do sistema reproductor feminino',
            'value' => '300.00'
        ]);
        Specialty::factory()->create([
            'name' => 'Hematología',
            'description' => 'Tratamento de enfermidades do sangue',
            'value' => '350.00'
        ]);
        Specialty::factory()->create([
            'name' => 'Infectología',
            'description' => 'Tratamento de enfermidades infecciosas',
            'value' => '400.00'
        ]);
        Specialty::factory()->create([
            'name' => 'Medicina interna',
            'description' => 'Tratamento de enfermidades do sistema digestivo',
            'value' => '450.00'
        ]);
        Specialty::factory()->create([
            'name' => 'Nefrología',
            'description' => 'Tratamento de enfermidades dos rins',
            'value' => '500.00'
        ]);
        Specialty::factory()->create([
            'name' => 'Neumología',
            'description' => 'Tratamento de enfermidades do sistema respiratório',
            'value' => '550.00'
        ]);
        Specialty::factory()->create([
            'name' => 'Neurología',
            'description' => 'Tratamento de enfermidades do sistema nervioso',
            'value' => '600.00'
        ]);
        Specialty::factory()->create([
            'name' => 'Oftalmología',
            'description' => 'Tratamento de enfermidades dos olhos',
            'value' => '650.00'
        ]);
        Specialty::factory()->create([
            'name' => 'Oncología',
            'description' => 'Tratamento de enfermidades do câncer',
            'value' => '700.00'
        ]);
        Specialty::factory()->create([
            'name' => 'Otorrinolaringología',
            'description' => 'Tratamento de enfermidades do ouvido, nariz e garganta',
            'value' => '750.00'
        ]);
        Specialty::factory()->create([
            'name' => 'Pediatría',
            'description' => 'Tratamento de enfermidades de crianças',
            'value' => '800.00'
        ]);
        Specialty::factory()->create([
            'name' => 'Psiquiatría',
            'description' => 'Tratamento de enfermidades mentais',
            'value' => '850.00'
        ]);
        Specialty::factory()->create([
            'name' => 'Reumatología',
            'description' => 'Tratamento de enfermidades do sistema músculo-esquelético',
            'value' => '900.00'
        ]);
        Specialty::factory()->create([
            'name' => 'Traumatología',
            'description' => 'Tratamento de enfermidades do sistema músculo-esquelético',
            'value' => '950.00'
        ]);
        Specialty::factory()->create([
            'name' => 'Urología',
            'description' => 'Tratamento de enfermidades do sistema urinário',
            'value' => '1000.00'
        ]);
    }
}
