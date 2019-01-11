@extends('main.app')
@section('tittle','Cafeteria | Nuevo Producto')

@section('titulo')
    <h3 style="color: white">Productos</h3>
@endsection
@section('aside')
    @include('caja.siderbar')
@endsection
@section('content')
    <div class="container" style="margin-top: -20px">
        <nav class="navbar navbar-light" style="background-color: #0069d9;border-radius: 5px 10px 15px 20px;box-shadow: 1px 2px 18px -1px rgba(0,0,0,0.75);">
            <a class="navbar-brand" href="#" style="color: whitesmoke"><i class="fas fa-list-ul"></i> Lista de Productos</a>
            <input type="search" class="form-control col-md-3 " v-model="buscador"  :input.self="buscadorp(buscador)" placeholder="Buscar..." name="" id="busca">

            <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#crear" @click="cargarcategoria()"><i class="fas fa-plus"></i> Nuevo Producto</button>
        </nav>
    </div>
    @include('productos.newproduct')


    <div class="container" v-if="buscador == ''" >
        <div class="row m-t-30">
            <div class="col-md-12">
                <!-- DATA TABLE-->
                <div class="table-responsive" style="border-radius: 5px 10px 15px 20px;box-shadow: 1px 2px 18px -1px rgba(0,0,0,0.75);">
                    <table class="table table-borderless table-data3 table-hover" style="">
                        <thead>
                        <tr>
                            <th>
                                {{--<select v-model="paginate" @change="productosp()" class="form-control form-control-sm">--}}
                                    {{--<option value="5">5</option>--}}
                                    {{--<option value="10">10</option>--}}
                                    {{--<option value="15">15</option>--}}
                                    {{--<option value="20">20</option>--}}
                                {{--</select>--}}

                                <input type="range" @mouseleave="productosp()" v-model="paginate" class="custom-range" min="5" max="15" id="customRange2">
                            </th>
                            <th>Nombre</th>
                            <th>Codigo</th>
                            <th>Existencia</th>
                            <th>Precio</th>
                            <th>Impuesto</th>
                            <th>Editar</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="p in productospag">
                            <td><img class="rounded-circle mx-auto d-block" :src="'imagenes/'+p.img" alt="" style="width: 60px"></td>
                            <td>@{{p.name }}</td>
                            <td>@{{p.barcode}}</td>
                            <td>@{{p.existence}}</td>
                            <td><strong>@{{p.price}}.00</strong></td>
                            <td>@{{p.porciento}}%</td>
                            <td>
                                <button type="button" @click="producto(p.id)" class="btn btn-sm btn-warning mb-1" data-toggle="modal" data-target="#largeModal">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-outline-danger btn-sm" @click="confimar(p.id)" title="Eliminar Producto">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </td>
                        </tr>
                        <template v-if="loading == true">
                            <tr>
                                <div class="" style="position: relative;left: 450px">
                                    <img src="loading.gif" width="100" alt="">
                                </div>
                            </tr>
                        </template>
                        </tbody>
                    </table>
                </div>
                <br>
                <div class="pull-right">
                    <nav v-if="pagination.last_page>1" aria-label="Page navigation example">
                        <ul class="pagination justify-content-center">
                            <li v-if="pagination.current_page==1" class="page-item disabled">
                                <a class="page-link" href="#" tabindex="-1">Anterior</a>
                            </li>
                            <li v-else class="page-item">
                                <a class="page-link" href="#" tabindex="-1" @click="productosp(pagination.prev_page_url)">Anterior</a>
                            </li>

                            <li v-for="page in pagination.last_page" v-if="pagination.current_page==page" class="page-item active">
                                <a class="page-link" href="#">@{{ page }}</a>
                            </li>
                            <li v-else class="page-item">
                                <a class="page-link" href="#" @click="productosp(pagination.path+'?page='+page)">@{{ page }}</a>
                            </li>
                            <li v-if="pagination.current_page==pagination.last_page" class="page-item disabled">
                                <a class="page-link" href="#">Siguiente</a>
                            </li>
                            <li v-else class="page-item">
                                <a class="page-link" href="#" @click="productosp(pagination.next_page_url)">Siguiente</a>
                            </li>
                        </ul>
                    </nav>
                </div>
                <br>
                <br>
                <br>

            </div>
        </div>
    </div>

    <div class="container" v-else>
        <div class="row m-t-30">
            <div class="col-md-12">
                <!-- DATA TABLE-->
                <div class="table-responsive m-b-40">
                    <table class="table table-borderless table-data3 table-hover">
                        <thead>
                        <tr>
                            <th></th>
                            <th>Nombre</th>
                            <th>Codigo</th>
                            <th>Existencia</th>
                            <th>Precio</th>
                            <th>Impuesto</th>
                            <th>Editar</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="p in productos">
                            <td><img class="rounded-circle mx-auto d-block" :src="'imagenes/'+p.img" alt="" style="width: 60px"></td>
                            <td>@{{ p.name }}</td>
                            <td>@{{p.barcode}}</td>
                            <td>@{{p.existence}}</td>
                            <td><strong>@{{p.price}}.00</strong></td>
                            <td>@{{p.impost}}</td>
                            <td>
                                <button type="button" @click="producto(p.id)" class="btn btn-sm btn-warning mb-1" data-toggle="modal" data-target="#largeModal">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-outline-danger btn-sm" @click="confimar(p.id)" title="Eliminar Producto">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <!-- END DATA TABLE-->

            </div>
        </div>
    </div>

    @include('productos.edit')
    @include('categoria.nueva')
    @include('categoria.createsubcategoriarapida')
