@php 

$heads = [
    'ID',
    'Nome',
    ['label' => 'Valor', 'width' => 40],
    ['label' => 'Ações', 'no-export' => true, 'width' => 5],
];

@endphp

@extends('layouts.data_table')

@section('modals')

@foreach ($data as $cell)

<x-adminlte-modal id="show{{$cell->id}}" title="Detalhes do {{$title}}" theme="teal" icon="{{$icon}}" size="lg" static-backdrop>
    <x-adminlte-input name="name" label="Nome" placeholder="Nome" value="{{ $cell->name }}" disabled />
    <x-adminlte-input name="description" label="Descrição" placeholder="Descrição" value="{{ $cell->description }}" disabled />
    <x-adminlte-input name="value" label="Valor" placeholder="Valor" value="{{ $cell->value }}" disabled />
</x-adminlte-modal>

<x-adminlte-modal id="edit{{$cell->id}}" title="Editar Dados do {{$title}}" theme="blue" icon="{{$icon}}" size="lg" static-backdrop>
    <form action="{{ route($route . '.update', $cell->id) }}" method="POST">
        @csrf
        @method('PUT')
        <x-adminlte-input name="name" label="Nome" placeholder="Nome" value="{{ $cell->name }}" />
        <x-adminlte-input name="description" label="Descrição" placeholder="Descrição" value="{{ $cell->description }}" />
        <x-adminlte-input name="value" label="Valor" placeholder="Valor" value="{{ $cell->value }}" />
        <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
        </div>
    </form>
    <x-slot name="footerSlot">
        <x-adminlte-button theme="danger" label="Excluir" data-toggle="modal" data-target="#destroy{{$cell->id}}" />
    </x-slot>
</x-adminlte-modal>

@endforeach

@endsection

@section('create_form_inputs')

<x-adminlte-input name="name" label="Nome" placeholder="Nome" />
<x-adminlte-input name="description" label="Descrição" placeholder="Descrição" />
<x-adminlte-input name="value" label="Valor" placeholder="Valor" />

@endsection