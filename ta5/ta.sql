-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 24-09-2024 a las 21:43:53
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
-- Base de datos: `ta`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factores`
--

CREATE TABLE `factores` (
  `id` int(11) NOT NULL,
  `dui` int(10) NOT NULL,
  `historia` char(1) NOT NULL DEFAULT '0',
  `obesidad` char(1) NOT NULL DEFAULT '0',
  `sedentarismo` char(1) NOT NULL DEFAULT '0',
  `alcoholismo` char(1) NOT NULL DEFAULT '0',
  `tabaquismo` char(1) NOT NULL DEFAULT '0',
  `diabetes` char(1) NOT NULL DEFAULT '0',
  `colesterol` char(1) NOT NULL DEFAULT '0',
  `ingreso` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `factores`
--

INSERT INTO `factores` (`id`, `dui`, `historia`, `obesidad`, `sedentarismo`, `alcoholismo`, `tabaquismo`, `diabetes`, `colesterol`, `ingreso`) VALUES
(1, 5, '2', '2', '2', '2', '2', '3', '2', '2024-08-01'),
(2, 6, '1', '1', '1', '1', '3', '2', '0', '2024-08-01'),
(3, 7, '2', '2', '2', '0', '0', '0', '0', '2024-08-01'),
(4, 1, '3', '1', '0', '1', '1', '1', '1', '2024-08-01'),
(5, 2, '1', '2', '3', '0', '1', '2', '3', '2024-08-01'),
(6, 3, '1', '1', '1', '1', '2', '1', '2', '2024-08-01'),
(7, 4, '0', '0', '0', '0', '0', '0', '0', '2024-08-01'),
(8, 8, '3', '3', '1', '1', '1', '0', '0', '2024-08-06'),
(10, 9, '0', '0', '0', '0', '0', '0', '0', '2024-08-09'),
(11, 10, '0', '0', '0', '0', '0', '0', '0', '2024-08-09'),
(12, 11, '0', '0', '0', '0', '0', '0', '0', '2024-08-12'),
(13, 12, '3', '2', '1', '3', '2', '1', '1', '2024-08-12');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paciente`
--

