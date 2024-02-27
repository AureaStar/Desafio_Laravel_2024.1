@extends('adminlte::page')

@section('content')
    <x-adminlte-profile-widget name="{{$user->name}}" desc="{{$user->user_type}}" theme="lightblue"
        img="{{asset($user->doctor->image)}}"  layout-type="classic">
        <x-adminlte-profile-row-item icon="fas fa-fw fa-calendar-check" title="Consultas"
            text="{{$user->doctor->appointments->count()}}" url="appointments"
            badge="teal"/>
        <x-adminlte-profile-row-item icon="fas fa-fw fa-user" title="Nome" text="{{$user->name}}" url="profile/edit"/>
        <x-adminlte-profile-row-item icon="fas fa-fw fa-at" title="E-mail" text="{{$user->email}}" url="profile/edit"/>
        <x-adminlte-profile-row-item icon="fas fa-fw fa-key" title="Senha" text="********" url="profile/edit"/>
        <x-adminlte-profile-row-item icon="fas fa-fw fa-phone" title="Telefone" text="{{$user->doctor->phone}}"
            url="profile/edit"/>
        <x-adminlte-profile-row-item icon="fas fa-fw fa-map-marker-alt" title="Endereço"
            text="{{$user->doctor->address}}" url="profile/edit" />
        <x-adminlte-profile-row-item icon="fas fa-fw fa-birthday-cake" title="Data de nascimento"
            text="{{$user->doctor->birth_date}}" url="profile/edit" />
        <x-adminlte-profile-row-item icon="fas fa-fw fa-id-card" title="CPF" text="{{$user->doctor->cpf}}"
            url="profile/edit"/>
    </x-adminlte-profile-widget>
@stop