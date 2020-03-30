<template>
    <tr>
        <td style="width: 15%">
            <input type="text" v-model="code" class="form-control form-control-sm" @keypress.enter="searchProduct">
        </td>
        <td >
            <v-select
                    v-model="item.product"
                    taggable
                    :options="productsListForSelect"
                    @input="setSelected"
            />
        </td>
        <td style="text-align: center;width: 10%">
            <input
                    type="number"
                    class="form-control form-control-sm"
                    style="width: 100px;text-align: center"
                    value="0"
                    v-model="item.quantity"
            >
        </td>
        <td style="text-align: right;width: 200px">
            <money
                    v-model="item.amount"
                    v-bind="money"
                    class="form-control form-control-sm float-right"
                    style="text-align: right"
            />
        </td>
        <td style="text-align: right;width: 200px">
            {{parseFloat(impost).formatMoney(2)}}
        </td>
        <td style="text-align: center;width: 100px"><i
                class="fas fa-trash"
                @click="removeRow"
                style="font-size:18px;color:rgb(245, 188, 25);cursor:pointer;"
        ></i>
        </td>
    </tr>
</template>

<script>
    import money from "v-money";
    Vue.use(money, { precision: 4 });
    import vSelect from "vue-select";
    import "vue-select/dist/vue-select.css";
    Vue.component("v-select", vSelect);
    export default {
        props:['item', 'index', 'productsListForSelect'],
        data()
        {
          return{
              money: {
                  decimal: ".",
                  thousands: ",",
                  prefix: "RD$ ",
                  precision: 2,
                  masked: false
              },
              code:""
          }
        },
        methods:{
            searchProduct()
            {
              let found = this.productsListForSelect.find(e => e.code == this.code)
              if(found)
              {
                  this.item.product = found;
                  return;
              }
              toastr.warning("Este productos no fue encontrado", "Validador");
              this.item.product = "";
            },
            removeRow()
            {
                this.$emit('removeRow', this.index)
            },
            setSelected(i)
            {
                this.code = i.code
            }
        },
        computed:{
          impost()
          {
              return this.item.quantity * this.item.amount;
          }
        },
        watch:{
            item: {
                handler(val, oldVal) {
                    this.item.impost = this.impost;

                    this.$emit("replaceElement", {
                        index: this.index,
                        item: this.item
                    });
                },
                deep: true
            }
        }

    }
</script>

<style scoped>

</style>