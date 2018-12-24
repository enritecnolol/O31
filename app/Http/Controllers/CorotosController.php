<?php

namespace App\Http\Controllers;

use App\Coroto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CorotosController extends Controller
{
    public function store(Request $request)
    {
        $corotonombre = Coroto::all()->where('name',$request->name);
        if ($corotonombre == '[]')
        {
            $coroto = new Coroto();
            $coroto->name = $request->name;
            $coroto->img = $request->img;
            $coroto->numero = $request->numero;
            $coroto->width = $request->w;
            $coroto->height = $request->h;
            $coroto->status = $request->status;
            $coroto->top = $request->y;
            $coroto->left = $request->x;
            $coroto->area_id= $request->area;
            $coroto->user_id= Auth::id();
            $coroto->save();
            return 'guardado';
        }else{
            if ($request->name == 'pared')
            {
                $coroto = new Coroto();
                $coroto->name = $request->name;
                $coroto->img = $request->img;
                $coroto->numero = $request->numero;
                $coroto->width = $request->w;
                $coroto->height = $request->h;
                $coroto->status = $request->status;
                $coroto->top = $request->y;
                $coroto->left = $request->x;
                $coroto->area_id= $request->area;
                $coroto->user_id= Auth::id();
                $coroto->save();
                return 'guardado';
            }
        }
    }
    public function allcorotos(Request $request)
    {
        $corotos = Coroto::all()->where('user_id', Auth::id())->where('area_id', $request->area);
        if ($corotos == '[]')
        {
            $corotos = "['No Data']";
        }
        return $corotos;
    }

    public function edit(Request $request)
    {
        $coroto = Coroto::find($request->id);
        if ($coroto == "")
        {
            $coroto = "No";
        }
        if ($coroto != "No")
        {
            if ($coroto->top != $request->y || $coroto->left != $request->x || $coroto->numero != $request->numero)
            {
                $coroto->numero = $request->numero;
                $coroto->width = $request->w;
                $coroto->height = $request->h;
                $coroto->status = $request->status;
                $coroto->top = $request->y;
                $coroto->left = $request->x;
                $coroto->update();
            }
        }
        return 'editado';
    }
    public function delete(Request $request)
    {
        $coroto = Coroto::find($request->id);
        $coroto->delete();
    }
    public function saveeditcorotos(Request $request)
    {
        foreach ($request->corotos as $coroto)
        {
            if ($coroto['id'] == 0)
            {
                $corotonew = new Coroto();
                $corotonew->name = $coroto['name'];
                $corotonew->img = $coroto['img'];
                $corotonew->numero = $coroto['numero'];
                $corotonew->width = $coroto['width'];
                $corotonew->height = $coroto['height'];
                $corotonew->status = $coroto['status'];
                $corotonew->top = $coroto['top'];
                $corotonew->left = $coroto['left'];
                $corotonew->area_id= $request->area;
                $corotonew->user_id= Auth::id();
                $corotonew->save();
            }else{
                $corotoedit = Coroto::find($coroto['id']);
                $corotoedit->name = $coroto['name'];
                $corotoedit->img = $coroto['img'];
                $corotoedit->numero = $coroto['numero'];
                $corotoedit->width = $coroto['width'];
                $corotoedit->height = $coroto['height'];
                $corotoedit->top = $coroto['top'];
                $corotoedit->left = $coroto['left'];
                $corotoedit->update();
            }
        }
        return 'Todo Bien';
    }
}
