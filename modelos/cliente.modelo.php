<?php

require_once "conexion.php";

class ModeloClientes
{

    /*=============================================
    MOSTRAR CLIENTE POR ID
    =============================================*/
    static public function mdlMostrarClientePorId($tabla, $item, $valor)
    {
        $stmt = Conexion::conectar()->prepare("SELECT id, cedula, nombre, direccion, telefono FROM $tabla WHERE $item = :$item");
        $stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

    /*=============================================
    EDITAR CLIENTE
    =============================================*/
    static public function mdlEditarCliente($tabla, $datos)
    {
        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET cedula = :cedula, nombre = :nombre, direccion = :direccion, telefono = :telefono WHERE id = :id");

        // Agregar log para ver los valores que se van a bindear
        error_log("Datos que se están actualizando en la base de datos: " . json_encode($datos));

        $stmt->bindParam(":cedula", $datos["cedula"], PDO::PARAM_STR);
        $stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
        $stmt->bindParam(":direccion", $datos["direccion"], PDO::PARAM_STR);
        $stmt->bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
        $stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);

        if ($stmt->execute()) {
            return "ok";
        } else {
            // Log para ver el error de SQL si la consulta falla
            error_log("Error al ejecutar la consulta: " . implode(":", $stmt->errorInfo()));
            return "error";
        }

        $stmt->close();
        $stmt = null;
    }

    /*=============================================
    REGISTRAR CLIENTE
    =============================================*/
    static public function mdlIngresarCliente($tabla, $datos)
    {
        $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(cedula, nombre, direccion, telefono) VALUES (:cedula, :nombre, :direccion, :telefono)");

        $stmt->bindParam(":cedula", $datos["cedula"], PDO::PARAM_STR);
        $stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
        $stmt->bindParam(":direccion", $datos["direccion"], PDO::PARAM_STR);
        $stmt->bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);

        if ($stmt->execute()) {
            return "ok";
        } else {
            return "error";
        }

        $stmt->close();
        $stmt = null;
    }

    /*=============================================
    MOSTRAR CLIENTES
    =============================================*/
    static public function mdlMostrarClientes($tabla, $item = null, $valor = null)
    {
        if ($item != null) {
            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
            $stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);
            $stmt->execute();

            return $stmt->fetch(); // Esto devolverá un solo cliente
        } else {
            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");
            $stmt->execute();

            return $stmt->fetchAll(); // Esto devolverá todos los clientes
        }

        $stmt->close();
        $stmt = null;
    }
}
