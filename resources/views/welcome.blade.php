@extends('main.app')
@section('style')
    <style>

        #plus{
            -webkit-transition: all .6s ease-in-out;    /* safari - Chrome*/
            -moz-transition: all .6s ease-in-out;       /* Firefox */
            -o-transition: all .6s ease-in-out;         /* Opera */
            transition: all .6s ease-in-out;


        }
        #plus:hover{
            -webkit-transition: all 1s ease-in-out;
            -webkit-transform: rotate(360deg);  /* safari - Chrome*/


        }
        .text1:hover{
            -webkit-transition: all 1s ease-in-out;
            transform: scale(1.5);
        }
        .overlay1 {
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            height: 100%;
            width: 100%;
            opacity: 0;
            transition: .5s ease;
            background-color: #2dba50;

        }
        .overlay2 {
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            height: 100%;
            width: 100%;
            opacity: 0;
            transition: .5s ease;
            background-color: #ba0004;

        }

        .card:hover .overlay1{
            opacity: 0.8;
            cursor: pointer;
            box-shadow: 5px 10px 18px #888888
        }
        .card:hover .overlay2{
            opacity: 0.8;
            cursor: pointer;
            box-shadow: 5px 10px 18px #888888
        }

        #categoria:hover{
            box-shadow: 5px 10px 18px #00aced;
        }

        .text1 {
            color: white;
            position: absolute;
            margin: 40%;

        }
        .image1 {
            display: block;
            width: 100%;
            height: auto;
        }

        /* width */
        ::-webkit-scrollbar {
            width: 8px;
        }

        /* Track */
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        /* Handle */
        ::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 10px;

        }

        .factura-table th {
            font-weight: 600;
        }

        .factura-table td {
            font-size: 14px;
        }
        /* Handle on hover */
        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

    </style>
@endsection
@section('tittle',' Cafeteria| Facturacion')

@section('titulo')
    <h4 style="color: white;font-weight: 400"> <i class="fa fa-arrow-circle-right"></i> Punto de Venta</h4>
@endsection

@section('aside')

    <div class="container">
        <div class="card-title" style="margin: 0;  margin-top: 15px">
            <div style="text-align: center; background-color: #4272d7; color: white">
                Factura
            </div>
            {{--<h4 class="text-center title-2" style="padding-top: 10px;">Factura</h4>--}}

        </div>
        <form action="" method="post" novalidate="novalidate">
            <div class="form-group has-success">
                <div class="table-responsive" style="margin-bottom: 5px">
                    <table class="table table-sm factura-table" >
                        <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Cant.</th>
                            <th>Total</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="item in list">
                            <td style="line-height: 1">@{{item.name}}</td>
                            <td class="text-center" style="cursor: pointer" @click="cuadro = true" v-if="cuadro == false">@{{item.count}}</td>
                            <td class="text-center" style="cursor: pointer" v-else>
                                <input type="number" class="form-control" min="0" style="width: 70px" v-model="item.count" @keypress.enter="normal" @blur="normal" @input.self="cambiarcount(item.id, item.count)">
                            </td>
                            <td class="text-center">@{{item.price}}</td>
                            <td><button type="button" class="fas fa-minus" style="color: orangered" @click="eliminarp(item.id)"></button></td>
                        </tr>
                        </tbody>
                        <thead>
                        <tr>
                            <th>Total:</th>
                            <th class="text-center"></th>
                            <th class="text-center">@{{ facturatotal }}.00</th>
                            <th></th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>

        </form>

        <div v-show="cerrada == 'A' && facturatotal > 0" style="width: 320px;position: fixed;bottom: 10px;">
            <button type="button" @click="cancelarcompra" class="btn btn-danger btn-lg btn-block btn-sm"><i class="fas fa-ban"></i> Cancelar Compra</button>
            <button data-toggle="modal" data-target="#pago" type="button" style="height: 130px;background: #4272d7;" class="btn btn-lg  btn-block">
                <span id="payment-button-amount" style="font-size: 20px;color: whitesmoke"> Pagar <br><span style="color: whitesmoke;font-size: 30px">$ @{{ facturatotal }}.00</span></span>
                <span id="payment-button-sending" style="display:none;">Sending…</span>
            </button>
        </div>

        <div v-show="cerrada == 'A' && facturatotal == 0" style="width: 320px;position: fixed;bottom: 10px;">
            <button data-toggle="modal" disabled data-target="#pago" type="button" style="height: 130px; background: #4272d7;" class="btn btn-lg  btn-block">
                <span style="font-size: 24px"><span style="color: whitesmoke">Pagar <br></span><span style="color: whitesmoke;font-size: 30px">$&nbsp;@{{ facturatotal }}.00</span></span>
                <span style="display:none;">Sending…</span>
            </button>
        </div>

        <div v-show="cerrada == 'C'" style="position: fixed;bottom:10px; width: 250px">
            <h4 style="color: red; font-size: 24px">Caja no esta abierta</h4>
            <p style="font-size: small;font-size: 22px">Menu => Caja => Apertura Caja</p>
        </div>


    </div>




