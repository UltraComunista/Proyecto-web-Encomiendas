$(document).ready(function () {

  console.log("Script cargado correctamente");

  const preciosPorPeso = [
      { rango: [0.01, 1], precio: 35.00 },
      { rango: [1.01, 2], precio: 60.00 },
      { rango: [2.01, 3], precio: 70.00 },
      { rango: [3.01, 4], precio: 80.00 },
      { rango: [4.01, 5], precio: 90.00 },
      { rango: [5.01, 6], precio: 110.00 },
      { rango: [6.01, 7], precio: 110.00 },
      { rango: [7.01, 8], precio: 120.00 },
      { rango: [8.01, 9], precio: 130.00 },
      { rango: [9.01, 10], precio: 140.00 },
      { rango: [10.01, 12], precio: 160.00 },
      { rango: [12.01, 15], precio: 190.00 },
      { rango: [15.01, 20], precio: 240.00 },
  ];

  const preciosPorTipo = {
      1: 15.00, // Electrónico
      2: 10.00, // Indumentaria
      3: 30.00, // Juguetes
      4: 40.00, // Mercaderia
  };

  const pesoInput = $('#pesoPaquete');
  const precioInput = $('#precio');
  const tipoPaqueteSelect = $('#tipoPaquete');

  function obtenerPrecioPorPeso(peso) {
      for (let i = 0; i < preciosPorPeso.length; i++) {
          const rango = preciosPorPeso[i].rango;
          if (peso >= rango[0] && peso <= rango[1]) {
              return preciosPorPeso[i].precio;
          }
      }
      return 0; // Retorna 0 si no se encuentra un rango adecuado
  }

  function actualizarPrecio() {
      console.log("Evento de actualización de precio disparado");

      const peso = parseFloat(pesoInput.val()) || 0;
      const tipoPaquete = parseInt(tipoPaqueteSelect.val()) || 0;
      let precio = 0;

      console.log(`Peso seleccionado: ${peso}`);
      console.log(`Tipo de paquete seleccionado: ${tipoPaquete}`);

      // Obtener precio basado en el peso
      precio += obtenerPrecioPorPeso(peso);

      // Sumar el precio adicional basado en el tipo de paquete
      if (preciosPorTipo.hasOwnProperty(tipoPaquete)) {
          precio += preciosPorTipo[tipoPaquete];
          console.log(`Precio basado en el tipo: ${preciosPorTipo[tipoPaquete]}`);
      }

      console.log(`Precio total calculado: ${precio}`);
      precioInput.val(precio.toFixed(2));
  }

  pesoInput.on('input', actualizarPrecio);
  tipoPaqueteSelect.on('change', actualizarPrecio);
});




$(document).on("click", ".btnEditarPaquete", function () {
  var idPaquete = $(this).attr("idPaquete");

  $.ajax({
    url: "ajax/paquetes.ajax.php",
    method: "POST",
    data: { idPaquete: idPaquete, action: 'get' },
    dataType: "json",
    success: function (response) {
      if (response) {
        var htmlContent = `
          <input type="hidden" id="idPaquete" name="idPaquete" value="${response.id}">
          <div class="container">
            <!-- Campos del formulario -->
            <div class="row mb-3">
              <div class="col-md-6">
                <label class="form-label">Número de Rastreo:</label>
                <input type="text" class="form-control" id="nro_registro" value="${response.nro_registro}" readonly>
              </div>
              <div class="col-md-6">
                <label class="form-label">Estado del Paquete:</label>
                <select class="form-select" id="estadoPaquete">
                  <option value="0" ${response.estadoPaquete == 0 ? 'selected' : ''}>Recepcionado</option>
                  <option value="1" ${response.estadoPaquete == 1 ? 'selected' : ''}>En camino</option>
                  <option value="2" ${response.estadoPaquete == 2 ? 'selected' : ''}>Recepcionado</option>
                  <option value="3" ${response.estadoPaquete == 3 ? 'selected' : ''}>Entregado</option>
                </select>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-6">
                <label class="form-label">Cantidad:</label>
                <input type="text" class="form-control" id="cantidad" value="${response.cantidad || 1}" readonly>
              </div>
              <div class="col-md-6">
                <label class="form-label">Precio:</label>
                <input type="text" class="form-control" id="precio" value="${response.precio || 0.00}" readonly>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-6">
                <label class="form-label">Descripción:</label>
                <input type="text" class="form-control" id="descripcion" value="${response.descripcion || 'Sin descripción'}" readonly>
              </div>
              <div class="col-md-6">
                <label class="form-label">Estado del Pago:</label>
                <select class="form-select" id="estadoPago">
                  <option value="0" ${response.EstadoPago == 0 ? 'selected' : ''}>Debe</option>
                  <option value="1" ${response.EstadoPago == 1 ? 'selected' : ''}>Pagado</option>
                  <option value="2" ${response.EstadoPago == 2 ? 'selected' : ''}>Pagado QR</option>
                </select>
              </div>
            </div>
          </div>
        `;
        $("#modal-body-content").html(htmlContent);
      } else {
        console.log("No se pudo recuperar la información del paquete");
      }
    },
    error: function (xhr, status, error) {
      console.log("Error:", error);
    }
  });
});


