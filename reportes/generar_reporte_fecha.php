<?php
ob_start();

require_once '../vendor/autoload.php';
require_once('../modelos/paquetes.modelo.php');
require_once('../modelos/usuarios.modelo.php');

// Verificar si se recibieron las fechas
if (!isset($_POST['fechaInicio']) || !isset($_POST['fechaFin'])) {
    die('Error: Parámetros no válidos.');
}

$fechaInicio = $_POST['fechaInicio'];
$fechaFin = $_POST['fechaFin'];

// Iniciar sesión para obtener el usuario que está generando el reporte
session_start();
if (!isset($_SESSION['idUsuario'])) {
    die('Error: No se ha iniciado sesión.');
}
$idUsuario = $_SESSION['idUsuario'];

// Obtener los datos del usuario que está generando el reporte
$tabla = "usuario";
$usuario = ModeloUsuarios::mdlMostrarUsuarios($tabla, "id", $idUsuario);

if (!$usuario) {
    die('Error: Usuario no encontrado.');
}

// Obtener las entregas por fecha
$entregas = ModeloPaquetes::mdlMostrarEntregasPorFecha($fechaInicio, $fechaFin);

if (!$entregas) {
    $entregas = []; // Asegurar que $entregas sea un array, incluso si no se encuentran resultados
}

// Crear el objeto PDF en orientación horizontal
$pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Configuración del documento PDF
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor($usuario['nombre'] . ' ' . $usuario['apellido']); // Usuario que está haciendo el reporte
$pdf->SetTitle('Reporte de Entregas por Fecha');
$pdf->SetHeaderData('', 0, 'Reporte de Entregas por Fecha', '');
$pdf->setHeaderFont([PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN]);
$pdf->setFooterFont([PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA]);

// Configuraciones adicionales
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
$pdf->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// Agregar una página
$pdf->AddPage();

// Título del reporte
$pdf->SetFont('helvetica', 'B', 16);
$pdf->Cell(0, 10, 'Reporte de Entregas por Fecha', 0, 1, 'C');
$pdf->Ln(10);

// Escribir la información del usuario que está generando el reporte
$pdf->SetFont('helvetica', '', 12);
$pdf->Cell(0, 10, 'Reporte generado por: ' . $usuario['nombre'] . ' ' . $usuario['apellido'], 0, 1);
$pdf->Ln(5);

// Escribir la tabla de entregas
if (empty($entregas)) {
    $pdf->Cell(0, 10, 'No se encontraron entregas en el rango de fechas seleccionado.', 0, 1);
} else {
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->Cell(30, 10, 'Nro Registro', 1);
    $pdf->Cell(50, 10, 'Fecha Recepción', 1);
    $pdf->Cell(50, 10, 'Fecha Entrega', 1);
    $pdf->Cell(50, 10, 'Destino', 1);
    $pdf->Cell(50, 10, 'Estado', 1);
    $pdf->Cell(50, 10, 'Usuario', 1);
    $pdf->Ln(10);

    $pdf->SetFont('helvetica', '', 12);
    foreach ($entregas as $entrega) {
        $estadoTexto = '';
        switch ($entrega['estadoPaquete']) {
            case 0:
                $estadoTexto = 'Recepcionado (Inicial)';
                break;
            case 1:
                $estadoTexto = 'En Camino';
                break;
            case 2:
                $estadoTexto = 'Recepcionado (Destino)';
                break;
            case 3:
                $estadoTexto = 'Entregado';
                break;
            default:
                $estadoTexto = 'Desconocido';
                break;
        }

        $pdf->Cell(30, 10, $entrega['nro_registro'], 1);
        $pdf->Cell(50, 10, $entrega['FechaRecepcion'], 1);
        $pdf->Cell(50, 10, $entrega['fechaEntrega'], 1);
        $pdf->Cell(50, 10, $entrega['nombreSucursal'], 1);
        $pdf->Cell(50, 10, $estadoTexto, 1);
        $pdf->Cell(50, 10, $entrega['nombreUsuario'], 1);
        $pdf->Ln(10);
    }
}

// Cerrar y generar el PDF
ob_end_clean(); // Limpiar el búfer de salida
$pdf->Output("reporte_entregas_{$fechaInicio}_{$fechaFin}.pdf", 'I');
?>
