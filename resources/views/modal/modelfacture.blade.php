<div class="modal fade" id="pagofactura" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Factura</h5>
                <button type="button" @click="reset()" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="max-height: calc(100vh - 200px);overflow-y: auto;">
                <div id="myPrintArea" style="color: #000;margin: 0 auto;display: inline;width: 400px;">
                    <div class="row">
                        <div class="col-12">
{{--                            <div style="width: 400px;text-align: center;">--}}
{{--                                <img :src="'imagenes/'+setting.img" width="100" alt="">--}}
{{--                            </div>--}}
                            <h2 style="color: #000;width: 400px;text-align: center;">@{{ setting.nombreempresa }}</h2>
                            <p style="width: 400px;text-align: center;">@{{ setting.pais }}, @{{ setting.ciudad }}, @{{ setting.direccion }} <br> @{{ setting.telefono }} </p>
                        </div>
                        <div class="col-12">
                            <div class="form-group text-left" style="margin: 0" v-if="setting.generacomprobante=='si'">
                                <label style="margin-left: 120px;"><strong> @{{tiponfc === '02' ? 'Factura contado' : 'Factura de credito'}}</strong></label>
                            </div>
                            <div class="form-group text-left" style="margin: 0">
                                <label><strong>No. Factura: </strong> </label>
                                <label> @{{ lastid }}</label>
                            </div>
                            <div class="form-group text-left" style="margin: 0">
                                <label><strong>Fecha: </strong> </label>
                                <label><?php echo date('d-m-Y h:i:s A')?></label>
                            </div>
                            <div class="form-group text-left" v-if="setting.generacomprobante=='si'" style="margin: 0">
                                <label><strong>NCF: </strong> </label>
                                <label>@{{rncdevf}}</label>
                            </div>
                            <template v-if="setting.generacomprobante=='si' && datancf.rnc && tiponfc!='02'">
                                <div class="form-group text-left" style="margin: 0">
                                    <label><strong>Fecha vencimiento NCF: </strong> </label>
                                    <label>@{{rncDueDate}}</label>
                                </div>
                                <div class="form-group text-left" style="margin: 0">
                                    <label><strong>Razon Social: </strong> </label>
                                    <label>@{{datancf.razon}}</label>
                                </div>
                                <div class="form-group text-left" v-if="fiscal" style="margin: 0">
                                    <label><strong>RNC: </strong> </label>
                                    <label>@{{datancf.rnc}}</label>
                                </div>
                                <div class="form-group text-left" v-if="fiscal" style="margin: 0">
                                    <label><strong>Telefono: </strong> </label>
                                    <label>@{{datancf.telefono}}</label>
                                </div>
                            </template>
                        </div>
                        <hr>
                        <div class="col-12">
                            <div style="margin-bottom: 5px;clear:both;">
                                <table style="width: 400px;">
                                    <thead style="border-bottom: 1px solid black;border-top: 1px solid black;font-weight: bold;text-align: left;">
                                    <tr>
                                        <td style="font-weight: bold;color: #000;">Producto</td>
                                        <td style="font-weight: bold;color: #000;text-align: center;">Cantidad</td>
                                        <td style="font-weight: bold;color: #000;" align="right">Total</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="item in list">
                                        <td style="font-size: 14px;color: #000;" width="50%"><label>@{{item.name.toUpperCase()}}</label></td>
                                        <td style="font-size: 14px;text-align: center;color: #000;" width="20%">@{{item.count}}</td>
                                        <td style="font-size: 14px;color: #000;" width="30%" align="right">
                                            @{{ format2(parseFloat(item.price), '') }}
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-12">
                            <div style="border-top:1px solid #000; padding-top:10px;width: 400px;"></div>
                        </div>
                        <div class="col-12" style="margin-top: 10px">
                            <div style="margin-bottom: 5px;clear:both;">
                                <table style="width: 40%">
                                    <tbody>
                                    <tr>
                                        <td style="font-size: 14px;width: 70px;font-weight: bold;color: #000;text-align: right;">Bruto:</td>
                                        <td style="font-size: 14px;width: 50px;text-align: right;color: #000;">@{{ format2(parseFloat(bruto), '') }}</td>
                                    </tr>
                                    <tr v-if="parseFloat(totaldescuento) !== 0">
                                        <td style="font-size: 14px;width: 70px;font-weight: bold;color: #000;text-align: right;">Descuento: </td>
                                        <td style="font-size: 14px;width: 50px;text-align: right;color: #000;">@{{ format2(parseFloat(totaldescuento), '') }}</td>
                                    </tr>
                                    <tr>
                                        <td style="font-size: 14px;width: 70px;font-weight: bold;color: #000;text-align: right;">Itbis: </td>
                                        <td style="font-size: 14px;width: 50px;text-align: right;color: #000;">@{{ format2(parseFloat(algoitbis), '') }}</td>
                                    </tr>
                                    <tr v-if="setting.leycamarero == 'si'">
                                        <td style="font-size: 14px;width: 70px;font-weight: bold;color: #000;text-align: right;">10% ley: </td>
                                        <td style="font-size: 14px;width: 50px;text-align: right;color: #000;">@{{ format2(parseFloat(leycamarero), '') }}</td>
                                    </tr>
                                    <tr>
                                        <td style="font-size: 14px;width: 70px;font-weight: bold;color: #000;text-align: right;">Neto: </td>
                                        <td style="font-size: 14px;width: 50px;text-align: right;color: #000;">@{{ format2(parseFloat(neto), '') }}</td>
                                    </tr>
                                    <tr>
                                        <td style="font-size: 14px;width: 70px;font-weight: bold;color: #000;text-align: right;">-----</td>
                                        <td style="font-size: 14px;width: 50px;text-align: right;color: #000;">-----</td>
                                    </tr>
                                    <tr>
                                        <td style="font-size: 14px;width: 70px;font-weight: bold;color: #000;text-align: right;">Efectivo: </td>
                                        <td style="font-size: 14px;width: 50px;text-align: right;color: #000;">@{{ format2(parseFloat(campodinero), '') }}</td>
                                    </tr>
                                    <tr>
                                        <td style="font-size: 14px;width: 70px;font-weight: bold;color: #000;text-align: right;">Devuelta: </td>
                                        <td style="font-size: 14px;width: 50px;text-align: right;color: #000;"><b>@{{ devuelta }}</b></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-12">
                            <div style="border-top:1px solid #000; padding-top:10px;width: 400px;">
                                <div class="" style="padding:5px;width:100%;margin:0 auto;border-radius:3px;margin-top:20px;font-weight: bold;color: #000;text-align: center">
                                    GRACIAS POR PREFERIRNOS
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div style="border-top:1px solid #000; padding-top:10px;width: 400px;">
                                <div class="" style="padding: 5px;width: 100%;margin: 15px auto 0px;border-radius: 3px;font-weight: bold;color: rgb(0, 0, 0);text-align: center">
                                    Software POS: {{ url()->current() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn" data-dismiss="modal" @click="reset() ">Close</button>
                <button type="button" class="btn btn-primary btn" id="imprimir">Imprimir</button>
            </div>
        </div>
    </div>
</div>
