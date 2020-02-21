<template>
  <div>
    <modal-terms @refreshTerms="getTermsList" />
    <form @submit.prevent="save">
      <div class="row">
        <div class="col-md-3">
          <div class="form-group">
            <label for="nombre" class="form-control-label">
              Nombre:
              <span style="color: red">*</span>
            </label>
            <input
              type="text"
              v-model="name"
              id="nombre"
              placeholder
              class="form-control form-control-sm"
            />
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label for="telefono" class="form-control-label">
              Telefono:
              <span style="color: red">*</span>
            </label>
            <input
              type="text"
              v-model="phone"
              id="telefono"
              placeholder
              class="form-control form-control-sm"
            />
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label for="matricula" class="form-control-label">
              Documento:
              <span style="color: red">*</span>
            </label>
            <input
              type="text"
              id="matricula"
              v-model="enrollment"
              placeholder
              class="form-control form-control-sm"
            />
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label for="email" class="form-control-label">
              Email:
              <span style="color: red">*</span>
            </label>
            <input
              type="text"
              id="email"
              placeholder
              v-model="email"
              class="form-control form-control-sm"
            />
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label for="rnc" class="form-control-label">RNC:</label>
            <input
              type="text"
              id="rnc"
              placeholder
              v-model="rnc"
              class="form-control form-control-sm"
            />
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label for="limitBalance" class="form-control-label">
              Limite de balance:
              <span style="color: red">*</span>
            </label>
            <money
              v-model="limitBalance"
              v-bind="money"
              class="form-control form-control-sm"
              style="text-align: right"
            />
          </div>
        </div>
        <div class="col-md-6">
          <textarea
            name="editor2"
            class="form-control"
            placeholder="Dirección"
            v-model="address"
            id="editor2"
            rows="5"
            cols="80"
          />
        </div>
        <div class="col-md-6">
          <textarea
            name="editor1"
            class="form-control"
            placeholder="Observación"
            v-model="observation"
            id="editor1"
            rows="5"
            cols="80"
          />
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="rnc" class="form-control-label">Terminos :</label>
            <select
              class="form-control"
              id="exampleFormControlSelect1"
              v-model="term"
              style="width: 250px;"
            >
              <option value>seleccionar</option>
              <option value="new" style="background: rgb(229, 229, 229);color: black">agregar nuevo</option>
              <template v-for="(item, index) in termsList">
                <option :key="index" :value="item.id">{{item.name}}</option>
              </template>
            </select>
          </div>
        </div>
        <div class="col-md-12">
          <hr />
        </div>
        <div class="col-md-12 text-center">
          <button
            type="submit"
            class="btn btn-sm"
            :class="id ? 'btn-warning' : 'btn-primary'"
          >{{id ? 'Editar' : 'Guardar'}}</button>
        </div>
      </div>
    </form>
  </div>
</template>
<script>
import Vue from "vue";
import money from "v-money";
Vue.use(money, { precision: 4 });
import modalTerms from "../terms/modalTerms";
export default {
  props: ["editData"],
  components: { modalTerms },
  data() {
    return {
      id: "",
      name: "",
      phone: "",
      enrollment: "",
      email: "",
      observation: "",
      address: "",
      rnc: "",
      limitBalance: 0,
      term: "",
      money: {
        decimal: ".",
        thousands: ",",
        prefix: "RD$ ",
        precision: 2,
        masked: false
      },
      termsList: []
    };
  },
  methods: {
    getTermsList() {
      axios
        .get("/terms/list")
        .then(response => {
          this.termsList = response.data;
          console.log(response);
        })
        .catch(err => console.log(response));
    },
    save() {
      if (
        this.name === "" ||
        this.phone === "" ||
        this.email === "" ||
        this.enrollment === "" ||
        this.limitBalance === 0
      ) {
        toastr.warning("Revisar los campos obligatorio");
        return;
      }

      let url = this.id ? "/clientes/edit" : "/clientes/store";

      axios
        .post(url, {
          id: this.id,
          nombre: this.name,
          telefono: this.phone,
          email: this.email,
          matricula: this.enrollment,
          observacion: this.observation,
          direccion: this.address,
          rnc: this.rnc,
          limitBalance: this.limitBalance,
          term: this.term
        })
        .then(response => {
          toastr.success("El cliente ha sido ingresado con exito");
          this.reset();
          this.$emit("hideForm");
        })
        .catch(error => {
          toastr.warning("Se ha prodcido un error");
          console.log(error);
        });
    },
    reset() {
      Object.assign(this.$data, {
        id: "",
        name: "",
        phone: "",
        enrollment: "",
        email: "",
        observation: "",
        address: "",
        rnc: "",
        limitBalance: 0
      });
    },
    fetchData(id) {
      axios
        .get("/client/data", {
          params: {
            client_id: id
          }
        })
        .then(response => {
          this.id = response.data.id;
          this.name = response.data.nombre;
          this.phone = response.data.telefono;
          this.email = response.data.email;
          this.enrollment = response.data.matricula;
          this.observation = response.data.observacion;
          this.address = response.data.direccion;
          this.rnc = response.data.rnc;
          this.limitBalance = response.data.limitBalance;
          this.term = response.data.term;
        })
        .catch(error => {
          console.log(error);
        });
    }
  },
  watch: {
    term() {
      if (this.term === "new") {
        $("#exampleModal").modal("show");
      }
    }
  },
  created() {
    if (this.editData) {
      this.fetchData(this.editData);
    }
    this.getTermsList();
  }
};
</script>
<style>
</style>