<!-- Modal -->
<div class="modal fade" id="nuevacategoria" tabindex="-56" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Categoria</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-header">
                        <h2>Crear Categoria</h2>
                    </div>
                    <div class="card-body">
                        <form action="" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="form-group">
                                <label for="cc-payment" class="control-label mb-1" >Nombre Categoria</label>
                                <input id="cc-pament" v-model="nombrecategoria" name="categoria" minlength="0" required type="text" class="form-control" aria-required="true" aria-invalid="false" value="">
                            </div>
                            <div class="form-group">
                                <label for="cc-payment" class="control-label mb-1" >codigo</label>
                                <input id="cc-pament" v-model="codigocategoria" name="codigocategoria" minlength="0" required type="text" class="form-control" aria-required="true" aria-invalid="false" value="">
                            </div>
                            <div>
                                <button id="payment-button" @click="crearcategoria()" type="button" class="btn btn-info btn-block">
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
    </div>
</div>