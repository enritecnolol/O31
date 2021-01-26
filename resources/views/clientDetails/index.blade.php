@extends('main.app')
@section('tittle','O31 | Detalles de cliente')

@section('titulo')
    <h3 style="color: white"><i class="fas fa-arrow-circle-right"></i> Cliente</h3>
@endsection
@section('aside')
    @include('caja.siderbar')
@endsection
@section('content')
    <client-details />
@endsection

@section('scriptp')
    <script type="text/javascript" src="https://cdn.rawgit.com/asvd/dragscroll/master/dragscroll.js"></script>
    <script src="/js/app.js"></script>
@endsection