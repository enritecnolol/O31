<template>
  <tr  :style="{'background-color': color[0]}"  @click="seleccion = true">
    <td :style="{'color': color[1]}">{{ nombre ? id +" - " + nombre : servicio }}</td>
    <td :style="{'color': color[1]}" v-if="cantidaddevolver == 0"><div class="text-center"> {{  cantidad }} </div></td>
    <td :style="{'color': color[1]}" v-else><div class="text-center"> {{ operacion }} </div></td>
    <td :style="{'color': color[1]}">{{ precio  }}</td>
    <td :style="{'color': color[1]}">{{ decimal(bruto) }}</td>
    <td :style="{'color': color[1]}">{{ decimal(itbis) }}</td>
    <td style="width: 100px">
      <input type="number" style="width: 100px;" :disabled="cantidad === 0" v-model="cantidaddevolver" :max="cantidad" min="0" class="form-control form-control-sm">
<!--      <button type="button" style="float: right;" class="btn btn-primary btn-sm" @click="nuevodetalle"><i class="fas fa-undo"></i></button>-->
    </td>
  </tr>
</template>

<script>
  export default {
    props: ['index','id','nombre', 'cantidad', 'precio', 'bruto', 'itbis', 'bus', 'servicio'],
    computed: {
      color () {
        if (this.operacion === 0) {
          return ['#ea4343', 'white']
        }
        return ['transparent', 'black']
      },
      operacion(){
        return this.cantidad - this.cantidaddevolver;;
      },
    },
    data(){
      return{
        seleccion:false,
        cantidaddevolver:0
      }
    },
    methods:{
      nuevodetalle:function () {
        if (this.cantidaddevolver > 0 && this.cantidaddevolver <= this.cantidad){
          if  (this.cantidaddevolcer != 0)
          {
            this.$emit('nuevodetalle',{
              index:this.index,
              datos:{
                id:this.id,
                nombre:this.nombre,
                cantidad:this.cantidad,
                cantidaddevolcer:this.cantidaddevolver
              }
            });
          }
        }
      },
      decimal:function (i) {
        return parseFloat(i).toFixed(2)
      }
    },
    mounted() {
      this.bus.$on('ejecutar', this.nuevodetalle)
    },
    watch: {
      cantidaddevolver(){

        console.log(this.cantidaddevolver + '---- > --- '+this.cantidad)
        if(this.cantidaddevolver > this.cantidad){
          this.cantidaddevolver = this.cantidad;
        }
        if(this.cantidaddevolver < 0)
        {
          this.cantidaddevolver = 0;
        }
      }
    }
  }
</script>

<style scoped>

</style>