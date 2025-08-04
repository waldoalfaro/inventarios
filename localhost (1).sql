-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 23-05-2025 a las 16:48:44
-- Versión del servidor: 8.0.30
-- Versión de PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `ejemplo2`
--
CREATE DATABASE IF NOT EXISTS `ejemplo2` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `ejemplo2`;
--
-- Base de datos: `inventarios`
--
CREATE DATABASE IF NOT EXISTS `inventarios` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `inventarios`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alimentos`
--

CREATE TABLE `alimentos` (
  `id` int NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text,
  `stock_gramos` int NOT NULL DEFAULT '0',
  `creado_en` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `alimentos`
--

INSERT INTO `alimentos` (`id`, `nombre`, `descripcion`, `stock_gramos`, `creado_en`) VALUES
(1, 'Frijoles', 'frijoles', 12518, '2025-05-21 18:55:25'),
(2, 'Azucar', 'azucar', 22680, '2025-05-21 18:55:37'),
(3, 'leche', 'leche', 75, '2025-05-21 19:00:16');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumnos`
--

CREATE TABLE `alumnos` (
  `id` int NOT NULL,
  `nombre` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `carnet` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `alumnos`
--

INSERT INTO `alumnos` (`id`, `nombre`, `created_at`, `carnet`) VALUES
(6, 'jose oswaldo alfaro mora', '2025-05-20 02:48:31', 'am01137456'),
(7, 'alfa', '2025-05-20 03:49:22', 'sd23475'),
(8, 'nelson', '2025-05-20 03:51:54', 'vm7975444'),
(9, 'majano', '2025-05-20 03:52:07', 'mdf12345'),
(10, 'wlado', '2025-05-20 03:52:20', 'gh555');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entradas_alimentos`
--

CREATE TABLE `entradas_alimentos` (
  `id` int NOT NULL,
  `alimento_id` int NOT NULL,
  `cantidad_gramos` int NOT NULL,
  `fecha` date NOT NULL,
  `unidad` varchar(10) DEFAULT 'g',
  `precio` decimal(10,2) DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `entradas_alimentos`
--

INSERT INTO `entradas_alimentos` (`id`, `alimento_id`, `cantidad_gramos`, `fecha`, `unidad`, `precio`) VALUES
(1, 1, 4536, '2025-05-21', 'libras', NULL),
(2, 1, 2, '2025-05-21', 'gramos', NULL),
(3, 2, 22680, '2025-05-21', 'libras', 1.50),
(4, 1, 2000, '2025-05-21', 'kilogramos', NULL),
(5, 1, 2000, '2025-05-21', 'kilogramos', NULL),
(6, 1, 2000, '2025-05-21', 'kilogramos', NULL),
(7, 1, 2000, '2025-05-21', 'kilogramos', NULL),
(8, 3, 25, '2025-05-21', 'gramos', NULL),
(9, 3, 25, '2025-05-21', 'gramos', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movimientos_biblioteca`
--

CREATE TABLE `movimientos_biblioteca` (
  `id` int NOT NULL,
  `producto_id` int NOT NULL,
  `tipo` enum('entrada','salida') NOT NULL,
  `cantidad` int NOT NULL,
  `fecha` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `movimientos_biblioteca`
--

INSERT INTO `movimientos_biblioteca` (`id`, `producto_id`, `tipo`, `cantidad`, `fecha`) VALUES
(1, 4, 'entrada', 2, '2025-05-21 12:14:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movimientos_bodega`
--

CREATE TABLE `movimientos_bodega` (
  `id` int UNSIGNED NOT NULL,
  `producto_id` int UNSIGNED NOT NULL,
  `tipo` enum('entrada','salida') COLLATE utf8mb4_general_ci DEFAULT NULL,
  `cantidad` int NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `movimientos_bodega`
--

INSERT INTO `movimientos_bodega` (`id`, `producto_id`, `tipo`, `cantidad`, `fecha`) VALUES
(8, 7, 'salida', 2, '2025-05-20 18:56:32'),
(9, 8, 'salida', 4, '2025-05-23 15:54:11');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prestamos`
--

CREATE TABLE `prestamos` (
  `id` int NOT NULL,
  `alumno_id` int NOT NULL,
  `producto_id` int NOT NULL,
  `cantidad` int NOT NULL,
  `fecha_prestamo` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_devolucion` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `prestamos`
--

INSERT INTO `prestamos` (`id`, `alumno_id`, `producto_id`, `cantidad`, `fecha_prestamo`, `fecha_devolucion`) VALUES
(4, 6, 4, 2, '2025-05-19 06:00:00', '2025-05-21'),
(5, 6, 8, 5, '2025-05-20 06:00:00', '2025-05-21'),
(6, 6, 7, 2, '2025-05-20 06:00:00', '2025-05-21');

--
-- Disparadores `prestamos`
--
DELIMITER $$
CREATE TRIGGER `aumentar_cantidad_prestamo_cancelado` AFTER DELETE ON `prestamos` FOR EACH ROW BEGIN
  UPDATE productos_biblioteca
  SET cantidad = cantidad + OLD.cantidad
  WHERE id = OLD.producto_id;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `disminuir_cantidad_prestamo` AFTER INSERT ON `prestamos` FOR EACH ROW BEGIN
  UPDATE productos_biblioteca
  SET cantidad = cantidad - NEW.cantidad
  WHERE id = NEW.producto_id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos_biblioteca`
--

CREATE TABLE `productos_biblioteca` (
  `id` int NOT NULL,
  `nombre` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_general_ci NOT NULL,
  `cantidad` int NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `precio_unitario` decimal(10,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos_biblioteca`
--

INSERT INTO `productos_biblioteca` (`id`, `nombre`, `descripcion`, `cantidad`, `created_at`, `precio_unitario`) VALUES
(4, 'corbatas ', 'dddddd', 100, '2025-04-17 18:49:57', 0.00),
(6, 'Azucar ', 'dddddd', 1, '2025-05-20 03:13:08', 1.50),
(7, 'cell', 'dddddd', 2, '2025-05-20 03:52:36', 500.00),
(8, 'Laptop Dell', 'dddddd', 50, '2025-05-20 03:52:46', 400.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos_bodega`
--

CREATE TABLE `productos_bodega` (
  `id` int UNSIGNED NOT NULL,
  `nombre` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_general_ci,
  `cantidad` int NOT NULL DEFAULT '0',
  `creado_en` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `precio` decimal(10,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos_bodega`
--

INSERT INTO `productos_bodega` (`id`, `nombre`, `descripcion`, `cantidad`, `creado_en`, `precio`) VALUES
(7, 'corbatas ', 'dddddd', 10, '2025-05-20 02:19:33', 2.00),
(8, 'Jabon Liquido ', 'dddddd', 8, '2025-05-23 15:16:47', 1.50);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `salidas_alimentos`
--

CREATE TABLE `salidas_alimentos` (
  `id` int NOT NULL,
  `alimento_id` int NOT NULL,
  `cantidad_por_estudiante` int NOT NULL,
  `numero_estudiantes` int NOT NULL,
  `cantidad_total` int NOT NULL,
  `fecha` date NOT NULL,
  `unidad` varchar(10) DEFAULT 'g'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `salidas_alimentos`
--

INSERT INTO `salidas_alimentos` (`id`, `alimento_id`, `cantidad_por_estudiante`, `numero_estudiantes`, `cantidad_total`, `fecha`, `unidad`) VALUES
(1, 1, 1, 10, 10, '2025-05-21', 'gramos'),
(2, 1, 1, 10, 10, '2025-05-21', 'gramos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_usuario`
--

CREATE TABLE `tipo_usuario` (
  `idtipo` int NOT NULL,
  `tipo` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_usuario`
--

INSERT INTO `tipo_usuario` (`idtipo`, `tipo`) VALUES
(1, 'Administrador'),
(2, 'Bodega'),
(3, 'Biblioteca'),
(4, 'Alimentos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `idusuario` int NOT NULL,
  `usuario` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `passw` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `tipo` int NOT NULL,
  `estado` varchar(50) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'activo',
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`idusuario`, `usuario`, `passw`, `tipo`, `estado`, `email`) VALUES
(2, 'Rodriguez', '$2y$10$D5R8Ptl7Zpz6ombOHM3GPuYwu4de6xYXb0NSM9HbdyppzamYhmYXu', 4, '0', 'stivene017@gmail.com'),
(4, 'waldo', '$2y$10$dJg.LzU2TAQwwQnMs9m/YuYaGu0RGCN4eW5aIllADYt1W2X/ipgUq', 2, '0', 'jjsjsjjs@gmail.com'),
(5, 'oswaldo', '$2y$10$dJg.LzU2TAQwwQnMs9m/YuYaGu0RGCN4eW5aIllADYt1W2X/ipgUq', 1, '0', 'josepalfaro011@gmail.com'),
(8, 'alfaro', '$2y$10$C9Q5s4kfKJOALNBS8yn0TO3KMp6BGNnols91sQoBzRp1s5hkVdB5m', 1, '0', 'alfa@gmail.com'),
(9, 'espinoza', '$2y$10$etDcArVebPemBREfWOwdRu6rPj7NSlX7wIW8yf2lcQPYz3nOy621u', 3, '0', 'me6408048@gmail.com'),
(11, 'waldito', '$2y$10$Ak6NhANppU0MYvvoJr3.pO6uGQV/of/CLkKhgE1PB4okrZiZ/iK.G', 2, 'activo', 'wa@gmail.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id` int NOT NULL,
  `producto_id` int NOT NULL,
  `cantidad` int NOT NULL,
  `fecha_venta` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `cliente` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `precio_total` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id`, `producto_id`, `cantidad`, `fecha_venta`, `cliente`, `precio_total`) VALUES
(6, 6, 1, '2025-05-20 18:39:01', 'oswaldo', 1.50),
(7, 7, 2, '2025-05-20 18:43:52', 'oswaldo', 1000.00),
(8, 7, 1, '2025-05-20 18:53:13', 'oswaldo', 500.00),
(9, 6, 1, '2025-05-22 18:23:29', 'oswaldo', 1.50),
(10, 7, 1, '2025-05-22 18:24:59', 'oswaldo', 500.00);

--
-- Disparadores `ventas`
--
DELIMITER $$
CREATE TRIGGER `disminuir_cantidad_venta` AFTER INSERT ON `ventas` FOR EACH ROW BEGIN
  UPDATE productos_biblioteca
  SET cantidad = cantidad - NEW.cantidad
  WHERE id = NEW.producto_id;
END
$$
DELIMITER ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `alimentos`
--
ALTER TABLE `alimentos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `alumnos`
--
ALTER TABLE `alumnos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `entradas_alimentos`
--
ALTER TABLE `entradas_alimentos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `alimento_id` (`alimento_id`);

--
-- Indices de la tabla `movimientos_biblioteca`
--
ALTER TABLE `movimientos_biblioteca`
  ADD PRIMARY KEY (`id`),
  ADD KEY `producto_id` (`producto_id`);

--
-- Indices de la tabla `movimientos_bodega`
--
ALTER TABLE `movimientos_bodega`
  ADD PRIMARY KEY (`id`),
  ADD KEY `producto_id` (`producto_id`);

--
-- Indices de la tabla `prestamos`
--
ALTER TABLE `prestamos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `alumno_id` (`alumno_id`),
  ADD KEY `producto_id` (`producto_id`);

--
-- Indices de la tabla `productos_biblioteca`
--
ALTER TABLE `productos_biblioteca`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `productos_bodega`
--
ALTER TABLE `productos_bodega`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `salidas_alimentos`
--
ALTER TABLE `salidas_alimentos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `alimento_id` (`alimento_id`);

--
-- Indices de la tabla `tipo_usuario`
--
ALTER TABLE `tipo_usuario`
  ADD PRIMARY KEY (`idtipo`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`idusuario`),
  ADD UNIQUE KEY `usuario` (`usuario`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `producto_id` (`producto_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `alimentos`
--
ALTER TABLE `alimentos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `alumnos`
--
ALTER TABLE `alumnos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `entradas_alimentos`
--
ALTER TABLE `entradas_alimentos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `movimientos_biblioteca`
--
ALTER TABLE `movimientos_biblioteca`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `movimientos_bodega`
--
ALTER TABLE `movimientos_bodega`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `prestamos`
--
ALTER TABLE `prestamos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `productos_biblioteca`
--
ALTER TABLE `productos_biblioteca`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `productos_bodega`
--
ALTER TABLE `productos_bodega`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `salidas_alimentos`
--
ALTER TABLE `salidas_alimentos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tipo_usuario`
--
ALTER TABLE `tipo_usuario`
  MODIFY `idtipo` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idusuario` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `entradas_alimentos`
--
ALTER TABLE `entradas_alimentos`
  ADD CONSTRAINT `entradas_alimentos_ibfk_1` FOREIGN KEY (`alimento_id`) REFERENCES `alimentos` (`id`);

--
-- Filtros para la tabla `movimientos_biblioteca`
--
ALTER TABLE `movimientos_biblioteca`
  ADD CONSTRAINT `movimientos_biblioteca_ibfk_1` FOREIGN KEY (`producto_id`) REFERENCES `productos_biblioteca` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `movimientos_bodega`
--
ALTER TABLE `movimientos_bodega`
  ADD CONSTRAINT `movimientos_bodega_ibfk_1` FOREIGN KEY (`producto_id`) REFERENCES `productos_bodega` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `prestamos`
--
ALTER TABLE `prestamos`
  ADD CONSTRAINT `prestamos_ibfk_1` FOREIGN KEY (`alumno_id`) REFERENCES `alumnos` (`id`),
  ADD CONSTRAINT `prestamos_ibfk_2` FOREIGN KEY (`producto_id`) REFERENCES `productos_biblioteca` (`id`);

--
-- Filtros para la tabla `salidas_alimentos`
--
ALTER TABLE `salidas_alimentos`
  ADD CONSTRAINT `salidas_alimentos_ibfk_1` FOREIGN KEY (`alimento_id`) REFERENCES `alimentos` (`id`);

--
-- Filtros para la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD CONSTRAINT `ventas_ibfk_1` FOREIGN KEY (`producto_id`) REFERENCES `productos_biblioteca` (`id`);
--
-- Base de datos: `sistema_inventario`
--
CREATE DATABASE IF NOT EXISTS `sistema_inventario` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `sistema_inventario`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int NOT NULL,
  `nombre` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`) VALUES
(1, 'Impresiones '),
(2, 'Acrilicos'),
(3, 'soportes '),
(4, 'estructuras');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compras`
--

CREATE TABLE `compras` (
  `id` int NOT NULL,
  `fecha` datetime DEFAULT CURRENT_TIMESTAMP,
  `usuario_id` int NOT NULL,
  `proveedor_nombre` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `compras`
--

INSERT INTO `compras` (`id`, `fecha`, `usuario_id`, `proveedor_nombre`, `total`) VALUES
(1, '2025-05-18 07:22:48', 1, 'jose oswaldo', 255.00),
(2, '2025-05-18 08:14:45', 1, 'digital', 17.00),
(3, '2025-05-23 09:59:18', 1, 'jose oswaldo', 204.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_compras`
--

CREATE TABLE `detalle_compras` (
  `id` int NOT NULL,
  `compra_id` int NOT NULL,
  `producto_id` int NOT NULL,
  `cantidad` int NOT NULL,
  `precio_unitario` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `detalle_compras`
--

INSERT INTO `detalle_compras` (`id`, `compra_id`, `producto_id`, `cantidad`, `precio_unitario`) VALUES
(1, 1, 1, 15, 17.00),
(2, 2, 1, 1, 17.00),
(3, 3, 1, 12, 17.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_ventas`
--

CREATE TABLE `detalle_ventas` (
  `id` int NOT NULL,
  `venta_id` int NOT NULL,
  `producto_id` int NOT NULL,
  `cantidad` int NOT NULL,
  `precio_unitario` decimal(10,2) DEFAULT NULL,
  `descuento` decimal(10,2) DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `detalle_ventas`
--

INSERT INTO `detalle_ventas` (`id`, `venta_id`, `producto_id`, `cantidad`, `precio_unitario`, `descuento`) VALUES
(1, 1, 1, 5, 20.00, 0.00),
(2, 2, 1, 2, 20.00, 0.00),
(3, 3, 1, 12, 20.00, 0.00),
(4, 4, 2, 1, 5.00, 0.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facturas`
--

CREATE TABLE `facturas` (
  `id` int NOT NULL,
  `venta_id` int NOT NULL,
  `numero_factura` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha` date NOT NULL,
  `cliente_nombre` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `descuento_total` decimal(10,2) DEFAULT '0.00',
  `monto_neto` decimal(10,2) DEFAULT NULL,
  `iva` decimal(10,2) DEFAULT NULL,
  `cliente_correo` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tipo_factura` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `facturas`
--

INSERT INTO `facturas` (`id`, `venta_id`, `numero_factura`, `fecha`, `cliente_nombre`, `total`, `descuento_total`, `monto_neto`, `iva`, `cliente_correo`, `tipo_factura`) VALUES
(1, 1, 'F000001', '2025-05-18', 'Nelson', 100.00, 0.00, NULL, NULL, 'josep@gmail.com', NULL),
(2, 2, 'F000002', '2025-05-18', 'oswaldo', 40.00, 0.00, NULL, NULL, 'nve@gmail.com', NULL),
(3, 4, 'F000004', '2025-05-23', 'oswaldo', 5.65, 0.00, 5.00, 0.65, 'josep@gmail.com', 'Consumidor Final');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int NOT NULL,
  `nombre` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci,
  `precio_compra` decimal(10,2) DEFAULT NULL,
  `precio_venta` decimal(10,2) DEFAULT NULL,
  `stock` int DEFAULT '0',
  `stock_minimo` int DEFAULT '5',
  `proveedor_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `categoria_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `descripcion`, `precio_compra`, `precio_venta`, `stock`, `stock_minimo`, `proveedor_email`, `categoria_id`) VALUES
(1, 'banner', 'banner', 17.00, 20.00, 34, 10, 'josepalfaro@gmail.com', 1),
(2, 'banner', '100 x 100', 5.00, 5.00, 0, 2, 'nvenismoran@gmail.com', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_usuario`
--

CREATE TABLE `tipos_usuario` (
  `id` int NOT NULL,
  `nombre` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `tipos_usuario`
--

INSERT INTO `tipos_usuario` (`id`, `nombre`, `descripcion`) VALUES
(1, 'admin', 'Administrador con acceso total'),
(2, 'vendedor', 'Acceso solo a módulo de ventas'),
(3, 'almacenista', 'Acceso solo a inventario y compras'),
(4, 'facturador', 'Acceso solo a facturación');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int NOT NULL,
  `nombre` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `usuario` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `clave` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo_id` int NOT NULL,
  `estado` tinyint DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `usuario`, `clave`, `tipo_id`, `estado`) VALUES
(1, 'Waldo', 'Alfaro', '$2y$10$dJg.LzU2TAQwwQnMs9m/YuYaGu0RGCN4eW5aIllADYt1W2X/ipgUq', 1, 1),
(11, 'nelson moran', 'moran', '$2y$10$Cfx3nvZZKZLZ2Rg7A7.RSeYyx9cSRJRw5Csjsh3w7VdVpSIOF4Uma', 2, 1),
(12, 'waldito', 'alfal', '$2y$10$cjBTLDH9KPolWU/B1PwTqedXwSIzWb5dUq2YgXLn0SPWCoKpuBxsS', 3, 1),
(13, 'morales', 'moraless', '$2y$10$S1fPnLPvT/rZNWP8PZeQwekLbPpREWlkaJkf2.kLW7HHjjNMefp7K', 2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id` int NOT NULL,
  `fecha` datetime DEFAULT CURRENT_TIMESTAMP,
  `usuario_id` int NOT NULL,
  `cliente_nombre` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id`, `fecha`, `usuario_id`, `cliente_nombre`, `total`) VALUES
(1, '2025-05-18 07:23:30', 1, NULL, 100.00),
(2, '2025-05-18 08:17:55', 11, NULL, 40.00),
(3, '2025-05-23 10:15:26', 1, NULL, 240.00),
(4, '2025-05-23 10:43:59', 1, NULL, 5.00);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `compras`
--
ALTER TABLE `compras`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `detalle_compras`
--
ALTER TABLE `detalle_compras`
  ADD PRIMARY KEY (`id`),
  ADD KEY `compra_id` (`compra_id`),
  ADD KEY `producto_id` (`producto_id`);

--
-- Indices de la tabla `detalle_ventas`
--
ALTER TABLE `detalle_ventas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `venta_id` (`venta_id`),
  ADD KEY `producto_id` (`producto_id`);

--
-- Indices de la tabla `facturas`
--
ALTER TABLE `facturas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `venta_id` (`venta_id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categoria_id` (`categoria_id`);

--
-- Indices de la tabla `tipos_usuario`
--
ALTER TABLE `tipos_usuario`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tipo_id` (`tipo_id`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `compras`
--
ALTER TABLE `compras`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `detalle_compras`
--
ALTER TABLE `detalle_compras`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `detalle_ventas`
--
ALTER TABLE `detalle_ventas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `facturas`
--
ALTER TABLE `facturas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tipos_usuario`
--
ALTER TABLE `tipos_usuario`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `compras`
--
ALTER TABLE `compras`
  ADD CONSTRAINT `compras_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `detalle_compras`
--
ALTER TABLE `detalle_compras`
  ADD CONSTRAINT `detalle_compras_ibfk_1` FOREIGN KEY (`compra_id`) REFERENCES `compras` (`id`),
  ADD CONSTRAINT `detalle_compras_ibfk_2` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`);

--
-- Filtros para la tabla `detalle_ventas`
--
ALTER TABLE `detalle_ventas`
  ADD CONSTRAINT `detalle_ventas_ibfk_1` FOREIGN KEY (`venta_id`) REFERENCES `ventas` (`id`),
  ADD CONSTRAINT `detalle_ventas_ibfk_2` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`);

--
-- Filtros para la tabla `facturas`
--
ALTER TABLE `facturas`
  ADD CONSTRAINT `facturas_ibfk_1` FOREIGN KEY (`venta_id`) REFERENCES `ventas` (`id`);

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`tipo_id`) REFERENCES `tipos_usuario` (`id`);

--
-- Filtros para la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD CONSTRAINT `ventas_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
