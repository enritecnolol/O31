<template>
    <div class="table-responsive" style="height: 400px">
        <table class="table">
            <thead>
            <tr>
                <th scope="col">Serie</th>
                <th scope="col">Tipo NCF</th>
                <th scope="col">Desde</th>
                <th scope="col">Hasta</th>
                <th scope="col">Actual</th>
                <th scope="col">Aviso</th>
            </tr>
            </thead>
            <tbody>
            <template v-for="(item, index) in detalle_secuencia">
                <itemtable :fechaemision="fechaemision" @changeitem="changeitem" :fechavencimiento="fechavencimiento" :detalle="item" :key="index" :index="index"></itemtable>
            </template>
           <template v-for="(item, key) in tabladatos">
               <itemedit :item="item" :index="key" @editando="editando"></itemedit>
           </template>
            </tbody>
        </table>
    </div>
</template>
<script>
    import itemtable from './itemtable';
    import Datepicker from 'vuejs-datepicker';
    import itemedit from './itemtableedit';
    export default {
        name:"tablasecuencia",
        components:{
            Datepicker,
            itemtable,
            itemedit
        },
        data()
        {
            return {
                detalle_secuencia:[{
                    serie:'',
                    tipo_ncf:'',
                    desde:'',
                    hasta:'',
                    aviso:'',
                    actual:''
                }],
            }
        },
        props:['fechaemision', 'fechavencimiento', 'tabladatos', 'id'],
        methods:{
            editando()
            {
                this.$emit('buttonedit');
            },
            customFormatter(date) {
                return moment(date).format('YYYY-MM-DD');
            },
            columnatable(accion)
            {
                if (accion.accion === 'plus') {
                    this.detalle_secuencia.push({
                        serie:'',
                        tipo_ncf:'',
                        desde:'',
                        hasta:'',
                        aviso:'',
                        actual:''
                    });
                }
            },
            changeitem(i){
                this.detalle_secuencia.splice(i.index, 1, i.datos);
            },
            savedata()
            {
                var valid =0;
                for (var key in this.detalle_secuencia)
                {
                    if  (this.detalle_secuencia[key].serie === "" ||
                        this.detalle_secuencia[key].tipo_ncf === "" ||
                        this.detalle_secuencia[key].desde === "" ||
                        this.detalle_secuencia[key].hasta === "" ||
                        this.detalle_secuencia[key].aviso === "" ||
                        this.detalle_secuencia[key].actual === "")
                    {
                        valid++;
                        return;
                    }
                }
                if (valid === 0)
                {
                    axios.post('/comprobantes/store', {
                        id:this.id,
                        fecha_emision: this.customFormatter(this.fechaemision),
                        fecha_vecimiento: this.customFormatter(this.fechavencimiento),
                        details: this.detalle_secuencia
                    })
                        .then( (response) => {
                            toastr.success("datos Guardados");
                            this.detalle_secuencia = [];
                            this.$emit('saved');
                            console.log(response);
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                }else{
                    toastr.warning("Por favor revisar los datos", "Validador")
                }
            },
            passdata()
            {
                this.$eventbus.$emit('itemdata')
            },
            actualizaritem()
            {
                this.$eventbus.$emit('actualizartablaitem');
            }
        },
        computed:{

        },
        mounted() {
            this.$eventbus.$on('columnatabla', (accion) => {this.columnatable(accion);})
            this.$eventbus.$on('actualizartabla', () => {this.actualizaritem();})
            this.$eventbus.$on('passdata', () => {this.passdata(); setTimeout(this.savedata(), 1000)});
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