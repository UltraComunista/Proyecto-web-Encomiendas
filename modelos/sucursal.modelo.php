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
            return $stmt->fetch();
        } else {

            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");
            $stmt->execute();
            return $stmt->fetchAll();
        }

        $stmt->close();
        $stmt = null;
    }

    /*=============================================
    CREAR SUCURSAL
    =============================================*/

    static public function mdlIngresarSucursal($tabla, $datos)
    {

        $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(nombre, departamento, telefono, provincia) VALUES (:nombre, :departamento, :telefono, :provincia)");

        $stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
        $stmt->bindParam(":departamento", $datos["departamento"], PDO::PARAM_STR);
        $stmt->bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
        $stmt->bindParam(":provincia", $datos["provincia"], PDO::PARAM_STR);


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
        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET nombre = :nombre, departamento = :departamento, provincia = :provincia, telefono = :telefono WHERE id = :id");
    
        $stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);
        $stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
        $stmt->bindParam(":departamento", $datos["departamento"], PDO::PARAM_STR);
        $stmt->bindParam(":provincia", $datos["provincia"], PDO::PARAM_STR); // Asegúrate de agregar este campo
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

    public static function mdlObtenerSucursales($departamento, $provincia)
    {
        $stmt = Conexion::conectar()->prepare("SELECT id, nombre FROM sucursal WHERE departamento = :departamento AND provincia = :provincia");
        $stmt->bindParam(":departamento", $departamento, PDO::PARAM_STR);
        $stmt->bindParam(":provincia", $provincia, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    static public function mdlValidarNombreSucursal($tabla, $nombre, $idSucursal) {
        $db = Conexion::conectar();

        if ($idSucursal) {
            $stmt = $db->prepare("SELECT id FROM $tabla WHERE nombre = :nombre AND id != :idSucursal");
            $stmt->bindParam(":nombre", $nombre, PDO::PARAM_STR);
            $stmt->bindParam(":idSucursal", $idSucursal, PDO::PARAM_INT);
        } else {
            $stmt = $db->prepare("SELECT id FROM $tabla WHERE nombre = :nombre");
            $stmt->bindParam(":nombre", $nombre, PDO::PARAM_STR);
        }

        $stmt->execute();

        if ($stmt->fetch()) {
            return ["exists" => true];
        } else {
            return ["exists" => false];
        }

        $stmt->close();
        $stmt = null;
    }
    

    

}
