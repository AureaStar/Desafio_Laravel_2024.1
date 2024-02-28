@php

$heads = [
    'ID',
    'Nome',
    ['label' => 'Plano de Saúde', 'width' => 40],
    ['label' => 'Ações', 'no-export' => true, 'width' => 5],
];

@endphp

@extends('adminlte::page')

@section('content')

<div class="box">
    <div class="box-header" style="display: flex; justify-content: space-between; padding: 10px 5px;">
        <h3 class="box-title inline text-md text-xl text-2xl-md" style="width: fit-content;">Gerenciamento de Pacientes</h3>
        <x-adminlte-button label="Enviar Email" class="btn btn-inline btn-sm btn-md" data-toggle="modal" data-target="#emailmodal" theme="info" icon="fas fa-envelope" />
        <x-adminlte-button label="Adicionar Paciente" class="btn btn-inline btn-sm btn-md" data-toggle="modal" data-target="#add" theme="success" icon="fas fa-plus" />
    </div>
    <div class="box-body">
        <x-adminlte-datatable id="table1" :heads="$heads">
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td>{{ $user->patient->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->patient->health_plan->name }}</td>
                    <td>
                        <nobr>
                            <a href="#" class="btn btn-xs btn-default text-teal mx-1 shadow" title="Visualizar" data-toggle="modal" data-target="#show{{$user->id}}">
                                <i class="fa fa-lg fa-fw fa-eye"></i>
                            </a>
                            <a href="#" class="btn btn-xs btn-default text-primary mx-1 shadow" title="Editar" data-toggle="modal" data-target="#edit{{$user->id}}">
                                <i class="fa fa-lg fa-fw fa-pen"></i>
                            </a>
                            <a href="#" class="btn btn-xs btn-default text-danger mx-1 shadow" title="Excluir" data-toggle="modal" data-target="#destroy{{$user->id}}">
                                <i class="fa fa-lg fa-fw fa-trash"></i>
                            </a>
                        </nobr>
                    </td>
                </tr>

                <!-- Modais -->

                <!-- Modal de Deletar -->

                <x-adminlte-modal id="destroy{{$user->id}}" title="Deletar Paciente" theme="red" icon="fas fa-user-injured" size="lg" static-backdrop>
                    <form action="{{ route('patients.destroy', $user->patient->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <p>Você tem certeza que deseja deletar o Paciente {{ $user->name }}?</p>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-danger">Deletar</button>
                        </div>
                    </form>
                    <x-slot name="footerSlot">

                    </x-slot>
                </x-adminlte-modal>

                <!-- Modal de Visualizar -->

                <x-adminlte-modal id="show{{$user->id}}" title="Detalhes do Paciente" theme="teal" icon="fas fa-user-injured" size="lg" static-backdrop>
                    <x-adminlte-input name="name" label="Nome" placeholder="Nome" value="{{ $user->name }}" disabled />
                    <x-adminlte-input name="email" label="E-mail" placeholder="E-mail" value="{{ $user->email }}" disabled />
                    <x-adminlte-input name="cpf" label="CPF" placeholder="CPF" value="{{ $user->patient->cpf }}" disabled />
                    <x-adminlte-input tyde="date" name="birth_date" label="Data de Nascimento" placeholder="Data de Nascimento" value="{{ $user->patient->birth_date }}" disabled />
                    <x-adminlte-input name="phone" label="Telefone" placeholder="Telefone" value="{{ $user->patient->phone }}" disabled />
                    <x-adminlte-input name="address" label="Endereço" placeholder="Endereço" value="{{ $user->patient->address }}" disabled />
                    <x-adminlte-input name="health_plan" label="Plano de Saúde" placeholder="Plano de Saúde" value="{{ $user->patient->health_plan->name }}" disabled />
                    <x-adminlte-input name="blood_type" label="Tipo Sanguíneo" placeholder="Tipo Sanguíneo" value="{{ $user->patient->blood_type }}" disabled />
                    <img src="{{ asset($user->patient->image) }}" alt="Imagem do Paciente" width="100px" height="100px">
                </x-adminlte-modal>

                <!-- Modal de Editar -->

                <x-adminlte-modal id="edit{{$user->id}}" title="Editar Dados do Paciente" theme="blue" icon="fas fa-user-injured" size="lg" static-backdrop>
                    <form action="{{ route('patients.update', $user->patient->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <x-adminlte-input name="name" label="Nome" placeholder="Nome" value="{{ $user->name }}" />
                        <x-adminlte-input name="email" label="E-mail" placeholder="E-mail" value="{{ $user->email }}" />
                        <x-adminlte-input type="password" name="password" label="Senha" placeholder="Senha" />
                        <x-adminlte-input name="cpf" label="CPF" placeholder="CPF" value="{{ $user->patient->cpf }}" oninput="formatarCpf(this)"/>
                        <x-adminlte-input name="birth_date" label="Data de Nascimento" placeholder="Data de Nascimento" value="{{ $user->patient->birth_date }}" />
                        <x-adminlte-input name="phone" label="Telefone" placeholder="Telefone" value="{{ $user->patient->phone }}" oninput="formatarTelefone(this)" />
                        <x-adminlte-input name="address" label="Endereço" placeholder="Endereço" value="{{ $user->patient->address }}" />
                        <x-adminlte-select name="health_plan" label="Plano de Saúde" placeholder="Plano de Saúde" value="{{ $user->patient->health_plan_id }}" >
                            <option value="" disabled selected>Selecione</option>
                            @foreach ($health_plans as $health_plan)
                            <option value="{{ $health_plan->id }}">{{ $health_plan->name }}</option>
                            @endforeach
                        </x-adminlte-select>
                        <x-adminlte-select name="blood_type" label="Tipo Sanguíneo" placeholder="Tipo Sanguíneo" value="{{ $user->patient->blood_type }}" >
                            <option value="A+">A+</option>
                            <option value="A-">A-</option>
                            <option value="B+">B+</option>
                            <option value="B-">B-</option>
                            <option value="AB+">AB+</option>
                            <option value="AB-">AB-</option>
                            <option value="O+">O+</option>
                            <option value="O-">O-</option>
                        </x-adminlte-select>
                        <x-adminlte-input type="file" name="image" label="Imagem" placeholder="Imagem" value="{{ $user->patient->image }}" />
                        <x-adminlte-input hidden name="user_type" value="patient"/>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                        </div>
                    </form>
                    <x-slot name="footerSlot">
                    </x-slot>
                </x-adminlte-modal>

                @endforeach

                <!-- Modal de Enviar Email -->

                <x-adminlte-modal id="emailmodal" title="Enviar Email" theme="info" icon="fas fa-envelope" size="lg" static-backdrop>
                    <form action="{{ route('admin.send_email') }}" method="POST">
                        @csrf
                        <x-adminlte-input name="subject" label="Assunto" placeholder="Assunto" />
                        <x-adminlte-textarea name="message" label="Mensagem" placeholder="Mensagem" rows="5" />
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                            <button type="submit" class="btn btn-info">Enviar</button>
                        </div>
                    </form>
                    <x-slot name="footerSlot">
                    </x-slot>
                </x-adminlte-modal>

                <!-- Modal Adicionar -->

                <x-adminlte-modal id="add" title="Adicionar Paciente" theme="success" icon="fas fa-user-injured" size="lg" static-backdrop>
                    <form action="{{ route('patients.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <x-adminlte-input name="name" label="Nome" placeholder="Nome" />
                        <x-adminlte-input type="email" name="email" label="E-mail" placeholder="E-mail" />
                        <x-adminlte-input type="password" name="password" label="Senha" placeholder="Senha" />
                        <x-adminlte-input name="cpf" label="CPF" placeholder="CPF" oninput="formatarCpf(this)"/>
                        <x-adminlte-input type="date" name="birth_date" label="Data de Nascimento" placeholder="Data de Nascimento" />
                        <x-adminlte-input name="phone" label="Telefone" placeholder="Telefone" oninput="formatarTelefone(this)" />
                        <x-adminlte-input name="address" label="Endereço" placeholder="Endereço" />
                        <x-adminlte-select name="health_plan_id" label="Plano de Saúde" placeholder="Plano de Saúde" >
                            <option value="" disabled selected>Selecione</option>
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
                        <x-adminlte-input type="file" name="image" label="Imagem" placeholder="Imagem" accept="image/*" />
                        <x-adminlte-input hidden name="user_type" value="patient"/>
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
            {{ $users->links() }}
        </div>
    </div>
</div>

@endsection

@section('js')
    <script src="{{ asset('js/format_inputs.js') }}"></script>
    </script>
@stop