<template>
    <div class="container" style="margin-top: -35px">
        <div class="card">
            <div class="card-body">
                <div class="tittle-comprobante">
                    <div class="text-center">
                        <h5>Secuencia de comprobantes</h5>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <form>
                            <div class="form-group">
                                <button type="button" class="btn btn-dark" @click="allcodigos">Codigos <i class="fa fa-book"></i></button>
                            </div>

                            <modal name="codigos" :draggable="true">
                               <div class="" style="height: 300px; overflow-y: auto">
                                   <div class="table-responsive">
                                       <table class="table">
                                           <thead>
                                           <tr>
                                               <th scope="col">#</th>
                                               <th scope="col">Fecha Emision</th>
                                               <th scope="col">Fecha Vecimiento</th>
                                               <th></th>
                                           </tr>
                                           </thead>
                                           <tbody>
                                           <template v-for="(item, index) in codigos">
                                               <tr>
                                                   <th scope="row">{{item.id}}</th>
                                                   <td>{{item.fechaemision}}</td>
                                                   <td>{{item.fechavencimiento}}</td>
                                                   <td> <u @click="datasolicitud(item.id, index)"> Seleccionar </u> </td>
                                               </tr>
                                           </template>
                                           </tbody>
                                       </table>
                                   </div>
                               </div>
                            </modal>


                            <div class="form-group">
                                <label>Fecha Emision</label>
                                <datepicker v-model="fechaemision" class="form-control form-control-sm" :format="customFormatter" name="fechaemision"></datepicker>
                            </div>
                            <div class="form-group">
                                <label>Fecha vencimiento</label>
                                <datepicker v-model="fechavencimiento" class="form-control form-control-sm" :format="customFormatter" name="fechavencimiento"></datepicker>
                            </div>
                            <!--<div class="form-group">-->
                                <!--<label>Serie</label>-->
                                <!--<input type="text" v-model="serie" class="form-control form-control-sm" placeholder="A|B|C">-->
                            <!--</div>-->
                        </form>
                    </div>
                    <div class="col-md-12">
                        <div class="text-right">
                            <button type="button" class="btn btn-sm btn-primary" :disabled="!fechavencimiento || !fechaemision" @click="columnatabla('plus')"><i class="fa fa-plus"></i></button>
                            <button type="button" class="btn btn-sm btn-primary" :disabled="!fechavencimiento || !fechaemision"  @click="columnatabla('minus')"><i class="fa fa-minus"></i></button>
                        </div>
                        <br>
                    </div>
                    <div class="col-md-12">
                        <tablasecuencia :fechaemision="fechaemision" @saved="saved" :fechavencimiento="fechavencimiento" :id="id" @buttonedit="buttonedit" :tabladatos="tabladatos"></tablasecuencia>
                        <hr>
                    </div>
                    <div class="col-md-12">
                        <div class="text-center">
                            <button type="button" v-if="editar != true" class="btn btn-primary btn-sm" @click="guardar" :disabled="!fechavencimiento || !fechaemision"><i class="fa fa-save"></i> Guardar</button>
                            <button type="button" v-else class="btn btn-warning btn-sm" @click="editaritems" :disabled="!fechavencimiento || !fechaemision"><i class="fa fa-edit"></i> Editar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import Datepicker from 'vuejs-datepicker';
    import tablasecuencia from './tabla';
    import VModal from 'vue-js-modal';
    Vue.use(VModal);
    export default {
        name:"panelcomprobante",
        components:{
            Datepicker,
            tablasecuencia
        },
        data()
        {
            return {
                id:0,
                fechaemision:'',
                fechavencimiento:'',
                codigo:'',
                codigos:[],
                tabladatos:[],
                editar:false
            }
        },
        methods:{
            editaritems()
            {
              this.$eventbus.$emit('actualizartabla')
            },
            buttonedit()
            {
              this.editar = true;
            },
            saved()
            {
                this.fechaemision = '';
                this.fechavencimiento = '';
                this.tabladatos = '';
            },
            datasolicitud(i, index)
            {
                axios.post('/comprobantes/find/header/details', {id:i})
                    .then( (response) => {
                        this.tabladatos = response.data;
                    })
                    .catch( (error) => {
                        console.log(error);
                    });
                this.fechaemision = this.codigos[index].fechaemision;
                this.fechavencimiento = this.codigos[index].fechavencimiento;
                this.id = i;
            },
            allcodigos()
            {
                axios.post('/comprobantes/all/header')
                    .then( (response) => {
                        this.codigos = response.data;
                        this.show();
                    })
                    .catch( (error) => {
                        console.log(error);
                    });
            },
            show () {
                this.$modal.show('codigos');
            },
            hide () {
                this.$modal.hide('codigos');
            },
            customFormatter(date) {
                return moment(date).format('D MMMM  YYYY');
            },
            columnatabla(accion)
            {
                this.$eventbus.$emit('columnatabla', {accion:accion})
            },
            guardar()
            {
                if (new Date(this.fechavencimiento).getTime() < new Date(this.fechaemision).getTime())
                {
                    toastr.warning("Por favor revisar las fechas ingresadas");
                    return;
                }
                this.$eventbus.$emit('passdata')
            },

        },
        computed:{

        },
        created() {

        }
    }
</script>
<style>
    .tittle-comprobante{

    }
    u:hover{
        color: dodgerblue;
        cursor: pointer;
    }
</style>