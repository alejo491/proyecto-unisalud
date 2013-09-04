-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 01-09-2013 a las 22:12:05
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
  `id_servicio` int(11) NOT NULL,
  `id_medico` int(11) NOT NULL,
  PRIMARY KEY (`id_servicio`,`id_medico`),
  KEY `fk_atiende_atiende2_medico` (`id_medico`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
 
-- --------------------------------------------------------
 
--
-- Estructura de tabla para la tabla `cita`
--
 
CREATE TABLE IF NOT EXISTS `cita` (
  `id_usuario` int(11) NOT NULL,
  `id_estudiante` varchar(10) NOT NULL,
  `id_servicio` int(11) NOT NULL,
  `id_medico` int(11) NOT NULL,
  `dia` mediumtext NOT NULL,
  `hora_inicio` int(11) NOT NULL,
  `hora_fin` int(11) NOT NULL,
  `confirmado` smallint(6) NOT NULL,
  PRIMARY KEY (`id_usuario`,`id_estudiante`,`id_servicio`,`id_medico`),
  KEY `fk_cita_cita2_servicio` (`id_servicio`),
  KEY `fk_cita_cita3_medico` (`id_medico`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
 
-- --------------------------------------------------------
 
--
-- Estructura de tabla para la tabla `estudiante`
--
 
CREATE TABLE IF NOT EXISTS `estudiante` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `id_estudiante` varchar(10) NOT NULL,
  `id_programa` int(11) NOT NULL,
  `contrasena` varchar(256) NOT NULL,
  `email` varchar(256) NOT NULL,
  `tipo_identificacion` varchar(20) NOT NULL,
  `numero_identificacion` varchar(16) NOT NULL,
  `primer_nombre` varchar(256) NOT NULL,
  `segundo_nombre` varchar(256) DEFAULT NULL,
  `primer_apellido` varchar(256) NOT NULL,
  `segundo_apellido` varchar(256) NOT NULL,
  `genero` varchar(10) NOT NULL,
  PRIMARY KEY (`id_usuario`,`id_estudiante`),
  KEY `fk_estudian_pertenece_programa` (`id_programa`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
 
-- --------------------------------------------------------
 
--
-- Estructura de tabla para la tabla `facultad`
--
 
CREATE TABLE IF NOT EXISTS `facultad` (
  `id_facultad` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_facultad` varchar(256) NOT NULL,
  PRIMARY KEY (`id_facultad`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
 
-- --------------------------------------------------------
 
--
-- Estructura de tabla para la tabla `horarioatencion`
--
 
CREATE TABLE IF NOT EXISTS `horarioatencion` (
  `id_agenda` int(11) NOT NULL AUTO_INCREMENT,
  `id_medico` int(11) NOT NULL,
  `dia` mediumtext NOT NULL,
  `hora_inicial` time NOT NULL,
  `hora_final` time NOT NULL,
  PRIMARY KEY (`id_agenda`),
  KEY `fk_horarioa_tiene_2_medico` (`id_medico`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
 
-- --------------------------------------------------------
 
--
-- Estructura de tabla para la tabla `medico`
--
 
CREATE TABLE IF NOT EXISTS `medico` (
  `id_medico` int(11) NOT NULL AUTO_INCREMENT,
  `numero_tarjeta` varchar(32) NOT NULL,
  `identificacion` varchar(16) NOT NULL,
  `nombre_medico` varchar(256) NOT NULL,
  `especialidad` varchar(256) NOT NULL,
  PRIMARY KEY (`id_medico`)
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
 
-- --------------------------------------------------------
 
--
-- Estructura de tabla para la tabla `rol`
--
 
CREATE TABLE IF NOT EXISTS `rol` (
  `id_rol` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_rol` varchar(256) NOT NULL,
  PRIMARY KEY (`id_rol`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
 
-- --------------------------------------------------------
 
--
-- Estructura de tabla para la tabla `servicio`
--
 
CREATE TABLE IF NOT EXISTS `servicio` (
  `id_servicio` int(11) NOT NULL AUTO_INCREMENT,
  `costo` float NOT NULL,
  `tipo_servicio` varchar(256) NOT NULL,
  `actividad` varchar(256) NOT NULL,
  PRIMARY KEY (`id_servicio`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
 
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
-- Restricciones para tablas volcadas
--
 
--
-- Filtros para la tabla `atiende`
--
ALTER TABLE `atiende`
  ADD CONSTRAINT `fk_atiende_atiende2_medico` FOREIGN KEY (`id_medico`) REFERENCES `medico` (`id_medico`),
  ADD CONSTRAINT `fk_atiende_atiende_servicio` FOREIGN KEY (`id_servicio`) REFERENCES `servicio` (`id_servicio`);
 
--
-- Filtros para la tabla `cita`
--
ALTER TABLE `cita`
  ADD CONSTRAINT `fk_cita_cita3_medico` FOREIGN KEY (`id_medico`) REFERENCES `medico` (`id_medico`),
  ADD CONSTRAINT `fk_cita_cita2_servicio` FOREIGN KEY (`id_servicio`) REFERENCES `servicio` (`id_servicio`),
  ADD CONSTRAINT `fk_cita_cita_estudian` FOREIGN KEY (`id_usuario`, `id_estudiante`) REFERENCES `estudiante` (`id_usuario`, `id_estudiante`);
 
--
-- Filtros para la tabla `estudiante`
--
ALTER TABLE `estudiante`
  ADD CONSTRAINT `fk_estudian_inheritan_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`),
  ADD CONSTRAINT `fk_estudian_pertenece_programa` FOREIGN KEY (`id_programa`) REFERENCES `programa` (`id_programa`);
 
--
-- Filtros para la tabla `horarioatencion`
--
ALTER TABLE `horarioatencion`
  ADD CONSTRAINT `fk_horarioa_tiene_2_medico` FOREIGN KEY (`id_medico`) REFERENCES `medico` (`id_medico`);
 
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

INSERT INTO `usuario` (`id_usuario`, `email`, `contrasena`) VALUES
(12,'alexis@gmail.com', '147258'),
(13,'alejo491@gmail.com', '123456');

INSERT INTO `rol` (`id_rol`, `nombre_rol`) VALUES
(3,'administrador'),
(1,'estudiante');

INSERT INTO `posee` (`id_usuario`, `id_rol`) VALUES
(12,1),
(13,3);