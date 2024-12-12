<script>

    var myPieChart;
    var ventasChart;

    document.addEventListener('DOMContentLoaded', function () {
        loadPieChart();
        loadComparativeChart();
    });


    function loadPieChart() {
        let value_fechas = document.getElementById("filtro_fechas_ventas").value;
        let parametros_busqueda = "";

        if (value_fechas == 1) {
            let fecha_dia = document.getElementById("fecha_busqueda").value;

            if (fecha_dia == '') {
                toastr.warning("Debe seleccionar una fecha");
                return false;
            }

            parametros_busqueda = 'fechaEspecifica=' + fecha_dia;

        } else if (value_fechas == 2) {
            let fecha_semana = document.getElementById("fecha_semana").value;

            // Dividir la cadena de fecha_semana en sus componentes de semana y año
            let [anio, semana] = fecha_semana.split("-");

            if (semana == '' || anio == '') {
                toastr.warning("Debe seleccionar una fecha");
                return false;
            }

            // Construir los parámetros de búsqueda con la semana y el año seleccionados
            parametros_busqueda = 'semana=' + semana + '&anio=' + anio;

        } else if (value_fechas == 3) {
            let fecha_mes = document.getElementById("fecha_mes").value;

            let [anio, mes] = fecha_mes.split("-");

            if (fecha_mes == '') {
                toastr.warning("Debe seleccionar una fecha");
                return false;
            }

            parametros_busqueda = 'mes=' + mes + '&anio=' + anio;
        }


        // Realizar la solicitud AJAX para obtener los datos del gráfico de torta con la fecha seleccionada
        fetch('pie-chart?' + parametros_busqueda)
            .then(response => response.json())
            .then(data => {


                if (data.length == 0) {

                    var textoVacio = document.getElementById("texto_vacio");
                    textoVacio.classList.remove('texto_vacio');

                    var espacioGraficas = document.getElementById("espacio_graficas");
                    espacioGraficas.classList.add('espacio_graficas');

                    return false;
                }

                var textoVacio = document.getElementById("texto_vacio");
                textoVacio.classList.add('texto_vacio');

                var espacioGraficas = document.getElementById("espacio_graficas");
                espacioGraficas.classList.remove('espacio_graficas');

                // Actualizar los valores en el HTML
                var totalVentas = data.totalVentas;
                var masVendidoNombre = data.masVendido.nombre;
                var masVendidoTotal = data.masVendido.total;
                var menosVendidoNombre = data.menosVendido.nombre;
                var menosVendidoTotal = data.menosVendido.total;

                document.getElementById('total_ventas').innerText = totalVentas;
                document.getElementById('mas_vendidos').innerText = masVendidoNombre + ", " + masVendidoTotal + " vendidos";
                document.getElementById('menos_vendidos').innerText = menosVendidoNombre + ", " + menosVendidoTotal + " vendidos";

                // Crear el gráfico de torta usando los datos obtenidos
                var ctx = document.getElementById('myPieChart').getContext('2d');
                // Verificar si ya existe un gráfico de torta y destruirlo antes de crear uno nuevo
                if (window.myPieChart) {
                    window.myPieChart.destroy();
                }
                var myPieChart = new Chart(ctx, {
                    type: 'pie',
                    data: data,
                });
                // Guardar una referencia del gráfico en la ventana para poder destruirlo la próxima vez
                window.myPieChart = myPieChart;
            })
            .catch(error => console.error("Error al obtener los datos del gráfico:", error));
    }

    // Asociar el evento click del botón para cargar el gráfico de torta con la fecha seleccionada
    $("#btn_buscar_fecha").click(function() {
        loadPieChart();
    });

    function loadComparativeChart() {

        let value_fechas = document.getElementById("filtro_fechas_ventas").value;
        let parametros_busqueda = "";

        if (value_fechas == 1) {
            let fecha_dia = document.getElementById("fecha_busqueda").value;

            if (fecha_dia == '') {
                toastr.warning("Debe seleccionar una fecha");
                return false;
            }

            parametros_busqueda = 'fechaEspecifica=' + fecha_dia;

        } else if (value_fechas == 2) {
            let fecha_semana = document.getElementById("fecha_semana").value;

            let [anio, semana] = fecha_semana.split("-");

            if (semana == '' || anio == '') {
                toastr.warning("Debe seleccionar una fecha");
                return false;
            }

            // Construir los parámetros de búsqueda con la semana y el año seleccionados
            parametros_busqueda = 'semana=' + semana + '&anio=' + anio;

        } else if (value_fechas == 3) {
            let fecha_mes = document.getElementById("fecha_mes").value;

            let [anio, mes] = fecha_mes.split("-");

            if (fecha_mes == '') {
                toastr.warning("Debe seleccionar una fecha");
                return false;
            }

            parametros_busqueda = 'mes=' + mes + '&anio=' + anio;
        }

        fetch('comparative-chart?'+ parametros_busqueda)
        .then(response => response.json())
        .then(data => {

            const ventasDiaActual = data.ventasDiaActual.total;
            const ventasDiaAnterior = data.ventasDiaAnterior.total;
            const ventasDiaAnterior2 = data.ventasDiaAnterior2.total;
            const ventasDiaAnterior3 = data.ventasDiaAnterior3.total;

            const fechaDiaActual = data.ventasDiaActual.fecha;
            const fechaDiaAnterior = data.ventasDiaAnterior.fecha;
            const fechaDiaAnterior2 = data.ventasDiaAnterior2.fecha;
            const fechaDiaAnterior3 = data.ventasDiaAnterior3.fecha;

            const labels = [fechaDiaAnterior3, fechaDiaAnterior2, fechaDiaAnterior , fechaDiaActual];
            const data2 = {
                labels: labels,
                datasets: [
                {
                    label: "Ventas S/",
                    data: [ventasDiaAnterior3, ventasDiaAnterior2, ventasDiaAnterior, ventasDiaActual],
                    backgroundColor: "rgba(75, 192, 192, 0.2)",
                    borderColor: "rgba(75, 192, 192, 1)",
                    borderWidth: 2,
                },
                ],
            };



            const config = {
                type: "bar",
                data: data2,
                options: {
                responsive: true,
                scales: {
                    y: {
                    beginAtZero: true,
                    },
                },
                },
            };

            const ctx = document.getElementById("ventasChart").getContext("2d");

            if (window.ventasChart) {
                window.ventasChart.destroy();
            }

            window.ventasChart = new Chart(ctx, config);
        })
        .catch(error => console.error("Error al obtener los datos del gráfico:", error));

    };

    $("#btn_buscar_fecha").click(function() {
        loadComparativeChart();
    });

</script>
