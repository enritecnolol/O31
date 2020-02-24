<template>
  <div
    class="modal fade"
    id="paymentMethodsModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="paymentMethodsModalLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="paymentMethodsModalLabel">Nuevo termino</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <payment-methods-form @refreshData="refreshData" />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import paymentMethodsForm from "./paymentMethodsForm";
export default {
  components: {
    paymentMethodsForm
  },
  data() {
    return {
      loading: false
    };
  },
  methods: {
    refreshData() {
      this.$emit("refreshData");
    }
  }
};
</script>

<style lang="scss" scoped>
</style>