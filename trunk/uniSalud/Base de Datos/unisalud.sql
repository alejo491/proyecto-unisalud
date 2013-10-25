-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 16-10-2013 a las 18:59:18
-- Versión del servidor: 5.5.24-log
-- Versión de PHP: 5.2.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `unisalud`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `atiende`
--

CREATE TABLE IF NOT EXISTS `atiende` (
  `id_programasalud` int(11) NOT NULL,
  `id_personalsalud` int(11) NOT NULL,
  PRIMARY KEY (`id_programasalud`,`id_personalsalud`),
  KEY `fk_atiende_atiende2_personal` (`id_personalsalud`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cita`
--

CREATE TABLE IF NOT EXISTS `cita` (
  `id_estudiante` int(11) NOT NULL,
  `id_programasalud` int(11) NOT NULL,
  `id_personalsalud` int(11) NOT NULL,
  `dia` mediumtext NOT NULL,
  `hora_inicio` int(11) NOT NULL,
  `hora_fin` int(11) NOT NULL,
  `estado` smallint(6) NOT NULL,
  `observaciones` mediumtext,
  PRIMARY KEY (`id_estudiante`,`id_programasalud`,`id_personalsalud`),
  KEY `fk_cita_cita2_programa` (`id_programasalud`),
  KEY `fk_cita_cita3_personal` (`id_personalsalud`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consultorio`
--

CREATE TABLE IF NOT EXISTS `consultorio` (
  `id_consultorio` int(11) NOT NULL AUTO_INCREMENT,
  `numero_consultorio` varchar(100) NOT NULL,
   `descripcion` varchar(124) DEFAULT 'ninguna descripcion',
  PRIMARY KEY (`id_consultorio`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


-- Volcado de datos para la tabla `consultorio`
--
INSERT INTO `consultorio` (`id_consultorio`, `numero_consultorio`, `descripcion`) VALUES
(1, '1','Medico General'),
(2, '2','Odontologia'),
(3, '3','Sicologia');
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estudiante`
--

CREATE TABLE IF NOT EXISTS `estudiante` (
  `id_estudiante` int(11) NOT NULL AUTO_INCREMENT,
  `id_programa` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `primer_nombre` varchar(256) NOT NULL,
  `segundo_nombre` varchar(256) DEFAULT NULL,
  `primer_apellido` varchar(256) NOT NULL,
  `segundo_apellido` varchar(256) NOT NULL,
  `identificacion` varchar(16) NOT NULL,
  `tipo_identificacion` varchar(20) NOT NULL,
  `genero` varchar(10) NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  PRIMARY KEY (`id_estudiante`),
  KEY `fk_estudian_pertenece_programa` (`id_programa`),
  KEY `fk_estudian_reference_usuario` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facultad`
--

CREATE TABLE IF NOT EXISTS `facultad` (
  `id_facultad` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_facultad` varchar(256) NOT NULL,
  PRIMARY KEY (`id_facultad`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Volcado de datos para la tabla `facultad`
--

INSERT INTO `facultad` (`id_facultad`, `nombre_facultad`) VALUES
(1, 'Artes'),
(2, 'Ciencias Agropecuarias'),
(3, 'Ciencias de la Salud'),
(4, 'Ciencias Contables, Economicas y Administrativas'),
(5, 'Ciencias Humanas y Sociales'),
(6, 'Ciencias Naturales, Exactas y de la Educacion'),
(7, 'Derecho, Ciencias Politicas y Sociales'),
(8, 'Ingenieria Civil'),
(9, 'Ingenieria Electronica y Telecomunicaciones');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horarioatencion`
--

CREATE TABLE IF NOT EXISTS `horarioatencion` (
  `id_agenda` int(11) NOT NULL AUTO_INCREMENT,
  `id_personalsalud` int(11) NOT NULL,
  `dia` mediumtext NOT NULL,
  `hora_inicial` time NOT NULL,
  `hora_final` time NOT NULL,
  PRIMARY KEY (`id_agenda`),
  KEY `fk_horarioa_tiene_2_personal` (`id_personalsalud`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personalsalud`
--

CREATE TABLE IF NOT EXISTS `personalsalud` (
  `id_personalsalud` int(11) NOT NULL AUTO_INCREMENT,
  `id_consultorio` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `primer_nombre` varchar(256) NOT NULL,
  `segundo_nombre` varchar(256) DEFAULT NULL,
  `primer_apellido` varchar(256) NOT NULL,
  `segundo_apellido` varchar(256) NOT NULL,
   `tipo_identificacion` varchar(20) NOT NULL,
  `identificacion` varchar(16) NOT NULL,
  `numero_tarjeta` varchar(32) NOT NULL,
  `especialidad` varchar(256) NOT NULL,
  PRIMARY KEY (`id_personalsalud`),
  KEY `fk_personal_asignado_consulto` (`id_consultorio`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `posee`
--

CREATE TABLE IF NOT EXISTS `posee` (
  `id_usuario` int(11) NOT NULL,
  `id_rol` int(11) NOT NULL,
  PRIMARY KEY (`id_usuario`,`id_rol`),
  KEY `fk_posee_posee2_rol` (`id_rol`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `posee`
--
INSERT INTO `posee` (`id_usuario`, `id_rol`) VALUES
(12,1),
(13,3);
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `programa`
--

CREATE TABLE IF NOT EXISTS `programa` (
  `id_programa` int(11) NOT NULL AUTO_INCREMENT,
  `id_facultad` int(11) NOT NULL,
  `nombre_programa` varchar(256) NOT NULL,
  PRIMARY KEY (`id_programa`),
  KEY `fk_programa_tiene_facultad` (`id_facultad`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=44 ;

--
-- Volcado de datos para la tabla `programa`
--

INSERT INTO `programa` (`id_programa`, `id_facultad`, `nombre_programa`) VALUES
(1, 1, 'Diseño Grafico'),
(2, 1, 'Artes Plasticas'),
(3, 1, 'Licenciatura en Musica'),
(4, 1, 'Musica Instrumental'),
(5, 2, 'Ingenieria Agroindustrial'),
(6, 2, 'Ingenieria Forestal'),
(7, 2, 'Ingenieria Agropecuaria'),
(8, 2, 'Tecnologia en Agroindustria'),
(9, 3, 'Enfermeria'),
(10, 3, 'Fisioterapia'),
(11, 3, 'Fonoaudiologia'),
(12, 3, 'Medicina'),
(13, 4, 'Contaduria Publica'),
(14, 4, 'Administracion de Empresas'),
(15, 4, 'Economia'),
(16, 4, 'Turismo'),
(17, 4, 'Tecnologia en Administracion Financiera'),
(18, 5, 'Antropologia'),
(19, 5, 'Filosofia'),
(20, 5, 'Geografia'),
(21, 5, 'Historia'),
(22, 5, 'Licenciatura en Español y Literatura'),
(23, 5, 'Licenciatura en Etnoeducacion'),
(24, 5, 'Licenciatura en Lenguas Modernas Ingles-Frances'),
(25, 6, 'Biologia'),
(26, 6, 'Licenciatura en Educacion Basica con Enfasis en Educacion Fisica, Recreacion y Deportes'),
(27, 6, 'Licenciatura en Educacion Basica con Enfasis en Ciencias Naturales y Educacion Ambiental'),
(28, 6, 'Licenciatura en Educacion Basica con Enfasis en Lengua Castellana e Ingles'),
(29, 6, 'Licenciatura en Educacion Basica con Enfasis en Educacion Artistica'),
(30, 6, 'Ingenieria Fisica'),
(31, 6, 'Licenciatura en Matematicas'),
(32, 6, 'Matematicas'),
(33, 6, 'Quimica'),
(34, 7, 'Ciencia Politica'),
(35, 7, 'Comunicacion Social'),
(36, 7, 'Derecho'),
(37, 8, 'Geotecnologia'),
(38, 8, 'Ingenieria Ambiental'),
(39, 8, 'Ingenieria Civil'),
(40, 9, 'Ingenieria Electronica y Telecomunicaciones'),
(41, 9, 'Ingenieria en Automatica Industrial'),
(42, 9, 'Ingenieria de Sistemas'),
(43, 9, 'Tecnologia en Telematica');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `programasalud`
--

CREATE TABLE IF NOT EXISTS `programasalud` (
  `id_programasalud` int(11) NOT NULL AUTO_INCREMENT,
  `costo` float NOT NULL,
  `tipo_servicio` varchar(256) NOT NULL,
  `actividad` varchar(256) NOT NULL,
  PRIMARY KEY (`id_programasalud`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE IF NOT EXISTS `rol` (
  `id_rol` int(11) NOT NULL,
  `nombre_rol` varchar(256) NOT NULL,
  PRIMARY KEY (`id_rol`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`id_rol`, `nombre_rol`) VALUES
(1, 'estudiante'),
(3, 'administrador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `contrasena` varchar(256) NOT NULL,
  `email` varchar(256) NOT NULL,
  PRIMARY KEY (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
--
-- Volcado de datos para la tabla `usuario`
--
INSERT INTO `usuario` (`id_usuario`, `email`, `contrasena`) VALUES
(12,'alexis@gmail.com', '1496aa696d9d35aa2c23b0f1ef3020df7f26f869'),
(13,'alejo491@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b');

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `atiende`
--
ALTER TABLE `atiende`
  ADD CONSTRAINT `fk_atiende_atiende2_personal` FOREIGN KEY (`id_personalsalud`) REFERENCES `personalsalud` (`id_personalsalud`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_atiende_atiende_programa` FOREIGN KEY (`id_programasalud`) REFERENCES `programasalud` (`id_programasalud`) ON DELETE CASCADE;

--
-- Filtros para la tabla `cita`
--
ALTER TABLE `cita`
  ADD CONSTRAINT `fk_cita_cita3_personal` FOREIGN KEY (`id_personalsalud`) REFERENCES `personalsalud` (`id_personalsalud`),
  ADD CONSTRAINT `fk_cita_cita2_programa` FOREIGN KEY (`id_programasalud`) REFERENCES `programasalud` (`id_programasalud`),
  ADD CONSTRAINT `fk_cita_cita_estudian` FOREIGN KEY (`id_estudiante`) REFERENCES `estudiante` (`id_estudiante`);

--
-- Filtros para la tabla `estudiante`
--
ALTER TABLE `estudiante`
  ADD CONSTRAINT `fk_estudian_pertenece_programa` FOREIGN KEY (`id_programa`) REFERENCES `programa` (`id_programa`),
  ADD CONSTRAINT `fk_estudian_reference_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);

--
-- Filtros para la tabla `horarioatencion`
--
ALTER TABLE `horarioatencion`
  ADD CONSTRAINT `fk_horarioa_tiene_2_personal` FOREIGN KEY (`id_personalsalud`) REFERENCES `personalsalud` (`id_personalsalud`) ON DELETE CASCADE;

--
-- Filtros para la tabla `personalsalud`
--
ALTER TABLE `personalsalud`
  ADD CONSTRAINT `fk_personal_asignado_consulto` FOREIGN KEY (`id_consultorio`) REFERENCES `consultorio` (`id_consultorio`);

--
-- Filtros para la tabla `posee`
--
ALTER TABLE `posee`
  ADD CONSTRAINT `fk_posee_posee2_rol` FOREIGN KEY (`id_rol`) REFERENCES `rol` (`id_rol`),
  ADD CONSTRAINT `fk_posee_posee_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);

--
-- Filtros para la tabla `programa`
--
ALTER TABLE `programa`
  ADD CONSTRAINT `fk_programa_tiene_facultad` FOREIGN KEY (`id_facultad`) REFERENCES `facultad` (`id_facultad`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
