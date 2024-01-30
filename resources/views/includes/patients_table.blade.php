@php

    $heads = [
        'ID',
        'Nome',
        ['label' => 'Plano de Saúde', 'width' => 40],
        ['label' => 'Ações', 'no-export' => true, 'width' => 5],
    ];

@endphp


@extends('layouts.data_table')

@section('modals')

@foreach ($users as $cell)

<x-adminlte-modal id="show{{$cell->id}}" title="Detalhes do {{$title}}" theme="teal" icon="{{$icon}}" size="lg" static-backdrop>
    <x-adminlte-input name="name" label="Nome" placeholder="Nome" value="{{ $cell->name }}" disabled />
    <x-adminlte-input name="email" label="E-mail" placeholder="E-mail" value="{{ $cell->email }}" disabled />
    <x-adminlte-input name="cpf" label="CPF" placeholder="CPF" value="{{ $cell->$type->cpf }}" disabled />
    <x-adminlte-input name="birth_date" label="Data de Nascimento" placeholder="Data de Nascimento" value="{{ $cell->patient->birth_date }}" disabled />
    <x-adminlte-input name="phone" label="Telefone" placeholder="Telefone" value="{{ $cell->$type->phone }}"  disabled />
    <x-adminlte-input name="address" label="Endereço" placeholder="Endereço" value="{{ $cell->patient->address }}" disabled />
    <x-adminlte-input name="health_plan" label="Plano de Saúde" placeholder="Plano de Saúde" value="{{ $cell->patient->health_plan->name }}" disabled />
    <x-adminlte-input name="blood_type" label="Tipo Sanguíneo" placeholder="Tipo Sanguíneo" value="{{ $cell->patient->blood_type }}" disabled />
    <img src="{{ asset($cell->patient->image) }}" alt="Imagem do {{$title}}" width="100px" height="100px">
    <x-adminlte-input name="user_type" label="Tipo de Usuário" placeholder="Tipo de Usuário" value="{{ $cell->user_type }}" disabled />
</x-adminlte-modal>

<x-adminlte-modal id="edit{{$cell->id}}" title="Editar Dados do {{$title}}" theme="blue" icon="{{$icon}}" size="lg" static-backdrop>
    <form action="{{ route($route . '.update', $cell->$type->id) }}" method="POST">
        @csrf
        @method('PUT')
        <x-adminlte-input name="name" label="Nome" placeholder="Nome" value="{{ $cell->name }}" />
        <x-adminlte-input type="email" name="email" label="E-mail" placeholder="E-mail" value="{{ $cell->email }}" />
        <x-adminlte-input name="cpf" label="CPF" placeholder="CPF" value="{{ $cell->$type->cpf }}" oninput="formatarCpf(this)"/>
        <x-adminlte-input type="date" name="birth_date" label="Data de Nascimento" placeholder="Data de Nascimento" value="{{ $cell->$type->birth_date }}" />
        <x-adminlte-input name="phone" label="Telefone" placeholder="Telefone" value="{{ $cell->$type->phone }}" oninput="formatarTelefone(this)"/>
        <x-adminlte-input name="address" label="Endereço" placeholder="Endereço" value="{{ $cell->$type->address }}" />
        <x-adminlte-input name="health_plan" label="Plano de Saúde" placeholder="Plano de Saúde" value="{{ $cell->$type->health_plan->name }}" />
        <x-adminlte-select name="blood_type" label="Tipo Sanguíneo" placeholder="Tipo Sanguíneo" >
            <option value="A+">A+</option>
            <option value="A-">A-</option>
            <option value="B+">B+</option>
            <option value="B-">B-</option>
            <option value="AB+">AB+</option>
            <option value="AB-">AB-</option>
            <option value="O+">O+</option>
            <option value="O-">O-</option>
        </x-adminlte-select>
        <x-adminlte-input type="file" name="image" label="Imagem" placeholder="Imagem" value="{{ $cell->$type->image }}" />
        <x-adminlte-input name="user_type" label="Tipo de Usuário" placeholder="Tipo de Usuário" value="{{ $cell->user_type }}" />
        <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
        </div>
    </form>
    <x-slot name="footerSlot">
    </x-slot>
</x-adminlte-modal>

@endforeach

@endsection

@section('create_form_inputs')

<x-adminlte-input name="name" label="Nome" placeholder="Nome" value="{{ old('name') }}" />
<x-adminlte-input type="email" name="email" label="E-mail" placeholder="E-mail" value="{{ old('email') }}" />
<x-adminlte-input type="password" name="password" label="Senha" placeholder="Senha" />
<x-adminlte-input name="cpf" label="CPF" placeholder="CPF" value="{{ old('cpf') }}" oninput="formatarCpf(this)"/>
<x-adminlte-input type="date" name="birth_date" label="Data de Nascimento" placeholder="Data de Nascimento" value="{{ old('birth_date') }}" />
<x-adminlte-input name="phone" label="Telefone" placeholder="Telefone" value="{{ old('phone') }}" oninput="formatarTelefone(this)"/>
<x-adminlte-input name="address" label="Endereço" placeholder="Endereço" value="{{ old('address') }}" />
<x-adminlte-select name="health_plan_id" label="Plano de Saúde" placeholder="Plano de Saúde" >
    @foreach ($health_plans as $health_plan)
    <option value="{{ $health_plan->id }}">{{ $health_plan->name }}</option>
    @endforeach
</x-adminlte-select>
<x-adminlte-select name="blood_type" label="Tipo Sanguíneo" placeholder="Tipo Sanguíneo" >
    <option value="A+">A+</option>
    <option value="A-">A-</option>
    <option value="B+">B+</option>
    <option value="B-">B-</option>
    <option value="AB+">AB+</option>
    <option value="AB-">AB-</option>
    <option value="O+">O+</option>
    <option value="O-">O-</option>
</x-adminlte-select>
<x-adminlte-input type="file" name="image" label="Imagem" placeholder="Imagem" value="{{ old('image') }}" />
<x-adminlte-input name="user_type" placeholder="Tipo de Usuário" value="{{ $type }}" hidden/>

@endsection