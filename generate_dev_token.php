<?php
require 'vendor/autoload.php';  // Asegúrate de tener instalada la librería JWT de Firebase

use \Firebase\JWT\JWT;

$key = "your_secret_key";  // Clave secreta para firmar el token

$payload = [
    'iss' => "http://localhost/Proyecto-web-Encomiendas",  // Emisor del token
    'aud' => "http://localhost/Proyecto-web-Encomiendas",  // Audiencia
    'iat' => time(),  // Tiempo en que el token es emitido
    'nbf' => time(),  // No se debe usar antes de este tiempo
    'exp' => time() + (60*60*24*365*10),  // Expiración del token (10 años en este caso)
    'data' => [
        'role' => 'developer',  // Puedes agregar más datos aquí si lo deseas
        'user' => 'developer',
    ]
];

$jwt = JWT::encode($payload, $key, 'HS256');

echo "Token de desarrollador: " . $jwt;
