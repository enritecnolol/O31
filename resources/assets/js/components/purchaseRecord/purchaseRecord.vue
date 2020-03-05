<template>
  <card-panel style="margin-top:-50px;">
    <template slot="body">
      <div class="card-body">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <h4>Orden de compra</h4>
              <hr />
            </div>
            <div class="col-md-12">
              <div class="row">
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="documentNo">Documento no:</label>
                    <input
                      type="text"
                      class="form-control form-control-sm"
                      placeholder="#0000"
                      style="width:130px;"
                    />
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="supplier">Proveedor:</label>
                <v-select v-model="supplier" :options="suppliers" @input="setSelected" />
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <label for="invoice">Factura:</label>
                <input
                  id="invoice"
                  type="text"
                  class="form-control form-control-sm"
                  style="width:150px;"
                  placeholder="#0000"
                />
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="ncf">NCF:</label>
                <input
                  id="ncf"
                  type="text"
                  class="form-control form-control-sm"
                  style="width:250px;"
                  placeholder="#0000"
                />
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <label for="purchaseOrder">Orden de compra:</label>
                <input
                  id="purchaseOrder"
                  type="text"
                  class="form-control form-control-sm"
                  style="width:150px;"
                />
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="invoiceDate">Fecha fact:</label>
                <datepicker
                  style="width:300px;"
                  v-model="orderDate"
                  class="form-control form-control-sm"
                  :format="'yyyy-MM-dd'"
                  name="invoiceDate"
                />
              </div>
            </div>
            <div class="col-md-4">
              <select-term />
            </div>
            <div class="col-md-12">
              <general-table :hover="true" :responsive="false">
                <template slot="table-header">
                  <tr>
                    <th>Producto</th>
                    <th style="text-align: right;">Cantidad</th>
                    <th style="text-align: right;">Precio de compra</th>
                    <th style="text-align: right;">Precio venta sin impuesto</th>
                    <th style="text-align: right;">Precio total</th>
                  </tr>
                </template>
                <template slot="table-body">
                  <item-body
                    v-for="(item, index) in items"
                    :key="index"
                    :productsList="productsList"
                    :item="item"
                  />
                </template>
              </general-table>
            </div>
            <div class="col-md-12" style="margin-top: 30px">
              <estimate-total :subTotal="10000" />
            </div>
          </div>
        </div>
      </div>
    </template>
  </card-panel>
</template>

<script>
import cardPanel from "../cardPanel";
import generalTable from "../generalTable";
import Datepicker from "vuejs-datepicker";
import vSelect from "vue-select";
import itemBody from "./itemBody";
import EstimateTotal from "../estimate/Estimatetotal";
import "vue-select/dist/vue-select.css";
import selectTerm from "../terms/selectTerm";
Vue.component("v-select", vSelect);
export default {
  name: "purchase-record",
  components: {
    cardPanel,
    Datepicker,
    generalTable,
    itemBody,
    EstimateTotal,
    selectTerm
  },
  data() {
    return {
      supplierList: [],
      supplier: "",
      orderDate: "",
      paymentDate: "",
      note: "",
      productsList: [],
      supplierData: "",
      items: [
        {
          product: "",
          quantity: 0,
          unitPrice: 0,
          sales_price_without_tax: 0
        }
      ]
    };
  },
  methods: {
    fetchSupplier() {
      axios
        .get("/supplier/list/select")
        .then(response => {
          this.supplierList = response.data;
          console.log(response);
        })
        .catch(err => {
          console.log(err);
        });
    },
    setSelected(val) {
      console.log(val);
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
    }
  },
  computed: {
    suppliers() {
      let array = [];
      this.supplierList.forEach(element => {
        array.push({
          label: element.name,
          code: element.id
        });
      });
      return array;
    }
  },
  created() {
    var today = new Date();
    var paymentDate = new Date();
    paymentDate.setDate(today.getDate() + 5);
    this.orderDate = today;
    this.paymentDate = paymentDate;
    this.fetchSupplier();
    this.getProducts();
  }
};
</script>

<style>
</style>