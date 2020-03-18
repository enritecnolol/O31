<template>
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <div class="float-right">
                        <button class="btn btn-sm btn-link" @click="back">Volver</button>
                    </div>
                </div>
                <div class="col-md-4">
                    <h4 style="float: left">No.factura</h4>
                    <h4 style="float: right">{{ invoiceData.id }}</h4>
                </div>
                <div class="col-md-4">
                    <h4 style="float: left">Fecha</h4>
                    <h4 style="float: right">{{ invoiceData.date }}</h4>
                </div>
                <div class="col-md-4">
                    <h4 style="float: left">Cliente</h4>
                    <h4 style="float: right">{{ invoiceData.client }} - {{invoiceData.clientname}}</h4>
                </div>
                <div class="col-md-4">
                    <h4 style="float: left">Bruto</h4>
                    <h4 style="float: right">{{ parseFloat(invoiceData.brute).formatMoney(2) }}</h4>
                </div>
                <div class="col-md-4">
                    <h4 style="float: left">Descuento</h4>
                    <h4 style="float: right">{{ parseFloat(invoiceData.desc).formatMoney(2) }}</h4>
                </div>
                <div class="col-md-4">
                    <h4 style="float: left">Itbis</h4>
                    <h4 style="float: right">{{ parseFloat(invoiceData.itbis).formatMoney(2) }}</h4>
                </div>
                <div class="col-md-4">
                    <h4 style="float: left">devuelta</h4>
                    <h4 style="float: right">{{ parseFloat(invoiceData.returns).formatMoney(2) }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-12" style="margin-top: 20px">
            <h3>Lista de transacciones</h3>
            <hr>
            <general-table>
                <template slot="table-header">
                    <tr>
                        <th>Fecha de creacion</th>
                        <th>Tipo</th>
                        <th style="text-align: right">Monto</th>
                        <th style="text-align: right">itbis</th>
                        <th style="text-align: right">descuento</th>
                    </tr>
                </template>
                <template slot="table-body">
                    <tr v-if="invoiceTransactions.lenght == 0">
                        <td colspan="5" style="text-align: center">No hemos encontrado ningun tipo de transaccion</td>
                    </tr>
                    <tr v-for="(item,index) in invoiceTransactions" :key="index">
                        <td>{{item.created_at}}</td>
                        <th>{{item.type}}</th>
                        <td style="text-align: right">{{parseFloat(item.amount).formatMoney(2)}}</td>
                        <td style="text-align: right">{{parseFloat(item.itbis).formatMoney(2)}}</td>
                        <td style="text-align: right">{{parseFloat(item.discount).formatMoney(2)}}</td>
                    </tr>
                </template>
            </general-table>
        </div>
    </div>
</template>

<script>
    import generalTable from "../generalTable";
    export default {
        components:{
            generalTable
        },
        props:['invoiceData', 'invoiceTransactions'],
        methods:{
            back()
            {
                this.$emit('cleanHistory')
            }
        }
    }
</script>

<style scoped>

</style>
