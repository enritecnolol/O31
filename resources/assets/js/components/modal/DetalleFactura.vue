<template>
    <div class="modal fade" id="detallefactura" tabindex="-1"  data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Factura</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container" id="myPrintArea">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="text-center">
                                    <img :src="'imagenes/logo.png'" width="100" alt="">
                                    <br>
                                    <h5>COFFEBREAKPOS</h5>
                                </div>
                            </div>
                            <br>
                            <hr>
                            <br>
                            <div class="col-md-12">
                                <div class="form-group text-left" style="margin: 0">
                                    <label for="cc-exp" class="control-label mb-1"><strong>No.factura: </strong> </label>
                                    <label for="cc-exp" class="control-label mb-1"># {{factureselect.id}}</label>
                                </div>
                                <div class="form-group text-left" style="margin: 0">
                                    <label for="cc-exp" class="control-label mb-1"><strong>Fecha: </strong> </label>
                                    <label for="cc-exp" class="control-label mb-1">{{factureselect.date}}</label>
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
                                        <tr v-for="item in details">
                                            <td style="line-height: 1">{{item.name_product}}</td>
                                            <td class="text-center">{{item.quanlity}}</td>
                                            <td class="text-center">{{item.descuento}}%</td>
                                            <td class="text-center">${{formatMoney(item.price)}}</td>
                                            <td class="text-center">{{item.impost}}%</td>
                                        </tr>
                                        </tbody>
                                        <thead>
                                        <tr>
                                            <th>Total:</th>
                                            <th class="text-center"></th>
                                            <th></th>
                                            <th class="text-center">${{ formatMoney(factureselect.total_facture) }}</th>
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
                                            <h5 style="float: left">Efectivo: </h5> <p style="float: right"> ${{ formatMoney(factureselect.Monto_efectivo) }}</p>
                                        </div>
                                        <div class="col-sm-12">
                                            <h5 style="float: left">Bruto: </h5> <p style="float: right">${{formatMoney(factureselect.brute)}}</p>
                                        </div>
                                        <div class="col-sm-12">
                                            <h5 style="float: left">Descuento: </h5> <p style="float: right">${{ formatMoney(factureselect.desc) }}</p>
                                        </div>
                                        <div class="col-sm-12">
                                            <h5 style="float: left">Itbis: </h5> <p style="float: right">${{ formatMoney(factureselect.itbis) }}</p>
                                        </div>
                                        <div class="col-md-12">
                                            <h5 style="float: left">Neto: </h5> <p style="float: right">${{ formatMoney(factureselect.total_facture) }}</p>
                                        </div>
                                        <div class="col-sm-12">
                                            <h5 style="float: left">Devuelta: </h5> <p style="float: right">$ {{ formatMoney(factureselect.returns) }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props:['factureselect', 'details'],
        methods:{
            formatMoney(amount, decimalCount = 2, decimal = ".", thousands = ",") {
                try {
                    decimalCount = Math.abs(decimalCount);
                    decimalCount = isNaN(decimalCount) ? 2 : decimalCount;

                    const negativeSign = amount < 0 ? "-" : "";

                    let i = parseInt(
                        (amount = Math.abs(Number(amount) || 0).toFixed(decimalCount))
                    ).toString();
                    let j = i.length > 3 ? i.length % 3 : 0;

                    return (
                        negativeSign +
                        (j ? i.substr(0, j) + thousands : "") +
                        i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousands) +
                        (decimalCount
                            ? decimal +
                            Math.abs(amount - i)
                                .toFixed(decimalCount)
                                .slice(2)
                            : "")
                    );
                } catch (e) {
                    console.log(e);
                }
            }
        }
    }
</script>

<style scoped>

</style>