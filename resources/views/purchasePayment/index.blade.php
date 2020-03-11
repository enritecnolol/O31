@extends('main.app')
@section('tittle','SofiaRD | Pago de compra')

@section('titulo')
    <h3 style="color: white"><i class="fas fa-arrow-circle-right"></i> Pago de compra</h3>
@endsection
@section('aside')
    @include('caja.siderbar')
@endsection
@section('content')
    <purchase-payment />
@endsection

@section('scriptp')
    <script type="text/javascript" src="https://cdn.rawgit.com/asvd/dragscroll/master/dragscroll.js"></script>
    <script src="/js/app.js"></script>
@endsection