<form action="" method="post" novalidate="novalidate">
    <div class="text-center">
        <h3>Precio a Pagar: <span>@{{ facturatotal }} </span></h3>
    </div>
    <div class="form-group">
        <label for="cc-number" class="control-label mb-1">Tipo de Pago</label>
        <select name="selectSm" id="SelectLm" v-model="campotipop" class="form-control-sm form-control">
            <option value="efectivo">Efectivo</option>
            <option value="tarjeta" >Tarjeta</option>
        </select>
        <span class="help-block" data-valmsg-for="cc-number" data-valmsg-replace="true"></span>
    </div>
    <template v-if="campotipop == 'efectivo'">
        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label for="cc-exp" class="control-label mb-1">Dinero<span style="color: red">*</span></label>
                    <input id="dinero" name="dinero" type="number" class="form-control cc-exp" min="0"  v-model="campodinero" data-val="true" data-val-required="Please enter the card expiration" >
                    <span class="help-block" data-valmsg-for="cc-exp" data-valmsg-replace="true"></span>
                </div>
            </div>
            <div class="col-6">
                <label for="x_card_code" class="control-label mb-1">Devuelta</label>
                <div class="input-group">
                    <input id="devuelta" name="devuelta" disabled :value="devuelta" type="number" class="form-control cc-cvc"  data-val="true" data-val-required="Please enter the security code" >
                </div>
            </div>
        </div>
    </template>
    <template v-else>
        <div class="form-group">
            <label for="cc-number" class="control-label mb-1">Tipo de tarjeta</label>
            <select name="selectSm" id="SelectLm" v-model="tipotarjeta" class="form-control-sm form-control">
                <option value="">--Selecciona--</option>
                <option value="visa">Visa</option>
                <option value="mastercard">MasteCard</option>
                <option value="americanexpress">AmericanExpress</option>
            </select>
            <span class="help-block" data-valmsg-for="cc-number" data-valmsg-replace="true"></span>
        </div>
        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label for="numtarjeta" class="control-label mb-1">Num.Tarjeta <span style="color: red">*</span></label>
                    <input id="numtarjeta" name="numtarjeta" type="text" class="form-control cc-exp" maxlength="20"  v-model="Numtarjeta" data-val="true" data-val-required="Please enter the card expiration" >
                    <span class="help-block" data-valmsg-for="cc-exp" data-valmsg-replace="true"></span>
                </div>
            </div>
            <div class="col-6">
                <label for="auth" class="control-label mb-1">Auth<span style="color: red">*</span></label>
                <div class="input-group">
                    <input id="auth" name="auth" v-model="auth" maxlength="20" type="text" class="form-control cc-cvc"  data-val="true" data-val-required="Please enter the security code" >
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="banco" class="control-label mb-1">Banco<span style="color: red">*</span></label>
            <input id="banco" name="banco" v-model="banco" type="text" required class="input-sm form-control-sm form-control" aria-required="true" aria-invalid="false" placeholder="">
        </div>
    </template>

    <div class="form-group">
        <label for="cliente" class="control-label mb-1">Cliente<span style="color: red">*</span></label>
        <input id="cliente" name="cliente" v-model="campocliente" type="text" required class="input-sm form-control-sm form-control" aria-required="true" aria-invalid="false" placeholder="">
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" @click="facturar()" class="btn btn-primary">&nbsp;Pagar</button>
    </div>
</form>