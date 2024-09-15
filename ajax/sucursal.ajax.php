<?php

require_once "../controladores/sucursales.controlador.php";
require_once "../modelos/sucursal.modelo.php";

class AjaxUsuarios
{

	/*=============================================
	EDITAR USUARIO
	=============================================*/

	public $idSucursal;

	public function ajaxEditarSucursal()
	{

		$item = "id";
		$valor = $this->idSucursal;

		$respuesta = ControladorSucursales::ctrMostrarSucursales($item, $valor);

		echo json_encode($respuesta);
	}
	/*=============================================
	ACTIVAR USUARIO
	=============================================*/

	public $activarUsuario;
	public $activarId;


	public function ajaxActivarUsuario()
	{

		$tabla = "sucursal";

		$item1 = "estado";
		$valor1 = $this->activarUsuario;

		$item2 = "id";
		$valor2 = $this->activarId;

		$respuesta = ModeloSucursales::mdlActualizarSucurasl($tabla, $item1, $valor1, $item2, $valor2);
	}


}

/*=============================================
EDITAR USUARIO
=============================================*/
if (isset($_POST["idSucursal"])) {

	$editar = new AjaxUsuarios();
	$editar->idSucursal = $_POST["idSucursal"];
	$editar->ajaxEditarSucursal();
}
if (isset($_POST["departamento"]) && isset($_POST["provincia"])) {
    $departamento = $_POST["departamento"];
    $provincia = $_POST["provincia"];
    $sucursales = ControladorSucursales::ctrObtenerSucursales($departamento, $provincia);
    echo json_encode($sucursales);
}

