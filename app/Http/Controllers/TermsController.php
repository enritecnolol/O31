<?php

namespace App\Http\Controllers;

use App\Term;
use Illuminate\Http\Request;

class TermsController extends Controller
{
    //
    public function store(Request $request)
    {
        try{

            $term = new Term();
            $term ->name = $request->name;
            $term ->number_days = $request->number_days;
            $term->save();
            return response()->json(['message' => 'El termino fue agregado correctamente'], 200);

        }catch (\Exception $e)
        {
            return response()->json($e, 400);
        }

    }

    public function getList()
    {
        $terms = Term::all();
        return $terms;
    }
}
