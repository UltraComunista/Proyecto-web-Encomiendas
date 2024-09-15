<?php
session_start();
require_once "controladores/usuarios.controlador.php";

// Llama al método de cierre de sesión
ControladorUsuarios::ctrLogoutUsuario();
?>
