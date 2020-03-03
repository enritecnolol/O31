<template>
  <div
    class="modal fade"
    id="supplierModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="supplierModalLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="supplierModalLabel">Formulario de proveedor</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <supplie-form @closeForm="refreshData" />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import supplierForm from "./supplierForm";
export default {
  components: { supplierForm },
  methods: {
    refreshData() {
      this.$emit("refreshData");
    }
  }
};
</script>

<style lang="scss" scoped>
</style>