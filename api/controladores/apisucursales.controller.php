<?php

require_once __DIR__ . '/../../modelos/sucursal.modelo.php';

use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;
class ApiSucursalesController {
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
            // Verificar que el ID de usuario esté presente en el token
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
    public function index() {
        $sucursales = ModeloSucursales::mdlMostrarSucursales("sucursal", null, null);
        header('Content-Type: application/json');
        echo json_encode($sucursales, JSON_PRETTY_PRINT);
    }
}
