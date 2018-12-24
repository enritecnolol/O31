<div class="modal fade" id="clientep" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Cliente Preferencial</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="fas fa-code"></i></div>
                        </div>
                        <input type="text" id="matriculaa" v-model="idcliente" @keypress.capture="asinarcliente" list="matricullist" placeholder="Matricula" class="form-control" autofocus>
                        <datalist id="matricullist">
                            <template v-for="algo in datoscliente">
                                <option :value="algo.matricula">@{{ algo.nombre }}</option>
                            </template>
                        </datalist>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary btn-sm">Seguir</button>
            </div>
        </div>
    </div>
</div>