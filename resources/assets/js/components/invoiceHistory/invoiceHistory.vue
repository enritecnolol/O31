<template>
  <card-panel>
    <template slot="body">
      <div class="card-body">
        <div class="row">
          <div class="col-md-12 text-center">
            <h2>Historial de facturas</h2>
            <hr style="background-color: rgb(0, 98, 204)">
          </div>
          <div class="col-md-12">
            <input
                    style="text-align: center"
                    type="text"
                    class="form-control"
                    v-model="invoice"
                    @keypress.enter="searchHistory(invoice)"
                    placeholder="No. Factura"
            >
          </div>
          <div class="col-md-12" v-if="!invoiceData">
            <general-table :paginate="tableData" :hover="true" @pageChange="getInvoice" :responsive="false">
              <template slot="table-header">
                <th>No. factura</th>
                <th>Fecha</th>
                <th>Terminos</th>
                <th>Cliente</th>
                <th style="text-align: right">Total</th>
                <th>Estado</th>
                <th>Estado pagado</th>
                <th style="text-align: right">Balance pendiente</th>
                <th />
              </template>
              <template slot="table-body">
                <tr v-if="dataSize === 0">
                  <th
                          colspan="9"
                          style="font-size: 20px;text-align: center"
                  >No hemos encontrado resultado ....</th>
                </tr>
                <tr v-for="(item, index) in tableData.data" :key="index">
                  <th>#{{item.id}}</th>
                  <td>{{moment(item.date).format('DD-MM-YYYY')}}</td>
                  <td>{{TermTitle(item.term_id)}}</td>
                  <td>{{toShowClient(item.client)}}</td>
                  <td style="text-align: right">{{parseFloat(item.total_facture).formatMoney(2)}}</td>
                  <td>
                <span
                        :style="{
                color:spanColor(item.status).color,
                background:spanColor(item.status).background
              }"
                        style="font-size: 13px;padding: 5px 10px;"
                >{{item.status}}</span>
                  </td>
                  <td>
                <span
                        :style="{
                color:spanBackgroundColor(item.paid_status).color,
                background:spanBackgroundColor(item.paid_status).background
              }"
                        style="font-size: 13px;padding: 5px 10px;"
                >{{item.paid_status}}</span>
                  </td>
                  <td style="text-align: right">{{parseFloat(item.open_balance).formatMoney(2)}}</td>
                  <td><button class="btn btn-sm btn-link" @click="searchHistory(item.id)">Ver historial</button></td>
                </tr>
              </template>
            </general-table>
          </div>
          <div class="col-md-12" v-else>
            <history-template :invoiceData="invoiceData" :invoiceTransactions="invoiceTransactions" @cleanHistory="cleanHistory"/>
          </div>
        </div>
      </div>
    </template>
  </card-panel>
</template>

<script>
  import generalTable from "../generalTable";
  import cardPanel from "../cardPanel";
  import historyTemplate from "./historyTemplate";
  export default {
    components:{
      cardPanel,
      generalTable,
      historyTemplate
    },
    data()
    {
      return{
        tableData: {},
        loading:false,
        clientsData:null,
        termsList:null,
        invoiceToSearch:"",
        invoiceData:null,
        invoiceTransactions:null,
        invoice:""
      }
    },
    methods:{
      cleanHistory()
      {
        this.invoice = "";
        this.invoiceToSearch = "";
        this.invoiceData = null;
        this.invoiceTransactions = null;
      },
      searchHistory(id)
      {
       this.invoiceToSearch = id;
       axios.post('/invoices/history', {
         invoice:id
       })
        .then((response) => {
          this.invoiceData = response.data.invoice;
          this.invoiceTransactions = response.data.transactions;
          console.log(response)
        })
        .catch((error) => {
          console.log(error)
        })
      },
      loadingStatus(val) {
        this.loading = val;
      },
      getInvoice(page) {
        this.loadingStatus(true);
        axios
                .get("/invoices/list", {
                  params: {
                    filters: {
                      customer: "",
                      from: "",
                      to: "",
                      codeInvoice: "",
                      status: "ALL"
                    },
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
      spanColor(status) {
        if (status === "COMPLETADO") {
          return { color: "#354930", background: "#d5eed0" };
        } else if (status === "DEUDA") {
          return { color: "#6c432e", background: "#f8edcb" };
        } else {
          return { color: "#1e576c", background: "#c9e3ec" };
        }
      },
      spanBackgroundColor(status) {
        if (status === "PAGADO") {
          return { color: "#354930", background: "#d5eed0" };
        } else if (status === "NO PAGADO") {
          return { color: "#6c432e", background: "#f8edcb" };
        } else {
          return { color: "#1e576c", background: "#c9e3ec" };
        }
      },
      ClientsDate() {
        axios
                .post("/clientes/datos/tabla2")
                .then(response => {
                  this.clientsData = response["data"];
                })
                .catch(error => {
                  console.log(error);
                });
      },
      toShowClient(id) {
        if (this.clientsData) {
          let found = this.clientsData.find(e => e.id === parseInt(id));
          if (found) {
            return found.nombre;
          }
          return "General";
        }
        return "no found";
      },

      TermTitle(id)
      {
        let found = this.termsList.find(e => e.id == id);
        if(found)
        {
          return found.name;
        }
        return "";
      },
      getTermsList() {
        axios
                .get("/terms/list")
                .then(response => {
                  this.termsList = response.data;
                  console.log(response);
                })
                .catch(err => {
                  console.log(err);
                });
      },
    },
    computed:{
      dataSize() {
        let count = 0;
        if(!this.tableData)
        {
          return 0;
        }
        for (var index in this.tableData.data) {
          count++;
        }
        return count;
      }
    },
    created() {
      this.getTermsList();
      this.ClientsDate();
      this.getInvoice();
    }
  }
</script>

<style scoped>

</style>
