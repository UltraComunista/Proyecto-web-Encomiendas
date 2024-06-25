<?php
ob_start();
require_once('tcpdf_include.php');
require_once('../../../modelos/usuarios.modelo.php');
require_once('../../../controladores/usuarios.controlador.php');

// Crear un nuevo documento PDF
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Establecer las propiedades del documento
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Tu Nombre');
$pdf->SetTitle('Reporte de Usuarios');
$pdf->SetSubject('Reporte de Usuarios');
$pdf->SetKeywords('TCPDF, PDF, reporte, usuarios');

// Establecer las cabeceras y pie de página
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// Establecer el modo de subsetting de fuentes predeterminado
$pdf->setFontSubsetting(true);

// Establecer la fuente
$pdf->SetFont('dejavusans', '', 11, '', true);

// Añadir una página
$pdf->AddPage();

// Obtener la fecha y hora actual
$fechaActual = date('d-m-Y H:i:s');

// Establecer el contenido HTML
$html = <<<EOF
<style>
    h1 {
        color: navy;
        font-family: times;
        font-size: 24pt;
        text-align: center;
    }
    .header {
        font-size: 12pt;
        text-align: center;
    }
    .subheader {
        font-size: 10pt;
        text-align: center;
    }
    .tabla {
        border-collapse: collapse;
        width: 100%;
        margin-top: 20px;
    }
    .tabla th {
        background-color: #4CAF50;
        color: white;
        text-align: center;
        padding: 8px;
    }
    .tabla td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: center;
    }
    .tabla tr:nth-child(even) {
        background-color: #f2f2f2;
    }
</style>
<div class="subheader">
    <h1>Reporte de Usuarios</h1>
    <p>Generado el: $fechaActual</p>
</div>
<table class="tabla">
    <thead>
        <tr>
            <th>Nro.</th>
            <th>CI</th>
            <th>Usuario</th>
            <th>Nombre</th>
        </tr>
    </thead>
    <tbody>
EOF;

// Obtener datos de usuarios
$item = null;
$valor = null;
$usuarios = ControladorUsuarios::ctrMostrarUsuarios($item, $valor);
$contador = 1;

foreach ($usuarios as $key => $value) {
    $html .= '<tr>';
    $html .= '<td>' . $contador . '</td>';
    $html .= '<td>' . $value["cedula"] . '</td>';
    $html .= '<td>' . $value["usuario"] . '</td>';
    $html .= '<td>' . $value["nombre"] . ' ' . $value["apellido"] . '</td>';    
    $html .= '</tr>';
    $contador++;
}

$html .= <<<EOF
    </tbody>
</table>
EOF;

// Escribir el contenido HTML en el PDF
$pdf->writeHTML($html, true, false, true, false, '');

// Cerrar y emitir el documento PDF
ob_end_clean();
$pdf->Output('reporte_usuarios.pdf', 'I');
?>