@endsection
@section('content')
    <div id="p" style="margin-top: -80px">
        <br>
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="row" style="clear: both">
                    <template v-if="cerrada !='A'"></template>
                    <template v-if="cerrada == 'no es dia'"></template>
                    <template v-if="cerrada =='A'">
                        <div class="col-" style="overflow-y: scroll;margin:0; padding:0; height: 90vh;">
                            <div class="text-center" style="margin-bottom: 5px">
                                <h5>Categorias</h5>
                            </div>
                            @foreach($categoria as $cat)
                                <div class="card" id="categoria" style="height: auto;width: 150px;margin-right:10px;background: white;cursor: pointer;box-shadow:rgb(136, 136, 136) 1px 1px 5px;" @click="productocategoria('<?php echo $cat->id; ?>'), cargarsubcategoria('<?php echo $cat->id; ?>'), cambio = 'subcategoria'">
                                    <div class="card-body">
                                        <div class="mx-auto d-block">
                                            <img class="rounded-circle mx-auto d-block image1" style=" height: 60px; width: 80px" src="imagenes/{{$cat->img }}" alt="Card image cap">
                                            <h5 class="text-sm-center mt-2 mb-1">{{ $cat->nombre }}</h5>
                                            <div class="location text-sm-center" style="color: #0062cc">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="col-" v-show="cambio == 'subcategoria' && categoria_subcategoria.length !== 0" style="overflow-y: scroll;height: 90vh;">
                            <div class="text-center" style="margin-bottom: 5px">
                                <h6>Subcategoria</h6>
                            </div>
                            <template v-if="categoria_subcategoria == ''">

                                <div class="card" @click="cambio = 'categoria'" style="height: 110px;width: 130px;margin-right: 10px;margin-left: 10px;background: white;cursor: pointer;box-shadow: 3px 3px 10px #888888">
                                    <div class="card-body">
                                        <div class="mx-auto d-block">
                                            <img class="rounded-circle mx-auto d-block image1" style=" height: 50px; width: 80px"  src="imagenes/default.jpg" alt="Card image cap">
                                            <h6 class="text-sm-center mt-2 mb-1">No Resultado</h6>
                                            <div class="location text-sm-center" style="color: #0062cc">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </template>
                            <template v-else v-for="cs in categoria_subcategoria">
                                <div class="card" @click="subcategoriaproductos(cs.id)" style="height: 110px;width: 130px;margin-right: 10px;margin-left: 10px;background: white;cursor: pointer;box-shadow: 3px 3px 10px #888888">
                                    <div class="card-body">
                                        <div class="mx-auto d-block">
                                            <img class="rounded-circle mx-auto d-block image1" style=" height: 50px; width: 80px" :src="'imagenes/'+cs.img" alt="Card image cap">
                                            <h5 class="text-sm-center mt-2 mb-1">@{{ cs.nombre }}</h5>
                                            <div class="location text-sm-center" style="color: #0062cc">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </template>
                    <br>
                    <div class="col" style="box-shadow: 1px 1px 5px #888888;overflow-y: scroll;height: 90vh;">
                        <div class="text-center" style="margin-bottom: 8px">
                            <button type="button" class="btn btn-lg btn-sm btn-link" v-show="cambio == 'subcategoria' && categoria_subcategoria.length !== 0" @click="cambio = 'categoria'" style="float: left;margin-left: 10px"><i class="fas fa-arrow-left"></i></button>
                            <h3>Productos</h3>
                            <input type="search"  class="form-control form-control-sm" v-model="buscador"  v-on:input.self="buscadorp(buscador)" placeholder="Buscar..." name="" id="busca">
                        </div>

                        <div class="row">
                            <template v-for="p in productos" v-if="cerrada == 'A' && productosbuscados == ''">
                                <div class="card" style="height: auto;background: #c8f1ff;width: 130px;margin-left: 10px;margin-right: 10px;" @click="pfactura(p.id)" :title="p.name">
                                    <div class="card-body" style="background: white">
                                        <div class="mx-auto d-block">
                                            <img class="rounded-circle mx-auto d-block image1" style=" height: 60px; width: 80px" :src="'imagenes/'+p.img" alt="Card image cap">
                                            <h6 class="text-sm-center mt-2 mb-1" style="line-height: 1;">@{{ reducir(p.name) }}</h6>
                                            <div class="location text-sm-center" style="color: #0062cc">
                                                <i class="fa fa-money-bill-alt"></i> @{{p.price}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="overlay1">
                                        <div class="text1"><i class="fa fa-plus fa-3x" id="plus"></i></div>
                                    </div>
                                </div>
                            </template>

                            <template v-for="p in productosbuscados" v-if="cerrada == 'A' && productosbuscados != ''">
                                <div  class="card"  :title="p.name" style="height: auto;width: 130px;background: #c8f1ff;margin-left: 10px;margin-right: 10px;" @click="pfactura(p.id)">
                                    <div class="card-body" style="background: white">
                                        <div class="mx-auto d-block">
                                            <img class="rounded-circle mx-auto d-block image1" style=" height: 60px; width: 80px" :src="'imagenes/'+p.img" alt="Card image cap">
                                            <h6 class="text-sm-center mt-2 mb-1" style="line-height: 1;">@{{ reducir(p.name) }}</h6>
                                            <div class="location text-sm-center" style="color: #0062cc">
                                                <i class="fa fa-money-bill-alt"></i> @{{p.price}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="overlay1">
                                        <div class="text1"><i class="fa fa-plus fa-3x" id="plus"></i></div>
                                    </div>
                                </div>
                            </template>
                            <template v-if="cerrada == 'no es dia'">

                            </template>
                            <template v-for="p in productos" v-else-if="cerrada == 'C'">
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--Para decir que la caja esta cerrada-->
    <div v-if="cerrada == 'A'"></div>
    <div v-if="cerrada == 'no es dia'" class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="mediumModalLabel">Caja Pendiente</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning" role="alert">
                        <h4 class="alert-heading">Caja abierta</h4>
                        <p>En Este momento la caja se encuentra abierta del dia anterior por favor ir a cerrarla</p>
                        <hr>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <a class="btn btn-success" href="/caja" role="button">caja</a>
                </div>
            </div>
        </div>
    </div>
    <div v-if="cerrada == 'C'" class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="mediumModalLabel">Caja Cerrada</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger" role="alert">
                        <h4 class="alert-heading">Caja Cerrada</h4>
                        <p>En este momento la caja se encuentra cerrada, para poder realizar un venta necesitamos saber con cuento fondo cuenta la caja</p>
                        <hr>
                        <p class="mb-0">Para abrir la caja tiene que dirigirse a Opciones => Caja => Apertura de caja O</p>
                        <p class="mb-0">precione el boton que dice <span style="color: green">Abrir</span></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <a class="btn btn-success" href="/caja" role="button">Abrir</a>
                </div>
            </div>
        </div>
    </div>
    <!--/Para decir que la caja esta cerrada-->

    <!--Modal para configurar el Pago-->
    <div class="modal fade" id="pago" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="mediumModalLabel">Pago de Factura</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" novalidate="novalidate">
                        <div class="text-center" style="margin-bottom: 20px">
                            <h3 style="font-size: 50px">A PAGAR $: <span style="font-size: 50px; color: red">@{{ facturatotal }}.00</span></h3>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="cc-exp" class="control-label mb-1">Efectivo<span style="color: red">*</span></label>
                                    <input id="efectivom" name="dinero" autofocus="autofocus" required v-on:keypress.enter="facturar()" type="number" class="form-control cc-exp"  v-model="campodinero">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="cc-exp" class="control-label mb-1">Tarjeta<span style="color: red">*</span></label>
                                    <input id="tarjetam" name="dinero" required type="number" class="form-control cc-exp"  v-model="montotarjeta">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="cc-number" class="control-label mb-1">Tipo de tarjeta</label>
                                    <select name="selectSm"  id="SelectLm" v-model="tipotarjeta" class="form-control-sm form-control">
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
                                    <input id="numtarjeta"  name="numtarjeta" type="text" class="form-control cc-exp" maxlength="16"  v-model="Numtarjeta" data-val="true" data-val-required="Please enter the card expiration" >
                                    <span class="help-block" data-valmsg-for="cc-exp" data-valmsg-replace="true"></span>
                                </div>
                            </div>
                            <div class="col-6">
                                <label for="auth" class="control-label mb-1">Autorización<span style="color: red">*</span></label>
                                <div class="input-group">
                                    <input id="auth" name="auth"  v-model="auth" maxlength="20" type="text" class="form-control cc-cvc">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div class="" style="margin-right: 55%">
                                <h4>Devuelta:<span> @{{ devuelta }} </span></h4>
                            </div>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <button v-if="suma >= facturatotal" type="button" @click="facturar()" class="btn btn-primary">&nbsp;Pagar</button>
                            <button v-else disabled type="button" @click="facturar()" class="btn btn-primary">&nbsp;Pagar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--/Modal para configurar el Pago-->
    @include('productos.buscarmodal')
@endsection
@section('scriptp')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/locale/es-do.js"></script>

    <script !src="">

        console.log()

        $(document).ready(function(){




            $('#funciona').slick({
                infinite: false,
                speed: 300,
                slidesToShow: 5,
                slidesToScroll: 4,
                dots: true,
                vertical: true,
                verticalSwiping: true,
            });

            var alerta = '{{$alerta}}';


            dia = moment().format('DD-MM-YYYY');



            p = moment( dia +' '+ '10:00 PM', 'DD-MM-YYYY hh:mm A').utc().format();


            if (moment().isAfter(p)){

                toastr.options = {
                    "closeButton": true,
                    "timeOut": "500000",
                    "extendedTimeOut": "100000",
                    "positionClass": "toast-top-center",
                }
                toastr.warning('Son las ' + moment().format('hh:mm A') + ' favor acordarse de cerrar la caja');
            }

            /*Cerrar caja antes de las 12*/


        });

        $('body').keyup(function(e) {
            if(e.which == 35){
                $('#pago').modal('show');
            }
        });
        $(function () {
            $('#myModal').modal('show');
        })
        toastr.options.newestOnTop = 'false';

    </script>

    <script>
        function formatMoney(n, c, d, t) {
            var c = isNaN(c = Math.abs(c)) ? 2 : c,
                d = d == undefined ? "." : d,
                t = t == undefined ? "," : t,
                s = n < 0 ? "-" : "",
                i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
                j = (j = i.length) > 3 ? j % 3 : 0;

            return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
        };

        var productos = JSON.parse('{!! $productos !!}')
        var caja = '{!! $caja !!}'
        var cerrada = '{!! $cerrada !!}'

        function toObject(arr){
            var rv = {};

            for (var key in arr) {
                if(arr.hasOwnProperty(key)) {
                    var item = arr[key];
                    rv[item.id] = item;
                }
            }
            return rv;
        }

        var app = new Vue({
            el: '#Vue',
            data: {
                referencia:'',
                buscador:'',
                montotarjeta:0,
                tipotarjeta:'',
                banco:'',
                auth: '',
                Numtarjeta: '',
                cerrada: cerrada,
                caja: caja,
                campocliente:'general',
                campotipop:'efectivo',
                campodinero:0,
                count: 0,
                list: [],
                productos: toObject(productos),
                carrito: {},
                productosbuscados:'',
                productosreferencia:'',
                listacategoria: [],
                cuadro: false,
                categoria_subcategoria:[],
                cambio:'categoria',


            },
            watch:{
                formatMoney: function(n, c, d, t){
                    var c = isNaN(c = Math.abs(c)) ? 2 : c,
                        d = d == undefined ? "." : d,
                        t = t == undefined ? "," : t,
                        s = n < 0 ? "-" : "",
                        i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
                        j = (j = i.length) > 3 ? j % 3 : 0;

                    return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
                },

                facturatotal:function(valor){
                    this.campodinero = valor
                },


            },
            methods:{
                subcategoriaproductos:function (id) {

                    _this = this
                    axios.post('subcategoria/productos',{
                        id:id
                    })
                        .then(function (response) {
                            _this.productosbuscados = response["data"]
                        })
                        .catch(function (error) {
                        });

                },
                cargarsubcategoria:function(id){

                    _this = this
                    axios.post('subcategoria/vender',{
                        id:id
                    })
                        .then(function (response) {
                            _this.categoria_subcategoria = response["data"]
                        })
                        .catch(function (error) {
                        });
                },

                cancelarcompra:function(){
                    this.carrito = [];
                    this.list = [];
                },

                cargarcategoria: function () {
                    var _this = this;

                    axios.post('/ver/categoria')
                        .then(function (response) {
                            _this.listacategoria = response["data"];
                        })
                        .catch(function (error) {
                        });
                },

                buscadorp:function () {
                    var _this = this
                    $.ajax({
                        url: '/buscar/producto',
                        method: 'GET',
                        data: {
                            producto: this.buscador
                        },
                        success:function (data) {
                            _this.productosbuscados = data;
                        }

                    });
                },
                buscarreferencia:function () {
                    var _this = this
                    $.ajax({
                        url: '/buscar/producto/referencia',
                        method: 'GET',
                        data: {
                            referenciah: this.referencia
                        },
                        success:function (data) {
                            _this.productosreferencia = data;
                        }

                    });
                },


                pfactura: function (id) {

                    var producto = this.productos[id];
                    this.carrito = {
                        id : producto.id,
                        name : producto.name,
                        price : producto.price,
                        count : 1
                    }

                    var idp = parseFloat(producto.id)

                    function buscaid(prod) {
                        return prod.id == idp;
                    }
                    var cantidad = producto.existence;
                    var bar = producto.barcode;

                    if (this.list.find(buscaid)){

                        var count = this.list.find(buscaid).count;
                        var contador = parseFloat(count) + 1;
                        var cant = producto.existence - count;

                        var listid = this.list.find(buscaid).id
                        var total = contador * producto.price;

                        this.list.map(function (dato){
                            if (dato.id == listid) {
                                dato.count = parseFloat(contador)
                                dato.price = parseFloat(total)
                            }
                            return dato
                        });


                        // if(cant > 0){
                        //
                        //     this.list.map(function (dato){
                        //         if (dato.id == listid) {
                        //             dato.count = contador
                        //             dato.price = total
                        //         }
                        //         return dato
                        //     });
                        //
                        // }if(cant < 0 && bar == 'compuesto'){
                        //
                        //     this.list.map(function (dato) {
                        //         if (dato.id == listid) {
                        //             dato.count = contador
                        //             dato.price = total
                        //         }
                        //         return dato
                        //     });
                        //
                        // }if(cant < 0 && bar != 'compuesto'){
                        //
                        //     alert('no tiene mas producto de este');
                        // }

                    }else{
                        this.list.push(this.carrito)
                        // if(cantidad == 0 && bar == 'compuesto'){
                        //     this.list.push(this.carrito)
                        // }
                        // if(cantidad == 0){
                        //     alert('no tenemos mas de este producto O es un producto compuesto')
                        // }else{
                        //     this.list.push(this.carrito)
                        // }

                    }
                },

                eliminarp: function (id) {
                    var producto = this.productos[id]
                    var idp = producto.id

                    function buscaid(prod) {
                        return prod.id == idp;
                    }
                    if (this.list.find(buscaid)){

                        var count = this.list.find(buscaid).count;
                        var contador = count - 1 ;
                        var listid = this.list.find(buscaid).id
                        // var total = contador * producto.price;
                        var total = this.list.find(buscaid).price - producto.price

                        this.list.map(function(dato) {

                            if (dato.id == listid){
                                dato.count = contador
                                dato.price = total
                            }
                            return dato
                        });

                    }if(this.list.find(buscaid)){
                        if (this.list.find(buscaid).count == 0){
                            var index = this.list.indexOf(this.list.find(buscaid));
                            if (index > -1) {
                                this.list.splice(index, 1);
                            }
                        }
                    }

                },
                cambiarcount:function(idcambio ,cambiocount ){
                    var producto = this.productos[idcambio]
                    var idp = producto.id

                    function buscaid(prod) {
                        return prod.id == idp;
                    }
                    if (this.list.find(buscaid)){

                        var countnuevo = cambiocount;
                        var totalnuevo = countnuevo * producto.price;
                        var listid = this.list.find(buscaid).id

                        this.list.map(function(dato) {

                            if (dato.id == listid){
                                dato.count = parseFloat(countnuevo)
                                dato.price = parseFloat(totalnuevo)
                            }
                            return dato
                        });

                    }if(this.list.find(buscaid)){
                        if (this.list.find(buscaid).count == 0){
                            var index = this.list.indexOf(this.list.find(buscaid));
                            if (index > -1) {
                                this.list.splice(index, 1);
                            }
                        }
                    }


                },

                normal:function(e){
                    _this = this;
                    e.preventDefault();
                    _this.cuadro = false;
                },

                facturar:function () {
                    if (this.montotarjeta > 0){
                        if (this.tipotarjeta == '' ||  this.auth == '' || this.Numtarjeta == ''){
                            alert('Faltan Datos por Llenar')
                        }if (this.montotarjeta > this.facturatotal - this.campodinero){
                            alert('La tarjeta no puede ser mayor al precio a pagar');
                        }else{
                            _this = this
                            $.ajax({
                                url: '/facturacion',
                                method: 'GET',
                                data: {
                                    cliente:this.campocliente,
                                    devuelta:this.devuelta,
                                    preciop:this.facturatotal,
                                    tipop:this.campotipop,
                                    banco:this.banco,
                                    auth: this.auth,
                                    tipotarjeta: this.tipotarjeta,
                                    Numtarjeta: this.Numtarjeta,
                                    montotarjeta:this.montotarjeta,
                                    dinero:this.campodinero,
                                    detalle: this.list
                                },
                                success:function (dato) {
                                    if (dato == 'bien'){

                                        _this.list = [];
                                        _this.carrito = {};

                                        $('#pago').modal('hide');
                                        toastr.options.newestOnTop = false;
                                        toastr.success('Gracias por la compra');
                                        setTimeout('document.location.reload()',1000);
                                    }

                                },
                                error:function () {
                                    toastr.error('A ocurrido un error al realizar la venta');
                                }

                            });
                        }

                    }else{
                        if (this.montotarjeta > this.facturatotal){
                            alert('El Monto de la Tarjeta no puede ser mayor al precio a pagar')
                        }if (this.montotarjeta == 0 && this.campodinero == 0){
                            alert('No puedes hacer una compra de valor 0');
                        }else{
                            _this = this
                            $.ajax({
                                url: '/facturacion',
                                method: 'GET',
                                data: {
                                    cliente:this.campocliente,
                                    devuelta:this.devuelta,
                                    preciop:this.facturatotal,
                                    tipop:this.campotipop,
                                    banco:this.banco,
                                    auth: this.auth,

                                    tipotarjeta: this.tipotarjeta,
                                    Numtarjeta: this.Numtarjeta,
                                    montotarjeta:this.montotarjeta,
                                    dinero:this.campodinero,
                                    detalle: this.list
                                },
                                success:function (dato) {
                                    if (dato == 'bien'){

                                        _this.list = [];
                                        _this.carrito = {};

                                        $('#pago').modal('hide');
                                        toastr.options.newestOnTop = false;
                                        toastr.success('Gracias por la compra');
                                        setTimeout('document.location.reload()',1000);
                                    }
                                },
                                error:function () {
                                    toastr.error('A ocurrido un error al realizar la venta');
                                }

                            });
                        }
                    }
                },

                productocategoria:function (id) {
                    _this = this
                    $.ajax({
                        url: 'productos/categoria',
                        method: 'GET',
                        data: {
                            id:id
                        },
                        success:function (data) {
                            _this.productosbuscados = data;
                        },
                        error:function () {
                        }

                    });

                },
                doThis:function () {
                    alert('funciona')
                },

                reducir:function (cantidad) {
                    cant = cantidad.length;
                    if (cant > 10){
                        return cantidad.substr(0, 10) + '...';
                    }else {
                        return cantidad;
                    }
                }
            },
            computed:{

                facturatotal:function () {


                    var suma = 0
                    for(var i = 0; i< this.list.length; i++ ){

                        suma = suma + this.list[i].price
                    }
                    return parseFloat(suma);
                },

                productototal:function () {

                    var suma = 0
                    for(var i = 0; i< this.list.length; i++ ){

                        suma = suma + this.list[i].count
                    }

                    return suma;
                },

                suma:function () {

                    var suma = (parseFloat(this.campodinero) + parseFloat(this.montotarjeta))

                    return suma;
                },

                devuelta:function () {
                    // var devuelta = suma - this.facturatotal
                    var devuelta = this.suma - this.facturatotal

                    return devuelta;
                },




            }
        });
    </script>
@endsection