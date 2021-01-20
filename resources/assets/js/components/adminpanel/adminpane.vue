<template>
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12" style="margin-top:20px;">
                    <div class="card">
                        <div class="card-header">
                            <div class="text-left">
                                <strong>Clientes</strong>
                            </div>
                            <div style="position: absolute;right: 7px;top: 9px;">
                                <button type="button" class="btn btn-sm btn-warning" @click="formview = true" v-if="!formview">Nuevo <i class="fa fa-edit"></i></button>
                                <button type="button" class="btn btn-sm btn-danger" @click="formview = false, selected = ''" v-else><i class="fa fa-arrow-left"></i> Atras</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <formclient v-if="formview" @saved="refresh" :item="selected"/>
                            <tableadmin :headers="header" :datas="data" @selected="edititem" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import tableadmin from './table';
    import formclient from './formclient';
    export default {
        name:'adminpanel',
        components:{
            tableadmin,
            formclient
        },
        data(){
            return{
                header:[],
                data:[],
                formview:false,
                selected:''
            }
        },
        methods:{
            edititem(i)
            {
                this.selected = this.data[i];
                this.formview = true;
            },
            refresh()
            {
                this.usuariostable();
                this.formview = false;
            },
            usuariostable()
            {
                axios.post('/user/list')
                    .then( (response) => {
                        this.header = response.data['header'];
                        this.data = response.data['data'];
                    })
                    .catch( (error) => {
                        console.log(error);
                    });
            }
        },
        computed:{

        },
        mounted() {
            this.usuariostable();
        }
    }
</script>
<style>

</style>
