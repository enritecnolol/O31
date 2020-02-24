<template>
  <div class="float-right">
    <div
      style="width: 300px;height: 150px;box-shadow: 0px 0px 3px 0px rgba(0,0,0,0.75);border-radius: 10px 10px 10px 10px;"
    >
      <div class="container">
        <div class="row">
          <div class="col-md-6" style="margin-top: 10px">
            <b>SubTotal:</b>
          </div>
          <div class="col-md-6" style="margin-top: 10px">RD${{parseFloat(subTotal).formatMoney(2)}}</div>
          <template v-if="discount">
            <div class="col-md-6" style="margin-top: 10px">
              <b>Descuento:</b>
            </div>
            <div
              class="col-md-6"
              style="margin-top: 10px"
            >RD${{parseFloat(discount).formatMoney(2)}}</div>
          </template>
          <div class="col-md-12">
            <hr />
          </div>
          <div class="col-md-6">
            <b>Monto Total:</b>
          </div>
          <div class="col-md-6">RD${{parseFloat(subTotal).formatMoney(2)}}</div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  props: ["subTotal", "discount"]
};
</script>
<style>
</style>