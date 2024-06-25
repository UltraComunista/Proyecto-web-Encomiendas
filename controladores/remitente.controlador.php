<?php

class ControladorRemitente
{
    /*=============================================
    MOSTRAR REMITENTES
    =============================================*/

    static public function ctrMostrarRemitentePorCedula($cedula) {
        $tabla = "cliente";
        $respuesta = ModeloRemitente::mdlMostrarRemitentePorCedula($tabla, $cedula);
        return $respuesta;
    }

    static public function ctrMostrarRemitente($item, $valor)
    {
        $tabla = "cliente";
        $respuesta = ModeloRemitente::mdlMostrarRemitente($tabla, $item, $valor);
        return $respuesta;
    }

    /*=============================================
    CREAR REMITENTE
    =============================================*/
    static public function ctrCrearRemitente()
    {
        if (isset($_POST["nuevoNombre"])) {
            if (preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoNombre"])) {
                $tabla = "cliente";
                $datos = array(
                    "cedula" => $_POST["nuevoCedula"],
                    "nombre" => $_POST["nuevoNombre"],
                    "direccion" => $_POST["nuevoDireccion"],
                    "telefono" => $_POST["nuevoTelefono"],
                    "tipo" => "remitente"
                );
    
                $respuesta = ModeloRemitente::mdlIngresarRemitente($tabla, $datos);
    
                if ($respuesta == "ok") {
                    echo "<script>
                    window.addEventListener('load', function() {
                        toastr.success('El remitente ha sido guardado correctamente', '¡Éxito!');
                        setTimeout(function() {
                            window.location = 'remitente';
                        }, 2000);
                    });
                    </script>";
                } else {
                    echo "<script>
                    window.addEventListener('load', function() {
                        toastr.error('No se pudo registrar el remitente.', 'Error');
                        setTimeout(function() {
                            window.location = 'remitente';
                        }, 2000);
                    });
                    </script>";
                }
            }
        }
    }
    

    /*=============================================
    EDITAR REMITENTE
    =============================================*/
    static public function ctrEditarRemitente()
    {
        if (isset($_POST["editarNombre"])) {
            if (preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarNombre"])) {
                $tabla = "cliente";
                $datos = array(
                    "cedula" => $_POST["editarCedula"],
                    "nombre" => $_POST["editarNombre"],
                    "direccion" => $_POST["editarDireccion"],
                    "telefono" => $_POST["editarTelefono"],
                    "id" => $_POST["idRemitente"]
                );

                $respuesta = ModeloRemitente::mdlEditarRemitente($tabla, $datos);

                if ($respuesta == "ok") {
                    echo "<script>
                    window.addEventListener('load', function() {
                        toastr.success('El remitente ha sido editado correctamente', '¡Éxito!');
                        setTimeout(function() {
                            window.location = 'remitente';
                        }, 2000);
                    });
                    </script>";
                } else {
                    echo "<script>
                    window.addEventListener('load', function() {
                        toastr.error('No se pudo editar el remitente.', 'Error');
                        setTimeout(function() {
                            window.location = 'remitente';
                        }, 2000);
                    });
                    </script>";
                }
            }
        }
    }

    /*=============================================
    BORRAR REMITENTE
    =============================================*/
    static public function ctrBorrarRemitente()
    {
        if (isset($_GET["idRemitente"])) {
            $tabla = "cliente";
            $idSucursal = $_GET["idRemitente"];

            $respuesta = ModeloRemitente::mdlBorrarRemitente($tabla, $idSucursal);

            if ($respuesta == "ok") {
                echo "<script>
                window.addEventListener('load', function() {
                    toastr.success('El remitente ha sido eliminada', '¡Éxito!');
                    setTimeout(function() {
                        window.location = 'remitente';
                    }, 2000);
                });
                </script>";
            } else {
                echo "<script>
                window.addEventListener('load', function() {
                    toastr.error('No se pudo eliminar el remitente.', 'Error');
                    setTimeout(function() {
                        window.location = 'remitente';
                    }, 2000);
                });
                </script>";
            }
        }
    }
}
