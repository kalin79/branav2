
<div class="row">
    <div class="col-sm">
        <div class="table-wrap">
            <div class="table-responsive">
                <table class="table  table-striped mb-0">
                    <thead >
                    <tr>
                        <th>Tienda</th>
                        <th>Direccion</th>
                        <th>Tiempo Entrega</th>
                        <th>Telefono</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($tiendas as $tienda)
                        <tr>
                            <td>{{ $tienda->nombre }}</td>
                            <td>{{ $tienda->direccion }}</td>
                            <td>{{ $tienda->tiempo_entrega }}</td>
                            <td>{{ $tienda->telefono }}</td>
                            @if($tienda->active)
                                <td><span class="badge badge-success">Activo</span></td>
                            @else
                                <td><span class="badge badge-danger">No Activo</span></td>
                            @endif
                            <td>
                                <a title="Editar" data-name="{{$tienda->nombre}}"  href="{{ route('tienda.edit', $tienda->id) }}" class="btn btn-outline-info btn-sm edit-entity" >
                                    <i class="fa fa-pen"></i>
                                </a> &nbsp;
                                <button  onclick="eliminar({{ $tienda->id }},'{{route("tienda.destroy",$tienda->id )}}')" title="Eliminar" class="btn btn-outline-danger btn-sm" data-id="{{ $tienda->id }}">
                                    <i class="fa fa-trash"></i>
                                </button> &nbsp;
                                @if($tienda->active==1)
                                    <button  onclick="desactivar({{ $tienda->id }},'{{route("tienda.desactive")}}')" title="Desactivar" data-id="{{ $tienda->id }}" class="btn btn-outline-warning btn-sm" >
                                        <i class="fa fa-ban"></i>
                                    </button>
                                @else
                                    <button  onclick="activar({{ $tienda->id }},'{{route("tienda.active")}}')" title="Activar" data-id="{{ $tienda->id }}" class="btn btn-outline-success  btn-sm">
                                        <i class="fa fa-check "></i>
                                    </button>
                                @endif


                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted"><span>No se encontraron resultados</span></td>
                        </tr>
                    @endforelse
                    </tbody>
                    <tfoot>
                    <tr >
                        <td colspan="4">{{ $tiendas->links() }}</td>
                        <td><span>Total: </span> <b>{{ $tiendas->total() }}</b></td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>


