<?php

namespace App\Http\Controllers;

use App\Models\Servicios;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

class ServiciosController extends Controller
{
    public function index(){

        $servicios = DB::table('servicios')
                ->orderBy('estado','desc')
                ->get();

        return response()->json(['data'=> $servicios]);
    }

    public function details($id){
        // DETALLES, EDITAR
        $servicio = Servicios::find($id);
        return response()->json($servicio);
    }

    public function store(Request $request) {
        // UPDATE, CREATE
        $validator = Validator::make($request->all(),[
            'descripcion' => 'required|string|max:100'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());
        }

        $estado = (filled($request->estado))
                ? $request->estado
                : 1;

        Servicios::updateOrCreate([
            'id' => $request->id
        ],
        [
            'descripcion' => $request->descripcion,
            'estado' => $estado,
            'responsable' => $request->responsable
        ]);        

        return response()->json(['success'=>'Se agregó el nuevo servicio.']);
    }

    public function destroy($id)
    {
        $servicio = Servicios::find($id);
        $servicio->estado = 0;
        $servicio->save();

        return response()->json(['success'=>'Se inactivó el servicio.']);
    }

    public function activar($id)
    {
        $servicio = Servicios::find($id);
        $servicio->estado = 1;
        $servicio->save();

        return response()->json(['success'=>'Se activó el servicio.']);
    }
}


