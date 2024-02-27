@extends('adminlte::page')

@section('content')

<x-adminlte-card title="Bem-vindo ao Painel de Controle" theme="primary" icon="fas fa-lg fa-tachometer-alt">
    <p>Olá, {{ $user->name }}!</p>
    <p>Seja bem-vindo ao painel de controle do sistema de gerenciamento de consultas médicas.</p>
</x-adminlte-card>

<x-adminlte-info-box title="{{$doctors_qtd}}" text="Médicos Cadastrados" icon="fas fa-lg fa-user-md text-primary" theme="gradient-primary" icon-theme="white" />
<x-adminlte-info-box title="{{$patients_qtd}}" text="Pacientes Cadastrados" icon="fas fa-lg fa-user-injured text-teal" theme="gradient-teal" icon-theme="white" />
<x-adminlte-info-box title="{{$appointments_qtd}}" text="Consultas Agendadas" icon="fas fa-lg fa-calendar-check text-success" theme="gradient-success" icon-theme="white" />
<x-adminlte-info-box title="{{$specialties_qtd}}" text="Especialidades Cadastradas" icon="fas fa-lg fa-stethoscope text-danger" theme="gradient-danger" icon-theme="white" />
<x-adminlte-info-box title="{{$health_plans_qtd}}" text="Planos de Saúde Cadastrados" icon="fas fa-lg fa-file-medical-alt text-warning" theme="gradient-warning" icon-theme="white" />

@stop