@extends('main.app')
@section('tittle','O31 | Gastos y egresos')

@section('titulo')
    <h3 style="color: white"><i class="fas fa-arrow-circle-right"></i> Gastos y egresos</h3>
@endsection
@section('aside')
    @include('caja.siderbar')
@endsection
@section('content')
    <expenses-card />
@endsection

@section('scriptp')
    <script src="/js/app.js"></script>
@endsection
