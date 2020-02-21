@extends('main.app')
@section('tittle','SofiaRD | Devolucion de Producto')

@section('titulo')
    <h3 style="color: white"><i class="fas fa-arrow-circle-right"></i> Devolución </h3>
@endsection

@section('aside')
    @include('caja.siderbar')
@endsection

@section('style')
    <style>
        .loader {
            position: fixed;
            left: 0px;
            top: 0px;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background: url("{{URL::asset('loading2.gif')}}") 50% 50% no-repeat rgb(249,249,249);
            opacity: .8;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <div class="loader" v-if="loading"></div>
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body" v-if="confirmacion == false">
                                <div class="row">
                                    <div class="col-md-12" style="margin-bottom: 10px">
                                        <div class="text-center">
                                            <h2>Devolución de productos</h2>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <hr style="background-color: #0062cc">
                                    </div>
                                    <div class="col-md-12" style="margin-bottom: 15px">
                                        <div class="text-center">
                                            <div class="form-group">
                                                <label for="factura"><h4>No.Factura</h4></label>
                                                <input type="text" style="text-align: center" v-model="no_factura" @keypress.enter="datosfactura" class="form-control form-control-sm" id="factura" placeholder="">
                                            </div>
                                            <button class="btn btn-primary" @click="datosfactura">Buscar</button>
                                        </div>
                                    </div>
                                    <div class="col-md-12" v-if="datofactura === 'vacio'">
                                        <div class="row">
                                            <div class="col-md-4" v-for="(item ,index) in invoicesList">
                                                @include('devolucion.cardInvoice')
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12" v-if="datofactura != 'vacio'">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <h5 style="float: left">No.factura</h5>
                                                <h5 style="float: right">@{{ datofactura.id }}</h5>
                                            </div>
                                            <div class="col-md-4">
                                                <h5 style="float: left">Fecha</h5>
                                                <h5 style="float: right">@{{ datofactura.date }}</h5>
                                            </div>
                                            <div class="col-md-4">
                                                <h5 style="float: left">Cliente</h5>
                                                <h5 style="float: right">@{{ nombrecliente(datofactura.client) }} @{{ clientenombre }}</h5>
                                            </div>
                                            <div class="col-md-4">
                                                <h5 style="float: left">Bruto</h5>
                                                <h5 style="float: right">@{{ format2(datofactura.brute, 'RD$') }}</h5>
                                            </div>
                                            <div class="col-md-4">
                                                <h5 style="float: left">Descuento</h5>
                                                <h5 style="float: right">@{{ format2(datofactura.desc, 'RD$') }}</h5>
                                            </div>
                                            <div class="col-md-4">
                                                <h5 style="float: left">Itbis</h5>
                                                <h5 style="float: right">@{{ format2(datofactura.itbis, 'RD$') }}</h5>
                                            </div>
                                            <div class="col-md-4">
                                                <h5 style="float: left">devuelta</h5>
                                                <h5 style="float: right">@{{ format2(datofactura.returns, 'RD$') }}</h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <hr style="background: #0062cc">
                                    </div>
                                    <div class="col-md-12" v-if="datofactura != 'vacio'">
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                <tr>
                                                    <th >Producto / Servicio</th>
                                                    <th >Cantidad</th>
                                                    <th >Precio</th>
                                                    <th >Bruto</th>
                                                    <th >Itbis</th>
                                                    <th>Devolución</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <template v-for="(item, index) in datosdetallefactura">
                                                    <example  @nuevodetalle="nuevodetalle" :bus="bus" v-bind:key="index" v-bind:id="item.product_id" v-bind:index="index" v-bind:nombre="item.name_product" v-bind:servicio="item.description"  v-bind:cantidad="item.quanlity"  v-bind:precio="item.price"  v-bind:bruto="item.impost"  v-bind:itbis="item.depot"></example>
                                                </template>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="text-center" style="margin-top: 10px">
                                            <button type="button" @click="confimar" class="btn btn-primary btn-lg"><i class="fas fa-undo"></i> Efectuar Devolución</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body" v-if="confirmacion == true">
                                <div class="row">
                                    <div class="col-md-12" style="margin-bottom: 10px">
                                        <div class="text-center">
                                            <h2>Devolución de productos</h2>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <hr style="background-color: #0062cc">
                                    </div>
                                    <div class="col-md-12" style="margin-top: 10px;margin-bottom: 10px">
                                        <div class="text-right">
                                            <button type="button" @click="atras" class="btn btn-primary"><i class="fas fa-angle-left"></i> Volver</button>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="container-fluid"  style="width: 600px;box-shadow: 0px 0px 9px 0px rgba(0,0,0,0.75);">
                                            @include('devolucion.Invoice')
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="float-right">
                                            <button type="button" id="printD" @click="testPrintButton" class="btn btn-primary"><i class="fas fa-print" id="imprimir"></i> Imprimir</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scriptp')
    <script>

        // $(document).ready(function() {
        $("#printD").click(function () {
            var mode = 'iframe'; //popup
            var close = mode == "popup";
            var options = { mode : mode, popClose : close};
            $("div#myPrintArea").printArea(options);
        });
        // });
    </script>
    <script >

        Vue.component('example', {
            template:
                '<tr  :style="{\'background-color\': color[0]}"  @click="seleccion = true">\n' +
                '        <td :style="{\'color\': color[1]}">@{{ nombre ? nombre : servicio }}</td>\n' +
                '        <td :style="{\'color\': color[1]}" v-if="cantidaddevolver == 0"><div class="text-center">\n' + '@{{  cantidad }}' + '</div></td>\n' +
                '        <td :style="{\'color\': color[1]}" v-else><div class="text-center">\n' + '@{{ operacion }}' + '</div></td>\n' +
                '        <td :style="{\'color\': color[1]}">@{{ precio  }}</td>\n' +
                '        <td :style="{\'color\': color[1]}">@{{ decimal(bruto) }}</td>\n' +
                '        <td :style="{\'color\': color[1]}">@{{ decimal(itbis) }}</td>\n' +
                '        <td style="width: 100px">' +
                '            <input type="number" style="" :disabled="cantidad == 0" v-model="cantidaddevolver" :max="cantidad" min="0" class="form-control form-control-sm">' +
                // '            <button type="button" style="float: right;" class="btn btn-primary btn-sm" @click="nuevodetalle"><i class="fas fa-undo"></i></button>' +
                '        </td>' +
                '</tr>',
            props: ['index','id','nombre', 'cantidad', 'precio', 'bruto', 'itbis', 'bus', 'servicio'],
            computed: {
                color () {
                    if (this.operacion === 0) {
                        return ['#ea4343', 'white']
                    }
                    return ['transparent', 'black']
                },
                operacion(){
                    resta = this.cantidad - this.cantidaddevolver;
                    return resta;
                },
            },
            data(){
                return{
                    seleccion:false,
                    cantidaddevolver:0
                }
            },
            methods:{
                nuevodetalle:function () {
                    if (this.cantidaddevolver > 0 && this.cantidaddevolver <= this.cantidad){
                        if  (this.cantidaddevolcer != 0)
                        {
                            this.$emit('nuevodetalle',{
                                index:this.index,
                                datos:{
                                    id:this.id,
                                    nombre:this.nombre,
                                    cantidad:this.cantidad,
                                    cantidaddevolcer:this.cantidaddevolver
                                }
                            });
                        }
                    }
                },
                decimal:function (i) {
                    return parseFloat(i).toFixed(2)
                }
            },
            mounted() {
                this.bus.$on('ejecutar', this.nuevodetalle)
            },
            watch: {
                cantidaddevolver(){

                    console.log(this.cantidaddevolver + '---- > --- '+this.cantidad)
                    if(this.cantidaddevolver > this.cantidad){
                        this.cantidaddevolver = this.cantidad;
                    }
                    if(this.cantidaddevolver < 0)
                    {
                        this.cantidaddevolver = 0;
                    }
                }
            }
        });


        new Vue({
            el: '#Vue',
            data(){
                return {
                    no_factura:'',
                    datofactura:'vacio',
                    datosdetallefactura: 'vacio',
                    datosnuevodetalle:[],
                    bus: new Vue(),
                    confirmacion:false,
                    clientenombre:'',
                    compania:'',
                    totaldevolver:0,
                    numerodevolucion:0,
                    fecha:'',
                    devolucionesanteriores:'',
                    nfc:'',
                    invoicesList:[],
                    loading:false
                }
            },watch: {
            },
            mounted(){
            },
            created()
            {
                this.listInvoices()
            },
            methods:{
                listInvoices()
                {
                    _this = this;
                    axios.get('/invoices/last')
                        .then((resp)=> {
                            _this.invoicesList = resp.data
                        })
                        .catch( ( err )=> console.log(err))
                },
                format2(n, currency) {
                    return currency + n.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
                },
                testPrintButton()
                {

                    $("#printD").click( () => {
                        var mode = 'iframe'; //popup
                        var close = mode == "popup";
                        var options = { mode : mode, popClose : close};
                        $("div#myPrintArea").printArea(options);
                    });

                },
                decimal:function (i) {
                    return parseFloat(i).toFixed(2)
                },
                datosfactura:function (id) {
                    _this = this;
                    if(id)
                    {
                        _this.no_factura = id
                    }
                    this.loading = true;
                    axios.post('/devolucion/buscar/factura', {
                        id:_this.no_factura
                    })
                        .then(function (response) {
                            if  (response['data']['factura'] == 'vacio' && response['data']['detalle'] == 'vacio'){
                                toastr.warning('No existe factura con este numero');
                            }
                            _this.datofactura = response['data']['factura'];
                            if (response['data']['detalle_devolucion'] != "vacia")
                            {
                                _this.datosdetallefactura = response['data']['detalle_devolucion']
                            }else {
                                _this.datosdetallefactura= response['data']['detalle'];
                            }
                        })
                        .catch(function (error) {
                            toastr.warning('Se ha producido un Error');
                        })
                        .finally(()=> {_this.loading = false;});
                },
                nuevodetalle:function (i) {
                    _this = this;


                    for(var key in _this.datosdetallefactura)
                    {
                        if (key === i.index)
                        {
                            var detalle = {
                                name_product: _this.datosdetallefactura[key].name_product,
                                description: _this.datosdetallefactura[key].description,
                                cantidad: parseFloat(i.datos.cantidaddevolcer),
                                price: _this.datosdetallefactura[key].quanlity ==  parseFloat(i.datos.cantidaddevolcer) ? parseFloat(_this.datosdetallefactura[key].price) : parseFloat(_this.datosdetallefactura[key].price) / parseFloat(_this.datosdetallefactura[key].quanlity) * parseFloat(i.datos.cantidaddevolcer) ,
                                itbis: _this.datosdetallefactura[key].quanlity ==  parseFloat(i.datos.cantidaddevolcer) ? parseFloat(_this.datosdetallefactura[key].depot) : parseFloat(_this.datosdetallefactura[key].depot) / parseFloat(_this.datosdetallefactura[key].quanlity) * parseFloat(i.datos.cantidaddevolcer),
                                bruto: _this.datosdetallefactura[key].quanlity ==  parseFloat(i.datos.cantidaddevolcer) ? parseFloat(_this.datosdetallefactura[key].impost): parseFloat(_this.datosdetallefactura[key].impost) / parseFloat(_this.datosdetallefactura[key].quanlity) * parseFloat(i.datos.cantidaddevolcer),
                                product_id: _this.datosdetallefactura[key].product_id,
                            };
                            _this.datosnuevodetalle.push(detalle);
                            return
                        }
                    }

                },
                realizardevolucion:function () {
                    _this = this;
                    axios.post('/devolucion/store', {
                        factura: _this.datofactura,
                        detalle_devolucion: _this.datosnuevodetalle,

                    })
                        .then(function (response) {
                            if(response['data'] === "No es posible hacer la factura por falta de Comprobantes")
                            {
                                toastr.warning('No es posible hacer la devolucion por falta de Comprobantes');
                                return;
                            }
                            _this.confirmacion = true;
                            toastr.success('La Devolucion se ha realizado Correctamente');
                            _this.compania = response['data'][0][0];
                            _this.totaldevolver = response['data'][1];
                            _this.fecha = response['data'][2];
                            _this.numerodevolucion = response['data'][3];
                            _this.nfc = response['data'][4];
                            if(response['data'][5] != "")
                            {
                                toastr.warning(response['data'][5]);
                            }
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                },
                confimar: function (){
                    _this = this;
                    // if (_this.clientenombre == ""){
                    //     toastr.warning("no podemos realizar la devolucion a una factura sin cliente");
                    // }else{
                    var txt;
                    var r = confirm("Esta seguro que quiere hacer esta devolucion ?");
                    if (r == true){
                        txt = this.botondevolver();
                    }
                    // }
                },
                botondevolver:function () {
                    _this = this;
                    this.bus.$emit('ejecutar');
                    _this.realizardevolucion();

                },
                nombrecliente:function (i) {
                    _this = this;
                    var nombre;
                    if (i == null)
                    {
                        _this.clientenombre = ''
                    }else{
                        axios.post('/cliente/buscar/nombre', {
                            id:i
                        })
                            .then( (response) =>{
                                if (response['data'] == null)
                                {
                                    _this.clientenombre = ''
                                }else
                                {
                                    for (var key in response['data'])
                                    {
                                        if (i == response['data'][key].id){
                                            _this.clientenombre = response['data'][key].nombre
                                        }
                                    }
                                }
                            })
                            .catch(function (error) {
                                console.log(error);
                            });
                    }
                },
                atras:function () {
                    _this = this ;
                    _this.no_factura = '';
                    _this.datofactura ='vacio';
                    _this.datosdetallefactura = 'vacio';
                    _this.datosnuevodetalle = [];
                    _this.confirmacion = false;
                    _this.clientenombre ='';
                    _this.compania ='';
                    _this.totaldevolver = 0;
                    _this.numerodevolucion = 0;
                    _this.fecha = '';
                    _this.devolucionesanteriores = '';
                }
            },
            computed:{

            }
        })
    </script>

@endsection