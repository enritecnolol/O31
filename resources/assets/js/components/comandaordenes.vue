<template>
    <div class="container-fluid">
        <div class="loader" v-if="loading == true"></div>
        <div class="row" style="margin-top: 10px"></div>
        <div class="row">
            <div class="col-md-12" style="margin-top: 80px" v-if="ordensdetailsall.length ==0">
                <div class="text-center">
                    <h2>No hay resultado ...</h2>
                </div>
            </div>
            <template v-for="(item, index) in ordensdetailsall">
                <comandaordenitem :orden="item.orden" @cambioestado2="cambioestado" @ordenterminada="ordenterminada" :key="index" :index="index" :details="item.details"></comandaordenitem>
            </template>
        </div>
    </div>
</template>
<script>
    import comandaordenitem from './comandaordenitem';

    export default {
        name:'comandaordenes',
        components:{comandaordenitem},
        data(){
            return {
                areas:[],
                areaid:0,
                ordenes:[],
                ordensdetailsall:[],
                loading:false,
                detailsdata:[]
            }
        },
        methods:{
            ordenterminada(i)
            {
                this.ordensdetailsall.splice(i.index,1)
            },
            allareas()
            {
                axios.post('/all/area', {
                    nombre:this.nombrearea
                })
                    .then( (response) => {
                        this.areas = response.data
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            ordensdetails()
            {
                this.loading = true;
                axios.post('/all/ordens/open')
                    .then( (response) => {
                        this.ordenes = response.data;
                        this.detailtsordens();
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            detailtsordens()
            {
                var data2 = [];
                this.ordenes.forEach( (data) => {
                    axios.post('/all/ordens/details',{
                        id:data.id
                    })
                        .then( (response) => {
                            data2 = response.data;
                            this.ordensdetailsall.push({
                                orden:data,
                                details:data2
                            });
                            this.ordensdetailsall.reverse();
                        })
                        .catch( (error) => {
                            console.log(error);
                        });

                });
                this.loading = false;
            },
            cambioestado(i)
            {
                this.ordensdetailsall[i.ordendetalleindex].details[i.i.index].estado = 'preparando';
                axios.post('/cambio/estado/item/orden', {
                    id: i.i.id,
                })
                    .then((response) => {
                        console.log(response);
                        this.proceso = true
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            }
        },
        computed:{
        },
        mounted(){
        },
        created(){
            this.ordensdetails();
        },
    }
</script>
<style >
    .loader {
        position: fixed;
        left: 0px;
        top: 0px;
        width: 100%;
        height: 100%;
        z-index: 9999;
        background: url("../../../../public/loading2.gif") 50% 50% no-repeat rgb(249,249,249);
        opacity: .8;
    }
</style>