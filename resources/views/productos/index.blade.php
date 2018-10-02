@extends('main.app')
@section('tittle','Cafeteria | Nuevo Producto')

@section('titulo')
    <h3 style="color: white">Productos</h3>
@endsection
@section('aside')
    @include('caja.siderbar')
@endsection
@section('content')
    <div class="container">
        <nav class="navbar navbar-light" style="background-color: #0069d9;">
            <a class="navbar-brand" href="#" style="color: whitesmoke"><i class="fas fa-list-ul"></i> Lista de Productos</a>
            <input type="search" class="form-control col-md-3 " v-model="buscador"  v-on:input.self="buscadorp(buscador)" placeholder="Buscar..." name="" id="busca">

            <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#crear"><i class="fas fa-plus"></i> Nuevo Producto</button>
        </nav>
    </div>
    @include('productos.newproduct')
    <div id="edit">

        <div class="section__content section__content--p30" v-if="buscador == ''" >
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
                            @foreach($productos as $producto)
                                <tr>
                                    <td><img class="rounded-circle mx-auto d-block" src="imagenes/{{$producto->img }}" alt="" style="width: 60px"></td>
                                    <td>{{ $producto->name }}</td>
                                    <td>{{$producto->barcode}}</td>
                                    <td>{{$producto->existence}}</td>
                                    <td><strong>{{$producto->price}}</strong></td>
                                    <td>{{$producto->impost}}</td>
                                    <td>
                                        <button type="button" v-on:click="producto('<?php echo $producto->id; ?>')" class="btn btn-sm btn-warning mb-1" data-toggle="modal" data-target="#largeModal">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- END DATA TABLE-->
                </div>
            </div>
        </div>

        <div class="section__content section__content--p30" v-else>
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
                                <td><strong>@{{p.price}}</strong></td>
                                <td>@{{p.impost}}</td>
                                <td>
                                    <button type="button" v-on:click="producto(p.id)" class="btn btn-sm btn-warning mb-1" data-toggle="modal" data-target="#largeModal">
                                        <i class="fas fa-edit"></i>
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
    </div>
@endsection

@section('scriptp')
    <script>
        new Vue({
            el: '#Vue',
            data:{
                datos : [],
                buscador:'',
                productos: '',
                someData:'',
                image: '',
                files: new FormData()
            },
            methods:{
                producto: function (id) {
                    var _this = this;
                    $.ajax({
                        method: 'GET',
                        url: 'productos/' + id,
                        success:function (data) {
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
                    $.ajax({
                        url: '/buscar',
                        method: 'GET',
                        data: {
                            producto: this.buscador
                        },
                        success:function (data) {
                            _this.productos = data;
                        }

                    });
                },


            }
        })
    </script>
@endsection
