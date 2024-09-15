<?php
// api/controladores/auth.controller.php
require_once __DIR__ . '/../../vendor/autoload.php';

use \Firebase\JWT\JWT;

class AuthController {
    private $key = "your_secret_key";  // Clave secreta para firmar el token

    public function login() {
        // Aquí deberías validar las credenciales del usuario
        $user = "usuarioEjemplo";  // Este es un ejemplo, normalmente validarías con la base de datos

        // Si las credenciales son correctas, generamos el token
        $payload = [
            'iss' => "http://localhost/Proyecto-web-Encomiendas",  // Emisor del token
            'aud' => "http://localhost/Proyecto-web-Encomiendas",  // Audiencia
            'iat' => time(),  // Tiempo en que el token es emitido
            'nbf' => time(),  // No se debe usar antes de este tiempo
            'exp' => time() + 3600,  // Expiración del token (1 hora en este caso)
            'data' => [
                'user' => $user,
            ]
        ];

        $jwt = JWT::encode($payload, $this->key, 'HS256');
        echo $jwt;
        echo json_encode([
            'message' => 'Inicio de sesión exitoso',
            'token' => $jwt
        ]);
        

    }
}
