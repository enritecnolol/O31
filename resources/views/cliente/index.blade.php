@extends('main.app')
@section('tittle','Cafeteria | Clientes')
@section('titulo')
    <h3 style="color: white"><i class="fas fa-arrow-circle-right"></i> Clientes</h3>
@endsection

@section('aside')
    @include('caja.siderbar')
@endsection

@section('content')
    <div class="container" style="margin-top: -40px">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="default-tab">
                                        <nav>
                                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                                <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Lista de Clientes</a>
                                                <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Puntos</a>
                                                <a class="nav-item nav-link" id="nav-reporte-tab" data-toggle="tab" href="#nav-reporte" role="tab" aria-controls="nav-profile" aria-selected="false">Reporte de Cliente</a>
                                            </div>
                                        </nav>
                                        <div class="tab-content pl-3 pt-2" id="nav-tabContent">
                                            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                                <div class="container">
                                                    <div class="row">
                                                        <div class="col-md-12" style="background: #4272d7">
                                                            <div class="pull-left" style="margin-top: 5px; margin-bottom: 5px">
                                                                <h3 style="color: white; font-weight: bolder">Lista de Clientes</h3>
                                                            </div>
                                                            <div class="pull-right" v-show="formcliente == false" style="margin-top: 5px; margin-bottom: 5px">
                                                                <button type="button" @click="formcliente = true" class="btn btn-primary btn-sm">
                                                                    <i class="fas fa-user-plus"></i>&nbsp Nuevo Cliente</button>
                                                            </div>
                                                            <div class="pull-right" v-show="formcliente == true" style="margin-top: 5px; margin-bottom: 5px">
                                                                <button type="button" @click="formcliente = false" class="btn btn-danger btn-sm">
                                                                    <i class="fas fa-chevron-up"></i>&nbsp; ocultar</button>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12" v-show="formcliente == true" style="margin-top: 10px">
                                                            <div class="container">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="text-center">
                                                                            <h3 v-show="edit == false">Crear Nuevo Cliente</h3>
                                                                            <h3 v-show="edit == true">Editar Cliente</h3>
                                                                            <br>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="nombre" class=" form-control-label">Nombre <span style="color: red">*</span></label>
                                                                            <input type="text" v-model="nombre" id="nombre" placeholder="" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="telefono" class=" form-control-label">Telefono <span style="color: red">*</span></label>
                                                                            <input type="text" v-model="telefono" id="telefono" placeholder="" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="matricula" class=" form-control-label">Documento<span style="color: red">*</span></label>
                                                                            <input type="text" id="matricula" v-model="matricula" placeholder="" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="email" class=" form-control-label">Email <span style="color: red">*</span></label>
                                                                            <input type="text" id="email" placeholder="" v-model="email" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                    {{--<div class="col-md-6">--}}
                                                                    {{--<div class="form-group">--}}
                                                                    {{--<label for="descuento" class=" form-control-label">Descuento <span style="color: red">*</span></label>--}}
                                                                    {{--<input type="number" id="descuento" placeholder="" v-model="descuento" class="form-control">--}}
                                                                    {{--</div>--}}
                                                                    {{--</div>--}}
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="tpselect">Tipo de Tarjeta <span style="color: red">*</span></label>
                                                                            <select v-model="idtarjeta" class="form-control" id="tpselect">
                                                                                <option value="">-- Selecciona --</option>
                                                                                <template v-for="tp in datostj">
                                                                                    <option :value="tp.id">@{{ tp.nombre }}</option>
                                                                                </template>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <textarea name="editor1" class="form-control" placeholder="Observacion" v-model="observacion" id="editor1" rows="5" cols="80">
                                                                        </textarea>
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <hr style="background: #4272d7;">
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <div class="text-center">
                                                                            <button type="button" v-show="edit == false" @click="nuevocliente" class="btn btn-success btn-sm">
                                                                                <i class="fas fa-save"></i> Guardar
                                                                            </button>
                                                                            <button type="button" v-show="edit == true"  @click="editarcliente" class="btn btn-warning btn-sm">
                                                                                <i class="fas fa-edit"></i> editar
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <hr style="background: #4272d7;">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12" style="margin-top: 15px" v-show="formcliente == false">
                                                            <div class="container">
                                                                <table class="table table-bordered">
                                                                    <thead>
                                                                    <tr>
                                                                        <th scope="col">Nombre</th>
                                                                        <th scope="col">Telefono</th>
                                                                        <th scope="col">Email</th>
                                                                        <th scope="col">Identificador</th>
                                                                        <th scope="col">Puntos</th>
                                                                        <th scope="col">Tarjeta</th>
                                                                        <th scope="col"></th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    <tr v-for="item in datostable">
                                                                        <td>@{{ item.nombre }}</td>
                                                                        <td>@{{ item.telefono }}</td>
                                                                        <td>@{{ item.email }}</td>
                                                                        <td>@{{ item.matricula }}</td>
                                                                        <td v-if="item.puntos == null">0</td>
                                                                        <td v-else>@{{ item.puntos }}</td>
                                                                        <td>@{{ tarjetaid(item.tarjeta_id) }}</td>
                                                                        <td>
                                                                            <button type="button" @click="formeditar(item.id)" class="btn btn-warning btn-sm">
                                                                                <i class="fas fa-edit"></i>
                                                                            </button>
                                                                        </td>
                                                                    </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                                <div class="container">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="text-center" style="background: #4272d7">
                                                                <h2 style="color: white">Puntos Acumutados</h2>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="text-center" style="margin-top: 15px">
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <div class="input-group-text"><i class="fas fa-barcode"></i></div>
                                                                    </div>
                                                                    <input type="text" id="matriculaa" v-model="idcliente" list="list" @keypress.capture="elejircliente" placeholder="Codigo" class="form-control" autofocus>
                                                                    <datalist id="list">
                                                                        <template v-for="int in datostable">
                                                                            <option :value="int.matricula">@{{ int.nombre }}</option>
                                                                        </template>
                                                                    </datalist>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="row">
                                                                <div class="col-md-12" style="margin-top: 10px">
                                                                    <div class="text-center">
                                                                        <p style="font-size: 30px"><u>Datos</u></p>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-6" style="margin-top: 10px">
                                                                    <div class="text-left">
                                                                        <div class="row">
                                                                            <h4 class="col">Nombre: </h4> <label for="" class="col">@{{ nombre2 }}</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6" style="margin-top: 10px">
                                                                    <div class="text-left">
                                                                        <div class="row">
                                                                            <h4 class="col">Telefono: </h4> <label for="" class="col">@{{ telefono2 }}</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6" style="margin-top: 10px">
                                                                    <div class="text-left">
                                                                        <div class="row">
                                                                            <h4 class="col">Email: </h4><label for="" class="col">@{{ email2 }}</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6" style="margin-top: 10px">
                                                                    <div class="text-left">
                                                                        <div class="row">
                                                                            <h4 class="col">Identificador: </h4><label for="" class="col">@{{ matricula2 }}</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6" style="margin-top: 10px">
                                                                    <div class="text-left">
                                                                        <div class="row">
                                                                            <h4 class="col">Tipo Tarjeta: </h4><label for="" class="col">@{{ tarjetaid(tarjeta2) }}</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6" style="">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="text-center" style="margin: 60px; background: #4272d7;border-radius: 200px 200px 200px 200px;box-shadow: 0px 0px 38px -8px rgba(0,0,0,0.75);">
                                                                        <label for="" style="font-size: 70px; color: white" v-if="puntos2 != ''">@{{ puntos2 }}</label>
                                                                        <label for="" style="font-size: 70px; color: white" v-else>000</label>
                                                                        <br>
                                                                        <label for="" style="color: white;font-size: 30px">Puntos</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="text-center">
                                                                <div class="row">
                                                                    <div class="col-md-5">
                                                                        <input type="text" class="form-control" id="" v-model="montocambio" placeholder="Monto">
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <i class="fas fa-2x fa-arrow-left" style="margin-top: 5px"></i>
                                                                    </div>
                                                                    <div class="col-md-5">
                                                                        <input type="text"  disabled class="form-control" id="" v-model="puntos2" placeholder="Puntos">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12" style="margin-top: 15px">
                                                            <div class="text-center">
                                                                <button type="button" @click="ticketcambio" v-show="puntos2 != ''" class="btn btn-success"><i class="fas fa-print"></i> Generar Ticket</button>
                                                            </div>
                                                            {{--<div class="text-center">--}}
                                                            {{--<a href="">Ticket de Cambio</a>--}}
                                                            {{--</div>--}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="nav-reporte" role="tabpanel" aria-labelledby="nav-reporte-tab">
                                                <div class="container">
                                                    <div class="row">
                                                        <div class="col-md-12" style="margin-top: 20px">
                                                            <div class="text-center" style="background: #0062cc">
                                                                <h3 style="color: white">Reportes por clientes</h3>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12" style="margin-top: 15px">
                                                            <div class="row form-group">
                                                                <div class="col">
                                                                    <select class="select" id="cliente" name="cliente">
                                                                        <option value="">Selecciona</option>
                                                                        <option v-for="item in datostable" :value="item.id">@{{ item.nombre }} - @{{ item.matricula }}</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col">
                                                                    <div class="" id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                                                                        <i class="fa fa-calendar"></i>&nbsp;
                                                                        <span></span> <i class="fa fa-caret-down"></i>
                                                                    </div>
                                                                </div>
                                                                <div class="col-2">
                                                                    <button type="button" @click="buscarmovimientoscliente" class="btn btn-primary"><i class="fas fa-search"></i> Buscar</button>
                                                                    <button type="button" id="imprimir2" class="btn btn-success"><i class="fas fa-print"></i></button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12" id="myPrintArea2" style="margin-top: 20px;">
                                                            <div class="container" v-if="compania !== ''">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="text-center">
                                                                            <img :src="'/imagenes/'+compania.img" width="100" alt="">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12" style="margin-top: 15px">
                                                                        <div class="text-left">
                                                                            <strong>Telefono</strong>: @{{ compania.telefono }}
                                                                        </div>
                                                                        <div class="text-left">
                                                                            <strong>Direccion</strong>: @{{ compania.pais }}, @{{ compania.ciudad }}
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <hr style="background: #0062cc">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <table class="table table-bordered table-sm">
                                                                <thead>
                                                                    <tr>
                                                                        <th scope="col">Fecha</th>
                                                                        <th scope="col">Cliente</th>
                                                                        <th scope="col">Puntos</th>
                                                                        <th scope="col">Balance</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                <template v-if="todostickets !== 'vacio'">
                                                                    <tr v-for="item in todostickets">
                                                                        <td>@{{ item.fecha }}</td>
                                                                        <td>@{{ nombrecliente(item.cliente_id) }}</td>
                                                                        <td>@{{ item.puntos }}</td>
                                                                        <td>@{{ item.balancepuntos }}</td>
                                                                    </tr>
                                                                </template>
                                                                <template v-else>
                                                                    <tr>
                                                                        <td>No</td>
                                                                        <td>Hay</td>
                                                                        <td>Resultado</td>
                                                                        <td>!</td>
                                                                    </tr>
                                                                </template>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('modal.ticketcambio')
@endsection
@section('scriptp')
    <script !src="">
        var startfecha = '';
        var endfecha = '';
        var idcliente = '';


        $( document ).ready(function() {
            $("#imprimir").click(function () {
                $("div#myPrintArea").printArea();
            });
            $("#imprimir2").click(function () {
                $("div#myPrintArea2").printArea();
            });
            $('.select').select2();
            // CKEDITOR.replace( 'editor1' );

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
                startfecha = picker.startDate.format('YYYY-MM-DD');
                endfecha = picker.endDate.format('YYYY-MM-DD');
                idcliente = $('#cliente').val();
            });

        });

        var dia = moment().format('LLLL');

        new Vue({
            el: '#Vue',
            data:{
                formcliente: false,
                nombre:'',
                telefono:'',
                email:'',
                matricula:'',
                observacion:'',
                descuento:0,
                datostj:'',
                idtarjeta:'',
                datostable: '',
                edit: false,
                cliente:0,
                idcliente:'',
                nombre2: '',
                telefono2:'',
                email2:'',
                matricula2:'',
                observacion2:'',
                tarjeta2:'',
                puntos2:'',
                montocambio:0,
                idcliente2 : '',
                compania:'',
                fecha: dia,
                idticket:0,
                todostickets:'',

            },
            mounted(){
                _this = this;
                _this.cargartablatp();
                _this.cargartablacliente();
                _this.puntosmoviento();
            },
            watch:{
            },

            methods:{
                nuevocliente:function () {
                    _this = this

                    if (_this.nombre === '' || _this.telefono === '' || _this.email === '' || _this.matricula === ''|| _this.idtarjeta === '')
                    {
                        toastr.warning('Por favor llenar los campos importantes');
                    }
                    else {
                        axios.post('/clientes/store', {
                            nombre: _this.nombre,
                            telefono: _this.telefono,
                            email: _this.email,
                            matricula: _this.matricula,
                            descuento: _this.descuento,
                            idtarjeta: _this.idtarjeta,
                            observacion: _this.observacion
                        })
                            .then(function (response) {
                                console.log(response);
                                if (response['data'] === 'guardado')
                                {
                                    toastr.success('El cliente ha sido ingresado con exito');
                                    _this.nombre ='';
                                    _this.telefono = '';
                                    _this.email = '';
                                    _this.matricula = '';
                                    _this.descuento = 0;
                                    _this.idtarjeta = '';
                                    _this.observacion = '';
                                    _this.cargartablacliente();
                                    _this.formcliente = false;
                                }
                            })
                            .catch(function (error) {
                                toastr.warning('Se ha prodcido un error');
                                console.log(error);
                            });
                    }
                },
                cargartablatp :function () {
                    _this = this;

                    axios.post('/tipo/tarjeta/datos/tabla')
                        .then(function (response) {
                            if (response['data'] === 'vacio'){
                                _this.datostj = ''
                            }else {
                                _this.datostj = response['data'];
                            }

                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                },
                cargartablacliente: function () {
                    _this = this
                    axios.post('/clientes/datos/tabla')
                        .then(function (response) {
                            if (response['data'] === 'vacio'){
                                _this.datostable = ''
                            }else {
                                _this.datostable = response['data'];
                            }

                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                },
                tarjetaid:function (id) {
                    _this = this
                    var nombre = ''
                    for (var key in _this.datostj)
                    {
                        if (_this.datostj[key].id === id){
                            nombre = _this.datostj[key].nombre;
                        }
                    }
                    return nombre
                },
                formeditar:function (id) {
                    _this = this;

                    for (var key in _this.datostable)
                    {
                        if (_this.datostable[key].id === id)
                        {
                            _this.cliente = _this.datostable[key].id;
                            _this.nombre = _this.datostable[key].nombre;
                            _this.telefono =_this.datostable[key].telefono;
                            _this.email =_this.datostable[key].email;
                            _this.matricula =_this.datostable[key].matricula;
                            _this.descuento=_this.datostable[key].descuento;
                            _this.idtarjeta=_this.datostable[key].tarjeta_id;
                            _this.observacion = _this.datostable[key].observacion;
                            _this.formcliente = true;
                            _this.edit = true;
                        }
                    }
                    return
                },
                editarcliente:function () {
                    _this = this
                    axios.post('/clientes/edit', {
                        id:_this.cliente,
                        nombre: _this.nombre,
                        telefono: _this.telefono,
                        email: _this.email,
                        matricula: _this.matricula,
                        descuento: _this.descuento,
                        idtarjeta: _this.idtarjeta,
                        observacion: _this.observacion
                    })
                        .then(function (response) {
                            if (response['data'] === 'guardado'){
                                toastr.success('Los datos se han guardado');
                                _this.nombre ='';
                                _this.telefono = '';
                                _this.email = '';
                                _this.matricula = '';
                                _this.descuento = 0;
                                _this.idtarjeta = '';
                                _this.observacion = '';
                                _this.cargartablacliente();
                                _this.formcliente = false;
                            }
                        })
                        .catch(function (error) {
                            console.log(error);
                        });

                },
                elejircliente:function () {
                    _this = this

                    for (var key in _this.datostable){

                        if (_this.datostable[key].matricula === _this.idcliente){
                            _this.idcliente2 = _this.datostable[key].id;
                            _this.nombre2 = _this.datostable[key].nombre;
                            _this.telefono2 = _this.datostable[key].telefono;
                            _this.email2 = _this.datostable[key].email;
                            _this.matricula2 = _this.datostable[key].matricula;
                            _this.tarjeta2 = _this.datostable[key].tarjeta_id;
                            _this.puntos2 = _this.datostable[key].puntos;
                            _this.observacion2 = _this.datostable[key].observacion;
                        }
                    }
                },
                ticketcambio:function () {
                    _this = this

                    if (_this.montocambio<=_this.puntos2){
                        if (_this.montocambio > 10){
                            axios.post('/cambio/puntos',{
                                id: _this.idcliente2,
                                puntos: _this.puntos2,
                                cambio: _this.montocambio,
                                nombre: _this.nombre2,
                                telefono: _this.telefono2,
                                email:_this.email2,
                                matricula: _this.matricula2,

                            })
                                .then(function (response) {
                                    if (response['data'][0] === 'guardado')
                                    {
                                        toastr.success('ya hemos generado el ticket');
                                        _this.compania = response['data'][1][0];
                                        _this.idticket = response['data'][2];
                                        $('#ticketcambio').modal('show');
                                        _this.puntosmoviento();
                                    }
                                })
                                .catch(function (error) {
                                    console.log(error);
                                });
                        }else {
                            toastr.warning('Para poder cambiar los puntos debe ser mayor a 10 puntos')
                        }
                    }else {
                        toastr.warning('Los puntos que quiere cambiar no esta en el rango de los puntos disponibles')
                    }
                },
                puntosmoviento:function () {
                    _this = this

                    axios.post('/ticket/todos')
                        .then(function (response) {
                            _this.todostickets = response['data'];
                            console.log(response);
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                },
                nombrecliente:function (id) {
                    _this = this
                    var nombre = '';
                    for(var key in _this.datostable){
                        if (_this.datostable[key].id === id){
                            nombre = _this.datostable[key].nombre
                        }
                    }
                    return nombre
                },
                buscarmovimientoscliente:function () {
                    _this = this

                    axios.post('/ticket/cliente/tickets', {
                        id: $('#cliente').val(),
                        inicio: startfecha,
                        fin: endfecha,
                    })
                        .then(function (response) {
                            _this.todostickets = response['data'][0];
                            _this.compania = response['data'][1][0];
                            console.log(response);
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                }
            },
            computed:{

            }
        })
    </script>
@endsection