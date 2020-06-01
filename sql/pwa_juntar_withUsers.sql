-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 01-06-2020 a las 09:27:25
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

create database pwa_juntar2;

use pwa_juntar2;

--
-- Base de datos: `pwa_juntar`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evento`
--

CREATE TABLE `evento` (
  `idEvento` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `nombreEvento` varchar(100) NOT NULL,
  `descripcionEvento` varchar(200) NOT NULL,
  `lugar` varchar(200) NOT NULL,
  `modalidad` varchar(200) NOT NULL,
  `linkPresentaciones` varchar(200) NOT NULL,
  `linkFlyer` varchar(200) NOT NULL,
  `linkLogo` varchar(200) NOT NULL,
  `capacidad` int(6) NOT NULL,
  `preInscripcion` tinyint(1) NOT NULL,
  `fechaLimiteInscripcion` date NOT NULL,
  `codigoAcreditacion` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `expositor`
--

CREATE TABLE `expositor` (
  `idExpositor` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fecha`
--

CREATE TABLE `fecha` (
  `idFecha` int(11) NOT NULL,
  `idEvento` int(11) NOT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inscripcion`
--

CREATE TABLE `inscripcion` (
  `idInscripcion` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `idEvento` int(11) NOT NULL,
  `estado` int(11) NOT NULL,
  `fecha_preinscripcion` date NOT NULL,
  `fecha_inscripcion` date DEFAULT NULL,
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

--
-- Volcado de datos para la tabla `permiso`
--

INSERT INTO `permiso` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
('Administrador', 1, 'Superusuario Administrador', NULL, NULL, 1590382997, 1590382997),
('Organizador', 1, 'Usuario gestor de eventos', NULL, NULL, 1590382997, 1590382997),
('Registrado', 1, 'Usuario registrado en la plataforma', NULL, NULL, 1590382997, 1590382997),
('site/ABMEvento', 2, 'ABMEvento', NULL, NULL, 1590380545, 1590380545),
('site/ABMRol', 2, 'ABMRol', NULL, NULL, 1590380545, 1590380545),
('site/ABMUsuario', 2, 'ABMUsuario', NULL, NULL, 1590380545, 1590380545),
('site/contact', 2, 'Formulario de contacto con administradores', NULL, NULL, 1590380545, 1590380545),
('site/error', 2, 'Acceso denegado', NULL, NULL, 1590380544, 1590380544),
('site/index', 2, 'Ver el home de la plataforma', NULL, NULL, 1590380545, 1590380545),
('site/login', 2, 'Formulario de ingreso', NULL, NULL, 1590380545, 1590380545),
('site/logout', 2, 'Desloguearse de la plataforma', NULL, NULL, 1590380545, 1590380545),
('site/miPerfil', 2, 'Visualizar el perfil', NULL, NULL, 1590380545, 1590380545);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permiso_rol`
--

CREATE TABLE `permiso_rol` (
  `parent` varchar(64) NOT NULL,
  `child` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `permiso_rol`
--

INSERT INTO `permiso_rol` (`parent`, `child`) VALUES
('Administrador', 'site/ABMEvento'),
('Administrador', 'site/ABMRol'),
('Administrador', 'site/ABMUsuario'),
('Administrador', 'site/error'),
('Administrador', 'site/login'),
('Administrador', 'site/logout'),
('Organizador', 'Registrado'),
('Registrado', 'site/contact'),
('Registrado', 'site/error'),
('Registrado', 'site/index'),
('Registrado', 'site/login'),
('Registrado', 'site/logout'),
('Registrado', 'site/miPerfil');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `presentacion`
--

CREATE TABLE `presentacion` (
  `idPresentacion` int(11) NOT NULL,
  `idEvento` int(11) NOT NULL,
  `tituloPresentacion` varchar(100) NOT NULL,
  `descripcionPresentacion` varchar(400) NOT NULL,
  `horaInicioPresentacion` datetime NOT NULL,
  `horaFinPresentacion` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `presentacion_expositor`
--

CREATE TABLE `presentacion_expositor` (
  `idPresentacion` int(11) NOT NULL,
  `idExpositor` int(11) NOT NULL
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
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `idUsuario` int(11) NOT NULL,
  `nombre` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `apellido` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `dni` int(11) DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `localidad` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `telefono` int(11) DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` smallint(6) NOT NULL DEFAULT 9,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `verification_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idUsuario`, `nombre`, `apellido`, `dni`, `fecha_nacimiento`, `localidad`, `telefono`, `email`, `auth_key`, `password_hash`, `password_reset_token`, `status`, `created_at`, `updated_at`, `verification_token`) VALUES
(1, 'Marta', 'Caña', NULL, NULL, NULL, NULL, 'admin01@test.com', 'OmzVKGUJExEJuN4e_yJnso6tNabdoF09', '$2y$13$hkfdaAZgIQEaZTrHRNsnje0otnGEzHo.BIoaXbsWqEbb51si.PR3e', NULL, 10, 1590994328, 1590994328, 'FAcDt5Ki0rSn5JLg9aMtCaV4F-LeTGUY_1590994328'),
(2, 'Carlos', 'Sepulveda', NULL, NULL, NULL, NULL, 'admin02@test.com', '5tT59IUEQHIF7A8RpYCNaj15feVcY5hI', '$2y$13$VSLcQKUMVi4yGc8o1DRcIeH1u.KkzuohRRghOS6JZAKIBWcUX/GZ.', NULL, 10, 1590994652, 1590994652, 'jx4kYymAYb5I_bx29h5KC9m3fLAnqirN_1590994652'),
(3, 'Rodrigo', 'Lazo', NULL, NULL, NULL, NULL, 'organizador01@test.com', 'RfIaQzvchcC1zfRlAo2C7OpT04tNwcxF', '$2y$13$atb/agLp5ViXD20KG91yRefE0SN73JLrNOaJnD6UVcN64DQkTyrze', NULL, 10, 1590994729, 1590994729, '4i0PgyPBBD-1zt0DlQEVo8PP9MLtFAAN_1590994729'),
(4, 'Sabrina', 'Casas', NULL, NULL, NULL, NULL, 'organizador02@test.com', 'o546IVKZ0Vc1tnzfYruu3jTq1AEQl5XY', '$2y$13$OdLxghAQtDLB4WS7aIpWrOd7WR12ZuzfPfu/g23E.T8l06e8ALuWq', NULL, 10, 1590994776, 1590994776, 'zBU1IGmB733ix97W1n4GwVWVXQZhNemm_1590994776'),
(5, 'Marina', 'Perez', NULL, NULL, NULL, NULL, 'organizador03@test.com', 'PGvTg0o2LXqumMIZr4i472LZ_plvBBa-', '$2y$13$9IPBnPbxR6u3ucMMOR6rt.s/sIemcAtTiiaLAgqr7XguzZDRc0VsC', NULL, 10, 1590994822, 1590994822, 'amd5a1LNUJzwxXYcnozxpVd8gp0caScy_1590994822'),
(6, 'Alejandro', 'Medario', NULL, NULL, NULL, NULL, 'registrado01@test.com', 'nE1auJs4ex8KmM7mo5UEtvrkFtSt94FI', '$2y$13$TkAsHr/QXEWKXR0OAxCm/.9ij2nod5iBibpk6ly0ZkTz9YeHmrEha', NULL, 10, 1590994878, 1590994878, 'vucICXx57O0zJv3LkAK7ueInqv9vrF1I_1590994878'),
(7, 'Matias', 'Contreras', NULL, NULL, NULL, NULL, 'registrado02@test.com', '5pjZV8xixJkfcspDznsGCq3QuIbU05da', '$2y$13$gc42YUd7Qsp2vrJACHZYLOn3b.Mh9JmS1N/ZOLIf7ayyFhKre7rgW', NULL, 10, 1590994958, 1590994958, 'GApav7SolKFCdriU-_NNYnTleAfenZyz_1590994958'),
(8, 'Lidia', 'Calderon', NULL, NULL, NULL, NULL, 'registrado03@test.com', 'dHMzF22B5zRjX4dSLn6J-fqlXPpvJYa2', '$2y$13$4Ym0uF4zAjqdCFboFsSurOekefP0bdSsR7faxqrlQaSK8Ma7NAqEq', NULL, 10, 1590995084, 1590995084, '_UvCdkNDMuJCQLjRlfQOjb6Hv_SaWb48_1590995084'),
(9, 'Anastasia', 'Palomo', NULL, NULL, NULL, NULL, 'registrado04@test.com', 'LHalzRHycE2DAdCGiyGCetHUDEPVaFoK', '$2y$13$FerwjQJV1hAAiE6d6tBiueIDQoB4brUfBQJFUzYwLjZPeywtp27b6', NULL, 10, 1590995156, 1590995156, 'inbyGzB29SLhZquC0z4tw-mZpX0VzcL6_1590995156'),
(10, 'Joana', 'Otero', NULL, NULL, NULL, NULL, 'registrado05@test.com', 'qKdu_wt2JYETR6_E2u87OYY3iOy16cBx', '$2y$13$rnVUVvZutr/96w1cS4HhfetZw3dBQBlD9u.1ya4cdg7FPKDwUoov.', NULL, 10, 1590995182, 1590995182, 'TR9EWhAvtwWD8FR3-Sm1qc9HdBGRO6BP_1590995182'),
(11, 'Araceli', 'Manzano', NULL, NULL, NULL, NULL, 'registrado06@test.com', 'sHy4nUiJC24Ahf7iAoM6LLdbqrozvcAA', '$2y$13$2bjcaQxu2/4UnjjwStwPSeQJgNNS/B09gbdw8uJPsbm6TLcCNcFi6', NULL, 10, 1590995202, 1590995202, '8wjkPYwqlYBeop4L8bL_VHabpkfLpUgL_1590995202'),
(12, 'Fabiola', 'Maroto', NULL, NULL, NULL, NULL, 'registrado07@test.com', 'ipIF8YUsd4YWUho4xQk26K1LNyfh4Znz', '$2y$13$baEfEtJVIbb7NTQZLerLyeZdpWW/S525t0Ky.zTSx3c9pPwjBlp3a', NULL, 10, 1590995230, 1590995230, '_6rZyiqUDrYVG9Qsq2RUFnloz09aKVqN_1590995230'),
(13, 'Elias', 'Contreras', NULL, NULL, NULL, NULL, 'registrado08@test.com', 'Nn3xdz9B86R-sQwWdDtrOOk79e0CdMtN', '$2y$13$ysREVfh1HwvP/p0cC.jtGe.UiPYHS/.kvqPq5Ga9Y8.BeDZSgyL9K', NULL, 10, 1590995252, 1590995252, 'r01h04ffYeO0X--HeoR_Sl5s571YJRj4_1590995252'),
(14, 'Fernanda', 'Rosa', NULL, NULL, NULL, NULL, 'registrado09@test.com', 'eEymH70Ta4pi5uM1JdM4EQVMDCe8c94e', '$2y$13$YbKN8Zjs9YNBNSPSE/Npy.aowEX9nROQ44acOnuShe4lxpdKUpQgW', NULL, 10, 1590995290, 1590995290, 'lulupIU6dETfykAga9Pw4WzgcY3T6CBL_1590995290'),
(15, 'Elba', 'Thiroda', NULL, NULL, NULL, NULL, 'registrado10@test.com', 'NzK7e7ANsT2rLyqzqavoG8vm8wWo8eEC', '$2y$13$9l4aj9xXl7KZAjewr9tDIeAdog7ShW/jRBmQqlRjTHwtxro9tfJF6', NULL, 10, 1590995334, 1590995334, 'VzTx3f30jl_RjQXgahQ5jfPM9xzrBCPV_1590995334');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_rol`
--

CREATE TABLE `usuario_rol` (
  `item_name` varchar(64) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `created_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `evento`
--
ALTER TABLE `evento`
  ADD PRIMARY KEY (`idEvento`),
  ADD KEY `organizador` (`idUsuario`);

--
-- Indices de la tabla `expositor`
--
ALTER TABLE `expositor`
  ADD KEY `idUsuario` (`idUsuario`),
  ADD KEY `idExpositor` (`idExpositor`);

--
-- Indices de la tabla `fecha`
--
ALTER TABLE `fecha`
  ADD PRIMARY KEY (`idFecha`),
  ADD KEY `idEvento` (`idEvento`);

--
-- Indices de la tabla `inscripcion`
--
ALTER TABLE `inscripcion`
  ADD PRIMARY KEY (`idInscripcion`),
  ADD KEY `idUsuario` (`idUsuario`),
  ADD KEY `idEvento` (`idEvento`);

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
  ADD KEY `idPresentacion` (`idPresentacion`),
  ADD KEY `idExpositor` (`idExpositor`);

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
-- Indices de la tabla `usuario_rol`
--
ALTER TABLE `usuario_rol`
  ADD PRIMARY KEY (`item_name`) USING BTREE,
  ADD KEY `usuario_rol_usuario_id_idx` (`idUsuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `evento`
--
ALTER TABLE `evento`
  MODIFY `idEvento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `expositor`
--
ALTER TABLE `expositor`
  MODIFY `idExpositor` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `fecha`
--
ALTER TABLE `fecha`
  MODIFY `idFecha` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `inscripcion`
--
ALTER TABLE `inscripcion`
  MODIFY `idInscripcion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `presentacion`
--
ALTER TABLE `presentacion`
  MODIFY `idPresentacion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `evento`
--
ALTER TABLE `evento`
  ADD CONSTRAINT `evento_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`),
  ADD CONSTRAINT `evento_ibfk_2` FOREIGN KEY (`idEvento`) REFERENCES `presentacion` (`idEvento`);

--
-- Filtros para la tabla `expositor`
--
ALTER TABLE `expositor`
  ADD CONSTRAINT `expositor_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`);

--
-- Filtros para la tabla `fecha`
--
ALTER TABLE `fecha`
  ADD CONSTRAINT `fecha_ibfk_1` FOREIGN KEY (`idEvento`) REFERENCES `evento` (`idEvento`);

--
-- Filtros para la tabla `inscripcion`
--
ALTER TABLE `inscripcion`
  ADD CONSTRAINT `inscripcion_ibfk_1` FOREIGN KEY (`idEvento`) REFERENCES `evento` (`idEvento`);

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
  ADD CONSTRAINT `presentacion_ibfk_1` FOREIGN KEY (`idPresentacion`) REFERENCES `presentacion_expositor` (`idPresentacion`);

--
-- Filtros para la tabla `presentacion_expositor`
--
ALTER TABLE `presentacion_expositor`
  ADD CONSTRAINT `presentacion_expositor_ibfk_1` FOREIGN KEY (`idExpositor`) REFERENCES `expositor` (`idExpositor`);

--
-- Filtros para la tabla `usuario_rol`
--
ALTER TABLE `usuario_rol`
  ADD CONSTRAINT `usuario_rol_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `permiso` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `usuario_rol_ibfk_2` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
