@extends('main.app')
@section('tittle','O31 | Reporte 606')

@section('titulo')
    <h3 style="color: white"><i class="fas fa-arrow-circle-right"></i> Reporte 606</h3>
@endsection
@section('aside')
    @include('caja.siderbar')
@endsection
@section('content')
    <reporte-dgii-606-panel />
@endsection

@section('scriptp')
    <script type="text/javascript" src="https://cdn.rawgit.com/asvd/dragscroll/master/dragscroll.js"></script>
    <script src="/js/app.js"></script>
@endsection
