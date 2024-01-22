<div class="box">
    <div class="box-header" style="display: flex; justify-content: space-between; padding: 10px 5px;">
        <h3 class="box-title inline" style="width: fit-content;">Gerenciamento de {{$title}}</h3>
        <x-adminlte-button label="Adicionar {{$title}}" class="btn btn-inline" data-toggle="modal" data-target="#add" theme="success" icon="fas fa-plus" />
    </div>
    <div class="box-body">
        <x-adminlte-datatable id="table1" :heads="$heads">
            <tbody>
                @foreach ($data as $cell)
                <tr>
                    @if($table === 'users')
                        <td>{{ $cell->$type->id }}</td>
                        <td>{{ $cell->name }}</td>
                        <td>{{ $cell->$type->$extra_info->name }}</td>
                    @else
                        <td>{{ $cell->id }}</td>
                        <td>{{ $cell->name }}</td>
                        <td>{{ $cell->$extra_info }}</td>
                    @endif
                    <td>
                        <nobr>
                            <a href="#" class="btn btn-xs btn-default text-teal mx-1 shadow" title="Visualizar" data-toggle="modal" data-target="#show{{$cell->id}}">
                                <i class="fa fa-lg fa-fw fa-eye"></i>
                            </a>
                            <a href="#" class="btn btn-xs btn-default text-primary mx-1 shadow" title="Editar" data-toggle="modal" data-target="#edit{{$cell->id}}">
                                <i class="fa fa-lg fa-fw fa-pen"></i>
                            </a>
                            <a href="#" class="btn btn-xs btn-default text-danger mx-1 shadow" title="Excluir" data-toggle="modal" data-target="#destroy{{$cell->id}}">
                                <i class="fa fa-lg fa-fw fa-trash"></i>
                            </a>
                        </nobr>
                    </td>
                </tr>

                <!-- Modais -->

                <x-adminlte-modal id="destroy{{$cell->id}}" title="Deletar {{$title}}" theme="red" icon="{{$icon}}" size="lg" static-backdrop>
                    <form action="{{ route($route . '.destroy', $table === 'users' ? $cell->$type->id : $cell->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <p>Você tem certeza que deseja deletar o {{$title}} {{ $cell->name }}?</p>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-danger">Deletar</button>
                        </div>
                    </form>
                    <x-slot name="footerSlot">

                    </x-slot>
                </x-adminlte-modal>

                @yield('modals')

                @endforeach

                <!-- Modal Adicionar -->

                <x-adminlte-modal id="add" title="Adicionar {{$title}}" theme="success" icon="{{$icon}}" size="lg" static-backdrop>
                    <form action="{{ route($route . '.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @yield('create_form_inputs')
                    </form>
                    <x-slot name="footerSlot">
                    </x-slot>
                </x-adminlte-modal>

            </tbody>
        </x-adminlte-datatable>
        <div class="pagination">
            {{ $data->links() }}
        </div>
    </div>
</div>

<script>
    function formatarCpf(campo) {
        let valor = campo.value.replace(/\D/g, '');
        if (valor.length > 3) {
            valor = valor.substring(0, 3) + '.' + valor.substring(3);
        }
        if (valor.length > 7) {
            valor = valor.substring(0, 7) + '.' + valor.substring(7);
        }
        if (valor.length > 11) {
            valor = valor.substring(0, 11) + '-' + valor.substring(11);
        }

        campo.value = valor;
    }

    function formatarTelefone(campo) {
        let valor = campo.value.replace(/\D/g, '');
        if (valor.length > 2) {
            valor = '(' + valor.substring(0, 2) + ') ' + valor.substring(2);
        }
        if (valor.length > 10) {
            valor = valor.substring(0, 10) + '-' + valor.substring(10);
        }
        campo.value = valor;
    }
</script>