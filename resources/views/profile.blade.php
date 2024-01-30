@extends('adminlte::page')

@section('content')
    <x-adminlte-profile-widget name="{{$user->name}}" desc="{{$user->user_type}}" theme="lightblue"
        img="{{Auth::user()->user_type !== 'admin' ? asset(Auth::user()->$type->image) : asset('assets/admin.png')}}"  layout-type="classic">
        @if (Auth::user()->user_type === 'admin')
            <x-adminlte-profile-row-item icon="fas fa-fw fa-user-md" title="Médicos" text="{{$doctors_qtd}}"
                url="admin/doctors" badge="teal"/>
            <x-adminlte-profile-row-item icon="fas fa-fw fa-user-injured fa-flip-horizontal" title="Pacientes"
                text="{{$patients_qtd}}" url="admin/patients" badge="lightblue"/>
        @elseif (Auth::user()->user_type === 'doctor')
            <x-adminlte-profile-row-item icon="fas fa-fw fa-calendar-check" title="Consultas"
                text="{{Auth::user()->doctor->appointments->count()}}" url="doctors/{{Auth::user()->doctor->id}}/appointments"
                badge="teal"/>
        @elseif (Auth::user()->user_type === 'patient')
            <x-adminlte-profile-row-item icon="fas fa-fw fa-calendar-check" title="Consultas"
                text="{{Auth::user()->patient->appointments->count()}}" url="admin/patients/{{Auth::user()->patient->id}}/appointments"
                badge="teal"/>
            <x-adminlte-profile-row-item icon="fas fa-fw fa-user-md" title="Médicos"
                text="{{Auth::user()->patient->doctors->count()}}" url="admin/patients/{{Auth::user()->patient->id}}/doctors"
                badge="lightblue"/>
        @endif
        @if (Auth::user()->user_type !== 'admin')
        <x-adminlte-profile-row-item icon="fas fa-fw fa-user" title="Nome" text="{{$user->name}}" url="profile/edit"/>
        <x-adminlte-profile-row-item icon="fas fa-fw fa-at" title="E-mail" text="{{$user->email}}" url="profile/edit"/>
        <x-adminlte-profile-row-item icon="fas fa-fw fa-key" title="Senha" text="********" url="profile/edit"/>
        <x-adminlte-profile-row-item icon="fas fa-fw fa-phone" title="Telefone" text="{{$user->$type->phone}}"
            url="profile/edit"/>
        <x-adminlte-profile-row-item icon="fas fa-fw fa-map-marker-alt" title="Endereço"
            text="{{$user->$type->address}}" url="profile/edit" />
        <x-adminlte-profile-row-item icon="fas fa-fw fa-birthday-cake" title="Data de nascimento"
            text="{{$user->$type->birth_date}}" url="profile/edit" />
        <x-adminlte-profile-row-item icon="fas fa-fw fa-id-card" title="CPF" text="{{$user->$type->cpf}}"
            url="profile/edit"/>
        @if (Auth::user()->user_type === 'patient')
            <x-adminlte-profile-row-item icon="fas fa-fw fa-hospital" title="Plano de Saúde"
                text="{{$user->$type->health_plan->name}}" url="profile/edit"/>
            <x-adminlte-profile-row-item icon="fas fa-fw fa-tint" title="Tipo Sanguíneo" text="{{$user->$type->blood_type}}"
                url="profile/edit"/>
        @endif
        @endif

    </x-adminlte-profile-widget>
@stop