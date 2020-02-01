@extends('main.app')
@section('tittle','Cafeteria | Cotizacion')

@section('titulo')
    <h3 style="color: white"><i class="fas fa-arrow-circle-right"></i> Cotización</h3>
@endsection
@section('aside')
    @include('caja.siderbar')
@endsection
@section('content')
    <estimate-card />
@endsection

@section('scriptp')
    <script type="text/javascript" src="https://cdn.rawgit.com/asvd/dragscroll/master/dragscroll.js"></script>
    <script src="/js/app.js"></script>
@endsection