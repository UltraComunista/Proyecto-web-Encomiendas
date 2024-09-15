<?php

class ControladorClientes
{
    /*=============================================
    MOSTRAR CLIENTE POR ID
    =============================================*/
    static public function ctrMostrarClientePorId($item, $valor)
    {
        $tabla = "cliente";
        $respuesta = ModeloClientes::mdlMostrarClientePorId($tabla, $item, $valor);
        return $respuesta;
    }
    /*=============================================
    REGISTRAR CLIENTE
    =============================================*/
    static public function ctrCrearCliente()
    {
        if (isset($_POST["nuevoCedula"])) {
            if (
                preg_match('/^[0-9]+$/', $_POST["nuevoCedula"]) &&
                preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoNombre"]) &&
                preg_match('/^[0-9]+$/', $_POST["nuevoTelefono"])
            ) {
                $tabla = "cliente";
                $datos = array(
                    "cedula" => $_POST["nuevoCedula"],
                    "nombre" => $_POST["nuevoNombre"],
                    "direccion" => $_POST["nuevoDireccion"],
                    "telefono" => $_POST["nuevoTelefono"]
                );

                $respuesta = ModeloClientes::mdlIngresarCliente($tabla, $datos);

                if ($respuesta == "ok") {
                    echo "<script>
                    window.addEventListener('load', function() {
                        toastr.success('El cliente ha sido guardado correctamente', '¡Éxito!');
                        setTimeout(function() {
                            window.location = 'cliente';
                        }, 2000);
                    });
                    </script>";
                } else {
                    echo "<script>
                    window.addEventListener('load', function() {
                        toastr.error('No se pudo registrar el cliente.', 'Error');
                        setTimeout(function() {
                            window.location = 'cliente';
                        }, 2000);
                    });
                    </script>";
                }
            } else {
                echo "<script>
                window.addEventListener('load', function() {
                    toastr.error('Datos inválidos.', 'Error');
                    setTimeout(function() {
                        window.location = 'cliente';
                    }, 2000);
                });
                </script>";
            }
        }
    }
    /*=============================================
    EDITAR CLIENTE
    =============================================*/
    static public function ctrEditarCliente()
    {
        if (isset($_POST["idCliente"])) {
            // Agregar log para ver los datos recibidos
            error_log("Datos recibidos para editar cliente: " . json_encode($_POST));

            if (preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarNombre"])) {

                $tabla = "cliente";
                $datos = array(
                    "id" => $_POST["idCliente"],
                    "cedula" => $_POST["editarCedula"],
                    "nombre" => $_POST["editarNombre"],
                    "direccion" => $_POST["editarDireccion"],
                    "telefono" => $_POST["editarTelefono"]
                );

                // Agregar log para ver los datos que se enviarán al modelo
                error_log("Datos preparados para actualizar cliente: " . json_encode($datos));

                $respuesta = ModeloClientes::mdlEditarCliente($tabla, $datos);

                if ($respuesta == "ok") {
                    echo "<script>
                    window.addEventListener('load', function() {
                        toastr.success('El cliente ha sido actualizado correctamente', '¡Éxito!');
                        setTimeout(function() {
                            window.location = 'cliente';
                        }, 2000);
                    });
                    </script>";
                } else {
                    echo "<script>
                    window.addEventListener('load', function() {
                        toastr.error('No se pudo actualizar el cliente.', 'Error');
                        setTimeout(function() {
                            window.location = 'cliente';
                        }, 2000);
                    });
                    </script>";
                }
            } else {
                echo "<script>
                window.addEventListener('load', function() {
                    toastr.error('Datos inválidos.', 'Error');
                    setTimeout(function() {
                        window.location = 'cliente';
                    }, 2000);
                });
                </script>";
            }
        }
    }


    /*=============================================
    MOSTRAR CLIENTES
    =============================================*/
    static public function ctrMostrarClientes($item = null, $valor = null)
    {
        $tabla = "cliente";
        $respuesta = ModeloClientes::mdlMostrarClientes($tabla, $item, $valor);
        return $respuesta;
    }
}
