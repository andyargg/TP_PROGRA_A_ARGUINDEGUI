-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3307
-- Generation Time: Nov 19, 2024 at 12:32 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tp_progra3`
--

-- --------------------------------------------------------

--
-- Table structure for table `detalle_pedido`
--

CREATE TABLE `detalle_pedido` (
  `id` int(11) NOT NULL,
  `pedido_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mesas`
--

CREATE TABLE `mesas` (
  `id` int(11) NOT NULL,
  `codigoMesa` varchar(255) DEFAULT NULL,
  `capacidad` int(11) NOT NULL,
  `estado` enum('con cliente esperando pedido','con cliente comiendo','con cliente pagando','cerrada') NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mesas`
--

INSERT INTO `mesas` (`id`, `codigoMesa`, `capacidad`, `estado`, `fecha_creacion`) VALUES
(1, '3', 3, 'cerrada', '2024-11-06 03:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL,
  `mesaId` int(11) NOT NULL,
  `fecha_pedido` timestamp NOT NULL DEFAULT current_timestamp(),
  `estado` enum('pendiente','completado','cancelado') DEFAULT 'pendiente',
  `horaInicio` datetime DEFAULT NULL,
  `horaFinalizacion` datetime DEFAULT NULL,
  `importe` decimal(10,2) DEFAULT 0.00,
  `codigoPedido` int(11) DEFAULT NULL,
  `nombreCliente` varchar(20) DEFAULT NULL,
  `productoId` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `sector` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pedidos`
--

INSERT INTO `pedidos` (`id`, `mesaId`, `fecha_pedido`, `estado`, `horaInicio`, `horaFinalizacion`, `importe`, `codigoPedido`, `nombreCliente`, `productoId`, `cantidad`, `sector`) VALUES
(17, 1, '2024-11-14 19:39:02', 'pendiente', '2024-11-14 20:39:02', NULL, 250.00, 231231, 'Juan', 2, 2, 'cocina');

-- --------------------------------------------------------

--
-- Table structure for table `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `tipo` enum('bebida','comida') NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `cantidad` int(1) DEFAULT 1,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `cantidadVendida` int(11) DEFAULT 0,
  `sector` enum('barra','cocina','candy_bar') NOT NULL,
  `tiempoPreparacion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `tipo`, `precio`, `cantidad`, `fecha_creacion`, `cantidadVendida`, `sector`, `tiempoPreparacion`) VALUES
(2, 'lechuga', 'comida', 150.00, 1, '2024-11-13 01:05:59', 0, 'cocina', 1),
(6, 'carne', 'comida', 150.00, 3, '2024-11-18 20:17:49', 0, 'barra', 40);

-- --------------------------------------------------------

--
-- Table structure for table `registrologin`
--

CREATE TABLE `registrologin` (
  `id` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `fechaConexion` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `registrologin`
--

INSERT INTO `registrologin` (`id`, `idUsuario`, `fechaConexion`) VALUES
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
(14, 18, '2024-11-18 21:38:52');

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `clave` varchar(255) NOT NULL,
  `rol` enum('mozo','bartender','socio','cocinero','cervecero') NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_baja` timestamp NULL DEFAULT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`id`, `usuario`, `clave`, `rol`, `fecha_creacion`, `fecha_baja`, `email`) VALUES
(1, 'franco', 'Hsu23sDsjseWs', 'mozo', '2024-11-06 13:54:10', NULL, 'hola@asd.com'),
(2, 'pedro', 'dasdqsdw2sd23', 'mozo', '2024-11-06 13:54:10', '2024-11-13 03:00:00', 'andresarguin04@gmail.com'),
(3, 'jorge', 'sda2s2f332f2', 'mozo', '2024-11-06 13:54:10', '2024-11-13 03:00:00', 'juan.perez@example.com'),
(16, 'aeasa', '$2y$10$WJTLTn7u0MsTjkpYiW.KY.TxSh1o3lETB7bnw.B/4Ns6kmMUeomUW', 'socio', '2024-11-12 22:32:43', '2024-11-13 03:00:00', 'pedro.garcia@example.com'),
(18, 'yooo321', 'clave2', 'socio', '2024-11-12 22:48:57', '2024-11-18 03:00:00', 'javier.rodriguez@example.com'),
(19, 'Duko', '$2y$10$5t7g6xgFl2seJeGEWSDb7.3alPnydDoonosyQO3uKnC0Ets7QdvBW', 'bartender', '2024-11-12 23:44:01', NULL, 'isabel.flores@example.com'),
(21, 'Akon', 'clave1', 'mozo', '2024-11-13 00:31:52', NULL, 'nana@gmail.com'),
(22, 'Pablete', '$2y$10$J.a504vm63A1SwoPhZMl..N.hyVvBgNfPk2G0zqw6KS3ykFoC4NlW', 'bartender', '2024-11-14 18:58:15', NULL, 'daniel.gonzalez@example.com'),
(23, 'sergio', '$2y$10$fJOu3cMl7HlSi7kq3hxYYOkzc5vwlF2UDVTrmwcozVA8kmXu11QeS', 'mozo', '2024-11-14 18:58:22', NULL, 'asdasd@gmail.com'),
(26, 'yo', '$2y$10$ONd9h1Pq3cqwUgIE3hfdzORZVuYZorFC4d7EilVqlgy21FlxREYnu', 'bartender', '2024-11-18 18:18:03', NULL, ''),
(27, 'yoessergio', '$2y$10$0GFnfaEWBK8ipsI.eKbj7uhnGbTtOQORs2Db/JMnh5e6Zum2bwMDW', 'bartender', '2024-11-18 18:18:24', NULL, '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pedido_id` (`pedido_id`),
  ADD KEY `producto_id` (`producto_id`);

--
-- Indexes for table `mesas`
--
ALTER TABLE `mesas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mesa_id` (`mesaId`),
  ADD KEY `fk_producto` (`productoId`);

--
-- Indexes for table `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `registrologin`
--
ALTER TABLE `registrologin`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idUsuario` (`idUsuario`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario` (`usuario`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mesas`
--
ALTER TABLE `mesas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `registrologin`
--
ALTER TABLE `registrologin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  ADD CONSTRAINT `detalle_pedido_ibfk_1` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `detalle_pedido_ibfk_2` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `fk_producto` FOREIGN KEY (`productoId`) REFERENCES `productos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pedidos_ibfk_2` FOREIGN KEY (`mesaId`) REFERENCES `mesas` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `registrologin`
--
ALTER TABLE `registrologin`
  ADD CONSTRAINT `registrologin_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
