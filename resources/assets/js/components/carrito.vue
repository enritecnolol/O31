<template>
    <div class="row">
        <div class="col-md-12">
            <div class="row-horizon">
                <template v-for="(item, index) in mesasocupadas">
                    <span class="categorias" style="margin-left: 2px;cursor: pointer" :class="{selectcategories : item.active}" @click="buscarordenmesa(item.id, index)">{{item.mesa.name}}</span>
                </template>
            </div>
        </div>
        <div class="col-md-12" style="margin-top: 10px">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="pull-left">
                            <div class="text-center">
                                <!--<h4>Elegir Cliente</h4>-->
                                <h4>Clientes</h4>
                            </div>
                        </div>
                        <div class="pull-right" style="">
                            <div class="row">
                                <div class="col">
                                    <!--<i class="fas fa-angle-left" style="cursor: pointer;" @click="invitado('menos')"></i>-->
                                </div>
                                <div class="col-">
                                    <!--<div class="text-center"><h5> {{invitadoturno}} - {{invitadott}}</h5></div>-->
                                    <div class="text-center">
                                        <div class="row">
                                            <div class="col"><i class="fas fa-1x fa-users"></i></div>
                                            <div class="col"> <h3 style="float: right">{{invitado}}</h3></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <!--<i class="fas fa-angle-right" style="cursor: pointer" @click="invitado('mas')"></i>-->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12" style="margin-top: 15px">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-5 table-header">
                                    <h5>Productos</h5>
                                </div>
                                <div class="col-md-2 table-header">
                                    <h5>Precio</h5>
                                </div>
                                <div class="col-md-3 table-header">
                                    <h5>Cantidad</h5>
                                </div>
                                <div class="col-md-2 table-header">
                                    <h5>Total</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12" style="height: 530px;overflow-y:auto;background: url('../../../../local/fondo6.png')" id="listacarrito">
                        <template v-if="productoselecionado.length == 0">
                            <div class="messageVide" style="margin-top: 15px">
                                NO HAY PRODUCTOS
                                <span>(Seleccionar Producto)</span>
                            </div>
                        </template>
                        <template v-for="(item, index) in productoselecionado">
                            <itemcarrito @cambiarcantidad="cambiarcantidad" :index="index" :productoselecionado="item"></itemcarrito>
                        </template>
                    </div>
                    <div class="col-md-12" style="background: white">
                        <div class="table-responsive col-sm-12 totalTab">
                            <table class="table table-sm">
                                <tbody>
                                <tr>
                                    <td class="active" width="40%">
                                        SubTotal
                                    </td>
                                    <td class="whiteBg" width="60%">
                                        <span id="Subtot">
                                            {{ bruto }}
                                        </span>
                                        RD
                                        <span class="float-right">
                                            <b id="ItemsNum">
                                                <span>{{ cantidaditems }}
                                                </span> articulos
                                            </b>
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="active">Impuesto IVA</td>
                                    <td class="whiteBg">
                                        <!--<input type="text" value="" class="total-input" placeholder="N/A" maxlength="8" aria-haspopup="true" role="textbox">-->
                                        <b>{{ impuesto }} RD</b>
                                        <span class="float-right">
                                            <b>%</b>
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="active">Descuento</td>
                                    <td class="whiteBg">
                                        <input type="text" value="0" v-model="descuento" class="total-input" placeholder="N/A" maxlength="8" aria-haspopup="true" role="textbox">
                                        <span class="float-right">
                                            <b id="RemiseValue">
                                                {{ descuent }} RD
                                            </b>
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="active">Total</td>
                                    <td class="whiteBg light-blue text-bold">
                                        <span id="total">
                                            {{ total }}
                                        </span>
                                        RD
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-12" style="margin-top: 10px">
                        <div class="row">
                            <div class="col"><button type="button" class="btn btn-danger btn-lg btn-block " @click="cancelarorden"><i class="fas fa-times-circle"></i> Cancelar</button></div>
                            <div class="col"><button type="button" class="btn btn-primary btn-lg btn-block" @click="ordenar"><i class="fas fa-clipboard-list"></i> Ordenar</button></div>
                            <div class="col" v-if="detalle.orden"><button type="button" class="btn btn-success btn-lg btn-block" @click="pagarorden()"><i class="fas fa-money-bill-alt"></i> Pagar</button></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <modal name="modalcarritopagar" :clickToClose="false" :width="800" :height="600">
            <div class="modal-header">
                <h5 class="modal-title">Pagar Orden</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="cerrarmodal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="text-center" style="margin-bottom: 20px">
                    <h3 style="font-size: 50px">A PAGAR $: <span style="font-size: 50px; color: red">{{ total }}</span></h3>
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
                            <button type="button" class="btn btn-secondary" @click="efectivo = parseFloat(50) + parseFloat(efectivo)">$50</button>
                            <button type="button" class="btn btn-secondary" @click="efectivo = parseFloat(100) + parseFloat(efectivo)">$100</button>
                            <button type="button" class="btn btn-secondary" @click="efectivo = parseFloat(200) + parseFloat(efectivo)">$200</button>
                            <button type="button" class="btn btn-secondary" @click="efectivo = parseFloat(500) + parseFloat(efectivo)">$500</button>
                            <button type="button" class="btn btn-secondary" @click="efectivo = parseFloat(1000) + parseFloat(efectivo)">$1000</button>
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
                            <button type="button" class="btn btn-secondary"  @click="efectivo = parseFloat(2000) + parseFloat(efectivo)">$2000</button>
                            <button type="button" class="btn btn-secondary" @click="efectivo = parseFloat(25) + parseFloat(efectivo)">$25</button>
                            <button type="button" class="btn btn-secondary" @click="efectivo = parseFloat(10) + parseFloat(efectivo)">$10</button>
                            <button type="button" class="btn btn-secondary" @click="efectivo = parseFloat(5) + parseFloat(efectivo)">$5</button>
                            <button type="button" class="btn btn-secondary" @click="efectivo = parseFloat(1) + parseFloat(efectivo)">$1</button>
                            <button type="button" class="btn btn-secondary" @click="efectivo = parseFloat(0)">$0</button>
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
                    <h4>Devuelta:<span style="font-size: 25px"> {{ devuelta }}</span></h4>
                </div>
                <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="cerrarmodal">Cancelar</button>
                <button type="button"  class="btn btn-primary" :disabled="devuelta<0" @click="pago">&nbsp;Pagar</button>
            </div>
        </modal>

    </div>
