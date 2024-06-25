<?php

require_once "conexion.php";

class ModeloRemitente
{
    /*=============================================
    MOSTRAR REMITENTES
    =============================================*/
    static public function mdlMostrarRemitentePorCedula($tabla, $cedula) {
        $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE cedula = :cedula");
        $stmt->bindParam(":cedula", $cedula, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

   static public function mdlMostrarRemitente($tabla, $item, $valor)
{
    try {
        if ($item != null) {
            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
            $stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch();
        } else {
            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE tipo = 'remitente'");
            $stmt->execute();
            return $stmt->fetchAll();
        }
    } catch (PDOException $e) {
        echo "Error en la consulta: " . $e->getMessage();
        return false;
    }
    $stmt->close();
    $stmt = null;
}

    /*=============================================
    CREAR REMITENTE
    =============================================*/
    static public function mdlIngresarRemitente($tabla, $datos)
    {
        $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(cedula, nombre, direccion, telefono, tipo) VALUES (:cedula, :nombre, :direccion, :telefono, :tipo)");
        $stmt->bindParam(":cedula", $datos["cedula"], PDO::PARAM_STR);
        $stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
        $stmt->bindParam(":direccion", $datos["direccion"], PDO::PARAM_STR);
        $stmt->bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
        $stmt->bindParam(":tipo", $datos["tipo"], PDO::PARAM_STR);

        if ($stmt->execute()) {
            return "ok";
        } else {
            return "error";
        }
    }

    /*=============================================
    EDITAR REMITENTE
    =============================================*/
    static public function mdlEditarRemitente($tabla, $datos)
    {
        try {
            $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET cedula = :cedula, tipo = :tipo, nombre = :nombre, direccion = :direccion, telefono = :telefono WHERE id = :id");

            $stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);
            $stmt->bindParam(":cedula", $datos["cedula"], PDO::PARAM_STR);
            $stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
            $stmt->bindParam(":direccion", $datos["direccion"], PDO::PARAM_STR);
            $stmt->bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
            $stmt->bindParam(":tipo", $datos["tipo"], PDO::PARAM_STR);


            if ($stmt->execute()) {
                return "ok";
            } else {
                return "error";
            }
        } catch (PDOException $e) {
            echo "Error en la consulta: " . $e->getMessage();
            return false;
        }
        $stmt->close();
        $stmt = null;
    }

    /*=============================================
    BORRAR REMITENTE
    =============================================*/
    static public function mdlBorrarRemitente($tabla, $idSucursal)
    {
        try {
            $stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id");
            $stmt->bindParam(":id", $idSucursal, PDO::PARAM_INT);

            if ($stmt->execute()) {
                return "ok";
            } else {
                return "error";
            }
        } catch (PDOException $e) {
            echo "Error en la consulta: " . $e->getMessage();
            return false;
        }
        $stmt->close();
        $stmt = null;
    }
}
