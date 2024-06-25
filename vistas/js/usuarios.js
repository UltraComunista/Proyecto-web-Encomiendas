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

    // Manejar la edición de usuarios
    $(".tablas").on("click", ".btnEditarUsuario", function () {
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
                $("#editarNombre").val(respuesta["nombre"]);
                $("#editarApellido").val(respuesta["apellido"]);
                $("#editarCedula").val(respuesta["cedula"]);
                $("#editarUsuario").val(respuesta["usuario"]);
                $("#editarPerfil").val(respuesta["perfil"]);
                $("#editarSucursal").val(respuesta["sucursal"]);
                $("#fotoActual").val(respuesta["foto"]);
                $("#passwordActual").val(respuesta["password"]); // Añadir este campo oculto para la contraseña actual
                if (respuesta["foto"] != "") {
                    $(".previsualizar").attr("src", respuesta["foto"]);
                }
            }
        });
    });

    // Manejar la eliminación de usuarios
    $(".tablas").on("click", ".btnEliminarUsuario", function () {
        var idUsuario = $(this).attr("idUsuario");
        Swal.fire({
            title: "¿Estás seguro de eliminar este usuario?",
            text: "¡No puedes deshacer esta acción!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Sí, eliminar",
            cancelButtonText: "Cancelar",
        }).then((result) => {
            if (result.value) {
                window.location = "index.php?ruta=usuarios&idUsuario=" + idUsuario;
            }
        });s
    });

    // Manejar la generación de reportes
    $("#btn-reportes").on("click", function () {
        window.open("extensiones/tcpdf/pdf/reporteusuario.php", "_blank");
    });



});
