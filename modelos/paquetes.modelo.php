<?php

require_once "conexion.php";

class ModeloPaquetes
{
    /*=============================================
    OBTENER EL ÚLTIMO NÚMERO DE REGISTRO
    =============================================*/
    static public function mdlObtenerUltimoNumeroRegistro($tabla)
    {
        try {
            $stmt = Conexion::conectar()->prepare("SELECT MAX(nro_registro) AS ultimo_registro FROM $tabla");
            $stmt->execute();
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            return $resultado ? $resultado['ultimo_registro'] : 0;  // Devuelve 0 si no hay registros
        } catch (PDOException $e) {
            echo "Error en la consulta: " . $e->getMessage();
            return false;
        }
        $stmt->close();
        $stmt = null;
    }

    /*=============================================
CREAR PAQUETE
=============================================*/
static public function mdlIngresarPaquete($tabla, $datos) {
    $db = Conexion::conectar();
    try {
        $db->beginTransaction();

        // Verificar si el cliente enviador ya existe
        $stmt = $db->prepare("SELECT id FROM cliente WHERE cedula = :cedulaE AND tipo = 'remitente'");
        $stmt->bindParam(":cedulaE", $datos["cedula_enviador"], PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            $idClienteE = $result['id'];
        } else {
            // Insertar datos del cliente enviador
            $stmt = $db->prepare("INSERT INTO cliente (nombre, cedula, telefono, direccion, tipo) VALUES (:nombreE, :cedulaE, :telefonoE, :direccionE, 'remitente')");
            $stmt->bindParam(":nombreE", $datos["nombre_enviador"], PDO::PARAM_STR);
            $stmt->bindParam(":cedulaE", $datos["cedula_enviador"], PDO::PARAM_STR);
            $stmt->bindParam(":telefonoE", $datos["telefono_enviador"], PDO::PARAM_STR);
            $stmt->bindParam(":direccionE", $datos["direccion_enviador"], PDO::PARAM_STR);
            $stmt->execute();
            $idClienteE = $db->lastInsertId();
        }

        // Verificar si el cliente receptor ya existe
        $stmt = $db->prepare("SELECT id FROM cliente WHERE cedula = :cedulaR AND tipo = 'destinatario'");
        $stmt->bindParam(":cedulaR", $datos["cedula_remitente"], PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            $idClienteR = $result['id'];
        } else {
            // Insertar datos del cliente receptor
            $stmt = $db->prepare("INSERT INTO cliente (nombre, cedula, telefono, direccion, tipo) VALUES (:nombreR, :cedulaR, :telefonoR, :direccionR, 'destinatario')");
            $stmt->bindParam(":nombreR", $datos["nombre_remitente"], PDO::PARAM_STR);
            $stmt->bindParam(":cedulaR", $datos["cedula_remitente"], PDO::PARAM_STR);
            $stmt->bindParam(":telefonoR", $datos["telefono_remitente"], PDO::PARAM_STR);
            $stmt->bindParam(":direccionR", $datos["direccion_remitente"], PDO::PARAM_STR);
            $stmt->execute();
            $idClienteR = $db->lastInsertId();
        }

        // Insertar datos en la tabla detallepaquete
        $stmt = $db->prepare("INSERT INTO detallepaquete (descripcion, cantidad, precio) VALUES (:descripcion, :cantidad, :precio)");
        $stmt->bindParam(":descripcion", $datos["descripcion"], PDO::PARAM_STR);
        $stmt->bindParam(":cantidad", $datos["cantidad"], PDO::PARAM_INT);
        $stmt->bindParam(":precio", $datos["precio"], PDO::PARAM_STR);
        $stmt->execute();
        $idDetalle = $db->lastInsertId();

        // Insertar datos en la tabla recepcionpaquete, incluyendo las sucursales
        $stmt = $db->prepare("INSERT INTO $tabla (
        nro_registro, estadoPaquete, FechaRecepcion, TipoEnvio, EstadoPago, idclienteE, idclienteR, idSucursalR, idSucursalE, idDetalle
        ) VALUES (
        :nro_registro, :estadoPaquete, :FechaRecepcion, :TipoEnvio, :EstadoPago, :idclienteE, :idclienteR, :idSucursalR, :idSucursalE, :idDetalle
        )");

        // Bind parameters
        $stmt->bindParam(":nro_registro", $datos["nro_registro"], PDO::PARAM_STR);
        $stmt->bindParam(":estadoPaquete", $datos["estadoPaquete"], PDO::PARAM_STR);
        $stmt->bindParam(":FechaRecepcion", $datos["fechaRecepcion"], PDO::PARAM_STR);
        $stmt->bindParam(":TipoEnvio", $datos["tipoEnvio"], PDO::PARAM_STR);
        $stmt->bindParam(":EstadoPago", $datos["estadoPago"], PDO::PARAM_STR);
        $stmt->bindParam(":idclienteE", $idClienteE, PDO::PARAM_INT);
        $stmt->bindParam(":idclienteR", $idClienteR, PDO::PARAM_INT);
        $stmt->bindParam(":idSucursalR", $datos["sucursalLlegada"], PDO::PARAM_INT);
        $stmt->bindParam(":idSucursalE", $datos["sucursalPartida"], PDO::PARAM_INT);
        $stmt->bindParam(":idDetalle", $idDetalle, PDO::PARAM_INT);

        $stmt->execute();
        $db->commit();
        return "ok";
    } catch (Exception $e) {
        $db->rollBack();
        echo "Error: " . $e->getMessage();
        return "error";
    }
}







