@php

$heads = [
    ['label' => 'Tipo', 'width' => 20],
    ['label' => 'Data', 'width' => 30],
    ['label' => 'Valor', 'width' => 20],
    ['label' => 'Médico', 'width' => 40],
    ['label' => 'Ações', 'no-export' => true, 'width' => 10],
];

@endphp

@extends('adminlte::page')

@section('content')

<div class="box">
    <div class="box-header" style="display: flex; justify-content: space-between; padding: 10px 5px;">
        <h3 class="box-title inline text-md text-xl text-2xl-md" style="width: fit-content;">Meus Agendamentos</h3>
        <x-adminlte-button label="Novo Agendamento" class="btn btn-inline btn-sm btn-md" data-toggle="modal" data-target="#add" theme="success" icon="fas fa-plus" />
    </div>
    <div class="box-body">
        <x-adminlte-datatable id="table1" :heads="$heads">
            <tbody>
                @foreach ($appointments as $appointment)
                <tr>
                    <td>{{ $appointment->specialty->name }}</td>
                    <td>{{ $appointment->procedure_start }}</td>
                    <td>{{ $appointment->price }}</td>
                    <td>{{ $appointment->doctor->user->name }}</td>
                    <td>
                        <nobr>
                            <a href="#" class="btn btn-xs btn-default text-teal mx-1 shadow" title="Visualizar" data-toggle="modal" data-target="#show{{$appointment->id}}">
                                <i class="fa fa-lg fa-fw fa-eye"></i>
                            <a href="#" class="btn btn-xs btn-default text-danger mx-1 shadow" title="Cancelar" data-toggle="modal" data-target="#destroy{{$appointment->id}}">
                                <i class="fa fa-lg fa-fw fa-trash"></i>
                            </a>
                        </nobr>
                    </td>
                </tr>

                <!-- Modais -->

                <!-- Modal de Deletar -->

                <x-adminlte-modal id="destroy{{$appointment->id}}" title="Cancelar Agendamento" theme="red" icon="fas fa-stethoscope" size="lg" static-backdrop>
                    <form action="{{ route('patients.appointments.destroy', $appointment->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <p>Você tem certeza que deseja cancelar o Agendamento de {{ $appointment->specialty->name }}?</p>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                            <button type="submit" class="btn btn-danger">Cancelar</button>
                        </div>
                    </form>
                    <x-slot name="footerSlot">

                    </x-slot>
                </x-adminlte-modal>

                <!-- Modal de Visualizar -->

                <x-adminlte-modal id="show{{$appointment->id}}" title="Detalhes do Agendamento" theme="teal" icon="fas fa-stethoscope" size="lg" static-backdrop>
                    <x-adminlte-input name="specialty" label="Especialidade" placeholder="Especialidade" value="{{ $appointment->specialty->name }}" disabled />
                    <x-adminlte-input name="date" label="Data" placeholder="Data" value="{{ $appointment->procedure_start }}" disabled />
                    <x-adminlte-input name="hour" label="Hora" placeholder="Hora" value="{{ $appointment->procedure_end }}" disabled />
                    <x-adminlte-input name="doctor" label="Médico" placeholder="Médico" value="{{ $appointment->doctor->user->name }}" disabled />
                    <x-adminlte-input name="value" label="Valor (R$)" placeholder="Valor (R$)" value="{{ $appointment->price }}" disabled />
                    <x-adminlte-input name="status" label="Status" placeholder="Status" value="{{ $appointment->status }}" disabled />
                </x-adminlte-modal>

                @endforeach

                <!-- Modal de Adicionar -->

                <x-adminlte-modal id="add" title="Novo Agendamento" theme="teal" icon="fas fa-stethoscope" size="lg" static-backdrop>
                    <form action="{{ route('patients.appointments.create') }}" method="POST">
                        @csrf
                        <x-adminlte-select2 required name="specialty_id" label="Especialidade" fgroup-class="col-md-12" data-placeholder="Selecione uma especialidade">
                            <option value="" disabled selected>Selecione</option>
                            @foreach ($specialties as $specialty)
                            <option value="{{ $specialty->id }}">{{ $specialty->name }}</option>
                            @endforeach
                        </x-adminlte-select2>
                        <x-adminlte-input 
                            required
                            name="date" 
                            label="Data" 
                            type="date" 
                            fgroup-class="col-md-12" 
                            placeholder="Data" 
                        />
                        <x-adminlte-select2 required name="time" label="Horário">
                            <option value="" disabled selected>Selecione</option>
                            <option value="00:00">00:00</option>
                            <option value="02:00">02:00</option>
                            <option value="04:00">04:00</option>
                            <option value="06:00">06:00</option>
                            <option value="08:00">08:00</option>
                            <option value="10:00">10:00</option>
                            <option value="12:00">12:00</option>
                            <option value="14:00">14:00</option>
                            <option value="16:00">16:00</option>
                            <option value="18:00">18:00</option>
                            <option value="20:00">20:00</option>
                            <option value="22:00">22:00</option>
                        </x-adminlte-select2>


                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-success">Agendar</button>
                        </div>
                    </form>
                    <x-slot name="footerSlot">

                    </x-slot>
                </x-adminlte-modal>

            </tbody>
        </x-adminlte-datatable>
    </div>
    @component('components.alerts')
        
    @endcomponent
</div>

@endsection