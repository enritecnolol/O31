<div class="modal fade" id="pago" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mediumModalLabel">Pago de Factura</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="text-center" style="margin-bottom: 20px">
                    <h3 style="font-size: 50px">A PAGAR $: <span style="font-size: 50px; color: red">@{{ format2(parseFloat(neto ), '') }}</span></h3>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="text-right">
                            <span @click="facturaimp = true" v-if="!facturaimp" class="imp"><u>Imprimir Factura</u></span>
                            <span v-else><u>Listo para Imprimir</u></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            <label for="cc-exp" class="control-label mb-1">Efectivo<span style="color: red">*</span></label>
                            <input id="efectivom" name="dinero" autofocus required v-on:keypress.enter="facturar()" type="number" class="form-control cc-exp"  v-model="campodinero">
                        </div>
                    </div>
                    <div class="col-8">
                        <button type="button" class="btn btn-success btn-lg" style="height: 70px;" @click="campodinero = neto">$@{{ parseInt(neto) }}</button>
                        <button type="button" class="btn btn-secondary btn-lg" style="height: 70px;" @click="campodinero = parseFloat(50) + parseFloat(campodinero)">$50</button>
                        <button type="button" class="btn btn-secondary btn-lg" style="height: 70px;" @click="campodinero = parseFloat(100) + parseFloat(campodinero)">$100</button>
                        <button type="button" class="btn btn-secondary btn-lg" style="height: 70px;" @click="campodinero = parseFloat(200) + parseFloat(campodinero)">$200</button>
                        <button type="button" class="btn btn-secondary btn-lg" style="height: 70px;" @click="campodinero = parseFloat(500) + parseFloat(campodinero)">$500</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            <label for="cc-exp" class="control-label mb-1">Tarjeta<span style="color: red">*</span></label>
                            <input id="tarjetam" name="dinero" required type="number" class="form-control cc-exp"  v-model="montotarjeta">
                        </div>
                    </div>
                    <div class="col-8">
                        <button type="button" class="btn btn-secondary btn-lg" style="height: 70px;" @click="campodinero = parseFloat(1000) + parseFloat(campodinero)">$1000</button>
                        <button type="button" class="btn btn-secondary btn-lg" style="height: 70px;" @click="campodinero = parseFloat(2000) + parseFloat(campodinero)">$2000</button>
                        <button type="button" class="btn btn-secondary btn-lg" style="height: 70px;" @click="campodinero = parseFloat(25) + parseFloat(campodinero)">$25</button>
                        <button type="button" class="btn btn-secondary btn-lg" style="height: 70px;" @click="campodinero = parseFloat(10) + parseFloat(campodinero)">$10</button>
                        <button type="button" class="btn btn-secondary btn-lg" style="height: 70px;" @click="campodinero = parseFloat(5) + parseFloat(campodinero)">$5</button>
                        <button type="button" class="btn btn-secondary btn-lg" style="height: 70px;" @click="campodinero = parseFloat(1) + parseFloat(campodinero)">$1</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            <label for="cc-number" class="control-label mb-1">Tipo de tarjeta</label>
                            <select name="selectSm"  id="SelectLm" v-model="tipotarjeta" class="form-control-sm form-control">
                                <option value="">--Selecciona--</option>
                                <option value="visa">Visa</option>
                                <option value="mastercard">MasteCard</option>
                                <option value="americanexpress">AmericanExpress</option>
                            </select>
                            <span class="help-block" data-valmsg-for="cc-number" data-valmsg-replace="true"></span>
                        </div>
                    </div>
                    <div class="col-8">
                        <div class="form-group">
                            <label for="banco" class="control-label mb-1">Banco</label>
                            <input id="banco" name="banco" v-model="banco" class="form-control cc-exp" type="text">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            <label for="numtarjeta" class="control-label mb-1">Num.Tarjeta <span style="color: red">*</span></label>
                            <input id="numtarjeta"  name="numtarjeta" type="text" class="form-control cc-exp" maxlength="16"  v-model="Numtarjeta" data-val="true" data-val-required="Please enter the card expiration" >
                            <span class="help-block" data-valmsg-for="cc-exp" data-valmsg-replace="true"></span>
                        </div>
                    </div>
                    <div class="col-8">
                        <label for="auth" class="control-label mb-1">Autorización<span style="color: red">*</span></label>
                        <div class="input-group">
                            <input id="auth" name="auth"  v-model="auth" maxlength="20" type="text" class="form-control cc-cvc">
                        </div>
                    </div>
                </div>
                <div class="row" v-if="setting.generacomprobante == 'si'">
                    <div class="col-md-12">
                        <div class="text-center">
                            <button type="button" v-if="fiscal == false" class="btn btn-primary" @click="fiscalconfirm" >Documento Fiscal?</button>
                            <template v-else>
                                <label for="" class="control-label mb-1"><strong>Tipo NFC</strong></label>
                                <select class="form-control form-control-sm" v-model="tiponfc">
                                    <option value="01">01 | Credito Fiscal</option>
                                    <option value="02" selected>02 | Facturas de Consumo</option>
                                    <option value="03">03 | Notas de Debito</option>
                                    <option value="04">04 | Notas de Credito</option>
                                    <option value="11">11 | Provedores Informales</option>
                                    <option value="12">12 | Registro Unico de Ingresos</option>
                                    <option value="13">13 | Registro de Gastos Menores</option>
                                    <option value="14">14 | Regímenes Especiales de Tributación</option>
                                    <option value="15">15 | Comprobantes Gubernamentales</option>
                                </select>
                                <hr>
                                <div class="row" v-if="tiponfc != '02'">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="" class="control-label mb-1">Telefono</label>
                                            <input id="" name="" :disabled="loading" v-model="datancf.telefono" class="form-control form-control-sm" type="text">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="" class="control-label mb-1">Numero RNC</label>
                                            <input id="" name="" v-model="datancf.rnc" class="form-control form-control-sm" @keypress.enter="buscar_rnc" type="text" placeholder="presiona enter para buscar" maxlength="11">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="" class="control-label mb-1">Razon social</label>
                                            <input id="" name="" :disabled="loading" v-model="datancf.razon" class="form-control form-control-sm" type="text">
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <hr>
                    </div>
                </div>
                <div class="row" style="margin-bottom: 18px" v-if="clientedatos != ''">
                    <div class="col-12">
                        <div class="text-center">
                            <h4>Ticket de Puntos</h4>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="text-center">
                            <input type="number" v-model="idticket" placeholder="Codigo del Ticket" min="0" @keypress.enter="ticket" class="form-control" id="">
                        </div>
                    </div>
                    <template v-if="datosticket != ''">
                        <div class="col-6" style="margin-top: 15px">
                            <h5 style="float: left">Fecha: </h5> <p style="float: right">@{{ datosticket.fecha }}</p>
                        </div>
                        <div class="col-6" style="margin-top: 15px">
                            <h5 style="float: left">Cliente: </h5> <p style="float: right">@{{ datosticket.nombre }}</p>
                        </div>
                        <div class="col-6">
                            <h5 style="float: left">Puntos: </h5> <p style="float: right">@{{ datosticket.puntos }}</p>
                        </div>
                        <div class="col-6">
                            <h5 style="float: left">Balance: </h5> <p style="float: right">@{{ datosticket.balancepuntos }}</p>
                        </div>
                    </template>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="text-center">
                            <h3>Devuelta: <span style="font-size: 40px"> @{{ format2(parseFloat(devuelta), '') }}</span></h3>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="justify-content: normal !important;display:block !important;">
                    <div class="row">
                        <div class="col-sm-4">
                            <button style="width: 100%;" type="button" class="btn btn-warning btn-lg" @click="limpiar()">Limpiar</button></div>
                        <div class="col-sm-4">
                            <button style="width: 100%;" type="button" class="btn btn-secondary btn-lg" data-dismiss="modal">Cancelar</button></div>
                        <div class="col-sm-4">
                            <button v-if="suma >= neto" type="button" @click="facturar()" style="width: 100%;" class="btn btn-success btn-lg">&nbsp;Pagar</button>
                            <button v-else disabled type="button" style="width: 100%;" class="btn btn-primary btn-lg">&nbsp;Pagar</button></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>