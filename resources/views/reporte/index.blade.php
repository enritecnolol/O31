@extends('main.app')
@section('tittle','Cafeteria | Reporte')

@section('titulo')
    <h3 style="color: white"><i class="fas fa-arrow-circle-right"></i> Reportes</h3>
@endsection

@section('aside')
    @include('caja.siderbar')
@endsection

@section('content')
    <div class="container" style="margin-top: -40px">
        <div class="col-lg-12" id="myPrintArea">
            <div class="card">
                <div class="card-body">
                    <div class="col-md-12" style="background: #4272d7">
                        <div class="text-center">
                            <span style="color: white;">Reporte de venta</span>
                        </div>
                    </div>
                    <br>
                    <div class="col-md-12">
                        <div style="float: right">
                            <input type="text" class="form-control" name="daterange" value="" />
                        </div>
                        <div style="float: left">
                            <button type="button" class="btn btn-success btn-sm" id="imprimir"><i class="fas fa-print"></i></button>
                        </div>
                    </div>
                    <br>
                    <br>
                    <div class="col-md-12">
                        <table class="table table-sm table-bordered">
                            <thead>
                            <tr>
                                <th scope="col">FECHA</th>
                                <th scope="col">NO.FACTURA</th>
                                <th scope="col">MONTO EFECTIVO</th>
                                <th scope="col">MONTO TARJETA</th>
                                <th scope="col">BRUTO</th>
                                <th scope="col">DESC</th>
                                <th scope="col">ITBIS</th>
                                <th scope="col">TOTAL</th>
                            </tr>
                            </thead>
                            <tbody id="datos">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <br>
    </div>
@endsection

@section('scriptp')
    <script>
        $( document ).ready(function() {
            $("#imprimir").click(function () {
                $("div#myPrintArea").printArea();
            });
            $(function() {
                $('input[name="daterange"]').daterangepicker({
                    locale: {
                        format: 'DD/MM/YYYY'
                    },
                    opens: 'left'
                }, function(start, end, label) {
                    // console.log("A new date selection was made: " + start.format('DD-MM-YYYY') + ' to ' + end.format('DD-MM-YYYY'));
                    var inicio = start.format('YYYY-MM-DD')
                    var fin = end.format('YYYY-MM-DD')
                    var fecha = 'inicio=' + start + '&fin=' + end;
                    $.ajax({
                        url: '/reportes/resultado',
                        method:'GET',
                        data: {
                            inicio:inicio,
                            fin:fin
                        },
                        success:function (data) {
                            console.log(data);
                            $('#datos').html(data);
                        },
                        error:function () {
                            
                        }
                    });
                });
            });
        });
    </script>
@endsection