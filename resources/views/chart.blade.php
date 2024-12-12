@extends('layout.administracion')

<div class="container">
    <canvas id="myChart" width="400" height="200"></canvas>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Realizar una solicitud AJAX para obtener los datos del gráfico
        fetch('{{ route('chart-data') }}') // Corrige la ruta aquí
            .then(response => response.json())
            .then(data => {
                // Crear el gráfico usando los datos obtenidos
                var ctx = document.getElementById('myChart').getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: data,
                });
            });
    });
</script>