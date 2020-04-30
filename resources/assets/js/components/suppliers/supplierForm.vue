<template>
  <form @submit.prevent="save">
    <div class="row">
      <div class="col-md-6">
        <div class="form-group row">
          <label for="name" class="col-sm-3 col-form-label">
            Nombre:
            <span style="color: red">*</span>
          </label>
          <div class="col-sm">
            <input
                    :disabled="loading"
                    type="text"
                    v-model="form.name"
                    id="name"
                    placeholder
                    class="form-control form-control-sm"
            />
          </div>
        </div>
      </div>
      <div class="col-md-6" />
      <div class="col-md-6">
        <div class="form-group row">
          <label for="rnc" class="col-sm-3 col-form-label">RNC:</label>
          <div class="col-sm">
            <input
                    :disabled="loading"
                    type="text"
                    v-model="form.rnc"
                    id="rnc"
                    placeholder
                    maxlength="15"
                    style="width: 250px"
                    class="form-control form-control-sm"
            />
          </div>
        </div>
      </div>
      <div class="col-md-6" />
      <div class="col-md-6">
        <div class="form-group row">
          <label for="contact" class="form-control-label col-sm-3">Contacto:</label>
          <div class="col-sm">
            <input
                    :disabled="loading"
                    type="text"
                    v-model="form.contact"
                    id="contact"
                    placeholder
                    class="form-control form-control-sm"
            />
          </div>
        </div>
      </div>
      <div class="col-md-6"></div>
      <div class="col-md-6">
        <div class="form-group row">
          <label for="phone" class="form-control-label col-sm-3">Telefono:</label>
          <div class="col-sm">
            <input
                    :disabled="loading"
                    type="text"
                    v-model="form.phone"
                    id="phone"
                    placeholder
                    class="form-control form-control-sm"
                    style="width: 250px"
            />
          </div>
        </div>
      </div>
      <div class="col-md-6"></div>
      <div class="col-md-6">
        <div class="form-group row">
          <label for="email" class="form-control-label col-sm-3">Correo electronico:</label>
          <div class="col-sm">
            <input
                    :disabled="loading"
                    type="email"
                    v-model="form.email"
                    id="email"
                    placeholder
                    class="form-control form-control-sm"
            />
          </div>
        </div>
      </div>
      <div class="col-md-6" />
      <div class="col-md-6">
        <div class="form-group">
          <label for="observation" class="form-control-label">Observacion:</label>
          <textarea
            :disabled="loading"
            v-model="form.observation"
            id="observation"
            placeholder
            rows="3"
            class="form-control"
          />
        </div>
      </div>
      <div class="col-md-12">
        <hr />
      </div>
      <div class="col-md-12 text-center">
        <button
          class="btn btn-sm"
          :class="editData ? 'btn-warning' : 'btn-primary'"
          :disabled="loading"
          type="submit"
        >
          <i class="fas" :class="loading ? 'fa-spinner' : editData ? 'fa-edit' : 'fa-save'"></i>
          {{loading ? 'Cargando ...' : editData ? 'Editar' : 'Guardar'}}
        </button>
      </div>
    </div>
  </form>
</template>

<script>
export default {
  props: ["editData"],
  data() {
    return {
      form: {
        name: "",
        rnc: "",
        contact: "",
        email: "",
        phone: "",
        observation: ""
      },
      loading: false
    };
  },
  methods: {
    save() {
      if (this.form.name === "") {
        toastr.warning("Por favor llenar los campos importantes!", "Validador");
        return;
      }
      this.loading = true;
      let url = this.editData ? "/supplier/edit" : "/supplier";
      axios
        .post(url, {
          ...this.form
        })
        .then(response => {
          toastr.success(response.data.message, "validador");
          this.reset();
          this.$emit("closeForm", false);
          console.log(response.data);
        })
        .catch(err => {
          console.log(err);
        })
        .finally(() => {
          this.loading = false;
        });
    },
    reset() {
      Object.assign(this.$data, {
        form: {
          name: "",
          rnc: "",
          contact: "",
          email: "",
          phone: "",
          observation: ""
        }
      });
    },
    completeForm() {
      this.form = {
        id: this.editData.id,
        name: this.editData.name,
        rnc: this.editData.rnc,
        contact: this.editData.contact,
        email: this.editData.email,
        phone: this.editData.phone,
        observation: this.editData.observation
      };
    }
  },
  created() {
    if (this.editData) {
      this.completeForm();
    }
  }
};
</script>

<style>
</style>
