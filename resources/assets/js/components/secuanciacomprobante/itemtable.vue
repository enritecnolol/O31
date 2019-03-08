<template>
    <tr>
        <th scope="row"><input type="text" style="width: 100px" v-model="serie" :disabled="!fechavencimiento || !fechaemision" class="form-control form-control-sm" placeholder="A|B|C"></th>
        <td>
            <select class="form-control form-control-sm" :disabled="!fechavencimiento || !fechaemision" v-model="tiponfc">
                <option selected value="">Selecionar</option>
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
        </td>
        <td>
            <input type="text" v-model="desde" :disabled="!fechavencimiento || !fechaemision" class="form-control form-control-sm" :class="{ 'incorrecto' : validacion_desde_hasta}" placeholder="">
        </td>
        <td><input type="text" v-model="hasta" :disabled="!fechavencimiento || !fechaemision" class="form-control form-control-sm" :class="{ 'incorrecto' : validacion_desde_hasta}" placeholder=""></td>
        <td><input type="text" v-model="aviso" :disabled="!fechavencimiento || !fechaemision" class="form-control form-control-sm"  :class="{ 'incorrecto' : validacion_aviso_hasta}" placeholder=""></td>
        <td><input type="text" v-model="actual" :disabled="!fechavencimiento || !fechaemision" class="form-control form-control-sm" :class="{ 'incorrecto' : validacion_actual_hasta}" placeholder=""></td>
    </tr>
</template>
<script>
export default {
    name:'itemtable',
    components:{},
    props:['fechaemision', 'fechavencimiento', 'detalle', 'index'],
    data()
    {
        return{
            hasta:'',
            desde:'',
            aviso:'',
            actual:'',
            serie:'',
            tiponfc:'',
        }
    },
    methods:{
        cambiar(){
            if (!this.serie || !this.tiponfc || !this.desde || !this.hasta || !this.aviso || !this.actual){
                return;
            }
            if (parseInt(this.desde) > parseInt(this.hasta))
            {
                return;
            }
            if (parseInt(this.aviso) > parseInt(this.hasta))
            {
                toastr.warning("Revisar la cantidad ingresada en el campo Aviso!");
                return;
            }
            if (parseInt(this.actual) > parseInt(this.hasta))
            {
                toastr.warning("Revisar la cantidad ingresada en el campo Actual!");
                return;
            }
            this.$emit('changeitem',
                {
                    index:this.index,
                    datos:{
                        serie:this.serie,
                        tipo_nfc:this.tiponfc,
                        secuencia_inicial:this.desde,
                        secuencia_final:this.hasta,
                        aviso:this.aviso,
                        actual:this.actual
                    }
                });

        }
    },
    computed:{
        validacion_desde_hasta()
        {
            if (parseInt(this.desde) > parseInt(this.hasta))
            {
                return true;
            }else{
                return false;
            }
        },
        validacion_aviso_hasta()
        {
            if (parseInt(this.aviso) > parseInt(this.hasta))
            {
                return true;
            }else{
                return false;
            }
        },
        validacion_actual_hasta()
        {
            if (parseInt(this.actual) > parseInt(this.hasta))
            {
                return true;
            }else{
                return false;
            }
        }
    },
    mounted() {
        this.$eventbus.$on('itemdata', ()=>{this.cambiar()})
    }
}
</script>
<style scoped>
    .incorrecto{
        border: 1px solid red;
    }
    tr:hover{
        background: rgba(159,159,176,0.25);
    }
</style>