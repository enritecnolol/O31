<template>
    <div class="row">
        <div class="col-md-12">
            <div class="float-left">
                <h3>Formulario Gastos</h3>
            </div>
            <div class="float-right">
                <button class="btn btn-sm btn-primary" @click="createFormStatus">Lista de gastos</button>
            </div>
        </div>
        <div class="col-md-12">
            <hr>
        </div>
        <div class="col-md-7">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group row">
                        <label for="supplier" class="col-sm-3 col-form-label">
                            Proveedor:
                        </label>
                        <div class="col-sm" style="padding: 0">
                            <v-select v-model="supplier" :options="suppliers"/>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group row">
                        <label for="NCF_type" class="col-sm-3 col-form-label">Tipo NCF:</label>
                        <div class="col-sm" style="padding: 0">
                            <select id="NCF_type" class="form-control form-control-sm" v-model="type_ncf">
                                <option value="">Seleccionar</option>
                                <option value="01">01 | Facturas normales</option>
                                <option value="11">11 | Comprobantes de Compras</option>
                                <option value="13">13 | Comprobantes de gastos menores</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group row">
                        <label for="ncf" class="col-sm-3 col-form-label">NCF:</label>
                        <div class="col-sm" style="padding: 0">
                            <input type="text" class="form-control form-control-sm" style="width:250px" disabled>
                        </div>
                    </div>
                </div>
                <template v-if="!supplier">
                    <div class="col-md-12">
                        <div class="form-group row">
                            <label for="nameSupplier" class="col-sm-3 col-form-label">Nombre provedor:</label>
                            <div class="col-sm" style="padding: 0">
                                <input type="text" class="form-control form-control-sm" style="width:250px" v-model="nameSupplier">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group row">
                            <label for="rnc" class="col-sm-3 col-form-label">RNC:</label>
                            <div class="col-sm" style="padding: 0">
                                <input type="text" class="form-control form-control-sm" style="width:250px" v-model="rnc">
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>
        <div class="col-md-5">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group row">
                        <label for="document" class="col-sm-4 col-form-label">Documento No.</label>
                        <div class="col-sm">
                            <input type="text" id="document" class="form-control form-control-sm" v-model="document">
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
                                    :disabled="true"
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
                        <th>Tipo de gasto</th>
                        <th style="text-align:right;">Importe bruto</th>
                        <th style="text-align:right;">Descuento</th>
                        <th style="text-align:right;">Impuesto</th>
                        <th style="text-align:right;">Total Neto</th>
                    </tr>
                </template>
                <template slot="table-body">
                    <tr>
                        <td>
                            <select class="form-control form-control-sm" v-model="item.typeExpenses">
                                <option
                                        v-for="(item, index) in TypeExpenses"
                                        :value="item.code"
                                        :key="index"
                                >{{item.label}}</option>
                            </select>
                        </td>
                        <td style="width:15%;">
                            <money
                                    v-model="item.gross"
                                    v-bind="money"
                                    class="form-control form-control-sm float-right"
                                    style="text-align: right"
                            />
                        </td>
                        <td style="width:15%;">
                            <money
                                    v-model="item.discount"
                                    v-bind="money"
                                    class="form-control form-control-sm float-right"
                                    style="text-align: right"
                            />
                        </td>
                        <td style="width:15%;">
                            <money
                                    v-model="item.tax"
                                    v-bind="money"
                                    class="form-control form-control-sm float-right"
                                    style="text-align: right"
                            />
                        </td>
                        <td style="width:15%;">
                            <money
                                    v-model="item.totalNet"
                                    v-bind="money"
                                    class="form-control form-control-sm float-right"
                                    style="text-align: right"
                            />
                        </td>
                    </tr>
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
                                    v-model="note"
                            />
            </div>
            <div class="float-right">
                <div class="form-group row">
                    <label for="methodPay" class="col-sm-5 col-form-label">Forma de pago</label>
                    <div class="col-sm">
                        <select id="methodPay" class="form-control form-control-sm" v-model="payment">
                            <option value="01">01 Efectivo</option>
                            <option value="02">02 Cheques/Transferencias</option>
                            <option value="03">03 Tarjeta credito/debito</option>
                            <option value="04">04 Compra A credito</option>
                            <option value="05">05 Permuta</option>
                            <option value="06">06 Nota de credito</option>
                            <option value="07">07 Mixto</option>
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
                <button class="btn btn-danger btn-sm" @click="createFormStatus">
                    <i class="fas fa-arrow-left"></i>
                    Cancelar
                </button>
                <button class="btn btn-primary btn-sm" @click="save(false)">
                    <i class="far fa-file-alt" />
                    Salvar
                </button>
            </div>
        </div>
    </div>
