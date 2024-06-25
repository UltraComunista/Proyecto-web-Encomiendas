$(document).ready(function() {
    $('#tablaRemitentes').DataTable({
        responsive: true,
        language: {
            search: "Buscar Remitente:",
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

$(".tablas").on("click", ".btnEditarRemitente", function () {
    var idRemitente = $(this).attr("idRemitente");

    var datos = new FormData();
    datos.append("idRemitente", idRemitente);

    $.ajax({
        url: "ajax/remitente.ajax.php",
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
            $("#idRemitente").val(respuesta["id"]);
        }
    });
});

$(".tablas").on("click", ".btnEliminarRemitente", function () {
    var idRemitente = $(this).attr("idRemitente");

    Swal.fire({
        title: "Estas seguro de eliminar este remitente?",
        text: "No puedes deshacer esta accion!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si, eliminar",
        cancelButtonText: "Cancelar",
    }).then((result) => {
        if (result.value) {
            window.location = "index.php?ruta=remitente&idRemitente=" + idRemitente;
        }
    });
});
 // Manejar la generación de reportes
 $("#btn-reportes-remitente").on("click", function () {
    window.open("extensiones/tcpdf/pdf/reporteremitente.php", "_blank");
});
