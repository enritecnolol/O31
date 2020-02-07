@extends('main.app')
@section('tittle','SofiaRD | metodos de pago')

@section('titulo')
    <h3 style="color: white"><i class="fas fa-arrow-circle-right"></i> metodos de pago</h3>
@endsection
@section('aside')
    @include('caja.siderbar')
@endsection
@section('content')
    <payment-methods />
@endsection

@section('scriptp')
    <script src="/js/app.js"></script>
@endsection