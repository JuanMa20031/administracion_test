<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ventas;
use Validator;
use Carbon\Carbon;

class VentasController extends Controller
{
    public function index(){

        if(isset(request()->fechaEspecifica)){            

            $ventas = Ventas::whereDate('fecha',request()->fechaEspecifica)->get();

        }else{

            $fecha_inicial = Carbon::parse(request()->fechaInicial)->startOfDay();
            $fecha_final = Carbon::parse(request()->fechaFinal)->endOfDay();

            if(isset(request()->fechaInicial) && isset(request()->fechaFinal)){
                $ventas = Ventas::whereBetween('fecha',[$fecha_inicial, $fecha_final])->get();
            }
        }

        $totalVentas = $ventas->sum('precio');
        $totalMovimientos = $ventas->count();
            
        $data = [
            'total_ventas' => $totalVentas,
            'total_movimientos' => $totalMovimientos,
            'movimientos' => $ventas
        ];


        return response()->json([
            'data' => $data
        ]);
    }

    public function store(Request $request) {

        $validator = Validator::make($request->all(),[
            'descripcion' => 'required|string|max:100',
            'meses' => 'required',
            'celular' => 'required',
            'precio' => 'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());
        }

        $ventas = new Ventas();

        $ventas->descripcion = $request->descripcion;
        $ventas->meses = $request->meses;
        $ventas->celular = $request->celular;
        $ventas->precio = $request->precio;
        $ventas->fecha = $request->fecha;
        $ventas->plataforma1 = $request->plataforma1;
        $ventas->plataforma2 = $request->plataforma2;
        $ventas->plataforma3 = $request->plataforma3;
        $ventas->plataforma4 = $request->plataforma4;

        $ventas->save();

        return response()->json(['success'=>'Se agregó el registro.']);
    }

    public function details(int $idVenta){

        $venta = Ventas::find($idVenta);
        
        return response()->json(['data'=> $venta]);
    }


    public function destroy(int $idVenta) {

        $venta = Ventas::findOrFail($idVenta);
        $venta->delete();

        return response()->json(['success'=>'Se eliminó el registro.']);
    }

    public function update(Request $request, $idVenta)
    {
        // Validación de datos (puedes agregar más validaciones según tus necesidades)
        $request->validate([
            'meses' => 'required|integer',
            'celular' => 'required',
            'precio' => 'required',
            'fecha' => 'required|date',
        ]);

        // Obtén el registro a actualizar
        $ventas = Ventas::find($idVenta);

        if (!$ventas) {
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }

        // Actualiza los campos
        $ventas->descripcion = $request->descripcion;
        $ventas->meses = $request->input('meses');
        $ventas->celular = $request->input('celular');
        $ventas->precio = $request->input('precio');
        $ventas->fecha = $request->input('fecha');
        $ventas->plataforma1 = $request->input('plataforma1');
        $ventas->plataforma2 = $request->input('plataforma2');
        $ventas->plataforma3 = $request->input('plataforma3');
        $ventas->plataforma4 = $request->input('plataforma4');


        // Guarda los cambios
        $ventas->save();

        return response()->json(['message' => 'Registro actualizado correctamente']);
    }
}