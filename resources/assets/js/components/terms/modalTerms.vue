<template>
  <div
    class="modal fade"
    id="exampleModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Nuevo termino</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="name">
              Nombre:
              <span style="color: red">*</span>
            </label>
            <input
              type="text"
              :disabled="loading"
              class="form-control form-control-sm"
              id="name"
              v-model="name"
            />
          </div>
          <div class="form-group">
            <label for="number_days">
              vencimiento de un numero de dia:
              <span style="color: red">*</span>
            </label>
            <input
              type="text"
              :disabled="loading"
              class="form-control form-control-sm"
              id="number_days"
              v-model="number_days"
            />
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
export default {
  data() {
    return {
      name: "",
      number_days: 0,
      loading: false
    };
  },
  methods: {
    save() {
      console.log(this.number_days);
      if (this.name === "" || this.number_days === "") {
        toastr.warning("Favor de llenar los campos importantes !!");
        return;
      }
      this.loading = true;
      axios
        .post("/term", {
          name: this.name,
          number_days: this.number_days
        })
        .then(response => {
          toastr.success("Los datos han sido guardado !!");
          this.name = "";
          this.number_days = 0;
          this.$emit("refreshTerms");
        })
        .catch(err => {
          console.log(err);
        })
        .finally(() => (this.loading = false));
    }
  }
};
</script>
<style>
</style>