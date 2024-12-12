<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>Administracion</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"/>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css"/>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<!-- partial:index.partial.html -->
<div id="viewport">
  <!-- Sidebar -->
  <div id="sidebar">
    <header>
      <a href="#">CHEAPMING</a>
    </header>
    <ul class="opciones">
      <li style="margin-top: 20px;padding-bottom:10px;border-bottom:solid 1px #263238;">
        <a href="{{ route('logistica') }}" style="color:white;">
          <i class="opcion"></i>Logistica
        </a>
      </li>
      <li style="margin-top: 20px;padding-bottom:10px;border-bottom:solid 1px #263238;">
        <a href="{{ route('servicios') }}" style="color:white;">
          <i class="opcion"></i>Plataformas
        </a>
      </li>
      @if (in_array(auth()->user()->username, ['Valentina']))
        <li style="margin-top: 20px;padding-bottom:10px;border-bottom:solid 1px #263238;">
            <a href="{{ route('administracion-ventas') }}" style="color:white;">
                <i class="opcion"></i>Administración ventas
            </a>
        </li>
        <li style="margin-top: 20px;padding-bottom:10px;border-bottom:solid 1px #263238;">
            <a href="{{ route('estadisticas') }}" style="color:white;">
                <i class="opcion"></i>Estadisticas
            </a>
        </li>
    @endif
    </ul>
  </div>
  <!-- Content -->
  <div id="content">

    <div class="contenedor">
      <div class="elemento-izquierda">
        @if (auth()->check())
          <a style="color:#263238;" class="bottom-link" href="#">{{ auth()->user()->responsable }}</a>
        @endif
      </div>
      <div class="elemento-derecha">
        <a style="color:#263238;" href="{{ route('login') }}">Cerrar sesión &nbsp;&nbsp;<i class="fa-sharp fa-solid fa-right-from-bracket"></i></a>
      </div>
    </div>
    <div class="container-fluid">
        @yield('contenido')
    </div>
  </div>
</div>
<!-- partial -->

</body>
</html>

<style>
    @import url('https://fonts.googleapis.com/css?family=Roboto:300,400,400i,500');

    body {
    overflow-x: hidden;
    font-family: 'Roboto', sans-serif;
    font-size: 16px;
    }

    /* Toggle Styles */

    #viewport {
    padding-left: 250px;
    }

    #content {
    width: 100%;
    position: relative;
    margin-right: 0;
    }

    /* Sidebar Styles */

    #sidebar {
    z-index: 1000;
    position: fixed;
    left: 250px;
    width: 250px;
    height: 100%;
    margin-left: -250px;
    overflow-y: auto;
    background: #37474F;
    }

    #sidebar header {
    background-color: #263238;
    font-size: 20px;
    line-height: 52px;
    text-align: center;
    }

    #sidebar header a {
    color: #fff;

    text-decoration: none;
    }

    #sidebar header a:hover {
    color: #fff;
    }

    #sidebar .nav a{
    background: none;
    color: #CFD8DC;
    font-size: 14px;
    }

    #sidebar .nav a:hover{
    background: none;
    color: #ECEFF1;
    }

    #sidebar .nav a i{
    margin-right: 16px;
    }

    .opcion{
      margin-top: 55px;
    }
    .opciones{
      list-style: none;
      color: white;
      text-align: center;
      margin-right: 50px;
    }

    a:hover{
      text-decoration: none;
    }

    .contenedor {
      padding-top: 15px;
      display: flex;
      justify-content: space-between;
      width: 100%;
    }

    .elemento-izquierda{
      margin-left: 6%;
    }

    .elemento-derecha{
      margin-right: 6%;
    }

</style>
