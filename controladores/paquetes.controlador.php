<?php

require __DIR__ . '/../vendor/autoload.php'; // Asegúrate de que esta ruta es correcta
use Twilio\Rest\Client;
use Dotenv\Dotenv;

// Cargar variables de entorno
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

class ControladorPaquetes
{
    /*=============================================
    MOSTRAR PAQUETES
    =============================================*/
    static public function ctrMostrarPaquetes($item, $valor)
    {
        $tabla = "recepcionpaquete";
        $respuesta = ModeloPaquetes::mdlMostrarPaquetes($tabla, $item, $valor);
        return $respuesta;
    }

    /*=============================================
    CREAR PAQUETE
    =============================================*/
    static public function ctrCrearPaquete()
    {
        if (isset($_POST["cedula_enviador"])) {
            // Validar datos del enviador y del remitente
            if (
                preg_match('/^[0-9]+$/', $_POST["cedula_enviador"]) &&
                preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nombre_enviador"]) &&
                preg_match('/^[0-9]+$/', $_POST["cedula_remitente"]) &&
                preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nombre_remitente"])
            ) {

                $proximoNumeroRegistro = self::ctrObtenerSiguienteNumeroRegistro();

                $tabla = "recepcionpaquete";
                $fechaRecepcion = date("Y-m-d H:i:s");

                // Recoger datos del enviador, remitente y detalles del paquete
                $datos = array(
                    "nro_registro" => $proximoNumeroRegistro,
                    "cedula_enviador" => $_POST["cedula_enviador"],
                    "nombre_enviador" => $_POST["nombre_enviador"],
                    "telefono_enviador" => $_POST["telefono_enviador"],
                    "direccion_enviador" => $_POST["direccion_enviador"],
                    "cedula_remitente" => $_POST["cedula_remitente"],
                    "nombre_remitente" => $_POST["nombre_remitente"],
                    "telefono_remitente" => $_POST["telefono_remitente"],
                    "direccion_remitente" => $_POST["direccion_remitente"],
                    "sucursalPartida" => $_POST["sucursalPartida"],
                    "sucursalLlegada" => $_POST["sucursalLlegada"],
                    "fechaRecepcion" => $fechaRecepcion,
                    "tipoEnvio" => $_POST["tipoEnvio"],
                    "estadoPago" => isset($_POST["estadoPago"]) ? "Pagado" : "Debe",
                    "estadoPaquete" => "Pendiente",
                    "descripcion" => $_POST["descripcion"],
                    "cantidad" => $_POST["cantidad"],
                    "precio" => $_POST["precio"]
                );

                // Intentar crear el paquete
                $respuesta = ModeloPaquetes::mdlIngresarPaquete($tabla, $datos);

                if ($respuesta == "ok") {
                    // Aquí se envía la notificación a través de Twilio
                    self::enviarNotificacionWhatsApp(
                        $_POST["telefono_remitente"],
                        $_POST["nombre_remitente"],
                        $proximoNumeroRegistro,
                        $_POST["sucursalLlegada"]
                    );

                    echo "<script>
                        window.addEventListener('load', function() {
                            toastr.success('El paquete ha sido guardado correctamente', '¡Éxito!');
                            setTimeout(function() {
                                window.location = 'listaenvios';
                            }, 2000);
                        });
                    </script>";
                } else {
                    echo "<script>
                        window.addEventListener('load', function() {
                            toastr.error('No se pudo registrar el paquete.', 'Error');
                            setTimeout(function() {
                                window.location = 'ruta_a_la_pagina_de_paquetes';
                            }, 2000);
                        });
                    </script>";
                }
            } else {
                echo "<script>
                    window.addEventListener('load', function() {
                        toastr.error('Datos inválidos en los campos del enviador o remitente.', 'Error');
                        setTimeout(function() {
                            window.location = 'ruta_a_la_pagina_de_paquetes';
                        }, 2000);
                    });
                </script>";
            }
        }
    }

