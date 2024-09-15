<?php

require __DIR__ . '/../vendor/autoload.php'; // Asegúrate de que esta ruta es correcta
// Asegúrate de que el path sea correcto según tu estructura de carpetas
require_once __DIR__ . '/usuarios.controlador.php';

use Twilio\Rest\Client;
use Dotenv\Dotenv;

// Cargar variables de entorno
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

class ControladorPaquetes
{
    public static function ctrObtenerEnviosPorUsuario($idUsuario)
    {
        $tabla = "recepcionencomienda";
        $envios = ModeloPaquetes::mdlObtenerEnviosPorUsuario($tabla, $idUsuario);
    
        return $envios;
    }
    
    

    public static function ctrVerificarEstadoPago($idPaquete)
    {
        $tabla = "paquetes"; // Ajusta esto al nombre de la tabla donde almacenas el estado de pago

        // Llamar al modelo para obtener el estado del pago
        $respuesta = ModeloPaquetes::mdlVerificarEstadoPago($tabla, $idPaquete);

        // Devuelve el estado de pago
        return $respuesta['estadoPago']; // Ajusta 'estadoPago' al nombre real de tu columna en la base de datos
    }

    public static function ctrActualizarPagoExitoso($idPaquete)
    {
        $estadoPago = '1';  // Pagado
        $estadoPaquete = '3'; // Entregado (o el estado correspondiente)
        $idUsuario = $_SESSION['idUsuario'];

        $datos = array(
            "id" => $idPaquete,
            "estadoPaquete" => $estadoPaquete,
            "estadoPago" => $estadoPago,
            "idUsuario" => $idUsuario
        );

        $respuesta = self::ctrActualizarPaquete($datos);

        return $respuesta;
    }
    /*=============================================
    MOSTRAR PAQUETES
    =============================================*/
    static public function ctrMostrarPaquetes($item, $valor)
    {
        $tabla = "recepcionencomienda";
        $respuesta = ModeloPaquetes::mdlMostrarPaquetes($tabla, $item, $valor);
        return $respuesta;
    }

    static public function ctrCrearPaquete()
    {
        ob_start(); // Inicia el buffer de salida
        if (isset($_POST["cedula_enviador"])) {
            if (preg_match('/^[0-9]+$/', $_POST["cedula_enviador"])) {

                // Aquí puedes agregar logs para revisar qué datos están llegando
                error_log("Datos recibidos: " . json_encode($_POST));

                // Continúa con el proceso normal
                $proximoNumeroRegistro = self::ctrObtenerSiguienteNumeroRegistro();

                $tabla = "recepcionencomienda";
                $fechaRecepcion = date("Y-m-d H:i:s");

                $sucursalLlegadaNombre = self::ctrObtenerNombreSucursal($_POST["sucursalLlegada"]);
                $idUsuario = $_SESSION['idUsuario'];

                $datos = array(
                    "nro_registro" => (int)$proximoNumeroRegistro,
                    "cedula_enviador" => (int)$_POST["cedula_enviador"],
                    "nombre_enviador" => $_POST["nombre_enviador"],
                    "telefono_enviador" => $_POST["telefono_enviador"],
                    "direccion_enviador" => $_POST["direccion_enviador"],
                    "cedula_remitente" => (int)$_POST["cedula_remitente"],
                    "nombre_remitente" => $_POST["nombre_remitente"],
                    "telefono_remitente" => $_POST["telefono_remitente"],
                    "direccion_remitente" => $_POST["direccion_remitente"],
                    "sucursalPartida" => (int)$_POST["sucursalPartida"],  // Convertir a entero
                    "sucursalLlegada" => (int)$_POST["sucursalLlegada"],  // Convertir a entero
                    "fechaRecepcion" => $fechaRecepcion, // No es necesario convertir datetime
                    "tipoEnvio" => (int)$_POST["tipoEnvio"],  // Convertir a tinyint
                    "estadoPago" => 0,
                    "estadoPaquete" => 0,
                    "descripcion" => $_POST["descripcion"],
                    "cantidad" => (int)$_POST["cantidad"],  // Convertir a entero
                    "precio" => (float)$_POST["precio"],  // Convertir a flotante
                    "tipoPaquete" => (int)$_POST["tipoPaquete"],  // Convertir a tinyint
                    "peso" => (float)$_POST["pesoPaquete"],  // Agregar el peso como flotante
                    "idUsuario" => (int)$idUsuario  // Convertir a entero
                );

                error_log("Datos para insertar: " . json_encode($datos));

                $respuesta = ModeloPaquetes::mdlIngresarPaquete($tabla, $datos);

                if ($respuesta == "ok") {
                    self::enviarNotificacionWhatsApp(
                        $_POST["telefono_remitente"],
                        $_POST["nombre_remitente"],
                        $proximoNumeroRegistro,
                        $sucursalLlegadaNombre
                    );

                    $idPaquete = ModeloPaquetes::mdlObtenerUltimoId($tabla);
                    ob_end_clean();
                    echo json_encode(['status' => 'ok', 'id' => $idPaquete]);
                    exit();
                } else {
                    ob_end_clean();
                    echo json_encode(['status' => 'error']);
                    exit();
                }
            } else {
                ob_end_clean();
                echo json_encode(['status' => 'error']);
                exit();
            }
        } else {
            ob_end_clean();
            echo json_encode(['status' => 'error']);
            exit();
        }
    }


