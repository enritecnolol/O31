<div class="modal fade" id="FacturasEnPausa" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">LISTA DE PEDIDO</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <div class="col-md-2">
                            <button type="button" :disabled="!listLength > 0" @click="agregarFacturaEspera" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Agregar pedido</button>
                        </div>
                        <div class="col-md-12">
                            <hr>
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-12 text-center" v-if="ListaEnEsperaLenght == 0">
                                    <b>No hay facturas en espera en este momento</b>
                                </div>
                                <div class="col-md-4" v-for="(item, index) in ListaEnEspera">
                                    <div class="card" style="width: 18rem;">
                                        <div class="card-header">
                                            <b>Referencia: </b> @{{ item.reference }}<br>
                                            <b>Consumo: </b> @{{ item.donde_consumo == 'llevar' ? 'Para llevar' : 'Comer aquí' }}<br>
                                            <b>Fecha: </b> @{{ item.hora }}
                                        </div>
                                        <div class="card-body" style="padding: 0 !important;">
                                            <h6 class="card-subtitle mb-2 text-muted" style="margin-top: 5px;margin-left: 2px;"><b>Nota:</b> @{{ item.note }}</h6>
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item"
                                                    style="font-size: 14px"
                                                    v-for="(listItem , index) in item.list">@{{ listItem.count }} <i class="fas fa-arrow-right"></i> @{{ listItem.name }}</li>
                                            </ul>
                                        </div>
                                        <div class="card-footer">
                                            <div class="row">
                                                <div class="col-md-6" style="padding:0;">
                                                    <button
                                                            type="button"
                                                            class="btn btn-success"
                                                            style="width: 100%; margin-right: 2px"
                                                            @click="reasignarFactura(item, index)"><i class="fas fa-reply"></i> Retomar</button>
                                                </div>
                                                <div class="col-md-6" style="padding:0;">
                                                    <button
                                                            type="button"
                                                            class="btn btn-warning"
                                                            style="width: 100%; margin-left: 2px"
                                                            @click="printPedido(item, index)"><i class="fas fa-print"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
