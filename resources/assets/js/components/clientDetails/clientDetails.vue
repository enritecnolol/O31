<template>
  <card-panel style="margin-top: -30px">
    <template slot="body">
      <div class="card-body">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <div class="" style="float: left">
                <h2>Cliente </h2>
              </div>
              <div class="" style="float: right">
                <button type="button" class="btn btn-sm btn-outline-secondary">Editar</button>
                <div class="btn-group">
                  <button type="button" class="btn btn-sm btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="border-radius: 17px;">
                    Nueva transaccion
                  </button>
                  <div class="dropdown-menu">
                    <a class="dropdown-item" href="#" @click="ToInvoice(client)">Factura</a>
                    <a class="dropdown-item" href="#" @click="ToEstimate(client)">Cotizacion</a>
                    <a class="dropdown-item" href="#" @click="BillPayment">Recibo de pago</a>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-12">
              <hr>
            </div>
            <div class="col-md-12 nameRecord" style="margin-top: 10px">
              <div class="" style="float: left">
                <h3>{{clientInfo.nombre}}</h3>
                <p>{{clientInfo.direccion}}</p>
                <p>{{clientInfo.observacion}}</p>
              </div>
              <div class="" style="float: right">
                <div class="stage__insight--open padding-left-10px">
                  <div class="insights__amount-text" data-qbo-bind="text: openBalanceText">RD${{parseFloat(openBalance).formatMoney(2)}}</div>
                  <div class="insights__label-text">Balance</div>
                </div>
                <div class="stage__insight--overdue padding-left-10px" style="margin-top: 10px">
                  <div class="insights__amount-text" data-qbo-bind="text: overdueBalanceText">RD${{parseFloat(overDue).formatMoney(2)}}</div>
                  <div class="insights__label-text">Atrasado</div>
                </div>
              </div>
            </div>
            <div class="col-md-12" style="margin-top: 20px">
              <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active show" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Lista de transacciones</a>
                </li>
              </ul>
              <div class="tab-content pl-3 p-1" id="myTabContent">
                <div class="tab-pane fade active show" id="home" role="tabpanel" aria-labelledby="home-tab">

                  <general-table :hover="true" :bordered="true" style="margin-top: 15px">
                    <template slot="table-header">
                      <tr>
                        <th>FECHA</th>
                        <th>TIPO</th>
                        <th>NO.</th>
                        <th>FECHA VENCIMIENTO</th>
                        <th style="text-align: right">BALANCE</th>
                        <th style="text-align: right">TOTAL</th>
                        <th>ESTADO</th>
                        <th style="text-align: right">Action</th>
                      </tr>
                    </template>
                    <template slot="table-body">
                      <template v-for="(item, index) in transactions">
                        <tr :key="index">
                          <td style="font-size: 14px">{{item.date}}</td>
                          <td style="font-size: 14px;width: 30%" >{{item.type_sale}}</td>
                          <th style="font-size: 14px" >#{{item.id}}</th>
                          <td style="font-size: 14px" >{{item.due_date}}</td>
                          <td style="font-size: 14px;text-align: right" >RD${{parseFloat(item.open_balance).formatMoney(2)}}</td>
                          <td style="font-size: 14px;text-align: right" >RD${{parseFloat(item.total_facture).formatMoney(2)}}</td>
                          <td  style="font-size: 14px" :class="item.status === 'COMPLETADO' || item.status === 'PAGADO' ? 'paid' : 'overdue'">{{item.status}}</td>
                          <td style="font-size: 14px;text-align: right;width: 80px" >
                            <div class="btn-group" v-if="item.status === 'COMPLETADO'">
                              <button type="button" class="btn btn-sm btn-link">Imprimir</button>
                              <button type="button" class="btn btn-sm btn-link dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="sr-only">Toggle Dropdown</span>
                              </button>
                              <div class="dropdown-menu">
                                <a class="dropdown-item" href="#">Enviar</a>
                                <a class="dropdown-item" href="#">Ver</a>
                              </div>
                            </div>
                            <div class="btn-group" v-if="item.status === 'DEUDA'">
                              <button type="button" class="btn btn-sm btn-link" @click="BillPayment">Recibo de pago</button>
                              <button type="button" class="btn btn-sm btn-link dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="sr-only">Toggle Dropdown</span>
                              </button>
                              <div class="dropdown-menu">
                                <a class="dropdown-item" href="#">Imprimir</a>
                                <a class="dropdown-item" href="#">Enviar</a>
                                <a class="dropdown-item" href="#">Ver</a>
                              </div>
                            </div>
                          </td>
                        </tr>
                      </template>
                    </template>
                  </general-table>
                </div>
              </div>

            </div>

          </div>
        </div>
      </div>
    </template>
  </card-panel>
</template>
<script>
  import cardPanel from "../cardPanel";
  import generalTable from "../generalTable";
  export default {
    components:{
      cardPanel,
      generalTable
    },
    data()
    {
      return {
        client:'',
        clientInfo:{},
        overDue:0,
        openBalance:0,
        transactions:[]
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
      BillPayment()
      {
        window.location.href = '/invoice/payment?client='+this.client;
      },
      fetchData(id)
      {
        axios.get('/client/details/data', {
          params:{
            client:this.client
          }
        })
            .then((response) => {
              this.clientInfo = response.data.clientInfo;
              this.overDue = response.data.overDue.overdue;
              this.openBalance = response.data.openBalance.balance;
            })
            .catch((err) => {
              console.log(err)
            })
      },
      fetchTransactionsData(id)
      {
        axios.get('/client/details/transactions', {
          params:{
            client:id
          }
        })
            .then((response) => {
              this.transactions = response.data.transactions;
            })
            .catch((err) => {
              console.log(err)
            })
      },
      getUrlVars()
      {
        var vars = [], hash;
        var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
        for(var i = 0; i < hashes.length; i++)
        {
          hash = hashes[i].split('=');
          vars.push(hash[0]);
          vars[hash[0]] = hash[1];
        }
        return vars;
      },
    },
    created() {
      if(this.getUrlVars(window.location.href)['client'])
      {
        this.client = this.getUrlVars(window.location.href)['client'];
        this.fetchData(this.client)
        this.fetchTransactionsData(this.client)
      }
    }
  }
</script>
<style>
  .nameRecord .stage__insight--open {
    border-left: 5px solid #f2b835;
  }
  .nameRecord .stage__insight--overdue {
    border-left: 5px solid #ce5133;
  }
  .nameRecord .padding-left-10px {
    padding-left: 10px;
  }
  .nameRecord .insights__amount-text {
    font-size: 18px;
    color: #56b349;
    padding: 2px 4px 4px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    padding-bottom: 8px;
    color: #000;
    line-height: .85;
  }
  .nameRecord .insights__label-text {
    letter-spacing: 1px;
    margin-left: 5px;
    color: #6e8ba8;
    margin-top: -4px;
    text-transform: uppercase;
    font-size: 1.2rem;
    line-height: .8;
  }
  .paid{
    color: #108000;
  }
  .overdue {
    color: #f95700;
  }
</style>