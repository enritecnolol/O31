<template>
  <div class="card-body">
    <div class="row">
      <div class="col-md-12">
        <div class="float-left">
          <h3>{{clientForm ? 'Crear cliente' : 'Cotización'}}</h3>
        </div>
        <div class="float-right">
          <button class="btn btn-sm btn-primary" @click="createFormStatus">Lista de cotizaciones</button>
        </div>
      </div>
      <div class="col-md-12">
        <hr />
      </div>
      <div class="col-md-6" v-show="!clientForm">
        <label>
          Cliente
          <span style="color:red">*</span>
        </label>
        <v-select v-model="selectedCustomer" :options="clientsListForSelect" @input="setSelected" />
        <div class="text-center createCustomer" style="color: #007bff">
          <span style="cursor: pointer" @click="clientForm = !clientForm">
            <i class="fas fa-user-plus" /> Crear cliente
          </span>
        </div>
      </div>
      <div class="col-md-6" v-show="!clientForm">
        <div class="form-group">
          <label for="TexInputEmail">
            Email:
            <span style="color:red">*</span>
          </label>
          <input
            type="text"
            class="form-control form-control-sm"
            v-model="email"
            id="TexInputEmail"
            style="width: 300px;"
          />
        </div>
      </div>
      <div class="col-md-12" v-show="!clientForm">
        <div class="row">
          <div class="col-md-4">
            <select-term @changeTerm="changeTerm" />
          </div>
          <div class="col-md-4">
            <label>
              Fecha estimada:
              <span style="color:red">*</span>
            </label>
            <datepicker
              v-model="estimateDate"
              class="form-control form-control-sm"
              :format="'yyyy-MM-dd'"
              name="estimateDate"
            />
          </div>
          <div class="col-md-4">
            <label>
              Fecha vencimiento:
              <span style="color:red">*</span>
            </label>
            <datepicker
              v-model="dueDate"
              class="form-control form-control-sm"
              :format="'yyyy-MM-dd'"
              name="dueDate"
            />
          </div>
        </div>
      </div>
      <div class="col-md-5" v-show="!clientForm">
        <div class="form-group">
          <label for="Textarea1">
            Dirección:
            <span style="color:red">*</span>
          </label>
          <textarea class="form-control" id="Textarea1" rows="3" v-model="address" />
        </div>
      </div>
      <div class="col-md-2" v-show="!clientForm">
        <div class="form-group">
          <label for="TexInput1">
            No. Cotización
            <span style="color:red">*</span>
          </label>
          <input
            type="text"
            class="form-control form-control-sm"
            placeholder="#0000"
            v-model="codeEstimate"
            id="TexInput1"
          />
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12" style="margin-bottom: 20px" v-if="clientForm">
        <div class="float-right">
          <button class="btn-sm btn-warning" @click="hideClientForm">
            <i class="fas fa-angle-left" /> Volver
          </button>
        </div>
      </div>
      <div class="col-md-12">
        <client-form v-if="clientForm" @hideForm="clientForm = false" />
      </div>
    </div>

    <div class="row" style="margin-top: 20px" v-show="!clientForm">
      <div class="col-md-12">
        <table-estimate>
          <template slot="table-header">
            <th>Producto/Servicio</th>
            <th>Descripción</th>
            <th>
              <p style="float: right">Cantidad</p>
            </th>
            <th>
              <p style="float: right">Precio</p>
            </th>
            <th>
              <p style="float: right">Descuento</p>
            </th>
            <th>
              <p style="float: right">Importe</p>
            </th>
            <th />
          </template>
          <template slot="table-body">
            <template v-for="(item, index) in items">
              <itemBody
                :key="index"
                :index="index"
                :item="item"
                :products-list="productsList"
                @removeItem="removeElement"
                @replaceElement="replaceElement"
              />
            </template>
          </template>
        </table-estimate>
      </div>
      <div class="col-md-12" style="margin-top: 20px">
        <div class>
          <button class="btn btn-primary btn-sm" @click="addrow" style="width: 150px">
            <i class="fas fa-cart-arrow-down" /> Agregar fila
          </button>
        </div>
        <hr />
      </div>
      <div class="col-md-12" style="margin-top: 15px">
        <estimate-total :subTotal="subTotal" />
        <div class="float-left">
          <div class="form-group">
            <label for="NoteTextArea">Nota:</label>
            <textarea class="form-control" id="NoteTextArea" rows="3" v-model="note" />
          </div>
        </div>
      </div>
    </div>

    <div class="row" style="margin-top: 20px">
      <div class="col-md-12">
        <button class="btn btn-warning btn-sm" @click="save(false)">
          <i class="far fa-file-alt" />
          {{dataEdit ? 'Editar' : 'Guardar'}}
        </button>
        <button class="btn btn-success btn-sm" @click="save(true)">
          <i class="far fa-file-alt" />
          <i class="fas fa-paper-plane" />
          {{dataEdit ? 'Editar' : 'Guardar'}} y enviar
        </button>
      </div>
    </div>
  </div>
