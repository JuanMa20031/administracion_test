<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NuevasPlataformas;
use App\Models\NuevasPlataformasReno;
use Validator;

class NuevasPlataformasController extends Controller
{
    public function index(){
        
        $nuevasPlataformas = NuevasPlataformas::all();
        $nuevasPlataformasReno = NuevasPlataformasReno::all();

        return response()->json([
            'data' => [
                'plataformas'=>$nuevasPlataformas,
                'plataformasReno'=>$nuevasPlataformasReno,
            ]
        ]);
    }

    public function store(Request $request) {

        $validator = Validator::make($request->all(),[
            'descripcion' => 'required|string|max:100'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());
        }

        $nuevasPlataformas = new NuevasPlataformas();
        $nuevasPlataformas->descripcion = $request->descripcion;
        $nuevasPlataformas->estado = 1;
        $nuevasPlataformas->save();

        $nuevasPlataformasReno = new NuevasPlataformasReno();
        $nuevasPlataformasReno->descripcion = "Reno".$request->descripcion;
        $nuevasPlataformasReno->estado = 1;
        $nuevasPlataformasReno->save();

        return response()->json(['success'=>'Se agregó la nueva plataforma.']);
    }


}