</template>

<script>
    import itemcarrito from './itemcarrito'
    import vmodal from 'vue-js-modal';
    import modalpagar from './modalpago'

    Vue.use(vmodal);
    export default {
        name:'carrito',
        props:['mesasocupadas', 'mesa', 'productoselecionado', 'bus', 'detalle'],
        components:{itemcarrito,vmodal,modalpagar},
        data()
        {
            return{
                invitadott:0,
                invitadoturno:1,
                mesav1:this.mesa,
                productos:[],
                productoselecionadov2:this.productoselecionado,
                manejoitbi:'',
                descuento:'0',
                efectivo:0,
                tarjeta:0,
                tipotarjeta:'',
                banco:'',
                numerotarjeta:'',
                autorizacion:'',
                abrir:false
            }
        },
        methods:{
            pago()
            {
                var mesa = '';
                for (var key in this.mesasocupadas)
                {
                    if  (this.mesasocupadas[key].id == this.mesa)
                    {
                        mesa = this.mesasocupadas[key]
                    }
                }
                if (this.tarjeta > 0)
                {
                    if (this.autorizacion == '' || this.numerotarjeta == '' || this.tipotarjeta == '')
                    {
                        toastr.warning('Faltan datos por llenar','Validador')
                    }else if (this.tarjeta > this.total - this.efectivo){
                        toastr.warning('La tarjeta no puede ser mayor al precio a pagar', 'Validador');
                    }else{
                        axios.post('/orden/facturar', {
                            existencias: this.existenciarep,
                            devuelta:this.devuelta,
                            preciop:this.total,
                            banco:this.banco,
                            auth: this.autorizacion,
                            bruto:this.bruto,
                            itbis:this.impuesto,
                            neto:this.total,
                            descuento:this.descuent,
                            tipotarjeta: this.tipotarjeta,
                            Numtarjeta: this.numerotarjeta,
                            montotarjeta:this.tarjeta,
                            dinero:this.efectivo,
                            detalle: this.productoselecionado,
                            mesa:mesa
                        })
                            .then((response) => {
                                toastr.success('Venta procesada', 'Validador')
                                this.cerrarmodal();
                            })
                            .catch(function (error) {
                                console.log(error);
                            });
                    }
                }else{
                    axios.post('/orden/facturar', {
                        existencias: this.existenciarep,
                        devuelta:this.devuelta,
                        preciop:this.total,
                        banco:this.banco,
                        auth: this.autorizacion,
                        bruto:this.bruto,
                        itbis:this.impuesto,
                        neto:this.total,
                        descuento:this.descuent,
                        tipotarjeta: this.tipotarjeta,
                        Numtarjeta: this.numerotarjeta,
                        montotarjeta:this.tarjeta,
                        dinero:this.efectivo,
                        detalle: this.productoselecionado,
                        mesa:this.mesa
                    })
                        .then( (response) => {
                            toastr.success('Venta procesada', 'Validador');
                            this.cerrarmodal();

                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                }
            },
            pagarorden(e)
            {
                // console.log('modal');
                this.$modal.show('modalcarritopagar');
            },
            cerrarmodal()
            {
                this.$modal.hide('modalcarritopagar');
                this.$emit('volverpant');
            },
            cancelarorden()
            {
                var txt;
                var r = confirm("Estas Seguro que quieres cancelar la Orden? 😀");
                if (r == true){
                    axios.post('/orden/cancelar/orden', {
                        mesa:this.mesa
                    })
                        .then( (response) => {
                            console.log(response);
                            toastr.success('La orden se ha sido Cancelada')
                            this.$emit('volverpant')
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                }
            },
            manejoitbis()
            {
                axios.post('/configuracion/manejo/itbis')
                    .then((response) => {
                        this.manejoitbi = response.data
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            buscarordenmesa(i, index)
            {
                this.$emit('productopormesa',
                    {
                        index:index,
                        id:i
                    })
            },
            buscarordenmesa2(i)
            {
                for (var key in this.mesasocupadas)
                {
                    if (this.mesasocupadas[key].id == this.mesa)
                    {
                        this.$emit('productopormesa',
                            {
                                index:key,
                                id:this.mesasocupadas[key].id
                            });
                        break;
                    }
                }
            },
            cambiarcantidad(i)
            {
                this.$emit('cambiarcantidad', {obt:i,subtotal:this.subtotal})
            },
            bajarscroll()
            {
                $("#listacarrito").animate({scrollTop:$('#listacarrito').prop("scrollHeight")},420);
            },
            ordenar()
            {
                if (this.subtotal != 0)
                {
                    axios.post('/ordenar/mesa/store', {
                        productos:this.productoselecionado,
                        mesa:this.mesa,
                        invitados:this.invitadott,
                        subtotal:this.subtotal
                    })
                        .then((response) => {
                            toastr.success('La orden se ha realizado','Validador')
                            this.$emit('volverpant')
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                }else {
                    toastr.warning('Por Favor Seleccionar los productos', 'Validador')
                }
            },
            productselec()
            {
                var count=0;
                for (var key in this.productoselecionado)
                {
                    console.log(!empty(this.productoselecionado[key].orden));
                    if (!empty(this.productoselecionado[key].orden))
                    {
                        count++
                    }
                }
                return count;
            }

        },
        computed:{
            devuelta()
            {
                if (this.efectivo == '')
                {
                    this.efectivo = 0;
                }
                if (this.tarjeta == '')
                {
                    this.tarjeta = 0;
                }
                var devuelta = 0;
                var suma = parseInt(this.efectivo) + parseInt(this.tarjeta)
                devuelta = parseInt(suma) - parseInt(this.total);
                return parseFloat(devuelta).toFixed(2);
            },
            cantidaditems()
            {
                return this.productoselecionado.length;
            },
            subtotal()
            {
                var suma = 0;
                for (var key in this.productoselecionado)
                {
                    suma = parseFloat(parseFloat(suma) + parseFloat(this.productoselecionado[key].total))
                }
                return parseFloat(suma).toFixed(2);
            },
            bruto()
            {
                var total = 0;
                if (this.manejoitbi == 'incluido')
                {
                    for (var key in this.productoselecionado)
                    {
                        var producto = this.productoselecionado[key].producto;
                        if (producto.itbis == 'si')
                        {
                            var bruto = this.productoselecionado[key].total / parseFloat('1.'+producto.porciento);
                            total = bruto + total;
                        }else{
                            total = parseFloat(this.productoselecionado[key].total) + total
                        }
                    }
                }else{
                    for (var key in this.productoselecionado)
                    {
                        var producto = this.productoselecionado[key].producto;
                        if (producto.itbis == 'si')
                        {
                            var bruto = this.productoselecionado[key].total;
                            total = bruto + total;
                        }else{
                            total = parseFloat(this.productoselecionado[key].total) + total
                        }
                    }
                }
                return parseFloat(total).toFixed(2);
            },
            impuesto()
            {
                var total = 0;
                if (this.manejoitbi == 'incluido')
                {
                    for (var key in this.productoselecionado)
                    {
                        var id = this.productoselecionado[key].producto.id;
                        var producto = this.productoselecionado[key].producto;

                        if (producto.itbis == 'si')
                        {
                            var bruto = parseFloat(this.productoselecionado[key].total) / parseFloat('1.'+producto.porciento)
                            var itbis = bruto * parseFloat('0.'+producto.porciento)
                            total = itbis + total;
                        }
                    }
                }else{
                    for (var key in this.productoselecionado)
                    {
                        var id = this.productoselecionado[key].producto.id;
                        var producto = this.productoselecionado[key].producto;

                        if (producto.itbis == 'si')
                        {
                            // var bruto = parseFloat(this.productoselecionado[key].total) * parseFloat('1.'+producto.porciento)
                            var itbis = parseFloat(this.productoselecionado[key].total) * parseFloat('0.'+producto.porciento)
                            total = itbis + total;
                        }
                    }
                }
                return parseFloat(total).toFixed(2);
            },
            invitado()
            {
                for (var key in this.mesasocupadas){

                    if (this.mesasocupadas[key].id == this.mesa)
                    {
                        this.invitadott = this.mesasocupadas[key].personas;
                    }
                }
                return this.invitadott
            },
            descuent()
            {
                if (this.descuento == '')
                {
                    this.descuento = '0';
                }
                var paso1 = parseFloat(this.descuento)/100;
                var paso2 = parseFloat(this.totalsuma) * parseFloat(paso1);
                return parseFloat(paso2).toFixed(2)
            },
            totalsuma()
            {
                var suma = 0;
                suma = parseFloat(this.bruto) + parseFloat(this.impuesto);

                return parseFloat(suma).toFixed(2)
            },
            total()
            {
                var resta = 0;
                resta = parseFloat(this.totalsuma) - this.descuent;
                return parseFloat(resta).toFixed(2)
            },
        },
        watch:{

        },
        mounted() {
            this.manejoitbis();
            this.bus.$on('bajar', this.bajarscroll);
        },
        created() {
            this.$eventbus.$on('pagarorden2', this.pagarorden('e'));
            this.$eventbus.$on('ejecutarmesa', this.buscarordenmesa2());
        }
    }
</script>
<style>
    .table-header h3{
        font-weight: 700;
        font-size: 1.1em;
        margin: 20px 0;
        text-align: center;
        text-transform: uppercase;
    }
    .product-details {
        border: none !important;
        margin-bottom: 3px !important;
        color: #81909a !important;
    }
    .nopadding {
        padding: 0 !important;
        margin: 0 !important;
    }
    .panel{
        margin-bottom:20px;
        background-color:#fff;
        border:1px solid transparent;
        border-radius:4px;
        -webkit-box-shadow:0 1px 1px rgba(0,0,0,.05);
        box-shadow:0 1px 1px rgba(0,0,0,.05);
    }
    .panel-default {
        border-color: #ddd;
    }
    .panel-body {
        padding: 15px;
    }
    .product-details{
        border: none;
        margin-bottom: 3px;
        color: #81909a;
    }

    .product-details input[type="text"]{
        width: 2.1em;
        padding: 3px;
        display: inline;
        text-align: center;
        height: 1.8em;
    }

    .delete-product{
        color: #f65e48;
        margin-top: 1px;
    }

    .textPD{
        margin-top: 5px;
        float: left;
    }

    .subtotal{
        float: right;
    }
    .Hold {
        cursor: pointer;
        text-align: center;
        margin: 5px 1px;
        padding: 2px 13px;
        background-color: #E2E2E2;
        border-radius: 3px;
        color: #6B6B6B;
        text-transform: uppercase;
        font-size: 20px;
        display: inline-block;
        font-weight: 600;
        padding-bottom: 7px;
        border-bottom: 3px solid #6EC89B;
    }
    .total-input {
        border: none;
        outline: none;
    }
    .whiteBg {
        background-color: #fff;
    }
    .text-bold {
        font-weight: 700;
    }

    .light-blue {
        color: #1abc9c;
    }
    .messageVide {
        font-size: 30px;
        width: 100%;
        background-color: white;
        padding: 1.5em 0;
        border-radius: 5px;
        font-weight: lighter;
        display: inline-block;
        text-align: center;
    }

</style>