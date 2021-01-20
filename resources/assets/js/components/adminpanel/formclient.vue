<template>
  <div>
    <template v-if="!item">
      <div class="row">
        <div class="col-md-4">
          <div class="form-group">
            <label for>Nombre Cliente</label>
            <input type="text" maxlength="50" v-model="namec" class="form-control form-control-sm" />
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label for>Email</label>
            <input type="email" class="form-control form-control-sm" v-model="email" />
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label for>Password cliente</label>
            <input type="password" v-model="pass" class="form-control form-control-sm" />
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label for>Base de datos</label>
            <input type="text" maxlength="50" class="form-control form-control-sm" v-model="database" />
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label for>Monto cobrar</label>
            <input type="text" maxlength="50" class="form-control form-control-sm" v-model="fValue" />
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label for>Periodo de prueba</label>
            <input type="number" min="0" class="form-control form-control-sm" v-model="trial_period" />
          </div>
        </div>
      </div>
      <hr />
      <div class="row">
        <div class="col-md-12">
          <div class="text-center">
            <button type="button" class="btn btn-sm btn-primary" @click="save">
              <i class="fa fa-save"></i> Guardar
            </button>
          </div>
        </div>
      </div>
      <br />
    </template>
    <template v-else>
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label for>Nombre Cliente</label>
            <input type="text" v-model="item.name" class="form-control form-control-sm" />
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for>Email</label>
            <input type="email" class="form-control form-control-sm" v-model="item.email" />
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label for>Monto cobrar</label>
            <input type="text" maxlength="50" class="form-control form-control-sm" v-model="fValue" />
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label for>Periodo de prueba</label>
            <input type="number" min="0" class="form-control form-control-sm" v-model="item.trial_period" />
          </div>
        </div>
        <div class="col-md-4">
          <div class="custom-control custom-checkbox" style="margin-top: 45px;">
            <input type="checkbox" class="custom-control-input" id="customCheck1" v-model="item.status">
            <label class="custom-control-label" for="customCheck1">Estado de la cuenta</label>
          </div>
        </div>
      </div>
      <hr />
      <div class="row">
        <div class="col-md-12">
          <div class="text-center">
            <button type="button" class="btn btn-sm btn-warning" @click="edit">
              <i class="fa fa-edit"></i> Editar
            </button>
          </div>
        </div>
      </div>
      <br />
    </template>
  </div>
</template>
<script>
export default {
  name: "formclient",
  props: ["item"],
  data() {
    return {
      namec: "",
      email: "",
      database: "",
      pass: "123456789",
      host: "",
      port: "",
      username: "",
      password: "",
      amount:2500,
      trial_period:15
    };
  },
  methods: {
    save() {
      if (
          !this.namec ||
          !this.email ||
          !this.pass ||
          !this.database || !this.amount < 0 || !this.trial_period < 0
      ) {
        toastr.warning("Por Favor llenar todos los datos");
        return;
      }
      axios
          .post("/user/connection/store", {
            nameclient: this.namec,
            email: this.email,
            pass: this.pass,
            database: this.database,
            amount: this.amount,
            trial_period:this.trial_period
          })
          .then(response => {
            toastr.success("Los datos se han guardado");
            this.$emit("saved");
          })
          .catch(error => {
            toastr.warning(error.response.data.message);
            console.log(error);
          });
    },
    edit() {
      if (
          !this.item.datab
          || !this.amount < 0 || !this.trial_period < 0
      ) {
        toastr.warning("Por Favor llenar todos los datos");
        return;
      }
      this.item.amount = this.amount;
      axios
          .post("/user/connection/edit", {
            item: this.item
          })
          .then(response => {
            toastr.success("Los datos se han editado");
            this.$emit("saved");
          })
          .catch(error => {
            console.log(error);
          });
    }
  },
  computed: {
    fValue: {
      // getter
      get: function() {
        return "RD$ " + this.amount.toFixed(2).replace(/(\d)(?=(\d{3})+(?:\.\d+)?$)/g, "$1,")
      },
      // setter
      set: function(modifiedValue) {
        // Recalculate value after ignoring "$" and "," in user input
        let newValue = parseFloat(modifiedValue.replace(/[^\d\.]/g, ""))
        // Ensure that it is not NaN
        if (isNaN(newValue)) {
          newValue = 0
        }
        // Note: we cannot set this.value as it is a "prop". It needs to be passed to parent component
        // $emit the event so that parent component gets it
        this.amount = newValue;
      }
    }
  },
  mounted() {
    if(this.item)
    {
      this.amount = this.item.amount
    }
  }
};
</script>
<style>
</style>
