<template>
    <div class="container" style="margin-top: -40px">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12" style="margin-bottom: 10px">
                        <div class="text-right">
                            <button type="button" v-if="camareroform == false" class="btn btn-primary btn-sm" @click="camareroform = true"><i class="fas fa-user-plus"></i> Crear Camarero</button>
                            <button type="button" v-else class="btn btn-danger btn-sm" @click="camareroform = false"><i class="fas fa-sort-down"></i> Ocultar</button>
                        </div>
                    </div>
                </div>
                <formcamarero
                    :camareros="camareros"
                    @actualizar="allcamareros"
                    v-show="camareroform == true"></formcamarero>
                <tablacamarero
                    :camareros="camareros"
                    :camarerospaginate="camarerospaginate"
                    :pagination="pagination"
                    @datospaginare="datostablacamarero"
                    @editar="editar"
                    @eliminar="eliminar"></tablacamarero>
            </div>
        </div>
    </div>
</template>
<script>
    import formcamarero from './formcamarero';
    import tablacamarero from './tablacamarero';
    export default {
        name:'pantallacamarero',
        components:{formcamarero, tablacamarero},
        data(){
            return{
                camareros:[],
                camarerospaginate:[],
                camareroform:false,
                pagination:{}
            }
        },
        methods:{
            allcamareros()
            {
                this.camareroform = false;
                axios.post('/camareros/all')
                    .then( (response) => {
                        this.camareros = response.data;
                        this.datostablacamarero();
                    })
                    .catch( (error) => {
                        console.log(error);
                    });

                axios.post('/camareros/all/pagination')
                    .then( (response) => {
                        this.camarerospaginate = response.data;
                    })
                    .catch( (error) => {
                        console.log(error);
                    });
            },
            editar(i)
            {
                this.camareroform = true;
                this.$eventbus.$emit('editarcamarero', i)
            },
            eliminar(i){

                axios.post('/camareros/delete',{
                    id:i
                })
                    .then( (response) => {
                        this.allcamareros();
                        toastr.success('Se le ha eliminado con exito', 'Validador')
                    })
                    .catch( (error) => {
                        console.log(error);
                    });
            },
            datostablacamarero(url) {
                url  = url || '/camareros/all/pagination';
                axios.post(url)
                    .then( (response) => {
                        this.camarerospaginate = response['data']['data'];
                        this.setpaginator(response['data']);
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            setpaginator(data){
                let pagination = {
                    current_page: data.current_page,
                    path: data.path,
                    last_page: data.last_page,
                    first_page_url: data.first_page_url,
                    next_page_url: data.next_page_url,
                    prev_page_url: data.prev_page_url,
                    last_page_url: data.last_page_url
                };
                this.pagination = pagination;
            },
        },
        computed:{

        },
        mounted() {
        },
        created() {
            this.allcamareros();
            this.datostablacamarero();
        }
    }
</script>
<style>

</style>
