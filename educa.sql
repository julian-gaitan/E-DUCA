-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 11, 2023 at 05:10 AM
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
-- Table structure for table `tbl_cronogramas`
--

CREATE TABLE `tbl_cronogramas` (
  `id` int(11) NOT NULL,
  `fk_curso` int(11) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `duracion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_cronogramas`
--

INSERT INTO `tbl_cronogramas` (`id`, `fk_curso`, `fecha_inicio`, `fecha_fin`, `duracion`) VALUES
(1, 1, '2023-12-15', '2024-03-15', 60),
(2, 1, '0000-00-00', '0000-00-00', 90),
(3, 2, '2023-12-01', '2024-02-25', 45),
(4, 3, '0000-00-00', '0000-00-00', 30);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_cursos`
--

CREATE TABLE `tbl_cursos` (
  `id` int(11) NOT NULL,
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

INSERT INTO `tbl_cursos` (`id`, `nombre`, `descripcion`, `lista_contenido`, `lista_categoria`, `tags`, `carpeta`) VALUES
(1, 'HTML5, CSS3 Y JavaScript', 'Aprende HTML5, CSS3 Y JavaScript de manera rápida y efectiva.', 'HTML\r\nFormularios\r\nCSS3\r\nFlexBox\r\nJavaScript\r\nDOM', 'Software Web\r\nJavaScript', 'HTML\r\nCSS\r\nJavaScript', '1702264978-835'),
(2, 'jQuery desde 0', 'Aprenda jQuery desde los conceptos básicos hasta un manejo avanzado del lenguaje.', 'Selectores\nAtributos\nEventos\nEfectos\nAjax', 'Desarrollo Web\njQuery', 'JavaScript\njQuery', '1702265941-624'),
(3, 'Tomcat para Administradores', 'Aprende a usar el servidor web Tomcat para todo tipo de aplicaciones', 'Instalación\r\nConfiguración\r\nApache Web Server\r\nDespliegue\r\nClusters', 'Desarrollo Web\r\nTomcat', 'Apache\r\nWebServer\r\nTomcat', '1702266769-545');

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
(2, 4, 'ESTUDIANTE', '', ''),
(3, 8, 'PROFESOR', '', '');

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
  `rol` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_usuarios`
--

INSERT INTO `tbl_usuarios` (`id`, `nombres`, `apellidos`, `usuario`, `correo`, `contrasena`, `cumpleanos`, `rol`) VALUES
(1, 'mister', 'admin', 'ADMIN', 'a@b.com', 'asdASD123', '2023-12-31', 15),
(2, 'pedro', 'perez', 'pedrop', 'ac@eb.com', 'qwerQWER12', '2000-06-15', 5),
(3, 'Jonh', 'Doe', 'JonDoe', 'abc@xyz.org', 'Contrasena987', '1950-01-01', 9);

--
-- Indexes for dumped tables
--

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
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_roles`
--
ALTER TABLE `tbl_roles`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `tbl_cronogramas`
--
ALTER TABLE `tbl_cronogramas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_cursos`
--
ALTER TABLE `tbl_cursos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_roles`
--
ALTER TABLE `tbl_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_usuarios`
--
ALTER TABLE `tbl_usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_cronogramas`
--
ALTER TABLE `tbl_cronogramas`
  ADD CONSTRAINT `fk_idCronograma_idCurso` FOREIGN KEY (`fk_curso`) REFERENCES `tbl_cursos` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
