<?php
error_reporting(0); // Desactivar la visualización de errores para evitar problemas en la salida del PDF
ini_set('display_errors', 0);

require_once '../vendor/autoload.php';
require_once('../modelos/paquetes.modelo.php');
require_once('../modelos/usuarios.modelo.php');

// Verificar si se recibió el estado del paquete
if (!isset($_POST['estadoPaquete'])) {
    die('Error: estadoPaquete no está definido.');
}

$estadoPaquete = $_POST['estadoPaquete'];

// Crear el objeto PDF en orientación horizontal (L para Landscape)
$pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Configuración del documento PDF
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('TuSistema');
$pdf->SetTitle('Reporte de Encomiendas por Estado');
$pdf->SetHeaderData('', 0, 'Reporte de Encomiendas por Estado', '');
$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// Configuraciones adicionales
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// Agregar una página
$pdf->AddPage();

// Título del reporte
$pdf->SetFont('helvetica', 'B', 16);
$pdf->Cell(0, 10, 'Reporte de Encomiendas por Estado', 0, 1, 'C', 0, '', 0, false, 'T', 'M');
$pdf->Ln(10);

// Obtener las encomiendas por estado
$envios = ModeloPaquetes::mdlMostrarEnviosPorEstado($estadoPaquete);

// Código que genera el PDF
if (!$envios) {
    $pdf->SetFont('helvetica', '', 12);
    $pdf->Cell(0, 10, 'No se encontraron encomiendas para este estado.', 0, 1, 'C', 0, '', 0, false, 'T', 'M');
} else {
    // Escribir la tabla de envíos
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->Cell(30, 10, 'Nro Registro', 1);
    $pdf->Cell(50, 10, 'Fecha Recepción', 1);
    $pdf->Cell(50, 10, 'Destino', 1);
    $pdf->Cell(50, 10, 'Estado', 1);
    $pdf->Cell(50, 10, 'Usuario', 1); // Nueva columna para mostrar el usuario
    $pdf->Cell(42, 10, 'Fecha Entrega', 1); // Nueva columna para mostrar la fecha de entrega
    $pdf->Ln(10);

    $pdf->SetFont('helvetica', '', 12);
    foreach ($envios as $envio) {
        $estadoTexto = ''; // Variable para el texto del estado
        $usuarioTexto = ''; // Variable para el texto del usuario
        $fechaEntrega = 'N/A'; // Variable para la fecha de entrega

        // Condicionales para determinar el estado y usuario correspondiente
        switch ($envio['estadoPaquete']) {
            case 0:
                $estadoTexto = 'Recepcionado (Inicial)';
                $usuarioTexto = $envio['nombreUsuario']; // Usuario que registró el envío
                break;
            case 1:
                $estadoTexto = 'En Camino';
                $usuarioTexto = 'N/A';
                break;
            case 2:
                $estadoTexto = 'Recepcionado (Destino)';
                $usuarioTexto = 'N/A';
                break;
            case 3:
                $estadoTexto = 'Entregado';
                $usuarioTexto = $envio['nombreUsuario']; // Usuario que entregó el paquete
                $fechaEntrega = $envio['fechaEntrega']; // Fecha en que se entregó el paquete
                break;
            default:
                $estadoTexto = 'Desconocido';
                $usuarioTexto = 'N/A';
                break;
        }

        $pdf->Cell(30, 10, $envio['nro_registro'], 1);
        $pdf->Cell(50, 10, $envio['FechaRecepcion'], 1);
        $pdf->Cell(50, 10, $envio['nombreSucursal'], 1);
        $pdf->Cell(50, 10, $estadoTexto, 1); // Usar el texto del estado
        $pdf->Cell(50, 10, $usuarioTexto, 1); // Mostrar el nombre del usuario
        $pdf->Cell(42, 10, $fechaEntrega, 1); // Mostrar la fecha de entrega
        $pdf->Ln(10);
    }
}


// Cerrar y generar el PDF
ob_clean(); // Limpiar el búfer de salida
$pdf->Output('reporte_encomiendas_estado.pdf', 'I');
