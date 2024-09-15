<?php

require_once '../modelos/paquetes.modelo.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $transactionId = $_GET['transaction_id'];
    $status = $_GET['status'];
    $amount = $_GET['checkout_amount'] ?? null; // Agregado como ejemplo
    $currency = $_GET['checkout_currency'] ?? null; // Agregado como ejemplo

    if ($status == 'success') {
        // Validar el transaction_id y otros parámetros si es necesario
        if ($transactionId && $amount && $currency) {
            $tabla = "recepcionencomienda";
            $respuesta = ModeloPaquetes::mdlActualizarEstadoPago($tabla, $transactionId, 1);

            if ($respuesta == "ok") {
                echo "Pago confirmado y paquete actualizado.";
            } else {
                error_log("Error al actualizar el paquete con transaction_id: $transactionId");
                echo "Error al actualizar el paquete.";
            }
        } else {
            error_log("Callback recibido con parámetros faltantes. transaction_id: $transactionId, amount: $amount, currency: $currency");
            echo "Parámetros faltantes en el callback.";
        }
    } else {
        error_log("Pago no realizado o fallido para transaction_id: $transactionId");
        echo "Pago no realizado o fallido.";
    }
}
