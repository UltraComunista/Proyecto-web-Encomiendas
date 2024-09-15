<?php

// Clave secreta del JWT
$jwt_key = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0L1Byb3llY3RvLXdlYi1FbmNvbWllbmRhcyIsImF1ZCI6Imh0dHA6Ly9sb2NhbGhvc3QvUHJveWVjdG8td2ViLUVuY29taWVuZGFzIiwiaWF0IjoxNzI0Nzc1NDE1LCJuYmYiOjE3MjQ3NzU0MTUsImRhdGEiOnsiaWRVc3VhcmlvIjoxMywidXN1YXJpbyI6ImF1dG9jcmlzIiwicGVyZmlsIjoiZW1wcmVzYSJ9fQ.WHg7qdzhK5Hzt0ugwUBjiWH4XeXPvRUILDEDpT_iBzs';

// URL de la API
$url = 'https://proyecto-web.com/Proyecto-web-Encomiendas/api/envios';

// Datos a enviar en la solicitud POST
$data = [
    "cedula_remitente" => "4097516",
    "nombre_remitente" => "Jonny Lapongo",
    "telefono_remitente" => "70984905",
    "direccion_remitente" => "Calle xd",
    "sucursalPartida" => 1,
    "sucursalLlegada" => 6,
    "tipoEnvio" => 1,
    "descripcion" => "Paquete con productos",
    "cantidad" => 2,
    "pesoPaquete" => 1, 
    "tipoPaquete" => 5
];

// Convertimos los datos a JSON
$data_json = json_encode($data);

// Inicializar cURL
$ch = curl_init($url);

// Configurar opciones de cURL
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  // Para obtener la respuesta como string
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer ' . $jwt_key,
    'Content-Type: application/json'
]);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);

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
