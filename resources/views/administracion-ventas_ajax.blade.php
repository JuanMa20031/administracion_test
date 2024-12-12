<script>

loadData();

// Desplegar modal creacion
$("#btn-create2").click(function() {
    $("#modalCreate2").modal("show");
});

$("#btn_buscar_fecha").click(function() {

    let movimientos_html= '';

    let value_fechas = document.getElementById("filtro_fechas_ventas").value;

    let parametros_busqueda = "";

    if(value_fechas == 1){

        let fecha_dia = document.getElementById("fecha_busqueda").value;

        if(fecha_dia == ''){
            toastr.warning("Debe seleccionar una fecha");
            return false;
        }

        parametros_busqueda = 'fechaEspecifica='+fecha_dia;

    }else{
        let fecha_inicial = new Date(document.getElementById("fecha_inicial").value);
        let fecha_final = new Date(document.getElementById("fecha_final").value);

        if (document.getElementById("fecha_inicial").value == '' || document.getElementById("fecha_final").value == '') {
            toastr.warning("Ambas fechas deben ser seleccionadas");
            return false;
        }

        if (fecha_inicial > fecha_final) {
            toastr.warning("Ingrese un rango de fecha valido");
            return false;
        }

        parametros_busqueda = 'fechaInicial='+document.getElementById("fecha_inicial").value+'&fechaFinal='+document.getElementById("fecha_final").value;
    }

    $.get('api/ventas?'+parametros_busqueda,function(response){

        response.data.movimientos.forEach(pross);

        let total_ventas = response.data.total_ventas;
        let total_movimientos = response.data.total_movimientos;

        let total_ventas_html = '<b><p class="text-success">&nbsp;&nbsp;S/'+total_ventas+'</p></b>';
        let total_movimientos_html = '<p>&nbsp;&nbsp;'+total_movimientos+'</p>';

        $('#total_ventas').html(total_ventas_html);
        $('#total_movimientos').html(total_movimientos_html);

        function pross(item) {

            let mes = '';

            if(item.meses == 1){
                mes = 'mes';
            }else{
                mes = 'meses';
            }

            let descripcion = item.celular+ ' - '+item.descripcion+' x '+item.meses+' '+mes;

            movimientos_html += '<div style="border:solid 1px gray;border-radius:5px; height:50px; margin-bottom:8px;"><p style="margin-top:10px;margin-left:5px; float: left;">'+descripcion+'</p><p style="float:right; margin-right: 5px;"><a data-id="'+item.id+'" class="btn btn-danger rounded-circle mx-1 deleteVentas" style="margin-top:8px; background-color: #37474f;border-color:#37474f;font-size: 13px;"><i class="fa-solid fa-trash" style="color:white;"></i></a></p><a data-id="'+item.id+'" class="btn btn-primary rounded-circle mx-1 editVenta" style="float: right; margin-top:8px; background-color: #37474f;border-color:#37474f;font-size: 13px;"><i class="fa-solid fa-edit" style="color:white;"></i></a><p style="float: right; margin-top:10px; margin-right:10px;"class="text-success"><b>'+'S/'+item.precio+'</p></div></b>';

        }

        $('#espacio_movimientos').html(movimientos_html);

    });
});

$.get('api/nuevas-plataformas', function (response) {

    var content = '<option value="">Seleccione</option>';
    var content2 = '';

    if (response.data && Array.isArray(response.data.plataformas)) {
        response.data.plataformas.forEach(function (item) {
            content += '<option value="'+item.descripcion+'">'+item.descripcion+'</option>';
        });
    }

    if (response.data && Array.isArray(response.data.plataformasReno)) {
        response.data.plataformasReno.forEach(function (item) {
            content2 += '<option value="'+item.descripcion+'">'+item.descripcion+'</option>';
        });
    }

    var content_full = content+content2;

    $('#plataforma1_sel').html(content_full);
    $('#plataforma2_sel').html(content_full);
    $('#plataforma3_sel').html(content_full);
    $('#plataforma4_sel').html(content_full);

    $('#plataforma1_selEdit').html(content_full);
    $('#plataforma2_selEdit').html(content_full);
    $('#plataforma3_selEdit').html(content_full);
    $('#plataforma4_selEdit').html(content_full);
});

