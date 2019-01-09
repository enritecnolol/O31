<template>
    <div class="item">
        <div class="description">
            <span style="color: #212121">{{detail.name}}</span>
        </div>
        <div class="quantity">
            <input type="text" v-model="detail.cantidad">
        </div>
        <div class="buttons">
            <span style="display: inline-block;cursor: pointer;width: 39px;height: 30px;color:#757575;" @click="cambioestado" v-if="detail.estado == null">preparando?</span>
            <span class="process-btn" v-else></span>
        </div>
    </div>
</template>
<script>
    export default {
        name:'comandaordenitemitem',
        components:{},
        props:['detail', 'index'],
        data()
        {
            return{
            }
        },
        methods:{
            cambioestado()
            {
                this.$emit('cambioestado',{
                    id:this.detail.id,
                    index:this.index
                });
            }
        },
        computed:{

        },
        mounted() {
        },
        created() {
        }
    }
</script>
<style>

</style>