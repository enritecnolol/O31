<template>
  <tr>
    <td>
      <input type="checkbox" id="checkbox" v-model="checked">
    </td>
    <td style="width: 30%">Factura #{{data.id}} ({{data.invoice_date}})</td>
    <td>{{data.due_date}}</td>
    <td style="text-align: right">RD${{parseFloat(data.total).formatMoney(2)}}</td>
    <td style="text-align: right">RD${{parseFloat(data.open_balance).formatMoney(2)}}</td>
    <td><money
        v-model="amountReceived"
        :disabled="amountReceivedState"
        v-bind="money" class="form-control form-control-sm  float-right"
        style="text-align: right;width: 150px" /></td>
    <td><money v-model="discount" v-bind="money" class="form-control form-control-sm  float-right" style="text-align: right;width: 150px" /></td>
    <td style="text-align: right">RD${{parseFloat(BalanceAfterPay).formatMoney(2)}}</td>
  </tr>
</template>
<script>
  export default {
    name:'item-body',
    props:['data', 'index', 'amountReceivedState'],
    data()
    {
      return{
        money: {
          decimal: '.',
          thousands: ',',
          prefix: 'RD$ ',
          precision: 2,
          masked: false
        },
        amountReceived:0,
        discount:0,
        checked:false
      }
    },
    computed:{
      BalanceAfterPay()
      {
        return ( parseFloat(this.data.open_balance) - parseFloat(this.discount) ) - parseFloat(this.amountReceived) ;
      }
    },
    watch:{
      discount()
      {
        if(this.discount > this.data.open_balance)
        {
          this.amountReceived = 0;
          return;
        }
        this.amountReceived = parseFloat(this.data.open_balance) - parseFloat(this.discount);
      },
      checked()
      {
        if(this.checked)
        {
          this.amountReceived = this.data.open_balance - this.discount;
        }else {
          this.amountReceived = 0;
        }
      },
      BalanceAfterPay()
      {
        this.data.discount = this.discount;
        this.data.BalanceAfterPay = this.BalanceAfterPay;
        this.data.amountReceived = this.amountReceived;

        this.$emit('updateData', {
          index:this.index,
          data:this.data
        })
      },
      data:{
        handler()
        {
          this.amountReceived = this.data.amountReceived;
          // this.checked = this.data.check;
        },
        deep:true
      }
    }
  }
</script>
<style>

</style>