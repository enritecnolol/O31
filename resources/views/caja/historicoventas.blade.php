@extends('main.app')
@section('style')
    <style>
        .loader {
            font-size: 10px;
            margin: 30% auto;
            text-indent: -9999em;
            width: 11em;
            height: 11em;
            border-radius: 50%;
            background: #0062cc;
            background: -moz-linear-gradient(left, #ffffff 10%, rgba(255, 255, 255, 0) 42%);
            background: -webkit-linear-gradient(left, #ffffff 10%, rgba(255, 255, 255, 0) 42%);
            background: -o-linear-gradient(left, #ffffff 10%, rgba(255, 255, 255, 0) 42%);
            background: -ms-linear-gradient(left, #ffffff 10%, rgba(255, 255, 255, 0) 42%);
            background: linear-gradient(to right, #ffffff 10%, rgba(255, 255, 255, 0) 42%);
            position: relative;
            -webkit-animation: load3 1.4s infinite linear;
            animation: load3 1.4s infinite linear;
        }
        .loader:before {
            width: 50%;
            height: 50%;
            background: #0062cc;
            border-radius: 100% 0 0 0;
            position: absolute;
            top: 0;
            left: 0;
            content: '';
        }
        .loader:after {
            background: #0dcecb;
            width: 75%;
            height: 75%;
            border-radius: 50%;
            content: '';
            margin: auto;
            position: absolute;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
        }
        @-webkit-keyframes load3 {
            0% {
                -webkit-transform: rotate(0deg);
                transform: rotate(0deg);
            }
            100% {
                -webkit-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }
        @keyframes load3 {
            0% {
                -webkit-transform: rotate(0deg);
                transform: rotate(0deg);
            }
            100% {
                -webkit-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }
    </style>
@endsection
@section('tittle','Cafeteria | Historico de Venta')


@section('aside')
    @include('caja.siderbar')
@endsection

@section('content')

    <div class="container">
        <div class="container" v-if="loading == true">
            <div class="loader">Loading...</div>
        </div>
        <div v-else>
            <nav class="navbar navbar-light" style="background-color: #0069d9;">
                <a class="navbar-brand" href="#" style="color: whitesmoke"><i class="fas fa-clipboard-list"></i> Historial de Ventas</a>
                <input v-if="ventas == ''" disabled type="search" class="form-control col-md-3 "  placeholder="Buscar..." name="" >
                <input v-else-if="ventas == 'no ventas'" disabled type="search" class="form-control col-md-3 "  placeholder="Buscar..." name="" >
                <input v-else type="date" class="form-control col-md-3" id="datepicker" v-model="buscador"  v-on:input.self="ventasbusc(buscador)" placeholder="Buscar..." name="" >
            </nav>


            <template v-if="ventas == ''">
                <div class="card">
                    <div class="card-header">
                        <Strong>Historial de Ventas</Strong>
                    </div>
                    <div class="card-body">
                        <div class="text-center" style="margin-top: 10%;margin-bottom: 10%">
                            <h2>Presiona el boton para ver el historial de ventas</h2>
                        </div>
                        <div class="text-center">

                            <button type="button" @click="cargarventas()" class="btn btn-lg btn-outline-success">Ver</button>
                        </div>
                    </div>
                </div>
            </template>
            <template v-else-if="ventas == 'no ventas'">
                <div class="card">
                    <div class="card-header">
                        <Strong>Historial de Ventas</Strong>
                    </div>
                    <div class="card-body">
                        <div class="text-center" style="margin-top: 10%;margin-bottom: 10%">
                            <h2>No se ha realizado ninguna venta</h2>
                        </div>h
                    </div>
                </div>
            </template>

            <template v-else>
                <div class="table-responsive m-b-40">
                    <table class="table table-borderless table-data3">
                        <thead>
                        <tr>
                            <th></th>
                            <th>Caja</th>
                            <th>Cliente</th>
                            <th>Monto Efectivo</th>
                            <th>Monto Tarjeta</th>
                            <th>Total Factura</th>
                            <th>Estado</th>
                            <th>Fecha</th>
                        </tr>
                        </thead>
                        <tbody>
                        <template v-if="ventasbuscadas == ''">
                            <tr v-for="v in ventas">
                                <td>@{{ v.id }}</td>
                                <td>@{{ v.box }}</td>
                                <td>@{{ v.client }}</td>
                                <td>@{{ v.Monto_efectivo }}</td>
                                <td>@{{ v.Monto_tarjeta }}</td>
                                <td>@{{ v.total_facture }}</td>
                                <td>@{{ v.status }}</td>
                                <td>@{{  v.date }}</td>
                            </tr>
                        </template>
                        <template v-else>
                            <tr v-for="v in ventasbuscadas">
                                <td>@{{ v.id }}</td>
                                <td>@{{ v.box }}</td>
                                <td>@{{ v.client }}</td>
                                <td>@{{ v.Monto_efectivo }}</td>
                                <td>@{{ v.Monto_tarjeta }}</td>
                                <td>@{{ v.total_facture }}</td>
                                <td>@{{ v.status }}</td>
                                <td>@{{ v.date }}</td>
                            </tr>
                        </template>
                        </tbody>
                        <thead>
                        <tr>
                            <th></th>
                            <th>Caja</th>
                            <th>Cliente</th>
                            <th>Monto Efectivo</th>
                            <th>Monto Tarjeta</th>
                            <th>Total Factura</th>
                            <th>Estado</th>
                            <th>Fecha</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </template>
        </div>

    </div>

@endsection

@section('scriptp')
    <script !src="">
        $( document ).ready(function() {

            $('#datepicker').datepicker({format: 'mm-dd-yyyy'});
        });
    </script>

    <script !src="">

        new Vue({
            el: '#app',
            data() {
                return{
                    ventas:[],
                    loading: false,
                    buscador:'',
                    ventasbuscadas:[],
                }
            },
            methods:{
                cargarventas:function () {
                    this.loading = true;
                    _this = this;
                    axios.post('/historico/venta')

                        .then(function (response) {

                            _this.loading = false;
                            _this.ventas = response.data;
                        })
                        .catch(function (error) {
                            // handle error
                            console.log(error);
                        })
                        .then(function () {
                            // always executed
                        });
                },

                ventasbusc:function () {
                    // this.loading = true;
                    _this = this;
                    axios.post('/historico/venta/busqueda',
                        {
                            fecha: _this.buscador,

                        })

                        .then(function (response) {
                            // _this.loading = false;
                            _this.ventasbuscadas = response.data;
                        })
                        .catch(function (error) {

                            console.log(error);
                        })
                        .then(function () {
                            // always executed
                        });
                }
            }



        })

    </script>

@endsection