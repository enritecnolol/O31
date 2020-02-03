@extends('main.app2')
@section('tittle','SofiaRD | Ordenes')

@section('titulo')
    <h3 style="color: white"><i class="fas fa-arrow-circle-right"></i>Comanda</h3>
@endsection

@section('content')
    <comanda-ordenes></comanda-ordenes>
@endsection

@section('scriptp')
    <script type="text/javascript" src="https://cdn.rawgit.com/asvd/dragscroll/master/dragscroll.js"></script>
    <script src="/js/app.js"></script>
@endsection