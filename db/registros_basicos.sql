-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-03-2018 a las 22:08:46
-- Versión del servidor: 10.1.26-MariaDB
-- Versión de PHP: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `votaciones`
--
USE `votaciones`;

--
-- Volcado de datos para la tabla `candidatos`
--

INSERT INTO `candidatos` (`id_candidato`, `id_partido`, `cedula`, `nombres`, `apellidos`, `foto`, `activo`, `fecha_ingreso`, `fecha_update`) VALUES
(1, 1, 454645466, 'Ivan', 'Duque', '/imagenes/perfiles/candidatos/ivanduque.png', 1, '2018-03-20', NULL),
(2, 3, 546446222, 'Gustavo', 'Petro', '/imagenes/perfiles/candidatos/gustavopetro.png', 1, '2018-03-20', NULL),
(3, 2, 345332234, 'Aurelio', 'Iragorri', '/imagenes/perfiles/candidatos/aurelioiragorri', 1, '2018-03-20', NULL);

--
-- Volcado de datos para la tabla `ciudadanos`
--

INSERT INTO `ciudadanos` (`id_ciudadano`, `id_usuario`, `cedula`, `nombres`, `apellidos`, `id_ciudad`, `voto_hecho`, `activo`) VALUES
(1, 3, 1234567890, 'Carlos Humberto', 'Sastoque Rivera', 1, 0, 1);

--
-- Volcado de datos para la tabla `ciudades`
--

INSERT INTO `ciudades` (`id_ciudad`, `id_departamento`, `descripcion`) VALUES
(1, 1, 'Acacías'),
(2, 1, 'Villavicencio'),
(3, 2, 'Bogotá'),
(4, 4, 'Santa Marta'),
(5, 3, 'Medellín');

--
-- Volcado de datos para la tabla `departamentos`
--

INSERT INTO `departamentos` (`id_departamento`, `id_region`, `descripcion`) VALUES
(1, 4, 'Meta'),
(2, 3, 'Cundinamarca'),
(3, 3, 'Antioquia'),
(4, 1, 'Magdalena');

--
-- Volcado de datos para la tabla `partidos`
--

INSERT INTO `partidos` (`id_partido`, `nombre`, `descripcion`, `logo`) VALUES
(1, 'Centro Democrático', 'Somos un grupo de ciudadanos de diversos orígenes políticos –liberales, conservadores, de la U, de la izquierda democrática-, movimientos y sin partido, preocupados por el presente y el futuro de Colombia', 'imagenes/perfiles/partidos/logocd.png'),
(2, 'Partido de la Unidad', 'Somos una organización política con fuerte vocación social, interesada en la búsqueda de la reconciliación nacional y la paz, y en la construcción de un nuevo país sobre las premisas de la igualdad de oportunidades y la equidad.', 'imagenes/perfiles/partidos/logou.png'),
(3, 'Colombia Humana', 'dsfdjfnsdkfbdskfjbsfkjdbsfkjabfjadbfjkdbfkdbfdkjbfdkjbdfbjfdbjfdbfjdfsj', 'imagenes/perfiles/partidos/ColHumana.png');

--
-- Volcado de datos para la tabla `regiones`
--

INSERT INTO `regiones` (`id_region`, `descripcion`) VALUES
(1, 'Caribe'),
(2, 'Pacífica'),
(3, 'Andina'),
(4, 'Orinoquía'),
(5, 'Amazonía'),
(6, 'Insular');

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id_rol`, `descripcion`) VALUES
(1, 'Administrador'),
(2, 'Ciudadano'),
(3, 'Consultante');

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `login`, `password`, `id_rol`, `email`) VALUES
(1, 'admin', 'd4e8e6deaa7b1f8381e09e3e6b83e36f0b681c5c', 1, 'admin@votaciones.gov.co'),
(2, 'estadistica1', '621f2473d25bfa762a69214818d2eac7619a6be1', 3, 'estadistica@votaciones.gov.co'),
(3, 'carlos.sastoque', 'carlos12345', 2, 'cahusari2005@gmail.com');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
