@extends('layouts.app')
@section('content')
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div>
                    <div class="page-title-head center-elem">
                        <span class="d-inline-block pr-2">
                            <i class="fa fa-shopping-cart opacity-6"></i>
                        </span>
                        <span class="d-inline-block">Detalle de Venta #{{ $sale->order_number }}</span>
                    </div>
                </div>
            </div>
            <div class="page-title-actions">
                <a href="{{ route('sales.index') }}" class="btn btn-secondary">
                    <i class="fa fa-arrow-left"></i> Volver al Listado
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="main-card mb-3 card">
                <div class="card-header">Productos</div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Imagen</th>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Precio Unit.</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sale->saleProducts as $item)
                                <tr>
                                    <td>
                                        <img src="{{ $item->product ? $item->product->poster_url : asset('storage/images/products/' . $item->product_image) }}"
                                            width="50">
                                    </td>
                                    <td>{{ $item->product_name }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>S/ {{ number_format($item->unit_price, 2) }}</td>
                                    <td>S/ {{ number_format($item->total_price, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="4" class="text-right">Total:</th>
                                <th>S/ {{ number_format($sale->total_price, 2) }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="main-card mb-3 card">
                <div class="card-header">Información del Cliente</div>
                <div class="card-body">
                    <p><strong>Nombre:</strong>
                        {{ $sale->client ? $sale->client->nombres . ' ' . $sale->client->apellidos : $sale->contact_name }}
                    </p>
                    <p><strong>Email:</strong> {{ $sale->client ? $sale->client->email : $sale->contact_email }}</p>
                    <p><strong>Teléfono:</strong> {{ $sale->client ? $sale->client->celular : $sale->contact_cell_phone }}
                    </p>
                    <hr>
                    <p><strong>Dirección de Entrega:</strong> {{ $sale->direccion }}</p>
                    <p><strong>Referencia:</strong>
                        {{ $sale->orderShippingInformation ? $sale->orderShippingInformation->referre : 'N/A' }}</p>
                </div>
            </div>

            <div class="main-card mb-3 card">
                <div class="card-header">Estado del Pedido</div>
                <div class="card-body">
                    <p><strong>Estado Actual:</strong> <span
                            class="badge badge-info">{{ $sale->status ? $sale->status->name : 'N/A' }}</span></p>
                    <hr>
                    <p><strong>Número de Orden:</strong> {{ $sale->order_number }}</p>
                    <p><strong>Fecha de Compra:</strong> {{ $sale->fecha_venta }}</p>
                    <p><strong>Método de Pago:</strong> {{ $sale->payment_method_id ?? 'Tarjeta / MercadoPago' }}</p>
                    <p><strong>Estado Pago:</strong> {{ $sale->status_pay == 1 ? 'Aprobado' : 'Pendiente' }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection