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
        $appointmentDateTime = Carbon::createFromFormat('Y-m-d H:i', $date . ' ' . $time, 'America/Sao_Paulo');
        $now = Carbon::now('America/Sao_Paulo');

        if ($appointmentDateTime->isBefore($now)) {
            return redirect(route('patients.appointments'))->with('error', 'Não é possível agendar para um horário passado.');
        }
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
            return 'dawn'; // Madrugada
        } elseif ($valorNumerico >= 600 && $valorNumerico < 1200) {
            return 'morning'; // Manhã
        } elseif ($valorNumerico >= 1200 && $valorNumerico < 1800) {
            return 'afternoon'; // Tarde
        } elseif ($valorNumerico >= 1800 && $valorNumerico < 2400) {
            return 'night'; // Noite
        } else {
            return 'Invalid period'; // Período inválido
        }
    }

    public function destroy(Appointment $appointment)
    {
        $now = Carbon::now()->setTimezone('America/Sao_Paulo');
        $appointmentDate = Carbon::parse($appointment->procedure_start, 'America/Sao_Paulo');

        // Calcula a diferença em dias
        $daysUntilAppointment = $now->diffInDays($appointmentDate, false);

        // Verifica se o agendamento já ocorreu
        if ($appointment->procedure_end < $now->format('Y-m-d H:i:s')) {
            return redirect(route('patients.appointments'))->with('error', 'Não é possível excluir um agendamento que já foi realizado.');
        // Verifica se a tentativa de cancelamento ocorre menos de 3 dias antes
        } elseif ($daysUntilAppointment < 3) {
            return redirect(route('patients.appointments'))->with('error', 'Não é possível cancelar o agendamento com menos de 3 dias de antecedência.');
        }

        $appointment->delete();

        return redirect(route('patients.appointments'))->with('success', 'Agendamento excluído com sucesso!');
    }

    public function report()
    {
        Carbon::setLocale('pt_BR');
        $user = auth()->user();
        $now = Carbon::now()->setTimezone('America/Sao_Paulo')->format('Y-m-d H:i:s');
        $appointments = $user->doctor->appointments()
            ->where('procedure_end', '<', $now)
            ->get();
        $appointmentsByMonth = $appointments->groupBy(function ($appointment) {
            return Carbon::parse($appointment->procedure_start)->isoFormat('MMMM YYYY');
        });
        $datetime = Carbon::now()->setTimezone('America/Sao_Paulo')->format('d/m/Y H:i:s');
        $pdf = Pdf::loadView('doctor/appointments_report', [
            'user' => $user,
            'appointments' => $appointments,
            'appointmentsByMonth' => $appointmentsByMonth,
            'datetime' => $datetime
        ]);
        return $pdf->stream();
    }

}
