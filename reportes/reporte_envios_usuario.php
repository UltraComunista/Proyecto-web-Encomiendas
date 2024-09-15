<?php
ob_start(); // Iniciar almacenamiento en búfer de salida

require_once '../vendor/autoload.php'; // Ajusta la ruta según tu estructura de directorios
require_once('../modelos/usuarios.modelo.php');
require_once('../modelos/paquetes.modelo.php');

// Iniciar la sesión
session_start();

// Verificar si hay una sesión activa y obtener el ID del usuario desde la sesión
if (!isset($_SESSION['idUsuario'])) {
    die('Error: No se ha iniciado sesión.');
}

$idUsuario = $_SESSION['idUsuario'];

// Obtener los datos del usuario que está haciendo el reporte
$tabla = "usuario";
$usuario = ModeloUsuarios::mdlMostrarUsuarios($tabla, "id", $idUsuario);

if (!$usuario) {
    die('Error: Usuario no encontrado.');
}

// Obtener el ID del usuario del que se quiere ver los envíos
$idUsuarioReporte = isset($_POST['idUsuarioReporte']) ? $_POST['idUsuarioReporte'] : $idUsuario;

// Obtener los envíos realizados por el usuario
$envios = ModeloPaquetes::mdlMostrarEnviosPorUsuario($idUsuarioReporte);

// Creación del objeto PDF
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Configuración del documento PDF
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor($usuario['nombre'] . ' ' . $usuario['apellido']); // Usuario que está haciendo el reporte
$pdf->SetTitle("Reporte de Envíos por Usuario");
$pdf->SetHeaderData('', 0, "Reporte de Envíos por Usuario", '');
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
$pdf->Cell(0, 10, "Reporte de Envíos por Usuario", 0, 1, 'C');
$pdf->Ln(10);

// Escribir la información del usuario que está generando el reporte
$pdf->SetFont('helvetica', '', 12);
$pdf->Cell(0, 10, 'Reporte generado por: ' . $usuario['nombre'] . ' ' . $usuario['apellido'], 0, 1);
$pdf->Ln(5);

// Verificar si hay resultados
if (!$envios) {
    $pdf->Cell(0, 10, 'No se encontraron envíos para este usuario.', 0, 1);
} else {
    // Escribir la tabla de envíos
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->Cell(20, 10, 'ID', 1);
    $pdf->Cell(30, 10, 'Nro Registro', 1);
    $pdf->Cell(50, 10, 'Fecha Recepción', 1);
    $pdf->Cell(50, 10, 'Destino', 1);
    $pdf->Cell(30, 10, 'Estado', 1);
    $pdf->Ln(10);

    $pdf->SetFont('helvetica', '', 12);
    foreach ($envios as $envio) {
        $estadoTexto = '';
        switch ($envio['estadoPaquete']) {
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

        $pdf->Cell(20, 10, $envio['id'], 1);
        $pdf->Cell(30, 10, $envio['nro_registro'], 1);
        $pdf->Cell(50, 10, $envio['FechaRecepcion'], 1);
        $pdf->Cell(50, 10, $envio['nombreSucursal'], 1);
        $pdf->Cell(30, 10, $estadoTexto, 1);
        $pdf->Ln(10);
    }
}

// Cerrar y generar el PDF
ob_end_clean(); // Limpiar el búfer de salida
$pdf->Output("reporte_envios_usuario.pdf", 'I');
?>
