<template>
  <div>
    <payments-methods-modal @refreshData="getPaymentsMethods" />
    <div class="form-group">
      <label>
        Metodos de pago:
        <span style="color:red">*</span>
      </label>
      <v-select v-model="paymentMethods" :options="PaymentMethodsListForSelect" />
    </div>
  </div>
</template>

<script>
import paymentsMethodsModal from "./paymentsMethodsModal";
export default {
  components: { paymentsMethodsModal },
  data() {
    return {
      paymentMethods: "",
      PaymentMethodList: []
    };
  },
  methods: {
    getPaymentsMethods() {
      axios
        .get("/payment/methods/without/paginate")
        .then(response => {
          this.PaymentMethodList = response["data"];
        })
        .catch(error => {
          console.log(error);
        });
    }
  },
  computed: {
    PaymentMethodsListForSelect() {
      let array = [];

      array.push({
        label: "Agregar nuevo",
        code: "New"
      });
      for (var index in this.PaymentMethodList) {
        array.push({
          label: this.PaymentMethodList[index].name,
          code: this.PaymentMethodList[index].id
        });
      }
      return array;
    }
  },
  watch: {
    paymentMethods() {
      if (this.paymentMethods.code == "New") {
        $("#paymentMethodsModal").modal("show");
        return;
      }
      this.$emit("PaymentMethodsData", this.paymentMethods);
    }
  },
  created() {
    this.getPaymentsMethods();
  }
};
</script>

<style >
</style>