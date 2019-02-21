<template>
    <div class="row">
        <div class="col-md-6">
            <div class="form-check">
                <input class="form-check-input" type="radio" name="" id="exampleRadios1" value="detallado"  v-model="type" @click="typereport('detallado')">
                <label class="form-check-label" for="exampleRadios1">
                    Reporte Detallado
                </label>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-check">
                <input class="form-check-input" type="radio" name="" id="exampleRadios2" value="resumido" v-model="type" checked @click="typereport('resumido')">
                <label class="form-check-label" for="exampleRadios2">
                    Reporte Resumido
                </label>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        name:'filter-type-report',
        data()
        {
            return{
                type:''
            }
        },
        methods:{
            typereport(tipo)
            {
                this.$emit('typereport', {type:tipo})
            }
        },
        computed:{

        }
    }
</script>
<style>

</style>