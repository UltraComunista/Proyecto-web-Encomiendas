<?php

require_once "../controladores/cliente.controlador.php";
require_once "../modelos/cliente.modelo.php";

class AjaxClientes {
    
    public $idCliente;

    public function ajaxEditarCliente() {
        $item = "id";
        $valor = $this->idCliente;

        $respuesta = ControladorClientes::ctrMostrarClientes($item, $valor);

        echo json_encode($respuesta);
    }
    public $cedula;
    public $tipo;

    public function ajaxBuscarCliente() {
        $item = "cedula";
        $valor = $this->cedula;
        $respuesta = ControladorClientes::ctrMostrarClientePorId($item, $valor);

        if ($respuesta) {
            echo json_encode(["existe" => true, "cliente" => $respuesta]);
        } else {
            echo json_encode(["existe" => false]);
        }
    }
}

// Buscar cliente
if (isset($_POST["cedula"])) {
    $buscar = new AjaxClientes();
    $buscar->cedula = $_POST["cedula"];
    $buscar->tipo = $_POST["tipo"]; // tipo 1 para remitente, tipo 2 para destinatario
    $buscar->ajaxBuscarCliente();
}
if (isset($_POST["idCliente"])) {
    $editar = new AjaxClientes();
    $editar->idCliente = $_POST["idCliente"];
    $editar->ajaxEditarCliente();
}