    /*=============================================
    MOSTRAR PAQUETES
    =============================================*/
    /*=============================================
MOSTRAR PAQUETES
=============================================*/
    static public function mdlMostrarPaquetes($tabla, $item, $valor)
    {
        try {
            if ($item != null) {
                $stmt = Conexion::conectar()->prepare("
                SELECT rp.*, ce.nombre AS nombre_enviador, cr.nombre AS nombre_destinatario, cs.nombre AS nombre_sucursal, dp.precio, dp.descripcion
                FROM $tabla rp
                INNER JOIN cliente ce ON rp.idclienteE = ce.id
                INNER JOIN cliente cr ON rp.idclienteR = cr.id
                INNER JOIN sucursal cs ON rp.idSucursalR = cs.id
                INNER JOIN detallepaquete dp ON rp.idDetalle = dp.id
                WHERE rp.$item = :$item
            ");
                $stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);
                $stmt->execute();
                return $stmt->fetch();
            } else {
                $stmt = Conexion::conectar()->prepare("
                SELECT rp.*, ce.nombre AS nombre_enviador, cr.nombre AS nombre_destinatario, cs.nombre AS nombre_sucursal, dp.precio, dp.descripcion
                FROM $tabla rp
                INNER JOIN cliente ce ON rp.idclienteE = ce.id
                INNER JOIN cliente cr ON rp.idclienteR = cr.id
                INNER JOIN sucursal cs ON rp.idSucursalR = cs.id
                INNER JOIN detallepaquete dp ON rp.idDetalle = dp.id
            ");
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
    EDITAR SUCURSAL
    =============================================*/
    static public function mdlEditarSucursal($tabla, $datos)
    {
        try {
            $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET nombre = :nombre, departamento = :departamento, telefono = :telefono WHERE id = :id");

            $stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);
            $stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
            $stmt->bindParam(":departamento", $datos["departamento"], PDO::PARAM_STR);
            $stmt->bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);

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
    BORRAR SUCURSAL
    =============================================*/
    static public function mdlBorrarSucursal($tabla, $idSucursal)
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

    /*=============================================
    ACTUALIZAR SUCURSAL
    =============================================*/
    static public function mdlActualizarSucursal($tabla, $item1, $valor1, $item2, $valor2)
    {
        try {
            $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item1 = :$item1 WHERE $item2 = :$item2");

            $stmt->bindParam(":" . $item1, $valor1, PDO::PARAM_STR);
            $stmt->bindParam(":" . $item2, $valor2, PDO::PARAM_STR);

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
