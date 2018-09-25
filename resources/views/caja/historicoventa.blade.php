@extends('main.app')
@section('tittle','Cafeteria | Historico de Venta')


@section('aside')
    @include('caja.siderbar')
@endsection

@section('content')
    <div class="container-fluid">
        <div class="card">
            <h5 class="card-header">Historico de Ventas</h5>
            <div class="card-body">
                <div class="container-fluid">
                    <table id="historico" class="table table-hover">
                        <thead>
                        <tr>
                            <th></th>
                            <th>Caja</th>
                            <th>Cliente</th>
                            <th>Monto Efectivo</th>
                            <th>Monto Tarjeta</th>
                            <th>Total de Factura</th>
                            <th>Estado</th>
                            <th>Fecha</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scriptp')
    <script !src="">
        $(document).ready(function () {
            $('#historico').DataTable({
                serverSide: true,
                order: [[ 0, "desc" ]],
                ajax: '/historico/venta',
                columns: [
                    {data: "id"},
                    {data: "box"},
                    {data: "client"},
                    {data:"Monto_efectivo"},
                    {data:"Monto_tarjeta"},
                    {data: "total_facture"},
                    {data: "status"},
                    {data: "date"}
                ]
            } );

        });

    </script>
@endsection