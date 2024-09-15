<?php

require_once "conexion.php";

class ModeloUsuarios
{
    static public function mdlMostrarUsuariosPorEstado($tabla, $estado)
    {
        $stmt = Conexion::conectar()->prepare("SELECT usuario.*, sucursal.nombre AS nombreSucursal 
                                           FROM $tabla 
                                           INNER JOIN sucursal ON usuario.idSucursal = sucursal.id 
                                           WHERE usuario.estado = :estado");

        $stmt->bindParam(":estado", $estado, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();

        $stmt->close();
        $stmt = null;
    }

    public static function mdlMostrarUsuariosID($tabla, $item, $valor)
    {
        if ($item != null) {
            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
            $stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);
            $stmt->execute();

            return $stmt->fetch();
        } else {
            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");
            $stmt->execute();

            return $stmt->fetchAll();
        }

        $stmt = null;
    }


    /*=============================================
MOSTRAR USUARIOS CON SUCURSAL
=============================================*/
    static public function mdlMostrarUsuarios($tabla, $item, $valor)
    {
        if ($item != null) {
            $stmt = Conexion::conectar()->prepare("SELECT usuario.*, sucursal.nombre AS nombreSucursal 
                                               FROM $tabla 
                                               INNER JOIN sucursal ON usuario.idSucursal = sucursal.id 
                                               WHERE usuario.$item = :$item");

            $stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);
            $stmt->execute();

            return $stmt->fetch();
        } else {
            $stmt = Conexion::conectar()->prepare("SELECT usuario.*, sucursal.nombre AS nombreSucursal 
                                               FROM $tabla 
                                               INNER JOIN sucursal ON usuario.idSucursal = sucursal.id");

            $stmt->execute();

            return $stmt->fetchAll();
        }

        $stmt->close();
        $stmt = null;
    }
    // Método para obtener los datos de un usuario por su ID
    public static function mdlObtenerUsuarioPorId($tabla, $idUsuario)
    {
        $stmt = Conexion::conectar()->prepare("SELECT id, usuario, nombre, apellido, cedula, telefono, direccion, perfil FROM $tabla WHERE id = :idUsuario");
        $stmt->bindParam(":idUsuario", $idUsuario, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function mdlObtenerUltimoId($tabla)
    {
        $stmt = Conexion::conectar()->prepare("SELECT MAX(id) as id FROM $tabla");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['id'];
    }

    public static function mdlActualizarToken($idUsuario, $token)
    {
        $stmt = Conexion::conectar()->prepare("UPDATE usuario SET token = :token WHERE id = :idUsuario");
        $stmt->bindParam(":token", $token, PDO::PARAM_STR);
        $stmt->bindParam(":idUsuario", $idUsuario, PDO::PARAM_INT);
        return $stmt->execute() ? "ok" : "error";
    }

    /*=============================================
CREAR USUARIO
=============================================*/
    static public function mdlIngresarUsuario($tabla, $datos)
    {
        $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(usuario, password, perfil, nombre, apellido, cedula, direccion, telefono, foto, estado, idSucursal, token) VALUES (:usuario, :password, :perfil, :nombre, :apellido, :cedula, :direccion, :telefono, :foto, :estado, :idSucursal, :token)");

        $stmt->bindParam(":usuario", $datos["usuario"], PDO::PARAM_STR);
        $stmt->bindParam(":password", $datos["password"], PDO::PARAM_STR);
        $stmt->bindParam(":perfil", $datos["perfil"], PDO::PARAM_INT);
        $stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
        $stmt->bindParam(":apellido", $datos["apellido"], PDO::PARAM_STR);
        $stmt->bindParam(":cedula", $datos["cedula"], PDO::PARAM_STR);
        $stmt->bindParam(":direccion", $datos["direccion"], PDO::PARAM_STR); // Bind de dirección
        $stmt->bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR); // Bind de teléfono
        $stmt->bindParam(":foto", $datos["foto"], PDO::PARAM_STR);
        $stmt->bindParam(":estado", $datos["estado"], PDO::PARAM_INT);
        $stmt->bindParam(":idSucursal", $datos["idSucursal"], PDO::PARAM_INT);
        $stmt->bindParam(":token", $datos["token"], PDO::PARAM_STR);  // Agregamos el token

        if ($stmt->execute()) {
            return "ok";
        } else {
            return "error";
        }

        $stmt->close();
        $stmt = null;
    }
    public static function mdlEditarEmpresa($tabla, $datos)
{
    $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET nombre = :nombre, cedula = :cedula, direccion = :direccion, telefono = :telefono, password = :password, foto = :foto, usuario = :usuario, perfil = 5 WHERE id = :id");

    $stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);
    $stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
    $stmt->bindParam(":cedula", $datos["cedula"], PDO::PARAM_STR);
    $stmt->bindParam(":direccion", $datos["direccion"], PDO::PARAM_STR);
    $stmt->bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
    $stmt->bindParam(":usuario", $datos["usuario"], PDO::PARAM_STR);
    $stmt->bindParam(":password", $datos["password"], PDO::PARAM_STR);
    $stmt->bindParam(":foto", $datos["foto"], PDO::PARAM_STR);

    if ($stmt->execute()) {
        return "ok";
    } else {
        return "error";
    }

    $stmt->close();
    $stmt = null;
}




    static public function mdlEditarUsuario($tabla, $datos)
    {
        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET nombre = :nombre, apellido = :apellido, cedula = :cedula, direccion = :direccion, telefono = :telefono, password = :password, perfil = :perfil, foto = :foto, usuario = :usuario WHERE id = :id");

        $stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);
        $stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
        $stmt->bindParam(":apellido", $datos["apellido"], PDO::PARAM_STR);
        $stmt->bindParam(":cedula", $datos["cedula"], PDO::PARAM_STR);
        $stmt->bindParam(":direccion", $datos["direccion"], PDO::PARAM_STR);  // Asignar dirección
        $stmt->bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);    // Asignar teléfono
        $stmt->bindParam(":usuario", $datos["usuario"], PDO::PARAM_STR);      // Asegurarse de que el usuario se actualiza
        $stmt->bindParam(":password", $datos["password"], PDO::PARAM_STR);
        $stmt->bindParam(":perfil", $datos["perfil"], PDO::PARAM_INT);
        $stmt->bindParam(":foto", $datos["foto"], PDO::PARAM_STR);

        if ($stmt->execute()) {
            error_log("SQL: " . $stmt->queryString);

            return "ok";
        } else {
            return "error";
        }
        error_log("SQL: " . $stmt->queryString);

        $stmt->close();
        $stmt = null;
    }





