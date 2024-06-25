<?php
ob_start();
require_once('tcpdf_include.php');
require_once('../../../modelos/sucursal.modelo.php');
require_once('../../../controladores/sucursales.controlador.php');

class imprimirReporteSucursal {
    public function traerReporteSucursal() {
        // Crear un nuevo documento PDF
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // Establecer las propiedades del documento
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Tu Nombre');
        $pdf->SetTitle('Reporte de Sucursales');
        $pdf->SetSubject('Reporte de Sucursales');
        $pdf->SetKeywords('TCPDF, PDF, reporte, sucursales');

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

        // Bloque 1: Encabezado
        $bloque1 = <<<EOF
        <table>
            <tr>
                <td style="width:150px"><img src="images/logo-negro-bloque.png"></td>
                <td style="background-color:white; width:140px">
                    <div style="font-size:8.5px; text-align:right; line-height:15px;">
                        REPORTE SUCURSAL
                    </div>
                </td>
                <td style="background-color:white; width:140px">
                    <div style="font-size:8.5px; text-align:right; line-height:15px;">
                        <br>
                    </div>
                </td>
            </tr>
        </table>
EOF;
        $pdf->writeHTML($bloque1, false, false, false, false, '');

        // Bloque 2: Sub-Encabezado con fecha
        $bloque2 = <<<EOF
        <table>
            <tr>
                <td style="width:540px"><img src="images/back.jpg"></td>
            </tr>
        </table>
        <table style="font-size:10px; padding:5px 10px;">
            <tr>
                <td style="border: 1px solid #666; background-color:white; width:540px">Generado el: $fechaActual</td>
            </tr>
        </table>
EOF;
        $pdf->writeHTML($bloque2, false, false, false, false, '');

        // Bloque 3: Títulos de la tabla
        $bloque3 = <<<EOF
        <table style="font-size:10px; padding:5px 10px;">
            <tr>
                <td style="border: 1px solid #666; background-color:white; width:50px; text-align:center">Nro.</td>
                <td style="border: 1px solid #666; background-color:white; width:200px; text-align:center">Sucursal</td>
                <td style="border: 1px solid #666; background-color:white; width:140px; text-align:center">Departamento</td>
                <td style="border: 1px solid #666; background-color:white; width:140px; text-align:center">Provincia</td>
                <td style="border: 1px solid #666; background-color:white; width:110px; text-align:center">Numero Telefonico</td>
            </tr>
        </table>
EOF;
        $pdf->writeHTML($bloque3, false, false, false, false, '');

        // Bloque 4: Datos de las sucursales
        $item = null;
        $valor = null;
        $sucursales = ControladorSucursales::ctrMostrarSucursales($item, $valor);
        $contador = 1;

        foreach ($sucursales as $key => $value) {
            $nombre = $value["nombre"];
            $departamento = $value["departamento"];
            $provincia = $value["provincia"];
            $telefono = $value["telefono"];

            $bloque4 = <<<EOF
            <table style="font-size:10px; padding:5px 10px;">
                <tr>
                    <td style="border: 1px solid #666; color:#333; background-color:white; width:50px; text-align:center">
                    $contador
                    </td>
                    <td style="border: 1px solid #666; color:#333; background-color:white; width:200px; text-align:center">
                    $nombre
                    </td>
                    <td style="border: 1px solid #666; color:#333; background-color:white; width:140px; text-align:center">
                    $departamento
                    </td>
                    <td style="border: 1px solid #666; color:#333; background-color:white; width:140px; text-align:center">
                    $provincia
                    </td>
                    <td style="border: 1px solid #666; color:#333; background-color:white; width:110px; text-align:center">
                    $telefono
                    </td>
                </tr>
            </table>
EOF;
            $pdf->writeHTML($bloque4, false, false, false, false, '');
            $contador++;
        }

        // Salida del archivo
        ob_end_clean();
        $pdf->Output('reporte_sucursales.pdf', 'I');
    }
}

$reporte = new imprimirReporteSucursal();
$reporte->traerReporteSucursal();
?>
