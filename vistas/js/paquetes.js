$(document).ready(function () {
    $('input[name="cedula_enviador"]').on('blur', function () {
        var cedula = $(this).val();
        if (cedula) {
            $.ajax({
                type: 'POST',
                url: 'ajax/ajaxClientes.php',
                data: { cedula: cedula, tipo: 'remitente' },
                success: function (response) {
                    var cliente = JSON.parse(response);
                    if (cliente) {
                        $('input[name="nombre_enviador"]').val(cliente.nombre);
                        $('input[name="telefono_enviador"]').val(cliente.telefono);
                        $('input[name="direccion_enviador"]').val(cliente.direccion);
                    }
                }
            });
        }
    });

    $('input[name="cedula_remitente"]').on('blur', function () {
        var cedula = $(this).val();
        if (cedula) {
            $.ajax({
                type: 'POST',
                url: 'ajax/ajaxClientes.php',
                data: { cedula: cedula, tipo: 'destinatario' },
                success: function (response) {
                    var cliente = JSON.parse(response);
                    if (cliente) {
                        $('input[name="nombre_remitente"]').val(cliente.nombre);
                        $('input[name="telefono_remitente"]').val(cliente.telefono);
                        $('input[name="direccion_remitente"]').val(cliente.direccion);
                    }
                }
            });
        }
    });
});


$(document).ready(function () {
    function updateProvinces(selectorProvincias, provincias) {
        $(selectorProvincias).html('<option value="">Seleccionar Provincia</option>');
        provincias.forEach(function (provincia) {
            $(selectorProvincias).append('<option value="' + provincia.provincia + '">' + provincia.provincia + '</option>');
        });
    }

    function updateSucursales(selectorSucursales, sucursales) {
        $(selectorSucursales).html('<option value="">Seleccionar Sucursal</option>');
        sucursales.forEach(function (sucursal) {
            $(selectorSucursales).append('<option value="' + sucursal.id + '">' + sucursal.nombre + '</option>');
        });
    }

    $('#departamentoPartida').on('change', function () {
        var departamento = $(this).val();
        if (departamento) {
            $.ajax({
                type: 'POST',
                url: 'ajax/ajaxSucursales.php?action=obtenerProvincias',
                data: { departamento: departamento },
                success: function (response) {
                    var provincias = JSON.parse(response);
                    updateProvinces('#provinciaPartida', provincias);
                    $('#sucursalPartida').html('<option value="">Seleccionar Sucursal</option>'); // Reset sucursal dropdown
                }
            });
        } else {
            $('#provinciaPartida').html('<option value="">Seleccionar Provincia</option>');
            $('#sucursalPartida').html('<option value="">Seleccionar Sucursal</option>');
        }
    });

    $('#provinciaPartida').on('change', function () {
        var provincia = $(this).val();
        var departamento = $('#departamentoPartida').val();
        if (provincia) {
            $.ajax({
                type: 'POST',
                url: 'ajax/ajaxSucursales.php?action=obtenerSucursales',
                data: { departamento: departamento, provincia: provincia },
                success: function (response) {
                    var sucursales = JSON.parse(response);
                    updateSucursales('#sucursalPartida', sucursales);
                }
            });
        } else {
            $('#sucursalPartida').html('<option value="">Seleccionar Sucursal</option>');
        }
    });

    $('#departamentoLlegada').on('change', function () {
        var departamento = $(this).val();
        var departamentoPartida = $('#departamentoPartida').val();
        var provinciaPartida = $('#provinciaPartida').val();
        var sucursalPartida = $('#sucursalPartida').val();
        var tipoEnvio = $('#tipoEnvio').val();

        if (departamento) {
            $.ajax({
                type: 'POST',
                url: 'ajax/ajaxSucursales.php?action=obtenerProvincias',
                data: { departamento: departamento },
                success: function (response) {
                    var provincias = JSON.parse(response);
                    if (tipoEnvio === 'Normal') {
                        var filteredProvincias = provincias.filter(function (provincia) {
                            return !(departamento === departamentoPartida && provincia.provincia === provinciaPartida);
                        });
                        updateProvinces('#provinciaLlegada', filteredProvincias);
                    } else {
                        updateProvinces('#provinciaLlegada', provincias);
                    }
                    $('#sucursalLlegada').html('<option value="">Seleccionar Sucursal</option>'); // Reset sucursal dropdown
                }
            });
        } else {
            $('#provinciaLlegada').html('<option value="">Seleccionar Provincia</option>');
            $('#sucursalLlegada').html('<option value="">Seleccionar Sucursal</option>');
        }
    });

    $('#provinciaLlegada').on('change', function () {
        var provincia = $(this).val();
        var departamento = $('#departamentoLlegada').val();
        var provinciaPartida = $('#provinciaPartida').val();
        var sucursalPartida = $('#sucursalPartida').val();
        var tipoEnvio = $('#tipoEnvio').val();

        if (provincia) {
            $.ajax({
                type: 'POST',
                url: 'ajax/ajaxSucursales.php?action=obtenerSucursales',
                data: { departamento: departamento, provincia: provincia },
                success: function (response) {
                    var sucursales = JSON.parse(response);
                    if (tipoEnvio === 'Normal') {
                        var filteredSucursales = sucursales.filter(function (sucursal) {
                            return !(provincia === provinciaPartida && sucursal.id == sucursalPartida);
                        });
                        updateSucursales('#sucursalLlegada', filteredSucursales);
                    } else {
                        updateSucursales('#sucursalLlegada', sucursales);
                    }
                }
            });
        } else {
            $('#sucursalLlegada').html('<option value="">Seleccionar Sucursal</option>');
        }
    });

    $('#tipoEnvio').on('change', function () {
        var tipoEnvio = $(this).val();
        if (tipoEnvio === 'Domiciliario') {
            $('#direccionDiv').show();
        } else {
            $('#direccionDiv').hide();
        }

        // Reset the destination fields when changing the type of delivery
        $('#departamentoLlegada').val('');
        $('#provinciaLlegada').html('<option value="">Seleccionar Provincia</option>');
        $('#sucursalLlegada').html('<option value="">Seleccionar Sucursal</option>');
    });

    // Asegurarse de que el tipo de envío sea "Normal" por defecto y la dirección esté oculta
    $('#tipoEnvio').val('Normal');
    $('#direccionDiv').hide();
});







$(document).ready(function () {
    $('#tablap').DataTable({
        responsive: true,
        language: {
            search: "Buscar:",
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
});




