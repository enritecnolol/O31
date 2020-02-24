<template>
  <form @submit.prevent="save">
    <div class="row">
      <div class="col-md-12">
        <div class="form-group">
          <label for="nombre" class="form-control-label">
            Nombre Metodo:
            <span style="color: red">*</span>
          </label>
          <input type="text" v-model="name" id="nombre" placeholder class="form-control" />
        </div>
        <div class="col-md-12">
          <div class="text-center">
            <button class="btn btn-sm btn-primary" :class="editData ? 'btn-warning': 'btn-primary'">
              <i :class="editData ? 'fas fa-edit': 'fas fa-save'" />
              {{ editData ? 'Editar': 'Guardar'}}
            </button>
          </div>
        </div>
      </div>
    </div>
  </form>
</template>
<script>
export default {
  props: ["editData"],
  data() {
    return {
      name: ""
    };
  },
  methods: {
    loadingStatus(val) {
      this.$emit("loadingStatus", val);
    },
    save() {
      if (!this.name) {
        toastr.warning("Revisar los campos obligatorio");
        return;
      }
      this.loadingStatus(true);
      let url = this.editData ? "/payment/methods/edit" : "/payment/methods";
      axios
        .post(url, {
          id: this.editData ? this.editData.id : "",
          name: this.name
        })
        .then(response => {
          toastr.success("Metodo de pago registrado con exito");
          this.reset();
          this.refreshPaymentMethods();
        })
        .catch(error => {
          toastr.warning(error.response.data.message);
          console.log(error.response);
        })
        .finally(() => {
          this.loadingStatus(false);
        });
    },
    reset() {
      this.name = "";
    },
    refreshPaymentMethods() {
      this.$emit("refreshData");
    }
  },
  watch: {
    editData() {
      this.name = this.editData.name;
    }
  }
};
</script>
<style>
</style>