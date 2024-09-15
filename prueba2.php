<?php

// Clave secreta del JWT
$jwt_key = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0L1Byb3llY3RvLXdlYi1FbmNvbWllbmRhcyIsImF1ZCI6Imh0dHA6Ly9sb2NhbGhvc3QvUHJveWVjdG8td2ViLUVuY29taWVuZGFzIiwiaWF0IjoxNzI0MTk4Nzg0LCJuYmYiOjE3MjQxOTg3ODQsImRhdGEiOnsiaWRVc3VhcmlvIjo2LCJ1c3VhcmlvIjoiYWNyaXMiLCJwZXJmaWwiOiJlbXByZXNhIn19.4q28eHicNDjw9tH53OJ1qOpu84CHtjKvS4fQEDS8Plo';

// URL de la API para obtener las sucursales
$url = 'https://proyecto-web.com/Proyecto-web-Encomiendas/api/sucursales';

// Inicializar cURL
$ch = curl_init($url);

// Configurar opciones de cURL
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  // Para obtener la respuesta como string
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer ' . $jwt_key,  // Usar la variable $jwt_key para la autorización
    'Content-Type: application/json'
]);
curl_setopt($ch, CURLOPT_HTTPGET, true);  // Especificar que se trata de una solicitud GET

// Ejecutar la solicitud
$response = curl_exec($ch);

// Verificar si hubo errores
if (curl_errno($ch)) {
    echo 'Error en cURL: ' . curl_error($ch);
} else {
    // Mostrar la respuesta de la API
    echo 'Respuesta de la API: ' . $response;
}

// Cerrar cURL
curl_close($ch);
