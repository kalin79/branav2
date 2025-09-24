<table id="tbl-slider" class="table table-striped mb-0">
    <thead>
        <tr>
            <th width="200px">Icono</th>
            <th>Título</th>
            <th>Color</th>
            <th width="">Orden</th>
            <th>Estado</th>
            <th>Opciones</th>
        </tr>
    </thead>
<tbody>
    @forelse ($cuidados as $valor)
        <tr id="{{$valor->id}}">
            <td>
                @if($valor->icono)
                <img src="{{ asset('images/cuidado-personal') }}/{{ $valor->id }}/{{ $valor->icono }}"
                    width="200px">
                @endif
            </td>
            <td>
                {{ $valor->titulo }}
                <br>
                <small>{{ $valor->descripcion }}</small>
            </td>
            <td>{{ $valor->color }}
                <br>
                <small>{{ $valor->link }}</small>
            </td>
            <td>{{ $valor->orden }}</td>
            @if ($valor->active)
                <td><span class="badge badge-success">Activo</span></td>
            @else
                <td><span class="badge badge-danger">No-Activo</span></td>
            @endif
            <td width="150px">

                <a title="Editar" data-name="{{ $valor->titulo }}" href="{{ route('cuidado-personal.edit', $valor->id) }}"
                    class="btn btn-outline-info btn-sm edit-entity">
                    <i class="fa fa-pen"></i>
                </a> &nbsp;
                <button onclick="eliminar({{ $valor->id }},'{{ route('cuidado-personal.destroy', $valor->id) }}')"
                    title="Dar de baja" class="btn btn-outline-danger btn-sm" data-id="{{ $valor->id }}">
                    <i class="fa fa-trash"></i>
                </button> &nbsp;
                @if ($valor->active == 1)
                    <button onclick="desactivar({{ $valor->id }},'{{ route('cuidado-personal.desactive') }}')" title="Desactivar"
                        data-id="{{ $valor->id }}" class="btn btn-outline-warning btn-sm">
                        <i class="fa fa-ban"></i>
                    </button>
                @else

                    <button onclick="activar({{ $valor->id }},'{{ route('cuidado-personal.active') }}')" title="Activar"
                        data-id="{{ $valor->id }}" class="btn btn-outline-success  btn-sm">
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
    <tr>
        <td colspan="5">{{ $cuidados->links() }}</td>
        <td><span>Total: </span> <b>{{ $cuidados->total() }}</b></td>
    </tr>
</tfoot>
</table>
