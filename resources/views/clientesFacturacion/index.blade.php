@extends('main.app')
@section('tittle','SofiaRD | clientes de facturacion')

@section('titulo')
    <h3 style="color: white"><i class="fas fa-arrow-circle-right"></i> Clientes </h3>
@endsection
@section('aside')
    @include('caja.siderbar')
@endsection
@section('content')
    <billing-customers />
@endsection

@section('scriptp')
    <script src="/js/app.js"></script>
@endsection