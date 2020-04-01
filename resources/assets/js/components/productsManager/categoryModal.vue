<template>
    <div class="modal fade" id="newCategory" tabindex="-56" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Crear Categoria</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="save" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="name" class="control-label mb-1" >Nombre Categoria</label>
                            <input id="name" v-model="name" name="name" required type="text" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="code" class="control-label mb-1" >Codigo:</label>
                            <input id="code" v-model="code" name="code" required type="text" class="form-control">
                        </div>
                        <div>
                            <button id="payment-button" type="submit" class="btn btn-info btn-block">
                                <i class="fa fa-check-square fa-lg"></i>&nbsp;
                                <span id="payment-button-amount">Guardar</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data()
        {
            return{
                name:"",
                code:""
            }
        },
        methods:{
            save()
            {
                if(!this.name || !this.code)
                {
                    toastr.warning("Por favor llenar todos los campos", "Validar");
                    return;
                }

                axios.post("/category", {
                    name:this.name,
                    code:this.code
                })
                .then( (res) => {
                    toastr.success(res.data.message, "Validador");
                    this.name = "";
                    this.code = ""
                    this.$emit('refreshCategory')
                })
                .catch( (err) => {
                    toastr.error(err.response.data.message, "Error Inesperado");
                })
            }
        }
    }
</script>

<style scoped>

</style>