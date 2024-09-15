$(document).ready(function () {
  var form = $(".validation-wizard").show();

  $(".validation-wizard").steps({
    headerTag: "h6",
    bodyTag: "section",
    transitionEffect: "fade",
    titleTemplate: '<span class="step">#index#</span> #title#',
    labels: {
      previous: "Anterior",
      next: "Siguiente",
      finish: "Enviar",
      current: "Paso actual:"
    },
    onStepChanging: function (event, currentIndex, newIndex) {
      return currentIndex > newIndex || (
        !(3 === newIndex && Number($("#age-2").val()) < 18) &&
        (currentIndex < newIndex &&
          (form.find(".body:eq(" + newIndex + ") label.error").remove(),
            form.find(".body:eq(" + newIndex + ") .error").removeClass("error")),
          (form.validate().settings.ignore = ":disabled,:hidden"),
          form.valid())
      );
    },
    onFinishing: function (event, currentIndex) {
      return (form.validate().settings.ignore = ":disabled"), form.valid();
    },
    onFinished: function (event, currentIndex) {
      event.preventDefault(); // Prevenir el comportamiento predeterminado del formulario

      var formData = form.serialize() + '&action=createPaquete';
      console.log("Form data to be sent:", formData); // Añadir log de depuración

      $.ajax({
        url: "ajax/paquetes.ajax.php",
        method: "POST",
        data: formData,
        success: function (response) {
          console.log("Response from server:", response); // Añadir log de depuración
          try {
            var res = JSON.parse(response);
            if (res.status === 'ok') {
              Swal.fire({
                title: 'Formulario Enviado!',
                text: 'El paquete ha sido guardado correctamente.',
                icon: 'success'
              }).then(() => {
                // Abrir el PDF en una nueva ventana o pestaña con el id del paquete
                window.open('reportes/guia_envio.php?idPaquete=' + res.id, '_blank');
                location.reload(); // Recargar la página después de mostrar el SweetAlert
              });
            } else {
              Swal.fire({
                title: 'Error',
                text: res.message || 'No se pudo registrar el paquete.',
                icon: 'error'
              });
            }
          } catch (e) {
            console.error("Error parsing response:", e);
            Swal.fire({
              title: 'Error',
              text: 'Ocurrió un error al procesar la respuesta del servidor.',
              icon: 'error'
            });
          }
        },
        error: function (error) {
          console.error("Error in Ajax request:", error);
          Swal.fire({
            title: 'Error',
            text: 'Ocurrió un error al enviar el formulario.',
            icon: 'error'
          });
        }
      });
    }
  });

  $(".validation-wizard").validate({
    ignore: "input[type=hidden]",
    errorClass: "text-danger",
    successClass: "text-success",
    highlight: function (element, errorClass) {
      $(element).removeClass(errorClass);
    },
    unhighlight: function (element, errorClass) {
      $(element).removeClass(errorClass);
    },
    errorPlacement: function (error, element) {
      error.insertAfter(element);
    },
    rules: {
      email: {
        email: true
      }
    }
  });

  // Manejador de envío de formulario
  $("form.validation-wizard").on('submit', function (event) {
    event.preventDefault(); // Prevenir el comportamiento predeterminado del formulario
  });
});
