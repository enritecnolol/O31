<template>
  <div>
    <card-panel>
      <template slot="body">
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
              <div style="float:left">
                <h3>{{supplierForm ? 'Formulario provedores' : 'Lista de provedores'}}</h3>
              </div>
              <div style="float:right">
                <button
                  class="btn btn-sm"
                  @click="supplierFormStatus(!supplierForm)"
                  :class="supplierForm ? 'btn-danger' : 'btn-primary'"
                >
                  <i class="fas" :class="supplierForm ? 'fa-angle-down' : 'fa-plus'"></i>
                  {{supplierForm ? 'Ocultar' : 'Crear provedor'}}
                </button>
              </div>
            </div>
            <div class="col-md-12">
              <hr />
            </div>
          </div>
          <div class="col-md-12" v-if="supplierForm">
            <supplier-form @closeForm="supplierFormStatus(false)" :editData="editData" />
          </div>
          <div class="col-md-12" v-else>
            <general-table :paginate="supplier" :hover="true">
              <template slot="table-header">
                <tr>
                  <th>Nombre</th>
                  <th>Contacto</th>
                  <th>Telefono</th>
                  <th>Balance</th>
                  <th />
                </tr>
              </template>
              <template slot="table-body">
                <tr v-if="loading">
                  <td colspan="5">
                    <div class="text-center">
                      <h4>Cargando ...</h4>
                    </div>
                  </td>
                </tr>
                <tr v-if="!loading && supplierlength === 0">
                  <td colspan="5">
                    <div class="text-center">
                      <h4>no hemos encontrado datos</h4>
                    </div>
                  </td>
                </tr>
                <tr v-for="(item, index) in supplier.data" :key="index">
                  <td @click="supplierDetails(item)" style="cursor: pointer">{{item.name}}</td>
                  <td>{{item.contact}}</td>
                  <td>{{item.phone}}</td>
                  <td>RD${{parseFloat(item.balance).formatMoney(2)}}</td>
                  <td>
                    <div class="btn-group">
                      <button type="button" class="btn btn-sm btn-link" @click="DataToEdit(item)">Editar</button>
                      <button type="button" class="btn btn-sm btn-light dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="sr-only">Toggle Dropdown</span>
                      </button>
                      <div class="dropdown-menu">
                        <a class="dropdown-item" href="#" onclick="return false;">Crear compra</a>
                      </div>
                    </div>
                  </td>
                </tr>
              </template>
            </general-table>
          </div>
        </div>
      </template>
    </card-panel>
  </div>
</template>
<script>
import cardPanel from "../cardPanel";
import generalTable from "../generalTable";
import supplierForm from "./supplierForm";

export default {
  components: { cardPanel, generalTable, supplierForm },
  data() {
    return {
      supplierForm: false,
      loading: false,
      supplier: {},
      editData: null
    };
  },
  methods: {
    supplierDetails(item)
    {
      window.location.href = '/supplier/details?supplier='+item.id;
    },
    supplierFormStatus(val) {
      this.supplierForm = val;
      if (!val) {
        this.editData = null;
        this.fetchData();
      }
    },
    fetchData() {
      this.loading = true;
      axios
        .get("/supplier/list")
        .then(response => {
          this.supplier = response.data;
        })
        .catch(err => {
          console.log(err);
        })
        .finally(() => {
          this.loading = false;
        });
    },
    DataToEdit(item) {
      this.editData = item;
      this.supplierFormStatus(true);
    }
  },
  computed: {
    supplierlength() {
      let count = 0;
      for (var index in this.supplier.data) {
        count++;
      }
      return count;
    }
  },
  created() {
    this.fetchData();
  }
};
</script>
<style lang="">
</style>
