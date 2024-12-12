<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NuevasPlataformas;
use App\Models\Ventas;
use DateTime;
use Carbon\Carbon;

class ChartController extends Controller
{
    
    public function getChartData()
    {
       // Aquí puedes generar los datos necesarios para el gráfico en formato JSON
        $data = [
            'labels' => ['Label 1', 'Label 2', 'Label 3'],
            'datasets' => [
                [
                    'label' => 'Datos de ejemplo',
                    'data' => [10, 20, 30],
                    'backgroundColor' => ['red', 'blue', 'green'], // Colores de fondo para cada barra
                ],
            ],
        ]; 

        

        return response()->json($data);
    }

    public function getPieChart(Request $request)
    {
        
        $fechaEspecifica = $request->input('fechaEspecifica');

        $mesEspecifico = $request->input('fechas_mes');

        $plataformas = NuevasPlataformas::all();

        $semana = $request->input('semana');
        $anio = $request->input('anio');

        if ($fechaEspecifica) {
           
            $ventas = Ventas::whereDate('fecha', $fechaEspecifica)->get();

        } elseif ($semana !== null && $anio !== null) {

            $semana = intval(substr($semana, 1));

            $fechaInicio = new \DateTime();
            $fechaInicio->setISODate($anio, $semana);
    
            $fechaFinal = clone $fechaInicio;
            $fechaFinal->modify('+6 days');

            $fechaInicio = $fechaInicio->format('Y-m-d');
            $fechaFinal = $fechaFinal->format('Y-m-d 23:59:59');

            $ventas = Ventas::whereBetween('fecha', [$fechaInicio, $fechaFinal])->get();

        }else{

            $anio = $request->input('anio');
            $mes = $request->input('mes');

            $fechaInicio = new \DateTime("{$anio}-{$mes}-01");
            
            $ultimoDiaMes = $fechaInicio->format('t');
            $fechaFinal = new \DateTime("{$anio}-{$mes}-{$ultimoDiaMes} 23:59:59");
            
            $fechaInicio = $fechaInicio->format('Y-m-d');
            $fechaFinal = $fechaFinal->format('Y-m-d');
            
            $ventas = Ventas::whereBetween('fecha', [$fechaInicio, $fechaFinal])->get();
        }
        
        if(!filled($ventas)){

            return response()->json([]);
        }

        $ventas = $ventas->map(function ($venta) {

            $descripcion = $venta->descripcion;
        
            $palabras = explode(' ', $descripcion);
        
            $palabras_filtradas = array_filter($palabras, function ($palabra) {
                return strpos($palabra, "Reno") === false;
            });
        
            $nueva_descripcion = implode(' ', $palabras_filtradas);
        
            $venta->descripcion = $nueva_descripcion;
        
            return $venta;
        });
        
        $arrayPlataformas = [];

        $plataformas->map(function ($plataforma) use(&$arrayPlataformas, $ventas){

            $descripcion = $plataforma->descripcion;

            $ventas->map(function($venta) use($descripcion, &$arrayPlataformas){

                $mystring = $venta->descripcion;
                $findme   = $descripcion;

                $pos = strpos($mystring, $findme);
                
                if ($pos !== false) {

                    if(isset($arrayPlataformas[$descripcion])){

                        $arrayPlataformas[$descripcion] += 1;
        
                    }else{
        
                        $arrayPlataformas[$descripcion] = 1;
                    }
                } 
            });
        });

        // Encontrar el elemento con el valor más alto
        $max_value = max($arrayPlataformas);
        $max_key = null;

        // Encontrar el elemento con el valor más bajo
        $min_value = min($arrayPlataformas);
        $min_key = null;

        foreach ($arrayPlataformas as $key => $value) {
            if ($value === $max_value) {
                $max_key = $key;
            }

            if ($value === $min_value) {
                $min_key = $key;
            }
        }

        $data = [
            'totalVentas'=> array_sum($arrayPlataformas),
            'masVendido' => [
                'nombre' => $max_key,
                'total' => $max_value
            ],
            'menosVendido' => [
                'nombre' => $min_key,
                'total' => $min_value
            ],
            'labels' => [],
            'datasets' => [
                [
                    'data' => []
                ],
            ],
        ];

        
        foreach ($arrayPlataformas as $key => $value) {
            array_push($data['labels'], $key);
            array_push($data['datasets'][0]['data'], $value);
        }

        return response()->json($data);
    }