$("#btn-env-add").click(function(e) {

    e.preventDefault();

    var plataforma1 = $('#plataforma1_sel').val();
    var plataforma2 = $('#plataforma2_sel').val();
    var plataforma3 = $('#plataforma3_sel').val();
    var plataforma4 = $('#plataforma4_sel').val();
    var meses = $('#meses').val();
    var precio = $('#precio').val();
    var celular = $('#celular').val();
    var fecha_venta = $('#fecha_venta').val();

    if(plataforma1 == '' && plataforma2 == ''){
        toastr.warning("Debe seleccionar al menos una plataforma");
        return false;
    }

    if(meses == "" || precio == "" || celular == "" || fecha_venta==""){
        toastr.warning("Complete todos los campos");
        return false;
    }

    var plataformasSeleccionadas = [];
    if (plataforma1) {
        plataformasSeleccionadas.push(plataforma1);
    }
    if (plataforma2) {
        plataformasSeleccionadas.push(plataforma2);
    }
    if (plataforma3) {
        plataformasSeleccionadas.push(plataforma3);
    }
    if (plataforma4) {
        plataformasSeleccionadas.push(plataforma4);
    }

    var descripcion = plataformasSeleccionadas.join(' + ');

    $.ajax({

        url: "api/ventas/create",
        type: "POST",
        data: {
            descripcion:descripcion,
            meses:meses,
            celular:celular,
            precio:precio,
            fecha:fecha_venta,
            plataforma1:plataforma1,
            plataforma2:plataforma2,
            plataforma3:plataforma3,
            plataforma4:plataforma4
        },
        success:function(data){

            toastr.success("Se agregó el registro correctamente");

            $("#plataforma1_sel").val("");
            $("#plataforma2_sel").val("");
            $("#plataforma3_sel").val("");
            $("#plataforma4_sel").val("");
            $("#meses").val("");
            $("#celular").val("");
            $("#precio").val("");

            $("#modalCreate2").modal("hide");

            loadData();

        },error: function (data) {

            toastr.error("Ha ocurrido un error, verifique la información");
        }
    });
});


