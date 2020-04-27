<template>
    <card-panel style="margin-top: -30px">
        <template slot="body">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <h3>Recibir pago</h3>
                    </div>
                    <div class="col-md-12">
                        <hr />
                    </div>
                    <div class="col-md-12" style="margin-top: 20px">
                        <div class="row">
                            <div class="col-md-3">
                                <label>
                                    Supplidor:
                                    <span style="color:red">*</span>
                                </label>
                                <v-select
                                        v-model="supplier"
                                        :options="suppliers"
                                        @input="setSelected"
                                />
                            </div>
                            <div class="col-md-3">
                                <label for="email">
                                    Email:
                                    <span style="color:red">*</span>
                                </label>
                                <input type="text" maxlength="50" class="form-control form-control-sm" id="email" v-model="email" />
                            </div>
                            <div class="col-md-6">
                                <div class="float-right">
                                    <label>Monto Recibido:</label>
                                    <h2>RD${{parseFloat(AmountReceivedGeneral).formatMoney(2)}}</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12" style="margin-top: 10px">
                        <div class="row">
                            <div class="col-md-3">
                                <label>
                                    Fecha factura:
                                    <span style="color:red">*</span>
                                </label>
                                <datepicker
                                        v-model="PaymentDate"
                                        class="form-control form-control-sm"
                                        :format="'yyyy-MM-dd'"
                                        name="PaymentDate"
                                />
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12" style="margin-top: 10px">
                        <div class="row">
                            <div class="col-md-3">
                                <paymentsMethodsSelect @PaymentMethodsData="PaymentMethodsData" />
                                <!-- <label>
                                  Metodos de pago:
                                  <span style="color:red">*</span>
                                </label>
                                <v-select v-model="paymentMethods" :options="PaymentMethodsListForSelect" />-->
                            </div>
                            <div class="col-md-2">
                                <label for="reference">No. Referencia:</label>
                                <input
                                        type="text"
                                        maxlength="50"
                                        class="form-control form-control-sm"
                                        id="reference"
                                        v-model="reference"
                                />
                            </div>
                            <div class="col-md-2">
                                <label for="deposit">Depositado a :</label>
                                <input
                                        type="text"
                                        maxlength="50"
                                        class="form-control form-control-sm"
                                        id="deposit"
                                        v-model="deposit"
                                />
                            </div>
                            <div class="col-md-5">
                                <div class="float-right">
                                    <div class="form-group" style="width: 150px">
                                        <label for="amountReceived">Monto Recibido:</label>
                                        <money
                                                v-model="amountReceived"
                                                v-bind="money"
                                                class="form-control form-control-sm float-right"
                                                style="text-align: right;"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <hr />
                    </div>
                    <div class="col-md-12" style="margin-top: 10px">
                        <h4>Transacciones pendientes</h4>
                    </div>
                    <div class="col-md-12">
                        <general-table style="height:240px">
                            <template slot="table-header">
                                <tr>
                                    <th>
                                        <input type="checkbox" id="checkbox" v-model="checked" />
                                    </th>
                                    <th>Descripcion</th>
                                    <th>Fecha de vencimiento</th>
                                    <th style="text-align: right">Monto original</th>
                                    <th style="text-align: right">Balance pendiente</th>
                                    <th style="text-align: right">Pago</th>
                                    <th style="text-align: right">Descuento</th>
                                    <th style="text-align: right">Balance despues de pagado</th>
                                </tr>
                            </template>
                            <template slot="table-body">
                                <template v-for="(item, index) in supplierExpenses">
                                    <item-body-payment
                                            :key="index"
                                            :data="item"
                                            :index="index"
                                            @updateData="updateData"
                                            :amountReceivedState="amountReceivedState"
                                    />
                                </template>
                            </template>
                        </general-table>
                    </div>
                    <div class="col-md-12">
                        <hr />
                    </div>
                    <div class="col-md-12" style="margin-top: 20px">
                        <div class="float-right">
                            <div
                                    style="width: 300px;height: 150px;box-shadow: 0px 0px 3px 0px rgba(0,0,0,0.75);border-radius: 10px 10px 10px 10px;"
                            >
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-6" style="margin-top: 10px">
                                            <b>SubTotal:</b>
                                        </div>
                                        <div
                                                class="col-md-6"
                                                style="margin-top: 10px"
                                        >RD${{parseFloat(AmountReceivedGeneral).formatMoney()}}</div>
                                        <div class="col-md-12">
                                            <hr />
                                        </div>
                                        <div class="col-md-6">
                                            <b>Monto Total:</b>
                                        </div>
                                        <div class="col-md-6">RD${{parseFloat(AmountReceivedGeneral).formatMoney()}}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12" style="margin-top: 15px">
                        <div class="float-right">
                            <div class="btn-group">
                                <button
                                        type="button"
                                        class="btn btn-success btn-sm dropdown-toggle"
                                        data-toggle="dropdown"
                                        aria-haspopup="true"
                                        aria-expanded="false"
                                >
                                    <i class="fas fa-save" /> Guardar
                                </button>
                                <div class="dropdown-menu">
                                    <a
                                            class="dropdown-item"
                                            href="#"
                                            onclick="return false;"
                                            @click="save(false)"
                                    >Guardar</a>
                                    <a
                                            class="dropdown-item"
                                            href="#"
                                            onclick="return false;"
                                            @click="save(true)"
                                    >Guardar y Enviar</a>
                                </div>
                            </div>
                            <button class="btn btn-primary btn-sm" @click="cleanReceipt">
                                <i class="fas fa-broom" /> Limpiar recibo
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </card-panel>
</template>

