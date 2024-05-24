-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 24, 2024 at 05:03 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `educa`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_actividades`
--

CREATE TABLE `tbl_actividades` (
  `id` int(11) NOT NULL,
  `fk_modulo` int(11) NOT NULL,
  `indice` int(11) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `tipo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_actividades`
--

INSERT INTO `tbl_actividades` (`id`, `fk_modulo`, `indice`, `titulo`, `tipo`) VALUES
(1, 1, 1, 'Actividad 1', 0),
(2, 1, 2, 'activity 2', 0),
(3, 1, 3, 'Polinomios', 0),
(4, 2, 1, 'Act 2.1', 0),
(8, 7, 1, 'Actividad 1', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_cronogramas`
--

CREATE TABLE `tbl_cronogramas` (
  `id` int(11) NOT NULL,
  `fk_curso` int(11) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `duracion` int(11) NOT NULL,
  `precio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_cronogramas`
--

INSERT INTO `tbl_cronogramas` (`id`, `fk_curso`, `fecha_inicio`, `fecha_fin`, `duracion`, `precio`) VALUES
(1, 1, '2023-12-15', '2024-03-15', 60, 29500),
(2, 1, '0000-00-00', '0000-00-00', 90, 34900),
(3, 2, '2023-12-01', '2024-02-25', 45, 19990),
(4, 3, '0000-00-00', '0000-00-00', 30, 34500),
(7, 6, '2024-02-01', '2024-02-09', 10, 50000),
(8, 7, '2024-04-30', '2024-06-01', 64, 50500);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_cursos`
--

CREATE TABLE `tbl_cursos` (
  `id` int(11) NOT NULL,
  `fk_profesor` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `descripcion` varchar(500) NOT NULL,
  `lista_contenido` varchar(500) NOT NULL,
  `lista_categoria` varchar(100) NOT NULL,
  `tags` varchar(100) NOT NULL,
  `carpeta` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_cursos`
--

INSERT INTO `tbl_cursos` (`id`, `fk_profesor`, `nombre`, `descripcion`, `lista_contenido`, `lista_categoria`, `tags`, `carpeta`) VALUES
(1, 3, 'HTML5, CSS3 Y JavaScript, jQuery', 'Aprende HTML5, CSS3 Y JavaScript de manera rápida y efectiva.', 'HTML\r\nFormularios\r\nCSS3\r\nFlexBox\r\nJavaScript\r\nDOM', 'Software Web\r\nJavaScript', 'HTML\r\nCSS\r\nJavaScript', '1702264978-835'),
(2, 3, 'jQuery desde 0', 'Aprenda jQuery desde los conceptos básicos hasta un manejo avanzado del lenguaje.', 'Selectores\nAtributos\nEventos\nEfectos\nAjax', 'Desarrollo Web\njQuery', 'JavaScript\njQuery', '1702265941-624'),
(3, 1, 'Tomcat para Administradores', 'Aprende a usar el servidor web Tomcat para todo tipo de aplicaciones', 'Instalación\r\nConfiguración\r\nApache Web Server\r\nDespliegue\r\nClusters', 'Desarrollo Web\r\nTomcat', 'Apache\r\nWebServer\r\nTomcat', '1702266769-545'),
(6, 3, 'Nombre', 'Descripción', 'lista1\r\nlista2\r\nlista3', 'progracion web', 'html\r\nphp', '1707538838-375'),
(7, 1, '123', '123123', 'a\r\nb\r\nc', 'x\r\ny\r\nz', 'tag1\r\ntag2', '1714436152-284');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_estudiantes`
--

CREATE TABLE `tbl_estudiantes` (
  `id` int(11) NOT NULL,
  `suscripcion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_estudiantes`
--

INSERT INTO `tbl_estudiantes` (`id`, `suscripcion`) VALUES
(2, 0),
(7, 0),
(1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_foros`
--

CREATE TABLE `tbl_foros` (
  `id` int(11) NOT NULL,
  `fk_curso` int(11) NOT NULL,
  `fk_autor` int(11) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `contenido` varchar(1000) NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_foros`
--

INSERT INTO `tbl_foros` (`id`, `fk_curso`, `fk_autor`, `titulo`, `contenido`, `estado`, `created_at`, `updated_at`) VALUES
(16, 3, 7, 'Nuevo', 'foro', 0, '2024-03-22 03:47:15', '2024-03-22 04:43:31'),
(19, 3, 1, 'Prueba', 'probando', 1, '2024-03-22 04:14:42', '2024-03-22 04:14:42'),
(20, 3, 7, 'Tengo dudas', 'mas dudas', 1, '2024-03-22 04:43:57', '2024-03-22 04:43:57');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_inscripciones_pago`
--

CREATE TABLE `tbl_inscripciones_pago` (
  `idEstudiante` int(11) NOT NULL,
  `idCronograma` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_inscripciones_pago`
--

INSERT INTO `tbl_inscripciones_pago` (`idEstudiante`, `idCronograma`) VALUES
(1, 8),
(7, 4);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_inscripciones_suscrip`
--

CREATE TABLE `tbl_inscripciones_suscrip` (
  `idEstudiante` int(11) NOT NULL,
  `idCronograma` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_inscripciones_suscrip`
--

INSERT INTO `tbl_inscripciones_suscrip` (`idEstudiante`, `idCronograma`) VALUES
(1, 2),
(1, 3),
(1, 4);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_modulos`
--

CREATE TABLE `tbl_modulos` (
  `id` int(11) NOT NULL,
  `fk_curso` int(11) NOT NULL,
  `indice` int(11) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `asignatura` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_modulos`
--

INSERT INTO `tbl_modulos` (`id`, `fk_curso`, `indice`, `titulo`, `asignatura`) VALUES
(1, 3, 1, 'Modulo 1', ''),
(2, 3, 2, 'mOdUlO 2', ''),
(7, 7, 1, 'Modulo 1', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_profesores`
--

CREATE TABLE `tbl_profesores` (
  `id` int(11) NOT NULL,
  `titulo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_profesores`
--

INSERT INTO `tbl_profesores` (`id`, `titulo`) VALUES
(1, ''),
(3, '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_respuestas`
--

CREATE TABLE `tbl_respuestas` (
  `id` int(11) NOT NULL,
  `fk_foro` int(11) NOT NULL,
  `fk_autor` int(11) NOT NULL,
  `respuesta` varchar(1000) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_respuestas`
--

INSERT INTO `tbl_respuestas` (`id`, `fk_foro`, `fk_autor`, `respuesta`, `created_at`, `updated_at`) VALUES
(7, 16, 1, 'nueva respuesta', '2024-03-22 03:47:31', '2024-03-22 03:47:31'),
(8, 16, 1, 'otra', '2024-03-22 03:48:36', '2024-03-22 03:48:36'),
(9, 16, 1, 'bruh!', '2024-03-22 04:05:47', '2024-03-22 04:18:28'),
(12, 20, 1, ' s i ', '2024-03-22 23:38:51', '2024-03-23 00:57:17'),
(13, 20, 1, 'respondiendo', '2024-03-23 01:09:05', '2024-03-23 01:09:05');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_roles`
--

CREATE TABLE `tbl_roles` (
  `id` int(11) NOT NULL,
  `valor` int(11) NOT NULL,
  `tipo` varchar(50) NOT NULL,
  `paginas` varchar(500) NOT NULL DEFAULT '',
  `tabla` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_roles`
--

INSERT INTO `tbl_roles` (`id`, `valor`, `tipo`, `paginas`, `tabla`) VALUES
(1, 2, 'ADMIN', 'manage_courses,manage_schedules,manage_users', ''),
(2, 4, 'ESTUDIANTE', 'my_courses,my_payments,content', ''),
(3, 8, 'PROFESOR', 'courses_content,courses_stats,content,content_edit', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_suscripciones`
--

CREATE TABLE `tbl_suscripciones` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `usuarios` int(11) NOT NULL,
  `cursos` int(11) NOT NULL,
  `atencion` varchar(50) NOT NULL,
  `certificado` varchar(50) NOT NULL,
  `precio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_suscripciones`
--

INSERT INTO `tbl_suscripciones` (`id`, `nombre`, `usuarios`, `cursos`, `atencion`, `certificado`, `precio`) VALUES
(0, 'Ninguno', 0, 0, '', '', 0),
(1, 'Plan Básico', 1, 3, 'Atención Limitada ', 'Certificado Digital', 29900),
(2, 'Plan Estandar', 2, 5, 'Atención Regular', 'Certificado Digital y Físico', 49900),
(3, 'Plan Premium', 3, 10, 'Atención Ilimitada', 'Certificado Digital y Físico', 79900);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_tarjetas_debito_credito`
--

CREATE TABLE `tbl_tarjetas_debito_credito` (
  `id` int(11) NOT NULL,
  `numero` bigint(16) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `fecha_vencimiento` date NOT NULL,
  `cvv` int(3) NOT NULL,
  `fk_estudiante` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_tarjetas_debito_credito`
--

INSERT INTO `tbl_tarjetas_debito_credito` (`id`, `numero`, `nombre`, `fecha_vencimiento`, `cvv`, `fk_estudiante`) VALUES
(1, 1234567890123456, 'VISA CLASICA', '2029-06-01', 556, 1),
(3, 1000000000000001, 'Master Card D-', '2031-06-01', 951, 2),
(15, 1000000000000002, 'abc', '2024-01-01', 100, 7);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_usuarios`
--

CREATE TABLE `tbl_usuarios` (
  `id` int(11) NOT NULL,
  `nombres` varchar(30) NOT NULL,
  `apellidos` varchar(30) NOT NULL,
  `usuario` varchar(30) NOT NULL,
  `correo` varchar(30) NOT NULL,
  `contrasena` varchar(30) NOT NULL,
  `cumpleanos` date DEFAULT NULL,
  `rol` int(11) NOT NULL DEFAULT 5
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_usuarios`
--

INSERT INTO `tbl_usuarios` (`id`, `nombres`, `apellidos`, `usuario`, `correo`, `contrasena`, `cumpleanos`, `rol`) VALUES
(1, 'Julian', 'Gaitan', 'Hafgufa', 'a@b.com', 'asdASD123', '1989-10-30', 15),
(2, 'pedro', 'perez', 'pedrop', 'ac@eb.com', 'qwerQWER12', '2000-06-15', 5),
(3, 'Jon', 'Doe', 'JonhDoe', 'abc@xyz.org', 'Contrasena987', '1950-01-01', 9),
(7, 'Nombre', 'Apellido', 'usuario', 'correo@cualquiera.com', 'conTRA123', '2023-03-01', 5),
(9, 'Mi nombre', 'Mi apellido', 'MiUsuario', 'correo2@email.com', 'ASDasd23', '2023-02-01', 5);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_actividades`
--
ALTER TABLE `tbl_actividades`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `fk_modulo` (`fk_modulo`,`indice`);

--
-- Indexes for table `tbl_cronogramas`
--
ALTER TABLE `tbl_cronogramas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_idCronograma_idCurso` (`fk_curso`);

--
-- Indexes for table `tbl_cursos`
--
ALTER TABLE `tbl_cursos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_idCurso_idProfesor` (`fk_profesor`);

--
-- Indexes for table `tbl_estudiantes`
--
ALTER TABLE `tbl_estudiantes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_idEstudiante_idSuscripciones` (`suscripcion`);

--
-- Indexes for table `tbl_foros`
--
ALTER TABLE `tbl_foros`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_idForos_idCurso` (`fk_curso`),
  ADD KEY `fk_idForos_idUsuario` (`fk_autor`);

--
-- Indexes for table `tbl_inscripciones_pago`
--
ALTER TABLE `tbl_inscripciones_pago`
  ADD PRIMARY KEY (`idEstudiante`,`idCronograma`),
  ADD KEY `fk_idCronograma_tblPago` (`idCronograma`);

--
-- Indexes for table `tbl_inscripciones_suscrip`
--
ALTER TABLE `tbl_inscripciones_suscrip`
  ADD PRIMARY KEY (`idEstudiante`,`idCronograma`),
  ADD KEY `fk_idCronograma_tblSuscrip` (`idCronograma`);

--
-- Indexes for table `tbl_modulos`
--
ALTER TABLE `tbl_modulos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `fk_curso` (`fk_curso`,`indice`);

--
-- Indexes for table `tbl_profesores`
--
ALTER TABLE `tbl_profesores`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_respuestas`
--
ALTER TABLE `tbl_respuestas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_idRespuesta_idUsuario` (`fk_autor`),
  ADD KEY `fk_idRespuesta_idForo` (`fk_foro`);

--
-- Indexes for table `tbl_roles`
--
ALTER TABLE `tbl_roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_suscripciones`
--
ALTER TABLE `tbl_suscripciones`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_tarjetas_debito_credito`
--
ALTER TABLE `tbl_tarjetas_debito_credito`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `numero` (`numero`),
  ADD KEY `fk_idTarjetas_idEstudiantes` (`fk_estudiante`);

--
-- Indexes for table `tbl_usuarios`
--
ALTER TABLE `tbl_usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user` (`usuario`),
  ADD UNIQUE KEY `email` (`correo`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_actividades`
--
ALTER TABLE `tbl_actividades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_cronogramas`
--
ALTER TABLE `tbl_cronogramas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_cursos`
--
ALTER TABLE `tbl_cursos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_foros`
--
ALTER TABLE `tbl_foros`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `tbl_modulos`
--
ALTER TABLE `tbl_modulos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_respuestas`
--
ALTER TABLE `tbl_respuestas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tbl_roles`
--
ALTER TABLE `tbl_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_suscripciones`
--
ALTER TABLE `tbl_suscripciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_tarjetas_debito_credito`
--
ALTER TABLE `tbl_tarjetas_debito_credito`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tbl_usuarios`
--
ALTER TABLE `tbl_usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_actividades`
--
ALTER TABLE `tbl_actividades`
  ADD CONSTRAINT `fk_idActividad_idModulo` FOREIGN KEY (`fk_modulo`) REFERENCES `tbl_modulos` (`id`);

--
-- Constraints for table `tbl_cronogramas`
--
ALTER TABLE `tbl_cronogramas`
  ADD CONSTRAINT `fk_idCronograma_idCurso` FOREIGN KEY (`fk_curso`) REFERENCES `tbl_cursos` (`id`);

--
-- Constraints for table `tbl_cursos`
--
ALTER TABLE `tbl_cursos`
  ADD CONSTRAINT `fk_idCurso_idProfesor` FOREIGN KEY (`fk_profesor`) REFERENCES `tbl_profesores` (`id`);

--
-- Constraints for table `tbl_estudiantes`
--
ALTER TABLE `tbl_estudiantes`
  ADD CONSTRAINT `fk_idEstudiante_idSuscripciones` FOREIGN KEY (`suscripcion`) REFERENCES `tbl_suscripciones` (`id`),
  ADD CONSTRAINT `fk_idEstudiante_idUsuario` FOREIGN KEY (`id`) REFERENCES `tbl_usuarios` (`id`);

--
-- Constraints for table `tbl_foros`
--
ALTER TABLE `tbl_foros`
  ADD CONSTRAINT `fk_idForos_idCurso` FOREIGN KEY (`fk_curso`) REFERENCES `tbl_cursos` (`id`),
  ADD CONSTRAINT `fk_idForos_idUsuario` FOREIGN KEY (`fk_autor`) REFERENCES `tbl_usuarios` (`id`);

--
-- Constraints for table `tbl_inscripciones_pago`
--
ALTER TABLE `tbl_inscripciones_pago`
  ADD CONSTRAINT `fk_idCronograma_tblPago` FOREIGN KEY (`idCronograma`) REFERENCES `tbl_cronogramas` (`id`),
  ADD CONSTRAINT `fk_idEstudiante_tblPago` FOREIGN KEY (`idEstudiante`) REFERENCES `tbl_estudiantes` (`id`);

--
-- Constraints for table `tbl_inscripciones_suscrip`
--
ALTER TABLE `tbl_inscripciones_suscrip`
  ADD CONSTRAINT `fk_idCronograma_tblSuscrip` FOREIGN KEY (`idCronograma`) REFERENCES `tbl_cronogramas` (`id`),
  ADD CONSTRAINT `fk_idEstudiante_tblSuscrip` FOREIGN KEY (`idEstudiante`) REFERENCES `tbl_estudiantes` (`id`);

--
-- Constraints for table `tbl_modulos`
--
ALTER TABLE `tbl_modulos`
  ADD CONSTRAINT `fk_idModulo_idCurso` FOREIGN KEY (`fk_curso`) REFERENCES `tbl_cursos` (`id`);

--
-- Constraints for table `tbl_profesores`
--
ALTER TABLE `tbl_profesores`
  ADD CONSTRAINT `fk_idProfesor_idUsuario` FOREIGN KEY (`id`) REFERENCES `tbl_usuarios` (`id`);

--
-- Constraints for table `tbl_respuestas`
--
ALTER TABLE `tbl_respuestas`
  ADD CONSTRAINT `fk_idRespuesta_idForo` FOREIGN KEY (`fk_foro`) REFERENCES `tbl_foros` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_idRespuesta_idUsuario` FOREIGN KEY (`fk_autor`) REFERENCES `tbl_usuarios` (`id`);

--
-- Constraints for table `tbl_tarjetas_debito_credito`
--
ALTER TABLE `tbl_tarjetas_debito_credito`
  ADD CONSTRAINT `fk_idTarjetas_idEstudiantes` FOREIGN KEY (`fk_estudiante`) REFERENCES `tbl_estudiantes` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
