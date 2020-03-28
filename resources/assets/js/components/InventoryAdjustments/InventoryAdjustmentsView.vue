<template>
    <div class="row">
        <div class="col-md-12">
            <div class="loader" v-if="loading"></div>
            <div class="float-left">
                <h3>Lista de Ajustes de invetario</h3>
            </div>
            <div class="float-right">
                <button class="btn btn-primary" @click="openForm" ><i class="fas fa-plus" /> Crear Ajuste</button>
            </div>
        </div>
        <div class="col-md-12">
            <hr>
        </div>
        <div class="col-md-12">
            <general-table :responsive="false" :paginate="InventoryAdjustmentsData" :hover="true">
                <template slot="table-header">
                    <tr>
                        <th>ID</th>
                        <th>Documento</th>
                        <th>Fecha</th>
                        <th>concepto</th>
                        <th style="text-align: right">Total</th>
                    </tr>
                </template>
                <template slot="table-body">
                    <tr v-if="InventoryAdjustmentsData.data.length === 0">
                        <td colspan="5" style="text-align: center">
                            No hemos encontrado datos para mostrar ...
                        </td>
                    </tr>
                    <tr v-for="(item, index) in InventoryAdjustmentsData.data" :key="index">
                        <td>{{item.id}}</td>
                        <td>{{item.document}}</td>
                        <td>{{item.date_document}}</td>
                        <td>{{item.concept}}</td>
                        <td style="text-align: right">{{parseFloat(item.total).formatMoney(2)}}</td>
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
        data()
        {
          return {
              InventoryAdjustmentsData:null,
              loading:false
          }
        },
        methods:{
            getInventoryAdjustments()
            {
                this.loading = true;
                axios.get('/inventory/Adjustments/list')
                .then((response) => {
                    this.InventoryAdjustmentsData = response.data;
                })
                .catch((err) => {
                    console.log(err)
                })
                .finally(()=> {
                    this.loading = false;
                })
            },
            openForm()
            {
                this.$emit('openForm', true)
            }
        },
        created() {
            this.getInventoryAdjustments();
        }
    }
</script>

<style>
    .loader {
        position: fixed;
        left: 0px;
        top: 0px;
        width: 100%;
        height: 100%;
        z-index: 9999;
        background: url("../../../../../public/loading2.gif") 50% 50% no-repeat rgb(249,249,249);
        opacity: .8;
    }
</style>