@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')

    @if(Auth::user()->user_type === 'patient' && Auth::user()->patient->registration_status === 'incomplete')
        <div class="alert alert-warning">
            <h5><i class="icon fas fa-exclamation-triangle"></i> Atenção!</h5>
            <p>Seu cadastro está incompleto. Por favor, <a href="{{ route('profile.edit') }}">clique aqui</a> para completar seu cadastro.</p>
        </div>
    @endif
@stop