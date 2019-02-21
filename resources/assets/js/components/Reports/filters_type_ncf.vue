<template>
    <div class="col">
        <div class="card border-primary mb-3" style="max-width: 100%;">
            <div class="card-body text-primary">
                <h5 class="card-title">Tipo de NCF</h5>
                <hr style=" background:#007bff;">
                <p class="card-text">
                    <select class="form-control form-control-sm" v-model="nfc" @change="ncf_select">
                        <option selected value="">Selecionar</option>
                        <option value="all">General</option>
                        <option value="01">01 | Credito Fiscal</option>
                        <option value="02">02 | Facturas de Consumo</option>
                        <option value="03">03 | Notas de Debito</option>
                        <option value="04">04 | Notas de Credito</option>
                        <option value="11">11 | Provedores Informales</option>
                        <option value="12">12 | Registro Unico de Ingresos</option>
                        <option value="13">13 | Registro de Gastos Menores</option>
                        <option value="14">14 | Regímenes Especiales de Tributación</option>
                        <option value="15">15 | Comprobantes Gubernamentales</option>
                    </select>
                </p>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        name:'filters_ncf',
        data(){
            return{
                nfc:''
            }
        },
        methods:{
            ncf_select()
            {
                this.$emit("nfc_select", {ncf:this.nfc})
            }
        },
        computed:{

        }

    }
</script>
<style>

</style>