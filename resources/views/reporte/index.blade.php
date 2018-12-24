@extends('main.app')
@section('tittle','Cafeteria | Reporte')
@section('titulo')
    <h3 style="color: white"><i class="fas fa-arrow-circle-right"></i> Reportes</h3>
@endsection

@section('aside')
    @include('caja.siderbar')
@endsection



@section('content')
    <div class="container" style="margin-top: -35px">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="text-center" style="background: #0062cc">
                                        <span style="color: white; font-size: 24px">Reportes</span>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <br>
                                    <div style="margin-bottom: 10px">
                                        <h4>Reporte de Ventas por Productos</h4>
                                    </div>
                                    <div>
                                        <div class="row form-group">
                                            <div class="col">
                                                <select class="select" id="producto" name="producto">
                                                    <option value="-2">Selecciona</option>
                                                    @foreach($productos as  $producto)
                                                        <option value="{{$producto->id}}">{{$producto->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col">
                                                <div class="" id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                                                    <i class="fa fa-calendar"></i>&nbsp;
                                                    <span></span> <i class="fa fa-caret-down"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="col-lg-12">
                                    <br>
                                    <div style="margin-bottom: 10px">
                                        <h4>Reporte de Ventas</h4>
                                    </div>
                                    <div>
                                        <div class="row form-group">
                                            <div class="col">
                                                <div class="form-control" id="reportrange2" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                                                    <i class="fa fa-calendar"></i>&nbsp;
                                                    <span></span> <i class="fa fa-caret-down"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <button type="button" id="imprimirboton" class="btn btn-success"><i class="fas fa-print"></i> Imprimir</button>
                                </div>
                                <div class="col-lg-12">
                                    <br>
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="tabla-inicio">
                                            <thead id="table-header">
                                            <tr>
                                                <th scope="col">Fecha</th>
                                                <th scope="col">No.factura</th>
                                                <th scope="col">Bruto</th>
                                                <th scope="col">Desc</th>
                                                <th scope="col">Itbis</th>
                                                <th scope="col">Total factura</th>
                                                <th scope="col">Efectivo</th>
                                                <th scope="col">tarjeta</th>
                                            </tr>
                                            </thead>
                                            <tbody id="table-body">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-lg-12" style="display: none">
                                    <div id="prueba">

                                    </div>
                                </div>
                                <div class="col-lg-12" style="display: none">
                                    <div id="prueba2">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scriptp')
    <script !src="">
        var table = $('#table-inicio').DataTable();

        $(document).ready( function () {
            $.ajax({
                url: '/reportes/inicio',
                method: 'GET',
                success: function (data){
                    table.destroy();
                    $('#tabla-inicio').find('#table-body').html(data);
                    table = $('#tabla-inicio').DataTable({
                        "order": [[ 0, "desc" ]],
                        "language": {
                            "lengthMenu": "Registros por página _MENU_ ",
                            "zeroRecords": "No hay registros encontrados.",
                            "info": "Mostrando página _PAGE_ de _PAGES_",
                            "infoEmpty": "No hay registros disponibles.",
                            "search":         "Buscar:",
                            "paginate": {
                                "first":      "Primero",
                                "last":       "Último",
                                "next":       "Próximo",
                                "previous":   "Anterior"
                            }
                        },
                        responsive: true
                    } );
                }
            })
        });

        var este = 0;

        $(document).ready(function() {
            $('.select').select2();
            $("#imprimirboton").click(function(){
                if (este == 1){
                    $('#prueba').printArea();
                } else{
                    $('#prueba2').printArea();
                }
            });
        });

        $(function() {
            var start = moment();
            var end = moment();

            function cb(start, end) {
                $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            }

            $('#reportrange').daterangepicker({
                startDate: start,
                endDate: end,
                ranges: {
                    'Hoy': [moment(), moment()],
                    'Ayer': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Ultimos 7 dias': [moment().subtract(6, 'days'), moment()],
                    'Ultimos 30 dias': [moment().subtract(29, 'days'), moment()],
                    'Este Mes': [moment().startOf('month'), moment().endOf('month')],
                    'Ultimo Mes': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                }
            }, cb);

            cb(start, end);
        });

        $('#reportrange').on('apply.daterangepicker', function(ev, picker) {
            var start = picker.startDate.format('YYYY-MM-DD');
            var end = picker.endDate.format('YYYY-MM-DD');
            var producto = $('#producto').val();
            if (producto == '-2') {
                alert('seleccione un producto');
            } else {

                $('#table-body').html('<center> <img h src="{{url('select2-spinner.gif')}}" alt="loading"></center>');
                $.ajax({
                    url: '/reportes/productos/' + start + '/' + end,
                    method: 'GET',
                    data: {producto: producto},
                    success: function (data) {
                        table.destroy();
                        $('#tabla-inicio').find('#table-header').html('<tr>\n' +
                            '                                            <th scope="col">Nombre Producto</th>\n' +
                            '                                            <th scope="col">Cantidad</th>\n' +
                            '                                            <th scope="col">Importe</th>\n' +
                            '                                        </tr>');
                        $('#tabla-inicio').find('#table-body').html(data);
                        table = $('#tabla-inicio').DataTable({
                            "order": [[0, "desc"]],
                            "language": {
                                "lengthMenu": "Registros por página _MENU_ ",
                                "zeroRecords": "No hay registros encontrados.",
                                "info": "Mostrando página _PAGE_ de _PAGES_",
                                "infoEmpty": "No hay registros disponibles.",
                                "search": "Buscar:",
                                "paginate": {
                                    "first": "Primero",
                                    "last": "Último",
                                    "next": "Próximo",
                                    "previous": "Anterior"
                                }
                            },
                            responsive: true
                        });
                    }
                })
                $.ajax({
                    url: '/reportes/imprimir/productos/' + start + '/' + end,
                    method: 'GET',
                    data: {
                        producto: producto
                    },
                    success: function (data) {
                        $('#prueba2').html(data);
                        este = 2;
                        // $('#prueba').printArea(data);
                    }
                })
            }
        })


        $(function() {
            var start = moment();
            var end = moment();

            function cb(start, end) {
                $('#reportrange2 span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            }

            $('#reportrange2').daterangepicker({
                startDate: start,
                endDate: end,
                ranges: {
                    'Hoy': [moment(), moment()],
                    'Ayers': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Ultimos 7 dias': [moment().subtract(6, 'days'), moment()],
                    'Ultimos 30 dias': [moment().subtract(29, 'days'), moment()],
                    'Este Mes': [moment().startOf('month'), moment().endOf('month')],
                    'Ultimo mes': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                }
            }, cb);

            cb(start, end);
        });

        $('#reportrange2').on('apply.daterangepicker', function(ev, picker) {
            var start = picker.startDate.format('YYYY-MM-DD');
            var end = picker.endDate.format('YYYY-MM-DD');
            $('#table-body').html('<center> <img h src="{{url('select2-spinner.gif')}}" alt="loading"></center>');
            $.ajax({
                url: '/reportes/'+start+'/'+end,
                method: 'GET',
                success: function (data) {
                    table.destroy();
                    $('#tabla-inicio').find('#table-header').html('<tr>\n' +
                        '                                            <th scope="col">Fecha</th>\n' +
                        '                                            <th scope="col">No.factura</th>\n' +
                        '                                            <th scope="col">Bruto</th>\n' +
                        '                                            <th scope="col">Desc</th>\n' +
                        '                                            <th scope="col">Itbis</th>\n' +
                        '                                            <th scope="col">Total factura</th>\n' +
                        '                                            <th scope="col">Efectivo</th>\n' +
                        '                                            <th scope="col">tarjeta</th>\n' +
                        '                                        </tr>');
                    $('#tabla-inicio').find('#table-body').html(data);
                    table = $('#tabla-inicio').DataTable({
                        "order": [[ 0, "desc" ]],
                        "language": {
                            "lengthMenu": "Registros por página _MENU_ ",
                            "zeroRecords": "No hay registros encontrados.",
                            "info": "Mostrando página _PAGE_ de _PAGES_",
                            "infoEmpty": "No hay registros disponibles.",
                            "search":         "Buscar:",
                            "paginate": {
                                "first":      "Primero",
                                "last":       "Último",
                                "next":       "Próximo",
                                "previous":   "Anterior"
                            }
                        },
                        responsive: true
                    } );
                }
            })
            $.ajax({
                url: '/reportes/imprimir/'+start+'/'+end,
                method: 'GET',
                success: function (data) {
                    $('#prueba').html(data);
                    este = 1;
                    // $('#prueba').printArea(data);
                }
            })
        });

    </script>
@endsection