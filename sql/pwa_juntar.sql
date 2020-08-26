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

create database pwa_juntar;

use pwa_juntar;


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
  descripcionEvento varchar(2000) NOT NULL,
  lugar varchar(200) NOT NULL,
  fechaInicioEvento date NOT NULL,
  fechaFinEvento date NOT NULL,
  avalado tinyint(4) NOT NULL DEFAULT 0,
  eventoToken varchar(255) DEFAULT NULL,
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
  `descripcionPresentacion` varchar(2000) NOT NULL,
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
  `respuesta` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `imagen_evento`
--

CREATE TABLE `imagen_evento` (
  `idImagenEvento` bigint(20) NOT NULL,
  `idEvento` bigint(20) NOT NULL,
  `categoriaImagen` tinyint(4) NOT NULL,
  `rutaArchivoImagen` varchar(200) NOT NULL,
  `fechaCreacionImagen` datetime NOT NULL
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

--
-- Indices de la tabla `imagen_evento`
--
ALTER TABLE `imagen_evento`
  ADD PRIMARY KEY (`idImagenEvento`),
  ADD KEY `idEvento` (`idEvento`);


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

--
-- AUTO_INCREMENT de la tabla `solicitud_aval`
--
ALTER TABLE `solicitud_aval`
  MODIFY `idSolicitudAval` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `imagen_evento`
--
ALTER TABLE `imagen_evento`
  MODIFY `idImagenEvento` bigint(20) NOT NULL AUTO_INCREMENT;


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
  ADD CONSTRAINT `respuesta_ibfk_1` FOREIGN KEY (`idpregunta`) REFERENCES `pregunta` (`id`),
  ADD CONSTRAINT `respuesta_ibfk_2` FOREIGN KEY (`idinscripcion`) REFERENCES `inscripcion` (`idInscripcion`);

--
-- Filtros para la tabla `solicitud_aval`
--
ALTER TABLE `solicitud_aval`
  ADD CONSTRAINT `solicitud_aval_ibfk_1` FOREIGN KEY (`idEvento`) REFERENCES `evento` (`idEvento`),
  ADD CONSTRAINT `solicitud_aval_ibfk_2` FOREIGN KEY (`validador`) REFERENCES `usuario` (`idUsuario`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Filtros para la tabla `imagen_evento`
--
ALTER TABLE `imagen_evento`
  ADD CONSTRAINT `imagen_evento_ibfk_1` FOREIGN KEY (`idEvento`) REFERENCES `evento` (`idEvento`) ON DELETE NO ACTION ON UPDATE CASCADE;

-- #######################################################################################################################
-- #######################################################################################################################
--
-- Volcado de datos para las tablas
--

--
-- Volcado de datos para la tabla `permiso`
--

INSERT INTO `permiso` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
('acreditacion/acreditacion', 2, 'FRONTEND [Registrado] - Permite a un usuario acreditarse a un evento', NULL, NULL, 1593652530, 1593652530),
('Administrador', 1, 'Rol - Superusuario Administrador', NULL, NULL, 1590382997, 1590382997),
('certificado/index', 2, 'FRONTEND [Registrado] - Permite visualizar el menú de certificados', NULL, NULL, 1593652754, 1593652754),
('certificado/preview-attendance', 2, 'FRONTEND [Registrado] - Permite visualizar el certificado de asistencia a un evento', NULL, NULL, 1593652801, 1593652801),
('certificado/preview-organizer', 2, 'FRONTEND [Organizador] - Permite visualizar el certificado de Organizador del evento', NULL, NULL, 1593652824, 1593652824),
('cuenta/cambiar-email', 2, 'FRONTEND [Registrado] - Permite cambiar el email de la cuenta a partir del token enviado al correo', NULL, NULL, 1593652391, 1593652391),
('cuenta/cambiar-email-request', 2, 'FRONTEND [Registrado] - Permite solicitar un cambio de email para la cuenta', NULL, NULL, 1593652372, 1593652372),
('cuenta/cambiar-password', 2, 'FRONTEND [Registrado] - Permite cambiar la contraseña de la cuenta', NULL, NULL, 1593652358, 1593652358),
('cuenta/desactivar-cuenta', 2, 'FRONTEND [Registrado] - Permite desactivar la cuenta de usuario', NULL, NULL, 1593652344, 1593652344),
('cuenta/editprofile', 2, 'FRONTEND [Registrado] - Permite editar la información de la cuenta', NULL, NULL, 1593652258, 1593652258),
('cuenta/mis-eventos-gestionados', 2, 'FRONTEND [Organizador] - Permite visualizar todos los eventos gestionados', NULL, NULL, 1593652294, 1593652294),
('cuenta/mis-inscripciones-a-eventos', 2, 'FRONTEND [Registrado] - Permite visualizar todos los eventos a los que se inscribió el usuario', NULL, NULL, 1593652313, 1593652313),
('cuenta/profile', 2, 'FRONTEND [Registrado] - Permite acceder al perfil de usuario para visualizar tus datos', NULL, NULL, 1593652158, 1593652158),
('cuenta/upload-profile-image', 2, 'FRONTEND [Registrado] - Permite subir una imagen de perfil', NULL, NULL, 1593652328, 1593652328),
('evento/cargar-evento', 2, 'FRONTEND [Organizador] - Permite cargar un evento a la plataforma', NULL, NULL, 1593660608, 1593660608),
('evento/cargar-expositor', 2, 'FRONTEND [Organizador] - Permite cargar expositores a las presentaciones de un evento', NULL, NULL, 1593660742, 1593660742),
('evento/confirmar-solicitud', 2, 'FRONTEND [Validador] - Permite conceder el aval de la FAI a un evento que lo haya solicitado', NULL, NULL, 1593674263, 1593674263),
('evento/crear-email', 2, 'FRONTEND [Organizador] - Permite crear un email para el evento', NULL, NULL, 1593671564, 1593671564),
('evento/crear-formulario-dinamico', 2, 'FRONTEND [Organizador] - Permite a un organizador crear un formulario dinámico para la preinscripcion', NULL, NULL, 1593661609, 1593661609),
('evento/create', 2, 'BACKEND [Administrador] - Permite crear un nuevo evento, desde el backend, en la plataforma', NULL, NULL, 1593648747, 1593648747),
('evento/denegar-solicitud', 2, 'FRONTEND [Validador] - Permite denegar el aval de la FAI a un evento que lo haya solicitado', NULL, NULL, 1593674285, 1593674285),
('evento/deshabilitar', 2, 'BACKEND [Administrador] - Permite deshabilitar un evento en la plataforma', NULL, NULL, 1593648786, 1593648786),
('evento/editar-evento', 2, 'FRONTEND [Organizador] - Permite editar un evento cargado en la plataforma', NULL, NULL, 1593660626, 1593660626),
('evento/enviar-email', 2, 'FRONTEND [Organizador] - Permite enviar un email a los participantes del evento', NULL, NULL, 1593671582, 1593671582),
('evento/enviar-email-inscriptos', 2, 'FRONTEND [Organizador] - Permite enviar un email a todos los usuarios inscriptos al evento', NULL, NULL, 1593671537, 1593671537),
('evento/enviar-solicitud-evento', 2, 'FRONTEND [Organizador] - Permite enviar una solicitud para recibir el aval de la Facultad de informática para el evento gestionado', NULL, NULL, 1593674101, 1593674101),
('evento/evento-email', 2, 'FRONTEND [Organizador] - Permite enviar un email a todos los usuarios inscriptos a un evento', NULL, NULL, 1593674897, 1593674897),
('evento/finalizar-evento', 2, 'FRONTEND [Organizador] - Permite finalizar un evento cargado en la plataforma', NULL, NULL, 1593660674, 1593660674),
('evento/habilitar', 2, 'BACKEND [Administrador] - Permite habilitar un evento en la plataforma', NULL, NULL, 1593648799, 1593648799),
('evento/index', 2, 'BACKEND [Administrador] - Permite visualizar el listado de todos los eventos registrados en la plataforma', NULL, NULL, 1593648690, 1593648690),
('evento/lista-participantes', 2, 'FRONTEND [Organizador] - Permite bajar un archivo con el listado de participantes del evento', NULL, NULL, 1593671508, 1593671508),
('evento/no-js', 2, 'FRONTEND [Registrado] - Permite a un usuario saber si tiene Javascript activado', NULL, NULL, 1593674990, 1593674990),
('evento/obtener-expositores', 2, 'FRONTEND [Organizador] - Permite obtener todos los usuarios expositores del evento', NULL, NULL, 1593671741, 1593671741),
('evento/obtener-inscriptos', 2, 'FRONTEND [Organizador] - Permite obtener el listado de todos los usuarios inscriptos del evento', NULL, NULL, 1593671642, 1593671642),
('evento/obtener-prinscriptos', 2, 'FRONTEND [Organizador] - Permite obtener todos los usuarios preinscriptos al evento', NULL, NULL, 1593671612, 1593671612),
('evento/organizar-eventos', 2, 'FRONTEND [Organizador] - Permite a un usuario visualizar todos sus eventos organizados', NULL, NULL, 1593672671, 1593672671),
('evento/publicar-evento', 2, 'FRONTEND [Organizador] - Permite publicar un evento en la plataforma (hacerlo visible al público)', NULL, NULL, 1593660644, 1593660644),
('evento/responder-formulario', 2, 'FRONTEND [Registrado] - Permite responder el formulario de un evento', NULL, NULL, 1593672611, 1593672611),
('evento/respuestas-formulario', 2, 'FRONTEND [Organizador] - Permite visualizar las respuestas del formulario de preinscripcion', NULL, NULL, 1593661580, 1593661580),
('evento/suspender-evento', 2, 'FRONTEND [Organizador] - Permite suspender un evento cargado', NULL, NULL, 1593660661, 1593660661),
('evento/update', 2, 'BACKEND [Administrador] - Permite actualizar los datos de un evento registrado', NULL, NULL, 1593648763, 1593648763),
('evento/ver-evento', 2, 'FRONTEND [Registrado] - Permite visualizar un evento', NULL, NULL, 1593672598, 1593672598),
('evento/verificar-solicitud', 2, 'FRONTEND [Validador] - Permite verificar una solicitud para obtener el aval de la FAI', NULL, NULL, 1593674239, 1593674239),
('evento/view', 2, 'BACKEND [Administrador] - Permite visualizar los datos de un evento particular', NULL, NULL, 1593648718, 1593648718),
('inscripcion/anular-inscripcion', 2, 'FRONTEND [Organizador] - Permite anular la inscripción de un usuario a su evento', NULL, NULL, 1593658776, 1593658776),
('inscripcion/eliminar-inscripcion', 2, 'FRONTEND [Registrado] - Permite al usuario anular su inscripción a un evento', NULL, NULL, 1593658850, 1593658850),
('inscripcion/inscribir-a-usuario', 2, 'FRONTEND [Organizador] - Permite inscribir un usuario a su evento', NULL, NULL, 1593658793, 1593658793),
('inscripcion/preinscripcion', 2, 'FRONTEND [Registrado] - Permite preinscribirse a un evento', NULL, NULL, 1593658820, 1593658820),
('modalidad-evento/create', 2, 'BACKEND [Administrador] - Permite crear una nueva modalidad de evento', NULL, NULL, 1593651768, 1593651768),
('modalidad-evento/delete', 2, 'BACKEND [Administrador] - Permite eliminar una modalidad de evento', NULL, NULL, 1593651795, 1593651795),
('modalidad-evento/index', 2, 'BACKEND [Administrador] - Permite visualizar el listado de todas las modalidades de evento que existen', NULL, NULL, 1593651738, 1593651738),
('modalidad-evento/update', 2, 'BACKEND [Administrador] - Permite actualizar los datos de una modalidad de evento', NULL, NULL, 1593651784, 1593651784),
('modalidad-evento/view', 2, 'BACKEND [Administrador] - Permite visualizar la información de una modalidad de evento', NULL, NULL, 1593651756, 1593651756),
('Organizador', 1, 'Rol - Usuario gestor de eventos', NULL, NULL, 1590382997, 1590382997),
('permission/asignar-permiso-a-rol', 2, 'BACKEND [Administrador] - Permite asignar un permiso a un rol seleccionado', NULL, NULL, 1592304078, 1592304078),
('permission/asignar-permisos', 2, 'BACKEND [Administrador] - Permite acceder a la UI para la asignación de permisos', NULL, NULL, 1592303862, 1592303862),
('permission/create-permiso', 2, 'BACKEND [Administrador] - Permite registrar un nuevo permiso', NULL, NULL, 1592304105, 1592304105),
('permission/index', 2, 'BACKEND [Administrador] - Permite visualizar el listado de todos los permisos registrados', NULL, NULL, 1593651654, 1593651654),
('permission/remove-permiso', 2, 'BACKEND [Administrador] - Permite eliminar un permiso', NULL, NULL, 1593651640, 1593651640),
('permission/ver-permiso', 2, 'BACKEND [Administrador] - Permite visualizar la información de un permiso', NULL, NULL, 1593651626, 1593651626),
('pregunta/create', 2, 'FRONTEND [Organizador] - Permite crear una pregunta para formulario de preinscripcion', NULL, NULL, 1593656131, 1593656131),
('pregunta/delete', 2, 'FRONTEND [Organizador] - Permite borrar una pregunta del formulario de preinscripcion', NULL, NULL, 1593656169, 1593656169),
('pregunta/update', 2, 'FRONTEND [Organizador] - Permite modificar una pregunta del formulario de preinscripcion', NULL, NULL, 1593656155, 1593656155),
('presentacion-expositor/delete', 2, 'FRONTEND [Organizador] - Permite eliminar un expositor de una presentación de un evento', NULL, NULL, 1593673397, 1593673397),
('presentacion-expositor/ver-expositores', 2, 'FRONTEND [Registrado] - Permite visualizar los expositores designados para una presentación de un evento', NULL, NULL, 1593674591, 1593674591),
('presentacion/borrar', 2, 'FRONTEND [Organizador] - Permite borrar una presentacion de la agenda del evento', NULL, NULL, 1593673164, 1593673164),
('presentacion/cargar-presentacion', 2, 'FRONTEND [Organizador] - Permite cargar una presentación a la agenda del evento', NULL, NULL, 1593673353, 1593673353),
('presentacion/create', 2, 'FRONTEND [Organizador] - Permite definir una presentación para un evento', NULL, NULL, 1593673276, 1593673276),
('presentacion/delete', 2, 'FRONTEND [Organizador] - Permite eliminar la presentación de la agenda de un evento', NULL, NULL, 1593673329, 1593673329),
('presentacion/update', 2, 'FRONTEND [Organizador] - Permite actualizar los datos de una presentación de un evento', NULL, NULL, 1593673301, 1593673301),
('presentacion/view', 2, 'FRONTEND [Registrado] - Permite visualizar la información completa de una presentación de un evento', NULL, NULL, 1593674553, 1593674553),
('Registrado', 1, 'Rol - Usuario registrado en la plataforma', NULL, NULL, NULL, NULL),
('respuesta/create', 2, 'FRONTEND [Registrado] - Permite a un usuario registrar una respuesta a una pregunta de formulario de preinscripcion', NULL, NULL, 1593656949, 1593656949),
('respuesta/ver', 2, 'FRONTEND [Registrado] - Permite a un usuario ver su respuesta a una pregunta', NULL, NULL, 1593656916, 1593656916),
('rol/create-rol', 2, 'BACKEND [Administrador] - Permite crear un nuevo rol', NULL, NULL, 1593651459, 1593651459),
('rol/index', 2, 'BACKEND [Administrador] - Permite visualizar el listado de todos los roles registrados en la plataforma', NULL, NULL, 1593651438, 1593651438),
('rol/remove-rol', 2, 'BACKEND [Administrador] - Permite eliminar un rol', NULL, NULL, 1593651506, 1593651506),
('rol/ver-rol', 2, 'BACKEND [Administrador] - Permite visualizar la información de un rol', NULL, NULL, 1593651450, 1593651450),
('site/index', 2, 'Permite al usuario acceder al home de la plataforma', NULL, NULL, 1593649035, 1593649035),
('site/login', 2, 'Permite a un usuario iniciar sesión en la plataforma', NULL, NULL, 1593650681, 1593650681),
('site/logout', 2, 'Permite a un usuario cerrar sesión en la plataforma', NULL, NULL, 1593650703, 1593650703),
('solicitud-aval/conceder-aval', 2, 'BACKEND [Administrador] - Permite conceder el aval de la FAI a un evento', NULL, NULL, 1593651320, 1593651320),
('solicitud-aval/quitar-aval', 2, 'BACKEND [Administrador] - Permite quitar el aval de la FAI a un evento', NULL, NULL, 1593651333, 1593651333),
('solicitud-aval/solicitudes-de-aval', 2, 'BACKEND [Administrador] - Permite visualizar el listado de todas las solicitudes de aval de los eventos en Juntar', NULL, NULL, 1593651291, 1593651291),
('solicitud-aval/view', 2, 'BACKEND [Administrador] - Permite visualizar una solicitud de aval', NULL, NULL, 1593651307, 1593651307),
('usuario/assign', 2, 'BACKEND [Administrador] - Permite asignarle un rol a un usuario', NULL, NULL, 1593647871, 1593647871),
('usuario/crear-usuario', 2, 'BACKEND [Administrador] - Permite crear una nueva cuenta de usuario desde el backend', NULL, NULL, 1593647896, 1593647896),
('usuario/deshabilitar', 2, 'BACKEND [Administrador] - Permite deshabilitar un usuario', NULL, NULL, 1593647937, 1593647937),
('usuario/habilitar', 2, 'BACKEND [Administrador] - Permite habilitar un usuario deshabilitado', NULL, NULL, 1593647956, 1593647956),
('usuario/index', 2, 'BACKEND [Administrador] - Permite ver el listado de todos los usuarios registrados en la plataforma', NULL, NULL, 1593647819, 1593647819),
('usuario/update', 2, 'BACKEND [Administrador] - Permite modificar los datos de un usuario registrado', NULL, NULL, 1593647918, 1593647918),
('usuario/view', 2, 'BACKEND [Administrador] - Permite visualizar los datos de un usuario particular', NULL, NULL, 1593647847, 1593647847),
('Validador', 1, 'Rol - Encargado de validar eventos para dar el aval de la Facultad de Informática', NULL, NULL, 1593673992, 1593673992);

--
-- Volcado de datos para la tabla `permiso_rol`
--

INSERT INTO `permiso_rol` (`parent`, `child`) VALUES
('Administrador', 'evento/create'),
('Administrador', 'evento/deshabilitar'),
('Administrador', 'evento/habilitar'),
('Administrador', 'evento/index'),
('Administrador', 'evento/update'),
('Administrador', 'evento/view'),
('Administrador', 'modalidad-evento/create'),
('Administrador', 'modalidad-evento/delete'),
('Administrador', 'modalidad-evento/index'),
('Administrador', 'modalidad-evento/update'),
('Administrador', 'modalidad-evento/view'),
('Administrador', 'Organizador'),
('Administrador', 'permission/asignar-permiso-a-rol'),
('Administrador', 'permission/asignar-permisos'),
('Administrador', 'permission/create-permiso'),
('Administrador', 'permission/index'),
('Administrador', 'permission/remove-permiso'),
('Administrador', 'permission/ver-permiso'),
('Administrador', 'Registrado'),
('Administrador', 'rol/create-rol'),
('Administrador', 'rol/index'),
('Administrador', 'rol/remove-rol'),
('Administrador', 'rol/ver-rol'),
('Administrador', 'site/login'),
('Administrador', 'solicitud-aval/conceder-aval'),
('Administrador', 'solicitud-aval/quitar-aval'),
('Administrador', 'solicitud-aval/solicitudes-de-aval'),
('Administrador', 'solicitud-aval/view'),
('Administrador', 'usuario/assign'),
('Administrador', 'usuario/crear-usuario'),
('Administrador', 'usuario/deshabilitar'),
('Administrador', 'usuario/habilitar'),
('Administrador', 'usuario/index'),
('Administrador', 'usuario/update'),
('Administrador', 'usuario/view'),
('Administrador', 'Validador'),
('Organizador', 'certificado/preview-organizer'),
('Organizador', 'cuenta/mis-eventos-gestionados'),
('Organizador', 'evento/cargar-evento'),
('Organizador', 'evento/cargar-expositor'),
('Organizador', 'evento/crear-email'),
('Organizador', 'evento/crear-formulario-dinamico'),
('Organizador', 'evento/editar-evento'),
('Organizador', 'evento/enviar-email'),
('Organizador', 'evento/enviar-email-inscriptos'),
('Organizador', 'evento/enviar-solicitud-evento'),
('Organizador', 'evento/evento-email'),
('Organizador', 'evento/finalizar-evento'),
('Organizador', 'evento/lista-participantes'),
('Organizador', 'evento/obtener-expositores'),
('Organizador', 'evento/obtener-inscriptos'),
('Organizador', 'evento/obtener-prinscriptos'),
('Organizador', 'evento/organizar-eventos'),
('Organizador', 'evento/publicar-evento'),
('Organizador', 'evento/respuestas-formulario'),
('Organizador', 'evento/suspender-evento'),
('Organizador', 'inscripcion/anular-inscripcion'),
('Organizador', 'inscripcion/inscribir-a-usuario'),
('Organizador', 'pregunta/create'),
('Organizador', 'pregunta/delete'),
('Organizador', 'pregunta/update'),
('Organizador', 'presentacion-expositor/delete'),
('Organizador', 'presentacion/borrar'),
('Organizador', 'presentacion/cargar-presentacion'),
('Organizador', 'presentacion/create'),
('Organizador', 'presentacion/delete'),
('Organizador', 'presentacion/update'),
('Organizador', 'Registrado'),
('Registrado', 'acreditacion/acreditacion'),
('Registrado', 'certificado/index'),
('Registrado', 'certificado/preview-attendance'),
('Registrado', 'cuenta/cambiar-email'),
('Registrado', 'cuenta/cambiar-email-request'),
('Registrado', 'cuenta/cambiar-password'),
('Registrado', 'cuenta/desactivar-cuenta'),
('Registrado', 'cuenta/editprofile'),
('Registrado', 'cuenta/mis-inscripciones-a-eventos'),
('Registrado', 'cuenta/profile'),
('Registrado', 'cuenta/upload-profile-image'),
('Registrado', 'evento/no-js'),
('Registrado', 'evento/responder-formulario'),
('Registrado', 'evento/ver-evento'),
('Registrado', 'inscripcion/eliminar-inscripcion'),
('Registrado', 'inscripcion/preinscripcion'),
('Registrado', 'presentacion-expositor/ver-expositores'),
('Registrado', 'presentacion/view'),
('Registrado', 'respuesta/create'),
('Registrado', 'respuesta/ver'),
('Registrado', 'site/index'),
('Registrado', 'site/login'),
('Registrado', 'site/logout'),
('Validador', 'evento/confirmar-solicitud'),
('Validador', 'evento/denegar-solicitud'),
('Validador', 'evento/verificar-solicitud'),
('Validador', 'Organizador'),
('Validador', 'Registrado');

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idUsuario`, `nombre`, `apellido`, `dni`, `pais`, `provincia`, `localidad`, `email`, `auth_key`, `password_hash`, `password_reset_token`, `status`, `created_at`, `updated_at`, `verification_token`) VALUES
(1, 'Marta', 'Caña', 20332183, '', NULL, 'Neuquén', 'admin01@test.com', 'OmzVKGUJExEJuN4e_yJnso6tNabdoF09', '$2y$13$hkfdaAZgIQEaZTrHRNsnje0otnGEzHo.BIoaXbsWqEbb51si.PR3e', NULL, 10, 1590994328, 1590994328, 'FAcDt5Ki0rSn5JLg9aMtCaV4F-LeTGUY_1590994328'),
(2, 'Carlos', 'Sepulveda', 20332183, '', NULL, 'Plottier', 'admin02@test.com', '5tT59IUEQHIF7A8RpYCNaj15feVcY5hI', '$2y$13$VSLcQKUMVi4yGc8o1DRcIeH1u.KkzuohRRghOS6JZAKIBWcUX/GZ.', NULL, 10, 1590994652, 1590994652, 'jx4kYymAYb5I_bx29h5KC9m3fLAnqirN_1590994652'),
(3, 'Rodrigo', 'Lazo', 20332183, '', NULL, 'Neuquén', 'organizador01@test.com', 'RfIaQzvchcC1zfRlAo2C7OpT04tNwcxF', '$2y$13$atb/agLp5ViXD20KG91yRefE0SN73JLrNOaJnD6UVcN64DQkTyrze', NULL, 10, 1590994729, 1590994729, '4i0PgyPBBD-1zt0DlQEVo8PP9MLtFAAN_1590994729'),
(4, 'Sabrina', 'Casas', 18664055, '', NULL, 'Centenario', 'organizador02@test.com', 'o546IVKZ0Vc1tnzfYruu3jTq1AEQl5XY', '$2y$13$OdLxghAQtDLB4WS7aIpWrOd7WR12ZuzfPfu/g23E.T8l06e8ALuWq', NULL, 10, 1590994776, 1590994776, 'zBU1IGmB733ix97W1n4GwVWVXQZhNemm_1590994776'),
(5, 'Marina', 'Perez', 26301284, '', NULL, 'General Roca', 'organizador03@test.com', 'PGvTg0o2LXqumMIZr4i472LZ_plvBBa-', '$2y$13$9IPBnPbxR6u3ucMMOR6rt.s/sIemcAtTiiaLAgqr7XguzZDRc0VsC', NULL, 10, 1590994822, 1590994822, 'amd5a1LNUJzwxXYcnozxpVd8gp0caScy_1590994822'),
(6, 'Alejandro', 'Medario', 32976700, '', NULL, 'Neuquén', 'registrado01@test.com', 'nE1auJs4ex8KmM7mo5UEtvrkFtSt94FI', '$2y$13$TkAsHr/QXEWKXR0OAxCm/.9ij2nod5iBibpk6ly0ZkTz9YeHmrEha', NULL, 10, 1590994878, 1590994878, 'vucICXx57O0zJv3LkAK7ueInqv9vrF1I_1590994878'),
(7, 'Matias', 'Contreras', 31179842, '', NULL, 'Cipolletti', 'registrado02@test.com', '5pjZV8xixJkfcspDznsGCq3QuIbU05da', '$2y$13$gc42YUd7Qsp2vrJACHZYLOn3b.Mh9JmS1N/ZOLIf7ayyFhKre7rgW', NULL, 10, 1590994958, 1590994958, 'GApav7SolKFCdriU-_NNYnTleAfenZyz_1590994958'),
(8, 'Lidia', 'Calderon', 32684666, '', NULL, 'Plottier', 'registrado03@test.com', 'dHMzF22B5zRjX4dSLn6J-fqlXPpvJYa2', '$2y$13$4Ym0uF4zAjqdCFboFsSurOekefP0bdSsR7faxqrlQaSK8Ma7NAqEq', NULL, 10, 1590995084, 1590995084, '_UvCdkNDMuJCQLjRlfQOjb6Hv_SaWb48_1590995084'),
(9, 'Anastasia', 'Palomo', 34740201, '', NULL, 'Centenario', 'registrado04@test.com', 'LHalzRHycE2DAdCGiyGCetHUDEPVaFoK', '$2y$13$FerwjQJV1hAAiE6d6tBiueIDQoB4brUfBQJFUzYwLjZPeywtp27b6', NULL, 10, 1590995156, 1590995156, 'inbyGzB29SLhZquC0z4tw-mZpX0VzcL6_1590995156'),
(10, 'Joana', 'Otero', 24464510, '', NULL, 'Neuquén', 'registrado05@test.com', 'qKdu_wt2JYETR6_E2u87OYY3iOy16cBx', '$2y$13$rnVUVvZutr/96w1cS4HhfetZw3dBQBlD9u.1ya4cdg7FPKDwUoov.', NULL, 10, 1590995182, 1590995182, 'TR9EWhAvtwWD8FR3-Sm1qc9HdBGRO6BP_1590995182'),
(11, 'Araceli', 'Manzano', 31747790, '', NULL, 'Neuquén', 'registrado06@test.com', 'sHy4nUiJC24Ahf7iAoM6LLdbqrozvcAA', '$2y$13$2bjcaQxu2/4UnjjwStwPSeQJgNNS/B09gbdw8uJPsbm6TLcCNcFi6', NULL, 10, 1590995202, 1590995202, '8wjkPYwqlYBeop4L8bL_VHabpkfLpUgL_1590995202'),
(12, 'Fabiola', 'Maroto', 33102179, '', NULL, 'Plottier', 'registrado07@test.com', 'ipIF8YUsd4YWUho4xQk26K1LNyfh4Znz', '$2y$13$baEfEtJVIbb7NTQZLerLyeZdpWW/S525t0Ky.zTSx3c9pPwjBlp3a', NULL, 10, 1590995230, 1590995230, '_6rZyiqUDrYVG9Qsq2RUFnloz09aKVqN_1590995230'),
(13, 'Elias', 'Contreras', 30147983, '', NULL, 'Centenario', 'registrado08@test.com', 'Nn3xdz9B86R-sQwWdDtrOOk79e0CdMtN', '$2y$13$ysREVfh1HwvP/p0cC.jtGe.UiPYHS/.kvqPq5Ga9Y8.BeDZSgyL9K', NULL, 10, 1590995252, 1590995252, 'r01h04ffYeO0X--HeoR_Sl5s571YJRj4_1590995252'),
(14, 'Fernanda', 'Rosa', 28561145, '', NULL, 'Neuquén', 'registrado09@test.com', 'eEymH70Ta4pi5uM1JdM4EQVMDCe8c94e', '$2y$13$YbKN8Zjs9YNBNSPSE/Npy.aowEX9nROQ44acOnuShe4lxpdKUpQgW', NULL, 10, 1590995290, 1590995290, 'lulupIU6dETfykAga9Pw4WzgcY3T6CBL_1590995290'),
(15, 'Elba', 'Thidora', 23609276, '', NULL, 'Plottier', 'registrado10@test.com', 'NzK7e7ANsT2rLyqzqavoG8vm8wWo8eEC', '$2y$13$9l4aj9xXl7KZAjewr9tDIeAdog7ShW/jRBmQqlRjTHwtxro9tfJF6', NULL, 10, 1590995334, 1590995334, 'VzTx3f30jl_RjQXgahQ5jfPM9xzrBCPV_1590995334'),
(17, 'Pablo', 'Kogan', 27894458, 'Argentina', 'Rio Negro', 'General Fernandez Oro', 'pablo.kogan@fi.uncoma.edu.ar', 'gjn-6uGKJQsvPugxpxuSMuJWUW_pci4u', '$2y$13$K5dZR0CrUqWO7zDwVZUj/Oa8p.21PDN1LvMO8TlNZIyN58MLJospS', NULL, 10, 1592327713, 1592327776, 'b9_rCItrP6MDoz8vM2VR0rO-S1-M2M5f_1592327713'),
(18, 'Leandro', 'Casanova', 36876234, 'Argentina', 'Chubut', 'Barrio Caleta Cordova', 'leandro.casanova@est.fi.uncoma.edu.ar', 'iwOgqdR2UqPHX3f6VDjWTIFzgsJo0q4b', '$2y$13$fT6WjOr/2Hv8miGKPxT9KeSfjG/oUX1cqbHO34rzezQmEVdKHiJ3a', NULL, 10, 1592327723, 1592327806, 'vz3oZFJt_PbQ86vwllCYOjL7brmZ4o57_1592327723'),
(19, 'Natalia', 'Baeza', 27979821, 'Argentina', 'Neuquen', 'Neuquen', 'baeza.natalia@gmail.com', 'BxADsNR5nEaUPbEdyIVFRnQ44RBWWV_l', '$2y$13$iM8Z.6IZsVWXuper5joPduhW7Jvgfw4MhqK/4TSGnKcNo0qbfUtxS', NULL, 10, 1592328971, 1592328995, '8SBwnoDKG-e8UEfeqjcXnNjeCkoAskRl_1592328971');

--
-- Volcado de datos para la tabla `usuario_rol`
--

INSERT INTO `usuario_rol` (`item_name`, `user_id`, `created_at`) VALUES
('Administrador', 1, NULL),
('Administrador', 2, NULL),
('Organizador', 3, NULL),
('Organizador', 4, NULL),
('Organizador', 5, NULL),
('Organizador', 6, 1592257182),
('Organizador', 9, 1592249241),
('Organizador', 17, 1592327776),
('Organizador', 18, 1592327806),
('Organizador', 19, 1592328995),
('Registrado', 6, NULL),
('Registrado', 7, NULL),
('Registrado', 8, NULL),
('Registrado', 9, 1591271733),
('Registrado', 10, NULL),
('Registrado', 11, NULL),
('Registrado', 12, NULL),
('Registrado', 13, NULL),
('Registrado', 14, NULL),
('Registrado', 15, NULL);

--
-- Volcado de datos para la tabla `categoria_evento`
--

INSERT INTO categoria_evento (idCategoriaEvento, descripcionCategoria) VALUES
(1, 'Seminario'),
(2, 'Congreso'),
(3, 'Diplomatura'),
(4, 'Otra');

--
-- Volcado de datos para la tabla `estado_evento`
--

INSERT INTO estado_evento (idEstadoEvento, descripcionEstado) VALUES
(1, 'Activo'),
(2, 'inhabilitado'),
(3, 'Finalizado'),
(4, 'Borrador');

--
-- Volcado de datos para la tabla `modalidad_evento`
--

INSERT INTO modalidad_evento (idModalidadEvento, descripcionModalidad) VALUES
(1, 'Presencial'),
(2, 'Online'),
(3, 'Presencial y Online'),
(4, 'Otra');

--
-- Volcado de datos para la tabla `evento`
--

INSERT INTO `evento` (`idEvento`, `idUsuario`, `idCategoriaEvento`, `idEstadoEvento`, `idModalidadEvento`, `nombreEvento`, `nombreCortoEvento`, `descripcionEvento`, `lugar`, `fechaInicioEvento`, `fechaFinEvento`, `imgFlyer`, `imgLogo`, `capacidad`, `preInscripcion`, `fechaLimiteInscripcion`, `codigoAcreditacion`, `fechaCreacionEvento`) VALUES
(1, 3, 1, 1, 2, 'Flisol Argentina', 'Flisol', 'El FLISoL es el evento de difusión de Software Libre más grande en Latinoamérica y está dirigido a todo tipo de público: estudiantes, académicos, empresarios, trabajadores, funcionarios públicos, entusiastas y aun personas que no poseen conocimiento informático. La entrada es gratuita y su principal objetivo es promover el uso del software libre, dando a conocer al público en general su filosofía, alcances, avances y desarrollo. Durante el evento normalmente se instala, de manera gratuita y totalmente legal, software libre en las computadoras que llevan los asistentes y simultáneamente se darán charlas de divulgación, pero en el marco del aislamiento en el que estamos todos, este año vamos dar charlas de forma virtual.', 'Facultad de infomática Uncoma', '2020-06-25', '2020-06-26', '/eventos/images/flyers/flisol.png', '/eventos/images/logos/FLISoL.png', 150, 1, '2020-06-18', '', '2020-06-15'),
(2, 3, 2, 1, 2, 'Tecnologia en Educación & Educación en Tecnologia', 'TeyeT', 'Anualmente, la Red de Universidades Nacionales con carreras de Informática (RedUNCI) desarrolla el Congreso de “Tecnología en Educación” y “Educación en Tecnología” (TE&ET). TE&ET tiene por objetivo la exposición y discusión de trabajos relacionados con la educación y la tecnología, en un contexto multidisciplinario. Los trabajos presentados en TE&ET relacionan Tecnologías de la Información y la Comunicación (TIC) aplicadas en Educación y a su vez, se presentan trabajos respecto del enfoque educativo de las TICs.\r\n\r\nLa edición 2020, ha sido declarado de interes por el Consejo Directivo de la Facultad de Informática de la Universidad Nacional del Comahue RESOLUCION CD FAIF Nº003/2020', 'Facultad de infomática Uncoma', '2020-07-06', '2020-07-07', NULL, '/eventos/images/logos/educacion.jpg', 150, 1, '2020-07-01', '', '2020-06-15'),
(3, 3, 1, 1, 2, 'Herramientas y Tips Prácticos para facilitar el Teletrabajo ', 'WEBINAR', 'Desmitificar el teletrabajo. Sensibilizar a los tomadores de decisiones (directivos/gerentes/jefes) para que se animen al teletrabajo. Brindar tips y/o herramientas para facilitar el teletrabajo. Seguridad de la Información.', 'facultad de infomática Uncoma', '2020-07-01', '2020-07-01', '/eventos/images/flyers/flyerWebbinar.jpg', '/eventos/images/logos/teletrabajo.jpg', 45, 1, '2020-06-26', '', '2020-06-15'),
(4, 3, 4, 1, 1, 'Desarrollo de Apps para Estudiantes Secundarios ', 'Taller ', 'Descubrí un nuevo mundo, el de ser autor de tus propias Aplicaciones con la herramienta AppInventor. AppInventor es un intuitivo ambiente de programación visual que permite a cualquiera -inclusive chicos- construir apps totalmente funcionales para tablets y teléfonos celulares.\r\n\r\n', 'Facultad de infomática Uncoma', '2020-06-25', '2020-06-25', '/eventos/images/flyers/flyerTallerapp.jpg', '/eventos/images/logos/logoApp.png', 60, 0, NULL, '', '2020-06-15'),
(5, 3, 2, 1, 2, 'ROBOTICS SUMMIT & EXPO', 'ROBOTICS', 'Este evento tiene la exclusiva característica de aunar las ferias comerciales con eventos de asociación y conferencias académicas y ha estado dirigida a Tecnologías, herramientas de sujeción y seguimiento de plataformas, Diseño y desarrollo y Manufactura, Negocios y sus modelos.', 'Seaport Worl Trade Center', '2020-06-17', '2020-06-18', '/eventos/images/flyers/robotica2020.jpg', '/eventos/images/logos/Robotics.png', 50, 0, NULL, '123456', '2020-06-15'),
(6, 3, 2, 1, 1, 'Cybersecurity Bank & Government', 'Cybersecurity', 'Máximo y único evento que tiene como finalidad mostrar las tendencias, estrategias, herramientas, normas internacionales, estadísticas, y equipamiento relacionado a la Ciberseguridad de los sectores Bancario, Grandes Empresas y Gobierno Latinoamericano en especial Argentina. Participarán los principales organismos estatales, bancarios y financieros de la región junto a las grandes empresas, dedicados a la defensa, normativa y gestión de la seguridad informática y seguridad de la información. Espacio ideal para capacitarte, informarte y relacionarte en un ámbito de especialistas.', 'Buenos Aires, Argentina', '2020-07-14', '2020-07-14', '/eventos/images/flyers/flyerciberseguridad.jpg', '/eventos/images/logos/seguridad.jpg', 20, 0, NULL, '', '2020-06-15'),
(7, 3, 4, 1, 2, 'Sala-Taller ¿Cómo estudiar en tiempos de virtualidad? ', 'Sala-Taller ', '¿Cómo surge ?\r\nDe la mirada y escucha psicopedagógica en entrevistas individuales.\r\nDel encuentro de saberes y sentires con otros actores institucionales.\r\nDe las voces de las y los estudiantes.\r\nDel deseo de contribuir a entramar lazos en el proceso de afiliación.', 'Facultad de infomática Uncoma', '2020-06-24', '2020-07-03', '/eventos/images/flyers/flyervirtualidad.jpeg', '/eventos/images/logos/logoVirtualizacion.png', 45, 1, '2020-06-17', '', '2020-06-15'),
(8, 4, 2, 1, 2, 'Internet Day 2020', 'Internet Day', 'Internet Day 2020 es un espacio de intercambio y debate sobre escenario de la Industria, las nuevas tecnologías, nuevos modelos de negocios y el marco legal para desarrollarlos. Prestigiosos disertantes comparten sus experiencias con el público y dan a conocer las últimas tendencias sobre nuevas tecnologías y la Industria.', 'CABA', '2020-07-07', '2020-07-07', NULL, '/eventos/images/logos/logoInternetday.jpeg', 60, 0, NULL, '', '2020-06-15'),
(9, 17, 4, 4, 2, 'We tripantu o wüñoy Tripantu?', 'wiñoyxipantu', 'es la celebración del año nuevo mapuche que se realiza en el solsticio de invierno austral (el día más corto del año en el hemisferio sur) entre el 21 y el 24 de junio.? ', 'Neuquen', '2020-06-19', '2020-06-20', NULL, NULL, 0, 0, NULL, '12345', NULL),
(10, 3, 4, 1, 2, 'Wiñoy xipantu', 'We-Tripantu ', 'We tripantu o wüñoy Tripantu? es la celebración del año nuevo mapuche que se realiza en el solsticio de invierno austral (el día más corto del año en el hemisferio sur) entre el 21 y el 24 de junio.? El We tripantu es un día de celebración para los mapuches, ya que es el día más corto del año y corresponde al comienzo de los días cada vez más largos hasta el solsticio de verano y el renacer eventual de la naturaleza tras el invierno al que se entra.', 'Neuquen', '2020-06-16', '2020-06-16', '/eventos/images/flyers/We-Tripantu.jpg', NULL, 10000, 0, NULL, 'xipantu', '2020-06-16');

--
-- Volcado de datos para la tabla `inscripcion`
--

INSERT INTO `inscripcion` (`idInscripcion`, `idUsuario`, `idEvento`, `estado`, `fechaPreInscripcion`, `fechaInscripcion`, `acreditacion`, `certificado`) VALUES
(1, 6, 2, 0, '2020-06-15', NULL, 0, NULL),
(2, 3, 1, 0, '2020-06-15', NULL, 0, NULL),
(3, 6, 4, 0, '2020-06-15', NULL, 0, NULL),
(4, 13, 2, 2, '2020-06-15', NULL, 0, NULL),
(5, 6, 1, 0, '2020-06-16', NULL, 0, NULL),
(6, 17, 10, 0, '2020-06-16', NULL, 1, NULL),
(7, 19, 10, 0, '2020-06-16', NULL, 0, NULL),
(8, 18, 10, 0, '2020-06-16', NULL, 1, NULL),
(9, 12, 10, 0, '2020-06-16', NULL, 1, NULL);

--
-- Volcado de datos para la tabla `presentacion`
--

INSERT INTO `presentacion` (`idPresentacion`, `idEvento`, `tituloPresentacion`, `descripcionPresentacion`, `diaPresentacion`, `horaInicioPresentacion`, `horaFinPresentacion`, `linkARecursos`) VALUES
(1, 1, 'Introducción a GNU/Linux', 'GNU/Linux es la denominación técnica y generalizada que reciben una serie de sistemas operativos de tipo Unix, que también son multiplataforma, multiusuario y multitarea.? Estos sistemas operativos están formados mediante la combinación de varios proyectos, entre los cuales destaca el entorno GNU, encabezado por el programador estadounidense Richard Stallman junto a la Free Software Foundation, una fundación cuyo propósito es difundir el software libre, así como también el núcleo de sistema operativo conocido como «Linux», encabezado por el programador finlandés Linus Torvalds.', '2020-06-25', '15:00:00', '15:35:00', ''),
(3, 2, 'Bienvenida Autoridades Locales', 'Docente de grado de la Universidad de UNCuyo y de posgrado en varias universidades en espacios curriculares vinculados a las Tecnologías Digitales y la Educación. ', '2020-07-06', '11:00:00', '12:00:00', ''),
(5, 3, '¿Qué es el teletrabajo?', 'El teletrabajo es aquel que se realiza fuera de las instalaciones de una empresa mediante la utilización de todo tipo de tecnología de la información y de las comunicaciones (TIC). Esta modalidad está siendo adoptada cada vez más por trabajadores, empresas y organismos, a nivel mundial. ', '2020-07-01', '14:30:00', '18:30:00', 'https://tiuma.github.io/telework-presentation/#/'),
(6, 4, 'Desarrollo de mi primer App', 'Tallerista\r\n\r\nMatias es Estudiante de la Licenciatura en Ciencias de la Computación. Es docente de nivel medio y ha participado activamente en diferentes proyectos de Extensión y del proyecto de Vocaciones TICs dictando numerosos talleres de AppInventor.', '2020-06-25', '15:00:00', '17:00:00', 'https://drive.google.com/drive/folders/1drYhE3i4ewzks94MTr2QRvXWnb2N2uLU'),
(7, 1, 'Montun paso a paso Instalación', 'El desarrollo de estos sistemas operativos es uno de los ejemplos más prominentes de software libre: todo su código fuente puede ser utilizado, modificado y redistribuido libremente por cualquier persona, empresa o institución, bajo los términos de la Licencia Pública General de GNU, así como de otra serie de licencias, si se desea.3? La idea de desarrollar un sistema operativo libre y basado en el sistema operativo Unix, se remonta a mediados de la década de 1980 con el proyecto GNU. ', '2020-06-25', '15:35:00', '16:05:00', ''),
(8, 1, 'Homenaje al Oso. Anécdotas, Charlas, Ideas, Preguntas, Respuestas y Recuerdos de una gran persona Eduardo Grosclaude - el oso,', 'A pesar de que en la jerga cotidiana la mayoría de las personas usan el vocablo «Linux» para referirse a este sistema operativo,4?5? en realidad ese es solo el nombre del kernel o núcleo, ya que el sistema completo está formado también por una gran cantidad de componentes del proyecto GNU, que van desde compiladores hasta entornos de escritorio.', '2020-06-25', '16:06:00', '16:35:00', ''),
(9, 1, 'reconectar++', 'Sin embargo, tras publicar Torvalds su núcleo Linux en 1991 y ser este usado junto al software del proyecto GNU, una parte significativa de los medios generales y especializados han utilizado el término «Linux» para referirse a estos sistemas operativos completos', '2020-06-25', '16:35:00', '17:05:00', ''),
(10, 4, 'Agregando comportamiento a mi App', 'Tallerista\r\n\r\nCarlos es Estudiante de la Licenciatura en Ciencias de la Computación y ha participado activamente en diferentes proyectos de Extensión y del proyecto de Vocaciones TICs dictando numerosos talleres de AppInventor.', '2020-06-26', '17:00:00', '18:30:00', ''),
(11, 2, 'Conferencia Inaugural - La pandemia como aprendizaje para la post pandemia', 'Ha ocupado diferentes cargos en el ámbito de la Gestión Universitaria. En la actualidad es Directora de la Maestría en “Enseñanza en Escenarios Digitales” de la AUSA y de la Diplomatura “Educación en la Cultura Digital” de la FED.', '2020-07-07', '14:30:00', '16:00:00', ''),
(12, 3, 'Ventajas del Teletrabajo', 'En este contexto de pandemia, no tiene sentido hablar de ventajas. Hoy es una necesidad. Es una ventaja en si.', '2020-07-01', '18:30:00', '19:00:00', ''),
(13, 7, 'Rutinas de estudio en tiempos de virtualidad', 'Taller 1 - Atender  a  las  dificultades  de  las  y  los estudiantes  que se presentan con respecto a la rutina de estudio en tiempos de virtualidad.\r\nPromover  un  espacio  de  reflexión  sobre  los propios   procesos   cognitivos,emocionales, sociales    que  se  desarrollan  en  la  etapa  de ingreso universitario', '2020-06-24', '16:00:00', '17:30:00', ''),
(14, 7, 'Estrategias y recursos para fortalecer tu trayectoria académica', 'Taller 2 - Propiciar la reflexión sobre las condiciones que obstaculizan  y  facilitan  el  aprendizaje  en entornos virtuales.\r\nFavorecer  el desarrollo de diferentes recursos psicoeducativos para la mejora del aprendizaje en la Universidad.\r\nFortalecer el proceso de formación profesional en el contexto académico universitario', '2020-06-25', '14:00:00', '18:30:00', ''),
(15, 8, 'Proveedores de Soluciones IT / IoT', 'Proveedores de infraestructura\r\nProveedores de software\r\n', '2020-07-07', '13:30:00', '16:00:00', ''),
(16, 8, 'Organismos Gubernamentales', 'Proveedores de Telefonía IP\r\nProveedores de equipos, antenas, radios\r\nProveedores de hosting y cloud', '2020-07-07', '16:00:00', '18:00:00', ''),
(17, 9, 'Panel', 'lslsl', '2020-06-19', '17:00:00', '19:00:00', ''),
(18, 9, 'Panel', 'q', '2020-06-19', '22:00:00', '23:00:00', ''),
(19, 9, 'Panel', '555', '2020-06-19', '01:00:00', '02:00:00', ''),
(20, 9, 'Panel', '555', '2020-06-19', '01:00:00', '02:00:00', '');

--
-- Volcado de datos para la tabla `presentacion_expositor`
--

INSERT INTO `presentacion_expositor` (`idExpositor`, `idPresentacion`) VALUES
(2, 10),
(6, 5),
(6, 7),
(6, 13),
(7, 8),
(7, 14),
(8, 1),
(8, 13),
(8, 16),
(8, 20),
(10, 12),
(12, 9),
(13, 3),
(13, 11),
(14, 15),
(19, 20);

--
-- Volcado de datos para la tabla `pregunta`
--

INSERT INTO `pregunta` (`id`, `idevento`, `tipo`, `descripcion`) VALUES
(9, 3, '1', 'Hola'),
(10, 3, '2', 'Test2'),
(13, 1, '2', '¿Como te llamas?'),
(14, 3, '3', 'Subi tu cv');

--
-- Volcado de datos para la tabla `respuesta`
--

INSERT INTO `respuesta` (`id`, `idpregunta`, `idinscripcion`, `respuesta`) VALUES
(2, 9, 9, 'a'),
(3, 10, 9, 'dasdas'),
(16, 14, 9, '../web/eventos/formularios/archivos/IMG-20170129-WA0005.jpeg');

-- #######################################################################################################################
-- #######################################################################################################################

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
