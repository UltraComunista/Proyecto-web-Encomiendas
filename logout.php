<?php

session_start();
$idUsuario = $_SESSION["id"];

// Actualizar el estado a "offline"
require_once "modelos/usuarios.modelo.php";
ModeloUsuarios::mdlActualizarEstadoUsuario($idUsuario, 0);

session_destroy();

echo '<script>
    window.location = "login";
</script>';
?>
