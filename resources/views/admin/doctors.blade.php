@php

$heads = [
    'ID',
    'Nome',
    ['label' => 'Especialidade', 'width' => 40],
    ['label' => 'Ações', 'no-export' => true, 'width' => 5],
];

@endphp

@extends('adminlte::page')

@section('content')

<div class="box">
    <div class="box-header" style="display: flex; justify-content: space-between; padding: 10px 5px;">
        <h3 class="box-title inline text-md text-xl text-2xl-md" style="width: fit-content;">Gerenciamento de Médicos</h3>
        <x-adminlte-button label="Adicionar Médico" class="btn btn-inline btn-sm btn-md" data-toggle="modal" data-target="#add" theme="success" icon="fas fa-plus" />
    </div>
    <div class="box-body">
        <x-adminlte-datatable id="table1" :heads="$heads">
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td>{{ $user->doctor->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->doctor->specialty->name }}</td>
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

                <x-adminlte-modal id="destroy{{$user->id}}" title="Deletar Médico" theme="red" icon="fas fa-user-md" size="lg" static-backdrop>
                    <form action="{{ route('doctors.destroy', $user->doctor->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <p>Você tem certeza que deseja deletar o Médico {{ $user->name }}?</p>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-danger">Deletar</button>
                        </div>
                    </form>
                    <x-slot name="footerSlot">

                    </x-slot>
                </x-adminlte-modal>

                <!-- Modal de Visualizar -->

                <x-adminlte-modal id="show{{$user->id}}" title="Detalhes do Médico" theme="teal" icon="fas fa-user-md" size="lg" static-backdrop>
                    <x-adminlte-input name="name" label="Nome" placeholder="Nome" value="{{ $user->name }}" disabled />
                    <x-adminlte-input name="email" label="E-mail" placeholder="E-mail" value="{{ $user->email }}" disabled />
                    <x-adminlte-input name="cpf" label="CPF" placeholder="CPF" value="{{ $user->doctor->cpf }}" disabled />
                    <x-adminlte-input tyde="date" name="birth_date" label="Data de Nascimento" placeholder="Data de Nascimento" value="{{ $user->doctor->birth_date }}" disabled />
                    <x-adminlte-input name="phone" label="Telefone" placeholder="Telefone" value="{{ $user->doctor->phone }}" disabled />
                    <x-adminlte-input name="address" label="Endereço" placeholder="Endereço" value="{{ $user->doctor->address }}" disabled />
                    <x-adminlte-input name="crm" label="CRM" placeholder="CRM" value="{{ $user->doctor->crm }}" disabled />
                    <x-adminlte-input name="work_period" label="Período de Trabalho" placeholder="Período de Trabalho" value="{{ $user->doctor->work_period }}" disabled />
                    <x-adminlte-input name="specialty" label="Especialidade" placeholder="Especialidade" value="{{ $user->doctor->specialty->name }}" disabled />
                    <img src="{{ asset($user->doctor->image) }}" alt="Imagem do Médico" width="100px" height="100px">
                </x-adminlte-modal>

                <!-- Modal de Editar -->

                <x-adminlte-modal id="edit{{$user->id}}" title="Editar Dados do Médico" theme="blue" icon="fas fa-user-md" size="lg" static-backdrop>
                    <form action="{{ route('doctors.update', $user->doctor->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <x-adminlte-input name="name" label="Nome" placeholder="Nome" value="{{ $user->name }}" />
                        <x-adminlte-input name="email" label="E-mail" placeholder="E-mail" value="{{ $user->email }}" />
                        <x-adminlte-input name="password" label="Senha" placeholder="Senha" type="password" />
                        <x-adminlte-input name="cpf" label="CPF" placeholder="CPF" value="{{ $user->doctor->cpf }}" oninput="formatarCpf(this)"/>
                        <x-adminlte-input name="birth_date" label="Data de Nascimento" placeholder="Data de Nascimento" value="{{ $user->doctor->birth_date }}" />
                        <x-adminlte-input name="phone" label="Telefone" placeholder="Telefone" value="{{ $user->doctor->phone }}" oninput="formatarTelefone(this)" />
                        <x-adminlte-input name="address" label="Endereço" placeholder="Endereço" value="{{ $user->doctor->address }}" />
                        <x-adminlte-input name="crm" label="CRM" placeholder="CRM" value="{{ $user->doctor->crm }}" />
                        <x-adminlte-select name="work_period" label="Período de Trabalho" placeholder="Período de Trabalho" value="{{ $user->doctor->work_period }}" >
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
                        <x-adminlte-input type="file" name="image" label="Imagem" placeholder="Imagem" value="{{ $user->doctor->image }}" />
                        <x-adminlte-input name="user_type" placeholder="Tipo de Usuário" value="{{ $user->user_type }}" hidden/>
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

                <x-adminlte-modal id="add" title="Adicionar Médico" theme="success" icon="fas fa-user-md" size="lg" static-backdrop>
                    <form action="{{ route('doctors.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <x-adminlte-input name="name" label="Nome" placeholder="Nome" />
                        <x-adminlte-input name="email" label="E-mail" placeholder="E-mail" />
                        <x-adminlte-input name="password" label="Senha" placeholder="Senha" type="password" />
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