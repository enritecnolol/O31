<template>
  <div>
    <div class="loader" v-if="existenciarep == 'no'">
      <h3
        style="color: red;position: absolute;left: 35%;top: 30%;"
      >Usted no tiene acceso al control de inventario</h3>
    </div>
    <card-panel>
      <template slot="body">
        <div class="card-body">
          <create-purchase-record />
          <!-- <view-purchase-record /> -->
        </div>
      </template>
    </card-panel>
  </div>
</template>

<script>
import createPurchaseRecord from "./createPurchaseRecord";
import cardPanel from "../cardPanel";
import viewPurchaseRecord from "./viewPurchaseRecord";
export default {
  components: { createPurchaseRecord, cardPanel, viewPurchaseRecord },
  data() {
    return {
      existenciarep: ""
    };
  },
  methods: {
    existencia() {
      axios
        .post("/configuracion/existencia")
        .then(response => {
          this.existenciarep = response["data"];
        })
        .catch(function(error) {
          console.log(error);
        });
    }
  },
  created() {
    this.existencia();
  }
};
</script>

<style lang="scss" scoped>
</style>