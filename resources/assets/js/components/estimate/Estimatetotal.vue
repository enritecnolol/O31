<template>
  <div class="float-right">
    <div
            style="width: 350px;height: auto;box-shadow: 0px 0px 3px 0px rgba(0,0,0,0.75);border-radius: 10px 10px 10px 10px;"
    >
      <div class="container">
        <div class="row">
          <div class="col-md-6" style="margin-top: 10px">
            <b>SubTotal:</b>
          </div>
          <div class="col-md-6" style="margin-top: 10px;text-align: right;">RD${{parseFloat(subTotal).formatMoney(2)}}</div>
          <div class="col-md-5" style="margin-top: 10px">
            <b>Descuento:</b>
          </div>
          <div
                  class="col-md-7"
                  style="margin-top: 10px;text-align: right;"
          >
            <div class="float-left">
              <input type="number" class="form-control form-control-sm" style="width: 80px" v-model="desc">
            </div>
            <div class="float-right">
              RD${{parseFloat(discountApplied).formatMoney(2)}}
            </div>
          </div>

          <div class="col-md-6" style="margin-top: 10px">
            <b >Impuestos:</b>
          </div>
          <div
                  class="col-md-6"
                  style="margin-top: 10px;text-align: right;"
          >RD${{parseFloat(tax).formatMoney(2)}}</div>
          <div class="col-md-12">
            <hr />
          </div>
          <div class="col-md-6">
            <b>Monto Total:</b>
          </div>
          <div class="col-md-6" style="text-align: right;">RD${{parseFloat(total).formatMoney(2)}}</div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
  export default {
    props: {
      subTotal:{
        type:Number,
        default:0
      },
      discount:{
        type:Number,
        default:0
      },
      tax:{
        type:Number,
        default:0
      },
      total:{
        type:Number,
        default:0
      },
      discountPercent:{
        type:Number
      }
    },
    data()
    {
      return {
        desc:0
      }
    },
    computed:{
      discountApplied()
      {
        let discount = this.desc/100;
        discount = this.subTotal * discount;
        return discount;
      }
    },
    watch:{
      discountApplied()
      {
        this.$emit("ChangeDiscountApplied", this.desc)
      },
      desc()
      {
        if(this.desc < 0 || this.desc == "")
        {
          this.desc = 0;
          return;
        }

        if(this.desc>100)
        {
          this.desc = 100;
          return;
        }
      },
      discountPercent()
      {
        this.desc = this.discountPercent
      }
    }
  };
</script>
<style>
</style>
