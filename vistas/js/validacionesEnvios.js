$(document).ready(function() {
    // Validar campos de texto
    function validarCampoTexto(campo) {
        return /^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/.test(campo);
    }

    // Validar campos de números
    function validarCampoNumero(campo) {
        return /^[0-9]+$/.test(campo);
    }

    // Validar cedula
    $("#cedula_enviador, #cedula_remitente").on("input", function() {
        if (!validarCampoNumero($(this).val())) {
            toastr.error('La cédula solo debe contener números.', 'Error');
            $(this).val('');
        }
    });

    // Validar nombre
    $("#nombre_enviador, #nombre_remitente").on("input", function() {
        if (!validarCampoTexto($(this).val())) {
            toastr.error('El nombre solo debe contener letras y espacios.', 'Error');
            $(this).val('');
        }
    });

    // Validar teléfono
    $("#telefono_enviador, #telefono_remitente").on("input", function() {
        if (!validarCampoNumero($(this).val())) {
            toastr.error('El teléfono solo debe contener números.', 'Error');
            $(this).val('');
        }
    });
    
    // Validar cantidad
    $("input[name='cantidad']").on("input", function() {
        if (!validarCampoNumero($(this).val())) {
            toastr.error('La cantidad solo debe contener números.', 'Error');
            $(this).val('');
        }
    });

    // Validar precio
    $("input[name='precio']").on("input", function() {
        if (!validarCampoNumero($(this).val())) {
            toastr.error('El precio solo debe contener números.', 'Error');
            $(this).val('');
        }
    });
});