    static public function enviarNotificacionWhatsApp($telefonoRemitente, $nombreRemitente, $numeroRegistro, $sucursalLlegada)
    {
        // Las credenciales de Twilio
        $sid = $_ENV['TWILIO_SID'];
        $token = $_ENV['TWILIO_TOKEN'];
        $twilio = new Client($sid, $token);

        // Número de WhatsApp de origen
        $numeroWhatsAppOrigen = $_ENV['TWILIO_WHATSAPP_NUMBER']; // Este es el número de Twilio para WhatsApp

        // Número de WhatsApp de destino
        $numeroWhatsAppDestino = 'whatsapp:' . $telefonoRemitente;

        // Enviar mensaje
        $mensaje = $twilio->messages
            ->create($numeroWhatsAppDestino, // Destino
                array(
                    'from' => $numeroWhatsAppOrigen, // Origen
                    'body' => "Hola $nombreRemitente, tu paquete con número de seguimiento $numeroRegistro ha sido enviado y llegará a la sucursal $sucursalLlegada."
                )
            );

        // Imprimir SID del mensaje para verificar
        echo $mensaje->sid;
    }

    /*=============================================
    EDITAR SUCURSAL
    =============================================*/
    static public function ctrEditarSucursal()
    {
        if (isset($_POST["editarNombre"])) {
            if (
                preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarNombre"])
            ) {
                $tabla = "recepcionpaquete";

                $datos = array(
                    "nombre" => $_POST["editarNombre"],
                    "departamento" => $_POST["editarDepartamento"],
                    "telefono" => $_POST["editarTelefono"],
                    "id" => $_POST["idSucursal"]
                );
                $respuesta = ModeloSucursales::mdlEditarSucursal($tabla, $datos);

                if ($respuesta == "ok") {
                    echo "<script>
                    window.addEventListener('load', function() {
                        toastr.success('El sucursal ha sido editado correctamente', '¡Éxito!');
                        setTimeout(function() {
                            window.location = 'sucursal';
                        }, 2000); // 2000 milisegundos = 2 segundos
                    });
                    </script>";
                } else {
                    echo "<script>
                    window.addEventListener('load', function() {
                        toastr.error('No se pudo editar el sucursal.', 'Error');
                        setTimeout(function() {
                            window.location = 'sucursal';
                        }, 2000); // 2000 milisegundos = 2 segundos
                    });
                    </script>";
                }
            }
        }
    }

    /*=============================================
    BORRAR SUCURSAL
    =============================================*/
    static public function ctrBorrarSucursal()
    {
        if (isset($_GET["idSucursal"])) {
            $tabla = "recepcionpaquete";
            $idSucursal = $_GET["idSucursal"];

            $respuesta = ModeloSucursales::mdlBorrarSucursal($tabla, $idSucursal);

            if ($respuesta == "ok") {
                echo "<script>
                window.addEventListener('load', function() {
                    toastr.success('El sucursal ha sido eliminada', '¡Éxito!');
                    setTimeout(function() {
                        window.location = 'sucursal';
                    }, 2000); // 2000 milisegundos = 2 segundos
                });
                </script>";
            } else {
                echo "<script>
                window.addEventListener('load', function() {
                    toastr.error('No se pudo eliminar el sucursal.', 'Error');
                    setTimeout(function() {
                        window.location = 'sucursal';
                    }, 2000); // 2000 milisegundos = 2 segundos
                });
                </script>";
            }
        }
    }

    /*=============================================
    OBTENER EL SIGUIENTE NÚMERO DE REGISTRO PARA FORMULARIO
    =============================================*/
    static public function ctrObtenerSiguienteNumeroRegistro()
    {
        $tabla = "recepcionpaquete";
        $ultimoNumeroRegistro = ModeloPaquetes::mdlObtenerUltimoNumeroRegistro($tabla);

        // Incrementar el último número para el siguiente registro
        $proximoNumeroRegistro = (int)$ultimoNumeroRegistro + 1;

        return $proximoNumeroRegistro;
    }
}
?>
