-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 12-06-2024 a las 23:58:22
-- Versión del servidor: 8.0.36-0ubuntu0.22.04.1
-- Versión de PHP: 8.1.2-1ubuntu2.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `dbshalom`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `id` int NOT NULL,
  `nombre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `cedula` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tipo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `telefono` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `direccion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`id`, `nombre`, `cedula`, `tipo`, `telefono`, `direccion`) VALUES
(1, 'Juan Pérez', '12345678', 'remitente', '789456123', 'Calle 1, La Paz'),
(2, 'María López', '23456789', 'remitente', '987654321', 'Calle 2, Santa Cruz'),
(3, 'Carlos García', '34567890', 'remitente', '654321987', 'Calle 3, Cochabamba'),
(4, 'Ana Torres', '45678901', 'remitente', '321987654', 'Calle 4, Sucre'),
(5, 'Luis Gómez', '56789012', 'remitente', '741852963', 'Calle 5, Potosí'),
(6, 'Sofía Rodríguez', '67890123', 'remitente', '852963741', 'Calle 6, Oruro'),
(7, 'Miguel Martínez', '78901234', 'remitente', '963741852', 'Calle 7, Beni'),
(8, 'Laura Fernández', '89012345', 'remitente', '159753486', 'Calle 8, Pando'),
(9, 'Jorge Ramírez', '90123456', 'remitente', '357159486', 'Calle 9, Tarija'),
(10, 'Valeria Díaz', '01234567', 'remitente', '951753486', 'Calle 10, La Paz'),
(11, 'Pedro Castillo', '11234567', 'remitente', '753951486', 'Calle 11, Santa Cruz'),
(12, 'Elena Morales', '12234567', 'remitente', '159357486', 'Calle 12, Cochabamba'),
(13, 'Ricardo Vargas', '13234567', 'remitente', '357951486', 'Calle 13, Sucre'),
(14, 'Natalia Ortiz', '14234567', 'remitente', '753159486', 'Calle 14, Potosí'),
(15, 'Fernando Rojas', '15234567', 'remitente', '951357486', 'Calle 15, Oruro'),
(16, 'Gabriela Herrera', '16234567', 'remitente', '357753486', 'Calle 16, Beni'),
(17, 'Andrés Sánchez', '17234567', 'remitente', '159753486', 'Calle 17, Pando'),
(18, 'Claudia Romero', '18234567', 'remitente', '753951486', 'Calle 18, Tarija'),
(19, 'Pablo Vargas', '19234567', 'remitente', '951753486', 'Calle 19, La Paz'),
(20, 'Teresa Medina', '20234567', 'remitente', '357159486', 'Calle 20, Santa Cruz'),
(21, 'Diego Paredes', '21234567', 'remitente', '951357486', 'Calle 21, Cochabamba'),
(22, 'Luz Romero', '22234567', 'remitente', '753159486', 'Calle 22, Sucre'),
(23, 'Ramón Castro', '23234567', 'remitente', '159357486', 'Calle 23, Potosí'),
(24, 'Carmen Núñez', '24234567', 'remitente', '357753486', 'Calle 24, Oruro'),
(25, 'Esteban Rivera', '25234567', 'remitente', '753951486', 'Calle 25, Beni'),
(26, 'Gloria Guzmán', '26234567', 'remitente', '951753486', 'Calle 26, Pando'),
(27, 'Luis Mendoza', '27234567', 'remitente', '357159486', 'Calle 27, Tarija'),
(28, 'Marcela Flores', '28234567', 'remitente', '951357486', 'Calle 28, La Paz'),
(29, 'Oscar Salinas', '29234567', 'remitente', '753159486', 'Calle 29, Santa Cruz'),
(30, 'Paola Cabrera', '30234567', 'remitente', '159357486', 'Calle 30, Cochabamba'),
(31, 'Mateo Fernández', '41234567', 'destinatario', '789123456', 'Calle 31, La Paz'),
(32, 'Daniela Sánchez', '42234567', 'destinatario', '987321654', 'Calle 32, Santa Cruz'),
(33, 'Sebastián Gómez', '43234567', 'destinatario', '654987321', 'Calle 33, Cochabamba'),
(34, 'Martina López', '44234567', 'destinatario', '321654987', 'Calle 34, Sucre'),
(35, 'Lucas Martínez', '45234567', 'destinatario', '741963852', 'Calle 35, Potosí'),
(36, 'Isabella Rodríguez', '46234567', 'destinatario', '852741963', 'Calle 36, Oruro'),
(37, 'Emiliano Ramírez', '47234567', 'destinatario', '963852741', 'Calle 37, Beni'),
(38, 'Valentina Romero', '48234567', 'destinatario', '159486753', 'Calle 38, Pando'),
(39, 'Santiago Ortiz', '49234567', 'destinatario', '357486159', 'Calle 39, Tarija'),
(40, 'Sofía Pérez', '50234567', 'destinatario', '951486753', 'Calle 40, La Paz'),
(41, 'Dylan Vargas', '51234567', 'destinatario', '753951486', 'Calle 41, Santa Cruz'),
(42, 'Camila Morales', '52234567', 'destinatario', '159753486', 'Calle 42, Cochabamba'),
(43, 'Diego Rojas', '53234567', 'destinatario', '357951486', 'Calle 43, Sucre'),
(44, 'Mía Herrera', '54234567', 'destinatario', '753159486', 'Calle 44, Potosí'),
(45, 'Benjamin Sánchez', '55234567', 'destinatario', '951357486', 'Calle 45, Oruro'),
(46, 'Antonella Vargas', '56234567', 'destinatario', '357753486', 'Calle 46, Beni'),
(47, 'Tomás Romero', '57234567', 'destinatario', '159753486', 'Calle 47, Pando'),
(48, 'Sara Romero', '58234567', 'destinatario', '753951486', 'Calle 48, Tarija'),
(49, 'Thiago Medina', '59234567', 'destinatario', '951753486', 'Calle 49, La Paz'),
(50, 'Aitana Torres', '60234567', 'destinatario', '357159486', 'Calle 50, Santa Cruz'),
(51, 'Maximiliano López', '61234567', 'destinatario', '951357486', 'Calle 51, Cochabamba'),
(52, 'Victoria Fernández', '62234567', 'destinatario', '753159486', 'Calle 52, Sucre'),
(53, 'Samuel Castro', '63234567', 'destinatario', '159357486', 'Calle 53, Potosí'),
(54, 'Luna Núñez', '64234567', 'destinatario', '357753486', 'Calle 54, Oruro'),
(55, 'Leonardo Rivera', '65234567', 'destinatario', '753951486', 'Calle 55, Beni'),
(56, 'Julia Guzmán', '66234567', 'destinatario', '951753486', 'Calle 56, Pando'),
(57, 'Gabriel Mendoza', '67234567', 'destinatario', '357159486', 'Calle 57, Tarija'),
(58, 'Claudia Flores', '68234567', 'destinatario', '951357486', 'Calle 58, La Paz'),
(59, 'Mario Salinas', '69234567', 'destinatario', '753159486', 'Calle 59, Santa Cruz'),
(60, 'Jazmín Cabrera', '70234567', 'destinatario', '159357486', 'Calle 60, Cochabamba'),
(72, 'Jhonatan Echeverria', '12599229', 'remitente', '727131782', 'Balcon 2'),
(73, 'Julia Estrada', '3986156014', 'destinatario', '784845181', 'Melchor pinto');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detallepaquete`
--

CREATE TABLE `detallepaquete` (
  `id` int NOT NULL,
  `descripcion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `cantidad` int DEFAULT NULL,
  `tipo` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detallepaquete`
--

INSERT INTO `detallepaquete` (`id`, `descripcion`, `cantidad`, `tipo`, `precio`) VALUES
(1, 'Electrodomésticos', 10, 'Electrónico', '15.00'),
(2, 'Ropa', 20, 'Textil', '20.00'),
(3, 'Libros', 5, 'Oficina', '25.00'),
(4, 'Juguetes', 30, 'Hogar', '30.00'),
(5, 'Computadoras', 8, 'Electrónico', '15.00'),
(6, 'Muebles', 12, 'Hogar', '20.00'),
(7, 'Herramientas', 6, 'Jardinería', '25.00'),
(8, 'Accesorios de Auto', 18, 'Automotriz', '30.00'),
(9, 'Ropa Deportiva', 22, 'Deportivo', '15.00'),
(10, 'Juguetes Educativos', 7, 'Educativo', '20.00'),
(11, 'Electrónica de Consumo', 14, 'Electrónico', '25.00'),
(12, 'Calzado', 16, 'Textil', '30.00'),
(13, 'Instrumentos Musicales', 4, 'Musical', '15.00'),
(14, 'Artículos de Cocina', 25, 'Hogar', '20.00'),
(15, 'Muebles de Oficina', 11, 'Oficina', '25.00'),
(16, 'Herramientas Eléctricas', 9, 'Jardinería', '30.00'),
(17, 'Repuestos de Autos', 17, 'Automotriz', '15.00'),
(18, 'Equipo Deportivo', 23, 'Deportivo', '20.00'),
(19, 'Material Escolar', 6, 'Educativo', '25.00'),
(20, 'Cámaras y Accesorios', 10, 'Electrónico', '30.00'),
(21, 'Juguetes Electrónicos', 19, 'Electrónico', '15.00'),
(22, 'Accesorios para Mascotas', 13, 'Hogar', '20.00'),
(23, 'Artículos para el Hogar', 5, 'Hogar', '25.00'),
(24, 'Ropa Casual', 21, 'Textil', '30.00'),
(25, 'Libros Técnicos', 3, 'Oficina', '15.00'),
(26, 'Artículos de Jardinería', 27, 'Jardinería', '20.00'),
(27, 'Piezas de Bicicleta', 15, 'Automotriz', '25.00'),
(28, 'Juguetes para Bebés', 9, 'Educativo', '30.00'),
(29, 'Gadgets Electrónicos', 20, 'Electrónico', '15.00'),
(30, 'Equipos de Camping', 14, 'Deportivo', '20.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entregapaquete`
--