    public function mostrarGraficoVentas()
    {
        $fechaEspecifica = Carbon::parse(request('fechaEspecifica'));

        $semana = request('semana');
        $anio = request('anio');
        $mes = request('mes');

        if ($semana == "" && $anio =="") {
            // Obtener la fecha actual y la fecha del día anterior
            $fechaActual = $fechaEspecifica->format('Y-m-d');
            $fechaDiaAnterior = $fechaEspecifica->subDay()->format('Y-m-d');
            $fechaDiaAnterior2 = Carbon::parse($fechaDiaAnterior)->subDay()->format('Y-m-d');
            $fechaDiaAnterior3 = Carbon::parse($fechaDiaAnterior2)->subDay()->format('Y-m-d');

            // Obtener las ventas del día actual y del día anterior desde la base de datos
            $ventasDiaActual = Ventas::whereDate('fecha', $fechaActual)->sum('precio');
            $ventasDiaAnterior = Ventas::whereDate('fecha', $fechaDiaAnterior)->sum('precio');
            $ventasDiaAnterior2 = Ventas::whereDate('fecha', $fechaDiaAnterior2)->sum('precio');
            $ventasDiaAnterior3 = Ventas::whereDate('fecha', $fechaDiaAnterior3)->sum('precio');

            $data = [
                'ventasDiaActual' => [
                    'fecha' => $fechaActual,
                    'total' => $ventasDiaActual
                ],
                'ventasDiaAnterior' => [
                    'fecha' => $fechaDiaAnterior,
                    'total' => $ventasDiaAnterior
                ],
                'ventasDiaAnterior2' => [
                    'fecha' => $fechaDiaAnterior2,
                    'total' => $ventasDiaAnterior2
                ],
                'ventasDiaAnterior3' => [
                    'fecha' => $fechaDiaAnterior3,
                    'total' => $ventasDiaAnterior3
                ]
            ];
    

        }elseif ($semana !== null && $anio !== null){
            $semana = intval(substr($semana, 1));

            $fechaSemana = Carbon::now()->setISODate($anio, $semana);

            // Obtener las fechas de la semana actual
            $fechaInicioSemanaActual = $fechaSemana->startOfWeek()->format('Y-m-d');
            $fechaFinalSemanaActual = $fechaSemana->endOfWeek()->format('Y-m-d 23:59:59');

            // Obtener las fechas de las semanas anteriores usando subWeeks()
            $fechaInicioSemanaAnterior = $fechaSemana->copy()->subWeeks(1)->startOfWeek()->format('Y-m-d');
            $fechaFinalSemanaAnterior = $fechaSemana->copy()->subWeeks(1)->endOfWeek()->endOfDay()->format('Y-m-d 23:59:59');

            $fechaInicioSemanaAnterior2 = $fechaSemana->copy()->subWeeks(2)->startOfWeek()->format('Y-m-d');
            $fechaFinalSemanaAnterior2 = $fechaSemana->copy()->subWeeks(2)->endOfWeek()->endOfDay()->format('Y-m-d 23:59:59');

            $fechaInicioSemanaAnterior3 = $fechaSemana->copy()->subWeeks(3)->startOfWeek()->format('Y-m-d');
            $fechaFinalSemanaAnterior3 = $fechaSemana->copy()->subWeeks(3)->endOfWeek()->endOfDay()->format('Y-m-d 23:59:59');

            // Obtener las ventas de las semanas
            $ventasSemanaActual = Ventas::whereBetween('fecha', [$fechaInicioSemanaActual, $fechaFinalSemanaActual])->sum('precio');
            $ventasSemanaAnterior = Ventas::whereBetween('fecha', [$fechaInicioSemanaAnterior, $fechaFinalSemanaAnterior])->sum('precio');
            $ventasSemanaAnterior2 = Ventas::whereBetween('fecha', [$fechaInicioSemanaAnterior2, $fechaFinalSemanaAnterior2])->sum('precio');
            $ventasSemanaAnterior3 = Ventas::whereBetween('fecha', [$fechaInicioSemanaAnterior3, $fechaFinalSemanaAnterior3])->sum('precio');

            // Verificar si la semana actual es la 1 y obtener la semana anterior
            $semanaActual = $semana;
            $semanaAnterior = $semanaActual === 1 ? 52 : ($semanaActual - 1);
            $semanaAnterior2 = $semanaActual === 1 ? 51 : ($semanaActual === 2 ? 52 : ($semanaActual - 2));
            $semanaAnterior3 = $semanaActual === 1 ? 50 : ($semanaActual === 2 ? 51 : ($semanaActual === 3 ? 52 : ($semanaActual - 3)));

            // Obtener las ventas de las semanas anteriores si es necesario
            if ($semanaActual === 1) {
                $ventasSemanaAnterior = Ventas::whereBetween('fecha', [$fechaInicioSemanaAnterior, $fechaFinalSemanaAnterior])->sum('precio');
                $ventasSemanaAnterior2 = Ventas::whereBetween('fecha', [$fechaInicioSemanaAnterior2, $fechaFinalSemanaAnterior2])->sum('precio');
                $ventasSemanaAnterior3 = Ventas::whereBetween('fecha', [$fechaInicioSemanaAnterior3, $fechaFinalSemanaAnterior3])->sum('precio');
            }

            $data = [
                'ventasDiaActual' => [
                    'fecha' => 'Semana ' . $semana,
                    'total' => $ventasSemanaActual
                ],
                'ventasDiaAnterior' => [
                    'fecha' => 'Semana ' . $semanaAnterior,
                    'total' => $ventasSemanaAnterior
                ],
                'ventasDiaAnterior2' => [
                    'fecha' => 'Semana ' . $semanaAnterior2,
                    'total' => $ventasSemanaAnterior2
                ],
                'ventasDiaAnterior3' => [
                    'fecha' => 'Semana ' . $semanaAnterior3,
                    'total' => $ventasSemanaAnterior3
                ]
            ];
                
        } elseif ($semana === null && $mes !== null && $anio !== null){

            $mesesEnEspanol = [
                1 => 'Enero',
                2 => 'Febrero',
                3 => 'Marzo',
                4 => 'Abril',
                5 => 'Mayo',
                6 => 'Junio',
                7 => 'Julio',
                8 => 'Agosto',
                9 => 'Septiembre',
                10 => 'Octubre',
                11 => 'Noviembre',
                12 => 'Diciembre',
            ];

            // Convertir el mes a un número entero
            $mes = intval($mes);
        
            // Crear una nueva instancia de Carbon con el año y mes proporcionados
            $fechaMes = Carbon::create($anio, $mes, 1);

            // Establecer la configuración regional a español
            setlocale(LC_TIME, 'es_ES.utf8');

            // Crear copias independientes de la fechaMes para calcular las fechas de los meses anteriores
            $fechaMesAnterior = $fechaMes->copy()->subMonth();
            $fechaMesAnterior2 = $fechaMesAnterior->copy()->subMonth();
            $fechaMesAnterior3 = $fechaMesAnterior2->copy()->subMonth();

            // Obtener la fecha de inicio y fin del mes actual
            $fechaInicioMesActual = $fechaMes->startOfMonth()->format('Y-m-d');
            $fechaFinalMesActual = $fechaMes->endOfMonth()->format('Y-m-d 23:59:59');

            // Obtener las fechas de inicio y fin de los meses anteriores
            $fechaInicioMesAnterior = $fechaMesAnterior->startOfMonth()->format('Y-m-d');
            $fechaFinalMesAnterior = $fechaMesAnterior->endOfMonth()->format('Y-m-d 23:59:59');

            $fechaInicioMesAnterior2 = $fechaMesAnterior2->startOfMonth()->format('Y-m-d');
            $fechaFinalMesAnterior2 = $fechaMesAnterior2->endOfMonth()->format('Y-m-d 23:59:59');

            $fechaInicioMesAnterior3 = $fechaMesAnterior3->startOfMonth()->format('Y-m-d');
            $fechaFinalMesAnterior3 = $fechaMesAnterior3->endOfMonth()->format('Y-m-d 23:59:59');

            // Obtener las ventas de los meses
            $ventasMesActual = Ventas::whereBetween('fecha', [$fechaInicioMesActual, $fechaFinalMesActual])->sum('precio');
            $ventasMesAnterior = Ventas::whereBetween('fecha', [$fechaInicioMesAnterior, $fechaFinalMesAnterior])->sum('precio');
            $ventasMesAnterior2 = Ventas::whereBetween('fecha', [$fechaInicioMesAnterior2, $fechaFinalMesAnterior2])->sum('precio');
            $ventasMesAnterior3 = Ventas::whereBetween('fecha', [$fechaInicioMesAnterior3, $fechaFinalMesAnterior3])->sum('precio');

            $data = [
                'ventasDiaActual' => [
                    'fecha' => $mesesEnEspanol[$mes] . ' ' . $anio, // Por ejemplo: "julio 2023"
                    'total' => $ventasMesActual
                ],
                'ventasDiaAnterior' => [
                    'fecha' => $mesesEnEspanol[$fechaMesAnterior->month] . ' ' . $fechaMesAnterior->year, // Por ejemplo: "junio 2023"
                    'total' => $ventasMesAnterior
                ],
                'ventasDiaAnterior2' => [
                    'fecha' => $mesesEnEspanol[$fechaMesAnterior2->month] . ' ' . $fechaMesAnterior2->year, // Por ejemplo: "mayo 2023"
                    'total' => $ventasMesAnterior2
                ],
                'ventasDiaAnterior3' => [
                    'fecha' => $mesesEnEspanol[$fechaMesAnterior3->month] . ' ' . $fechaMesAnterior3->year, // Por ejemplo: "abril 2023"
                    'total' => $ventasMesAnterior3
                ]
            ];

        }
        
        return response()->json($data);
    }

    
}