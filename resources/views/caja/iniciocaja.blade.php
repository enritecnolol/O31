@extends('main.app')
@section('tittle','Cafeteria | Apertura de Caja')


@section('aside')
    @include('caja.siderbar')
@endsection


@section('content')
    <div class="text-center" style="margin-bottom: 25px">
        <h1>Apertura de Caja</h1>
    </div>
    <div class="section__content section__content--p30" >
        <div class="container-fluid">
            <div class="row">
                <div class="card" style="width: 100%;" v-if="cerrada == '' && cuadre == ''">
                    <div class="card-header">
                        <strong>Apertura de Caja</strong>
                    </div>
                    <div class="card-body">
                        <form action="" method="POST">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="row form-group">
                                <div class="col col-md-3">
                                    <label for="" class=" form-control-label">Fecha</label>
                                </div>
                                <div class="col-12 col-md-6">
                                    <input type="text" name="fecha" placeholder="" v-model="fecha" disabled class="form-control">
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col col-md-3">
                                    <label for="" class=" form-control-label">Almacen</label>
                                </div>
                                <div class="col-12 col-md-6">
                                    <input type="text" id="" name="almacen" placeholder="" value="general" disabled class="form-control">
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col col-md-3">
                                    <label for="" class=" form-control-label">Valor Apertura</label>
                                </div>
                                <div class="col-12 col-md-6">
                                    <input type="number" name="valor_apertura" v-on:keyup.enter="abrircaja()" placeholder="" min="0" value="0"  class="form-control" required v-model="valortotal" title="El numero tiene que se mayor a 0">
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col col-md-3">
                                    <label for="" class=" form-control-label">Total</label>
                                </div>
                                <div class="col-12 col-md-6">
                                    <input type="number" name="total" v-model="total" placeholder="" value="0" disabled class="form-control">
                                </div>
                            </div>

                            <div class="text-center" style="margin-top: 40px">
                                <button type="button" @click="abrircaja()" class="btn btn-success">
                                    <i class="fas fa-lock-open"></i>&nbsp; Guardar
                                </button>
                            </div>


                        </form>
                    </div>
                </div>

                <div class="card" style="width: 100%;" v-else-if="cerrada == 'C' && cuadre == 'Si'">
                    <div class="card-header">
                        <strong>Apertura de Caja</strong>
                    </div>
                    <div class="card-body">
                        <form action="" method="POST">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="row form-group">
                                <div class="col col-md-3">
                                    <label for="" class=" form-control-label">Fecha</label>
                                </div>
                                <div class="col-12 col-md-6">
                                    <input type="text" name="fecha" placeholder="" v-model="fecha" disabled class="form-control">
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col col-md-3">
                                    <label for="" class=" form-control-label">Almacen</label>
                                </div>
                                <div class="col-12 col-md-6">
                                    <input type="text" id="" name="almacen" placeholder="" value="general" disabled class="form-control">
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col col-md-3">
                                    <label for="" class=" form-control-label">Valor Apertura</label>
                                </div>
                                <div class="col-12 col-md-6">
                                    <input type="number" name="valor_apertura" v-on:keyup.enter="abrircaja()" placeholder="" min="0" value="0"  class="form-control" required v-model="valortotal" title="El numero tiene que se mayor a 0">
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col col-md-3">
                                    <label for="" class=" form-control-label">Total</label>
                                </div>
                                <div class="col-12 col-md-6">
                                    <input type="number" name="total" v-model="total" placeholder="" value="0" disabled class="form-control">
                                </div>
                            </div>

                            <div class="text-center" style="margin-top: 40px">
                                <button type="button" @click="abrircaja()" class="btn btn-success">
                                    <i class="fas fa-lock-open"></i>&nbsp; Guardar
                                </button>
                            </div>


                        </form>
                    </div>
                </div>

                <div class="card" style="width: 100%;" v-else-if="cerrada == 'C' && cuadre == 'No'">
                    <div class="card-header">
                        <strong>Apertura de Caja</strong>
                    </div>
                    <div class="card-body">
                        <form action="" method="POST">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="row form-group">
                                <div class="col col-md-3">
                                    <label for="" class=" form-control-label">Fecha</label>
                                </div>
                                <div class="col-12 col-md-6">
                                    <input type="text" name="fecha" placeholder="" v-model="fecha" disabled class="form-control">
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col col-md-3">
                                    <label for="" class=" form-control-label">Almacen</label>
                                </div>
                                <div class="col-12 col-md-6">
                                    <input type="text" id="" name="almacen" placeholder="" value="general" disabled class="form-control">
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col col-md-3">
                                    <label for="" class=" form-control-label">Valor Apertura</label>
                                </div>
                                <div class="col-12 col-md-6">
                                    <input type="number" name="valor_apertura" v-on:keyup.enter="abrircaja()" placeholder="" min="0" value="0"  class="form-control" required v-model="valortotal" title="El numero tiene que se mayor a 0">
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col col-md-3">
                                    <label for="" class=" form-control-label">Total</label>
                                </div>
                                <div class="col-12 col-md-6">
                                    <input type="number" name="total" v-model="total" placeholder="" value="0" disabled class="form-control">
                                </div>
                            </div>

                            <div class="text-center" style="margin-top: 40px">
                                <button type="button" @click="abrircaja()" class="btn btn-success">
                                    <i class="fas fa-lock-open"></i>&nbsp; Guardar
                                </button>
                            </div>


                        </form>
                    </div>
                </div>

                <div class="card" style="width: 100%;" v-else-if="cerrada == 'A' && cuadre == 'No'">
                    <div class="card-header">
                        <strong>Apertura de Caja</strong>
                    </div>
                    <div class="card-body text-center">
                        <h1 style="margin: 10%">La caja ya esta <span style="color: green">Abierta</span></h1>
                    </div>
                </div>

                <div class="card" style="width: 100%;" v-else>
                    <div class="card-header">
                        <strong>Apertura de Caja</strong>
                    </div>
                    <div class="card-body">
                        <form action="" method="POST">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="row form-group">
                                <div class="col col-md-3">
                                    <label for="" class=" form-control-label">Fecha</label>
                                </div>
                                <div class="col-12 col-md-6">
                                    <input type="text" name="fecha" placeholder="" v-model="fecha" disabled class="form-control">
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col col-md-3">
                                    <label for="" class=" form-control-label">Almacen</label>
                                </div>
                                <div class="col-12 col-md-6">
                                    <input type="text" id="" name="almacen" placeholder="" value="general" disabled class="form-control">
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col col-md-3">
                                    <label for="" class=" form-control-label">Valor Apertura</label>
                                </div>
                                <div class="col-12 col-md-6">
                                    <input type="number" name="valor_apertura" v-on:keyup.enter="abrircaja()" placeholder="" min="0" value="0"  class="form-control" required v-model="valortotal" title="El numero tiene que se mayor a 0">
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col col-md-3">
                                    <label for="" class=" form-control-label">Total</label>
                                </div>
                                <div class="col-12 col-md-6">
                                    <input type="number" name="total" v-model="total" placeholder="" value="0" disabled class="form-control">
                                </div>
                            </div>

                            <div class="text-center" style="margin-top: 40px">
                                <button type="button" @click="abrircaja()" class="btn btn-success">
                                    <i class="fas fa-lock-open"></i>&nbsp; Guardar
                                </button>
                            </div>


                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('scriptp')
    <script>
        var hoy = new Date();
        var fecha = hoy.getDate() + '-' + (hoy.getMonth()+1) + '-' + hoy.getFullYear();

        new Vue({
            el: '#Vue',
            data:{
                cuadre:'{!! $cuadre !!}',
                cerrada: '{!! $cerrad !!}' ,
                caja: '{!! $fecha!!}',
                fecha: fecha,
                valortotal: 0,
                total: 0,
                onetime:1
            },
            watch:{
                valortotal: function (valor) {
                    this.total = valor
                }
            },
            methods:{

                abrircaja:function () {
                    if (this.valortotal < 0 ){
                        alert('No puede en pesar debiendo')
                    }else {
                        if (this.onetime == 1){
                            this.onetime = 2;
                            $.ajax({
                                url: '/caja/apertura',
                                method: 'GET',
                                data: {
                                    fecha: this.fecha,
                                    valortotal:this.valortotal,
                                    total: this.total,
                                },
                                success:function (dato) {
                                    toastr.success('Hemos hecho la Apertura de la Caja');
                                    location.reload();

                                },
                                error:function (dato) {
                                    toastr.error('Ha ocurrido un error')
                                }

                            });
                        }
                    }

                }
            }

        });
    </script>
@endsection