$(document).on("click", "#update-status-btn", function () {
  var idPaquete = $("#idPaquete").val();

  // Verificar que idPaquete tiene un valor
  if (!idPaquete) {
    Swal.fire("Error", "No se pudo obtener el ID del paquete.", "error");
    return;
  }

  var estadoPaquete = document.getElementById("estadoPaquete").value;
  var estadoPago = document.getElementById("estadoPago").value;

  if (estadoPago === '2') {
    // Mostrar el SweetAlert de cargando para el pago QR
    Swal.fire({
      title: "Cargando...",
      text: "Esperando confirmación de pago...",
      icon: "info",
      showConfirmButton: false,
      allowOutsideClick: false
    });

    // Hacer la solicitud a la API para crear la orden de pago QR
    $.ajax({
      url: "ajax/paquetes.ajax.php",
      method: "POST",
      data: {
        idPaquete: idPaquete,
        action: 'createOrder'
      },
      dataType: "json",
      success: function (result) {
        if (result.payment_url) {
          console.log("Enlace de pago generado:", result.payment_url);

          // Redirigir al enlace de pago en la misma ventana
          window.location.href = result.payment_url;

        } else {
          console.error("Error al generar el pago:", result.error || "No se pudo generar el pago");
          Swal.fire("Error", result.error || "No se pudo generar el pago", "error");
        }
      },
      error: function (xhr, status, error) {
        Swal.fire("Error", "Hubo un problema al contactar la API: " + error, "error");
      }
    });

    // Detener el flujo aquí para evitar que continúe con la actualización
    return;
  }

  // Si no es "Pagado QR", actualizar el estado normalmente
  $.ajax({
    url: "ajax/paquetes.ajax.php",
    method: "POST",
    data: {
      idPaquete: idPaquete,
      estadoPaquete: estadoPaquete,
      estadoPago: estadoPago,
      action: 'updateStatus'
    },
    success: function (response) {
      console.log("Respuesta del servidor: ", response);
      if (response.trim() === "ok") {
        let mensaje = '';
        if (estadoPago === '0') {
          mensaje = 'Estado actualizado a Debe correctamente';
        } else if (estadoPago === '1') {
          mensaje = 'Estado actualizado a Pagado correctamente';
        } else {
          mensaje = 'Estado actualizado correctamente';
        }

        Swal.fire({
          title: 'Éxito',
          text: mensaje,
          icon: 'success',
          confirmButtonText: 'OK'
        }).then(() => {
          location.reload();
        });
      } else {
        Swal.fire({
          title: 'Error',
          text: 'Error al actualizar el estado: ' + response,
          icon: 'error',
          confirmButtonText: 'OK'
        });
      }
    },
    error: function (xhr, status, error) {
      Swal.fire({
        title: 'Error',
        text: 'Hubo un problema al contactar el servidor: ' + error,
        icon: 'error',
        confirmButtonText: 'OK'
      });
    }
  });
});



$(document).ready(function () {
  $('input[name="cedula_enviador"]').on('blur', function () {
    var cedula = $(this).val();
    if (cedula) {
      $.ajax({
        type: 'POST',
        url: 'ajax/cliente.ajax.php',
        data: { cedula: cedula, tipo: 1 }, // tipo 1 para remitente
        success: function (response) {
          var data = JSON.parse(response);
          if (data.existe) {
            var cliente = data.cliente;
            $('input[name="nombre_enviador"]').val(cliente.nombre);
            $('input[name="telefono_enviador"]').val(cliente.telefono);
            $('input[name="direccion_enviador"]').val(cliente.direccion);
            $('#mensajeClienteEnviador').remove();
          } else {
            if (!$('#mensajeClienteEnviador').length) {
              $('input[name="cedula_enviador"]').after('<span id="mensajeClienteEnviador" class="text-dark">Cliente no registrado, se registrará este cliente.</span>');
            }
            $('input[name="nombre_enviador"]').val('');
            $('input[name="telefono_enviador"]').val('');
            $('input[name="direccion_enviador"]').val('');
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
        url: 'ajax/cliente.ajax.php',
        data: { cedula: cedula, tipo: 2 }, // tipo 2 para destinatario
        success: function (response) {
          var data = JSON.parse(response);
          if (data.existe) {
            var cliente = data.cliente;
            $('input[name="nombre_remitente"]').val(cliente.nombre);
            $('input[name="telefono_remitente"]').val(cliente.telefono);
            $('input[name="direccion_remitente"]').val(cliente.direccion);
            $('#mensajeClienteRemitente').remove();
          } else {
            if (!$('#mensajeClienteRemitente').length) {
              $('input[name="cedula_remitente"]').after('<span id="mensajeClienteRemitente" class="text-dark">Cliente no registrado, se registrará este cliente.</span>');
            }
            $('input[name="nombre_remitente"]').val('');
            $('input[name="telefono_remitente"]').val('');
            $('input[name="direccion_remitente"]').val('');
          }
        }
      });
    }
  });
});





$(document).on("click", ".btnImprimirPaquete", function () {
  var idPaquete = $(this).attr("idPaquete");
  $.ajax({
    url: "ajax/paquetes.ajax.php",
    method: "POST",
    data: { idPaquete: idPaquete, action: 'generatePDF' },
    success: function (response) {
      var res = JSON.parse(response);
      if (res.status == 'ok') {
        var pdfWindow = window.open("");
        pdfWindow.document.write(
          "<iframe width='100%' height='100%' src='data:application/pdf;base64," + encodeURI(res.pdfData) + "'></iframe>"
        );
      } else {
        alert("Error al generar el PDF: " + res.message);
      }
    },
    error: function (error) {
      console.log("Error:", error);
      alert("Error al procesar la solicitud");
    }
  });
});


