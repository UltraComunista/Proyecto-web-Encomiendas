$(".tablas").on("click", ".btnEditarUsuario", function () {
    console.log($("#idUsuario").val());

    var idUsuario = $(this).attr("idUsuario");
    var datos = new FormData();
    datos.append("idUsuario", idUsuario);

    $.ajax({
        url: "ajax/usuarios.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function (respuesta) {
            $("#idUsuario").val(respuesta["id"]);  // Aquí aseguramos que se llene el campo oculto con el ID
            $("#editarNombre").val(respuesta["nombre"]);
            $("#editarApellido").val(respuesta["apellido"]);
            $("#editarCedula").val(respuesta["cedula"]);
            $("#editarDireccion").val(respuesta["direccion"]); // Cargar dirección
            $("#editarTelefono").val(respuesta["telefono"]);   // Cargar teléfono
            $("#editarUsuario").val(respuesta["usuario"]);
            $("#editarPerfil").val(respuesta["perfil"]);
            $("#fotoActual").val(respuesta["foto"]);
            $("#passwordActual").val(respuesta["password"]);

            if (respuesta["foto"] != "") {
                $("#previsualizar").attr("src", respuesta["foto"]);
            }

            if (respuesta["perfil"] == 5) {
                $("#editarApellidoContainer").hide();
                $("#editarApellido").prop('required', false);
                $("#editarToken").val(respuesta["token"]);
            } else {
                $("#editarApellidoContainer").show();
                $("#editarApellido").prop('required', true);
                $("#editarToken").val("");
            }
        }
    });
});

$(document).ready(function () {
    // Función para manejar el cambio del perfil
    function manejarCambioDePerfil() {
        var perfilSeleccionado = $('select[name="nuevoPerfil"]').val();

        if (perfilSeleccionado == "5") {
            // Si el perfil es "Empresa", oculta el campo de apellido
            $('#apellidoContainer').hide();
            $('input[name="nuevoApellido"]').prop('required', false); // Elimina el requisito de ser obligatorio
        } else {
            // Si no es "Empresa", muestra el campo de apellido
            $('#apellidoContainer').show();
            $('input[name="nuevoApellido"]').prop('required', true); // Establece el requisito de ser obligatorio
        }
    }

    // Ejecutar la función al cargar la página para manejar el estado inicial
    manejarCambioDePerfil();

    // Ejecutar la función cada vez que se cambie el perfil
    $('select[name="nuevoPerfil"]').change(manejarCambioDePerfil);
});


$(document).ready(function () {
    $('#tablaUsuarios').DataTable({
        responsive: true,
        language: {
            search: "Buscar Usuario:",
            lengthMenu: "Mostrar _MENU_ registros por página",
            zeroRecords: "No se encontraron resultados",
            info: "Mostrando página _PAGE_ de _PAGES_",
            infoEmpty: "No hay registros disponibles",
            infoFiltered: "(filtrado de _MAX_ registros en total)",
            paginate: {
                first: "Primero",
                last: "Último",
                next: "Siguiente",
                previous: "Anterior"
            }
        }
    });

    // Generar automáticamente el nombre de usuario y contraseña
    $("#addContactModalTitle input[name='nuevoNombre'], #addContactModalTitle input[name='nuevoApellido'], #addContactModalTitle input[name='nuevoCedula']").on("input", function () {
        var nombre = $("input[name='nuevoNombre']").val().trim();
        var apellido = $("input[name='nuevoApellido']").val().trim();
        var cedula = $("input[name='nuevoCedula']").val().trim();

        if (nombre && apellido) {
            var usuario = nombre.charAt(0).toLowerCase() + apellido.toLowerCase();
            $("input[name='nuevoUsuario']").val(usuario);
        }

        if (cedula) {
            $("input[name='nuevoPassword']").val(cedula);
        }
    });

    // Resetear usuario y contraseña en la edición
    $("#resetUsuarioPassword").on("click", function () {
        var nombre = $("#editarNombre").val().trim();
        var apellido = $("#editarApellido").val().trim();
        var cedula = $("#editarCedula").val().trim();

        if (nombre && apellido) {
            var usuario = nombre.charAt(0).toLowerCase() + apellido.toLowerCase();
            $("#editarUsuario").val(usuario);
        }

        if (cedula) {
            $("#editarPassword").val(cedula);
        }
    });








    // Manejar la generación de reportes
    $("#btn-reportes").on("click", function () {
        window.open("extensiones/tcpdf/pdf/reporteusuario.php", "_blank");
    });



});
