@extends('main.app')
@section('tittle','O31 | Historial de factura')

@section('titulo')
    <h3 style="color: white"><i class="fas fa-arrow-circle-right"></i> Historial de factura</h3>
@endsection
@section('aside')
    @include('caja.siderbar')
@endsection
@section('content')
    <invoice-history />
@endsection

@section('scriptp')
    <script src="/js/app.js"></script>
@endsection