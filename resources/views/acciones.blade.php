<script>

    function cambiarFiltroRangoFechas(obj){

        let fechas_dia = document.getElementById('rango_fechas_dia');
        let fechas_rango = document.getElementById('rango_fechas_form');
        let valor_select = obj.value;

        switch (valor_select) {

            case '1':
            
            fechas_rango.classList.add('rango_fechas_class');
            fechas_dia.style.display = 'block';

                break;

            case '2':
        
                fechas_rango.classList.remove('rango_fechas_class');
                fechas_dia.style.display = 'none';

                break;

            default:
                break;

        }
    }

    function cambiarFiltroRangoFechasEstadisticas(obj){

        let fechas_dia = document.getElementById('estadisticas_dia');
        let fechas_semana = document.getElementById('estadisticas_semana');
        let fechas_mes = document.getElementById('estadisticas_mes');
        let valor_select = obj.value;


        switch (valor_select) {

            

            case '1':
                
                fechas_semana.classList.add('estadisticas_semana');
                fechas_mes.classList.add('estadisticas_mes');
                fechas_dia.style.display = 'block';

                break;

            case '2':
        
                fechas_semana.classList.remove('estadisticas_semana');
                fechas_mes.classList.add('estadisticas_mes');
                fechas_dia.style.display = 'none';

                break;

            case '3':
        
                fechas_mes.classList.remove('estadisticas_mes');
                fechas_semana.classList.add('estadisticas_semana');
                fechas_dia.style.display = 'none';

                break;

            default:
                break;
        }

    }

</script>