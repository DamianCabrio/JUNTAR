-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-06-2020 a las 05:07:57
-- Versión del servidor: 10.3.16-MariaDB
-- Versión de PHP: 7.3.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


-- #######################################################################################################################
-- #######################################################################################################################
--
-- Base de datos: `pwa_juntar`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria_evento`
--

CREATE TABLE `categoria_evento` (
  `idCategoriaEvento` tinyint(4) NOT NULL,
  `descripcionCategoria` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_evento`
--

CREATE TABLE `estado_evento` (
  `idEstadoEvento` tinyint(4) NOT NULL,
  `descripcionEstado` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modalidad_evento`
--

CREATE TABLE `modalidad_evento` (
  `idModalidadEvento` tinyint(4) NOT NULL,
  `descripcionModalidad` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evento`
--

CREATE TABLE evento (
  idEvento bigint(20) NOT NULL,
  idUsuario bigint(20) NOT NULL,
  idCategoriaEvento tinyint(4) NOT NULL,
  idEstadoEvento tinyint(4) NOT NULL,
  idModalidadEvento tinyint(4) NOT NULL,
  nombreEvento varchar(200) NOT NULL,
  nombreCortoEvento varchar(100) NOT NULL,
  descripcionEvento varchar(800) NOT NULL,
  lugar varchar(200) NOT NULL,
  fechaInicioEvento date NOT NULL,
  fechaFinEvento date NOT NULL,
  imgFlyer varchar(200) DEFAULT NULL,
  imgLogo varchar(200) DEFAULT NULL,
  capacidad smallint(6) NULL,
  preInscripcion tinyint(1) NOT NULL,
  fechaLimiteInscripcion date DEFAULT NULL,
  codigoAcreditacion varchar(100) DEFAULT NULL,
  fechaCreacionEvento date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inscripcion`
--

CREATE TABLE `inscripcion` (
  `idInscripcion` bigint(20) NOT NULL,
  `idUsuario` bigint(20) NOT NULL,
  `idEvento` bigint(20) NOT NULL,
  `estado` tinyint(1) NOT NULL,
  `fechaPreInscripcion` date NOT NULL,
  `fechaInscripcion` date DEFAULT NULL,
  `acreditacion` tinyint(1) DEFAULT NULL,
  `certificado` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permiso`
--

CREATE TABLE `permiso` (
  `name` varchar(64) NOT NULL,
  `type` smallint(6) NOT NULL,
  `description` text DEFAULT NULL,
  `rule_name` varchar(64) DEFAULT NULL,
  `data` blob DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `regla`
--

CREATE TABLE `regla` (
  `name` varchar(64) NOT NULL,
  `data` blob DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permiso_rol`
--

CREATE TABLE `permiso_rol` (
  `parent` varchar(64) NOT NULL,
  `child` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `presentacion`
--

CREATE TABLE `presentacion` (
  `idPresentacion` bigint(20) NOT NULL,
  `idEvento` bigint(20) NOT NULL,
  `tituloPresentacion` varchar(200) NOT NULL,
  `descripcionPresentacion` varchar(800) NOT NULL,
  `diaPresentacion` date NOT NULL,
  `horaInicioPresentacion` time NOT NULL,
  `horaFinPresentacion` time NOT NULL,
  `linkARecursos` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `presentacion_expositor`
--

CREATE TABLE `presentacion_expositor` (
  `idExpositor` bigint(20) NOT NULL,
  `idPresentacion` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `idUsuario` bigint(20) NOT NULL,
  `nombre` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `apellido` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `dni` int(11) DEFAULT NULL,
  `pais` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `provincia` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `localidad` varchar(70) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` smallint(6) NOT NULL DEFAULT 9,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `verification_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `imagen_perfil`
--

CREATE TABLE `imagen_perfil` (
  `idUsuario` bigint(20) NOT NULL,
  `rutaImagenPerfil` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `usuario_rol`
--

CREATE TABLE `usuario_rol` (
  `item_name` varchar(64) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `created_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitud_aval`
--

CREATE TABLE `solicitud_aval` (
  `idSolicitudAval` bigint(20) NOT NULL,
  `idEvento` bigint(20) NOT NULL,
  `fechaSolicitud` datetime NOT NULL,
  `tokenSolicitud` varchar(200) NOT NULL,
  `fechaRevision` datetime DEFAULT NULL,
  `avalado` tinyint(1) DEFAULT NULL,
  `validador` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pregunta`
--

CREATE TABLE `pregunta` (
  `id` bigint(20) NOT NULL,
  `idevento` bigint(20) NOT NULL,
  `tipo` enum('1','2','3') NOT NULL,
  `descripcion` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `respuesta`
--

CREATE TABLE `respuesta` (
  `id` bigint(20) NOT NULL,
  `idpregunta` bigint(20) NOT NULL,
  `idinscripcion` bigint(20) NOT NULL,
  `respuesta` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Estructura de tabla para la tabla `solicitud_aval`
--

CREATE TABLE `solicitud_aval` (
  `idSolicitudAval` bigint(20) NOT NULL,
  `idEvento` bigint(20) NOT NULL,
  `fechaSolicitud` datetime NOT NULL,
  `tokenSolicitud` varchar(200) DEFAULT NULL,
  `fechaRevision` datetime DEFAULT NULL,
  `avalado` tinyint(1) DEFAULT NULL,
  `validador` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- #######################################################################################################################
-- #######################################################################################################################
--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categoria_evento`
--
ALTER TABLE `categoria_evento`
  ADD PRIMARY KEY (`idCategoriaEvento`);

--
-- Indices de la tabla `estado_evento`
--
ALTER TABLE `estado_evento`
  ADD PRIMARY KEY (`idEstadoEvento`);

--
-- Indices de la tabla `evento`
--
ALTER TABLE `evento`
  ADD PRIMARY KEY (`idEvento`),
  ADD KEY `idUsuario` (`idUsuario`),
  ADD KEY `idCategoria` (`idCategoriaEvento`),
  ADD KEY `idEstadoEvento` (`idEstadoEvento`),
  ADD KEY `idModalidadEvento` (`idModalidadEvento`);

--
-- Indices de la tabla `inscripcion`
--
ALTER TABLE `inscripcion`
  ADD PRIMARY KEY (`idInscripcion`),
  ADD KEY `idUsuario` (`idUsuario`),
  ADD KEY `idEvento` (`idEvento`);

--
-- Indices de la tabla `modalidad_evento`
--
ALTER TABLE `modalidad_evento`
  ADD PRIMARY KEY (`idModalidadEvento`);

--
-- Indices de la tabla `permiso`
--
ALTER TABLE `permiso`
  ADD PRIMARY KEY (`name`),
  ADD KEY `rule_name` (`rule_name`),
  ADD KEY `type` (`type`);

--
-- Indices de la tabla `permiso_rol`
--
ALTER TABLE `permiso_rol`
  ADD PRIMARY KEY (`parent`,`child`),
  ADD KEY `child` (`child`);

--
-- Indices de la tabla `presentacion`
--
ALTER TABLE `presentacion`
  ADD PRIMARY KEY (`idPresentacion`),
  ADD KEY `idEvento` (`idEvento`);

--
-- Indices de la tabla `presentacion_expositor`
--
ALTER TABLE `presentacion_expositor`
  ADD PRIMARY KEY (`idExpositor`,`idPresentacion`),
  ADD KEY `idExpositor` (`idExpositor`),
  ADD KEY `idPresentacion` (`idPresentacion`);

--
-- Indices de la tabla `regla`
--
ALTER TABLE `regla`
  ADD PRIMARY KEY (`name`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idUsuario`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `password_reset_token` (`password_reset_token`);

--
-- Indices de la tabla `imagen_perfil`
--
ALTER TABLE `imagen_perfil`
  ADD PRIMARY KEY (`idUsuario`,`rutaImagenPerfil`),
  ADD UNIQUE KEY `rutaImagenPerfil` (`rutaImagenPerfil`),
  ADD KEY `idUsuario` (`idUsuario`);

--
-- Indices de la tabla `usuario_rol`
--
ALTER TABLE `usuario_rol`
  ADD PRIMARY KEY (`item_name`,`user_id`),
  ADD KEY `usuario_rol_usuario_id_idx` (`user_id`),
  ADD KEY `item_name` (`item_name`);

--
-- Indices de la tabla `pregunta`
--
ALTER TABLE `pregunta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idevento` (`idevento`);

--
-- Indices de la tabla `respuesta`
--
ALTER TABLE `respuesta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idpregunta` (`idpregunta`),
  ADD KEY `idinscripcion` (`idinscripcion`);

--
-- Indices de la tabla `solicitud_aval`
--
ALTER TABLE `solicitud_aval`
  ADD PRIMARY KEY (`idSolicitudAval`) USING BTREE,
  ADD UNIQUE KEY `idEvento` (`idEvento`) USING BTREE,
  ADD KEY `validador` (`validador`) USING BTREE;



ALTER TABLE `solicitud_aval`
  ADD PRIMARY KEY (`idSolicitudAval`) USING BTREE,
  ADD UNIQUE KEY `idEvento` (`idEvento`) USING BTREE,
  ADD KEY `validador` (`validador`) USING BTREE;

-- #######################################################################################################################
-- #######################################################################################################################
--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categoria_evento`
--
ALTER TABLE `categoria_evento`
  MODIFY `idCategoriaEvento` tinyint(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `estado_evento`
--
ALTER TABLE `estado_evento`
  MODIFY `idEstadoEvento` tinyint(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `evento`
--
ALTER TABLE `evento`
  MODIFY `idEvento` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `inscripcion`
--
ALTER TABLE `inscripcion`
  MODIFY `idInscripcion` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `modalidad_evento`
--
ALTER TABLE `modalidad_evento`
  MODIFY `idModalidadEvento` tinyint(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `presentacion`
--
ALTER TABLE `presentacion`
  MODIFY `idPresentacion` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idUsuario` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pregunta`
--
ALTER TABLE `pregunta`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `respuesta`
--
ALTER TABLE `respuesta`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

ALTER TABLE `solicitud_aval`
  MODIFY `idSolicitudAval` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

-- #######################################################################################################################
-- #######################################################################################################################
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `evento`
--
ALTER TABLE `evento`
  ADD CONSTRAINT `evento_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`),
  ADD CONSTRAINT `evento_ibfk_2` FOREIGN KEY (`idCategoriaEvento`) REFERENCES `categoria_evento` (`idCategoriaEvento`),
  ADD CONSTRAINT `evento_ibfk_3` FOREIGN KEY (`idModalidadEvento`) REFERENCES `modalidad_evento` (`idModalidadEvento`),
  ADD CONSTRAINT `evento_ibfk_4` FOREIGN KEY (`idEstadoEvento`) REFERENCES `estado_evento` (`idEstadoEvento`);

--
-- Filtros para la tabla `inscripcion`
--
ALTER TABLE `inscripcion`
  ADD CONSTRAINT `inscripcion_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`),
  ADD CONSTRAINT `inscripcion_ibfk_2` FOREIGN KEY (`idEvento`) REFERENCES `evento` (`idEvento`);

--
-- Filtros para la tabla `permiso`
--
ALTER TABLE `permiso`
  ADD CONSTRAINT `permiso_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `regla` (`name`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `permiso_rol`
--
ALTER TABLE `permiso_rol`
  ADD CONSTRAINT `permiso_rol_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `permiso` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `permiso_rol_ibfk_2` FOREIGN KEY (`child`) REFERENCES `permiso` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `presentacion`
--
ALTER TABLE `presentacion`
  ADD CONSTRAINT `presentacion_ibfk_1` FOREIGN KEY (`idEvento`) REFERENCES `evento` (`idEvento`);

--
-- Filtros para la tabla `presentacion_expositor`
--
ALTER TABLE `presentacion_expositor`
  ADD CONSTRAINT `presentacion_expositor_ibfk_1` FOREIGN KEY (`idExpositor`) REFERENCES `usuario` (`idUsuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `presentacion_expositor_ibfk_2` FOREIGN KEY (`idPresentacion`) REFERENCES `presentacion` (`idPresentacion`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `imagen_perfil`
--
ALTER TABLE `imagen_perfil`
  ADD CONSTRAINT `imagen_perfil_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`) ON DELETE CASCADE ON UPDATE CASCADE;
--
-- Filtros para la tabla `usuario_rol`
--
ALTER TABLE `usuario_rol`
  ADD CONSTRAINT `usuario_rol_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `permiso` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `usuario_rol_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `usuario` (`idUsuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `pregunta`
--
ALTER TABLE `pregunta`
  ADD CONSTRAINT `pregunta_ibfk_1` FOREIGN KEY (`idevento`) REFERENCES `evento` (`idEvento`);

--
-- Filtros para la tabla `respuesta`
--
ALTER TABLE `respuesta`
  ADD CONSTRAINT `respuesta_ibfk_1` FOREIGN KEY (`idpregunta`) REFERENCES `pregunta` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `respuesta_ibfk_2` FOREIGN KEY (`idinscripcion`) REFERENCES `inscripcion` (`idInscripcion`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `solicitud_aval`
  ADD CONSTRAINT `solicitud_aval_ibfk_1` FOREIGN KEY (`idEvento`) REFERENCES `evento` (`idEvento`),
  ADD CONSTRAINT `solicitud_aval_ibfk_2` FOREIGN KEY (`validador`) REFERENCES `usuario` (`idUsuario`) ON DELETE SET NULL ON UPDATE SET NULL;
COMMIT;
-- #######################################################################################################################
-- #######################################################################################################################

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
