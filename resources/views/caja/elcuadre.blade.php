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
    <h2 style="text-align: center">Desglose del Cuadre de Caja</h2>
    <div class="" style="text-align: center">
        <img src="/imagenes/{{$company->img}}" width="100px" style="text-align: center" alt="">
    </div>
    <p style="font-size: 22px;text-align: center"><strong>{{$company->nombreempresa}}</strong></p>
    <p style="font-size: 22px;text-align: center">{{$company->pais}}, {{$company->ciudad}}, {{$company->direccion}}</p>
    <hr>
    <div>
        <p style="font-size: 20px"><strong>Usuario</strong>: General</p>
        <p style="font-size: 20px"><strong>Fecha</strong>: {{$caja->fecha_apertura}}</p>
        <p style="font-size: 20px"><strong>Valor Apertura</strong>: {{number_format($caja->valor_apertura, 2, '.', ',')}}</p>
        <p style="font-size: 20px"><strong>Total de Ventas</strong>: {{$caja->total_venta}}</p>
        <p style="font-size: 20px"><strong>Total Cierre</strong>: {{number_format($caja->total_cierre, 2, '.', ',')}}</p>
    </div>
    <hr>
    <p style="margin-left: 60px;"> <strong>Segun Sistema</strong></p>
    <div>
        <p style="font-size: 20px"><strong>Efectivo:    {{number_format($json["segunsistema"]["efectivo"], 2, '.', ',')}}</strong></p>
        <p style="font-size: 20px"><strong>Tarjeta:     {{number_format($json["segunsistema"]["tarjeta"], 2, '.', ',')}}</strong></p>
        <p style="font-size: 20px"><strong>Total =      {{number_format($json["segunsistema"]["total"], 2, '.', ',')}}</strong></p>
    </div>
    <hr>
    <p style="margin-left: 60px;font-size: 22px"> <strong>Segun Caja</strong></p>
    <div>
        <p style="font-size: 20px"><strong>Efectivo en caja :   {{number_format($json["efectivocaja"], 2, '.', ',')}}</strong></p>
        <p style="font-size: 20px"><strong>Deposistos:          {{number_format($json["deposito"], 2, '.', ',')}}</strong></p>
        <p style="font-size: 20px"><strong>Egresos:             {{number_format($json["egresos"], 2, '.', ',')}}</strong></p>
    </div>
    <hr>
    <p style="margin-left: 60px;font-size: 22px"> <strong>Desglose</strong></p>
    <div>
        <table>
            <tr>
                <td style="font-size: 22px"><strong>2,000 = </strong></td>
                <td style="font-size: 22px">{{$json['desglose']['billetes']['dosmil']}}</td>
                <td></td>
                <td style="font-size: 22px"><strong>25 = </strong></td>
                <td style="font-size: 22px">{{$json['desglose']['monedas']['veinticinco']}}</td>
            </tr>
            <tr>
                <td style="font-size: 22px"><strong>1,000 = </strong></td>
                <td style="font-size: 22px">{{$json['desglose']['billetes']['mil']}}</td>
                <td></td>
                <td style="font-size: 22px"><strong>10 = </strong></td>
                <td style="font-size: 22px">{{$json['desglose']['monedas']['diez']}}</td>
            </tr>
            <tr>
                <td style="font-size: 22px"><strong>500 = </strong></td>
                <td style="font-size: 22px">{{$json['desglose']['billetes']['quinientos']}}</td>
                <td style="font-size: 22px"></td>
                <td style="font-size: 22px"><strong>5 = </strong></td>
                <td style="font-size: 22px">{{$json['desglose']['monedas']['cinco']}}</td>
            </tr>
            <tr>
                <td style="font-size: 22px"><strong>200 = </strong></td>
                <td style="font-size: 22px">{{$json['desglose']['billetes']['dociento']}}</td>
                <td style="font-size: 22px"></td>
                <td style="font-size: 22px"><strong>1 = </strong></td>
                <td style="font-size: 22px">{{$json['desglose']['monedas']['uno']}}</td>
            </tr>
            <tr>
                <td style="font-size: 22px"><strong>100 = </strong></td>
                <td style="font-size: 22px">{{$json['desglose']['billetes']['cien']}}</td>
            </tr>
            <tr>
                <td style="font-size: 22px"><strong>50 = </strong></td>
                <td style="font-size: 22px">{{$json['desglose']['billetes']['cincuenta']}}</td>
            </tr>
        </table>
    </div>
    <hr>
    <div>
        <p style="font-size: 24px">Gracias</p>
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