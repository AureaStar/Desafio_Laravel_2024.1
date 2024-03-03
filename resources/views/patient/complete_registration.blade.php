@extends('adminlte::page')

@section('content_header')
    <h1>Completar Cadastro</h1>
@stop

@section('content')
    <form class="form-horizontal" action="{{ route('patient.completed') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <div class="row">
            <div class="col-md-6">
                <!-- Campos da primeira coluna -->
                <x-adminlte-input required name="name" label="Nome" placeholder="Nome" value="{{ $user->name }}"/>
                <x-adminlte-input required name="email" label="E-mail" placeholder="E-mail" type="email" value="{{ $user->email }}" />
                <x-adminlte-input required name="password" label="Senha" placeholder="Senha" type="password" />
                <x-adminlte-input required name="password_confirmation" label="Confirmar Senha" placeholder="Confirmar Senha" type="password" />
                <x-adminlte-input required name="cpf" label="CPF" placeholder="CPF" value="" oninput="formatarCpf(this)" />
                <x-adminlte-input required name="birth_date" label="Data de Nascimento" placeholder="Data de Nascimento" type="date" value="{{ $user->patient->birth_date }}" />
            </div>
            <div class="col-md-6">
                <!-- Campos da segunda coluna -->
                <x-adminlte-input required name="phone" label="Telefone" placeholder="(XX) XXXXX-XXXX" value="" oninput="formatarTelefone(this)" />
                <x-adminlte-input required name="address" label="Endereço" placeholder="Endereço" value="" />
                <x-adminlte-input name="image" label="Imagem" placeholder="Imagem" type="file" value="{{ $user->patient->image }}" />
                <x-adminlte-select required name="health_plan_id" label="Plano de Saúde" placeholder="Plano de Saúde" class="select2">
                    <option value="" disabled selected>Selecione</option>
                    @foreach ($health_plans as $health_plan)
                        <option value="{{ $health_plan->id }}">{{ $health_plan->name }}</option>
                    @endforeach
                </x-adminlte-select>
                <x-adminlte-select required name="blood_type" label="Tipo Sanguíneo" placeholder="Tipo Sanguíneo" class="select2">
                    <option value="" disabled selected>Selecione</option>
                    <option value="A+" >A+</option>
                    <option value="A-" >A-</option>
                    <option value="B+" >B+</option>
                    <option value="B-" >B-</option>
                    <option value="AB+" >AB+</option>
                    <option value="AB-" >AB-</option>
                    <option value="O+" >O+</option>
                    <option value="O-" >O-</option>
                </x-adminlte-select>
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
