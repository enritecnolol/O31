@extends('main.app')
@section('tittle','Cafeteria | Provedores')

@section('titulo')
    <h3 style="color: white"><i class="fas fa-arrow-circle-right"></i> Provedores</h3>
@endsection

@section('aside')
    @include('caja.siderbar')
@endsection

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="text-center">
                                <h1>Provedores</h1>
                            </div>
                            <div class="text-right">
                                <div class="row">
                                    <div class="col-md-10">
                                        <input class="form-control mr-sm-2" @input.stop="normal" v-model="buscador" type="text" placeholder="Buscador"  v-show="form == false" >
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-primary" @click="form = true, vaciar()" v-show="form == false"><i class="fas fa-user"></i> Nuevo Provedor</button>
                                        <button type="button" class="btn btn-danger" @click="form = false, vaciar()" v-show="form == true"><i class="fas fa-sort-down"></i> ocultar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <hr style="background: #00aced">
                        </div>
                        <div class="col-md-12" v-if="form == true">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row form-group">
                                        <div class="col-sm-5">
                                            <label for="nombre" class=" form-control-label">Nombre <span style="color: red">*</span></label>
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="text" v-model="nombre" id="nombre" placeholder="" class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-sm-5">
                                            <label for="razons"  class=" form-control-label">Razon Social</label>
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="text" v-model="razons" id="razons" placeholder="" class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-sm-5">
                                            <label for="direccion" class=" form-control-label">Direccion <span style="color: red">*</span></label>
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="text" id="direccion" v-model="direccion" placeholder="" class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-sm-5">
                                            <label for="pais" class=" form-control-label">Pais <span style="color: red">*</span></label>
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="text" id="pais" v-model="pais" placeholder="" class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-sm-5">
                                            <label for="provincia" class=" form-control-label">Provincia <span style="color: red">*</span></label>
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="text" id="provincia" placeholder="" v-model="provincia" class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-sm-5">
                                            <label for="ciudad" class=" form-control-label">Ciudad <span style="color: red">*</span></label>
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="text" id="ciudad" placeholder="" v-model="ciudad" class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-sm-5">
                                            <label for="sector" class=" form-control-label">Sector <span style="color: red">*</span></label>
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="text" id="sector" placeholder="" v-model="sector" class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-sm-5">
                                            <label for="telefono" class=" form-control-label">Telefono <span style="color: red">*</span></label>
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="text" id="telefono" v-model="telefono" placeholder="" class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-sm-5">
                                            <label for="email" class=" form-control-label">E-mail <span style="color: red">*</span></label>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" id="email" v-model="email" placeholder="" class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-sm-5">
                                            <label for="contacto" class=" form-control-label">Contacto </label>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" id="contacto" v-model="contacto" placeholder="" class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-sm-5">
                                            <label for="itbis" class=" form-control-label">Itbis <span style="color: red">*</span></label>
                                        </div>
                                        <div class="col-sm-6">
                                            <select class="form-control form-control-sm" v-model="itbis" >
                                                <option value="">--Selecciona--</option>
                                                <option value="+">( + ) Sumado</option>
                                                <option value="-">( - ) Incluido</option>
                                                <option value="=">( = ) Exento</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row form-group">
                                        <div class="col-sm-5">
                                            <label for="tcontribuyente" class="form-control-label">Tipo contribuyente</label>
                                        </div>
                                        <div class="col-ms-6">
                                            <input type="text" id="tcontribuyente" v-model="tipocontribuyente" placeholder="" class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-sm-5">
                                            <label for="referencia" class=" form-control-label">Referencia</label>
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="text" id="referencia" v-model="referencia" placeholder="" class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-sm-5">
                                            <label for="cedula" class=" form-control-label">Cedula <span style="color: red">*</span></label>
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="text" id="cedula" maxlength="11" v-model="cedula" placeholder="" class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-sm-5">
                                            <label for="vendedor" class=" form-control-label">Vendedor <span style="color: red">*</span></label>
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="text" id="vendedor" placeholder="" v-model="vendedor" class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-sm-5">
                                            <label for="condiciones" class=" form-control-label">Condiciones <span style="color: red">*</span></label>
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="number" id="condiciones" min="0" max="30" onkeydown="return false" v-model="condiciones" class="form-control form-control-sm col-md-3">
                                            <h4 style="position: absolute;right: 0;margin-top: -25px;left: 100px">Dias</h4>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-sm-5">
                                            <label for="tcxp" class=" form-control-label"><a href="#" data-toggle="modal" data-target="#exampleModal"><u>Tipo CxP </u></a><span style="color: red"> *</span></label>
                                        </div>
                                        <div class="col-sm-6">
                                            <select class="form-control form-control-sm"  v-model="tipocxp" id="exampleFormControlSelect1">
                                                <option value="">Selecciona</option>
                                                <template v-for="item in datostcxptabla">
                                                    <option :value="item.id">@{{ item.nombre }}</option>
                                                </template>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <hr style="background: #00aced">
                                </div>
                                <div class="col-md-12">
                                    <div class="text-center">
                                        <button type="button" @click="nuevoprovedor" class="btn btn-primary btn-lg" v-if="numero_provedor == 0"><i class="fas  fa-save"></i> Guardar</button>
                                        <button type="button" @click="editarprovedores" class="btn btn-warning btn-lg" v-else><i class="fas  fa-edit"></i> Editar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12" v-if="form == false">
                            <div class="table-responsive" style="width: 100%">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Nombre</th>
                                        <th scope="col">Direccion</th>
                                        <th scope="col">Pais</th>
                                        <th scope="col">Ciudad</th>
                                        <th scope="col">Telefono</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Itbis</th>
                                        <th scope="col">Vendedor</th>
                                        <th scope="col">Cedula</th>
                                        <th scope="col">CxP</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <template v-if="datosprovedorestabla != '' && loading == false">
                                        <template v-for="item in datosprovedorestabla">
                                            <tr>
                                                <td>@{{ item.id }}</td>
                                                <td>@{{ item.nombre }}</td>
                                                <td>@{{ item.direccion }}</td>
                                                <td>@{{ item.pais }}</td>
                                                <td>@{{ item.ciudad }}</td>
                                                <td>@{{ item.telefono }}</td>
                                                <td>@{{ item.email }}</td>
                                                <td>@{{ item.itbis }}</td>
                                                <td>@{{ item.vendedor }}</td>
                                                <td>@{{ item.cedula }}</td>
                                                <td>@{{ nombrecxp(item.tcxp_id) }}</td>
                                                <td><button type="button" class="btn btn-warning btn-sm" @click="seleccionarprovedor(item.id)"><i class="fas fa-edit"></i></button></td>
                                            </tr>
                                        </template>
                                    </template>
                                    <template v-else-if=" loading == true">
                                        <tr>
                                            <div class="" style="position: relative;left: 400px">
                                                <img src="loading.gif" width="100" alt="">
                                            </div>
                                        </tr>
                                    </template>
                                    <template v-else>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td>
                                                <div class="text-center">
                                                    No hay resultado
                                                </div>
                                            </td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </template>
                                    </tbody>
                                </table>
                            </div>
                            <br>
                            <nav v-if="pagination.last_page>1" aria-label="Page navigation example">
                                <ul class="pagination justify-content-center">
                                    <li v-if="pagination.current_page==1" class="page-item disabled">
                                        <a class="page-link" href="#" tabindex="-1">Anterior</a>
                                    </li>
                                    <li v-else class="page-item">
                                        <a class="page-link" href="#" tabindex="-1" @click="datostablaprovedores(pagination.prev_page_url, buscador)">Anterior</a>
                                    </li>

                                    <li v-for="page in pagination.last_page" v-if="pagination.current_page==page" class="page-item active">
                                        <a class="page-link" href="#">@{{ page }}</a>
                                    </li>
                                    <li v-else class="page-item">
                                        <a class="page-link" href="#" @click="datostablaprovedores(pagination.path+'?page='+page, buscador)">@{{ page }}</a>
                                    </li>
                                    <li v-if="pagination.current_page==pagination.last_page" class="page-item disabled">
                                        <a class="page-link" href="#">Siguiente</a>
                                    </li>
                                    <li v-else class="page-item">
                                        <a class="page-link" href="#" @click="datostablaprovedores(pagination.next_page_url, buscador)">Siguiente</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('modal.modalcxp')
