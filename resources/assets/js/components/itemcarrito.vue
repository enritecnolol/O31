<template>
    <div class="panel panel-default product-details" style="margin-top: 10px">
        <div class="panel-body">
            <div class="row">
                <div class="col-md-5">
                    <div class="row">
                        <div class="col-md-2">
                            <span class="badge badge-danger" style="border-radius: 50px;margin-left: -6px;cursor: pointer" @click="masomenos('eliminar')"><i class="fas fa-times"></i></span>
                        </div>
                        <div class="col-md-10 nopadding">
                            <span class="textPD">{{productoselecionado.producto.name}}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 nopadding">
                    <div class="text-center">
                        <span class="textPD" style="margin-left: 8px">{{parseFloat(productoselecionado.producto.price).toFixed(2)}}</span>
                    </div>
                </div>
                <div class="col-md-3 nopadding">
                    <div class="row" style="margin-left: 10px">
                        <div class="nopadding" style="cursor: pointer" @click="masomenos('menos')"><span class="badge badge-pill badge-secondary"><i class="fas fa-minus"></i></span></div>
                        <div class="nopadding"><input type="text" style="width: 30px" value="0" v-model="productoselecionado.cantidad" @blur="masomenos" @input.self="masomenos" class="form-control form-control-sm"></div>
                        <div class="nopadding" style="cursor: pointer;" @click="masomenos('mas')"><span class="badge badge-pill badge-secondary"><i class="fas fa-plus"></i></span></div>
                    </div>
                </div>
                <div class="col-md-2 nopadding">
                    <span class="subtotal textPD" style="margin-right: 37px;">{{productoselecionado.total}}</span>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        name:'itemcarrito',
        props:['productoselecionado', 'index'],
        methods:{
            masomenos(accion)
            {
                if  (this.productoselecionado.cantidad == '')
                {
                    accion = 'eliminar';
                }

                if (accion == 'mas')
                {
                    this.productoselecionado.cantidad = parseFloat(this.productoselecionado.cantidad) + 1
                }
                else if(accion == 'eliminar')
                {
                    this.productoselecionado.cantidad = 0;
                }
                else if (accion == 'menos')
                {
                    this.productoselecionado.cantidad = parseFloat(this.productoselecionado.cantidad) - 1
                }
                this.$emit('cambiarcantidad',{cantidad:this.productoselecionado.cantidad,index:this.index});
            }
        },
        computed:{

        }
    }
</script>
<style>

</style>