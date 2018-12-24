<div class="modal fade" id="pagofactura" tabindex="-1"  data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Factura</h5>
                <button type="button" onclick=" location.href='/' " class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container" id="myPrintArea">
                    <div class="row">
                        <div class="col-md-12">
                           <div class="text-center">
                               <img src="imagenes/logo.png" width="100" alt="">
                               <br>
                               <h5>COFFEBREAKPOS</h5>
                           </div>
                        </div>
                        <br>
                        <hr>
                        <br>
                        <div class="col-md-12">
                            <div class="form-group text-center">
                                <label for="cc-exp" class="control-label mb-1"><strong>No.factura: </strong> </label>
                                <label for="cc-exp" class="control-label mb-1"># @{{ ultfacture }}</label>
                            </div>
                            <div class="form-group text-center">
                                <label for="cc-exp" class="control-label mb-1"><strong>Fecha: </strong> </label>
                                <label for="cc-exp" class="control-label mb-1"><?php echo date('d-m-Y h:i:s A')?></label>
                            </div>
                        </div>
                        <hr>
                        <div class="col-md-12">
                            <div class="table-responsive" style="margin-bottom: 5px">
                                <table class="table table-sm factura-table" >
                                    <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th>Cant.</th>
                                        <th>Desc.</th>
                                        <th>Total</th>
                                        <th>Itbis</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="item in list">
                                        <td style="line-height: 1">@{{item.name}}</td>
                                        <td class="text-center">@{{item.count}}</td>
                                        <td class="text-center">@{{item.desc}}%</td>
                                        <td class="text-center">@{{item.price}}</td>
                                        <td class="text-center">@{{item.itbis}}%</td>
                                    </tr>
                                    </tbody>
                                    <thead>
                                    <tr>
                                        <th>Total:</th>
                                        <th class="text-center"></th>
                                        <th></th>
                                        <th class="text-center">@{{ neto }}</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-12" style="margin-top: 10px">
                            <div class="container">
                                <div class="row text-center">
                                    <div class="col-sm-12">
                                        <h5 style="float: left">Efectivo: </h5> <p style="float: right"> @{{ campodinero }}</p>
                                    </div>
                                    <div class="col-sm-12">
                                        <h5 style="float: left">Bruto: </h5> <p style="float: right">@{{bruto}}</p>
                                    </div>
                                    <div class="col-sm-12">
                                        <h5 style="float: left">Descuento: </h5> <p style="float: right">@{{ totaldescuento }}</p>
                                    </div>
                                    <div class="col-sm-12">
                                        <h5 style="float: left">Itbis: </h5> <p style="float: right">@{{ algoitbis }}</p>
                                    </div>
                                    <div class="col-md-12">
                                        <h5 style="float: left">Neto: </h5> <p style="float: right">@{{ neto }}</p>
                                    </div>
                                    <div class="col-sm-12">
                                        <h5 style="float: left">Devuelta: </h5> <p style="float: right"> @{{ devuelta }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal" onclick=" location.href='/' ">Close</button>
                <button type="button" class="btn btn-primary btn-sm" id="imprimir">Imprimir</button>
            </div>
        </div>
    </div>
</div>