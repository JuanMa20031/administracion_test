<script>

    loadData();

    $("#btn_env_plataformas").click(function(e) {

        e.preventDefault();

        var descripcion = $('#descripcion_nueva_plataforma').val();

        if(descripcion == ""){
            toastr.warning("El nombre de servicio no puede estar vacío");
            return false;
        }

        $.ajax({

            url: "api/nuevas-plataformas/create",
            type: "POST",
            data: {
                descripcion:descripcion
            },
            success:function(data){

                toastr.success("Se agregó la plataforma correctamente");

                loadData();

            },error: function (data) {

                toastr.error("Ha ocurrido un error, verifique la información");
            }
        });
    });

    // Funcion que carga todos los registros
    function loadData() {
        $.get('api/nuevas-plataformas', function (response) {
            var content = '';
            var content2 = '';

            if (response.data && Array.isArray(response.data.plataformas)) {
                response.data.plataformas.forEach(function (item) {
                    content += '<tr>';
                    content += '<td>' + item.descripcion + '</td>';
                    content += '</tr>';
                });
            }

            if (response.data && Array.isArray(response.data.plataformasReno)) {
                response.data.plataformasReno.forEach(function (item) {
                    content2 += '<tr>';
                    content2 += '<td>' + item.descripcion + '</td>';
                    content2 += '</tr>';
                });
            }

            $('#result').html(content);
            $('#result2').html(content2);
        });
    }

</script>
