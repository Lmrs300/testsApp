-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 28-03-2024 a las 03:22:07
-- Versión del servidor: 10.4.22-MariaDB
-- Versión de PHP: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `testsapp`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materias`
--

CREATE TABLE `materias` (
  `id_mat` int(11) NOT NULL,
  `materia` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `materias`
--

INSERT INTO `materias` (`id_mat`, `materia`) VALUES
(1, 'Inteligencia artificial'),
(2, 'Programación'),
(3, 'Ingeniería del software'),
(4, 'Electiva'),
(5, 'Investigación de operaciones');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `preguntas`
--

CREATE TABLE `preguntas` (
  `id_preg` int(11) NOT NULL,
  `pregunta` text NOT NULL,
  `tipo_preg` varchar(100) NOT NULL,
  `id_test` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `preguntas`
--

INSERT INTO `preguntas` (`id_preg`, `pregunta`, `tipo_preg`, `id_test`) VALUES
(32, 'deded', 'pregunta corta', 15),
(33, 'frfrfr', 'pregunta parrafo', 15),
(34, 'qaqaq', 'pregunta sel mul', 15),
(35, 'aaa', 'pregunta sel mul', 15),
(41, 'dedswdwes', 'pregunta sel mul', 27),
(42, 'dededefrf', 'pregunta corta', 27),
(43, 'gtgtgtghy', 'pregunta parrafo', 27),
(44, 'aaaaaa', 'pregunta parrafo', 27),
(45, 'yhujuhygt', 'pregunta sel mul', 27);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `puntuaciones_tests`
--

CREATE TABLE `puntuaciones_tests` (
  `id_pun_test` int(11) NOT NULL,
  `puntos` float NOT NULL,
  `id_usu` int(11) NOT NULL,
  `id_test` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `puntuaciones_tests`
--

INSERT INTO `puntuaciones_tests` (`id_pun_test`, `puntos`, `id_usu`, `id_test`) VALUES
(1, 7.5, 2, 15),
(7, 4, 2, 27),
(8, 16, 4, 27);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resp_est`
--