CREATE TABLE `paciente` (
  `id` int(11) NOT NULL,
  `dui` int(10) NOT NULL,
  `nombre` varchar(25) NOT NULL,
  `apellido` varchar(25) NOT NULL,
  `sexo` varchar(9) NOT NULL,
  `nacimiento` date NOT NULL,
  `ingreso` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `paciente`
--

INSERT INTO `paciente` (`id`, `dui`, `nombre`, `apellido`, `sexo`, `nacimiento`, `ingreso`) VALUES
(1035, 5, 'ARMANDO', 'MOLINA', 'MASCULINO', '1951-10-23', '2024-08-01'),
(1036, 6, 'PEDRO', 'PARAMO', 'MASCULINO', '1980-11-11', '2024-08-01'),
(1037, 7, 'ANA MARIA', 'PELUFO', 'FEMENINO', '1960-12-01', '2024-08-01'),
(1038, 1, 'LUIS', 'PASTEUR', 'MASCULINO', '1950-10-10', '2024-08-01'),
(1039, 2, 'JUANA', 'TIGRIS', 'FEMENINO', '1980-12-10', '2024-08-01'),
(1040, 3, 'JULIA', 'MARTINEZ', 'FEMENINO', '1990-01-01', '2024-08-01'),
(1041, 4, 'FELIZ', 'EL GATO', 'MASCULINO', '1950-01-01', '2024-08-01'),
(1043, 8, 'MARIA', 'FELIX', 'FEMENINO', '1980-10-10', '2024-08-06'),
(1045, 9, 'PEDRO', 'DOMINGUEZ', 'MASCULINO', '2023-11-14', '2024-08-09'),
(1046, 10, 'MARIA', 'DEL PILAR', 'FEMENINO', '2019-02-04', '2024-08-09'),
(1047, 11, 'DAMARIS', 'ORTIZ', 'FEMENINO', '2019-06-03', '2024-08-12'),
(1048, 12, 'ORTENSIA', 'JIMENEZ', 'FEMENINO', '1960-11-23', '2024-08-12');

--
-- Disparadores `paciente`
--
DELIMITER $$
CREATE TRIGGER `after_insert_paciente` AFTER INSERT ON `paciente` FOR EACH ROW BEGIN
    INSERT INTO factores (dui) VALUES (NEW.dui);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prediccion`
--

CREATE TABLE `prediccion` (
  `id` int(11) NOT NULL,
  `dui` int(10) NOT NULL,
  `sistole` int(3) NOT NULL,
  `diastole` int(3) NOT NULL,
  `ingreso` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `prediccion`
--

INSERT INTO `prediccion` (`id`, `dui`, `sistole`, `diastole`, `ingreso`) VALUES
(5, 1, 132, 92, '2024-09-24');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `riesgos`
--

CREATE TABLE `riesgos` (
  `id` int(11) NOT NULL,
  `factor` int(1) NOT NULL,
  `descripcion` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `riesgos`
--

INSERT INTO `riesgos` (`id`, `factor`, `descripcion`) VALUES
(1, 0, 'Sin riesgo'),
(2, 1, 'Riesgo leve'),
(3, 2, 'Sin moderado'),
(4, 3, 'Riesgo alto');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tension`
--

CREATE TABLE `tension` (
  `id` int(11) NOT NULL,
  `dui` int(10) NOT NULL,
  `sistole` int(3) NOT NULL,
  `diastole` int(3) NOT NULL,
  `ingreso` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tension`
--

INSERT INTO `tension` (`id`, `dui`, `sistole`, `diastole`, `ingreso`) VALUES
(3, 2, 120, 80, '2024-07-23'),
(4, 2, 120, 80, '2024-07-23'),
(5, 2, 130, 100, '2024-07-23'),
(6, 2, 130, 100, '2024-07-23'),
(7, 2, 130, 100, '2024-07-23'),
(8, 2, 150, 100, '2024-07-24'),
(9, 1, 150, 100, '2024-07-24'),
(10, 2, 130, 90, '2024-07-24'),
(11, 2, 120, 80, '2024-07-24'),
(12, 2, 130, 90, '2024-07-24'),
(13, 2, 150, 100, '2024-07-24'),
(14, 2, 160, 120, '2024-07-24'),
(15, 2, 140, 90, '2024-07-24'),
(16, 2, 120, 80, '2024-07-24'),
(17, 1, 140, 100, '2024-07-26'),
(18, 4, 140, 100, '2024-07-26'),
(19, 4, 120, 80, '2024-07-26'),
(20, 1, 140, 100, '2024-08-01'),
(21, 1, 140, 100, '2024-08-01'),
(22, 1, 130, 90, '2024-08-01'),
(23, 1, 120, 90, '2024-08-01'),
(24, 1, 120, 100, '2024-08-01'),
(25, 1, 130, 90, '2024-08-01'),
(26, 1, 150, 110, '2024-08-01'),
(27, 2, 150, 100, '2024-08-01'),
(28, 2, 140, 90, '2024-08-01'),
(29, 2, 160, 110, '2024-08-01'),
(30, 3, 150, 100, '2024-08-02'),
(31, 3, 150, 90, '2024-08-02'),
(32, 1, 130, 90, '2024-08-02'),
(33, 1, 140, 100, '2024-08-02'),
(34, 1, 120, 80, '2024-08-02'),
(35, 1, 130, 90, '2024-08-02'),
(36, 1, 140, 100, '2024-08-02'),
(37, 1, 120, 80, '2024-08-02'),
(38, 1, 140, 100, '2024-08-02'),
(39, 1, 140, 90, '2024-08-05'),
(40, 8, 120, 80, '2024-08-06'),
(41, 1, 140, 90, '2024-08-14'),
(42, 3, 140, 90, '2024-08-15'),
(43, 5, 120, 80, '2024-08-15'),
(44, 5, 120, 80, '2024-08-15'),
(45, 5, 120, 80, '2024-08-15'),
(46, 5, 130, 90, '2024-08-15'),
(47, 5, 120, 80, '2024-08-15'),
(48, 8, 120, 80, '2024-08-16'),
(49, 8, 125, 90, '2024-08-16'),
(50, 8, 140, 100, '2024-08-16'),
(51, 8, 130, 90, '2024-08-16');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tmpcd`
--

CREATE TABLE `tmpcd` (
  `id` int(11) NOT NULL,
  `dui` int(11) NOT NULL,
  `cdsistole` int(3) NOT NULL,
  `cddiastole` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tmpcd`
--

INSERT INTO `tmpcd` (`id`, `dui`, `cdsistole`, `cddiastole`) VALUES
(1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tmpfactores`
--

CREATE TABLE `tmpfactores` (
  `id` int(11) NOT NULL,
  `dui` int(10) NOT NULL,
  `historia` char(1) NOT NULL DEFAULT '0',
  `obesidad` char(1) NOT NULL DEFAULT '0',
  `sedentarismo` char(1) NOT NULL DEFAULT '0',
  `alcoholismo` char(1) NOT NULL DEFAULT '0',
  `tabaquismo` char(1) NOT NULL DEFAULT '0',
  `diabetes` char(1) NOT NULL DEFAULT '0',
  `colesterol` char(1) NOT NULL DEFAULT '0',
  `ingreso` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tmpfactores`
--

INSERT INTO `tmpfactores` (`id`, `dui`, `historia`, `obesidad`, `sedentarismo`, `alcoholismo`, `tabaquismo`, `diabetes`, `colesterol`, `ingreso`) VALUES
(5, 1, '3', '1', '0', '1', '1', '1', '1', '2024-09-24');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tmppaciente`
--

CREATE TABLE `tmppaciente` (
  `id` int(11) NOT NULL,
  `dui` int(10) NOT NULL,
  `nombre` varchar(25) NOT NULL,
  `apellido` varchar(25) NOT NULL,
  `sexo` varchar(9) NOT NULL,
  `nacimiento` date NOT NULL,
  `ingreso` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tmppaciente`
--

INSERT INTO `tmppaciente` (`id`, `dui`, `nombre`, `apellido`, `sexo`, `nacimiento`, `ingreso`) VALUES
(0, 1, 'LUIS', 'PASTEUR', 'MASCULINO', '1950-10-10', '2024-08-01');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tmptension`
--

CREATE TABLE `tmptension` (
  `id` int(11) NOT NULL,
  `dui` int(10) NOT NULL,
  `sistole` int(3) NOT NULL,
  `diastole` int(3) NOT NULL,
  `ingreso` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tmptension`
--

INSERT INTO `tmptension` (`id`, `dui`, `sistole`, `diastole`, `ingreso`) VALUES
(26, 1, 140, 90, '2024-08-14'),
(27, 1, 140, 90, '2024-08-05'),
(28, 1, 120, 80, '2024-08-02'),
(29, 1, 130, 90, '2024-08-02'),
(30, 1, 140, 100, '2024-08-02'),
(31, 1, 120, 80, '2024-08-02'),
(32, 1, 140, 100, '2024-08-02'),
(33, 1, 140, 100, '2024-08-02'),
(34, 1, 130, 90, '2024-08-02'),
(35, 1, 120, 100, '2024-08-01');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `nombre` varchar(25) NOT NULL,
  `apellido` varchar(25) NOT NULL,
  `usuario` varchar(10) NOT NULL,
  `pass` varchar(10) NOT NULL,
  `ingreso` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `factores`
--
ALTER TABLE `factores`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dui` (`dui`);

--
-- Indices de la tabla `paciente`
--
ALTER TABLE `paciente`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `dui` (`dui`);

--
-- Indices de la tabla `prediccion`
--
ALTER TABLE `prediccion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dui` (`dui`);

--
-- Indices de la tabla `riesgos`
--
ALTER TABLE `riesgos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `factor` (`factor`);

--
-- Indices de la tabla `tension`
--
ALTER TABLE `tension`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dui` (`dui`);

--
-- Indices de la tabla `tmpcd`
--
ALTER TABLE `tmpcd`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tmpfactores`
--
ALTER TABLE `tmpfactores`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dui` (`dui`);

--
-- Indices de la tabla `tmppaciente`
--
ALTER TABLE `tmppaciente`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dui` (`dui`),
  ADD KEY `dui_2` (`dui`);

--
-- Indices de la tabla `tmptension`
--
ALTER TABLE `tmptension`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `factores`
--
ALTER TABLE `factores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `paciente`
--
ALTER TABLE `paciente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1049;

--
-- AUTO_INCREMENT de la tabla `prediccion`
--
ALTER TABLE `prediccion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `riesgos`
--
ALTER TABLE `riesgos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tension`
--
ALTER TABLE `tension`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT de la tabla `tmpcd`
--
ALTER TABLE `tmpcd`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tmpfactores`
--
ALTER TABLE `tmpfactores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `tmptension`
--
ALTER TABLE `tmptension`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `factores`
--
ALTER TABLE `factores`
  ADD CONSTRAINT `factores_ibfk_1` FOREIGN KEY (`dui`) REFERENCES `paciente` (`dui`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
