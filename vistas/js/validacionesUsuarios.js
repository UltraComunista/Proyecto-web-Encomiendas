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

    // Validar cédula para que solo contenga números
    $("input[name='nuevoCedula'], input[name='editarCedula']").on("input", function () {
        var valor = $(this).val();
        if (/[^0-9]/.test(valor)) {
            toastr.error('La cédula solo puede contener números.', 'Error');
            $(this).val(valor.replace(/[^0-9]/g, ''));
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

    // Validar antes de enviar el formulario de creación de usuario
    $("#addContactModalTitle").on("submit", function (e) {
        var nombre = $("input[name='nuevoNombre']").val();
        var apellido = $("input[name='nuevoApellido']").val();
        var cedula = $("input[name='nuevoCedula']").val();

        if (nombre === "" || /[^a-zA-ZñÑáéíóúÁÉÍÓÚ\s]/.test(nombre)) {
            toastr.error('El nombre no puede estar vacío ni contener caracteres especiales.', 'Error');
            e.preventDefault();
            return false;
        }

        if (apellido === "" || /[^a-zA-ZñÑáéíóúÁÉÍÓÚ\s]/.test(apellido)) {
            toastr.error('El apellido no puede contener caracteres especiales.', 'Error');
            e.preventDefault();
            return false;
        }

        if (cedula === "" || /[^0-9]/.test(cedula)) {
            toastr.error('La cédula solo puede contener números.', 'Error');
            e.preventDefault();
            return false;
        }
    });

    // Validar antes de enviar el formulario de edición de usuario
    $("#editContactModalTitle").on("submit", function (e) {
        var nombre = $("input[name='editarNombre']").val();
        var apellido = $("input[name='editarApellido']").val();
        var cedula = $("input[name='editarCedula']").val();

        if (nombre === "" || /[^a-zA-ZñÑáéíóúÁÉÍÓÚ\s]/.test(nombre)) {
            toastr.error('El nombre no puede estar vacío ni contener caracteres especiales.', 'Error');
            e.preventDefault();
            return false;
        }

        if (apellido === "" || /[^a-zA-ZñÑáéíóúÁÉÍÓÚ\s]/.test(apellido)) {
            toastr.error('El apellido no puede contener caracteres especiales.', 'Error');
            e.preventDefault();
            return false;
        }

        if (cedula === "" || /[^0-9]/.test(cedula)) {
            toastr.error('La cédula solo puede contener números.', 'Error');
            e.preventDefault();
            return false;
        }
    });
});
