<template>
    <div class="col">
        <div class="card border-primary mb-3" style="max-width: 100%;">
            <div class="card-body text-primary">
                <h5 class="card-title">Categorias</h5>
                <hr style=" background:#007bff;">
                <p class="card-text">
                    <select class="form-control form-control-sm" v-model="categoria" @change="categories_select">
                        <option selected value="">Selecionar</option>
                        <option :value="item.id" v-for="item in categorias">{{item.nombre}}</option>
                    </select>
                </p>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        name:'filters_categories',
        data(){
            return{
                categoria:'',
                categorias:[]
            }
        },
        methods:{
            categories_select()
            {
                this.$emit('categories_select', {
                    categories:this.categoria
                })
            }
        },
        created(){
            axios.get('ver/categoria/get')
                .then( (response) => {
                    this.categorias =  response.data
                })
                .catch( (error) => {
                    toastr.warning("Error al llamar categorias");
                    console.log(error);
                });
        },
        computed:{

        }

    }
</script>
<style>

</style>