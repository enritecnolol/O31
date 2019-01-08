<template>
    <div>
        <modal name="modalcarritopagar" :clickToClose="false" :width="800" :height="600">
            <div class="modal-header">
                <h5 class="modal-title">Pagar Orden</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="text-center" style="margin-bottom: 20px">
                    <h3 style="font-size: 50px">A PAGAR $: <span style="font-size: 50px; color: red">00.00</span></h3>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label class="control-label mb-1">Efectivo<span style="color: red">*</span></label>
                            <input id="efectivom" name="dinero" v-model="efectivo" autofocus required type="number" class="form-control cc-exp" >
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="control-label mb-1">Billetes<span style="color: red"></span></label>
                            <br>
                            <button type="button" class="btn btn-secondary">$50</button>
                            <button type="button" class="btn btn-secondary">$100</button>
                            <button type="button" class="btn btn-secondary">$200</button>
                            <button type="button" class="btn btn-secondary">$500</button>
                            <button type="button" class="btn btn-secondary">$1000</button>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label class="control-label mb-1">Tarjeta<span style="color: red">*</span></label>
                            <input id="tarjetam" name="dinero" required v-model="tarjeta" type="number" class="form-control cc-exp">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="control-label mb-1">Billetes<span style="color: red"></span></label>
                            <br>
                            <button type="button" class="btn btn-secondary" >$2000</button>
                            <button type="button" class="btn btn-secondary">$25</button>
                            <button type="button" class="btn btn-secondary">$10</button>
                            <button type="button" class="btn btn-secondary">$5</button>
                            <button type="button" class="btn btn-secondary">$1</button>
                            <button type="button" class="btn btn-secondary">$0</button>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="" class="control-label mb-1">Tipo de tarjeta</label>
                            <select name="selectSm"  v-model="tipotarjeta" id="SelectLm" class="form-control-sm form-control">
                                <option value="">--Selecciona--</option>
                                <option value="visa">Visa</option>
                                <option value="mastercard">MasteCard</option>
                                <option value="americanexpress">AmericanExpress</option>
                            </select>
                            <span class="help-block" data-valmsg-for="cc-number" data-valmsg-replace="true"></span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="banco" class="control-label mb-1">Banco</label>
                            <input id="banco" name="banco" v-model="banco" class="form-control cc-exp" type="text">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="numtarjeta" class="control-label mb-1">Num.Tarjeta <span style="color: red">*</span></label>
                            <input id="numtarjeta"  name="numtarjeta" v-model="numerotarjeta" type="text" class="form-control cc-exp" maxlength="16" data-val="true" data-val-required="Please enter the card expiration" >
                            <span class="help-block" data-valmsg-for="cc-exp" data-valmsg-replace="true"></span>
                        </div>
                    </div>
                    <div class="col-6">
                        <label for="auth" class="control-label mb-1">Autorización<span style="color: red">*</span></label>
                        <div class="input-group">
                            <input id="auth" name="auth" maxlength="20" v-model="autorizacion" type="text" class="form-control cc-cvc">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="" style="position: absolute; left: 50px">
                    <h4>Devuelta:<span style="font-size: 25px"></span></h4>
                </div>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button"  class="btn btn-primary" >&nbsp;Pagar</button>
            </div>
        </modal>
    </div>
</template>
<script>
    import vmodal from 'vue-js-modal';
    Vue.use(vmodal);
    export default {
        name:'modalpago',
        components:{vmodal},
        props:['abrir'],
        data()
        {
            return{
                efectivo:0,
                tarjeta:0,
                tipotarjeta:'',
                banco:'',
                numerotarjeta:'',
                autorizacion:'',
            }
        },
        methods:{

        },
        computed:{

        },
        mounted() {
            if (this.abrir == true)
            {
                this.$modal.show('modalcarritopagar', {});
            }
        },
        created() {
        }
    }
</script>
<style>

</style>