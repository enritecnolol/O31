@extends('main.app')
@section('tittle','Cafeteria | Reporte 607')

@section('titulo')
    <h3 style="color: white"><i class="fas fa-arrow-circle-right"></i> Reporte 607</h3>
@endsection
@section('aside')
    @include('caja.siderbar')
@endsection
@section('content')
    <reporte-dgii-panel />
@endsection

@section('scriptp')
    <script type="text/javascript" src="https://cdn.rawgit.com/asvd/dragscroll/master/dragscroll.js"></script>
    <script src="/js/app.js"></script>
@endsection