</template>
<script>
import Vue from "vue";
import vSelect from "vue-select";
import "vue-select/dist/vue-select.css";
import money from "v-money";
Vue.use(money, { precision: 4 });
Vue.component("v-select", vSelect);
import Datepicker from "vuejs-datepicker";
import tableEstimate from "./table-estimate";
import itemBody from "./ItemBody";
import clientForm from "./clientForm";
import EstimateTotal from "./Estimatetotal";
import selectTerm from "../terms/selectTerm";

export default {
  name: "create-estimate",
  components: {
    Datepicker,
    tableEstimate,
    itemBody,
    clientForm,
    EstimateTotal,
    selectTerm
  },
  props: ["dataEdit"],
  data() {
    return {
      clientForm: false,
      estimateDate: "",
      dueDate: "",
      selectedCustomer: "",
      clientsData: [],
      productsList: [],
      items: [
        {
          product: "",
          description: "",
          quantity: "1",
          price: 0,
          discount: 0,
          amount: 0
        }
      ],
      note: "",
      address: "",
      codeEstimate: "",
      email: ""
    };
  },
  methods: {
    changeTerm(val) {
      if (val === "") {
        return;
      }
      var today = new Date();
      var dueDate = new Date();
      dueDate.setDate(today.getDate() + val);
      console.log(dueDate);
      this.dueDate = dueDate;
    },
    itemsEditFormat(items) {
      let array = [];
      for (var index in items) {
        array.push({
          id: items[index].id,
          product: {
            label: items[index].product,
            code: items[index].product_id
          },
          description: items[index].description,
          quantity: items[index].quantity,
          price: items[index].price,
          discount: items[index].discount,
          amount: items[index].amount,
          product_id: items[index].product_id
        });
      }
      return array;
    },
    createFormStatus() {
      this.$emit("createFormStatus", false);
    },
    setSelected(val) {
      let found = this.clientsData.find(e => e.id === val.code);
      if (found) {
        this.address = found.direccion;
        this.email = found.email;
      }
    },
    hideClientForm() {
      this.clientForm = false;
      this.ClientsDate();
    },
    labelView(label) {
      return label.label ? label.label : label;
    },
    loading(val) {
      this.$emit("loading", val);
    },
    save(send) {
      if (
        this.selectedCustomer === "" ||
        this.codeEstimate === "" ||
        this.email === "" ||
        this.address === "" ||
        this.selectedCustomer === ""
      ) {
        toastr.warning("por favor llenar los datos necesarios");
        return;
      }
      if (this.reduceItems.length === 0) {
        toastr.warning("La factura no posee articulos vinculados");
        return;
      }
      this.loading(true);
      let url = this.dataEdit ? "/estimate/edit" : "/estimate";
      axios
        .post(url, {
          id: this.dataEdit ? this.dataEdit.id : this.dataEdit,
          estimateNumber: this.codeEstimate,
          estimateDate: this.estimateDate,
          dueDate: this.dueDate,
          client_id: this.selectedCustomer,
          address: this.address,
          email: this.email,
          note: this.note,
          subtotal: this.subTotal,
          total: this.subTotal,
          details: this.reduceItems,
          send: send
        })
        .then(response => {
          toastr.success("Datos guardado correctamente");
          this.reset();
        })
        .catch(error => {
          toastr.warning(error.response.data.message);
          console.log(error.response.data.message);
        })
        .finally(() => {
          this.loading(false);
        });
    },
    reset() {
      var today = new Date();
      var dueDate = new Date();
      dueDate.setDate(today.getDate() + 15);

      Object.assign(this.$data, {
        clientForm: false,
        estimateDate: today,
        dueDate: dueDate,
        selectedCustomer: "",
        items: [
          {
            product: "",
            description: "",
            quantity: "1",
            price: 0,
            discount: 0,
            amount: 0
          }
        ],
        note: "",
        address: "",
        codeEstimate: "",
        email: ""
      });
    },
    ClientsDate() {
      axios
        .post("/clientes/datos/tabla2")
        .then(response => {
          this.clientsData = response["data"];
          if (this.dataEdit) this.completeForm();
          this.clientToEstimate();
        })
        .catch(error => {
          console.log(error);
        });
    },
    completeForm() {
      this.estimateDate = this.dataEdit.estimatedate;
      this.dueDate = this.dataEdit.duedate;
      this.selectedCustomer = this.clientsListForSelect.find(
        e => e.code === this.dataEdit.client_id
      );
      this.address = this.dataEdit.address;
      this.codeEstimate = this.dataEdit.estimatenumber;
      this.email = this.dataEdit.email;
      this.items = this.itemsEditFormat(this.dataEdit.estimate_details);
    },
    getProducts() {
      axios
        .get("/products/select")
        .then(response => {
          this.productsList = response["data"];
        })
        .catch(error => {
          console.log(error);
        });
    },
    addrow() {
      this.items.push({
        product: "",
        description: "",
        quantity: 1,
        price: 0.0,
        discount: 0,
        amount: 0.0
      });
    },
    removeElement(index) {
      this.items.splice(index, 1);
    },
    replaceElement({ index, item }) {
      this.items.splice(index, 1, item);
    },
    clientToEstimate() {
      if (this.getUrlVars(window.location.href)["client"]) {
        this.selectedCustomer = this.clientsListForSelect.find(
          e =>
            e.code === parseInt(this.getUrlVars(window.location.href)["client"])
        );
        this.setSelected(this.selectedCustomer);
      }
    },
    getUrlVars() {
      var vars = [],
        hash;
      var hashes = window.location.href
        .slice(window.location.href.indexOf("?") + 1)
        .split("&");
      for (var i = 0; i < hashes.length; i++) {
        hash = hashes[i].split("=");
        vars.push(hash[0]);
        vars[hash[0]] = hash[1];
      }
      return vars;
    }
  },
  computed: {
    reduceItems() {
      let array = [];
      for (var index in this.items) {
        if (
          this.items[index].product !== "" ||
          this.items[index].description !== ""
        ) {
          array.push(this.items[index]);
        }
      }
      return array;
    },
    clientsListForSelect() {
      let array = [];
      for (var index in this.clientsData) {
        array.push({
          label: this.clientsData[index].nombre,
          code: this.clientsData[index].id
        });
      }
      return array;
    },
    productsListForSelect() {
      let array = [];
      for (var index in this.productsList) {
        array.push({
          label: this.productsList[index].name,
          code: this.productsList[index].id
        });
      }
      return array;
    },
    subTotal() {
      let total = 0;
      for (var index in this.items) {
        total = total + parseFloat(this.items[index].amount);
      }
      return total;
    }
  },
  created() {
    this.getProducts();
    this.ClientsDate();
    var today = new Date();
    var dueDate = new Date();
    dueDate.setDate(today.getDate() + 5);
    this.estimateDate = today;
    this.dueDate = dueDate;
  }
};
</script>
<style>
.createCustomer:hover {
  color: #0e3bbb !important;
}
input[type="number"] {
  text-align: right;
}
</style>