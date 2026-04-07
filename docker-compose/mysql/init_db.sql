-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 05-04-2026 a las 21:08:39
-- Versión del servidor: 10.11.16-MariaDB-log
-- Versión de PHP: 8.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `flynowwe_recibo`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2022_12_18_140919_create_permission_tables', 1),
(6, '2023_01_04_201350_create_personas_table', 1),
(7, '2023_03_18_032857_create_recibos_table', 1),
(8, '2025_05_24_201408_add_estado_column_to_recibos_table', 2),
(9, '2025_05_25_001135_add_is_active_column_to_users_table', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'users', 'web', '2025-05-25 03:23:26', '2025-05-25 03:23:26'),
(2, 'user.create', 'web', '2025-05-25 03:23:26', '2025-05-25 03:23:26'),
(3, 'user.edit', 'web', '2025-05-25 03:23:26', '2025-05-25 03:23:26'),
(4, 'user.update', 'web', '2025-05-25 03:23:26', '2025-05-25 03:23:26'),
(5, 'user.store', 'web', '2025-05-25 03:23:26', '2025-05-25 03:23:26'),
(6, 'user.destroy', 'web', '2025-05-25 03:23:26', '2025-05-25 03:23:26'),
(7, 'user.show', 'web', '2025-05-25 03:23:26', '2025-05-25 03:23:26'),
(8, 'profile.edit', 'web', '2025-05-25 03:23:26', '2025-05-25 03:23:26'),
(9, 'profile.update', 'web', '2025-05-25 03:23:26', '2025-05-25 03:23:26'),
(10, 'profile.destroy', 'web', '2025-05-25 03:23:26', '2025-05-25 03:23:26');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personas`
--

CREATE TABLE `personas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombres` varchar(40) NOT NULL,
  `ap_paterno` varchar(30) DEFAULT NULL,
  `ap_materno` varchar(30) DEFAULT NULL,
  `ci` bigint(20) DEFAULT NULL,
  `complemento` varchar(7) DEFAULT NULL,
  `expedido` varchar(3) DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `genero` varchar(20) DEFAULT NULL,
  `titulo` varchar(10) DEFAULT NULL,
  `ocupacion_profesion` varchar(50) DEFAULT NULL,
  `domicilio` varchar(255) DEFAULT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `personas`
--

INSERT INTO `personas` (`id`, `nombres`, `ap_paterno`, `ap_materno`, `ci`, `complemento`, `expedido`, `fecha_nacimiento`, `genero`, `titulo`, `ocupacion_profesion`, `domicilio`, `telefono`, `foto`, `active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Basilia', 'Llica', '', NULL, NULL, NULL, NULL, NULL, 'Sra.', NULL, NULL, NULL, NULL, 0, '2024-03-17 02:15:20', '2024-03-17 02:15:20', NULL),
(2, 'Miguel A.', 'Lima', 'Yupanqui', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2024-03-17 02:48:43', '2024-03-17 02:48:43', NULL),
(3, 'Victoria', 'Aquise', 'Zapana', NULL, NULL, NULL, NULL, NULL, 'Sra.', NULL, NULL, NULL, NULL, 0, '2024-05-28 01:36:08', '2024-05-28 01:36:08', NULL),
(4, 'Freddy', 'Lima', 'Yupanqui', NULL, NULL, NULL, NULL, NULL, 'Sr.', NULL, NULL, NULL, NULL, 0, '2024-07-22 00:49:22', '2024-07-22 00:49:22', NULL),
(5, 'Marcos Ivan', 'Cori', 'Parada', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2024-07-27 22:52:52', '2024-07-27 22:52:52', NULL),
(6, 'Meylin', 'Lecon', 'Ayaviri', NULL, NULL, NULL, NULL, NULL, 'Sra.', NULL, NULL, NULL, NULL, 0, '2025-03-10 00:53:01', '2025-03-10 00:53:01', NULL),
(7, 'Juan Eloy', 'Carvajal', 'Ayaviri', NULL, NULL, NULL, NULL, NULL, 'Sr.', NULL, NULL, NULL, NULL, 0, '2025-09-13 17:09:47', '2025-09-13 17:09:47', NULL),
(8, 'Julia', 'Quispe', 'Mamani', NULL, NULL, NULL, NULL, NULL, 'Sra.', 'Estudiante', NULL, NULL, NULL, 0, '2025-09-27 12:54:59', '2025-09-27 13:07:10', NULL),
(9, 'Freddy Gabriel', 'Anze', 'Moreira', NULL, NULL, NULL, NULL, NULL, 'Sr.', NULL, NULL, NULL, NULL, 0, '2025-12-12 12:59:25', '2025-12-12 12:59:25', NULL),
(10, 'Alex', 'Rojas', 'Ayaviri', NULL, NULL, NULL, NULL, NULL, 'Sr.', NULL, NULL, NULL, NULL, 0, '2026-03-21 15:43:31', '2026-03-21 15:43:31', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recibos`
--

CREATE TABLE `recibos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nro_serie` int(11) NOT NULL,
  `hash` varchar(255) NOT NULL,
  `fecha` date NOT NULL,
  `cliente_id` int(11) NOT NULL,
  `moneda` varchar(10) NOT NULL DEFAULT 'BS',
  `cantidad` decimal(8,2) NOT NULL,
  `cantidad_literal` varchar(255) DEFAULT NULL,
  `concepto` varchar(255) NOT NULL,
  `observaciones` varchar(255) DEFAULT NULL,
  `estado` tinyint(3) UNSIGNED NOT NULL DEFAULT 1 COMMENT '0 = Anulado, 1 = Registrado, 2 = Aprobado',
  `user_id` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `recibos`
--

INSERT INTO `recibos` (`id`, `nro_serie`, `hash`, `fecha`, `cliente_id`, `moneda`, `cantidad`, `cantidad_literal`, `concepto`, `observaciones`, `estado`, `user_id`, `created_at`, `updated_at`) VALUES
(31, 31, '8b4d240e900141f4841021d57f9add15', '2024-01-13', 2, 'BS', 600.00, 'Seiscientos con 00/100 Bs', 'Alquiler del mes de enero (tres cuartos)', NULL, 1, '2', '2024-03-17 02:52:23', '2024-03-17 03:01:50'),
(32, 32, '046c937d3bc95aaf1c76099679194c45', '2024-02-11', 2, 'BS', 600.00, 'Seiscientos con 00/100 Bs', 'Alquiler del mes de febrero (tres cuartos)', NULL, 1, '2', '2024-03-17 03:01:36', '2024-03-17 03:01:36'),
(33, 33, '7f449a6713da448b296cba4393e3c55b', '2024-02-23', 1, 'BS', 560.00, 'Quinientos sesenta con 00/100 Bs', 'Pago de alquiler y servicios básicos correspondientes al mes de Enero', NULL, 1, '1', '2024-03-17 03:07:44', '2024-03-17 03:07:44'),
(34, 34, '1c321347d818a6325f7ff75a65577e68', '2024-03-17', 2, 'BS', 850.00, 'Ochocientos cincuenta con 00/100 Bs', 'Alquiler del mes de marzo (cuatro cuartos)', NULL, 1, '2', '2024-03-17 17:00:09', '2024-03-17 17:00:09'),
(35, 35, 'b34e1629412615b86c113e1499f3e3e6', '2024-04-21', 2, 'BS', 850.00, 'Ochocientos cincuenta con 00/100 Bs', 'Alquiler del mes de abril (cuatro cuartos)', NULL, 1, '2', '2024-04-21 19:21:08', '2024-04-21 19:21:22'),
(36, 36, 'a89337020bb9e1205acc71b3517376ba', '2024-04-25', 1, 'BS', 560.00, 'Quinientos sesenta con 00/100 Bs', 'Pago de alquiler y servicios básicos correspondientes al mes de Febrero', NULL, 1, '1', '2024-04-27 17:18:28', '2024-04-27 17:18:28'),
(37, 37, '154ecd4433547f55b1c60a8b831e1d1d', '2024-04-28', 3, 'BS', 550.00, 'Quinientos cincuenta con 00/100 Bs', 'Garantía un cuarto y una cocina', NULL, 1, '2', '2024-05-28 01:42:42', '2024-05-28 01:42:42'),
(38, 38, '154ecd4433547f55b1c60a8b831e1d1d', '2024-04-28', 3, 'BS', 550.00, 'Quinientos cincuenta con 00/100 Bs', 'Pago de alquiler (1 cuarto y 1 cocina) y servicios básicos correspondientes al mes de Mayo', NULL, 1, '2', '2024-05-28 01:44:21', '2024-05-28 01:44:21'),
(39, 39, 'be515843731df2a9bb0e5b22689e4275', '2024-05-27', 1, 'BS', 560.00, 'Quinientos sesenta con 00/100 Bs', 'Pago de alquiler y servicios básicos correspondientes al mes de Marzo', NULL, 1, '1', '2024-05-28 01:44:59', '2024-05-28 01:44:59'),
(40, 40, 'be515843731df2a9bb0e5b22689e4275', '2024-05-27', 1, 'BS', 560.00, 'Quinientos sesenta con 00/100 Bs', 'Pago de alquiler y servicios básicos correspondientes al mes de Abril', NULL, 1, '1', '2024-05-28 01:45:27', '2024-05-28 01:45:27'),
(41, 41, '23659606173ac1ad128228fa3a1361a1', '2024-06-02', 2, 'BS', 850.00, 'Ochocientos cincuenta con 00/100 Bs', 'Alquiler del mes de mayo (cuatro cuartos)', NULL, 1, '1', '2024-06-04 22:11:07', '2024-06-04 22:11:07'),
(42, 42, '3d0f4968e6c074e1e720aa3ea8db6e00', '2024-06-28', 1, 'BS', 560.00, 'Quinientos sesenta con 00/100 Bs', 'Pago de alquiler y servicios básicos correspondientes al mes de Mayo', NULL, 1, '1', '2024-06-30 00:06:23', '2024-06-30 00:06:23'),
(43, 43, '86dfd752c3f1aa9cf459f37811425c4f', '2024-07-02', 4, 'BS', 430.00, 'Cuatrocientos treinta con 00/100 Bs', 'Alquiler del mes de julio (dos cuartos)', NULL, 1, '3', '2024-07-22 00:34:12', '2024-07-22 00:50:59'),
(44, 44, '86dfd752c3f1aa9cf459f37811425c4f', '2024-07-21', 2, 'BS', 650.00, 'Seiscientos cincuenta con 00/100 Bs', 'Alquiler del mes de junio (tres cuartos)', NULL, 1, '3', '2024-07-22 00:34:50', '2024-07-22 00:58:18'),
(45, 45, '86dfd752c3f1aa9cf459f37811425c4f', '2024-07-21', 2, 'BS', 650.00, 'Seiscientos cincuenta con 00/100 Bs', 'Alquiler del mes de julio (tres cuartos)', NULL, 1, '3', '2024-07-22 00:51:45', '2024-07-22 00:51:45'),
(46, 46, '4a49fd7661b612999d48ccc5b97e8814', '2024-07-25', 5, 'BS', 500.00, 'Quinientos con 00/100 Bs', 'Garantía un cuarto y una cocina', NULL, 1, '2', '2024-07-27 22:53:45', '2024-07-27 22:53:45'),
(47, 47, '4a49fd7661b612999d48ccc5b97e8814', '2024-07-25', 5, 'BS', 500.00, 'Quinientos con 00/100 Bs', 'Alquiler mes de agosto un cuarto y una cocina', NULL, 1, '2', '2024-07-27 22:54:28', '2024-07-27 22:54:28'),
(48, 48, 'a49bb7136fd9c1e4edeb92e3189dd399', '2024-08-02', 1, 'BS', 560.00, 'Quinientos sesenta con 00/100 Bs', 'Pago de alquiler y servicios básicos correspondientes al mes de Junio', NULL, 1, '1', '2024-08-04 00:20:36', '2024-08-04 00:20:36'),
(49, 49, '411cb93f2a7b439f0225741ca39bd7c4', '2024-08-10', 1, 'BS', 560.00, 'Quinientos sesenta con 00/100 Bs', 'Pago de alquiler y servicios básicos correspondientes al mes de Julio', NULL, 1, '1', '2024-08-11 15:10:47', '2024-08-11 15:10:47'),
(50, 50, '1ca4006409fab0e78381eadfcfeff599', '2024-08-10', 4, 'BS', 430.00, 'Cuatrocientos treinta con 00/100 Bs', 'Alquiler del mes de agosto (dos cuartos)', NULL, 1, '1', '2024-08-11 15:13:34', '2024-08-11 15:13:34'),
(51, 51, '01707a05a6c134c3871495a4078a07f5', '2024-08-24', 2, 'BS', 650.00, 'Seiscientos cincuenta con 00/100 Bs', 'Alquiler del mes de agosto (tres cuartos)', NULL, 1, '2', '2024-08-24 22:40:32', '2024-09-15 16:15:21'),
(52, 52, '87ea1f9882b18a2734569c4ef168f235', '2024-09-11', 4, 'BS', 430.00, 'Cuatrocientos treinta con 00/100 Bs', 'Alquiler del mes de septiembre (dos cuartos)', NULL, 1, '1', '2024-09-12 01:24:47', '2024-09-12 01:24:47'),
(53, 53, 'd0f87617a1f61d992371efbd95f6ddf7', '2024-09-15', 2, 'BS', 650.00, 'Seiscientos cincuenta con 00/100 Bs', 'Alquiler del mes de septiembre (tres cuartos)', NULL, 1, '1', '2024-09-15 16:15:56', '2024-09-15 16:15:56'),
(54, 54, '36ddd3974ab3e9df60c5c86fef8b6fea', '2024-09-29', 1, 'BS', 560.00, 'Quinientos sesenta con 00/100 Bs', 'Pago de alquiler y servicios básicos correspondientes al mes de Agosto', NULL, 1, '1', '2024-09-29 12:42:42', '2024-09-29 12:42:42'),
(55, 55, '4ea59dc16c0c0daa7715963352ff0b9d', '2024-09-07', 5, 'BS', 500.00, 'Quinientos con 00/100 Bs', 'Alquiler mes de septiembre un cuarto y una cocina', NULL, 1, '3', '2024-10-13 20:26:06', '2024-10-13 20:26:06'),
(56, 56, 'df0fb7e7e1dbb0638529f5bcc59f5e16', '2024-10-06', 5, 'BS', 500.00, 'Quinientos con 00/100 Bs', 'Alquiler mes de octubre un cuarto y una cocina', NULL, 1, '3', '2024-10-13 20:26:52', '2024-10-13 20:26:52'),
(57, 57, 'c3a7c5a69ec855d2db55123a06732e18', '2024-10-17', 4, 'BS', 430.00, 'Cuatrocientos treinta con 00/100 Bs', 'Alquiler del mes de octubre (dos cuartos)', NULL, 1, '1', '2024-10-18 02:20:42', '2024-10-18 02:20:42'),
(58, 58, '92b5525872d71a5c9115b120e2b306c3', '2024-10-20', 2, 'BS', 650.00, 'Seiscientos cincuenta con 00/100 Bs', 'Alquiler del mes de octubre (tres cuartos)', NULL, 1, '1', '2024-10-20 15:56:11', '2024-10-20 15:56:11'),
(59, 59, '122aa018a523327213b9e81faaa3c524', '2024-11-07', 5, 'BS', 500.00, 'Quinientos con 00/100 Bs', 'Alquiler mes de noviembre un cuarto y una cocina', NULL, 1, '3', '2024-11-08 01:05:40', '2024-11-08 01:05:40'),
(60, 60, '0994be0fcd1efd4f9fabe188c21b702e', '2024-11-15', 4, 'BS', 430.00, 'Cuatrocientos treinta con 00/100 Bs', 'Alquiler del mes de noviembre (dos cuartos)', NULL, 1, '1', '2024-11-16 13:47:35', '2024-11-16 13:47:35'),
(61, 61, '34282b7151f0f4923b8483e4189543ca', '2024-11-24', 2, 'BS', 650.00, 'Seiscientos cincuenta con 00/100 Bs', 'Alquiler del mes de noviembre (tres cuartos)', NULL, 1, '1', '2024-11-24 16:40:24', '2024-11-24 16:43:17'),
(62, 62, '136e16388371c31db3329b0833227a6a', '2024-12-01', 1, 'BS', 560.00, 'Quinientos sesenta con 00/100 Bs', 'Pago de alquiler y servicios básicos correspondientes al mes de Septiembre', NULL, 1, '1', '2024-12-05 00:22:57', '2024-12-05 00:22:57'),
(63, 63, '136e16388371c31db3329b0833227a6a', '2024-12-01', 1, 'BS', 560.00, 'Quinientos sesenta con 00/100 Bs', 'Pago de alquiler y servicios básicos correspondientes al mes de Octubre', NULL, 1, '1', '2024-12-05 00:23:22', '2024-12-05 00:23:22'),
(64, 64, '84993ba4fdbe97769d0db54fdd6a25ec', '2024-12-24', 1, 'BS', 560.00, 'Quinientos sesenta con 00/100 Bs', 'Pago de alquiler y servicios básicos correspondientes al mes de Noviembre', NULL, 1, '1', '2024-12-26 02:47:32', '2024-12-26 02:47:32'),
(65, 65, 'cd392c93b0e551a819559983b3139986', '2024-12-25', 2, 'BS', 650.00, 'Seiscientos cincuenta con 00/100 Bs', 'Alquiler del mes de diciembre (tres cuartos)', NULL, 1, '1', '2024-12-26 02:48:12', '2024-12-26 02:48:41'),
(66, 66, '8082d3e0929c32a8b59bcabf1b00fab3', '2024-12-30', 4, 'BS', 430.00, 'Cuatrocientos treinta con 00/100 Bs', 'Alquiler del mes de diciembre (dos cuartos)', NULL, 1, '2', '2025-01-02 00:11:10', '2025-01-02 00:11:10'),
(67, 67, 'f45607d37922254dae7111f89c191946', '2025-01-22', 5, 'BS', 500.00, 'Quinientos con 00/100 Bs', 'Alquiler mes de diciembre un cuarto y una cocina', NULL, 1, '3', '2025-01-02 01:42:18', '2025-01-22 22:20:49'),
(68, 68, '4bb8be028ef33b1b654f88cb1467f690', '2025-01-10', 1, 'BS', 560.00, 'Quinientos sesenta con 00/100 Bs', 'Pago de alquiler y servicios básicos correspondientes al mes de Diciembre', NULL, 1, '1', '2025-01-19 21:05:31', '2025-01-19 21:06:16'),
(69, 69, '425ff4a6823f999146408040a3f53d2c', '2025-01-22', 2, 'BS', 700.00, 'Setecientos con 00/100 Bs', 'Alquiler del mes de enero (tres cuartos)', NULL, 1, '2', '2025-01-22 17:46:05', '2025-01-22 17:46:05'),
(70, 70, 'a052018872ee610be5a6b5a994d0873c', '2025-01-23', 4, 'BS', 430.00, 'Cuatrocientos treinta con 00/100 Bs', 'Alquiler del mes de enero (dos cuartos)', NULL, 1, '2', '2025-02-17 01:09:49', '2025-03-08 12:46:23'),
(71, 71, '681a70ad80f81fffbeb270d531f178ba', '2025-02-01', 5, 'BS', 500.00, 'Quinientos con 00/100 Bs', 'Pago de alquiler enero (cuarto y cocina)', NULL, 1, '3', '2025-03-08 12:34:02', '2025-03-08 12:56:36'),
(72, 72, 'a052018872ee610be5a6b5a994d0873c', '2025-02-16', 4, 'BS', 430.00, 'Cuatrocientos treinta con 00/100 Bs', 'Alquiler del mes de febrero (dos cuartos)', NULL, 1, '2', '2025-03-08 12:57:45', '2025-04-14 22:52:31'),
(73, 73, '681a70ad80f81fffbeb270d531f178ba', '2025-02-19', 1, 'BS', 560.00, 'Quinientos sesenta con 00/100 Bs', 'Pago de alquiler y servicios básicos correspondientes al mes de enero', NULL, 1, '1', '2025-03-08 12:58:40', '2025-03-08 14:08:09'),
(74, 74, '8a095573d40417e0f18f5929308cbffc', '2025-02-21', 5, 'BS', 500.00, 'Quinientos con 00/100 Bs', 'Pago de alquiler febrero (cuarto y cocina)', NULL, 1, '3', '2025-03-08 13:03:00', '2025-03-08 14:06:38'),
(75, 75, '8a095573d40417e0f18f5929308cbffc', '2025-03-01', 2, 'BS', 700.00, 'Setecientos con 00/100 Bs', 'Alquiler del mes de febrero (tres cuartos)', NULL, 1, '2', '2025-03-08 14:07:30', '2025-03-08 14:07:30'),
(76, 76, 'b9ac0c9dd277c6815231d7f936b16dbd', '2025-03-08', 1, 'BS', 560.00, 'Quinientos sesenta con 00/100 Bs', 'Pago de alquiler y servicios básicos correspondientes al mes de febrero', NULL, 1, '2', '2025-03-08 14:09:00', '2025-03-08 14:09:00'),
(77, 77, 'ebf13bef416926411fd709d4e305ccc4', '2025-03-09', 6, 'BS', 360.00, 'Trescientos sesenta con 00/100 Bs', 'Alquiler de los meses de marzo, abril y mayo (Un cuarto)', NULL, 1, '1', '2025-03-10 00:53:28', '2025-03-10 00:53:28'),
(78, 78, '4419e87cacfa2b3fcd67beef939ea853', '2025-04-15', 4, 'BS', 500.00, 'Quinientos con 00/100 Bs', 'Alquiler del mes de marzo (dos cuartos)', NULL, 1, '2', '2025-04-16 00:29:13', '2025-04-16 00:29:13'),
(79, 79, 'b0b8a6b8103abd1eb69d3167ed4e2b14', '2025-04-24', 2, 'BS', 700.00, 'Setecientos con 00/100 Bs', 'Alquiler del mes de marzo (tres cuartos)', NULL, 1, '2', '2025-04-24 23:50:20', '2025-04-24 23:50:20'),
(80, 80, 'b0b8a6b8103abd1eb69d3167ed4e2b14', '2025-04-24', 2, 'BS', 700.00, 'Setecientos con 00/100 Bs', 'Alquiler del mes de abril (tres cuartos)', NULL, 1, '2', '2025-04-24 23:50:56', '2025-04-24 23:50:56'),
(81, 81, 'a72a97298e83ae03d2917f1cee40168b', '2025-04-12', 5, 'BS', 500.00, 'Quinientos con 00/100 Bs', 'Pago de alquiler marzo (cuarto y cocina)', NULL, 1, '3', '2025-05-17 19:01:43', '2025-05-17 19:01:43'),
(82, 82, 'ff9e3b68c56c3eb5bf7bd57b0734c4c5', '2025-05-05', 5, 'BS', 500.00, 'Quinientos con 00/100 Bs', 'Pago de alquiler abril (cuarto y cocina)', NULL, 1, '3', '2025-05-17 19:03:04', '2025-05-17 19:03:04'),
(83, 83, '38de938f501e6244caa918220f5c8a15', '2025-05-15', 4, 'BS', 500.00, 'Quinientos con 00/100 Bs', 'Alquiler del mes de abril (dos cuartos)', NULL, 1, '2', '2025-05-17 19:07:31', '2025-05-17 19:08:03'),
(84, 84, 'cddca38a2dd733b02910ecc8b7f429a0', '2025-04-17', 1, 'BS', 560.00, 'Quinientos sesenta con 00/100 Bs', 'Pago de alquiler y servicios básicos correspondientes al mes de marzo', NULL, 1, '2', '2025-05-24 13:16:15', '2025-05-24 13:16:15'),
(85, 85, 'ca4ef916d990ce64a6f450e3d10ae4dd', '2025-05-17', 1, 'BS', 560.00, 'Quinientos sesenta con 00/100 Bs', 'Pago de alquiler y servicios básicos correspondientes al mes de abril', NULL, 1, '1', '2025-05-24 13:21:51', '2025-05-24 13:21:51'),
(86, 86, '6fab2913d27c6383671624a8c4ea4252', '2025-06-17', 1, 'BS', 560.00, 'Quinientos sesenta con 00/100 Bs', 'Pago de alquiler y servicios básicos correspondientes al mes de mayo', NULL, 1, '2', '2025-06-21 14:17:49', '2025-06-24 13:24:47'),
(87, 87, '6d3d7e02721a52e5378b82cb84763066', '2025-06-21', 4, 'BS', 500.00, 'Quinientos con 00/100 Bs', 'Alquiler del mes de mayo (dos cuartos)', NULL, 1, '2', '2025-06-22 12:12:32', '2025-06-22 12:12:32'),
(88, 88, 'fe84f463d7533cd0c5d0236d3e7c03e2', '2025-08-02', 1, 'BS', 560.00, 'Quinientos sesenta con 00/100 Bs', 'Pago de alquiler y servicios básicos correspondientes al mes de junio', NULL, 2, '1', '2025-08-03 01:12:07', '2025-08-04 09:33:40'),
(89, 89, '1d8cabe811bcfadaae44abe3f3f16f5e', '2025-08-02', 1, 'BS', 560.00, 'Quinientos sesenta con 00/100 Bs', 'Pago de alquiler y servicios básicos correspondientes al mes de julio', NULL, 2, '1', '2025-08-03 01:13:22', '2025-09-05 22:50:14'),
(90, 90, '3ddd958d5a735a25a8f87d6edc6283c0', '2025-05-17', 5, 'BS', 500.00, 'Quinientos con 00/100 Bs', 'Pago de alquiler mayo (cuarto y cocina)', NULL, 1, '3', '2025-09-05 23:23:48', '2025-09-06 16:12:07'),
(91, 91, '593f529833b5f446d25ed66e719d6ed0', '2025-07-14', 4, 'BS', 500.00, 'Quinientos con 00/100 Bs', 'Alquiler del mes de junio (dos cuartos)', NULL, 1, '2', '2025-09-05 23:25:15', '2025-09-13 00:14:59'),
(92, 92, '79052357433a985b0220c9cfc1cfa1cd', '2025-08-04', 2, 'BS', 700.00, 'Setecientos con 00/100 Bs', 'Alquiler del mes de mayo (tres cuartos)', NULL, 1, '2', '2025-09-08 01:48:54', '2025-09-08 01:49:54'),
(93, 93, '2d79f2f4960c7e00a6d78dcf83b0151e', '2025-08-04', 2, 'BS', 700.00, 'Setecientos con 00/100 Bs', 'Alquiler del mes de junio (tres cuartos)', NULL, 1, '2', '2025-09-08 01:50:48', '2025-09-08 01:50:48'),
(94, 94, '455f7a31a91902102ed98f750861b128', '2025-08-02', 4, 'BS', 500.00, 'Quinientos con 00/100 Bs', 'Alquiler del mes de julio (dos cuartos)', NULL, 2, '2', '2025-09-08 01:54:16', '2025-09-13 00:20:15'),
(95, 95, 'd9ef2be9fb1f685f590a077af5874102', '2025-09-10', 5, 'BS', 500.00, 'Quinientos con 00/100 Bs', 'Pago de alquiler junio (cuarto y cocina) - Borrador', NULL, 1, '3', '2025-09-12 23:39:01', '2025-09-12 23:39:01'),
(96, 96, 'd90c313842108735bfe20e3f9385ba5b', '2025-09-10', 5, 'BS', 500.00, 'Quinientos con 00/100 Bs', 'Pago de alquiler julio (cuarto y cocina)', NULL, 1, '3', '2025-09-12 23:40:35', '2025-09-12 23:40:35'),
(97, 97, 'a8922e3c5ea0447f7b4e6d190875fdd8', '2025-09-10', 2, 'BS', 700.00, 'Setecientos con 00/100 Bs', 'Alquiler del mes de julio (tres cuartos)', NULL, 2, '2', '2025-09-12 23:42:01', '2025-09-13 00:20:47'),
(98, 98, '1d894dccf6abbde7b15ba788aec70746', '2025-09-10', 2, 'BS', 700.00, 'Setecientos con 00/100 Bs', 'Alquiler del mes de agosto (tres cuartos)', NULL, 2, '2', '2025-09-12 23:43:17', '2025-09-13 00:20:59'),
(99, 99, '59018d43763cd1451df84f7ecbf94f2b', '2025-09-05', 4, 'BS', 500.00, 'Quinientos con 00/100 Bs', 'Alquiler del mes de agosto (dos cuartos)', NULL, 2, '2', '2025-09-13 00:17:46', '2025-09-13 00:20:24'),
(100, 100, '513b35970af4961461bac0820a28fb71', '2025-09-12', 7, 'BS', 500.00, 'Quinientos con 00/100 Bs', 'Alquiler junio - julio (2 cuartos)', NULL, 2, '2', '2025-09-13 17:10:43', '2025-09-27 13:09:45'),
(101, 101, '61084cdaa447b7a4cf3440e90614f679', '2025-09-19', 8, 'BS', 2000.00, 'Dos mil con 00/100 Bs', 'Alquiler tienda - B y cocina (8 meses)', NULL, 1, '2', '2025-09-26 00:49:02', '2025-09-27 13:08:09'),
(102, 102, '5d7c90bbae171513d356d753ffde02b8', '2025-09-24', 1, 'BS', 560.00, 'Quinientos sesenta con 00/100 Bs', 'Pago de alquiler y servicios básicos correspondientes al mes de agosto', NULL, 2, '1', '2025-09-27 12:49:33', '2025-09-27 13:08:25'),
(103, 103, 'ee7104f0b32da644185d123c2dbb2bf3', '2025-10-09', 4, 'BS', 500.00, 'Quinientos con 00/100 Bs', 'Alquiler del mes de septiembre (dos cuartos)', NULL, 2, '2', '2025-10-11 13:17:54', '2025-10-19 00:03:15'),
(104, 104, '296dd2518b9f55f5adeb78ffa92698a2', '2025-10-18', 7, 'BS', 500.00, 'Quinientos con 00/100 Bs', 'Alquiler agosto - septiembre (2 cuartos)', NULL, 2, '2', '2025-10-19 00:02:57', '2025-12-28 12:07:06'),
(105, 105, 'e858bedc26584b3e3a03269b42382be3', '2025-10-19', 6, 'BS', 480.00, 'Cuatrocientos ochenta con 00/100 Bs', 'Alquiler de junio - septiembre (Un cuarto)', NULL, 1, '1', '2025-10-19 14:10:07', '2025-10-19 14:10:07'),
(106, 106, '6b7795147eb366d2c4e3422fbf01478b', '2025-10-23', 1, 'BS', 560.00, 'Quinientos sesenta con 00/100 Bs', 'Pago de alquiler y servicios básicos correspondientes al mes de septiembre', NULL, 2, '1', '2025-10-25 19:32:15', '2025-11-24 15:29:31'),
(107, 107, '64ca4ad9b4ea53d48db34d5baefb90a9', '2025-10-22', 2, 'BS', 700.00, 'Setecientos con 00/100 Bs', 'Alquiler del mes de septiembre (tres cuartos)', NULL, 2, '2', '2025-10-25 19:38:24', '2025-10-29 22:55:57'),
(108, 108, '667dbba04a9aaee99424e7e0c74f4280', '2025-10-22', 2, 'BS', 700.00, 'Setecientos con 00/100 Bs', 'Alquiler del mes de octubre (tres cuartos)', NULL, 2, '2', '2025-10-25 19:39:35', '2025-10-29 22:56:05'),
(109, 109, 'f40ee42c67266b291d534e8e908b550e', '2025-11-24', 1, 'BS', 560.00, 'Quinientos sesenta con 00/100 Bs', 'Pago de alquiler y servicios básicos correspondientes al mes de octubre', NULL, 2, '1', '2025-11-24 15:30:16', '2025-12-12 12:59:47'),
(110, 110, '0ad7d87231fab1f8fe1246f1ffe68955', '2025-12-12', 9, 'BS', 560.00, 'Quinientos sesenta con 00/100 Bs', 'Pago de alquiler y servicios básicos correspondientes al mes de noviembre', NULL, 2, '1', '2025-12-12 13:00:55', '2026-01-01 02:01:25'),
(111, 111, 'cf8e7c9209df43fd11ee251875d34378', '2025-12-17', 7, 'BS', 500.00, 'Quinientos con 00/100 Bs', 'Alquiler octubre - noviembre (2 cuartos)', NULL, 2, '2', '2025-12-28 12:08:40', '2026-01-01 01:56:53'),
(112, 112, 'a43566210dbf8c0013b37880091e2a0c', '2025-12-31', 4, 'BS', 500.00, 'Quinientos con 00/100 Bs', 'Alquiler del mes de octubre (dos cuartos)', NULL, 2, '2', '2026-01-01 01:56:33', '2026-01-01 02:01:21'),
(113, 113, '86ff18d373154254641ce7533bffde83', '2025-12-31', 2, 'BS', 700.00, 'Setecientos con 00/100 Bs', 'Alquiler del mes de noviembre (tres cuartos)', NULL, 2, '2', '2026-01-01 01:59:43', '2026-01-01 02:01:15'),
(114, 114, 'b6b8f7d8f3f566b1eeb8b4122ee43a34', '2025-12-31', 2, 'BS', 700.00, 'Setecientos con 00/100 Bs', 'Alquiler del mes de diciembre (tres cuartos)', NULL, 2, '2', '2026-01-01 02:00:42', '2026-01-01 02:01:18'),
(115, 115, 'f1459f74fabe0a00a0d20adf4cc6eb2c', '2026-01-16', 1, 'BS', 560.00, 'Quinientos sesenta con 00/100 Bs', 'Pago de alquiler y servicios básicos correspondientes al mes de diciembre 2025', NULL, 2, '1', '2026-01-16 10:51:28', '2026-02-18 16:44:07'),
(116, 116, '8ea5616d1aac7d07b0593a1dc5b5e1cf', '2026-02-02', 5, 'BS', 500.00, 'Quinientos con 00/100 Bs', 'Pago de alquiler febrero (cuarto y cocina)', NULL, 1, '2', '2026-02-18 16:43:59', '2026-02-18 16:43:59'),
(117, 117, 'e021f725d633f52363afafd67f99635c', '2026-02-24', 1, 'BS', 560.00, 'Quinientos sesenta con 00/100 Bs', 'Pago de alquiler y servicios básicos correspondientes al mes de enero', NULL, 1, '1', '2026-02-24 22:30:12', '2026-02-24 22:30:12'),
(118, 118, 'd54213d6b61ca5914e3ecad5e4695ef9', '2026-03-21', 10, 'BS', 70000.00, 'Setenta mil con 00/100 Bs', 'Venta de lote Llimphi', NULL, 1, '2', '2026-03-21 15:45:49', '2026-03-21 15:45:49');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'web', '2025-05-25 03:23:26', '2025-05-25 03:23:26'),
(2, 'supervisor', 'web', '2025-05-25 03:23:26', '2025-05-25 03:23:26'),
(3, 'vendedor', 'web', '2025-05-25 03:23:26', '2025-05-25 03:23:26'),
(4, 'cliente', 'web', '2025-05-25 03:23:26', '2025-05-25 03:23:26');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(8, 2),
(8, 3),
(8, 4),
(9, 1),
(9, 2),
(9, 3),
(9, 4),
(10, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `is_active`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'William Castro Ayaviri', 'william@gmail.com', NULL, 1, '$2y$10$ERiVZYiqoz24diG2DzV2g.lqRqjKMkZz1Qa6QPmbAUDTaSGrH0r6q', NULL, '2024-03-04 00:56:45', '2025-05-25 03:26:48'),
(2, 'Florentino Castro Mamani', 'lalo@gmail.com', NULL, 0, '$2y$10$8WqSx6i6TOq4jRNtodPkr.HoGV.PorS7x6SfA/ltrVrGkqLAL8V6C', NULL, '2024-03-17 02:51:03', '2024-03-17 02:51:03'),
(3, 'Yamil Castro Ayaviri', 'yamil@gmail.com', NULL, 0, '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, '2024-07-22 00:40:03', '2024-03-17 02:51:03');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indices de la tabla `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indices de la tabla `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indices de la tabla `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indices de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indices de la tabla `personas`
--
ALTER TABLE `personas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `recibos`
--
ALTER TABLE `recibos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indices de la tabla `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `personas`
--
ALTER TABLE `personas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `recibos`
--
ALTER TABLE `recibos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=119;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
