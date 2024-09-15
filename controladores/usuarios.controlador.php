<?php
require __DIR__ . '/../vendor/autoload.php'; // Asegúrate de que esta ruta es correcta
require_once __DIR__ . '/../modelos/usuarios.modelo.php';

use \Firebase\JWT\JWT;

class ControladorUsuarios
{
    private $key = "your_secret_key";  // Clave secreta para firmar el token

    public static function ctrIngresoUsuario()
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

                if ($respuesta["usuario"] == $_POST["ingUsuario"] && password_verify($_POST["ingPassword"], $respuesta["password"])) {
                    // Actualizar estado a "en línea" y último login
                    $fechaActual = date("Y-m-d H:i:s");

                    $_SESSION["iniciarSesion"] = "ok";
                    $_SESSION["idUsuario"] = $respuesta["id"];
                    $_SESSION["usuario"] = $respuesta["usuario"];
                    $_SESSION["nombre"] = $respuesta["nombre"];
                    $_SESSION["apellido"] = $respuesta["apellido"];
                    $_SESSION["foto"] = $respuesta["foto"]; // Guardar la foto en la sesión
                    $_SESSION["perfil"] = $respuesta["perfil"]; // Guardar el perfil en la sesión
                    $_SESSION["idSucursal"] = $respuesta["idSucursal"];  // Guardar idSucursal en la sesión

                    ModeloUsuarios::mdlActualizarEstadoYUltimoLogin($respuesta["id"], 1, $fechaActual);

                    // Redirigir según el perfil
                    if ($_SESSION["perfil"] == 5) {
                        echo '<script> window.location = "enviosempresa" </script>';
                    } else {
                        echo '<script> window.location = "inicio" </script>';
                    }
                } else {
                    echo '<br>
            <div class="alert alert-info alert-dismissible fade show">
            <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
            <strong>Error!</strong> Error al ingresar, vuelve a intentarlo
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
            </button>
            </div>';
                }
            }
        }
    }

    public static function ctrLogoutUsuario()
    {
        if (isset($_SESSION["idUsuario"])) {
            $idUsuario = $_SESSION["idUsuario"];
            $fechaActual = date("Y-m-d H:i:s");

            // Actualizar el estado a "offline" (0) y el último login
            $resultado = ModeloUsuarios::mdlActualizarEstadoYUltimoLogin($idUsuario, 0, $fechaActual);

            if ($resultado == "ok") {
                // Si la actualización fue exitosa, destruir la sesión
                session_destroy();

                // Redirigir al usuario a la página de login
                echo '<script> window.location = "login"; </script>';
            } else {
                // Si la actualización falló, mostrar un mensaje de error
                echo '<br>
            <div class="alert alert-danger alert-dismissible fade show">
            <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
            <strong>Error!</strong> Hubo un problema al cerrar sesión. Inténtalo de nuevo.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
            </button>
            </div>';
            }
        } else {
            // Si la sesión no está iniciada, redirigir directamente al login
            echo '<script> window.location = "login"; </script>';
        }
    }



    public static function ctrMostrarDatosUsuarioPorId($idUsuario)
    {
        $tabla = "usuario";
        $item = "id";
        $valor = $idUsuario;

        $respuesta = ModeloUsuarios::mdlMostrarUsuariosID($tabla, $item, $valor);

        return $respuesta;
    }


    public function ctrCrearUsuario()
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
            $estado = 0; // Estado activo por defecto
            $perfil = intval($_POST["nuevoPerfil"]); // Asegurarse de que el perfil es numérico

            $passwordEncriptado = password_hash($_POST["nuevoPassword"], PASSWORD_BCRYPT);

            $datos = array(
                "usuario" => $_POST["nuevoUsuario"],
                "password" => $passwordEncriptado, // Guardar la contraseña encriptada
                "perfil" => $perfil,
                "nombre" => $_POST["nuevoNombre"],
                "apellido" => $_POST["nuevoApellido"],
                "cedula" => $_POST["nuevoCedula"],
                "direccion" => $_POST["nuevaDireccion"], // Campo dirección
                "telefono" => $_POST["nuevoTelefono"], // Campo teléfono
                "foto" => $ruta,
                "estado" => $estado,
                "idSucursal" => $_POST["nuevaSucursal"],
                "token" => null  // Inicialmente nulo
            );

            $respuesta = ModeloUsuarios::mdlIngresarUsuario($tabla, $datos);

            if ($respuesta == "ok") {
                // Obtener el ID del usuario recién creado
                $idUsuario = ModeloUsuarios::mdlObtenerUltimoId($tabla);

                // Si el perfil es 5 (Empresa), generamos un token con el ID del usuario
                if ($perfil == 5) {
                    $payload = [
                        'iss' => "http://localhost/Proyecto-web-Encomiendas",
                        'aud' => "http://localhost/Proyecto-web-Encomiendas",
                        'iat' => time(),
                        'nbf' => time(),
                        'data' => [
                            'idUsuario' => $idUsuario,
                            'usuario' => $datos["usuario"],
                            'perfil' => 'empresa',
                        ]
                    ];

                    $token = JWT::encode($payload, $this->key, 'HS256');

                    // Actualizar el usuario con el token generado
                    ModeloUsuarios::mdlActualizarToken($idUsuario, $token);
                }

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
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

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

                $password = isset($_POST["editarPassword"]) && $_POST["editarPassword"] != "" ? $_POST["editarPassword"] : $_POST["passwordActual"];

                $datos = array(
                    "id" => $_POST["idUsuario"],
                    "nombre" => $_POST["editarNombre"],
                    "apellido" => $_POST["editarApellido"],
                    "cedula" => $_POST["editarCedula"],
                    "direccion" => $_POST["editarDireccion"],  // Incluir dirección
                    "telefono" => $_POST["editarTelefono"],    // Incluir teléfono
                    "usuario" => $_POST["editarUsuario"],
                    "password" => $password,
                    "perfil" => $_POST["editarPerfil"],
                    "foto" => $ruta
                );
                error_log(print_r($datos, true));

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
    public static function ctrEditarEmpresa()
    {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        if (isset($_POST["editarNombre"])) {
            if (preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarUsuario"])) {

                // Mantener la foto actual si no se sube una nueva
                $ruta = isset($_POST["fotoActual"]) ? $_POST["fotoActual"] : "vistas/img/predeterminado/images.png";

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
                            if (!empty($_POST["fotoActual"]) && $_POST["fotoActual"] != "vistas/img/predeterminado/images.png") {
                                unlink($_POST["fotoActual"]);
                            }
                        }
                    }
                }

                $tabla = "usuario";

                // Obtener la contraseña actual de la base de datos si no se ingresa una nueva
                if (isset($_POST["editarPassword"]) && !empty($_POST["editarPassword"])) {
                    $password = $_POST["editarPassword"];
                } else {
                    // Obtener la contraseña actual desde la base de datos
                    $usuario = ModeloUsuarios::mdlMostrarUsuarios($tabla, "id", $_POST["idUsuario"]);
                    $password = $usuario["password"];
                }

                $datos = array(
                    "id" => $_POST["idUsuario"],
                    "nombre" => $_POST["editarNombre"],
                    "cedula" => $_POST["editarCedula"],
                    "telefono" => $_POST["editarTelefono"],
                    "direccion" => $_POST["editarDireccion"],
                    "usuario" => $_POST["editarUsuario"],
                    "password" => $password,
                    "foto" => $ruta,
                );

                $respuesta = ModeloUsuarios::mdlEditarEmpresa($tabla, $datos);

                if ($respuesta == "ok") {
                    echo "<script>
                        window.addEventListener('load', function() {
                            toastr.success('La empresa ha sido editada correctamente', '¡Éxito!');
                            setTimeout(function() {
                                window.location = 'ajustes';
                            }, 2000);
                        });
                    </script>";
                } else {
                    echo "<script>
                        window.addEventListener('load', function() {
                            toastr.error('No se pudo editar la empresa.', 'Error');
                            setTimeout(function() {
                                window.location = 'ajustes';
                            }, 2000);
                        });
                    </script>";
                }
            }
        }
    }


    static public function ctrObtenerNombreEmpresa($userId)
    {
        $tabla = "usuario";  // Asumo que el nombre de la tabla es 'usuario'
        $item = "id";  // El campo que estás usando para buscar es 'id'
        $valor = $userId;

        $respuesta = ModeloUsuarios::mdlMostrarUsuarios($tabla, $item, $valor);
        if ($respuesta) {
            return $respuesta["nombre"];  // Aquí asumo que 'nombre' es el nombre de la empresa
        } else {
            return null;
        }
    }


    // Método para obtener los datos de un usuario por su ID
    public static function ctrObtenerUsuarioPorId($idUsuario)
    {
        $tabla = "usuario";
        $respuesta = ModeloUsuarios::mdlObtenerUsuarioPorId($tabla, $idUsuario);

        if ($respuesta) {
            return $respuesta;
        } else {
            error_log("No se encontró el usuario con ID: " . $idUsuario);
            return null;
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
    
}


