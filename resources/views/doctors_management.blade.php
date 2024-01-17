@extends('adminlte::page')

@section('content')
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Minha Tabela</h3>
        </div>
        <div class="box-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <!-- Adicione mais colunas conforme necessário -->
                    </tr>
                </thead>
                <tbody>
                    @foreach ($doctors as $doctor)
                        <tr>
                            <td>{{ $doctor->id }}</td>
                            <td>{{ $doctor->name }}</td>
                            <!-- Adicione mais colunas conforme necessário -->
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
