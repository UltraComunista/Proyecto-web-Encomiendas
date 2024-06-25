<?php

require_once "../controladores/destinatario.controlador.php";
require_once "../modelos/destinatario.modelo.php";

class AjaxDestinatarios
{
    public $idDestinatario;

    public function ajaxEditarDestinatario()
    {
        $item = "id";
        $valor = $this->idDestinatario;
        $respuesta = ControladorDestinatarios::ctrMostrarDestinatarios($item, $valor);
        echo json_encode($respuesta);
    }
}

if (isset($_POST["idDestinatario"])) {
    $editar = new AjaxDestinatarios();
    $editar->idDestinatario = $_POST["idDestinatario"];
    $editar->ajaxEditarDestinatario();
}
?>
