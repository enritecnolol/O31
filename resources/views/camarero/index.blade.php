@extends('main.app')
@section('tittle','Cafeteria | Camareros')

@section('titulo')
    <h3 style="color: white"><i class="fas fa-arrow-circle-right"></i> Camareros</h3>
@endsection

@section('aside')
    @include('caja.siderbar')
@endsection

@section('content')
    {{--<pantalla-camarero></pantalla-camarero>--}}
    <pantallacamarero></pantallacamarero>
@endsection

@section('scriptp')
    <script src="/js/app.js"></script>
@endsection