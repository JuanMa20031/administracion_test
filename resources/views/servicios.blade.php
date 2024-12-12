@extends('layout.administracion')

@section('contenido')

    <section class="container">
        <div class="row">
            <div class="col-lg-12">

                <div class="contenedor">
                    <h2 class="my-4">PLATAFORMAS</h2>
                    <button class="btn btn-success" id="btn-create" style="background-color: #37474f;border-color:#37474f;height:fit-content;margin-top:20px;"><i class="fa-solid fa-plus"></i>&nbsp; Agregar</button>
                </div>

                <table class="table table-sm table-responsive-md table-hover my-4">

                    <thead>
                        <th>NOMBRE</th>
                        <th>ESTADO</th>
                        <th>CREADO POR</th>
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
            <h5 class="modal-title" id="exampleModalLabel">Agregar servicio</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
            
                <form id="form-register">

                    @csrf
                    <input type="hidden" name="responsable" id="responsable" value="{{auth()->user()->responsable}}">

                    <div class="form-outline mb-4">
                        <input type="text" id="descripcion" name="descripcion" class="form-control form-control-md" />
                        <label class="form-label" for="form3Example1cg">Nombre</label>
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
            <h5 class="modal-title" id="exampleModalLabel">Editar servicio</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
            
                <form id="form-register">
                    @csrf

                    <input type="hidden" name="responsable" id="responsableEdit" value="{{auth()->user()->responsable}}">


                    <input type="hidden" name="id_tr" id="id_tr">

                    <div class="form-outline mb-1">
                        <input type="text" id="descEdit" name="descripcion" class="form-control form-control-md" />
                        <label class="form-label" for="form3Example1cg">Nombre</label>
                    </div>

                        <input type="hidden" id="estadoEdit" name="descripcion" class="form-control form-control-lg" />
                       {{--  <label class="form-label" for="form3Example1cg">Estado</label> --}}
                    
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
            <h5 class="modal-title" id="exampleModalLabel">Inactivar servicio</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
            
                <p>¿Estás seguro de que quieres inactivar el siguiente servicio?</p><br>

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

    @include('servicios_ajax')

@endsection