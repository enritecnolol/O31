<template>
  <div>
    <supplier-modal @refreshData="fetchData" />
    <div class="form-group">
      <label>
        Proveedor:
        <span style="color:red">*</span>
      </label>
      <v-select v-model="supplier" :options="suppliersList" />
    </div>
  </div>
</template>

<script>
import supplierModal from "./supplierModal";
import vSelect from "vue-select";
import "vue-select/dist/vue-select.css";
Vue.component("v-select", vSelect);
export default {
  components: { supplierModal },
  data() {
    return {
      supplier: "",
      loading: false,
      suppliers: []
    };
  },
  methods: {
    fetchData() {
      this.loading = true;
      axios
        .get("/supplier/list")
        .then(response => {
          this.suppliers = response.data;
        })
        .catch(err => {
          console.log(err);
        })
        .finally(() => {
          this.loading = false;
        });
    }
  },
  computed: {
    suppliersList() {
      let array = [];

      array.push({
        label: "Agregar nuevo",
        code: "New"
      });

      for (const index in this.suppliers) {
        array.push({
          labe: this.suppliers[index].name,
          code: this.suppliers[index].id
        });
      }
      return array;
    }
  },
  watch: {
    supplier() {
      if (this.supplier.code == "New") {
        $("#supplierModal").modal("show");
        return;
      }
      this.$emit("supplierData", this.supplier);
    }
  },
  created() {}
};
</script>