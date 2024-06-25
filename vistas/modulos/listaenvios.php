<div class="container-fluid mw-100">
  <div class="card w-100 position-relative overflow-hidden">
    <div class="card-body p-4">
      <div class="container-fluid">
        <div class="card bg-light-info shadow-none position-relative overflow-hidden">
          <div class="card-body px-4 py-3">
            <div class="row align-items-center">
              <div class="col-9">
                <h4 class="fw-semibold mb-8">LISTA DE ENVIOS</h4>
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a class="text-muted" href="./index.html">Menu</a></li>
                    <li class="breadcrumb-item" aria-current="page">Lista de Envíos</li>
                  </ol>
                </nav>
              </div>
              <div class="col-3">
                <div class="text-center mb-n5">
                  <img src="../../dist/images/breadcrumb/ChatBc.png" alt="" class="img-fluid mb-n4">
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- Buscador y botón agregar -->
        <div class="d-flex justify-content-between align-items-center mt-4 mb-2">
          <div class="col-md-8 col-xl-9 d-flex align-items-center">
            <a href="registrarenv" id="btn-add-contact" class="btn btn-info d-flex align-items-center">
              <i class="ti ti-plus text-white me-1 fs-5"></i> Agregar
            </a>
          </div>
        </div>
        <br>
        <div class="widget-content searchable-container list">
          <div class="card card-body">
            <div class="table-responsive">
              <table id="example" class="display responsive nowrap tablas" style="width:100%">
                <thead class="header-item">
                  <tr>
                    <th>id</th>
                    <th>Numero Reg.</th>
                    <th>Enviador</th>
                    <th>Destinatario</th>
                    <th>Lugar Destino</th>
                    <th>Precio</th>
                    <th>Descripcion</th>
                    <th>Estado Pago</th>
                    <th>Estado Envio</th>
                    <th>Acciones</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $usuarios = ControladorPaquetes::ctrMostrarPaquetes(null, null);
                  $contador = 1; // Inicializa un contador para los IDs fuera del bucle
                  foreach ($usuarios as $key => $value) {
                    echo '<tr>';
                    echo '<td>' . $contador . '</td>';
                    echo '<td>' . $value["nro_registro"] . '</td>';
                    echo '<td>' . $value["nombre_enviador"] . '</td>';
                    echo '<td>' . $value["nombre_destinatario"] . '</td>';
                    echo '<td>' . $value["nombre_sucursal"] . '</td>';
                    echo '<td>' . $value["precio"] . '</td>';
                    echo  '<td>' . $value["descripcion"] . '</td>';
                    echo '<td>' . ($value["EstadoPago"] == 'Pagado' ? '<span class="badge bg-success">Pagado</span>' : '<span class="badge bg-danger">Debe</span>') . '</td>';
                    echo '<td>' . ($value["estadoPaquete"] == 'Entregado' ? '<span class="badge bg-success">Entregado</span>' : '<span class="badge bg-danger">Pendiente</span>') . '</td>';
                    echo '<td><div class="action-btn ms-4"><a href="" class="btnEditarUsuario" idUsuario="' . $value["id"] . '" data-bs-toggle="modal" data-bs-target="#editContactModal"><i class="ti ti-refresh fs-5"></i></a></div></td>';
                    $contador++;
                    echo '</tr>';
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
