@extends('main.app')
@section('style')
    <style>
        .imp:hover{
            color: #3ca5ea;
            cursor: pointer;
        }
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
            border-radius: 20px 20px 20px 20px;
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
            margin: 35%;

        }
        .image1 {
            display: block;
            width: 100%;
            height: auto;
        }

        /* width */
        ::-webkit-scrollbar {
            width: 12px;
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
        @media print {
            #myPrintArea {
                display: inline;
            }
        }
    </style>
@endsection
@section('tittle',' SofiaRD | Punto Venta')

@section('titulo')
    {{--<MARQUEE width="100%" SCROLLDELAY=200><h5 style="color: white">acceso rapido: tecla inicio - Enfoca el codigo, tecla F8 - buscar cliente, tecla F7 - Crear Cliente, tecla FIN - Cobrar, tecla pagina abajo - Cancelar Compra</h5></MARQUEE>--}}
    <div class="" style="width: 90%">
        <h4 style="color: white;float: left">
            <i class="fas fa-arrow-right"></i> PUNTO DE VENTA &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        </h4>
        <h4 style="color: white; float: right;cursor: help; margin-right: 15px" title="
              acceso rapido:
              tecla inicio : Enfoca el codigo,
              tecla F8 : buscar cliente,
              tecla F7 : Crear Cliente,
              tecla FIN : Cobrar,
              tecla pagina abajo : Cancelar Compra,
              tecla F2 : Buscar Producto">
            AYUDA
            <i class="fas fa-question"></i>
        </h4>
    </div>
@endsection

