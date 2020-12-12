<?php

namespace App\Http\Controllers;

use App\Impuestosref;
use App\Rangoimpuesto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ImpuestosrefsController extends Controller
{
    public function store(Request $request)
    {
        $iduser = Auth::id();

        // comparando fechas si existen fecha iguales en ya guardadas
        $fechainicio = $request->fechadesde;
        $fechafin = $request->fechahasta;

        if (strtotime($fechainicio) < strtotime($fechafin)){

//            $compararfecha  = DB::select("SELECT * FROM rangoimpuestos WHERE '".$fechainicio."' BETWEEN desde AND hasta");


                $ref = new Impuestosref;
                $ref->codigo = $request->codigo;
                $ref->descripcion = $request->descripcion;
                $ref->identificador = $request->identificador;
                $ref->user_id = Auth::id();
                $ref->save();

                $refid = Impuestosref::all();

                $rango = new Rangoimpuesto;
                $rango->desde = $request->fechadesde;
                $rango->hasta = $request->fechahasta;
                $rango->porciento = $request->porciento;
                $rango->referenciaitbis_id =$refid->last()->id;
                $rango->user_id = Auth::id();
                $rango->save();

                return 'guardado';


        }else{
            return 'fecha fin no puedes estar antes de la fecha inicial';
        }

    }
    public function datos(Request $request)
    {
        $iduser = Auth::id();
        $ref = Impuestosref::all()->where('id', $request->codigo);

        if($ref == '[]'){
            return 'no resultado con ese id';
        }else{
            foreach ($ref as $ref){
                $id = $ref->id;
            }
            $rango = Rangoimpuesto::all()->where('referenciaitbis_id', $id);

            if ($rango == '[]')
            {
                $rango = 'no resultado';
            }else{
                $rango = $rango;
            }

            return [$ref, $rango];
        }
    }
    public function ingresarrango(Request $request)
    {
        $iduser = Auth::id();

        // comparando fechas si existen fecha iguales en ya guardadas
        $fechainicio = $request->fechadesde;
        $fechafin = $request->fechahasta;

        if (strtotime($fechainicio )< strtotime($fechafin)){

            $compararfecha  = DB::connection('client')->select("SELECT * FROM rangoimpuestos WHERE  referenciaitbis_id = ".$request->id." and '".$fechainicio."' BETWEEN desde AND hasta ");

            if ($compararfecha == [])
            {
                $rango = new Rangoimpuesto;
                $rango->desde = $request->fechadesde;
                $rango->hasta = $request->fechahasta;
                $rango->porciento = $request->porciento;
                $rango->referenciaitbis_id = $request->id;
                $rango->user_id = Auth::id();
                $rango->save();
                return 'guardado';
            }
            else{
                return 'fecha ingresada se encuentra en un rango ya utilizado';
            }

        }else{
            return 'fecha fin no puedes estar antes de la fecha inicial';
        }
    }
    public function editarrango(Request $request)
    {
        $datos = $request['rango'];

        foreach ($datos as $dato)
        {
            $id = $dato['id'];

            $rango = Rangoimpuesto::find($id);
            $rango->desde = $dato['desde'];
            $rango->hasta = $dato['hasta'];
            $rango->porciento = $dato['porciento'];
            $rango->update();
        }
        return 'editado';
    }
    public function datosimpuestorefproducto()
    {
        $id = Auth::id();
        $ref = DB::connection('client')->select("SELECT impuestosrefs.*, rangoimpuestos.porciento FROM impuestosrefs, rangoimpuestos WHERE impuestosrefs.id = rangoimpuestos.referenciaitbis_id AND CURDATE() BETWEEN rangoimpuestos.desde AND rangoimpuestos.hasta");
        return $ref;
    }
}
