<div class="modal fade" id="nuevocliente" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Crear Cliente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="text-center">
                                <h3>Crear Nuevo Cliente</h3>
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
                            <div class="text-center">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" @click="nuevocliente" class="btn btn-primary">
                    <i class="fas fa-save"></i> Guardar
                </button>
            </div>
        </div>
    </div>
</div>