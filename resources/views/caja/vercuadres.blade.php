@extends('main.app')
@section('tittle','SofiaRD | Ver Cuadres')
@section('titulo')
    <h3 style="color: white"><i class="fas fa-dollar-sign"></i> Ver Cuadres</h3>
@endsection

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
                <a class="navbar-brand" href="#" style="color: whitesmoke"><i class="fas fa-clipboard-list"></i> Historial de Cuadres</a>
                <input v-if="cuadres == ''" disabled type="search" class="form-control col-md-3 "  placeholder="Buscar..." name="" >
                <input v-else type="date" class="form-control col-md-3" id="datepicker" v-model="buscador"  v-on:input.self="busquedacuadres(buscador)" placeholder="Buscar..." name="" >
            </nav>


            {{--<template v-if="cuadres == ''">--}}
            {{--<div class="card">--}}
            {{--<div class="card-header">--}}
            {{--<Strong>Historial de Ventas</Strong>--}}
            {{--</div>--}}
            {{--<div class="card-body">--}}
            {{--<div class="text-center" style="margin-top: 10%;margin-bottom: 10%">--}}
            {{--<h2>Presiona el boton para ver el Historial de Cuadres</h2>--}}
            {{--</div>--}}
            {{--<div class="text-center">--}}

            {{--<button type="button" @click="cargarcuadres()" class="btn btn-lg btn-outline-success">Ver</button>--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--</template>--}}

            <template>
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive m-b-40" style="height: 600px;overflow-y: auto;overflow-x: hidden">
                            <table class="table table-sm table-hover">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th>fecha apertura</th>
                                    <th>fecha cierre</th>
                                    <th style="text-align: right">total cierre</th>
                                    <th style="text-align: right">Valor apertura</th>
                                    <th>Total venta</th>
                                    <th>cuadrada?</th>
                                    <th></th>

                                </tr>
                                </thead>
                                <tbody>
                                <template v-if="cuadresbuscadas == ''">
                                    <tr v-for="v in cuadres">
                                        <td>@{{ v.id }}</td>
                                        <td>@{{ v.fecha_apertura }}</td>
                                        <td>@{{ v.fecha_cierre }}</td>
                                        <td style="text-align: right">@{{ format2(v.total_cierre, '') }}</td>
                                        <td style="text-align: right">@{{ format2(v.valor_apertura, '') }}</td>
                                        <td>@{{ v.total_venta }}</td>
                                        <td v-if="v.cuadreconf === 'Si'"><span class="badge badge-info">@{{ v.cuadreconf }}</span></td>
                                        <td v-else><span class="badge badge-danger">@{{ v.cuadreconf }}</span></td>

                                        <td><button v-if="v.cuadreconf ==='Si'" type="button" @click="desglose(v.id)" class="btn btn-light">Ver Desglose</button></td>
                                        {{--<td><button v-else type="button" disabled class="btn btn-light">Ver Desglose</button></td>--}}
                                    </tr>
                                </template>
                                <template v-else>
                                    <tr v-for="v in cuadresbuscadas">
                                        <td>@{{ v.id }}</td>
                                        <td>@{{ v.fecha_apertura }}</td>
                                        <td>@{{ v.fecha_cierre }}</td>
                                        <td>@{{ format2(v.total_cierre, '') }}</td>
                                        <td>@{{ format2(v.valor_apertura, '') }}</td>
                                        <td>@{{ v.total_venta }}</td>
                                        <td v-if="v.cuadreconf === 'Si'"><span class="badge badge-info">@{{ v.cuadreconf }}</span></td>
                                        <td v-else><span class="badge badge-danger">@{{ v.cuadreconf }}</span></td>

                                        <td><button v-if="v.cuadreconf =='Si'" type="button" @click="desglose(v.id)" class="btn btn-light">Ver Desglose</button></td>
                                        {{--<td><button v-else type="button" disabled class="btn btn-light">Ver Desglose</button></td>--}}
                                    </tr>
                                </template>
                                </tbody>
                                <thead>
                                <tr>
                                    <th></th>
                                    <th>fecha apertura</th>
                                    <th>fecha cierre</th>
                                    <th>total cierre</th>
                                    <th>Valor apertura</th>
                                    <th>Total venta</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>


@endsection

@section('scriptp')

    <script !src="">

        new Vue({
            el: '#Vue',
            data() {
                return{
                    cuadres:[],
                    loading: false,
                    buscador:'',
                    cuadresbuscadas:[],
                }
            },
            mounted(){
                _this = this;
                _this.cargarcuadres();
            },
            created: function () {
                _this = this;
                _this.cargarcuadres();
            },
            methods:{
                format2(n, currency) {
                    return currency + n.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
                },
                cargarcuadres:function () {
                    this.loading = true;
                    _this = this;
                    axios.post('/caja/cuadres')

                        .then(function (response) {

                            _this.loading = false;
                            _this.cuadres = response.data;
                        })
                        .catch(function (error) {
                            // handle error
                            console.log(error);
                        })
                        .then(function () {
                            // always executed
                        });
                },

                busquedacuadres:function () {
                    // this.loading = true;
                    _this = this;
                    axios.post('/caja/cuadres/ver',
                        {
                            fecha: _this.buscador,

                        })

                        .then(function (response) {
                            // _this.loading = false;
                            _this.cuadresbuscadas = response.data;
                        })
                        .catch(function (error) {

                            console.log(error);
                        })
                        .then(function () {
                            // always executed
                        });
                },
                desglose:function (id) {

                    window.open('/formato/cuadre/'+id);
                }
            }



        })

    </script>

@endsection
