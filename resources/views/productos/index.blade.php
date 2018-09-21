@extends('main.app')
@section('tittle','Cafeteria | Nuevo Producto')

@section('aside')
    <div>
        <div class="card" style="background: #4272d7">

            <div class="card-body">
                <div class="card-title">
                    <h3 class="text-center title-2" style="color: white">Nuevo Producto</h3>
                </div>
                <hr style="color: white">
                <form action="productos" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group">
                        <label for="cc-payment" class="control-label mb-1" style="color: white">Nombre</label>
                        <input id="cc-pament" name="nombre" minlength="0" required type="text" class="form-control" aria-required="true" aria-invalid="false" value="">
                    </div>
                    <div class="form-group">
                        <label for="precio" class="control-label mb-1" style="color: white">Precio</label>
                        <input type="number" id="precio" min="0" name="precio" required placeholder="$:" class="input-sm form-control-sm form-control">
                    </div>
                    <div class="form-group">
                        <label for="Cbarra" class="control-label mb-1" style="color: white">Codigo de barra</label>
                        <input type="text" id="Cbarra"  name="Cbarra" placeholder="" class="input-sm form-control-sm form-control">
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="existencia" class="control-label mb-1" style="color: white">Existencia</label>
                                <input id="existencia" min="0" name="existencia" type="number" class="form-control cc-exp" value="" data-val="true" data-val-required="Es necesario es te dato"
                                       data-val-cc-exp="Please enter a valid month and year" placeholder="" >
                                <span class="help-block" data-valmsg-for="cc-exp" data-valmsg-replace="true"></span>
                            </div>
                        </div>
                        <div class="col-6">
                            <label for="impuesto" class="control-label mb-1" style="color: white">Impuesto</label>
                            <div class="input-group">
                                <input id="impuesto" min="0" name="impuesto" type="number" class="form-control cc-cvc" value="">
                            </div>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label for="file-input" class=" form-control-label" style="color: white">Imagen</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <input type="file" id="file-input"  name="img" class="form-control-file">
                        </div>
                    </div>
                    <div>
                        <button id="payment-button" type="submit" class="btn btn-lg btn-info btn-block">
                            <i class="fa fa-check-square fa-lg"></i>&nbsp;
                            <span id="payment-button-amount">Guardar</span>
                            <span id="payment-button-sending" style="display:none;">Enviando…</span>
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>

@endsection
@section('content')
    <div id="edit">
        <div class="section__content section__content--p30" >
            <div class="row m-t-30">
                <div class="col-md-12">
                    <!-- DATA TABLE-->
                    <div class="table-responsive m-b-40">
                        <table class="table table-borderless table-data3">
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
                                    <td>{{$producto->price}}</td>
                                    <td>{{$producto->impost}}</td>
                                    <td>
                                        <button type="button" v-on:click="producto('<?php echo $producto->id; ?>')" class="btn btn-sm btn-secondary mb-1" data-toggle="modal" data-target="#largeModal">
                                            Editar
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
        @include('productos.edit')
    </div>
@endsection

@section('scriptp')

    <script>
        new Vue({
            el: '#edit',
            data:{
                datos : [],
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
                updateproducto: function () {

                    $.ajax({
                        url: '/actualizar/producto',
                        method: 'GET',
                        data: {
                            data: this.datos
                        },
                        success:function (dato) {
                            $('#largeModal').modal('hide');
                            toastr.success('El producto se a Actualizado');
                            setTimeout('document.location.reload()',2000);
                        },
                        error:function () {
                            toastr.error('Sea producido un error')
                        }
                    });
                }

            }
        })
    </script>
@endsection
