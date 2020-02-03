@extends('main.app')
@section('tittle','SofiaRD | Configuración de sistema')

@section('titulo')
    <h3 style="color: white"><i class="fas fa-arrow-circle-right"></i> Configuración</h3>
@endsection

@section('aside')
    @include('caja.siderbar')
@endsection

@section('content')
    <div class="container" style="margin-top: -35px">
        <div class="card">
            <div class="card-body">
                <div class="col-md-12">
                    <div class="text-center" style="background: #4272d7;margin-top: 2px;margin-bottom: 2px">
                        <strong style="font-size: 24px;color: white"><i class="far fa-building"></i> Compañia</strong>
                        <small style="color: white">Formulario</small>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="text-right">
                        <button type="button" class="btn btn-sm btn-primary" @click="openmodal"><i class="fa fa-key"></i> Cambiar Contraseña</button>
                    </div>
                    <br>
                </div>
                <div class="col-md-12" v-if="infoconfig == 'no'">
                    <form action="/configuracion/store" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="card" style="box-shadow:rgb(136, 136, 136) 1px 1px 5px;">
                            <div class="card-body card-block">
                                <div class="form-group">
                                    <label for="company" class=" form-control-label"><strong>Nombre Compañia</strong></label>
                                    <input type="text" required autofocus  name="nombreempresa" placeholder="Ingrese nombre de la compañia" class="form-control">
                                </div>
                                <div class="row form-group">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="vat" class=" form-control-label"><strong>Teléfono</strong></label>
                                            <input type="text" maxlength="11"  required name="telefono"  placeholder="0000000000" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="vat" class=" form-control-label"><strong>RNC</strong></label>
                                            <input type="text" maxlength="11"  required name="rnc"  placeholder="" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="city" class=" form-control-label"><strong>Ciudad</strong></label>
                                            <input type=""  required name="ciudad" placeholder="Ciudad" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="postal-code" class=" form-control-label"><strong>País</strong></label>
                                            <input type=""  required name="pais" placeholder="Pais" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="street" class=" form-control-label"><strong>Dirección</strong></label>
                                    <input type="text"  required name="direccion" placeholder="Ingrese la Dirección" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="logo" class=" form-control-label"><strong>Logo</strong></label>
                                    <input type="file"  name="img" class="form-control-file">
                                </div>
                                <hr>
                                <div class="row form-group">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="city" class=" form-control-label"><strong>Manejo de Impuesto?</strong></label>
                                            <select required name="impuesto" class="form-control">
                                                <option value="">Selecciona</option>
                                                <option value="sumado">Sumado</option>
                                                <option value="incluido">Incluido</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="postal-code" class=" form-control-label"><strong>Manejo de Descuento?</strong></label>
                                            <select required class="form-control" name="descuento">
                                                <option value="">Selecciona</option>
                                                <option value="si">si</option>
                                                <option value="si">no</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="" class=" form-control-label"><strong>Control inventario?</strong></label>
                                            <select required disabled name="inventario" class="form-control">
                                                <option value="">Selecciona</option>
                                                <option value=true>Si</option>
                                                <option value=false selected>No</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="" class=" form-control-label"><strong>Email resumen del dia</strong></label>
                                            <input type="text" class="form-control" required name="emailinfo">
                                        </div>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="" class=" form-control-label"><strong>Genera comprobante fiscal</strong></label>
                                            <select required name="generacomprobante" class="form-control">
                                                <option value="">Selecciona</option>
                                                <option value="si">Si</option>
                                                <option value="no">No</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="" class=" form-control-label"><strong>10% de ley</strong></label>
                                            <select required name="leycamarero" class="form-control">
                                                <option value="">Selecciona</option>
                                                <option value="si">Si</option>
                                                <option value="no">No</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer" style="background: white;box-shadow:rgb(136, 136, 136) 1px 1px 4px;">
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary btn-sm">
                                        <i class="fa fa-dot-circle-o"></i> Guardar
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm">
                                        <i class="fa fa-ban"></i> Resetear
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="col-md-12" v-else>
                    <div class="card" style="box-shadow:rgb(136, 136, 136) 1px 1px 5px;">
                        <form action="/configuracion/edit" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="id" v-model="infoconfig.id">
                            <div class="card-body card-block">
                                <div class="form-group">
                                    <label for="company" class=" form-control-label"><strong>Nombre Compañia</strong></label>
                                    <input type="text"   :disabled="editar == false" required v-model="infoconfig.nombreempresa" name="nombreempresa" placeholder="Ingrese nombre de la compañia" class="form-control">
                                </div>
                                <div class="row form-group">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="vat" class=" form-control-label"><strong>Teléfono</strong></label>
                                            <input type="text" maxlength="11" :disabled="editar == false" required v-model="infoconfig.telefono"  name="telefono"  placeholder="0000000000" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="vat" class=" form-control-label"><strong>RNC</strong></label>
                                            <input type="text" maxlength="11"  :disabled="editar == false" required name="rnc" v-model="infoconfig.rnc" placeholder="" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="city" class=" form-control-label"><strong>Ciudad</strong></label>
                                            <input type=""  :disabled="editar == false" required v-model="infoconfig.ciudad"  name="ciudad" placeholder="Ciudad" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="postal-code" class=" form-control-label"><strong>País</strong></label>
                                            <input type=""  required :disabled="editar == false" v-model="infoconfig.pais"  name="pais" placeholder="Pais" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="street" class=" form-control-label"><strong>Dirección</strong></label>
                                    <input type="text"  required :disabled="editar == false" v-model="infoconfig.direccion"  name="direccion" placeholder="Ingrese la Dirección" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="logo" class=" form-control-label"><strong>Logo</strong></label>
                                    <br>
                                    <img :src="'imagenes/'+infoconfig.img" style="width: 100px;height: 100px" alt="">
                                    <input type="file"  :disabled="editar == false" name="img" class="form-control-file">
                                </div>
                                <hr>
                                <div class="row form-group">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="city" class=" form-control-label"><strong>Manejo de Impuesto?</strong></label>
                                            <select :disabled="editar == false" required v-model="infoconfig.impuesto" name="impuesto" class="form-control">
                                                <option value="">Selecciona</option>
                                                <option value="sumado">Sumado</option>
                                                <option value="incluido">Incluido</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="postal-code" class=" form-control-label"><strong>Manejo de Descuento?</strong></label>
                                            <select :disabled="editar == false" required v-model="infoconfig.descuento" class="form-control" name="descuento">
                                                <option value="">Selecciona</option>
                                                <option value="si">si</option>
                                                <option value="si">no</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="" class=" form-control-label"><strong>Control inventario?</strong></label>
                                            <select required :disabled="true" v-model="infoconfig.controlinv" name="inventario" class="form-control">
                                                <option value="">Selecciona</option>
                                                <option value="si">Si</option>
                                                <option value="no" selected>No</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="" class=" form-control-label"><strong>Email resumen del dia</strong></label>
                                            <input type="text" :disabled="editar == false" class="form-control" v-model="infoconfig.emailinfo" name="emailinfo" aria-describedby="emailHelp" placeholder="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="" class=" form-control-label"><strong>Genera comprobante fiscal</strong></label>
                                            <select required :disabled="editar == false" v-model="infoconfig.generacomprobante" name="generacomprobante" class="form-control">
                                                <option value="">Selecciona</option>
                                                <option value="si">Si</option>
                                                <option value="no">No</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="" class=" form-control-label"><strong>10% de ley</strong></label>
                                            <select required :disabled="editar == false" v-model="infoconfig.leycamarero" name="leycamarero" class="form-control">
                                                <option value="">Selecciona</option>
                                                <option value="si">Si</option>
                                                <option value="no">No</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer" style="background: white;box-shadow:rgb(136, 136, 136) 1px 1px 4px;">
                                <div class="text-center">
                                    <button type="button" v-if="editar == false" @click="editar = true" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i> editar
                                    </button>
                                    <button type="submit" v-else class="btn btn-success btn-sm">
                                        <i class="fas fa-save"></i> Guardar
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('modal.changepassword')
@endsection

@section('scriptp')
    <script !src="">
        var config = '{{$config}}';
        config = JSON.parse(config.replace(/&quot;/g,'"'));
        new Vue({
            el: '#Vue',
            data: {
                infoconfig: config,
                editar:false,
                oldpass:'',
                newpass:'',
                passreplay:''
            },watch: {

            },
            methods:{
                openmodal(){
                    $('#changepass').modal('show');
                },
                changepassword()
                {
                    if (!this.oldpass || !this.newpass || !this.passreplay)
                    {
                        toastr.warning("Por llenar todos los campo de cambio de contrasena");
                        return;
                    }
                    if (this.newpass != this.passreplay){
                        toastr.warning("Las contrasenas no coinciden");
                        return;
                    }
                    axios.post('/change/pass', {
                        oldpass:this.oldpass,
                        newpass:this.newpass,
                        passreplay:this.passreplay
                    })
                        .then( (response) => {
                            toastr.success("Las Clave ha sido cambiada");
                            $('#changepass').modal('hide');
                            this.newpass = "";
                            this.oldpass = "";
                            this.passreplay = "";
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