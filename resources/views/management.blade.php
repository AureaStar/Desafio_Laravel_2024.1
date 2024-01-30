@extends('adminlte::page')

@section('content')
    @if ($table === 'dashboard')
        <x-adminlte-info-box title="{{$doctors_qtd}}" text="Médicos Cadastrados" icon="fas fa-lg fa-user-md text-primary" theme="gradient-primary" icon-theme="white" />
        <x-adminlte-info-box title="{{$patients_qtd}}" text="Pacientes Cadastrados" icon="fas fa-lg fa-user-injured text-teal" theme="gradient-teal" icon-theme="white" />
    @endif
    @if ($table === 'doctors')
        @include('includes.doctors_table', [
            'title' => 'Médicos',
            'table' => 'users',
            'specialties' => $specialties,
            'route' => 'doctors',
            'type' => 'doctor',
            'data' => $users,
            'extra_info' => 'specialty',
            'icon' => 'fas fa-user-md'
        ])
    @elseif ($table === 'patients')
        @include('includes.patients_table', [
        'title' => 'Pacientes',
        'table' => 'users',
        'health_plans' => $health_plans,
        'route' => 'patients',
        'type' => 'patient',
        'data' => $users,
        'extra_info' => 'health_plan',
        'icon' => 'fas fa-user-injured'
        ])
    @elseif ($table === 'specialties')
        @include('includes.specialties_table', [
        'title' => 'Especialidades',
        'specialties' => $specialties,
        'route' => 'specialties',
        'type' => 'specialty',
        'data' => $specialties,
        'extra_info' => 'value',
        'icon' => 'fas fa-stethoscope'
        ])
    @elseif ($table === 'health_plans')
        @include('includes.health_plans_table', [
        'title' => 'Planos de Saúde',
        'health_plans' => $health_plans,
        'route' => 'health_plans',
        'type' => 'health_plan',
        'data' => $health_plans,
        'extra_info' => 'discount',
        'icon' => 'fas fa-file-medical'
        ])
    @endif
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
@endsection

@section('js')
    <script src="{{ asset('js/format_inputs.js') }}"></script>
    </script>
@stop