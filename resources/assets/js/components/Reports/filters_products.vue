<template>
    <div class="col-12">
        <div class="card border-primary mb-3" style="max-width: 100%;">
            <div class="card-body text-primary">
                <h5 class="card-title">Productos</h5>
                <hr style=" background:#007bff;">
                <p class="card-text">
                    <multiselect
                            v-model="value"
                            tag-placeholder="Add this as new tag"
                            placeholder="Search or add a tag"
                            label="name"
                            track-by="id"
                            :close-on-select="false"
                            :preserve-search="true"
                            :options="options"
                            :multiple="true"
                            :taggable="true">

                    </multiselect>
                </p>
            </div>
        </div>
    </div>
</template>
<script>
    import Multiselect from 'vue-multiselect'

    export default {
        components:{Multiselect},
        name:'filters_products',
        data(){
            return{
                value:[],
                options:[]
            }
        },
        created(){
            axios.get('/products/select')
                .then( (response) => {
                    this.options =  response.data
                })
                .catch( (error) => {
                    toastr.warning("Error al llamar los productos");
                    console.log(error);
                });
        },
        watch:{
            value(){
                this.$emit('products_select', {
                    products:this.value
                })
            }
        }

    }
</script>
<style>
    @import url('https://unpkg.com/vue-multiselect@2.1.0/dist/vue-multiselect.min.css');
</style>