@endsection

@section('scriptp')
    <script >
        new Vue({
            el: '#Vue',
            data(){
                return {
                    nombre:'',
                    razons:'',
                    direccion:'',
                    pais:'',
                    provincia:'',
                    ciudad:'',
                    sector:'',
                    telefono:'',
                    fax:'',
                    email:'',
                    contacto:'',
                    itbis:'',
                    tipocontribuyente:'',
                    referencia:'',
                    cedula:'',
                    vendedor:'',
                    condiciones:0,
                    tipocxp:'',
                    nuevotipocxpnombre:'',
                    datostcxptabla:'',
                    datosprovedorestabla:'',
                    form: false,
                    pagination:{},
                    buscador:"",
                    numero_provedor:0,
                    loading:false
                }
            },
            mounted(){
                _this = this ;
                _this.datostablaprovedores();
                _this.datostcxp();
            },
            methods:{
                nuevotcxp:function () {
                    _this = this;
                    if  (_this.nuevotipocxpnombre == '')
                    {
                        toastr.warning('Por Rellenar el campo faltante', 'Validador')
                    }else{
                        axios.post('/tcxp/store', {
                            nombre:_this.nuevotipocxpnombre
                        })
                            .then(function (response) {
                                toastr.success('Los Datos se ha guadado Correctamente','Datos')
                                $('#exampleModal').modal('hide');
                                _this.nuevotipocxpnombre = '';
                                _this.datostcxp();
                            })
                            .catch(function (error) {
                                console.log(error);
                            });
                    }
                },
                nuevoprovedor:function () {
                    _this = this;
                    if (_this.nombre == '' || _this.direccion == '' || _this.pais == '' || _this.provincia == '' || _this.ciudad == '' || _this.sector == '' || _this.telefono=='' || _this.email == '' || _this.itbis == '' || _this.cedula == '' || _this.vendedor == '' || _this.condiciones == '')
                    {
                        toastr.warning('Favor Revisar los campos importante', 'Validacion')
                    }else{
                        axios.post('/provedores/store', {
                            nombre:_this.nombre,
                            razons:_this.razons,
                            direccion:_this.direccion,
                            pais:_this.pais,
                            provincia:_this.provincia,
                            ciudad:_this.ciudad,
                            sector:_this.sector,
                            telefono:_this.telefono,
                            email:_this.email,
                            contacto:_this.contacto,
                            itbis:_this.itbis,
                            tipocontribuyente:_this.tipocontribuyente,
                            referencia:_this.referencia,
                            cedula:_this.cedula,
                            vendedor:_this.vendedor,
                            condiciones:_this.condiciones,
                            tipocxp:_this.tipocxp,
                        })
                            .then(function (response) {
                                toastr.success('Los Datos se ha guadado Correctamente','Datos')
                                _this.vaciar();
                            })
                            .catch(function (error) {
                                console.log(error);
                            });
                    }
                },
                vaciar:function() {
                    _this.nombre = ''
                    _this.razons = ''
                    _this.direccion = ''
                    _this.pais = ''
                    _this.provincia = ''
                    _this.ciudad = ''
                    _this.sector = ''
                    _this.telefono = ''
                    _this.email = ''
                    _this.contacto = ''
                    _this.numero_provedor=0
                    _this.itbis = ''
                    _this.tipocontribuyente = ''
                    _this.referencia = ''
                    _this.cedula = ''
                    _this.vendedor = ''
                    _this.condiciones = ''
                    _this.tipocxp  = ''
                    _this.datostablaprovedores();
                },
                normal:function(e){
                    _this = this;
                    e.preventDefault();
                    _this.datostablaprovedores('',_this.buscador);
                },
                datostcxp:function () {
                    _this = this;

                    axios.post('/tcxp/datos/todos')
                        .then(function (response) {
                            _this.datostcxptabla = response['data'];
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                },
                datostablaprovedores:function (url, buscador) {
                    _this = this;
                    _this.loading = true;
                    url  = url || '/provedores/todos/datos';
                    axios.post(url, {
                        search: buscador
                    })
                        .then(function (response) {
                            _this.datosprovedorestabla = response['data']['data'];
                            _this.setpaginator(response['data']);
                            _this.loading = false;
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                },
                setpaginator:function (data){
                    _this = this

                    let pagination = {
                        current_page: data.current_page,
                        path: data.path,
                        last_page: data.last_page,
                        first_page_url: data.first_page_url,
                        next_page_url: data.next_page_url,
                        prev_page_url: data.prev_page_url,
                        last_page_url: data.last_page_url
                    };
                    _this.pagination = pagination;
                },
                seleccionarprovedor:function (i) {
                    _this = this;
                    _this.form = true;
                    for (var key in _this.datosprovedorestabla)
                    {
                        if  (_this.datosprovedorestabla[key].id == i)
                        {
                            _this.numero_provedor = i
                            _this.nombre = _this.datosprovedorestabla[key].nombre
                            _this.razons = _this.datosprovedorestabla[key].razon_social
                            _this.direccion = _this.datosprovedorestabla[key].direccion
                            _this.pais = _this.datosprovedorestabla[key].pais
                            _this.provincia = _this.datosprovedorestabla[key].provincia
                            _this.ciudad = _this.datosprovedorestabla[key].ciudad
                            _this.sector = _this.datosprovedorestabla[key].sector
                            _this.telefono = _this.datosprovedorestabla[key].telefono
                            _this.email = _this.datosprovedorestabla[key].email
                            _this.contacto = _this.datosprovedorestabla[key].contacto
                            _this.itbis = _this.datosprovedorestabla[key].itbis
                            _this.tipocontribuyente = _this.datosprovedorestabla[key].tcontribuyente
                            _this.referencia = _this.datosprovedorestabla[key].referencia
                            _this.cedula = _this.datosprovedorestabla[key].cedula
                            _this.vendedor = _this.datosprovedorestabla[key].vendedor
                            _this.condiciones = _this.datosprovedorestabla[key].Condiciones
                            _this.tipocxp  = _this.datosprovedorestabla[key].tcxp_id
                            return
                        }
                    }
                },
                editarprovedores:function () {
                    _this = this;
                    if (_this.nombre == '' || _this.direccion == '' || _this.pais == '' || _this.provincia == '' || _this.ciudad == '' || _this.sector == '' || _this.telefono=='' || _this.email == '' || _this.itbis == '' || _this.cedula == '' || _this.vendedor == '' || _this.condiciones == '')
                    {
                        toastr.warning('Favor Revisar los campos importante', 'Validacion')
                    }else{
                        axios.post('/provedores/edit', {
                            id:_this.numero_provedor,
                            nombre:_this.nombre,
                            razons:_this.razons,
                            direccion:_this.direccion,
                            pais:_this.pais,
                            provincia:_this.provincia,
                            ciudad:_this.ciudad,
                            sector:_this.sector,
                            telefono:_this.telefono,
                            email:_this.email,
                            contacto:_this.contacto,
                            itbis:_this.itbis,
                            tipocontribuyente:_this.tipocontribuyente,
                            referencia:_this.referencia,
                            cedula:_this.cedula,
                            vendedor:_this.vendedor,
                            condiciones:_this.condiciones,
                            tipocxp:_this.tipocxp,
                        })
                            .then(function (response) {
                                toastr.success('Los Datos se ha guadado Correctamente','Datos')
                                _this.vaciar();
                            })
                            .catch(function (error) {
                                console.log(error);
                            });
                    }
                },
                nombrecxp:function (i) {
                    _this = this
                    for (var key in _this.datostcxptabla)
                    {
                        if  (_this.datostcxptabla[key].id == i)
                        {
                            return _this.datostcxptabla[key].nombre
                        }
                    }
                }
            },
            computed:{

            }
        })

    </script>

@endsection