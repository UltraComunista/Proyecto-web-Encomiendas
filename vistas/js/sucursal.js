$(document).ready(function () {
    var provincias = {
        1: ['Andrés Ibáñez', 'Ichilo', 'Sara', 'Cordillera', 'Germán Busch'],
        2: ['Murillo', 'Los Andes', 'Ingavi', 'Pacajes', 'Nor Yungas'],
        3: ['Arani', 'Carrasco', 'Cercado', 'Esteban Arce', 'Germán Jordán'],
        4: ['Oropeza', 'Azurduy', 'Tomina', 'Zudáñez', 'Yamparáez'],
        5: ['Tomás Frías', 'Charcas', 'Nor Chichas', 'Sud Chichas', 'Linares'],
        6: ['Cercado', 'Litoral', 'Ladislao Cabrera', 'Poopó', 'Sajama'],
        7: ['Cercado', 'Yacuma', 'Ballivián', 'Moxos', 'Vaca Díez'],
        8: ['Madre de Dios', 'Manuripi', 'Abuná', 'Federico Román', 'Nicolás Suárez'],
        9: ['Cercado', 'Arce', 'Avilés', 'O’Connor', 'Gran Chaco']
    };

    function actualizarProvincias(departamento, target, selectedProvincia = null) {
        $(target).empty().append('<option value="">Seleccionar Provincia</option>');
        if (provincias[departamento]) {
            $.each(provincias[departamento], function (index, provincia) {
                var optionValue = index + 1;
                var selected = optionValue == selectedProvincia ? 'selected' : '';
                $(target).append('<option value="' + optionValue + '" ' + selected + '>' + provincia + '</option>');
            });
        }
    }

    $(".tablas").on("click", ".btnEditarSucursal", function () {
        var idSucursal = $(this).attr("idSucursal");
        var datos = new FormData();
        datos.append("idSucursal", idSucursal);

        $.ajax({
            url: "ajax/sucursal.ajax.php",
            method: "POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function (respuesta) {
                $("#editarNombre").val(respuesta["nombre"]);
                $("#editarDepartamento").val(respuesta["departamento"]);
                actualizarProvincias(respuesta["departamento"], '#editarProvincia', respuesta["provincia"]);
                $("#editarDireccion").val(respuesta["direccion"]);
                $("#editarTelefono").val(respuesta["telefono"]);
                $("#editarEstado").val(respuesta["estado"]);
                $("#idSucursal").val(respuesta["id"]);
            },
            error: function (xhr, status, error) {
                console.error("Error al cargar la sucursal:", status, error);
            }
        });
    });

    // Lógica para la selección de provincias y sucursales de llegada en la funcionalidad general
    $('#departamentoLlegada').change(function () {
        var departamento = $(this).val();
        actualizarProvincias(departamento, '#provinciaLlegada');
        $('#provinciaLlegada').change();
    });

    $('#provinciaLlegada').change(function () {
        validarSucursalLlegada();
    });

    $('#tipoEnvio').change(function () {
        validarSucursalLlegada();
    });

    function validarSucursalLlegada() {
        var tipoEnvio = $('#tipoEnvio').val();
        var departamento = $('#departamentoLlegada').val();
        var provincia = $('#provinciaLlegada').val();

        if (tipoEnvio === 'domiciliario') {
            cargarSucursales(departamento, provincia, '#sucursalLlegada');
        } else {
            cargarSucursales(departamento, provincia, '#sucursalLlegada');
        }
    }

    function cargarSucursales(departamento, provincia, target) {
        $.ajax({
            url: "ajax/sucursal.ajax.php",
            method: "POST",
            data: {
                departamento: departamento,
                provincia: provincia
            },
            dataType: "json",
            success: function (sucursales) {
                var sucursalPartida = $('#sucursalPartida').val();
                $(target).empty().append('<option value="">Seleccionar Sucursal</option>');
                $.each(sucursales, function (index, sucursal) {
                    if (sucursal.nombre !== sucursalPartida) {
                        $(target).append('<option value="' + sucursal.id + '">' + sucursal.nombre + '</option>');
                    }
                });
            },
            error: function (xhr, status, error) {
                console.error("Error al cargar las sucursales:", status, error);
            }
        });
    }

    // Si ya hay un valor seleccionado en el departamento de llegada al cargar la página
    if ($('#departamentoLlegada').val()) {
        $('#departamentoLlegada').change();
    }
});


