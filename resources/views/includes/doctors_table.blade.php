@php

$heads = [
'ID',
'Nome',
['label' => 'Especialidade', 'width' => 40],
['label' => 'Ações', 'no-export' => true, 'width' => 5],
];

@endphp

@extends('layouts.data_table')

@section('modals')

@foreach ($users as $cell)

<x-adminlte-modal id="show{{$cell->id}}" title="Detalhes do {{$title}}" theme="teal" icon="{{$icon}}" size="lg" static-backdrop>
    <x-adminlte-input name="name" label="Nome" placeholder="Nome" value="{{ $cell->name }}" disabled />
    <x-adminlte-input name="email" label="E-mail" placeholder="E-mail" value="{{ $cell->email }}" disabled />
    <x-adminlte-input name="cpf" label="CPF" placeholder="CPF" value="{{ $cell->doctor->cpf }}" disabled />
    <x-adminlte-input tyde="date" name="birth_date" label="Data de Nascimento" placeholder="Data de Nascimento" value="{{ $cell->doctor->birth_date }}" disabled />
    <x-adminlte-input name="phone" label="Telefone" placeholder="Telefone" value="{{ $cell->doctor->phone }}" disabled />
    <x-adminlte-input name="address" label="Endereço" placeholder="Endereço" value="{{ $cell->doctor->address }}" disabled />
    <x-adminlte-input name="crm" label="CRM" placeholder="CRM" value="{{ $cell->doctor->crm }}" disabled />
    <x-adminlte-input name="work_period" label="Período de Trabalho" placeholder="Período de Trabalho" value="{{ $cell->doctor->work_period }}" disabled />
    <x-adminlte-input name="specialty" label="Especialidade" placeholder="Especialidade" value="{{ $cell->doctor->specialty->name }}" disabled />
    <x-adminlte-input type="image" name="image" label="Imagem" placeholder="Imagem" value="{{ $cell->doctor->image }}" disabled />
    <x-adminlte-input name="user_type" label="Tipo de Usuário" placeholder="Tipo de Usuário" value="{{ $cell->user_type }}" disabled />
</x-adminlte-modal>

<x-adminlte-modal id="edit{{$cell->id}}" title="Editar Dados do {{$title}}" theme="blue" icon="{{$icon}}" size="lg" static-backdrop>
    <form action="{{ route('doctors.update', $cell->doctor->id) }}" method="POST">
        @csrf
        @method('PUT')
        <x-adminlte-input name="name" label="Nome" placeholder="Nome" value="{{ $cell->name }}" />
        <x-adminlte-input name="email" label="E-mail" placeholder="E-mail" value="{{ $cell->email }}" />
        <x-adminlte-input name="cpf" label="CPF" placeholder="CPF" value="{{ $cell->doctor->cpf }}" oninput="formatarCpf(this)"/>
        <x-adminlte-input name="birth_date" label="Data de Nascimento" placeholder="Data de Nascimento" value="{{ $cell->doctor->birth_date }}" />
        <x-adminlte-input name="phone" label="Telefone" placeholder="Telefone" value="{{ $cell->doctor->phone }}" oninput="formatarTelefone(this)" />
        <x-adminlte-input name="address" label="Endereço" placeholder="Endereço" value="{{ $cell->doctor->address }}" />
        <x-adminlte-input name="crm" label="CRM" placeholder="CRM" value="{{ $cell->doctor->crm }}" />
        <x-adminlte-select name="work_period" label="Período de Trabalho" placeholder="Período de Trabalho" value="{{ $cell->doctor->work_period }}" >
            <option value="morning">Manhã</option>
            <option value="afternoon">Tarde</option>
            <option value="night">Noite</option>
            <option value="dawn">Madrugada</option>
        </x-adminlte-select>
        <x-adminlte-select name="specialty" label="Especialidade" placeholder="Especialidade" >
            @foreach ($specialties as $specialty)
            <option value="{{ $specialty->id }}">{{ $specialty->name }}</option>
            @endforeach
        </x-adminlte-select>
        <x-adminlte-input name="image" label="Imagem" placeholder="Imagem" value="{{ $cell->doctor->image }}" />
        <x-adminlte-input name="user_type" placeholder="Tipo de Usuário" value="{{ $cell->user_type }}" hidden/>
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

<x-adminlte-input name="name" label="Nome" placeholder="Nome" />
<x-adminlte-input name="email" label="E-mail" placeholder="E-mail" />
<x-adminlte-input name="cpf" label="CPF" placeholder="CPF" oninput="formatarCpf(this)"/>
<x-adminlte-input type="date" name="birth_date" label="Data de Nascimento" placeholder="Data de Nascimento" />
<x-adminlte-input name="phone" label="Telefone" placeholder="Telefone" oninput="formatarTelefone(this)" />
<x-adminlte-input name="address" label="Endereço" placeholder="Endereço" />
<x-adminlte-input name="crm" label="CRM" placeholder="CRM" />
<x-adminlte-select name="work_period" label="Período de Trabalho" placeholder="Período de Trabalho" >
    <option value="morning">Manhã</option>
    <option value="afternoon">Tarde</option>
    <option value="night">Noite</option>
    <option value="dawn">Madrugada</option>
</x-adminlte-select>
<x-adminlte-select name="specialty" label="Especialidade" placeholder="Especialidade" >
    @foreach ($specialties as $specialty)
    <option value="{{ $specialty->id }}">{{ $specialty->name }}</option>
    @endforeach
</x-adminlte-select>
<x-adminlte-input type="file" name="image" label="Imagem" placeholder="Insira uma imagem" accept="image/*" />
<x-adminlte-input hidden name="user_type" value="doctor"/>
<div class="modal-footer justify-content-between">
    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
    <button type="submit" class="btn btn-success">Adicionar</button>
</div>

@endsection