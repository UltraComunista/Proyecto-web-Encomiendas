<?php

require_once "conexion.php";

class ModeloSucursales
{


    /*=============================================
    MOSTRAR SUCURSALES
    =============================================*/

    static public function mdlMostrarSucursales($tabla, $item, $valor)
    {
        if ($item != null) {
            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
            $stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC); // Cambiar fetch() a fetch(PDO::FETCH_ASSOC)
        } else {
            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC); // Cambiar fetchAll() a fetchAll(PDO::FETCH_ASSOC)
        }

        $stmt->close();
        $stmt = null;
    }

    /*=============================================
CREAR SUCURSAL
=============================================*/
    static public function mdlIngresarSucursal($tabla, $datos)
    {
        $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(nombre, departamento, provincia, direccion, telefono, estado) VALUES (:nombre, :departamento, :provincia, :direccion, :telefono, :estado)");

        $stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
        $stmt->bindParam(":departamento", $datos["departamento"], PDO::PARAM_INT);
        $stmt->bindParam(":provincia", $datos["provincia"], PDO::PARAM_INT);
        $stmt->bindParam(":direccion", $datos["direccion"], PDO::PARAM_STR);
        $stmt->bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
        $stmt->bindParam(":estado", $datos["estado"], PDO::PARAM_INT);

        if ($stmt->execute()) {
            return "ok";
        } else {
            return "error";
        }

        $stmt->close();
        $stmt = null;
    }

    /*=============================================
    EDITAR SUCURSAL
=============================================*/
    static public function mdlEditarSucursal($tabla, $datos)
    {
        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET nombre = :nombre, departamento = :departamento, provincia = :provincia, direccion = :direccion, telefono = :telefono, estado = :estado WHERE id = :id");

        $stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);
        $stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
        $stmt->bindParam(":departamento", $datos["departamento"], PDO::PARAM_INT);
        $stmt->bindParam(":provincia", $datos["provincia"], PDO::PARAM_INT);
        $stmt->bindParam(":direccion", $datos["direccion"], PDO::PARAM_STR);
        $stmt->bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
        $stmt->bindParam(":estado", $datos["estado"], PDO::PARAM_INT);

        if ($stmt->execute()) {
            return "ok";
        } else {
            return "error";
        }

        $stmt->close();
        $stmt = null;
    }



    /*=============================================
    BORRAR SUCURSAL
    =============================================*/

    static public function mdlBorrarSucursal($tabla, $idSucursal)
    {
        $stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id");
        $stmt->bindParam(":id", $idSucursal, PDO::PARAM_INT);

        if ($stmt->execute()) {

            return "ok";
        } else {

            return "error";
        }
        $stmt->close();
        $stmt = null;
    }
    static public function mdlActualizarSucurasl($tabla, $item1, $valor1, $item2, $valor2)
    {

        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item1 = :$item1 WHERE $item2 = :$item2");

        $stmt->bindParam(":" . $item1, $valor1, PDO::PARAM_STR);
        $stmt->bindParam(":" . $item2, $valor2, PDO::PARAM_STR);

        if ($stmt->execute()) {

            return "ok";
        } else {

            return "error";
        }

        $stmt->close();

        $stmt = null;
    }


    public static function mdlObtenerProvincias($departamento)
    {
        $stmt = Conexion::conectar()->prepare("SELECT DISTINCT provincia FROM sucursal WHERE departamento = :departamento");
        $stmt->bindParam(":departamento", $departamento, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function mdlMostrarDepartamentos()
    {
        $stmt = Conexion::conectar()->prepare("SELECT DISTINCT departamento FROM sucursal");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    static public function mdlObtenerSucursales($tabla, $departamento, $provincia)
    {
        try {
            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE departamento = :departamento AND provincia = :provincia");
            $stmt->bindParam(":departamento", $departamento, PDO::PARAM_INT);
            $stmt->bindParam(":provincia", $provincia, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return array();
        }
    }
}
