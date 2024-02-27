@php

$heads = [
    'ID',
    'Nome',
    ['label' => 'Valor (R$)', 'width' => 40],
    ['label' => 'Ações', 'no-export' => true, 'width' => 5],
];

@endphp

@extends('adminlte::page')

@section('content')

<div class="box">
    <div class="box-header" style="display: flex; justify-content: space-between; padding: 10px 5px;">
        <h3 class="box-title inline text-md text-xl text-2xl-md" style="width: fit-content;">Gerenciamento de Especialidades</h3>
        <x-adminlte-button label="Adicionar Especialidade" class="btn btn-inline btn-sm btn-md" data-toggle="modal" data-target="#add" theme="success" icon="fas fa-plus" />
    </div>
    <div class="box-body">
        <x-adminlte-datatable id="table1" :heads="$heads">
            <tbody>
                @foreach ($specialties as $specialty)
                <tr>
                    <td>{{ $specialty->id }}</td>
                    <td>{{ $specialty->name }}</td>
                    <td>{{ $specialty->value }}</td>
                    <td>
                        <nobr>
                            <a href="#" class="btn btn-xs btn-default text-teal mx-1 shadow" title="Visualizar" data-toggle="modal" data-target="#show{{$specialty->id}}">
                                <i class="fa fa-lg fa-fw fa-eye"></i>
                            </a>
                            <a href="#" class="btn btn-xs btn-default text-primary mx-1 shadow" title="Editar" data-toggle="modal" data-target="#edit{{$specialty->id}}">
                                <i class="fa fa-lg fa-fw fa-pen"></i>
                            </a>
                            <a href="#" class="btn btn-xs btn-default text-danger mx-1 shadow" title="Excluir" data-toggle="modal" data-target="#destroy{{$specialty->id}}">
                                <i class="fa fa-lg fa-fw fa-trash"></i>
                            </a>
                        </nobr>
                    </td>
                </tr>

                <!-- Modais -->

                <!-- Modal de Deletar -->

                <x-adminlte-modal id="destroy{{$specialty->id}}" title="Deletar Especialidade" theme="red" icon="fas fa-stethoscope" size="lg" static-backdrop>
                    <form action="{{ route('specialties.destroy', $specialty->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <p>Você tem certeza que deseja deletar a Especialidade {{ $specialty->name }}?</p>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-danger">Deletar</button>
                        </div>
                    </form>
                    <x-slot name="footerSlot">

                    </x-slot>
                </x-adminlte-modal>

                <!-- Modal de Visualizar -->

                <x-adminlte-modal id="show{{$specialty->id}}" title="Detalhes da Especialidade" theme="teal" icon="fas fa-stethoscope" size="lg" static-backdrop>
                    <x-adminlte-input name="name" label="Nome" placeholder="Nome" value="{{ $specialty->name }}" disabled />
                    <x-adminlte-input name="description" label="Descrição" placeholder="Descrição" value="{{ $specialty->description }}" disabled />
                    <x-adminlte-input name="value" label="Valor (R$)" placeholder="Valor (R$)" value="{{ $specialty->value }}" disabled />
                </x-adminlte-modal>

                <!-- Modal de Editar -->

                <x-adminlte-modal id="edit{{$specialty->id}}" title="Editar Dados da Especialidade" theme="blue" icon="fas fa-stethoscope" size="lg" static-backdrop>
                    <form action="{{ route('specialties.update', $specialty->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <x-adminlte-input name="name" label="Nome" placeholder="Nome" value="{{ $specialty->name }}" />
                        <x-adminlte-input name="description" label="Descrição" placeholder="Descrição" value="{{ $specialty->description }}" />
                        <x-adminlte-input name="value" label="Valor (R$)" placeholder="Valor (R$)" value="{{ $specialty->value }}" oninput="formatCurrency(this)"/>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                        </div>
                    </form>
                    <x-slot name="footerSlot">
                    </x-slot>
                </x-adminlte-modal>

                @endforeach

                <!-- Modal Adicionar -->

                <x-adminlte-modal id="add" title="Adicionar Especialidade" theme="success" icon="fas fa-stethoscope" size="lg" static-backdrop>
                    <form action="{{ route('specialties.store') }}" method="POST">
                        @csrf
                        <x-adminlte-input name="name" label="Nome" placeholder="Nome" />
                        <x-adminlte-input name="description" label="Descrição" placeholder="Descrição" />
                        <x-adminlte-input name="value" label="Valor (R$)" placeholder="Valor (R$)" oninput="formatCurrency(this)" />
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-success">Adicionar</button>
                        </div>
                    </form>
                    <x-slot name="footerSlot">
                    </x-slot>
                </x-adminlte-modal>

            </tbody>
        </x-adminlte-datatable>
        @component('components.alerts')
            
        @endcomponent
        <div class="pagination">
            {{ $specialties->links() }}
        </div>
    </div>
</div>

@endsection

    <script>
        function formatCurrency(input) {

            let value = input.value.replace(/\D/g, '');

            value = (parseFloat(value) / 100).toFixed(2) + '';

            input.value = value;

        }
    </script>