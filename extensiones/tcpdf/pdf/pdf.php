<?php

// Incluir los controladores y modelos necesarios
require_once('../../../controladores/usuarios.controlador.php');
require_once('../../../modelos/usuarios.modelo.php');

// Incluir la librería TCPDF
require_once('tcpdf_include.php');

// Crear un nuevo documento PDF
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Establecer las propiedades del documento
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Tu Nombre');
$pdf->SetTitle('Reporte de Usuarios');
$pdf->SetSubject('Reporte generado con TCPDF');
$pdf->SetKeywords('TCPDF, PDF, ejemplo, test, guía');

// Establecer las cabeceras y pie de página
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// Establecer el modo de subsetting de fuentes predeterminado
$pdf->setFontSubsetting(true);

// Establecer la fuente
$pdf->SetFont('dejavusans', '', 11, '', true);

// Añadir una página
$pdf->AddPage();

// Establecer el efecto de sombra de texto
$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

// Obtener los datos de todos los usuarios
$item = null;
$valor = null;
$usuarios = ControladorUsuarios::ctrMostrarUsuarios($item, $valor);

// Crear el contenido HTML para el PDF
$html = '
<h1>Reporte de Usuarios</h1>
<table border="1" cellpadding="5">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Cédula</th>
            <th>Usuario</th>
            <th>Perfil</th>
            <th>Última vez</th>
        </tr>
    </thead>
    <tbody>';

foreach ($usuarios as $usuario) {
    $html .= '<tr>
        <td>' . $usuario["id"] . '</td>
        <td>' . $usuario["nombre"] . '</td>
        <td>' . $usuario["apellido"] . '</td>
        <td>' . $usuario["cedula"] . '</td>
        <td>' . $usuario["usuario"] . '</td>
        <td>' . $usuario["perfil"] . '</td>
        <td>' . $usuario["ultimologin"] . '</td>
    </tr>';
}

$html .= '
    </tbody>
</table>';

// Escribir el contenido HTML en el PDF
$pdf->writeHTML($html, false, false, false, false, '');

// Cerrar y emitir el documento PDF
$pdf->Output('reporte_usuarios.pdf', 'I');

?>
