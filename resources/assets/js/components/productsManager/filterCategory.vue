<template>
    <div class="form-group">
        <label for="category">Categoria: </label>
        <select id="category" class="form-control form-control-sm" v-model="category" @change="categorySelect">
            <option selected value="">Selecionar</option>
            <option :value="item.id" v-for="item in categories">{{item.nombre}}</option>
        </select>
    </div>
</template>

<script>
    export default {
        props:['reset'],
        data(){
            return{
                category:'',
                categories:[]
            }
        },
        methods:{
            categorySelect()
            {
                this.$emit('categorySelect', {
                    categories:this.category
                })
            }
        },
        created(){
            axios.get('ver/categoria/get')
                .then( (response) => {
                    this.categories =  response.data
                })
                .catch( (error) => {
                    toastr.warning("Error al llamar categorias");
                    console.log(error);
                });
        },
        watch:{
            reset(){
                if(this.reset){
                    this.category = '';
                }
            }
        },
        computed:{

        }
    }
</script>

<style scoped>

</style>