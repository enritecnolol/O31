@extends('main.app')
@section('tittle','SofiaRD | Tipo de Tarjetas')

@section('titulo')
    <h3 style="color: white"><i class="fas fa-arrow-circle-right"></i> Tipo de Tarjetas</h3>
@endsection

@section('aside')
    @include('caja.siderbar')
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active show" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Crear Tipo de Tarjeta</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Configuracion  de tipo de tarjeta</a>
                            </li>
                            {{--<li class="nav-item">--}}
                                {{--<a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Menu 2</a>--}}
                            {{--</li>--}}
                        </ul>
                        <div class="tab-content pl-3 p-1" id="myTabContent">
                            <div class="tab-pane fade active show" id="home" role="tabpanel" aria-labelledby="home-tab">
                                <div class="container" style="margin-top: 15px">
                                    <div class="row">
                                        <div class="col-lg-12" style="margin-bottom: 20px">
                                            <div class="text-center">
                                                <h3>Crear Tipo de Tarjeta</h3>
                                            </div>
                                        </div>
                                        <div class="col-lg-12" style="margin-bottom: 20px">
                                            <hr style="background: #4272d7;">
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div style="float: left">
                                                        <div class="form-group">
                                                            <label for="company" class=" form-control-label"><strong>Codigo</strong></label>
                                                            <div class="container">
                                                                <div class="row">
                                                                    <input type="text" required v-model="codigotp" min="1" maxlength="4" name="" class="form-control col-sm-3">&nbsp;
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="company" class=" form-control-label"><strong>Nombre<span style="color: red">*</span></strong></label>
                                                            <input type="text"  min="1" name="" required v-model="nombretp" class="form-control ">&nbsp;
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="company" class=" form-control-label"><strong>Estado<span style="color: red">*</span></strong></label>
                                                            <select class="form-control" required v-model="estadotp" id="">
                                                                <option value="1">Activo</option>
                                                                <option value="2">Desactivo</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div style="height: 300px; width: auto;overflow-y: scroll">
                                                        <div class="">
                                                            <h4>Lista de tipos de tarjetas</h4>
                                                        </div>
                                                        <table class="table table-responsive">
                                                            <thead>
                                                            <tr>
                                                                <th scope="col">Codigo</th>
                                                                <th scope="col">Nombre</th>
                                                                <th scope="col">Estado</th>
                                                                <th></th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <template v-if="datostabla != ''">
                                                                <tr style="cursor: pointer" v-for="item in datostabla" @click="editarsettp(item.codigo), editar = true">
                                                                    <td>@{{ item.codigo }}</td>
                                                                    <td>@{{ item.nombre }}</td>
                                                                    <td v-if="item.estado == 1">Activo</td>
                                                                    <td v-else>Desactivado</td>
                                                                    <td><button type="button"  @click="editarsettp(item.codigo), editar = true" class="btn btn-warning btn-sm">
                                                                            <i class="fas fa-edit"></i>
                                                                        </button></td>
                                                                </tr>
                                                            </template>
                                                            <template v-else>
                                                                <tr>
                                                                    <td>Resultado</td>
                                                                    <td>No</td>
                                                                    <td>Encontrado</td>
                                                                    <td></td>
                                                                </tr>
                                                            </template>
                                                            </tbody>
                                                        </table>
                                                        <small style="color: red">Para editar un tipo de tarjeta hacer click en la que desee editar</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <hr style="background: #4272d7;">
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="text-center">
                                                        <button type="button" v-if="editar == ''" @click="guardartipotarjeta" class="btn btn-primary btn-sm">
                                                            <i class="fas fa-save"></i> Guardar
                                                        </button>
                                                        <button type="button" v-else @click="editart" class="btn btn-warning btn-sm">
                                                            <i class="fas fa-edit"></i> Guardar
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <hr style="background: #4272d7;">
                                        </div>
                                        <div class="col-md-12">
                                            <div class="row" style="margin-top: 10px">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="tpselect">Tipo de Tarjeta <span style="color: red">*</span></label>
                                                        <select v-model="idtarjeta" @change="buscardatostarjeta" class="form-control" id="tpselect">
                                                            <option value="">-- Selecciona --</option>
                                                            <template v-for="tp in datostabla">
                                                                <option :value="tp.id">@{{ tp.nombre }}</option>
                                                            </template>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="identf">Identificador <span style="color: red">*</span></label>
                                                        <input type="text" v-model="identificador" class="form-control" id="identf" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="cdtip">Cantidad de digitos <span style="color: red">*</span></label>
                                                        <input type="number" v-model="cantidadd" class="form-control" id="cdtip" placeholder="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6" style="box-shadow:rgb(136, 136, 136) 1px 1px 5px;">
                                            <div class="row">
                                                <div class="col-md-12" style="background: #4272d7">
                                                    <h4 style="float: right;color: white">Generar Puntos</h4>
                                                    <div class="custom-control custom-radio pull-left">
                                                        <input style="color: white" type="radio" name="accion" v-model="accioncheck" value="GPuntos" class="custom-control-input" id="GPcheck">
                                                        <label class="custom-control-label" for="GPcheck" style="color: white">Activar</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-12" v-show="accioncheck == 'GDescuento'">
                                                    <div class="pull-left">
                                                        <span style="font-size: medium;color: red">Deshabilitado</span>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="row" style="margin-top: 20px">
                                                        <div class="col-md-6">
                                                            <div class="custom-control custom-radio pull-left">
                                                                <input style="color: white" v-model="generar" value="generarpuntos" name="GP" :disabled="accioncheck == 'GDescuento'" type="radio" class="custom-control-input" id="puntos">
                                                                <label class="custom-control-label" for="puntos" >Generar Puntos</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="custom-control custom-radio pull-left">
                                                                <input style="color: white" type="radio" v-model="generar"  disabled value="generarporciento" name="GP"  class="custom-control-input" id="porciento">
                                                                <label class="custom-control-label" for="porciento">Generar Porciento</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12" style="box-shadow:rgb(136, 136, 136) 1px 1px 5px;">
                                                    <div class="row" style="margin-top: 15px">
                                                        <div class="col-md-12">
                                                            <div class="custom-control custom-checkbox pull-left">
                                                                <input style="color: white" type="checkbox" checked disabled class="custom-control-input" id="gpmf">
                                                                <label class="custom-control-label" for="gpmf">Generar puntos por monto de las facturas</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="dineropc">Por cada</label>
                                                                <input type="text" v-model="porcada" :disabled="accioncheck == 'GDescuento'" class="form-control form-control-sm" id="dineropc" placeholder="100.00">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="puntosg">generar # puntos</label>
                                                                <input type="text" v-model="generarnumeropuntos" :disabled="accioncheck == 'GDescuento'" class="form-control form-control-sm" id="puntosg" placeholder="0">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="porcientog">porciento</label>
                                                                <input type="text" v-model="porciento" disabled  class="form-control form-control-sm" id="porcientog" placeholder="0">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6" style="box-shadow:rgb(136, 136, 136) 1px 1px 5px;">
                                            <div class="row">
                                                <div class="col-md-12" style="background: #4272d7;box-shadow:rgb(136, 136, 136) 1px 1px 5px;">
                                                    <h4 style="float: right;color: white">Generar Descuento</h4>
                                                    <div class="custom-control custom-radio pull-left">
                                                        <input style="color: white" type="radio" name="accion" v-model="accioncheck" value="GDescuento"  class="custom-control-input" id="GDactivar">
                                                        <label class="custom-control-label" for="GDactivar" style="color: white">Activar</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-12" v-show="accioncheck == 'GPuntos'">
                                                    <div class="pull-left">
                                                        <span style="font-size: medium;color: red">Deshabilitado</span>
                                                    </div>
                                                </div>
                                                <div class="col-md-12" style="margin-top: 15px;">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="custom-control custom-checkbox pull-left">
                                                                <input style="color: white" checked disabled type="checkbox" class="custom-control-input" id="gdf">
                                                                <label class="custom-control-label" for="gdf">Generar descuento fijo:</label>
                                                                <input  style="position: absolute; top: 0; left: 220px;width: 60px" :disabled="accioncheck == 'GPuntos'"  v-model="GenerarDescuento" type="number" class="form-control form-control-sm col-" id="" placeholder="0">
                                                                <label   style="position: absolute; top: 0; left: 285px;width: 60px">%</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <hr style="background: #4272d7;">
                                        </div>
                                        <div class="col-md-12">
                                            <div class="text-center">
                                                <button type="button"  @click="guardarconfig" v-if="editardatostarjeta == false" class="btn btn-success btn-sm">
                                                    <i class="fas fa-save"></i> Guardar
                                                </button>
                                                <button type="button" @click="editardatostarjetas"  v-else class="btn btn-warning btn-sm">
                                                    <i class="fas fa-edit"></i> editar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{--<div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">--}}
                                {{--<h3>Menu 2</h3>--}}
                                {{--<p>Some content here.</p>--}}
                            {{--</div>--}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
            </div>
        </div>
    </div>
@endsection

@section('scriptp')
    <script !src="">
        new Vue({
            el: '#Vue',
            data: {
                idtp:0,
                nombretp:'',
                codigotp:'',
                estadotp:1,
                datostabla:'',
                editar:'',
                accioncheck:'',
                /**/
                idtarjeta:'',
                identificador:'',
                cantidadd:0,
                generar:'',
                porcada:0,
                generarnumeropuntos:0,
                porciento:0,
                GenerarDescuento:0,
                datostarjeta:'',
                editardatostarjeta: false,
                iddatostj:0,
            },
            mounted(){
                _this = this;
                _this.cargartablatp();
            },
            watch:{

            },
            methods:{
                guardartipotarjeta:function () {
                    _this = this;

                    axios.post('/tipo/tarjeta/store', {
                        nombre: _this.nombretp,
                        codigo: _this.codigotp,
                        estado: _this.estadotp
                    })
                        .then(function (response) {
                            if (response['data'] === 'guardado')
                            {
                                toastr.success('Nuevo tipo de tarjeta Guardado');
                                _this.cargartablatp();
                                _this.nombretp = '';
                                _this.codigotp = '';
                                _this.estadotp = ''
                            }else if (response['data'] === 'ya existe'){
                                toastr.warning('ya Exites este codigo')
                            }
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                },
                cargartablatp :function () {
                    _this = this;

                    axios.post('/tipo/tarjeta/datos/tabla')
                        .then(function (response) {
                            if (response['data'] == 'vacio'){
                                _this.datostabla = ''
                            }else {
                                _this.datostabla = response['data'];
                            }

                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                },
                editarsettp:function (codigo) {
                    _this = this;
                    console.log(codigo)

                    for (var key in _this.datostabla)
                    {
                        if (_this.datostabla[key].codigo == codigo){
                            _this.codigotp = _this.datostabla[key].codigo;
                            _this.nombretp = _this.datostabla[key].nombre;
                            _this.estadotp = _this.datostabla[key].estado;
                            _this.idtp = _this.datostabla[key].id;
                        }
                    }
                },
                editart:function () {
                    _this = this;
                    axios.post('/tipo/tarjeta/edit', {
                        id: _this.idtp,
                        nombre: _this.nombretp,
                        codigo: _this.codigotp,
                        estado: _this.estadotp
                    })
                        .then(function (response) {
                            console.log(response);
                            if (response['data'] == 'editado'){
                                toastr.success('Editado con exito')
                                _this.editar  = '';
                                _this.idtp = ''
                                _this.nombretp = ''
                                _this.codigotp = ''
                                _this.estadotp = ''
                                _this.cargartablatp();
                            }
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                },
                guardarconfig:function () {
                    _this = this
                    if (_this.idtarjeta === '' || _this.identificador === '' || _this.cantidadd === 0 || _this.accioncheck === '')
                    {
                        toastr.warning('por favor llenar todos los datos importantes');
                    }
                    else {
                        axios.post('/config/tipo/tarjeta/store',{
                            id:_this.idtarjeta,
                            config:{
                                Datos:{
                                    tarjeta_id:_this.idtarjeta,
                                    identificador:_this.identificador,
                                    cantidadd:_this.cantidadd,
                                    tipo:_this.accioncheck,
                                    Gpuntos:{
                                        generar:_this.generar,
                                        porcada:_this.porcada,
                                        generarpuntos:_this.generarnumeropuntos,
                                        porciento:_this.porciento
                                    },
                                    Gdescuento:{
                                        descuentog:_this.GenerarDescuento
                                    }
                                },
                            }
                        })
                            .then(function (response) {
                                console.log(response);
                                if (response['data'] === 'Guardado')
                                {
                                    toastr.success('Los datos sean guardado con exito');
                                }
                            })
                            .catch(function (error) {
                                toastr.warning('se ha producido un error');
                                console.log(error);
                            });
                    }
                    
                },
                buscardatostarjeta:function () {
                    _this = this

                    axios.post('/config/tipo/tarjeta/buscar', {
                        id:_this.idtarjeta
                    })
                        .then(function (response) {
                            if (response['data'] === 'vacio'){
                                _this.identificador = '';
                                _this.cantidadd= 0;
                                _this.accioncheck= '';
                                _this.generar= '';
                                _this.porcada= 0;
                                _this.generarnumeropuntos= 0;
                                _this.porciento= 0;
                                _this.GenerarDescuento= 0;
                                _this.editardatostarjeta = false;
                            }else {
                                var jso = JSON.parse(response['data'].config);
                                _this.iddatostj = response['data'].id;
                                _this.identificador = jso.Datos['identificador'];
                                _this.cantidadd= jso.Datos['cantidadd'];
                                _this.accioncheck= jso.Datos['tipo'];
                                _this.generar= jso.Datos['Gpuntos']['generar'];
                                _this.porcada= jso.Datos['Gpuntos']['porcada'];
                                _this.generarnumeropuntos= jso.Datos['Gpuntos']['generarpuntos'];
                                _this.porciento= jso.Datos['Gpuntos']['porciento'];
                                _this.GenerarDescuento= jso.Datos['Gdescuento']['descuentog'];
                                _this.editardatostarjeta = true;
                            }
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                },
                editardatostarjetas:function () {
                    _this = this
                    if (_this.idtarjeta === '' || _this.identificador === '' || _this.cantidadd === 0 || _this.accioncheck === '')
                    {
                        toastr.warning('por favor llenar todos los datos importantes');
                    }
                    else {
                        axios.post('/config/tipo/tarjeta/edit',{
                            id:_this.iddatostj,
                            config:{
                                Datos:{
                                    tarjeta_id:_this.idtarjeta,
                                    identificador:_this.identificador,
                                    cantidadd:_this.cantidadd,
                                    tipo:_this.accioncheck,
                                    Gpuntos:{
                                        generar:_this.generar,
                                        porcada:_this.porcada,
                                        generarpuntos:_this.generarnumeropuntos,
                                        porciento:_this.porciento
                                    },
                                    Gdescuento:{
                                        descuentog:_this.GenerarDescuento
                                    }
                                },
                            }
                        })
                            .then(function (response) {
                                console.log(response);
                                if (response['data'] === 'editado')
                                {
                                    toastr.success('Se han guardados los datos con exito');
                                }
                            })
                            .catch(function (error) {
                                toastr.warning('se ha producido un error');
                                console.log(error);
                            });
                    }
                },

            },
            computed:{

            }
        })
    </script>
@endsection