$(document).ready(function() {
    // Validar formulario de creación de sucursal
    $("#agregarsucursal").on("submit", function(event) {
        event.preventDefault();

        var nombre = $("input[name='nuevoNombre']").val();
        var telefono = $("input[name='nuevoTelefono']").val();

        // Validar que el teléfono solo contenga números
        if (!/^\d+$/.test(telefono)) {
            toastr.error('El teléfono solo debe contener números.', 'Error');
            return;
        }

        // Verificar si el nombre ya existe
        $.ajax({
            url: "ajax/validaciones.ajax.php",
            method: "POST",
            data: { nombre: nombre },
            dataType: "json",
            success: function(respuesta) {
                if (respuesta.exists) {
                    toastr.error(respuesta.message, 'Error');
                } else {
                    $("#agregarsucursal")[0].submit();
                }
            }
        });
    });

    // Validar formulario de edición de sucursal
    $("#editarsucursal").on("submit", function(event) {
        event.preventDefault();

        var idSucursal = $("#idSucursal").val();
        var nombre = $("#editarNombre").val();
        var telefono = $("#editarTelefono").val();

        // Validar que el teléfono solo contenga números
        if (!/^\d+$/.test(telefono)) {
            toastr.error('El teléfono solo debe contener números.', 'Error');
            return;
        }

        // Verificar si el nombre ya existe
        $.ajax({
            url: "ajax/validaciones.ajax.php",
            method: "POST",
            data: { idSucursal: idSucursal, nombre: nombre },
            dataType: "json",
            success: function(respuesta) {
                if (respuesta.exists && respuesta.id != idSucursal) {
                    toastr.error(respuesta.message, 'Error');
                } else {
                    $("#editarsucursal")[0].submit();
                }
            }
        });
    });
});
