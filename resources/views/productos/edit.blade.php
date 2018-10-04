<div class="modal fade" id="largeModal" tabindex="-1" role="dialog" aria-labelledby="largeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="largeModalLabel">Editar Productos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" @mousemove="cargarcategoria()">
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
                            <label for="exampleFormControlSelect1">Categoria</label>
                            {{--<label class="sr-only" for="inlineFormInputGroup">Categoria</label>--}}
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
                        {{--<div class="row">--}}
                            {{--<div class="col-6">--}}
                                {{--<div class="form-group">--}}
                                    {{--<label for="existencia" class="control-label mb-1">Existencia</label>--}}
                                    {{--<input id="existenciam"  v-if="datos.barcode == 'compuesto'"  readonly v-model="datos.existence" name="existencia" type="number" min="0" class="form-control cc-exp" >--}}
                                    {{--<input id="existenciam"  v-else v-model="datos.existence" name="existencia" type="number" min="0" class="form-control cc-exp" >--}}
                                    {{--<span class="help-block" data-valmsg-for="cc-exp" data-valmsg-replace="true"></span>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="col-6">--}}
                                {{--<label for="impuesto" class="control-label mb-1">Impuesto</label>--}}
                                {{--<div class="input-group">--}}
                                    {{--<input id="impuestom" v-if="datos.barcode == 'compuesto'" readonly v-model="datos.impost" min="0" name="impuesto" type="number" class="form-control cc-cvc" value="" data-val="true" data-val-required="Ingrese el impuesto del producto" data-val-cc-cvc="Ingrese el impuesto del producto">--}}
                                    {{--<input id="impuestom" v-else v-model="datos.impost" min="0" name="impuesto" type="number" class="form-control cc-cvc" value="" data-val="true" data-val-required="Ingrese el impuesto del producto" data-val-cc-cvc="Ingrese el impuesto del producto">--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
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