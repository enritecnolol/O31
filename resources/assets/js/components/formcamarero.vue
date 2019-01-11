<template>
    <div class="row">
        <div class="col-md-12">
            <div class="text-center" style="background-color: #4272d7;">
                <h2 style="color: white">Crear Camarero</h2>
            </div>
        </div>
        <div class="col-md-12" style="margin-top: 20px">
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label class="control-label mb-1">Nombre <span style="color: red">*</span></label>
                        <input type="text" v-model="nombre" class="form-control form-control-sm">
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label class="control-label mb-1">Telefono <span style="color: red">*</span></label>
                        <input type="text" v-model="telefono" class="form-control form-control-sm">
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label class="control-label mb-1">Cedula <span style="color: red">*</span></label>
                        <input type="text" v-model="cedula" class="form-control form-control-sm">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label mb-1">Codigo <span style="color: red">*</span></label>
                        <input type="text" v-model="codigo"  maxlength="4" class="form-control form-control-sm"><small>Solo se permite 4 digitos</small>
                    </div>
                </div>
                <div class="col">
                </div>
            </div>
            <div class="row" style="margin-top: 5px">
                <div class="col-md-12">
                    <div class="text-center">
                        <button type="button" class="btn btn-primary btn-sm" @click="guardar" v-if="id == 0"> Guardar </button>
                        <button type="button" class="btn btn-warning btn-sm" @click="editarcamarero" v-else> Editar </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        name:'formcamarero',
        props:['camareros'],
        components:{},
        data(){
            return{
                id:0,
                nombre:'',
                telefono:'',
                cedula:'',
                codigo:'',
            }
        },
        methods:{
            guardar(){
                if (this.nombre =='' || this.telefono=='' || this.cedula=='' || this.codigo =='')
                {
                    toastr.warning('Por favor llenar todos los datos importante', 'Validador');
                }else{
                    var count=0;
                    for (var key in this.camareros)
                    {
                        if (this.camareros[key].codigo == this.codigo)
                        {
                            count++;
                            break;
                        }
                    }

                    if (count ==0)
                    {
                        axios.post('/camareros/store',{
                            nombre:this.nombre,
                            telefono:this.telefono,
                            cedula:this.cedula,
                            codigo:this.codigo
                        })
                            .then( (response) => {
                                toastr.success('Los datos han sido guardado', 'Validador')
                                this.nombre = '';
                                this.telefono = '';
                                this.cedula = '';
                                this.codigo = '';
                                this.$emit('actualizar')
                            })
                            .catch(function (error) {
                                console.log(error);
                            });
                    }else{
                        toastr.warning('Codigo no Disponible', 'Validador')
                    }
                }
            },
            editar(data)
            {
                for (var key in this.camareros)
                {
                    if (this.camareros[key].id == data)
                    {
                        this.nombre = this.camareros[key].nombre;
                        this.telefono = this.camareros[key].telefono;
                        this.cedula = this.camareros[key].cedula;
                        this.codigo = this.camareros[key].codigo;
                        this.id = data;
                    }
                }
            },
            editarcamarero()
            {
                if (this.nombre =='' || this.telefono=='' || this.cedula=='' || this.codigo =='' || this.id == 0)
                {
                    toastr.warning('Por favor llenar todos los datos importante', 'Validador');
                }else{
                    axios.post('/camareros/edit', {
                        id:this.id,
                        nombre:this.nombre,
                        telefono:this.telefono,
                        cedula:this.cedula,
                        codigo:this.codigo
                    })
                        .then( (response) => {
                            this.$emit('actualizar');
                            this.id = 0;
                            this.nombre = '';
                            this.telefono = '';
                            this.cedula = '';
                            this.codigo = '';
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                }
            },
        },
        computed:{
        },
        mounted() {
            this.$eventbus.$on('editarcamarero', (data) => {
                this.editar(data)
            })
        },
        created() {
        }
    }
</script>
<style>

</style>