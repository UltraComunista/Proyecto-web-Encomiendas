<?php


require_once "../controladores/sucursales.controlador.php";
require_once "../modelos/sucursal.modelo.php";

if (isset($_GET['action'])) {
    $action = $_GET['action'];
    if ($action == 'obtenerProvincias') {
        ControladorSucursales::ctrObtenerProvincias();
    } elseif ($action == 'obtenerSucursales') {
        ControladorSucursales::ctrObtenerSucursales();
    }
}
