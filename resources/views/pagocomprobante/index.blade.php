@extends('main.app')
@section('tittle','Cafeteria | Gastos')

@section('titulo')
    <h3 style="color: white"><i class="fas fa-arrow-circle-right"></i>Pago de Comprobante</h3>
@endsection

@section('aside')
    @include('caja.siderbar')
@endsection

@section('content')
    <div class="container" style="margin-top: -50px">
        <div class="card">
            <div class="card-body">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div style="height: 30px;background: #4272d7;margin-bottom: 15px;border-radius: 10px 10px 10px 10px;box-shadow: 0px 0px 2px 0px rgba(0,0,0,0.75);">

                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="container">
                                <div class="text-center" style="padding-left: 40%">

                                    <input type="text" id="vendedor" placeholder="provedor" style="width: 200px" v-model="idprovedor" @keypress.enter="seleccionarprovedor(idprovedor)" list="list" class="form-control text-center form-control-sm">
                                    <datalist id="list">
                                        <template v-for="item in dataprovedores">
                                            <option :value="item.id">@{{ item.nombre }}</option>
                                        </template>
                                    </datalist>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-12" v-if="provedor != ''">
                            <div class="row" style="">
                                <div style="padding-top: 10px" class="col-md-4">
                                    <div class="row form-group">
                                        <div class="col">
                                            <h5>Nombre</h5>
                                        </div>
                                        <div class="col">
                                            <div class="text-left">
                                                <p class="form-control-static">@{{ provedor.nombre }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div style="padding-top: 10px" class="col-md-4">
                                    <div class="row form-group">
                                        <div class="col">
                                            <h5>Telefono</h5>
                                        </div>
                                        <div class="col">
                                            <div class="text-left">
                                                <p class="form-control-static">@{{ provedor.telefono }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div style="padding-top: 10px" class="col-md-4">
                                    <div class="row form-group">
                                        <div class="col">
                                            <h5>Email</h5>
                                        </div>
                                        <div class="col">
                                            <div class="text-left">
                                                <p class="form-control-static">@{{ provedor.email }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="row form-group">
                                        <div class="col">
                                            <h5>Vendedor</h5>
                                        </div>
                                        <div class="col">
                                            <div class="text-left">
                                                <p class="form-control-static">@{{ provedor.vendedor }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="row form-group">
                                        <div class="col">
                                            <h5>Cedula</h5>
                                        </div>
                                        <div class="col">
                                            <div class="text-left">
                                                <p class="form-control-static">@{{ provedor.cedula }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="row form-group">
                                        <div class="col">
                                            <h5>Total Facturas</h5>
                                        </div>
                                        <div class="col">
                                            <div class="text-left">
                                                <p class="form-control-static">$ @{{ totalfactura }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <hr style="background: #4272d7">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12" style="margin-top: 10px;margin-bottom: 10px" v-if="provedor != ''">
                            <div class="text-center" style="padding-left: 40%">
                                <input type="text" id="vendedor" placeholder="Monto" @keypress.enter="subtraccion(monto)" min="0" style="width: 200px" v-model="monto" class="form-control text-center form-control-sm">
                                <button type="button" @click="subtraccion(monto)" :disabled="monto == ''" class="btn btn-primary btn-sm"><i class="fas fa-share-alt"></i> Repartir Monto</button>
                                <button type="button" class="btn btn-danger btn-sm" @click="subtraccion(0)"><i class="fas fa-paint-brush"></i> Limpiar</button>
                            </div>
                        </div>
                        <div class="col-md-12" style="margin-top: 10px" v-if="provedor != ''">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col">#Factura</th>
                                        <th scope="col">Fecha</th>
                                        <th scope="col">Tipo Gasto</th>
                                        <th scope="col">Total</th>
                                        <th scope="col">Balance</th>
                                        <th scope="col">Monto a Pagar</th>
                                        <th scope="col">Balance Restante</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <template v-if="comprobantesprovedor != 'no resultado' && loading == false">
                                        <template v-for="(item, index) in comprobantesprovedor">
                                            <datostabla :key="index" :id="item.id" :factura="item.factura_ref" :fecha="item.date" :tipogasto="item.tipogasto" :netototal="item.netototal" :balance="item.balance" :apagar="item.montoapagar" :provedor="idprovedor" :bus="bus"></datostabla>
                                        </template>
                                    </template>
                                    <template v-else-if=" loading == true">
                                        <tr>
                                            <div class="" style="position: relative;left: 400px">
                                                <img src="/loading.gif" width="100" alt="">
                                            </div>
                                        </tr>
                                    </template>
                                    <template v-else>
                                        <tr>
                                            <th scope="row"></th>
                                            <td>No</td>
                                            <td>se</td>
                                            <td>encontro</td>
                                            <td>Resultado</td>
                                            <td></td>
                                        </tr>
                                    </template>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-12" style="margin-top: 15px" v-show="comprobantesprovedor != ''">
                            <div class="text-center">
                                <button type="button" class="btn btn-primary" :disabled="comprobantesprovedor == 'no resultado'" @click="pagar"><i class="fas fa-money-bill-alt"></i> Pagar</button>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div style="height: 30px;background: #4272d7;border-radius: 10px 10px 10px 10px;margin-top: 15px;box-shadow: 0px 0px 2px 0px rgba(0,0,0,0.75);">
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


        // const eventBus = new Vue();

        Vue.component('datostabla', {
            template:'' +
                '<tr>\n' +
                '    <th scope="row">@{{ factura }}</th>\n' +
                '    <td>@{{ fecha }}</td>\n' +
                '    <td>@{{ tipogasto }}</td>\n' +
                '    <td>@{{ netototal }}</td>\n' +
                '    <td>@{{ balance }}</td>\n' +
                '    <td><input type="number" style="width: 100px" v-model="apagar"  min="0" class="form-control" id="" placeholder=""></td>\n' +
                '    <td>@{{ balancenuevo }}</td>\n' +
                '</tr>',
            props:['id', 'fecha', 'factura' ,'tipogasto', 'netototal', 'balance', 'apagar', 'provedor', 'bus'],
            data() {
                return {
                    montopagar:0,
                }
            },
            methods:{
                pagarrr()
                {
                    _this = this;
                    if  (_this.apagar != 0)
                    {
                        axios.post('/pago/comprobante', {
                            idcomprobante:_this.id,
                            balance:_this.balancenuevo,
                            suplidor:_this.provedor,
                            montopagado:_this.apagar
                        })
                            .then(function (response) {
                                toastr.success('Guardado con exito', 'Validador')
                            })
                            .catch(function (error) {
                                toastr.error('Se ha producido un error')
                            });
                    }
                }
            },
            computed:{
                balancenuevo()
                {
                    _this = this;
                    var resta = parseFloat(_this.balance) - parseFloat(_this.apagar);

                    if(resta < 0){
                        return 0;
                    }else if(resta >= 0)
                    {
                        return parseFloat(resta).toFixed(2);
                    }
                },

            },
            mounted() {
                this.bus.$on('ejecutar', this.pagarrr)
            }


        });


        new Vue({
            el: '#Vue',
            data(){
                return {
                    dataprovedores:'',
                    idprovedor:'',
                    provedor:'',
                    comprobantesprovedor:[],
                    loading:false,
                    monto:'',
                    sobrante:0,
                    bus: new Vue(),
                }
            },
            mounted(){
                _this = this;
                _this.listaprovedores()
            },
            methods:{
                listaprovedores()
                {
                    _this = this;
                    axios.post('/provedores/todos/provedores')
                        .then(function (response){
                            _this.dataprovedores = response['data'];
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                },
                seleccionarprovedor(i)
                {
                    _this = this;
                    for (var key in _this.dataprovedores)
                    {
                        if (_this.dataprovedores[key].id == i)
                        {
                            _this.provedor = _this.dataprovedores[key];
                            _this.loading = true;
                            _this.buscarcomprobanteprovedor(i);
                            break
                        }
                    }
                },
                buscarcomprobanteprovedor(i)
                {
                    _this = this
                    axios.post('/entrada/comprobante/provedor', {
                        id:i
                    })
                        .then(function (response) {
                            _this.comprobantesprovedor = response['data'];
                            _this.loading= false;
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                },
                pagocomprobante()
                {
                    _this = this;
                    axios.post('/entrada/comprobante/pago', {
                        monto: _this.monto,
                        comprobantes: _this.comprobantesprovedor
                    })
                        .then(function (response) {
                            _this.buscarcomprobanteprovedor(_this.idprovedor);
                            console.log(response);
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                },
                subtraccion(monto)
                {
                    _this = this;

                    if (monto == 0)
                    {
                        _this.buscarcomprobanteprovedor(_this.idprovedor)
                    }else {
                        var monto1 = monto;
                        dinero = monto;
                        for (var key in _this.comprobantesprovedor)
                        {
                            monto1 =  parseFloat(monto1) -  parseFloat(_this.comprobantesprovedor[key].balance);
                            var resta = parseFloat(dinero) - parseFloat(_this.comprobantesprovedor[key].balance);
                            if(resta > 0){
                                _this.comprobantesprovedor[key].montoapagar = _this.comprobantesprovedor[key].balance
                            }else{
                                _this.comprobantesprovedor[key].montoapagar = parseInt(dinero);
                            }
                            dinero = resta;
                            if (dinero < 0 )
                            {
                                dinero = 0;
                            }

                        }
                    }
                },
                pagar()
                {
                    _this = this;
                    this.bus.$emit('ejecutar');
                    setTimeout('_this.buscarcomprobanteprovedor(_this.idprovedor)',1000);
                }
            },
            computed:{
                totalfactura()
                {
                    _this = this

                    var total = 0;

                    for (var key in _this.comprobantesprovedor)
                    {
                        total = total + parseFloat(_this.comprobantesprovedor[key].balance)
                    }

                    return parseFloat(total).toFixed(2)
                }
            }

        })

    </script>

@endsection