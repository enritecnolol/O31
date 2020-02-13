<template>
  <card-panel style="margin-top: -30px">
    <template slot="body">
      <div class="card-body">
        <div class="row">
          <div class="col-md-12">
            <h3>Recibir pago</h3>
          </div>
          <div class="col-md-12">
            <hr>
          </div>
          <div class="col-md-12" style="margin-top: 20px">
            <div class="row">
              <div class="col-md-3">
                <label>Cliente: <span style="color:red">*</span></label>
                <v-select v-model="selectedCustomer" :options="clientsListForSelect" @input="setSelected"/>
              </div>
              <div class="col-md-3">
                <label for="email">Email: <span style="color:red">*</span></label>
                <input type="text" class="form-control form-control-sm" id="email" v-model="email">
              </div>
              <div class="col-md-6">
                <div class="float-right">
                  <label>Monto Recibido:</label>
                  <h2>RD${{parseFloat(AmountReceivedGeneral).formatMoney(2)}}</h2>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-12" style="margin-top: 50px">
            <div class="row">
              <div class="col-md-3">
                <label>Fecha factura: <span style="color:red">*</span></label>
                <datepicker v-model="PaymentDate" class="form-control form-control-sm" :format="'yyyy-MM-dd'" name="PaymentDate" />
              </div>
            </div>
          </div>
          <div class="col-md-12" style="margin-top: 30px">
            <div class="row">
              <div class="col-md-3">
                <label>Metodos de pago: <span style="color:red">*</span></label>
                <v-select v-model="paymentMethods" :options="PaymentMethodsListForSelect"/>
              </div>
              <div class="col-md-2">
                <label for="reference">No. Referencia:</label>
                <input type="text" class="form-control form-control-sm" id="reference" v-model="reference">
              </div>
              <div class="col-md-2">
                <label for="deposit">Depositado a :</label>
                <input type="text" class="form-control form-control-sm" id="deposit" v-model="deposit">
              </div>
              <div class="col-md-5">
                <div class="float-right">
                  <div class="form-group" style="width: 150px">
                    <label for="amountReceived">Monto Recibido:</label>
                    <money v-model="amountReceived" v-bind="money" class="form-control form-control-sm  float-right" style="text-align: right;" />
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <hr>
          </div>
          <div class="col-md-12" style="margin-top: 20px">
            <h4>Transacciones pendientes</h4>
          </div>
          <div class="col-md-12">
            <general-table>
              <template slot="table-header">
                <tr>
                  <th>
                    <input type="checkbox" id="checkbox" v-model="checked">
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
                <template v-for="(item, index) in clientInvoices">
                  <item-body :data="item" :index="index" @updateData="updateData" :amountReceivedState="amountReceivedState"/>
                </template>
              </template>
            </general-table>
          </div>
          <div class="col-md-12">
            <hr>
          </div>
          <div class="col-md-12" style="margin-top: 50px">
            <div class="float-right">
              <div style="width: 300px;height: 150px;box-shadow: 0px 0px 3px 0px rgba(0,0,0,0.75);border-radius: 10px 10px 10px 10px;">
                <div class="container">
                  <div class="row">
                    <div class="col-md-6" style="margin-top: 10px"><b>SubTotal:</b></div>
                    <div class="col-md-6" style="margin-top: 10px">RD${{parseFloat(AmountReceivedGeneral).formatMoney()}}</div>
                    <div class="col-md-12">
                      <hr>
                    </div>
                    <div class="col-md-6"><b>Monto Total:</b></div>
                    <div class="col-md-6">RD${{parseFloat(AmountReceivedGeneral).formatMoney()}}</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-12" style="margin-top: 15px">
            <div class="float-right">
              <div class="btn-group">
                <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="fas fa-save" /> Guardar
                </button>
                <div class="dropdown-menu">
                  <a class="dropdown-item" href="#" @click="save">Guardar</a>
                  <a class="dropdown-item" href="#">Guardar y Enviar</a>
                </div>
              </div>
              <button class="btn btn-primary btn-sm" @click="cleanReceipt"><i class="fas fa-broom" /> Limpiar recibo</button>
            </div>
          </div>
        </div>
      </div>
    </template>
  </card-panel>
