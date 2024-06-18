-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 18, 2024 at 05:03 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.3.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `editorial`
--

-- --------------------------------------------------------

--
-- Table structure for table `adjuntos`
--

CREATE TABLE `adjuntos` (
  `id_adjunto` int(11) NOT NULL,
  `uri` varchar(200) NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `adjuntos`
--

INSERT INTO `adjuntos` (`id_adjunto`, `uri`, `descripcion`, `id_producto`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'adjunto1_prod1.jpg', 'Adjunto de Producto 1', 7, '2024-06-18 00:20:03', '2024-06-18 00:20:03', NULL),
(2, 'adjunto2_prod2.jpg', 'Adjunto de Producto 2', 8, '2024-06-18 00:20:03', '2024-06-18 00:20:03', NULL),
(3, 'adjunto3_prod3.jpg', 'Adjunto de Producto 3', 9, '2024-06-18 00:20:03', '2024-06-18 00:20:03', NULL),
(4, 'adjunto4_prod4.jpg', 'Adjunto de Producto 4', 10, '2024-06-18 00:20:03', '2024-06-18 00:20:03', NULL),
(5, 'adjunto5_prod5.jpg', 'Adjunto de Producto 5', 11, '2024-06-18 00:20:03', '2024-06-18 00:20:03', NULL),
(6, 'adjunto6_prod6.jpg', 'Adjunto de Producto 6', 12, '2024-06-18 00:20:03', '2024-06-18 00:20:03', NULL),
(7, 'adjunto7_prod7.jpg', 'Adjunto de Producto 7', 13, '2024-06-18 00:20:03', '2024-06-18 00:20:03', NULL),
(8, 'adjunto8_prod8.jpg', 'Adjunto de Producto 8', 14, '2024-06-18 00:20:03', '2024-06-18 00:20:03', NULL),
(9, 'adjunto9_prod9.jpg', 'Adjunto de Producto 9', 15, '2024-06-18 00:20:03', '2024-06-18 00:20:03', NULL),
(10, 'adjunto10_prod10.jpg', 'Adjunto de Producto 10', 16, '2024-06-18 00:20:03', '2024-06-18 00:20:03', NULL),
(11, 'adjunto11_prod11.jpg', 'Adjunto de Producto 11', 17, '2024-06-18 00:20:04', '2024-06-18 00:20:04', NULL),
(12, 'adjunto12_prod12.jpg', 'Adjunto de Producto 12', 18, '2024-06-18 00:20:04', '2024-06-18 00:20:04', NULL),
(13, 'adjunto13_prod13.jpg', 'Adjunto de Producto 13', 19, '2024-06-18 00:20:04', '2024-06-18 00:20:04', NULL),
(14, 'adjunto14_prod14.jpg', 'Adjunto de Producto 14', 20, '2024-06-18 00:20:04', '2024-06-18 00:20:04', NULL),
(15, 'adjunto15_prod15.jpg', 'Adjunto de Producto 15', 21, '2024-06-18 00:20:04', '2024-06-18 00:20:04', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `almacenes`
--

CREATE TABLE `almacenes` (
  `id_almacen` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `almacenes`
--

INSERT INTO `almacenes` (`id_almacen`, `nombre`, `created_at`, `updated_at`, `deleted_at`) VALUES
(4, 'Almacén Principal', '2024-06-18 00:10:59', '2024-06-18 00:10:59', NULL),
(5, 'Almacén Secundario', '2024-06-18 00:10:59', '2024-06-18 00:10:59', NULL),
(6, 'Almacén Terciario', '2024-06-18 00:10:59', '2024-06-18 00:10:59', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `categorias`
--

CREATE TABLE `categorias` (
  `id_categoria` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categorias`
--

INSERT INTO `categorias` (`id_categoria`, `nombre`, `created_at`, `updated_at`, `deleted_at`) VALUES
(7, 'Categoría A', '2024-06-18 00:10:59', '2024-06-18 00:10:59', NULL),
(8, 'Categoría B', '2024-06-18 00:10:59', '2024-06-18 00:10:59', NULL),
(9, 'Categoría C', '2024-06-18 00:10:59', '2024-06-18 00:10:59', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `contactos`
--

CREATE TABLE `contactos` (
  `id_persona` int(11) NOT NULL,
  `id_empresa` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contactos`
--

INSERT INTO `contactos` (`id_persona`, `id_empresa`, `created_at`, `updated_at`, `deleted_at`) VALUES
(10, 7, '2024-06-18 00:19:21', '2024-06-18 00:19:21', NULL),
(11, 8, '2024-06-18 00:19:21', '2024-06-18 00:19:21', NULL),
(12, 9, '2024-06-18 00:19:21', '2024-06-18 00:19:21', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cuotas`
--

CREATE TABLE `cuotas` (
  `id_cuota` int(11) NOT NULL,
  `numero` int(10) NOT NULL,
  `codigo` varchar(100) NOT NULL,
  `concepto` varchar(200) NOT NULL,
  `fecha_venc` date NOT NULL,
  `monto_pagar` decimal(10,2) NOT NULL,
  `monto_pagado` decimal(10,2) NOT NULL,
  `monto_adeudado` decimal(10,2) NOT NULL,
  `condicion` varchar(100) NOT NULL,
  `id_movimiento` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cuotas`
--

INSERT INTO `cuotas` (`id_cuota`, `numero`, `codigo`, `concepto`, `fecha_venc`, `monto_pagar`, `monto_pagado`, `monto_adeudado`, `condicion`, `id_movimiento`, `created_at`, `updated_at`, `deleted_at`) VALUES
(9, 1, 'CUOTA001-MOV001', 'Cuota de prueba 1 para MOV001', '2024-07-01', 50.00, 0.00, 50.00, 'pendiente', 21, '2024-06-18 00:30:47', '2024-06-18 00:30:47', NULL),
(10, 2, 'CUOTA002-MOV001', 'Cuota de prueba 2 para MOV001', '2024-07-15', 50.00, 0.00, 50.00, 'pendiente', 21, '2024-06-18 00:30:47', '2024-06-18 00:30:47', NULL),
(11, 1, 'CUOTA001-MOV002', 'Cuota de prueba 1 para MOV002', '2024-07-01', 75.00, 0.00, 75.00, 'pendiente', 22, '2024-06-18 00:30:47', '2024-06-18 00:30:47', NULL),
(12, 2, 'CUOTA002-MOV002', 'Cuota de prueba 2 para MOV002', '2024-07-15', 75.00, 0.00, 75.00, 'pendiente', 22, '2024-06-18 00:30:47', '2024-06-18 00:30:47', NULL),
(13, 1, 'CUOTA001-MOV003', 'Cuota de prueba 1 para MOV003', '2024-07-01', 100.00, 0.00, 100.00, 'pendiente', 23, '2024-06-18 00:30:47', '2024-06-18 00:30:47', NULL),
(14, 2, 'CUOTA002-MOV003', 'Cuota de prueba 2 para MOV003', '2024-07-15', 100.00, 0.00, 100.00, 'pendiente', 23, '2024-06-18 00:30:47', '2024-06-18 00:30:47', NULL),
(15, 1, 'CUOTA001-MOV004', 'Cuota de prueba 1 para MOV004', '2024-07-01', 60.00, 0.00, 60.00, 'pendiente', 24, '2024-06-18 00:30:47', '2024-06-18 00:30:47', NULL),
(16, 2, 'CUOTA002-MOV004', 'Cuota de prueba 2 para MOV004', '2024-07-15', 60.00, 0.00, 60.00, 'pendiente', 24, '2024-06-18 00:30:47', '2024-06-18 00:30:47', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `detalles`
--

CREATE TABLE `detalles` (
  `id_detalle` int(11) NOT NULL,
  `cantidad` int(10) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `id_movimiento` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detalles`
--

INSERT INTO `detalles` (`id_detalle`, `cantidad`, `precio`, `total`, `id_movimiento`, `id_producto`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 2, 50.00, 100.00, 21, 7, '2024-06-18 00:27:27', '2024-06-18 00:27:27', NULL),
(2, 3, 30.00, 90.00, 21, 8, '2024-06-18 00:27:27', '2024-06-18 00:27:27', NULL),
(3, 5, 30.00, 150.00, 22, 8, '2024-06-18 00:27:27', '2024-06-18 00:27:27', NULL),
(4, 4, 25.00, 100.00, 22, 7, '2024-06-18 00:27:27', '2024-06-18 00:27:27', NULL),
(5, 8, 25.00, 200.00, 23, 9, '2024-06-18 00:27:28', '2024-06-18 00:27:28', NULL),
(6, 6, 30.00, 180.00, 23, 10, '2024-06-18 00:27:28', '2024-06-18 00:27:28', NULL),
(7, 3, 40.00, 120.00, 24, 11, '2024-06-18 00:27:28', '2024-06-18 00:27:28', NULL),
(8, 2, 35.00, 70.00, 24, 12, '2024-06-18 00:27:28', '2024-06-18 00:27:28', NULL),
(9, 6, 20.00, 120.00, 25, 7, '2024-06-18 00:27:28', '2024-06-18 00:27:28', NULL),
(10, 4, 25.00, 100.00, 25, 9, '2024-06-18 00:27:28', '2024-06-18 00:27:28', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `empresas`
--

CREATE TABLE `empresas` (
  `id_empresa` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `imagen` varchar(200) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `empresas`
--

INSERT INTO `empresas` (`id_empresa`, `nombre`, `imagen`, `created_at`, `updated_at`, `deleted_at`) VALUES
(7, 'Empresa A', 'imagen_empresa_a.jpg', '2024-06-18 00:10:59', '2024-06-18 00:10:59', NULL),
(8, 'Empresa B', 'imagen_empresa_b.jpg', '2024-06-18 00:10:59', '2024-06-18 00:10:59', NULL),
(9, 'Empresa C', 'imagen_empresa_c.jpg', '2024-06-18 00:10:59', '2024-06-18 00:10:59', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `movimientos`
--

CREATE TABLE `movimientos` (
  `id_movimiento` int(11) NOT NULL,
  `codigo` varchar(100) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT current_timestamp(),
  `glose` varchar(200) DEFAULT NULL,
  `tipo` varchar(100) NOT NULL,
  `id_cliente` int(11) DEFAULT NULL,
  `id_recinto` int(11) DEFAULT NULL,
  `id_proveedor` int(11) DEFAULT NULL,
  `id_operador` int(11) NOT NULL,
  `id_almacen` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `movimientos`
--

INSERT INTO `movimientos` (`id_movimiento`, `codigo`, `fecha`, `glose`, `tipo`, `id_cliente`, `id_recinto`, `id_proveedor`, `id_operador`, `id_almacen`, `created_at`, `updated_at`, `deleted_at`) VALUES
(21, 'MOV001', '2024-06-17 20:26:24', 'Movimiento de prueba 1', 'entrada', 10, 3, NULL, 11, 4, '2024-06-18 00:26:24', '2024-06-18 00:26:24', NULL),
(22, 'MOV002', '2024-06-17 20:26:24', 'Movimiento de prueba 2', 'salida', 11, 3, 12, 10, 5, '2024-06-18 00:26:24', '2024-06-18 00:26:24', NULL),
(23, 'MOV003', '2024-06-17 20:26:24', 'Movimiento de prueba 3', 'entrada', 12, 4, NULL, 10, 6, '2024-06-18 00:26:24', '2024-06-18 00:26:24', NULL),
(24, 'MOV004', '2024-06-17 20:26:24', 'Movimiento de prueba 4', 'salida', 10, 4, 10, 11, 4, '2024-06-18 00:26:24', '2024-06-18 00:26:24', NULL),
(25, 'MOV005', '2024-06-17 20:26:24', 'Movimiento de prueba 5', 'entrada', 11, 3, NULL, 10, 5, '2024-06-18 00:26:24', '2024-06-18 00:26:24', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `personas`
--

CREATE TABLE `personas` (
  `id_persona` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `papellido` varchar(100) NOT NULL,
  `sapellido` varchar(100) NOT NULL,
  `carnet` varchar(100) NOT NULL,
  `celular` int(10) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `personas`
--

INSERT INTO `personas` (`id_persona`, `nombre`, `papellido`, `sapellido`, `carnet`, `celular`, `email`, `created_at`, `updated_at`, `deleted_at`) VALUES
(10, 'Persona 1', 'Apellido1', 'Apellido2', '123456789', 2147483647, 'persona1@example.com', '2024-06-18 00:10:59', '2024-06-18 00:10:59', NULL),
(11, 'Persona 2', 'Apellido3', 'Apellido4', '987654321', 1234567890, 'persona2@example.com', '2024-06-18 00:10:59', '2024-06-18 00:10:59', NULL),
(12, 'Persona 3', 'Apellido5', 'Apellido6', '456789123', 2147483647, 'persona3@example.com', '2024-06-18 00:10:59', '2024-06-18 00:10:59', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `productos`
--

CREATE TABLE `productos` (
  `id_producto` int(11) NOT NULL,
  `codigo` varchar(100) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `presentacion` varchar(200) NOT NULL DEFAULT 'unidad',
  `unidad` varchar(100) NOT NULL,
  `id_empresa` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `productos`
--

INSERT INTO `productos` (`id_producto`, `codigo`, `nombre`, `precio`, `presentacion`, `unidad`, `id_empresa`, `created_at`, `updated_at`, `deleted_at`) VALUES
(7, 'PROD001', 'Producto 1 Empresa A', 100.00, 'presentación 1', 'unidad', 7, '2024-06-18 00:15:10', '2024-06-18 00:15:10', NULL),
(8, 'PROD002', 'Producto 2 Empresa A', 120.00, 'presentación 2', 'unidad', 7, '2024-06-18 00:15:10', '2024-06-18 00:15:10', NULL),
(9, 'PROD003', 'Producto 3 Empresa A', 150.00, 'presentación 3', 'unidad', 7, '2024-06-18 00:15:10', '2024-06-18 00:15:10', NULL),
(10, 'PROD004', 'Producto 4 Empresa A', 80.00, 'presentación 1', 'unidad', 7, '2024-06-18 00:15:10', '2024-06-18 00:15:10', NULL),
(11, 'PROD005', 'Producto 5 Empresa A', 200.00, 'presentación 2', 'unidad', 7, '2024-06-18 00:15:10', '2024-06-18 00:15:10', NULL),
(12, 'PROD006', 'Producto 1 Empresa B', 90.00, 'presentación 1', 'unidad', 8, '2024-06-18 00:15:10', '2024-06-18 00:15:10', NULL),
(13, 'PROD007', 'Producto 2 Empresa B', 110.00, 'presentación 2', 'unidad', 8, '2024-06-18 00:15:10', '2024-06-18 00:15:10', NULL),
(14, 'PROD008', 'Producto 3 Empresa B', 130.00, 'presentación 3', 'unidad', 8, '2024-06-18 00:15:10', '2024-06-18 00:15:10', NULL),
(15, 'PROD009', 'Producto 4 Empresa B', 70.00, 'presentación 1', 'unidad', 8, '2024-06-18 00:15:10', '2024-06-18 00:15:10', NULL),
(16, 'PROD010', 'Producto 5 Empresa B', 180.00, 'presentación 2', 'unidad', 8, '2024-06-18 00:15:10', '2024-06-18 00:15:10', NULL),
(17, 'PROD011', 'Producto 1 Empresa C', 110.00, 'presentación 1', 'unidad', 9, '2024-06-18 00:15:10', '2024-06-18 00:15:10', NULL),
(18, 'PROD012', 'Producto 2 Empresa C', 130.00, 'presentación 2', 'unidad', 9, '2024-06-18 00:15:10', '2024-06-18 00:15:10', NULL),
(19, 'PROD013', 'Producto 3 Empresa C', 160.00, 'presentación 3', 'unidad', 9, '2024-06-18 00:15:10', '2024-06-18 00:15:10', NULL),
(20, 'PROD014', 'Producto 4 Empresa C', 85.00, 'presentación 1', 'unidad', 9, '2024-06-18 00:15:10', '2024-06-18 00:15:10', NULL),
(21, 'PROD015', 'Producto 5 Empresa C', 220.00, 'presentación 2', 'unidad', 9, '2024-06-18 00:15:10', '2024-06-18 00:15:10', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `productos_categorias`
--

CREATE TABLE `productos_categorias` (
  `id_producto` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `productos_categorias`
--

INSERT INTO `productos_categorias` (`id_producto`, `id_categoria`, `created_at`, `updated_at`, `deleted_at`) VALUES
(7, 7, '2024-06-18 00:18:17', '2024-06-18 00:18:17', NULL),
(8, 8, '2024-06-18 00:18:17', '2024-06-18 00:18:17', NULL),
(9, 9, '2024-06-18 00:18:17', '2024-06-18 00:18:17', NULL),
(10, 7, '2024-06-18 00:18:17', '2024-06-18 00:18:17', NULL),
(11, 8, '2024-06-18 00:18:17', '2024-06-18 00:18:17', NULL),
(12, 8, '2024-06-18 00:18:17', '2024-06-18 00:18:17', NULL),
(13, 9, '2024-06-18 00:18:17', '2024-06-18 00:18:17', NULL),
(14, 7, '2024-06-18 00:18:17', '2024-06-18 00:18:17', NULL),
(15, 8, '2024-06-18 00:18:17', '2024-06-18 00:18:17', NULL),
(16, 9, '2024-06-18 00:18:17', '2024-06-18 00:18:17', NULL),
(17, 9, '2024-06-18 00:18:17', '2024-06-18 00:18:17', NULL),
(18, 7, '2024-06-18 00:18:17', '2024-06-18 00:18:17', NULL),
(19, 8, '2024-06-18 00:18:17', '2024-06-18 00:18:17', NULL),
(20, 9, '2024-06-18 00:18:17', '2024-06-18 00:18:17', NULL),
(21, 7, '2024-06-18 00:18:17', '2024-06-18 00:18:17', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `recintos`
--

CREATE TABLE `recintos` (
  `id_recinto` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `direccion` varchar(200) NOT NULL,
  `tipo` varchar(100) NOT NULL,
  `telefono` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `recintos`
--

INSERT INTO `recintos` (`id_recinto`, `nombre`, `direccion`, `tipo`, `telefono`, `created_at`, `updated_at`, `deleted_at`) VALUES
(3, 'Recinto 1', 'Dirección Recinto 1', 'Tipo Recinto 1', 123456789, '2024-06-18 00:10:59', '2024-06-18 00:10:59', NULL),
(4, 'Recinto 2', 'Dirección Recinto 2', 'Tipo Recinto 2', 987654321, '2024-06-18 00:10:59', '2024-06-18 00:10:59', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ubicaciones`
--

CREATE TABLE `ubicaciones` (
  `id_ubicacion` int(11) NOT NULL,
  `direccion` varchar(200) NOT NULL,
  `telefono` int(10) DEFAULT NULL,
  `tipo` varchar(100) NOT NULL,
  `nota` varchar(200) DEFAULT NULL,
  `id_persona` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ubicaciones`
--

INSERT INTO `ubicaciones` (`id_ubicacion`, `direccion`, `telefono`, `tipo`, `nota`, `id_persona`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Dirección Ubicación 1 Persona 1', 1234567890, 'Tipo Ubicación 1', 'Nota Ubicación 1', 10, '2024-06-18 00:13:36', '2024-06-18 00:13:36', NULL),
(2, 'Dirección Ubicación 1 Persona 2', 2147483647, 'Tipo Ubicación 2', 'Nota Ubicación 2', 11, '2024-06-18 00:13:36', '2024-06-18 00:13:36', NULL),
(3, 'Dirección Ubicación 1 Persona 3', 2147483647, 'Tipo Ubicación 3', 'Nota Ubicación 3', 12, '2024-06-18 00:13:36', '2024-06-18 00:13:36', NULL),
(4, 'Dirección Ubicación 2 Persona 3', 2147483647, 'Tipo Ubicación 4', 'Nota Ubicación 4', 12, '2024-06-18 00:13:36', '2024-06-18 00:13:36', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nick` varchar(100) NOT NULL,
  `pass` varchar(100) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nick`, `pass`, `remember_token`, `email`, `created_at`, `updated_at`, `deleted_at`) VALUES
(10, 'usuario1', 'password1', NULL, 'usuario1@example.com', '2024-06-18 00:12:11', '2024-06-18 00:12:11', NULL),
(11, 'usuario2', 'password2', NULL, 'usuario2@example.com', '2024-06-18 00:12:11', '2024-06-18 00:12:11', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adjuntos`
--
ALTER TABLE `adjuntos`
  ADD PRIMARY KEY (`id_adjunto`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indexes for table `almacenes`
--
ALTER TABLE `almacenes`
  ADD PRIMARY KEY (`id_almacen`);

--
-- Indexes for table `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indexes for table `contactos`
--
ALTER TABLE `contactos`
  ADD PRIMARY KEY (`id_persona`,`id_empresa`),
  ADD KEY `id_empresa` (`id_empresa`);

--
-- Indexes for table `cuotas`
--
ALTER TABLE `cuotas`
  ADD PRIMARY KEY (`id_cuota`),
  ADD UNIQUE KEY `codigo` (`codigo`),
  ADD KEY `id_movimiento` (`id_movimiento`);

--
-- Indexes for table `detalles`
--
ALTER TABLE `detalles`
  ADD PRIMARY KEY (`id_detalle`),
  ADD KEY `id_movimiento` (`id_movimiento`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indexes for table `empresas`
--
ALTER TABLE `empresas`
  ADD PRIMARY KEY (`id_empresa`);

--
-- Indexes for table `movimientos`
--
ALTER TABLE `movimientos`
  ADD PRIMARY KEY (`id_movimiento`),
  ADD KEY `id_cliente` (`id_cliente`),
  ADD KEY `id_recinto` (`id_recinto`),
  ADD KEY `id_proveedor` (`id_proveedor`),
  ADD KEY `id_operador` (`id_operador`),
  ADD KEY `id_almacen` (`id_almacen`);

--
-- Indexes for table `personas`
--
ALTER TABLE `personas`
  ADD PRIMARY KEY (`id_persona`);

--
-- Indexes for table `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id_producto`),
  ADD KEY `id_empresa` (`id_empresa`);

--
-- Indexes for table `productos_categorias`
--
ALTER TABLE `productos_categorias`
  ADD PRIMARY KEY (`id_producto`,`id_categoria`),
  ADD KEY `id_categoria` (`id_categoria`);

--
-- Indexes for table `recintos`
--
ALTER TABLE `recintos`
  ADD PRIMARY KEY (`id_recinto`);

--
-- Indexes for table `ubicaciones`
--
ALTER TABLE `ubicaciones`
  ADD PRIMARY KEY (`id_ubicacion`),
  ADD KEY `id_persona` (`id_persona`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `adjuntos`
--
ALTER TABLE `adjuntos`
  MODIFY `id_adjunto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `almacenes`
--
ALTER TABLE `almacenes`
  MODIFY `id_almacen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `cuotas`
--
ALTER TABLE `cuotas`
  MODIFY `id_cuota` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `detalles`
--
ALTER TABLE `detalles`
  MODIFY `id_detalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `empresas`
--
ALTER TABLE `empresas`
  MODIFY `id_empresa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `movimientos`
--
ALTER TABLE `movimientos`
  MODIFY `id_movimiento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `personas`
--
ALTER TABLE `personas`
  MODIFY `id_persona` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `productos`
--
ALTER TABLE `productos`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `recintos`
--
ALTER TABLE `recintos`
  MODIFY `id_recinto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `ubicaciones`
--
ALTER TABLE `ubicaciones`
  MODIFY `id_ubicacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `adjuntos`
--
ALTER TABLE `adjuntos`
  ADD CONSTRAINT `adjuntos_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`);

--
-- Constraints for table `contactos`
--
ALTER TABLE `contactos`
  ADD CONSTRAINT `contactos_ibfk_1` FOREIGN KEY (`id_persona`) REFERENCES `personas` (`id_persona`),
  ADD CONSTRAINT `contactos_ibfk_2` FOREIGN KEY (`id_empresa`) REFERENCES `empresas` (`id_empresa`);

--
-- Constraints for table `cuotas`
--
ALTER TABLE `cuotas`
  ADD CONSTRAINT `cuotas_ibfk_1` FOREIGN KEY (`id_movimiento`) REFERENCES `movimientos` (`id_movimiento`);

--
-- Constraints for table `detalles`
--
ALTER TABLE `detalles`
  ADD CONSTRAINT `detalles_ibfk_1` FOREIGN KEY (`id_movimiento`) REFERENCES `movimientos` (`id_movimiento`),
  ADD CONSTRAINT `detalles_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`);

--
-- Constraints for table `movimientos`
--
ALTER TABLE `movimientos`
  ADD CONSTRAINT `movimientos_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `personas` (`id_persona`),
  ADD CONSTRAINT `movimientos_ibfk_2` FOREIGN KEY (`id_recinto`) REFERENCES `recintos` (`id_recinto`),
  ADD CONSTRAINT `movimientos_ibfk_3` FOREIGN KEY (`id_proveedor`) REFERENCES `personas` (`id_persona`),
  ADD CONSTRAINT `movimientos_ibfk_4` FOREIGN KEY (`id_operador`) REFERENCES `usuarios` (`id_usuario`),
  ADD CONSTRAINT `movimientos_ibfk_5` FOREIGN KEY (`id_almacen`) REFERENCES `almacenes` (`id_almacen`);

--
-- Constraints for table `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`id_empresa`) REFERENCES `empresas` (`id_empresa`);

--
-- Constraints for table `productos_categorias`
--
ALTER TABLE `productos_categorias`
  ADD CONSTRAINT `productos_categorias_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`),
  ADD CONSTRAINT `productos_categorias_ibfk_2` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id_categoria`);

--
-- Constraints for table `ubicaciones`
--
ALTER TABLE `ubicaciones`
  ADD CONSTRAINT `ubicaciones_ibfk_1` FOREIGN KEY (`id_persona`) REFERENCES `personas` (`id_persona`);

--
-- Constraints for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `personas` (`id_persona`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