$('body').on('click', '.editVenta', function () {

      var id = $(this).data('id');

      $.get('api/ventas/details/'+id,function(response){

            var descripcion = response.data.descripcion;
            var meses = response.data.meses;
            var celular = response.data.celular;
            var precio = response.data.precio;
            var fecha = response.data.fecha;
            var plataforma1 = response.data.plataforma1;
            var plataforma2 = response.data.plataforma2;
            var plataforma3 = response.data.plataforma3;
            var plataforma4 = response.data.plataforma4;

            var fechaFormateada = new Date(fecha).toISOString().split('T')[0];


            document.getElementById('precioEdit').value = precio;
            document.getElementById('mesesEdit').value = meses;
            document.getElementById('celularEdit').value = celular;
            document.getElementById('fecha_ventaEdit').value = fechaFormateada;
            document.getElementById('plataforma1_selEdit').value = plataforma1;
            document.getElementById('plataforma2_selEdit').value = plataforma2;
            document.getElementById('plataforma3_selEdit').value = plataforma3;
            document.getElementById('plataforma4_selEdit').value = plataforma4;

            document.getElementById('id_tr').value = id;
        });

        $("#modalEdit2").modal("show");

  });

    $( "#btn-env-edit" ).click(function(e) {

        e.preventDefault();

        var id = $('#id_tr').val();
        var meses = $('#mesesEdit').val();
        var celular = $('#celularEdit').val();
        var precio = $('#precioEdit').val();
        var fecha = $('#fecha_ventaEdit').val();
        var plataforma1 = $('#plataforma1_selEdit').val();
        var plataforma2 = $('#plataforma2_selEdit').val();
        var plataforma3 = $('#plataforma3_selEdit').val();
        var plataforma4 = $('#plataforma4_selEdit').val();

        var fechaFormateada = new Date(fecha).toISOString().split('T')[0];

        if(meses == ""){
            toastr.warning("Debe seleccionar una cantidad de meses");
            return false;
        }

        if(celular == ""){
            toastr.warning("El número de celular no puede estar vacío");
            return false;
        }

        if(fecha == ""){
            toastr.warning("Debe seleccionar una fecha");
            return false;
        }

        var plataformasSeleccionadas = [];
        if (plataforma1) {
            plataformasSeleccionadas.push(plataforma1);
        }
        if (plataforma2) {
            plataformasSeleccionadas.push(plataforma2);
        }
        if (plataforma3) {
            plataformasSeleccionadas.push(plataforma3);
        }
        if (plataforma4) {
            plataformasSeleccionadas.push(plataforma4);
        }

        var descripcion = plataformasSeleccionadas.join(' + ');

        if (descripcion === '') {
            toastr.warning("Debe seleccionar al menos una plataforma");
            return false;
        }

        $.ajax({

            url: "api/ventas/update/"+id,
            type: "POST",
            data: {
                descripcion: descripcion,
                meses: meses,
                celular: celular,
                precio: precio,
                fecha: fechaFormateada,
                plataforma1: plataforma1,
                plataforma2: plataforma2,
                plataforma3: plataforma3,
                plataforma4: plataforma4
            },
            success: function(data){

                $("#modalEdit2").modal("hide");

                $("#mesesEdit").val("");
                $("#celularEdit").val("");
                $("#precioEdit").val("");
                $("#fecha_ventaEdit").val("");
                toastr.success("Se modificó el registro correctamente");

                document.getElementById('fecha_busqueda').value = fecha;
                loadData2(fecha);



            },
            error: function (data) {

                toastr.error("Ha ocurrido un error, verifique la información");
            }
        });
    });



  $('body').on('click', '.deleteVentas', function () {

        $("#modalDelete").modal("show");

        var id = $(this).data('id');

        $.get('api/ventas/details/'+id,function(response){

            var descripcion = response.data.descripcion;
            var meses = response.data.meses;
            var celular = response.data.celular;
            var precio = response.data.precio;
            var fecha = response.data.fecha;

            var datos = '<b>Descripcion: </b> '+descripcion+
                        '<br><b>meses: </b> '+meses+
                        '<br><b>Celular: </b> '+celular+
                        '<br><b>Precio: </b> '+precio+
                        '<br><b>Fecha: </b> '+fecha;

            document.getElementById('infoDelete').innerHTML = datos;
            document.getElementById('idDelete').value = id;
        });

    });

$('#btn-env-delete').click(function(e){

    var id = document.getElementById('idDelete').value;

    var fecha = null;

    $.get('api/ventas/details/'+id,function(response){

        fecha = response.data.fecha;

    }).done(function() {

        $.ajax({

            url: "api/ventas/delete/"+id,
            type: "POST",

            success:function(data){

                $("#modalDelete").modal("hide");

                toastr.success("Se borró el registro correctamente");

                // Llamar a loadData2 aquí para asegurarse de que la variable fecha tenga un valor antes de ser utilizada
                loadData2(fecha);

            },error: function (data) {

                toastr.error("Ha ocurrido un error");
            }
        });
    });
});


