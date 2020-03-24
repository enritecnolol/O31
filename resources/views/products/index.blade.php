@extends('main.app')
@section('tittle','SofiaRD | Catalogo de productos')

@section('titulo')
    <h3 style="color: white"><i class="fas fa-arrow-circle-right"></i> Catalogo de productos</h3>
@endsection
@section('aside')
    @include('caja.siderbar')
@endsection
@section('content')
    <products-manager />
@endsection

@section('scriptp')
    <script src="/js/app.js"></script>
@endsection
