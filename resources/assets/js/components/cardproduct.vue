<template>
    <div class="col-md-2">
        <div class="card-mio" @click="productoselect()">
            <p class="title-card letra">{{producto.name}}</p>
            <h6 class="card-price letra">${{producto.price}}.00</h6>
            <div class="card-img-wrap" style="box-shadow: 0px 0px 6px 0px rgba(0,0,0,0.75);">
                <img class="img-card" :src="'../../../../imagenes/'+producto.img" alt="">
            </div>
        </div>
    </div>
</template>
<script !src="">
    export default {
        name:'cardproduct',
        props:['producto', 'index', 'id', 'mesa'],
        components:{},
        data()
        {
            return{
                bus: new Vue(),
            }
        },
        methods:{
            productoselect()
            {
                this.$emit('productoagregar',{
                    index:this.index,
                    producto:this.producto,
                    mesa:this.mesa,
                    cantidad:1,
                    total:parseFloat(this.producto.price).toFixed(2),
                });
                this.$emit('bajarscroll')
            }
        },
        mounted() {

        }
    }
</script>
<style>

</style>