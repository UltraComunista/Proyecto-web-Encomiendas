$(document).ready(function() {
    // Inicializa DataTables
    $('#example').DataTable({
        responsive: true,
        language: {
            search: "Buscar Sucursal:",
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

    // Manejar la edición de sucursales
    $(".tablas").on("click", ".btnEditarSucursal", function() {
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
            success: function(respuesta) {
                $("#editarNombre").val(respuesta["nombre"]);
                $("#editarDepartamento").val(respuesta["departamento"]);
                $("#editarTelefono").val(respuesta["telefono"]);
                $("#idSucursal").val(respuesta["id"]);

                // Cargar provincias según el departamento seleccionado
                actualizarProvinciasEditar(respuesta["departamento"], respuesta["provincia"]);
            }
        });
    });

    function actualizarProvincias(departamento) {
        var provincias = {
            'Santa Cruz': ['Andrés Ibáñez', 'Ichilo', 'Sara', 'Cordillera', 'Germán Busch'],
            'La Paz': ['Murillo', 'Los Andes', 'Ingavi', 'Pacajes', 'Nor Yungas'],
            'Cochabamba': ['Arani', 'Carrasco', 'Cercado', 'Esteban Arce', 'Germán Jordán'],
            'Sucre': ['Oropeza', 'Azurduy', 'Tomina', 'Zudáñez', 'Yamparáez'],
            'Potosi': ['Tomás Frías', 'Charcas', 'Nor Chichas', 'Sud Chichas', 'Linares'],
            'Oruro': ['Cercado', 'Litoral', 'Ladislao Cabrera', 'Poopó', 'Sajama'],
            'Beni': ['Cercado', 'Yacuma', 'Ballivián', 'Moxos', 'Vaca Díez'],
            'Pando': ['Madre de Dios', 'Manuripi', 'Abuná', 'Federico Román', 'Nicolás Suárez'],
            'Tarija': ['Cercado', 'Arce', 'Avilés', 'O’Connor', 'Gran Chaco']
        };

        $('#nuevaProvincia').empty().append('<option value="">Seleccionar Provincia</option>');
        if (provincias[departamento]) {
            $.each(provincias[departamento], function(index, provincia) {
                $('#nuevaProvincia').append('<option value="' + provincia + '">' + provincia + '</option>');
            });
        }
        $('#nuevaProvincia').select2(); // Actualiza select2
    }

    function actualizarProvinciasEditar(departamento, provinciaSeleccionada) {
        var provincias = {
            'Santa Cruz': ['Andrés Ibáñez', 'Ichilo', 'Sara', 'Cordillera', 'Germán Busch'],
            'La Paz': ['Murillo', 'Los Andes', 'Ingavi', 'Pacajes', 'Nor Yungas'],
            'Cochabamba': ['Arani', 'Carrasco', 'Cercado', 'Esteban Arce', 'Germán Jordán'],
            'Sucre': ['Oropeza', 'Azurduy', 'Tomina', 'Zudáñez', 'Yamparáez'],
            'Potosi': ['Tomás Frías', 'Charcas', 'Nor Chichas', 'Sud Chichas', 'Linares'],
            'Oruro': ['Cercado', 'Litoral', 'Ladislao Cabrera', 'Poopó', 'Sajama'],
            'Beni': ['Cercado', 'Yacuma', 'Ballivián', 'Moxos', 'Vaca Díez'],
            'Pando': ['Madre de Dios', 'Manuripi', 'Abuná', 'Federico Román', 'Nicolás Suárez'],
            'Tarija': ['Cercado', 'Arce', 'Avilés', 'O’Connor', 'Gran Chaco']
        };

        $('#editarProvincia').empty().append('<option value="">Seleccionar Provincia</option>');
        if (provincias[departamento]) {
            $.each(provincias[departamento], function(index, provincia) {
                $('#editarProvincia').append('<option value="' + provincia + '">' + provincia + '</option>');
            });
        }
        $('#editarProvincia').val(provinciaSeleccionada).select2(); // Selecciona la provincia correspondiente y actualiza select2
    }

    // Cargar provincias dinámicamente cuando se cambia el departamento en el formulario de edición
    $('#editarDepartamento').change(function() {
        var departamento = $(this).val();
        actualizarProvinciasEditar(departamento, null);
    });

    // Manejar cambio de departamento y cargar provincias correspondientes
    $('#nuevaDepartamento').change(function() {
        var departamento = $(this).val();
        actualizarProvincias(departamento);
    });

    // Sincronizar selecciones de sucursal
    $('#sucursalPartida, #sucursalLlegada').change(function() {
        var partidaSelected = $('#sucursalPartida').val();
        var llegadaSelected = $('#sucursalLlegada').val();

        // Habilitar todas las opciones primero
        $('#sucursalPartida option, #sucursalLlegada option').prop('disabled', false);

        // Deshabilitar la opción seleccionada en el otro selector
        if (partidaSelected) {
            $('#sucursalLlegada option[value="' + partidaSelected + '"]').prop('disabled', true);
        }
        if (llegadaSelected) {
            $('#sucursalPartida option[value="' + llegadaSelected + '"]').prop('disabled', true);
        }

        // Actualizar select2 para reflejar cambios
        $('#sucursalPartida').select2();
        $('#sucursalLlegada').select2();
    });

    // Asegurarte de que Select2 se inicialice aquí también puede ser útil
    $('.select2').select2();
});
 // Manejar la generación de reportes
 $("#btn-reportes-sucursal").on("click", function () {
    window.open("extensiones/tcpdf/pdf/reportesucursal.php", "_blank");
});
