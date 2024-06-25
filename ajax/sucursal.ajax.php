<?php

require_once "../controladores/sucursales.controlador.php";
require_once "../modelos/sucursal.modelo.php";

class AjaxUsuarios{

	/*=============================================
	EDITAR USUARIO
	=============================================*/	

	public $idSucursal;

	public function ajaxEditarSucursal(){

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


	public function ajaxActivarUsuario(){

		$tabla = "sucursal";

		$item1 = "estado";
		$valor1 = $this->activarUsuario;

		$item2 = "id";
		$valor2 = $this->activarId;

		$respuesta = ModeloSucursales::mdlActualizarSucurasl($tabla, $item1, $valor1, $item2, $valor2);

	}

	/*=============================================
	VALIDAR NO REPETIR USUARIO
	=============================================*/	

	public $validarUsuario;

	public function ajaxValidarUsuario(){

		$item = "usuario";
		$valor = $this->validarUsuario;

		$respuesta = ControladorUsuarios::ctrMostrarUsuarios($item, $valor);

		echo json_encode($respuesta);

	}
}

/*=============================================
EDITAR USUARIO
=============================================*/
if(isset($_POST["idSucursal"])){

	$editar = new AjaxUsuarios();
	$editar -> idSucursal = $_POST["idSucursal"];
	$editar -> ajaxEditarSucursal();

}

/*=============================================
ACTIVAR USUARIO
=============================================*/	

if(isset($_POST["activarUsuario"])){

	$activarUsuario = new AjaxUsuarios();
	$activarUsuario -> activarUsuario = $_POST["activarUsuario"];
	$activarUsuario -> activarId = $_POST["activarId"];
	$activarUsuario -> ajaxActivarUsuario();

}

/*=============================================
VALIDAR NO REPETIR USUARIO
=============================================*/

if(isset( $_POST["validarUsuario"])){

	$valUsuario = new AjaxUsuarios();
	$valUsuario -> validarUsuario = $_POST["validarUsuario"];
	$valUsuario -> ajaxValidarUsuario();

}


if(isset($_POST["departamento"])){
    $departamento = $_POST["departamento"];
    $provincias = ControladorSucursales::ctrMostrarProvinciasPorDepartamento($departamento);
    echo json_encode($provincias);
} elseif (isset($_POST["provincia"])) {
    $provincia = $_POST["provincia"];
    $sucursales = ControladorSucursales::ctrMostrarSucursalesPorProvincia($provincia);
    echo json_encode($sucursales);
}
