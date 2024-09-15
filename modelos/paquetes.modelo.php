<?php

require_once "conexion.php";

class ModeloPaquetes
{
    public static function mdlObtenerEnviosPorUsuario($tabla, $idUsuario)
    {
        try {
            $stmt = Conexion::conectar()->prepare("
                SELECT rp.*, 
                       ce.nombre AS nombre_enviador, ce.cedula AS cedula_enviador, ce.telefono AS telefono_enviador, ce.direccion AS direccion_enviador,
                       cr.nombre AS nombre_destinatario, cr.cedula AS cedula_destinatario, cr.telefono AS telefono_destinatario, cr.direccion AS direccion_destinatario,
                       cs.nombre AS nombre_sucursal_salida, cs.direccion AS direccion_sucursal_salida,
                       cs2.nombre AS nombre_sucursal_llegada, cs2.direccion AS direccion_sucursal_llegada,
                       dp.descripcion, dp.cantidad, dp.precio, dp.tipo AS tipo_paquete,
                       u.usuario AS nombre_usuario_registro -- Aquí se agrega el nombre del usuario que registró el envío
                FROM $tabla rp
                INNER JOIN cliente ce ON rp.idclienteE = ce.id
                INNER JOIN cliente cr ON rp.idclienteR = cr.id
                INNER JOIN sucursal cs ON rp.idSucursalE = cs.id
                INNER JOIN sucursal cs2 ON rp.idSucursalR = cs2.id
                INNER JOIN detallePaquete dp ON rp.idDetalle = dp.id
                INNER JOIN usuario u ON rp.idUsuario = u.id -- Unión con la tabla de usuarios para obtener el nombre del usuario
                WHERE rp.idUsuario = :idUsuario
            ");

            $stmt->bindParam(":idUsuario", $idUsuario, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error en la consulta: " . $e->getMessage());
            return false;
        }

        // Cerrar el statement
        $stmt->close();
        $stmt = null;
    }

    public static function mdlMostrarEnviosRealizadosPorSucursal($sucursalReporte)
    {
        $stmt = Conexion::conectar()->prepare("
        SELECT re.*, e.nombre AS nombreSucursal, u.usuario AS nombreUsuario, en.fecha AS fechaEntrega
        FROM recepcionencomienda re
        LEFT JOIN sucursal e ON re.idSucursalE = e.id
        LEFT JOIN usuario u ON re.idUsuario = u.id
        LEFT JOIN entregaencomienda en ON re.id = en.idRecepcionEncomienda
        WHERE re.idSucursalE = :sucursalReporte
    ");
        $stmt->bindParam(":sucursalReporte", $sucursalReporte, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public static function mdlMostrarEnviosRecibidosPorSucursal($sucursalReporte)
    {
        $stmt = Conexion::conectar()->prepare("
            SELECT re.*, e.nombre AS nombreSucursal, u.usuario AS nombreUsuario
            FROM recepcionencomienda re
            LEFT JOIN sucursal e ON re.idSucursalR = e.id
            LEFT JOIN usuario u ON re.idUsuario = u.id
            WHERE re.idSucursalR = :sucursalReporte
        ");
        $stmt->bindParam(":sucursalReporte", $sucursalReporte, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function mdlMostrarEncomiendasEntregadasPorSucursal($sucursalReporte)
    {
        $stmt = Conexion::conectar()->prepare("
        SELECT re.*, en.fecha AS fechaEntrega, e.nombre AS nombreSucursal, u.usuario AS nombreUsuario
        FROM entregaencomienda en
        LEFT JOIN recepcionencomienda re ON en.idRecepcionEncomienda = re.id
        LEFT JOIN sucursal e ON re.idSucursalR = e.id
        LEFT JOIN usuario u ON en.idUsuario = u.id
        WHERE re.idSucursalR = :sucursalReporte
    ");
        $stmt->bindParam(":sucursalReporte", $sucursalReporte, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public static function mdlMostrarEncomiendasPendientesPorSucursal($sucursalReporte)
    {
        $stmt = Conexion::conectar()->prepare("
            SELECT re.*, e.nombre AS nombreSucursal, u.usuario AS nombreUsuario
            FROM recepcionencomienda re
            LEFT JOIN sucursal e ON re.idSucursalE = e.id
            LEFT JOIN usuario u ON re.idUsuario = u.id
            WHERE re.idSucursalE = :sucursalReporte AND re.estadoPaquete < 3
        ");
        $stmt->bindParam(":sucursalReporte", $sucursalReporte, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function mdlMostrarMovimientosGeneralesPorSucursal($sucursalReporte)
    {
        $stmt = Conexion::conectar()->prepare("
        SELECT re.*, en.fecha AS fechaEntrega, e.nombre AS nombreSucursal, u.usuario AS nombreUsuario
        FROM recepcionencomienda re
        LEFT JOIN entregaencomienda en ON re.id = en.idRecepcionEncomienda
        LEFT JOIN sucursal e ON re.idSucursalE = e.id OR re.idSucursalR = e.id
        LEFT JOIN usuario u ON re.idUsuario = u.id
        WHERE re.idSucursalE = :sucursalReporte OR re.idSucursalR = :sucursalReporte
    ");
        $stmt->bindParam(":sucursalReporte", $sucursalReporte, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

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

    public static function mdlMostrarEnviosPorEstado($estadoPaquete)
    {
        $stmt = Conexion::conectar()->prepare("
        SELECT re.*, e.nombre AS nombreSucursal, 
               IFNULL(u1.usuario, u2.usuario) AS nombreUsuario,
               IFNULL(u1.nombre, u2.nombre) AS nombreUsuarioNombre,
               IFNULL(u1.apellido, u2.apellido) AS apellidoUsuario,
               en.fecha AS fechaEntrega  -- Obtenemos la fecha de entrega
        FROM recepcionencomienda re
        LEFT JOIN sucursal e ON re.idSucursalR = e.id
        LEFT JOIN usuario u1 ON re.idUsuario = u1.id  -- Usuario que registró el envío
        LEFT JOIN entregaencomienda en ON re.id = en.idRecepcionEncomienda
        LEFT JOIN usuario u2 ON en.idUsuario = u2.id  -- Usuario que entregó el envío
        WHERE re.estadoPaquete = :estadoPaquete
    ");
        $stmt->bindParam(":estadoPaquete", $estadoPaquete, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }


    static public function mdlObtenerUltimoId($tabla)
    {
        $stmt = Conexion::conectar()->prepare("SELECT id FROM $tabla ORDER BY id DESC LIMIT 1");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['id'];
    }

    // REGISTRO DE PAQUETE
    //=============================================*/
    static public function mdlIngresarPaquete($tabla, $datos)
    {
        $db = Conexion::conectar();
        try {
            $db->beginTransaction();

            // Verificar si el usuario es una empresa (perfil = 5)
            $stmt = $db->prepare("SELECT perfil FROM usuario WHERE id = :idUsuario");
            $stmt->bindParam(":idUsuario", $datos["idUsuario"], PDO::PARAM_INT);
            $stmt->execute();
            $perfilUsuario = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($perfilUsuario['perfil'] == 5) {
                $idClienteE = $datos['idUsuario']; // Usamos el idUsuario como idclienteE
            } else {
                // Verificar si el cliente enviador ya existe
                $stmt = $db->prepare("SELECT id FROM cliente WHERE cedula = :cedulaE");
                $stmt->bindParam(":cedulaE", $datos["cedula_enviador"], PDO::PARAM_STR);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($result) {
                    $idClienteE = $result['id'];
                } else {
                    // Insertar datos del cliente enviador
                    $stmt = $db->prepare("INSERT INTO cliente (nombre, cedula, telefono, direccion) VALUES (:nombreE, :cedulaE, :telefonoE, :direccionE)");
                    $stmt->bindParam(":nombreE", $datos["nombre_enviador"], PDO::PARAM_STR);
                    $stmt->bindParam(":cedulaE", $datos["cedula_enviador"], PDO::PARAM_STR);
                    $stmt->bindParam(":telefonoE", $datos["telefono_enviador"], PDO::PARAM_STR);
                    $stmt->bindParam(":direccionE", $datos["direccion_enviador"], PDO::PARAM_STR);
                    $stmt->execute();
                    $idClienteE = $db->lastInsertId(); // Corrección aquí
                }
            }

            // Verificar si el cliente receptor ya existe
            $stmt = $db->prepare("SELECT id FROM cliente WHERE cedula = :cedulaR");
            $stmt->bindParam(":cedulaR", $datos["cedula_remitente"], PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                $idClienteR = $result['id'];
            } else {
                // Insertar datos del cliente receptor
                $stmt = $db->prepare("INSERT INTO cliente (nombre, cedula, telefono, direccion) VALUES (:nombreR, :cedulaR, :telefonoR, :direccionR)");
                $stmt->bindParam(":nombreR", $datos["nombre_remitente"], PDO::PARAM_STR);
                $stmt->bindParam(":cedulaR", $datos["cedula_remitente"], PDO::PARAM_STR);
                $stmt->bindParam(":telefonoR", $datos["telefono_remitente"], PDO::PARAM_STR);
                $stmt->bindParam(":direccionR", $datos["direccion_remitente"], PDO::PARAM_STR);
                $stmt->execute();
                $idClienteR = $db->lastInsertId(); // Corrección aquí
            }

            // Insertar datos en la tabla detallepaquete, incluyendo el peso
            $stmt = $db->prepare("INSERT INTO detallePaquete (descripcion, cantidad, precio, tipo, peso) VALUES (:descripcion, :cantidad, :precio, :tipo, :peso)");
            $stmt->bindParam(":descripcion", $datos["descripcion"], PDO::PARAM_STR);
            $stmt->bindParam(":cantidad", $datos["cantidad"], PDO::PARAM_INT);
            $stmt->bindParam(":precio", $datos["precio"], PDO::PARAM_STR);
            $stmt->bindParam(":tipo", $datos["tipoPaquete"], PDO::PARAM_INT);
            $stmt->bindParam(":peso", $datos["peso"], PDO::PARAM_STR); // Agregar el peso
            $stmt->execute();
            $idDetalle = $db->lastInsertId(); // Corrección aquí

            // Insertar datos en la tabla recepcionencomienda, incluyendo las sucursales y el usuario
            $stmt = $db->prepare("INSERT INTO $tabla (
        nro_registro, estadoPaquete, FechaRecepcion, TipoEnvio, EstadoPago, idclienteE, idclienteR, idSucursalR, idSucursalE, idDetalle, idUsuario
    ) VALUES (
        :nro_registro, :estadoPaquete, :FechaRecepcion, :TipoEnvio, :EstadoPago, :idclienteE, :idclienteR, :idSucursalR, :idSucursalE, :idDetalle, :idUsuario
    )");

            // Bind parameters
            $stmt->bindParam(":nro_registro", $datos["nro_registro"], PDO::PARAM_STR);
            $stmt->bindParam(":estadoPaquete", $datos["estadoPaquete"], PDO::PARAM_INT);
            $stmt->bindParam(":FechaRecepcion", $datos["fechaRecepcion"], PDO::PARAM_STR);
            $stmt->bindParam(":TipoEnvio", $datos["tipoEnvio"], PDO::PARAM_INT);
            $stmt->bindParam(":EstadoPago", $datos["estadoPago"], PDO::PARAM_INT);
            $stmt->bindParam(":idclienteE", $idClienteE, PDO::PARAM_INT);
            $stmt->bindParam(":idclienteR", $idClienteR, PDO::PARAM_INT);
            $stmt->bindParam(":idSucursalR", $datos["sucursalLlegada"], PDO::PARAM_INT);
            $stmt->bindParam(":idSucursalE", $datos["sucursalPartida"], PDO::PARAM_INT);
            $stmt->bindParam(":idDetalle", $idDetalle, PDO::PARAM_INT);
            $stmt->bindParam(":idUsuario", $datos["idUsuario"], PDO::PARAM_INT);

            // Log de consulta SQL
            error_log("Consulta SQL: " . $stmt->queryString);

            $stmt->execute();
            $db->commit();
            return "ok";
        } catch (PDOException $e) {
            $db->rollBack();
            echo "Error: " . $e->getMessage();
            return "error";
        }
    }


    public static function mdlIngresarPaqueteAPI($tabla, $datos)
    {
        $db = Conexion::conectar();
        try {
            $db->beginTransaction();

            // Registrar los datos que se van a usar para insertar
            error_log("Datos recibidos: " . print_r($datos, true) . "\n");

            // Verificar si el usuario es una empresa (perfil = 5)
            $stmt = $db->prepare("SELECT perfil FROM usuario WHERE id = :idUsuario");
            $stmt->bindParam(":idUsuario", $datos["idUsuario"], PDO::PARAM_INT);
            $stmt->execute();
            $perfilUsuario = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$perfilUsuario) {
                error_log("Error: No se encontró el perfil para el usuario con ID " . $datos["idUsuario"] . "\n");
                $db->rollBack();
                return "error";
            }

            if ($perfilUsuario['perfil'] == 5) {
                // Usamos el idUsuario como idclienteE
                $idClienteE = $datos['idUsuario'];

                // Verificar si la cédula del usuario existe en la tabla cliente
                $stmt = $db->prepare("SELECT id FROM cliente WHERE cedula = :cedula");
                $stmt->bindParam(":cedula", $datos['cedula_enviador'], PDO::PARAM_STR);
                $stmt->execute();
                $clienteEmpresa = $stmt->fetch(PDO::FETCH_ASSOC);

                if (!$clienteEmpresa) {
                    // Obtener datos del usuario como cliente
                    $usuario = ControladorUsuarios::ctrObtenerUsuarioPorId($datos['idUsuario']);
                    if (!$usuario) {
                        error_log("Error: No se encontró el usuario con ID " . $datos["idUsuario"] . "\n");
                        $db->rollBack();
                        return "error";
                    }

                    error_log("Datos del usuario empresa: " . print_r($usuario, true) . "\n");

                    // Si no existe, insertar la empresa como cliente
                    $stmt = $db->prepare("INSERT INTO cliente (nombre, cedula, telefono, direccion) VALUES (:nombre, :cedula, :telefono, :direccion)");
                    $stmt->bindParam(":nombre", $usuario["nombre"], PDO::PARAM_STR);
                    $stmt->bindParam(":cedula", $usuario["cedula"], PDO::PARAM_STR);
                    $stmt->bindParam(":telefono", $usuario["telefono"], PDO::PARAM_STR);
                    $stmt->bindParam(":direccion", $usuario["direccion"], PDO::PARAM_STR);
                    $stmt->execute();
                    $idClienteE = $db->lastInsertId();
                    error_log("Nueva empresa creada como cliente. ID: " . $idClienteE . "\n");
                } else {
                    $idClienteE = $clienteEmpresa['id'];
                    error_log("Empresa existente como cliente. ID: " . $idClienteE . "\n");
                }
            } else {
                // Verificar si el cliente enviador ya existe por cédula
                $stmt = $db->prepare("SELECT id FROM cliente WHERE cedula = :cedulaE");
                $stmt->bindParam(":cedulaE", $datos["cedula_enviador"], PDO::PARAM_STR);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($result) {
                    $idClienteE = $result['id'];
                    error_log("Cliente enviador existente. ID: " . $idClienteE . "\n");
                } else {
                    // Si no existe, insertar datos del cliente enviador
                    $stmt = $db->prepare("INSERT INTO cliente (nombre, cedula, telefono, direccion) VALUES (:nombreE, :cedulaE, :telefonoE, :direccionE)");
                    $stmt->bindParam(":nombreE", $datos["nombre_enviador"], PDO::PARAM_STR);
                    $stmt->bindParam(":cedulaE", $datos["cedula_enviador"], PDO::PARAM_STR);
                    $stmt->bindParam(":telefonoE", $datos["telefono_enviador"], PDO::PARAM_STR);
                    $stmt->bindParam(":direccionE", $datos["direccion_enviador"], PDO::PARAM_STR);
                    $stmt->execute();
                    $idClienteE = $db->lastInsertId();
                    error_log("Nuevo cliente enviador creado. ID: " . $idClienteE . "\n");
                }
            }

            // Verificar si el cliente receptor ya existe por cédula
            $stmt = $db->prepare("SELECT id FROM cliente WHERE cedula = :cedulaR");
            $stmt->bindParam(":cedulaR", $datos["cedula_remitente"], PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                $idClienteR = $result['id'];
                error_log("Cliente receptor existente. ID: " . $idClienteR . "\n");
            } else {
                // Si no existe, insertar datos del cliente receptor
                $stmt = $db->prepare("INSERT INTO cliente (nombre, cedula, telefono, direccion) VALUES (:nombreR, :cedulaR, :telefonoR, :direccionR)");
                $stmt->bindParam(":nombreR", $datos["nombre_remitente"], PDO::PARAM_STR);
                $stmt->bindParam(":cedulaR", $datos["cedula_remitente"], PDO::PARAM_STR);
                $stmt->bindParam(":telefonoR", $datos["telefono_remitente"], PDO::PARAM_STR);
                $stmt->bindParam(":direccionR", $datos["direccion_remitente"], PDO::PARAM_STR);
                $stmt->execute();
                $idClienteR = $db->lastInsertId();
                error_log("Nuevo cliente receptor creado. ID: " . $idClienteR . "\n");
            }

            // Insertar datos en la tabla detallepaquete
            $stmt = $db->prepare("INSERT INTO detallePaquete (descripcion, cantidad, precio, tipo, peso) VALUES (:descripcion, :cantidad, :precio, :tipo, :peso)");
            $stmt->bindParam(":descripcion", $datos["descripcion"], PDO::PARAM_STR);
            $stmt->bindParam(":cantidad", $datos["cantidad"], PDO::PARAM_INT);
            $stmt->bindParam(":precio", $datos["precio"], PDO::PARAM_STR);
            $stmt->bindParam(":tipo", $datos["tipoPaquete"], PDO::PARAM_INT);
            $stmt->bindParam(":peso", $datos["peso"], PDO::PARAM_STR); // Agregar el peso

            $stmt->execute();
            $idDetalle = $db->lastInsertId();
            error_log("Detalle del paquete creado. ID: " . $idDetalle . "\n");

            // Insertar datos en la tabla recepcionencomienda
            $stmt = $db->prepare("INSERT INTO $tabla (
            nro_registro, estadoPaquete, FechaRecepcion, TipoEnvio, EstadoPago, idclienteE, idclienteR, idSucursalR, idSucursalE, idDetalle, idUsuario
        ) VALUES (
            :nro_registro, :estadoPaquete, :FechaRecepcion, :TipoEnvio, :EstadoPago, :idclienteE, :idclienteR, :idSucursalR, :idSucursalE, :idDetalle, :idUsuario
        )");

            // Bind parameters
            $stmt->bindParam(":nro_registro", $datos["nro_registro"], PDO::PARAM_STR);
            $stmt->bindParam(":estadoPaquete", $datos["estadoPaquete"], PDO::PARAM_INT);
            $stmt->bindParam(":FechaRecepcion", $datos["fechaRecepcion"], PDO::PARAM_STR);
            $stmt->bindParam(":TipoEnvio", $datos["tipoEnvio"], PDO::PARAM_INT);
            $stmt->bindParam(":EstadoPago", $datos["estadoPago"], PDO::PARAM_INT);
            $stmt->bindParam(":idclienteE", $idClienteE, PDO::PARAM_INT);
            $stmt->bindParam(":idclienteR", $idClienteR, PDO::PARAM_INT);
            $stmt->bindParam(":idSucursalR", $datos["sucursalLlegada"], PDO::PARAM_INT);
            $stmt->bindParam(":idSucursalE", $datos["sucursalPartida"], PDO::PARAM_INT);
            $stmt->bindParam(":idDetalle", $idDetalle, PDO::PARAM_INT);
            $stmt->bindParam(":idUsuario", $datos["idUsuario"], PDO::PARAM_INT);

            // Registrar consulta SQL antes de ejecutar
            error_log("Consulta SQL: " . $stmt->queryString . "\n");

            $stmt->execute();
            $db->commit();
            error_log("Transacción completada exitosamente para el envío.\n");
            return "ok";
        } catch (PDOException $e) {
            $db->rollBack();
            error_log("Error en la transacción: " . $e->getMessage() . "\n");
            return "error";
        }
    }















    // MOSTRAR ENVÍOS POR USUARIO
    //=============================================*/
    static public function mdlMostrarEnviosPorUsuario($idUsuario)
    {
        $stmt = Conexion::conectar()->prepare("SELECT r.*, s.nombre AS nombreSucursal FROM recepcionencomienda r
                                            JOIN sucursal s ON r.idSucursalR = s.id
                                            WHERE r.idUsuario = :idUsuario");
        $stmt->bindParam(":idUsuario", $idUsuario, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Otros métodos del modelo...

    public static function mdlVerificarEstadoPago($tabla, $idPaquete)
    {
        try {
            $stmt = Conexion::conectar()->prepare("SELECT estadoPago FROM $tabla WHERE id = :id");
            $stmt->bindParam(":id", $idPaquete, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetch();
        } catch (PDOException $e) {
            echo "Error en la consulta: " . $e->getMessage();
            return false;
        }

        $stmt = null;
    }
    /*=============================================
    MOSTRAR SUCURSALES
    =============================================*/
    static public function mdlMostrarSucursales($tabla, $item, $valor)
    {
        $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
        $stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetch();

        $stmt->close();
        $stmt = null;
    }
    public static function mdlMostrarEntregasPorFecha($fechaInicio, $fechaFin)
    {
        try {
            $stmt = Conexion::conectar()->prepare("
            SELECT re.*, 
                   e.nombre AS nombreSucursal, 
                   u.usuario AS nombreUsuario, 
                   en.fecha AS fechaEntrega 
            FROM recepcionencomienda re
            INNER JOIN sucursal e ON re.idSucursalR = e.id
            INNER JOIN usuario u ON re.idUsuario = u.id
            LEFT JOIN entregaencomienda en ON re.id = en.idRecepcionEncomienda
            WHERE en.fecha BETWEEN :fechaInicio AND :fechaFin
        ");

            // Enlazar los parámetros con los valores
            $stmt->bindParam(":fechaInicio", $fechaInicio, PDO::PARAM_STR);
            $stmt->bindParam(":fechaFin", $fechaFin, PDO::PARAM_STR);

            // Ejecutar la consulta
            $stmt->execute();

            // Devolver los resultados
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error en la consulta: " . $e->getMessage();
            return false;
        }

        $stmt->close();
        $stmt = null;
    }


    static public function mdlMostrarPaquetes($tabla, $item, $valor)
    {
        try {
            if ($item != null) {
                $stmt = Conexion::conectar()->prepare("
            SELECT rp.*, 
                   ce.nombre AS nombre_enviador, ce.cedula AS cedula_enviador, ce.telefono AS telefono_enviador, ce.direccion AS direccion_enviador,
                   cr.nombre AS nombre_destinatario, cr.cedula AS cedula_destinatario, cr.telefono AS telefono_destinatario, cr.direccion AS direccion_destinatario,
                   cs.nombre AS nombre_sucursal_salida, cs.direccion AS direccion_sucursal_salida,
                   cs2.nombre AS nombre_sucursal_llegada, cs2.direccion AS direccion_sucursal_llegada,
                   dp.descripcion, dp.cantidad, dp.precio, dp.tipo AS tipo_paquete,
                   u.usuario AS nombre_usuario_registro -- Aquí se agrega el nombre del usuario que registró el envío
            FROM $tabla rp
            INNER JOIN cliente ce ON rp.idclienteE = ce.id
            INNER JOIN cliente cr ON rp.idclienteR = cr.id
            INNER JOIN sucursal cs ON rp.idSucursalE = cs.id
            INNER JOIN sucursal cs2 ON rp.idSucursalR = cs2.id
            INNER JOIN detallePaquete dp ON rp.idDetalle = dp.id
            INNER JOIN usuario u ON rp.idUsuario = u.id -- Unión con la tabla de usuarios para obtener el nombre del usuario
            WHERE rp.$item = :$item
        ");
                $stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);
                $stmt->execute();
                return $stmt->fetch();
            } else {
                $stmt = Conexion::conectar()->prepare("
            SELECT rp.*, 
                   ce.nombre AS nombre_enviador, ce.cedula AS cedula_enviador, ce.telefono AS telefono_enviador, ce.direccion AS direccion_enviador,
                   cr.nombre AS nombre_destinatario, cr.cedula AS cedula_destinatario, cr.telefono AS telefono_destinatario, cr.direccion AS direccion_destinatario,
                   cs.nombre AS nombre_sucursal_salida, cs.direccion AS direccion_sucursal_salida,
                   cs2.nombre AS nombre_sucursal_llegada, cs2.direccion AS direccion_sucursal_llegada,
                   dp.descripcion, dp.cantidad, dp.precio, dp.tipo AS tipo_paquete,
                   u.usuario AS nombre_usuario_registro -- Aquí se agrega el nombre del usuario que registró el envío
            FROM $tabla rp
            INNER JOIN cliente ce ON rp.idclienteE = ce.id
            INNER JOIN cliente cr ON rp.idclienteR = cr.id
            INNER JOIN sucursal cs ON rp.idSucursalE = cs.id
            INNER JOIN sucursal cs2 ON rp.idSucursalR = cs2.id
            INNER JOIN detallePaquete dp ON rp.idDetalle = dp.id
            INNER JOIN usuario u ON rp.idUsuario = u.id -- Unión con la tabla de usuarios para obtener el nombre del usuario
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




    static public function mdlActualizarPaquete($tabla, $datos)
    {
        $db = Conexion::conectar();

        try {
            $db->beginTransaction();

            // Actualizar el estado del paquete en recepcionencomienda
            $stmt = $db->prepare("UPDATE $tabla SET estadoPaquete = :estadoPaquete, EstadoPago = :estadoPago WHERE id = :id");
            $stmt->bindParam(":estadoPaquete", $datos["estadoPaquete"], PDO::PARAM_INT);
            $stmt->bindParam(":estadoPago", $datos["estadoPago"], PDO::PARAM_INT);
            $stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);

            if ($stmt->execute()) {
                // Registrar la entrega si el estado es "Entregado" (estadoPaquete = 3)
                if ($datos["estadoPaquete"] == 3) {
                    $stmtEntrega = $db->prepare("INSERT INTO entregaencomienda (fecha, idRecepcionEncomienda, idUsuario) VALUES (NOW(), :idRecepcionEncomienda, :idUsuario)");
                    $stmtEntrega->bindParam(":idRecepcionEncomienda", $datos["id"], PDO::PARAM_INT);
                    $stmtEntrega->bindParam(":idUsuario", $datos["idUsuario"], PDO::PARAM_INT);

                    if (!$stmtEntrega->execute()) {
                        $db->rollBack();
                        error_log("Error al registrar la entrega.");
                        return "error";
                    }
                }

                $db->commit();
                return "ok";
            } else {
                $db->rollBack();
                error_log("Error al actualizar el paquete.");
                return "error";
            }
        } catch (PDOException $e) {
            $db->rollBack();
            error_log("Error al actualizar paquete: " . $e->getMessage());
            return "error";
        }
    }
    static public function mdlActualizarEstadoPago($tabla, $idPaquete, $estadoPago)
    {
        try {
            $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET EstadoPago = :estadoPago WHERE id = :idPaquete");

            $stmt->bindParam(":estadoPago", $estadoPago, PDO::PARAM_INT);
            $stmt->bindParam(":idPaquete", $idPaquete, PDO::PARAM_INT);

            if ($stmt->execute()) {
                return "ok";
            } else {
                return "error";
            }
        } catch (PDOException $e) {
            error_log("Error al actualizar el estado de pago: " . $e->getMessage());
            return "error";
        }
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
}
