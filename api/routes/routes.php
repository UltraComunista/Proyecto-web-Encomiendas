<?php
// api/routes/routes.php

require_once __DIR__ . '/../controladores/apienvios.controller.php';
require_once __DIR__ . '/../controladores/auth.controller.php';
require_once __DIR__ . '/../controladores/apisucursales.controller.php';


class ApiRouter {
    private $routes = [
        'POST' => [
            '/api/login' => 'AuthController@login',  // Ruta para obtener el token
            '/api/envios' => 'ApiEnviosController@store',  // Ruta protegida
        ],
        'GET' => [
            '/api/sucursales' => 'ApiSucursalesController@index',  // Nueva ruta para listar sucursales
            '/api/envios' => 'ApiEnviosController@obtenerEnvios',  // Nueva ruta para obtener los envíos de un usuario

        ],
        // Otras rutas...
    ];

    public function handle($uri, $method) {
        $base_url = '/Proyecto-web-Encomiendas';
        $route = str_replace($base_url, '', parse_url($uri, PHP_URL_PATH));

        error_log("Ruta solicitada después de ajuste: " . $route);

        if (isset($this->routes[$method][$route])) {
            $controllerAction = $this->routes[$method][$route];
            [$controller, $action] = explode('@', $controllerAction);
            $controllerInstance = new $controller();
            $controllerInstance->$action();
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Ruta no encontrada']);
        }
    }
}
