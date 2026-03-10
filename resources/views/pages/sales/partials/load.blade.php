@forelse($sales as $sale)
    <tr>
        <td>{{ $sale->id }}</td>
        <td>{{ $sale->fecha_venta }}</td>
        <td>{{ $sale->order_number }}</td>
        <td>{{ $sale->client ? $sale->client->nombres . ' ' . $sale->client->apellidos : $sale->contact_name }}</td>
        <td>S/ {{ number_format($sale->total_price, 2) }}</td>
        <td>
            @if($sale->status_pay == 1)
                <span class="badge badge-success">Pagado</span>
            @else
                <span class="badge badge-warning">Pendiente</span>
            @endif
        </td>
        <td>
            <span class="badge badge-info">{{ $sale->status ? $sale->status->name : 'N/A' }}</span>
        </td>
        <td>
            <a href="{{ route('sales.show', $sale->id) }}" class="btn btn-info btn-sm">
                <i class="fa fa-eye"></i> Ver Detalle
            </a>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="8" class="text-center">No hay ventas registradas.</td>
    </tr>
@endforelse
<tr>
    <td colspan="8">
        {{ $sales->links() }}
    </td>
</tr>