<?php
require_once "../controladores/remitente.controlador.php";
require_once "../modelos/remitente.modelo.php";
require_once "../controladores/destinatario.controlador.php";
require_once "../modelos/destinatario.modelo.php";

if (isset($_POST['cedula'])) {
    $cedula = $_POST['cedula'];
    $tipo = $_POST['tipo'];  // remitente o destinatario

    if ($tipo == "remitente") {
        $cliente = ControladorRemitente::ctrMostrarRemitentePorCedula($cedula);
    } else {
        $cliente = ControladorDestinatarios::ctrMostrarDestinatarioPorCedula($cedula);
    }

    echo json_encode($cliente);
}
?>
