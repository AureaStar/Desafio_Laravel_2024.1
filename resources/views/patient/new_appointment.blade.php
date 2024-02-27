@extends('adminlte::page')

@section('content')

<form action="{{ route('patients.appointments.store') }}" method="POST">
    @csrf
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Novo Agendamento</h3>
        </div>
        <div class="box-body">
            <div class="form-group">
                <label for="specialty">Especialidade</label>
                <input type="text" class="form-control" id="specialty" value="{{ $specialty->name }}" readonly>
                <input type="hidden" name="specialty_id" value="{{ $specialty->id }}">
            </div>
            <div class="form-group">
                <label for="procedure_start">Data e Hora</label>
                <input type="text" class="form-control" id="procedure_start" name="procedure_start" value="{{ $date . ' ' . $time . ':00' }}" readonly>
            </div>
            <div class="form-group">
                <label for="doctor">Médico</label>
                <select class="form-control" id="doctor" name="doctor_id">
                    <option value="" disabled selected>Selecione</option>
                    @foreach ($doctors as $doctor)
                    <option value="{{ $doctor->id }}">{{ $doctor->user->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="health_plan">Plano de Saúde</label>
                <input type="text" class="form-control" id="health_plan" value="{{ $health_plan->name }}" readonly>
            </div>
            <div class="form-group">
                <label for="price">Valor (R$)</label>
                <input type="number" class="form-control" id="price" name="price" step="0.01" value="{{$valor}}" readonly>
            </div>
            <input type="hidden" name="patient_id" value="{{ $user->patient->id }}">
            <input type="hidden" name="procedure_end" value="{{ $date . ' ' . $final_time . ':00' }}">
            <input type="hidden" name="status" value="scheduled">
        </div>
        <div class="box-footer" style="display: flex; justify-content: space-between; padding: 10px 5px;">
            <button type="submit" class="btn btn-success">Agendar</button>
            <a type="button" class="btn btn-default" href="{{ route('patients.appointments') }}">Cancelar</a>
        </div>
    </div>
</form>

@stop