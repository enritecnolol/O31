<template>
  <div class="row">
    <div class="col-md-12">
      <div class="float-left">
        <h3>Formulario de compra</h3>
      </div>
      <div class="float-right">
        <button class="btn btn btn-danger" @click="formStatus">
          <i class="fa fa-angle-left" /> Volver
        </button>
      </div>
    </div>
    <div class="col-md-12">
      <hr />
    </div>
    <div class="col-md-7">
      <div class="row">
        <div class="col-md-12">
          <div class="form-group row">
            <label for="documentNo" class="col-sm-3 col-form-label">
              Documento no:
              <span style="color:red;">*</span>
            </label>
            <div class="col-sm" style="padding: 0">
              <input
                      v-model="documentNo"
                      type="text"
                      class="form-control form-control-sm"
                      placeholder="#0000"
                      style="width:130px;"
                      maxlength="17"
              />
            </div>
          </div>
        </div>
        <div class="col-md-12">
          <div class="form-group row">
            <label for="supplier" class="col-sm-3 col-form-label">
              Proveedor:
              <span style="color:red;">*</span>
            </label>
            <div class="col-sm" style="padding: 0">
              <v-select v-model="supplier" :options="suppliers" @input="setSelected" />
            </div>
          </div>
        </div>
        <div class="col-md-12">
          <div class="form-group row">
            <label for="invoice" class="col-sm-3 col-form-label">Factura:</label>
            <div class="col-sm" style="padding: 0">
              <input
                      v-model="invoice"
                      id="invoice"
                      type="text"
                      class="form-control form-control-sm"
                      style="width:150px;"
                      placeholder="#0000"
                      maxlength="17"
              />
            </div>
          </div>
        </div>
        <div class="col-md-12">
          <div class="form-group row">
            <label for="ncf" class="col-sm-3 col-form-label">NCF:</label>
            <div class="col-sm" style="padding: 0">
              <input
                      v-model="ncf"
                      id="ncf"
                      type="text"
                      class="form-control form-control-sm"
                      style="width:250px;"
                      placeholder="#0000"
                      maxlength="17"
              />
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-5">
      <div class="row">
        <div class="col-md-12">
          <div class="form-group row">
            <label for="kind" class="col-sm-4 col-form-label">
              Tipo:
              <span style="color:red;">*</span>
            </label>
            <div class="col-sm">
              <select class="form-control form-control-sm" id="kind" v-model="kindPurchase">
                <option :value="''">Seleccionar</option>
                <option value="cash">De contado</option>
                <option value="credit">Credito</option>
              </select>
            </div>
          </div>
        </div>
        <div class="col-md-12">
          <div class="form-group row">
            <label for="invoiceDate" class="col-sm-4 col-form-label">
              Fecha:
              <span style="color:red;">*</span>
            </label>
            <div class="col-sm" >
              <datepicker
                      :bootstrap-styling="true"
                      style="width:300px;"
                      v-model="invoiceDate"
                      :format="'yyyy-MM-dd'"
                      name="invoiceDate"
              />
            </div>
          </div>
        </div>
        <div class="col-md-12">
          <select-term @changeTerm="changeTerm" :termExternal="term" :landscape="true" />
        </div>
      </div>
    </div>
    <div class="col-md-12">
      <general-table :hover="true" :responsive="false">
        <template slot="table-header">
          <tr>
            <th>Producto</th>
            <th style="text-align: right;">Cantidad</th>
            <th style="text-align: right;">Precio</th>
            <th style="text-align: right;">Itbis</th>
            <th style="text-align: right;">Total</th>
            <th />
          </tr>
        </template>
        <template slot="table-body">
          <item-body
            v-for="(item, index) in items"
            :key="index"
            :index="index"
            :productsList="productsList"
            :item="item"
            @removeRow="removeRow"
            @replaceElement="replaceElement"
          />
        </template>
      </general-table>
    </div>
    <div class="col-md-12" style="margin-top:20px;">
      <button type="button" class="btn btn-primary" @click="addNewRow">
        <i class="fas fa-plus" /> Agregar producto
      </button>
    </div>
    <div class="col-md-12" style="margin-top: 30px">
      <div class="float-left">
        <div class="form-group">
          <label for="note">Nota:</label>
          <textarea class="form-control" id="note" rows="5" v-model="note" style="width:500px;"></textarea>
        </div>
      </div>
      <total-purchase :subTotal="subTotal" :itbis="itbis" :total="total" />
    </div>
    <div class="col-md-12">
      <div class="float-right">
        <button class="btn btn-sm btn-warning" @click="reset">
          <i class="fas fa-broom" /> Limpiar
        </button>
        <button class="btn btn-sm" :class="editData ? 'btn-warning' : 'btn-primary'" @click="save">
          <i class="fas" :class="editData ? 'fa-edit' : 'fa-save'" /> {{editData ? 'Editar' : 'Guardar'}}
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import Datepicker from "vuejs-datepicker";
import vSelect from "vue-select";
import itemBody from "./itemBody";
import totalPurchase from "./totalPurchase";
import "vue-select/dist/vue-select.css";
import selectTerm from "../terms/selectTerm";
import generalTable from "../generalTable";
Vue.component("v-select", vSelect);
export default {
  props:['editData'],
  components: {
    Datepicker,
    itemBody,
    totalPurchase,
    selectTerm,
    generalTable
  },
  data() {
    return {
      loading:false,
      documentNo: "",
      supplierList: [],
      supplier: "",
      invoice: "",
      ncf: "",
      purchaseOrder: "",
      invoiceDate: "",
      term: "",
      productsList: [],
      supplierData: "",
      note: "",
      items: [
        {
          product: "",
          quantity: 0,
          price: 0,
          itbis: 0,
          total: 0
        }
      ],
      kindPurchase: ""
    };
  },
  methods: {
    detailsFormat(items)
    {
      let array = [];
      for (var index in items)
      {
        let product = this.productsList.find(e => parseInt(e.id) === parseInt(items[index].product_id));
        array.push({
          id:items.id,
          product: {
            code:product.id,
            label:product.name
          },
          quantity: items[index].quantity,
          price: items[index].price,
          itbis: items[index].itbis,
          total: items[index].total
        })
      }
      return array;
    },
    completeForm()
    {
      this.documentNo = this.editData.document_no;
      this.supplier = this.suppliers.find(e => e.code == this.editData.supplier_id);
      this.invoice = this.editData.invoice;
      this.ncf = this.editData.ncf;
      this.invoiceDate = this.editData.invoice_date;
      this.term = this.editData.term_id;
      this.kindPurchase = this.editData.kind_purchase;
      this.items = this.detailsFormat(this.editData.details);
    },
    loadingStatus(val) {
      this.$emit("loadingStatus", val);
    },
    formStatus() {
      this.$emit("formStatus", false);
    },
    reset() {
      this.documentNo = "";
      this.supplier = "";
      this.invoice = "";
      this.ncf = "";
      this.term = "";
      this.note = "";
      this.invoiceDate = "";
      this.items = [
        {
          product: "",
          quantity: 0,
          price: 0,
          itbis: 0,
          total: 0
        }
      ];
      this.$emit('cleanEditData');
    },
    save() {
      if (
        this.documentNo === "" ||
        this.supplier === "" ||
        this.invoiceDate === ""
      ) {
        toastr.warning("Por favor revisar los datos importante");
        return;
      }

      if (this.validateItems()) {
        toastr.warning("Por favor revisar los productos");
        return;
      }
      this.loadingStatus(true);
      let url = this.editData ? '/purchase/edit' : '/purchase';
      axios
        .post(url, {
          id:this.editData ? this.editData.id : '',
          document_no: this.documentNo,
          supplier_id: this.supplier,
          invoice: this.invoice,
          ncf: this.ncf,
          term_id: this.term,
          note: this.note,
          invoice_date: this.invoiceDate,
          subtotal: this.subTotal,
          itbis: this.itbis,
          total: this.total,
          items: this.items,
          kind_purchase:this.kindPurchase
        })
        .then(res => {
          toastr.success(res.data.message);
          this.reset();
        })
        .catch(err => {
          toastr.error("Error en el sistema");
          console.log(err);
        })
      .finally(()=> {
        this.loadingStatus(false);
      })
      ;
    },
    validateItems() {
      for (const key in this.items) {
        if (this.items[key].total === 0) {
          return true;
        }
      }
      return false;
    },
    replaceElement({ index, item }) {
      this.items.splice(index, 1, item);
    },
    changeTerm({ id, number_days }) {
      if (number_days === "") {
        return;
      }
      this.term = id;
    },
    removeRow(index) {
      this.items.splice(index, 1);
    },
    addNewRow() {
      this.items.push({
        product: "",
        quantity: 0,
        price: 0,
        itbis: 0,
        total: 0
      });
    },
    fetchSupplier() {
      axios
        .get("/supplier/list/select")
        .then(response => {
          this.getProducts();
          this.supplierList = response.data;
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
        .get("/products/select/purchase")
        .then(response => {
          this.productsList = response["data"];
          if(this.editData)
          {
            this.completeForm();
          }
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
    },
    subTotal() {
      let subtotal = 0;
      for (const key in this.items) {
        subtotal +=
          parseInt(this.items[key]["quantity"]) * this.items[key]["price"];
      }
      return subtotal;
    },
    itbis() {
      let itbis = 0;
      for (const key in this.items) {
        itbis +=
          parseInt(this.items[key]["quantity"]) * this.items[key]["itbis"];
      }
      return itbis;
    },
    total() {
      let itbis = 0;
      for (const key in this.items) {
        itbis +=
          parseInt(this.items[key]["quantity"]) *
          (this.items[key]["price"] + this.items[key]["itbis"]);
      }
      return itbis;
    }
  },
  created() {
    var today = new Date();
    this.invoiceDate = today;
    this.fetchSupplier();
  }
};
</script>

<style lang="scss" scoped>
</style>
