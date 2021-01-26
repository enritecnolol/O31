@extends('main.app')
@section('tittle','O31 | Facturacion')

@section('titulo')
    <h3 style="color: white"><i class="fas fa-arrow-circle-right"></i> Facturacion</h3>
@endsection
@section('aside')
    @include('caja.siderbar')
@endsection
@section('content')
    <billing-card />
@endsection

@section('scriptp')
    <script src="/js/app.js"></script>
@endsection