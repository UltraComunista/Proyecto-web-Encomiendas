<?php

require_once "conexion.php";

class ModeloDestinatarios
{
    static public function mdlMostrarDestinatarioPorCedula($tabla, $cedula) {
        $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE cedula = :cedula");
        $stmt->bindParam(":cedula", $cedula, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }
    
    /*=============================================
    INGRESAR DESTINATARIO
    =============================================*/
    static public function mdlIngresarDestinatario($tabla, $datos)
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
    MOSTRAR DESTINATARIOS
    =============================================*/
    static public function mdlMostrarDestinatario($tabla, $item, $valor)
{
    try {
        if ($item != null) {
            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
            $stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch();
        } else {
            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE tipo = 'destinatario'");
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
    EDITAR DESTINATARIO
    =============================================*/
    static public function mdlEditarDestinatario($tabla, $datos)
    {
        try {
            $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET cedula = :cedula, tipo = :tipo, nombre = :nombre, direccion = :direccion, telefono = :telefono WHERE id = :id");
            $stmt->bindParam(":cedula", $datos["cedula"], PDO::PARAM_STR);
            $stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
            $stmt->bindParam(":direccion", $datos["direccion"], PDO::PARAM_STR);
            $stmt->bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
            $stmt->bindParam(":tipo", $datos["tipo"], PDO::PARAM_STR);

            $stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);
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
    BORRAR DESTINATARIO
    =============================================*/
    static public function mdlBorrarDestinatario($tabla, $datos)
    {
        try {
            $stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id");
            $stmt->bindParam(":id", $datos, PDO::PARAM_INT);
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
?>
