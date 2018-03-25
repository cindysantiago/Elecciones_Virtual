-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-03-2018 a las 20:18:52
-- Versión del servidor: 10.1.26-MariaDB
-- Versión de PHP: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `votaciones`
--
CREATE DATABASE IF NOT EXISTS `votaciones` DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci;
USE `votaciones`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `candidatos`
--

CREATE TABLE IF NOT EXISTS `candidatos` (
  `id_candidato` int(10) NOT NULL AUTO_INCREMENT,
  `id_partido` int(2) NOT NULL,
  `cedula` int(10) NOT NULL,
  `nombres` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `apellidos` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `foto` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `activo` int(1) NOT NULL DEFAULT '1',
  `fecha_ingreso` date NOT NULL,
  `fecha_update` date DEFAULT NULL,
  PRIMARY KEY (`id_candidato`),
  UNIQUE KEY `cedula` (`cedula`),
  KEY `id_partido` (`id_partido`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- RELACIONES PARA LA TABLA `candidatos`:
--   `id_partido`
--       `partidos` -> `id_partido`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ciudadanos`
--

CREATE TABLE IF NOT EXISTS `ciudadanos` (
  `id_ciudadano` int(10) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(10) NOT NULL,
  `cedula` int(10) NOT NULL,
  `nombres` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `apellidos` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `id_ciudad` int(3) NOT NULL,
  `voto_hecho` int(1) NOT NULL DEFAULT '0',
  `activo` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_ciudadano`),
  UNIQUE KEY `cedula` (`cedula`),
  KEY `id_usuario` (`id_usuario`),
  KEY `id_ciudad` (`id_ciudad`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- RELACIONES PARA LA TABLA `ciudadanos`:
--   `id_usuario`
--       `usuarios` -> `id_usuario`
--   `id_ciudad`
--       `ciudades` -> `id_ciudad`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ciudades`
--

CREATE TABLE IF NOT EXISTS `ciudades` (
  `id_ciudad` int(3) NOT NULL AUTO_INCREMENT,
  `id_departamento` int(3) NOT NULL,
  `descripcion` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id_ciudad`),
  KEY `id_departamento` (`id_departamento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- RELACIONES PARA LA TABLA `ciudades`:
--   `id_departamento`
--       `departamentos` -> `id_departamento`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamentos`
--

CREATE TABLE IF NOT EXISTS `departamentos` (
  `id_departamento` int(3) NOT NULL AUTO_INCREMENT,
  `id_region` int(1) NOT NULL,
  `descripcion` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id_departamento`),
  KEY `id_region` (`id_region`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- RELACIONES PARA LA TABLA `departamentos`:
--   `id_region`
--       `regiones` -> `id_region`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_candidato`
--

CREATE TABLE IF NOT EXISTS `detalle_candidato` (
  `id_detalle` int(10) NOT NULL AUTO_INCREMENT,
  `id_candidato` int(10) NOT NULL,
  `descripcion` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id_detalle`),
  KEY `id_candidato` (`id_candidato`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- RELACIONES PARA LA TABLA `detalle_candidato`:
--   `id_candidato`
--       `candidatos` -> `id_candidato`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paginas`
--

CREATE TABLE IF NOT EXISTS `paginas` (
  `id_pagina` int(2) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `url` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `padre` int(2) DEFAULT NULL,
  PRIMARY KEY (`id_pagina`),
  KEY `padre` (`padre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- RELACIONES PARA LA TABLA `paginas`:
--   `padre`
--       `paginas` -> `id_pagina`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `partidos`
--

CREATE TABLE IF NOT EXISTS `partidos` (
  `id_partido` int(2) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `logo` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id_partido`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- RELACIONES PARA LA TABLA `partidos`:
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos`
--

CREATE TABLE IF NOT EXISTS `permisos` (
  `id_permiso` int(2) NOT NULL AUTO_INCREMENT,
  `id_rol` int(1) NOT NULL,
  `id_pagina` int(2) NOT NULL,
  `fecha` date NOT NULL,
  PRIMARY KEY (`id_permiso`),
  KEY `id_rol` (`id_rol`),
  KEY `id_pagina` (`id_pagina`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- RELACIONES PARA LA TABLA `permisos`:
--   `id_rol`
--       `roles` -> `id_rol`
--   `id_pagina`
--       `paginas` -> `id_pagina`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `propuesta_candidato`
--

CREATE TABLE IF NOT EXISTS `propuesta_candidato` (
  `id_propuesta` int(10) NOT NULL AUTO_INCREMENT,
  `id_candidato` int(10) NOT NULL,
  `descripcion` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id_propuesta`),
  KEY `id_candidato` (`id_candidato`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- RELACIONES PARA LA TABLA `propuesta_candidato`:
--   `id_candidato`
--       `candidatos` -> `id_candidato`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `regiones`
--

CREATE TABLE IF NOT EXISTS `regiones` (
  `id_region` int(1) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id_region`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- RELACIONES PARA LA TABLA `regiones`:
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `id_rol` int(1) NOT NULL,
  `descripcion` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id_rol`),
  UNIQUE KEY `descripcion` (`descripcion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- RELACIONES PARA LA TABLA `roles`:
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sesiones`
--

CREATE TABLE IF NOT EXISTS `sesiones` (
  `id_sesion` int(10) NOT NULL AUTO_INCREMENT,
  `hash` varchar(120) COLLATE utf8_spanish_ci NOT NULL,
  `id_usuario` int(10) NOT NULL,
  `ip` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `tipo_usuario` int(1) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date DEFAULT NULL,
  PRIMARY KEY (`id_sesion`),
  KEY `id_usuario` (`id_usuario`),
  KEY `tipo_usuario` (`tipo_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- RELACIONES PARA LA TABLA `sesiones`:
--   `id_usuario`
--       `usuarios` -> `id_usuario`
--   `tipo_usuario`
--       `roles` -> `id_rol`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `id_usuario` int(10) NOT NULL AUTO_INCREMENT,
  `login` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `password` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `id_rol` int(1) NOT NULL,
  `email` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `login` (`login`),
  KEY `id_rol` (`id_rol`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- RELACIONES PARA LA TABLA `usuarios`:
--   `id_rol`
--       `roles` -> `id_rol`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `votaciones`
--

CREATE TABLE IF NOT EXISTS `votaciones` (
  `id_voto` int(10) NOT NULL AUTO_INCREMENT,
  `id_candidato` int(10) NOT NULL,
  `id_ciudad` int(3) NOT NULL,
  `fecha_hora` datetime NOT NULL,
  PRIMARY KEY (`id_voto`),
  KEY `id_candidato` (`id_candidato`),
  KEY `id_ciudad` (`id_ciudad`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- RELACIONES PARA LA TABLA `votaciones`:
--   `id_candidato`
--       `candidatos` -> `id_candidato`
--   `id_ciudad`
--       `ciudades` -> `id_ciudad`
--

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `candidatos`
--
ALTER TABLE `candidatos`
  ADD CONSTRAINT `candidatos_ibfk_1` FOREIGN KEY (`id_partido`) REFERENCES `partidos` (`id_partido`);

--
-- Filtros para la tabla `ciudadanos`
--
ALTER TABLE `ciudadanos`
  ADD CONSTRAINT `ciudadanos_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`),
  ADD CONSTRAINT `ciudadanos_ibfk_2` FOREIGN KEY (`id_ciudad`) REFERENCES `ciudades` (`id_ciudad`);

--
-- Filtros para la tabla `ciudades`
--
ALTER TABLE `ciudades`
  ADD CONSTRAINT `ciudades_ibfk_1` FOREIGN KEY (`id_departamento`) REFERENCES `departamentos` (`id_departamento`);

--
-- Filtros para la tabla `departamentos`
--
ALTER TABLE `departamentos`
  ADD CONSTRAINT `departamentos_ibfk_1` FOREIGN KEY (`id_region`) REFERENCES `regiones` (`id_region`);

--
-- Filtros para la tabla `detalle_candidato`
--
ALTER TABLE `detalle_candidato`
  ADD CONSTRAINT `detalle_candidato_ibfk_1` FOREIGN KEY (`id_candidato`) REFERENCES `candidatos` (`id_candidato`);

--
-- Filtros para la tabla `paginas`
--
ALTER TABLE `paginas`
  ADD CONSTRAINT `paginas_ibfk_1` FOREIGN KEY (`padre`) REFERENCES `paginas` (`id_pagina`);

--
-- Filtros para la tabla `permisos`
--
ALTER TABLE `permisos`
  ADD CONSTRAINT `permisos_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id_rol`),
  ADD CONSTRAINT `permisos_ibfk_2` FOREIGN KEY (`id_pagina`) REFERENCES `paginas` (`id_pagina`);

--
-- Filtros para la tabla `propuesta_candidato`
--
ALTER TABLE `propuesta_candidato`
  ADD CONSTRAINT `propuesta_candidato_ibfk_1` FOREIGN KEY (`id_candidato`) REFERENCES `candidatos` (`id_candidato`);

--
-- Filtros para la tabla `sesiones`
--
ALTER TABLE `sesiones`
  ADD CONSTRAINT `sesiones_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`),
  ADD CONSTRAINT `sesiones_ibfk_2` FOREIGN KEY (`tipo_usuario`) REFERENCES `roles` (`id_rol`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id_rol`);

--
-- Filtros para la tabla `votaciones`
--
ALTER TABLE `votaciones`
  ADD CONSTRAINT `votaciones_ibfk_1` FOREIGN KEY (`id_candidato`) REFERENCES `candidatos` (`id_candidato`),
  ADD CONSTRAINT `votaciones_ibfk_2` FOREIGN KEY (`id_ciudad`) REFERENCES `ciudades` (`id_ciudad`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
