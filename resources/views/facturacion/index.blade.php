@extends('main.app')
@section('tittle','Cafeteria | Facturacion')

@section('titulo')
    <h3 style="color: white"><i class="fas fa-arrow-circle-right"></i> Facturacion</h3>
@endsection

@section('aside')
    @include('caja.siderbar')
@endsection

@section('content')
    <div class="container" style="margin-top: -40px">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div>
                            <div class="row form-group">
                                <div class="col col-md-2">
                                    <label for="text-input" class="form-control-label">Tipo NCF:</label>
                                </div>
                                <div class="col-12 col-md-4">
                                    <select class="form-control form-control-sm" id="">
                                        <option>1</option>
                                        <option>2</option>
                                        <option>3</option>
                                        <option>4</option>
                                        <option>5</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col col-md-2">
                                    <label for="text-input" class="form-control-label">Tipo:</label>
                                </div>
                                <div class="col-12 col-md-4">
                                    <select class="form-control form-control-sm" id="exampleFormControlSelect1">
                                        <option>Contado</option>
                                        <option>Credito</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col col-md-2">
                                    <label for="text-input" class="form-control-label">Cliente:</label>
                                </div>
                                <div class="col-12 col-md-4">
                                    <input type="text" class="form-control form-control-sm" id="">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label for="text-input" class="form-control-label">Nombre: </label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <input type="text" class="form-control form-control-sm" id="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label for="text-input" class="form-control-label">Direcc:</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <input type="text" class="form-control form-control-sm" id="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label for="text-input" class="form-control-label">Ciudad:</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <input type="text" class="form-control form-control-sm" id="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label for="text-input" class="form-control-label">Tel(s):</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <input type="text" class="form-control form-control-sm" id="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label for="text-input" class="form-control-label">Cedula:</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <input type="text" class="form-control form-control-sm" id="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12" style="margin-top: 15px;">
                        <table class="table">
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
                                <td>Larry</td>
                                <td>the Bird</td>
                                <td>@twitter</td>
                            </tr>
                            </tbody>
                        </table>
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
            data(){
                return {

                }
            },
            mounted(){

            },
            methods:{

            },
            computed:{

            }
        })

    </script>

@endsection