$(document).ready(function () {
    // Definimos las provincias
    var provincias = {
        '1': ['Andrés Ibáñez', 'Ichilo', 'Sara', 'Cordillera', 'Germán Busch'],
        '2': ['Murillo', 'Los Andes', 'Ingavi', 'Pacajes', 'Nor Yungas'],
        '3': ['Arani', 'Carrasco', 'Cercado', 'Esteban Arce', 'Germán Jordán'],
        '4': ['Oropeza', 'Azurduy', 'Tomina', 'Zudáñez', 'Yamparáez'],
        '5': ['Tomás Frías', 'Charcas', 'Nor Chichas', 'Sud Chichas', 'Linares'],
        '6': ['Cercado', 'Litoral', 'Ladislao Cabrera', 'Poopó', 'Sajama'],
        '7': ['Cercado', 'Yacuma', 'Ballivián', 'Moxos', 'Vaca Díez'],
        '8': ['Madre de Dios', 'Manuripi', 'Abuná', 'Federico Román', 'Nicolás Suárez'],
        '9': ['Cercado', 'Arce', 'Avilés', 'O’Connor', 'Gran Chaco']
    };

    // Función para actualizar las provincias en el modal de agregar sucursal
    function actualizarProvincias(departamento, target) {
        // Limpiar el select antes de agregar nuevas opciones
        $(target).empty().append('<option value="">Seleccionar Provincia</option>');

        // Recorrer las provincias y agregarlas al select
        if (provincias[departamento]) {
            provincias[departamento].forEach(function (provincia, index) {
                $(target).append('<option value="' + (index + 1) + '">' + provincia + '</option>');
            });
        }
    }

    // Evento para cargar las provincias cuando se selecciona un departamento en el modal de agregar sucursal
    $('#nuevoDepartamento').change(function () {
        var departamentoSeleccionado = $(this).val();
        actualizarProvincias(departamentoSeleccionado, '#nuevaProvincia');
    });
});

$(document).ready(function () {
    // Función para mostrar u ocultar el contenedor de dirección y llenar la dirección automáticamente
    function toggleDireccionContainer() {
        const tipoEnvio = $('#tipoEnvio').val();
        const direccionContainer = $('#direccionContainer');

        if (tipoEnvio === 'domiciliario') {
            // Muestra el contenedor
            direccionContainer.show();
            // Copia la dirección del remitente al campo de dirección de envío
            const direccionRemitente = $('#direccion_remitente').val();
            $('#direccionDomiciliario').val(direccionRemitente);
        } else {
            // Oculta el contenedor
            direccionContainer.hide();
            // Limpia el campo de dirección de envío
            $('#direccionDomiciliario').val('');
        }
    }

    // Ejecutar la función al cargar la página para manejar el estado inicial
    toggleDireccionContainer();

    // Asignar la función al evento de cambio del select
    $('#tipoEnvio').on('change', toggleDireccionContainer);
});



$(document).ready(function () {
    // Definimos las provincias
    var provincias = {
        '1': ['Andrés Ibáñez', 'Ichilo', 'Sara', 'Cordillera', 'Germán Busch'],
        '2': ['Murillo', 'Los Andes', 'Ingavi', 'Pacajes', 'Nor Yungas'],
        '3': ['Arani', 'Carrasco', 'Cercado', 'Esteban Arce', 'Germán Jordán'],
        '4': ['Oropeza', 'Azurduy', 'Tomina', 'Zudáñez', 'Yamparáez'],
        '5': ['Tomás Frías', 'Charcas', 'Nor Chichas', 'Sud Chichas', 'Linares'],
        '6': ['Cercado', 'Litoral', 'Ladislao Cabrera', 'Poopó', 'Sajama'],
        '7': ['Cercado', 'Yacuma', 'Ballivián', 'Moxos', 'Vaca Díez'],
        '8': ['Madre de Dios', 'Manuripi', 'Abuná', 'Federico Román', 'Nicolás Suárez'],
        '9': ['Cercado', 'Arce', 'Avilés', 'O’Connor', 'Gran Chaco']
    };

    // Función para actualizar las provincias, excluyendo la provincia seleccionada en la ida
    function actualizarProvincias(departamento, target, excludeProvincia = null) {

        // Limpiar el select antes de agregar nuevas opciones
        $(target).empty().append('<option value="">Seleccionar Provincia</option>');

        // Recorrer las provincias y excluir la que se seleccionó en la ida
        if (provincias[departamento]) {
            provincias[departamento].forEach(function (provincia, index) {
                if (provincia.trim() !== excludeProvincia.trim()) {
                    $(target).append('<option value="' + (index + 1) + '">' + provincia + '</option>');
                } else {
                }
            });
        }
    }

    // Función que maneja el cambio de departamento
    function manejarCambioDeDepartamento() {
        var departamentoSeleccionado = $('#departamentoLlegada').val();
        var provinciaIdaTexto = $('#provinciaPartida').val().trim();


        actualizarProvincias(departamentoSeleccionado, '#provinciaLlegada', provinciaIdaTexto);
    }

    // Evento cuando se cambia el departamento de llegada
    $('#departamentoLlegada').change(function () {
        manejarCambioDeDepartamento();
    });

    // Ejecutar al cargar la página para manejar el estado inicial
    manejarCambioDeDepartamento();
});


























