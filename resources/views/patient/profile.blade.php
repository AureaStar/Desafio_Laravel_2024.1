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
    <x-adminlte-button label="Deletar Conta" theme="danger" icon="fas fa-trash" class="mt-2" data-toggle="modal"
        data-target="#modal-danger" />
    <x-adminlte-modal id="modal-danger" title="Deletar Conta" theme="danger" icon="fas fa-trash" static-backdrop
        btn-dismiss="Cancelar">
        Tem certeza que deseja deletar sua conta? Esta ação é irreversível.
        <x-slot name="footerSlot">
            <x-adminlte-button theme="danger" label="Deletar" icon="fas fa-trash" class="float-right"
                onclick="event.preventDefault();document.getElementById('delete-form').submit();" />
            <form id="delete-form" action="{{route('patient.destroy')}}" method="POST"
                style="display: none;">
                @csrf
                @method('DELETE')
            </form>
        </x-slot>
    </x-adminlte-modal>
@stop