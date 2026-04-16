-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 19-01-2026 a las 19:53:14
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `mirentatotal`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `activity_log`
--

CREATE TABLE `activity_log` (
  `id` int(11) UNSIGNED NOT NULL,
  `table_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `record_id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `action` enum('INSERT','UPDATE','DELETE') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `old_values` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `new_values` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `activity_log`
--

INSERT INTO `activity_log` (`id`, `table_name`, `record_id`, `action`, `old_values`, `new_values`, `user_id`, `created_at`) VALUES
(97, 'motos', 'JC21007', 'INSERT', NULL, '{\"placa\":\"JC21007\",\"idestado\":\"1\",\"idmarca\":\"2\",\"modelo\":\"160\",\"a\\u00f1o\":\"2025\",\"Motor\":\"0\",\"creado_por\":\"3\",\"fecha_creacion\":\"2026-01-13 12:37:18\",\"activo\":1,\"chasis\":null,\"idcliente\":null,\"Sucursal\":null,\"color\":null,\"fecha_entrega\":null,\"fecha_renovacion\":null,\"Envio\":null,\"taller\":null,\"iddepartamento\":null,\"idagencia\":\"1\",\"renta_sinIva\":null,\"renta_conIva\":null,\"naf\":null}', 3, '2026-01-13 12:37:18'),
(98, 'motos', 'PRUEBA1', 'INSERT', NULL, '{\"placa\":\"PRUEBA1\",\"idestado\":\"1\",\"idmarca\":\"2\",\"modelo\":\"NAVI\",\"a\\u00f1o\":\"2025\",\"Motor\":\"2569631DSA980\",\"creado_por\":\"3\",\"fecha_creacion\":\"2026-01-13 14:05:09\",\"activo\":1,\"chasis\":null,\"idcliente\":null,\"Sucursal\":null,\"color\":null,\"fecha_entrega\":null,\"fecha_renovacion\":null,\"Envio\":null,\"taller\":null,\"iddepartamento\":null,\"idagencia\":\"1\",\"renta_sinIva\":null,\"renta_conIva\":null,\"naf\":null}', 3, '2026-01-13 14:05:10'),
(100, 'motos', 'PRUEBA1', 'UPDATE', '{\"placa\":\"PRUEBA1\",\"motivo_ingreso\":\"NUEVO\",\"placa_anterior\":null,\"idestado\":\"1\",\"idcliente\":null,\"chasis\":null,\"Motor\":\"2569631DSA980\",\"Sucursal\":null,\"idmarca\":\"2\",\"a\\u00f1o\":\"2025\",\"modelo\":\"NAVI\",\"color\":null,\"fecha_entrega\":null,\"fecha_renovacion\":null,\"Envio\":null,\"taller\":null,\"iddepartamento\":null,\"idagencia\":\"1\",\"renta_sinIva\":null,\"renta_conIva\":null,\"naf\":null,\"creado_por\":\"3\",\"modificado_por\":null}', '{\"idestado\":5,\"modificado_por\":\"3\"}', 3, '2026-01-13 14:47:15'),
(101, 'motos', 'JC210078', 'INSERT', NULL, '{\"placa\":\"JC210078\",\"idestado\":\"1\",\"idmarca\":\"1\",\"modelo\":\"2025\",\"a\\u00f1o\":\"2026\",\"Motor\":\"20\",\"motivo_ingreso\":\"RENOVACION\",\"placa_anterior\":\"PRUEBA1\",\"creado_por\":\"3\",\"fecha_creacion\":\"2026-01-13 14:47:15\",\"activo\":1,\"chasis\":null,\"idcliente\":null,\"Sucursal\":null,\"color\":null,\"fecha_entrega\":null,\"fecha_renovacion\":null,\"Envio\":null,\"taller\":null,\"iddepartamento\":null,\"idagencia\":\"1\",\"renta_sinIva\":null,\"renta_conIva\":null,\"naf\":null}', 3, '2026-01-13 14:47:15'),
(102, 'motos', 'JC21007', 'UPDATE', '{\"placa\":\"JC21007\",\"motivo_ingreso\":\"NUEVO\",\"placa_anterior\":null,\"idestado\":\"1\",\"idcliente\":null,\"chasis\":null,\"Motor\":\"0\",\"Sucursal\":null,\"idmarca\":\"2\",\"a\\u00f1o\":\"2025\",\"modelo\":\"160\",\"color\":null,\"fecha_entrega\":null,\"fecha_renovacion\":null,\"Envio\":null,\"taller\":null,\"iddepartamento\":null,\"idagencia\":\"1\",\"renta_sinIva\":null,\"renta_conIva\":null,\"naf\":null,\"creado_por\":\"3\",\"modificado_por\":null}', '{\"idestado\":4,\"modificado_por\":\"3\"}', 3, '2026-01-13 14:48:43'),
(103, 'motos', 'PRUEBA2', 'INSERT', NULL, '{\"placa\":\"PRUEBA2\",\"idestado\":\"1\",\"idmarca\":\"2\",\"modelo\":\"2025\",\"a\\u00f1o\":\"2025\",\"Motor\":\"20\",\"motivo_ingreso\":\"REPOSICION\",\"placa_anterior\":\"JC21007\",\"creado_por\":\"3\",\"fecha_creacion\":\"2026-01-13 14:48:43\",\"activo\":1,\"chasis\":null,\"idcliente\":null,\"Sucursal\":null,\"color\":null,\"fecha_entrega\":null,\"fecha_renovacion\":null,\"Envio\":null,\"taller\":null,\"iddepartamento\":null,\"idagencia\":\"1\",\"renta_sinIva\":null,\"renta_conIva\":null,\"naf\":null}', 3, '2026-01-13 14:48:43'),
(106, 'motos', 'JC210078', 'UPDATE', '{\"placa\":\"JC210078\",\"motivo_ingreso\":\"RENOVACION\",\"placa_anterior\":\"PRUEBA1\",\"idestado\":\"3\",\"idcliente\":\"4\",\"chasis\":null,\"Motor\":\"20\",\"Sucursal\":null,\"idmarca\":\"1\",\"a\\u00f1o\":\"2026\",\"modelo\":\"2025\",\"color\":null,\"fecha_entrega\":\"2026-01-13\",\"fecha_renovacion\":\"2026-01-27\",\"Envio\":null,\"taller\":null,\"iddepartamento\":null,\"idagencia\":\"1\",\"renta_sinIva\":\"25.00\",\"renta_conIva\":\"30.00\",\"naf\":null,\"creado_por\":\"3\",\"modificado_por\":\"3\"}', '{\"idestado\":5,\"modificado_por\":\"3\"}', 3, '2026-01-13 14:50:26'),
(107, 'motos', 'JC2100725', 'INSERT', NULL, '{\"placa\":\"JC2100725\",\"idestado\":\"1\",\"idmarca\":\"1\",\"modelo\":\"160\",\"a\\u00f1o\":\"2025\",\"Motor\":\"a487\",\"motivo_ingreso\":\"RENOVACION\",\"placa_anterior\":\"JC210078\",\"creado_por\":\"3\",\"fecha_creacion\":\"2026-01-13 14:50:26\",\"activo\":1,\"chasis\":null,\"idcliente\":null,\"Sucursal\":null,\"color\":null,\"fecha_entrega\":null,\"fecha_renovacion\":null,\"Envio\":null,\"taller\":null,\"iddepartamento\":null,\"idagencia\":\"1\",\"renta_sinIva\":null,\"renta_conIva\":null,\"naf\":null}', 3, '2026-01-13 14:50:26'),
(110, 'motos', 'JC2100725', 'UPDATE', '{\"placa\":\"JC2100725\",\"motivo_ingreso\":\"RENOVACION\",\"placa_anterior\":\"JC210078\",\"idestado\":\"1\",\"idcliente\":null,\"chasis\":null,\"Motor\":\"a487\",\"Sucursal\":null,\"idmarca\":\"1\",\"a\\u00f1o\":\"2025\",\"modelo\":\"160\",\"color\":null,\"fecha_entrega\":null,\"fecha_renovacion\":null,\"Envio\":null,\"taller\":null,\"iddepartamento\":null,\"idagencia\":\"1\",\"renta_sinIva\":null,\"renta_conIva\":null,\"naf\":null,\"creado_por\":\"3\",\"modificado_por\":null}', '{\"idestado\":5,\"modificado_por\":\"3\"}', 3, '2026-01-13 14:58:16'),
(111, 'motos', 'JC210007', 'INSERT', NULL, '{\"placa\":\"JC210007\",\"idestado\":\"1\",\"idmarca\":\"1\",\"modelo\":\"160\",\"a\\u00f1o\":\"2025\",\"Motor\":\"20\",\"motivo_ingreso\":\"RENOVACION\",\"placa_anterior\":\"JC2100725\",\"creado_por\":\"3\",\"fecha_creacion\":\"2026-01-13 14:58:16\",\"activo\":1,\"chasis\":null,\"idcliente\":null,\"Sucursal\":null,\"color\":null,\"fecha_entrega\":null,\"fecha_renovacion\":null,\"Envio\":null,\"taller\":null,\"iddepartamento\":null,\"idagencia\":\"1\",\"renta_sinIva\":null,\"renta_conIva\":null,\"naf\":null}', 3, '2026-01-13 14:58:16'),
(113, 'motos', 'PRUEBA1', 'UPDATE', '{\"placa\":\"PRUEBA1\",\"motivo_ingreso\":\"NUEVO\",\"placa_anterior\":null,\"idestado\":\"5\",\"idcliente\":null,\"chasis\":null,\"Motor\":\"2569631DSA980\",\"Sucursal\":null,\"idmarca\":\"2\",\"a\\u00f1o\":\"2025\",\"modelo\":\"NAVI\",\"color\":null,\"fecha_entrega\":null,\"fecha_renovacion\":null,\"Envio\":null,\"taller\":null,\"iddepartamento\":null,\"idagencia\":\"1\",\"renta_sinIva\":null,\"renta_conIva\":null,\"naf\":null,\"creado_por\":\"3\",\"modificado_por\":\"3\"}', '{\"idmarca\":\"2\",\"modelo\":\"NAVI\",\"a\\u00f1o\":\"2025\",\"Motor\":\"2569631DSA980\",\"idestado\":\"6\",\"idagencia\":null,\"chasis\":null,\"idcliente\":null,\"color\":null,\"fecha_entrega\":null,\"fecha_renovacion\":null,\"Envio\":null,\"taller\":null,\"iddepartamento\":null,\"renta_sinIva\":null,\"renta_conIva\":null,\"naf\":null}', 3, '2026-01-14 09:09:08'),
(114, 'motos', 'PRUEBA2', 'UPDATE', '{\"placa\":\"PRUEBA2\",\"motivo_ingreso\":\"REPOSICION\",\"placa_anterior\":\"JC21007\",\"idestado\":\"3\",\"idcliente\":\"5\",\"chasis\":null,\"Motor\":\"20\",\"Sucursal\":null,\"idmarca\":\"2\",\"a\\u00f1o\":\"2025\",\"modelo\":\"2025\",\"color\":null,\"fecha_entrega\":\"2026-01-14\",\"fecha_renovacion\":\"2026-01-29\",\"Envio\":null,\"taller\":null,\"iddepartamento\":null,\"idagencia\":\"1\",\"renta_sinIva\":\"25.00\",\"renta_conIva\":\"30.00\",\"naf\":null,\"creado_por\":\"3\",\"modificado_por\":\"3\"}', '{\"idestado\":4,\"modificado_por\":\"3\"}', 3, '2026-01-14 09:47:12'),
(115, 'motos', 'MW2025', 'INSERT', NULL, '{\"placa\":\"MW2025\",\"idestado\":\"1\",\"idmarca\":\"3\",\"modelo\":\"160\",\"a\\u00f1o\":\"2025\",\"Motor\":\"861024\",\"motivo_ingreso\":\"REPOSICION\",\"placa_anterior\":\"PRUEBA2\",\"creado_por\":\"3\",\"fecha_creacion\":\"2026-01-14 09:47:12\",\"activo\":1,\"chasis\":null,\"idcliente\":null,\"Sucursal\":null,\"color\":null,\"fecha_entrega\":null,\"fecha_renovacion\":null,\"Envio\":null,\"taller\":null,\"iddepartamento\":null,\"idagencia\":\"1\",\"renta_sinIva\":null,\"renta_conIva\":null,\"naf\":null}', 3, '2026-01-14 09:47:12');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `agencia`
--

CREATE TABLE `agencia` (
  `idagencia` int(11) NOT NULL,
  `agencia` varchar(100) DEFAULT NULL,
  `dirrecion` varchar(250) DEFAULT NULL,
  `celular` varchar(9) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `agencia`
--

INSERT INTO `agencia` (`idagencia`, `agencia`, `dirrecion`, `celular`) VALUES
(1, 'Agencia Central', 'Calle Principal 123, San Salvador', '7890-1234'),
(2, 'Agencia Oriente', 'Carretera al Litoral Km 5, San Miguel', '7123-4567'),
(3, 'Agencia Occidente', 'Avenida Las Palmas 45, Santa Ana', '7567-8901'),
(4, 'Agencia Norte', 'Bulevar Constitución 789, Chalatenango', '7345-6789'),
(5, 'Agencia Sur', 'Final Calle La Mascota 10, Antiguo Cuscatlán', '7012-3456');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `idCliente` int(11) NOT NULL,
  `Cliente` varchar(100) DEFAULT NULL,
  `idempresa` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`idCliente`, `Cliente`, `idempresa`) VALUES
(1, 'Jose', 1),
(3, 'Ivan Torres', NULL),
(4, 'KFC SAN SALVADOR', 1),
(5, 'KFC SAN SALVADOR', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamento`
--

CREATE TABLE `departamento` (
  `iddepartamento` int(11) NOT NULL,
  `departamento` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresa`
--

CREATE TABLE `empresa` (
  `idempresa` int(11) NOT NULL,
  `Empresa` varchar(50) DEFAULT NULL,
  `direccion` varchar(250) DEFAULT NULL,
  `telefono` varchar(9) DEFAULT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `nit` varchar(17) DEFAULT NULL,
  `representante_legal` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `empresa`
--

INSERT INTO `empresa` (`idempresa`, `Empresa`, `direccion`, `telefono`, `correo`, `nit`, `representante_legal`) VALUES
(1, 'Doordash', 'adjasfgg', '7645423', 'sbdasjd@hjdsf.com', '1234-123456-123-1', 'dsfsdfsf');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado`
--

CREATE TABLE `estado` (
  `idestado` int(11) NOT NULL,
  `estado` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `estado`
--

INSERT INTO `estado` (`idestado`, `estado`) VALUES
(1, 'Disponible'),
(2, 'En Mantenimiento'),
(3, 'Leasing'),
(4, 'Perdida Total'),
(5, 'Disponible para venta'),
(6, 'Venta de moto usada ');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marca`
--

CREATE TABLE `marca` (
  `idmarca` int(11) NOT NULL,
  `marca` varchar(60) DEFAULT NULL,
  `responsable` varchar(100) DEFAULT NULL,
  `celular` varchar(9) DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT current_timestamp(),
  `creado_por` int(11) DEFAULT NULL,
  `fecha_modificacion` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `modificado_por` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `marca`
--

INSERT INTO `marca` (`idmarca`, `marca`, `responsable`, `celular`, `fecha_creacion`, `creado_por`, `fecha_modificacion`, `modificado_por`) VALUES
(1, 'Hero', 'Juan Perez', '78901234', '2025-06-14 21:03:57', NULL, '2025-08-28 14:30:03', NULL),
(2, 'Honda', 'Maria Gomez', '71234567', '2025-06-14 21:03:57', NULL, '2025-06-14 21:03:57', NULL),
(3, 'Freedom', 'Carlos Diaz', '75678901', '2025-06-14 21:04:03', NULL, '2025-08-28 14:30:37', NULL),
(4, 'TVS', 'Jose Adan', '76543123', '2025-08-28 14:32:41', NULL, '2025-08-28 14:32:41', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(1, '2025-08-26-204750', 'App\\Database\\Migrations\\CreateServiciosTable', 'default', 'App', 1756845546, 1),
(2, '2025-09-02-203808', 'App\\Database\\Migrations\\AddEmpresaFields', 'default', 'App', 1756845546, 1),
(3, '2025-09-02-212214', 'App\\Database\\Migrations\\FixClienteAutoIncrement', 'default', 'App', 1756848167, 2),
(4, '2025-09-08-140000', 'App\\Database\\Migrations\\AddEstadoOriginalMotocicletaToServicios', 'default', 'App', 1757362023, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `motocicleta_bitacora`
--

CREATE TABLE `motocicleta_bitacora` (
  `id` int(11) NOT NULL,
  `placa` varchar(15) NOT NULL,
  `comentario` text NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `motocicleta_bitacora`
--

INSERT INTO `motocicleta_bitacora` (`id`, `placa`, `comentario`, `idUsuario`, `created_at`) VALUES
(11, 'MW2025', 'Fue atropellada', 3, '2026-01-16 15:21:36');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `motos`
--

CREATE TABLE `motos` (
  `placa` varchar(15) NOT NULL,
  `motivo_ingreso` enum('NUEVO','RENOVACION','REPOSICION') DEFAULT 'NUEVO',
  `placa_anterior` varchar(15) DEFAULT NULL,
  `idestado` int(11) DEFAULT NULL,
  `idcliente` int(11) DEFAULT NULL,
  `chasis` varchar(50) DEFAULT NULL,
  `Motor` varchar(50) DEFAULT NULL,
  `Sucursal` varchar(100) DEFAULT NULL,
  `idmarca` int(11) DEFAULT NULL,
  `año` int(11) DEFAULT NULL,
  `modelo` varchar(50) DEFAULT NULL,
  `color` varchar(50) DEFAULT NULL,
  `fecha_entrega` date DEFAULT NULL,
  `fecha_renovacion` date DEFAULT NULL,
  `Envio` varchar(50) DEFAULT NULL,
  `taller` varchar(100) DEFAULT NULL,
  `iddepartamento` int(11) DEFAULT NULL,
  `idagencia` int(11) DEFAULT NULL,
  `renta_sinIva` double(10,2) DEFAULT NULL,
  `renta_conIva` double(10,2) DEFAULT NULL,
  `naf` varchar(50) DEFAULT NULL,
  `creado_por` int(11) DEFAULT NULL,
  `modificado_por` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `motos`
--

INSERT INTO `motos` (`placa`, `motivo_ingreso`, `placa_anterior`, `idestado`, `idcliente`, `chasis`, `Motor`, `Sucursal`, `idmarca`, `año`, `modelo`, `color`, `fecha_entrega`, `fecha_renovacion`, `Envio`, `taller`, `iddepartamento`, `idagencia`, `renta_sinIva`, `renta_conIva`, `naf`, `creado_por`, `modificado_por`) VALUES
('JC210007', 'RENOVACION', 'JC2100725', 3, 3, NULL, '20', NULL, 1, 2025, '160', NULL, '2026-01-14', '2026-01-28', NULL, NULL, NULL, 1, 24.00, 30.00, NULL, 3, 3),
('JC21007', 'NUEVO', NULL, 4, NULL, NULL, '0', NULL, 2, 2025, '160', NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 3, 3),
('JC2100725', 'RENOVACION', 'JC210078', 5, NULL, NULL, 'a487', NULL, 1, 2025, '160', NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 3, 3),
('JC210078', 'RENOVACION', 'PRUEBA1', 5, 4, NULL, '20', NULL, 1, 2026, '2025', NULL, '2026-01-13', '2026-01-27', NULL, NULL, NULL, 1, 25.00, 30.00, NULL, 3, 3),
('MW2025', 'REPOSICION', 'PRUEBA2', 1, NULL, NULL, '861024', NULL, 3, 2025, '160', NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 3, NULL),
('PRUEBA1', 'NUEVO', NULL, 6, NULL, NULL, '2569631DSA980', NULL, 2, 2025, 'NAVI', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 3),
('PRUEBA2', 'REPOSICION', 'JC21007', 4, 5, NULL, '20', NULL, 2, 2025, '2025', NULL, '2026-01-14', '2026-01-29', NULL, NULL, NULL, 1, 25.00, 30.00, NULL, 3, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `type` enum('motorcycle','service','rental','activity') DEFAULT NULL,
  `related_table` varchar(100) DEFAULT NULL,
  `related_id` varchar(100) DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `title`, `message`, `type`, `related_table`, `related_id`, `is_read`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 21, 'UPDATE en servicios (ID: 3)', '28/10/2025 19:54 - Usuario: admin2', '', 'servicios', '3', 0, '2025-10-28 19:54:01', '2025-10-28 19:54:01', NULL),
(2, 25, 'UPDATE en servicios (ID: 3)', '28/10/2025 19:54 - Usuario: admin2', '', 'servicios', '3', 0, '2025-10-28 19:54:02', '2025-10-28 19:54:02', NULL),
(3, 21, 'UPDATE en motos (ID: M76453)', '28/10/2025 20:23 - Usuario: Jefatura', 'activity', 'motos', 'M76453', 0, '2025-10-28 20:23:21', '2025-10-28 20:23:21', NULL),
(4, 28, 'UPDATE en motos (ID: M76453)', '28/10/2025 20:23 - Usuario: Jefatura', 'activity', 'motos', 'M76453', 0, '2025-10-28 20:23:21', '2025-10-28 20:23:21', NULL),
(5, 21, 'INSERT en cliente (ID: 4)', '07/01/2026 21:18 - Usuario: admin', 'activity', 'cliente', '4', 0, '2026-01-07 21:18:30', '2026-01-07 21:18:30', NULL),
(6, 25, 'INSERT en cliente (ID: 4)', '07/01/2026 21:18 - Usuario: admin', 'activity', 'cliente', '4', 0, '2026-01-07 21:18:30', '2026-01-07 21:18:30', NULL),
(7, 28, 'INSERT en cliente (ID: 4)', '07/01/2026 21:18 - Usuario: admin', 'activity', 'cliente', '4', 0, '2026-01-07 21:18:30', '2026-01-07 21:18:30', NULL),
(8, 21, 'INSERT en usuario (ID: 29)', '07/01/2026 21:22 - Usuario: admin', 'activity', 'usuario', '29', 0, '2026-01-07 21:22:10', '2026-01-07 21:22:10', NULL),
(9, 25, 'INSERT en usuario (ID: 29)', '07/01/2026 21:22 - Usuario: admin', 'activity', 'usuario', '29', 0, '2026-01-07 21:22:10', '2026-01-07 21:22:10', NULL),
(10, 28, 'INSERT en usuario (ID: 29)', '07/01/2026 21:22 - Usuario: admin', 'activity', 'usuario', '29', 0, '2026-01-07 21:22:10', '2026-01-07 21:22:10', NULL),
(11, 29, 'INSERT en usuario (ID: 29)', '07/01/2026 21:22 - Usuario: admin', 'activity', 'usuario', '29', 0, '2026-01-07 21:22:10', '2026-01-07 21:22:10', NULL),
(12, 21, 'INSERT en cliente (ID: 5)', '07/01/2026 22:58 - Usuario: admin', 'activity', 'cliente', '5', 0, '2026-01-07 22:58:13', '2026-01-07 22:58:13', NULL),
(13, 25, 'INSERT en cliente (ID: 5)', '07/01/2026 22:58 - Usuario: admin', 'activity', 'cliente', '5', 0, '2026-01-07 22:58:13', '2026-01-07 22:58:13', NULL),
(14, 28, 'INSERT en cliente (ID: 5)', '07/01/2026 22:58 - Usuario: admin', 'activity', 'cliente', '5', 0, '2026-01-07 22:58:13', '2026-01-07 22:58:13', NULL),
(15, 29, 'INSERT en cliente (ID: 5)', '07/01/2026 22:58 - Usuario: admin', 'activity', 'cliente', '5', 0, '2026-01-07 22:58:13', '2026-01-07 22:58:13', NULL),
(16, 21, 'INSERT en usuario (ID: 30)', '07/01/2026 22:58 - Usuario: admin', 'activity', 'usuario', '30', 0, '2026-01-07 22:58:42', '2026-01-07 22:58:42', NULL),
(17, 25, 'INSERT en usuario (ID: 30)', '07/01/2026 22:58 - Usuario: admin', 'activity', 'usuario', '30', 0, '2026-01-07 22:58:42', '2026-01-07 22:58:42', NULL),
(18, 28, 'INSERT en usuario (ID: 30)', '07/01/2026 22:58 - Usuario: admin', 'activity', 'usuario', '30', 0, '2026-01-07 22:58:42', '2026-01-07 22:58:42', NULL),
(19, 29, 'INSERT en usuario (ID: 30)', '07/01/2026 22:58 - Usuario: admin', 'activity', 'usuario', '30', 0, '2026-01-07 22:58:42', '2026-01-07 22:58:42', NULL),
(20, 30, 'INSERT en usuario (ID: 30)', '07/01/2026 22:58 - Usuario: admin', 'activity', 'usuario', '30', 0, '2026-01-07 22:58:42', '2026-01-07 22:58:42', NULL),
(21, 21, 'INSERT en usuario (ID: 31)', '08/01/2026 15:29 - Usuario: admin', 'activity', 'usuario', '31', 0, '2026-01-08 15:29:12', '2026-01-08 15:29:12', NULL),
(22, 25, 'INSERT en usuario (ID: 31)', '08/01/2026 15:29 - Usuario: admin', 'activity', 'usuario', '31', 0, '2026-01-08 15:29:12', '2026-01-08 15:29:12', NULL),
(23, 28, 'INSERT en usuario (ID: 31)', '08/01/2026 15:29 - Usuario: admin', 'activity', 'usuario', '31', 0, '2026-01-08 15:29:12', '2026-01-08 15:29:12', NULL),
(24, 29, 'INSERT en usuario (ID: 31)', '08/01/2026 15:29 - Usuario: admin', 'activity', 'usuario', '31', 0, '2026-01-08 15:29:12', '2026-01-08 15:29:12', NULL),
(25, 30, 'INSERT en usuario (ID: 31)', '08/01/2026 15:29 - Usuario: admin', 'activity', 'usuario', '31', 0, '2026-01-08 15:29:12', '2026-01-08 15:29:12', NULL),
(26, 21, 'INSERT en cliente (ID: 6)', '08/01/2026 15:33 - Usuario: admin', 'activity', 'cliente', '6', 0, '2026-01-08 15:33:29', '2026-01-08 15:33:29', NULL),
(27, 25, 'INSERT en cliente (ID: 6)', '08/01/2026 15:33 - Usuario: admin', 'activity', 'cliente', '6', 0, '2026-01-08 15:33:29', '2026-01-08 15:33:29', NULL),
(28, 28, 'INSERT en cliente (ID: 6)', '08/01/2026 15:33 - Usuario: admin', 'activity', 'cliente', '6', 0, '2026-01-08 15:33:29', '2026-01-08 15:33:29', NULL),
(29, 29, 'INSERT en cliente (ID: 6)', '08/01/2026 15:33 - Usuario: admin', 'activity', 'cliente', '6', 0, '2026-01-08 15:33:29', '2026-01-08 15:33:29', NULL),
(30, 30, 'INSERT en cliente (ID: 6)', '08/01/2026 15:33 - Usuario: admin', 'activity', 'cliente', '6', 0, '2026-01-08 15:33:29', '2026-01-08 15:33:29', NULL),
(31, 21, 'INSERT en cliente (ID: 7)', '08/01/2026 15:33 - Usuario: admin', 'activity', 'cliente', '7', 0, '2026-01-08 15:33:46', '2026-01-08 15:33:46', NULL),
(32, 25, 'INSERT en cliente (ID: 7)', '08/01/2026 15:33 - Usuario: admin', 'activity', 'cliente', '7', 0, '2026-01-08 15:33:46', '2026-01-08 15:33:46', NULL),
(33, 28, 'INSERT en cliente (ID: 7)', '08/01/2026 15:33 - Usuario: admin', 'activity', 'cliente', '7', 0, '2026-01-08 15:33:46', '2026-01-08 15:33:46', NULL),
(34, 29, 'INSERT en cliente (ID: 7)', '08/01/2026 15:33 - Usuario: admin', 'activity', 'cliente', '7', 0, '2026-01-08 15:33:46', '2026-01-08 15:33:46', NULL),
(35, 30, 'INSERT en cliente (ID: 7)', '08/01/2026 15:33 - Usuario: admin', 'activity', 'cliente', '7', 0, '2026-01-08 15:33:46', '2026-01-08 15:33:46', NULL),
(36, 21, 'DELETE en cliente (ID: 7)', '08/01/2026 15:49 - Usuario: admin', 'activity', 'cliente', '7', 0, '2026-01-08 15:49:41', '2026-01-08 15:49:41', NULL),
(37, 25, 'DELETE en cliente (ID: 7)', '08/01/2026 15:49 - Usuario: admin', 'activity', 'cliente', '7', 0, '2026-01-08 15:49:41', '2026-01-08 15:49:41', NULL),
(38, 28, 'DELETE en cliente (ID: 7)', '08/01/2026 15:49 - Usuario: admin', 'activity', 'cliente', '7', 0, '2026-01-08 15:49:41', '2026-01-08 15:49:41', NULL),
(39, 29, 'DELETE en cliente (ID: 7)', '08/01/2026 15:49 - Usuario: admin', 'activity', 'cliente', '7', 0, '2026-01-08 15:49:41', '2026-01-08 15:49:41', NULL),
(40, 30, 'DELETE en cliente (ID: 7)', '08/01/2026 15:49 - Usuario: admin', 'activity', 'cliente', '7', 0, '2026-01-08 15:49:41', '2026-01-08 15:49:41', NULL),
(41, 21, 'DELETE en cliente (ID: 6)', '08/01/2026 15:49 - Usuario: admin', 'activity', 'cliente', '6', 0, '2026-01-08 15:49:48', '2026-01-08 15:49:48', NULL),
(42, 25, 'DELETE en cliente (ID: 6)', '08/01/2026 15:49 - Usuario: admin', 'activity', 'cliente', '6', 0, '2026-01-08 15:49:48', '2026-01-08 15:49:48', NULL),
(43, 28, 'DELETE en cliente (ID: 6)', '08/01/2026 15:49 - Usuario: admin', 'activity', 'cliente', '6', 0, '2026-01-08 15:49:48', '2026-01-08 15:49:48', NULL),
(44, 29, 'DELETE en cliente (ID: 6)', '08/01/2026 15:49 - Usuario: admin', 'activity', 'cliente', '6', 0, '2026-01-08 15:49:48', '2026-01-08 15:49:48', NULL),
(45, 30, 'DELETE en cliente (ID: 6)', '08/01/2026 15:49 - Usuario: admin', 'activity', 'cliente', '6', 0, '2026-01-08 15:49:48', '2026-01-08 15:49:48', NULL),
(46, 21, 'UPDATE en cliente (ID: 3)', '08/01/2026 15:50 - Usuario: admin', 'activity', 'cliente', '3', 0, '2026-01-08 15:50:59', '2026-01-08 15:50:59', NULL),
(47, 25, 'UPDATE en cliente (ID: 3)', '08/01/2026 15:50 - Usuario: admin', 'activity', 'cliente', '3', 0, '2026-01-08 15:50:59', '2026-01-08 15:50:59', NULL),
(48, 28, 'UPDATE en cliente (ID: 3)', '08/01/2026 15:50 - Usuario: admin', 'activity', 'cliente', '3', 0, '2026-01-08 15:50:59', '2026-01-08 15:50:59', NULL),
(49, 29, 'UPDATE en cliente (ID: 3)', '08/01/2026 15:50 - Usuario: admin', 'activity', 'cliente', '3', 0, '2026-01-08 15:50:59', '2026-01-08 15:50:59', NULL),
(50, 30, 'UPDATE en cliente (ID: 3)', '08/01/2026 15:50 - Usuario: admin', 'activity', 'cliente', '3', 0, '2026-01-08 15:50:59', '2026-01-08 15:50:59', NULL),
(51, 21, 'UPDATE en usuario (ID: 14)', '08/01/2026 15:56 - Usuario: admin', 'activity', 'usuario', '14', 0, '2026-01-08 15:56:07', '2026-01-08 15:56:07', NULL),
(52, 25, 'UPDATE en usuario (ID: 14)', '08/01/2026 15:56 - Usuario: admin', 'activity', 'usuario', '14', 0, '2026-01-08 15:56:07', '2026-01-08 15:56:07', NULL),
(53, 28, 'UPDATE en usuario (ID: 14)', '08/01/2026 15:56 - Usuario: admin', 'activity', 'usuario', '14', 0, '2026-01-08 15:56:07', '2026-01-08 15:56:07', NULL),
(54, 29, 'UPDATE en usuario (ID: 14)', '08/01/2026 15:56 - Usuario: admin', 'activity', 'usuario', '14', 0, '2026-01-08 15:56:07', '2026-01-08 15:56:07', NULL),
(55, 30, 'UPDATE en usuario (ID: 14)', '08/01/2026 15:56 - Usuario: admin', 'activity', 'usuario', '14', 0, '2026-01-08 15:56:07', '2026-01-08 15:56:07', NULL),
(56, 21, 'DELETE en usuario (ID: 14)', '08/01/2026 15:56 - Usuario: admin', 'activity', 'usuario', '14', 0, '2026-01-08 15:56:19', '2026-01-08 15:56:19', NULL),
(57, 25, 'DELETE en usuario (ID: 14)', '08/01/2026 15:56 - Usuario: admin', 'activity', 'usuario', '14', 0, '2026-01-08 15:56:19', '2026-01-08 15:56:19', NULL),
(58, 28, 'DELETE en usuario (ID: 14)', '08/01/2026 15:56 - Usuario: admin', 'activity', 'usuario', '14', 0, '2026-01-08 15:56:19', '2026-01-08 15:56:19', NULL),
(59, 29, 'DELETE en usuario (ID: 14)', '08/01/2026 15:56 - Usuario: admin', 'activity', 'usuario', '14', 0, '2026-01-08 15:56:19', '2026-01-08 15:56:19', NULL),
(60, 30, 'DELETE en usuario (ID: 14)', '08/01/2026 15:56 - Usuario: admin', 'activity', 'usuario', '14', 0, '2026-01-08 15:56:19', '2026-01-08 15:56:19', NULL),
(61, 21, 'UPDATE en cliente (ID: 3)', '08/01/2026 15:58 - Usuario: admin', 'activity', 'cliente', '3', 0, '2026-01-08 15:58:07', '2026-01-08 15:58:07', NULL),
(62, 25, 'UPDATE en cliente (ID: 3)', '08/01/2026 15:58 - Usuario: admin', 'activity', 'cliente', '3', 0, '2026-01-08 15:58:07', '2026-01-08 15:58:07', NULL),
(63, 28, 'UPDATE en cliente (ID: 3)', '08/01/2026 15:58 - Usuario: admin', 'activity', 'cliente', '3', 0, '2026-01-08 15:58:07', '2026-01-08 15:58:07', NULL),
(64, 29, 'UPDATE en cliente (ID: 3)', '08/01/2026 15:58 - Usuario: admin', 'activity', 'cliente', '3', 0, '2026-01-08 15:58:07', '2026-01-08 15:58:07', NULL),
(65, 30, 'UPDATE en cliente (ID: 3)', '08/01/2026 15:58 - Usuario: admin', 'activity', 'cliente', '3', 0, '2026-01-08 15:58:07', '2026-01-08 15:58:07', NULL),
(66, 21, 'INSERT en empresa (ID: 2)', '08/01/2026 16:02 - Usuario: admin', 'activity', 'empresa', '2', 0, '2026-01-08 16:02:46', '2026-01-08 16:02:46', NULL),
(67, 25, 'INSERT en empresa (ID: 2)', '08/01/2026 16:02 - Usuario: admin', 'activity', 'empresa', '2', 0, '2026-01-08 16:02:46', '2026-01-08 16:02:46', NULL),
(68, 28, 'INSERT en empresa (ID: 2)', '08/01/2026 16:02 - Usuario: admin', 'activity', 'empresa', '2', 0, '2026-01-08 16:02:46', '2026-01-08 16:02:46', NULL),
(69, 29, 'INSERT en empresa (ID: 2)', '08/01/2026 16:02 - Usuario: admin', 'activity', 'empresa', '2', 0, '2026-01-08 16:02:46', '2026-01-08 16:02:46', NULL),
(70, 30, 'INSERT en empresa (ID: 2)', '08/01/2026 16:02 - Usuario: admin', 'activity', 'empresa', '2', 0, '2026-01-08 16:02:46', '2026-01-08 16:02:46', NULL),
(71, 21, 'UPDATE en empresa (ID: 2)', '08/01/2026 16:06 - Usuario: admin', 'activity', 'empresa', '2', 0, '2026-01-08 16:06:15', '2026-01-08 16:06:15', NULL),
(72, 25, 'UPDATE en empresa (ID: 2)', '08/01/2026 16:06 - Usuario: admin', 'activity', 'empresa', '2', 0, '2026-01-08 16:06:15', '2026-01-08 16:06:15', NULL),
(73, 28, 'UPDATE en empresa (ID: 2)', '08/01/2026 16:06 - Usuario: admin', 'activity', 'empresa', '2', 0, '2026-01-08 16:06:15', '2026-01-08 16:06:15', NULL),
(74, 29, 'UPDATE en empresa (ID: 2)', '08/01/2026 16:06 - Usuario: admin', 'activity', 'empresa', '2', 0, '2026-01-08 16:06:15', '2026-01-08 16:06:15', NULL),
(75, 30, 'UPDATE en empresa (ID: 2)', '08/01/2026 16:06 - Usuario: admin', 'activity', 'empresa', '2', 0, '2026-01-08 16:06:15', '2026-01-08 16:06:15', NULL),
(76, 21, 'UPDATE en empresa (ID: 2)', '08/01/2026 16:06 - Usuario: admin', 'activity', 'empresa', '2', 0, '2026-01-08 16:06:34', '2026-01-08 16:06:34', NULL),
(77, 25, 'UPDATE en empresa (ID: 2)', '08/01/2026 16:06 - Usuario: admin', 'activity', 'empresa', '2', 0, '2026-01-08 16:06:34', '2026-01-08 16:06:34', NULL),
(78, 28, 'UPDATE en empresa (ID: 2)', '08/01/2026 16:06 - Usuario: admin', 'activity', 'empresa', '2', 0, '2026-01-08 16:06:34', '2026-01-08 16:06:34', NULL),
(79, 29, 'UPDATE en empresa (ID: 2)', '08/01/2026 16:06 - Usuario: admin', 'activity', 'empresa', '2', 0, '2026-01-08 16:06:34', '2026-01-08 16:06:34', NULL),
(80, 30, 'UPDATE en empresa (ID: 2)', '08/01/2026 16:06 - Usuario: admin', 'activity', 'empresa', '2', 0, '2026-01-08 16:06:34', '2026-01-08 16:06:34', NULL),
(81, 21, 'DELETE en empresa (ID: 2)', '08/01/2026 16:06 - Usuario: admin', 'activity', 'empresa', '2', 0, '2026-01-08 16:06:39', '2026-01-08 16:06:39', NULL),
(82, 25, 'DELETE en empresa (ID: 2)', '08/01/2026 16:06 - Usuario: admin', 'activity', 'empresa', '2', 0, '2026-01-08 16:06:39', '2026-01-08 16:06:39', NULL),
(83, 28, 'DELETE en empresa (ID: 2)', '08/01/2026 16:06 - Usuario: admin', 'activity', 'empresa', '2', 0, '2026-01-08 16:06:39', '2026-01-08 16:06:39', NULL),
(84, 29, 'DELETE en empresa (ID: 2)', '08/01/2026 16:06 - Usuario: admin', 'activity', 'empresa', '2', 0, '2026-01-08 16:06:39', '2026-01-08 16:06:39', NULL),
(85, 30, 'DELETE en empresa (ID: 2)', '08/01/2026 16:06 - Usuario: admin', 'activity', 'empresa', '2', 0, '2026-01-08 16:06:39', '2026-01-08 16:06:39', NULL),
(86, 21, 'INSERT en motos (ID: JC21007)', '08/01/2026 16:11 - Usuario: admin', 'activity', 'motos', 'JC21007', 0, '2026-01-08 16:11:50', '2026-01-08 16:11:50', NULL),
(87, 25, 'INSERT en motos (ID: JC21007)', '08/01/2026 16:11 - Usuario: admin', 'activity', 'motos', 'JC21007', 0, '2026-01-08 16:11:50', '2026-01-08 16:11:50', NULL),
(88, 28, 'INSERT en motos (ID: JC21007)', '08/01/2026 16:11 - Usuario: admin', 'activity', 'motos', 'JC21007', 0, '2026-01-08 16:11:50', '2026-01-08 16:11:50', NULL),
(89, 29, 'INSERT en motos (ID: JC21007)', '08/01/2026 16:11 - Usuario: admin', 'activity', 'motos', 'JC21007', 0, '2026-01-08 16:11:50', '2026-01-08 16:11:50', NULL),
(90, 30, 'INSERT en motos (ID: JC21007)', '08/01/2026 16:11 - Usuario: admin', 'activity', 'motos', 'JC21007', 0, '2026-01-08 16:11:50', '2026-01-08 16:11:50', NULL),
(91, 21, 'UPDATE en motos (ID: JC21007)', '08/01/2026 16:16 - Usuario: admin', 'activity', 'motos', 'JC21007', 0, '2026-01-08 16:16:11', '2026-01-08 16:16:11', NULL),
(92, 25, 'UPDATE en motos (ID: JC21007)', '08/01/2026 16:16 - Usuario: admin', 'activity', 'motos', 'JC21007', 0, '2026-01-08 16:16:11', '2026-01-08 16:16:11', NULL),
(93, 28, 'UPDATE en motos (ID: JC21007)', '08/01/2026 16:16 - Usuario: admin', 'activity', 'motos', 'JC21007', 0, '2026-01-08 16:16:11', '2026-01-08 16:16:11', NULL),
(94, 29, 'UPDATE en motos (ID: JC21007)', '08/01/2026 16:16 - Usuario: admin', 'activity', 'motos', 'JC21007', 0, '2026-01-08 16:16:11', '2026-01-08 16:16:11', NULL),
(95, 30, 'UPDATE en motos (ID: JC21007)', '08/01/2026 16:16 - Usuario: admin', 'activity', 'motos', 'JC21007', 0, '2026-01-08 16:16:11', '2026-01-08 16:16:11', NULL),
(96, 21, 'UPDATE en motos (ID: JC21007)', '08/01/2026 16:16 - Usuario: admin', 'activity', 'motos', 'JC21007', 0, '2026-01-08 16:16:36', '2026-01-08 16:16:36', NULL),
(97, 25, 'UPDATE en motos (ID: JC21007)', '08/01/2026 16:16 - Usuario: admin', 'activity', 'motos', 'JC21007', 0, '2026-01-08 16:16:36', '2026-01-08 16:16:36', NULL),
(98, 28, 'UPDATE en motos (ID: JC21007)', '08/01/2026 16:16 - Usuario: admin', 'activity', 'motos', 'JC21007', 0, '2026-01-08 16:16:36', '2026-01-08 16:16:36', NULL),
(99, 29, 'UPDATE en motos (ID: JC21007)', '08/01/2026 16:16 - Usuario: admin', 'activity', 'motos', 'JC21007', 0, '2026-01-08 16:16:36', '2026-01-08 16:16:36', NULL),
(100, 30, 'UPDATE en motos (ID: JC21007)', '08/01/2026 16:16 - Usuario: admin', 'activity', 'motos', 'JC21007', 0, '2026-01-08 16:16:36', '2026-01-08 16:16:36', NULL),
(101, 21, 'UPDATE en motos (ID: JC21007)', '08/01/2026 16:16 - Usuario: admin', 'activity', 'motos', 'JC21007', 0, '2026-01-08 16:16:45', '2026-01-08 16:16:45', NULL),
(102, 25, 'UPDATE en motos (ID: JC21007)', '08/01/2026 16:16 - Usuario: admin', 'activity', 'motos', 'JC21007', 0, '2026-01-08 16:16:45', '2026-01-08 16:16:45', NULL),
(103, 28, 'UPDATE en motos (ID: JC21007)', '08/01/2026 16:16 - Usuario: admin', 'activity', 'motos', 'JC21007', 0, '2026-01-08 16:16:45', '2026-01-08 16:16:45', NULL),
(104, 29, 'UPDATE en motos (ID: JC21007)', '08/01/2026 16:16 - Usuario: admin', 'activity', 'motos', 'JC21007', 0, '2026-01-08 16:16:45', '2026-01-08 16:16:45', NULL),
(105, 30, 'UPDATE en motos (ID: JC21007)', '08/01/2026 16:16 - Usuario: admin', 'activity', 'motos', 'JC21007', 0, '2026-01-08 16:16:45', '2026-01-08 16:16:45', NULL),
(106, 21, 'DELETE en motos (ID: TRE6512)', '08/01/2026 16:17 - Usuario: admin', 'activity', 'motos', 'TRE6512', 0, '2026-01-08 16:17:29', '2026-01-08 16:17:29', NULL),
(107, 25, 'DELETE en motos (ID: TRE6512)', '08/01/2026 16:17 - Usuario: admin', 'activity', 'motos', 'TRE6512', 0, '2026-01-08 16:17:29', '2026-01-08 16:17:29', NULL),
(108, 28, 'DELETE en motos (ID: TRE6512)', '08/01/2026 16:17 - Usuario: admin', 'activity', 'motos', 'TRE6512', 0, '2026-01-08 16:17:29', '2026-01-08 16:17:29', NULL),
(109, 29, 'DELETE en motos (ID: TRE6512)', '08/01/2026 16:17 - Usuario: admin', 'activity', 'motos', 'TRE6512', 0, '2026-01-08 16:17:29', '2026-01-08 16:17:29', NULL),
(110, 30, 'DELETE en motos (ID: TRE6512)', '08/01/2026 16:17 - Usuario: admin', 'activity', 'motos', 'TRE6512', 0, '2026-01-08 16:17:29', '2026-01-08 16:17:29', NULL),
(111, 21, 'INSERT en servicios (ID: 6)', '08/01/2026 16:33 - Usuario: admin', 'activity', 'servicios', '6', 0, '2026-01-08 16:33:07', '2026-01-08 16:33:07', NULL),
(112, 25, 'INSERT en servicios (ID: 6)', '08/01/2026 16:33 - Usuario: admin', 'activity', 'servicios', '6', 0, '2026-01-08 16:33:07', '2026-01-08 16:33:07', NULL),
(113, 28, 'INSERT en servicios (ID: 6)', '08/01/2026 16:33 - Usuario: admin', 'activity', 'servicios', '6', 0, '2026-01-08 16:33:07', '2026-01-08 16:33:07', NULL),
(114, 29, 'INSERT en servicios (ID: 6)', '08/01/2026 16:33 - Usuario: admin', 'activity', 'servicios', '6', 0, '2026-01-08 16:33:07', '2026-01-08 16:33:07', NULL),
(115, 30, 'INSERT en servicios (ID: 6)', '08/01/2026 16:33 - Usuario: admin', 'activity', 'servicios', '6', 0, '2026-01-08 16:33:07', '2026-01-08 16:33:07', NULL),
(116, 21, 'UPDATE en servicios (ID: 6)', '08/01/2026 16:37 - Usuario: admin', 'activity', 'servicios', '6', 0, '2026-01-08 16:37:54', '2026-01-08 16:37:54', NULL),
(117, 25, 'UPDATE en servicios (ID: 6)', '08/01/2026 16:37 - Usuario: admin', 'activity', 'servicios', '6', 0, '2026-01-08 16:37:54', '2026-01-08 16:37:54', NULL),
(118, 28, 'UPDATE en servicios (ID: 6)', '08/01/2026 16:37 - Usuario: admin', 'activity', 'servicios', '6', 0, '2026-01-08 16:37:54', '2026-01-08 16:37:54', NULL),
(119, 29, 'UPDATE en servicios (ID: 6)', '08/01/2026 16:37 - Usuario: admin', 'activity', 'servicios', '6', 0, '2026-01-08 16:37:54', '2026-01-08 16:37:54', NULL),
(120, 30, 'UPDATE en servicios (ID: 6)', '08/01/2026 16:37 - Usuario: admin', 'activity', 'servicios', '6', 0, '2026-01-08 16:37:54', '2026-01-08 16:37:54', NULL),
(121, 21, 'UPDATE en servicios (ID: 6)', '08/01/2026 16:38 - Usuario: admin', 'activity', 'servicios', '6', 0, '2026-01-08 16:38:22', '2026-01-08 16:38:22', NULL),
(122, 25, 'UPDATE en servicios (ID: 6)', '08/01/2026 16:38 - Usuario: admin', 'activity', 'servicios', '6', 0, '2026-01-08 16:38:22', '2026-01-08 16:38:22', NULL),
(123, 28, 'UPDATE en servicios (ID: 6)', '08/01/2026 16:38 - Usuario: admin', 'activity', 'servicios', '6', 0, '2026-01-08 16:38:22', '2026-01-08 16:38:22', NULL),
(124, 29, 'UPDATE en servicios (ID: 6)', '08/01/2026 16:38 - Usuario: admin', 'activity', 'servicios', '6', 0, '2026-01-08 16:38:22', '2026-01-08 16:38:22', NULL),
(125, 30, 'UPDATE en servicios (ID: 6)', '08/01/2026 16:38 - Usuario: admin', 'activity', 'servicios', '6', 0, '2026-01-08 16:38:22', '2026-01-08 16:38:22', NULL),
(126, 21, 'DELETE en servicios (ID: 3)', '08/01/2026 16:38 - Usuario: admin', 'activity', 'servicios', '3', 0, '2026-01-08 16:38:41', '2026-01-08 16:38:41', NULL),
(127, 25, 'DELETE en servicios (ID: 3)', '08/01/2026 16:38 - Usuario: admin', 'activity', 'servicios', '3', 0, '2026-01-08 16:38:41', '2026-01-08 16:38:41', NULL),
(128, 28, 'DELETE en servicios (ID: 3)', '08/01/2026 16:38 - Usuario: admin', 'activity', 'servicios', '3', 0, '2026-01-08 16:38:41', '2026-01-08 16:38:41', NULL),
(129, 29, 'DELETE en servicios (ID: 3)', '08/01/2026 16:38 - Usuario: admin', 'activity', 'servicios', '3', 0, '2026-01-08 16:38:41', '2026-01-08 16:38:41', NULL),
(130, 30, 'DELETE en servicios (ID: 3)', '08/01/2026 16:38 - Usuario: admin', 'activity', 'servicios', '3', 0, '2026-01-08 16:38:41', '2026-01-08 16:38:41', NULL),
(131, 21, 'UPDATE en servicios (ID: 6)', '08/01/2026 16:39 - Usuario: admin', 'activity', 'servicios', '6', 0, '2026-01-08 16:39:38', '2026-01-08 16:39:38', NULL),
(132, 25, 'UPDATE en servicios (ID: 6)', '08/01/2026 16:39 - Usuario: admin', 'activity', 'servicios', '6', 0, '2026-01-08 16:39:38', '2026-01-08 16:39:38', NULL),
(133, 28, 'UPDATE en servicios (ID: 6)', '08/01/2026 16:39 - Usuario: admin', 'activity', 'servicios', '6', 0, '2026-01-08 16:39:38', '2026-01-08 16:39:38', NULL),
(134, 29, 'UPDATE en servicios (ID: 6)', '08/01/2026 16:39 - Usuario: admin', 'activity', 'servicios', '6', 0, '2026-01-08 16:39:38', '2026-01-08 16:39:38', NULL),
(135, 30, 'UPDATE en servicios (ID: 6)', '08/01/2026 16:39 - Usuario: admin', 'activity', 'servicios', '6', 0, '2026-01-08 16:39:38', '2026-01-08 16:39:38', NULL),
(136, 21, 'INSERT en rental_history (ID: 2)', '08/01/2026 16:43 - Usuario: admin', 'activity', 'rental_history', '2', 0, '2026-01-08 16:43:32', '2026-01-08 16:43:32', NULL),
(137, 25, 'INSERT en rental_history (ID: 2)', '08/01/2026 16:43 - Usuario: admin', 'activity', 'rental_history', '2', 0, '2026-01-08 16:43:32', '2026-01-08 16:43:32', NULL),
(138, 28, 'INSERT en rental_history (ID: 2)', '08/01/2026 16:43 - Usuario: admin', 'activity', 'rental_history', '2', 0, '2026-01-08 16:43:32', '2026-01-08 16:43:32', NULL),
(139, 29, 'INSERT en rental_history (ID: 2)', '08/01/2026 16:43 - Usuario: admin', 'activity', 'rental_history', '2', 0, '2026-01-08 16:43:32', '2026-01-08 16:43:32', NULL),
(140, 30, 'INSERT en rental_history (ID: 2)', '08/01/2026 16:43 - Usuario: admin', 'activity', 'rental_history', '2', 0, '2026-01-08 16:43:32', '2026-01-08 16:43:32', NULL),
(141, 21, 'UPDATE en usuario (ID: 3)', '08/01/2026 17:01 - Usuario: admin', 'activity', 'usuario', '3', 0, '2026-01-08 17:01:24', '2026-01-08 17:01:24', NULL),
(142, 25, 'UPDATE en usuario (ID: 3)', '08/01/2026 17:01 - Usuario: admin', 'activity', 'usuario', '3', 0, '2026-01-08 17:01:24', '2026-01-08 17:01:24', NULL),
(143, 28, 'UPDATE en usuario (ID: 3)', '08/01/2026 17:01 - Usuario: admin', 'activity', 'usuario', '3', 0, '2026-01-08 17:01:24', '2026-01-08 17:01:24', NULL),
(144, 29, 'UPDATE en usuario (ID: 3)', '08/01/2026 17:01 - Usuario: admin', 'activity', 'usuario', '3', 0, '2026-01-08 17:01:24', '2026-01-08 17:01:24', NULL),
(145, 30, 'UPDATE en usuario (ID: 3)', '08/01/2026 17:01 - Usuario: admin', 'activity', 'usuario', '3', 0, '2026-01-08 17:01:24', '2026-01-08 17:01:24', NULL),
(146, 21, 'UPDATE en usuario (ID: 3)', '08/01/2026 17:04 - Usuario: admin', 'activity', 'usuario', '3', 0, '2026-01-08 17:04:35', '2026-01-08 17:04:35', NULL),
(147, 25, 'UPDATE en usuario (ID: 3)', '08/01/2026 17:04 - Usuario: admin', 'activity', 'usuario', '3', 0, '2026-01-08 17:04:35', '2026-01-08 17:04:35', NULL),
(148, 28, 'UPDATE en usuario (ID: 3)', '08/01/2026 17:04 - Usuario: admin', 'activity', 'usuario', '3', 0, '2026-01-08 17:04:35', '2026-01-08 17:04:35', NULL),
(149, 29, 'UPDATE en usuario (ID: 3)', '08/01/2026 17:04 - Usuario: admin', 'activity', 'usuario', '3', 0, '2026-01-08 17:04:35', '2026-01-08 17:04:35', NULL),
(150, 30, 'UPDATE en usuario (ID: 3)', '08/01/2026 17:04 - Usuario: admin', 'activity', 'usuario', '3', 0, '2026-01-08 17:04:35', '2026-01-08 17:04:35', NULL),
(151, 21, 'UPDATE en usuario (ID: 3)', '08/01/2026 17:05 - Usuario: admin', 'activity', 'usuario', '3', 0, '2026-01-08 17:05:36', '2026-01-08 17:05:36', NULL),
(152, 25, 'UPDATE en usuario (ID: 3)', '08/01/2026 17:05 - Usuario: admin', 'activity', 'usuario', '3', 0, '2026-01-08 17:05:36', '2026-01-08 17:05:36', NULL),
(153, 28, 'UPDATE en usuario (ID: 3)', '08/01/2026 17:05 - Usuario: admin', 'activity', 'usuario', '3', 0, '2026-01-08 17:05:36', '2026-01-08 17:05:36', NULL),
(154, 29, 'UPDATE en usuario (ID: 3)', '08/01/2026 17:05 - Usuario: admin', 'activity', 'usuario', '3', 0, '2026-01-08 17:05:36', '2026-01-08 17:05:36', NULL),
(155, 30, 'UPDATE en usuario (ID: 3)', '08/01/2026 17:05 - Usuario: admin', 'activity', 'usuario', '3', 0, '2026-01-08 17:05:36', '2026-01-08 17:05:36', NULL),
(156, 21, 'INSERT en usuario (ID: 32)', '08/01/2026 17:09 - Usuario: admin', 'activity', 'usuario', '32', 0, '2026-01-08 17:09:42', '2026-01-08 17:09:42', NULL),
(157, 25, 'INSERT en usuario (ID: 32)', '08/01/2026 17:09 - Usuario: admin', 'activity', 'usuario', '32', 0, '2026-01-08 17:09:42', '2026-01-08 17:09:42', NULL),
(158, 28, 'INSERT en usuario (ID: 32)', '08/01/2026 17:09 - Usuario: admin', 'activity', 'usuario', '32', 0, '2026-01-08 17:09:42', '2026-01-08 17:09:42', NULL),
(159, 29, 'INSERT en usuario (ID: 32)', '08/01/2026 17:09 - Usuario: admin', 'activity', 'usuario', '32', 0, '2026-01-08 17:09:42', '2026-01-08 17:09:42', NULL),
(160, 30, 'INSERT en usuario (ID: 32)', '08/01/2026 17:09 - Usuario: admin', 'activity', 'usuario', '32', 0, '2026-01-08 17:09:42', '2026-01-08 17:09:42', NULL),
(161, 32, 'INSERT en usuario (ID: 32)', '08/01/2026 17:09 - Usuario: admin', 'activity', 'usuario', '32', 0, '2026-01-08 17:09:42', '2026-01-08 17:09:42', NULL),
(162, 21, 'INSERT en motos (ID: JC5501)', '08/01/2026 17:09 - Usuario: admin', 'activity', 'motos', 'JC5501', 0, '2026-01-08 17:09:56', '2026-01-08 17:09:56', NULL),
(163, 25, 'INSERT en motos (ID: JC5501)', '08/01/2026 17:09 - Usuario: admin', 'activity', 'motos', 'JC5501', 0, '2026-01-08 17:09:56', '2026-01-08 17:09:56', NULL),
(164, 28, 'INSERT en motos (ID: JC5501)', '08/01/2026 17:09 - Usuario: admin', 'activity', 'motos', 'JC5501', 0, '2026-01-08 17:09:56', '2026-01-08 17:09:56', NULL),
(165, 29, 'INSERT en motos (ID: JC5501)', '08/01/2026 17:09 - Usuario: admin', 'activity', 'motos', 'JC5501', 0, '2026-01-08 17:09:56', '2026-01-08 17:09:56', NULL),
(166, 30, 'INSERT en motos (ID: JC5501)', '08/01/2026 17:09 - Usuario: admin', 'activity', 'motos', 'JC5501', 0, '2026-01-08 17:09:56', '2026-01-08 17:09:56', NULL),
(167, 32, 'INSERT en motos (ID: JC5501)', '08/01/2026 17:09 - Usuario: admin', 'activity', 'motos', 'JC5501', 0, '2026-01-08 17:09:56', '2026-01-08 17:09:56', NULL),
(168, 21, 'UPDATE en usuario (ID: 28)', '08/01/2026 17:10 - Usuario: admin', 'activity', 'usuario', '28', 0, '2026-01-08 17:10:33', '2026-01-08 17:10:33', NULL),
(169, 25, 'UPDATE en usuario (ID: 28)', '08/01/2026 17:10 - Usuario: admin', 'activity', 'usuario', '28', 0, '2026-01-08 17:10:33', '2026-01-08 17:10:33', NULL),
(170, 28, 'UPDATE en usuario (ID: 28)', '08/01/2026 17:10 - Usuario: admin', 'activity', 'usuario', '28', 0, '2026-01-08 17:10:33', '2026-01-08 17:10:33', NULL),
(171, 29, 'UPDATE en usuario (ID: 28)', '08/01/2026 17:10 - Usuario: admin', 'activity', 'usuario', '28', 0, '2026-01-08 17:10:33', '2026-01-08 17:10:33', NULL),
(172, 30, 'UPDATE en usuario (ID: 28)', '08/01/2026 17:10 - Usuario: admin', 'activity', 'usuario', '28', 0, '2026-01-08 17:10:33', '2026-01-08 17:10:33', NULL),
(173, 32, 'UPDATE en usuario (ID: 28)', '08/01/2026 17:10 - Usuario: admin', 'activity', 'usuario', '28', 0, '2026-01-08 17:10:33', '2026-01-08 17:10:33', NULL),
(174, 21, 'DELETE en usuario (ID: 4)', '08/01/2026 17:11 - Usuario: admin', 'activity', 'usuario', '4', 0, '2026-01-08 17:11:45', '2026-01-08 17:11:45', NULL),
(175, 25, 'DELETE en usuario (ID: 4)', '08/01/2026 17:11 - Usuario: admin', 'activity', 'usuario', '4', 0, '2026-01-08 17:11:45', '2026-01-08 17:11:45', NULL),
(176, 28, 'DELETE en usuario (ID: 4)', '08/01/2026 17:11 - Usuario: admin', 'activity', 'usuario', '4', 0, '2026-01-08 17:11:45', '2026-01-08 17:11:45', NULL),
(177, 29, 'DELETE en usuario (ID: 4)', '08/01/2026 17:11 - Usuario: admin', 'activity', 'usuario', '4', 0, '2026-01-08 17:11:45', '2026-01-08 17:11:45', NULL),
(178, 30, 'DELETE en usuario (ID: 4)', '08/01/2026 17:11 - Usuario: admin', 'activity', 'usuario', '4', 0, '2026-01-08 17:11:45', '2026-01-08 17:11:45', NULL),
(179, 32, 'DELETE en usuario (ID: 4)', '08/01/2026 17:11 - Usuario: admin', 'activity', 'usuario', '4', 0, '2026-01-08 17:11:45', '2026-01-08 17:11:45', NULL),
(180, 21, 'DELETE en usuario (ID: 27)', '08/01/2026 17:11 - Usuario: admin', 'activity', 'usuario', '27', 0, '2026-01-08 17:11:58', '2026-01-08 17:11:58', NULL),
(181, 25, 'DELETE en usuario (ID: 27)', '08/01/2026 17:11 - Usuario: admin', 'activity', 'usuario', '27', 0, '2026-01-08 17:11:58', '2026-01-08 17:11:58', NULL),
(182, 28, 'DELETE en usuario (ID: 27)', '08/01/2026 17:11 - Usuario: admin', 'activity', 'usuario', '27', 0, '2026-01-08 17:11:58', '2026-01-08 17:11:58', NULL),
(183, 29, 'DELETE en usuario (ID: 27)', '08/01/2026 17:11 - Usuario: admin', 'activity', 'usuario', '27', 0, '2026-01-08 17:11:58', '2026-01-08 17:11:58', NULL),
(184, 30, 'DELETE en usuario (ID: 27)', '08/01/2026 17:11 - Usuario: admin', 'activity', 'usuario', '27', 0, '2026-01-08 17:11:58', '2026-01-08 17:11:58', NULL),
(185, 32, 'DELETE en usuario (ID: 27)', '08/01/2026 17:11 - Usuario: admin', 'activity', 'usuario', '27', 0, '2026-01-08 17:11:58', '2026-01-08 17:11:58', NULL),
(186, 25, 'DELETE en usuario (ID: 21)', '08/01/2026 17:12 - Usuario: admin', 'activity', 'usuario', '21', 0, '2026-01-08 17:12:04', '2026-01-08 17:12:04', NULL),
(187, 28, 'DELETE en usuario (ID: 21)', '08/01/2026 17:12 - Usuario: admin', 'activity', 'usuario', '21', 0, '2026-01-08 17:12:04', '2026-01-08 17:12:04', NULL),
(188, 29, 'DELETE en usuario (ID: 21)', '08/01/2026 17:12 - Usuario: admin', 'activity', 'usuario', '21', 0, '2026-01-08 17:12:04', '2026-01-08 17:12:04', NULL),
(189, 30, 'DELETE en usuario (ID: 21)', '08/01/2026 17:12 - Usuario: admin', 'activity', 'usuario', '21', 0, '2026-01-08 17:12:04', '2026-01-08 17:12:04', NULL),
(190, 32, 'DELETE en usuario (ID: 21)', '08/01/2026 17:12 - Usuario: admin', 'activity', 'usuario', '21', 0, '2026-01-08 17:12:04', '2026-01-08 17:12:04', NULL),
(191, 25, 'DELETE en usuario (ID: 2)', '08/01/2026 17:12 - Usuario: admin', 'activity', 'usuario', '2', 0, '2026-01-08 17:12:09', '2026-01-08 17:12:09', NULL),
(192, 28, 'DELETE en usuario (ID: 2)', '08/01/2026 17:12 - Usuario: admin', 'activity', 'usuario', '2', 0, '2026-01-08 17:12:09', '2026-01-08 17:12:09', NULL),
(193, 29, 'DELETE en usuario (ID: 2)', '08/01/2026 17:12 - Usuario: admin', 'activity', 'usuario', '2', 0, '2026-01-08 17:12:09', '2026-01-08 17:12:09', NULL),
(194, 30, 'DELETE en usuario (ID: 2)', '08/01/2026 17:12 - Usuario: admin', 'activity', 'usuario', '2', 0, '2026-01-08 17:12:09', '2026-01-08 17:12:09', NULL),
(195, 32, 'DELETE en usuario (ID: 2)', '08/01/2026 17:12 - Usuario: admin', 'activity', 'usuario', '2', 0, '2026-01-08 17:12:09', '2026-01-08 17:12:09', NULL),
(196, 25, 'DELETE en usuario (ID: 22)', '08/01/2026 17:12 - Usuario: admin', 'activity', 'usuario', '22', 0, '2026-01-08 17:12:15', '2026-01-08 17:12:15', NULL),
(197, 28, 'DELETE en usuario (ID: 22)', '08/01/2026 17:12 - Usuario: admin', 'activity', 'usuario', '22', 0, '2026-01-08 17:12:15', '2026-01-08 17:12:15', NULL),
(198, 29, 'DELETE en usuario (ID: 22)', '08/01/2026 17:12 - Usuario: admin', 'activity', 'usuario', '22', 0, '2026-01-08 17:12:15', '2026-01-08 17:12:15', NULL),
(199, 30, 'DELETE en usuario (ID: 22)', '08/01/2026 17:12 - Usuario: admin', 'activity', 'usuario', '22', 0, '2026-01-08 17:12:15', '2026-01-08 17:12:15', NULL),
(200, 32, 'DELETE en usuario (ID: 22)', '08/01/2026 17:12 - Usuario: admin', 'activity', 'usuario', '22', 0, '2026-01-08 17:12:15', '2026-01-08 17:12:15', NULL),
(201, 25, 'DELETE en usuario (ID: 31)', '08/01/2026 17:12 - Usuario: admin', 'activity', 'usuario', '31', 0, '2026-01-08 17:12:21', '2026-01-08 17:12:21', NULL),
(202, 28, 'DELETE en usuario (ID: 31)', '08/01/2026 17:12 - Usuario: admin', 'activity', 'usuario', '31', 0, '2026-01-08 17:12:21', '2026-01-08 17:12:21', NULL),
(203, 29, 'DELETE en usuario (ID: 31)', '08/01/2026 17:12 - Usuario: admin', 'activity', 'usuario', '31', 0, '2026-01-08 17:12:21', '2026-01-08 17:12:21', NULL),
(204, 30, 'DELETE en usuario (ID: 31)', '08/01/2026 17:12 - Usuario: admin', 'activity', 'usuario', '31', 0, '2026-01-08 17:12:21', '2026-01-08 17:12:21', NULL),
(205, 32, 'DELETE en usuario (ID: 31)', '08/01/2026 17:12 - Usuario: admin', 'activity', 'usuario', '31', 0, '2026-01-08 17:12:21', '2026-01-08 17:12:21', NULL),
(206, 25, 'DELETE en usuario (ID: 30)', '08/01/2026 17:12 - Usuario: admin', 'activity', 'usuario', '30', 0, '2026-01-08 17:12:28', '2026-01-08 17:12:28', NULL),
(207, 28, 'DELETE en usuario (ID: 30)', '08/01/2026 17:12 - Usuario: admin', 'activity', 'usuario', '30', 0, '2026-01-08 17:12:28', '2026-01-08 17:12:28', NULL),
(208, 29, 'DELETE en usuario (ID: 30)', '08/01/2026 17:12 - Usuario: admin', 'activity', 'usuario', '30', 0, '2026-01-08 17:12:28', '2026-01-08 17:12:28', NULL),
(209, 32, 'DELETE en usuario (ID: 30)', '08/01/2026 17:12 - Usuario: admin', 'activity', 'usuario', '30', 0, '2026-01-08 17:12:28', '2026-01-08 17:12:28', NULL),
(210, 25, 'DELETE en usuario (ID: 32)', '08/01/2026 17:12 - Usuario: admin', 'activity', 'usuario', '32', 0, '2026-01-08 17:12:33', '2026-01-08 17:12:33', NULL),
(211, 28, 'DELETE en usuario (ID: 32)', '08/01/2026 17:12 - Usuario: admin', 'activity', 'usuario', '32', 0, '2026-01-08 17:12:33', '2026-01-08 17:12:33', NULL),
(212, 29, 'DELETE en usuario (ID: 32)', '08/01/2026 17:12 - Usuario: admin', 'activity', 'usuario', '32', 0, '2026-01-08 17:12:33', '2026-01-08 17:12:33', NULL),
(213, 25, 'DELETE en usuario (ID: 26)', '08/01/2026 17:12 - Usuario: admin', 'activity', 'usuario', '26', 0, '2026-01-08 17:12:57', '2026-01-08 17:12:57', NULL),
(214, 28, 'DELETE en usuario (ID: 26)', '08/01/2026 17:12 - Usuario: admin', 'activity', 'usuario', '26', 0, '2026-01-08 17:12:57', '2026-01-08 17:12:57', NULL),
(215, 29, 'DELETE en usuario (ID: 26)', '08/01/2026 17:12 - Usuario: admin', 'activity', 'usuario', '26', 0, '2026-01-08 17:12:57', '2026-01-08 17:12:57', NULL),
(216, 25, 'DELETE en usuario (ID: 24)', '08/01/2026 17:13 - Usuario: admin', 'activity', 'usuario', '24', 0, '2026-01-08 17:13:48', '2026-01-08 17:13:48', NULL),
(217, 28, 'DELETE en usuario (ID: 24)', '08/01/2026 17:13 - Usuario: admin', 'activity', 'usuario', '24', 0, '2026-01-08 17:13:48', '2026-01-08 17:13:48', NULL),
(218, 29, 'DELETE en usuario (ID: 24)', '08/01/2026 17:13 - Usuario: admin', 'activity', 'usuario', '24', 0, '2026-01-08 17:13:48', '2026-01-08 17:13:48', NULL),
(219, 25, 'DELETE en usuario (ID: 20)', '08/01/2026 17:14 - Usuario: admin', 'activity', 'usuario', '20', 0, '2026-01-08 17:14:02', '2026-01-08 17:14:02', NULL),
(220, 28, 'DELETE en usuario (ID: 20)', '08/01/2026 17:14 - Usuario: admin', 'activity', 'usuario', '20', 0, '2026-01-08 17:14:02', '2026-01-08 17:14:02', NULL),
(221, 29, 'DELETE en usuario (ID: 20)', '08/01/2026 17:14 - Usuario: admin', 'activity', 'usuario', '20', 0, '2026-01-08 17:14:02', '2026-01-08 17:14:02', NULL),
(222, 25, 'INSERT en motos (ID: MW)', '12/01/2026 15:37 - Usuario: admin', 'activity', 'motos', 'MW', 0, '2026-01-12 15:37:46', '2026-01-12 15:37:46', NULL),
(223, 28, 'INSERT en motos (ID: MW)', '12/01/2026 15:37 - Usuario: admin', 'activity', 'motos', 'MW', 0, '2026-01-12 15:37:46', '2026-01-12 15:37:46', NULL),
(224, 29, 'INSERT en motos (ID: MW)', '12/01/2026 15:37 - Usuario: admin', 'activity', 'motos', 'MW', 0, '2026-01-12 15:37:46', '2026-01-12 15:37:46', NULL),
(225, 25, 'UPDATE en motos (ID: MW)', '12/01/2026 15:39 - Usuario: admin', 'activity', 'motos', 'MW', 0, '2026-01-12 15:39:02', '2026-01-12 15:39:02', NULL),
(226, 28, 'UPDATE en motos (ID: MW)', '12/01/2026 15:39 - Usuario: admin', 'activity', 'motos', 'MW', 0, '2026-01-12 15:39:02', '2026-01-12 15:39:02', NULL),
(227, 29, 'UPDATE en motos (ID: MW)', '12/01/2026 15:39 - Usuario: admin', 'activity', 'motos', 'MW', 0, '2026-01-12 15:39:02', '2026-01-12 15:39:02', NULL),
(228, 25, 'UPDATE en motos (ID: H63452)', '12/01/2026 15:45 - Usuario: admin', 'activity', 'motos', 'H63452', 0, '2026-01-12 15:45:26', '2026-01-12 15:45:26', NULL),
(229, 28, 'UPDATE en motos (ID: H63452)', '12/01/2026 15:45 - Usuario: admin', 'activity', 'motos', 'H63452', 0, '2026-01-12 15:45:26', '2026-01-12 15:45:26', NULL),
(230, 29, 'UPDATE en motos (ID: H63452)', '12/01/2026 15:45 - Usuario: admin', 'activity', 'motos', 'H63452', 0, '2026-01-12 15:45:26', '2026-01-12 15:45:26', NULL),
(231, 25, 'UPDATE en motos (ID: H63452)', '12/01/2026 15:46 - Usuario: admin', 'activity', 'motos', 'H63452', 0, '2026-01-12 15:46:26', '2026-01-12 15:46:26', NULL),
(232, 28, 'UPDATE en motos (ID: H63452)', '12/01/2026 15:46 - Usuario: admin', 'activity', 'motos', 'H63452', 0, '2026-01-12 15:46:26', '2026-01-12 15:46:26', NULL),
(233, 29, 'UPDATE en motos (ID: H63452)', '12/01/2026 15:46 - Usuario: admin', 'activity', 'motos', 'H63452', 0, '2026-01-12 15:46:26', '2026-01-12 15:46:26', NULL),
(234, 3, 'UPDATE en usuario (ID: 29)', '13/01/2026 09:15 - Usuario: Alfredo', 'activity', 'usuario', '29', 0, '2026-01-13 09:15:04', '2026-01-13 09:15:04', NULL),
(235, 25, 'UPDATE en usuario (ID: 29)', '13/01/2026 09:15 - Usuario: Alfredo', 'activity', 'usuario', '29', 0, '2026-01-13 09:15:04', '2026-01-13 09:15:04', NULL),
(236, 28, 'UPDATE en usuario (ID: 29)', '13/01/2026 09:15 - Usuario: Alfredo', 'activity', 'usuario', '29', 0, '2026-01-13 09:15:04', '2026-01-13 09:15:04', NULL),
(237, 25, 'UPDATE en usuario (ID: 29)', '13/01/2026 09:16 - Usuario: admin', 'activity', 'usuario', '29', 0, '2026-01-13 09:16:32', '2026-01-13 09:16:32', NULL),
(238, 28, 'UPDATE en usuario (ID: 29)', '13/01/2026 09:16 - Usuario: admin', 'activity', 'usuario', '29', 0, '2026-01-13 09:16:32', '2026-01-13 09:16:32', NULL),
(239, 25, 'INSERT en rental_history (ID: 3)', '13/01/2026 09:54 - Usuario: admin', 'activity', 'rental_history', '3', 0, '2026-01-13 09:54:21', '2026-01-13 09:54:21', NULL),
(240, 28, 'INSERT en rental_history (ID: 3)', '13/01/2026 09:54 - Usuario: admin', 'activity', 'rental_history', '3', 0, '2026-01-13 09:54:21', '2026-01-13 09:54:21', NULL),
(241, 25, 'INSERT en rental_history (ID: 4)', '13/01/2026 09:54 - Usuario: admin', 'activity', 'rental_history', '4', 0, '2026-01-13 09:54:28', '2026-01-13 09:54:28', NULL),
(242, 28, 'INSERT en rental_history (ID: 4)', '13/01/2026 09:54 - Usuario: admin', 'activity', 'rental_history', '4', 0, '2026-01-13 09:54:28', '2026-01-13 09:54:28', NULL),
(243, 25, 'INSERT en rental_history (ID: 5)', '13/01/2026 09:54 - Usuario: admin', 'activity', 'rental_history', '5', 0, '2026-01-13 09:54:34', '2026-01-13 09:54:34', NULL),
(244, 28, 'INSERT en rental_history (ID: 5)', '13/01/2026 09:54 - Usuario: admin', 'activity', 'rental_history', '5', 0, '2026-01-13 09:54:34', '2026-01-13 09:54:34', NULL),
(245, 25, 'INSERT en motos (ID: JC21007)', '13/01/2026 12:37 - Usuario: admin', 'activity', 'motos', 'JC21007', 0, '2026-01-13 12:37:18', '2026-01-13 12:37:18', NULL),
(246, 28, 'INSERT en motos (ID: JC21007)', '13/01/2026 12:37 - Usuario: admin', 'activity', 'motos', 'JC21007', 0, '2026-01-13 12:37:18', '2026-01-13 12:37:18', NULL),
(247, 25, 'INSERT en motos (ID: PRUEBA1)', '13/01/2026 14:05 - Usuario: admin', 'activity', 'motos', 'PRUEBA1', 0, '2026-01-13 14:05:10', '2026-01-13 14:05:10', NULL),
(248, 28, 'INSERT en motos (ID: PRUEBA1)', '13/01/2026 14:05 - Usuario: admin', 'activity', 'motos', 'PRUEBA1', 0, '2026-01-13 14:05:10', '2026-01-13 14:05:10', NULL),
(251, 25, 'UPDATE en motos (ID: PRUEBA1)', '13/01/2026 14:47 - Usuario: admin', 'activity', 'motos', 'PRUEBA1', 0, '2026-01-13 14:47:15', '2026-01-13 14:47:15', NULL),
(252, 28, 'UPDATE en motos (ID: PRUEBA1)', '13/01/2026 14:47 - Usuario: admin', 'activity', 'motos', 'PRUEBA1', 0, '2026-01-13 14:47:15', '2026-01-13 14:47:15', NULL),
(253, 25, 'INSERT en motos (ID: JC210078)', '13/01/2026 14:47 - Usuario: admin', 'activity', 'motos', 'JC210078', 0, '2026-01-13 14:47:15', '2026-01-13 14:47:15', NULL),
(254, 28, 'INSERT en motos (ID: JC210078)', '13/01/2026 14:47 - Usuario: admin', 'activity', 'motos', 'JC210078', 0, '2026-01-13 14:47:15', '2026-01-13 14:47:15', NULL),
(255, 25, 'UPDATE en motos (ID: JC21007)', '13/01/2026 14:48 - Usuario: admin', 'activity', 'motos', 'JC21007', 0, '2026-01-13 14:48:43', '2026-01-13 14:48:43', NULL),
(256, 28, 'UPDATE en motos (ID: JC21007)', '13/01/2026 14:48 - Usuario: admin', 'activity', 'motos', 'JC21007', 0, '2026-01-13 14:48:43', '2026-01-13 14:48:43', NULL),
(257, 25, 'INSERT en motos (ID: PRUEBA2)', '13/01/2026 14:48 - Usuario: admin', 'activity', 'motos', 'PRUEBA2', 0, '2026-01-13 14:48:43', '2026-01-13 14:48:43', NULL),
(258, 28, 'INSERT en motos (ID: PRUEBA2)', '13/01/2026 14:48 - Usuario: admin', 'activity', 'motos', 'PRUEBA2', 0, '2026-01-13 14:48:43', '2026-01-13 14:48:43', NULL),
(263, 25, 'UPDATE en motos (ID: JC210078)', '13/01/2026 14:50 - Usuario: admin', 'activity', 'motos', 'JC210078', 0, '2026-01-13 14:50:26', '2026-01-13 14:50:26', NULL),
(264, 28, 'UPDATE en motos (ID: JC210078)', '13/01/2026 14:50 - Usuario: admin', 'activity', 'motos', 'JC210078', 0, '2026-01-13 14:50:26', '2026-01-13 14:50:26', NULL),
(265, 25, 'INSERT en motos (ID: JC2100725)', '13/01/2026 14:50 - Usuario: admin', 'activity', 'motos', 'JC2100725', 0, '2026-01-13 14:50:26', '2026-01-13 14:50:26', NULL),
(266, 28, 'INSERT en motos (ID: JC2100725)', '13/01/2026 14:50 - Usuario: admin', 'activity', 'motos', 'JC2100725', 0, '2026-01-13 14:50:26', '2026-01-13 14:50:26', NULL),
(271, 25, 'UPDATE en motos (ID: JC2100725)', '13/01/2026 14:58 - Usuario: admin', 'activity', 'motos', 'JC2100725', 0, '2026-01-13 14:58:16', '2026-01-13 14:58:16', NULL),
(272, 28, 'UPDATE en motos (ID: JC2100725)', '13/01/2026 14:58 - Usuario: admin', 'activity', 'motos', 'JC2100725', 0, '2026-01-13 14:58:16', '2026-01-13 14:58:16', NULL),
(273, 25, 'INSERT en motos (ID: JC210007)', '13/01/2026 14:58 - Usuario: admin', 'activity', 'motos', 'JC210007', 0, '2026-01-13 14:58:16', '2026-01-13 14:58:16', NULL),
(274, 28, 'INSERT en motos (ID: JC210007)', '13/01/2026 14:58 - Usuario: admin', 'activity', 'motos', 'JC210007', 0, '2026-01-13 14:58:16', '2026-01-13 14:58:16', NULL),
(277, 25, 'UPDATE en motos (ID: PRUEBA1)', '14/01/2026 09:09 - Usuario: admin', 'activity', 'motos', 'PRUEBA1', 0, '2026-01-14 09:09:08', '2026-01-14 09:09:08', NULL),
(278, 28, 'UPDATE en motos (ID: PRUEBA1)', '14/01/2026 09:09 - Usuario: admin', 'activity', 'motos', 'PRUEBA1', 0, '2026-01-14 09:09:08', '2026-01-14 09:09:08', NULL),
(279, 25, 'UPDATE en motos (ID: PRUEBA2)', '14/01/2026 09:47 - Usuario: admin', 'activity', 'motos', 'PRUEBA2', 0, '2026-01-14 09:47:12', '2026-01-14 09:47:12', NULL),
(280, 28, 'UPDATE en motos (ID: PRUEBA2)', '14/01/2026 09:47 - Usuario: admin', 'activity', 'motos', 'PRUEBA2', 0, '2026-01-14 09:47:12', '2026-01-14 09:47:12', NULL),
(281, 25, 'INSERT en motos (ID: MW2025)', '14/01/2026 09:47 - Usuario: admin', 'activity', 'motos', 'MW2025', 0, '2026-01-14 09:47:12', '2026-01-14 09:47:12', NULL),
(282, 28, 'INSERT en motos (ID: MW2025)', '14/01/2026 09:47 - Usuario: admin', 'activity', 'motos', 'MW2025', 0, '2026-01-14 09:47:12', '2026-01-14 09:47:12', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rental_history`
--

CREATE TABLE `rental_history` (
  `id` int(11) UNSIGNED NOT NULL,
  `placa` varchar(15) NOT NULL,
  `idcliente` int(11) NOT NULL,
  `fecha_entrega` date NOT NULL,
  `fecha_renovacion` date DEFAULT NULL,
  `renta_sinIva` decimal(10,2) DEFAULT NULL,
  `renta_conIva` decimal(10,2) DEFAULT NULL,
  `naf` varchar(20) DEFAULT NULL,
  `fecha_finalizacion` datetime NOT NULL DEFAULT current_timestamp(),
  `finalizado_por` int(11) DEFAULT NULL,
  `idmarca` int(11) NOT NULL,
  `modelo` varchar(50) NOT NULL,
  `año` int(11) NOT NULL,
  `idagencia` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicios`
--

CREATE TABLE `servicios` (
  `id` int(11) UNSIGNED NOT NULL,
  `placa_motocicleta` varchar(15) NOT NULL,
  `tipo_servicio` varchar(100) NOT NULL,
  `descripcion` text NOT NULL,
  `estado_servicio` enum('pendiente','en_progreso','completado','cancelado') NOT NULL DEFAULT 'pendiente',
  `fecha_solicitud` date NOT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_completado` date DEFAULT NULL,
  `costo_estimado` decimal(10,2) DEFAULT NULL,
  `costo_real` decimal(10,2) DEFAULT NULL,
  `tecnico_responsable` varchar(100) DEFAULT NULL,
  `notas` text DEFAULT NULL,
  `prioridad` enum('baja','media','alta','urgente') NOT NULL DEFAULT 'media',
  `kilometraje_actual` int(11) UNSIGNED DEFAULT NULL,
  `estado_original_motocicleta` int(11) DEFAULT NULL COMMENT 'Estado original de la motocicleta antes del servicio',
  `creado_por` int(11) NOT NULL,
  `modificado_por` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `idUsuario` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `user` varchar(50) DEFAULT NULL,
  `Password` varchar(255) DEFAULT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `estado` tinyint(1) DEFAULT NULL,
  `rol` varchar(20) DEFAULT NULL,
  `dui` varchar(10) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `last_login` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idUsuario`, `nombre`, `user`, `Password`, `correo`, `estado`, `rol`, `dui`, `created_at`, `last_login`, `updated_at`) VALUES
(1, 'Arch Test User', 'testuser', '444$', 'test@example.com', 1, 'Operativo', '00000000-0', '2025-06-08 17:11:49', NULL, '2025-06-09 19:09:17'),
(3, 'Admin', 'admin', '$2y$10$DHQG9ZVwJ7rr1IOTb8PllePpN5JuJOHWCJ9RDdnFHxHRF8KIbHduG', 'admin@example.sv', 1, 'Administrador', '02632569-4', '2025-06-08 17:11:49', NULL, '2026-01-08 17:05:36'),
(9, 'asdasfaf', 'fasfasfasf', '$2y$12$WRIVfwitvgl6.wXhIVieaOLOuA/0gvFMMhIFmBcGkkWqyZgaZDXUS', 'qweqweqweq@test.com', 1, 'Visualizador', '63542711-1', '2025-06-09 18:38:35', NULL, '2025-06-09 18:38:35'),
(23, 'ARCH', 'arch', '$2y$12$8s9w6n9xj25HKhpq72gQ1etfaQCM7caszJYdvYfpBvhafm8qoUJ4K', 'test@test.com', 1, 'Operativo', '99237312-4', '2025-06-15 21:12:37', NULL, '2025-06-15 21:12:37'),
(25, 'Jefe', 'Jefatura', '$2y$12$2qhqxfFwcuKXVVzJwdlivugtUlsYJLlaCCSyI5OeIAwqxhtv4.uV6', 'asgfdha@gmail.com', 1, 'Administrador', '15615615-7', '2025-10-14 20:41:10', NULL, '2026-01-07 14:22:59'),
(28, 'Admin2', 'admin2', '$2y$12$iM2nsQMZMh16J7GO9HqiiuTlPFvlZsXdZ1lMcyCyUQlBqqQVWZxc6', 'admin@rentatotal.com', 1, 'Administrador', '65645640-4', '2025-10-28 17:43:51', NULL, '2026-01-08 17:10:33'),
(29, 'Alfredo Vidal Jimenez', 'Alfredo', '$2y$10$el.cavcaw20O.jK/3uLFU.IIZqzJmNFCZYMFOKWqxX32Be3ybL1OK', 'alfredo.jimenez@crediopciones.com', 1, 'Visualizador', '06269319-4', '2026-01-07 21:22:10', NULL, '2026-01-13 09:16:32');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `activity_log`
--
ALTER TABLE `activity_log`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `agencia`
--
ALTER TABLE `agencia`
  ADD PRIMARY KEY (`idagencia`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`idCliente`),
  ADD KEY `idempresa` (`idempresa`);

--
-- Indices de la tabla `departamento`
--
ALTER TABLE `departamento`
  ADD PRIMARY KEY (`iddepartamento`);

--
-- Indices de la tabla `empresa`
--
ALTER TABLE `empresa`
  ADD PRIMARY KEY (`idempresa`);

--
-- Indices de la tabla `estado`
--
ALTER TABLE `estado`
  ADD PRIMARY KEY (`idestado`);

--
-- Indices de la tabla `marca`
--
ALTER TABLE `marca`
  ADD PRIMARY KEY (`idmarca`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `motocicleta_bitacora`
--
ALTER TABLE `motocicleta_bitacora`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_placa` (`placa`),
  ADD KEY `idx_usuario` (`idUsuario`);

--
-- Indices de la tabla `motos`
--
ALTER TABLE `motos`
  ADD PRIMARY KEY (`placa`),
  ADD KEY `idestado` (`idestado`),
  ADD KEY `idcliente` (`idcliente`),
  ADD KEY `idmarca` (`idmarca`),
  ADD KEY `iddepartamento` (`iddepartamento`),
  ADD KEY `idagencia` (`idagencia`),
  ADD KEY `creado_por` (`creado_por`),
  ADD KEY `modificado_por` (`modificado_por`),
  ADD KEY `idx_placa_anterior` (`placa_anterior`);

--
-- Indices de la tabla `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `is_read` (`is_read`),
  ADD KEY `type` (`type`);

--
-- Indices de la tabla `rental_history`
--
ALTER TABLE `rental_history`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `servicios`
--
ALTER TABLE `servicios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_servicios_usuario` (`creado_por`),
  ADD KEY `fk_servicios_motos` (`placa_motocicleta`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idUsuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `activity_log`
--
ALTER TABLE `activity_log`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

--
-- AUTO_INCREMENT de la tabla `agencia`
--
ALTER TABLE `agencia`
  MODIFY `idagencia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `idCliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `departamento`
--
ALTER TABLE `departamento`
  MODIFY `iddepartamento` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `empresa`
--
ALTER TABLE `empresa`
  MODIFY `idempresa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `estado`
--
ALTER TABLE `estado`
  MODIFY `idestado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `marca`
--
ALTER TABLE `marca`
  MODIFY `idmarca` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `motocicleta_bitacora`
--
ALTER TABLE `motocicleta_bitacora`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=283;

--
-- AUTO_INCREMENT de la tabla `rental_history`
--
ALTER TABLE `rental_history`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `servicios`
--
ALTER TABLE `servicios`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD CONSTRAINT `cliente_ibfk_1` FOREIGN KEY (`idempresa`) REFERENCES `empresa` (`idempresa`);

--
-- Filtros para la tabla `motocicleta_bitacora`
--
ALTER TABLE `motocicleta_bitacora`
  ADD CONSTRAINT `fk_bitacora_moto` FOREIGN KEY (`placa`) REFERENCES `motos` (`placa`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_bitacora_usuario` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Filtros para la tabla `motos`
--
ALTER TABLE `motos`
  ADD CONSTRAINT `motos_ibfk_1` FOREIGN KEY (`idestado`) REFERENCES `estado` (`idestado`),
  ADD CONSTRAINT `motos_ibfk_2` FOREIGN KEY (`idcliente`) REFERENCES `cliente` (`idCliente`),
  ADD CONSTRAINT `motos_ibfk_3` FOREIGN KEY (`idmarca`) REFERENCES `marca` (`idmarca`),
  ADD CONSTRAINT `motos_ibfk_4` FOREIGN KEY (`iddepartamento`) REFERENCES `departamento` (`iddepartamento`),
  ADD CONSTRAINT `motos_ibfk_5` FOREIGN KEY (`idagencia`) REFERENCES `agencia` (`idagencia`),
  ADD CONSTRAINT `motos_ibfk_6` FOREIGN KEY (`creado_por`) REFERENCES `usuario` (`idUsuario`),
  ADD CONSTRAINT `motos_ibfk_7` FOREIGN KEY (`modificado_por`) REFERENCES `usuario` (`idUsuario`);

--
-- Filtros para la tabla `servicios`
--
ALTER TABLE `servicios`
  ADD CONSTRAINT `fk_servicios_motos` FOREIGN KEY (`placa_motocicleta`) REFERENCES `motos` (`placa`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_servicios_usuario` FOREIGN KEY (`creado_por`) REFERENCES `usuario` (`idUsuario`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
