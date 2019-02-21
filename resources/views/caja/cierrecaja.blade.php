@extends('main.app')
@section('tittle','Cafeteria | Cierre de Caja')


@section('aside')
    @include('caja.siderbar')
@endsection


@section('content')
    <div class="container">
        <div class="text-center" style="margin-bottom: 25px">
            <h1>Cierre de Caja</h1>
        </div>
        <div  class="card" v-if="caja[0].cuadreconf == 'Si'">
            <div class="card-header">
                <strong>Caja</strong>
            </div>
            <div class="card-body">
                <div class="text-center">
                    <div class="alert alert-warning" role="alert" style="width: 500px; margin-left: 30%">
                        <h4 class="alert-heading">No hay una caja abierta!!</h4>
                        <p>Para poder cerrar la caja debes hacer una apertura y procede a Vender.</p>
                        <hr>
                        <p class="mb-0">Luego de vender ya podra cerrar la caja, despues cuadre la caja, si la caja no esta cuadrada no se le permitira abrir otra caja.</p>
                    </div>
                </div>
            </div>
        </div>
        <div v-else class="card" style="width: 100%;">
            <div class="card-header">
                <strong>Cierre</strong>
                <button v-if="caja[0].status == 'A'" class="btn btn-success btn-sm pull-right" @click="confimar()" type="button"><i class="fas fa-lock">&nbsp; Cerrar Caja</i></button>
                <button v-else disabled class="btn btn-success btn-sm pull-right"  type="button"><i class="fas fa-lock">&nbsp; Cerrar Caja</i></button>
            </div>
            <div class="card-body">
                <div class="row" v-if="caja[0].status == 'A'">
                    <div class="col-md-3">
                        <strong>Cierre de caja:</strong> No.1
                    </div>
                    <div class="col-md-3">
                        <strong>Fecha:</strong> @{{ caja[0].fecha_apertura }}
                    </div>
                    <div class="col-md-6">
                        <strong>Hora de Apertura: </strong> @{{ caja[0].hora_apertura }} - <strong>Hora de Cierre</strong> 00:00:00
                    </div>
                    <br>
                    <div class="col-md-3">
                        <strong>Usuario:</strong> General
                    </div>
                    <div class="col-md-2">
                        <strong>Caja:</strong> 1
                    </div>
                    <div class="col-md-3">
                        <strong>Almacen:</strong> General
                    </div>
                    <div class="col-md-3">
                        <strong>Total de Ventas:</strong> @{{ ventas }}  - @{{ total }}
                    </div>
                </div>
                <div v-if="caja[0].status == 'C'" class="text-center">
                    <h1>La ultima caja esta <strong style="color: red">Cerrada</strong></h1>
                    <br>
                    <br>
                    <hr>
                    <a href="/caja/cuadre">Si desea cuadrar una caja presione <strong style="color: red">AQUI</strong></a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scriptp')
    <script !src="">
        var caja = JSON.parse('{!! $caja !!}')
        var ventas = JSON.parse('{!! $ventas !!}')
        var totalc = '{!! $total !!}'
        var valor_apertura = '{!! $valor_apertura !!}'
        var ordenes = '{{$ordens}}';

        function toObject(arr) {
            var rv = {};
            for (var i = 0; i < arr.length; ++i)
                rv[arr[i].id] = arr[i];
            return rv;
        }
        new Vue({
            el: '#Vue',
            data: {
                valor_apertura: valor_apertura,
                total: totalc,
                caja: Object.values(caja),
                ventas: ventas,
                datos:[],
                onetime:1
            },
            methods:{

                confimar: function (){
                    var txt;
                    var r = confirm("Esta seguro que quieres cerrar la caja?");
                    if (r == true){
                        txt = this.cerrarcaja();
                    }
                },
                cerrarcaja: function () {
                    if (ordenes != 0){
                        toastr.warning("Por favor cerrar las ordenes que posee abiertas");
                        return;
                    }
                    if (this.onetime == 1){
                        this.onetime = 2;
                        $.ajax({
                            url: '/cierrecaja',
                            method: 'GET',
                            data: {
                                caja: this.caja,
                                ventas: this.ventas,
                                total: this.total,
                                valor_apertura: this.valor_apertura
                            },
                            success:function (dato) {
                                toastr.success('La caja se a Cerrado');
                                setTimeout('document.location.reload()',1000);
                            }
                        });
                    }
                }
            }
        })
    </script>
@endsection
