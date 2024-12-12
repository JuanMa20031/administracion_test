@extends('layout.administracion')

@section('contenido')

@include('estilos-acciones')

<section class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="row">

                <input type="hidden" id="fecha_hoy" value="<?php echo date('Y-m-d')?>">    

                <div class="contenedor">
                    <h2 class="my-4">ADMINISTRACIÓN VENTAS</h2>
                    <button class="btn btn-success" id="btn-create2" style="background-color: #37474f;border-color:#37474f;height:fit-content; margin-top:20px;"><i class="fa-solid fa-plus"></i>&nbsp; Agregar Venta</button>
                </div>

                <div class="row contenedor">
                    <div class="col-lg-4">
                        <div class="form-outline" style="margin-top:30px;">
                            <select onchange="cambiarFiltroRangoFechas(this)" name="filtro_fechas_ventas" id="filtro_fechas_ventas" class="form-control">
                                <option value="1">Filtrar por día</option>
                                <option value="2">Filtrar por rango de fechas</option>
                            </select>         
                        </div>
                    </div>

                    <div class="col-lg-6" id="rango_fechas_dia">
                        <div class="form-outline">
                            <label class="form-label" for="form3Example1cg">Seleccionar día</label>
                            <input type="date" id="fecha_busqueda" name="fecha_busqueda" class="form-control form-control-md" value="<?php echo date('Y-m-d')?>"/>
                        </div>
                    </div>

                    <div class="row rango_fechas_class" id="rango_fechas_form">
                        <div class="form-outline col-lg-6">
                            <label class="form-label" for="form3Example1cg">Fecha inicial</label>
                            <input type="date" id="fecha_inicial" name="fecha_inicial" class="form-control form-control-md" />
                        </div>
                        <div class="form-outline col-lg-6">
                            <label class="form-label" for="form3Example1cg">Fecha final</label>
                            <input type="date" id="fecha_final" name="fecha_final" class="form-control form-control-md" />
                        </div>
                    </div>

                    <div class="col-lg-2">
                        <button class="btn btn-success" id="btn_buscar_fecha"style="background-color: #37474f;border-color:#37474f;height:fit-content;margin-top:32px;">
                            <i class="fa-solid fa-search"></i>&nbsp; Buscar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<br>

<hr>


<div class="contenedor">
    <div class="row" style="margin-left:10px;">
        <b><p>Total movimientos: </p></b>
        <div id="total_movimientos"></div>
    </div>
    <div class="row" style="margin-right:10px;">
        <b><p>Total ventas: </p></b>
        <div id="total_ventas"></div>
    </div>
</div>


<section id="espacio_movimientos">

</section>

<!-- MODAL CREATE -->
<div class="modal fade" id="modalCreate2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Agregar venta</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
        
            <form id="form-register">

                @csrf
                
                <div class="row">
                    
                    <div class="col-lg-6">
                        <div class="form-outline">
                            <label class="form-label" for="form3Example1cg">Plataforma 1</label>
                            <select  class="form-control" name="plataforma1" id="plataforma1_sel">
                                
                            </select>         
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <label class="form-label" for="form3Example1cg">Plataforma 2</label>
                        <div class="form-outline">
                            <select  class="form-control" name="plataforma2" id="plataforma2_sel">
                                
                            </select>         
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    
                    <div class="col-lg-6">
                        <div class="form-outline">
                            <label class="form-label" for="form3Example1cg">Plataforma 3</label>
                            <select  class="form-control" name="plataforma3" id="plataforma3_sel">
                                
                            </select>         
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <label class="form-label" for="form3Example1cg">Plataforma 4</label>
                        <div class="form-outline">
                            <select  class="form-control" name="plataforma4" id="plataforma4_sel">
                                
                            </select>         
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">

                    <div class="col-lg-12">
                        <label class="form-label" for="form3Example1cg">Fecha venta</label>
                        <input type="date" id="fecha_venta" value="<?php echo date('Y-m-d')?>" name="fecha_venta" class="form-control form-control-md" />
                    </div>

                </div>
                <br>
                <div class="row">

                    <div class="col-lg-4">
                        <label class="form-label" for="form3Example1cg">Meses</label>
                        <input type="number" id="meses" name="meses" class="form-control form-control-md" />
                    </div>
                    
                    <div class="col-lg-4">
                        <label class="form-label" for="form3Example1cg">Precio S/</label>
                        <input type="number" id="precio" name="precio" class="form-control form-control-md" />
                    </div>
                    <div class="col-lg-4">
                        <label class="form-label" for="form3Example1cg">Celular</label>
                        <input type="text" id="celular" name="celular" class="form-control form-control-md" />
                    </div>
                </div>

            </form>
            <br>
            
        </div>

        <a href="{{ route('nuevas-plataformas') }}" class="mx-3 my-2">Agregar nuevas plataformas</a>

        <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="btn-env-add">Agregar</button>
        </div>
    </div>
    </div>
</div>

<!-- MODAL DELETE -->
<div class="modal fade" id="modalDelete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Borrar registro</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
        
            <p>¿Estás seguro de que quieres borrar el siguiente registro?</p><br>

            <p id="infoDelete"></p>

            <input type="hidden" id="idDelete" name="idDelete">
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-danger" id="btn-env-delete">Confirmar</button>
        </div>
    </div>
    </div>
</div>

<!-- MODAL EDIT -->
<div class="modal fade" id="modalEdit2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Editar venta</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
        
            <form id="form-register">

                @csrf
                
                <input type="hidden" name="id_tr" id="id_tr">

                <div class="row">
                    
                    <div class="col-lg-6">
                        <div class="form-outline">
                            <label class="form-label" for="form3Example1cg">Plataforma 1</label>
                            <select  class="form-control" name="plataforma1" id="plataforma1_selEdit">
                                
                            </select>         
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <label class="form-label" for="form3Example1cg">Plataforma 2</label>
                        <div class="form-outline">
                            <select  class="form-control" name="plataforma2" id="plataforma2_selEdit">
                                
                            </select>         
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    
                    <div class="col-lg-6">
                        <div class="form-outline">
                            <label class="form-label" for="form3Example1cg">Plataforma 3</label>
                            <select  class="form-control" name="plataforma3" id="plataforma3_selEdit">
                                
                            </select>         
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <label class="form-label" for="form3Example1cg">Plataforma 4</label>
                        <div class="form-outline">
                            <select  class="form-control" name="plataforma4" id="plataforma4_selEdit">
                                
                            </select>         
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">

                    <div class="col-lg-12">
                        <label class="form-label" for="form3Example1cg">Fecha venta</label>
                        <input type="date" id="fecha_ventaEdit" name="fecha_venta" class="form-control form-control-md" />
                    </div>

                </div>
                <br>
                <div class="row">

                    <div class="col-lg-4">
                        <label class="form-label" for="form3Example1cg">Meses</label>
                        <input type="number" id="mesesEdit" name="meses" class="form-control form-control-md" />
                    </div>
                    
                    <div class="col-lg-4">
                        <label class="form-label" for="form3Example1cg">Precio S/</label>
                        <input type="number" id="precioEdit" name="precio" class="form-control form-control-md" />
                    </div>
                    <div class="col-lg-4">
                        <label class="form-label" for="form3Example1cg">Celular</label>
                        <input type="text" id="celularEdit" name="celular" class="form-control form-control-md" />
                    </div>
                </div>

            </form>
            <br>
            
        </div>

        <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="btn-env-edit">Guardar</button>
        </div>
    </div>
    </div>
</div>

@include('administracion-ventas_ajax')

@include('acciones')

@endsection