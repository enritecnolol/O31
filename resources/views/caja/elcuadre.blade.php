<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<div style="width: 400px">
    <h2>Desglose del Cuadre de Caja</h2>
    <img src="/imagenes/logo.png" width="100px" style="margin-left: 50px" alt="">
    <br>
    <p style="margin-left: 60px"> <strong>Detaller</strong></p>
    <hr>
    <div>
        <p><strong>Usuario</strong>: General - - - <strong>Fecha</strong>: {{$caja->fecha_apertura}}</p>
        <p><strong>Valor Apertura</strong>: {{$caja->valor_apertura}} - - - <strong>Total de Ventas</strong>: {{$caja->total_venta}}</p>
        <p><strong>Total Cierre</strong>: {{$caja->total_cierre}}</p>
    </div>
    <hr>
    <p style="margin-left: 60px"> <strong>Segun Sistema</strong></p>
    <div>
        <p><strong>Efectivo:    {{$json["segunsistema"]["efectivo"]}}</strong></p>
        <p><strong>Tarjeta:     {{$json["segunsistema"]["tarjeta"]}}</strong></p>
        <p><strong>Total =      {{$json["segunsistema"]["total"]}}</strong></p>
    </div>
    <hr>
    <p style="margin-left: 60px"> <strong>Segun Caja</strong></p>
    <div>
        <p><strong>Efectivo en caja :   {{$json["efectivocaja"]}}</strong></p>
        <p><strong>Deposistos:          {{$json["deposito"]}}</strong></p>
        <p><strong>Egresos:             {{$json["egresos"]}}</strong></p>
    </div>
    <hr>
    <p style="margin-left: 60px"> <strong>Desglose</strong></p>
    <div>
        <table>
            <tr>
                <td><strong>2,000 = </strong></td>
                <td>{{$json['desglose']['billetes']['dosmil']}}</td>
            </tr>
            <tr>
                <td><strong>1,000 = </strong></td>
                <td>{{$json['desglose']['billetes']['mil']}}</td>
            </tr>
            <tr>
                <td><strong>500 = </strong></td>
                <td>{{$json['desglose']['billetes']['quinientos']}}</td>
            </tr>
            <tr>
                <td><strong>200 = </strong></td>
                <td>{{$json['desglose']['billetes']['dociento']}}</td>
            </tr>
            <tr>
                <td><strong>100 = </strong></td>
                <td>{{$json['desglose']['billetes']['cien']}}</td>
            </tr>
            <tr>
                <td><strong>50 = </strong></td>
                <td>{{$json['desglose']['billetes']['cincuenta']}}</td>
            </tr>
        </table>
    </div>
    <hr>
    <div>
        <table>
            <tr>
                <td><strong>25 = </strong></td>
                <td>{{$json['desglose']['monedas']['veinticinco']}}</td>
            </tr>
            <tr>
                <td><strong>10 = </strong></td>
                <td>{{$json['desglose']['monedas']['diez']}}</td>
            </tr>
            <tr>
                <td><strong>5 = </strong></td>
                <td>{{$json['desglose']['monedas']['cinco']}}</td>
            </tr>
            <tr>
                <td><strong>1 = </strong></td>
                <td>{{$json['desglose']['monedas']['uno']}}</td>
            </tr>
        </table>
    </div>

</div>

</body>
</html>