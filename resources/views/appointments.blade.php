@extends('adminlte::page')

@section('title', 'Consultas')

@section('content_header')
    <h1>Consultas</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Lista de Consultas</h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Paciente</th>
                        <th>Médico</th>
                        <th>Especialidade</th>
                        <th>Data</th>
                        <th>Preço</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($appointments as $appointment)
                        <tr>
                            <td>{{ $appointment->patient->name }}</td>
                            <td>{{ $appointment->doctor->name }}</td>
                            <td>{{ $appointment->specialty->name }}</td>
                            <td>{{ $appointment->date }}</td>
                            <td>{{ $appointment->price }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
        @if ($user->user_type == 'patient')
                <a href="{{ route('appointments.create') }}" class="btn btn-primary">Agendar Consulta</a>
            @elseif ($user->user_type == 'doctor')
                <!-- Gerar relatorio -->
                <a href="{{ route('appointments.report') }}" class="btn btn-primary">Gerar Relatório</a>
            @endif
    </div>
@stop
