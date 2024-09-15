<?php
// Obtener la ID del usuario de la sesión
$idUsuario = $_SESSION["idUsuario"];

// Obtener los datos del usuario usando el controlador
$usuario = ControladorUsuarios::ctrMostrarDatosUsuarioPorId($idUsuario);
?>

<div class="container-fluid">
    <!-- Breadcrumb and Header -->
    <div class="card bg-light-info shadow-none position-relative overflow-hidden">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">Ajustes</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a class="text-muted" href="./index.html">Inicio</a></li>
                            <li class="breadcrumb-item" aria-current="page">Ajustes</li>
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

    <!-- Profile and Personal Details Section -->
    <div class="tab-pane fade show active" id="pills-account" role="tabpanel" aria-labelledby="pills-account-tab" tabindex="0">
        <div class="row">
            <!-- Sección para cambiar la imagen de perfil -->
            <div class="col-lg-6 d-flex align-items-stretch">
                <div class="card w-100 position-relative overflow-hidden">
                    <div class="card-body p-4">
                        <h5 class="card-title fw-semibold">Cambiar Foto de Perfil</h5>
                        <p class="card-subtitle mb-4">Cambia tu foto de perfil desde aquí</p>
                        <div class="text-center">
                            <img src="<?php echo $usuario['foto']; ?>" alt="" class="img-fluid rounded-circle" width="120" height="120">
                            <div class="d-flex align-items-center justify-content-center my-4 gap-3">
                                <input type="file" class="form-control" name="editarFoto" id="editarFoto">
                                <input type="hidden" name="fotoActual" value="<?php echo $usuario['foto']; ?>">
                                <button class="btn btn-outline-danger">Restablecer</button>
                            </div>
                            <p class="mb-0">Permitido JPG, GIF o PNG. Tamaño máximo de 800K</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 d-flex align-items-stretch">
                <div class="card w-100 position-relative overflow-hidden">
                    <div class="card-body p-4">
                        <h5 class="card-title fw-semibold">Cambiar Contraseña</h5>
                        <p class="card-subtitle mb-4">Para cambiar tu contraseña, ingresa una nueva o deja el campo vacío para mantener la actual.</p>
                        <div class="mb-4">
                            <input type="hidden" name="passwordActual" value="<?php echo $usuario['password']; ?>">
                            <label for="currentPassword" class="form-label fw-semibold">Contraseña Actual</label>
                            <input type="password" class="form-control" id="currentPassword" placeholder="Contraseña Actual" value="<?php echo $usuario['password']; ?>" readonly>
                        </div>
                        <div class="mb-4">
                            <label for="newPassword" class="form-label fw-semibold">Nueva Contraseña</label>
                            <input type="password" class="form-control" name="editarPassword" id="newPassword" placeholder="Nueva Contraseña">
                        </div>



                    </div>
                </div>
            </div>

            <!-- Sección para los detalles personales -->
            <div class="col-12">
                <div class="card w-100 position-relative overflow-hidden mb-0">
                    <div class="card-body p-4">
                        <h5 class="card-title fw-semibold">Detalles Personales</h5>
                        <p class="card-subtitle mb-4">Para cambiar tus detalles personales, edítalos y guárdalos desde aquí</p>
                        <form method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="idUsuario" value="<?php echo $usuario['id']; ?>"> <!-- ID del Usuario -->
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-4">
                                        <label for="userName" class="form-label fw-semibold">Nombre</label>
                                        <input type="text" class="form-control" id="userName" name="editarNombre" placeholder="Nombre" value="<?php echo $usuario['nombre']; ?>">
                                    </div>
                                    <div class="mb-4">
                                        <label for="userName" class="form-label fw-semibold">Cedula</label>
                                        <input type="text" class="form-control" id="userName" name="editarCedula" placeholder="Cedula" value="<?php echo $usuario['cedula']; ?>">
                                    </div>
                                    <div class="mb-4">
                                        <label for="userRole" class="form-label fw-semibold">Usuario</label>
                                        <input type="text" class="form-control" id="userRole" name="editarUsuario" placeholder="Usuario" value="<?php echo $usuario['usuario']; ?>">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-4">
                                        <label for="phoneNumber" class="form-label fw-semibold">Teléfono</label>
                                        <input type="text" class="form-control" id="phoneNumber" name="editarTelefono" placeholder="+91 12345 65478" value="<?php echo $usuario['telefono']; ?>">
                                    </div>
                                    <div class="mb-4">
                                        <label for="token" class="form-label fw-semibold">Token</label>
                                        <input type="text" class="form-control" id="token" name="editarToken" placeholder="Token" value="<?php echo $usuario['token']; ?>" readonly required>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="">
                                        <label for="address" class="form-label fw-semibold">Dirección</label>
                                        <input type="text" class="form-control" id="address" name="editarDireccion" placeholder="814 Howard Street, 120065, India" value="<?php echo $usuario['direccion']; ?>">
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="d-flex align-items-center justify-content-end mt-4 gap-3">
                                        <button type="submit" class="btn btn-primary">Guardar</button>
                                        <?php
                                        $editarUsuarios = new ControladorUsuarios();
                                        $editarUsuarios->ctrEditarEmpresa();
                                        ?>
                                        <button class="btn btn-light-danger text-danger">Cancelar</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>