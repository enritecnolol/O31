@extends('main.app')
@section('tittle','Cafeteria | Categoria')

@section('titulo')
    <h3 style="color: white">Categorias</h3>
@endsection

@section('aside')
    @include('caja.siderbar')
@endsection

@section('content')
    <div class="container" v-on:mousemove="cargarcategoria()">
        <div class="card">
            <div class="card-header">
                <strong style="color: #0062cc">Categorias</strong>
                <button type="button" class="btn btn-primary btn-sm pull-right"  data-toggle="modal" data-target="#crearcategoria">Nueva Categoria</button>
            </div>
            <div class="card-body">
                <template>
                    <h2></h2>
                </template>
                <tempalte>
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
                        <template v-for="c in listacategoria">
                            <tr>
                                <th scope="row"><img class="rounded-circle mx-auto d-block" :src="'imagenes/'+c.img" alt="" style="width: 60px"></th>
                                <td>@{{ c.nombre }}</td>
                                <td>@{{ c.codigo }}</td>
                                <td>
                                    <button type="button" @click="categoria(c.id)" class="btn btn-sm btn-warning mb-1" data-toggle="modal" data-target="#editcategoria">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </td>
                            </tr>
                        </template>
                        </tbody>
                    </table>
                </tempalte>
            </div>
        </div>
    </div>
    @include('categoria.crear')
    @include('categoria.edit')
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
                categoriaedit:[]
            },
            methods:{

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