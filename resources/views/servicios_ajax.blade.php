<script>

    loadData();

    // Desplegar modal creacion
    $("#btn-create").click(function() {

        $("#modalCreate").modal("show");
    });

    // Desplegar modal edicion y cargar informacion del registro
    $('body').on('click', '.editService', function () {

        var id = $(this).data('id');

        $.get('api/servicios/details/'+id,function(response){

            var descripcion = response.descripcion;
            var estado = response.estado;

            document.getElementById('descEdit').value = descripcion;
            document.getElementById('estadoEdit').value = estado;
            document.getElementById('id_tr').value = id;
        });

        $("#modalEdit").modal("show");

    });

    // Desplegar modal para eliminar y cargar informacion del registro
    $('body').on('click', '.deleteService', function () {

        $("#modalDelete").modal("show");

        var id = $(this).data('id');

        $.get('api/servicios/details/'+id,function(response){

             var descripcion = response.descripcion;
            var datos = '<b>Nombre: </b> '+descripcion;

            document.getElementById('infoDelete').innerHTML = datos;
            document.getElementById('idDelete').value = id;
        });

    });

    $('body').on('click', '.enableService', function () {

        var id = $(this).data('id');

        $.post('api/servicios/activar/'+id,function(response){
            toastr.success("Se activó el servicio correctamente");
            loadData();

        });
    });

    // AJAX para borrar el registro
    $('#btn-env-delete').click(function(e){

        var id = document.getElementById('idDelete').value;

        $.ajax({

            url: "api/servicios/delete/"+id,
            type: "POST",

            success:function(data){

                $("#modalDelete").modal("hide");

                toastr.success("Se inactivó el servicio correctamente");

                loadData();

            },error: function (data) {

                toastr.error("Ha ocurrido un error");
            }
        });
    });


    // AJAX para crear el registro
    $( "#btn-env-create" ).click(function(e) {

        e.preventDefault();

        var descripcion = $('#descripcion').val();
        var responsable = $('#responsable').val();

        if(descripcion == ""){
            toastr.warning("El nombre de servicio no puede estar vacío");
            return false;
        }

        $.ajax({

            url: "api/servicios/create",
            type: "POST",
            data: {
                descripcion:descripcion,
                responsable:responsable
            },
            success:function(data){

                $("#modalCreate").modal("hide");

                $("#descripcion").val("");

                toastr.success("Se agregó el servicio correctamente");

                loadData();

            },error: function (data) {

                toastr.error("Ha ocurrido un error, verifique la información");
            }
        });
    });


    $( "#btn-env-edit" ).click(function(e) {

        e.preventDefault();

        var descripcion = $('#descEdit').val();
        var estado = $('#estadoEdit').val();
        var responsable = $('#responsableEdit').val();
        var id = $('#id_tr').val();

        if(descripcion == ""){
            toastr.warning("El nombre no puede estar vacío");
            return false;
        }

        $.ajax({

            url: "api/servicios/update/"+id,
            type: "POST",
            data: {
                descripcion:descripcion,
                responsable:responsable,
                estado:estado
            },
            success:function(data){

                $("#modalEdit").modal("hide");

                $("#descripcion").val("");
                $("#estado").val("");

                toastr.success("Se modificó el servicio correctamente");

                loadData();

            },error: function (data) {

                toastr.error("Ha ocurrido un error, verifique la información");
            }
        });
    });

    // Funcion que carga todos los registros
    function loadData() {

        $.get('api/servicios',function(response){

            var content = "";
            var clase_tabla = "";

            response.data.forEach(pross);
            function pross(item) {

                if(item.estado == 0){
                    clase_tabla = 'table-warning';
                    estado_registro = 'INACTIVO';
                    accion = 'enableService';
                    icono = 'fa-solid fa-check';
                }else{
                    clase_tabla = 'table-default';
                    estado_registro = 'ACTIVO';
                    accion = 'deleteService';
                    icono = 'fa-solid fa-cancel';
                }

                content += '<tr class="'+clase_tabla+'">';

                content += '<td>' + item.descripcion + '</td>'
                + '<td>' + estado_registro + '</td>'
                + '<td>' + item.responsable + '</td>'
                + '<td> <a data-id="'+item.id+'" class="btn btn-primary rounded-circle mx-1 editService" style="background-color: #37474f;border-color:#37474f;font-size: 13px;"><i class="fa-solid fa-edit" style="color:white;"></i></a> <a data-id="'+item.id+'" class="btn btn-danger rounded-circle mx-1 '+accion+'" style="background-color: #37474f;border-color:#37474f;font-size: 13px;"><i class="'+icono+'" style="color:white;"></i></a> </td>';

                content += '</tr>';

            }
            $('#result').html(content);
        });
    }

</script>
