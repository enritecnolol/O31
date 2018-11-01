@extends('main.app')
@section('tittle','Cafeteria | Clientes')
@section('titulo')
    <h3 style="color: white"><i class="fas fa-arrow-circle-right"></i> Clientes</h3>
@endsection

@section('aside')
    @include('caja.siderbar')
@endsection

@section('content')
    <div class="container" style="margin-top: -40px">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12" style="background: #4272d7">
                                    <div class="pull-left" style="margin-top: 5px; margin-bottom: 5px">
                                        <h3 style="color: white; font-weight: bolder">Lista de Clientes</h3>
                                    </div>
                                    <div class="pull-right" v-show="formcliente == false" style="margin-top: 5px; margin-bottom: 5px">
                                        <button type="button" @click="formcliente = true" class="btn btn-primary btn-sm">
                                            <i class="fas fa-user-plus"></i>&nbsp; Nuevo Cliente</button>
                                    </div>
                                    <div class="pull-right" v-show="formcliente == true" style="margin-top: 5px; margin-bottom: 5px">
                                        <button type="button" @click="formcliente = false" class="btn btn-danger btn-sm">
                                            <i class="fas fa-chevron-up"></i>&nbsp; ocultar</button>
                                    </div>
                                </div>

                                <div class="col-md-12" v-show="formcliente == true" style="margin-top: 10px">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="text-center">
                                                    <h3>Crear Nuevo Cliente</h3>
                                                    <br>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="company" class=" form-control-label">Nombre</label>
                                                    <input type="text" id="company" placeholder="Enter your company name" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="company" class=" form-control-label">Telefono</label>
                                                    <input type="text" id="company" placeholder="Enter your company name" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="company" class=" form-control-label">Matricula</label>
                                                    <input type="text" id="company" placeholder="Enter your company name" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="company" class=" form-control-label">Email</label>
                                                    <input type="text" id="company" placeholder="Enter your company name" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="company" class=" form-control-label">Descuento</label>
                                                    <input type="text" id="company" placeholder="Enter your company name" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="company" class=" form-control-label">Tipo de tarjeta</label>
                                                    <select name="select" id="select" class="form-control">
                                                        <option value="0">Please select</option>
                                                        <option value="1">Option #1</option>
                                                        <option value="2">Option #2</option>
                                                        <option value="3">Option #3</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12" style="margin-top: 15px">
                                   <div class="container">
                                       <table class="table table-bordered">
                                           <thead>
                                           <tr>
                                               <th scope="col">#</th>
                                               <th scope="col">First</th>
                                               <th scope="col">Last</th>
                                               <th scope="col">Handle</th>
                                           </tr>
                                           </thead>
                                           <tbody>
                                           <tr>
                                               <th scope="row">1</th>
                                               <td>Mark</td>
                                               <td>Otto</td>
                                               <td>@mdo</td>
                                           </tr>
                                           <tr>
                                               <th scope="row">2</th>
                                               <td>Jacob</td>
                                               <td>Thornton</td>
                                               <td>@fat</td>
                                           </tr>
                                           <tr>
                                               <th scope="row">3</th>
                                               <td colspan="2">Larry the Bird</td>
                                               <td>@twitter</td>
                                           </tr>
                                           </tbody>
                                       </table>
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
    <script !src="">
        new Vue({
            el: '#Vue',
            data:{
                formcliente: false
            },
            watch:{

            },
            methods:{
                nuevocliente:function () {

                }
            },
            computed:{

            }
        })
    </script>
@endsection