@section('aside')
    <div class="container">
        <div class="row" v-if="clientedatos !== ''" style="margin-top: 15px">
            <div class="col-md-6">
                <h6 style="float: left">ID: </h6>
                <h6 style="float:right;font-style: oblique;font-variant: small-caps">&ensp;@{{ clientedatos.matricula }}</h6>
            </div>
            <div class="col-md-6">
                <h6 style="float: left">Tarjeta: </h6>
                <h6 style="float: right;font-style: oblique;font-variant: small-caps">@{{ clientedatos.codigo }}</h6>
            </div>
            <div class="col-md-12">
                <h6 style="float: left">Cliente: </h6>
                <h6 style="float:none;font-style: oblique;">&ensp;@{{ clientedatos.nombre }}</h6>
            </div>
            <div class="col-md-6">
                <h6 style="float: left;">Puntos: </h6>
                <h6 style="float: right;font-style: oblique;font-variant: small-caps" v-if="clientedatos.puntos == null">00</h6>
                <h6 style="float: right;font-style: oblique;font-variant: small-caps" v-else> @{{ clientedatos.puntos }}</h6>
            </div>
            <div class="col-md-6">
                <h6 style="float: left;">Bonos:</h6>
                <h6 style="float: right;font-style: oblique;font-variant: small-caps">@{{ bonos }}</h6>
            </div>
        </div>
        <div class="card-title" style="margin: 0;  margin-top: 15px;">
            <div style="text-align: center; background-color: #4272d7; margin-bottom: 5px;color: white">
                Factura
            </div>
            <div v-show="cerrada !== 'C'" style="text-align: center; color: white; margin-bottom: 5px">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fas fa-barcode"></i></div>
                    </div>
                    <input type="text" placeholder="Codigo" id="codigo1" title="presionar INICIO para hacer focus aqui" v-model="codigop" class="form-control form-control-sm" autofocus @keyup.enter="codigopfactura">
                </div>
            </div>
        </div>
        <form action="" method="post" novalidate="novalidate">
            <div class="form-group has-success">
                <div class="table-responsive" id="tabeldiv" style="margin-bottom: 5px; max-height: 400px; min-height: 300px;overflow-y: auto">
                    <table class="table table-sm factura-table" >
                        <thead>
                        <tr>
                            <th>Producto</th>
                            <th></th>
                            <th>Cant.</th>
                            <th>Desc</th>
                            <th>Total</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="item in list">
                            <td style="line-height: 1">@{{item.name}}</td>
                            <td style="line-height: 1;" v-if="item.itbis != 0">@{{item.itbis}}%</td>
                            <td style="line-height: 1;" v-else></td>
                            <td class="text-center" style="cursor: pointer" @click="cuadro = true" v-if="cuadro == false">@{{item.count}}</td>
                            <td class="text-center" style="cursor: pointer" v-else>
                                <input type="number" class="form-control" min="0" style="width: 70px" v-model="item.count" @keypress.enter="normal" @blur="normal" @input.self="cambiarcount(item.id, item.count)">
                            </td>
                            <td class="text-center" style="cursor: pointer" v-if="desc == false" @click="desc = true">@{{ item.desc }} %</td>
                            <td class="text-center" v-else>
                                <input type="number" class="form-control" min="0" v-model="item.desc" @keypress.enter="normall" @blur="normall" @input.self="descuentoagregar(item.id, item.desc)" style="width: 70px">
                            </td>
                            <td class="text-center">@{{item.price}}</td>
                            <td><i class="fas fa-minus" style="color: orangered;font-size: 20px;cursor: pointer;" @click="eliminarp(item.id)"></i></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </form>
        <div v-if="cerrada === 'A' && neto > 0 && idticket === ''" style="width: 320px;position: fixed;bottom: 10px;">
            <div class="" style="height: 120px;margin-bottom: 64px">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12" v-if="list.length != 0">
                            <h5 style="float: left">items: @{{ cantidaditems }}</h5> <p style="float: right">@{{ cantidaditemsall }}</p>
                        </div>
                        <div class="col-sm-12"><hr></div>
                        <div class="col-sm-12">
                            <h5 style="float: left">Sub Total: </h5> <p style="float: right">@{{  format2(parseFloat(bruto), '') }}</p>
                        </div>
                        <div class="col-sm-12">
                            <h5 style="float: left">Descuento: </h5> <p style="float: right">@{{ format2(parseFloat(totaldescuento ), '') }}</p>
                        </div>
                        <div class="col-sm-12">
                            <h5 style="float: left">Itbis: </h5> <p style="float: right">@{{ format2(parseFloat(algoitbis ), '') }}</p>
                        </div>
                        <div class="col-md-12" v-if="setting.leycamarero == 'si'">
                            <h5 style="float: left">10% ley: </h5> <p style="float: right">@{{ format2(parseFloat(leycamarero), '') }}</p>
                        </div>
                        <div class="col-md-12">
                            <h5 style="float: left">Neto: </h5> <p style="float: right">@{{ format2(parseFloat(neto ), '') }}</p>
                        </div>
                        <div class="col-md-12" v-if="clientedatos !== ''">
                            <h5 style="float: left">Puntos: </h5> <p style="float: right">@{{ puntosagenerar }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <button type="button" id="cancelarcompara" title="presionar PAGINA ABAJO" @click="cancelarcompra" class="btn btn-danger btn-lg btn-block btn-sm"><i class="fas fa-ban"></i> Cancelar Compra</button>
            <button data-toggle="modal" data-target="#pago" title="presione tecla FIN" type="button" style="height: 130px;background: rgb(66, 150, 50);" class="btn btn-lg  btn-block">
                <span id="payment-button-amount" style="font-size: 20px;color: whitesmoke"> Pagar <br><span style="color: whitesmoke;font-size: 30px">$ @{{ format2(parseFloat(neto ), '') }}</span></span>
                <span id="payment-button-sending" style="display:none;">Sending…</span>
            </button>
        </div>
        <div v-else-if="cerrada === 'A' && idticket !== ''" style="width: 320px;position: fixed;bottom: 10px;">
            <div class="" style="height: 120px;margin-bottom: 5px">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <h5 style="float: left">Bruto: </h5> <p style="float: right">@{{  format2(parseFloat(bruto), '') }}</p>
                        </div>
                        <div class="col-sm-12">
                            <h5 style="float: left">Descuento: </h5> <p style="float: right">@{{ format2(parseFloat(totaldescuento), '') }}</p>
                        </div>
                        <div class="col-sm-12">
                            <h5 style="float: left">Itbis: </h5> <p style="float: right">@{{ format2(parseFloat(algoitbis), '') }}</p>
                        </div>
                        <div class="col-md-12" v-if="setting.leycamarero == 'si'">
                            <h5 style="float: left">10% ley: </h5> <p style="float: right">@{{ format2(parseFloat(leycamarero ), '')}}</p>
                        </div>
                        <div class="col-md-12">
                            <h5 style="float: left">Neto: </h5> <p style="float: right">@{{ format2(parseFloat(neto ), '')}}</p>
                        </div>
                        <div class="col-md-12" v-if="clientedatos !== ''">
                            <h5 style="float: left">Puntos: </h5> <p style="float: right">@{{ puntosagenerar }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <button type="button" id="cancelarcompara" title="presionar PAGINA ABAJO" @click="cancelarcompra" class="btn btn-danger btn-lg btn-block btn-sm"><i class="fas fa-ban"></i> Cancelar Compra</button>
            <button data-toggle="modal" data-target="#pago" title="presione tecla FIN" type="button" style="height: 130px;background: rgb(66, 150, 50);" class="btn btn-lg  btn-block">
                <span id="payment-button-amount" style="font-size: 20px;color: whitesmoke"> Pagar <br><span style="color: whitesmoke;font-size: 30px">$ @{{ format2(parseFloat(neto ), '') }}</span></span>
                <span id="payment-button-sending" style="display:none;">Sending…</span>
            </button>
        </div>

        <div v-else-if="cerrada === 'A' && neto <= 0 && datosticket  === ''" style="width: 320px;position: fixed;bottom: 10px;">
            <button data-toggle="modal" disabled data-target="#pago" type="button" style="height: 130px; background: rgb(66, 150, 50);" class="btn btn-lg  btn-block">
                <span style="font-size: 24px"><span style="color: whitesmoke">Pagar <br></span><span style="color: whitesmoke;font-size: 30px">$&nbsp;@{{ format2(parseFloat(neto ), '')}}</span></span>
                <span style="display:none;">Sending…</span>
            </button>
        </div>

        <div v-else-if="cerrada === 'C'" style="position: fixed;bottom:10px; width: 250px">
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
                    <template v-if="cerrada !=='A'"></template>
                    <template v-if="cerrada === 'no es dia'"></template>
                    <template v-if="cerrada ==='A'">
                        <div class="col- dragscroll" style="overflow-y: scroll;margin:0; padding:0; height: 90vh;">
                            <div class="text-center" style="margin-bottom: 5px">
                                <h5>Categorias</h5>
                            </div>
                            <div class="card" id="categoria" style="height: auto;width: 150px;margin-right:10px;background: white;cursor: pointer;box-shadow:rgb(136, 136, 136) 1px 1px 5px;" @click="productosbuscados = ''">
                                <div class="card-body">
                                    <div class="mx-auto d-block">
                                        <img class="rounded-circle mx-auto d-block image1" style=" height: 60px; width: 80px" src="imagenes/list-view-icon-png-4.png" alt="Card image cap">
                                        <h5 class="text-sm-center mt-2 mb-1">Todos</h5>
                                        <div class="location text-sm-center" style="color: #0062cc">
                                        </div>
                                    </div>
                                </div>
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
                        <div class="col- dragscroll" v-show="cambio === 'subcategoria' && categoria_subcategoria.length !== 0" style="cursor: grab; cursor : -o-grab; cursor : -moz-grab; cursor : -webkit-grab;overflow-y: scroll;height: 90vh;">
                            <div class="text-center" style="margin-bottom: 5px">
                                <h6>Subcategoria</h6>
                            </div>
                            <template v-if="categoria_subcategoria === ''">

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
                    <div class="col" style="box-shadow: 1px 1px 5px #888888;">
                        <div class="container-fluid">
                            <div class="text-center" style="margin-bottom: 8px">
                                <button type="button" class="btn btn-lg btn-sm btn-link" v-show="cambio === 'subcategoria' && categoria_subcategoria.length !== 0" @click="cambio = 'categoria'" style="float: left;margin-left: 10px"><i class="fas fa-arrow-left"></i></button>
                                <h3>Productos</h3>
                                <input type="search"  style="height: 35px;" class="form-control form-control-sm" v-model="buscador"  @input.self="buscadorp(buscador)" placeholder="Buscar..." name="" id="busca">
                            </div>
                            <div class="dragscroll" style="height: 84vh;width: auto;overflow-y: auto;overflow-x: hidden;cursor: grab; cursor : -o-grab; cursor : -moz-grab; cursor : -webkit-grab;">
                                <div class="row " style="">
                                    <template v-for="p in productosbuscados !== '' ? productosbuscados : productos" v-if="cerrada === 'A'">
                                        <div class="col-sm-2 col-xs-4">
                                            <div class="card"  style="box-shadow: 0px 0px 2px 0px rgba(0,0,0,0.75);border-radius: 20px 20px 20px 20px;width: 130px;margin-left: 10px;margin-right: 10px;max-height: 184px;" @click="pfactura(p.id)" :title="p.name">
                                                <div class="card-body" style="background: white;border-radius: 20px 20px 20px 20px;padding:0px">
                                                    <span class="badge badge-primary" style="position: absolute; top: -6px; left: -8px">@{{ p.barcode }}</span>
                                                    <div class="mx-auto d-block">
                                                        <img class="mx-auto d-block" style="border-radius: 20px 20px 0px 0px;height:91px;width:128px" :src="'imagenes/'+p.img" alt="Card image cap">
                                                        <h6 class="text-sm-center mt-2 mb-1" style="line-height: 1;">@{{ p.name }}</h6>
                                                        <div class="location text-sm-center" style="color: #0062cc">
                                                            <i class="fa fa-money-bill-alt"></i> @{{p.price}}
                                                        </div>
                                                    </div>
                                                </div>
                                                <template v-if="existenciarep == 'no'">
                                                    <div class="overlay1">
                                                        <div class="text1"><i class="fa fa-plus fa-3x" id="plus"></i></div>
                                                    </div>
                                                </template>
                                                <template v-if="existenciarep == 'si'">
                                                    <div class="overlay1" v-if="p.existence > 0 && p.compuesto == 'no'">
                                                        <div class="text1"><i class="fa fa-plus fa-3x" id="plus"></i></div>
                                                    </div>
                                                    <div class="overlay1" v-if="p.existence == 0 && p.compuesto == 'si'">
                                                        <div class="text1"><i class="fa fa-plus fa-3x" id="plus"></i></div>
                                                    </div>
                                                    <div class="overlay2" v-else-if="p.existence == 0 && p.compuesto =='no'">
                                                        <div class="text1"><i class="fas fa-times fa-3x" id="plus"></i></div>
                                                    </div>
                                                </template>
                                            </div>
                                        </div>
                                    </template>
                                    <template v-if="cerrada === 'no es dia'">
                                    </template>
                                    <template v-for="p in productos" v-else-if="cerrada == 'C'">
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--Para decir que la caja esta cerrada-->
    @include('modal.ModalDeCajasStatus')
    <!--/Para decir que la caja esta cerrada-->

    <!--Modal para configurar el Pago-->
    @include('modal.ModalPagar')
    <!--/Modal para configurar el Pago-->
    @include('productos.buscarmodal')
    @include('modal.modelfacture')
    @include('modal.modelcliente')
    @include('modal.modalcrearcliente')
@endsection

@section('scriptp')


    <script !src="">
        $(document).ready(function(){
            $("#codigo1").focus();


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
            if(e.which === 35){
                $('#pago').modal('show', function () {});
                $('#efectivom').focus();
            }
            if(e.which === 119){
                $('#clientep').modal('show');
                $("#matriculaa").focus();
            }
            if(e.which === 34){
                $("#cancelarcompara").click();
            }
            if(e.which ===36){
                $("#codigo1").focus();

            }if(e.which === 118){
                $('#nuevocliente').modal('show');
            }if(e.which === 113){
                $('#busca').focus();
            }
        });

        $(function () {
            $('#myModal').modal('show');
        })

        toastr.options.newestOnTop = 'false';

    </script>
    <script type="text/javascript" src="https://cdn.rawgit.com/asvd/dragscroll/master/dragscroll.js"></script>
    <script>
        $( document ).ready(function() {
            $("#imprimir").click(function () {
                var mode = 'iframe'; //popup
                var close = mode == "popup";
                var options = { mode : mode, popClose : close};
                $("div#myPrintArea").printArea(options);
            });
        });
    </script>



    <script>
        var productos = JSON.parse('{!! $productos !!}');
        var caja = '{!! $caja !!}';
        var cerrada = '{!! $cerrada !!}';

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

        var itbistotal = 0;
        var brutototal = 0;
        var descuentototal = 0;

        var tipoitbis = '{{$config}}';

        var app = new Vue({

            el: '#Vue',
            data: {
                cantidadp:0,
                codigop:'',
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
                descuento:0,
                desc:false,
                descgeneral:0,
                cuadrogeneral:false,
                ultfacture: 0,
                datoscliente:'',
                idcliente: '',
                clientedatos:'',
                configtj:'',
                bonos:0,
                idticket:'',
                datosticket:'',
                datostj:'',
                nombre:'',
                telefono:'',
                email:'',
                matricula:'',
                observacion:'',
                idtarjeta:'',
                existenciarep:'',
                setting:'',
                fiscal:false,
                tiponfc:'02',
                datancf:{
                    telefono:'',
                    rnc:'',
                    razon:''
                },
                facturaimp:false,
                rncdevf:'',
                lastid:'',
                rncData:{},
                loading:false,
                rncDueDate:''
            },
            mounted() {
                _this = this;
                _this.cargartablacliente();
                _this.cargartablatp();
                _this.existencia();
                _this.config();
            },
            watch:{
                neto:function(valor){
                    this.campodinero = 0;
                },
            },
            methods:{
                limpiar()
                {
                    this.campodinero = 0;
                    this.tiponfc = '02';
                    this.datancf = {
                        telefono:'',
                        rnc:'',
                        razon:''
                    };
                },
                reset () {
                    Object.assign(this.$data,{
                        cantidadp:0,
                        codigop:'',
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
                        descuento:0,
                        desc:false,
                        descgeneral:0,
                        cuadrogeneral:false,
                        ultfacture: 0,
                        datoscliente:'',
                        idcliente: '',
                        clientedatos:'',
                        configtj:'',
                        bonos:0,
                        idticket:'',
                        datosticket:'',
                        nombre:'',
                        telefono:'',
                        email:'',
                        matricula:'',
                        observacion:'',
                        idtarjeta:'',
                        tiponfc:'02',
                        datancf:{
                            telefono:'',
                            rnc:'',
                            razon:''
                        },
                        facturaimp:false,
                        rncdevf:'',
                        lastid:'',
                        rncData:{},
                        loading:false,
                        rncDueDate:''
                    });
                },
                format2(n, currency) {
                    return currency + n.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
                },
                buscar_rnc()
                {
                    // if(this.datancf.rnc.length !== 9 || 11)
                    // {
                    //     toastr.warning("Revisar RNC")
                    //     return;
                    // }
                    _this = this
                    this.loading = true;
                    this.datancf.razon = "cargando...";
                    axios.post('/rnc/test', {
                        rnc: this.datancf.rnc
                    })
                        .then( (response) => {

                            if (this.rncData == 0){
                                toastr.warning("No se ha encotrado este RNC")
                                return;
                            }
                            let dataXML =  _this.convertirXmlEnObjeto($.parseXML(response.data));
                            _this.rncData  = JSON.parse(dataXML['soap:Body']['GetContribuyentesResponse']['GetContribuyentesResult'])
                            _this.datancf.razon = this.rncData['RGE_NOMBRE']
                        })
                        .catch(function (error) {
                            console.log(error)
                            _this.datancf.razon = "";
                        })
                        .finally(function () {
                            if(_this.datancf.razon == "cargando..."){
                                _this.datancf.razon = "";
                            }
                            _this.loading = false;
                        });
                },
                productosindex()
                {
                    axios.post('/productos/index')
                        .then( (response) => {
                            productos = response.data
                        })
                        .catch(function (error) {
                        });
                },
                fiscalconfirm(){
                    this.fiscal = true;
                    this.tiponfc = '01';
                },
                config(){
                    axios.post('/configuracion/sale')
                        .then( (response) => {
                            for(var key in response['data']){
                                this.setting = response["data"][key];
                                break;
                            }
                        })
                        .catch(function (error) {
                        });
                },
                subcategoriaproductos:function (id) {

                    _this = this;
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
                    _this = this
                    var txt;
                    var r = confirm("Estas seguro que quieres cancelar la compra ? ");
                    if (r == true){

                        txt = _this.carrito = {};
                        _this.list = [];
                        _this.clientedatos = '';
                        _this.idcliente= '';
                    }
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
                codigopfactura:function () {
                    _this = this ;
                    var dos = _this.codigop.split("+")

                    for (var key in _this.productos ){
                        if (_this.productos[key].barcode  == dos[0]){

                            if  (dos.length == 1){
                                _this.pfactura(_this.productos[key].id)
                                _this.codigop = ''

                            }else {
                                _this.pfactura(_this.productos[key].id);
                                _this.cambiarcount(_this.productos[key].id, dos[1])
                                _this.codigop = ''
                                _this.cantidadp = 0
                            }

                            return
                        }
                    }

                    toastr.warning('Producto no encontrado');
                    _this.codigop = ''


                },
                pfactura: function (id) {
                    $("#tabeldiv").animate({scrollTop:$('#tabeldiv').prop("scrollHeight")},420);
                    var producto = this.productos[id];
                    this.carrito = {
                        id : producto.id,
                        name : producto.name,
                        price : parseFloat(producto.price).toFixed(2),
                        desc : 0,
                        count : 1,
                        itbis : producto.porciento
                    };

                    var idp = parseFloat(producto.id);

                    function buscaid(prod) {
                        return prod.id == idp;
                    }
                    var cantidad = producto.existence;
                    var bar = producto.barcode;

                    if (this.list.find(buscaid)){

                        var count = this.list.find(buscaid).count;
                        var contador = parseFloat(count) + 1;
                        var cant = producto.existence - count;
                        if (_this.existenciarep == 'si')
                        {
                            if  (producto.compuesto == 'no')
                            {
                                if  (contador > producto.existence)
                                {
                                    contador = producto.existence;
                                    toastr.warning('Producto agotado')
                                }
                            }
                        }
                        var listid = this.list.find(buscaid).id;
                        var total = contador * producto.price;

                        this.list.map(function (dato){
                            if (dato.id == listid) {
                                dato.count = parseFloat(contador);
                                dato.price = parseFloat(total).toFixed(2)
                            }
                            return dato
                        });

                    }else{
                        if (_this.existenciarep == 'si')
                        {
                            if  (producto.compuesto == 'no' && producto.existence == 0)
                            {
                                toastr.warning('Producto agotado')
                            }else {
                                this.list.push(this.carrito)
                            }
                        }else {
                            this.list.push(this.carrito)
                        }
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
                        var listid = this.list.find(buscaid).id;
                        // var total = contador * producto.price;
                        var total = this.list.find(buscaid).price - producto.price;

                        this.list.map(function(dato) {

                            if (dato.id == listid){
                                dato.count = contador
                                dato.price = (total).toFixed(2)
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

                        if (_this.existenciarep == 'si')
                        {
                            if  (countnuevo > producto.existence)
                            {
                                countnuevo = producto.existence;
                                toastr.warning('Producto agotado')
                            }
                        }
                        var totalnuevo = countnuevo * producto.price;
                        var listid = this.list.find(buscaid).id

                        this.list.map(function(dato) {

                            if (dato.id == listid){
                                dato.count = parseFloat(countnuevo)
                                dato.price = parseFloat(totalnuevo).toFixed(2)
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
                normall:function(e){
                    _this = this;
                    e.preventDefault();
                    _this.desc = false;
                },
                facturar:function () {
                    if (this.montotarjeta > 0){
                        if (this.tipotarjeta === '' ||  this.auth === '' || this.Numtarjeta === ''){
                            alert('Faltan Datos por Llenar')
                            return;
                        }
                        if (this.montotarjeta > this.neto - this.campodinero){
                            alert('La tarjeta no puede ser mayor al precio a pagar');
                            return;
                        }
                        if (_this.datosticket !== ''){
                            if (this.datosticket.balancepuntos > this.neto ){
                                alert('Si va a utilizar su bonos por favor consumirlo completo')
                                return;
                            }
                            if (this.setting.generacomprobante === 'si')
                            {
                                if  (this.tiponfc != '02')
                                {
                                    if (!this.datancf.telefono || !this.datancf.rnc || !this.datancf.razon ){
                                        toastr.warning("Llenar datos de NFC");
                                        return;
                                    }
                                }
                            }
                            _this = this;
                            $.ajax({
                                url: '/facturacioncar',
                                method: 'GET',
                                data: {
                                    setting:this.setting,
                                    tiponfc:this.tiponfc,
                                    datancf:this.datancf,
                                    existencias: this.existenciarep,
                                    ticket: this.datosticket.id,
                                    puntos:this.puntosagenerar,
                                    cliente:this.clientedatos.id,
                                    devuelta:this.devuelta,
                                    preciop:this.neto,
                                    tipop:this.campotipop,
                                    banco:this.banco,
                                    auth: this.auth,
                                    bruto:this.bruto,
                                    itbis:this.algoitbis,
                                    neto:this.neto,
                                    leycamarero:this.leycamarero,
                                    descuento:this.totaldescuento,
                                    tipotarjeta: this.tipotarjeta,
                                    Numtarjeta: this.Numtarjeta,
                                    montotarjeta:this.montotarjeta,
                                    dinero:this.campodinero,
                                    detalle: this.list
                                },
                                success: (dato) => {
                                    var _this = this;
                                    if  (dato == "No es posible hacer la factura por falta de Comprobantes")
                                    {
                                        toastr.warning(dato, "validador");
                                        return;
                                    }
                                    if (dato[0] == 'bien'){
                                        $('#pago').modal('hide');
                                        toastr.options.newestOnTop = false;
                                        toastr.success('Gracias por la compra');
                                        this.rncdevf = dato[1];
                                        this.rncDueDate= dato[4];
                                        this.lastid = dato[2];
                                        if  (this.facturaimp === false){
                                            this.reset();
                                            // setTimeout('document.location.reload()',1000);
                                            return;
                                        }
                                        if  (dato[3] != "")
                                        {
                                            toastr.info(dato[3], "Aviso");
                                        }
                                        $('#pagofactura').modal('show');
                                    }
                                },
                                error:function () {
                                    toastr.error('A ocurrido un error al realizar la venta');
                                }

                            });
                            return;
                        }

                        if (this.setting.generacomprobante == 'si')
                        {
                            if  (this.tiponfc != '02')
                            {
                                if (!this.datancf.telefono || !this.datancf.rnc || !this.datancf.razon ){
                                    toastr.warning("Llenar datos de NFC");
                                    return;
                                }
                            }
                        }
                        _this = this;
                        $.ajax({
                            url: '/facturacioncar',
                            method: 'GET',
                            data: {
                                setting:this.setting,
                                tiponfc:this.tiponfc,
                                datancf:this.datancf,
                                existencias: this.existenciarep,
                                puntos:this.puntosagenerar,
                                cliente:this.clientedatos.id,
                                devuelta:this.devuelta,
                                preciop:this.neto,
                                tipop:this.campotipop,
                                banco:this.banco,
                                auth: this.auth,
                                bruto:this.bruto,
                                itbis:this.algoitbis,
                                neto:this.neto,
                                leycamarero:this.leycamarero,
                                descuento:this.totaldescuento,
                                tipotarjeta: this.tipotarjeta,
                                Numtarjeta: this.Numtarjeta,
                                montotarjeta:this.montotarjeta,
                                dinero:this.campodinero,
                                detalle: this.list
                            },
                            success: (dato) => {
                                var _this = this;
                                console.log(' 3 '+dato[1])
                                if  (dato == "No es posible hacer la factura por falta de Comprobantes")
                                {
                                    toastr.warning(dato, "validador");
                                    return;
                                }
                                if (dato[0] == 'bien'){
                                    $('#pago').modal('hide');
                                    toastr.options.newestOnTop = false;
                                    toastr.success('Gracias por la compra');
                                    this.rncdevf = dato[1];
                                    this.rncDueDate= dato[4];
                                    this.lastid = dato[2];
                                    if  (this.facturaimp === false){
                                        this.reset();
                                        // setTimeout('document.location.reload()',1000);
                                        return;
                                    }
                                    if  (dato[3] != "")
                                    {
                                        toastr.info(dato[3], "Aviso");
                                    }
                                    $('#pagofactura').modal('show');
                                }
                            },
                            error:function () {
                                toastr.error('A ocurrido un error al realizar la venta');
                            }

                        });

                    }
                    else{
                        if (this.montotarjeta === 0 && this.campodinero === 0 && this.datosticket.balancepuntos === 0){
                            alert('No puedes hacer una compra de valor 0');
                            return;
                        }

                        if (this.datosticket !== ''){
                            if (this.datosticket.balancepuntos > this.neto && this.neto < 0 ){
                                alert('Si va a utilizar su bonos por favor consumirlo completo')
                                return;
                            }else{
                                if (this.setting.generacomprobante == 'si')
                                {
                                    if  (this.tiponfc != '02')
                                    {
                                        if (!this.datancf.telefono || !this.datancf.rnc || !this.datancf.razon ){
                                            toastr.warning("Llenar datos de NFC");
                                            return;
                                        }
                                    }
                                }
                                _this = this;
                                $.ajax({
                                    url: '/facturacioncar',
                                    method: 'GET',
                                    data: {
                                        setting:this.setting,
                                        tiponfc:this.tiponfc,
                                        datancf:this.datancf,
                                        existencias: this.existenciarep,
                                        ticket: this.datosticket.id,
                                        puntos:this.puntosagenerar,
                                        cliente:this.clientedatos.id,
                                        devuelta:this.devuelta,
                                        preciop:this.neto,
                                        tipop:this.campotipop,
                                        banco:this.banco,
                                        auth: this.auth,
                                        bruto:this.bruto,
                                        itbis:this.algoitbis,
                                        neto:this.neto,
                                        leycamarero:this.leycamarero,
                                        descuento:this.totaldescuento,
                                        tipotarjeta: this.tipotarjeta,
                                        Numtarjeta: this.Numtarjeta,
                                        montotarjeta:this.montotarjeta,
                                        dinero:this.campodinero,
                                        detalle: this.list
                                    },
                                    success: (dato) => {
                                        var _this = this;
                                        console.log(' 3 '+dato[1])
                                        if  (dato == "No es posible hacer la factura por falta de Comprobantes")
                                        {
                                            toastr.warning(dato, "validador");
                                            return;
                                        }
                                        if (dato[0] == 'bien'){
                                            $('#pago').modal('hide');
                                            toastr.options.newestOnTop = false;
                                            toastr.success('Gracias por la compra');
                                            this.rncdevf = dato[1];
                                            this.rncDueDate= dato[4];
                                            this.lastid = dato[2];
                                            if  (this.facturaimp === false){
                                                this.reset();
                                                // setTimeout('document.location.reload()',1000);
                                                return;
                                            }
                                            if  (dato[3] != "")
                                            {
                                                toastr.info(dato[3], "Aviso");
                                            }
                                            $('#pagofactura').modal('show');
                                        }
                                    },
                                    error:function () {
                                        toastr.error('A ocurrido un error al realizar la venta');
                                    }

                                });
                            }
                            return;
                        }
                        if (this.setting.generacomprobante == 'si')
                        {
                            if  (this.tiponfc != '02')
                            {
                                if (!this.datancf.telefono || !this.datancf.rnc || !this.datancf.razon ){
                                    toastr.warning("Llenar datos de NFC");
                                    return;
                                }
                            }
                        }
                        axios.post('/facturacioncar', {
                            setting:this.setting,
                            tiponfc:this.tiponfc,
                            datancf:this.datancf,
                            existencias: this.existenciarep,
                            puntos:this.puntosagenerar,
                            cliente:this.clientedatos.id,
                            devuelta:this.devuelta,
                            preciop:this.neto,
                            tipop:this.campotipop,
                            banco:this.banco,
                            auth: this.auth,
                            bruto:this.bruto,
                            itbis:this.algoitbis,
                            neto:this.neto,
                            leycamarero:this.leycamarero,
                            descuento:this.totaldescuento,
                            tipotarjeta: this.tipotarjeta,
                            Numtarjeta: this.Numtarjeta,
                            montotarjeta:this.montotarjeta,
                            dinero:this.campodinero,
                            detalle: this.list
                        })
                            .then( (response) => {
                                let dato = response['data'];
                                if  (dato == "No es posible hacer la factura por falta de Comprobantes")
                                {
                                    toastr.warning(dato, "validador");
                                    return;
                                }
                                if (dato[0] == 'bien'){
                                    $('#pago').modal('hide');
                                    toastr.options.newestOnTop = false;
                                    toastr.success('Gracias por la compra');
                                    this.rncdevf = dato[1];
                                    this.rncDueDate= dato[4];
                                    this.lastid = dato[2];
                                    if  (this.facturaimp === false){
                                        this.reset();
                                        // setTimeout('document.location.reload()',1000);
                                        return;
                                    }
                                    if  (dato[3] != "")
                                    {
                                        toastr.info(dato[3], "Aviso");
                                    }
                                    $('#pagofactura').modal('show');
                                }
                            })
                            .catch(function (error) {
                            });

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
                reducir:function (cantidad) {
                    cant = cantidad.length;
                    if (cant > 10){
                        return cantidad.substr(0, 10) + '...';
                    }else {
                        return cantidad;
                    }
                },
                descuentoagregar:function(idcambio ,desc ){
                    var producto = this.productos[idcambio];
                    var idp = producto.id;
                    var descuento = desc;
                    function buscaid(prod) {
                        return prod.id == idp;
                    }
                    if(this.list.find(buscaid)){

                        var listid = this.list.find(buscaid).id;

                        this.list.map(function(dato){
                            if(dato.id == listid){
                                dato.desc = parseFloat(descuento)
                            }
                            return dato
                        });
                    }
                },
                ultimoidfactura:function () {
                    _this = this

                    axios.post('/ultima/facture',)
                        .then(function (response) {
                            _this.ultfacture = response['data'];
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                },
                cargartablacliente: function () {
                    _this = this
                    axios.post('/clientes/datos/tabla2')
                        .then(function (response) {
                            if (response['data'] == 'vacio'){
                                _this.datoscliente = ''
                            }else {
                                _this.datoscliente = response['data'];
                            }

                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                },
                asinarcliente:function ()
                {
                    _this = this;
                    for (var key in _this.datoscliente)
                    {
                        if (_this.datoscliente[key].matricula === _this.idcliente){
                            _this.idcliente = _this.datoscliente[key].id;
                            $('#clientep').modal('hide');
                            axios.post('/clientes/buscar/cliente', {
                                id: _this.idcliente,
                            })
                                .then(function (response) {
                                    _this.clientedatos = response['data'][0];
                                    _this.configtj= JSON.parse(response['data'][0].config);
                                    _this.bonos = response['data'][0].total;
                                })
                                .catch(function (error) {
                                    console.log(error);
                                });
                            return
                        }
                    }
                },
                ticket:function ()
                {
                    _this = this

                    axios.post('/ticket/busqueda', {
                        id:_this.idticket
                    })
                        .then(function (response) {
                            if (response['data'] === 'no encontrado') {
                                toastr.warning('ticket no encontrado')
                            }else{
                                _this.datosticket = response['data'][0];
                            }
                            console.log(response);
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                },
                cargartablatp :function ()
                {
                    _this = this;

                    axios.post('/tipo/tarjeta/datos/tabla')
                        .then(function (response) {
                            if (response['data'] === 'vacio'){
                                _this.datostj = ''
                            }else {
                                _this.datostj = response['data'];
                            }

                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                },
                nuevocliente:function ()
                {
                    _this = this

                    if (_this.nombre === '' || _this.telefono === '' || _this.email === '' || _this.matricula === ''|| _this.idtarjeta === '')
                    {
                        toastr.warning('Por favor llenar los campos importantes');
                    }
                    else {
                        axios.post('/clientes/store', {
                            nombre: _this.nombre,
                            telefono: _this.telefono,
                            email: _this.email,
                            matricula: _this.matricula,
                            descuento: _this.descuento,
                            idtarjeta: _this.idtarjeta,
                            observacion: _this.observacion
                        })
                            .then(function (response) {
                                console.log(response);
                                if (response['data'] === 'guardado')
                                {
                                    toastr.success('El cliente ha sido ingresado con exito');
                                    _this.nombre ='';
                                    _this.telefono = '';
                                    _this.email = '';
                                    _this.matricula = '';
                                    _this.descuento = 0;
                                    _this.idtarjeta = '';
                                    _this.observacion = '';
                                    _this.cargartablacliente();
                                    $('#nuevocliente').modal('hide');
                                }
                            })
                            .catch(function (error) {
                                toastr.warning('Se ha prodcido un error');
                                console.log(error);
                            });
                    }
                },
                existencia()
                {
                    _this = this
                    axios.post('/configuracion/existencia')
                        .then(function (response) {
                            _this.existenciarep = response['data']
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                },
                consultRNC()
                {
                    _this = this;
                    axios.post('/rnc/test', {
                        rnc: '0000001'
                    })
                        .then(function (response) {
                            let dataXML =  _this.convertirXmlEnObjeto($.parseXML(response.data));
                            this.rncData  = dataXML['soap:Body']['GetContribuyentesResponse']['GetContribuyentesResult']
                            console.log(this.rncData)
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                },
                convertirXmlEnObjeto(xml) {
                    var objeto = {};
                    var esRaiz = false;

                    //  Objeto "raiz"
                    if (xml.nodeType == 1) { // Objeto
                        // Se recuperan sus atributos
                        if (xml.attributes.length > 0) {
                            for (var j = 0; j < xml.attributes.length; j++) {
                                var atributo = xml.attributes.item(j);
                                objeto[atributo.nodeName] = atributo.nodeValue;
                            }
                        }
                    } else if (xml.nodeType == 3) { // Texto
                        objeto = xml.nodeValue;
                    } else if (xml.nodeType == 9) { // Elemento raiz
                        esRaiz = true;
                    }

                    // Atributos del objeto (objetos hijos)
                    if (xml.hasChildNodes()) {
                        for(var i = 0; i < xml.childNodes.length; i++) {
                            var item = xml.childNodes.item(i);
                            var nombreNodo = item.nodeName;

                            // Si objeto no tiene un atributo con el nombre nombreNodo se anade, si ya lo tiene (es un array) se anade
                            // a la lista del objeto con nombre nombreNodo
                            if (typeof(objeto[nombreNodo]) == "undefined") {
                                // Si el elemento es un CDATA se copia el contenido en el elemento y no se crea un
                                // hijo para almacenar el texto
                                if (nombreNodo == "#cdata-section") {
                                    objeto = item.nodeValue;
                                } else if (nombreNodo == "#text") { // Si el elemento es un texto no se crea el objeto #text
                                    if (item.childNodes.length < 1) {
                                        objeto = item.nodeValue;
                                    } else {
                                        objeto[nombreNodo] = this.convertirXmlEnObjeto(item);
                                    }
                                } else {
                                    if (esRaiz) {
                                        objeto = this.convertirXmlEnObjeto(item);
                                    } else {
                                        objeto[nombreNodo] = this.convertirXmlEnObjeto(item);
                                    }
                                }
                            } else {
                                // Si el atributo no es una lista se convierte el atributo en un array y se anade el
                                // valor a dicho array
                                if (typeof(objeto[nombreNodo].push) == "undefined") {
                                    var valorAtributo = objeto[nombreNodo];
                                    objeto[nombreNodo] = new Array();
                                    objeto[nombreNodo].push(valorAtributo);
                                }

                                objeto[nombreNodo].push(this.convertirXmlEnObjeto(item));
                            }
                        }
                    }

                    return objeto;
                }
            },
            computed:{
                cantidaditems()
                {
                    return this.list.length
                },
                cantidaditemsall()
                {
                    var total = 0;
                    for(var key in this.list)
                    {
                        total = total + this.list[key].count
                    }
                    return total
                },
                facturatotal:function () {


                    var suma = 0;
                    for(var i = 0; i< this.list.length; i++ ){

                        suma = suma + this.list[i].price
                    }
                    return parseFloat(suma).toFixed(2);
                },
                productototal:function () {

                    var suma = 0;
                    for(var i = 0; i< this.list.length; i++ ){

                        suma = suma + this.list[i].count
                    }

                    return suma;
                },
                suma:function () {

                    var suma = (parseFloat(this.campodinero) + parseFloat(this.montotarjeta));

                    return suma;
                },
                devuelta:function () {
                    // var devuelta = suma - this.neto
                    var devuelta = this.suma - this.neto;

                    return parseFloat(devuelta).toFixed(2);
                },
                bruto:function () {

                    if (tipoitbis == 'incluido'){

                        _this = this;

                        var total = 0;
                        var id = 0;

                        for(var i = 0; i< this.list.length; i++ ){

                            id = _this.list[i].id;

                            var producto = this.productos[id];

                            var idp = producto.id;

                            function buscaid(prod) {
                                return prod.id == idp;
                            }

                            var dinero = this.list.find(buscaid).price;
                            var descuento = this.list.find(buscaid).desc;

                            var paso1 = descuento/100;
                            var itbis = producto.itbis;
                            if (itbis == 'si'){

                                var porciento = producto.porciento;

                                var pitbis = parseFloat('1.' + porciento);

                                var bruto = parseFloat(dinero)/ parseFloat(pitbis);
                                var paso2 = bruto * parseFloat(paso1).toFixed(3);
                                var brutodescuento = bruto - parseFloat(paso2).toFixed(3);

                                var itbismultiplicado =  parseFloat(brutodescuento).toFixed(3) * parseFloat('0.'+porciento);

                                itbistotal = parseFloat(itbismultiplicado + itbistotal);

                                brutototal = (bruto + brutototal);

                                total = parseFloat(bruto)  + parseFloat(total)


                            }else{
                                var paso2 = dinero * parseFloat(paso1).toFixed(3);
                                var paso3 = dinero - paso2;
                                total = parseFloat(total + paso3)
                            }
                        }
                        return parseFloat(total).toFixed(2);

                    }
                    if (tipoitbis == 'sumado'){

                        _this = this;

                        var total = 0;
                        var id = 0;

                        for(var i = 0; i< this.list.length; i++ ){

                            id = _this.list[i].id;

                            var producto = this.productos[id];

                            var idp = producto.id;

                            function buscaid(prod) {
                                return prod.id == idp;
                            }
                            var dinero = this.list.find(buscaid).price;
                            var descuento = this.list.find(buscaid).desc;

                            var paso1 = descuento/100;
                            // var paso2 = dinero * parseFloat(paso1).toFixed(3);
                            // var paso3 = dinero - paso2;

                            var itbis = producto.itbis;
                            if (itbis == 'si'){

                                var porciento = producto.porciento;

                                var pitbis = parseFloat('1.' + porciento);

                                var bruto = parseFloat(dinero);
                                var paso2 = bruto * parseFloat(paso1).toFixed(3);
                                var brutodescuento = bruto - parseFloat(paso2).toFixed(3);

                                var itbismultiplicado = parseFloat(brutodescuento).toFixed(3) - parseFloat(dinero);

                                itbistotal = parseFloat(itbismultiplicado);

                                if  (_this.configtj != ''){
                                    if  (_this.configtj['Datos']['tipo'] === 'GDescuento'){
                                        total = parseFloat(bruto)  + parseFloat(total)
                                        var descuentodos = parseInt(_this.configtj['Datos']['Gdescuento']['descuentog']) / 100;
                                        var desc = parseFloat(total) * parseFloat(descuentodos).toFixed(3)
                                        var descmenos = parseFloat(total) - parseFloat(desc).toFixed(3)
                                        total = parseFloat(descmenos)
                                    }else {
                                        total = parseFloat(bruto)  + parseFloat(total)
                                    }
                                }else {
                                    total = parseFloat(bruto)  + parseFloat(total)
                                }


                            }else{
                                var paso2 = dinero * parseFloat(paso1).toFixed(3);
                                var paso3 = dinero - paso2;
                                total = parseFloat(total) + parseFloat(paso3);
                            }
                        }
                        return parseFloat(total).toFixed(2);
                    }

                },
                algoitbis:function () {

                    if (tipoitbis == 'incluido'){
                        _this = this;

                        var total = 0;

                        var id = 0;
                        var otrototal = 0;

                        for(var i = 0; i< this.list.length; i++ ){

                            id = _this.list[i].id;

                            var producto = this.productos[id];

                            var idp = producto.id;

                            function buscaid(prod) {
                                return prod.id == idp;
                            }

                            var dinero = this.list.find(buscaid).price;
                            var descuento = this.list.find(buscaid).desc;
                            var paso1 = descuento/100;
                            var itbis = producto.itbis;

                            if (itbis == 'si'){

                                var porciento = producto.porciento;

                                var pitbis = parseFloat('1.' + porciento);

                                var bruto = parseFloat(dinero)/ parseFloat(pitbis);
                                var paso2 = bruto * parseFloat(paso1);
                                var brutodescuento = bruto - parseFloat(paso2);
                                if  (_this.configtj != ''){
                                    if  (_this.configtj['Datos']['tipo'] === 'GDescuento'){
                                        var descuentodos = parseInt(_this.configtj['Datos']['Gdescuento']['descuentog']) / 100;
                                        var desc = parseFloat(brutodescuento) * parseFloat(descuentodos)
                                        var otro = parseFloat(brutodescuento) - parseFloat(desc)
                                        var itbismultiplicado =  parseFloat(otro) * parseFloat('0.'+porciento);
                                        itbistotal = parseFloat(itbismultiplicado);
                                        total = parseFloat(itbistotal) + parseFloat(total);
                                    }else {
                                        var itbismultiplicado =  parseFloat(brutodescuento) * parseFloat('0.'+porciento);

                                        itbistotal = parseFloat(itbismultiplicado);

                                        total = parseFloat(itbistotal) + parseFloat(total);
                                    }
                                }else {
                                    var itbismultiplicado =  parseFloat(brutodescuento) * parseFloat('0.'+porciento);

                                    itbistotal = parseFloat(itbismultiplicado);

                                    total = parseFloat(itbistotal) + parseFloat(total);
                                }


                            }else{

                                total = (parseFloat(total).toFixed(2) + 0);

                            }
                        }
                        return parseFloat(total).toFixed(2);

                    }
                    if (tipoitbis == 'sumado'){

                        _this = this;

                        var total = 0;
                        var id = 0;

                        for(var i = 0; i< this.list.length; i++ ){

                            id = _this.list[i].id;

                            var producto = this.productos[id];

                            var idp = producto.id;

                            function buscaid(prod) {
                                return prod.id == idp;
                            }
                            var dinero = this.list.find(buscaid).price;
                            var descuento = this.list.find(buscaid).desc;
                            var paso1 = descuento/100;

                            var itbis = producto.itbis;
                            if (itbis == 'si'){

                                var porciento = producto.porciento;

                                var pitbis = parseFloat('1.' + porciento);

                                var bruto = parseFloat(dinero);
                                var paso2 = bruto * parseFloat(paso1).toFixed(3);
                                var brutodescuento = bruto - parseFloat(paso2).toFixed(3);

                                var itbismultiplicado = parseFloat(brutodescuento).toFixed(3) * parseFloat(pitbis).toFixed(3);
                                var itbisresta = parseFloat(itbismultiplicado).toFixed(3) - parseFloat(brutodescuento).toFixed(3) ;

                                itbistotal = parseFloat(itbisresta);

                                total = parseFloat( total) + parseFloat(itbistotal)

                            }else{

                                total = parseFloat(total + 0)
                            }
                        }
                        return parseFloat(total).toFixed(2);
                    }
                },
                totaldescuento:function () {

                    if (tipoitbis == 'incluido'){

                        _this = this;

                        var total = 0;
                        var id = 0;
                        var otrototal = 0;

                        for(var i = 0; i< this.list.length; i++ ){
                            id = _this.list[i].id;

                            var producto = this.productos[id];

                            var idp = producto.id;

                            function buscaid(prod) {
                                return prod.id == idp;
                            }

                            var dinero = this.list.find(buscaid).price;
                            var descuento = this.list.find(buscaid).desc;

                            var paso1 = descuento/100;

                            var itbis = producto.itbis;
                            if (itbis == 'si'){
                                var porciento = producto.porciento;

                                var pitbis = parseFloat('1.' + porciento);

                                var bruto = parseFloat(dinero)/ parseFloat(pitbis);
                                var paso2 = bruto * parseFloat(paso1);
                                var brutodescuento = bruto - parseFloat(paso2);
                                var itbismultiplicado =  parseFloat(brutodescuento)* parseFloat('0.'+porciento);
                                itbistotal = parseFloat(itbismultiplicado + itbistotal);

                                descuentototal = parseFloat(paso2 + descuentototal);

                                if  (_this.configtj != ''){
                                    if  (_this.configtj['Datos']['tipo'] === 'GDescuento'){
                                        var descuentodos = parseInt(_this.configtj['Datos']['Gdescuento']['descuentog']) / 100;
                                        var desc = parseFloat(bruto) * parseFloat(descuentodos)
                                        total = parseFloat(desc) + parseFloat(paso2) + parseFloat(total)
                                    }else {
                                        total = parseFloat( paso2) + parseFloat(total)
                                    }
                                }else {
                                    total = parseFloat(paso2) + parseFloat(total)
                                }

                            }else{

                                var paso2 = dinero * parseFloat(paso1);
                                if  (_this.configtj != ''){
                                    if  (_this.configtj['Datos']['tipo'] === 'GDescuento'){
                                        var descuentodos = parseInt(_this.configtj['Datos']['Gdescuento']['descuentog']) / 100;
                                        var desc = parseFloat(dinero) * parseFloat(descuentodos)
                                        total = desc + parseFloat(total)
                                    }else {
                                        total = parseFloat(paso2) + parseFloat(total)
                                    }
                                }else {
                                    total = parseFloat(paso2) + parseFloat(total)
                                }
                            }
                        }
                        return parseFloat(total).toFixed(2);

                    }
                    if (tipoitbis == 'sumado'){

                        _this = this;

                        var total = 0;
                        var id = 0;

                        for(var i = 0; i< this.list.length; i++ ){

                            id = _this.list[i].id;

                            var producto = this.productos[id];

                            var idp = producto.id;

                            function buscaid(prod) {
                                return prod.id == idp;
                            }
                            var dinero = this.list.find(buscaid).price;
                            var descuento = this.list.find(buscaid).desc;

                            var paso1 = descuento/100;
                            // var paso2 = dinero * parseFloat(paso1).toFixed(3);
                            // var paso3 = dinero - paso2;

                            var itbis = producto.itbis;
                            if (itbis == 'si'){

                                var porciento = producto.porciento;

                                var bruto = parseFloat(dinero);
                                var paso2 = bruto * parseFloat(paso1).toFixed(3);
                                var brutodescuento = bruto - parseFloat(paso2).toFixed(3);

                                var itbismultiplicado = parseFloat(brutodescuento).toFixed(3) - parseFloat(dinero);

                                itbistotal = parseFloat(itbismultiplicado);

                                total = parseFloat(paso2) + parseFloat(total)

                            }else{
                                var paso2 = dinero * parseFloat(paso1).toFixed(3);
                                var paso3 = dinero - paso2;
                                total = parseFloat(total) + parseFloat(paso2);
                            }
                        }
                        return parseFloat(total).toFixed(2);
                    }
                },
                neto:function () {
                    _this = this;
                    var total = 0;
                    var id = 0;

                    for(var i = 0; i< this.list.length; i++ ){
                        if  (_this.datosticket !== ''){
                            var suma = (parseFloat(_this.algoitbis) + (parseFloat(_this.bruto) + parseFloat(_this.leycamarero)) - _this.totaldescuento) - _this.datosticket.balancepuntos;
                            total = suma;
                        }else {
                            var suma = parseFloat(_this.algoitbis) + (parseFloat(_this.bruto) + parseFloat(_this.leycamarero))  - _this.totaldescuento;
                            total = suma;
                        }

                    }
                    return parseFloat(total).toFixed(2);
                },
                leycamarero:function(){
                    _this = this;
                    let porciento = 0;
                    porciento = (_this.bruto - _this.totaldescuento) * 0.10;
                    return _this.setting.leycamarero == "si" ? parseFloat(porciento).toFixed(2) : 0 ;
                },
                puntosagenerar:function () {
                    _this = this;
                    var total = 0;

                    if  (_this.configtj != '')
                    {
                        if  (_this.configtj['Datos']['tipo'] === 'GPuntos')
                        {
                            for(var i = 0; i< this.list.length; i++ ){
                                var suma = parseFloat(_this.neto) / parseInt(_this.configtj['Datos']['Gpuntos']['porcada']);
                                total = parseInt(suma) * parseInt(_this.configtj['Datos']['Gpuntos']['generarpuntos']);
                            }
                        }
                    }
                    return parseInt(total);
                }
            }
        });
    </script>
@endsection