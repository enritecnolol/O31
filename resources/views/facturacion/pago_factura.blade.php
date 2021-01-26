@extends('main.app')
@section('tittle','O31 | Pago de factura')

@section('titulo')
    <h3 style="color: white"><i class="fas fa-arrow-circle-right"></i> Pago de facturas</h3>
@endsection
@section('aside')
    @include('caja.siderbar')
@endsection
@section('content')
    <bill-payment />
@endsection

@section('scriptp')
    <script src="/js/app.js"></script>
@endsection