<script>
    import Vue from "vue";
    import cardPanel from "../cardPanel";
    import Datepicker from "vuejs-datepicker";
    import money from "v-money";
    import generalTable from "../generalTable";
    import paymentsMethodsSelect from "../paymentMethods/paymentsMethodsSelect";
    import itemBodyPayment from "./itemBodyPayment";
    Vue.use(money, { precision: 4 });
    export default {
        components:{
            cardPanel,
            Datepicker,
            generalTable,
            paymentsMethodsSelect,
            itemBodyPayment
        },
        data()
        {
            return {
                money: {
                    decimal: ".",
                    thousands: ",",
                    prefix: "RD$ ",
                    precision: 2,
                    masked: false
                },
                supplierList:[],
                PaymentDate:"",
                paymentMethods: "",
                supplier:"",
                reference: "",
                deposit: "",
                amountReceived: 0,
                email:"",
                supplierExpenses:[],
                checked: false
            }
        },
        methods:{
            cleanReceipt() {
                this.amountReceived = 0;
                for (var index in this.supplierExpenses) {
                    this.supplierExpenses[index].amountReceived = 0;
                    this.supplierExpenses[index].discount = 0;
                }
            },
            save(send)
            {
                if (
                    this.supplier === "" ||
                    this.supplierExpenses.length === 0 ||
                    this.paymentMethods === ""
                ) {
                    toastr.warning("Por revisar los datos", "Validador");
                    return;
                }

                axios.post('/expenses/payment', {
                    supplier: this.supplier,
                    PaymentDate: this.PaymentDate,
                    email: this.email,
                    payment_method_id: this.paymentMethods,
                    reference: this.reference,
                    deposit_to: this.deposit,
                    amount: this.AmountReceivedGeneral,
                    items: this.supplierExpenses,
                    send: send
                })
                    .then((resp) => {
                        toastr.success("La operacion fue realizado con exito", "Respuesta");
                        this.amountReceived = 0;
                        this.supplier = "";
                        this.email = "";
                        this.paymentMethods = "";
                        this.reference = "";
                        this.deposit = "";
                        this.supplierExpenses = [];
                    })
                    .catch((err) => {
                        console.log(err)
                    })
            },
            updateData({ index, data }) {
                this.supplierExpenses.splice(index, 1, data);
                this.reCalculate();
            },
            reCalculate() {
                let amount = this.amountReceived;
                if (this.amountReceived > 0) {
                    for (var index in this.supplierExpenses) {
                        if (amount === 0) {
                            this.supplierExpenses[index].amountReceived = 0;
                            continue;
                        }
                        if (
                            amount >
                            parseFloat(this.supplierExpenses[index].invoice_balance) -
                            parseFloat(this.supplierExpenses[index].discount)
                        ) {
                            amount =
                                amount -
                                (parseFloat(this.supplierExpenses[index].invoice_balance) -
                                    parseFloat(this.supplierExpenses[index].discount));
                            this.supplierExpenses[index].amountReceived =
                                parseFloat(this.supplierExpenses[index].invoice_balance) -
                                parseFloat(this.supplierExpenses[index].discount);
                        } else {
                            this.supplierExpenses[index].amountReceived = amount;
                            return;
                        }
                    }
                    return;
                }
            },
            PaymentMethodsData(val) {
                this.paymentMethods = val;
            },
            setSelected(val) {
                let found = this.supplierList.find(e => e.id === val.code);
                if (found) {
                    this.email = found.email;
                }
                axios
                    .get("/expenses/supplier", {
                        params: {
                            supplier_id: val.code
                        }
                    })
                    .then(response => {
                        this.supplierExpenses = this.ExpensesDataFormat(response["data"]);
                    })
                    .catch(error => {
                        console.log(error);
                    });
            },
            ExpensesDataFormat(data) {
                let array = [];
                for (var index in data) {
                    array.push({
                        ...data[index],
                        discount: 0,
                        amountReceived: 0,
                        BalanceAfterPay: 0,
                        check: false
                    });
                }
                return array;
            },
            fetchSupplier() {
                axios
                    .get("/supplier/list/select")
                    .then(response => {
                        this.supplierList = response.data;
                        if (this.getUrlVars(window.location.href)["supplier"]) {
                            this.setSelected({
                                code: parseInt(this.getUrlVars(window.location.href)["supplier"])
                            });
                            let found = this.supplierList.find(
                                e =>
                                    e.id ===
                                    parseInt(this.getUrlVars(window.location.href)["supplier"])
                            );
                            this.supplier = {
                                label: found.name,
                                code: found.id
                            };
                        }
                        if(this.getUrlVars(window.location.href)["expense"])
                        {
                            this.supplier = {
                                label: this.getUrlVars(window.location.href)["name_supplier"],
                                code:null
                            };

                            axios
                                .get("/expenses/supplier", {
                                    params: {
                                        expense_id: parseInt(this.getUrlVars(window.location.href)["expense"])
                                    }
                                })
                                .then(response => {
                                    this.supplierExpenses = this.ExpensesDataFormat(response["data"]);
                                })
                                .catch(error => {
                                    console.log(error);
                                });
                        }
                    })
                    .catch(err => {
                        console.log(err);
                    });
            },
            getUrlVars() {
                var vars = [],
                    hash;
                var hashes = window.location.href
                    .slice(window.location.href.indexOf("?") + 1)
                    .split("&");
                for (var i = 0; i < hashes.length; i++) {
                    hash = hashes[i].split("=");
                    vars.push(hash[0]);
                    vars[hash[0]] = hash[1];
                }
                return vars;
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
            AmountReceivedGeneral() {
                let sum = 0;
                for (var index in this.supplierExpenses) {
                    sum += this.supplierExpenses[index].amountReceived;
                }
                return sum;
            },
            amountReceivedState() {
                return this.amountReceived > 0;
            },
        },
        watch:{
            amountReceived() {
                this.reCalculate();
            },
            checked() {
                for (var index in this.supplierExpenses) {
                    this.supplierExpenses[index].check = this.checked;
                }
            }
        },
        created() {
            this.fetchSupplier();
            var today = new Date();
            this.PaymentDate = today;
        }
    }
</script>

<style scoped>

</style>
