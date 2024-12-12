@extends('layout.administracion')

@section('contenido')

@include('estilos-acciones')

<section class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="row">   

                <div class="contenedor">
                    <h2 class="my-4">ESTADISTICAS</h2>
                </div>

                <div class="row contenedor">
                        <div class="col-lg-4">
                            <div class="form-outline" style="margin-top:30px;">
                                <select onchange="cambiarFiltroRangoFechasEstadisticas(this)" id="filtro_fechas_ventas" class="form-control">
                                    <option value="1">Estadisticas por día</option>
                                    <option value="2">Estadisticas por semana</option>
                                    <option value="3">Estadisticas por mes</option>
                                </select>         
                            </div>
                        </div>
                        
                        <div class="col-lg-6" id="estadisticas_dia">
                            <div class="form-outline">
                                <label class="form-label" for="form3Example1cg">Seleccionar día</label>
                                <input type="date" id="fecha_busqueda" name="fecha_busqueda" class="form-control form-control-md" value="<?php echo date('Y-m-d')?>"/>
                            </div>
                        </div>
                        
                        <div class="col-lg-6 estadisticas_semana" id="estadisticas_semana">
                            <div class="form-outline">
                                <label class="form-label" for="form3Example1cg">Seleccionar semana</label>
                                
                                <input type="week" id="fecha_semana" name="fecha_semana" class="form-control form-control-md" value="<?php echo date('Y-\WW') ?>"/>
                            </div>
                        </div>

                        <div class="col-lg-6 estadisticas_mes" id="estadisticas_mes">
                            <div class="form-outline">
                                <label class="form-label" for="form3Example1cg">Seleccionar mes</label>
                                <input type="month" id="fecha_mes" name="fecha_mes" class="form-control form-control-md" value="<?php echo date('Y-m'); ?>"/>
                            </div>
                        </div>

                        <div class="col-lg-2">
                            <button class="btn btn-success" id="btn_buscar_fecha"style="background-color: #37474f;border-color:#37474f;height:fit-content;margin-top:32px;">
                                <i class="fa-solid fa-search"></i>&nbsp; Buscar
                            </button>
                        </div>
                </div>

                <div style="width: 100%;border-top:1px solid #e5e5e5; margin-top:50px;"></div>

                <div class="row" style="margin-top:50px;">
                    <div class="row" id="espacio_graficas" class="espacio_graficas">
                        <canvas id="myPieChart" style="max-width:420px; max-height:420px; margin-left:150px;"></canvas>
                        <div style="margin-top:170px; margin-left:50px;">
                            <p><b>TOTAL VENTAS: </b><span id="total_ventas"></span></p>
                            <p><b>MÁS VENDIDO: </b><span id="mas_vendidos"></span></p>
                            <p><b>MENOS VENDIDO: </b><span id="menos_vendidos"></span></p>
                        </div>
                    </div>
                </div>

                <div id="texto_vacio" class="texto_vacio" style="border: 1px solid grey; margin-top:100px; padding:50px; background:#c9c9ca; border-radius:10px; margin-left:200px;">
                    <h2 style="">No se encontraron datos</h2>
                </div>

                <div style="width: 100%;border-top:1px solid #e5e5e5; margin-top:50px;"></div>
                <div style="margin-top:100px; margin-bottom:50px;">
                    <h2 style="margin-left:25%; margin-bottom:50px; width: 100%;">COMPARATIVO FECHAS ANTERIORES</h2>
                    <canvas id="ventasChart" class="ventasChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</section>


@include('estadisticas_ajax')

@include('acciones')

@endsection