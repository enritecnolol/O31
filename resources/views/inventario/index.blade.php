@extends('main.app')
@section('tittle','SofiaRD | Control de Inventario')

@section('titulo')
    <h3 style="color: white"><i class="fas fa-arrow-circle-right"></i> Control de Inventario</h3>
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
            background: url("{{URL::asset('403.gif')}}") 50% 50% no-repeat rgb(249,249,249);
            opacity: .8;
        }
    </style>
@endsection

@section('aside')
    @include('caja.siderbar')
@endsection

@section('content')
    <div class="loader" v-if="existenciarep == 'no'"> <h3 style="color: red;position: absolute;left: 35%;top: 30%;"> Usted no tiene acceso al control de inventario</h3></div>
    <div class="container" style="margin-top: -40px">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="text-center">
                            <h3 style="color: #4272d7">
                                <u>Registro de Compra</u>
                            </h3>
                        </div>
                    </div>
                    <div class="col-md-12" style="margin-top: 15px">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="row form-group">
                                        <div class="col col-md-3">
                                            <label for="fecha" class=" form-control-label">Fecha</label>
                                        </div>
                                        <div class="col-12 col-md-9">
                                            <input type="date" id="fecha" value="" v-model="fecha" class="form-control form-control-sm">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="row form-group">
                                        <div class="col col-md-3">
                                            <label for="vendedor" class=" form-control-label">Provedor</label>
                                        </div>
                                        <div class="col-12 col-md-9">
                                            <input type="text" id="vendedor" v-model="vendedor" class="form-control form-control-sm">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="row form-group">
                                        <div class="col col-md-3">
                                            <label for="cantidad" class=" form-control-label">Cantidad</label>
                                        </div>
                                        <div class="col-12 col-md-9">
                                            <input type="number" id="cantidad" v-model="cantidad" placeholder="$" class="form-control form-control-sm">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="nota" class=" form-control-label">Nota </label>
                                        <textarea id="nota" class="form-control form-control-sm" v-model="nota" rows="3"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6" style="margin-top: 15px">
                        <div class="container">
                            <input type="text" placeholder="Buscar producto" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="col-md-6" style="margin-top: 15px">
                        <div class="container">
                            <input type="text" placeholder="Buscar producto" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="col-md-12" style="margin-top: 15px">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="table-responsive" style="height: 500px;overflow-y: scroll">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th scope="col">Producto</th>
                                            <th scope="col">Existencia</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <template v-for="item in productos">
                                            <tr>
                                                <th scope="row">@{{ item.name }}</th>
                                                <td>@{{ item.existence }}</td>
                                                <td><button type="button" class="btn btn-primary btn-sm" @click="pasarnuevaexistencia(item.id)"><i class="fas fa-arrow-circle-right"></i></button></td>
                                            </tr>
                                        </template>
                                        <template v-if=" loading == true">
                                            <tr>
                                                <div class="" style="position: relative;left: 200px">
                                                    <img src="/loading.gif" width="100" alt="">
                                                </div>
                                            </tr>
                                        </template>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="table-responsive" style="height: 500px;overflow-y: scroll">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th scope="col">Producto</th>
                                            <th scope="col">Existencia</th>
                                            <th scope="col">Cantidad Comprada</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <template v-for="item in productosnuevos">
                                            <tr>
                                                <th scope="row">@{{ item.name }}</th>
                                                <td>@{{ item.existence }}</td>
                                                <td><input type="number" style="width: 150px" min="0" v-model="item.status" class="form-control form-control-sm"></td>
                                                <td><div style="cursor: pointer;font-size: 24px" @click="eliminarnuevaexistencia(item.id)">&times;</div></td>
                                            </tr>
                                        </template>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-12" style="margin-top: 10px">
                                <div class="text-center">
                                    <button type="button" class="btn btn-primary" @click="validarnuevaexistencia"><i class="fas fa-save"></i> Guardar</button>
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
    <script >
        new Vue({
            el: '#Vue',
            data()
            {
                return{
                    productos:[],
                    productosnuevos:[],
                    loading:false,
                    fecha:'{{date('Y-m-d')}}',
                    vendedor:'',
                    nota:'',
                    cantidad:'',
                    existenciarep:''
                }
            },
            mounted()
            {
                _this = this;
                _this.todosproductos();
                _this.existencia();
            },
            methods: {
                todosproductos()
                {
                    _this = this;
                    _this.loading =true;
                    axios.post('/todos/productos')
                        .then(function (response) {
                            console.log(response);
                            _this.productos = response['data'];
                            _this.loading =false
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                },
                pasarnuevaexistencia(i)
                {
                    _this = this;
                    for (var key in _this.productos)
                    {
                        if (_this.productos[key].id == i)
                        {
                            _this.productosnuevos.push(_this.productos[key]);
                            var index = _this.productos.indexOf(_this.productos[key]);
                            console.log(index);
                            if (index > -1) {
                                _this.productos.splice(index, 1);
                            }
                            return
                        }
                    }
                },
                eliminarnuevaexistencia(i)
                {
                    _this = this;
                    for (var key in _this.productosnuevos)
                    {
                        if (_this.productosnuevos[key].id == i)
                        {
                            _this.productos.push(_this.productosnuevos[key]);
                            _this.productosnuevos.splice(key, 1);
                            return
                        }
                    }
                },
                validarnuevaexistencia(){
                    _this = this
                    for (var key in _this.productosnuevos)
                    {
                        if (_this.productosnuevos[key].status <= 0)
                        {
                            toastr.warning('Por favor revisar los productos con nueva existencia', 'Validador')
                            return
                        }
                    }
                    _this.registrarcompra();
                },
                registrarcompra()
                {
                    _this = this;
                    if (_this.fecha == '' || _this.vendedor == '' || _this.nota == '' || _this.cantidad == '')
                    {
                        toastr.warning('Por favor llenar todos los campos vacios', 'Validador');
                    }else {
                        axios.post('/store/compra', {
                            fecha: _this.fecha,
                            vendedor: _this.vendedor,
                            nota: _this.nota,
                            cantidad:_this.cantidad,
                            productoscomprados: _this.productosnuevos,
                        })
                            .then(function (response) {
                                toastr.success('Datos Guardado Con Exito', 'Validador')
                                _this.productosnuevos = []
                                _this.todosproductos();
                            })
                            .catch(function (error) {
                                toastr.error('Se ha producido un error', 'Error')
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
                }
            },
            computed:{

            }
        })

    </script>

@endsection