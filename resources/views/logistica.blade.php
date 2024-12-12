@extends('layout.administracion')

@section('contenido')

<hr>
<section class="container">
    <div class="row">
        <div class="col-lg-12">
            <form action="" method="GET">
                <div class="row">
                    <div class="col-lg-3">
                        <select name="servicios_filtros" id="servicios_filtros"  class="form-control">
                        </select>
                        Plataforma
                    </div>

                    <div class="col-lg-3">
                        <input type="date" name="fecha_inicio_filtro" id="fecha_inicio_filtro" class="form-control">
                        Fecha Inicial
                    </div>

                    <div class="col-lg-3">
                        <input type="date" name="fecha_venc_filtro" id="fecha_venc_filtro" class="form-control">
                        Fecha Vencimiento
                    </div>

                    <div class="col-lg-3">
                        <select name="decision_filtro" id="decision_filtro" class="form-control">
                            <option value="" selected>DECISION</option>
                            <option value="0">ACTIVO</option>
                            <option value="1">CORTE</option>
                        </select>
                        Decision
                    </div>
                </div>
                <br><button type="button" class="btn" style="background-color: #37474f;border-color:#37474f;height:fit-content;margin-top:20px;color:white;" onclick="loadData()">APLICAR FILTROS</button>
            </form>
        </div>
    </div>
</section>
<hr>

<section class="container">
    <div class="row">
        <div class="col-lg-12">

            <div class="contenedor">
                <h2 class="my-4">LOGISTICA</h2>
                <button class="btn btn-success" id="btn-create" style="background-color: #37474f;border-color:#37474f;height:fit-content;margin-top:20px;"><i class="fa-solid fa-plus"></i>&nbsp; Agregar</button>
            </div>

            <table class="table table-sm table-responsive-md table-responsive-lg table-responsive-sm table-hover my-4">

                <thead>
                    <th>NOMBRE</th>
                    <th>PANTALLAS</th>
                    <th>PLATAFORMA</th>
                    <th>CELULAR</th>
                    <th>DIAS</th>
                    <th>INICIO</th>
                    <th>VENCIMIENTO</th>
                    <th>RESTANTES</th>
                    <th>DECISION</th>
                    <th>CORTE</th>
                    <th>RESPONSABLE</th>
                    <th>ACCIONES</th>
                </thead>

                <tbody id="result">

                </tbody>
            </table>
        </div>
    </div>
</section>

<!-- MODAL CREATE -->
<div class="modal fade" id="modalCreate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Agregar registro</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
            <form id="form-register">

                @csrf

                <input type="hidden" name="responsable" id="responsable" value="{{auth()->user()->responsable}}">

                <div class="form-outline mb-4">
                    <select name="servicio_id" id="servicio_idEdit"  class="form-control form-control-md">

                    </select>
                    <label class="form-label" for="form3Example1cg">Plataforma</label>
                </div>

                <div class="form-outline mb-4">
                    <input type="text" id="nombre" name="nombre" class="form-control form-control-md" />
                    <label class="form-label" for="form3Example1cg">Nombre</label>
                </div>

                <div class="form-outline mb-4">
                    <input type="text" id="celular" name="celular" class="form-control form-control-md" />
                    <label class="form-label" for="form3Example1cg">Celular</label>
                </div>

                <div class="form-outline d-flex justify-content-between align-items-center">
                    <input type="number" id="pantallas" name="pantallas" class="form-control col-5" />
                    <input type="number" id="dias" name="dias" class="form-control col-5" />
                </div>

                <div class="form-outline mb-4  d-flex justify-content-between align-items-center">
                    <label class="form-label" for="form3Example1cg">Pantallas</label>
                    <label class="form-label" for="form3Example1cg" style="margin-right: 22%;">Días del plan</label>
                </div>

                <div class="form-outline mb-4">
                    <input type="date" id="fecha_inicio" name="fecha_inicio" class="form-control form-control-md" />
                    <label class="form-label" for="form3Example1cg">Fecha de inicio</label>
                </div>
            </form>
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="btn-env-create">Guardar</button>
        </div>
    </div>
    </div>
</div>

<!-- MODAL EDIT -->
<div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Editar registro</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
        
            <form id="form-register">
                @csrf

                <input type="hidden" name="id_tr" id="id_tr">
                <input type="hidden" name="responsable" id="responsableEdit" value="{{auth()->user()->responsable}}">

                <div class="form-outline mb-4">
                    <select name="servicio_id" id="servicio_idEdit2"  class="form-control form-control-md">

                    </select>
                    <label class="form-label" for="form3Example1cg">Plataforma</label>
                </div>

                <div class="form-outline mb-4">
                    <input type="text" id="nombreEdit" name="nombre" class="form-control form-control-md" />
                    <label class="form-label" for="form3Example1cg">Nombre</label>
                </div>

                <div class="form-outline mb-4">
                    <input type="text" id="celularEdit" name="celular" class="form-control form-control-md" />
                    <label class="form-label" for="form3Example1cg">Celular</label>
                </div>

                <div class="form-outline d-flex justify-content-between align-items-center">
                    <input type="number" id="pantallasEdit" name="pantallas" class="form-control col-5" />
                    <input type="number" id="diasEdit" name="dias" class="form-control col-5" />
                </div>

                <div class="form-outline mb-4  d-flex justify-content-between align-items-center">
                    <label class="form-label" for="form3Example1cg">Pantallas</label>
                    <label class="form-label" for="form3Example1cg" style="margin-right: 22%;">Días del plan</label>
                </div>

                <div class="form-outline mb-4">
                    <input type="date" id="fecha_inicioEdit" name="fecha_inicio" class="form-control form-control-md" />
                    <label class="form-label" for="form3Example1cg">Fecha de inicio</label>
                </div>

                <div class="form-outline mb-4">
                    <input type="date" id="fecha_corteEdit" name="fecha_corte" class="form-control form-control-md" />
                    <label class="form-label" for="form3Example1cg">Fecha corte</label>
                </div>
                
            </form>
            
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="btn-env-edit">Guardar</button>
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

<!-- MODAL AVISOS -->
<div class="modal fade" id="modalAvisos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Avisos</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
        
            <section id="avisos">

            </section>
            <input type="hidden" id="idAvisosF" name="idAvisosF">
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="btn-env-avisos">Guardar</button>
        </div>
    </div>
    </div>
</div>

<style>
    table{
        font-size: 13px;
    }
    .contenedor {
        padding-top: 55px;
        display: flex;
        width: 100%;
    }
</style>

@include('logistica_ajax')

@endsection