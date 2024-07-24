$(document).ready(function () {
    // Validar nombre para que no contenga números ni espacios vacíos
    $("input[name='nuevoNombre'], input[name='editarNombre']").on("input", function () {
        var valor = $(this).val();
        if (/[^a-zA-ZñÑáéíóúÁÉÍÓÚ\s]/.test(valor)) {
            toastr.error('El nombre no puede contener números o caracteres especiales.', 'Error');
            $(this).val(valor.replace(/[^a-zA-ZñÑáéíóúÁÉÍÓÚ\s]/g, ''));
        }

    });

    // Validar apellido para que no contenga números
    $("input[name='nuevoApellido'], input[name='editarApellido']").on("input", function () {
        var valor = $(this).val();
        if (/[^a-zA-ZñÑáéíóúÁÉÍÓÚ\s]/.test(valor)) {
            toastr.error('El apellido no puede contener números o caracteres especiales.', 'Error');
            $(this).val(valor.replace(/[^a-zA-ZñÑáéíóúÁÉÍÓÚ\s]/g, ''));
        }
    });


    // Validar usuario existente
    $("input[name='nuevoUsuario'], input[name='editarUsuario']").on("input", function () {
        var usuario = $(this).val();
        var input = $(this);
        var datos = new FormData();
        datos.append("validarUsuario", usuario);

        $.ajax({
            url: "ajax/validacionesUsuarios.ajax.php",
            method: "POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function (respuesta) {
                if (respuesta) {
                    toastr.error('El nombre de usuario ya existe.', 'Error');
                    input.val('');
                }
            }
        });
    });

});
