-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-02-2026 a las 05:30:43
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
-- Base de datos: `latienditadesiempre`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrito`
--

CREATE TABLE `carrito` (
  `idCarrito` int(11) NOT NULL,
  `idUsuario` int(11) DEFAULT NULL,
  `idProducto` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `idCATEGORIA` int(11) NOT NULL,
  `nomCATEGORIA` varchar(30) DEFAULT NULL,
  `descripcionCATEGORIA` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`idCATEGORIA`, `nomCATEGORIA`, `descripcionCATEGORIA`) VALUES
(1, 'Bebidas', 'Categoría de bebidas'),
(2, 'Aseo', 'Categoría de aseo'),
(3, 'Misceláneos', 'Varios productos'),
(4, 'Alimentos', 'Productos alimenticios\r\n\r\n'),
(6, 'Higiene', 'Productos de higiene personal'),
(7, 'Limpieza', 'Productos de limpieza del hogar');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detallesalida`
--

CREATE TABLE `detallesalida` (
  `idDETALLE` int(11) NOT NULL,
  `idFACTURA` int(11) DEFAULT NULL,
  `idPRODUCTO` int(11) DEFAULT NULL,
  `cantiSalidaDETALLESALIDA` int(11) DEFAULT NULL,
  `valorunitarioDETALLESALIDA` int(11) DEFAULT NULL,
  `valorTotalventaDETALLESALIDA` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detallesalida`
--

INSERT INTO `detallesalida` (`idDETALLE`, `idFACTURA`, `idPRODUCTO`, `cantiSalidaDETALLESALIDA`, `valorunitarioDETALLESALIDA`, `valorTotalventaDETALLESALIDA`) VALUES
(7, 7, 4, 10, 4000, 40000),
(8, 8, 4, 10, 6000, 60000),
(9, 9, 3, 1, 1900, 1900),
(10, 9, 6, 4, 2450, 9800),
(11, 10, 6, 3, 2450, 7350),
(12, 11, 3, 15, 1900, 28500),
(13, 11, 4, 10, 5000, 50000),
(14, 12, 3, 1, 1900, 1900),
(15, 13, 6, 1, 2450, 2450),
(16, 14, 2, 1, 12000, 12000),
(17, 14, 1, 2, 5000, 10000),
(18, 14, 6, 5, 2450, 12250),
(19, 14, 4, 2, 5000, 10000);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

CREATE TABLE `empleados` (
  `id_empleado` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `cargo` varchar(50) DEFAULT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `fecha_ingreso` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entrada`
--

CREATE TABLE `entrada` (
  `idENTRADA` int(11) NOT NULL,
  `fechaIngreENTRADA` date DEFAULT NULL,
  `cantIngreENTRADA` int(11) DEFAULT NULL,
  `idPRODUCTO` int(11) DEFAULT NULL,
  `idUSUARIO` int(11) DEFAULT NULL,
  `codigo` varchar(20) DEFAULT NULL,
  `precioCompraUnid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `entrada`
--

INSERT INTO `entrada` (`idENTRADA`, `fechaIngreENTRADA`, `cantIngreENTRADA`, `idPRODUCTO`, `idUSUARIO`, `codigo`, `precioCompraUnid`) VALUES
(1, '2025-11-19', 40, 3, 7, 'E-001', 3000),
(2, '2025-11-19', 40, 3, 7, '', 3000),
(3, '2025-11-19', 40, 3, 7, 'E-001', 3000),
(4, '2025-11-19', 100, 3, 7, '', 3000),
(5, '2025-11-19', 2, 4, 7, '', 5500),
(6, '2025-12-04', 20, 4, 7, '', 5500),
(7, '2025-12-15', 10, 2, 7, '', 12000),
(8, '2025-12-15', -10, 4, 7, '', 5000);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura`
--

CREATE TABLE `factura` (
  `idFACTURA` int(11) NOT NULL,
  `fechaFACTURA` date DEFAULT NULL,
  `idUSUARIO` int(11) DEFAULT NULL,
  `totalFACTURA` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `factura`
--

INSERT INTO `factura` (`idFACTURA`, `fechaFACTURA`, `idUSUARIO`, `totalFACTURA`) VALUES
(7, '2025-12-04', 7, 40000),
(8, '2025-12-04', 7, 60000),
(9, '2026-01-04', 7, 11700),
(10, '2026-01-29', 11, 7350),
(11, '2026-01-29', 11, 78500),
(12, '2026-02-02', 15, 1900),
(13, '2026-02-02', 7, 2450),
(14, '2026-02-03', 7, 44250);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensajes_contacto`
--

CREATE TABLE `mensajes_contacto` (
  `id_mensaje` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `mensaje` text NOT NULL,
  `fecha_envio` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `mensajes_contacto`
--

INSERT INTO `mensajes_contacto` (`id_mensaje`, `nombre`, `correo`, `telefono`, `mensaje`, `fecha_envio`) VALUES
(1, 'pepito', 'perez@gmail.com', '3123342343', 'excelentes servicios', '2025-12-04 18:28:17'),
(2, 'pepito', 'mfds.camilo@gmail.com', '3123342343', 'asadadasd', '2025-12-04 18:44:42'),
(3, 'Caira', 'camargocaira07@gmail.com', '3208062761', 'Galleta festival muy cara, comparándola con precios de otras tiendas; otra cosa, me estas vendiendo un producto virtual, o sea, me toca pagar un adicional más por el domicilio, nadie me garantiza que el producto va a llegar en optimas condiciones. Gracias. mejoren', '2026-01-05 02:02:56'),
(4, 'santiago', 'camarrgosanti23@gmail.com', '3216545', 'buena pagina', '2026-01-29 19:34:25');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagos`
--

CREATE TABLE `pagos` (
  `idPago` int(11) NOT NULL,
  `idFactura` int(11) DEFAULT NULL,
  `metodo_pago` varchar(50) DEFAULT NULL,
  `monto` decimal(10,2) DEFAULT NULL,
  `fecha_pago` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pagos`
--

INSERT INTO `pagos` (`idPago`, `idFactura`, `metodo_pago`, `monto`, `fecha_pago`) VALUES
(1, 9, 'Tarjeta', 12000.00, '2026-01-29 19:20:11'),
(2, 9, 'Transferencia', 11700.00, '2026-01-29 19:42:26'),
(3, 11, 'Efectivo', 78500.00, '2026-01-29 19:46:31');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `idPRODUCTO` int(11) NOT NULL,
  `nomPRODUCTO` varchar(50) DEFAULT NULL,
  `marcaPRODUCTO` varchar(25) DEFAULT NULL,
  `precioPRODUCTO` int(11) DEFAULT NULL,
  `cantidadenstockPRODUCTO` int(11) DEFAULT NULL,
  `fechaingrePRODUCTO` date DEFAULT NULL,
  `unidadMedidaPRODUCTO` varchar(15) DEFAULT NULL,
  `fotoPRODUCTO` varchar(255) DEFAULT NULL,
  `idCATEGORIA` int(11) DEFAULT NULL,
  `idPROVEEDOR` int(11) DEFAULT NULL,
  `destacado` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`idPRODUCTO`, `nomPRODUCTO`, `marcaPRODUCTO`, `precioPRODUCTO`, `cantidadenstockPRODUCTO`, `fechaingrePRODUCTO`, `unidadMedidaPRODUCTO`, `fotoPRODUCTO`, `idCATEGORIA`, `idPROVEEDOR`, `destacado`) VALUES
(1, 'Coca Cola 1.5L', 'Coca Cola', 5000, 38, '2025-11-13', 'Unidad', 'assets/img/cocacola.png', 1, 1, 1),
(2, 'Detergente 1Kg', 'Ariel', 12000, 39, '2025-11-13', 'Unidad', 'assets/img/ariel.png', 2, 2, 0),
(3, 'Galletas Festival', 'Noel', 1900, 23, '2025-11-13', 'Paquete', 'assets/img/festival.png', 3, 1, 1),
(4, 'Leche', 'Colanta', 5000, 28, '2025-11-19', 'L', 'assets/img/691dcaa402a56_leche.png', 1, 1, 1),
(6, 'Arroz', 'Roa', 2450, 187, '2026-01-05', 'Und', 'assets/img/695b1c3aea708_descarga.jpg', 4, 4, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
--

CREATE TABLE `proveedor` (
  `idPROVEEDOR` int(11) NOT NULL,
  `nomPROVEEDOR` varchar(50) DEFAULT NULL,
  `telPROVEEDOR` varchar(20) DEFAULT NULL,
  `direcPROVEEDOR` varchar(120) DEFAULT NULL,
  `emailPROVEEDOR` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `proveedor`
--

INSERT INTO `proveedor` (`idPROVEEDOR`, `nomPROVEEDOR`, `telPROVEEDOR`, `direcPROVEEDOR`, `emailPROVEEDOR`) VALUES
(1, 'Proveedor 1', '3001112233', 'Calle 10 #20-30', 'prov1@example.com'),
(2, 'Proveedor 2', '3002223344', 'Carrera 15 #40-20', 'prov2@example.com'),
(3, 'Distribuidora Central', '+57 310 1234567', 'Cra 10 #20-30', 'contacto@distcentral.com'),
(4, 'Importaciones del Norte', '+57 310 9876543', 'Cra 5 #10-20', 'info@imporznorte.com'),
(5, 'Proveedora Nacional', '+57 310 5555555', 'Cra 15 #30-40', 'ventas@provnacional.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `idUSUARIO` int(11) NOT NULL,
  `numdocUSUARIO` int(11) DEFAULT NULL,
  `tipodocumenUSUARIO` varchar(20) DEFAULT NULL,
  `nomUSUARIO` varchar(30) DEFAULT NULL,
  `direcUSUARIO` varchar(120) DEFAULT NULL,
  `telUSUARIO` int(11) DEFAULT NULL,
  `emailUSUARIO` varchar(40) DEFAULT NULL,
  `pass` varchar(255) DEFAULT NULL,
  `rolUSUARIO` varchar(20) DEFAULT NULL,
  `cargoUSUARIO` varchar(20) DEFAULT NULL,
  `reset_token` varchar(255) DEFAULT NULL COMMENT 'Token para recuperaci?n de contrase?a',
  `reset_token_expira` datetime DEFAULT NULL COMMENT 'Fecha de expiraci?n del token',
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'Fecha de creaci?n del usuario',
  `fecha_actualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'Fecha ?ltima actualizaci?n'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idUSUARIO`, `numdocUSUARIO`, `tipodocumenUSUARIO`, `nomUSUARIO`, `direcUSUARIO`, `telUSUARIO`, `emailUSUARIO`, `pass`, `rolUSUARIO`, `cargoUSUARIO`, `reset_token`, `reset_token_expira`, `fecha_creacion`, `fecha_actualizacion`) VALUES
(7, 123456789, 'CC', 'Administrador', NULL, NULL, 'admin@admin.com', '$2y$10$zM4V2/4TUaPVrJ9Bbi.0V.ruP6E63l4FabUsXsBOovlsCDR90NZla', 'admin', NULL, NULL, NULL, '2026-02-10 03:29:55', '2026-02-10 03:29:55'),
(11, 23165456, 'CC', 'santiago', 'ibague', 3312564, 'camarrgosanti23@gmail.com', '$2y$10$2ViwqdDKMqgce/kVvHOnBuGw70jvxJpe6OfNDai5vmsFYqEUGEx4W', 'cliente', NULL, '946da43c7cd39fca78454795579ee4f1d8b75fc3e2ba4ffa4492ac430e20d4b1', '2026-02-10 05:58:36', '2026-02-10 03:29:55', '2026-02-10 03:58:36'),
(15, 1105466148, 'CC', 'sebitas', 'bac', 2147483647, 'sebas@gmail.com', '$2y$10$W5UPZVWpl/kiWY/vjknJj.YJzL1toGVfZV6wsPg85BXcTrmBauFS6', 'cliente', NULL, NULL, NULL, '2026-02-10 03:29:55', '2026-02-10 03:29:55'),
(16, 12345678, 'CC', 'manuel diaz', 'ibague', 31354658, 'mfds.camilo@gmail.com', '$2y$10$XObhotjlwZf0EFw.GW9tYuku2JBjhc5zb4lDRWJc/CrPHyHGZd0FK', 'cliente', NULL, NULL, NULL, '2026-02-10 03:59:37', '2026-02-10 04:12:10');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD PRIMARY KEY (`idCarrito`),
  ADD KEY `idProducto` (`idProducto`),
  ADD KEY `idx_carrito_usuario` (`idUsuario`);

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`idCATEGORIA`);

--
-- Indices de la tabla `detallesalida`
--
ALTER TABLE `detallesalida`
  ADD PRIMARY KEY (`idDETALLE`),
  ADD KEY `idFACTURA` (`idFACTURA`),
  ADD KEY `idPRODUCTO` (`idPRODUCTO`);

--
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`id_empleado`);

--
-- Indices de la tabla `entrada`
--
ALTER TABLE `entrada`
  ADD PRIMARY KEY (`idENTRADA`),
  ADD KEY `idUSUARIO` (`idUSUARIO`),
  ADD KEY `idx_entrada_producto` (`idPRODUCTO`);

--
-- Indices de la tabla `factura`
--
ALTER TABLE `factura`
  ADD PRIMARY KEY (`idFACTURA`),
  ADD KEY `idx_factura_usuario` (`idUSUARIO`);

--
-- Indices de la tabla `mensajes_contacto`
--
ALTER TABLE `mensajes_contacto`
  ADD PRIMARY KEY (`id_mensaje`);

--
-- Indices de la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD PRIMARY KEY (`idPago`),
  ADD KEY `idFactura` (`idFactura`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`idPRODUCTO`),
  ADD KEY `idx_producto_categoria` (`idCATEGORIA`),
  ADD KEY `idx_producto_proveedor` (`idPROVEEDOR`);

--
-- Indices de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD PRIMARY KEY (`idPROVEEDOR`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idUSUARIO`),
  ADD KEY `idx_usuario_email` (`emailUSUARIO`),
  ADD KEY `idx_reset_token` (`reset_token`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `carrito`
--
ALTER TABLE `carrito`
  MODIFY `idCarrito` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `idCATEGORIA` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `detallesalida`
--
ALTER TABLE `detallesalida`
  MODIFY `idDETALLE` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `empleados`
--
ALTER TABLE `empleados`
  MODIFY `id_empleado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `entrada`
--
ALTER TABLE `entrada`
  MODIFY `idENTRADA` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `factura`
--
ALTER TABLE `factura`
  MODIFY `idFACTURA` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `mensajes_contacto`
--
ALTER TABLE `mensajes_contacto`
  MODIFY `id_mensaje` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `pagos`
--
ALTER TABLE `pagos`
  MODIFY `idPago` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `idPRODUCTO` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  MODIFY `idPROVEEDOR` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idUSUARIO` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD CONSTRAINT `carrito_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUSUARIO`),
  ADD CONSTRAINT `carrito_ibfk_2` FOREIGN KEY (`idProducto`) REFERENCES `producto` (`idPRODUCTO`);

--
-- Filtros para la tabla `detallesalida`
--
ALTER TABLE `detallesalida`
  ADD CONSTRAINT `detallesalida_ibfk_1` FOREIGN KEY (`idFACTURA`) REFERENCES `factura` (`idFACTURA`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detallesalida_ibfk_2` FOREIGN KEY (`idPRODUCTO`) REFERENCES `producto` (`idPRODUCTO`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `entrada`
--
ALTER TABLE `entrada`
  ADD CONSTRAINT `entrada_ibfk_1` FOREIGN KEY (`idPRODUCTO`) REFERENCES `producto` (`idPRODUCTO`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `entrada_ibfk_2` FOREIGN KEY (`idUSUARIO`) REFERENCES `usuario` (`idUSUARIO`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `factura`
--
ALTER TABLE `factura`
  ADD CONSTRAINT `factura_ibfk_1` FOREIGN KEY (`idUSUARIO`) REFERENCES `usuario` (`idUSUARIO`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD CONSTRAINT `pagos_ibfk_1` FOREIGN KEY (`idFactura`) REFERENCES `factura` (`idFACTURA`);

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `producto_ibfk_1` FOREIGN KEY (`idCATEGORIA`) REFERENCES `categoria` (`idCATEGORIA`) ON UPDATE CASCADE,
  ADD CONSTRAINT `producto_ibfk_2` FOREIGN KEY (`idPROVEEDOR`) REFERENCES `proveedor` (`idPROVEEDOR`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
