<template>
  <tr>
    <td style="width:30%;">
      <v-select :max-height="'200px'" v-model="item.product" :options="productsListForSelect"  @input="setSelected"/>
    </td>
    <td style="text-align: right;width:5%;">
      <input
        type="number"
        class="form-control form-control-sm"
        style="text-align:right;"
        value="0"
        min="0"
        v-model.number="item.quantity"
      />
    </td>
    <td style="text-align: right;width:12%;">
      <money
        v-model="item.price"
        v-bind="money"
        class="form-control form-control-sm float-right"
        style="text-align: right"
      />
    </td>
    <td style="text-align: right;width:12%;">
      <money
        v-model="item.itbis"
        v-bind="money"
        class="form-control form-control-sm float-right"
        style="text-align: right"
      />
    </td>
    <td style="text-align: right;width:12%;">{{parseFloat(totalPrice).formatMoney(2)}}</td>
    <td style="width:3%;">
      <i
        class="fas fa-trash"
        @click="deleteRow"
        style="font-size:18px;color:rgb(245, 188, 25);cursor:pointer;"
      ></i>
    </td>
  </tr>
</template>

<script>
import money from "v-money";
Vue.use(money, { precision: 4 });
export default {
  props: ["item", "productsList", "index"],
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
  methods: {
    setSelected(value)
    {
      let found =  this.productsList.find(e => e.id === value.code);
      if(found)
      {
        this.item.price = found.price
      }
    },
    deleteRow() {
      this.$emit("removeRow", this.index);
    }
  },
  watch: {
    item: {
      handler(val, oldVal) {
        if (this.item.quantity < 0) {
          this.item.quantity = 0;
        }
        this.item.total = this.totalPrice;
        this.$emit("replaceElement", {
          index: this.index,
          item: this.item
        });
      },
      deep: true
    }
  },
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
      let amount = (this.item.price + this.item.itbis) * this.item.quantity;
      return amount;
    }
  }
};
</script>

<style>
</style>