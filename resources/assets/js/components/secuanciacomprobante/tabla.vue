<template>
    <div class="table-responsive" style="height: 400px">
        <table class="table">
            <thead>
            <tr>
                <th scope="col">Serie</th>
                <th scope="col">Tipo NCF</th>
                <th scope="col">Desde</th>
                <th scope="col">Hasta</th>
                <th scope="col">Aviso</th>
                <th scope="col">Actual</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <th scope="row"><input type="text" style="width: 100px" v-model="serie" class="form-control form-control-sm" placeholder="A|B|C"></th>
                <td>
                    <select class="form-control form-control-sm" v-model="tiponfc">
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
                    <datepicker v-model="desde"
                                 class="form-control form-control-sm animated-placeholder"
                                 :input-class="'inputdate'"
                                 name="fechavencimiento"></datepicker>
                </td>

                <td>
                    <datepicker
                        v-model="hasta"
                        class="form-control form-control-sm"
                        :input-class="'inputdate'"
                        name="fechavencimiento"></datepicker>
                </td>

                <td><input type="text" v-model="aviso" class="form-control form-control-sm" placeholder=""></td>
                <td><input type="text" v-model="actual" class="form-control form-control-sm" placeholder=""></td>
            </tr>
            </tbody>
        </table>
    </div>
</template>
<script>
    import Datepicker from 'vuejs-datepicker';
    export default{
        name:"tablasecuencia",
        components:{
            Datepicker
        },
        data()
        {
            return {
                hasta:'',
                desde:'',
                aviso:'',
                actual:'',
                serie:'',
                tiponfc:'',

            }
        },
        props:[],
        methods:{

        },
        computed:{

        }
    }
</script>
<style>
    .inputdate{
        width: 170px;
    }
    .inputdate:hover{
        border: 1px solid #4d90fe;
    }
</style>