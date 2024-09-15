<?php
ob_start();

require_once '../controladores/paquetes.controlador.php';
require_once '../modelos/paquetes.modelo.php';
require_once '../vendor/autoload.php'; // Ajusta la ruta según tu estructura de directorios

if (isset($_GET['idPaquete'])) {
    $idPaquete = $_GET['idPaquete'];
    $item = 'id';
    $valor = $idPaquete;
    $paquete = ControladorPaquetes::ctrMostrarPaquetes($item, $valor);

    if ($paquete) {
        // Crear una nueva instancia de TCPDF con tamaño personalizado
        $pdf = new \TCPDF('L', 'mm', array(100,150), true, 'UTF-8', false);

        // Configurar el documento PDF
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Tu Nombre');
        $pdf->SetTitle('Guía de Envío');
        $pdf->SetSubject('Reporte de Envío');
        $pdf->SetKeywords('TCPDF, PDF, guía, envío');

        // Eliminar la cabecera y el pie de página predeterminados
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        // Agregar una página
        $pdf->AddPage();

        // Establecer fuente
        $pdf->SetFont('helvetica', '', 10);

        // Agregar logo (ajusta el tamaño y la posición según sea necesario)
        $logo = '../ruta/al/logo.png'; // Ajusta la ruta al logo
        $pdf->Image($logo, 5, 5, 20, '', 'PNG');

        // Título del reporte
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->Cell(0, 10, 'Guía de Envío', 0, 1, 'C');
        $pdf->Ln(5);

        // Datos del paquete
        $nro_registro = (string)$paquete["nro_registro"]; // Convertir a cadena
        $nombre_enviador = $paquete["nombre_enviador"];
        $telefono_enviador = $paquete["telefono_enviador"];
        $direccion_enviador = $paquete["direccion_enviador"];
        $nombre_remitente = isset($paquete["nombre_destinatario"]) ? $paquete["nombre_destinatario"] : 'Desconocido';
        $telefono_remitente = isset($paquete["telefono_destinatario"]) ? $paquete["telefono_destinatario"] : 'Desconocido';
        $direccion_remitente = isset($paquete["direccion_destinatario"]) ? $paquete["direccion_destinatario"] : 'Desconocido';
        $sucursalPartida = isset($paquete["nombre_sucursal_salida"]) ? $paquete["nombre_sucursal_salida"] : 'Desconocido';
        $sucursalLlegada = isset($paquete["nombre_sucursal_llegada"]) ? $paquete["nombre_sucursal_llegada"] : 'Desconocido';
        $descripcion = isset($paquete["descripcion"]) ? $paquete["descripcion"] : 'No disponible';
        $fechaRecepcion = $paquete["FechaRecepcion"];
        $usuario_registro = $paquete["nombre_usuario_registro"]; // Nombre del usuario que registró el envío

        // Generar código de barras
        $style = array(
            'position' => '',
            'align' => 'C',
            'stretch' => false,
            'fitwidth' => true,
            'cellfitalign' => '',
            'border' => false,
            'hpadding' => 'auto',
            'vpadding' => 'auto',
            'fgcolor' => array(0, 0, 0),
            'bgcolor' => false, // Fondo transparente
            'text' => true, // Mostrar el texto debajo del código de barras
            'font' => 'helvetica',
            'fontsize' => 8,
            'stretchtext' => 4
        );
        $pdf->write1DBarcode($nro_registro, 'C128', 120, 15, '', 18, 0.4, $style, 'N');

        // Escribir los datos en el PDF
        $pdf->SetFont('helvetica', '', 10);
        $html = '
        <table>
            <tr>
                <td width="50%"><strong>Código de rastreo:</strong> ' . $nro_registro . '</td>
                <td width="50%"><strong>Destinatario:</strong> ' . $nombre_remitente . '</td>
            </tr>
            
            <tr>
                <td width="50%"><strong>Teléfono Destinatario:</strong> ' . $telefono_remitente . '</td>
                <td width="50%"><strong>Dirección Destinatario:</strong> ' . $direccion_remitente . '</td>
            </tr>
            <tr>
                <td width="50%"><strong>Sucursal de Partida:</strong> ' . $sucursalPartida . '</td>
                <td width="50%"><strong>Sucursal de Llegada:</strong> ' . $sucursalLlegada . '</td>
            </tr>
            <tr>
                <td width="50%"><strong>Descripción:</strong> ' . $descripcion . '</td>
                <td width="50%"><strong>Fecha de Recepción:</strong> ' . $fechaRecepcion . '</td>
            </tr>
            <tr>
                <td width="50%"><strong>Registrado por:</strong> ' . $usuario_registro . '</td>
            </tr>
        </table>
        ';
        $pdf->writeHTML($html, true, false, true, false, '');

        // --- Comprobante de Envío ---
        $pdf->AddPage('P', array(80, 150)); // Página con tamaño personalizado para el comprobante
        $pdf->SetFont('helvetica', '', 8);
        $pdf->Cell(0, 5, 'COMPROBANTE DE ENVÍO', 0, 1, 'C');
        $pdf->Ln(5);

        $htmlComprobante = '
        <table cellpadding="3">
            <tr>
                <td><strong>Orden de Transporte:</strong> ' . $nro_registro . '</td>
            </tr>
            <tr>
                <td><strong>Fecha de Admisión:</strong> ' . $fechaRecepcion . '</td>
            </tr>
            <tr>
                <td><strong>Destinatario:</strong> ' . $nombre_remitente . '</td>
            </tr>
            <tr>
                <td><strong>Dirección Destinatario:</strong> ' . $direccion_remitente . '</td>
            </tr>
            <tr>
                <td><strong>Teléfono Destinatario:</strong> ' . $telefono_remitente . '</td>
            </tr>
            <tr>
                <td><strong>Enviador:</strong> ' . $nombre_enviador . '</td>
            </tr>
            <tr>
                <td><strong>Teléfono Enviador:</strong> ' . $telefono_enviador . '</td>
            </tr>
            <tr>
                <td><strong>Dirección Enviador:</strong> ' . $direccion_enviador . '</td>
            </tr>
            <tr>
                <td><strong>Sucursal de Partida:</strong> ' . $sucursalPartida . '</td>
            </tr>
            <tr>
                <td><strong>Sucursal de Llegada:</strong> ' . $sucursalLlegada . '</td>
            </tr>
            <tr>
                <td><strong>Descripción:</strong> ' . $descripcion . '</td>
            </tr>
            <tr>
                <td width="100%"><strong>Registrado por:</strong> ' . $usuario_registro . '</td>
            </tr>
        </table>
        ';
        $pdf->writeHTML($htmlComprobante, true, false, true, false, '');

        // Añadir código de barras y texto
        $pdf->Ln(10);
        $pdf->write1DBarcode($nro_registro, 'C128', 10, $pdf->GetY(), 60, 18, 0.4, $style, 'N');
        $pdf->Cell(0, 0, 'Escanea para rastrear el envío', 0, 0, 'C');

        $pdf->Ln(25);

        // Cerrar y generar el PDF
        ob_end_clean();
        $pdf->Output('documentos_envio.pdf', 'I');
    } else {
        echo 'Paquete no encontrado';
    }
} else {
    echo 'ID de paquete no proporcionado';
}
