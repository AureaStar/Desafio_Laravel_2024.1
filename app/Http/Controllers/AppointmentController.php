<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use App\Models\{Appointment, Doctor, Specialty};

class AppointmentController extends Controller
{
    //

    public function index()
    {
        return redirect(route('patients.appointments'));
    }

    public function create(Request $request)
    {
        $user = auth()->user();
        $specialtyid = $request->specialty_id;
        $specialty = Specialty::find($specialtyid);
        $date = $request->date;
        $time = $request->time;
        $final_time = date('H:i', strtotime($time . ' +2 hours'));
        $health_plan = auth()->user()->patient->health_plan;
        $valor = $specialty->value - ($specialty->value * ($health_plan->discount / 100));
        $periodo = $this->verificarPeriodo($time);
        $doctors = Doctor::where('specialty_id', $specialtyid)
            ->where('work_period', $periodo)
            ->get();
        $doctors = $doctors->filter(function ($doctor) use ($time , $date) {
            if ($doctor->appointments->isEmpty()) {
                return true;
            }
            foreach ($doctor->appointments as $appointment) {
                if ($appointment->procedure_start === $date . ' ' . $time . ':00') {
                    return false;
                }
                return true;
            }
        });
        if ($doctors->isEmpty()) {
            return redirect(route('patients.appointments'))->with('error', 'Nenhum médico encontrado para o horário selecionado. Por favor, selecione outro horário.');
        }
        return view('patient/new_appointment', [
            'user' => $user,
            'specialty' => $specialty,
            'date' => $date,
            'time' => $time,
            'doctors' => $doctors,
            'valor' => $valor,
            'health_plan' => $health_plan,
            'final_time' => $final_time
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'patient_id' => 'required|integer',
            'doctor_id' => 'required|integer',
            'specialty_id' => 'required|integer',
            'procedure_start' => 'required|date',
            'procedure_end' => 'required|date',
            'price' => 'required|numeric',
            'status' => 'required|string|in:scheduled,canceled,completed'
        ]);

        $appointment = Appointment::create($validatedData);

        return redirect(route('patients.appointments'))->with('success', 'Agendamento criado com sucesso!');
    }

    public function verificarPeriodo($horario)
    {
        list($hora, $minuto) = explode(':', $horario);

        $valorNumerico = intval($hora) * 100 + intval($minuto);

        if ($valorNumerico >= 0 && $valorNumerico < 600) {
            return 'Dawn'; // Madrugada
        } elseif ($valorNumerico >= 600 && $valorNumerico < 1200) {
            return 'Morning'; // Manhã
        } elseif ($valorNumerico >= 1200 && $valorNumerico < 1800) {
            return 'Afternoon'; // Tarde
        } elseif ($valorNumerico >= 1800 && $valorNumerico < 2400) {
            return 'Night'; // Noite
        } else {
            return 'Invalid period'; // Período inválido
        }
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->delete();

        return redirect(route('patients.appointments'))->with('success', 'Agendamento excluído com sucesso!');
    }

    public function report()
    {
        $user = auth()->user();
        $now = Carbon::now()->setTimezone('America/Sao_Paulo')->format('d/m/Y H:i:s');
        $appointments = $user->doctor->appointments()
            ->where('procedure_end', '<', $now)
            ->get();
        $pdf = Pdf::loadView('doctor/appointments_report', [
            'user' => $user,
            'appointments' => $appointments,
            'datetime' => $now
        ]);
        return $pdf->stream();
    }

}
