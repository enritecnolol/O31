@extends('main.app')
@section('tittle','Cafeteria | Cuadre caja')
@section('titulo')
    <h3 style="color: white">Cuadre de Caja</h3>
@endsection
@section('style')
    <style type="text/css">
    </style>
@endsection


@section('aside')
    @include('caja.siderbar')
@endsection


@section('content')
    <div  v-if="nose == 'cuadrada'" class="section__content section__content--p30">
        <div class="container-fluid">

            <div class="card">
                <div class="card-header">
                    <strong style="color: #007bff">Caja Cuadrada</strong>
                </div>
                <div class="card-body text-center">
                    <h1 style="margin: 10%;">La Caja ya ha sido cuadrada,<br>Despues de que la caja se cuadre esta no se puede editar <span style="color: red"><i class="fas fa-lock"></i></span></h1>
                    <br>
                </div>
            </div>
        </div>
    </div>
    <div v-else-if="nose == 'NoCuadrada'" class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <strong style="color: #007bff">Caja</strong>
                    <button v-if="nose != 'Abierta'" @click="confimar()" class="btn btn-warning btn-sm pull-right"  type="button"><i class="fas fa-lock">&nbsp; Cuadrar Caja</i></button>
                    <button v-else class="btn btn-warning btn-sm pull-right" disabled type="button"><i class="fas fa-lock">&nbsp; Cuadrar Caja</i></button>
                </div>
                <div class="card-body">

                    <div class="row" v-if="nose != 'Abierta'">
                        <div class="col-md-3">
                            <strong>Cierre de caja:</strong> No.1
                        </div>
                        <div class="col-md-3">
                            <strong>Fecha:</strong> @{{ caja[0].fecha_apertura }}
                        </div>
                        <div class="col-md-6">
                            <strong>Hora de Apertura: </strong> @{{ caja[0].hora_apertura }} - <strong>Hora de Cierre</strong> @{{ caja[0].fecha_cierre }}
                        </div>
                        <br>
                        <div class="col-md-3">
                            <strong>Usuario:</strong> @{{ caja[0].usuario }}
                        </div>
                        <div class="col-md-2">
                            <strong>Caja:</strong> 1
                        </div>
                        <div class="col-md-3">
                            <strong>Almacen:</strong> General
                        </div>
                        <div class="col-md-3">
                            <strong>Total de Ventas:</strong> @{{ caja[0].total_venta }}  - @{{ caja[0].total_cierre }}
                        </div>
                        <div class="col-md-3">
                            <strong>Total de Apertura:</strong> @{{ caja[0].valor_apertura }}
                        </div>
                    </div>
                    <h3 v-else style="color:red;"  class="text-center"> Para poder cuadrar la caja es necesario cerrarla </h3>
                </div>
            </div>
            <div class="row" v-if="nose != 'Abierta'">
                <div class="col-lg-4">
                    <div class="card" style="height: 600px">
                        <div class="card-header"><strong style="color: #007bff">Billetes</strong></div>
                        <div class="card-body">
                            <table class="table table-hover table-sm">
                                <thead>
                                <tr>
                                    <th scope="col">Billetes</th>
                                    <th scope="col" class="text-center">Cantidad</th>
                                    <th scope="col">Total</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <th scope="row">2000</th>
                                    <td class="text-center">
                                        <div class="col col-sm-8 ">
                                            <input type="number" min="0" v-model="dosk" class="form-control">
                                        </div>
                                    </td>
                                    <td>@{{ dosktotal }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">1000</th>
                                    <td class="text-center">
                                        <div class="col col-sm-8">
                                            <input type="number" min="0" v-model="unok" class="form-control">
                                        </div>
                                    </td>
                                    <td>@{{ unoktotal }}</td>

                                </tr>
                                <tr>
                                    <th scope="row">500</th>
                                    <td class="text-center">
                                        <div class="col col-sm-8">
                                            <input type="number" min="0" v-model="quinientos" class="form-control">
                                        </div>
                                    </td>
                                    <td>@{{ quinientostotal }}</td>

                                </tr>
                                <tr>
                                    <th scope="row">200</th>
                                    <td class="text-center">
                                        <div class="col col-sm-8">
                                            <input type="number" min="0" v-model="dociento" class="form-control">
                                        </div>
                                    </td>
                                    <td>@{{ docientototal }}</td>

                                </tr>
                                <tr>
                                    <th scope="row">100</th>
                                    <td class="text-center">
                                        <div class="col col-sm-8">
                                            <input type="number" min="0" v-model="cien" class="form-control">
                                        </div>
                                    </td>
                                    <td>@{{ cientotal }}</td>

                                </tr>
                                <tr>
                                    <th scope="row">50</th>
                                    <td class="text-center">
                                        <div class="col col-sm-8">
                                            <input type="number" min="0" v-model="cincuenta" class="form-control">
                                        </div>
                                    </td>
                                    <td>@{{ cincuentatotal }}</td>

                                </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card" style="height: 600px">
                        <div class="card-header"><strong style="color: #007bff">Monedas</strong></div>
                        <div class="card-body">
                            <table class="table table-hover table-responsive table-sm">
                                <thead>
                                <tr>
                                    <th scope="col">Monedas</th>
                                    <th scope="col" class="text-center">Cantidad</th>
                                    <th scope="col">Total</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <th scope="row">25</th>
                                    <td class="text-center">
                                        <div class="col ">
                                            <input type="number" min="0" v-model="veinticinco" class="form-control">
                                        </div>
                                    </td>
                                    <td>@{{ ventecincototal }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">10</th>
                                    <td class="text-center">
                                        <div class="col">
                                            <input type="number" min="0" v-model="diez" class="form-control">
                                        </div>
                                    </td>
                                    <td>@{{ dieztotal }}</td>

                                </tr>
                                <tr>
                                    <th scope="row">5</th>
                                    <td class="text-center">
                                        <div class="col">
                                            <input type="number" min="0" v-model="cinco" class="form-control">
                                        </div>
                                    </td>
                                    <td>@{{ cincototal }}</td>

                                </tr>
                                <tr>
                                    <th scope="row">1</th>
                                    <td class="text-center">
                                        <div class="col">
                                            <input type="number" min="0"  v-model="uno" class="form-control">
                                        </div>
                                    </td>
                                    <td>@{{ unototal }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card" style="height: 600px">
                        <div class="card-header">
                            <strong style="color: #007bff">Cuadre segun ventas</strong>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label  class="pr-1  form-control-label"> +&emsp;&emsp;<i class="fas fa-money-bill-alt"></i> Efectivo &emsp;= </label>
                                <label  class="pr-1  form-control-label">&emsp;@{{ cajaefectivo }}</label>
                            </div>
                            <div class="form-group">
                                <label class="pr-1  form-control-label">+&emsp;&emsp;<i class="fas fa-credit-card"></i> Tarjeta  &emsp;&nbsp;= </label>
                                <label class="pr-1  form-control-label">&emsp;@{{ cajatarjeta }}</label>
                            </div>
                            <div class="form-group">
                                <label  class="pr-1  form-control-label">+&emsp;&emsp;<i class="fas fa-suitcase"></i> Total  &emsp;&emsp;= </label>
                                <label  class="pr-1  form-control-label">&emsp;@{{ totalcaja }}</label>
                            </div>
                        </div>

                        <div class="card-header">
                            <h4 style="color: #007bff">Fondo en caja</h4>
                        </div>

                        <div class="card-body">
                            <div class="form-horizontal">
                                <div class="row form-group">
                                    <div class="col col-md-4">
                                        <label for="text-input" class=" form-control-label"><i class="fas fa-money-bill-alt"></i> Efectivo</label>
                                    </div>
                                    <div class="col-5 col-md-7">
                                        <input type="number" min="0" disabled class="form-control form-control-sm" :value="efectivocaja">
                                    </div>
                                </div>
                            </div>
                            <div class="form-horizontal">
                                <div class="row form-group">
                                    <div class="col col-md-4">
                                        <label for="text-input" class=" form-control-label"><i class="fas fa-credit-card"></i> Tarjeta</label>
                                    </div>
                                    <div class="col-4 col-md-6">
                                        <input type="number" min="0" disabled :value="cajatarjeta" class="form-control form-control-sm">
                                    </div>
                                    <div class="col-5 col-md-2">
                                        <button disabled class="btn btn-dark btn-sm">...</button>
                                    </div>
                                </div>
                            </div>
                            <div class="form-horizontal">
                                <div class="row form-group">
                                    <div class="col col-md-4">
                                        <label for="text-input" class=" form-control-label">Deposito</label>
                                    </div>
                                    <div class="col-5 col-md-7">
                                        <input type="number" min="0" v-model="deposito" class="form-control form-control-sm">
                                    </div>
                                </div>
                            </div>
                            <div class="form-horizontal">
                                <div class="row form-group">
                                    <div class="col col-md-4">
                                        <label for="text-input" class=" form-control-label">Egresos</label>
                                    </div>
                                    <div class="col-5 col-md-7">
                                        <input type="number" min="0" v-model="egresos" class="form-control form-control-sm">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="pr-1  form-control-label"><i class="fas fa-suitcase"></i> Total Cuadre</label>
                                <label class="pr-1  form-control-label">= </label>
                                <label v-if="totalcuadre == cajatarjeta" class="pr-1  form-control-label">0</label>
                                <label v-else class="pr-1  form-control-label">@{{ totalcuadre }}</label>
                            </div>
                            <div class="form-group" v-if="sobrantecaja == 0">
                                <label class="pr-1  form-control-label"><i class="fas fa-briefcase"></i> Caja Cuadrada</label>
                                <label class="pr-1  form-control-label">:</label>
                                <label class="pr-1  form-control-label" style="color: green"> @{{ sobrantecaja }}</label>
                            </div>
                            <div class="form-group" v-else-if="sobrantecaja < 0">
                                <label class="pr-1  form-control-label">Faltante</label>
                                <label class="pr-1  form-control-label">:</label>
                                <label class="pr-1  form-control-label" style="color: red"><strong>@{{ sobrantecaja }}</strong></label>
                            </div>
                            <div class="form-group" v-else-if="sobrantecaja > 0">
                                <label class="pr-1  form-control-label"><i class="fas fa-briefcase"></i><i class="fas fa-briefcase"></i> Sobrante en caja</label>
                                <label class="pr-1  form-control-label">:</label>
                                <label  class="pr-1  form-control-label" style="color: orange"> @{{ sobrantecaja }}</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div v-else class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <strong style="color: #007bff">Caja</strong>
                    <button v-if="nose != 'Abierta'" @click="confimar()" class="btn btn-warning btn-sm pull-right"  type="button"><i class="fas fa-lock">&nbsp; Cuadrar Caja</i></button>
                    <button v-else class="btn btn-warning btn-sm pull-right" disabled type="button"><i class="fas fa-lock">&nbsp; Cuadrar Caja</i></button>
                </div>
                <div class="card-body">

                    <div class="row" v-if="nose != 'Abierta'">
                        <div class="col-md-3">
                            <strong>Cierre de caja:</strong> No.1
                        </div>
                        <div class="col-md-3">
                            <strong>Fecha:</strong> @{{ caja[0].fecha_apertura }}
                        </div>
                        <div class="col-md-6">
                            <strong>Hora de Apertura: </strong> @{{ caja[0].hora_apertura }} - <strong>Hora de Cierre</strong> @{{ caja[0].fecha_cierre }}
                        </div>
                        <br>
                        <div class="col-md-3">
                            <strong>Usuario:</strong> @{{ caja[0].usuario }}
                        </div>
                        <div class="col-md-2">
                            <strong>Caja:</strong> 1
                        </div>
                        <div class="col-md-3">
                            <strong>Almacen:</strong> General
                        </div>
                        <div class="col-md-3">
                            <strong>Total de Ventas:</strong> @{{ caja[0].total_venta }}  - @{{ caja[0].total_cierre }}
                        </div>
                        <div class="col-md-3">
                            <strong>Total de Apertura:</strong> @{{ caja[0].valor_apertura }}
                        </div>
                    </div>
                    <h3 v-else style="color:red;"  class="text-center"> Para poder cuadrar la caja es necesario cerrarla </h3>
                </div>
            </div>
            <div class="row" v-if="nose != 'Abierta'">
                <div class="col-lg-4">
                    <div class="card" style="height: 600px">
                        <div class="card-header"><strong style="color: #007bff">Billetes</strong></div>
                        <div class="card-body">
                            <table class="table table-hover table-sm">
                                <thead>
                                <tr>
                                    <th scope="col">Billetes</th>
                                    <th scope="col" class="text-center">Cantidad</th>
                                    <th scope="col">Total</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <th scope="row">2000</th>
                                    <td class="text-center">
                                        <div class="col col-sm-8 ">
                                            <input type="number" min="0" v-model="dosk" class="form-control">
                                        </div>
                                    </td>
                                    <td>@{{ dosktotal }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">1000</th>
                                    <td class="text-center">
                                        <div class="col col-sm-8">
                                            <input type="number" min="0" v-model="unok" class="form-control">
                                        </div>
                                    </td>
                                    <td>@{{ unoktotal }}</td>

                                </tr>
                                <tr>
                                    <th scope="row">500</th>
                                    <td class="text-center">
                                        <div class="col col-sm-8">
                                            <input type="number" min="0" v-model="quinientos" class="form-control">
                                        </div>
                                    </td>
                                    <td>@{{ quinientostotal }}</td>

                                </tr>
                                <tr>
                                    <th scope="row">200</th>
                                    <td class="text-center">
                                        <div class="col col-sm-8">
                                            <input type="number" min="0" v-model="dociento" class="form-control">
                                        </div>
                                    </td>
                                    <td>@{{ docientototal }}</td>

                                </tr>
                                <tr>
                                    <th scope="row">100</th>
                                    <td class="text-center">
                                        <div class="col col-sm-8">
                                            <input type="number" min="0" v-model="cien" class="form-control">
                                        </div>
                                    </td>
                                    <td>@{{ cientotal }}</td>

                                </tr>
                                <tr>
                                    <th scope="row">50</th>
                                    <td class="text-center">
                                        <div class="col col-sm-8">
                                            <input type="number" min="0" v-model="cincuenta" class="form-control">
                                        </div>
                                    </td>
                                    <td>@{{ cincuentatotal }}</td>

                                </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card" style="height: 600px">
                        <div class="card-header"><strong style="color: #007bff">Monedas</strong></div>
                        <div class="card-body">
                            <table class="table table-hover table-responsive table-sm">
                                <thead>
                                <tr>
                                    <th scope="col">Monedas</th>
                                    <th scope="col" class="text-center">Cantidad</th>
                                    <th scope="col">Total</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <th scope="row">25</th>
                                    <td class="text-center">
                                        <div class="col ">
                                            <input type="number" min="0" v-model="veinticinco" class="form-control">
                                        </div>
                                    </td>
                                    <td>@{{ ventecincototal }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">10</th>
                                    <td class="text-center">
                                        <div class="col">
                                            <input type="number" min="0" v-model="diez" class="form-control">
                                        </div>
                                    </td>
                                    <td>@{{ dieztotal }}</td>

                                </tr>
                                <tr>
                                    <th scope="row">5</th>
                                    <td class="text-center">
                                        <div class="col">
                                            <input type="number" min="0" v-model="cinco" class="form-control">
                                        </div>
                                    </td>
                                    <td>@{{ cincototal }}</td>

                                </tr>
                                <tr>
                                    <th scope="row">1</th>
                                    <td class="text-center">
                                        <div class="col">
                                            <input type="number" min="0"  v-model="uno" class="form-control">
                                        </div>
                                    </td>
                                    <td>@{{ unototal }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card" style="height: 600px">
                        <div class="card-header">
                            <strong style="color: #007bff">Cuadre segun ventas</strong>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label  class="pr-1  form-control-label"> +&emsp;&emsp;<i class="fas fa-money-bill-alt"></i> Efectivo &emsp;= </label>
                                <label  class="pr-1  form-control-label">&emsp;@{{ cajaefectivo }}</label>
                            </div>
                            <div class="form-group">
                                <label class="pr-1  form-control-label">+&emsp;&emsp;<i class="fas fa-credit-card"></i> Tarjeta  &emsp;&nbsp;= </label>
                                <label class="pr-1  form-control-label">&emsp;@{{ cajatarjeta }}</label>
                            </div>
                            <div class="form-group">
                                <label  class="pr-1  form-control-label">+&emsp;&emsp;<i class="fas fa-suitcase"></i> Total  &emsp;&emsp;= </label>
                                <label  class="pr-1  form-control-label">&emsp;@{{ totalcaja }}</label>
                            </div>
                        </div>

                        <div class="card-header">
                            <h4 style="color: #007bff">Fondo en caja</h4>
                        </div>

                        <div class="card-body">
                            <div class="form-horizontal">
                                <div class="row form-group">
                                    <div class="col col-md-4">
                                        <label for="text-input" class=" form-control-label"><i class="fas fa-money-bill-alt"></i> Efectivo</label>
                                    </div>
                                    <div class="col-5 col-md-7">
                                        <input type="number" min="0" disabled class="form-control form-control-sm" :value="efectivocaja">
                                    </div>
                                </div>
                            </div>
                            <div class="form-horizontal">
                                <div class="row form-group">
                                    <div class="col col-md-4">
                                        <label for="text-input" class=" form-control-label"><i class="fas fa-credit-card"></i> Tarjeta</label>
                                    </div>
                                    <div class="col-4 col-md-6">
                                        <input type="number" min="0" disabled :value="cajatarjeta" class="form-control form-control-sm">
                                    </div>
                                    <div class="col-5 col-md-2">
                                        <button disabled class="btn btn-dark btn-sm">...</button>
                                    </div>
                                </div>
                            </div>
                            <div class="form-horizontal">
                                <div class="row form-group">
                                    <div class="col col-md-4">
                                        <label for="text-input" class=" form-control-label">Deposito</label>
                                    </div>
                                    <div class="col-5 col-md-7">
                                        <input type="number" min="0" v-model="deposito" class="form-control form-control-sm">
                                    </div>
                                </div>
                            </div>
                            <div class="form-horizontal">
                                <div class="row form-group">
                                    <div class="col col-md-4">
                                        <label for="text-input" class=" form-control-label">Egresos</label>
                                    </div>
                                    <div class="col-5 col-md-7">
                                        <input type="number" min="0" v-model="egresos" class="form-control form-control-sm">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="pr-1  form-control-label"><i class="fas fa-suitcase"></i> Total Cuadre</label>
                                <label class="pr-1  form-control-label">= </label>
                                <label v-if="totalcuadre == cajatarjeta" class="pr-1  form-control-label">0</label>
                                <label v-else class="pr-1  form-control-label">@{{ totalcuadre }}</label>
                            </div>
                            <div class="form-group" v-if="sobrantecaja == 0">
                                <label class="pr-1  form-control-label"><i class="fas fa-briefcase"></i> Caja Cuadrada</label>
                                <label class="pr-1  form-control-label">:</label>
                                <label class="pr-1  form-control-label" style="color: green"> @{{ sobrantecaja }}</label>
                            </div>
                            <div class="form-group" v-else-if="sobrantecaja < 0">
                                <label class="pr-1  form-control-label">Faltante</label>
                                <label class="pr-1  form-control-label">:</label>
                                <label class="pr-1  form-control-label" style="color: red"><strong>@{{ sobrantecaja }}</strong></label>
                            </div>
                            <div class="form-group" v-else-if="sobrantecaja > 0">
                                <label class="pr-1  form-control-label"><i class="fas fa-briefcase"></i><i class="fas fa-briefcase"></i> Sobrante en caja</label>
                                <label class="pr-1  form-control-label">:</label>
                                <label  class="pr-1  form-control-label" style="color: orange"> @{{ sobrantecaja }}</label>
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
        var cajatotal = '{!! $total !!}';
        var cajaefectivo = '{!! $total_efectivo !!}';
        var cajatarjeta = '{!! $total_tarjeta !!}';
        var fecha = '{!! $fecha !!}';
        var caja = JSON.parse('{!! $caja !!}');
        var nose = '{!! $nose !!}';

        function toObject(arr) {
            var rv = {};
            for (var i = 0; i < arr.length; ++i)
                rv[arr[i].id] = arr[i];
            return rv;
        }

    </script>
    <script !src="">
        new Vue({
            el: '#Vue',
            data:{
                nose: nose,
                deposito:0,
                egresos:0,
                caja: Object.values(caja),
                dosk:0,
                unok:0,
                quinientos:0,
                dociento:0,
                cien: 0,
                cincuenta: 0,
                veinticinco: 0,
                diez:0,
                cinco:0,
                uno:0,
                fecha: fecha,
                totalcaja: cajatotal,
                cajaefectivo: cajaefectivo,
                cajatarjeta: cajatarjeta
            },
            methods:{
                //Cuadrar caja
                confimar: function (){
                    var txt;
                    var r = confirm("Estas Seguro que quieres cuadrar la caja?");
                    if (r == true){
                        txt = this.cuadrar();
                    }
                },

                cuadrar:function () {

                    if (this.sobrantecaja < 0){
                        toastr.warning('No puedo cuadrar la caja, Hay un descuadre!!');
                    }else{
                        $.ajax({
                            url: '/caja/cuadrarcaja',
                            method: 'GET',
                            data: {
                                caja:       this.caja,
                                fecha:      this.fecha,
                                totalcaja:  this.totalcaja,

                                encaja:{
                                    segunsistema:{
                                        efectivo:this.cajaefectivo,
                                        tarjeta:this.cajatarjeta,
                                        total: this.totalcaja
                                    },
                                    efectivocaja: this.efectivocaja,
                                    cajatarjeta: this.cajatarjeta,
                                    deposito:   this.deposito,
                                    egresos:    this.egresos,
                                    desglose:{
                                        billetes:{
                                            dosmil:       this.dosk,
                                            mil:       this.unok,
                                            quinientos: this.quinientos,
                                            dociento:   this.dociento,
                                            cien:       this.cien,
                                            cincuenta:  this.cincuenta,
                                        },
                                        monedas:{
                                            veinticinco:this.veinticinco,
                                            diez:       this.diez,
                                            cinco:      this.cinco,
                                            uno:        this.uno,
                                        }
                                    }
                                }

                            },
                            success:function (dato) {
                                toastr.success('La caja ha sido Cuadrada');
                                setTimeout('document.location.reload()',1500);
                            },
                            error:function () {
                                toastr.error('Ha ocurrido un error en el cuadre');
                                setTimeout('document.location.reload()',1500);
                            }
                        });

                    }

                }

            },
            computed:{
                //Billetes
                dosktotal:function () {
                    var total = parseFloat(this.dosk ) * 2000
                    return total;
                },
                unoktotal:function () {
                    var total = parseFloat(this.unok) * 1000
                    return total;
                },
                quinientostotal: function () {
                    var total = parseFloat(this.quinientos) * 500
                    return total;
                },
                docientototal: function () {
                    var total = parseFloat(this.dociento) * 200
                    return total;
                },
                cientotal:function () {
                    var total = parseFloat(this.cien) * 100
                    return total;
                },
                cincuentatotal:function () {
                    var total = parseFloat(this.cincuenta) * 50
                    return total;
                },
                // Monedas

                ventecincototal:function () {
                    var total = parseFloat(this.veinticinco) * 25
                    return total;
                },
                dieztotal:function () {
                    var total = parseFloat(this.diez) * 10
                    return total;
                },
                cincototal:function () {
                    var total = parseFloat(this.cinco) * 5
                    return total;
                },
                unototal:function () {
                    var total = parseFloat(this.uno) * 1
                    return total;
                },

                // Dinero en caja
                efectivocaja:function () {
                    var total =
                        parseFloat(this.dosktotal) +
                        parseFloat(this.unoktotal) +
                        parseFloat(this.quinientostotal) +
                        parseFloat(this.docientototal) +
                        parseFloat(this.cientotal) +
                        parseFloat(this.cincuentatotal) +
                        parseFloat(this.ventecincototal) +
                        parseFloat(this.dieztotal) +
                        parseFloat(this.cincototal) +
                        parseFloat(this.unototal)
                    return total;
                },
                totalcuadre:function () {
                    var total = parseFloat(this.efectivocaja) + parseFloat(this.cajatarjeta) + parseFloat(this.egresos) + parseFloat(this.deposito)
                    return total;
                },
                sobrantecaja:function () {
                    var total = parseFloat(this.totalcuadre) - parseFloat(this.totalcaja);
                    return total;
                }
            }
        });
    </script>
@endsection

