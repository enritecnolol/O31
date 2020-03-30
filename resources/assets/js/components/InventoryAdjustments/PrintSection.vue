<template>
    <div>
        <div class="row" id="myPrintArea">
            <div class="col-md-4">
                <div class="text-center">
                    <img class="rounded-circle mx-auto d-block" :src="'/imagenes/' + company.img" style="width: 109px" alt="">
                </div>
            </div>
            <div class="col-md-4 text-center">
                {{company.nombreempresa}}
                <br>
                {{company.telefono}}
                <br>
                {{company.pais}}, {{company.ciudad}}, {{company.direccion}}
                <br>
                <br>
                <h3>Ajuste de inventario</h3>
            </div>
            <div class="col-md-4"></div>
            <div class="col-md-2">
                <b>Documento No: </b> #{{dataHeader.document != "0" ? dataHeader.document : dataHeader.id}}
            </div>
            <div class="col-md-4">
                <b>Fecha: </b> {{dataHeader.date? dataHeader.date : moment(dataHeader.date_document).format('YYYY-MM-DD')}}
            </div>
            <div class="col-md-6" />
            <div class="col-md-12">
                <b>Concepto: </b>  {{dataHeader.concept}}
            </div>
            <div class="col-md-12">
                <b>Tipo de ajuste: </b>  {{fitTypeName(dataHeader.fitType ? dataHeader.fitType : dataHeader.fit_type)}}
            </div>
            <div class="col-md-12">
                <hr style="background: black">
            </div>
            <div class="col-md-12">
                <div class="float-left">
                    <h4>Lista de productos</h4>
                </div>
            </div>
            <div class="col-md-12">
                <general-table :hover="true" :bordered="true" :responsive="false">
                    <template slot="table-header">
                        <tr>

                            <th>Referencia</th>
                            <th>Nombre</th>
                            <th style="text-align: center">Cantidad</th>
                            <th style="text-align: right">Costo</th>
                            <th style="text-align: right">Importe</th>
                        </tr>
                    </template>
                    <template slot="table-body">
                        <tr v-for="(item, index) in dataBody" :key="index">
                            <td>{{item.product_id ? item.product_id : item.product.code}}</td>
                            <td>{{item.name ? item.name : item.product.label}}</td>
                            <td style="text-align: center">{{parseFloat(item.quantity).formatMoney(2)}}</td>
                            <td style="text-align: right">{{parseFloat(item.amount).formatMoney(2)}}</td>
                            <td style="text-align: right">{{parseFloat(item.impost ? item.impost : (item.quantity * item.amount)).formatMoney(2)}}</td>
                        </tr>
                    </template>
                    <template slot="table-footer">
                        <tfoot>
                        <tr>
                            <td colspan="4"></td>
                            <th style="text-align: right">{{dataHeader.total ? dataHeader.total : totalItems}}</th>
                        </tr>
                        </tfoot>
                    </template>
                </general-table>
            </div>
            <div class="col-md-12">
                <b>Nota: </b> {{dataHeader.note}}
            </div>
        </div>
        <div class="row">
            <div class="col-md-12" style="margin-top: 20px">
                <button class="btn btn-success" id="print" @click="testPrintButton"><i class="fas fa-print"/>Imprimir</button>
            </div>
        </div>
    </div>
</template>

<script>
    import generalTable from "../generalTable";
    export default {
        props:['dataHeader', 'dataBody', 'company'],
        components:{
            generalTable
        },
        methods:{
            fitTypeName(i)
            {
                switch (i) {
                    case "EI":
                        return "Entranda de inventario";
                        break;
                    case "SI":
                        return "Salida de inventario";
                        break;
                    case "AI":
                        return "Ajuste de invetario";
                        break;
                }
            },
            testPrintButton()
            {
                $("#print").click( () => {
                    var mode = 'iframe'; //popup
                    var close = mode == "popup";
                    var options = { mode : mode, popClose : close};
                    $("div#myPrintArea").printArea(options);
                });

            }
        },
        computed:{
            totalItems()
            {
                let total = 0;
                for (var index in this.dataBody)
                {
                    total = total + (this.dataBody[index].quantity * this.dataBody[index].amount)
                }
                return total;
            }
        }
    }
</script>

<style scoped>

</style>