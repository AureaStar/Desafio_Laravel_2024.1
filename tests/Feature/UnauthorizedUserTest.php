<?php
namespace Tests\Feature\Auth;

use App\Models\{User, Specialty, Doctor};
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UnauthorizedUserTest extends TestCase
{
    public function testCreateMedicoUnauthorized()
    {
        $user = User::factory()->create([
            'user_type' => 'patient',
        ]);

        $specialty = Specialty::factory()->create();
        $this->actingAs($user);

        $response = $this->post(route('doctors.store'), [
            'name' => 'Dr. João',
            'email' => 'drjoao@starlight.com',
            'password' => 'password',
            'birth_date' => '1999-01-01',
            'work_period' => 'morning',
            'image' => '',
            'crm' => '123456',
            'specialty' => $specialty->id,
            'phone' => '123456789',
            'cpf' => '12345678910112',
            'address' => 'Rua 1',
        ]);

        $response->assertStatus(403);

    }

    public function testUpdateMedicoUnauthorized()
    {
        $user = User::factory()->create(
            [
                'user_type' => 'patient'
            ]
        );

        $doctor = Doctor::factory()->create();

        $specialty = Specialty::factory()->create();

        $response = $this->actingAs($user)->put(route('doctors.update', $doctor->id), [
            'name' => 'Dr. João',
            'email' => 'drjoao@starlight.com',
            'password' => 'password',
            'birth_date' => '1999-01-01',
            'work_period' => 'morning',
            'image' => '',
            'crm' => '123456',
            'specialty' => $specialty->id,
            'phone' => '123456789',
            'cpf' => '12345678910112',
            'address' => 'Rua 1',
        ]);

        $response->assertStatus(403);

    }

    public function testDeleteMedicoUnauthorized()
    {
        $user = User::factory()->create(
            [
                'user_type' => 'patient'
            ]
        );

        $doctor = Doctor::factory()->create();

        $response = $this->actingAs($user)->delete(route('doctors.destroy', $doctor->id));

        $response->assertStatus(403);

    }
}
