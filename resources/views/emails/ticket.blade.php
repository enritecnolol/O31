<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <title>Document</title>
</head>
<body>
    <div class="card">
       <div class="card-body">
           <div class="container">
               <div class="row">
                   <div class="col-md-12">
                       <div class="text-center" style="align-content: center">
                           <h2>{!!  $compania->nombreempresa !!}</h2>
                       </div>
                   </div>
                   <div class="col-md-12" style="margin-top: 15px">
                       <div class="text-left">
                           <strong>No.Ticket</strong>: {!! $idtickect !!}
                       </div>
                       <div class="text-left">
                           <strong>Fecha</strong>: {!! $fecha !!}
                       </div>
                       <div class="text-left">
                           <strong>Telefono</strong>: {!! $compania->telefono !!}
                       </div>
                       <div class="text-left">
                           <strong>Direccion</strong>: {!! $compania->pais !!}, {!! $compania->ciudad !!}
                       </div>
                   </div>
                   <div class="col-md-12">
                       <hr>
                   </div>
                   <div class="col-md-12">
                       <div class="text-center" style="align-content: center">
                           <h4>Cliente:</h4>
                       </div>
                       <div class="text-left">
                           <strong>Nombre: </strong> {!! $nombre !!}
                       </div>
                       <div class="text-left">
                           <strong>Telefono: </strong> {!! $telefono !!}
                       </div>
                       <div class="text-left">
                           <strong>Email: </strong> {!! $email !!}
                       </div>
                       <div class="text-left">
                           <strong>Matricula: </strong> {!! $matricula !!}
                       </div>
                   </div>
                   <div class="col-md-12">
                       <hr>
                   </div>
                   <div class="col-md-12">
                       <div class="text-center" style="margin: 60px;border-radius: 200px 200px 200px 200px;box-shadow: 0px 0px 38px -8px rgba(0,0,0,0.75);">
                           <label for="" style="font-size: 70px;">{!! $puntos !!}</label>
                           <br>
                           <label for="" style="font-size: 30px">Puntos</label>
                       </div>
                   </div>
                   <div class="col-md-12">
                       <div class="text-center">
                           <small>Este ticket solo es valido durante 7 dias</small>
                       </div>
                   </div>
                   <div class="col-md-12">
                       <div class="text-center">
                           <img src="<?php echo $message->embed('qr.png'); ?>" alt="">
                       </div>
                   </div>
               </div>
           </div>
       </div>
    </div>
    <div class="" style="">
    </div>
</body>
</html>