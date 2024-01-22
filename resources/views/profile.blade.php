@extends('adminlte::page')

@section('content')
<x-adminlte-profile-widget name="{{$user->name}}" desc="{{$user->user_type}}" theme="lightblue"
    img="https://picsum.photos/id/1/100" layout-type="classic">
    <x-adminlte-profile-row-item icon="fas fa-fw fa-user-md" title="Médicos" text="{{$doctors_qtd}}"
        url="admin/doctors" badge="teal"/>
    <x-adminlte-profile-row-item icon="fas fa-fw fa-user-injured fa-flip-horizontal" title="Pacientes"
        text="{{$patients_qtd}}" url="admin/patients" badge="lightblue"/>
</x-adminlte-profile-widget>
@stop