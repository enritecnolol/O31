@extends('main.app')
@section('tittle','Cafeteria | Tabla itbis(%)')

@section('titulo')
    <h3 style="color: white"><i class="fas fa-arrow-circle-right"></i> Impuesto</h3>
@endsection

@section('aside')
    @include('caja.siderbar')
@endsection

@section('content')
    <div class="container">
        <div class="card" style="box-shadow:rgb(136, 136, 136) 1px 1px 4px;">
            <div class="card-body">
                <div class="text-center">
                    <h4><strong>Definir tabla Itbis %</strong></h4>
                </div>
                <hr style="background: #4272d7;">
                <div class="row">
                    <div class="col-md-6">
                        <div style="float: left">
                            <div class="form-group">
                                <label for="company" class=" form-control-label"><strong>Codigo</strong></label>
                                <div class="container">
                                    <div class="row">
                                        <input type="number" v-model="codigo" min="1" @keypress.enter="datos" name="secuenciano" class="form-control col-sm-2">&nbsp;
                                        <button type="button" @click="datos" class="btn btn-dark"><i class="fas fa-search"></i></button>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="company" class=" form-control-label"><strong>Descripcion<span style="color: red">*</span></strong></label>
                                <textarea class="form-control" id="" v-model="descripcion" rows="3"></textarea>
                            </div>

                            <div class="form-group">
                                <label for="company" class=" form-control-label"><strong>Identificador<span style="color: red">*</span></strong></label>
                                <input type="text" id="" required  v-model="identificador"  maxlength="4" name="hastafecha" placeholder="" class="form-control form-control-sm col-sm-3">
                            </div>
                            <small style="color: red">Favor de especificar porciento de impuesto y periodo que abarca</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div style="height: 300px ;overflow-y: scroll">
                            <table class="table table-responsive">
                                <thead>
                                <tr>
                                    <th scope="col">Desde</th>
                                    <th scope="col">Hasta</th>
                                    <th scope="col">Porciento</th>
                                </tr>
                                </thead>
                                <tbody>
                                <template v-if="datotabla != 'no resultado'">
                                    <template v-for="item in datotabla ">
                                        <tr @click="editar = true" v-if="editar == false" style="cursor: pointer">
                                            <td>@{{ item.desde }}</td>
                                            <td>@{{ item.hasta }}</td>
                                            <td>@{{ item.porciento }}%</td>
                                        </tr>
                                        <tr v-else>
                                            <td><input v-model="item.desde" type="date" class="form-control col-10"></td>
                                            <td><input v-model="item.hasta" type="date" class="form-control col-10"></td>
                                            <td><input v-model="item.porciento" type="number" class="form-control col"></td>
                                        </tr>
                                    </template>
                                </template>
                                <template v-if="datotabla == 'no resultado'">
                                </template>
                                <template v-else></template>
                                <template>
                                    <tr v-if="editar != true">
                                        <td><input v-model="fechadesde" type="date" class="form-control col-10"></td>
                                        <td><input v-model="fechahasta" type="date" class="form-control col-10"></td>
                                        <td><input v-model="porciento" type="number" class="form-control col"></td>
                                    </tr>
                                </template>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <hr style="background: #4272d7;">
                <div class="text-center">
                    <button type="button" v-if="datotabla == ''" @click="nuevoimpuestoref" class="btn btn-primary btn-sm">
                        <i class="fas fa-save"></i> Guardar
                    </button>
                    <button type="button" v-if="datotabla != '' && editar == false"  @click="guardarrango" class="btn btn-warning btn-sm">
                        <i class="fas fa-save"></i> Guardar
                    </button>
                    <button type="button" v-if="datotabla != '' && editar == true"  @click="editarrango" class="btn btn-success btn-sm">
                        <i class="fas fa-save"></i> Guardar
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scriptp')
    <script !src="">
        var codigo = '{{$ref}}';
        new Vue({
            el: '#Vue',
            data:{
                editar: false,
                id:0,
                codigo:codigo,
                descripcion:'',
                identificador:'',
                fechadesde:'',
                fechahasta:'',
                porciento:0,
                datotabla:'',
            },
            watch:{

            },
            mounted(){

            },
            methods:{
                nuevoimpuestoref:function () {
                    _this = this;
                    if (_this.descripcion == '' || _this.identificador == '' || _this.fechadesde == '' || _this.fechahasta == '' || _this.porciento == 0){
                        toastr.warning('rellene todos campos');
                    }else{
                        axios.post('/impuestoref/nuevo',{
                            codigo: _this.codigo,
                            descripcion: _this.descripcion,
                            identificador: _this.identificador,
                            fechadesde: _this.fechadesde,
                            fechahasta: _this.fechahasta,
                            porciento: _this.porciento,
                        })
                            .then(function(response){

                                if (response['data'] == 'guardado'){
                                    toastr.success('Se ha guardado con exito')

                                }if (response['data'] == 'fecha ingresada se encuentra en un rango ya utilizado'){
                                    toastr.warning('fecha ingresada se encuentra en un rango ya utilizado');
                                }if (response['data'] == 'fecha fin no puedes estar antes de la fecha inicial'){
                                    toastr.warning('fecha fin no puedes estar antes de la fecha inicial');
                                }
                            })
                            .catch(function (error) {
                                toastr.error('se ha producido un error');
                            });
                    }
                },
                datos:function () {
                    _this = this;

                    axios.post('/impuestoref/datos',{
                        codigo:_this.codigo
                    })
                        .then(function(response){
                            if (response['data'] == 'no resultado con ese id'){
                                toastr.warning('no resultado con ese codigo');
                            }else{
                                console.log(response)
                                _this.id = response['data'][0].id;
                                _this.descripcion = response['data'][0].descripcion;
                                _this.identificador = response['data'][0].identificador;
                                _this.datotabla = response['data'][1];
                            }

                        })
                        .catch(function (error) {
                            console.log(error)
                            toastr.error('se ha producido un error');
                        });
                },
                guardarrango:function () {
                    _this = this;

                    if (_this.fechadesde == _this.fechahasta || _this.fechahasta == _this.fechadesde){
                        toastr.warning('Las fechas no pueden ser iguales');
                    }else{
                        axios.post('/impuestoref/ingresar/rango',{
                            id : _this.id,
                            fechadesde: _this.fechadesde,
                            fechahasta: _this.fechahasta,
                            porciento: _this.porciento,
                            descripcion: _this.descripcion,
                            identificador: _this.identificador,
                        })
                            .then(function(response){
                                if (response['data'] == 'guardado'){
                                    toastr.success('Se ha guardado con exito');
                                    _this.datos();
                                    _this.fechadesde = '';
                                    _this.fechahasta = '';
                                    _this.porciento = 0;
                                }if (response['data'] == 'fecha ingresada se encuentra en un rango ya utilizado'){
                                    toastr.warning('fecha ingresada se encuentra en un rango ya utilizado');
                                }if (response['data'] == 'fecha fin no puedes estar antes de la fecha inicial'){
                                    toastr.warning('fecha fin no puedes estar antes de la fecha inicial');
                                }

                            })
                            .catch(function (error) {
                                toastr.error('se ha producido un error');
                            });
                    }
                },
                editarrango:function () {
                    _this = this;
                    axios.post('/impuestoref/editar/rango',{
                        rango: _this.datotabla,
                    })
                        .then(function(response){
                            toastr.success('Se ha guardado con exito');
                            _this.editar = false
                            _this.datos();
                            console.log(response['data'])
                        })
                        .catch(function (error) {
                            toastr.error('se ha producido un error');
                        });
                }
            },
            computed:{

            }
        })
    </script>
@endsection