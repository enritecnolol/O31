@extends('main.app')
@section('tittle','SofiaRD | Reporteria')

@section('titulo')
    <h3 style="color: white"><i class="fas fa-arrow-circle-right"></i> Reporteria</h3>
@endsection
@section('aside')
    @include('caja.siderbar')
@endsection
@section('content')
    <reportspanel/>
@endsection

@section('scriptp')
    <script type="text/javascript" src="https://cdn.rawgit.com/asvd/dragscroll/master/dragscroll.js"></script>
    <script src="/js/app.js"></script>
@endsection