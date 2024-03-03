@php

$heads = [
    'ID',
    'Nome',
    ['label' => 'Desconto (%)', 'width' => 40],
    ['label' => 'Ações', 'no-export' => true, 'width' => 5],
];

@endphp

@extends('adminlte::page')

@section('content')

<div class="box">
    <div class="box-header" style="display: flex; justify-content: space-between; padding: 10px 5px;">
        <h3 class="box-title inline text-md text-xl text-2xl-md" style="width: fit-content;">Gerenciamento de Planos de Saúde</h3>
        <x-adminlte-button label="Adicionar Plano de Saúde" class="btn btn-inline btn-sm btn-md" data-toggle="modal" data-target="#add" theme="success" icon="fas fa-plus" />
    </div>
    <div class="box-body">
        <x-adminlte-datatable id="table1" :heads="$heads">
            <tbody>
                @foreach ($health_plans as $plan)
                <tr>
                    <td>{{ $plan->id }}</td>
                    <td>{{ $plan->name }}</td>
                    <td>{{ $plan->discount }}</td>
                    <td>
                        <nobr>
                            <a href="#" class="btn btn-xs btn-default text-teal mx-1 shadow" title="Visualizar" data-toggle="modal" data-target="#show{{$plan->id}}">
                                <i class="fa fa-lg fa-fw fa-eye"></i>
                            </a>
                            <a href="#" class="btn btn-xs btn-default text-primary mx-1 shadow" title="Editar" data-toggle="modal" data-target="#edit{{$plan->id}}">
                                <i class="fa fa-lg fa-fw fa-pen"></i>
                            </a>
                            <a href="#" class="btn btn-xs btn-default text-danger mx-1 shadow" title="Excluir" data-toggle="modal" data-target="#destroy{{$plan->id}}">
                                <i class="fa fa-lg fa-fw fa-trash"></i>
                            </a>
                        </nobr>
                    </td>
                </tr>

                <!-- Modals -->

                <!-- Delete Modal -->

                <x-adminlte-modal id="destroy{{$plan->id}}" title="Deletar Plano de Saúde" theme="red" icon="fas fa-file-medical" size="lg" static-backdrop>
                    <form action="{{ route('health_plans.destroy', $plan->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <p>Você tem certeza que deseja deletar o Plano de Saúde {{ $plan->name }}?</p>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-danger">Deletar</button>
                        </div>
                    </form>
                    <x-slot name="footerSlot">

                    </x-slot>
                </x-adminlte-modal>

                <!-- View Modal -->

                <x-adminlte-modal id="show{{$plan->id}}" title="Detalhes do Plano de Saúde" theme="teal" icon="fas fa-file-medical" size="lg" static-backdrop>
                    <x-adminlte-input name="name" label="Nome" placeholder="Nome" value="{{ $plan->name }}" disabled />
                    <x-adminlte-input name="discount" label="Desconto (%)" placeholder="Desconto (%)" value="{{ $plan->discount }}" disabled />
                </x-adminlte-modal>

                <!-- Edit Modal -->

                <x-adminlte-modal id="edit{{$plan->id}}" title="Editar Dados do Plano de Saúde" theme="blue" icon="fas fa-file-medical" size="lg" static-backdrop>
                    <form action="{{ route('health_plans.update', $plan->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <x-adminlte-input required name="name" label="Nome" placeholder="Nome" value="{{ $plan->name }}" />
                        <x-adminlte-input required name="description" label="Descrição" placeholder="Descrição" value="{{ $plan->description }}" />
                        <x-adminlte-input required name="discount" label="Desconto (%)" placeholder="Desconto (%)" value="{{ $plan->discount }}" oninput="formatVal(this)" />
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                        </div>
                    </form>
                    <x-slot name="footerSlot">
                    </x-slot>
                </x-adminlte-modal>

                @endforeach

                <!-- Add Modal -->

                <x-adminlte-modal id="add" title="Adicionar Plano de Saúde" theme="success" icon="fas fa-file-medical" size="lg" static-backdrop>
                    <form action="{{ route('health_plans.store') }}" method="POST">
                        @csrf
                        <x-adminlte-input required name="name" label="Nome" placeholder="Nome" />
                        <x-adminlte-input required name="description" label="Descrição" placeholder="Descrição" />
                        <x-adminlte-input required name="discount" label="Desconto (%)" placeholder="Desconto (%)" oninput="formatVal(this)" />
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
            {{ $health_plans->links() }}
        </div>
    </div>
</div>

@endsection

@section('js')
    <script src="{{ asset('js/format_inputs.js') }}"></script>
@stop