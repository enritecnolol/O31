<div class="modal fade" id="createfc" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Nuevo NFC</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row form-group">
                    <div class="col-sm-5">
                        <label for="Nombrenfc" class=" form-control-label">Nombre</label>
                    </div>
                    <div class="col-sm-6">
                        <input type="text" id="Nombrenfc" maxlength="20" v-model="nombrenfc" placeholder=""  class="form-control form-control-sm">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" @click="nuevonfc" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </div>
</div>