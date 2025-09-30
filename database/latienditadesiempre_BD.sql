-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 30-09-2025 a las 19:54:05
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
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `idCATEGORIA` int(11) NOT NULL,
  `nomCATEGORIA` varchar(30) DEFAULT NULL,
  `descripcionCATEGORIA` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `fotoPRODUCTO` varchar(100) DEFAULT NULL,
  `idCATEGORIA` int(11) DEFAULT NULL,
  `idPROVEEDOR` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `pass` varchar(40) DEFAULT NULL,
  `rolUSUARIO` varchar(20) DEFAULT NULL,
  `cargoUSUARIO` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

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
-- Indices de la tabla `entrada`
--
ALTER TABLE `entrada`
  ADD PRIMARY KEY (`idENTRADA`),
  ADD KEY `idPRODUCTO` (`idPRODUCTO`),
  ADD KEY `idUSUARIO` (`idUSUARIO`);

--
-- Indices de la tabla `factura`
--
ALTER TABLE `factura`
  ADD PRIMARY KEY (`idFACTURA`),
  ADD KEY `idUSUARIO` (`idUSUARIO`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`idPRODUCTO`),
  ADD KEY `idCATEGORIA` (`idCATEGORIA`),
  ADD KEY `idPROVEEDOR` (`idPROVEEDOR`);

--
-- Indices de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD PRIMARY KEY (`idPROVEEDOR`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idUSUARIO`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `idCATEGORIA` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detallesalida`
--
ALTER TABLE `detallesalida`
  MODIFY `idDETALLE` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `entrada`
--
ALTER TABLE `entrada`
  MODIFY `idENTRADA` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `factura`
--
ALTER TABLE `factura`
  MODIFY `idFACTURA` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `idPRODUCTO` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  MODIFY `idPROVEEDOR` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idUSUARIO` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

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
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `producto_ibfk_1` FOREIGN KEY (`idCATEGORIA`) REFERENCES `categoria` (`idCATEGORIA`) ON UPDATE CASCADE,
  ADD CONSTRAINT `producto_ibfk_2` FOREIGN KEY (`idPROVEEDOR`) REFERENCES `proveedor` (`idPROVEEDOR`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
