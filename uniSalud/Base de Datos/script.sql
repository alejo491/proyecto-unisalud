-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generaciÃ³n: 21-10-2013 a las 06:09:33
-- VersiÃ³n del servidor: 5.5.24-log
-- VersiÃ³n de PHP: 5.3.13

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


INSERT INTO `atiende` (`id_programasalud`,`id_personalsalud`) VALUES
(7, 6),
(8, 6),
(2, 7),
(3, 8),
(4, 8),
(5, 9);
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cita`
--

CREATE TABLE IF NOT EXISTS `cita` (
  `id_estudiante` int(11) NOT NULL,
  `id_programasalud` int(11) NOT NULL,
  `id_personalsalud` int(11) NOT NULL,
  `dia` date NOT NULL,
  `hora_inicio` time NOT NULL,
  `hora_fin` time NOT NULL,
  `estado` smallint(6) NOT NULL,
  `observaciones` mediumtext,
  PRIMARY KEY (`id_estudiante`,`id_programasalud`,`id_personalsalud`),
  KEY `fk_cita_cita2_programa` (`id_programasalud`),
  KEY `fk_cita_cita3_personal` (`id_personalsalud`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `cita`
--


INSERT INTO `cita` (`id_estudiante`, `id_programasalud`, `id_personalsalud`, `dia`, `hora_inicio`, `hora_fin`, `estado`, `observaciones`) VALUES
(78964, 2, 7, '2013-12-19', '00:00:13', '00:00:13', 2, '..'),
(78964, 7, 6, '2013-12-20', '00:00:12', '00:00:13', 2, '...'),
(98776, 3, 8, '2013-12-21', '00:00:12', '00:00:12', 2, '..'),
(98776, 8, 6, '2014-01-06', '07:10:00', '07:30:00', 0, '123'),
(123852, 4, 8, '2013-12-23', '00:00:13', '00:00:13', 2, '....'),
(46081021, 2, 7, '2014-01-21', '07:40:00', '08:00:00', 2, '....'),
(46081022, 2, 7, '2014-01-21', '07:00:00', '07:20:00', 0, '....'),
(46081023, 2, 7, '2014-01-21', '07:20:00', '07:40:00', 2, '....'),
(46081024, 2, 7, '2014-01-21', '08:00:00', '08:20:00', 0, '...'),
(46081026, 3, 8, '2014-01-20', '12:10:00', '12:30:00', 2, '.....'),
(46081027, 3, 8, '2014-01-20', '13:10:00', '13:30:00', 2, '...'),
(46081098, 4, 8, '2014-01-04', '00:00:12', '00:00:13', 2, 'asdfg'),
(46081098, 8, 6, '2013-12-25', '00:00:14', '00:00:14', 2, '....'),
(46081099, 3, 8, '2014-01-20', '12:50:00', '13:10:00', 2, '.....'),
(741852963, 2, 7, '2013-12-24', '00:00:12', '00:00:12', 2, '..');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consultorio`
--

