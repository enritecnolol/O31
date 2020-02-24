<?php

namespace App\Http\Controllers;

use App\Client;
use App\Configuracion;
use App\Puntosmovimiento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Milon\Barcode\DNS1D;
use Milon\Barcode\DNS2D;
use LaravelQRCode\Facades\QRCode;

class ClientesController extends Controller
{
    public function index()
    {
        return view('cliente.index');
    }
    public function store(Request $request)
    {
        $cliente = new Client;
        $cliente->nombre = $request->nombre;
        $cliente->telefono= $request->telefono;
        $cliente->email= $request->email;
        $cliente->matricula= $request->matricula;
        $cliente->observacion= $request->observacion;
        $cliente->direccion= $request->direccion;
        $cliente->descuento= $request->descuento;
        $cliente->tarjeta_id= $request->idtarjeta;
        $cliente->rnc= $request->rnc;
        $cliente->limit_balance = $request->limitBalance;
        $cliente->term = $request->term;
        $cliente->contact = $request->contact;
        $cliente->user_id= Auth::id();
        $cliente->save();

        return 'guardado';

    }
    public function datostabla()
    {
//        $clientes = Client::all()->where('user_id',Auth::id())->paginate(2);
        $clientes = Client::paginate(5);
        if ($clientes == '[]')
        {
            $clientes = 'vacio';
        }
        return $clientes;
    }
    public function datostabla2()
    {
        $clientes = Client::all();
//        $clientes = Client::paginate(5);
        if ($clientes == '[]')
        {
            $clientes = 'vacio';
        }
        return $clientes;
    }
    public function clientepuntos()
    {
        /*
            SELECT clients.*, tipotarjetas.codigo, configtjs.config, puntosmovimientos.* FROM clients
            LEFT JOIN tipotarjetas ON tipotarjetas.id = clients.tarjeta_id
            LEFT JOIN configtjs ON configtjs.tarjeta_id = tipotarjetas.id
            LEFT JOIN puntosmovimientos ON puntosmovimientos.cliente_id = clients.id
            WHERE clients.id = 2 AND clients.user_id = 1
        */
        $clientes = Client::all();
        if ($clientes == '[]')
        {
            $clientes = 'vacio';
        }
        return $clientes;
    }

    public function edit(Request $request)
    {
        $cliente = Client::find($request->id);
        $cliente->nombre = $request->nombre;
        $cliente->telefono = $request->telefono;
        $cliente->email = $request->email;
        $cliente->matricula = $request->matricula;
        $cliente->observacion = $request->observacion;
        $cliente->direccion = $request->direccion;
        $cliente->descuento = $request->descuento;
        $cliente->tarjeta_id = $request->idtarjeta;
        $cliente->rnc = $request->rnc;
        $cliente->limit_balance = $request->limitBalance;
        $cliente->term = $request->term;
        $cliente->contact = $request->contact;
        $cliente->update();

        return 'guardado';
    }
    public function clientetarjeta(Request $request){
        $cliente =DB::connection('client')->select("SELECT clients.*, tipotarjetas.codigo FROM clients, tipotarjetas WHERE clients.id = '".$request->id."'AND clients.tarjeta_id = tipotarjetas.id");
        if ($cliente == '[]')
        {
            $cliente = 'vacio';
        }
        return $cliente;
    }
    public function buscarcliente(Request $request)
    {
        $iduser = Auth::id();
        $cliente = DB::connection('client')->select("
        SELECT clients.*, tipotarjetas.codigo, configtjs.config,
        (
            SELECT IFNULL(sum(puntosmovimientos.balancepuntos), 0) FROM puntosmovimientos WHERE puntosmovimientos.cliente_id = clients.id AND puntosmovimientos.fecha between date_sub(now(),INTERVAL 1 WEEK) and now()
        ) AS total
        FROM clients
        INNER JOIN tipotarjetas ON tipotarjetas.id = clients.tarjeta_id
        INNER JOIN configtjs ON configtjs.tarjeta_id = tipotarjetas.id
        WHERE clients.id = ".$request->id."
        ");
        if ($cliente == '[]')
        {
            $cliente = 'vacio';
        }
        return $cliente;
    }

    public function cambiopuntos(Request $request)
    {
        $cambio = Client::find($request->id);
        $resta = $request->puntos - $request->cambio;
        $cambio->puntos = $resta;
        $cambio->update();

        $movimiento = new Puntosmovimiento;
        $movimiento->fecha = now();
        $movimiento->cliente_id = $request->id;
        $movimiento->puntos = $request->cambio;
        $movimiento->balancepuntos = $request->cambio;
        $movimiento->estado = 1;
        $movimiento->user_id = Auth::id();
        $movimiento->save();

        $compania = Configuracion::all();

        $movimientoid = Puntosmovimiento::all();
        $email = $request->email;
        $data = array(
          'fecha' => now(),
            'nombre' => $request->nombre,
            'telefono' => $request->telefono,
            'email' => $request->email,
            'matricula' => $request->matricula,
            'compania' => $compania[0],
            'puntos' =>  $request->cambio,
            'idtickect' => $movimientoid->last()->id,
        );

        $file = public_path('qr.png');
        QRCode::text($movimientoid->last()->id)->setOutfile($file)->png();


        Mail::send('emails.ticket', $data, function ($message) use ($email){
//            $message->from('coffebreakpos@outlook.com', 'Puntos');
            $message->to($email)->subject('Ticket Para uso de puntos');
        });

        return ['guardado', $compania, $movimientoid->last()->id];
    }

    public function nombrecliente(Request $request)
    {
        $cliente = Client::all()->where('id',$request->id);
        if ($cliente == '[]'){
            $cliente = null;
        }
        return $cliente;
    }

    public function findClient(Request $request)
    {
        $client = Client::find($request->client_id);
        return $client;
    }
}
