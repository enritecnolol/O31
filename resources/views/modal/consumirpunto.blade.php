<div class="modal fade bd-example-modal-lg" id="Cpuntos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Usar Puntos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12" v-show="clientedatos == ''">
                            <div class="text-center">
                                <h2>Por favor ingresar un cliente</h2>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="text-center">
                                <div class="text-center">
                                    <label for="" style="font-size: large">Monto a Pagar</label>
                                    <br>
                                    <h1 style="font-size: 100px; font-weight: normal">@{{ neto }}</h1>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="text-center" style="margin-top: 40px">
                                <i class="fas fa-5x fa-arrow-left"></i>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="text-center">
                                <label for="" style="font-size: large">Puntos Actuales</label>
                                <br>
                                    <h1 style="font-size: 100px;font-weight: normal" v-if="clientedatos != ''">@{{ clientedatos.puntos }}</h1>
                                    <h1 style="font-size: 100px;font-weight: normal" v-else>00</h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary btn-sm" @click="facturarconpuntos" v-show="clientedatos != ''">Consumir</button>
            </div>
        </div>
    </div>
</div>