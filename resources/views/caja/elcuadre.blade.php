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
<div style="width: 400px" id="Vue">
    <h2>Desglose del Cuadre de Caja</h2>
    <img src="/imagenes/{{$company->img}}" width="100px" style="margin-left: 50px" alt="">
    <br>
    <h3 style="margin-left: 60px"><strong>Detalle</strong></h3>
    <hr>
    <div>
        <p><strong>Usuario</strong>: General - - - <strong>Fecha</strong>: {{$caja->fecha_apertura}}</p>
        <p><strong>Valor Apertura</strong>: {{number_format($caja->valor_apertura, 2, '.', ',')}} - - - <strong>Total de Ventas</strong>: {{$caja->total_venta}}</p>
        <p><strong>Total Cierre</strong>: {{number_format($caja->total_cierre, 2, '.', ',')}}</p>
    </div>
    <hr>
    <p style="margin-left: 60px"> <strong>Segun Sistema</strong></p>
    <div>
        <p><strong>Efectivo:    {{number_format($json["segunsistema"]["efectivo"], 2, '.', ',')}}</strong></p>
        <p><strong>Tarjeta:     {{number_format($json["segunsistema"]["tarjeta"], 2, '.', ',')}}</strong></p>
        <p><strong>Total =      {{number_format($json["segunsistema"]["total"], 2, '.', ',')}}</strong></p>
    </div>
    <hr>
    <p style="margin-left: 60px"> <strong>Segun Caja</strong></p>
    <div>
        <p><strong>Efectivo en caja :   {{number_format($json["efectivocaja"], 2, '.', ',')}}</strong></p>
        <p><strong>Deposistos:          {{number_format($json["deposito"], 2, '.', ',')}}</strong></p>
        <p><strong>Egresos:             {{number_format($json["egresos"], 2, '.', ',')}}</strong></p>
    </div>
    <hr>
    <p style="margin-left: 60px"> <strong>Desglose</strong></p>
    <div>
        <table>
            <tr>
                <td><strong>2,000 = </strong></td>
                <td>{{$json['desglose']['billetes']['dosmil']}}</td>
                <td></td>
                <td><strong>25 = </strong></td>
                <td>{{$json['desglose']['monedas']['veinticinco']}}</td>
            </tr>
            <tr>
                <td><strong>1,000 = </strong></td>
                <td>{{$json['desglose']['billetes']['mil']}}</td>
                <td></td>
                <td><strong>10 = </strong></td>
                <td>{{$json['desglose']['monedas']['diez']}}</td>
            </tr>
            <tr>
                <td><strong>500 = </strong></td>
                <td>{{$json['desglose']['billetes']['quinientos']}}</td>
                <td></td>
                <td><strong>5 = </strong></td>
                <td>{{$json['desglose']['monedas']['cinco']}}</td>
            </tr>
            <tr>
                <td><strong>200 = </strong></td>
                <td>{{$json['desglose']['billetes']['dociento']}}</td>
                <td></td>
                <td><strong>1 = </strong></td>
                <td>{{$json['desglose']['monedas']['uno']}}</td>
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
        <p>Gracias</p>
    </div>

</div>
<script src="{{ URL::asset('js/vue.js') }}"></script>
<script !src="">
    var app = new Vue({
            el: '#Vue',
            methods:{
            },
            created(){
                    window.print();
                    setTimeout(() => {
                            window.close();
                        },
                        3000
                    );
            }
        })
</script>
</body>
</html>