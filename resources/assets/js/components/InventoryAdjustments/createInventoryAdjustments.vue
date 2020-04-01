<template>
    <div class="row">
        <div class="loader" v-if="loading"></div>
        <div class="col-md-12">
            <div class="float-left">
                <h3>Ajuste de inventario</h3>
            </div>
            <div class="float-right">
                <button class="btn btn-link" @click="back"><i class="fas fa-angle-left" /> Volver</button>
            </div>
        </div>
        <div class="col-md-12">
            <hr>
        </div>
        <template v-if="!printTemplate">
            <div class="col-md-2">
                <div class="form-group">
                    <label for="document">Documento No. <span style="color: red">*</span></label>
                    <input
                            disabled
                            id="document"
                            placeholder="#0000"
                            type="text"
                            v-model="document"
                            class="form-control form-control-sm"
                    >
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Fecha: <span style="color: red">*</span></label>
                    <datepicker
                            v-model="date"
                            class="form-control form-control-sm"
                            :format="'yyyy-MM-dd'"
                            name="estimateDate"
                    />
                </div>
            </div>
            <div class="col-md-6" />
            <div class="col-md-6">
                <div class="form-group">
                    <label for="concept">Concepto: <span style="color: red">*</span></label>
                    <input id="concept" type="text" maxlength="191" class="form-control form-control-sm" v-model="concept">
                </div>
                <div class="form-group">
                    <label for="fitType">Tipo ajuste:</label>
                    <select id="fitType"  class="form-control form-control-sm" v-model="fitType">
                        <option value="">Seleccionar</option>
                        <option value="EI">Entrada de inventario (Sumar cantidad a la existencia actual)</option>
                        <option value="SI">Salida de inventario (Restar cantidad a la exitencia actual)</option>
                        <option value="AI">Ajuste de inventerio (lleva la existencia actual de la cantidad indicada)</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="note">Nota:</label>
                    <textarea id="note" class="form-control" rows="4" v-model="note"/>
                </div>
            </div>
            <div class="col-md-12">
                <hr>
            </div>
            <div class="col-md-12">
                <div class="float-left">
                    <h4>Lista de productos</h4>
                </div>
            </div>
            <div class="col-md-12" style="margin-top: 20px">
                <general-table :hover="true" :bordered="true" :responsive="false">
                    <template slot="table-header">
                        <tr>
                            <th>Referencia</th>
                            <th>Nombre</th>
                            <th style="text-align: center">Cantidad</th>
                            <th style="text-align: right">Costo</th>
                            <th style="text-align: right">Importe</th>
                            <th />
                        </tr>
                    </template>
                    <template slot="table-body">
                        <item-body
                                v-for="(item ,index) in List"
                                :index="index"
                                :item="item"
                                :productsListForSelect="productsListForSelect"
                                @removeRow="removeRow"
                                @replaceElement="replaceElement"
                                :key="index"
                        />
                    </template>
                    <template slot="table-footer">
                        <tfoot>
                        <tr>
                            <td colspan="4"></td>
                            <th style="text-align: right">{{parseFloat(totalList).formatMoney(2)}}</th>
                            <th/>
                        </tr>
                        </tfoot>
                    </template>
                </general-table>
            </div>
            <div class="col-md-12" style="margin-top: 10px">
                <button class="btn btn-sm btn-primary" @click="addRow"><i class="fas fa-plus" /> Nueva Fila</button>
            </div>
            <div class="col-md-12" style="margin-top: 20px">
                <div class="float-right">
                    <button class="btn btn-danger" @click="reset" :disabled="loading" ><i class="fas fa-times" /> Cancelar</button>
                    <button class="btn btn-primary" @click="save"><i class="fas fa-save" /> Guardar</button>
                </div>
            </div>
        </template>
        <template v-else>
            <div class="col-md-12">
                <PrintSection
                        :dataHeader="{
                date,
                document,
                concept,
                fitType,
                note
            }"
                        :dataBody="List"
                        :company="company"
                />
            </div>
        </template>
    </div>
</template>

<script>
    import Datepicker from "vuejs-datepicker";
    import generalTable from "../generalTable";
    import itemBody from "./itemBody";
    import PrintSection from "./PrintSection";
    export default {
        components:{
            Datepicker,
            generalTable,
            itemBody,
            PrintSection
        },
        data()
        {
            return{
                printTemplate:false,
                date:"",
                document:"",
                concept:"",
                fitType:"",
                note:"",
                List:[
                    {
                        product:"",
                        quantity:0,
                        amount:0,
                        impost:0
                    }
                ],
                productsList:[],
                loading:false,
                company:null
            }
        },
        methods:{
            save()
            {
                if(!this.date || !this.concept || !this.fitType)
                {
                    toastr.warning("Favor llenar todos los campos importantes");
                    return;
                }

                if(this.itemsLength == 0)
                {
                    toastr.warning("Favor revisar las lista de productos");
                    return;
                }

                this.loading = true;
                axios.post('/inventory/Adjustments', {
                    date_document:moment(this.date).format('YYYY-MM-DD'),
                    concept:this.concept,
                    note:this.note,
                    total:this.totalList,
                    details:this.List,
                    fitType:this.fitType
                })
                    .then((response) => {
                        toastr.success(response.data.message);
                        this.document = response.data.document_id;
                        this.printTemplate = true;
                        this.company = response.data.company;
                    })
                    .catch((err) => {
                        console.log(err)
                    })
                    .finally(()=>{
                        this.loading = false;
                    })
            },
            reset()
            {
                this.date = new Date();
                this.document = "";
                this.concept = "";
                this.fitType = "";
                this.note = "";
                this.List = [
                    {
                        product:"",
                        quantity:0,
                        amount:0,
                        impost:0
                    }
                ]
            },
            back()
            {
                this.$emit('closeForm', false)
            },
            replaceElement({ index, item }) {
                this.List.splice(index, 1, item);
            },
            addRow()
            {
                this.List.push({
                    product:"",
                    quantity:0,
                    amount:0,
                    impost:0,
                })
            },
            removeRow(index) {
                this.List.splice(index, 1);
            },
            getProducts() {
                this.loading = true;
                axios
                    .get("/products/select/sale")
                    .then(response => {
                        this.productsList = response["data"];
                    })
                    .catch(error => {
                        console.log(error);
                    })
                    .finally(()=> {
                        this.loading = false;
                    });
            },
        },
        computed:{
            productsListForSelect() {
                let array = [];
                for (var index in this.productsList) {
                    array.push({
                        label: this.productsList[index].name,
                        code: this.productsList[index].id
                    });
                }
                return array;
            },
            itemsLength()
            {
                var count = 0;
                for(var index in this.List)
                {
                    if(this.List[index].product && this.List[index].quantity > 0 && this.List[index].amount > 0)
                    {
                        count++
                    }
                }
                return count;
            },
            totalList()
            {
                var total = 0;
                for(var index in this.List)
                {
                    total = total + (this.List[index].quantity * this.List[index].amount);
                }
                return total;
            },
            quantityList()
            {
                var total = 0;
                for(var index in this.List)
                {
                    total = total + this.List[index].quantity;
                }
                return total;
            }
        },
        created() {
            this.date = Date();
            this.getProducts();
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