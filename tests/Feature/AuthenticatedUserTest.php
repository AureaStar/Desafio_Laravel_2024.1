<?php
namespace Tests\Feature\Auth;

use App\Models\{User, Specialty, Doctor};
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class AuthenticatedUserTest extends TestCase
{

    public function testCreateMedico()
    {
        $user = User::factory()->create(
            [
                'user_type' => 'admin'
            ]
        );
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

        $response->assertSessionHas('success', 'Doctor created successfully.');

    }

    public function testReadMedico()
    {
        $user = User::factory()->create(
            [
                'user_type' => 'admin'
            ]
        );

        $response = $this->actingAs($user)->get(route('doctors.index'));

        $response->assertStatus(200);
    }

    public function testUpdateMedico()
    {
        $user = User::factory()->create(
            [
                'user_type' => 'admin'
            ]
        );

        $doctor = Doctor::factory()->create();

        $specialty = Specialty::factory()->create();

        $response = $this->actingAs($user)->put(route('doctors.update', $doctor->id), [
            'name' => 'Dr. João',
            'email' => 'drjoao2@starlight.com',
            'password' => 'password',
            'birth_date' => '1999-01-01',
            'work_period' => 'morning',
            'image' => '',
            'crm' => '123456',
            'specialty' => $specialty->id,
            'phone' => '123456789',
            'cpf' => '12345678910113',
            'address' => 'Rua 1',
        ]);

        $response->assertSessionHas('success', 'Doctor updated successfully.');
    }

    public function testDeleteMedico()
    {
        $user = User::factory()->create(
            [
                'user_type' => 'admin'
            ]
        );

        $doctor = Doctor::factory()->create();

        $response = $this->actingAs($user)->delete(route('doctors.destroy', $doctor->id));

        $response->assertSessionHas('success', 'Doctor deleted successfully.');
    }
}