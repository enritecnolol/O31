@extends('main.app')
@section('tittle','O31 | Devolucion de Producto')

@section('titulo')
    <h3 style="color: white"><i class="fas fa-arrow-circle-right"></i> Devolución </h3>
@endsection

@section('aside')
    @include('caja.siderbar')
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
            background: url("{{URL::asset('loading2.gif')}}") 50% 50% no-repeat rgb(249,249,249);
            opacity: .8;
        }
    </style>
@endsection

@section('content')
    <returns-invoice />
@endsection

@section('scriptp')

    <script src="/js/app.js"></script>
@endsection