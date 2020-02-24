<template>
  <tr>
    <td>
      <v-select
        v-model="item.product"
        taggable
        :options="productsListForSelect"
        @input="setSelected"
      />
    </td>
    <td>
      <input type="text" class="form-control form-control-sm" v-model="item.description" />
    </td>
    <td style="width: 6%">
      <input
        type="number"
        class="form-control form-control-sm float-right"
        min="1"
        v-model="item.quantity"
      />
    </td>
    <td style="width: 12%">
      <money
        v-model="item.price"
        v-bind="money"
        class="form-control form-control-sm float-right"
        style="text-align: right"
      />
    </td>
    <td style="width: 10%">
      <input
        type="number"
        class="form-control form-control-sm float-right"
        min="1"
        v-model="item.discount"
      />
    </td>
    <td style="width: 10%">
      <p style="float: right">RD${{Number.parseFloat(item.amount).formatMoney(2)}}</p>
    </td>
    <td style="width: 5%">
      <i
        :class="index === 0 ? '' : 'fas fa-trash-alt'"
        style="cursor: pointer;color: #CC8400;"
        @click="removeElement"
      />
    </td>
  </tr>
</template>
<script>
export default {
  props: ["index", "item", "productsList"],
  data() {
    return {
      money: {
        decimal: ".",
        thousands: ",",
        prefix: "RD$ ",
        precision: 2,
        masked: false
      }
    };
  },
  methods: {
    setSelected(value) {
      let foundProduct = this.productsList.find(e => e.id === value.code);
      if (foundProduct) {
        this.item.price = foundProduct.price;
      }
    },
    removeElement() {
      this.$emit("removeItem", this.index);
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
    }
  },
  watch: {
    item: {
      handler(val, oldVal) {
        let discount =
          this.item.price * this.item.quantity * (this.item.discount / 100);
        this.item.amount = this.item.price * this.item.quantity - discount;

        this.$emit("replaceElement", {
          index: this.index,
          item: this.item
        });
      },
      deep: true
    }
  }
};
</script>
<style>
</style>