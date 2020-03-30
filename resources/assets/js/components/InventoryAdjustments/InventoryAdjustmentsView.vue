<template>
    <div class="row">
        <div class="col-md-12">
            <div class="loader" v-if="loading"></div>
            <div class="float-left">
                <h3>Lista de Ajustes de invetario</h3>
            </div>
            <div class="float-right">
                <button class="btn btn-primary" @click="openForm" ><i class="fas fa-plus" /> Crear Ajuste</button>
                <button class="btn btn-danger"
                        @click="back"
                        v-if="dataToPrint"
                ><i class="fas fa-angle-left" /> Volver</button>
            </div>
        </div>
        <div class="col-md-12">
            <hr>
        </div>
        <template v-if="!printView">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="search">Buscar por documento</label>
                    <input
                            type="text"
                            placeholder="#000"
                            id="search"
                            v-model="search"
                            class="form-control"
                            style="text-align: center"
                            @keypress.enter="getInventoryAdjustments">
                </div>
            </div>
            <div class="col-md-12">
                <general-table :responsive="false" :paginate="InventoryAdjustmentsData" :hover="true" @pageChange="getInventoryAdjustments">
                    <template slot="table-header">
                        <tr>
                            <th>ID</th>
                            <th>Tipo de ajuste</th>
                            <th>Fecha</th>
                            <th>concepto</th>
                            <th style="text-align: right">Total</th>
                            <th/>
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
                            <td>{{fitTypeName(item.fit_type)}}</td>
                            <td>{{item.date_document}}</td>
                            <td>{{item.concept}}</td>
                            <td style="text-align: right">{{parseFloat(item.total).formatMoney(2)}}</td>
                            <td style="width: 80px" @click="print(item.id)"><button class="btn btn-link btn-sm">Imprimir</button></td>
                        </tr>
                    </template>
                </general-table>
            </div>
        </template>
        <template v-else>
            <div class="col-md-12">
                <PrintSection
                        :data-body="dataToPrint.InventoryAdjustmentsDetails"
                        :data-header="dataToPrint.InventoryAdjustments"
                        :company="dataToPrint.company"/>
            </div>
        </template>
    </div>
</template>

<script>
    import generalTable from "../generalTable";
    import PrintSection from "./PrintSection";
    export default {
        components:{
            generalTable,
            PrintSection
        },
        data()
        {
          return {
              InventoryAdjustmentsData:null,
              loading:false,
              search:"",
              dataToPrint:null,
              printView:false
          }
        },
        methods:{
            back()
            {
                this.printView = false;
                this.dataToPrint = null;
            },
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
            getInventoryAdjustments(page)
            {
                this.loading = true;
                axios.get('/inventory/Adjustments/list', {
                    params:{
                        page:page,
                        search: this.search
                    }
                })
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
                this.dataToPrint = null;
                this.$emit('openForm', true)
            },
            print(id)
            {
                axios.get('/inventory/Adjustments/dataInfo',{
                    params:{
                        id:id
                    }
                })
                .then((res) => {
                    this.dataToPrint = res.data;
                    this.printView = true;
                })
                .catch((e) => {
                    console.log(e)
                })
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