@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <x-adminlte-info-box title="{{$doctors_qtd}}" text="Médicos Cadastrados" icon="fas fa-lg fa-user-md text-primary"
        theme="gradient-primary" icon-theme="white"/>
    <x-adminlte-info-box title="{{$patients_qtd}}" text="Pacientes Cadastrados" icon="fas fa-lg fa-user-injured text-teal"
        theme="gradient-teal" icon-theme="white"/>
@stop