</template>

<script>
    import Datepicker from "vuejs-datepicker";
    import selectTerm from "../terms/selectTerm";
    import generalTable from "../generalTable";
    import itemBody from "./itemBody";
    import money from "v-money";
    import Vue from "vue";
    import cardPanel from "../cardPanel";
    Vue.use(money, { precision: 4 });
    export default {
        components:{cardPanel, Datepicker, selectTerm, generalTable, itemBody},
        props:['editData'],
        data()
        {
            return {
                supplierList:[],
                supplier:"",
                type_ncf:"",
                invoiceDate:"",
                term:"",
                dueDate:"",
                rnc:"",
                nameSupplier:"",
                item:{
                    typeExpenses: "",
                    gross: 0,
                    discount: 0,
                    tax: 0,
                    totalNet: 0,
                },
                document:"",
                note:"",
                money: {
                    decimal: ".",
                    thousands: ",",
                    prefix: "RD$ ",
                    precision: 2,
                    masked: false
                },
                amount:0,
                payment:"",
                type_expenses:[]
            }
        },
        methods:{
            createFormStatus()
            {
                this.$emit('createFormStatus', false);
            },
            loadingStatus(status)
            {
                this.$emit('loadingStatus', status)
            },
            save(send)
            {
                if(!this.supplier)
                {
                    if(!this.nameSupplier || !this.rnc)
                    {
                        toastr.warning("Por favor llenar campos faltantes","Validador");
                        return;
                    }
                }

                if(!this.type_ncf || !this.document || !this.term || !this.item.typeExpenses || !this.term)
                {
                    toastr.warning("Por favor llenar los campos faltantes","Validador")
                    return;
                }
                this.loadingStatus(true);
                let url = this.editData ? '/expenses/edit' : '/expenses';
                axios.post(url, {
                    id:this.editData.id,
                    supplier:this.supplier,
                    invoiceDate:this.invoiceDate,
                    name_supplier:this.nameSupplier,
                    rnc:this.rnc,
                    document:this.document,
                    type_ncf:this.type_ncf,
                    typeExpenses:this.item.typeExpenses,
                    grossAmount:this.item.gross,
                    discountAmount:this.item.discount,
                    taxAmount:this.item.tax,
                    totalAmount:this.item.totalNet,
                    invoiceNote:this.note,
                    term:this.term,
                    invoiceDue:this.dueDate,
                    payment:this.payment,
                    send:send
                })
                    .then(resp => {
                        toastr.success( resp.data.message , "Validador");
                        if(resp.data.notification)
                        {
                            toastr.warning(resp.data.notification , "Validador");
                        }
                        window.open("/expenses/print?expenses_id=" + resp.data.id, "_blank");
                    })
                    .catch(err => {
                        if(err.response.data.message)
                        {
                            toastr.error(err.response.data.message, "Validador")
                        }
                        console.log(err)
                    })
                    .finally(() => {
                        this.loadingStatus(false);
                    })
            },
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
                        this.fetchTypeExpenses()
                    })
                    .catch(err => {
                        console.log(err);
                    });
            },
            fetchTypeExpenses() {
                axios
                    .get("/type_expenses/list")
                    .then(response => {
                        this.type_expenses = response.data;
                        if(this.editData)
                        {
                            this.completeForm();
                        }
                    })
                    .catch(err => {
                        console.log(err);
                    });
            },
            completeForm()
            {
                this.supplier = this.suppliers.find(e => e.code == this.editData.supplier_id);
                this.invoiceDate = this.editData.invoice_date;
                this.nameSupplier = this.editData.name_supplier
                this.rnc = this.editData.rnc;
                this.document = this.editData.document;
                this.type_ncf = this.editData.type_ncf;
                this.item.typeExpenses = this.TypeExpenses.find(e => e.code == this.editData.type_expenses).code;
                this.item.gross = this.editData.gross_amount;
                this.item.discount = this.editData.discount_amount;
                this.item.tax = this.editData.tax_amount;
                this.item.totalNet = this.editData.total_amount;
                this.note = this.editData.invoice_note;
                this.term = this.editData.invoice_term_id;
                this.dueDate = this.editData.invoice_due;
                this.payment = this.editData.payment;
            }
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
            TypeExpenses() {
                let array = [];
                this.type_expenses.forEach(element => {
                    array.push({
                        label: element.description,
                        code: element.id
                    });
                });
                return array;
            },
        },
        created() {
            this.fetchSupplier();
            this.invoiceDate = new Date();
        }
    }
</script>

<style scoped>

</style>
