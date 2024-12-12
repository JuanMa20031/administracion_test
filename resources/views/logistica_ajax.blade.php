<script>

    loadData();

    // Desplegar modal creacion
    $("#btn-create").click(function() {

        $("#modalCreate").modal("show");
    });

    // Desplegar modal edicion y cargar informacion del registro
    $('body').on('click', '.editLogistica', function () {

        var id = $(this).data('id');

        $.get('api/logistica/details/'+id,function(response){

            var nombre = response.data.nombre;
            var pantallas = response.data.pantallas;
            var plataforma = response.data.plataforma;
            var celular = response.data.celular;
            var dias = response.data.dias;
            var fecha_inicio = response.data.fecha_inicio;
            var fecha_corte = response.data.fecha_corte;
            var fecha_vencimiento = response.data.fecha_vencimiento;
            var servicio_id = response.data.servicio_id;
            var servicios = "";
            var servicios_arr = [];

            for (let clave in response.servicios){

                if(clave == servicio_id){
                    servicios += '<option value="'+clave+'" selected>'+response.servicios[clave]+'</option>';
                }else{
                    servicios += '<option value="'+clave+'">'+response.servicios[clave]+'</option>';
                }
            }

            for (let clave in response.servicios){
                servicios_arr[clave] = response.servicios[clave];
            }

            document.getElementById('nombreEdit').value = nombre;
            document.getElementById('pantallasEdit').value = pantallas;
            document.getElementById('celularEdit').value = celular;
            document.getElementById('diasEdit').value = dias;
            document.getElementById('fecha_inicioEdit').value = fecha_inicio;
            document.getElementById('fecha_corteEdit').value = fecha_corte;

            $('#servicio_idEdit2').html(servicios);

            document.getElementById('id_tr').value = id;
        });

        $("#modalEdit").modal("show");

    });

    // Desplegar modal para eliminar y cargar informacion del registro
    $('body').on('click', '.deleteLogistica', function () {

        $("#modalDelete").modal("show");

        var id = $(this).data('id');

        $.get('api/logistica/details/'+id,function(response){
            console.log(response);
            var nombre = response.data.nombre;
            var pantallas = response.data.pantallas;
            var plataforma = response.servicios[response.data.servicio_id];
            var celular = response.data.celular;
            var dias = response.data.dias;
            var fecha_inicio = response.data.fecha_inicio;

            var datos = '<b>Nombre: </b> '+nombre+
                        '<br><b>Plataforma: </b> '+plataforma+
                        '<br><b>Pantallas: </b> '+pantallas+
                        '<br><b>Celular: </b> '+celular+
                        '<br><b>Días: </b> '+dias+
                        '<br><b>Fecha inicio: </b> '+fecha_inicio;

            document.getElementById('infoDelete').innerHTML = datos;
            document.getElementById('idDelete').value = id;
        });

    });

    $('body').on('click', '.editAvisos', function () {
    $("#modalAvisos").modal("show");

    var id = $(this).data('id');

    $.get('api/logistica/details/'+id, function(response) {
        var primer_aviso = response.data.primer_aviso;
        var segundo_aviso = response.data.segundo_aviso;
        var corte_definitivo = response.data.corte_definitivo;

        var formulario = '<form id="form-avisos">@csrf';

        formulario += '<div class="row"><div class="col-lg-4"><input type="checkbox" name="primer_aviso" id="primer_aviso" class="form-control" value="'+primer_aviso+'"><center><br>Primer aviso</center></div>';
        formulario += '<div class="col-lg-4"><input type="checkbox" name="segundo_aviso" id="segundo_aviso" class="form-control" value="'+segundo_aviso+'"><center><br>Segundo aviso</center></div>';
        formulario += '<div class="col-lg-4"><input type="checkbox" name="corte_definitivo" id="corte_definitivo" class="form-control" value="'+corte_definitivo+'"><center><br>Corte definitivo</center></div></div>';

        formulario += '</form>';

        $('#avisos').html(formulario);
        document.getElementById('idAvisosF').value = id;

        if(primer_aviso != null){
            $('#primer_aviso').prop('checked', true);
        }

        if(segundo_aviso != null){
            $('#segundo_aviso').prop('checked', true);
        }

        if(corte_definitivo != null){
            $('#corte_definitivo').prop('checked', true);
        }
    });
});

    // AJAX para borrar el registro
    $('#btn-env-delete').click(function(e){

        var id = document.getElementById('idDelete').value;

        $.ajax({

            url: "api/logistica/delete/"+id,
            type: "POST",

            success:function(data){

                $("#modalDelete").modal("hide");

                toastr.success("Se borró el registro correctamente");

                loadData();

            },error: function (data) {

                toastr.error("Ha ocurrido un error");
            }
        });
    });

    // AJAX para crear el registro
    $( "#btn-env-create" ).click(function(e) {

        e.preventDefault();

        var nombre       = $('#nombre').val();
        var servicio_id  = $('#servicio_idEdit').val();
        var celular      = $('#celular').val();
        var pantallas    = $('#pantallas').val();
        var dias         = $('#dias').val();
        var fecha_inicio = $('#fecha_inicio').val();
        var responsable  = $('#responsable').val();
        var decision = 0;
        var fecha_corte = '0';

        if(nombre == ""){
            toastr.warning("El nombre no puede estar vacío");
            return false;
        }

        if(servicio_id == "" || servicio_id == null){
            toastr.warning("Debe seleccionar una plataforma");
            return false;
        }

        if(pantallas == ""){
            toastr.warning("El número de pantallas no puede estar vacío");
            return false;
        }

        if(dias == ""){
            toastr.warning("El número de dias no puede estar vacío");
            return false;
        }

        if(fecha_inicio == ""){
            toastr.warning("Debe seleccionar una fecha de inicio");
            return false;
        }

        $.ajax({

            url: "api/logistica/create",
            type: "POST",
            data: {
                nombre:nombre,
                servicio_id:servicio_id,
                celular:celular,
                pantallas:pantallas,
                dias:dias,
                fecha_inicio:fecha_inicio,
                decision:decision,
                fecha_corte:fecha_corte,
                responsable:responsable,
            },
            success:function(data){

                $("#modalCreate").modal("hide");

                $("#nombre").val("");
                $("#pantallas").val("");
                $("#celular").val("");
                $("#dias").val("");
                $("#fecha_inicio").val("");

                toastr.success("Se agregó el registro correctamente");

                loadData();

            },error: function (data) {

                toastr.error("Ha ocurrido un error, verifique la información");
            }
        });
    });

    $( "#btn-env-avisos" ).click(function(e) {

        var primer_aviso = null;
        var segundo_aviso = null;
        var corte_definitivo = null;

        var checkbox1 = document.getElementById("primer_aviso");
        if (checkbox1.checked) {
            primer_aviso = 1;
        }

        var checkbox2 = document.getElementById("segundo_aviso");
        if (checkbox2.checked) {
            segundo_aviso = 1;
        }

        var checkbox3 = document.getElementById("corte_definitivo");
        if (checkbox3.checked) {
            corte_definitivo = 1;
        }

        var id = document.getElementById("idAvisosF").value;

        $.ajax({

            url: "api/logistica/updateAdvice/"+id,
            type: "POST",
            data: {
                primer_aviso:primer_aviso,
                segundo_aviso:segundo_aviso,
                corte_definitivo:corte_definitivo,
            },
            success:function(data){

                $("#modalAvisos").modal("hide");

                toastr.success("Se modificó el registro correctamente");

                loadData();

            },error: function (data) {

                toastr.error("Ha ocurrido un error, verifique la información");
            }
        });

    });

    $( "#btn-env-edit" ).click(function(e) {

        e.preventDefault();

        var id = $('#id_tr').val();
        var servicio_id = $('#servicio_idEdit2').val();
        var nombre = $('#nombreEdit').val();
        var pantallas = $('#pantallasEdit').val();
        var celular = $('#celularEdit').val();
        var dias = $('#diasEdit').val();
        var fecha_inicio = $('#fecha_inicioEdit').val();
        var fecha_corte = $('#fecha_corteEdit').val();
        var celular = $('#celularEdit').val();
        var responsable = $('#responsableEdit').val();

        if(nombre == ""){
            toastr.warning("El nombre no puede estar vacío");
            return false;
        }

        if(servicio_id == ""){
            toastr.warning("Debe seleccionar un servicio");
            return false;
        }

        if(pantallas == ""){
            toastr.warning("El número de pantallas no puede estar vacío");
            return false;
        }

        if(dias == ""){
            toastr.warning("El número de dias no puede estar vacío");
            return false;
        }

        if(fecha_inicio == ""){
            toastr.warning("Debe seleccionar una fecha de inicio");
            return false;
        }

        $.ajax({

            url: "api/logistica/update/"+id,
            type: "POST",
            data: {
                nombre:nombre,
                servicio_id:servicio_id,
                celular:celular,
                pantallas:pantallas,
                dias:dias,
                fecha_inicio:fecha_inicio,
                fecha_corte:fecha_corte,
                responsable:responsable,
            },
            success:function(data){

                $("#modalEdit").modal("hide");

                $("#nombre").val("");
                $("#pantallas").val("");
                $("#celular").val("");
                $("#dias").val("");
                $("#fecha_inicio").val("");
                $("#fecha_corteEdit").val("");

                toastr.success("Se modificó el registro correctamente");

                loadData();

            },error: function (data) {

                toastr.error("Ha ocurrido un error, verifique la información");
            }
        });
    });

    // Funcion que carga todos los registros
    function loadData() {

        var fecha_inicio_filtro = $("#fecha_inicio_filtro").val();
        var fecha_venc_filtro = $("#fecha_venc_filtro").val();
        var decision = $("#decision_filtro").val();
        var servicio = $("#servicios_filtros").val();

        var filtros = 'fecha_inicio_filtro='+fecha_inicio_filtro+'&fecha_venc_filtro='+fecha_venc_filtro+
                    '&decision_filtro='+decision+'&servicios_filtros='+servicio;

        $.get('api/logistica?'+filtros,function(response){

            var content = "";
            var clase_tabla = "";
            var servicios = "";
            var servicios_arr = [];
            var decision = "";
            var corte = "";

            for (let clave in response.servicios_filtrados){
                servicios += '<option value="'+clave+'">'+response.servicios_filtrados[clave]+'</option>';
            }

            for (let clave in response.servicios){
                servicios_arr[clave] = response.servicios[clave];
            }

            servicios_filtros = '<option value="999999" selected>TODAS</option>'+servicios;

            $('#servicio_id').html(servicios);
            $('#servicio_idEdit').html(servicios);
            $('#servicios_filtros').html(servicios_filtros);

            response.data.forEach(pross);
            function pross(item) {

                if(item.decision == 0){
                    decision = "ACTIVO";
                    corte = "";
                    clase_tabla = 'table-default';
                }else{
                    decision = "CORTE";
                    corte = item.fecha_corte;
                    clase_tabla = 'table-warning';
                }

                if(corte == null || corte == 'null' || corte == 0){
                    corte = "";
                }

                if(calcularDiasRestantes(item.fecha_vencimiento) < 1  && calcularDiasRestantes(item.fecha_vencimiento) >= -20){
                    clase_tabla = 'table-danger';
                }

                if(item.corte_definitivo == 1){
                    clase_tabla = 'bg-warning';
                }

                if(calcularDiasRestantes(item.fecha_vencimiento) <= -20 && item.decision == 0){
                    clase_tabla = 'table-warning';
                    decision = 'CORTE';

                    $.post('api/logistica/cambiarCorte/'+item.id,function(response){
                    });

                }

                if(item.estado != 0){

                    content += '<tr class="'+clase_tabla+'">';

                        content += '<td>' + item.nombre + '</td>'
                        + '<td>' + item.pantallas + '</td>'
                        + '<td>' + servicios_arr[item.servicio_id] + '</td>'
                        + '<td>' + item.celular + '</td>'
                        + '<td>' + item.dias + '</td>'
                        + '<td>' + item.fecha_inicio + '</td>'
                        + '<td>' + item.fecha_vencimiento + '</td>'
                        + '<td>' + calcularDiasRestantes(item.fecha_vencimiento) + '</td>'
                        + '<td>' + decision + '</td>'
                        + '<td>' + corte + '</td>'
                        + '<td>' + item.responsable + '</td>'
                        + '<td> <a data-id="'+item.id+'" class="btn btn-primary rounded-circle mx-1 editLogistica" style="background-color: #37474f;border-color:#37474f;font-size: 13px;"><i class="fa-solid fa-edit" style="color:white;"></i></a><a data-id="'+item.id+'" class="btn btn-danger rounded-circle mx-1 deleteLogistica" style="background-color: #37474f;border-color:#37474f;font-size: 13px;"><i class="fa-solid fa-trash" style="color:white;"></i></a><a data-id="'+item.id+'" class="btn btn-danger rounded-circle mx-1 editAvisos" style="background-color: #37474f;border-color:#37474f;font-size: 13px;"><i class="fa-solid fa-warning" style="color:white;"></i></a></td>';

                    content += '</tr>';
                }

            }
            $('#result').html(content);
        });
    }

    function calcularDiasRestantes(fecha_vencimiento){

        var fechaVencimiento = new Date(fecha_vencimiento);
        var fechaActual = new Date();
        var diasFaltantes = Math.floor((fechaVencimiento - fechaActual) / (1000 * 60 * 60 * 24));

        return diasFaltantes;
    }

    </script>
