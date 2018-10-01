<div class="modal fade" id="crear" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header" >
                <h5 class="modal-title" id="exampleModalCenterTitle" style="color: #0069d9">Nuevo producto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" >
                <div class="card" style="background: white">

                    <div class="card-body">
                        <div class="card-title">
                            <h3 class="text-center title-2" style="color: #0069d9">Agregar Producto</h3>
                        </div>
                        <hr style="color: white">
                        <form action="productos" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-group">
                                <label for="cc-payment" class="control-label mb-1" >Nombre</label>
                                <input id="cc-pament" name="nombre" minlength="0" required type="text" class="form-control" aria-required="true" aria-invalid="false" value="">
                            </div>
                            <div class="form-group">
                                <label for="precio" class="control-label mb-1" >Precio</label>
                                <input type="number" id="precio" min="0" name="precio" required placeholder="$:" class="input-sm form-control-sm form-control">
                            </div>
                            <div class="form-group">
                                <label for="Cbarra" class="control-label mb-1" >Codigo de barra</label>
                                <input type="text" id="Cbarra"  required name="Cbarra" placeholder="" class="input-sm form-control-sm form-control">
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="existencia" class="control-label mb-1">Existencia</label>
                                        <input id="existencia" min="0" name="existencia" required type="number" class="form-control cc-exp" value="0" data-val="true" data-val-required="Es necesario es te dato"
                                               data-val-cc-exp="Please enter a valid month and year" placeholder="" >
                                        <span class="help-block" data-valmsg-for="cc-exp" data-valmsg-replace="true"></span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <label for="impuesto" class="control-label mb-1" >Impuesto</label>
                                    <div class="input-group">
                                        <input id="impuesto" min="0" required name="impuesto" type="number" class="form-control cc-cvc" value="0">
                                    </div>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col col-md-3">
                                    <label for="file-input" class=" form-control-label">Imagen</label>
                                </div>
                                <div class="col-12 col-md-9">
                                    <input type="file" id="file-input"  name="img" class="form-control-file">
                                </div>
                            </div>
                            <div>
                                <button id="payment-button" type="submit" class="btn btn-lg btn-info btn-block">
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