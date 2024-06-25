<?php

require_once "../controladores/usuarios.controlador.php";
require_once "../modelos/usuarios.modelo.php";

class AjaxValidacionesUsuarios {

    /*=============================================
    VALIDAR USUARIO EXISTENTE
    =============================================*/    
    public $validarUsuario;

    public function ajaxValidarUsuario() {
        $item = "usuario";
        $valor = $this->validarUsuario;

        $respuesta = ControladorUsuarios::ctrMostrarUsuarios($item, $valor);

        echo json_encode($respuesta);
    }
}

/*=============================================
VALIDAR USUARIO EXISTENTE
=============================================*/
if(isset($_POST["validarUsuario"])) {
    $valUsuario = new AjaxValidacionesUsuarios();
    $valUsuario -> validarUsuario = $_POST["validarUsuario"];
    $valUsuario -> ajaxValidarUsuario();
}
?>
