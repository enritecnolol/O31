@extends('main.app')
@section('tittle','Cafeteria | Tabla itbis(%)')

@section('titulo')
    <h3 style="color: white"><i class="fas fa-arrow-circle-right"></i> Definir tabla itbis (%)</h3>
@endsection

@section('aside')
    @include('caja.siderbar')
@endsection

@section('content')
    <div class="container">
        <div class="card" style="box-shadow:rgb(136, 136, 136) 1px 1px 4px;">
            <div class="card-body">
                <div class="text-center">
                    <h4><strong>Definir tabla Itbis % <button type="button" style="float: right" class="btn btn-primary btn-sm">Clasificacion de impuestos de productos</button></strong></h4>
                </div>
                <hr style="background: #4272d7;">
                <div class="row">
                    <div class="col-md-6">
                        <div style="float: right">
                            <div class="form-group">
                                <label for="company" class=" form-control-label"><strong>Secuencia No.</strong></label>
                                <input type="number" id="" v-model="secuencia" @keypress.enter="editarbuscar(secuencia)" min="0" value="0" name="secuenciano" placeholder="" class="form-control col-sm-2">
                            </div>
                            <template v-if="datoseditar == ''">
                                <div class="form-group">
                                    <label for="company" class=" form-control-label"><strong>Desde Fecha <span style="color: red">*</span></strong></label>
                                    <input type="date" id=""  v-model="fechadesde" required name="desdefecha" placeholder="" class="form-control form-control-sm col-sm-6">
                                </div>
                                <div class="form-group">
                                    <label for="company" class=" form-control-label"><strong>Hasta Fecha <span style="color: red">*</span></strong></label>
                                    <input type="date" id="" required  v-model="fechahasta" name="hastafecha" placeholder="" class="form-control form-control-sm col-sm-6">
                                </div>
                                <div class="form-group">
                                    <label for="company" class=" form-control-label"><strong>Valor itbis <span style="color: red">*</span></strong></label>
                                    <input type="number" id=""  value="0" min="0" v-model="itbis" required name="itbis" placeholder="" class="form-control col-sm-2">
                                </div>
                            </template>
                            <template v-else>
                                <div class="form-group">
                                    <label for="company" class=" form-control-label"><strong>Desde Fecha <span style="color: red">*</span></strong></label>
                                    <input type="date" id=""  v-model="datoseditar.desde" required name="desdefecha" placeholder="" class="form-control form-control-sm col-sm-6">
                                </div>
                                <div class="form-group">
                                    <label for="company" class=" form-control-label"><strong>Hasta Fecha <span style="color: red">*</span></strong></label>
                                    <input type="date" id="" required  v-model="datoseditar.hasta" name="hastafecha" placeholder="" class="form-control form-control-sm col-sm-6">
                                </div>
                                <div class="form-group">
                                    <label for="company" class=" form-control-label"><strong>Valor itbis <span style="color: red">*</span></strong></label>
                                    <input type="number" id="" @keypress.enter="editaritbis" value="0" min="0" v-model="datoseditar.itbis" required name="itbis" placeholder="" class="form-control col-sm-2">
                                </div>
                            </template>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div style="width: 340px; height: 300px ;overflow-y: scroll">
                            <table class="table table-responsive">
                                <thead>
                                <tr>
                                    <th scope="col">Sec</th>
                                    <th scope="col">Desde</th>
                                    <th scope="col">Hasta</th>
                                    <th scope="col">Itbis</th>
                                </tr>
                                </thead>
                                <tbody>
                                <template v-if="datos != 'no resultado'">
                                    <template v-for="item in datos">
                                        <tr>
                                            <th scope="row">@{{ item.id }}</th>
                                            <td>@{{ item.desde }}</td>
                                            <td>@{{ item.hasta }}</td>
                                            <td>@{{ item.itbis }}.00</td>
                                        </tr>
                                    </template>
                                </template>
                                <template v-else>
                                    <tr>
                                        <th scope="row">No</th>
                                        <td>Hay</td>
                                        <td>Datos</td>
                                        <td>Disponible</td>
                                    </tr>
                                </template>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <hr style="background: #4272d7;">
                <div class="text-center">
                    <button type="button" @click="nuevoitbis" v-if="datoseditar == ''" class="btn btn-primary btn-sm">
                        <i class="fas fa-save"></i> Guardar
                    </button>
                    <button v-else type="button" @click="editaritbis" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i> Editar
                    </button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scriptp')

    <script !src="">

        var inicio ;
        var fin ;

        $(function() {
            $('input[name="daterange"]').daterangepicker({
                opens: 'left',
                locale: {
                    format: 'DD/MM/YYYY'
                },
            }, function(start, end, label) {
                inicio = start.format('YYYY-MM-DD');
                fin = end.format('YYYY-MM-DD');


            });
        });

        new Vue({
            el: '#Vue',
            data(){
                return {
                    secuencia:0,
                    fechadesde: '',
                    fechahasta: '',
                    itbis:0,
                    datos:'',
                    datoseditar:'',
                }

            },watch: {

            },
            mounted(){
                _this = this;
                _this.mostrartabla()

            },
            methods:{
                nuevoitbis:function () {
                    _this = this;

                    if (_this.fechadesde == '' || _this.fechahasta == '' || _this.itbis == 0){
                        toastr.warning('por favor llenar los campos importantes');
                    }else{
                        axios.post('/nuevo/itbis', {
                            // secuencia: _this.secuencia ,
                            fechadesde: _this.fechadesde,
                            fechahasta: _this.fechahasta,
                            itbis: _this.itbis
                        })
                            .then(function (response) {
                                _this.fechadesde = '';
                                _this.fechahasta = '';
                                _this.itbis = 0;
                                toastr.success('Se ha agregado un nuevo itbis');
                                _this.mostrartabla();
                            })
                            .catch(function (error) {
                                toastr.error('Se ha producido un error');
                            });
                    }
                },
                mostrartabla:function () {
                    _this = this;
                    axios.post('/itbis/datos')
                        .then(function (response) {
                            _this.datos = response["data"];
                        })
                        .catch(function (error) {
                            toastr.error('al tomar los datos de la tabla');
                        });

                },
                editarbuscar:function (secuencia) {
                    _this = this;
                    if (_this.fechadesde == '' || _this.fechahasta == '' || _this.itbis == 0){
                        toastr.warning('por favor llenar los campos importantes');
                    }else {
                        axios.post('/itbis/editar/buscar',{
                            id:secuencia
                        })
                            .then(function (response) {
                                console.log(response["data"]);
                                if (response["data"] == 'no resultado'){
                                    toastr.warning('No hay resultado con esa secuencia');
                                }else {
                                    _this.datoseditar = response["data"];
                                }
                            })
                            .catch(function (error) {
                                toastr.error('se ha producido un error al buscar el itbis');
                            });
                    }
                },
                editaritbis:function () {
                    _this = this;
                    axios.post('/itbis/editar',{
                        datos:_this.datoseditar
                    })
                        .then(function (response) {
                            if (response['data'] == 'editado'){
                                toastr.success('se ha editado con exito');
                                _this.mostrartabla();
                            }
                        })
                        .catch(function (error) {
                            toastr.error('se ha producido un error al editar');
                        });
                }

            },
            computed:{

            }
        })
    </script>
@endsection