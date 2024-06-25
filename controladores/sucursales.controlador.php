<?php

class ControladorSucursales
{
    /*=============================================
    MOSTRAR SUCURSALES
    =============================================*/
    static public function ctrMostrarSucursales($item, $valor)
    {
        $tabla = "sucursal";
        $respuesta = ModeloSucursales::mdlMostrarSucursales($tabla, $item, $valor);
        return $respuesta;
    }

    /*=============================================
    CREAR SUCURSAL
    =============================================*/
    static public function ctrCrearSucursal()
    {
        if (isset($_POST["nuevoNombre"])) {
            if (preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoNombre"])) {
                $tabla = "sucursal";
                $datos = array(
                    "nombre" => $_POST["nuevoNombre"],
                    "departamento" => $_POST["nuevaDepartamento"],
                    "provincia" => $_POST["nuevaProvincia"],
                    "telefono" => $_POST["nuevoTelefono"]
                );

                $respuesta = ModeloSucursales::mdlIngresarSucursal($tabla, $datos);

                if ($respuesta == "ok") {
                    echo "<script>
                    window.addEventListener('load', function() {
                        toastr.success('El sucursal ha sido guardado correctamente', '¡Éxito!');
                        setTimeout(function() {
                            window.location = 'sucursal';
                        }, 2000); // 2000 milisegundos = 2 segundos
                    });
                    </script>";
                } else {
                    echo "<script>
                    window.addEventListener('load', function() {
                        toastr.error('No se pudo registrar el sucursal.', 'Error');
                        setTimeout(function() {
                            window.location = 'sucursal';
                        }, 2000); // 2000 milisegundos = 2 segundos
                    });
                    </script>";
                }
            }
        }
    }

    /*=============================================
EDITAR SUCURSAL
=============================================*/
    static public function ctrEditarSucursal()
    {
        if (isset($_POST["editarNombre"])) {
            if (preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarNombre"])) {
                $tabla = "sucursal";
                $datos = array(
                    "id" => $_POST["idSucursal"],
                    "nombre" => $_POST["editarNombre"],
                    "departamento" => $_POST["editarDepartamento"],
                    "provincia" => $_POST["editarProvincia"],
                    "telefono" => $_POST["editarTelefono"]
                );

                $respuesta = ModeloSucursales::mdlEditarSucursal($tabla, $datos);

                if ($respuesta == "ok") {
                    echo "<script>
                window.addEventListener('load', function() {
                    toastr.success('La sucursal ha sido editada correctamente', '¡Éxito!');
                    setTimeout(function() {
                        window.location = 'sucursal';
                    }, 2000); // 2000 milisegundos = 2 segundos
                });
                </script>";
                } else {
                    echo "<script>
                window.addEventListener('load', function() {
                    toastr.error('No se pudo editar la sucursal.', 'Error');
                    setTimeout(function() {
                        window.location = 'sucursal';
                    }, 2000); // 2000 milisegundos = 2 segundos
                });
                </script>";
                }
            }
        }
    }


    /*=============================================
    BORRAR SUCURSAL
    =============================================*/
    static public function ctrBorrarSucursal()
    {
        if (isset($_GET["idSucursal"])) {
            $tabla = "sucursal";
            $idSucursal = $_GET["idSucursal"];

            $respuesta = ModeloSucursales::mdlBorrarSucursal($tabla, $idSucursal);

            if ($respuesta == "ok") {
                echo "<script>
                window.addEventListener('load', function() {
                    toastr.success('El sucursal ha sido eliminada', '¡Éxito!');
                    setTimeout(function() {
                        window.location = 'sucursal';
                    }, 2000); // 2000 milisegundos = 2 segundos
                });
                </script>";
            } else {
                echo "<script>
                window.addEventListener('load', function() {
                    toastr.error('No se pudo eliminar el sucursal.', 'Error');
                    setTimeout(function() {
                        window.location = 'sucursal';
                    }, 2000); // 2000 milisegundos = 2 segundos
                });
                </script>";
            }
        }
    }





    public static function ctrObtenerProvincias()
    {
        if (isset($_POST["departamento"])) {
            $departamento = $_POST["departamento"];
            $provincias = ModeloSucursales::mdlObtenerProvincias($departamento);
            echo json_encode($provincias);
        }
    }
    public static function ctrObtenerSucursales()
    {
        if (isset($_POST["departamento"]) && isset($_POST["provincia"])) {
            $departamento = $_POST["departamento"];
            $provincia = $_POST["provincia"];
            $sucursales = ModeloSucursales::mdlObtenerSucursales($departamento, $provincia);
            echo json_encode($sucursales);
        }
    }

    public static function ctrMostrarDepartamentos()
    {
        return ModeloSucursales::mdlMostrarDepartamentos();
    }
    static public function ctrValidarNombreSucursal($nombre, $idSucursal = null) {
        $tabla = "sucursal";
        $respuesta = ModeloSucursales::mdlValidarNombreSucursal($tabla, $nombre, $idSucursal);
        return $respuesta;
    }

    static public function ctrExisteSucursalPorTelefono($telefono)
    {
        $tabla = "sucursal";
        $item = "telefono";
        $valor = $telefono;
        $respuesta = ModeloSucursales::mdlMostrarSucursales($tabla, $item, $valor);
        return !empty($respuesta);
    }
}
