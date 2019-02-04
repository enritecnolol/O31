<template>
    <div class="container">
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
                                <label>Fecha Emision</label>
                                <datepicker v-model="fechaemision" class="form-control form-control-sm" name="fechaemision"></datepicker>
                            </div>
                            <div class="form-group">
                                <label>Fecha vencimiento</label>
                                <datepicker v-model="fechavencimiento" class="form-control form-control-sm" name="fechavencimiento"></datepicker>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-12">
                        <tablasecuencia></tablasecuencia>
                        <hr>
                    </div>
                    <div class="col-md-12">
                        <div class="text-center">
                            <button type="button" class="btn btn-primary btn-sm">Guardar</button>
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
    export default {
        name:"panelcomprobante",
        components:{
            Datepicker,
            tablasecuencia
        },
        data()
        {
            return {
                fechaemision:'',
                fechavencimiento:'',
            }
        },
        methods:{

        },
        computed:{

        }
    }
</script>
<style>
    .tittle-comprobante{

    }
</style>