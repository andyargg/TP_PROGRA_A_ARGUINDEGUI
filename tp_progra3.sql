-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 24-11-2024 a las 01:09:11
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tp_progra3`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_pedido`
--

CREATE TABLE `detalle_pedido` (
  `id` int(11) NOT NULL,
  `pedido_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `logtransacciones`
--

CREATE TABLE `logtransacciones` (
  `nroTransaccion` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `code` int(11) NOT NULL,
  `accion` varchar(20) NOT NULL,
  `usuarioId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `logtransacciones`
--

INSERT INTO `logtransacciones` (`nroTransaccion`, `fecha`, `code`, `accion`, `usuarioId`) VALUES
(7, '2024-11-23 21:38:50', 200, '/sesion', -1),
(18, '2024-11-23 21:53:16', 200, '/sesion', -1),
(19, '2024-11-23 21:53:26', 500, '/usuarios/franco', -1),
(20, '2024-11-23 21:53:32', 500, '/usuarios/pepe', -1),
(21, '2024-11-23 21:53:44', 200, '/usuarios/pepe', 3),
(22, '2024-11-23 21:53:56', 200, '/usuarios/pablodi', 3),
(23, '2024-11-23 21:54:38', 200, '/usuarios/3', 3),
(24, '2024-11-23 21:55:11', 500, '/usuarios', -1),
(25, '2024-11-23 21:55:21', 200, '/usuarios', 3),
(26, '2024-11-23 22:00:58', 200, '/sesion', -1),
(27, '2024-11-23 22:05:37', 500, '/usuarios/cantidad-o', 3),
(31, '2024-11-23 22:19:07', 500, '/usuarios/cantidad-o', 3),
(32, '2024-11-23 22:21:51', 200, '/usuarios/cantidad-o', 3),
(33, '2024-11-23 22:27:31', 200, '/usuarios/cantidad-o', 3),
(34, '2024-11-23 22:28:03', 200, '/usuarios/cantidad-o', 3),
(35, '2024-11-23 22:28:54', 200, '/usuarios/cantidad-o', 3),
(36, '2024-11-23 22:31:31', 200, '/usuarios/cantidad-o', 3),
(37, '2024-11-23 22:37:05', 200, '/usuarios/cantidad-o', 3),
(38, '2024-11-23 22:37:32', 200, '/usuarios/cantidad-o', 3),
(39, '2024-11-23 22:40:49', 200, '/usuarios/cantidad-o', 3),
(40, '2024-11-23 22:44:18', 200, '/usuarios/cantidad-o', 3),
(41, '2024-11-23 22:45:19', 200, '/usuarios/cantidad-o', 3),
(42, '2024-11-23 23:23:25', 200, '/pedidos/mas-vendido', 3),
(43, '2024-11-23 23:24:09', 200, '/pedidos/mas-vendido', 3),
(44, '2024-11-23 23:25:09', 200, '/pedidos/mas-vendido', 3),
(45, '2024-11-23 23:27:37', 200, '/archivos/cargarProd', 3),
(46, '2024-11-23 23:27:52', 200, '/archivos/cargarProd', 3),
(47, '2024-11-23 23:28:00', 200, '/pedidos/mas-vendido', 3),
(48, '2024-11-23 23:28:48', 200, '/pedidos/mas-vendido', 3),
(49, '2024-11-23 23:29:01', 200, '/archivos/cargarProd', 3),
(50, '2024-11-23 23:29:05', 200, '/archivos/cargarProd', 3),
(51, '2024-11-23 23:29:18', 200, '/pedidos/mas-vendido', 3),
(52, '2024-11-23 23:29:20', 200, '/archivos/cargarProd', 3),
(53, '2024-11-24 00:10:10', 200, '/archivos/cargarProd', 3),
(54, '2024-11-24 00:10:24', 200, '/pedidos/mas-vendido', 3),
(55, '2024-11-24 00:10:56', 200, '/pedidos/mas-vendido', 3),
(56, '2024-11-24 00:14:10', 200, '/pedidos/mas-vendido', 3),
(57, '2024-11-24 00:14:32', 200, '/pedidos/mas-vendido', 3),
(58, '2024-11-24 00:15:16', 200, '/pedidos/mas-vendido', 3),
(59, '2024-11-24 00:22:40', 200, '/archivos/descargarP', 3),
(60, '2024-11-24 00:23:03', 200, '/pedidos/menos-vendi', 3),
(61, '2024-11-24 00:28:24', 200, '/pedidos/menos-vendi', 3),
(62, '2024-11-24 00:28:44', 200, '/pedidos/menos-vendi', 3),
(63, '2024-11-24 00:28:52', 200, '/pedidos/menos-vendi', 3),
(64, '2024-11-24 00:28:57', 200, '/pedidos/menos-vendi', 3),
(65, '2024-11-24 00:29:06', 200, '/pedidos/menos-vendi', 3),
(66, '2024-11-24 00:29:08', 200, '/pedidos/menos-vendi', 3),
(67, '2024-11-24 00:29:56', 200, '/pedidos/menos-vendi', 3),
(68, '2024-11-24 00:30:06', 200, '/pedidos/menos-vendi', 3),
(69, '2024-11-24 00:30:36', 200, '/pedidos/menos-vendi', 3),
(70, '2024-11-24 00:31:40', 200, '/pedidos/menos-vendi', 3),
(71, '2024-11-24 00:32:06', 200, '/pedidos/menos-vendi', 3),
(72, '2024-11-24 00:33:01', 200, '/pedidos/mas-vendido', 3),
(73, '2024-11-24 00:33:14', 200, '/pedidos/mas-vendido', 3),
(74, '2024-11-24 00:33:18', 500, '/pedidos/menos-vendi', 3),
(75, '2024-11-24 00:33:48', 200, '/pedidos/menos-vendi', 3),
(76, '2024-11-24 00:40:33', 500, '/pedidos/cancelados', 3),
(77, '2024-11-24 00:43:45', 500, '/pedidos/cancelados', 3),
(78, '2024-11-24 00:44:28', 500, '/pedidos/cancelados', 3),
(79, '2024-11-24 00:44:53', 500, '/pedidos/cancelados', 3),
(80, '2024-11-24 00:45:03', 500, '/pedidos/cancelados', 3),
(81, '2024-11-24 00:45:31', 500, '/pedidos/cancelados', 3),
(82, '2024-11-24 00:46:39', 200, '/pedidos/cancelados', 3),
(83, '2024-11-24 00:49:29', 200, '/pedidos/menos-vendi', 3),
(84, '2024-11-24 00:49:46', 200, '/pedidos/cancelados', 3),
(85, '2024-11-24 00:50:27', 200, '/pedidos/cancelados', 3),
(86, '2024-11-24 00:50:34', 200, '/usuarios/cantidad-o', 3),
(87, '2024-11-24 00:50:43', 200, '/usuarios/cantidad-o', 3),
(88, '2024-11-24 00:56:49', 200, '/pedidos/fuera-de-ti', 3),
(89, '2024-11-24 00:57:39', 500, '/pedidos/fuera-de-ti', 3),
(90, '2024-11-24 00:57:52', 200, '/pedidos/fuera-de-ti', 3),
(91, '2024-11-24 00:58:34', 200, '/pedidos/fuera-de-ti', 3),
(92, '2024-11-24 00:58:41', 200, '/pedidos/fuera-de-ti', 3),
(93, '2024-11-24 00:59:00', 200, '/pedidos/fuera-de-ti', 3),
(94, '2024-11-24 00:59:13', 200, '/pedidos/fuera-de-ti', 3),
(95, '2024-11-24 00:59:24', 200, '/pedidos/fuera-de-ti', 3),
(96, '2024-11-24 00:59:52', 200, '/pedidos/fuera-de-ti', 3),
(97, '2024-11-24 01:02:23', 200, '/pedidos/fuera-de-ti', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mesas`
--

CREATE TABLE `mesas` (
  `id` int(11) NOT NULL,
  `codigoMesa` varchar(255) DEFAULT NULL,
  `capacidad` int(11) NOT NULL,
  `estado` enum('con cliente esperando pedido','con cliente comiendo','con cliente pagando','cerrada') NOT NULL,
  `fechaCreacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `aCobrar` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `mesas`
--

INSERT INTO `mesas` (`id`, `codigoMesa`, `capacidad`, `estado`, `fechaCreacion`, `aCobrar`) VALUES
(1, '3', 3, 'cerrada', '2024-11-06 06:00:00', NULL),
(7, '1', 2, 'con cliente esperando pedido', '2024-11-19 06:00:00', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL,
  `sector` text NOT NULL,
  `mesaId` int(11) NOT NULL,
  `estado` enum('pendiente','completado','cancelado') DEFAULT 'pendiente',
  `horaInicio` datetime(3) DEFAULT NULL,
  `horaFinalizacion` datetime(3) DEFAULT NULL,
  `importe` decimal(10,2) DEFAULT 0.00,
  `codigoPedido` int(11) DEFAULT NULL,
  `productoId` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id`, `sector`, `mesaId`, `estado`, `horaInicio`, `horaFinalizacion`, `importe`, `codigoPedido`, `productoId`, `cantidad`) VALUES
(49, 'cocina', 7, 'completado', '2024-11-20 01:57:49.000', NULL, 2000.00, 5, 7, 5),
(50, 'barra', 1, 'completado', '2024-11-20 01:58:10.000', '2024-11-20 21:24:47.000', 450.00, 2, 7, 3),
(51, 'candybar', 7, 'completado', '2024-11-20 01:58:23.000', NULL, 500.00, 4, 3, 4),
(52, 'candybar', 7, 'completado', '2024-11-20 01:58:23.000', '2024-11-21 02:40:18.000', 1600.00, 10231, 9, 4),
(54, 'candybar', 1, 'cancelado', '2024-11-23 00:03:16.000', NULL, 400.00, 1023, 9, 1),
(55, 'candybar', 1, 'pendiente', '2024-11-23 00:03:17.000', NULL, 400.00, 105, 5, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `tipo` enum('comida','bebida','postre') NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `cantidad` int(1) DEFAULT 1,
  `tiempoPreparacion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `tipo`, `precio`, `cantidad`, `tiempoPreparacion`) VALUES
(1, 'agua', 'bebida', 20.00, 10, 20),
(2, 'caramelo', 'postre', 40.00, 1, 40),
(3, 'carne', 'comida', 40.00, 1, 40),
(4, 'manzana', 'comida', 30.00, 20, 30),
(5, 'leche', 'bebida', 15.00, 50, 15),
(6, 'pizza', 'comida', 100.00, 10, 100),
(7, 'helado', 'postre', 60.00, 5, 60),
(8, 'hamburguesa', 'comida', 80.00, 3, 80),
(9, 'te', 'bebida', 25.00, 30, 25),
(10, 'ensalada', 'comida', 50.00, 8, 50);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registrologin`
--

CREATE TABLE `registrologin` (
  `id` int(11) NOT NULL,
  `usuarioId` int(11) NOT NULL,
  `fechaConexion` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `registrologin`
--

INSERT INTO `registrologin` (`id`, `usuarioId`, `fechaConexion`) VALUES
(1, 21, '2024-11-18 02:04:57'),
(2, 21, '2024-11-18 02:05:08'),
(3, 21, '2024-11-18 02:05:17'),
(4, 18, '2024-11-18 02:05:53'),
(5, 18, '2024-11-18 18:15:18'),
(6, 18, '2024-11-18 19:09:02'),
(7, 18, '2024-11-18 19:09:25'),
(8, 18, '2024-11-18 19:10:11'),
(9, 18, '2024-11-18 19:14:32'),
(10, 18, '2024-11-18 19:24:47'),
(11, 18, '2024-11-18 19:25:28'),
(12, 18, '2024-11-18 20:53:03'),
(13, 18, '2024-11-18 21:13:14'),
(14, 18, '2024-11-18 21:38:52'),
(15, 21, '2024-11-19 19:23:10'),
(16, 21, '2024-11-19 19:25:14'),
(17, 21, '2024-11-19 19:31:37'),
(18, 21, '2024-11-19 19:33:03'),
(19, 21, '2024-11-19 19:33:56'),
(20, 21, '2024-11-19 19:35:28'),
(21, 21, '2024-11-19 19:37:40'),
(22, 21, '2024-11-19 19:39:23'),
(23, 18, '2024-11-19 19:39:51'),
(24, 18, '2024-11-19 20:51:55'),
(25, 18, '2024-11-19 22:24:54'),
(26, 18, '2024-11-19 22:47:59'),
(27, 18, '2024-11-20 00:32:32'),
(28, 18, '2024-11-20 01:27:48'),
(29, 18, '2024-11-20 01:58:45'),
(30, 18, '2024-11-20 23:12:56'),
(31, 18, '2024-11-21 00:53:48'),
(32, 18, '2024-11-21 01:24:05'),
(0, 18, '2024-11-22 23:39:39'),
(0, 18, '2024-11-23 01:48:49'),
(0, 18, '2024-11-23 21:31:27'),
(0, 18, '2024-11-23 21:34:44'),
(0, 18, '2024-11-23 21:35:48'),
(0, 18, '2024-11-23 21:36:57'),
(0, 18, '2024-11-23 21:38:28'),
(0, 18, '2024-11-23 21:38:50'),
(0, 18, '2024-11-23 21:43:32'),
(0, 18, '2024-11-23 21:45:26'),
(0, 3, '2024-11-23 21:53:16'),
(0, 3, '2024-11-23 22:00:58'),
(0, 3, '2024-11-23 22:34:47'),
(0, 3, '2024-11-24 00:15:08');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `clave` varchar(255) NOT NULL,
  `rol` enum('mozo','bartender','socio','cocinero','cervecero') NOT NULL,
  `fecha_creacion` datetime DEFAULT current_timestamp(),
  `fecha_baja` timestamp NULL DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `estado` varchar(255) DEFAULT 'activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `usuario`, `clave`, `rol`, `fecha_creacion`, `fecha_baja`, `email`, `estado`) VALUES
(1, 'pablodi', 'pape', 'mozo', '2024-11-23 21:52:03', NULL, 'mozo@gmail.com', 'activo'),
(2, 'pepe', 'pape', 'socio', '2024-11-23 21:52:13', NULL, 'mozo@gmail.com', 'activo'),
(3, 'pepe', 'pedrodelamancha', 'socio', '2024-11-23 21:52:30', NULL, 'pepitoo@gmail.com', 'activo');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pedido_id` (`pedido_id`),
  ADD KEY `producto_id` (`producto_id`);

--
-- Indices de la tabla `logtransacciones`
--
ALTER TABLE `logtransacciones`
  ADD PRIMARY KEY (`nroTransaccion`);

--
-- Indices de la tabla `mesas`
--
ALTER TABLE `mesas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mesa_id` (`mesaId`),
  ADD KEY `fk_producto` (`productoId`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `logtransacciones`
--
ALTER TABLE `logtransacciones`
  MODIFY `nroTransaccion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

--
-- AUTO_INCREMENT de la tabla `mesas`
--
ALTER TABLE `mesas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
