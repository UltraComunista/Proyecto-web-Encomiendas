<div class="container-fluid mw-100">
  <div class="card w-100 position-relative overflow-hidden">
    <div class="card-body p-4">
      <div class="container-fluid">
        <div class="card bg-light-info shadow-none position-relative overflow-hidden">
          <div class="card-body px-4 py-3">
            <div class="row align-items-center">
              <div class="col-9">
                <h4 class="fw-semibold mb-8">Remitente</h4>
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a class="text-muted" href="./index.html">Menu</a></li>
                    <li class="breadcrumb-item" aria-current="page">Remitente</li>
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
            <a href="javascript:void(0)" id="btn-add-contact" class="btn btn-info d-flex align-items-center">
              <i class="ti ti-building-store text-white me-1 fs-5"></i> Agregar Remitente
            </a>
            <a href="javascript:void(0)" id="btn-reportes-remitente" class="btn btn-secondary d-flex align-items-center ms-2">
              <i class="ti ti-file text-white me-1 fs-5"></i> Generar Reporte
            </a>
          </div>
        </div>
        <br>

        <!-- Modal -->
        <div class="modal fade" id="addContactModal" tabindex="-1" role="dialog" aria-labelledby="addContactModalTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header d-flex align-items-center">
                <h5 class="modal-title"> <i class="ti ti-building-store text-blue me-1 fs-5"></i> Nuevo Remitente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <div class="add-contact-box">
                  <div class="add-contact-content">
                    <form method="post" enctype="multipart/form-data">
                      <div class="mb-3">
                        <input type="text" name="nuevoCedula" class="form-control" placeholder="Ingrese cedula de identidad" required />
                      </div>
                      <div class="mb-3">
                        <input type="text" name="nuevoNombre" class="form-control" placeholder="Ingrese nombre completo" required />
                      </div>
                      <div class="mb-3">
                        <input type="text" name="nuevoDireccion" class="form-control" placeholder="Ingrese direccion" required />
                      </div>
                      <div class="mb-3">
                        <input type="text" name="nuevoTelefono" class="form-control" placeholder="Telefono" required />
                      </div>
                      <button type="submit" class="btn btn-success">Agregar</button>
                      <?php
                      $crearRemitente = new ControladorRemitente();
                      $crearRemitente->ctrCrearRemitente();
                      ?>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Modal Editar-->
        <div class="modal fade" id="editContactModal" tabindex="-1" role="dialog" aria-labelledby="editContactModalTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header d-flex align-items-center">
                <h5 class="modal-title"> <i class="ti ti-user text-blue me-1 fs-5"></i> Editar Remitente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <div class="edit-contact-box">
                  <div class="edit-contact-content">
                    <form method="post" enctype="multipart/form-data">
                      <div class="mb-3">
                        <input type="text" name="editarCedula" id="editarCedula" class="form-control" placeholder="Ingrese cedula de identidad" required />
                        <input type="hidden" name="idRemitente" id="idRemitente" value="">
                      </div>
                      <div class="mb-3">
                        <input type="text" name="editarNombre" id="editarNombre" class="form-control" placeholder="Ingrese nombre completo" required />
                      </div>
                      <div class="mb-3">
                        <input type="text" name="editarDireccion" id="editarDireccion" class="form-control" placeholder="Ingrese direccion" required />
                      </div>
                      <div class="mb-3">
                        <input type="text" name="editarTelefono" id="editarTelefono" class="form-control" placeholder="Telefono" required />
                      </div>
                      <button type="submit" class="btn btn-success">Guardar</button>
                      <?php
                      $editarRemitente = new ControladorRemitente();
                      $editarRemitente->ctrEditarRemitente();
                      ?>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="widget-content searchable-container list">
          <div class="card card-body">
            <div class="table-responsive rounded-2 mb-4">
              <table class="table border text-nowrap customize-table mb-0 align-middle tablas">
                <thead class="text-dark fs-4">
                  <tr>
                    <th>
                      <h6 class="fs-4 fw-semibold mb-0">id</h6>
                    </th>
                    <th>
                      <h6 class="fs-4 fw-semibold mb-0">Cedula de identidad</h6>
                    </th>
                    <th>
                      <h6 class="fs-4 fw-semibold mb-0">Nombre</h6>
                    </th>
                    <th>
                      <h6 class="fs-4 fw-semibold mb-0">Direccion</h6>
                    </th>
                    <th>
                      <h6 class="fs-4 fw-semibold mb-0">Telefono</h6>
                    </th>
                    <th>
                      <h6 class="fs-4 fw-semibold mb-0">Acciones</h6>
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $item = null;
                  $valor = null;
                  $destinatarios = ControladorRemitente::ctrMostrarRemitente($item, $valor);
                  $contador = 1; // Inicializa un contador para los IDs fuera del bucle
                  foreach ($destinatarios as $key => $value) {
                    echo '<tr class="search-items">';
                    // Celda para el ID
                    echo '<td>
              <div class="d-flex align-items-center">
                <h6>' . $contador . '</h6>
              </div>
            </td>';
                    // Celda para la cedula de identidad
                    echo '<td>
              <div class="ms-3">
                <div class="user-meta-info">
                  <h6 class="user-name mb-0">' . $value["cedula"] . '</h6>
                </div>
              </div>
            </td>';
                    // Celda para el nombre
                    echo '<td>
              <span class="usr-location">' . $value["nombre"] . '</span>
            </td>';
                    // Celda para la dirección
                    echo '<td>
              <span class="usr-ph-no">' . $value["direccion"] . '</span>
            </td>';
                    // Celda para el teléfono
                    echo '<td>' . $value["telefono"] . '</td>';
                    // Celda para las acciones
                    echo '<td>
              <div class="dropdown dropstart">
                <a href="#" class="text-muted" id="dropdownMenuButton' . $value["id"] . '" data-bs-toggle="dropdown" aria-expanded="false">
                  <i class="ti ti-dots fs-5"></i>
                </a>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton' . $value["id"] . '">
                  <li>
                    <a class="dropdown-item d-flex align-items-center gap-3 btnEditarDestinatario" idDestinatario="' . $value["id"] . '" href="#" data-bs-toggle="modal" data-bs-target="#editContactModal">
                      <i class="fs-4 ti ti-edit"></i>Editar
                    </a>
                  </li>
                  <li>
                    <a class="dropdown-item d-flex align-items-center gap-3 btnEliminarDestinatario" idDestinatario="' . $value["id"] . '" href="#">
                      <i class="fs-4 ti ti-trash"></i>Eliminar
                    </a>
                  </li>
                </ul>
              </div>
            </td>';
                    // Incrementa el contador por cada usuario
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
  <?php
  $borrarRemitente = new ControladorRemitente();
  $borrarRemitente->ctrBorrarRemitente();
  ?>
</div>
