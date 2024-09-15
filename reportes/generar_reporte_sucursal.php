<?php
require_once '../vendor/autoload.php';
require_once('../modelos/paquetes.modelo.php');
require_once('../modelos/sucursal.modelo.php');

// Verificar si se recibió la sucursal y tipo de reporte
if (!isset($_POST['sucursalReporte']) || !isset($_POST['tipoReporte'])) {
    die('Error: Parámetros no válidos.');
}

$sucursalReporte = $_POST['sucursalReporte'];
$tipoReporte = $_POST['tipoReporte'];

// Obtener el usuario que generó el reporte
session_start();
$usuarioReporte =  $_SESSION['nombre'] . ' ' . $_SESSION['apellido']; // Asumiendo que el nombre de usuario se almacena en la sesión

// Obtener la fecha y hora actual
$fechaHoraReporte = date('Y-m-d H:i:s');

// Crear el objeto PDF en orientación horizontal (L para Landscape)
$pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Configuración del documento PDF
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('TuSistema');
$pdf->SetTitle('Reporte de Encomiendas por Sucursal');
$pdf->SetHeaderData('', 0, 'Reporte de Encomiendas por Sucursal', '');
$pdf->setHeaderFont([PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN]);
$pdf->setFooterFont([PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA]);

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
$pdf->Cell(0, 10, 'Reporte de Encomiendas por Sucursal', 0, 1, 'C', 0, '', 0, false, 'T', 'M');
$pdf->Ln(5);
// Mostrar la fecha, hora y usuario que generó el reporte
$pdf->SetFont('helvetica', '', 12);
$pdf->Cell(0, 10, "Generado por: $usuarioReporte el $fechaHoraReporte", 0, 1, 'C', 0, '', 0, false, 'T', 'M');
$pdf->Ln(10);



// Generar reporte según el tipo seleccionado
switch ($tipoReporte) {
    case 'realizados':
        $encomiendas = ModeloPaquetes::mdlMostrarEnviosRealizadosPorSucursal($sucursalReporte);
        $titulo = 'Envíos Realizados';
        break;
    case 'recibidos':
        $encomiendas = ModeloPaquetes::mdlMostrarEnviosRecibidosPorSucursal($sucursalReporte);
        $titulo = 'Encomiendas Recibidas';
        break;
    case 'entregados':
        $encomiendas = ModeloPaquetes::mdlMostrarEncomiendasEntregadasPorSucursal($sucursalReporte);
        $titulo = 'Encomiendas Entregadas';
        break;
    case 'pendientes':
        $encomiendas = ModeloPaquetes::mdlMostrarEncomiendasPendientesPorSucursal($sucursalReporte);
        $titulo = 'Encomiendas Pendientes';
        break;
    case 'generales':
        $encomiendas = ModeloPaquetes::mdlMostrarMovimientosGeneralesPorSucursal($sucursalReporte);
        $titulo = 'Movimientos Generales';
        break;
    default:
        die('Error: Tipo de reporte no válido.');
}

// Verificar si hay resultados
if (!$encomiendas) {
    $pdf->SetFont('helvetica', '', 12);
    $pdf->Cell(0, 10, "No se encontraron encomiendas para $titulo.", 0, 1, 'C', 0, '', 0, false, 'T', 'M');
} else {
    // Escribir la tabla de resultados
    $pdf->SetFont('helvetica', 'B', 12);

    // Ajustar columnas según el tipo de reporte
    $pdf->Cell(20, 10, 'Nro', 1);
    $pdf->Cell(45, 10, 'Fecha Recepción', 1);

    if ($tipoReporte == 'entregados' || $tipoReporte == 'generales') {
        $pdf->Cell(45, 10, 'Fecha Entrega', 1);
    }

    $pdf->Cell(50, 10, 'Destino/Origen', 1);
    $pdf->Cell(50, 10, 'Estado', 1);
    $pdf->Cell(50, 10, 'Usuario', 1);
    $pdf->Ln(10);

    $pdf->SetFont('helvetica', '', 12);
    foreach ($encomiendas as $encomienda) {
        // Determinar la fecha de recepción y entrega a mostrar
        $fechaRecepcion = $encomienda['FechaRecepcion'];
        $fechaEntrega = $encomienda['fechaEntrega'] ? $encomienda['fechaEntrega'] : 'No Entregado';

        // Determinar el estado del paquete
        switch ($encomienda['estadoPaquete']) {
            case 0:
                $estadoTexto = 'Recepcionado (Inicial)';
                $usuarioTexto = $encomienda['nombreUsuario']; // Usuario que registró el envío
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
                $usuarioTexto = $encomienda['nombreUsuario']; // Usuario que entregó el paquete
                $fechaEntrega = $encomienda['fechaEntrega']; // Fecha en que se entregó el paquete
                break;
            default:
                $estadoTexto = 'Desconocido';
                $usuarioTexto = 'N/A';
                break;
        }

        // Imprimir datos en las columnas ajustadas
        $pdf->Cell(20, 10, $encomienda['nro_registro'], 1);
        $pdf->Cell(45, 10, $fechaRecepcion, 1);

        if ($tipoReporte == 'entregados' || $tipoReporte == 'generales') {
            $pdf->Cell(45, 10, $fechaEntrega, 1);
        }

        $pdf->Cell(50, 10, $encomienda['nombreSucursal'], 1);
        $pdf->Cell(50, 10, $estadoTexto, 1);
        $pdf->Cell(50, 10, $usuarioTexto, 1);
        $pdf->Ln(10);
    }
}

// Cerrar y generar el PDF
ob_clean(); // Limpiar el búfer de salida
$pdf->Output("reporte_encomiendas_sucursal_$titulo.pdf", 'I');
