@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')

    @if($user->user_type === 'patient' && $user->patient->registration_status === 'incomplete')
        <div class="alert alert-warning">
            <h5><i class="icon fas fa-exclamation-triangle"></i> Atenção!</h5>
            <p>Seu cadastro está incompleto. Por favor, <a href="{{ route('patient.complete') }}">clique aqui</a> para completar seu cadastro.</p>
        </div>
    @endif
    @component('components.alerts')
        
    @endcomponent
@stop