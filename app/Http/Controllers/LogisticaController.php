<?php

namespace App\Http\Controllers;

use App\Models\Logistica;
use App\Models\Servicios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;
use DateTime;

class LogisticaController extends Controller
{
    public function index(){

        $servicios_filtro = Servicios::where('estado',1)->pluck('descripcion','id');
        $servicios = Servicios::pluck('descripcion','id');

        $logistica = Logistica::all();

        $fecha_inicio = request('fecha_inicio_filtro');
        $fecha_venc = request('fecha_venc_filtro');
        $decision_fil = request('decision_filtro');
        $servicios_filtros = request('servicios_filtros');

        $array_servicios = [];

        foreach ($servicios as $servicio => $valor) {
            array_push($array_servicios,$servicio); 
        }

        $busqueda_decision = [0,1];
        
        if(filled($decision_fil)){
            if($decision_fil == 0){
                $busqueda_decision = [0];
            }else{

                $busqueda_decision = [1];
            }
        }

        if (strtolower($servicios_filtros) !== 'null' && $servicios_filtros != '999999'){
            $array_servicios = [];
            array_push($array_servicios,$servicios_filtros); 
        }

        $logistica = Logistica::query()
        ->when($fecha_inicio, function ($query, $fecha_inicio){
            return $query->where('fecha_inicio', '=', $fecha_inicio);
          })
        ->when($fecha_venc, function ($query, $fecha_venc){
            return $query->where('fecha_vencimiento', '=', $fecha_venc);
        })

        ->when($array_servicios, function ($query, $array_servicios){
            
            return $query->whereIn('servicio_id', $array_servicios);
        })

        ->whereIn('decision', $busqueda_decision)

        ->get();
        
        return response()->json(['data'=> $logistica,'servicios' => $servicios,'servicios_filtrados'=> $servicios_filtro]);
    }

    public function details($id){
        // DETALLES, EDITAR
        $logistica = Logistica::find($id);
        $servicios = Servicios::pluck('descripcion','id');
        $servicios_filtro = Servicios::where('estado',1)->pluck('descripcion','id');

        return response()->json(['data'=> $logistica,'servicios' => $servicios,'servicios_filtrados'=> $servicios_filtro]);
    }

    public function store(Request $request) {
        // UPDATE, CREATE
        $validator = Validator::make($request->all(),[
            'servicio_id'  => 'required|int',
            'pantallas'    => 'required|int',
            'dias'         => 'required|int',
            'fecha_inicio' => 'required',
            'fecha_corte' => 'nullable',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());
        }

        $decision = ($request->fecha_corte)
                  ? 1
                  : 0;

        Logistica::updateOrCreate([
            'id' => $request->id
        ],
        [
            'servicio_id' => $request->servicio_id,
            'nombre'      => $request->nombre,
            'pantallas' => $request->pantallas,
            'celular' => $request->celular,
            'dias' => $request->dias,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_vencimiento' => $this->obtenerFechaVencimiento($request->fecha_inicio,$request->dias),
            'decision' =>$decision,
            'fecha_corte' => $request->fecha_corte,
            'estado' => 1,
            'responsable' => $request->responsable,
            'primer_aviso' => $request->primer_aviso,
            'segundo_aviso' => $request->segundo_aviso,
            'corte_definitivo' => $request->corte_definitivo
        ]);        

        return response()->json(['success'=>'Se agregó el nuevo registro.']);
    }

    public function destroy($id)
    {
        $servicio = Logistica::find($id);
        $servicio->estado = 0;
        $servicio->save();

        return response()->json(['success'=>'Se eliminó el registro.']);
    }

    public function actualizarAvisos(Request $request, $id){

        $logistica = Logistica::find($id);

        $logistica->primer_aviso = $request->primer_aviso;
        $logistica->segundo_aviso = $request->segundo_aviso;
        $logistica->corte_definitivo = $request->corte_definitivo;

        if($request->corte_definitivo == 1){
            $logistica->decision = 1;
        }
        
        $logistica->save();

        return response()->json(['success'=>'Se actualizó el registro.']);
    }
    
        public function cambiarCorte($id){

        $logistica = Logistica::find($id);

        \Log::alert("CAMBIAR A CORTEEE A {$id}");
        $logistica->decision = 1;        
        $logistica->save();
 
        return response()->json(['success'=>'Se actualizó el registro.']);
    }

    private function obtenerFechaVencimiento($fecha_inicio,$dias_plan){
        return date('Y-m-d', strtotime($fecha_inicio . ' +' . $dias_plan . ' days'));
    }

}
