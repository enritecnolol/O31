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

        .card:hover .overlay1{
            opacity: 0.8;
            cursor: pointer;
            box-shadow: 5px 10px 18px #888888
        }

        .text1 {
            color: white;
            position: absolute;
            margin: 41%;

        }
        .image1 {
            display: block;
            width: 100%;
            height: auto;
        }

    </style>
@endsection
@section('tittle',' Cafeteria| Facturacion')
@section('aside')

    <div class="container">
        <div class="card-title">
            <h3 class="text-center title-2" style="padding-top: 10px; color: white">Factura</h3>
        </div>

        <form action="" method="post" novalidate="novalidate">
            <div class="form-group has-success">
                <div class="table-responsive" style="margin-bottom: 5px">
                    <table class="table table-sm">
                        <thead>
                        <tr>
                            <th style="color: white">Producto</th>
                            <th style="color: white">Cant.</th>
                            <th style="color: white">Total</th>
                            <th style="color: white"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="item in list">
                            <th style="color: white">@{{item.name}}</th>
                            <td class="text-center" style="color: white">@{{item.count}}</td>
                            <td class="text-center" style="color: white">@{{item.price}}</td>
                            <td><button type="button" class="far fa-trash-alt" style="color: #ffc30e" @click="eliminarp(item.id)"></button></td>
                        </tr>
                        </tbody>
                    </table>
                    <div v-if="cerrada == 'A'" style="position: fixed;bottom:10px; width: 250px">
                        <button data-toggle="modal" data-target="#pago" type="button" class="btn btn-lg btn-info btn-block">
                            <i class="fa fa-money-bill-alt fa-lg"></i>&nbsp;
                            <span id="payment-button-amount">Pagar </span>
                            <span id="payment-button-sending" style="display:none;">Sending…</span>
                        </button>
                    </div>
                    <div v-else style="position: fixed;bottom:10px; width: 250px">
                        <h4 style="color: red">Caja no esta abierta</h4>
                        <p style="font-size: small;color:white;">Opciones => Caja => Apertura Caja </p>
                    </div>
                </div>
            </div>
        </form>
    </div>


@endsection
@section('content')
    <div id="p">
        <div class="text-center" style="padding-bottom: 20px">
            <h1 class="title-2"><strong>Productos</strong></h1>
        </div>
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="row">

                    <template v-for="p in productos" v-if="cerrada == 'A'">
                        <div class="col-md-3">
                            <div class="card" style="height: auto;background: #c8f1ff" @click="pfactura(p.id)">
                                <div class="card-header" style="color: #2db3ff">
                                    <i class="fa fa-shopping-cart"></i>
                                    <span class="badge badge-success pull-right"></span>
                                </div>
                                <div class="card-body">
                                    <div class="mx-auto d-block">
                                        <img class="rounded-circle mx-auto d-block image1" style=" height: 100px; width: 100px" :src="'imagenes/'+p.img" alt="Card image cap">
                                        <h5 class="text-sm-center mt-2 mb-1">@{{ p.name }}</h5>
                                        <div class="location text-sm-center" style="color: #2db3ff">
                                            <i class="fa fa-money-bill-alt"></i> @{{p.price}}</div>
                                    </div>
                                </div>
                                <div class="overlay1">
                                    <div class="text1"><i class="fa fa-plus fa-3x" id="plus"></i></div>
                                </div>
                            </div>
                        </div>
                    </template>

                    <template v-for="p in productos" v-else>
                        <div class="col-md-3">
                            <div class="card" style="height: auto">
                                <div class="card-header">
                                    <i class="fa fa-shopping-cart"></i>
                                    <span class="badge badge-success pull-right"></span>
                                </div>
                                <div class="card-body">
                                    <div class="mx-auto d-block">
                                        <img class="rounded-circle mx-auto d-block image1" style=" height: 100px; width: 100px" :src="'imagenes/'+p.img" alt="Card image cap">
                                        <h5 class="text-sm-center mt-2 mb-1">@{{ p.name }}</h5>
                                        <div class="location text-sm-center">
                                            <i class="fa fa-money-bill-alt"></i> @{{p.price}}</div>
                                    </div>
                                </div>
                                <div class="overlay1">
                                    <div class="text1"><i class="fa fa-plus fa-3x" id="plus"></i></div>
                                </div>
                            </div>
                        </div>
                    </template>

                </div>
            </div>
        </div>
    </div>

    <!--Para decir que la caja esta cerrada-->
    <div v-if="cerrada == 'A'"></div>
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true" v-else>
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
                        <div class="form-group">
                            <label for="cc-number" class="control-label mb-1">Tipo de Pago</label>
                            <select name="selectSm" id="SelectLm" v-model="campotipop" class="form-control-sm form-control">
                                <option value="efectivo">Efectivo</option>
                                <option value="tarjeta" >Tarjeta</option>
                            </select>
                            <span class="help-block" data-valmsg-for="cc-number" data-valmsg-replace="true"></span>
                        </div>
                        <div class="form-group">
                            <label for="ppagar" class="control-label mb-1">Precio a pagar</label>
                            <input id="ppagar" name="ppagar" type="text" disabled
                                   class="input-sm form-control-sm form-control" aria-required="true" aria-invalid="false"
                                   :value="facturatotal">
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
                </div>


            </div>
        </div>
    </div>
    <!--/Modal para configurar el Pago-->
