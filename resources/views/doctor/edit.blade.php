@extends('adminlte::page')

@section('content_header')
    <h1>Editar Perfil</h1>
@stop

@section('content')
    <form class="form-horizontal" action="{{ route('doctor.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <div class="row">
            <div class="col-md-6">
                <!-- Campos da primeira coluna -->
                <x-adminlte-input name="name" label="Nome" placeholder="Nome" value="{{ $user->name }}" />
                <x-adminlte-input name="email" label="E-mail" placeholder="E-mail" type="email" value="{{ $user->email }}" />
                <x-adminlte-input name="password" label="Senha" placeholder="Senha" type="password" />
                <x-adminlte-input name="password_confirmation" label="Confirmar Senha" placeholder="Confirmar Senha" type="password" />
                <x-adminlte-input name="cpf" label="CPF" placeholder="CPF" value="{{ $user->doctor->cpf }}" oninput="formatarCpf(this)" />
                <x-adminlte-input name="birth_date" label="Data de Nascimento" placeholder="Data de Nascimento" type="date" value="{{ $user->doctor->birth_date }}" />
            </div>
            <div class="col-md-6">
                <!-- Campos da segunda coluna -->
                <x-adminlte-input name="phone" label="Telefone" placeholder="(XX) XXXXX-XXXX" value="{{ $user->doctor->phone }}" oninput="formatarTelefone(this)" />
                <x-adminlte-input name="address" label="Endereço" placeholder="Endereço" value="{{ $user->doctor->address }}" />
                <x-adminlte-input name="image" label="Imagem" placeholder="Imagem" type="file" value="{{ $user->doctor->image }}" />
            </div>
        </div>
        <div class="mt-3">
            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
        </div>
    </form>
@stop

@section('js')
    <script src="{{ asset('js/format_inputs.js') }}"></script>
@stop
