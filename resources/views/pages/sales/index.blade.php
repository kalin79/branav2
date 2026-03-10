@extends('layouts.app')
@section('content')
    <div class="app-page-title ">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div>
                    <div class="page-title-head center-elem">
                        <span class="d-inline-block pr-2">
                            <i class="fa fa-shopping-cart opacity-6"></i>
                        </span>
                        <span class="d-inline-block">Ventas</span>
                    </div>
                    <div class="page-title-subheading opacity-10">
                        <nav class="" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a>E-commerce</a>
                                </li>
                                <li class="active breadcrumb-item" aria-current="page">
                                    Ventas
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('includes.search')
    <div class="main-card mb-3 card">
        <div class="card-body p-0">
            <div class="row">
                <div class="col-sm">
                    <div class="table-wrap">
                        <div id="table-content" class="table-responsive">
                            <table class="table table-striped mb-0">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Fecha</th>
                                        <th>Nro Orden</th>
                                        <th>Cliente</th>
                                        <th>Total</th>
                                        <th>Estado Pago</th>
                                        <th>Estado Pedido</th>
                                        <th>Opciones</th>
                                    </tr>
                                </thead>
                                <tbody id="table-body">
                                </tbody>
                            </table>
                            <div id="loading" class="text-center">
                                <i class="fa fa-spinner fa-pulse fa-lg p-5" role="status" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        var url_sales_load = "{{ route('sales.load') }}";
    </script>
    <script type="text/javascript" src="{{ asset('js/bootbox.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/functions.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/filter.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            loadSales();
        });

        function loadSales() {
            $("#loading").show();
            $.ajax({
                url: url_sales_load,
                type: 'GET',
                success: function (data) {
                    $("#table-body").html(data);
                    $("#loading").hide();
                }
            });
        }
    </script>
@endpush