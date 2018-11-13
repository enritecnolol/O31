<div class="modal fade" id="ticketcambio" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ticket de Cambio</h5>
                <button type="button" onclick=" location.reload() " class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="myPrintArea">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="text-center">
                                <img :src="'/imagenes/'+compania.img" width="100" alt="">
                            </div>
                        </div>
                        <div class="col-md-12" style="margin-top: 15px">
                            <div class="text-left">
                                <strong>Fecha</strong>: @{{ fecha }}
                            </div>
                            <div class="text-left">
                                <strong>No.Ticket</strong>: @{{ idticket }}
                            </div>
                            <div class="text-left">
                                <strong>Telefono</strong>: @{{ compania.telefono }}
                            </div>
                            <div class="text-left">
                                <strong>Direccion</strong>: @{{ compania.pais }}, @{{ compania.ciudad }}
                            </div>
                        </div>
                        <div class="col-md-12">
                            <hr>
                        </div>
                        <div class="col-md-12">
                            <div class="text-center">
                                <h4>Cliente:</h4>
                            </div>
                            <div class="text-left">
                                <strong>Nombre: </strong> @{{ nombre2 }}
                            </div>
                            <div class="text-left">
                                <strong>Telefono: </strong> @{{ telefono2 }}
                            </div>
                            <div class="text-left">
                                <strong>Email: </strong> @{{ email2 }}
                            </div>
                            <div class="text-left">
                                <strong>Matricula: </strong> @{{ matricula2 }}
                            </div>
                        </div>
                        <div class="col-md-12">
                            <hr>
                        </div>
                        <div class="col-md-12">
                            <div class="text-center" style="margin: 60px;border-radius: 200px 200px 200px 200px;box-shadow: 0px 0px 38px -8px rgba(0,0,0,0.75);">
                                <label for="" style="font-size: 70px;">@{{ montocambio }}</label>
                                <br>
                                <label for="" style="font-size: 30px">Puntos</label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="text-center">
                                <small>Este ticket solo es valido durante 7 dias</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick=" location.reload() " data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="imprimir">Imprimir</button>
            </div>
        </div>
    </div>
</div>