    public static function ctrCrearPaqueteAPI($data, $userId)
    {
        try {
            // Generar número de registro u otros datos necesarios
            $proximoNumeroRegistro = self::ctrObtenerSiguienteNumeroRegistro();
            if (!$proximoNumeroRegistro) {
                error_log("Error: No se pudo generar el número de registro.");
                return ['status' => 'error', 'message' => 'No se pudo generar el número de registro.'];
            }

            // Obtener los datos del usuario (empresa) desde el ID
            $usuario = ControladorUsuarios::ctrObtenerUsuarioPorId($userId);
            if (!$usuario) {
                error_log("Error: No se pudo obtener el usuario con ID $userId.");
                return ['status' => 'error', 'message' => 'No se pudo obtener el usuario.'];
            }

            // Calcular el precio basado en el peso
            $precio = self::calcularPrecio($data['pesoPaquete'], $data['tipoPaquete']);
            error_log("Precio calculado: " . $precio);

            $datos = array(
                "nro_registro" => $proximoNumeroRegistro,
                "cedula_remitente" => $data["cedula_remitente"],
                "nombre_remitente" => $data["nombre_remitente"],
                "telefono_remitente" => $data["telefono_remitente"],
                "direccion_remitente" => $data["direccion_remitente"],
                "sucursalPartida" => $data["sucursalPartida"],
                "sucursalLlegada" => $data["sucursalLlegada"],
                "fechaRecepcion" => date("Y-m-d H:i:s"),
                "tipoEnvio" => $data["tipoEnvio"],
                "estadoPago" => 0,
                "estadoPaquete" => 0,
                "descripcion" => $data["descripcion"],
                "cantidad" => $data["cantidad"],
                "precio" => $precio, // Usar el precio calculado
                "tipoPaquete" => $data["tipoPaquete"],
                "idUsuario" => $userId,
                "nombre_enviador" => $usuario['nombre'],
                "cedula_enviador" => $usuario['cedula'],
                "telefono_enviador" => $usuario['telefono'],
                "direccion_enviador" => $usuario['direccion'],
                "peso" => (float)$data["pesoPaquete"]
            );

            // Registrar los datos antes de insertarlos
            error_log("Datos a insertar: " . print_r($datos, true));

            // Insertar en la base de datos usando el modelo
            $respuesta = ModeloPaquetes::mdlIngresarPaqueteAPI("recepcionencomienda", $datos);

            if ($respuesta == "ok") {
                $idPaquete = ModeloPaquetes::mdlObtenerUltimoId("recepcionencomienda");

                // Enviar notificación por WhatsApp (si es necesario)
                self::enviarNotificacionWhatsApp(
                    $data["telefono_remitente"],
                    $data["nombre_remitente"],
                    $proximoNumeroRegistro,
                    self::ctrObtenerNombreSucursal($data["sucursalLlegada"])
                );

                return [
                    'status' => 'ok',
                    'id' => $idPaquete,
                    'nro_registro' => $proximoNumeroRegistro,
                    'sucursalLlegada' => self::ctrObtenerNombreSucursal($data["sucursalLlegada"]),
                    'precio' => $precio
                ];
            } else {
                error_log("Error en la inserción del paquete: " . $respuesta);
                return ['status' => 'error', 'message' => 'Error al insertar el paquete en la base de datos.'];
            }
        } catch (Exception $e) {
            error_log("Excepción capturada: " . $e->getMessage());
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }


    // Nueva función para calcular el precio basado en el peso y tipo de paquete
    private static function calcularPrecio($peso, $tipoPaquete)
    {
        $preciosPorPeso = [
            [0.01, 1, 35.00],
            [1.01, 2, 60.00],
            [2.01, 3, 70.00],
            [3.01, 4, 80.00],
            [4.01, 5, 90.00],
            [5.01, 6, 110.00],
            [6.01, 7, 110.00],
            [7.01, 8, 120.00],
            [8.01, 9, 130.00],
            [9.01, 10, 140.00],
            [10.01, 12, 160.00],
            [12.01, 15, 190.00],
            [15.01, 20, 240.00],
        ];

        $preciosPorTipo = [
            1 => 15.00, // Electrónico
            2 => 10.00, // Indumentaria
            3 => 30.00, // Juguetes
            4 => 40.00, // Mercaderia
        ];

        $precioPorPeso = 0;
        foreach ($preciosPorPeso as $rango) {
            if ($peso >= $rango[0] && $peso <= $rango[1]) {
                $precioPorPeso = $rango[2];
                break;
            }
        }

        $precioPorTipo = $preciosPorTipo[$tipoPaquete] ?? 0;

        return $precioPorPeso + $precioPorTipo;
    }













    /*=============================================
    OBTENER NOMBRE DE SUCURSAL
    =============================================*/
    static public function ctrObtenerNombreSucursal($idSucursal)
    {
        $tabla = "sucursal";
        $respuesta = ModeloPaquetes::mdlMostrarSucursales($tabla, "id", $idSucursal);
        return $respuesta["nombre"];
    }

    /*=============================================
    ENVIAR NOTIFICACION WHATSAPP
    =============================================*/
    public static function enviarNotificacionWhatsApp($telefonoRemitente, $nombreRemitente, $numeroRegistro, $sucursalLlegada)
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
            ->create(
                $numeroWhatsAppDestino, // Destino
                array(
                    'from' => $numeroWhatsAppOrigen, // Origen
                    'body' => "Hola $nombreRemitente, tu paquete con número de seguimiento $numeroRegistro ha sido enviado y llegará a la sucursal $sucursalLlegada."
                )
            );

        // Imprimir SID del mensaje para verificar
        echo $mensaje->sid;
    }



    // Otros métodos...
    static public function ctrActualizarPaquete($datos)
    {
        $tabla = "recepcionencomienda";
        $respuesta = ModeloPaquetes::mdlActualizarPaquete($tabla, $datos);

        return $respuesta;
    }









    /*=============================================
    BORRAR SUCURSAL
    =============================================*/
    static public function ctrBorrarSucursal()
    {
        if (isset($_GET["idSucursal"])) {
            $tabla = "recepcionencomienda";
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
        $tabla = "recepcionencomienda";
        $ultimoNumeroRegistro = ModeloPaquetes::mdlObtenerUltimoNumeroRegistro($tabla);

        // Incrementar el último número para el siguiente registro
        $proximoNumeroRegistro = (int)$ultimoNumeroRegistro + 1;

        return $proximoNumeroRegistro;
    }
}
