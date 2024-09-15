<?php

// 1. Configuración de la base de datos
require_once '../modelos/conexion.php';  // Ruta a tu archivo de conexión

// 2. Configuración de URLs y rutas
define('BASE_URL', '/Proyecto-web-Encomiendas/');
define('API_URL', BASE_URL . 'api/');

// 3. Configuración de la aplicación
define('APP_NAME', 'Sistema de Envíos');
define('APP_VERSION', '1.0.0');

// 4. Configuración de errores (para desarrollo)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// 5. Configuraciones adicionales
// Aquí podrías agregar configuraciones globales como claves de API, tokens, etc.
// Por ejemplo:
// define('JWT_SECRET', 'your_secret_key');

spl_autoload_register(function($class_name) {
    $file = "../modelos/" . strtolower($class_name) . ".modelo.php";
    if (file_exists($file)) {
        require_once $file;
    }
});