</template>
<script>
  import Vue from 'vue';
  import cardPanel from "../cardPanel";
  import Datepicker from 'vuejs-datepicker';
  import money from 'v-money';
  import generalTable from "../generalTable";
  import itemBody from "./itemBody";
  Vue.use(money, {precision: 4});
  export default {
    name:'bill-payment',
    components:{cardPanel, Datepicker, generalTable, itemBody},
    data(){
      return{
        selectedCustomer : '',
        paymentMethods : '',
        clientsData:[],
        email:'',
        PaymentDate:'',
        PaymentMethodList:[],
        reference:'',
        deposit:'',
        amountReceived:0,
        clientInvoices:[],
        money: {
          decimal: '.',
          thousands: ',',
          prefix: 'RD$ ',
          precision: 2,
          masked: false
        },
        checked:false
      }
    },
    methods:{
      save(send)
      {
        if(this.selectedCustomer === '' || this.clientInvoices.length === 0 || this.paymentMethods === '')
        {
          toastr.warning('Por revisar los datos', 'Validador')
          return;
        }
        axios.post('/pay/payment', {
          client_id: this.selectedCustomer,
          date:this.PaymentDate,
          email:this.email,
          payment_method_id:this.paymentMethods,
          reference:this.reference,
          deposit_to:this.deposit,
          amount:this.AmountReceivedGeneral,
          items: this.clientInvoices
        })
            .then((response) => {
              toastr.success('La operacion fue realizado con exito', 'Respuesta')
              this.amountReceived = 0;
              this.selectedCustomer = '';
              this.email = '';
              this.paymentMethods = '';
              this.reference = '';
              this.deposit = '';
              this.clientInvoices = [];
            })
            .catch( (error) => {
              console.log(error);
            });
      },
      cleanReceipt()
      {
        this.amountReceived = 0;
        for (var index in this.clientInvoices){
          this.clientInvoices[index].amountReceived = 0;
          this.clientInvoices[index].discount = 0;
        }
      },
      updateData({index, data})
      {
        this.clientInvoices.splice(index, 1, data);
        this.reCalculate();
      },
      InvoiceDataFormat(data)
      {
        let array = [];
        for(var index in data)
        {
          array.push({
            ...data[index],
            discount:0,
            amountReceived:0,
            BalanceAfterPay:0,
            check:false
          });
        }
        return array;
      },
      ClientsDate()
      {
        axios.post('/clientes/datos/tabla2')
            .then((response) => {
              this.clientsData = response['data'];
              if(this.getUrlVars(window.location.href)['client'])
              {
                this.setSelected({code: parseInt(this.getUrlVars(window.location.href)['client'])})
                let found = this.clientsData.find(e => e.id === parseInt(this.getUrlVars(window.location.href)['client']));
                this.selectedCustomer = {
                  label: found.nombre,
                  code:found.id
                }
              }
            })
            .catch( (error) => {
              console.log(error);
            });
      },
      getPaymentsMethods()
      {
        axios.get('/payment/methods/without/paginate')
            .then((response) => {
              this.PaymentMethodList = response['data'];
            })
            .catch( (error) => {
              console.log(error);
            });
      },
      setSelected(val)
      {
        let found = this.clientsData.find(e => e.id === val.code);
        if(found)
        {
          this.email = found.email;
        }
        axios.get('/invoice/client', {
          params:{
            client_id:val.code
          }
        })
            .then((response) => {
              this.clientInvoices = this.InvoiceDataFormat(response['data'])
            })
            .catch( (error) => {
              console.log(error);
            });
      },

      reCalculate()
      {

        let amount = this.amountReceived;
        if(this.amountReceived > 0)
        {
          for (var index in this.clientInvoices)
          {
            if(amount === 0)
            {
              this.clientInvoices[index].amountReceived = 0;
              continue;
            }
            if(amount > (parseFloat(this.clientInvoices[index].open_balance) - parseFloat(this.clientInvoices[index].discount)))
            {
              amount = amount - (parseFloat(this.clientInvoices[index].open_balance) - parseFloat(this.clientInvoices[index].discount));
              this.clientInvoices[index].amountReceived = (parseFloat(this.clientInvoices[index].open_balance) - parseFloat(this.clientInvoices[index].discount));

            }else{
              this.clientInvoices[index].amountReceived = amount;
              return;
            }
          }
          return;
        }
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
    computed:{
      /**
       * @return {number}
       */
      AmountReceivedGeneral()
      {
        let sum = 0;
        for (var index in this.clientInvoices){
          sum += this.clientInvoices[index].amountReceived;
        }
        return sum;
      },
      amountReceivedState()
      {
        return this.amountReceived > 0
      },
      clientsListForSelect()
      {
        let array = [];
        for (var index in this.clientsData)
        {
          array.push({
            label:this.clientsData[index].nombre,
            code:this.clientsData[index].id
          })
        }
        return array;
      },
      PaymentMethodsListForSelect()
      {
        let array = [];
        for (var index in this.PaymentMethodList)
        {
          array.push({
            label:this.PaymentMethodList[index].name,
            code:this.PaymentMethodList[index].id
          })
        }
        return array;
      },
    },
    watch:{
      amountReceived()
      {
        this.reCalculate();
      },
      checked()
      {
        for (var index in this.clientInvoices)
        {
          this.clientInvoices[index].check =  this.checked;
        }
      }
    },
    created() {
      this.ClientsDate();
      this.getPaymentsMethods();
      var today = new Date();
      this.PaymentDate = today;

    }
  }
</script>
<style>

</style>