<template>
  <div class="card">
    <div class="loader" v-if="loading"></div>
    <div class="card-body">
      <div class="row">
        <div class="col-md-12">
          <div class="pull-left" style>
            <i class="fa fa-angle-left" style="cursor: pointer;font-size: 30px" @click="regresar">
              <small></small>
            </i>
          </div>
        </div>
      </div>
      <div class="row">
        <filters_ncf @nfc_select="nfc_select" v-if="seleccionado === 'Comprobantes'" />
        <filters_date @date_select="date_select" :reset="reset" :selected="seleccionado" />
        <filters_categories
          @categories_select="categories_select"
          v-if="seleccionado === 'Productos'"
          :reset="reset"
        />
        <filters_products
          @products_select="products_select"
          v-if="seleccionado === 'Productos'"
          :reset="reset"
        />
      </div>
      <filter_report @typereport="typereport" v-if="type_ncf === 'all'" />
      <div class="row">
        <div class="col-md-12">
          <div class="text-center">
            <button type="button" class="btn btn-primary" @click="searchdata">
              <i class="fas fa-search"></i> Buscar
            </button>
            <button
              type="button"
              class="btn btn-warning"
              @click="resetFilter"
              v-if="seleccionado === 'Productos'"
            >
              <i class="far fa-circle"></i> Limpiar
            </button>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12" style="margin-top: 20px">
          <template v-if="nfcleng">
            <template v-for="(ncf, index) in ncfs">
              <div class="row" :key="index">
                <div class="col-md-12">
                  <multi_table
                    :data="table_data[index]"
                    :headers="header"
                    :seleccionado="seleccionado"
                    :ncfs="ncfs"
                    :index="index"
                  />
                </div>
              </div>
            </template>
          </template>
          <template v-else>
            <div class="row">
              <div class="col-md-12">
                <multi_table
                  :date="date"
                  :products="products"
                  :categories="category"
                  :data="table_data"
                  :headers="header"
                  :ncf="ncf"
                  :seleccionado="seleccionado"
                />
              </div>
            </div>
          </template>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import multi_table from "../multi_table";
import filters_ncf from "./filters_type_ncf";
import filters_date from "./filters_date";
import filters_categories from "./filters_categories";
import filters_products from "./filters_products";
import filter_report from "./filter_type_report";
import JsonExcel from "vue-json-excel";
import XLSX from "xlsx";
Vue.component("downloadExcel", JsonExcel);
export default {
  name: "panel",
  components: {
    filters_ncf,
    filters_date,
    multi_table,
    filter_report,
    JsonExcel,
    XLSX,
    filters_categories,
    filters_products
  },
  props: ["seleccionado"],
  data() {
    return {
      reset: false,
      type_ncf: "",
      date: "",
      loading: false,
      table_data: [],
      header: [],
      treport: "",
      ncfs: [],
      ncf: "",
      category: [],
      products: []
    };
  },
  methods: {
    resetFilter() {
      this.date = "";
      this.products = [];
      this.category = [];
      this.reset = true;
      setTimeout(() => {
        this.reset = false;
      }, 4000);
    },
    regresar() {
      this.$emit("regresar");
    },
    exportexc() {
      var dataWS = XLSX.utils.json_to_sheet(this.table_data);

      var wb = XLSX.utils.book_new();

      XLSX.utils.book_append_sheet(wb, dataWS, "Data");

      XLSX.writeFile(wb, "Comprobantes.xlsx");
    },
    typereport(i) {
      this.treport = i.type;
    },
    date_select(i) {
      this.date = i.date;
    },
    nfc_select(i) {
      this.type_ncf = i.ncf;
    },
    products_select(i) {
      this.products = i.products;
    },
    categories_select(i) {
      this.category = i.categories;
    },
    searchdata() {
      if (this.seleccionado == "Comprobantes") {
        if (!this.type_ncf || !this.date) {
          toastr.warning("Por favor seleccione los filtros");
          return;
        }
        if (this.type_ncf == "all") {
          if (this.treport == "") {
            toastr.warning("Por favor seleccione los filtros");
            return;
          }
        }
        this.loading = true;
        axios
          .post("/reportv2/comprobantes/fiscales", {
            type_report: this.treport,
            date: this.date,
            ncf: this.type_ncf
          })
          .then(response => {
            this.loading = false;
            this.table_data = response.data["data"];
            this.header = response.data["header"];
            this.ncfs = response.data["ncfs"];
            this.ncf = response.data["ncf"];
          })
          .catch(error => {
            this.loading = false;
            console.log(error);
          });
      } else {
        if (!this.date || this.date.length == 0) {
          toastr.warning("Seleccione un a fecha");
          return;
        }
        this.loading = true;
        axios
          .post("/reportv2/return/data", {
            date: this.date,
            seleccionado: this.seleccionado,
            categories: this.category,
            products: this.products
          })
          .then(response => {
            this.loading = false;
            this.table_data = response.data["data"];
            this.header = response.data["header"];
          })
          .catch(error => {
            this.loading = false;
            console.log(error);
          });
      }
    }
  },
  computed: {
    nfcleng() {
      var count = 0;
      for (var key in this.ncfs) {
        count++;
      }
      if (count > 0) {
        return true;
      } else {
        return false;
      }
    }
  }
};
</script>
<style>
.loader {
  position: fixed;
  left: 0px;
  top: 0px;
  width: 100%;
  height: 100%;
  z-index: 9999;
  background: url("../../../../../public/loading2.gif") 50% 50% no-repeat
    rgb(249, 249, 249);
  opacity: 0.8;
}
</style>