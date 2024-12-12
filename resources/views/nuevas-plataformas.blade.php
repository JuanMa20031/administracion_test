@extends('layout.administracion')

@section('contenido')

<section style="margin-top:30px;">

    <form method="post">
        <div class="row">
            <div class="col-lg-6">
                <input type="text" placeholder="Nombre de la plataforma" name="descripcion" id="descripcion_nueva_plataforma" class="form-control">
            </div>
            <div class="col-lg-2">
                <button class="btn btn-success" id="btn_env_plataformas" type="button" style="background-color: #37474f;border-color:#37474f;height:fit-content;">Agregar</button>   
            </div>
        </div>
    </form>

</section>

<br>
<hr>

<section class="container">
        <div class="row">
            <div class="col-lg-6">

                <div class="contenedor">
                    <h2 class="my-4">PLATAFORMAS</h2>
                </div>

                <table class="table table-sm table-responsive-md table-hover my-4">

                    <thead>
                        <th>NOMBRE DEL SERVICIO</th>
                    </thead>

                    <tbody id="result">

                    </tbody>
                </table>
            </div>
            <div class="col-lg-6">

                <div class="contenedor" >
                    <h2 class="my-4">PLATAFORMAS RENO</h2>
                </div>

                <table class="table table-sm table-responsive-md table-hover my-4">

                    <thead>
                        <th>NOMBRE DEL SERVICIO</th>
                    </thead>

                    <tbody id="result2">

                    </tbody>
                </table>
            </div>
        </div>
    </section>

@include('nuevas-plataformas_ajax')

@endsection