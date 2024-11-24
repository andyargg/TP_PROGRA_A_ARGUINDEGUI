
-- -- Base de datos: `tp_progra3`
-- --
-- CREATE DATABASE IF NOT EXISTS `tp_progra3` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
-- USE `tp_progra3`;

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
-- Estructura de tabla para la tabla `logtransaccione`
--

CREATE TABLE `logtransacciones` (
  `fecha` datetime NOT NULL,
  `usuarioId` int(11) NOT NULL,
  `code` int(11) NOT NULL,
  `accion` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(1, '3', 3, 'cerrada', '2024-11-06 03:00:00', NULL),
(7, '1', 2, 'con cliente esperando pedido', '2024-11-19 03:00:00', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL,
  `sector` text NOT NULL,
  `mesaId` int(11) NOT NULL,
  `estado` enum('pendiente','completado','cancelado') DEFAULT 'pendiente',
  `horaInicio` datetime DEFAULT NULL,
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
(49, 'cocina', 7, 'completado', '2024-11-20 01:57:49', NULL, 2000.00, 5, 7, 5),
(50, 'barra', 1, 'completado', '2024-11-20 01:58:10', '2024-11-20 21:24:47.000', 450.00, 2, 7, 3),
(51, 'candybar', 7, 'completado', '2024-11-20 01:58:23', NULL, 500.00, 10, 7, 4),
(52, 'candybar', 7, 'completado', '2024-11-20 01:58:23', '2024-11-21 02:40:18.000', 1600.00, 10, 7, 4);

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
(6, 'carne', 'comida', 150.00, 3, 40),
(7, 'agua\r\n', 'bebida', 400.00, 3, 400),
(8, 'toro', 'bebida', 0.00, 2, 0),
(9, 'helado', 'postre', 400.00, 3, 400),
(17, 'milanesa', 'comida', 40.00, 1, 40),
(18, 'agua', 'bebida', 20.00, 1, 20),
(19, 'caramelo', 'postre', 40.00, 1, 40);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registrologin`
--

CREATE TABLE `registrologin` (
  `id` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `fechaConexion` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `registrologin`
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
(32, 18, '2024-11-21 01:24:05');

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
(1, 'franco', 'Hsu23sDsjseWs', 'mozo', '2024-11-06 10:54:10', '2024-11-19 23:13:13', 'hola@asd.com', 'inactivo'),
(2, 'pedro', 'dasdqsdw2sd23', 'mozo', '2024-11-06 10:54:10', '2024-11-13 03:00:00', 'andresarguin04@gmail.com', 'activo'),
(3, 'jorge', 'sda2s2f332f2', 'mozo', '2024-11-06 10:54:10', '2024-11-13 03:00:00', 'juan.perez@example.com', 'activo'),
(16, 'aeasa', '$2y$10$WJTLTn7u0MsTjkpYiW.KY.TxSh1o3lETB7bnw.B/4Ns6kmMUeomUW', 'socio', '2024-11-12 19:32:43', '2024-11-19 23:11:56', 'pedro.garcia@example.com', 'activo'),
(18, 'yooo321', 'clave2', 'socio', '2024-11-12 19:48:57', '2024-11-18 03:00:00', 'javier.rodriguez@example.com', 'activo'),
(19, 'Duko', '$2y$10$5t7g6xgFl2seJeGEWSDb7.3alPnydDoonosyQO3uKnC0Ets7QdvBW', 'bartender', '2024-11-12 20:44:01', NULL, 'isabel.flores@example.com', 'activo'),
(21, 'Akon', 'clave1', 'mozo', '2024-11-12 21:31:52', NULL, 'nana@gmail.com', 'activo'),
(22, 'Pablete', '$2y$10$J.a504vm63A1SwoPhZMl..N.hyVvBgNfPk2G0zqw6KS3ykFoC4NlW', 'bartender', '2024-11-14 15:58:15', NULL, 'daniel.gonzalez@example.com', 'activo'),
(23, 'sergio', '$2y$10$fJOu3cMl7HlSi7kq3hxYYOkzc5vwlF2UDVTrmwcozVA8kmXu11QeS', 'mozo', '2024-11-14 15:58:22', NULL, 'asdasd@gmail.com', 'activo'),
(26, 'yo', '$2y$10$ONd9h1Pq3cqwUgIE3hfdzORZVuYZorFC4d7EilVqlgy21FlxREYnu', 'bartender', '2024-11-18 15:18:03', NULL, '', 'activo'),
(27, 'yoessergio', '$2y$10$0GFnfaEWBK8ipsI.eKbj7uhnGbTtOQORs2Db/JMnh5e6Zum2bwMDW', 'bartender', '2024-11-18 15:18:24', NULL, '', 'activo'),
(28, 'pepePadre', 'clave4', 'socio', '2024-11-19 15:46:34', NULL, 'pepe324@gmail.com', 'activo'),
(30, 'pepeHijo', '424131', 'bartender', '2024-11-19 00:00:00', NULL, 'pepe32324@gmail.com', 'activo');

