<div class="modal fade" id="modaltipof" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Crear Tipo Factura</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row form-group">
                    <div class="col-sm-5">
                        <label for="nombre" class=" form-control-label">Nombre</label>
                    </div>
                    <div class="col-sm-6">
                        <input type="text" id="nombre" maxlength="20" placeholder=""  v-model="nombretf" class="form-control form-control-sm">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-sm" @click="nuevotipofactura">Guardar</button>
            </div>
        </div>
    </div>
</div>