CREATE TABLE `entregapaquete` (
  `id` int NOT NULL,
  `fecha` date DEFAULT NULL,
  `idusuario` int DEFAULT NULL,
  `id_paquete` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recepcionpaquete`
--

CREATE TABLE `recepcionpaquete` (
  `id` int NOT NULL,
  `nro_registro` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `estadoPaquete` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `FechaRecepcion` datetime DEFAULT NULL,
  `TipoEnvio` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `EstadoPago` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `idclienteE` int DEFAULT NULL,
  `idclienteR` int DEFAULT NULL,
  `idSucursalR` int DEFAULT NULL,
  `idSucursalE` int DEFAULT NULL,
  `idDetalle` int DEFAULT NULL,
  `idUsuario` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `recepcionpaquete`
--

INSERT INTO `recepcionpaquete` (`id`, `nro_registro`, `estadoPaquete`, `FechaRecepcion`, `TipoEnvio`, `EstadoPago`, `idclienteE`, `idclienteR`, `idSucursalR`, `idSucursalE`, `idDetalle`, `idUsuario`) VALUES
(1, '1', 'En tránsito', '2024-01-01 08:00:00', 'Normal', 'Pagado', 1, 1, 2, 3, 1, NULL),
(2, '2', 'Entregado', '2024-01-02 09:00:00', 'Domiciliario', 'Debe', 2, 2, 3, 1, 2, NULL),
(3, '3', 'En tránsito', '2024-01-03 10:00:00', 'Normal', 'Pagado', 3, 3, 4, 3, 3, NULL),
(4, '4', 'Entregado', '2024-01-04 11:00:00', 'Domiciliario', 'Debe', 4, 4, 5, 2, 4, NULL),
(5, '5', 'En tránsito', '2024-01-05 12:00:00', 'Normal', 'Pagado', 5, 5, 6, 3, 5, NULL),
(6, '6', 'Entregado', '2024-01-06 13:00:00', 'Domiciliario', 'Debe', 6, 6, 7, 1, 6, NULL),
(7, '7', 'En tránsito', '2024-01-07 14:00:00', 'Normal', 'Pagado', 7, 7, 8, 2, 7, NULL),
(8, '8', 'Entregado', '2024-01-08 15:00:00', 'Domiciliario', 'Debe', 8, 8, 9, 4, 8, NULL),
(9, '9', 'En tránsito', '2024-01-09 16:00:00', 'Normal', 'Pagado', 9, 9, 1, 1, 9, NULL),
(10, '1', 'Entregado', '2024-01-10 17:00:00', 'Domiciliario', 'Debe', 1, 1, 2, 2, 10, NULL),
(11, '2', 'En tránsito', '2024-01-11 18:00:00', 'Normal', 'Pagado', 2, 2, 3, 3, 11, NULL),
(12, '3', 'Entregado', '2024-01-12 19:00:00', 'Domiciliario', 'Debe', 3, 3, 4, 4, 12, NULL),
(13, '4', 'En tránsito', '2024-01-13 20:00:00', 'Normal', 'Pagado', 4, 4, 5, 1, 13, NULL),
(14, '5', 'Entregado', '2024-01-14 21:00:00', 'Domiciliario', 'Debe', 5, 5, 6, 2, 14, NULL),
(15, '6', 'En tránsito', '2024-01-15 22:00:00', 'Normal', 'Pagado', 6, 6, 7, 3, 15, NULL),
(16, '7', 'Entregado', '2024-01-16 23:00:00', 'Domiciliario', 'Debe', 7, 7, 8, 4, 16, NULL),
(17, '8', 'En tránsito', '2024-01-17 08:00:00', 'Normal', 'Pagado', 8, 8, 9, 1, 17, NULL),
(18, '9', 'Entregado', '2024-01-18 09:00:00', 'Domiciliario', 'Debe', 9, 9, 1, 2, 18, NULL),
(19, '1', 'En tránsito', '2024-01-19 10:00:00', 'Normal', 'Pagado', 1, 1, 2, 3, 19, NULL),
(20, '2', 'Entregado', '2024-01-20 11:00:00', 'Domiciliario', 'Debe', 2, 2, 3, 4, 20, NULL),
(21, '3', 'En tránsito', '2024-01-21 12:00:00', 'Normal', 'Pagado', 3, 3, 4, 1, 21, NULL),
(22, '4', 'Entregado', '2024-01-22 13:00:00', 'Domiciliario', 'Debe', 4, 4, 5, 2, 22, NULL),
(23, '5', 'En tránsito', '2024-01-23 14:00:00', 'Normal', 'Pagado', 5, 5, 6, 3, 23, NULL),
(24, '6', 'Entregado', '2024-01-24 15:00:00', 'Domiciliario', 'Debe', 6, 6, 7, 4, 24, NULL),
(25, '7', 'En tránsito', '2024-01-25 16:00:00', 'Normal', 'Pagado', 7, 7, 8, 1, 25, NULL),
(26, '8', 'Entregado', '2024-01-26 17:00:00', 'Domiciliario', 'Debe', 8, 8, 9, 2, 26, NULL),
(27, '9', 'En tránsito', '2024-01-27 18:00:00', 'Normal', 'Pagado', 9, 9, 1, 3, 27, NULL),
(28, '1', 'Entregado', '2024-01-28 19:00:00', 'Domiciliario', 'Debe', 1, 1, 2, 4, 28, NULL),
(29, '2', 'En tránsito', '2024-01-29 20:00:00', 'Normal', 'Pagado', 2, 2, 3, 1, 29, NULL),
(30, '3', 'Entregado', '2024-01-30 21:00:00', 'Domiciliario', 'Debe', 3, 3, 4, 2, 30, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sucursal`
--

CREATE TABLE `sucursal` (
  `id` int NOT NULL,
  `nombre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `departamento` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `provincia` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `direccion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `telefono` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `estado` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `sucursal`
--

INSERT INTO `sucursal` (`id`, `nombre`, `departamento`, `provincia`, `direccion`, `telefono`, `estado`) VALUES
(1, 'Sucursal La Paz Centro', 'La Paz', 'Murillo', NULL, '69123450', '1'),
(2, 'Sucursal El Alto', 'La Paz', 'Murillo', NULL, '69123451', '1'),
(3, 'Sucursal Cochabamba Centro', 'Cochabamba', 'Cercado', NULL, '69123452', '1'),
(4, 'Sucursal Quillacollo', 'Cochabamba', 'Quillacollo', NULL, '69123453', '1'),
(5, 'Sucursal Santa Cruz Centro', 'Santa Cruz', 'Andrés Ibáñez', NULL, '69123454', '1'),
(6, 'Sucursal Montero', 'Santa Cruz', 'Obispo Santistevan', NULL, '69123455', '1'),
(7, 'Sucursal Sucre Centro', 'Chuquisaca', 'Oropeza', NULL, '69123456', '1'),
(8, 'Sucursal Potosí Centro', 'Potosí', 'Tomás Frías', NULL, '69123457', '1'),
(9, 'Sucursal Tarija Centro', 'Tarija', 'Cercado', NULL, '69123458', '1'),
(10, 'Sucursal Oruro Centro', 'Oruro', 'Cercado', NULL, '69123459', '1'),
(11, 'Sucursal Trinidad Centro', 'Beni', 'Cercado', NULL, '69123460', '1'),
(12, 'Sucursal Cobija Centro', 'Pando', 'Cercado', NULL, '69123461', '1'),
(13, 'Sucursal Riberalta', 'Beni', 'Vaca Díez', NULL, '69123462', '1'),
(14, 'Sucursal Yacuiba', 'Tarija', 'Gran Chaco', NULL, '69123463', '1'),
(15, 'Sucursal Villazón', 'Potosí', 'Modesto Omiste', NULL, '69123464', '1'),
(16, 'Sucursal Viacha', 'La Paz', 'Ingavi', NULL, '69123465', '1'),
(17, 'Sucursal Sacaba', 'Cochabamba', 'Chapare', NULL, '69123466', '1'),
(18, 'Sucursal Warnes', 'Santa Cruz', 'Andrés Ibáñez', NULL, '69123467', '1'),
(19, 'Sucursal Villa Montes', 'Tarija', 'Gran Chaco', NULL, '69123468', '1'),
(20, 'Sucursal Uyuni', 'Potosí', 'Antonio Quijarro', NULL, '69123469', '1'),
(21, 'Sucursal Llallagua', 'Potosí', 'Rafael Bustillo', NULL, '69123470', '1'),
(22, 'Sucursal Caranavi', 'La Paz', 'Caranavi', NULL, '69123471', '1'),
(23, 'Sucursal Rurrenabaque', 'Beni', 'Ballivián', NULL, '69123472', '1'),
(24, 'Sucursal San Ignacio', 'Santa Cruz', 'Velasco', NULL, '69123473', '1'),
(25, 'Sucursal Vallegrande', 'Santa Cruz', 'Vallegrande', NULL, '69123474', '1'),
(26, 'Sucursal Punata', 'Cochabamba', 'Punata', NULL, '69123475', '1'),
(27, 'Sucursal Aiquile', 'Cochabamba', 'Campero', NULL, '69123476', '1'),
(28, 'Sucursal Tupiza', 'Potosí', 'Sud Chichas', NULL, '69123477', '1'),
(29, 'Sucursal Camiri', 'Santa Cruz', 'Cordillera', NULL, '69123478', '1'),
(30, 'Sucursal Guayaramerín', 'Beni', 'Vaca Díez', NULL, '69123479', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int NOT NULL,
  `nombre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `cedula` int NOT NULL,
  `usuario` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `apellido` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `foto` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `ultimologin` datetime DEFAULT NULL,
  `estado` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `perfil` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `nombre`, `cedula`, `usuario`, `apellido`, `password`, `foto`, `ultimologin`, `estado`, `perfil`) VALUES
(1, 'Rodrigo', 12599229, 'recheverria', 'Echeverria', NULL, 'vistas/img/predeterminado/images.png', NULL, NULL, 'Administrador'),
(2, 'Carlos', 12599876, 'cperez', 'Perez', NULL, 'vistas/img/predeterminado/images.png', NULL, NULL, 'Recepcion'),
(3, 'Ana', 12654321, 'agonzalez', 'Gonzalez', NULL, 'vistas/img/predeterminado/images.png', NULL, NULL, 'Delivery'),
(4, 'Maria', 12345678, 'mlopez', 'Lopez', '12345678', 'vistas/img/predeterminado/images.png', NULL, NULL, 'Administrador'),
(5, 'Luis', 12456789, 'lmartinez', 'Martinez', NULL, 'vistas/img/predeterminado/images.png', NULL, NULL, 'Delivery'),
(6, 'Jorge', 12765432, 'jsanchez', 'Sanchez', NULL, 'vistas/img/predeterminado/images.png', NULL, NULL, 'Recepcion'),
(7, 'Elena', 12876543, 'eramirez', 'Ramirez', '12876543', 'vistas/img/predeterminado/images.png', NULL, NULL, 'Administrador'),
(8, 'Marta', 12987654, 'mhernandez', 'Hernandez', NULL, 'vistas/img/predeterminado/images.png', NULL, NULL, 'Ayudante'),
(9, 'Diego', 13098765, 'dtorres', 'Torres', NULL, 'vistas/img/predeterminado/images.png', NULL, NULL, 'Ayudante'),
(10, 'Sofia', 13109876, 'sdiaz', 'Diaz', '13109876', 'vistas/img/predeterminado/images.png', NULL, NULL, 'Administrador'),
(11, 'Pablo', 13210987, 'pcruz', 'Cruz', '13210987', 'vistas/img/predeterminado/images.png', NULL, NULL, 'Usuario'),
(12, 'Laura', 13321098, 'lmendez', 'Mendez', '13321098', 'vistas/img/predeterminado/images.png', NULL, NULL, 'Usuario'),
(13, 'Cristina', 13432109, 'cgarcia', 'Garcia', '13432109', 'vistas/img/predeterminado/images.png', NULL, NULL, 'Administrador'),
(14, 'Andres', 13543210, 'arojas', 'Rojas', '13543210', 'vistas/img/predeterminado/images.png', NULL, NULL, 'Usuario'),
(15, 'Julia', 13654321, 'jmorales', 'Morales', '13654321', 'vistas/img/predeterminado/images.png', NULL, NULL, 'Usuario'),
(16, 'Fernando', 13765432, 'fortiz', 'Ortiz', '13765432', 'vistas/img/predeterminado/images.png', NULL, NULL, 'Administrador'),
(17, 'Natalia', 13876543, 'nsilva', 'Silva', '13876543', 'vistas/img/predeterminado/images.png', NULL, NULL, 'Usuario'),
(18, 'Ricardo', 13987654, 'rramos', 'Ramos', '13987654', 'vistas/img/predeterminado/images.png', NULL, NULL, 'Usuario'),
(19, 'Patricia', 14098765, 'pflores', 'Flores', '14098765', 'vistas/img/predeterminado/images.png', NULL, NULL, 'Administrador'),
(20, 'Miguel', 14109876, 'mcastro', 'Castro', '14109876', 'vistas/img/predeterminado/images.png', NULL, NULL, 'Usuario'),
(21, 'Isabel', 14210987, 'ivargas', 'Vargas', '14210987', 'vistas/img/predeterminado/images.png', NULL, NULL, 'Usuario'),
(22, 'Juan', 14321098, 'jreyes', 'Reyes', '14321098', 'vistas/img/predeterminado/images.png', NULL, NULL, 'Administrador'),
(23, 'Daniela', 14432109, 'dacosta', 'Acosta', '14432109', 'vistas/img/predeterminado/images.png', NULL, NULL, 'Usuario'),
(24, 'Hector', 14543210, 'hmedina', 'Medina', '14543210', 'vistas/img/predeterminado/images.png', NULL, NULL, 'Usuario'),
(25, 'Gabriela', 14654321, 'gguerrero', 'Guerrero', '14654321', 'vistas/img/predeterminado/images.png', NULL, NULL, 'Administrador'),
(26, 'Raul', 14765432, 'rpena', 'Pena', '14765432', 'vistas/img/predeterminado/images.png', NULL, NULL, 'Usuario'),
(27, 'Alicia', 14876543, 'asuarez', 'Suarez', '14876543', 'vistas/img/predeterminado/images.png', NULL, NULL, 'Usuario'),
(28, 'Tomas', 14987654, 'tromero', 'Romero', '14987654', 'vistas/img/predeterminado/images.png', NULL, NULL, 'Administrador'),
(29, 'Sandra', 15098765, 'scabrera', 'Cabrera', '15098765', 'vistas/img/predeterminado/images.png', NULL, NULL, 'Usuario'),
(30, 'Victor', 15109876, 'vmontes', 'Montes', '15109876', 'vistas/img/predeterminado/images.png', NULL, NULL, 'Usuario');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `detallepaquete`
--
ALTER TABLE `detallepaquete`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `entregapaquete`
--
ALTER TABLE `entregapaquete`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idusuario` (`idusuario`),
  ADD KEY `fk_id_paquete` (`id_paquete`);

--
-- Indices de la tabla `recepcionpaquete`
--
ALTER TABLE `recepcionpaquete`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idclienteE` (`idclienteE`),
  ADD KEY `idclienteR` (`idclienteR`),
  ADD KEY `idSucursalR` (`idSucursalR`),
  ADD KEY `idSucursalE` (`idSucursalE`),
  ADD KEY `idDetalle` (`idDetalle`),
  ADD KEY `idUsuario` (`idUsuario`);

--
-- Indices de la tabla `sucursal`
--
ALTER TABLE `sucursal`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT de la tabla `detallepaquete`
--
ALTER TABLE `detallepaquete`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT de la tabla `entregapaquete`
--
ALTER TABLE `entregapaquete`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `recepcionpaquete`
--
ALTER TABLE `recepcionpaquete`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT de la tabla `sucursal`
--
ALTER TABLE `sucursal`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `entregapaquete`
--
ALTER TABLE `entregapaquete`
  ADD CONSTRAINT `entregapaquete_ibfk_1` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`id`),
  ADD CONSTRAINT `fk_id_paquete` FOREIGN KEY (`id_paquete`) REFERENCES `recepcionpaquete` (`id`);

--
-- Filtros para la tabla `recepcionpaquete`
--
ALTER TABLE `recepcionpaquete`
  ADD CONSTRAINT `recepcionpaquete_ibfk_1` FOREIGN KEY (`idclienteE`) REFERENCES `cliente` (`id`),
  ADD CONSTRAINT `recepcionpaquete_ibfk_2` FOREIGN KEY (`idclienteR`) REFERENCES `cliente` (`id`),
  ADD CONSTRAINT `recepcionpaquete_ibfk_3` FOREIGN KEY (`idSucursalR`) REFERENCES `sucursal` (`id`),
  ADD CONSTRAINT `recepcionpaquete_ibfk_4` FOREIGN KEY (`idSucursalE`) REFERENCES `sucursal` (`id`),
  ADD CONSTRAINT `recepcionpaquete_ibfk_5` FOREIGN KEY (`idDetalle`) REFERENCES `detallepaquete` (`id`),
  ADD CONSTRAINT `recepcionpaquete_ibfk_6` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
