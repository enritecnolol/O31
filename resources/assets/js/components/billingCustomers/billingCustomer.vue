<template>
  <card-panel style="margin-top: -30px">
    <template slot="body">
<!--      <div class="loader" v-if="loading"></div>-->
      <div class="card-body">
        <div class="row">
          <div class="col-md-12">
            <h3>Clientes de facturación</h3>
          </div>
          <div class="col-md-12">
            <hr>
          </div>
          <div class="col-md-12">
            <div class="row justify-content-md-center">
              <div class="col-md">
                <summary-invoices :subtitle="' Facturas atrasado'" :summary="'overdue'"/>
              </div>
              <div class="col-md">
                <summary-invoices :subtitle="' Facturas abierta'" :summary="'open_invoices'"/>
              </div>
              <div class="col-md">
                <summary-invoices :subtitle="' Pagado los ultimas 30 dias'" :summary="'paid_last_30_days'"/>
              </div>
            </div>
          </div>
          <div class="col-md-12" style="margin-top: 50px">
            <general-table :paginate="customerData" style="height: 400px">
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
                <tr v-for="(item, index) in customerData.data">
                  <td style="width: 40%">{{item.nombre}}</td>
                  <td style="width: 40%">{{item.telefono}}</td>
                  <td align="right">RD${{parseFloat(item.balance).formatMoney(2)}}</td>
                  <td>
                    <div class="dropdown">
                      <a class="btn btn-link dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Acción
                      </a>
                      <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <a class="dropdown-item" :class="parseFloat(item.balance) === 0 ? 'disabled' : ''" href="#" @click="toBillPayment(item.id)">Recibo de pago</a>
                        <a class="dropdown-item"  href="#" @click="ToInvoice(item.id)">Crear factura</a>
                        <a class="dropdown-item" href="#" @click="ToEstimate(item.id)">Crear cotizacion</a>
                      </div>
                    </div>
                  </td>
                </tr>
              </template>
            </general-table>
          </div>
        </div>
      </div>
    </template>
  </card-panel>
</template>
<script>
  import cardPanel from "../cardPanel";
  import generalTable from "../generalTable";
  import summaryInvoices from "./summaryInvoices";
export default {
  components:{
    cardPanel,
    generalTable,
    summaryInvoices
  },
  data(){
    return {
      customerData:{},
      loading:false
    }
  },
  methods:{
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
</style>