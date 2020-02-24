<template>
  <card-panel>
    <template slot="body">
      <div class="card-header">Metodos de pago</div>
      <div class="card-body" style="height: 400px">
        <div class="row">
          <div class="loader" v-if="loading" />
          <div class="col-md-6">
            <payment-methods-form
              :editData="PaymentMethodEdit"
              @refreshData="getPaymentMethods(1)"
              @loadingStatus="loadingStatus"
            />
          </div>
          <div class="col-md-6">
            <div class="row">
              <div class="col-md-12">
                <h3>Lista de metodos de pago</h3>
              </div>
              <div class="col-md-12" style="margin-top: 15px">
                <general-table
                  :pagination="true"
                  :paginate="paymentMethodsList"
                  @pageChange="getPaymentMethods"
                >
                  <template slot="table-header">
                    <tr>
                      <th>Nombre</th>
                      <th></th>
                    </tr>
                  </template>
                  <template slot="table-body">
                    <tr v-for="(item, index) in paymentMethodsList.data" :key="index">
                      <td>{{item.name}}</td>
                      <td align="right">
                        <div class="dropdown">
                          <button
                            class="btn btn-sm btn-secondary dropdown-toggle"
                            type="button"
                            id="dropdownMenuButton"
                            data-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false"
                          >
                            <i class="fas fa-bars" />
                          </button>
                          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="#" @click="editData(index)">Editar</a>
                            <!--                    <a class="dropdown-item" href="#" @click="ResendEstimate(item.id)">Reenviar</a>-->
                            <a class="dropdown-item" href="#">Eliminar</a>
                          </div>
                        </div>
                      </td>
                    </tr>
                  </template>
                </general-table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </template>
  </card-panel>
</template>
<script>
import cardPanel from "../cardPanel";
import paymentMethodsForm from "./paymentMethodsForm";
import generalTable from "../generalTable";
export default {
  name: "payment-methods",
  components: { cardPanel, paymentMethodsForm, generalTable },
  data() {
    return {
      paymentMethodsList: {},
      PaymentMethodEdit: null,
      loading: false
    };
  },
  methods: {
    editData(index) {
      this.PaymentMethodEdit = this.paymentMethodsList.data[index];
    },
    getPaymentMethods(page) {
      this.PaymentMethodEdit = null;
      this.loading = true;
      axios
        .get("/payment/methods/list", {
          params: {
            page: page
          }
        })
        .then(response => {
          this.paymentMethodsList = response.data;
        })
        .catch(error => {
          toastr.warning(error.response.data.message);
          console.log(error.response);
        })
        .finally(() => {
          this.loading = false;
        });
    },
    loadingStatus(val) {
      this.loading = val;
    }
  },
  computed: {},
  created() {
    this.getPaymentMethods();
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