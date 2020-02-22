<template>
  <card-panel style="margin-top: -30px">
    <template slot="body">
      <div class="card-body">
        <div class="row">
          <div class="col-md-12">
            <div style="float: left">
              <h3>{{clientForm ? 'Formulario de cliente' : 'Clientes'}}</h3>
            </div>
            <div style="float: right">
              <button
                  class="btn btn-sm"
                  :class="clientForm ? 'btn-danger' : ' btn-primary'"
                  @click="clientFormStatus(!clientForm)">
                <i class="fas"
                   :class="clientForm ? 'fa-angle-down' : 'fa-plus'" /> {{clientForm ? 'Ocultar' : 'Crear cliente'}}
              </button>
            </div>
          </div>
          <div class="col-md-12">
            <hr>
          </div>
          <template v-if="clientForm">
            <div class="col-md-12">
              <client-form :edit-data="editClientData.id" @hideForm="clientFormStatus(false)"/>
            </div>
          </template>
          <template v-else>
            <div class="col-md-12">
              <div class="row">
                <div class="col">
                  <summary-invoices :subtitle="' Facturas atrasado'" :summary="'overdue'"/>
                </div>
                <div class="col">
                  <summary-invoices :subtitle="' Facturas abierta'" :summary="'open_invoices'"/>
                </div>
                <div class="col">
                  <summary-invoices :subtitle="' Facturas saldadas los ultimas 30 dias'" :summary="'paid_last_30_days'"/>
                </div>
              </div>
            </div>
            <div class="col-md-12" style="margin-top: 50px">
              <general-table :paginate="customerData" style="height: 400px" :hover="true">
                <template slot="table-header">
                  <tr>
                    <th>Cliente</th>
                    <th>Telefono</th>
                    <th align="right" style="text-align: right">Balance</th>
                    <th></th>
                  </tr>
                </template>
                <template slot="table-body">
                  <tr v-if="loading">
                    <td colspan="4">
                      <div class="text-center">
                        <h3> Cargando ... </h3>
                      </div>
                    </td>
                  </tr>
                  <tr v-for="(item, index) in customerData.data" :key="index">
                    <td style="width: 40%;cursor: pointer" @click="DetailClient(item.id)">{{item.nombre}}</td>
                    <td style="width: 40%">{{item.telefono}}</td>
                    <td align="right">RD${{parseFloat(item.balance).formatMoney(2)}}</td>
                    <td>
                      <div class="btn-group">
                        <button type="button" class="btn btn-link" @click="editClient(item.id)">Editar</button>
                        <button type="button" class="btn btn-light dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <div class="dropdown-menu">
                          <a class="dropdown-item"
                             :class="parseFloat(item.balance) === 0 ? 'disabled' : ''"
                             href="#"
                             @click="toBillPayment(item.id)">Recibo de pago</a>
                          <a class="dropdown-item"  href="#" @click="ToInvoice(item.id)">Crear factura</a>
                          <a class="dropdown-item" href="#" @click="ToEstimate(item.id)">Crear cotizacion</a>
                        </div>
                      </div>
                    </td>
                  </tr>
                </template>
              </general-table>
            </div>
          </template>
        </div>
      </div>
    </template>
  </card-panel>
</template>
<script>
  import cardPanel from "../cardPanel";
  import generalTable from "../generalTable";
  import summaryInvoices from "./summaryInvoices";
  import clientForm from "../client/clientForm";

export default {
  components:{
    cardPanel,
    generalTable,
    summaryInvoices,
    clientForm
  },
  data(){
    return {
      customerData:{},
      loading:false,
      clientForm:false,
      editClientData:{id:''}
    }
  },
  methods:{
    editClient(id)
    {
      this.editClientData.id = id;
      this.clientFormStatus(true);
    },
    clientFormStatus(status)
    {
      this.clientForm = status;
      if(!status)
      {
        this.fetchData()
        this.editClientData.id = ''
      }
    },
    DetailClient(id)
    {
      window.location.href = '/client/details?client='+id;
    },
    ToEstimate(id)
    {
      window.location.href = '/estimate?client='+id;
    },
    ToInvoice(id)
    {
      window.location.href = '/billing?client='+id;
    },
    toBillPayment(id)
    {
      window.location.href = '/invoice/payment?client='+id;
    },
    fetchData()
    {
      this.loading = true;
      axios.get('/clients/balance')
      .then((response) => {
        this.customerData = response.data;
      })
      .catch((err) => {
        console.log(err)
      })
      .finally(()=> {
        this.loading = false;
      })
    }
  },
  created() {
    this.fetchData()
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
  .fade-enter-active, .fade-leave-active {
    transition: opacity .5s;
  }
  .fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
    opacity: 0;
  }
</style>