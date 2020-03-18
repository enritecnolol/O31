<template>
  <div class="card" style="width: 400px;cursor: pointer" @click="datosfactura(item.id)">
    <div class="card-body">
      <div class="row">
        <div class="col-md-12 text-center">
          <h6>Factura {{ item.type_sale }}</h6>
        </div>
        <div class="col-md-12">
          <hr>
        </div>
        <div class="col-md-6" style="margin-top: 10px">
          <p><b>No. Factura: </b>{{ item.id }}</p>
        </div>
        <div class="col-md-6" style="margin-top: 10px">
          <p><b>Fecha: </b> {{ formatMoment(item.created_at) }}</p>
        </div>
        <div class="col-md-6" style="margin-top: 10px">
          <p><b>Monto: </b> {{ parseFloat(item.total_facture).formatMoney(2) }}</p>
        </div>
        <div class="col-md-6" style="margin-top: 10px">
          <p><b>Devuelta: </b> {{ parseFloat(item.returns).formatMoney(2) }}</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    props:['item'],
    methods:{
      formatMoment(datetime)
      {
        return moment(datetime).format('DD-MMM-YYYY hh:mm A')
      },
      datosfactura(id)
      {
        this.$emit('datosfactura', id)
      }
    }
  }
</script>

<style scoped>

</style>