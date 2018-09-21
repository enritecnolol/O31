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
        <div class="card" style="width: 100%;">
            <div class="card-header">
                <strong>Cierre</strong>
                <button v-if="caja[0].total_cierre == 0" class="btn btn-success btn-sm pull-right" @click="confimar()" type="button"><i class="fas fa-lock">&nbsp; Cerrar Caja</i></button>
                <button v-else disabled class="btn btn-success btn-sm pull-right"  type="button"><i class="fas fa-lock">&nbsp; Cerrar Caja</i></button>
            </div>
            <div class="card-body">
                <div class="row" v-if="caja[0].total_cierre == 0">
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
                <div v-else class="text-center">
                    <h1>La caja esta <strong style="color: red">Cerrada</strong></h1>
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
        })
    </script>
@endsection
