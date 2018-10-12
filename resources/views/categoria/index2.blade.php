@extends('main.app')
@section('tittle','Cafeteria | Categoria')

@section('titulo')
    <h3 style="color: white">Categorias</h3>
@endsection

@section('aside')
    @include('caja.siderbar')
@endsection

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <strong style="color: #0062cc">Categorias</strong>
                <button type="button" class="btn btn-outline-primary btn-sm pull-right"  data-toggle="modal" data-target="#crearcategoria"><i class="fas fa-plus"></i> Nueva Categoria</button>
            </div>
            <div class="card-body">
                    <table class="table">
                        <thead class="" style="background: #0062cc">
                        <tr>
                            <th scope="col"></th>
                            <th scope="col" style="color: whitesmoke">Nombre</th>
                            <th scope="col" style="color: whitesmoke">Codigo</th>
                            <th></th>

                        </tr>
                        </thead>
                        <tbody>
                        @foreach($categorias as $categoria)
                            <tr>
                                <th scope="row"><img class="rounded-circle mx-auto d-block" src="imagenes/{{$categoria->img }}" alt="" style="width: 60px"></th>
                                <td>{{ $categoria->nombre }}</td>
                                <td>{{ $categoria->codigo  }}</td>
                                <td>
                                    <button type="button" @click="categoria('<?php echo $categoria->id; ?>')" class="btn btn-sm btn-warning mb-1" data-toggle="modal" data-target="#editcategoria">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-success btn-sm" @click="cargarid('<?php echo $categoria->id; ?>')" title="Agregar nueva subcategoria" data-toggle="modal" data-target="#createsubcategoria">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-primary btn-sm" @click="versubcategorias('<?php echo $categoria->id; ?>')" title="Ver Subcategorias" data-toggle="modal" data-target="#showsubcategorias">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-danger btn-sm" @click="confimar('<?php echo $categoria->id; ?>')" title="Eliminar Categoria y Subcategorias">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="pull-right">
                        {{ $categorias->links() }}
                    </div>
            </div>
        </div>
    </div>
    @include('categoria.crear')
    @include('categoria.edit')
    @include('categoria.createsubcategoria')
    @include('categoria.showsubcategoria')
    @include('categoria.editsubcategoria')
@endsection

@section('scriptp')
    <script !src="">
        var error = '{!! $errors !!}';


        if (error != '[]') {
            $(function () {
                $('#crearcategoria').modal('show');
            })
        }

    </script>
    <script !src="">
        new Vue({
            el: '#Vue',
            data:{
                listacategoria:[],
                categoriaedit:[],
                subcategoria:[],
                idcategoria:0,
                subcategoriadatos:[],
            },
            methods:{

                confimar2: function (id){
                    var txt;
                    var r = confirm("Estas Seguro que quieres borrar la subcategoria?");
                    if (r == true){
                        txt = this.borrarsubcategoria(id);
                    }
                },
                borrarsubcategoria:function (id){
                    _this = this

                    axios.post('eliminar/subcategoria',{
                        id:id
                    })
                        .then(function (response) {
                            if (response["data"] == 'eliminado'){
                                toastr.success('La subcategoria han sido eliminadas');
                                setTimeout('document.location.reload()',1000);
                            }
                        })
                        .catch(function (error) {
                        });
                },

                confimar: function (id){
                    var txt;
                    var r = confirm("Estas Seguro que quieres borrar las categorias y subcategoria?");
                    if (r == true){
                        txt = this.borrardos(id);
                    }
                },
                borrardos:function (id){
                    _this = this

                    axios.post('eliminar/dos',{
                        id:id
                    })
                        .then(function (response) {
                            if (response["data"] == 'eliminados'){
                                toastr.success('La subcategoria y Categorias han sido eliminadas');
                                setTimeout('document.location.reload()',1000);
                            }
                        })
                        .catch(function (error) {
                        });
                },

                subcategoriaedit:function(id){
                    _this = this

                    axios.post('datos/subcategoria',{
                        id:id
                    })
                        .then(function (response) {

                            _this.subcategoriadatos = response["data"];
                        })
                        .catch(function (error) {
                        });

                },
                versubcategorias:function(id){
                    _this = this

                    axios.post('/mostrar/subcategorias',{
                        id:id
                    })
                        .then(function (response) {

                            _this.subcategoria = response["data"];
                        })
                        .catch(function (error) {
                        });
                },

                cargarid:function (id){
                    _this = this
                    _this.idcategoria = id;
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

                categoria:function (id) {

                    var _this = this;

                    $.ajax({
                        method: 'GET',
                        url: 'categoria/editar/' + id,
                        success:function (data) {
                            _this.categoriaedit =  data;

                        }

                    });
                }
            }
        })
    </script>
@endsection