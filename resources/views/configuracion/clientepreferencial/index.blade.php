@extends('main.app')
@section('tittle','SofiaRD | Configuración | Cliente preferencial')

@section('titulo')
    <h3 style="color: white"><i class="fas fa-arrow-circle-right"></i> Cliente Preferencial</h3>
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
                        <div class="row">
                            <div class="col-md-12">
                                <div class="text-center">
                                    <h3>Cliente</h3>
                                </div>
                            </div>
                            <div class="col-md-12" style="margin-top: 15px">
                                <div class="container">
                                    <div class="row">

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
            data: {

            },watch:{

            },
            methods:{

            },
            computed:{

            }
        })
    </script>
@endsection