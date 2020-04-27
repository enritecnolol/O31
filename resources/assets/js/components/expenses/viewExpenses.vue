<template>
    <div class="row">
        <div class="col-md-12">
            <div class="float-left">
            <h3>Lista de Gastos</h3>
            </div>
            <div class="float-right">
                <button class="btn btn-sm btn-primary" @click="createFormStatus">Crear gastos</button>
            </div>
        </div>
        <div class="col-md-12">
            <hr>
        </div>
        <div class="col-md-12">
            <div class="row" style="margin-bottom: 15px;margin-top: 5px">
                <div class="col-md-3">
                    <label>Provedor:</label>
                    <v-select v-model="filter.supplier" :options="suppliers" />
                </div>
                <div class="col-md-3">
                    <label>Desde:</label>
                    <datepicker
                            v-model="filter.from"
                            :bootstrap-styling="true"
                            :calendar-class="'form-control form-control-sm'"
                            :format="'yyyy-MM-dd'"
                            name="from"
                    />
                </div>
                <div class="col-md-3">
                    <label>Hasta:</label>
                    <datepicker
                            v-model="filter.to"
                            :bootstrap-styling="true"
                            :calendar-class="'form-control form-control-sm'"
                            :format="'yyyy-MM-dd'"
                            name="to"
                    />
                </div>
                <div class="col-md-3">
                    <label>Codigo de gasto:</label>
                    <input
                            type="text"
                            class="form-control"
                            v-model="filter.codeExpenses"
                            placeholder="#00000"
                    />
                </div>
<!--                <div class="col-md-3" style="margin-top: 10px">-->
<!--                    <label for="status">Estado:</label>-->
<!--                    <select id="status" class="form-control" v-model="filter.status">-->
<!--                        <option value="ALL">Todas</option>-->
<!--                        <option value="1">Activos</option>-->
<!--                        <option value="0">Inactivos</option>-->
<!--                    </select>-->
<!--                </div>-->
            </div>
        </div>
        <div class="col-md-12">
            <general-table :paginate="tableData" :hover="true" @pageChange="getExpenses">
                <template slot="table-header">
                    <tr>
                        <th>#</th>
                        <th>Fecha</th>
                        <th>Termino</th>
                        <th>Suplidor</th>
                        <th>NCF</th>
                        <th>Tipo de gasto</th>
                        <th style="text-align: right">Monto total</th>
                        <th style="text-align: right">Balance</th>
                        <th></th>
                        <th>Estado</th>
                        <th></th>
                    </tr>
                </template>
                <template slot="table-body">
                    <tr v-if="loading">
                        <td colspan="9">
                            <div class="text-center">
                                <h3>Cargando ...</h3>
                            </div>
                        </td>
                    </tr>
                    <tr v-else v-for="(item, index) in tableData.data" :key="index">
                        <td>{{item.id}}</td>
                        <td>{{item.invoice_date}}</td>
                        <td>{{item.name}}</td>
                        <td>{{item.supplier_id ? SupplierName(item.supplier_id) : item.name_supplier}}</td>
                        <td>{{item.ncf}}</td>
                        <td>{{TypeExpensesName(item.type_expenses)}}</td>
                        <td style="text-align: right">{{parseFloat(item.total_amount).formatMoney(2)}}</td>
                        <td style="text-align: right">{{parseFloat(item.invoice_balance).formatMoney(2)}}</td>
                        <td style="text-align: center">
                          <span :style="{
                            color:spanColor(item.payment_process).color,
                            background:spanColor(item.payment_process).background
                          }"
                                style="font-size: 13px;padding: 5px 10px;"
                          >{{item.payment_process}}</span>
                        </td>
                        <td style="text-align: center">
                          <span :style="{
                            color:spanColor(item.invoice_status).color,
                            background:spanColor(item.invoice_status).background
                          }"
                                  style="font-size: 13px;padding: 5px 10px;"
                          >{{item.invoice_status ? "Activo" : "Inactivo"}}</span>
                        </td>
                        <td>
                            <div class="dropdown">
                                <button
                                        class="btn btn-sm btn-secondary dropdown-toggle"
                                        type="button"
                                        id="dropdownMenuButton"
                                        data-toggle="dropdown"
                                        aria-haspopup="true"
                                        aria-expanded="false"
                                >
                                    <i class="fas fa-bars" />
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item"
                                       href="#"
                                       onclick="return false;"
                                       @click="EditData(item)"
                                    >Editar</a>
                                    <a
                                            class="dropdown-item"
                                            href="#"
                                            onclick="return false;"
                                            @click="toPrint(item.id)"
                                    >Reimprimir</a>
                                    <a
                                            class="dropdown-item"
                                            href="#"
                                            onclick="return false;"
                                            @click="toPay(item)"
                                    >Pago de gasto</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr v-if="dataSize == 0">
                        <td colspan="9">
                            <div class="text-center">
                                <h3>No hemos encontrado datos!!!</h3>
                            </div>
                        </td>
                    </tr>
                </template>
                <template slot="bottom-down">
                    <div class="float-left">
                        Mostando {{dataSize}} de 10
                    </div>
                </template>
            </general-table>
        </div>
    </div>
