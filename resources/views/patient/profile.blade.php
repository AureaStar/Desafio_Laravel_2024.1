@extends('adminlte::page')

@section('content')
    <x-adminlte-profile-widget name="{{$user->name}}" desc="{{$user->user_type}}" theme="lightblue"
        img="{{asset($user->patient->image)}}"  layout-type="classic">
        <x-adminlte-profile-row-item icon="fas fa-fw fa-calendar-check" title="Consultas"
            text="{{$user->patient->appointments->count()}}" url="{{route('patients.appointments')}}"
            badge="teal"/>
        <x-adminlte-profile-row-item icon="fas fa-fw fa-user" title="Nome" text="{{$user->name}}" url="profile/edit"/>
        <x-adminlte-profile-row-item icon="fas fa-fw fa-at" title="E-mail" text="{{$user->email}}" url="profile/edit"/>
        <x-adminlte-profile-row-item icon="fas fa-fw fa-key" title="Senha" text="********" url="profile/edit"/>
        <x-adminlte-profile-row-item icon="fas fa-fw fa-phone" title="Telefone" text="{{$user->patient->phone}}"
            url="profile/edit"/>
        <x-adminlte-profile-row-item icon="fas fa-fw fa-map-marker-alt" title="Endereço"
            text="{{$user->patient->address}}" url="profile/edit" />
        <x-adminlte-profile-row-item icon="fas fa-fw fa-birthday-cake" title="Data de nascimento"
            text="{{$user->patient->birth_date}}" url="profile/edit" />
        <x-adminlte-profile-row-item icon="fas fa-fw fa-id-card" title="CPF" text="{{$user->patient->cpf}}"
            url="profile/edit"/>
        <x-adminlte-profile-row-item icon="fas fa-fw fa-hospital" title="Plano de Saúde"
            text="{{$user->patient->health_plan->name}}" url="profile/edit"/>
        <x-adminlte-profile-row-item icon="fas fa-fw fa-tint" title="Tipo Sanguíneo" text="{{$user->patient->blood_type}}"
            url="profile/edit"/>
    </x-adminlte-profile-widget>
@stop