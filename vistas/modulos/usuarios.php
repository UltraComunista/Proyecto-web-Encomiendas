<div class="container-fluid mw-100">
  <div class="card w-100 position-relative overflow-hidden">
    <div class="card-body p-4">
      <div class="container-fluid">
        <div class="card bg-light-info shadow-none position-relative overflow-hidden">
          <div class="card-body px-4 py-3">
            <div class="row align-items-center">
              <div class="col-9">
                <h4 class="fw-semibold mb-8">Usuarios</h4>
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a class="text-muted" href="./index.html">Menu</a></li>
                    <li class="breadcrumb-item" aria-current="page">Usuarios</li>
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
            <a href="javascript:void(0)" id="btn-add-contact" class="btn btn-info d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#agregarusuario">
              <i class="ti ti-plus text-white me-1 fs-5"></i> Agregar Usuario
            </a>
            <a href="javascript:void(0)" id="btn-reportes" class="btn btn-secondary d-flex align-items-center ms-2">
              <i class="ti ti-file text-white me-1 fs-5"></i> Generar Reporte
            </a>
          </div>
        </div>
        <br>

        <!-- Modal -->
        <div class="modal fade" id="agregarusuario" tabindex="-1" role="dialog" aria-labelledby="addContactModalTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header d-flex align-items-center">
                <h5 class="modal-title"> <i class="ti ti-user text-blue me-1 fs-5"></i> Nuevo usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <div class="add-contact-box">
                  <div class="add-contact-content">
                    <form id="addContactModalTitle" method="post" enctype="multipart/form-data">
                      <!-- Asegúrate de que todos los campos tienen los nombres correctos y que los select tienen su atributo name definido -->
                      <div class="mb-3">
                        <input type="text" name="nuevoNombre" class="form-control" placeholder="Ingrese nombre" required />
                      </div>
                      <div class="mb-3">
                        <input type="text" name="nuevoApellido" class="form-control" placeholder="Ingrese apellido" required />
                      </div>
                      <div class="mb-3">
                        <input type="text" name="nuevoCedula" class="form-control" placeholder="Ingrese cedula de identidad " required />
                      </div>
                      <div class="mb-3">
                        <input type="text" id="c-name" class="form-control" name="nuevoUsuario" placeholder="Usuario" required readonly />
                      </div>
                      <div class="mb-3">
                        <input type="password" name="nuevoPassword" class="form-control" placeholder="Contraseña" required />
                      </div>
                      <div class="mb-3">
                        <select class="form-select" name="nuevoPerfil" required>
                          <option value="">Perfil...</option>
                          <option value="Recepcion">Recepcion</option>
                          <option value="Delivery">Delivery</option>
                          <option value="Ayudante">Ayudante</option>
                        </select>
                      </div>
                      <div class="mb-3">
                        <input type="file" name="nuevaFoto" class="form-control">
                      </div>
                      <button type="submit" class="btn btn-success">Registrar</button>
                      <?php
                      $crearUsuario = new ControladorUsuarios();
                      $crearUsuario->ctrCrearUsuario();
                      ?>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Modal Editar-->
        <div class="modal fade" id="editarusuario" tabindex="-1" role="dialog" aria-labelledby="editContactModalTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header d-flex align-items-center">
                <h5 class="modal-title"> <i class="ti ti-user text-blue me-1 fs-5"></i> Editar usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <div class="edit-contact-box">
                  <div class="edit-contact-content">
                    <form method="post" enctype="multipart/form-data">
                      <input type="hidden" name="idUsuario" id="idUsuario" />
                      <div class="mb-3">
                        <input type="text" name="editarNombre" id="editarNombre" class="form-control" placeholder="Ingrese nombre" required />
                      </div>
                      <div class="mb-3">
                        <input type="text" name="editarApellido" id="editarApellido" class="form-control" placeholder="Ingrese apellido" required />
                      </div>
                      <div class="mb-3">
                        <input type="text" name="editarCedula" id="editarCedula" class="form-control" placeholder="Ingrese cedula" required />
                      </div>
                      <div class="mb-3">
                        <input type="text" class="form-control" name="editarUsuario" id="editarUsuario" placeholder="Usuario" required />
                      </div>
                      <div class="mb-3">
                        <select class="form-select" name="editarPerfil" id="editarPerfil" required>
                          <option value="">Perfil...</option>
                          <option value="Administrador">Administrador</option>
                          <option value="Recepcion">Recepcion</option>
                          <option value="Delivery">Delivery</option>
                          <option value="Ayudante">Ayudante</option>
                        </select>
                      </div>
                      <div class="mb-3">
                        <input type="hidden" name="fotoActual" id="fotoActual">
                        <input type="file" name="editarFoto" id="editarFoto" class="form-control">
                      </div>
                      <button type="button" id="resetUsuarioPassword" class="btn btn-warning">Resetear Usuario y Contraseña</button>
                      <button type="submit" class="btn btn-success">Guardar cambios</button>
                      <?php
                      $editarUsuarios = new ControladorUsuarios();
                      $editarUsuarios->ctrEditarUsuario();
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
                      <h6 class="fs-4 fw-semibold mb-0">ID</h6>
                    </th>
                    <th>
                      <h6 class="fs-4 fw-semibold mb-0">Foto</h6>
                    </th>
                    <th>
                      <h6 class="fs-4 fw-semibold mb-0">Nombre</h6>
                    </th>
                    <th>
                      <h6 class="fs-4 fw-semibold mb-0">Cédula identidad</h6>
                    </th>
                    <th>
                      <h6 class="fs-4 fw-semibold mb-0">Usuario</h6>
                    </th>
                    <th>
                      <h6 class="fs-4 fw-semibold mb-0">Perfil</h6>
                    </th>
                    <th>
                      <h6 class="fs-4 fw-semibold mb-0">Estado</h6>
                    </th>
                    <th>
                      <h6 class="fs-4 fw-semibold mb-0">Última vez</h6>
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
                  $usuarios = ControladorUsuarios::ctrMostrarUsuarios($item, $valor);
                  $contador = 1;
                  foreach ($usuarios as $key => $value) {
                    $foto = !empty($value["foto"]) ? $value["foto"] : './img/predeterminado/images.png';
                    $estado = $value["estado"] ? '<span class="badge bg-light-success text-success fw-semibold fs-2 gap-1 d-inline-flex align-items-center"><i class="ti ti-circle fs-3"></i>active</span>' : '<span class="badge bg-light text-dark fw-semibold fs-2 gap-1 d-inline-flex align-items-center"><i class="ti ti-clock-hour-4 fs-3"></i>offline</span>';
                    echo '<tr>';
                    echo '<td><div class="d-flex align-items-center"><h6>' . $contador . '</h6></div></td>';
                    echo '<td>';
                    echo '<div class="d-flex align-items-center">';
                    echo '<img src="' . $foto . '" class="rounded-circle" width="40" height="40" />';
                    echo '</div>';
                    echo '</td>';
                    echo '<td>';
                    echo '<div class="d-flex align-items-center">';
                    echo '<div class="ms-3">';
                    echo '<h6 class="fs-4 fw-semibold mb-0">' . $value["nombre"] . ' ' . $value["apellido"] . '</h6>';
                    echo '<span class="fw-normal">@' . $value["usuario"] . '</span>';
                    echo '</div>';
                    echo '</div>';
                    echo '</td>';
                    echo '<td><p class="mb-0 fw-normal">' . $value["cedula"] . '</p></td>';
                    echo '<td><p class="mb-0 fw-normal">' . $value["usuario"] . '</p></td>';
                    echo '<td><p class="mb-0 fw-normal">' . $value["perfil"] . '</p></td>';
                    echo '<td>' . $estado . '</td>';
                    echo '<td><p class="mb-0 fw-normal">' . $value["ultimologin"] . '</p></td>';
                    echo '<td>';
                    echo '<div class="dropdown dropstart">';
                    echo '<a href="#" class="text-muted" id="dropdownMenuButton' . $contador . '" data-bs-toggle="dropdown" aria-expanded="false">';
                    echo '<i class="ti ti-dots fs-5"></i>';
                    echo '</a>';
                    echo '<ul class="dropdown-menu" aria-labelledby="dropdownMenuButton' . $contador . '">';
                    echo '<li>';
                    echo '<a class="dropdown-item d-flex align-items-center gap-3 btnEditarUsuario" idUsuario="' . $value["id"] . '" href="#" data-bs-toggle="modal" data-bs-target="#editarusuario"><i class="fs-4 ti ti-pencil"></i>Edit</a>';
                    echo '</li>';
                    echo '<li>';
                    echo '<a class="dropdown-item d-flex align-items-center gap-3 btnImprimir" idUsuario="' . $value["id"] . '" href="#"><i class="fs-4 ti ti-printer"></i>Print</a>';
                    echo '</li>';
                    echo '</ul>';
                    echo '</div>';
                    echo '</td>';
                    echo '</tr>';
                    $contador++;
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
  $borrarUsuario = new ControladorUsuarios();
  $borrarUsuario->ctrBorrarUsuario();
  ?>
</div>