<div class="modal fade" id="quantityInput" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Insertar cantidad</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <h2>Cantidad: @{{ inputQuantity }}</h2>
                        </div>
                        <div class="col-md-12">
                            <hr>
                        </div>
                        <div class="col-md-4">
                            <button type="button"
                                    class="btn btn-secondary"
                                    @click="addInputQuantity('7')"
                                    style="width: 100%;height: 100px;margin-bottom: 5px;font-size: 50px">7</button>
                        </div>
                        <div class="col-md-4">
                            <button type="button"
                                    class="btn btn-secondary"
                                    @click="addInputQuantity('8')"
                                    style="width: 100%;height: 100px;margin-bottom: 5px;font-size: 50px">8</button>
                        </div>
                        <div class="col-md-4">
                            <button type="button"
                                    class="btn btn-secondary"
                                    @click="addInputQuantity('9')"
                                    style="width: 100%;height: 100px;margin-bottom: 5px;font-size: 50px">9</button>
                        </div>
                        <div class="col-md-4">
                            <button type="button"
                                    class="btn btn-secondary"
                                    @click="addInputQuantity('4')"
                                    style="width: 100%;height: 100px;margin-bottom: 5px;font-size: 50px">4</button>
                        </div>
                        <div class="col-md-4">
                            <button type="button"
                                    class="btn btn-secondary"
                                    @click="addInputQuantity('5')"
                                    style="width: 100%;height: 100px;margin-bottom: 5px;font-size: 50px">5</button>
                        </div>
                        <div class="col-md-4">
                            <button type="button"
                                    class="btn btn-secondary"
                                    @click="addInputQuantity('6')"
                                    style="width: 100%;height: 100px;margin-bottom: 5px;font-size: 50px">6</button>
                        </div>
                        <div class="col-md-4">
                            <button type="button"
                                    class="btn btn-secondary"
                                    @click="addInputQuantity('1')"
                                    style="width: 100%;height: 100px;margin-bottom: 5px;font-size: 50px">1</button>
                        </div>
                        <div class="col-md-4">
                            <button type="button"
                                    class="btn btn-secondary"
                                    @click="addInputQuantity('2')"
                                    style="width: 100%;height: 100px;margin-bottom: 5px;font-size: 50px">2</button>
                        </div>
                        <div class="col-md-4">
                            <button type="button"
                                    class="btn btn-secondary"
                                    @click="addInputQuantity('3')"
                                    style="width: 100%;height: 100px;margin-bottom: 5px;font-size: 50px">3</button>
                        </div>
                        <div class="col-md-4">
                            <button type="button"
                                    class="btn btn-secondary"
                                    @click="inputQuantity = '0'"
                                    style="width: 100%;height: 100px;margin-bottom: 5px;font-size: 20px">Reset</button>
                        </div>
                        <div class="col-md-4">
                            <button type="button"
                                    class="btn btn-secondary"
                                    @click="addInputQuantity('0')"
                                    style="width: 100%;height: 100px;margin-bottom: 5px;font-size: 50px">0</button>
                        </div>
                        <div class="col-md-4">
                            <button type="button"
                                    class="btn btn-secondary"
                                    @click="addInputQuantity('.')"
                                    style="width: 100%;height: 100px;margin-bottom: 5px;font-size: 50px">.</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-md-6">
                        <button type="button"
                                class="btn btn-danger"
                                style="height: 50px;width: 100%"
                                @click="closeInputQuantityModal"><i class="fas fa-window-close"></i> Cancelar</button>
                    </div>
                    <div class="col-md-6">
                        <button type="button"
                                class="btn btn-success"
                                style="height: 50px;width: 100%"
                                @click="pfactura"><i class="fas fa-thumbs-up"></i>Listo!</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
