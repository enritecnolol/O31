<div id="myPrintArea">
    <div class="row">
        <div class="col-md-12" style="color: #000;">
            <div class="row">
                <div class="col-md-12">
                    <div style="width: 400px;text-align: center;">
                        <img :src="'imagenes/'+compania.img" width="100" alt="">
                    </div>
                    <h3 style="color: #000;width: 400px;text-align: center;">@{{ compania.nombreempresa }}</h3>
                    <p style="color: #000;width: 400px;text-align: center;">@{{ compania.pais }}, @{{ compania.ciudad }}, @{{ compania.direccion }} <br> @{{ compania.telefono }} </p>
                    <label style="color: #000;width: 400px;text-align: center;"><strong> Devolucion sobre venta </strong></label>
                </div>
                <div class="col-md-12">
                    <b>Fecha :  </b>@{{ fecha }}
                </div>
                <div class="col-md-12">
                    <b style="color: #000;">No. Factura :</b> @{{ _this.datofactura.id }}
                </div>
                <div class="col-md-12">
                    <b style="color: #000;">No. Devolucion : </b> @{{ numerodevolucion }}
                </div>
                <div class="col-md-12" v-if="nfc">
                    <b style="color: #000;">NCF :</b> @{{ nfc }}
                </div>
                <div class="col-md-12" v-if="nfc">
                    <b style="color: #000;">NCF modificado:</b> @{{ _this.datofactura.nfc }}
                </div>
                <div class="col-md-12">
                    <hr style="background-color: #0062cc">
                </div>
                <div class="col-md-12">
                    <table style="width: 400px;">
                        <thead style="border-bottom: 1px solid black;border-top: 1px solid black;font-weight: bold;text-align: left;">
                        <tr>
                            {{--<th style="font-weight: bold;color: #000;">Prod.</th>--}}
                            <th style="font-weight: bold;color: #000;text-align: center">Cantidad</th>
                            <th style="font-weight: bold;color: #000;text-align: right">Precio</th>
                            <th style="font-weight: bold;color: #000;text-align: right">Itbis</th>
                            <th style="font-weight: bold;color: #000;text-align: right">Total</th>
                        </tr>
                        </thead>
                        <tbody>
                        <template v-for="item in datosnuevodetalle">
                            <tr>
                                <td colspan="4" style="font-size: 14px;color: #000;text-align: left">@{{ item.name_product ? item.name_product : item.description }}</td>
                            </tr>
                            <tr style="">
                                {{--<td style="font-size: 14px;width: 20%;color: #000;">@{{ item.name_product }}</td>--}}
                                <td style="font-size: 14px;width: 4%;color: #000;text-align: center">
                                    @{{ item.cantidad }}
                                </td>
                                <td style="font-size: 14px;width: 4%;color: #000;text-align: right">@{{ format2(item.bruto == 0 ? item.price : item.bruto, '') }}</td>
                                <td style="font-size: 14px;width: 4%;color: #000;text-align: right">@{{ format2(item.itbis, '') }}</td>
                                <td style="font-size: 14px;width: 10%;color: #000;text-align: right">@{{ format2(item.price * item.cantidad, '') }}</td>
                            </tr>
                        </template>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-12">
                    <hr style="color: #000;">
                </div>
                <div class="col-md-12" style="margin-top: 20px;margin-bottom: 20px">
                    <div style="border-radius: 50px 50px 50px 50px;box-shadow: 0px 0px 9px 0px rgba(0,0,0,0.75);">
                        <h3 style="color: #000;width: 400px;text-align: right;">Total: @{{ format2(totaldevolver, '') }}</h3>
                    </div>
                </div>
                <div class="col-12">
                    <div style="border-top:1px solid #000; padding-top:10px;">
                        <div class="" style="padding:5px;width:85%;margin:0 auto;border-radius:3px;margin-top:20px;font-weight: bold;color: #000;">
                            GRACIAS POR PREFERIRNOS <br>
                            {{ url()->current() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>