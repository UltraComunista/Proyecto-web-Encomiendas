<?php

require_once "../controladores/sucursales.controlador.php";
require_once "../modelos/sucursal.modelo.php";

class AjaxValidaciones {

    /*=============================================
    VALIDAR NOMBRE DE SUCURSAL EXISTENTE
    =============================================*/    
    public $nombre;
    public $idSucursal;

    public function ajaxValidarNombreSucursal() {

        $item = "nombre";
        $valor = $this->nombre;

        $respuesta = ControladorSucursales::ctrMostrarSucursales($item, $valor);

        if (!empty($respuesta) && $respuesta["id"] != $this->idSucursal) {
            echo json_encode(['exists' => true, 'message' => 'El nombre de la sucursal ya existe.']);
        } else {
            echo json_encode(['exists' => false]);
        }
    }
}

/*=============================================
VALIDAR NOMBRE DE SUCURSAL EXISTENTE
=============================================*/
if(isset($_POST["nombre"])) {
    $validarNombre = new AjaxValidaciones();
    $validarNombre -> idSucursal = isset($_POST["idSucursal"]) ? $_POST["idSucursal"] : null;
    $validarNombre -> nombre = $_POST["nombre"];
    $validarNombre -> ajaxValidarNombreSucursal();
}
?>
