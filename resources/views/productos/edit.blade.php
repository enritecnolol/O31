<div class="modal fade" id="largeModal" tabindex="-1" role="dialog" aria-labelledby="largeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="largeModalLabel">Editar Productos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form :action="'/anja/' + datos.id" method="POST"  enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div>
                        <div class="form-group">
                            <label for="cc-payment" class="control-label mb-1">Nombre</label>
                            <input id="nombrem" v-model="datos.name" required minlength="0" name="nombre" type="text" class="form-control" aria-required="true" aria-invalid="false" value="{{ old('nombre') }}">
                        </div>
                        <div class="form-group">
                            <label for="precio" class="control-label mb-1">Precio</label>
                            <input type="number" v-model="datos.price" required id="preciom" min="0" value="{{ old('precio') }}" name="precio" placeholder="$:" class="input-sm form-control-sm form-control">
                        </div>
                        <div class="form-group">
                            <label for="Cbarra" class="control-label mb-1">Codigo</label>
                            <input type="text" id="Cbarram" value="{{ old('barcode') }}" v-model="datos.barcode" minlength="0" name="Cbarra" placeholder="" class="input-sm form-control-sm form-control">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <p>El codigo ya es existente</p>
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="" class="control-label mb-1">El producto es Compuesto?</label>
                            <div class="container">
                                <div class="row">
                                    <select class="form-control form-control-sm" v-model="datos.compuesto"  name="compuesto" id="exampleFormControlSelect1">
                                        <option value="no">No</option>
                                        <option value="si">Si</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="control-label mb-1">Grabado de itbis ? </label>
                            <button type="button" class="btn btn-outline-secondary btn-sm" :class="check ? '' : 'active'" @click="check = false">No</button>
                            <button type="button" class="btn btn-outline-secondary btn-sm"  :class="check ? 'active' : ''"  @click="check = true">Si</button>
                        </div>

                        <div class="form-group" v-if="check == true">
                            <label for="" class="control-label mb-1">Clasificacion de ITBIS</label>
                            <div class="container">
                                <div class="row">
                                    <select class="form-control" v-model="datos.impuestoref_id" required name="refimpuestoid" id="exampleFormControlSelect1">
                                        <option value="0">No Itbis</option>
                                        <template v-for="ref in refimpuesto">
                                            <option :value="ref.id">@{{ ref.descripcion}}</option>
                                        </template>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div v-else>
                            <input type="text" hidden name="refimpuestoid"  value="0" style="margin-right: 5px" required readonly class="input-sm col-sm-1 text-center form-control-sm form-control">
                        </div>

                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Categoria</label>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <button type="button" data-toggle="modal" data-target="#nuevacategoria"><span style="color: green"><i class="fas fa-plus"></i></span></button>
                                    </div>
                                </div>
                                <select class="form-control" v-model="datos.categoria_id" name="categoria" id="exampleFormControlSelect1">
                                    <option value="">-selecciona-</option>
                                    <template v-for="c in listacategoria">
                                        <option :value="c.id" >@{{ c.nombre }}</option>
                                    </template>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Subcategoria</label>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <button type="button" data-toggle="modal" data-target="#createsubcategoria"><span style="color: #0062cc"><i class="fas fa-plus"></i></span></button>
                                    </div>
                                </div>
                                <select class="form-control" v-model="datos.subcategoria_id" required :disabled="datos.subcategoria_id == null" name="subcategoria" id="exampleFormControlSelect1">
                                    <option value="">-selecciona-</option>
                                    <template v-for="sc in listasubcategoriaedit">
                                        <option :value="sc.id">@{{ sc.nombre }}</option>
                                    </template>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="estadoSelect" class="control-label mb-1">Estado</label>
                            <div class="container">
                                <div class="row">
                                    <select class="form-control" v-model="datos.estado" required name="estado" id="estadoSelect">
                                        <option value="1">Activo</option>
                                        <option value="0">Inactivo</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row form-group" v-if="!image">
                            <div class="col col-md-3">
                                <label for="file-input" class=" form-control-label">Imagen</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <input type="file" id="imagen" name="img">

                            </div>
                        </div>
                        <div class="row form-group" v-else>
                            <div class="col col-md-3">
                                <div class="row">
                                    <div class="col">
                                        <img :src="image" style="width: 100px; height: 100px"/>
                                    </div>
                                    <div class="col">
                                        <img style="width: 100px; height: 100px" :src="'imagenes/' + datos.img"  alt="">
                                    </div>
                                </div>
                                <button @click="removeImage">Remove image</button>
                            </div>
                        </div>

                    </div>
                    <div>
                        <button id="payment-button"  type="submit" class="btn btn-lg btn-info btn-block">
                            <i class="fa fa-check-square fa-lg"></i>&nbsp;
                            <span id="payment-button-amount">Guardar</span>
                            <span id="payment-button-sending" style="display:none;">Enviando…</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>