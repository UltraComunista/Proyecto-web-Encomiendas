$(document).ready(function() {
    // Editar Cliente
    $(".tablas").on("click", ".btnEditarCliente", function() {
        var idCliente = $(this).attr("idCliente");
        var datos = new FormData();
        datos.append("idCliente", idCliente);

        $.ajax({
            url: "ajax/cliente.ajax.php",
            method: "POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function(respuesta) {
                console.log(respuesta);

                if (respuesta) {
                    $("#editarCedula").val(respuesta["cedula"]);
                    $("#editarNombre").val(respuesta["nombre"]);
                    $("#editarDireccion").val(respuesta["direccion"]);
                    $("#editarTelefono").val(respuesta["telefono"]);
                    $("#idCliente").val(respuesta["id"]);
                } else {
                    console.log("Error: No se recibieron datos válidos.");
                }
            },
            error: function(xhr, status, error) {
                console.error("Error en la solicitud AJAX: ", error);
            }
        });
    });
});
