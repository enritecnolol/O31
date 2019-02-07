<template>
    <tr @dblclick="estoyeditando">
        <template v-if="editar === true">
            <th scope="row"><input type="text" style="width: 100px" v-model="item.serie"  class="form-control form-control-sm" placeholder="A|B|C"></th>
            <td>
                <select class="form-control form-control-sm" v-model="item.tipo_nfc">
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
            <td><input type="text" v-model="item.secuencia_inicial"  class="form-control form-control-sm" :class="{ 'incorrecto' : validacion_desde_hasta}" placeholder=""></td>
            <td><input type="text" v-model="item.secuencia_final" class="form-control form-control-sm" :class="{ 'incorrecto' : validacion_desde_hasta}" placeholder=""></td>
            <!--<td><input type="text" v-model="item.actual"  class="form-control form-control-sm"  :class="{ 'incorrecto' : validacion_aviso_hasta}" placeholder=""></td>-->
            <td>{{item.actual}}</td>
            <td><input type="text" v-model="item.aviso"  class="form-control form-control-sm" :class="{ 'incorrecto' : validacion_actual_hasta}" placeholder=""></td>
        </template>
        <template v-else>
            <th>{{item.serie}}</th>
            <td>{{tnfc(item.tipo_nfc)}}</td>
            <td>{{item.secuencia_inicial}}</td>
            <td>{{item.secuencia_final}}</td>
            <td>{{item.actual}}</td>
            <td>{{item.aviso}}</td>
        </template>
    </tr>
</template>
<script>
    export default {
        name:'itemtableedit',
        props:['item', 'index'],
        components:{},
        data()
        {
            return{
                editar:false
            }
        },
        methods:{
            tnfc(nfc)
            {
                if (nfc === '01')
                {
                    return '01 | Credito Fiscal';
                }
                if (nfc === '02')
                {
                    return '02 | Facturas de Consumo';
                }
                if (nfc === '03')
                {
                    return '03 | Notas de Debito';
                }
                if (nfc === '04')
                {
                    return '04 | Notas de Credito';
                }
                if (nfc === '11')
                {
                    return '11 | Provedores Informales';
                }
                if (nfc === '12')
                {
                    return '12 | Registro Unico de Ingresos';
                }
                if (nfc === '13')
                {
                    return '13 | Registro de Gastos Menores';
                }
                if (nfc === '14')
                {
                    return '14 | Regímenes Especiales de Tributación';
                }
                if (nfc === '15')
                {
                    return '15 | Comprobantes Gubernamentales';
                }

            },
            estoyeditando()
            {
                this.editar = true;
                this.$emit('editando')
            },
            actualizaritem()
            {
                if (!this.item.serie || !this.item.tipo_nfc || !this.item.secuencia_inicial || !this.item.secuencia_final || !this.item.actual || !this.item.aviso){
                    toastr.warning("Revisar algunos campos que estan vacios! ");
                    return;
                }
                axios.post('/comprobantes/edit/detail/sequence', {
                    detail:this.item
                })
                    .then( (response) => {
                        this.editar = false;
                        console.log(response);
                    })
                    .catch( (error) => {
                        toastr.error('Se produjo un error');
                        console.log(error);
                    });
            }
        },
        computed:{
            validacion_desde_hasta()
            {
                if (parseInt(this.item.secuencia_inicial) > parseInt(this.item.secuencia_final))
                {
                    return true;
                }else{
                    return false;
                }
            },
            validacion_aviso_hasta()
            {
                if (parseInt(this.item.aviso) > parseInt(this.item.secuencia_final))
                {
                    return true;
                }else{
                    return false;
                }
            },
            validacion_actual_hasta()
            {
                if (parseInt(this.item.actual) > parseInt(this.item.secuencia_final))
                {
                    return true;
                }else{
                    return false;
                }
            }
        },
        mounted() {
            this.$eventbus.$on('actualizartablaitem', () => this.actualizaritem());
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