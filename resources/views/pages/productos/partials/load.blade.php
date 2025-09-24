<table id="tbl-slider" class="table table-striped mb-0">
    <thead>
        <tr>
            <th width="200px">Poster</th>
            <th>Título</th>
            <th>Precio actual / Precio anterior</th>
            <th width="">Stock</th>
            <th class="text-center">Relacionadas</th>
            <th>Estado</th>
            <th>Opciones</th>
        </tr>
    </thead>
<tbody>
    @forelse ($productos as $producto)
        <tr >
            <td>
                @if($producto->poster)
                <img src="{{ asset('images/products') }}/{{ $producto->id }}/{{ $producto->poster }}"
                    width="80px">
                @endif
            </td>
            <td>
                {{ $producto->title_large}}
            </td>
            <td>
                <div role="group" class="btn-xs btn-group  btn-group-xs " data-toggle="buttons">
                    <button class="btn btn-success btn-xs">S/ {{ $producto->precio_normal }}</button>
                    <button class="btn btn-danger btn-xs">S/ {{ $producto->precio_online }}</button>
                </div>
            </td>
            <td>
                {{ $producto->stock}}
            </td>
            <td class="text-center">
                <a title="Relacionas"  href="{{ route('products.relacionada.index', $producto->id) }}"
                   class="btn btn-outline-primary btn-sm">
                    {{$producto->relation_product_count}}
                </a>
            </td>

        @if ($producto->active)
                <td><span class="badge badge-success">Activo</span></td>
            @else
                <td><span class="badge badge-danger">No-Activo</span></td>
            @endif
            <td width="150px">

                <a title="Editar" data-name="{{ $producto->title_small }}" href="{{ route('products.edit', $producto->id) }}"
                    class="btn btn-outline-info btn-sm edit-entity">
                    <i class="fa fa-pen"></i>
                </a> &nbsp;
                <button onclick="eliminar({{ $producto->id }},'{{ route('products.destroy', $producto->id) }}')"
                    title="Dar de baja" class="btn btn-outline-danger btn-sm" data-id="{{ $producto->id }}">
                    <i class="fa fa-trash"></i>
                </button> &nbsp;
                @if ($producto->active == 1)
                    <button onclick="desactivar({{ $producto->id }},'{{ route('products.desactive') }}')" title="Desactivar"
                        data-id="{{ $producto->id }}" class="btn btn-outline-warning btn-sm">
                        <i class="fa fa-ban"></i>
                    </button>
                @else

                    <button onclick="activar({{ $producto->id }},'{{ route('products.active') }}')" title="Activar"
                        data-id="{{ $producto->id }}" class="btn btn-outline-success  btn-sm">
                        <i class="fa fa-check "></i>
                    </button>
                @endif
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="7" class="text-center text-muted"><span>No se encontraron resultados</span></td>
        </tr>
    @endforelse

</tbody>
<tfoot>
    <tr>
        <td colspan="6">{{ $productos->links() }}</td>
        <td><span>Total: </span> <b>{{ $productos->total() }}</b></td>
    </tr>
</tfoot>
</table>
