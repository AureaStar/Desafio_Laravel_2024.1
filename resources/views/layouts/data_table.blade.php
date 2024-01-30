<div class="box">
    <div class="box-header" style="display: flex; justify-content: space-between; padding: 10px 5px;">
        <h3 class="box-title inline text-md text-xl text-2xl-md" style="width: fit-content;">Gerenciamento de {{$title}}</h3>

        <x-adminlte-button label="Adicionar {{$title}}" class="btn btn-inline btn-sm btn-md" data-toggle="modal" data-target="#add" theme="success" icon="fas fa-plus" />
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
        <div class="pagination">
            {{ $data->links() }}
        </div>
    </div>
</div>