CREATE TABLE IF NOT EXISTS `consultorio` (
  `id_consultorio` int(11) NOT NULL AUTO_INCREMENT,
  `numero_consultorio` varchar(100) NOT NULL,
  `descripcion` varchar(124) DEFAULT 'ninguna descripcion',
  PRIMARY KEY (`id_consultorio`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------
--
-- Volcado de datos para la tabla `consultorio`
-- 
INSERT INTO `consultorio` (`id_consultorio`, `numero_consultorio`, `descripcion`) VALUES
(1, '1','Medicina General'),
(2, '2','Odontologia'),
(3, '3','Enfermeria'),
(4, '4','Sicologia');
--
-- Estructura de tabla para la tabla `estudiante`
--

CREATE TABLE IF NOT EXISTS `estudiante` (
  `id_estudiante` int(11) NOT NULL AUTO_INCREMENT,
  `id_programa` int(11) NOT NULL,
 
  `primer_nombre` varchar(256) NOT NULL,
  `segundo_nombre` varchar(256) DEFAULT NULL,
  `primer_apellido` varchar(256) NOT NULL,
  `segundo_apellido` varchar(256) NOT NULL,
  `identificacion` varchar(16) NOT NULL,
  `tipo_identificacion` varchar(20) NOT NULL,
  `genero` varchar(10) NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  PRIMARY KEY (`id_estudiante`),
  KEY `fk_estudian_pertenece_programa` (`id_programa`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=46091095 ;


INSERT INTO `estudiante` (`id_estudiante`, `id_programa`, `primer_nombre`, `segundo_nombre`, `primer_apellido`, `segundo_apellido`, `identificacion`, `tipo_identificacion`, `genero`, `fecha_nacimiento`) VALUES
(78964, 7, 'luisa', '', 'lopez', '', '23146894', 'Cedula de Ciudadania', 'f', '2013-12-01'),
(98776, 3, 'jeni', '', 'duque', '', '0987890', 'Cedula de Ciudadania', 'm', '2008-12-10'),
(123456, 42, 'luis', '', 'jimenez', '', '10000', 'Tarjeta de Identidad', 'm', '2013-12-02'),
(123852, 12, 'edwar', '', 'perez', 'muñoz', '423561036', 'Cedula de Ciudadania', 'm', '2013-12-02'),
(46081098, 42, 'edwar', '', 'giraldo', '', '1061741945', 'Cedula de ciudadania', 'm', '1991-10-10'),
(96000000, 19, 'maria', '', 'muñoz', '', '45630258964', 'Cedula de Ciudadania', 'f', '2013-12-02'),
(741852963, 3, 'jorge', '', 'narvaez', '', '1324653', 'Cedula de Ciudadania', 'm', '2013-12-02'),
(2147483647, 19, 'luisa', '', 'luisa', '', '8790456', 'Cedula de Ciudadania', 'f', '2013-12-01'),
(46081099, 19, 'pedro', '', 'gomez', '', '123333', 'Cedula de Ciudadania', 'm', '2000-12-01'),
(46081020, 19, 'juan', '', 'perez', '', '123334', 'Cedula de Ciudadania', 'm', '1995-10-01'),
(46081021, 19, 'antonio', '', 'perez', '', '123335', 'Cedula de Ciudadania', 'm', '1994-11-11'),
(46081022, 12, 'ferney', '', 'rendon', '', '123336', 'Cedula de Ciudadania', 'm', '1990-10-01'),
(46081023, 12, 'juan', '', 'lopez', '', '123337', 'Cedula de Ciudadania', 'm', '1995-01-30'),
(46081024, 19, 'jenifer', '', 'perez', '', '124034', 'Cedula de Ciudadania', 'f', '1993-10-01'),
(46081025, 19, 'jorge', '', 'giraldo', '', '123340', 'Cedula de Ciudadania', 'm', '1995-10-01'),
(46081026, 19, 'william', '', 'marin', '', '123341', 'Cedula de Ciudadania', 'm', '1995-10-01'),
(46081027, 19, 'mario', '', 'gomez', '', '123342', 'Cedula de Ciudadania', 'm', '1995-10-01');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;


--
-- Volcado de datos para la tabla `horarioatencion`
--

INSERT INTO `horarioatencion` (`id_agenda`, `id_personalsalud`, `dia`, `hora_inicial`, `hora_final`) VALUES
(6, 6, 'lunes', '07:10:00', '08:00:00'),
(7, 6, 'miercoles', '13:00:00', '16:00:00'),
(8, 6, 'viernes', '07:00:00', '13:15:00'),
(9, 7, 'lunes', '09:00:00', '12:00:00'),
(10, 7, 'martes', '07:00:00', '14:00:00'),
(11, 7, 'jueves', '13:00:00', '17:20:00'),
(12, 8, 'lunes', '12:10:00', '14:00:00'),
(13, 8, 'sabado', '12:00:00', '16:00:00'),
(14, 9, 'lunes', '07:10:00', '13:00:00'),
(15, 9, 'martes', '14:00:00', '18:00:00'),
(16, 9, 'miercoles', '07:00:00', '12:00:00'),
(17, 9, 'viernes', '14:00:00', '17:00:00');
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personalsalud`
--

CREATE TABLE IF NOT EXISTS `personalsalud` (
  `id_personalsalud` int(11) NOT NULL AUTO_INCREMENT,
  `id_consultorio` int(11) NOT NULL,
  
  `primer_nombre` varchar(256) NOT NULL,
  `segundo_nombre` varchar(256) DEFAULT NULL,
  `primer_apellido` varchar(256) NOT NULL,
  `segundo_apellido` varchar(256) NOT NULL,
  `identificacion` varchar(16) NOT NULL,
  `tipo_identificacion` varchar(20) NOT NULL,
  `numero_tarjeta` varchar(32) NOT NULL,
  `especialidad` varchar(256) NOT NULL,
  PRIMARY KEY (`id_personalsalud`),
  KEY `fk_personal_asignado_consulto` (`id_consultorio`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

INSERT INTO `personalsalud` (`id_personalsalud`, `id_consultorio`, `primer_nombre`, `segundo_nombre`, `primer_apellido`, `segundo_apellido`, `identificacion`, `tipo_identificacion`, `numero_tarjeta`, `especialidad`) VALUES
(6, 3, 'Margarita', '', 'Alegria', 'Ramirez', '25000123', 'Cedula de Ciudadania', '15762258', 'Enfermeria'),
(7, 2, 'Alvaro', 'Fernando', 'Martinez', 'Pabon', '250234123', 'Cedula de Ciudadania', '10962758', 'Odontologo'),
(8, 2, 'Heli', 'Francisco', 'Forero', '', '1061234123', 'Cedula de Ciudadania', '16022758', 'Odontologo'),
(9, 1, 'Cristian', '', 'Narvaez', '', '5632896', 'Cedula de Ciudadania', '85236415', 'Medico General'),
(10, 4, 'Dayana', '', 'Muñoz', '', '1256328', 'Cedula de Ciudadania', '106153264785', 'Sicologo');
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
(12, 1),
(14, 1),
(15, 1),
(16, 1),
(17, 1),
(18, 1),
(19, 1),
(20, 1),
(21, 1),
(22, 1),
(23, 1),
(24, 1),
(25, 1),
(26, 1),
(27, 1),
(13, 3);

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
(1, 1, 'DiseÃ±o Grafico'),
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
(22, 5, 'Licenciatura en EspaÃ±ol y Literatura'),
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;


INSERT INTO `programasalud` (`costo`, `tipo_servicio`, `actividad`) VALUES
(6800,'Consulta Urgencias','Odontologia'),
(3400,'Radiografias Intra orales','Odontologia'),
(6800,'Obturacion de una superficie en amalgama','Odontologia'),
(5800,'Consulta Medica General','Procedimientos Medico y de Enfermeria'),
(5800,'Cosulta Psicologica','Procedimientos Medico y de Enfermeria'),
(8000,'Lavado de oido','Procedimientos Medico y de Enfermeria'),
(2400,'Inyectologia','Procedimientos Medico y de Enfermeria'),
(7400,'Citologia','Procedimientos Medico y de Enfermeria');
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
  `id_persona` int(11) DEFAULT '-1',
  `contrasena` varchar(256) NOT NULL,
  `email` varchar(256) NOT NULL,
  PRIMARY KEY (`id_usuario`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Volcado de datos para la tabla `usuario`
--


INSERT INTO `usuario` (`id_usuario`, `id_persona`, `contrasena`, `email`) VALUES
(12, -1, '7c4a8d09ca3762af61e59520943dc26494f8941b', 'alexis@gmail.com'),
(13, -1, '7c4a8d09ca3762af61e59520943dc26494f8941b', 'alejo491@gmail.com'),
(14, 46081098, '7c4a8d09ca3762af61e59520943dc26494f8941b', 'edwar@gmail.com'),
(15, 2147483647, '7c4a8d09ca3762af61e59520943dc26494f8941b', 'luis@unicauca.edu.co'),
(16, 123456, '7c4a8d09ca3762af61e59520943dc26494f8941b', 'luis_perez@gmail.com'),
(17, 98776, '7c4a8d09ca3762af61e59520943dc26494f8941b', '0987@unicauca.edu.co'),
(18, 46081020, '7c4a8d09ca3762af61e59520943dc26494f8941b', 'juanperez@GMAIL.COM'),
(19, 46081022, '7c4a8d09ca3762af61e59520943dc26494f8941b', 'ferney@gmail.com'),
(20, 46081023, '7c4a8d09ca3762af61e59520943dc26494f8941b', 'juanlopez@gmail.com'),
(21, 123852, '7c4a8d09ca3762af61e59520943dc26494f8941b', 'ljo@unicauca.edu.co'),
(22, 46081024, '7c4a8d09ca3762af61e59520943dc26494f8941b', 'pepito@hotmail.com'),
(23, 46081099, '7c4a8d09ca3762af61e59520943dc26494f8941b', 'pedorgomez@unicauca.edu.co'),
(24, 96000000, '7c4a8d09ca3762af61e59520943dc26494f8941b', 'maria_maria@gmail.com'),
(25, 741852963, '7c4a8d09ca3762af61e59520943dc26494f8941b', 'lui@hotmail.com'),
(26, 46081027, '7c4a8d09ca3762af61e59520943dc26494f8941b', 'mariogomez@hotmail.com'),
(27, 78964, '7c4a8d09ca3762af61e59520943dc26494f8941b', 'l@gmail.com');
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
  ADD CONSTRAINT `fk_cita_cita2_programa` FOREIGN KEY (`id_programasalud`) REFERENCES `programasalud` (`id_programasalud`) ,
  ADD CONSTRAINT `fk_cita_cita3_personal` FOREIGN KEY (`id_personalsalud`) REFERENCES `personalsalud` (`id_personalsalud`) ,
  ADD CONSTRAINT `fk_cita_cita_estudian` FOREIGN KEY (`id_estudiante`) REFERENCES `estudiante` (`id_estudiante`);

--
-- Filtros para la tabla `estudiante`
--
ALTER TABLE `estudiante`
  ADD CONSTRAINT `fk_estudian_pertenece_programa` FOREIGN KEY (`id_programa`) REFERENCES `programa` (`id_programa`);

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
