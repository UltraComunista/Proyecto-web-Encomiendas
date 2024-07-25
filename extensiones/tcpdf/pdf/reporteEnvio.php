<?php
ob_start();
require_once('tcpdf_include.php');
require_once('../../../modelos/paquetes.modelo.php');
require_once('../../../controladores/paquetes.controlador.php');

// Obtener el ID del envío desde la URL
$idEnvio = isset($_GET['idEnvio']) ? $_GET['idEnvio'] : null;

// Verificar que el ID del envío no sea nulo
if ($idEnvio === null) {
    die('ID de envío no especificado.');
}

// Obtener datos del envío
$envio = ControladorPaquetes::ctrMostrarPaquetes('id', $idEnvio);

// Verificar que se haya encontrado el envío
if ($envio === null) {
    die('No se encontraron datos para el ID de envío especificado.');
}

// Crear un nuevo documento PDF
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Establecer las propiedades del documento
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Tu Empresa');
$pdf->SetTitle('Etiqueta de Envío');
$pdf->SetSubject('Etiqueta de Envío');
$pdf->SetKeywords('TCPDF, PDF, etiqueta, envio');

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

// Datos del envío
$nroRegistro = $envio['nro_registro'];
$nombreEnviador = $envio['nombre_enviador'];
$direccionEnviador = $envio['direccion_enviador'];
$nombreRemitente = $envio['nombre_destinatario'];
$direccionRemitente = $envio['direccion_destinatario'];
$estadoPaquete = $envio['estadoPaquete'];
$sucursalPartida = $envio['nombre_sucursal_partida'];
$sucursalLlegada = $envio['nombre_sucursal_llegada'];
$telefonoRemitente = $envio['telefono_remitente'];
$descripcion = $envio['descripcion'];

// Bloque 1: Encabezado
$bloque1 = <<<EOF
<table>
    <tr>
        <td>
            <div>
                <h1>EMPRESA</h1>
            </div>
        </td>
        <td>
            <div>
                <h1>DPTO</h1>
            </div>
        </td>
        <td>
            <div>
                <h1>LOGO</h1>
            </div>
        </td>
    </tr> 
</table>
EOF;

$pdf->writeHTML($bloque1, false, false, false, false, '');

// Bloque 2: Título del reporte
$bloqueTitulo = <<<EOF
<table>
    <tr>
        <td>
            <h4>De:</h4> 
            <p>$nombreEnviador</p>
            <p>direccion</p>
            <p>sucursal partida</p>
            <p>telefono</p>
        </td>

    </tr> 
</table>
EOF;
$pdf->writeHTML($bloqueTitulo, false, false, false, false, '');

// Bloque 3: Código de Barras
$bloqueDestino = <<<EOF
<table>
    <tr>
        <td>
            <h4>Para:</h4> 
            <p>$nombreRemitente</p>
            <p>direccion</p>
            <p>sucursal partida</p>
            <p>telefono</p>
        </td>

    </tr> 
</table>
EOF;
$pdf->writeHTML($bloqueDestino, false, false, false, false, '');

// Bloque 4: TITULO GUIA
$bloqueGuia = <<<EOF
<table>
    <tr>
        <td>
            <div>
                <h1></h1>
            </div>
        </td>
        <td>
            <div>
                <h1>GUIA</h1>
            </div>
        </td>
        <td>
            <div>
                <h1></h1>
            </div>
        </td>
    </tr> 
</table>
EOF;
$pdf->writeHTML($bloqueGuia, false, false, false, false, '');
// Bloque 5: registros
$bloqueRegistro = <<<EOF
<table>
    <tr>
        <td>
            <div>
                <h1>Registrado</h1>
            </div>
        </td>
        <td>
            <div>
                
            </div>
        </td>
        <td>
            <div>
                <h1>Dia hora </h1>
            </div>
        </td>
    </tr> 
</table>
EOF;
$pdf->writeHTML($bloqueRegistro, false, false, false, false, '');

// Bloque 6: Barra
$bloqueBarra = <<<EOF
<table>
    <tr>
        <td>
            <div>
                <h1></h1>
            </div>
        </td>
        <td>
            <div>
                <h1>Codgio barra</h1>
            </div>
        </td>
        <td>
            <div>
                <h1></h1>
            </div>
        </td>
    </tr> 
</table>
EOF;
$pdf->writeHTML($bloqueBarra, false, false, false, false, '');

// Cerrar y emitir el documento PDF
ob_end_clean();
$pdf->Output('etiqueta_envio.pdf', 'I');
