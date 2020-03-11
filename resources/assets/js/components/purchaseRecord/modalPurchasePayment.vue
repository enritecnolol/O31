<template>
  <div
      class="modal fade"
      id="modalPurchasePayment"
      tabindex="-1"
      role="dialog"
      aria-labelledby="modalPurchasePaymentLabel"
      aria-hidden="true"
  >
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalPurchasePaymentLabel">Pago de compra</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="datePayment">
              Fecha:
            </label>
            <datepicker
                :disabled="true"
                id="datePayment"
                style="width:300px;"
                v-model="date"
                class="form-control form-control-sm"
                :format="'yyyy-MM-dd'"
                name="datePayment"
            />
          </div>
          <div class="form-group">
            <label>Pago:</label>
            <money
                v-model="payment"
                v-bind="money"
                class="form-control form-control-sm"
                style="text-align: right;width: 150px"
            />
          </div>
          <div class="form-group">
            <label for="methods">Metodo:</label>
            <select class="form-control form-control-sm" id="methods" style="width: 300px" v-model="payment_method">
              <option :value="''">Seleccionar</option>
              <option :value="'Efectivo'">Efectivo</option>
              <option :value="'Tarjeta de credito'">Tarjeta de credito</option>
              <option :value="'Tarjeta de debito'">Tarjeta de debito</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          <button
              type="button"
              class="btn btn-primary"
              :disabled="loading"
              @click="save"
          >{{ loading ? 'Cargando ... ' : 'Guardar'}}</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import Datepicker from "vuejs-datepicker";
  import money from "v-money";
  Vue.use(money, { precision: 4 });
  export default {
    components:{ Datepicker },
    props:['data'],
    data()
    {
      return{
        date:'',
        loading:false,
        payment:0,
        payment_method:'',
        purchase_id:'',
        money: {
          decimal: ".",
          thousands: ",",
          prefix: "RD$ ",
          precision: 2,
          masked: false
        }
      }
    },
    methods:{
      save()
      {
        if(this.payment <= 0 || this.payment_method === "" || this.payment > this.data.balance)
        {
          toastr.warning("Por favor validar los datos de pagos", "Validador");
          return;
        }

        axios.post('/purchase/payment', {
          date_payment:this.date,
          amount:this.payment,
          payment_method:this.payment_method,
          purchase_id:this.data.id
        })
            .then((response) => {
              toastr.success("El pago ha sido registrado", "Validador");
              this.$emit('fetchData');
              this.payment = 0;
              this.payment_method = '';
              $('#modalPurchasePayment').modal('hide');
            })
            .catch((err) => {
              toastr.error(err.response.data.message, "Validador");
              console.log(err)
            })
      }
    },
    watch:{
      payment()
      {
        if(this.payment > this.data.balance)
        {
          this.payment = this.data.balance;
          return;
        }
      }
    },
    created() {
      this.date = new Date();
    }
  }
</script>

<style>

</style>