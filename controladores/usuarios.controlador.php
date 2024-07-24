<?php

class ControladorUsuarios
{
    static public function ctrIngresoUsuario()
    {
        if (isset($_POST["ingUsuario"])) {
            if (
                preg_match('/^[a-zA-Z0-9]+$/', $_POST["ingUsuario"]) &&
                preg_match('/^[a-zA-Z0-9]+$/', $_POST["ingPassword"])
            ) {
                $tabla = "usuario";
                $item = "usuario";
                $valor = $_POST["ingUsuario"];
                $respuesta = ModeloUsuarios::mdlMostrarUsuarios($tabla, $item, $valor);

                if ($respuesta["usuario"] == $_POST["ingUsuario"] && $respuesta["password"] == $_POST["ingPassword"]) {
                    // Actualizar estado a "en línea"
                    ModeloUsuarios::mdlActualizarEstadoUsuario($respuesta["id"], 1);

                    $_SESSION["iniciarSesion"] = "ok";
                    $_SESSION["id"] = $respuesta["id"];
                    $_SESSION["usuario"] = $respuesta["usuario"];

                    echo '<script> window.location = "inicio" </script>';
                } else {
                    echo '<br>
                        <div class="alert alert-info alert-dismissible fade show">
                        <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                        <strong>Error!</strong> Error al ingresar, vuelve a intentarlo
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
                        </button>
                        </div>
                        ';
                }
            }
        }
    }

    static public function ctrCrearUsuario()
    {
        if (isset($_POST["nuevoUsuario"])) {
            if (
                preg_match('/^[a-zA-Z0-9]+$/', $_POST["nuevoUsuario"]) &&
                preg_match('/^[a-zA-Z0-9]+$/', $_POST["nuevoPassword"])
            ) {
                $ruta = 'vistas/img/predeterminado/images.png'; // Ruta predeterminada
                if (isset($_FILES["nuevaFoto"]["tmp_name"]) && $_FILES["nuevaFoto"]["tmp_name"] != "") {
                    $directorio = "vistas/img/usuarios/";
                    $archivo = $directorio . basename($_FILES["nuevaFoto"]["name"]);
                    $tipoArchivo = strtolower(pathinfo($archivo, PATHINFO_EXTENSION));
                    $validarImagen = getimagesize($_FILES["nuevaFoto"]["tmp_name"]);
                    if ($validarImagen !== false) {
                        $nombreArchivo = md5(uniqid(rand(), true)) . "." . $tipoArchivo;
                        $rutaFinal = $directorio . $nombreArchivo;
                        if (move_uploaded_file($_FILES["nuevaFoto"]["tmp_name"], $rutaFinal)) {
                            $ruta = $rutaFinal;
                        }
                    }
                }
                $tabla = "usuario";
                $datos = array(
                    "usuario" => $_POST["nuevoUsuario"],
                    "password" => $_POST["nuevoPassword"],
                    "perfil" => $_POST["nuevoPerfil"],
                    "nombre" => $_POST["nuevoNombre"],
                    "apellido" => $_POST["nuevoApellido"],
                    "cedula" => $_POST["nuevoCedula"],

                    "foto" => $ruta
                );
                $respuesta = ModeloUsuarios::mdlIngresarUsuario($tabla, $datos);
                if ($respuesta == "ok") {
                    echo "<script>
                    window.addEventListener('load', function() {
                        toastr.success('El usuario ha sido guardado correctamente', '¡Éxito!');
                        setTimeout(function() {
                            window.location = 'usuarios';
                        }, 2000);
                    });
                    </script>";
                } else {
                    echo "<script>
                    window.addEventListener('load', function() {
                        toastr.error('No se pudo registrar el usuario.', 'Error');
                        setTimeout(function() {
                            window.location = 'usuarios';
                        }, 2000);
                    });
                    </script>";
                }
            }
        }
    }

    static public function ctrMostrarUsuarios($item, $valor)
    {
        $tabla = "usuario";
        $respuesta = ModeloUsuarios::mdlMostrarUsuarios($tabla, $item, $valor);
        return $respuesta;
    }

    static public function ctrEditarUsuario()
    {
        if (isset($_POST["editarNombre"])) {
            if (preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarUsuario"])) {
                $ruta = $_POST["fotoActual"];
                if (isset($_FILES["editarFoto"]["tmp_name"]) && $_FILES["editarFoto"]["tmp_name"] != "") {
                    $directorio = "vistas/img/usuarios/";
                    $archivo = $directorio . basename($_FILES["editarFoto"]["name"]);
                    $tipoArchivo = strtolower(pathinfo($archivo, PATHINFO_EXTENSION));
                    $validarImagen = getimagesize($_FILES["editarFoto"]["tmp_name"]);
                    if ($validarImagen !== false) {
                        $nombreArchivo = md5(uniqid(rand(), true)) . "." . $tipoArchivo;
                        $rutaFinal = $directorio . $nombreArchivo;
                        if (move_uploaded_file($_FILES["editarFoto"]["tmp_name"], $rutaFinal)) {
                            $ruta = $rutaFinal;
                            if (!empty($_POST["fotoActual"]) && $_POST["fotoActual"] != "vistas/img/usuarios/default.jpg") {
                                unlink($_POST["fotoActual"]);
                            }
                        }
                    }
                }
                $tabla = "usuario";

                // Verificar si se cambió la contraseña
                $password = isset($_POST["editarPassword"]) && $_POST["editarPassword"] != "" ? $_POST["editarPassword"] : $_POST["passwordActual"];

                $datos = array(
                    "id" => $_POST["idUsuario"],
                    "nombre" => $_POST["editarNombre"],
                    "apellido" => $_POST["editarApellido"],
                    "cedula" => $_POST["editarCedula"],
                    "usuario" => $_POST["editarUsuario"],
                    "password" => $password,
                    "perfil" => $_POST["editarPerfil"],
                    "foto" => $ruta
                );

                $respuesta = ModeloUsuarios::mdlEditarUsuario($tabla, $datos);

                if ($respuesta == "ok") {
                    echo "<script>
                window.addEventListener('load', function() {
                    toastr.success('El usuario ha sido editado correctamente', '¡Éxito!');
                    setTimeout(function() {
                        window.location = 'usuarios';
                    }, 2000);
                });
                </script>";
                } else {
                    echo "<script>
                window.addEventListener('load', function() {
                    toastr.error('No se pudo editar el usuario.', 'Error');
                    setTimeout(function() {
                        window.location = 'usuarios';
                    }, 2000);
                });
                </script>";
                }
            }
        }
    }


    static public function ctrBorrarUsuario()
    {
        if (isset($_GET["idUsuario"])) {
            $tabla = "usuario";
            $datos = $_GET["idUsuario"];
            $respuesta = ModeloUsuarios::mdlBorrarUsuario($tabla, $datos);
            if ($respuesta == "ok") {
                echo "<script>
                    window.addEventListener('load', function() {
                        toastr.success('El usuario ha sido eliminado correctamente', '¡Éxito!');
                        setTimeout(function() {
                            window.location = 'usuarios';
                        }, 2000);
                    });
                    </script>";
            }
        }
    }
    static public function ctrLogoutUsuario()
    {
        if (isset($_SESSION["id"])) {
            // Actualizar estado a "offline"
            ModeloUsuarios::mdlActualizarEstadoUsuario($_SESSION["id"], 0);

            session_destroy();
            echo '<script> window.location = "login" </script>';
        }
    }
}
