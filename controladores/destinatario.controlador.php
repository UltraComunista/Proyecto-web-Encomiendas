<?php

class ControladorDestinatarios
{
    static public function ctrMostrarDestinatarioPorCedula($cedula) {
        $tabla = "cliente";
        $respuesta = ModeloDestinatarios::mdlMostrarDestinatarioPorCedula($tabla, $cedula);
        return $respuesta;
    }

    static public function ctrCrearDestinatario()
    {
        if (isset($_POST["nuevoNombre"])) {
            if (preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoNombre"])) {
                $tabla = "cliente";
                $datos = array(
                    "cedula" => $_POST["nuevoCedula"],
                    "nombre" => $_POST["nuevoNombre"],
                    "direccion" => $_POST["nuevoDireccion"],
                    "telefono" => $_POST["nuevoTelefono"],
                    "tipo" => "destinatario"
                );
    
                $respuesta = ModeloDestinatarios::mdlIngresarDestinatario($tabla, $datos);
    
                if ($respuesta == "ok") {
                    echo "<script>
                    window.addEventListener('load', function() {
                        toastr.success('El destinatario ha sido guardado correctamente', '¡Éxito!');
                        setTimeout(function() {
                            window.location = 'destinatario';
                        }, 2000);
                    });
                    </script>";
                } else {
                    echo "<script>
                    window.addEventListener('load', function() {
                        toastr.error('No se pudo registrar el destinatario.', 'Error');
                        setTimeout(function() {
                            window.location = 'destinatario';
                        }, 2000);
                    });
                    </script>";
                }
            }
        }
    }
    

    static public function ctrMostrarDestinatarios($item, $valor)
    {
        $tabla = "cliente";
        $respuesta = ModeloDestinatarios::mdlMostrarDestinatario($tabla, $item, $valor);
        return $respuesta;
    }

    static public function ctrEditarDestinatario()
    {
        if (isset($_POST["editarCedula"])) {
            if (
                preg_match('/^[0-9]+$/', $_POST["editarCedula"]) &&
                preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarNombre"]) &&
                preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarDireccion"]) &&
                preg_match('/^[0-9]+$/', $_POST["editarTelefono"])
            ) {
                $tabla = "cliente";
                $datos = array(
                    "id" => $_POST["idDestinatario"],
                    "cedula" => $_POST["editarCedula"],
                    "nombre" => $_POST["editarNombre"],
                    "direccion" => $_POST["editarDireccion"],
                    "telefono" => $_POST["editarTelefono"],
                    "tipo" => "destinatario"
                );
                $respuesta = ModeloDestinatarios::mdlEditarDestinatario($tabla, $datos);
                if ($respuesta == "ok") {
                    echo "<script>
                    window.addEventListener('load', function() {
                        toastr.success('El destinatario ha sido editado correctamente', '¡Éxito!');
                        setTimeout(function() {
                            window.location = 'destinatario';
                        }, 2000);
                    });
                    </script>";
                } else {
                    echo "<script>
                    window.addEventListener('load', function() {
                        toastr.error('No se pudo editar el destinatario.', 'Error');
                        setTimeout(function() {
                            window.location = 'destinatario';
                        }, 2000);
                    });
                    </script>";
                }
            }
        }
    }

    static public function ctrBorrarDestinatario()
    {
        if (isset($_GET["idDestinatario"])) {
            $tabla = "cliente";
            $datos = $_GET["idDestinatario"];
            $respuesta = ModeloDestinatarios::mdlBorrarDestinatario($tabla, $datos);
            if ($respuesta == "ok") {
                echo "<script>
                window.addEventListener('load', function() {
                    toastr.success('El destinatario ha sido eliminado correctamente', '¡Éxito!');
                    setTimeout(function() {
                        window.location = 'destinatario';
                    }, 2000);
                });
                </script>";
            }
        }
    }
}
?>
