<template>
  <card-panel>
    <template slot="body">
      <div class="card-body">
        <div class="loader" v-if="loading"></div>
        <div class="row" v-if="data">
          <div class="col-md-6">
            <h2>{{data.name}}</h2>
            <p>
              {{data.rnc}} <br>
              {{data.email}} <br>
              {{data.contact}} - {{data.phone}} <br>
              {{data.observation}}
            </p>
          </div>
          <div class="col-md-6 nameRecord">
            <div class="float-right">
              <div class="stage__insight--open padding-left-10px">
                <div
                    class="insights__amount-text"
                    data-qbo-bind="text: openBalanceText"
                >RD${{parseFloat(data.balance.balance).formatMoney(2)}}</div>
                <div class="insights__label-text">Balance</div>
              </div>
            </div>
          </div>
          <div class="col-md-12" style="margin-top: 20px">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
              <li class="nav-item">
                <a
                    class="nav-link active show"
                    id="home-tab"
                    data-toggle="tab"
                    href="#home"
                    role="tab"
                    aria-controls="home"
                    aria-selected="true"
                >Lista de transacciones</a>
              </li>
            </ul>
            <div class="tab-content pl-3 p-1" id="myTabContent">
              <div
                  class="tab-pane fade active show"
                  id="home"
                  role="tabpanel"
                  aria-labelledby="home-tab"
              >
                <general-table style="margin-top: 20px" :hover="true" :bordered="true">
                  <template slot="table-header">
                    <th>DOCUMENTO</th>
                    <th>TIPO</th>
                    <th>FECHA</th>
                    <th style="text-align: right">TOTAL</th>
                    <th style="text-align: right">BALANCE</th>
                    <th>ESTADO</th>
                    <th />
                  </template>
                  <template slot="table-body">
                    <tr v-for="(item, index) in data.purchases" :key="index">
                      <th style="font-size: 14px">{{item.document_no}}</th>
                      <td style="font-size: 14px">{{item.tipo}}</td>
                      <td style="font-size: 14px">{{moment(item.created_at).format('MMMM D YYYY, h:mm:ss a')}}</td>
                      <td style="text-align: right;font-size: 14px">{{parseFloat(item.total).formatMoney(2)}}</td>
                      <td style="text-align: right;font-size: 14px">{{parseFloat(item.balance).formatMoney(2)}}</td>
                      <td style="font-size: 14px" :class="item.payment_status === 'COMPLETADO' ? 'paid' : 'overdue'">{{item.payment_status}}</td>
                      <td>
                        <button class="btn btn-sm btn-link" @click="purchasePayment(item.id)" v-if="item.tipo === 'Pago compra'">Historial</button>
                      </td>
                    </tr>
                  </template>
                </general-table>
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
        loading:false,
        data:null
      }
    },
    methods:{
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
      },
      purchasePayment(id)
      {
        window.location.href = '/purchase/payment?purchase='+id;
      },
      fetch(supplier_id)
      {
        this.loading = true;
        axios.get('/supplier/details/get', {
          params:{
            supplier_id:supplier_id
          }
        })
        .then((response) => {
          this.data = response.data;
        })
        .catch((error) => {
          console.log(error)
        })
        .finally(() => {
          this.loading = false;
        })
      }
    },
    created() {
      this.fetch(this.getUrlVars(window.location.href)["supplier"]);
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
    line-height: 0.85;
  }
  .nameRecord .insights__label-text {
    letter-spacing: 1px;
    margin-left: 5px;
    color: #6e8ba8;
    margin-top: -4px;
    text-transform: uppercase;
    font-size: 1.2rem;
    line-height: 0.8;
  }
  .paid {
    color: #108000;
  }
  .overdue {
    color: #f95700;
  }
</style>