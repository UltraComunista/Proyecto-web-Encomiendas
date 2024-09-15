<?php
require_once('../tcpdf/tcpdf.php');
require_once('../modelos/usuarios.modelo.php');

if (isset($_GET["idUsuario"])) {
    $idUsuario = $_GET["idUsuario"];
    $usuario = ModeloUsuarios::mdlMostrarUsuarios("usuario", "id", $idUsuario);

    if ($usuario) {
        // Crear nueva instancia de TCPDF
        $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

        // Información del documento
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Tu Nombre');
        $pdf->SetTitle('Reporte de Usuario');
        $pdf->SetSubject('Reporte generado automáticamente');
        $pdf->SetKeywords('TCPDF, PDF, usuario, reporte');

        // Información por defecto del encabezado
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

        // Configurar fuente
        $pdf->SetFont('helvetica', 'B', 20);

        // Añadir página
        $pdf->AddPage();

        // Título del reporte
        $pdf->Cell(0, 10, 'Reporte de Usuario', 0, 1, 'C', 0, '', 0);

        // Configurar fuente
        $pdf->SetFont('helvetica', '', 12);

        // Contenido del reporte
        $html = '<h2>Datos del Usuario</h2>';
        $html .= '<p><strong>Nombre:</strong> ' . $usuario["nombre"] . ' ' . $usuario["apellido"] . '</p>';
        $html .= '<p><strong>Cédula:</strong> ' . $usuario["cedula"] . '</p>';
        $html .= '<p><strong>Usuario:</strong> ' . $usuario["usuario"] . '</p>';
        $html .= '<p><strong>Perfil:</strong> ' . $usuario["perfil"] . '</p>';
        $html .= '<p><strong>Última vez:</strong> ' . $usuario["ultimologin"] . '</p>';

        // Imprimir texto
        $pdf->writeHTML($html, true, false, true, false, '');

        // Cerrar y mostrar el reporte
        $pdf->Output('reporte_usuario.pdf', 'I');
    } else {
        echo "No se encontraron datos para el usuario seleccionado.";
    }
} else {
    echo "ID de usuario no proporcionado.";
}
?>
