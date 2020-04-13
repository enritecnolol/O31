<template>
    <card-panel>
        <template slot="body">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-7">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label for="supplier" class="col-sm-2 col-form-label">
                                        Proveedor:
                                    </label>
                                    <div class="col-sm" style="padding: 0">
                                        <v-select v-model="supplier" :options="suppliers"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label for="NCF_type" class="col-sm-2 col-form-label">Tipo NCF:</label>
                                    <div class="col-sm" style="padding: 0">
                                        <select id="NCF_type" class="form-control form-control-sm">
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
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label for="ncf" class="col-sm-2 col-form-label">NCF:</label>
                                    <div class="col-sm" style="padding: 0">
                                        <input type="text" class="form-control form-control-sm" style="width:250px">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label for="invoiceNo" class="col-sm-2 col-form-label">Factura No.</label>
                                    <div class="col-sm" style="padding: 0">
                                        <input type="text" class="form-control form-control-sm" style="width:250px">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label for="document" class="col-sm-4 col-form-label">Documento No.</label>
                                    <div class="col-sm">
                                        <input type="text" id="document" class="form-control form-control-sm">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">
                                        Fecha:
                                    </label>
                                    <div class="col-sm">
                                        <datepicker
                                                :bootstrap-styling="true"
                                                v-model="invoiceDate"
                                                :calendar-class="'form-control form-control-sm'"
                                                :format="'yyyy-MM-dd'"
                                                name="estimateDate"
                                        />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <select-term @changeTerm="changeTerm" :termExternal="term" :landscape="true"/>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">
                                        Fecha Venc.
                                    </label>
                                    <div class="col-sm">
                                        <datepicker
                                                :bootstrap-styling="true"
                                                v-model="dueDate"
                                                :calendar-class="'form-control form-control-sm'"
                                                :format="'yyyy-MM-dd'"
                                                name="estimateDate"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <general-table :responsive="false">
                            <template slot="table-header">
                                <tr>
                                    <td>Tipo de gasto</td>
                                    <td style="text-align:right;">Importe bruto</td>
                                    <td style="text-align:right;">Descuento</td>
                                    <td style="text-align:right;">Impuesto</td>
                                    <td style="text-align:right;">Total Neto</td>
                                </tr>
                            </template>
                            <template slot="table-body">
                                <template v-for="(item, index) in items">
                                    <itemBody
                                            :key="index"
                                            :index="index"
                                            :item="item"
                                    />
                                </template>
                            </template>
                        </general-table>
                    </div>
                    <div class="col-md-12" style="margin-top: 10px">
                        <div class="float-left">
                            <textarea
                                    placeholder="Aqui va lo terminos o acuerdo..."
                                    class="form-control"
                                    id="terms"
                                    rows="4"
                                    style="width:470px;"
                            />
                        </div>
                        <div class="float-right">
                            <div class="form-group row">
                                <label for="methodPay" class="col-sm-5 col-form-label">Forma de pago</label>
                                <div class="col-sm">
                                    <select id="methodPay" class="form-control form-control-sm">
                                        <option value="01">01 | Credito Fiscal</option>
                                        <option value="02" >02 | Facturas de Consumo</option>
                                        <option value="03">03 | Notas de Debito</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <hr>
                    </div>
                    <div class="col-md-12">
                        <div class="float-right">
                            <button class="btn btn-primary btn-sm">
                                <i class="far fa-file-alt" />
                                Salvar
                            </button>
                            <button class="btn btn-success btn-sm">
                                <i class="far fa-file-alt" />
                                <i class="fas fa-paper-plane" />
                                Salvar y enviar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </card-panel>
</template>

<script>
    import cardPanel from "../cardPanel";
    import Datepicker from "vuejs-datepicker";
    import selectTerm from "../terms/selectTerm";
    import generalTable from "../generalTable";
    import itemBody from "./itemBody";
    import money from "v-money";
    import Vue from "vue";
    Vue.use(money, { precision: 4 });
    export default {
        components:{cardPanel, Datepicker, selectTerm, generalTable, itemBody},
        data()
        {
            return {
                supplierList:[],
                supplier:"",
                type_ncf:"",
                invoiceDate:"",
                term:"",
                dueDate:"",
                items:[
                    {
                        typeExpenses: "",
                        gross: 0,
                        discount: 0,
                        impost: 0,
                        totalNet: 0,
                    }
                ],
                money: {
                    decimal: ".",
                    thousands: ",",
                    prefix: "RD$ ",
                    precision: 2,
                    masked: false
                },
                amount:0
            }
        },
        methods:{
            changeTerm({ id, number_days }) {
                if (number_days === "") {
                    return;
                }
                this.term = id;
                var today = new Date();
                var dueDate = new Date();
                dueDate.setDate(today.getDate() + number_days);
                this.dueDate = dueDate;
            },
            fetchSupplier() {
                axios
                    .get("/supplier/list/select")
                    .then(response => {
                        this.supplierList = response.data;
                    })
                    .catch(err => {
                        console.log(err);
                    });
            },
        },
        computed:{
            suppliers() {
                let array = [];
                this.supplierList.forEach(element => {
                    array.push({
                        label: element.name,
                        code: element.id
                    });
                });
                return array;
            },
        },
        created() {
            this.fetchSupplier();
            this.invoiceDate = new Date();
            this.dueDate = new Date();
        }
    }
</script>

<style scoped>

</style>
