<template>
    <div class="container" style="margin-top:0;">
        <div class="row" v-if="!seleccionado">
            <template v-for="(item, index) in typereports">
                <card :report="item" :index="index" @seleccionado="cardseleccionado"></card>
            </template>
        </div>
        <div v-else>
            <panel :seleccionado="seleccionado" @regresar="regresar" />
        </div>
    </div>
</template>
<script>
    import card from './card';
    import panel from './panel';
    export default {
        name:'reportpanel',
        components:{card, panel},
        data(){
            return {
                typereports:[
                    {
                        tittle:'Ventas'
                    },
                    {
                        tittle:'Productos'
                    },
                    {
                        tittle:'Comprobantes'
                    },
                    {
                        tittle:'Caja'
                    },
                    {
                        tittle:'Reporte 607'
                    },
                ],
                seleccionado:''
            }
        },
        methods:{
            regresar()
            {
              this.seleccionado  = "";
            },
            cardseleccionado(i)
            {
                if (this.typereports[i.index].tittle === "Reporte 607")
                {
                    window.location.href = '/reporte607';
                    return;
                }
                this.seleccionado = this.typereports[i.index].tittle;
            }
        },
        computed:{

        },
    }
</script>
<style>
</style>