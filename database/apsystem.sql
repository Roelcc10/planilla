-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-04-2021 a las 18:08:19
-- Versión del servidor: 10.4.14-MariaDB
-- Versión de PHP: 7.3.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `apsystem`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(60) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `photo` varchar(200) NOT NULL,
  `created_on` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `firstname`, `lastname`, `photo`, `created_on`) VALUES
(1, 'admin', '$2y$10$QVf.WddIXKmjG0ZdKrH5NudBkFBTg93GZvvDN6VYxEMzXVSbjThUO', 'Roel Admin', 'CCte', '1614273532.jpg', '2018-04-30');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `afp`
--

CREATE TABLE `afp` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `afp`
--

INSERT INTO `afp` (`id`, `name`) VALUES
(1, 'HABITAT'),
(2, 'INTEGRA'),
(3, 'PRIMA'),
(4, 'PROFUTURO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `time_in` time NOT NULL,
  `inLaunch` time NOT NULL,
  `outLaunch` time NOT NULL,
  `status` int(1) NOT NULL,
  `statusFilter` int(11) NOT NULL,
  `type_check` varchar(250) NOT NULL,
  `time_out` time NOT NULL,
  `num_hr` double NOT NULL,
  `feriadotrabajado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `attendance`
--

INSERT INTO `attendance` (`id`, `employee_id`, `date`, `time_in`, `inLaunch`, `outLaunch`, `status`, `statusFilter`, `type_check`, `time_out`, `num_hr`, `feriadotrabajado`) VALUES
(122, 28, '2021-04-09', '08:00:00', '00:00:00', '00:00:00', 1, 4, 'offline', '21:00:00', 3, 0),
(124, 29, '2021-03-01', '09:00:00', '00:00:00', '00:00:00', 1, 4, 'offline', '18:00:00', 8, 0),
(126, 29, '2021-03-02', '09:00:00', '09:00:00', '09:00:00', 1, 4, 'offline', '18:00:00', 8, 0),
(127, 29, '2021-03-03', '09:00:00', '09:00:00', '09:00:00', 1, 4, 'offline', '18:00:00', 8, 0),
(128, 29, '2021-03-04', '09:00:00', '09:00:00', '09:00:00', 1, 4, 'offline', '18:00:00', 8, 0),
(129, 29, '2021-03-05', '09:00:00', '09:00:00', '09:00:00', 1, 4, 'offline', '18:00:00', 8, 0),
(130, 29, '2021-03-06', '09:00:00', '09:00:00', '09:00:00', 1, 4, 'offline', '18:00:00', 8, 0),
(131, 29, '2021-03-07', '09:00:00', '00:00:00', '00:00:00', 1, 4, 'offline', '17:00:00', 8, 0),
(132, 29, '2021-03-08', '09:00:00', '09:00:00', '09:00:00', 1, 4, 'offline', '18:00:00', 8, 0),
(133, 29, '2021-03-09', '09:00:00', '09:00:00', '09:00:00', 1, 4, 'offline', '18:00:00', 8, 0),
(134, 29, '2021-03-10', '09:00:00', '09:00:00', '09:00:00', 1, 4, 'offline', '18:00:00', 8, 0),
(135, 29, '2021-03-11', '09:00:00', '09:00:00', '09:00:00', 1, 4, 'offline', '18:00:00', 8, 0),
(136, 29, '2021-03-12', '09:00:00', '09:00:00', '09:00:00', 1, 4, 'offline', '18:00:00', 8, 0),
(137, 29, '2021-03-13', '09:00:00', '09:00:00', '09:00:00', 1, 4, 'offline', '18:00:00', 8, 0),
(139, 29, '2021-03-15', '09:00:00', '09:00:00', '09:00:00', 1, 4, 'offline', '18:00:00', 4, 0),
(140, 29, '2021-03-16', '09:00:00', '09:00:00', '09:00:00', 1, 4, 'offline', '18:00:00', 8, 0),
(141, 29, '2021-03-17', '09:00:00', '09:00:00', '09:00:00', 1, 4, 'offline', '18:00:00', 8, 0),
(142, 29, '2021-03-18', '09:00:00', '09:00:00', '09:00:00', 1, 4, 'offline', '18:00:00', 8, 0),
(143, 29, '2021-03-19', '09:00:00', '09:00:00', '09:00:00', 1, 4, 'offline', '18:00:00', 8, 0),
(144, 29, '2021-03-20', '09:00:00', '09:00:00', '09:00:00', 1, 4, 'offline', '18:00:00', 8, 0),
(146, 29, '2021-03-22', '09:00:00', '09:00:00', '09:00:00', 1, 4, 'offline', '18:00:00', 8, 0),
(147, 29, '2021-03-23', '09:00:00', '09:00:00', '09:00:00', 1, 4, 'offline', '18:00:00', 8, 0),
(148, 29, '2021-03-24', '09:00:00', '09:00:00', '09:00:00', 1, 4, 'offline', '18:00:00', 8, 0),
(149, 29, '2021-03-25', '09:00:00', '09:00:00', '09:00:00', 1, 4, 'offline', '18:00:00', 8, 0),
(150, 29, '2021-03-26', '09:00:00', '09:00:00', '09:00:00', 1, 4, 'offline', '18:00:00', 8, 0),
(151, 29, '2021-03-27', '09:00:00', '09:00:00', '09:00:00', 1, 4, 'offline', '18:00:00', 8, 0),
(153, 29, '2021-03-29', '09:00:00', '09:00:00', '09:00:00', 1, 4, 'offline', '18:00:00', 8, 0),
(154, 29, '2021-03-30', '09:00:00', '09:00:00', '09:00:00', 1, 4, 'offline', '18:00:00', 8, 0),
(155, 29, '2021-03-31', '09:00:00', '09:00:00', '09:00:00', 1, 4, 'offline', '18:00:00', 8, 0),
(158, 29, '2021-04-01', '09:00:00', '00:00:00', '00:00:00', 1, 4, '4', '17:00:00', 8, 0),
(159, 29, '2021-04-02', '09:00:00', '00:00:00', '00:00:00', 1, 4, '4', '17:00:00', 8, 0),
(160, 29, '2021-04-03', '09:00:00', '00:00:00', '00:00:00', 1, 4, '4', '17:00:00', 8, 0),
(161, 29, '2021-04-04', '09:00:00', '00:00:00', '00:00:00', 1, 4, '4', '17:00:00', 8, 0),
(162, 29, '2021-04-05', '09:00:00', '00:00:00', '00:00:00', 1, 4, '4', '17:00:00', 8, 0),
(163, 29, '2021-04-06', '09:00:00', '00:00:00', '00:00:00', 1, 4, '4', '17:00:00', 8, 0),
(164, 29, '2021-04-07', '09:00:00', '00:00:00', '00:00:00', 1, 4, '4', '17:00:00', 8, 0),
(165, 29, '2021-04-08', '09:00:00', '00:00:00', '00:00:00', 1, 4, '4', '17:00:00', 8, 0),
(166, 29, '2021-04-10', '09:00:00', '00:00:00', '00:00:00', 1, 4, '4', '17:00:00', 8, 0),
(168, 29, '2021-04-12', '09:00:00', '00:00:00', '00:00:00', 1, 4, '4', '17:00:00', 8, 0),
(169, 29, '2021-04-13', '09:00:00', '00:00:00', '00:00:00', 1, 4, '4', '17:00:00', 8, 0),
(170, 29, '2021-04-14', '09:00:00', '00:00:00', '00:00:00', 1, 4, '4', '17:00:00', 8, 0),
(171, 29, '2021-04-15', '09:00:00', '00:00:00', '00:00:00', 1, 4, '4', '17:00:00', 8, 0),
(172, 29, '2021-04-16', '09:00:00', '00:00:00', '00:00:00', 1, 4, '4', '17:00:00', 8, 0),
(173, 29, '2021-04-17', '09:00:00', '00:00:00', '00:00:00', 1, 4, '4', '17:00:00', 8, 0),
(174, 29, '2021-04-18', '09:00:00', '00:00:00', '00:00:00', 1, 4, '4', '17:00:00', 8, 0),
(175, 29, '2021-04-19', '09:00:00', '00:00:00', '00:00:00', 1, 4, '4', '17:00:00', 8, 0),
(176, 29, '2021-04-20', '09:00:00', '00:00:00', '00:00:00', 1, 4, '4', '17:00:00', 8, 0),
(177, 29, '2021-04-21', '09:00:00', '00:00:00', '00:00:00', 1, 4, '4', '17:00:00', 8, 0),
(178, 29, '2021-04-22', '09:00:00', '00:00:00', '00:00:00', 1, 4, '4', '17:00:00', 8, 0),
(179, 29, '2021-04-23', '09:00:00', '00:00:00', '00:00:00', 1, 4, '4', '17:00:00', 8, 0),
(180, 29, '2021-04-24', '09:00:00', '00:00:00', '00:00:00', 1, 4, '4', '17:00:00', 8, 0),
(181, 29, '2021-04-25', '09:00:00', '00:00:00', '00:00:00', 1, 4, '4', '17:00:00', 8, 0),
(182, 29, '2021-04-26', '09:00:00', '00:00:00', '00:00:00', 1, 4, '4', '17:00:00', 8, 0),
(183, 29, '2021-04-27', '09:00:00', '00:00:00', '00:00:00', 1, 4, '4', '17:00:00', 8, 0),
(185, 29, '2021-04-29', '09:00:00', '00:00:00', '00:00:00', 1, 4, '4', '17:00:00', 8, 0),
(186, 29, '2021-04-30', '09:00:00', '00:00:00', '00:00:00', 1, 4, '4', '17:00:00', 8, 0),
(187, 29, '2021-04-11', '15:38:34', '00:00:00', '00:00:00', 1, 4, 'offline', '15:44:41', 8, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `break`
--

CREATE TABLE `break` (
  `id` int(11) NOT NULL,
  `break` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `break`
--

INSERT INTO `break` (`id`, `break`) VALUES
(1, 'Monday'),
(2, 'Tuesday'),
(3, 'Wednesday'),
(4, 'Thursday'),
(5, 'Friday'),
(6, 'Saturday'),
(7, 'Sunday');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cashadvance`
--

CREATE TABLE `cashadvance` (
  `id` int(11) NOT NULL,
  `date_advance` date NOT NULL,
  `employee_id` varchar(15) NOT NULL,
  `amount` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `cashadvance`
--

INSERT INTO `cashadvance` (`id`, `date_advance`, `employee_id`, `amount`) VALUES
(12, '2021-04-10', '29', 50),
(13, '2021-04-11', '29', 250);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `days`
--

CREATE TABLE `days` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `days`
--

INSERT INTO `days` (`id`, `name`) VALUES
(1, 'Monday'),
(2, 'Tuesday'),
(3, 'Wednesday'),
(4, 'Thursday'),
(5, 'Friday'),
(6, 'Saturday'),
(7, 'Sunday');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `deductions`
--

CREATE TABLE `deductions` (
  `id` int(11) NOT NULL,
  `description` varchar(100) NOT NULL,
  `amount` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `deductions`
--

INSERT INTO `deductions` (`id`, `description`, `amount`) VALUES
(1, 'SSS', 100),
(2, 'Pagibig', 150),
(3, 'PhilHealth', 150),
(4, 'Project Issues', 1500),
(5, 'Descripcion de prueba', 150);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `descuentos_sbs`
--

CREATE TABLE `descuentos_sbs` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `slug` varchar(250) NOT NULL,
  `percentage` float NOT NULL,
  `afp_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `descuentos_sbs`
--

INSERT INTO `descuentos_sbs` (`id`, `name`, `slug`, `percentage`, `afp_id`) VALUES
(1, 'Comisión Fija', 'comision_fija', 0, 1),
(2, 'Comisión Sobre Flujo', 'comision_sobre_flujo', 1.47, 1),
(3, 'Comisión Sobre Flujo Mixta', 'comision_sobre_flujo_mixta', 0.23, 1),
(4, 'Comisión Anual Sobre Saldo', 'comision_anual_sobre_saldo', 1.25, 1),
(5, 'Prima de Seguros', 'prima_seguros', 1.74, 1),
(6, 'Aporte Obligatorio al Fondo de Pensiones', 'aporte_fondo_pensiones', 10, 1),
(7, 'Comisión Fija', 'comision_fija', 0, 2),
(8, 'Comisión Sobre Flujo', 'comision_sobre_flujo', 1.55, 2),
(9, 'Comisión Sobre Flujo Mixta', 'comision_sobre_flujo_mixta', 0, 2),
(10, 'Comisión Anual Sobre Saldo', 'comision_anual_sobre_saldo', 0.82, 2),
(11, 'Prima de Seguros', 'prima_seguros', 1.74, 2),
(12, 'Aporte Obligatorio al Fondo de Pensiones', 'aporte_fondo_pensiones', 10, 2),
(13, 'Comisión Fija', 'comision_fija', 0, 3),
(14, 'Comisión Sobre Flujo', 'comision_sobre_flujo', 1.6, 3),
(15, 'Comisión Sobre Flujo Mixta', 'comision_sobre_flujo_mixta', 0.18, 3),
(16, 'Comisión Anual Sobre Saldo', 'comision_anual_sobre_saldo', 1.25, 3),
(17, 'Prima de Seguros', 'prima_seguros', 1.74, 3),
(18, 'Aporte Obligatorio al Fondo de Pensiones', 'aporte_fondo_pensiones', 10, 3),
(19, 'Comisión Fija', 'comision_fija', 0, 4),
(20, 'Comisión Sobre Flujo', 'comision_sobre_flujo', 1.69, 4),
(21, 'Comisión Sobre Flujo Mixta', 'comision_sobre_flujoo_mixta', 0.28, 4),
(22, 'Comisión Anual Sobre Saldo', 'comision_anual_sobre_saldo', 1.2, 4),
(23, 'Prima de Seguros', 'prima_seguros', 1.74, 4),
(24, 'Aporte Obligatorio al Fondo de Pensiones', 'aporte_fondo_pensiones', 10, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `employee_id` varchar(15) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `address` text NOT NULL,
  `birthdate` date NOT NULL,
  `contact_info` varchar(100) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `position_id` int(11) NOT NULL,
  `schedule_id` int(11) NOT NULL,
  `break_id` int(11) NOT NULL,
  `afp_id` int(11) NOT NULL,
  `empresa_id` int(11) NOT NULL,
  `photo` varchar(200) NOT NULL,
  `created_on` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `employees`
--

INSERT INTO `employees` (`id`, `employee_id`, `firstname`, `lastname`, `address`, `birthdate`, `contact_info`, `gender`, `position_id`, `schedule_id`, `break_id`, `afp_id`, `empresa_id`, `photo`, `created_on`) VALUES
(28, 'VGQ296451380', 'Roel', 'CCente', 'Av. Jose Olaya 1480', '2021-03-16', '972419891', 'Male', 2, 1, 7, 1, 2, '', '2021-03-27'),
(29, 'VYB039648125', 'Fernando', 'Moreno', 'qwer', '2021-04-12', '12341234', 'Male', 1, 5, 3, 2, 1, '', '2021-04-09'),
(30, 'VWS782930145', 'Hildeliza', 'Peña', 'Calle 20 noviembre 240B', '2021-04-20', '12341234', 'Female', 2, 1, 0, 2, 2, '', '2021-04-17');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresas`
--

CREATE TABLE `empresas` (
  `id` int(11) NOT NULL,
  `nombre` varchar(350) NOT NULL,
  `descripcion` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `empresas`
--

INSERT INTO `empresas` (`id`, `nombre`, `descripcion`) VALUES
(1, 'PRUEBA 1', 'Prueba'),
(2, 'Prueba 2', 'Prueba');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `festiv`
--

CREATE TABLE `festiv` (
  `id` int(11) NOT NULL,
  `date_festive` date NOT NULL,
  `name` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `festiv`
--

INSERT INTO `festiv` (`id`, `date_festive`, `name`) VALUES
(2, '2021-04-19', 'Papa'),
(3, '2021-04-09', 'asdfad '),
(4, '2021-04-17', 'Papa'),
(6, '2021-04-24', 'asdfasd f'),
(7, '2021-04-30', 'Dia del niñó');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `overtime`
--

CREATE TABLE `overtime` (
  `id` int(11) NOT NULL,
  `employee_id` varchar(15) NOT NULL,
  `hours` double NOT NULL,
  `rate` double NOT NULL,
  `date_overtime` date NOT NULL,
  `approved_admin` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `overtime`
--

INSERT INTO `overtime` (`id`, `employee_id`, `hours`, `rate`, `date_overtime`, `approved_admin`) VALUES
(21, '28', 5, 25, '2021-04-09', 0),
(23, '29', 10, 25, '2021-04-14', 1),
(24, '29', 3, 25, '2021-04-15', 1),
(25, '29', 3, 25, '2021-03-28', 1),
(27, '28', 2, 20, '2031-11-08', 1),
(28, '28', 2, 20, '2031-11-08', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `position`
--

CREATE TABLE `position` (
  `id` int(11) NOT NULL,
  `description` varchar(150) NOT NULL,
  `rate` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `position`
--

INSERT INTO `position` (`id`, `description`, `rate`) VALUES
(1, 'Programmer', 100),
(2, 'Writer', 50),
(3, 'Marketing ', 35),
(4, 'Graphic Designer', 75),
(5, 'prueba', 80);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `schedules`
--

CREATE TABLE `schedules` (
  `id` int(11) NOT NULL,
  `time_in` time NOT NULL,
  `time_out` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `schedules`
--

INSERT INTO `schedules` (`id`, `time_in`, `time_out`) VALUES
(1, '07:00:00', '15:00:00'),
(2, '08:00:00', '17:00:00'),
(3, '09:00:00', '18:00:00'),
(4, '10:00:00', '19:00:00'),
(5, '04:15:00', '09:15:00'),
(6, '08:30:00', '15:30:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `weekschedules`
--

CREATE TABLE `weekschedules` (
  `id` int(11) NOT NULL,
  `date_work` varchar(250) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `hours` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `weekschedules`
--

INSERT INTO `weekschedules` (`id`, `date_work`, `employee_id`, `hours`) VALUES
(22, 'Monday', 28, 8),
(23, 'Tuesday', 28, 8),
(24, 'Wednesday', 28, 8),
(25, 'Thursday', 28, 8),
(26, 'Friday', 28, 8),
(27, 'Saturday', 28, 4),
(28, 'Sunday', 28, 0),
(29, 'Monday', 29, 8),
(30, 'Tuesday', 29, 8),
(31, 'Wednesday', 29, 8),
(32, 'Thursday', 29, 8),
(33, 'Friday', 29, 8),
(34, 'Saturday', 29, 4),
(35, 'Sunday', 29, 0),
(36, 'Monday', 30, 5),
(37, 'Tuesday', 30, 8),
(38, 'Wednesday', 30, 8),
(39, 'Thursday', 30, 8),
(40, 'Friday', 30, 8),
(41, 'Saturday', 30, 5),
(42, 'Sunday', 30, 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `afp`
--
ALTER TABLE `afp`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `break`
--
ALTER TABLE `break`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cashadvance`
--
ALTER TABLE `cashadvance`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `days`
--
ALTER TABLE `days`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `deductions`
--
ALTER TABLE `deductions`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `descuentos_sbs`
--
ALTER TABLE `descuentos_sbs`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `empresas`
--
ALTER TABLE `empresas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `festiv`
--
ALTER TABLE `festiv`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `overtime`
--
ALTER TABLE `overtime`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `position`
--
ALTER TABLE `position`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `weekschedules`
--
ALTER TABLE `weekschedules`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `afp`
--
ALTER TABLE `afp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=188;

--
-- AUTO_INCREMENT de la tabla `break`
--
ALTER TABLE `break`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `cashadvance`
--
ALTER TABLE `cashadvance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `days`
--
ALTER TABLE `days`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `deductions`
--
ALTER TABLE `deductions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `descuentos_sbs`
--
ALTER TABLE `descuentos_sbs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `empresas`
--
ALTER TABLE `empresas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `festiv`
--
ALTER TABLE `festiv`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `overtime`
--
ALTER TABLE `overtime`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de la tabla `position`
--
ALTER TABLE `position`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `schedules`
--
ALTER TABLE `schedules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `weekschedules`
--
ALTER TABLE `weekschedules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