function loadData() {

    document.getElementById("filtro_fechas_ventas").value = 1;

    let fechas_dia = document.getElementById('rango_fechas_dia');
    let fechas_rango = document.getElementById('rango_fechas_form');

    fechas_rango.classList.add('rango_fechas_class');
    fechas_dia.style.display = 'block';

    document.getElementById("fecha_busqueda").value = document.getElementById("fecha_venta").value;

    let movimientos_html= '';

    let fechaFormateada = document.getElementById("fecha_busqueda").value;

    $.get('api/ventas?fechaEspecifica='+fechaFormateada,function(response){

        response.data.movimientos.forEach(pross);

        let total_ventas = response.data.total_ventas;
        let total_movimientos = response.data.total_movimientos;

        let total_ventas_html = '<b><p class="text-success">&nbsp;&nbsp;S/'+total_ventas+'</p></b>';
        let total_movimientos_html = '<p>&nbsp;&nbsp;'+total_movimientos+'</p>';

        $('#total_ventas').html(total_ventas_html);
        $('#total_movimientos').html(total_movimientos_html);

        function pross(item) {

            let mes = '';

            if(item.meses == 1){
                mes = 'mes';
            }else{
                mes = 'meses';
            }

            let descripcion = item.celular+ ' - '+item.descripcion+' x '+item.meses+' '+mes;

            movimientos_html += '<div style="border:solid 1px gray;border-radius:5px; height:50px; margin-bottom:8px;"><p style="margin-top:10px;margin-left:5px; float: left;">'+descripcion+'</p><p style="float:right; margin-right: 5px;"><a data-id="'+item.id+'" class="btn btn-danger rounded-circle mx-1 deleteVentas" style="margin-top:8px; background-color: #37474f;border-color:#37474f;font-size: 13px;"><i class="fa-solid fa-trash" style="color:white;"></i></a></p><a data-id="'+item.id+'" class="btn btn-primary rounded-circle mx-1 editVenta" style="float: right; margin-top:8px; background-color: #37474f;border-color:#37474f;font-size: 13px;"><i class="fa-solid fa-edit" style="color:white;"></i></a><p style="float: right; margin-top:10px; margin-right:10px;"class="text-success"><b>'+'S/'+item.precio+'</p></div></b>';
        }

        $('#espacio_movimientos').html(movimientos_html);

    });
}

function loadData2(fecha){

    let movimientos_html= '';

    let fechaFormateada = fecha;

    $.get('api/ventas?fechaEspecifica='+fechaFormateada,function(response){

        response.data.movimientos.forEach(pross);

        let total_ventas = response.data.total_ventas;
        let total_movimientos = response.data.total_movimientos;

        let total_ventas_html = '<b><p class="text-success">&nbsp;&nbsp;S/'+total_ventas+'</p></b>';
        let total_movimientos_html = '<p>&nbsp;&nbsp;'+total_movimientos+'</p>';

        $('#total_ventas').html(total_ventas_html);
        $('#total_movimientos').html(total_movimientos_html);

        function pross(item) {

            let mes = '';

            if(item.meses == 1){
                mes = 'mes';
            }else{
                mes = 'meses';
            }

            let descripcion = item.celular+ ' - '+item.descripcion+' x '+item.meses+' '+mes;

            movimientos_html += '<div style="border:solid 1px gray;border-radius:5px; height:50px; margin-bottom:8px;"><p style="margin-top:10px;margin-left:5px; float: left;">'+descripcion+'</p><p style="float:right; margin-right: 5px;"><a data-id="'+item.id+'" class="btn btn-danger rounded-circle mx-1 deleteVentas" style="margin-top:8px; background-color: #37474f;border-color:#37474f;font-size: 13px;"><i class="fa-solid fa-trash" style="color:white;"></i></a></p><a data-id="'+item.id+'" class="btn btn-primary rounded-circle mx-1 editVenta" style="float: right; margin-top:8px; background-color: #37474f;border-color:#37474f;font-size: 13px;"><i class="fa-solid fa-edit" style="color:white;"></i></a><p style="float: right; margin-top:10px; margin-right:10px;"class="text-success"><b>'+'S/'+item.precio+'</p></div></b>';
        }

        $('#espacio_movimientos').html(movimientos_html);

        });
}

</script>
