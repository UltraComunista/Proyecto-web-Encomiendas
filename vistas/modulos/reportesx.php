<!-- Modal para el Reporte de Envíos por Usuario -->
<div class="modal fade" id="reporteEnviosUsuario" tabindex="-1" role="dialog" aria-labelledby="reporteEnviosUsuarioLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reporteEnviosUsuarioLabel">Generar Reporte de Envíos por Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formReporteEnviosUsuario" method="POST" action="/Proyecto-web-Encomiendas/reportes/reporte_envios_usuario.php">
                    <div class="mb-3">
                        <label for="usuarioReporte" class="form-label">Seleccionar Usuario</label>
                        <select class="form-select" id="usuarioReporte" name="idUsuario" required>
                            <option value="">Selecciona un usuario...</option>
                            <?php
                            // Aquí se deben cargar los usuarios de la base de datos
                            $usuarios = ControladorUsuarios::ctrMostrarUsuarios(null, null);
                            foreach ($usuarios as $usuario) {
                                echo '<option value="' . $usuario['id'] . '">' . $usuario['nombre'] . ' ' . $usuario['apellido'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Generar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal para el Reporte de Encomiendas por Estado -->
<div class="modal fade" id="reporteEncomiendasEstado" tabindex="-1" role="dialog" aria-labelledby="reporteEncomiendasEstadoLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reporteEncomiendasEstadoLabel">Generar Reporte de Encomiendas por Estado</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formReporteEncomiendasEstado" method="POST" action="/Proyecto-web-Encomiendas/reportes/reporte_estado.php">
                    <div class="mb-3">
                        <label for="estadoPaquete" class="form-label">Seleccionar Estado</label>
                        <select class="form-select" id="estadoPaquete" name="estadoPaquete" required>
                            <option value="">Selecciona un estado...</option>
                            <option value="0">Recepcionado (Predeterminado)</option>
                            <option value="1">En camino</option>
                            <option value="2">Recepcionado (Destino)</option>
                            <option value="3">Entregado</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Generar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal para el Reporte de Encomiendas por Sucursal -->
<div class="modal fade" id="reporteEncomiendasSucursal" tabindex="-1" role="dialog" aria-labelledby="reporteEncomiendasSucursalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reporteEncomiendasSucursalLabel">Generar Reporte de Encomiendas por Sucursal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formReporteEncomiendasSucursal" method="POST" action="/Proyecto-web-Encomiendas/reportes/generar_reporte_sucursal.php">
                    <div class="mb-3">
                        <label for="sucursalReporte" class="form-label">Seleccionar Sucursal</label>
                        <select class="form-select" id="sucursalReporte" name="sucursalReporte" required>
                            <option value="">Selecciona una sucursal...</option>
                            <?php
                            $sucursales = ControladorSucursales::ctrMostrarSucursales(null, null);
                            foreach ($sucursales as $sucursal) {
                                echo '<option value="' . $sucursal['id'] . '">' . $sucursal['nombre'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="tipoReporte" class="form-label">Tipo de Reporte</label>
                        <select class="form-select" id="tipoReporte" name="tipoReporte" required>
                            <option value="realizados">Envíos Realizados</option>
                            <option value="recibidos">Encomiendas Recibidas</option>
                            <option value="entregados">Encomiendas Entregadas</option>
                            <option value="pendientes">Encomiendas Pendientes</option>
                            <option value="generales">Movimientos Generales</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Generar</button>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Modal para el Reporte de Usuarios Activos/Inactivos -->
<div class="modal fade" id="reporteUsuariosActivos" tabindex="-1" role="dialog" aria-labelledby="reporteUsuariosActivosLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reporteUsuariosActivosLabel">Generar Reporte de Usuarios Activos/Inactivos</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formReporteUsuariosActivos" method="POST" action="/Proyecto-web-Encomiendas/reportes/generar_reporte_usuarios.php">
                    <div class="mb-3">
                        <label for="estadoUsuarioReporte" class="form-label">Seleccionar Estado</label>
                        <select class="form-select" id="estadoUsuarioReporte" name="estadoUsuarioReporte" required>
                            <option value="">Selecciona un estado...</option>
                            <option value="0">Desconectado</option>
                            <option value="1">En línea</option>
                            <option value="2">Fuera de servicio</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Generar</button>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Modal para el Reporte de Entregas por Fecha -->
<div class="modal fade" id="reporteEntregasFecha" tabindex="-1" role="dialog" aria-labelledby="reporteEntregasFechaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reporteEntregasFechaLabel">Generar Reporte de Entregas por Fecha</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formReporteEntregasFecha" method="POST" action="/Proyecto-web-Encomiendas/reportes/generar_reporte_fecha.php">
                    <div class="mb-3">
                        <label for="fechaInicio" class="form-label">Fecha de Inicio</label>
                        <input type="date" class="form-control" id="fechaInicio" name="fechaInicio" required>
                    </div>
                    <div class="mb-3">
                        <label for="fechaFin" class="form-label">Fecha de Fin</label>
                        <input type="date" class="form-control" id="fechaFin" name="fechaFin" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Generar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal para el Reporte de Envíos por Tipo de Paquete -->
<div class="modal fade" id="reportePaquetesTipo" tabindex="-1" role="dialog" aria-labelledby="reportePaquetesTipoLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reportePaquetesTipoLabel">Generar Reporte de Envíos por Tipo de Paquete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formReportePaquetesTipo" method="POST" action="generar_reporte_tipo.php">
                    <div class="mb-3">
                        <label for="tipoPaqueteReporte" class="form-label">Seleccionar Tipo de Paquete</label>
                        <select class="form-select" id="tipoPaqueteReporte" name="tipoPaqueteReporte" required>
                            <option value="">Selecciona un tipo de paquete...</option>
                            <option value="1">Documento</option>
                            <option value="2">Paquete</option>
                            <option value="3">Otro</option>
                            <!-- Otros tipos según tu base de datos -->
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Generar</button>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid mw-100">


    <div class="container mt-5">
        <h2 class="mb-4">Generación de Reportes</h2>
        <div class="row">
            <!-- Reporte de Envíos por Usuario -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Reporte de Envíos por Usuario</h5>
                        <p class="card-text">Genera un reporte detallado de los envíos realizados por un usuario específico.</p>
                        <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#reporteEnviosUsuario">Generar Reporte</a>
                    </div>
                </div>
            </div>

            <!-- Reporte de Encomiendas por Estado -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Reporte de Encomiendas por Estado</h5>
                        <p class="card-text">Consulta los estados de las encomiendas y genera un reporte de las mismas.</p>
                        <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#reporteEncomiendasEstado">Generar Reporte</a>
                    </div>
                </div>
            </div>

            <!-- Reporte de Encomiendas por Sucursal -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Reporte de Encomiendas por Sucursal</h5>
                        <p class="card-text">Genera un reporte de las encomiendas gestionadas por una sucursal específica.</p>
                        <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#reporteEncomiendasSucursal">Generar Reporte</a>
                    </div>
                </div>
            </div>

            <!-- Reporte de Usuarios Activos/Inactivos -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Reporte de Usuarios Activos/Inactivos</h5>
                        <p class="card-text">Genera un reporte de los usuarios que están activos o inactivos en el sistema.</p>
                        <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#reporteUsuariosActivos">Generar Reporte</a>
                    </div>
                </div>
            </div>

            <!-- Reporte de Entregas por Fecha -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Reporte de Entregas por Fecha</h5>
                        <p class="card-text">Consulta las entregas realizadas dentro de un rango de fechas.</p>
                        <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#reporteEntregasFecha">Generar Reporte</a>
                    </div>
                </div>
            </div>

            <!-- Reporte de Envíos por Tipo de Paquete -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Reporte de Envíos por Tipo de Paquete</h5>
                        <p class="card-text">Genera un reporte basado en los tipos de paquetes enviados.</p>
                        <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#reportePaquetesTipo">Generar Reporte</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>