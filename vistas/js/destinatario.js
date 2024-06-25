
$(document).ready(function() {
    $('#tablaDestinatarios').DataTable({
        responsive: true,
        language: {
            search: "Buscar Destinatario:",
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
 // Manejar la edición de destinatarios
 $(".tablas").on("click", ".btnEditarDestinatario", function () {
    var idDestinatario = $(this).attr("idDestinatario");
    var datos = new FormData();
    datos.append("idDestinatario", idDestinatario);

    $.ajax({
        url: "ajax/destinatario.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function (respuesta) {
            $("#editarCedula").val(respuesta["cedula"]);
            $("#editarNombre").val(respuesta["nombre"]);
            $("#editarDireccion").val(respuesta["direccion"]);
            $("#editarTelefono").val(respuesta["telefono"]);
            $("#idDestinatario").val(respuesta["id"]);
        }
    });
});

// Manejar la eliminación de destinatarios
$(".tablas").on("click", ".btnEliminarDestinatario", function () {
    var idDestinatario = $(this).attr("idDestinatario");
    Swal.fire({
        title: "¿Estás seguro de eliminar este destinatario?",
        text: "¡No puedes deshacer esta acción!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Sí, eliminar",
        cancelButtonText: "Cancelar",
    }).then((result) => {
        if (result.value) {
            window.location = "index.php?ruta=destinatario&idDestinatario=" + idDestinatario;
        }
    });
});
 // Manejar la generación de reportes
 $("#btn-reportes-destinatario").on("click", function () {
    window.open("extensiones/tcpdf/pdf/reportedestinatario.php", "_blank");
});

