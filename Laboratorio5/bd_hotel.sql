-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-06-2025 a las 01:45:12
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
-- Base de datos: `bd_hotel`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fotografias_habitacion`
--

CREATE TABLE `fotografias_habitacion` (
  `id` int(11) NOT NULL,
  `habitacion_id` int(11) NOT NULL,
  `fotografia` varchar(255) NOT NULL,
  `orden` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `fotografias_habitacion`
--

INSERT INTO `fotografias_habitacion` (`id`, `habitacion_id`, `fotografia`, `orden`) VALUES
(2, 2, 'habitacion_1.avif', 1),
(4, 1, 'ind_2.png', 3),
(5, 2, 'matri_2.png', 2),
(6, 2, 'matri_3.png', 3),
(9, 3, 'hab3_3.jpg', 3),
(11, 4, 'hab4_2.jpg', 2),
(12, 4, 'hab4_3.jpg', 3),
(13, 5, 'hab5_1.jpg', 1),
(14, 5, 'hab5_2.jpg', 2),
(15, 5, 'hab5_3.jpg', 3),
(16, 6, 'hab6_1.jpg', 1),
(17, 6, 'hab6_2.jpg', 2),
(18, 6, 'hab6_3.jpg', 3),
(19, 7, 'hab7_1.jpg', 1),
(20, 7, 'hab7_2.jpg', 2),
(21, 7, 'hab7_3.jpg', 3),
(30, 13, '1749679186_28-scaled.jpg', 2),
(31, 13, '1749679186_1749609645_junior.avif', 3),
(32, 13, '1749679186_1749609645_junior2.avif', 4),
(33, 13, '1749679186_1749609645_junior5.avif', 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `habitaciones`
--

CREATE TABLE `habitaciones` (
  `id` int(11) NOT NULL,
  `numero` int(11) NOT NULL,
  `piso` int(11) NOT NULL,
  `tipo_habitacion_id` int(11) NOT NULL,
  `Precio` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `habitaciones`
--

INSERT INTO `habitaciones` (`id`, `numero`, `piso`, `tipo_habitacion_id`, `Precio`) VALUES
(1, 101, 1, 1, 100),
(2, 102, 2, 3, 120),
(3, 101, 3, 4, 80),
(4, 102, 4, 4, 75),
(5, 103, 2, 2, 200),
(6, 104, 2, 1, 0),
(7, 105, 1, 3, 0),
(13, 80, 100, 2, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservas`
--

CREATE TABLE `reservas` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `habitacion_id` int(11) NOT NULL,
  `fecha_ingreso` date NOT NULL,
  `fecha_salida` date NOT NULL,
  `estado` enum('pendiente','confirmada','cancelada') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `reservas`
--

INSERT INTO `reservas` (`id`, `usuario_id`, `habitacion_id`, `fecha_ingreso`, `fecha_salida`, `estado`) VALUES
(1, 1, 1, '2025-06-11', '2025-06-13', 'pendiente'),
(2, 1, 2, '2025-06-11', '2025-06-15', 'confirmada'),
(3, 1, 1, '2025-06-11', '2025-06-13', 'confirmada'),
(4, 1, 1, '2025-06-11', '2025-06-14', 'confirmada'),
(5, 1, 1, '2025-06-12', '2025-06-20', 'confirmada'),
(6, 1, 1, '2025-06-11', '2025-06-13', 'confirmada'),
(7, 1, 7, '2025-06-12', '2025-06-13', 'confirmada'),
(8, 1, 3, '2025-06-12', '2025-06-13', 'confirmada'),
(9, 3, 13, '2025-06-15', '2025-06-22', 'confirmada');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_habitacion`
--

CREATE TABLE `tipos_habitacion` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `superficie` decimal(5,2) NOT NULL,
  `numero_camas` int(11) NOT NULL,
  `Descripcion` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipos_habitacion`
--

INSERT INTO `tipos_habitacion` (`id`, `nombre`, `superficie`, `numero_camas`, `Descripcion`) VALUES
(1, 'Individual', 20.50, 1, 'Ideal para viajeros solos, con espacio suficiente para descansar. Suele incluir escritorio, armario y baño privado.\r\n'),
(2, 'Doble', 35.00, 2, 'Perfecta para amigos o compañeros de viaje que prefieren camas independientes. Equipada con mobiliario básico y baño privado.'),
(3, 'Matrimonial', 35.00, 1, 'Diseñada para parejas, con un espacio más amplio y ambiente acogedor. Incluye amenities básicos y baño privado.'),
(4, 'Familiar', 45.50, 4, 'Espaciosa, pensada para familias o grupos. Puede tener zona de estar y baño amplio. Algunas incluyen cocineta o servicios adicionales para niños.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `correo` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rol` enum('admin','cliente') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `correo`, `password`, `rol`) VALUES
(1, 'admin@usfx.bo', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'admin'),
(2, 'cliente@gmail.com', 'd94019fd760a71edf11844bb5c601a4de95aacaf', 'cliente'),
(3, 'lu@gmail.com', '8cb2237d0679ca88db6464eac60da96345513964', 'admin'),
(4, 'rafa@gmail.com', '67023cda456b9844abf8a9a3992799093bbfb69f', 'cliente');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `fotografias_habitacion`
--
ALTER TABLE `fotografias_habitacion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `habitacion_id` (`habitacion_id`);

--
-- Indices de la tabla `habitaciones`
--
ALTER TABLE `habitaciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tipo_habitacion_id` (`tipo_habitacion_id`);

--
-- Indices de la tabla `reservas`
--
ALTER TABLE `reservas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `habitacion_id` (`habitacion_id`);

--
-- Indices de la tabla `tipos_habitacion`
--
ALTER TABLE `tipos_habitacion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `correo` (`correo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `fotografias_habitacion`
--
ALTER TABLE `fotografias_habitacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT de la tabla `habitaciones`
--
ALTER TABLE `habitaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `reservas`
--
ALTER TABLE `reservas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `tipos_habitacion`
--
ALTER TABLE `tipos_habitacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `fotografias_habitacion`
--
ALTER TABLE `fotografias_habitacion`
  ADD CONSTRAINT `fotografias_habitacion_ibfk_1` FOREIGN KEY (`habitacion_id`) REFERENCES `habitaciones` (`id`);

--
-- Filtros para la tabla `habitaciones`
--
ALTER TABLE `habitaciones`
  ADD CONSTRAINT `habitaciones_ibfk_1` FOREIGN KEY (`tipo_habitacion_id`) REFERENCES `tipos_habitacion` (`id`);

--
-- Filtros para la tabla `reservas`
--
ALTER TABLE `reservas`
  ADD CONSTRAINT `reservas_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `reservas_ibfk_2` FOREIGN KEY (`habitacion_id`) REFERENCES `habitaciones` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
