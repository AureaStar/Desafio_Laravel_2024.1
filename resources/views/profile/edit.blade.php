@extends('adminlte::page')

@section('content_header')
    <h1>Editar Perfil</h1>
@stop

@section('content')
    <form class="form-horizontal" action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <div class="row">
            <div class="col-md-6">
                <!-- Campos da primeira coluna -->
                <x-adminlte-input name="name" label="Nome" placeholder="Nome" value="{{ Auth::user()->name }}" />
                <x-adminlte-input name="email" label="E-mail" placeholder="E-mail" type="email" value="{{ Auth::user()->email }}" />
                <x-adminlte-input name="password" label="Senha" placeholder="Senha" type="password" />
                <x-adminlte-input name="password_confirmation" label="Confirmar Senha" placeholder="Confirmar Senha" type="password" />
                <x-adminlte-input name="cpf" label="CPF" placeholder="CPF" value="{{ Auth::user()->patient->cpf }}" oninput="formatarCpf(this)" />
                <x-adminlte-input name="birth_date" label="Data de Nascimento" placeholder="Data de Nascimento" type="date" value="{{ Auth::user()->patient->birth_date }}" />
            </div>
            <div class="col-md-6">
                <!-- Campos da segunda coluna -->
                <x-adminlte-input name="phone" label="Telefone" placeholder="(XX) XXXXX-XXXX" value="{{ Auth::user()->patient->phone }}" oninput="formatarTelefone(this)" />
                <x-adminlte-input name="address" label="Endereço" placeholder="Endereço" value="{{ Auth::user()->patient->address }}" />
                <x-adminlte-input name="image" label="Imagem" placeholder="Imagem" type="file" value="{{ Auth::user()->patient->image }}" />
                <x-adminlte-select name="health_plan_id" label="Plano de Saúde" placeholder="Plano de Saúde" value="{{ Auth::user()->patient->health_plan !== null ?  Auth::user()->patient->health_plan->id : '' }}" class="select2">
                    @foreach ($health_plans as $health_plan)
                        <option value="{{ $health_plan->id }}"  {{ Auth::user()->patient->health_plan->id == $health_plan->id ? 'selected' : '' }} >{{ $health_plan->name }}</option>
                    @endforeach
                </x-adminlte-select>
                <x-adminlte-select name="blood_type" label="Tipo Sanguíneo" placeholder="Tipo Sanguíneo" value="{{ Auth::user()->patient->blood_type !== null ? Auth::user()->patient->blood_type : '' }}" class="select2">
                    <option value="A+" {{ Auth::user()->patient->blood_type == 'A+' ? 'selected' : '' }}>A+</option>
                    <option value="A-" {{ Auth::user()->patient->blood_type == 'A-' ? 'selected' : '' }}>A-</option>
                    <option value="B+" {{ Auth::user()->patient->blood_type == 'B+' ? 'selected' : '' }}>B+</option>
                    <option value="B-" {{ Auth::user()->patient->blood_type == 'B-' ? 'selected' : '' }}>B-</option>
                    <option value="AB+" {{ Auth::user()->patient->blood_type == 'AB+' ? 'selected' : '' }}>AB+</option>
                    <option value="AB-" {{ Auth::user()->patient->blood_type == 'AB-' ? 'selected' : '' }}>AB-</option>
                    <option value="O+" {{ Auth::user()->patient->blood_type == 'O+' ? 'selected' : '' }}>O+</option>
                    <option value="O-" {{ Auth::user()->patient->blood_type == 'O-' ? 'selected' : '' }}>O-</option>
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
