@extends('main.app')
@section('tittle','Cafeteria | DashBoard')

@section('titulo')
    <h3 style="color: white">DashBoard</h3>
@endsection

@section('aside')
    @include('caja.siderbar')
@endsection

@section('content')
    <div style="margin-top: -60px">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="overview-wrap">
                        <h2 class="title-1">Vista General</h2>
                    </div>
                </div>
            </div>
            <div class="row m-t-25">
                <div class="col-sm-6 col-lg-3">
                    <div class="overview-item overview-item--c2">
                        <div class="overview__inner">
                            <div class="overview-box clearfix">
                                <div class="icon">
                                    <i class="zmdi zmdi-hc-5x zmdi-money"></i>
                                </div>
                                <div class="text">
                                    <h3>${{$totaldias}}.00</h3>
                                    <span>Total del dia</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="overview-item overview-item--c2">
                        <div class="overview__inner">
                            <div class="overview-box clearfix">
                                <div class="icon">
                                    <i class="zmdi zmdi-shopping-cart"></i>
                                </div>
                                <div class="text">
                                    <h3>${{$ventassemana}}.00</h3>
                                    <span>total semana</span>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="overview-item overview-item--c2">
                        <div class="overview__inner">
                            <div class="overview-box clearfix">
                                <div class="icon">
                                    <i class="zmdi zmdi-calendar-note"></i>
                                </div>
                                <div class="text">
                                    <h3>${{$ventasmes}}.00</h3>
                                    <span>Total del mes</span>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="overview-item overview-item--c2">
                        <div class="overview__inner">
                            <div class="overview-box clearfix">
                                <div class="icon">
                                    <i class="zmdi zmdi-money"></i>
                                </div>
                                <div class="text">
                                    <h3>${{$totalventas}}.00</h3>
                                    <span>Total Ventas - año</span>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">

            <div class="row">
                <div class="col-lg-12">
                    <div class="au-card m-b-30">
                        <div class="au-card-inner">
                            <h3 class="title-2 m-b-40">Ventas por dias 2018</h3>
                            <div id="chartdiv" style="width: auto; height: 400px;"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="au-card m-b-30">
                        <div class="au-card-inner">
                            <h3 class="title-2 m-b-40">Dias con mas Ventas 2018</h3>
                            <canvas id="diasmasventa"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="au-card m-b-30">
                        <div class="au-card-inner">
                            <h3 class="title-2 m-b-40">Ventas Semana pasada</h3>
                            <canvas id="semanapasadaventa"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="au-card m-b-30">
                        <div class="au-card-inner">
                            <h3 class="title-2 m-b-40">Ventas Por Mes 2018</h3>
                            <canvas id="ventasmes"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="au-card m-b-30">
                        <div class="au-card-inner">
                            <h3 class="title-2 m-b-40">Productos Mas Vendidos 2018</h3>
                            <canvas id="productomasvendidos"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="au-card m-b-30">
                        <div class="au-card-inner">
                            <h3 class="title-2 m-b-40">Ventas por Horas 2018</h3>
                            <canvas id="ventaporhoras" height="90"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scriptp')
    <script>
        var datos = '{{$diasconmasventas}}';
        var datoss = JSON.parse(datos.replace(/&quot;/g,'"'));
        var valores = [];
        var entidad = [];
        var otro = [];
        for (var valor of datoss) {
            otro.push(valor.dia)
            entidad.push(valor.DIA_SEMANA)
            valores.push(valor.total);
        }

        var ctx = document.getElementById("diasmasventa");
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: entidad,
                datasets: [{
                    label: '',
                    data: valores,
                    backgroundColor: [
                        'rgba(255, 99, 132, 4)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)',
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(54, 162, 235, 1)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero:true
                        }
                    }]
                }
            }
        });
    </script>
    <script>
        var datos2 = '{{$pormes}}';
        var datoss2 = JSON.parse(datos2.replace(/&quot;/g,'"'));
        var valores2 = [];
        var entidad2 = [];
        for (var valor of datoss2) {
            entidad2.push(valor.mes);
            valores2.push(valor.cantidad);
        }
        var ctx = document.getElementById("ventasmes");
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: entidad2,
                datasets: [{
                    label: '',
                    data: valores2,
                    backgroundColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)',
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero:true
                        }
                    }]
                }
            }
        });
    </script>
    <script>
        var datos3 = '{{$productosmasvendidos}}';
        var datoss3 = JSON.parse(datos3.replace(/&quot;/g,'"'));
        var valores3 = [];
        var entidad3 = [];
        for (var valor of datoss3) {
            entidad3.push(valor.nombre);
            valores3.push(valor.catidad);
        }
        var ctx = document.getElementById("productomasvendidos");
        var myChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: entidad3,
                datasets: [{
                    label: '',
                    data: valores3,
                    backgroundColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)',
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],

                }]
            },
        });
    </script>
    <script>
        var datos4 = '{{$ventassemanapasada}}';
        var datoss4 = JSON.parse(datos4.replace(/&quot;/g,'"'));
        var valores4 = [];
        var entidad4 = [];
        for (var valor of datoss4) {
            entidad4.push(valor.DIA_SEMANA);
            valores4.push(valor.total);
        }
        var ctx = document.getElementById("semanapasadaventa");
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: entidad4,
                datasets: [{
                    label: '',
                    data: valores4,
                    backgroundColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)',
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(54, 162, 235, 1)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                yAxes: [{
                    ticks: {
                        beginAtZero:false
                    }
                }]
            }
        });
    </script>
    <script>
        var datos6 = '{{$ventasporhoras}}';
        var datoss6 = JSON.parse(datos6.replace(/&quot;/g,'"'));
        var valores6 = [];
        var entidad6 = [];
        for (var valor of datoss6) {
            entidad6.push(valor.hora);
            valores6.push(valor.total);
        }
        var ctx = document.getElementById("ventaporhoras");
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: entidad6,
                datasets: [{
                    label: '',
                    data: valores6,
                    backgroundColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)',
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(54, 162, 235, 1)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero:true
                        }
                    }]
                }
            }
        });
    </script>
    <script !src="">
        var grande = '{{$graficogrande}}';
        var grandedato = JSON.parse(grande.replace(/&quot;/g,'"'));
        var chartData = grandedato;
        var chart = AmCharts.makeChart("chartdiv", {
            "type": "serial",
            "theme": "light",
            "dataProvider": chartData,
            "valueAxes": [{
                "axisAlpha": 0,
                "dashLength": 4,
                "position": "left"
            }],
            "mouseWheelZoomEnabled": true,
            "graphs": [{
                "bulletSize": 14,
                "customBullet": "https://www.amcharts.com/lib/3/images/star.png?x",
                "customBulletField": "customBullet",
                "valueField": "total",
                "balloonText":"<div style='margin:10px; text-align:left;'><span style='font-size:13px'>[[category]]</span><br><span style='font-size:18px'>Monto: $[[value]]</span>",
            }],
            "marginTop": 20,
            "marginRight": 70,
            "marginLeft": 40,
            "marginBottom": 20,
            "chartCursor": {
                "graphBulletSize": 1.5,
                "zoomable":false,
                "valueZoomable":true,
                "cursorAlpha":0,
                "valueLineEnabled":true,
                "valueLineBalloonEnabled":true,
                "valueLineAlpha":0.2
            },
            "chartCursor": {
                "limitToGraph":"g1"
            },
            "chartScrollbar": {
                "autoGridCount": true,
                "graph": "g1",
                "scrollbarHeight": 40
            },
            "autoMargins": false,
            "dataDateFormat": "YYYY-MM-DD",
            "categoryField": "date",
            "valueScrollbar":{
                "offset":30
            },
            "categoryAxis": {
                "parseDates": true,
                "axisAlpha": 0,
                "gridAlpha": 0,
                "inside": true,
                "tickLength": 0
            },
            "export": {
                "enabled": true
            }
        });
    </script>
@endsection