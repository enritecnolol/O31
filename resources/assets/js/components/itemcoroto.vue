<template>
    <div>
        <div>
            <img  v-show="name != 'pared'" :src="'../../../../local/'+img" :width="w" :height="h" alt="">
            <template v-if="name != 'caja' && name != 'pared' && name != 'mata' && name != 'puerta'">
                <template v-if="numero!=0">
                    <div style="position: absolute;left: 0;top: 0;">
                        <h3 style="color: #4cd137" v-if="status == 1" @dblclick="editari = true">{{nombre}}</h3>
                        <h3 style="color: orange" v-else-if="status == 2" @dblclick="editari = true">{{nombre}}</h3>
                        <h3 style="color: red" v-else>{{nombre}}</h3>
                        <h3 style="color: #4cd137" v-if="editari == true"><input type="text" class="form-control form-control-sm" @keypress.enter="cambiarnomb" style="width: 100px;background: white" v-model="nombre" id=""></h3>
                    </div>
                </template>
            </template>
            <template v-if="name == 'pared'">
                <div style="background: grey;box-shadow: 0px 0px 5px 0px rgba(0,0,0,0.75);" :style="{height: h+'px', width: w+'px'}"></div>
            </template>
        </div>
        <h3 style="position: absolute;right: 2px;top: 0px; color: orange;cursor: pointer" v-if="editar == true" @click="eliminarcoroto(index)">&times;</h3>
    </div>
</template>
<script>
    export default {
        name:'ItemCoroto',
        props:['index', 'id','name','numero', 'img', 'status', 'w', 'h', 'y', 'x', 'editar', 'area'],
        components:{},
        data(){
            return{
                editari:false,
                nombre:this.name
            }
        },
        methods:{
            cambiarnomb()
            {
                console.log('aqui');
                this.editari = false;
                this.$emit('cambiarnombre',{
                    index:this.index,
                    id:this.id,
                    nombre:this.nombre
                });
            },
            eliminarcoroto(i)
            {
                this.$emit('eliminarcoroto',{
                    index:this.index,
                    id:this.id
                })
            },
        },
        computed:{

        },
        mounted() {
        }
    }
</script>
<style>

</style>