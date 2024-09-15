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
                    "departamento" => $_POST["nuevoDepartamento"],
                    "provincia" => $_POST["nuevaProvincia"],
                    "direccion" => $_POST["nuevaDireccion"],
                    "telefono" => $_POST["nuevoTelefono"],
                    "estado" => $_POST["nuevoEstado"]
                );

                $respuesta = ModeloSucursales::mdlIngresarSucursal($tabla, $datos);

                if ($respuesta == "ok") {
                    echo "<script>
                window.addEventListener('load', function() {
                    toastr.success('La sucursal ha sido guardada correctamente', '¡Éxito!');
                    setTimeout(function() {
                        window.location = 'sucursal';
                    }, 2000); // 2000 milisegundos = 2 segundos
                });
                </script>";
                } else {
                    echo "<script>
                window.addEventListener('load', function() {
                    toastr.error('No se pudo registrar la sucursal.', 'Error');
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
                    "direccion" => $_POST["editarDireccion"],
                    "telefono" => $_POST["editarTelefono"],
                    "estado" => $_POST["editarEstado"]
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
    /*=============================================
    OBTENER SUCURSALES
    =============================================*/
    public static function ctrObtenerSucursales($departamento, $provincia) {
        return ModeloSucursales::mdlObtenerSucursales("sucursal", $departamento, $provincia);
    }

    public static function ctrMostrarDepartamentos()
    {
        return ModeloSucursales::mdlMostrarDepartamentos();
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