@endsection
@section('scriptp')
    <script !src="">

        $(function () {
            $('#myModal').modal('show');
        })
        toastr.options.newestOnTop = false;
    </script>

    <script>
        var productos = JSON.parse('{!! $productos !!}')
        var caja = '{!! $caja !!}'
        var cerrada = '{!! $cerrada !!}'

        function toObject(arr) {
            var rv = {};
            for (var i = 0; i < arr.length; ++i)
                rv[arr[i].id] = arr[i];
            return rv;
        }

        var app = new Vue({
            el: '#Vue',
            data: {
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
                carrito: {}

            },
            watch:{

                facturatotal:function(valor){

                    this.campodinero = valor
                }

            },
            methods:{

                pfactura: function (id) {

                    var producto = Object.entries(this.productos)[id-1]

                    this.carrito = {
                        id : producto[1].id,
                        name : producto[1].name,
                        price : producto[1].price,
                        count : 1
                    }

                    var idp = producto[1].id

                    function buscaid(prod) {
                        return prod.id == idp;
                    }

                    if (this.list.find(buscaid)){

                        var count = this.list.find(buscaid).count;
                        var contador = count + 1;
                        var listid = this.list.find(buscaid).id
                        var total = contador * producto[1].price;

                        this.list.map(function(dato) {

                            if (dato.id == listid){
                                dato.count = contador
                                dato.price = total
                            }
                            return dato
                        });

                    }else{
                        this.list.push(this.carrito)

                    }

                    // this.total= this.list.price.reduce(function(a, b){
                    //     return a + b
                    // });

                },

                eliminarp: function (id) {
                    var producto = Object.entries(this.productos)[id-1]
                    var idp = producto[1].id

                    function buscaid(prod) {
                        return prod.id == idp;
                    }
                    if (this.list.find(buscaid)){

                        var count = this.list.find(buscaid).count;
                        var contador = count - 1 ;
                        var listid = this.list.find(buscaid).id
                        // var total = contador * producto[1].price;
                        var total = this.list.find(buscaid).price - producto[1].price

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

                facturar:function () {

                    if (this.campodinero < this.facturatotal){
                        alert('El dinero no puede ser menor que precio a pagar');
                    }else {

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
                                dinero:this.campodinero,
                                detalle: this.list
                            },
                            success:function (dato) {
                                $('#pago').modal('hide');
                                toastr.options.newestOnTop = false;
                                toastr.success('Gracias por la compra');
                                setTimeout('document.location.reload()',2000);
                            },
                            error:function () {
                                toastr.error('A ocurrido un error al realizar la venta');
                            }

                        });

                    }
                }
            },
            computed:{

                facturatotal:function () {


                    var suma = 0
                    for(var i = 0; i< this.list.length; i++ ){

                        suma = suma + this.list[i].price
                    }
                    return suma;
                },

                devuelta:function () {

                    var devuelta = this.campodinero - this.facturatotal

                    return devuelta;
                },



            }
        });
    </script>
@endsection