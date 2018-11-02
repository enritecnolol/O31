@extends('main.app')
@section('tittle','Cafeteria | Tipo de Tarjetas')

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
                            <li class="nav-item">
                                <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Menu 2</a>
                            </li>
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
                                                                    <button type="button" class="btn btn-dark"><i class="fas fa-search"></i></button>
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
                                                                <option value="1">True</option>
                                                                <option value="2">False</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div style="height: 300px; width: auto;overflow-y: scroll">
                                                        <table class="table table-responsive">
                                                            <thead>
                                                            <tr>
                                                                <th scope="col">Codigo</th>
                                                                <th scope="col">Nombre</th>
                                                                <th scope="col">Estado</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <template v-if="datostabla != ''">
                                                                <tr style="cursor: pointer" v-for="item in datostabla" @click="editarsettp(item.codigo), editar = true">
                                                                    <td>@{{ item.codigo }}</td>
                                                                    <td>@{{ item.nombre }}</td>
                                                                    <td v-if="item.estado == 1">Activo</td>
                                                                    <td v-else>Desactivado</td>
                                                                </tr>
                                                            </template>
                                                            <template v-else>
                                                                <tr>
                                                                    <td>Resultado</td>
                                                                    <td>No</td>
                                                                    <td>Encontrado</td>
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
                                                            <i class="fas fa-edit"></i> Editar
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                <h3>Menu 1</h3>
                                <p>Some content here.</p>
                            </div>
                            <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                                <h3>Menu 2</h3>
                                <p>Some content here.</p>
                            </div>
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
                editar:''
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
                }
            },
            computed:{

            }
        })
    </script>
@endsection