CREATE TABLE `resp_est` (
  `id_resp_est` int(11) NOT NULL,
  `resp_est` text NOT NULL,
  `correcta` tinyint(1) NOT NULL,
  `id_preg` int(11) NOT NULL,
  `id_usu` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `resp_est`
--

INSERT INTO `resp_est` (`id_resp_est`, `resp_est`, `correcta`, `id_preg`, `id_usu`) VALUES
(8, 'Sin respuesta', 1, 32, 2),
(9, 'algo', 1, 33, 2),
(10, 'dedede', 0, 34, 2),
(11, 'ccc', 1, 35, 2),
(18, 'qq', 0, 41, 2),
(19, 'dededeaa', 0, 42, 2),
(20, 'vfcds', 0, 43, 2),
(21, 'kjmh', 0, 44, 2),
(22, 'hnybtg', 0, 45, 2),
(23, 'edede', 1, 41, 4),
(24, 'ynhtbgvrfcd', 1, 42, 4),
(25, 'efrgvfecd', 1, 43, 4),
(26, 'bbbbbbb', 1, 44, 4),
(28, 'gbtvrf', 0, 45, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resp_radio`
--

CREATE TABLE `resp_radio` (
  `id_resp_radio` int(11) NOT NULL,
  `resp_radio` text NOT NULL,
  `seleccionada` tinyint(1) NOT NULL,
  `id_preg` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `resp_radio`
--

INSERT INTO `resp_radio` (`id_resp_radio`, `resp_radio`, `seleccionada`, `id_preg`) VALUES
(3, 'dedede', 0, 34),
(4, 'frfr', 1, 34),
(5, 'gtgt', 0, 34),
(6, 'aaa', 0, 35),
(7, 'bbb', 0, 35),
(8, 'ccc', 1, 35),
(16, 'edede', 1, 41),
(17, 'rfr', 0, 41),
(18, 'gygtg', 0, 41),
(19, 'qq', 0, 41),
(20, 'aa', 0, 41),
(21, 'gbtvrf', 0, 45),
(22, 'hnybtg', 1, 45),
(23, 'dededw', 0, 45);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id_rol` int(11) NOT NULL,
  `rol` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id_rol`, `rol`) VALUES
(1, 'Estudiante'),
(2, 'Profesor');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tests`
--

CREATE TABLE `tests` (
  `id_test` int(11) NOT NULL,
  `tema` text NOT NULL,
  `fecha_limite` date NOT NULL,
  `escala` float NOT NULL,
  `id_mat` int(11) NOT NULL,
  `id_usu` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tests`
--

INSERT INTO `tests` (`id_test`, `tema`, `fecha_limite`, `escala`, `id_mat`, `id_usu`) VALUES
(15, 'Reutilización de código', '2024-03-20', 10, 2, 1),
(27, 'Agentes inteligentes', '2024-04-04', 20, 1, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usu` int(11) NOT NULL,
  `nom_usu` varchar(100) NOT NULL,
  `ced_usu` varchar(20) NOT NULL,
  `id_rol` int(11) NOT NULL,
  `contra_usu` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usu`, `nom_usu`, `ced_usu`, `id_rol`, `contra_usu`) VALUES
(1, 'Luis Romero', '29850292', 2, '1234-prof'),
(2, 'Jorge Ramirez', '29555990', 1, '12345'),
(3, 'Jose Sanchez', '29765970', 2, 'prof'),
(4, 'Leonardo Polanco', '28463791', 1, '123'),
(5, 'Johnangel Del Rosario', '29555492', 1, '12');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `materias`
--
ALTER TABLE `materias`
  ADD PRIMARY KEY (`id_mat`);

--
-- Indices de la tabla `preguntas`
--
ALTER TABLE `preguntas`
  ADD PRIMARY KEY (`id_preg`),
  ADD KEY `test_fk` (`id_test`);

--
-- Indices de la tabla `puntuaciones_tests`
--
ALTER TABLE `puntuaciones_tests`
  ADD PRIMARY KEY (`id_pun_test`),
  ADD KEY `id_test` (`id_test`),
  ADD KEY `id_usu` (`id_usu`);

--
-- Indices de la tabla `resp_est`
--
ALTER TABLE `resp_est`
  ADD PRIMARY KEY (`id_resp_est`),
  ADD KEY `id_usu` (`id_usu`),
  ADD KEY `resp_est_ibfk_1` (`id_preg`);

--
-- Indices de la tabla `resp_radio`
--
ALTER TABLE `resp_radio`
  ADD PRIMARY KEY (`id_resp_radio`),
  ADD KEY `id_preg` (`id_preg`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id_rol`);

--
-- Indices de la tabla `tests`
--
ALTER TABLE `tests`
  ADD PRIMARY KEY (`id_test`),
  ADD KEY `id_mat` (`id_mat`),
  ADD KEY `id_usu` (`id_usu`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usu`),
  ADD KEY `rol_fk` (`id_rol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `materias`
--
ALTER TABLE `materias`
  MODIFY `id_mat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `preguntas`
--
ALTER TABLE `preguntas`
  MODIFY `id_preg` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT de la tabla `puntuaciones_tests`
--
ALTER TABLE `puntuaciones_tests`
  MODIFY `id_pun_test` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `resp_est`
--
ALTER TABLE `resp_est`
  MODIFY `id_resp_est` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT de la tabla `resp_radio`
--
ALTER TABLE `resp_radio`
  MODIFY `id_resp_radio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tests`
--
ALTER TABLE `tests`
  MODIFY `id_test` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `preguntas`
--
ALTER TABLE `preguntas`
  ADD CONSTRAINT `test_fk` FOREIGN KEY (`id_test`) REFERENCES `tests` (`id_test`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `puntuaciones_tests`
--
ALTER TABLE `puntuaciones_tests`
  ADD CONSTRAINT `puntuaciones_tests_ibfk_1` FOREIGN KEY (`id_test`) REFERENCES `tests` (`id_test`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `puntuaciones_tests_ibfk_2` FOREIGN KEY (`id_usu`) REFERENCES `usuarios` (`id_usu`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `resp_est`
--
ALTER TABLE `resp_est`
  ADD CONSTRAINT `resp_est_ibfk_1` FOREIGN KEY (`id_preg`) REFERENCES `preguntas` (`id_preg`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `resp_est_ibfk_2` FOREIGN KEY (`id_usu`) REFERENCES `usuarios` (`id_usu`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `resp_radio`
--
ALTER TABLE `resp_radio`
  ADD CONSTRAINT `resp_radio_ibfk_1` FOREIGN KEY (`id_preg`) REFERENCES `preguntas` (`id_preg`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tests`
--
ALTER TABLE `tests`
  ADD CONSTRAINT `tests_ibfk_1` FOREIGN KEY (`id_mat`) REFERENCES `materias` (`id_mat`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tests_ibfk_2` FOREIGN KEY (`id_usu`) REFERENCES `usuarios` (`id_usu`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `rol_fk` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id_rol`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
