<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Cuentas por cobrar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row form-group">
                    <div class="col-sm-5">
                        <label for="nuevotcxp" class=" form-control-label">Nombre</label>
                    </div>
                    <div class="col-sm-6">
                        <input type="text" id="nuevotcxp" maxlength="20" placeholder="" v-model="nuevotipocxpnombre" class="form-control form-control-sm">
                    </div>
                </div>
            </div>
            <div class="">
                 <div class="text-center" style="margin-bottom: 20px">
                     <button type="button" @click="nuevotcxp" class="btn btn-primary btn-sm">Guardar</button>
                 </div>
            </div>
        </div>
    </div>
</div>