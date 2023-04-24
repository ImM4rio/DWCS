-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 15-02-2022 a las 21:54:31
-- Versión del servidor: 10.4.21-MariaDB
-- Versión de PHP: 8.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tarea4.5`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentarios`
--

CREATE TABLE `comentarios` (
  `usuario` varchar(30) COLLATE utf8mb4_spanish_ci NOT NULL,
  `comentario` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
  `data` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `produto`
--

CREATE TABLE `produto` (
  `idProduto` int(11) NOT NULL,
  `nome` varchar(30) COLLATE utf8mb4_spanish_ci NOT NULL,
  `descricion` varchar(400) COLLATE utf8mb4_spanish_ci NOT NULL,
  `prezo` int(11) NOT NULL,
  `imaxe` varchar(30) COLLATE utf8mb4_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `produto`
--

INSERT INTO `produto` (`idProduto`, `nome`, `descricion`, `prezo`, `imaxe`) VALUES
(1, 'tomate', 'tomate en rama', 2, 'tomate.jpg'),
(2, 'pera', 'pera conferencia', 2, 'pera.jpg'),
(3, 'manzana', 'manzana golden', 2, 'manzana.jpg'),
(4, 'manzana', 'manzana roja', 2, 'manzanaRoja.jpg'),
(5, 'plátano', 'plátano de canarias', 3, 'canarias.jpg'),
(6, 'banana', 'banana', 1, 'banana.jpg'),
(7, 'kiwi', 'kiwi australiano', 3, 'kiwi.jpg'),
(8, 'mango', 'mango', 4, 'mango.jpg'),
(9, 'melón', 'melón piel de sapo', 4, 'melon.jpg'),
(10, 'sandía', 'sandía roja', 3, 'sandia.jpg'),
(11, 'fresa', 'fresón de palos', 3, 'fresa.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `nome` varchar(30) COLLATE utf8mb4_spanish_ci NOT NULL,
  `contrasinal` varchar(255) COLLATE utf8mb4_spanish_ci NOT NULL,
  `nomeCompleto` varchar(40) COLLATE utf8mb4_spanish_ci NOT NULL,
  `email` varchar(30) COLLATE utf8mb4_spanish_ci NOT NULL,
  `data` datetime NOT NULL,
  `rol` varchar(20) COLLATE utf8mb4_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`nome`, `contrasinal`, `nomeCompleto`, `email`, `data`, `rol`) VALUES
('admin', '$2y$10$0UXJY.2ouTOcJltBdSVBk.Nb8oc.xgeKUmmtOXY7ZWRDKPZy8tL7S', '', '', '2022-02-14 22:05:05', 'administrador'),
('mario', '$2y$10$kyU265.DLtZBJa5.JP.0/.bSptnDXAmj7NgTuxNf2WnFLvQb1PTDa', 'mario', 'mario@hotmail.com', '2022-02-14 22:03:24', 'administrador'),
('pepe', '$2y$10$r5aaONEzye4zhcpFcYMo3O6nHma2KO2upbPxKCCXUEA0tqghCyD7W', 'pepe', 'pepe@hotmail.com', '2022-02-15 20:48:10', 'usuario');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `produto`
--
ALTER TABLE `produto`
  ADD PRIMARY KEY (`idProduto`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`nome`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
