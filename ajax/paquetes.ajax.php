<?php

require_once "../controladores/paquetes.controlador.php";
require_once "../modelos/paquetes.modelo.php";

// Iniciar la sesión si no se ha iniciado aún
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_POST['action'])) {
    $action = $_POST['action'];

    if ($action == 'get') {
        $idPaquete = $_POST['idPaquete'];
        $item = 'id';
        $valor = $idPaquete;
        $respuesta = ControladorPaquetes::ctrMostrarPaquetes($item, $valor);
        echo json_encode($respuesta);
    }

    if ($action == 'updateStatus') {
        $idPaquete = $_POST['idPaquete'];
        $estadoPaquete = $_POST['estadoPaquete'];
        $estadoPago = $_POST['estadoPago'];
        $idUsuario = $_SESSION['idUsuario']; // Obtén el idUsuario de la sesión


        $datos = array(
            "id" => $idPaquete,
            "estadoPaquete" => $estadoPaquete,  // Asegúrate de que este campo esté en el array
            "estadoPago" => $estadoPago,
            "idUsuario" => $idUsuario
        );

        $respuesta = ControladorPaquetes::ctrActualizarPaquete($datos);

        // Imprimir respuesta para depuración
        error_log("Respuesta del servidor: {$respuesta}");

        echo $respuesta;
    }

    if ($action == 'createOrder') {
        $idPaquete = $_POST['idPaquete'];

        // Obtener datos del paquete
        $item = 'id';
        $valor = $idPaquete;
        $paquete = ControladorPaquetes::ctrMostrarPaquetes($item, $valor);

        if ($paquete) {
            // Configuración de la orden
            $appkey = "Vm0xMFlWbFdWWGxVYmtwT1ZucFdVbFpyVWtKUFVUMDk=-KGUWK";
            $callback_url = "https://proyecto-web.com/Proyecto-web-Encomiendas/callback.php";
            $return_url = "https://proyecto-web.com/Proyecto-web-Encomiendas/pagoexitoso.php?status=success&idPaquete={$idPaquete}";

            $data = [
                "appkey" => $appkey,
                "currency_code" => "BOB",
                "payment_type" => "REDIRECT",
                "payment_method" => "ALL",
                "items" => [
                    [
                        "name" => "Rastreo: " . $paquete['nro_registro'],
                        "quantity" => $paquete['cantidad'],
                        "price" => $paquete['precio']
                    ]
                ],
                "callback_url" => $callback_url,
                "customer_email" => "cliente@correo.com",
                "customer_first_name" => "Nombre",
                "customer_last_name" => "Apellido",
                "detail" => $paquete['descripcion'],
                "return_url" => $return_url
            ];

            // Convertir los datos a formato JSON
            $jsonData = json_encode($data);

            // URL del endpoint de Qhantuy Checkout
            $url = "https://testingcheckout.qhantuy.com/external-api/checkout";

            // Iniciar cURL
            $ch = curl_init($url);

            // Configurar cURL
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'X-API-Token: ' . $appkey
            ]);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);

            // Ejecutar la solicitud
            $response = curl_exec($ch);

            // Verificar si hubo errores
            if (curl_errno($ch)) {
                error_log("Error de cURL: " . curl_error($ch));
                echo json_encode(['error' => curl_error($ch)]);
            } else {
                error_log("Respuesta de la API: " . $response);
                $responseData = json_decode($response, true);

                // Verificar si la respuesta tiene el payment_url
                if (isset($responseData['payment_url'])) {
                    echo json_encode(['payment_url' => $responseData['payment_url']]);
                } else {
                    echo json_encode(['error' => 'No se pudo generar el enlace de pago']);
                }
            }

            // Cerrar cURL
            curl_close($ch);
        } else {
            echo json_encode(['error' => 'Paquete no encontrado']);
        }
    }

    if ($action == 'checkPaymentStatus') {
        $idPaquete = $_POST['idPaquete'];

        // Aquí debes implementar la lógica para chequear el estado del pago
        // Esto podría implicar una consulta a tu base de datos o una API externa

        $estadoPago = ControladorPaquetes::ctrVerificarEstadoPago($idPaquete);

        if ($estadoPago == 'success') {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'failed']);
        }
    }

    // Nueva acción para crear un paquete
    if ($action == 'createPaquete') {
        // Llama a la función del controlador que maneja la creación del paquete
        $respuesta = ControladorPaquetes::ctrCrearPaquete();

        // Devuelve la respuesta en formato JSON
        echo json_encode(['status' => $respuesta ? 'ok' : 'error']);
    }
}
