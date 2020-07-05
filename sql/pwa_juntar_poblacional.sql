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

-- #######################################################################################################################
-- #######################################################################################################################
--
-- Volcado de datos para las tablas
--
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
(13, 'Elias', 'Contreras', 30147983, '', NULL, 'Centenario', 'contreras.elias@test.com', 'Nn3xdz9B86R-sQwWdDtrOOk79e0CdMtN', '$2y$13$ysREVfh1HwvP/p0cC.jtGe.UiPYHS/.kvqPq5Ga9Y8.BeDZSgyL9K', NULL, 10, 1590995252, 1590995252, 'r01h04ffYeO0X--HeoR_Sl5s571YJRj4_1590995252'),
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
('Organizador', 17, 1592327776),
('Organizador', 18, 1592327806),
('Organizador', 19, 1592328995),
('Organizador', 7, NULL),
('Organizador', 8, NULL),
('Organizador', 9, 1591271733),
('Organizador', 10, NULL),
('Organizador', 11, NULL),
('Organizador', 12, NULL),
('Organizador', 13, NULL),
('Organizador', 14, NULL),
('Organizador', 15, NULL),
('Validador', 13, NULL),
('Validador', 14, NULL);
--
-- Volcado de datos para la tabla `categoria_evento` @
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

-- #######################################################################################################################
-- #######################################################################################################################

COMMIT;
