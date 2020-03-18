<template>
  <tr :style="{'background-color': color[0]}">
    <th :style="{'color': color[1]}">{{item.product_id}} - {{item.name}}</th>
    <td :style="{'color': color[1]}" style="text-align: center">{{remaining}}</td>
    <td :style="{'color': color[1]}" style="text-align: right">{{parseFloat(item.price).formatMoney(2)}}</td>
    <td :style="{'color': color[1]}" style="text-align: right">{{parseFloat(item.itbis).formatMoney(2)}}</td>
    <td :style="{'color': color[1]}" style="text-align: right">{{parseFloat(item.price * remaining).formatMoney(2)}}</td>
    <td style="width: 100px">
      <input
          type="number"
          style="width: 100px;"
          min="0"
          :disabled="item.quantity === 0"
          :max="item.quantity"
          v-model="returnsQuantity"
          class="form-control form-control-sm"/>
    </td>
  </tr>
</template>

<script>
  export default {
    props: ['item', 'bus', 'index'],
    data() {
      return {
        returnsQuantity: 0
      }
    },
    computed: {
      color() {
        if (this.remaining === 0) {
          return ['#ea4343', 'white']
        }
        return ['transparent', 'black']
      },
      remaining() {
        return this.item.quantity - this.returnsQuantity;
      },
    },
    methods:{
      saveDetail() {
        if (this.returnsQuantity > 0 && this.returnsQuantity <= this.item.quantity) {
          if (this.returnsQuantity !== 0) {
            this.$emit('return_purchase_detail', {
              index: this.index,
              data: {
                name: this.item.name,
                product_id: this.item.product_id,
                returnsQuantity: this.returnsQuantity,
                total: this.item.price * this.remaining
              }
            });
          }
        }
      }
    },
    watch: {
      returnsQuantity() {
        if (this.returnsQuantity > this.item.quantity) {
          this.returnsQuantity = this.item.quantity;
        }

        if (this.returnsQuantity < 0 || this.returnsQuantity === "") {
          this.returnsQuantity = 0;
        }
      }
    },
    mounted() {
      this.bus.$on('ejecutar', this.saveDetail)
    },
  }
</script>

<style scoped>

</style>