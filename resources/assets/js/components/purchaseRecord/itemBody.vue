<template>
  <tr>
    <td style="width:30%;">
      <v-select :max-height="'200px'" v-model="item.product" :options="productsListForSelect" />
    </td>
    <td style="text-align: right;width:5%;">
      <input
        type="number"
        class="form-control form-control-sm"
        style="text-align:right;"
        value="0"
        min="0"
        v-model="item.quantity"
      />
    </td>
    <td style="text-align: right;width:12%;">
      <money
        v-model="item.unitPrice"
        v-bind="money"
        class="form-control form-control-sm float-right"
        style="text-align: right"
      />
    </td>
    <td style="text-align: right;width:12%;">
      <money
        v-model="item.sales_price_without_tax"
        v-bind="money"
        class="form-control form-control-sm float-right"
        style="text-align: right"
      />
    </td>

    <td style="text-align: right;width:12%;">{{parseFloat(totalPrice).formatMoney(2)}}</td>
  </tr>
</template>

<script>
import money from "v-money";
Vue.use(money, { precision: 4 });
export default {
  props: ["item", "productsList"],
  data() {
    return {
      money: {
        decimal: ".",
        thousands: ",",
        prefix: "RD$ ",
        precision: 2,
        masked: false
      },
      price: 0
    };
  },
  methods: {},
  computed: {
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
    totalPrice() {
      let amount = this.item.unitPrice * this.item.quantity;
      return amount;
    }
  }
};
</script>

<style>
</style>