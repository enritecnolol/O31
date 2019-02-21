<div class="modal fade bd-example-modal-lg" id="changepass" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="">Cambio de Contraseña</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                   <div class="row">
                       <div class="col-md-12">
                           <div class="form-group">
                               <label for="">Contraseña Actual</label>
                               <input type="password" class="form-control" v-model="oldpass" placeholder="Password">
                           </div>
                       </div>
                       <div class="col-md-12">
                           <hr>
                       </div>
                       <div class="col-md-6">
                           <div class="form-group">
                               <label for="">Contraseña Nueva</label>
                               <input type="password" class="form-control"  v-model="newpass" placeholder="Password">
                           </div>
                       </div>
                       <div class="col-md-6">
                           <div class="form-group">
                               <label for="">Repita la Contraseña</label>
                               <input type="password" class="form-control" v-model="passreplay" placeholder="Password">
                           </div>
                       </div>
                   </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary btn-sm" @click="changepassword">Cambiar contraseña</button>
            </div>
        </div>
    </div>
</div>