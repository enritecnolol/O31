<template>
  <div class="row">
    <div class="col-md-12">
      <div class="float-left">
        <h3>Lista de compra</h3>
      </div>
      <div class="float-right">
        <button type="button" class="btn btn-primary btn-sm" @click="formStatus">
          <i class="fa fa-plus" /> Crear compra
        </button>
      </div>
    </div>
    <div class="col-md-12" style="margin-top:20px;">
      <general-table :paginate="tableData" :hover="true" @pageChange="fetch">
        <template slot="table-header">
          <tr>
            <th>Id</th>
            <th>No. Documento</th>
            <th>Proveedor</th>
            <th>Fecha Factura</th>
            <th style="text-align: right;">Total</th>
            <th style="text-align: right;">Balance</th>
            <th style="text-align: center">Estado</th>
            <th />
          </tr>
        </template>
        <template slot="table-body">
          <tr v-if="loading">
            <td colspan="8">
              <div class="text-center">
                <h3>Cargando ...</h3>
              </div>
            </td>
          </tr>
          <tr v-else v-for="(item, index) in tableData.data" :key="index">
            <td># {{item.id}}</td>
            <td>{{item.document_no}}</td>
            <td>{{searchSupplier(item.supplier_id)}}</td>
            <td>{{item.invoice_date}}</td>
            <td style="text-align: right;">RD${{parseFloat(item.total).formatMoney(2)}}</td>
            <td style="text-align: right;">RD${{parseFloat(item.balance).formatMoney(2)}}</td>
            <td style="text-align: center">
              <span
                :style="{
                color:spanColor(item.payment_status).color,
                background:spanColor(item.payment_status).background
              }"
                style="font-size: 13px;padding: 5px 10px;"
              >{{item.payment_status}}</span>
            </td>
            <td>
              <div class="dropdown">
                <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="fas fa-list" />
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
<!--                  <a class="dropdown-item disabled" onclick="return false;" href="#">Preview</a>-->
<!--                  <a class="dropdown-item disabled" onclick="return false;" href="#" @click="editData(item)">Editar</a>-->
                  <a class="dropdown-item" onclick="return false;" href="#" @click="purchasePayment(item.id)">Realizar pago</a>
                  <a class="dropdown-item" onclick="return false;" @click="purchasePayment(item.id)" href="#">Historial de pago</a>
                </div>
              </div>
            </td>
          </tr>
        </template>
      </general-table>
    </div>
  </div>
</template>

<script>
import generalTable from "../generalTable";
export default {
  components: { generalTable },
  data() {
    return {
      loading: false,
      tableData: {},
      supplierList: []
    };
  },
  methods: {
    purchasePayment(id)
    {
      window.location.href = '/purchase/payment?purchase='+id;
    },
    editData(item)
    {
      this.$emit("editPurchase", item);
    },
    spanColor(status) {
      if (status === "COMPLETADO") {
        return { color: "#354930", background: "#d5eed0" };
      } else if (status === "NO PAGADO") {
        return { color: "#6c432e", background: "#f8edcb" };
      } else {
        return { color: "#1e576c", background: "#c9e3ec" };
      }
    },
    loadingStatus(val) {
      this.loading = val
      this.$emit("loadingStatus", val);
    },
    formStatus() {
      this.$emit("formStatus", true);
    },
    fetch(page) {
      this.loadingStatus(true);
      axios
        .get("/purchase/list", {
          params: {
            page: page
          }
        })
        .then(response => {
          this.tableData = response.data;
        })
        .catch(err => {
          console.log(err);
        })
        .finally(() => {
          this.loadingStatus(false);
        });
    },
    fetchSupplier() {
      axios
        .get("/supplier/list/select")
        .then(response => {
          this.supplierList = response.data;
        })
        .catch(err => {
          console.log(err);
        });
    },
    searchSupplier(id) {
      let found = this.supplierList.find(e => e.id === id);
      if (found) {
        return found.name;
      }
      return "No found";
    }
  },
  created() {
    this.fetch();
    this.fetchSupplier();
  }
};
</script>

<style lang="scss" scoped>
</style>