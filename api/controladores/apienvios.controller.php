<?php
// api/controladores/apienvios.controller.php
require_once __DIR__ . '/../../controladores/paquetes.controlador.php';
require_once __DIR__ . '/../../modelos/paquetes.modelo.php';

use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

class ApiEnviosController
{
    private $key = "your_secret_key";  // La misma clave secreta usada para generar el token
    private $userId;  // Definimos la propiedad userId

    public function __construct()
    {
        $this->verificarToken();  // Verificamos el token en cada instancia del controlador
    }

    private function verificarToken()
    {
        $headers = apache_request_headers();
        if (!isset($headers['Authorization'])) {
            http_response_code(401);
            echo json_encode(['error' => 'Token no proporcionado'], JSON_PRETTY_PRINT);
            exit();
        }

        $token = str_replace('Bearer ', '', $headers['Authorization']);

        try {
            $decoded = JWT::decode($token, new Key($this->key, 'HS256'));
            if (!isset($decoded->data->idUsuario)) {
                throw new Exception('ID de usuario no presente en el token');
            }
            $this->userId = $decoded->data->idUsuario;  // Asignamos el ID de usuario a la propiedad userId

            if (!$this->userId) {
                throw new Exception('ID de usuario no presente en el token');
            }
        } catch (Exception $e) {
            http_response_code(401);
            echo json_encode(['error' => 'Token no válido o ID de usuario no encontrado'], JSON_PRETTY_PRINT);
            exit();
        }
    }

    private function validarDatos($data)
    {
        return isset($data['cedula_remitente']) &&
            isset($data['nombre_remitente']) &&
            isset($data['telefono_remitente']) &&
            isset($data['direccion_remitente']) &&
            isset($data['sucursalPartida']) &&
            isset($data['sucursalLlegada']) &&
            isset($data['tipoEnvio']) &&
            isset($data['descripcion']) &&
            isset($data['cantidad']) &&
            isset($data['pesoPaquete']) &&  
            isset($data['tipoPaquete']);  
    }

    public function store()
    {
        // Leer el cuerpo de la solicitud y decodificar el JSON
        $data = json_decode(file_get_contents("php://input"), true);

        // Validar los datos mínimos necesarios
        if (!$this->validarDatos($data)) {
            http_response_code(400);
            echo json_encode(['error' => 'Datos incompletos o incorrectos'], JSON_PRETTY_PRINT);
            exit();
        }

        // Agregar el idUsuario al array de datos
        $data['idUsuario'] = $this->userId;

        // Llamar al método en el controlador
        $resultado = ControladorPaquetes::ctrCrearPaqueteAPI($data, $this->userId);

        // Responder según el resultado de la operación
        if ($resultado['status'] == 'ok') {
            echo json_encode([
                'message' => 'ok',
                'id' => $resultado['id'],
                'nro_registro' => $resultado['nro_registro'],
                'sucursalLlegada' => $resultado['sucursalLlegada'],
                'precio' => $resultado['precio'],
                'si lees esto' => 'sos gai'
            ], JSON_PRETTY_PRINT);  
        } else {
            http_response_code(500);
            echo json_encode(['error' => $resultado['message']], JSON_PRETTY_PRINT);  
        }
    }

    // Nuevo método para obtener envíos por usuario
    public function obtenerEnvios()
    {
        // Asegurarse de que el token ya haya sido validado en el constructor
        $idUsuario = $this->userId;

        // Obtener los envíos desde el controlador
        $envios = ControladorPaquetes::ctrObtenerEnviosPorUsuario($idUsuario);

        // Verificar si se encontraron envíos
        if ($envios) {
            echo json_encode($envios, JSON_PRETTY_PRINT);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'No se encontraron envíos para este usuario'], JSON_PRETTY_PRINT);
        }
    }
}