    static public function mdlBorrarUsuario($tabla, $datos)
    {
        $stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id");
        $stmt->bindParam(":id", $datos, PDO::PARAM_INT);
        if ($stmt->execute()) {
            return "ok";
        } else {
            return "error";
        }
        $stmt->close();
        $stmt = null;
    }

    public static function mdlActualizarEstadoYUltimoLogin($idUsuario, $estado, $fechaActual)
    {
        try {
            $stmt = Conexion::conectar()->prepare("UPDATE usuario SET estado = :estado, ultimoLogin = :ultimoLogin WHERE id = :id");

            $stmt->bindParam(":estado", $estado, PDO::PARAM_INT);
            $stmt->bindParam(":ultimoLogin", $fechaActual, PDO::PARAM_STR);
            $stmt->bindParam(":id", $idUsuario, PDO::PARAM_INT);

            if ($stmt->execute()) {
                // Log para verificar que la consulta se ejecutó correctamente
                error_log("Actualización exitosa para el usuario con ID $idUsuario. Estado establecido en $estado.");
                return "ok";
            } else {
                // Log en caso de que la ejecución de la consulta falle
                error_log("Error al ejecutar la consulta SQL para actualizar el estado del usuario con ID $idUsuario.");
                return "error";
            }
        } catch (PDOException $e) {
            // Log en caso de una excepción
            error_log("Excepción SQL: " . $e->getMessage());
            return "error";
        } finally {
            $stmt = null; // Cerrar conexión
        }
    }

    public static function mdlActualizarEstadoUsuario($idUsuario, $estado)
    {
        $ultimoLogin = ($estado == 0) ? date("Y-m-d H:i:s") : null;

        $stmt = Conexion::conectar()->prepare("UPDATE usuario SET estado = :estado, ultimoLogin = :ultimoLogin WHERE id = :id");
        $stmt->bindParam(":estado", $estado, PDO::PARAM_INT);
        $stmt->bindParam(":ultimoLogin", $ultimoLogin, PDO::PARAM_STR);
        $stmt->bindParam(":id", $idUsuario, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return "ok";
        } else {
            return "error";
        }

        $stmt->close();
        $stmt = null;
    }
}
