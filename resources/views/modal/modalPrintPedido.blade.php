<div class="modal fade" id="pedidoPrint" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Pedido</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="max-height: calc(100vh - 200px);overflow-y: auto;">
                <div id="myPrintAreaPedido" style="color: #000;margin: 0 auto;display: inline;width: 400px;">
                    <div class="row">
                        <div class="col-md-12">
                            <h2 style="text-align: center;width: 400px;">Pedido por preparar</h2>
                        </div>
                        <div class="col-12">
                            <div style="border-top:1px solid #000; padding-top:10px;width: 400px;"></div>
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-12" style="width: 400px;">
                                    <b>Referecia: </b> @{{ printPedidoData.reference }}
                                </div>

                                <div class="col-md-12">
                                    <div style="width: 400px;">
                                        <b>Nota: </b> <p>@{{ printPedidoData.note }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div style="margin-bottom: 5px;clear:both;">
                                <table style="width: 400px;">
                                    <thead style="border-bottom: 1px solid black;border-top: 1px solid black;font-weight: bold;text-align: left;">
                                    <tr>
                                        <td style="font-weight: bold;color: #000;">Producto</td>
                                        <td style="font-weight: bold;color: #000;text-align: center;">Cantidad</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="item in printPedidoData.list">
                                        <td style="font-size: 14px;color: #000;" width="50%"><label>@{{item.name.toUpperCase()}}</label></td>
                                        <td style="font-size: 14px;text-align: center;color: #000;" width="20%">@{{item.count}}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary btn" id="printPedidoOrden">Imprimir</button>
            </div>
        </div>
    </div>
</div>
