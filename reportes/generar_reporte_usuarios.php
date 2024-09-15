<?php
ob_start(); // Iniciar almacenamiento en búfer de salida

require_once '../vendor/autoload.php';
require_once('../modelos/usuarios.modelo.php');

// Iniciar la sesión
session_start();

// Verificar si hay una sesión activa y obtener el ID del usuario desde la sesión
if (!isset($_SESSION['idUsuario'])) {
    die('Error: No se ha iniciado sesión.');
}

$idUsuario = $_SESSION['idUsuario'];

// Obtener el estado seleccionado desde el formulario
$estadoSeleccionado = isset($_POST['estadoUsuarioReporte']) ? $_POST['estadoUsuarioReporte'] : null;

if ($estadoSeleccionado === null) {
    die('Error: No se seleccionó un estado.');
}

// Obtener los datos del usuario que está haciendo el reporte
$tabla = "usuario";
$usuario = ModeloUsuarios::mdlMostrarUsuarios($tabla, "id", $idUsuario);

if (!$usuario) {
    die('Error: Usuario no encontrado.');
}

// Obtener los usuarios por el estado seleccionado
$usuarios = ModeloUsuarios::mdlMostrarUsuariosPorEstado($tabla, $estadoSeleccionado);

// Definir los perfiles y estados
$perfiles = [
    1 => 'Administrador',
    2 => 'Recepcion',
    3 => 'Delivery',
    4 => 'Ayudante'
];

$estados = [
    0 => 'Desconectado',
    1 => 'En linea',
    2 => 'Fuera de servicio'
];

// Crear el objeto PDF en orientación horizontal
$pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Configuración del documento PDF
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor($usuario['nombre'] . ' ' . $usuario['apellido']); // Usuario que está haciendo el reporte
$pdf->SetTitle("Reporte de Usuarios {$estados[$estadoSeleccionado]}");
$pdf->SetHeaderData('', 0, "Reporte de Usuarios {$estados[$estadoSeleccionado]}", '');
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
$pdf->Cell(0, 10, "Reporte de Usuarios {$estados[$estadoSeleccionado]}", 0, 1, 'C');
$pdf->Ln(10);

// Escribir la información del usuario que está generando el reporte
$pdf->SetFont('helvetica', '', 12);
$pdf->Cell(0, 10, 'Reporte generado por: ' . $usuario['nombre'] . ' ' . $usuario['apellido'], 0, 1);
$pdf->Ln(5);

// Escribir la tabla de usuarios
$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(10, 10, 'ID', 1);
$pdf->Cell(30, 10, 'Nombre', 1);
$pdf->Cell(30, 10, 'Apellido', 1);
$pdf->Cell(30, 10, 'Cedula', 1);
$pdf->Cell(30, 10, 'Usuario', 1);
$pdf->Cell(50, 10, 'Último Login', 1);
$pdf->Cell(30, 10, 'Perfil', 1);
$pdf->Cell(40, 10, 'Estado', 1);
$pdf->Ln(10);

$pdf->SetFont('helvetica', '', 12);
foreach ($usuarios as $usuario) {
    $perfilTexto = isset($perfiles[$usuario['perfil']]) ? $perfiles[$usuario['perfil']] : 'Desconocido';
    $estadoTexto = isset($estados[$usuario['estado']]) ? $estados[$usuario['estado']] : 'Desconocido';
    
    $pdf->Cell(10, 10, $usuario['id'], 1);
    $pdf->Cell(30, 10, $usuario['nombre'], 1);
    $pdf->Cell(30, 10, $usuario['apellido'], 1);
    $pdf->Cell(30, 10, $usuario['cedula'], 1);
    $pdf->Cell(30, 10, $usuario['usuario'], 1);
    $pdf->Cell(50, 10, $usuario['ultimoLogin'], 1);
    $pdf->Cell(30, 10, $perfilTexto, 1);
    $pdf->Cell(40, 10, $estadoTexto, 1);
    $pdf->Ln(10);
}

// Cerrar y generar el PDF
ob_end_clean(); // Limpiar el búfer de salida
$pdf->Output("reporte_usuarios_{$estados[$estadoSeleccionado]}.pdf", 'I');
?>
