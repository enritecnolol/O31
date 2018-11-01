<div class="container">
    <div class="">
        <img  src="imagenes/{{$empresa[0]->img}}" alt="">
        <br>
    </div>
    <hr>
    <div class="text-center">
        <h5>Desde: {{$start}}  Hasta: {{$end}}</h5>
    </div>
</div>

<div class="container" style="">
    <table class="table table-bordered table-sm">
        <thead>
        <tr>
            <th scope="col">Nombre Producto</th>
            <th scope="col">Cantidad</th>
            <th scope="col">Importe</th>
        </tr>
        </thead>
        <tbody>
            @foreach($productos as $productos)
                <tr>
                    <td>{{$productos->name}}</td>
                    <td>{{$productos->cantidad}}</td>
                    <td class="text-left"><span class="pull-right">{{number_format($productos->impost , 2)}}</span></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>