<?php
require_once "controladores/paquetes.controlador.php";
require_once "modelos/paquetes.modelo.php";

// Suprime errores y advertencias para la producción
error_reporting(0);
ini_set('display_errors', 0);

// Función para obtener los parámetros de la URL
function getParam($name) {
    return $_GET[$name] ?? $_GET['amp;' . $name] ?? null;
}

// Obtener los parámetros de la URL
$transaction_id = getParam('transaction_id');
$status = getParam('status');
$amount = getParam('checkout_amount');
$currency = getParam('checkout_currency');
$idPaquete = getParam('idPaquete');

// Si el pago es exitoso, actualiza el estado del paquete
if ($status === 'success' && $idPaquete) {
    $estadoPago = '1';  // Asumimos que '1' significa 'Pagado'
    $estadoPaquete = '3';

    // Obtener el ID del usuario actual desde la sesión
    session_start();
    $idUsuario = $_SESSION['idUsuario'];

    // Actualizar el estado del paquete en la base de datos
    $datos = array(
        "id" => $idPaquete,
        "estadoPaquete" => $estadoPaquete,
        "estadoPago" => $estadoPago,
        "idUsuario" => $idUsuario
    );

    $respuesta = ControladorPaquetes::ctrActualizarPaquete($datos);

    // Redirigir a listaenvios con un parámetro indicando que el pago fue exitoso
    header("Location: listaenvios?pagado=success");
    exit();
} else {
    // Si algo falla, redirigir a listaenvios con un mensaje de error
    header("Location: listaenvios?pagado=error");
    exit();
}