</template>

<script>
    import generalTable from "../generalTable";
    import Datepicker from "vuejs-datepicker";
    export default {
        components:{generalTable, Datepicker},
        data()
        {
            return{
                tableData:{},
                loading:false,
                filter: {
                    supplier: "",
                    from: "",
                    to: "",
                    codeExpenses: "",
                    status: "ALL"
                },
                supplierList:[],
                type_expenses:[]
            }
        },
        methods:{
            fetchTypeExpenses() {
                axios
                    .get("/type_expenses/list")
                    .then(response => {
                        this.type_expenses = response.data;
                    })
                    .catch(err => {
                        console.log(err);
                    });
            },
            toPay(item)
            {
                window.open("/expenses/payment?supplier=" + item.supplier_id, "_blank");
            },
            toPrint(id)
            {
                window.open("/expenses/print?expenses_id=" + id, "_blank");
            },
            EditData(item)
            {
                this.$emit('EditData', item)
            },
            createFormStatus()
            {
                this.$emit('createFormStatus', true);
            },
            SupplierName(id)
            {
                var found = this.suppliers.find(e => e.code == id);
                if(found)
                {
                    return found.label
                }
                return "no found"
            },
            TypeExpensesName(id)
            {
                var found = this.type_expenses.find(e => e.id == id);
                if(found)
                {
                    return found.description
                }
                return "no found"
            },
            getExpenses(page) {
                this.loadingStatus(true);
                axios
                    .get("/expenses/list", {
                        params: {
                            filters: this.filter,
                            page: page
                        }
                    })
                    .then(response => {
                        this.tableData = response["data"];
                    })
                    .catch(error => {
                        console.log(error);
                    })
                    .finally(() => {
                        this.loadingStatus(false);
                    });
            },
            loadingStatus(val) {
                this.$emit("loadingStatus", val);
                this.loading = val;
            },
            spanColor(status) {
                if (status === 1 || status === "COMPLETADO") {
                    return { color: "#354930", background: "#d5eed0" };
                } else if (status === 0 || status === "DEUDA") {
                    return { color: "#6c432e", background: "#f8edcb" };
                } else {
                    return { color: "#1e576c", background: "#c9e3ec" };
                }
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
            dataSize() {
                let count = 0;
                for (var index in this.tableData.data) {
                    count++;
                }
                return count;
            }
        },
        watch: {
            filter: {
                handler(val, oldVal) {
                    this.getExpenses(1);
                },
                deep: true
            }
        },
        created() {
            this.getExpenses()
            this.fetchSupplier();
            this.fetchTypeExpenses();
        }
    }
</script>

<style scoped>

</style>
