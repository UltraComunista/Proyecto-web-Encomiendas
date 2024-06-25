<?php
require_once "controladores/controlador.plantilla.php";
require_once "controladores/usuarios.controlador.php";
require_once "controladores/sucursales.controlador.php";
require_once "controladores/remitente.controlador.php";
require_once "controladores/destinatario.controlador.php";
require_once "controladores/paquetes.controlador.php";



require_once "modelos/sucursal.modelo.php";
require_once "modelos/remitente.modelo.php";
require_once "modelos/paquetes.modelo.php";
require_once "modelos/destinatario.modelo.php";
require_once "modelos/usuarios.modelo.php";

$plantilla = new ControladorPlantilla();
$plantilla->ctrControlador();