@endsection

@section('scriptp')
    <script !src="">
        var error = '{!! $errors !!}';


        if (error != '[]') {
            $(function () {
                $('#crear').modal('show');
            })
        }

    </script>
    <script>
        new Vue({
            el: '#Vue',
            data:{
                datos : [],
                buscador:'',
                productos: '',
                someData:'',
                image: '',
                files: new FormData(),
                tipop: '',
                no : 'no',
                nombrecategoria:'',
                codigocategoria: '',
                listacategoria: [],
                listasubcategoria:'',
                idsubcategoria:'',
                nombresubcategoria: '',
                listasubcategoriaedit:'',
                check:false,
                refimpuesto:'',
                existenciarep:'',
                productospag:[],
                pagination:{},
                paginate:5,
                loading:false

            },
            mounted(){
                _this = this;
                _this.datorefimpuesto();
                _this.cargarcategoria();
                _this.cargarsubcategoria();
                _this.existencia();
                _this.productosp();
            },
            methods:{
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
                datorefimpuesto:function (){
                    axios.post('/impuestoref/datos/producto',)
                        .then(function (response) {
                            _this.refimpuesto = response['data'];
                            console.log(response['data'])
                        })
                        .catch(function (error) {
                        });
                },
                confimar: function (id){
                    var txt;
                    var r = confirm("Estas Seguro que quieres borrar este producto?");
                    if (r == true){
                        txt = this.borrar(id);
                    }
                },
                borrar:function (id){
                    _this = this

                    axios.post('eliminar/producto',{
                        id:id
                    })
                        .then(function (response) {
                            if (response["data"] == 'eliminado'){
                                toastr.success('El producto ha sido eliminado');
                                setTimeout('document.location.reload()',1000);
                            }
                        })
                        .catch(function (error) {
                        });
                },

                subcategoria:function(){
                    // console.log(this.idsubcategoria);
                    var _this = this;
                    axios.post('subcategoria/producto', {
                        id:_this.idsubcategoria
                    })
                        .then(function (response) {
                            _this.listasubcategoria = response["data"];
                        })
                        .catch(function (error) {
                        });

                },
                nuevasubcategoria:function (){
                    var _this = this;
                    axios.post('subcategoria/rapida', {
                        nombre:_this.nombresubcategoria,
                        idcategoria: _this.idsubcategoria
                    })
                        .then(function (response) {
                            console.log(response)
                            if (response["data"] == 'bien'){
                                $('#createsubcategoria').modal('hide');
                                toastr.success('La subcategoria se a creado correctamente');
                                _this.subcategoria();
                            }
                        })
                        .catch(function (error) {
                            toastr.error('Ha ocurrido un error');
                        });
                },
                producto: function (id) {
                    var _this = this;
                    $.ajax({
                        method: 'GET',
                        url: 'productos/' + id,
                        success:function (data) {
                            if (data.itbis == 'si'){
                                _this.check = true
                            }else {
                                _this.check = false
                            }
                            _this.datos =  data;

                        }

                    });
                },

                onFileChange(e) {
                    var files = e.target.files || e.dataTransfer.files;
                    if (!files.length)
                        return;
                    this.createImage(files[0]);
                },
                createImage(file) {
                    var image = new Image();
                    var reader = new FileReader();
                    var vm = this;

                    reader.onload = (e) => {
                        vm.image = e.target.result;
                    };
                    reader.readAsDataURL(file);
                },

                removeImage: function (e) {
                    this.image = '';
                },


                fileChange(fileList) {
                    this.files.append("file", fileList[0], fileList[0].name);
                },

                buscadorp:function () {
                    var _this = this
                    // $.ajax({
                    //     url: '/buscar',
                    //     method: 'GET',
                    //     data: {
                    //         producto: this.buscador
                    //     },
                    //     success:function (data) {
                    //         _this.productos = data;
                    //     }
                    //
                    // });
                },

                crearcategoria: function (id) {
                    var _this = this;
                    axios.post('/crear/categoria', {
                        nombre: this.nombrecategoria,
                        codigo: this.codigocategoria
                    })
                        .then(function (response) {
                            console.log(response);
                            $('#nuevacategoria').modal('hide');
                            toastr.success('categoria Creada');
                            _this.cargarcategoria();
                        })
                        .catch(function (error) {
                            toastr.warning('El codigo o el nombre de la categoria esta registrado');
                        });
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
                cargarsubcategoria: function () {
                    var _this = this;

                    axios.post('/ver/subcategorias')
                        .then(function (response) {
                            _this.listasubcategoriaedit = response["data"];
                        })
                        .catch(function (error) {
                        });
                },
                productosp:function (url) {
                    _this = this;
                    _this.loading = true
                    url = url || '/productos/paginate';

                    axios.post(url, {
                            paginate:_this.paginate
                    })
                        .then(function (response) {
                            console.log(response);
                            _this.productospag = response['data'].data;
                            _this.setpaginator(response['data'])
                            _this.loading = false
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                },
                setpaginator:function (data){
                    _this = this

                    let pagination = {
                        current_page: data.current_page,
                        path: data.path,
                        last_page: data.last_page,
                        first_page_url: data.first_page_url,
                        next_page_url: data.next_page_url,
                        prev_page_url: data.prev_page_url,
                        last_page_url: data.last_page_url
                    };
                    _this.pagination = pagination;
                },
            }
        })
    </script>
@endsection
