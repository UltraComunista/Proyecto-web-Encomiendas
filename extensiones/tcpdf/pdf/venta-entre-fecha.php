<?php

require_once "../../../controladores/ventas.controlador.php";
require_once "../../../modelos/ventas.modelo.php";

require_once "../../../controladores/clientes.controlador.php";
require_once "../../../modelos/clientes.modelo.php";

require_once "../../../controladores/usuarios.controlador.php";
require_once "../../../modelos/usuarios.modelo.php";

require_once "../../../controladores/productos.controlador.php";
require_once "../../../modelos/productos.modelo.php";

class ReporteVentaFecha{

public $fechainicio;
public $fechafin;

public function traerReporteVentaFecha(){

$fechainicio = $this->fechainicio;
$fechafin = $this->fechafin;
//TRAEMOS LA INFORMACIÓN DE LA VENTA


require_once('tcpdf_include.php');

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->startPageGroup();

$pdf->AddPage();

// ---------------------------------------------------------

$bloque1 = <<<EOF

	<table>
		
		<tr>
			
			<td style="width:150px"><img src="images/logo-negro-bloque.png"></td>

			<td style="background-color:white; width:140px">
				
				<div style="font-size:8.5px; text-align:right; line-height:15px;">
					
					<br>
					NIT: 71.759.963-9

					<br>
					Dirección: Calle 44B 92-11

				</div>

			</td>

			<td style="background-color:white; width:140px">

				<div style="font-size:8.5px; text-align:right; line-height:15px;">
					
					<br>
					Teléfono: 300 786 52 49
					
					<br>
					ventas@inventorysystem.com

				</div>
				
			</td>

	
		</tr>

	</table>

EOF;

$pdf->writeHTML($bloque1, false, false, false, false, '');

$bloque2 = <<<EOF

  <table style="font-size:10px; padding:5px 10px;">

		<tr>
		
		<td style=" background-color:white; width:300px; text-align:right"> Fecha desde $fechainicio  </td>
		<td style=" background-color:white; width:300px; text-align:left"> Hasta $fechafin </td>
		</tr>

	</table>

EOF;
$pdf->writeHTML($bloque2, false, false, false, false, '');



$bloque3 = <<<EOF

	<table style="font-size:10px; padding:5px 10px;">

		<tr>
		
		<td style="border: 1px solid #666; background-color:white; width:100px; text-align:center"> Código </td>
		<td style="border: 1px solid #666; background-color:white; width:100x; text-align:center"> Fecha </td>
		<td style="border: 1px solid #666; background-color:white; width:100px; text-align:center"> Total </td>
		<td style="border: 1px solid #666; background-color:white; width:100px; text-align:center"> Cliente </td>
		<td style="border: 1px solid #666; background-color:white; width:100px; text-align:center"> Vendedor </td>
		</tr>

	</table>

EOF;

$pdf->writeHTML($bloque3, false, false, false, false, '');

$respuesta = ControladorVentas::ctrEntreFechasVentas($fechainicio, $fechafin);

for($i = 0; $i < count($respuesta); $i++){

	$codigo = $respuesta[$i]["codigo"];

	$fecha = $respuesta[$i]["fecha"];

	$total = $respuesta[$i]["total"];

	$cliente = $respuesta[$i]["cliente"];

	$usuario = $respuesta[$i]["usuario"];

$bloque4 = <<<EOF

	<table style="font-size:10px; padding:5px 10px;">

		<tr>
			
			<td style="border: 1px solid #666; color:#333; background-color:white; width:100px; text-align:center">
		      $codigo
			</td>

			<td style="border: 1px solid #666; color:#333; background-color:white; width:100px; text-align:center">
			  $fecha
			</td>

			<td style="border: 1px solid #666; color:#333; background-color:white; width:100px; text-align:center">$ 
				$total
			</td>

			<td style="border: 1px solid #666; color:#333; background-color:white; width:100px; text-align:center">$ 
				$cliente
			</td>

			<td style="border: 1px solid #666; color:#333; background-color:white; width:100px; text-align:center">$ 
				$usuario
			</td>

		</tr>

	</table>


EOF;

$pdf->writeHTML($bloque4, false, false, false, false, '');
}


$pdf->Output('venta-entre-fecha.pdf', 'D');

}

}


$factura = new ReporteVentaFecha();
$factura -> fechainicio = $_GET["fechainicio"];
$factura -> fechafin = $_GET["fechafin"];
$factura -> traerReporteVentaFecha();

?>