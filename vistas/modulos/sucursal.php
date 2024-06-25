<div class="container-fluid mw-100">
  <div class="card w-100 position-relative overflow-hidden">
    <div class="card-body p-4">
      <div class="container-fluid">
        <div class="card bg-light-info shadow-none position-relative overflow-hidden">
          <div class="card-body px-4 py-3">
            <div class="row align-items-center">
              <div class="col-9">
                <h4 class="fw-semibold mb-8">Sucursal</h4>
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a class="text-muted" href="./index.html">Menu</a></li>
                    <li class="breadcrumb-item" aria-current="page">Sucursal</li>
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
            <a href="javascript:void(0)" id="btn-add-contact" class="btn btn-info d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#agregarsucursal">
              <i class="ti ti-building-store text-white me-1 fs-5"></i> Agregar Sucursal
            </a>
            <a href="javascript:void(0)" id="btn-reportes-sucursal" class="btn btn-secondary d-flex align-items-center ms-2">
              <i class="ti ti-file text-white me-1 fs-5"></i> Generar Reporte
            </a>
          </div>
        </div>
        <br>

        <!-- Modal -->
        <div class="modal fade" id="agregarsucursal" tabindex="-1" role="dialog" aria-labelledby="addContactModalTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header d-flex align-items-center">
                <h5 class="modal-title"> <i class="ti ti-building-store text-blue me-1 fs-5"></i> Nuevo Sucursal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <div class="add-contact-box">
                  <div class="add-contact-content">
                    <form id="addContactModalTitle" method="post" enctype="multipart/form-data">
                      <!-- Asegúrate de que todos los campos tienen los nombres correctos y que los select tienen su atributo name definido -->

                      <div class="mb-3">
                        <input type="text" name="nuevoNombre" class="form-control" placeholder="Ingrese sucursal" required />
                      </div>

                      <div class="mb-3">
                        <select class="form-select" name="nuevaDepartamento" id="nuevaDepartamento" required>
                          <option value="">Sucursal...</option>
                          <option value="Santa Cruz">Santa Cruz</option>
                          <option value="La Paz">La Paz</option>
                          <option value="Cochabamba">Cochabamba</option>
                          <option value="Sucre">Sucre</option>
                          <option value="Potosi">Potosi</option>
                          <option value="Oruro">Oruro</option>
                          <option value="Beni">Beni</option>
                          <option value="Pando">Pando</option>
                          <option value="Tarija">Tarija</option>
                        </select>
                      </div>
                      <div class="mb-3">
                        <select class="form-select" name="nuevaProvincia" id="nuevaProvincia" required>
                          <option value="">Provincias...</option>
                        </select>
                      </div>
                      <div class="mb-3">
                        <input type="text" name="nuevoTelefono" class="form-control" placeholder="Telefono" required />
                      </div>
                      <button type="submit" class="btn btn-success">Registrar</button>
                      <?php
                      $crearUsuario = new ControladorSucursales();
                      $crearUsuario->ctrCrearSucursal();
                      ?>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Modal Editar-->
        <div class="modal fade" id="editarsucursal" tabindex="-1" role="dialog" aria-labelledby="editContactModalTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header d-flex align-items-center">
                <h5 class="modal-title"> <i class="ti ti-user text-blue me-1 fs-5"></i> Editar Sucursal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <div class="edit-contact-box">
                  <div class="edit-contact-content">
                    <form id="editContactModalTitle" method="post" enctype="multipart/form-data">
                      <!-- Asegúrate de que todos los campos tienen los nombres correctos y que los select tienen su atributo name definido -->

                      <div class="mb-3">
                        <input type="text" name="editarNombre" id="editarNombre" class="form-control" placeholder="Ingrese sucursal" required />
                        <input type="hidden" name="idSucursal" id="idSucursal" required>
                      </div>

                      <div class="mb-3">
                        <select class="form-select" name="editarDepartamento" id="editarDepartamento" required>
                          <option value="">Departamento...</option>
                          <option value="Santa Cruz">Santa Cruz</option>
                          <option value="La Paz">La Paz</option>
                          <option value="Cochabamba">Cochabamba</option>
                          <option value="Sucre">Sucre</option>
                          <option value="Potosi">Potosi</option>
                          <option value="Oruro">Oruro</option>
                          <option value="Beni">Beni</option>
                          <option value="Pando">Pando</option>
                          <option value="Tarija">Tarija</option>
                        </select>
                      </div>
                      <div class="mb-3">
                        <select class="form-select" name="editarProvincia" id="editarProvincia" required>
                          <option value="">Provincias...</option>
                        </select>
                      </div>
                      <div class="mb-3">
                        <input type="text" name="editarTelefono" id="editarTelefono" class="form-control" placeholder="Telefono" required />
                      </div>
                      <button type="submit" class="btn btn-success">Guardar cambios</button>
                      <?php
                      $editarSucursal = new ControladorSucursales();
                      $editarSucursal->ctrEditarSucursal();
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
            <div class="table-responsive">
              <table id="example" class="display responsive nowrap tablas" style="width:100%">
                <thead class="header-item">
                  <tr>
                    <th>id</th>
                    <th>Sucursal</th>
                    <th>Departamento</th>
                    <th>Provincia</th>
                    <th>Estado</th>
                    <th>Numero Telefonico</th>
                    <th>Acciones</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $item = null;
                  $valor = null;
                  $usuarios = ControladorSucursales::ctrMostrarSucursales($item, $valor);
                  $contador = 1;
                  foreach ($usuarios as $key => $value) {
                    echo '<tr>';
                    echo '<td><div class="d-flex align-items-center"><h6>' . $contador . '</h6></div></td>';
                    echo '<td><div class="ms-3"><div class="user-meta-info"><h6 class="user-name mb-0" data-name="' . $value["nombre"] . '">' . $value["nombre"] . '</h6></div></div></td>';
                    echo '<td><span class="usr-location" data-location="' . $value["departamento"] . '">' . $value["departamento"] . '</span></td>';
                    echo '<td><span class="usr-location" data-location="' . $value["provincia"] . '">' . $value["provincia"] . '</span></td>';
                    if ($value["estado"] != 0) {
                      echo '<td><button class="btn btn-success btnActivar" id="' . $value["id"] . '" estadoSucursal="0">Activado</button></td>';
                    } else {
                      echo '<td><button class="btn btn-danger btnActivar" id="' . $value["id"] . '" estadoSucursal="1">Desactivado</button></td>';
                    }
                    echo '<td>' . $value["telefono"] . '</td>';
                    echo '<td><div class="action-btn ms-4"><a href="" class="btnEditarSucursal" idSucursal="' . $value["id"] . '" data-bs-toggle="modal" data-bs-target="#editarsucursal"><i class="ti ti-eye fs-5"></i></a></div></td>';
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
  $borrarUsuario = new ControladorSucursales();
  $borrarUsuario->ctrBorrarSucursal();
  ?>
</div>