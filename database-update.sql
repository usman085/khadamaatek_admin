-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 22, 2020 at 01:26 PM
-- Server version: 5.7.24
-- PHP Version: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: 'khadamaatek-admin`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `parent_id`, `created_at`, `updated_at`) VALUES
(1, 'Category 1', NULL, '2020-07-20 06:02:17', '2020-07-20 06:02:17'),
(3, 'Category 2', 1, '2020-07-20 06:07:09', '2020-07-20 06:26:11'),
(4, 'Category 3', 1, '2020-07-20 06:26:35', '2020-07-20 06:49:54');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cnic` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nationality` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `otp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `first_name`, `last_name`, `email`, `cnic`, `nationality`, `gender`, `phone_no`, `address`, `otp`, `last_login`, `created_at`, `updated_at`) VALUES
(1, 'Ali', 'Khan', 'ali@gmail.com', '33321654987', 'Pakistani', 'Male', '923216547987', 'House No. P-123, Raiwand Road Lahore Punjab', '9854', '2020-07-21 12:52:47', '2020-07-21 07:52:48', '2020-07-21 03:21:00'),
(2, 'Sheikh', 'Jamil', 'jamil@gmail.com', '33321654987', 'Pakistani', 'Male', '923216547987', 'House No. P-123, Raiwand Road Lahore Punjab', '9854', '2020-07-21 12:52:47', '2020-07-21 07:52:48', '2020-07-21 03:21:00'),
(3, 'Khalil', 'Ahmad', 'khalil@gmail.com', '33321654987', 'Pakistani', 'Male', '923216547987', 'House No. P-123, Raiwand Road Lahore Punjab', '9854', '2020-07-21 12:52:47', '2020-07-21 07:52:48', '2020-07-21 03:21:00'),
(4, 'Ahmad', 'Raza', 'ahmad@gmail.com', '33321654987', 'Pakistani', 'Male', '923216547987', 'House No. P-123, Raiwand Road Lahore Punjab', '9854', '2020-07-21 12:52:47', '2020-07-21 07:52:48', '2020-07-21 03:21:00');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Department 1', '2020-07-20 07:57:24', '2020-07-20 07:57:24'),
(2, 'Department 2', '2020-07-20 07:57:32', '2020-07-20 07:57:32'),
(6, 'Department 3', '2020-07-20 08:09:40', '2020-07-20 08:10:07');

-- --------------------------------------------------------

--
-- Table structure for table `email_template`
--

CREATE TABLE `email_template` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `email_template`
--

INSERT INTO `email_template` (`id`, `created_at`, `updated_at`, `content`, `name`, `subject`) VALUES
(1, NULL, NULL, '<!DOCTYPE html>\n                <html lang=\"en\">\n                <head>\n                    <meta charset=\"utf-8\">\n                    <meta name=\"viewport\" content=\"width=device-width\">\n                    <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\"> \n                    <meta name=\"x-apple-disable-message-reformatting\">\n                    <title>Example</title>\n                    <style>\n                        body {\n                            background-color:#fff;\n                            color:#222222;\n                            margin: 0px auto;\n                            padding: 0px;\n                            height: 100%;\n                            width: 100%;\n                            font-weight: 400;\n                            font-size: 15px;\n                            line-height: 1.8;\n                        }\n                        .continer{\n                            width:400px;\n                            margin-left:auto;\n                            margin-right:auto;\n                            background-color:#efefef;\n                            padding:30px;\n                        }\n                        .btn{\n                            padding: 5px 15px;\n                            display: inline-block;\n                        }\n                        .btn-primary{\n                            border-radius: 3px;\n                            background: #0b3c7c;\n                            color: #fff;\n                            text-decoration: none;\n                        }\n                        .btn-primary:hover{\n                            border-radius: 3px;\n                            background: #4673ad;\n                            color: #fff;\n                            text-decoration: none;\n                        }\n                    </style>\n                </head>\n                <body>\n                    <div class=\"continer\">\n                        <h1>Lorem ipsum dolor</h1>\n                        <h4>Ipsum dolor cet emit amet</h4>\n                        <p>\n                            Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea <strong>commodo consequat</strong>. \n                            Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. \n                            Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\n                        </p>\n                        <h4>Ipsum dolor cet emit amet</h4>\n                        <p>\n                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod <a href=\"#\">tempor incididunt ut labore</a> et dolore magna aliqua.\n                            Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. \n                        </p>\n                        <h4>Ipsum dolor cet emit amet</h4>\n                        <p>\n                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.\n                            Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. \n                        </p>\n                        <a href=\"#\" class=\"btn btn-primary\">Lorem ipsum dolor</a>\n                        <h4>Ipsum dolor cet emit amet</h4>\n                        <p>\n                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.\n                            Ut enim ad minim veniam, quis nostrud exercitation <a href=\"#\">ullamco</a> laboris nisi ut aliquip ex ea commodo consequat. \n                            Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. \n                            Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\n                        </p>\n                    </div>\n                </body>\n                </html>', 'Example E-mail', 'Example E-mail');

-- --------------------------------------------------------

--
-- Table structure for table `example`
--

CREATE TABLE `example` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `example`
--

INSERT INTO `example` (`id`, `created_at`, `updated_at`, `name`, `description`, `status_id`) VALUES
(1, NULL, NULL, 'Aut omnis fugit.', 'Repudiandae laborum architecto illo a iste.', 1),
(2, NULL, NULL, 'Omnis nobis expedita distinctio.', 'Quas eum quis voluptatibus accusantium.', 1),
(3, NULL, NULL, 'Vero id et et et.', 'Dolor minus eius nihil aliquid quae aut sint deserunt. Quo occaecati doloribus maiores fugit dolorum.', 4),
(4, NULL, NULL, 'Exercitationem voluptates sequi et aut quas.', 'Ad maiores nihil vero cumque similique voluptatem. Ut repudiandae pariatur consequatur porro eligendi laborum tempora.', 2),
(5, NULL, NULL, 'Doloribus quos labore aut ullam.', 'Maxime eligendi explicabo hic eaque quasi quibusdam repellat. Aut dolores quod vel quia numquam laudantium voluptate.', 3),
(6, NULL, NULL, 'Ut magni qui cumque odio.', 'Quo iste omnis eum perspiciatis nisi.', 2),
(7, NULL, NULL, 'Placeat et perferendis exercitationem et sed.', 'Tempore quidem magni nobis non.', 2),
(8, NULL, NULL, 'Vero dolor neque.', 'Magnam eum veritatis labore. Eius sint assumenda molestiae atque et cupiditate eveniet commodi.', 3),
(9, NULL, NULL, 'Minima molestiae aut dolores et.', 'Ipsam assumenda enim aut.', 2),
(10, NULL, NULL, 'Distinctio culpa temporibus eligendi quod.', 'Sed mollitia dolor mollitia enim rem iusto.', 2),
(11, NULL, NULL, 'Neque neque rerum ut esse.', 'Ad veniam omnis voluptas nemo aperiam omnis molestias dolorem. Nemo corporis quis officiis accusamus quasi.', 3),
(12, NULL, NULL, 'Ut autem natus ad.', 'Aliquid nihil ut quisquam optio quasi. Libero vel ducimus sunt nemo quas.', 2),
(13, NULL, NULL, 'Maxime eos omnis nesciunt ea nihil.', 'Suscipit possimus voluptatum sunt ullam quia ut.', 3),
(14, NULL, NULL, 'In cum quia tempore.', 'Sunt atque commodi vitae in.', 1),
(15, NULL, NULL, 'Quidem facere blanditiis quisquam.', 'Facere aliquam culpa ut.', 1),
(16, NULL, NULL, 'Excepturi adipisci ea ab.', 'Dolores soluta nostrum provident qui nam odio. Quam officia voluptas sunt consequuntur velit aut.', 4),
(17, NULL, NULL, 'Commodi temporibus iusto est.', 'Illum in quisquam iusto ratione tenetur aut nihil. Doloremque quos corporis hic qui est pariatur optio.', 4),
(18, NULL, NULL, 'Mollitia alias veniam dolor beatae.', 'Aut voluptatem impedit illum rem.', 4),
(19, NULL, NULL, 'Iste dolores consequatur accusamus.', 'Eos quisquam quasi et non est. Et quod quia laborum consequatur quas inventore.', 2),
(20, NULL, NULL, 'Pariatur nobis aut et sed qui.', 'Maxime soluta aut quis reiciendis mollitia eum ratione.', 4),
(21, NULL, NULL, 'Ea in numquam.', 'Iusto dolorem ipsam qui doloribus.', 1),
(22, NULL, NULL, 'Omnis consequatur sed dolore quae.', 'Cupiditate et esse aut hic ut. Est totam nisi sit molestias.', 2),
(23, NULL, NULL, 'Non facilis qui nobis.', 'Sit veritatis voluptatem officia minima cumque. Sapiente quos adipisci eum dolores quae voluptatum magni.', 3),
(24, NULL, NULL, 'Assumenda maiores iure similique repellendus itaque.', 'Exercitationem ab ad reprehenderit dolores eum voluptas. Id iusto nesciunt corrupti.', 1),
(25, NULL, NULL, 'Qui quo facere veritatis.', 'Iste adipisci dolore molestiae et itaque voluptatibus aliquam id. Commodi harum omnis aliquam assumenda et.', 3);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `folder`
--

CREATE TABLE `folder` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `folder_id` int(10) UNSIGNED DEFAULT NULL,
  `resource` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `folder`
--

INSERT INTO `folder` (`id`, `created_at`, `updated_at`, `name`, `folder_id`, `resource`) VALUES
(1, NULL, NULL, 'root', NULL, NULL),
(2, NULL, NULL, 'resource', 1, 1),
(3, NULL, NULL, 'documents', 1, NULL),
(4, NULL, NULL, 'graphics', 1, NULL),
(5, NULL, NULL, 'other', 1, NULL),
(6, '2020-07-20 08:11:44', '2020-07-20 08:11:44', 'New Folder', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `form`
--

CREATE TABLE `form` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `table_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `read` tinyint(1) NOT NULL,
  `edit` tinyint(1) NOT NULL,
  `add` tinyint(1) NOT NULL,
  `delete` tinyint(1) NOT NULL,
  `pagination` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `form`
--

INSERT INTO `form` (`id`, `created_at`, `updated_at`, `name`, `table_name`, `read`, `edit`, `add`, `delete`, `pagination`) VALUES
(1, NULL, NULL, 'Example', 'example', 1, 1, 1, 1, 5);

-- --------------------------------------------------------

--
-- Table structure for table `form_builders`
--

CREATE TABLE `form_builders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `schema` json NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `form_builders`
--

INSERT INTO `form_builders` (`id`, `name`, `schema`, `created_at`, `updated_at`) VALUES
(2, 'Service Form', '[{\"type\": \"text\", \"label\": \"Name\", \"readonly\": \"true\", \"required\": \"true\", \"placeholder\": \"Name\"}, {\"type\": \"number\", \"label\": \"Number\", \"readonly\": \"false\", \"required\": \"true\", \"placeholder\": \"Number\"}]', '2020-07-21 06:50:09', '2020-07-21 07:10:46');

-- --------------------------------------------------------

--
-- Table structure for table `form_field`
--

CREATE TABLE `form_field` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `browse` tinyint(1) NOT NULL,
  `read` tinyint(1) NOT NULL,
  `edit` tinyint(1) NOT NULL,
  `add` tinyint(1) NOT NULL,
  `relation_table` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `relation_column` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `form_id` int(10) UNSIGNED NOT NULL,
  `column_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `form_field`
--

INSERT INTO `form_field` (`id`, `created_at`, `updated_at`, `name`, `type`, `browse`, `read`, `edit`, `add`, `relation_table`, `relation_column`, `form_id`, `column_name`) VALUES
(1, NULL, NULL, 'Title', 'text', 1, 1, 1, 1, NULL, NULL, 1, 'name'),
(2, NULL, NULL, 'Description', 'text_area', 1, 1, 1, 1, NULL, NULL, 1, 'description'),
(3, NULL, NULL, 'Status', 'relation_select', 1, 1, 1, 1, 'status', 'name', 1, 'status_id');

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

CREATE TABLE `media` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL,
  `collection_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mime_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `disk` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `size` bigint(20) UNSIGNED NOT NULL,
  `manipulations` json NOT NULL,
  `custom_properties` json NOT NULL,
  `responsive_images` json NOT NULL,
  `order_column` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `media`
--

INSERT INTO `media` (`id`, `model_type`, `model_id`, `collection_name`, `name`, `file_name`, `mime_type`, `disk`, `size`, `manipulations`, `custom_properties`, `responsive_images`, `order_column`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\Folder', 1, 'default', 'opera_autoupdate.log', '20200720131149opera_autoupdate.log', 'text/plain', 'public', 220, '[]', '[]', '[]', 1, '2020-07-20 08:11:49', '2020-07-20 08:11:49');

-- --------------------------------------------------------

--
-- Table structure for table `menulist`
--

CREATE TABLE `menulist` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menulist`
--

INSERT INTO `menulist` (`id`, `name`) VALUES
(1, 'sidebar menu');

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `href` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_id` int(10) UNSIGNED DEFAULT NULL,
  `menu_id` int(10) UNSIGNED NOT NULL,
  `sequence` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `name`, `href`, `icon`, `slug`, `parent_id`, `menu_id`, `sequence`) VALUES
(1, 'Dashboard', '/dashboard', 'cil-speedometer', 'link', NULL, 1, 1),
(2, 'Settings', NULL, 'cil-settings', 'dropdown', NULL, 1, 8),
(4, 'Users', '/users', NULL, 'link', 2, 1, 9),
(6, 'Role Permissions', '/menu/element', NULL, 'link', 2, 1, 12),
(7, 'Roles', '/roles', NULL, 'link', 2, 1, 11),
(66, 'Service Categories', '/service-categories', 'cil-vertical-align-center1', 'link', NULL, 1, 3),
(67, 'Departments', '/departments', 'cil-library-building', 'link', NULL, 1, 2),
(68, 'Services', '/services', 'cil-touch-app', 'link', NULL, 1, 4),
(69, 'Orders', '/orders', 'cil-list-rich', 'link', NULL, 1, 5),
(70, 'Customers', '/customers', 'cil-user', 'link', NULL, 1, 6),
(71, 'Requirement Templates', '/forms', 'cil-inbox', 'link', NULL, 1, 7);

-- --------------------------------------------------------

--
-- Table structure for table `menu_role`
--

CREATE TABLE `menu_role` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `menus_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menu_role`
--

INSERT INTO `menu_role` (`id`, `role_name`, `menus_id`) VALUES
(5, 'admin', 3),
(6, 'admin', 4),
(10, 'admin', 8),
(11, 'admin', 9),
(13, 'guest', 11),
(14, 'guest', 12),
(17, 'user', 14),
(18, 'admin', 14),
(19, 'user', 15),
(20, 'admin', 15),
(21, 'user', 16),
(22, 'admin', 16),
(23, 'user', 17),
(24, 'admin', 17),
(25, 'user', 18),
(26, 'admin', 18),
(27, 'user', 19),
(28, 'admin', 19),
(29, 'user', 20),
(30, 'admin', 20),
(31, 'user', 21),
(32, 'admin', 21),
(33, 'user', 22),
(34, 'admin', 22),
(35, 'user', 23),
(36, 'admin', 23),
(37, 'user', 24),
(38, 'admin', 24),
(39, 'user', 25),
(40, 'admin', 25),
(41, 'user', 26),
(42, 'admin', 26),
(43, 'user', 27),
(44, 'admin', 27),
(45, 'user', 28),
(46, 'admin', 28),
(47, 'user', 29),
(48, 'admin', 29),
(49, 'user', 30),
(50, 'admin', 30),
(51, 'user', 31),
(52, 'admin', 31),
(53, 'user', 32),
(54, 'admin', 32),
(55, 'user', 33),
(56, 'admin', 33),
(57, 'user', 34),
(58, 'admin', 34),
(59, 'user', 35),
(60, 'admin', 35),
(61, 'user', 36),
(62, 'admin', 36),
(63, 'user', 37),
(64, 'admin', 37),
(65, 'user', 38),
(66, 'admin', 38),
(67, 'user', 39),
(68, 'admin', 39),
(69, 'user', 40),
(70, 'admin', 40),
(71, 'user', 41),
(72, 'admin', 41),
(73, 'user', 42),
(74, 'admin', 42),
(75, 'user', 43),
(76, 'admin', 43),
(77, 'user', 44),
(78, 'admin', 44),
(79, 'user', 45),
(80, 'admin', 45),
(81, 'user', 46),
(82, 'admin', 46),
(83, 'user', 47),
(84, 'admin', 47),
(89, 'user', 50),
(90, 'admin', 50),
(91, 'user', 51),
(92, 'admin', 51),
(93, 'user', 52),
(94, 'admin', 52),
(95, 'user', 53),
(96, 'admin', 53),
(103, 'guest', 56),
(104, 'user', 56),
(105, 'admin', 56),
(106, 'guest', 57),
(107, 'user', 57),
(108, 'admin', 57),
(109, 'user', 58),
(110, 'admin', 58),
(111, 'admin', 59),
(112, 'admin', 60),
(113, 'admin', 61),
(114, 'admin', 62),
(115, 'admin', 63),
(116, 'admin', 64),
(117, 'admin', 65),
(119, 'admin', 2),
(123, 'admin', 10),
(125, 'admin', 67),
(126, 'admin', 68),
(127, 'admin', 66),
(128, 'admin', 69),
(129, 'admin', 70),
(132, 'admin', 71),
(134, 'admin', 6),
(136, 'admin', 7),
(138, 'admin', 1);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(17, '2014_10_12_000000_create_users_table', 1),
(18, '2014_10_12_100000_create_password_resets_table', 1),
(19, '2019_08_19_000000_create_failed_jobs_table', 1),
(20, '2019_10_11_085455_create_notes_table', 1),
(21, '2019_10_12_115248_create_status_table', 1),
(22, '2019_11_08_102827_create_menus_table', 1),
(23, '2019_11_13_092213_create_menurole_table', 1),
(24, '2019_12_10_092113_create_permission_tables', 1),
(25, '2019_12_11_091036_create_menulist_table', 1),
(26, '2019_12_18_092518_create_role_hierarchy_table', 1),
(27, '2020_01_07_093259_create_folder_table', 1),
(28, '2020_01_08_184500_create_media_table', 1),
(29, '2020_01_21_161241_create_form_field_table', 1),
(30, '2020_01_21_161242_create_form_table', 1),
(31, '2020_01_21_161243_create_example_table', 1),
(32, '2020_03_12_111400_create_email_template_table', 1),
(33, '2020_07_20_101628_create_categories_table', 2),
(34, '2020_07_20_124242_create_departments_table', 3),
(35, '2020_07_20_135811_create_services_table', 4),
(36, '2020_07_21_060155_create_orders_table', 5),
(37, '2020_07_21_073528_create_customers_table', 6),
(38, '2020_07_21_103121_create_form_builders_table', 7),
(39, '2020_07_22_111202_create_websites_table', 8);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\User', 1),
(2, 'App\\User', 1),
(2, 'App\\User', 2),
(2, 'App\\User', 3),
(2, 'App\\User', 4),
(2, 'App\\User', 5),
(2, 'App\\User', 6),
(2, 'App\\User', 7),
(2, 'App\\User', 8),
(2, 'App\\User', 9),
(2, 'App\\User', 10),
(2, 'App\\User', 11);

-- --------------------------------------------------------

--
-- Table structure for table `notes`
--

CREATE TABLE `notes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `note_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `applies_to_date` date NOT NULL,
  `users_id` int(10) UNSIGNED NOT NULL,
  `status_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notes`
--

INSERT INTO `notes` (`id`, `title`, `content`, `note_type`, `applies_to_date`, `users_id`, `status_id`, `created_at`, `updated_at`) VALUES
(1, 'Sapiente quisquam voluptatem animi adipisci.', 'Sed culpa similique sunt quisquam iste rerum ratione cum. Consequatur nulla sed velit aut eum. Quia architecto similique facere corrupti at ea. Fugiat qui quae possimus et doloribus nobis ut.', 'reprehenderit', '2017-11-28', 8, 2, NULL, NULL),
(2, 'Consequatur quisquam explicabo tempora ea fugit.', 'Omnis sapiente illum non blanditiis laudantium. Fugit quam ad dolorum sunt qui quas. Ut in temporibus id assumenda sunt ut.', 'voluptatem repellat', '1970-07-07', 8, 3, NULL, NULL),
(3, 'Aut iure incidunt nihil.', 'Cupiditate delectus aspernatur ut rerum. Inventore aliquam rerum quaerat unde consequuntur. Quidem sed nam omnis sit.', 'similique sequi', '1985-05-10', 8, 3, NULL, NULL),
(4, 'Voluptate sunt alias pariatur.', 'Voluptatum quam eos animi molestiae rerum. Ipsa voluptas exercitationem ipsa doloremque eos maiores eos. Magnam modi consequatur soluta. Est nesciunt vel nesciunt reprehenderit nemo dolor.', 'nemo et', '1978-01-13', 6, 1, NULL, NULL),
(5, 'Numquam accusamus omnis aut.', 'Provident iure totam consectetur voluptas optio consectetur. Ut perferendis ut asperiores. Ut aut qui laboriosam magnam hic magnam aut iusto. Id ipsa quod quis sapiente id. Magnam et consequatur id deleniti quam.', 'et', '1971-05-10', 9, 1, NULL, NULL),
(6, 'Dolorem distinctio voluptas a in.', 'Hic provident inventore aspernatur aperiam ipsa architecto. Laudantium et molestiae ab et. Minus quibusdam vero voluptatem labore pariatur. Repellat aspernatur sed qui repellat odio.', 'quo', '1989-07-14', 9, 2, NULL, NULL),
(7, 'Ut nihil magni sed tempora.', 'Natus incidunt assumenda ullam architecto. Repellendus eaque ipsam ratione dolore repellendus repudiandae porro. Culpa rerum est autem quis quia delectus minima.', 'aspernatur', '2011-03-16', 5, 4, NULL, NULL),
(8, 'Temporibus exercitationem voluptatem ut.', 'Error recusandae ut eum. Voluptas ipsum nobis in fuga. Occaecati voluptas a similique eligendi culpa ad.', 'magni', '1981-05-03', 5, 3, NULL, NULL),
(9, 'Quia laudantium sint.', 'Porro odio dicta commodi. Sapiente rem rerum fugit aut et. Dolorem vitae molestiae qui sed aliquid ex aut. Sed unde possimus odio.', 'vel eaque', '1989-01-08', 4, 4, NULL, NULL),
(10, 'Voluptatem quas aut ut repudiandae.', 'Laudantium asperiores dolores aspernatur molestiae eum aliquam. Consequatur sed ut culpa at. Ea molestias quia maxime maxime qui.', 'et', '2016-09-08', 10, 3, NULL, NULL),
(11, 'Voluptas aut sed.', 'Qui aut pariatur enim et. Autem vel inventore consectetur. Dolores et ducimus nihil optio.', 'voluptas', '2001-08-27', 6, 3, NULL, NULL),
(12, 'Sunt consectetur ut necessitatibus assumenda.', 'Voluptates vel deserunt nihil culpa aut saepe temporibus. Debitis itaque consequatur dicta perferendis fugit. Non quidem sed fugit inventore molestias sunt.', 'ratione ut', '1994-03-14', 2, 2, NULL, NULL),
(13, 'Labore et iste excepturi cum.', 'Rem ut consequuntur distinctio placeat. Eaque in fugit fugit ut corporis. Voluptatum explicabo tenetur ipsa id dolores. Itaque quis error in distinctio commodi.', 'consequatur fuga', '1999-03-20', 4, 3, NULL, NULL),
(14, 'Eum temporibus neque est.', 'Et impedit voluptatem iusto. Enim cumque delectus quia nemo autem aut. Eligendi fuga natus fugiat sit tempora. Pariatur eius et repellat rem illo.', 'omnis veritatis', '1976-05-10', 4, 1, NULL, NULL),
(15, 'Sit nihil beatae enim.', 'Dicta quo provident nulla est sit dolor nostrum. Corporis est rerum maxime. Animi est dolores ut officia accusantium ut.', 'quidem numquam', '1976-08-03', 2, 3, NULL, NULL),
(16, 'Est aliquid ut rerum.', 'Numquam qui vitae aut placeat nihil. Autem optio id consectetur dignissimos. Eum expedita molestiae et.', 'dolor', '1987-09-26', 6, 2, NULL, NULL),
(17, 'Fugit nesciunt sint quia.', 'Quisquam laboriosam qui culpa consequatur nostrum facere ut sint. Molestias molestiae accusamus eum eaque temporibus. Laudantium et voluptatem harum modi et eligendi dicta in.', 'facere libero', '2019-07-14', 9, 4, NULL, NULL),
(18, 'Culpa impedit nostrum.', 'Et doloribus officia voluptas ullam officia. Nisi veritatis optio exercitationem error eveniet beatae id. Distinctio est nihil illo soluta ullam.', 'laudantium', '2020-04-09', 8, 2, NULL, NULL),
(19, 'Ab ducimus incidunt qui.', 'Commodi exercitationem minima quidem totam voluptatem. Labore in et labore sit quo. Veniam esse adipisci rerum unde non quia quam.', 'neque', '2004-11-21', 5, 4, NULL, NULL),
(20, 'Veritatis est saepe vitae.', 'Odit aperiam ullam repellat exercitationem. Consequatur aut omnis quia inventore excepturi. Ducimus soluta sapiente cum.', 'quis', '1992-09-03', 7, 1, NULL, NULL),
(21, 'Vel reprehenderit aut magnam placeat.', 'Harum optio ut doloribus ut at reprehenderit accusamus. Dolorem quia est veniam mollitia. Exercitationem quas nam at qui maiores. Rem laudantium voluptas sed aut.', 'et', '1990-08-13', 10, 1, NULL, NULL),
(22, 'Qui quaerat sint.', 'Nam animi eaque eum ipsam est non. Nostrum quaerat natus sit ut debitis iusto. Praesentium eum voluptatem earum sit at odio. Doloremque laudantium voluptatibus sit aut qui vel totam est.', 'exercitationem', '1994-04-27', 6, 3, NULL, NULL),
(23, 'Modi dignissimos molestiae.', 'Maxime nihil ratione ut. Sequi non culpa saepe. Dolores inventore et aliquid assumenda harum necessitatibus dolor aut.', 'ut ad', '2003-03-18', 8, 2, NULL, NULL),
(24, 'Est repudiandae provident provident aspernatur.', 'Quis qui saepe nihil aliquam optio autem velit. Natus praesentium dicta atque illo doloribus in. Doloremque suscipit incidunt consectetur quia nihil sit ad.', 'nesciunt', '2013-07-15', 4, 3, NULL, NULL),
(25, 'Praesentium officia odio amet ratione.', 'Dignissimos voluptas debitis animi. Voluptas sapiente temporibus hic laboriosam ut illum quae. Aliquid id enim magni doloribus est minima et. Fugit qui officiis et illum est facilis nam.', 'non minus', '1996-07-03', 4, 4, NULL, NULL),
(26, 'Qui qui enim expedita et mollitia.', 'Quis dolores libero dignissimos est quis delectus. Omnis at ad voluptatem necessitatibus excepturi quisquam eos. Ea nisi hic animi exercitationem eveniet recusandae optio.', 'est', '1989-05-27', 6, 2, NULL, NULL),
(27, 'Quidem tenetur vel incidunt.', 'Illo esse occaecati incidunt deserunt. Assumenda est quis quidem aliquid iste dolorum.', 'quas magnam', '1993-04-17', 5, 1, NULL, NULL),
(28, 'Odio occaecati vitae earum.', 'Ea quasi non deleniti autem delectus similique omnis magni. Molestiae ducimus error facilis odio optio. Rerum corrupti magni est et ea qui ex. Amet repellat perspiciatis ullam ipsum voluptas.', 'dignissimos', '2005-02-18', 11, 1, NULL, NULL),
(29, 'Ea voluptatem est qui vel.', 'Repudiandae provident nulla et ipsam maxime aut sequi veniam. In quam distinctio quis. Magnam veniam similique quo. Minus magni quos non beatae sint.', 'aut distinctio', '2015-06-06', 7, 2, NULL, NULL),
(30, 'Sit nesciunt autem aut.', 'Corrupti incidunt non ullam sequi. Sunt molestias dicta laborum praesentium. Corporis consequuntur ut fugiat vero. Quae dignissimos fuga ut sapiente. Suscipit distinctio explicabo nobis accusamus similique eos maiores fugit.', 'rerum', '1988-05-29', 8, 2, NULL, NULL),
(31, 'Aliquid aliquam porro omnis.', 'Sed est illum animi voluptatem voluptas ipsam. Consequatur vitae aut itaque velit. Aperiam et dolorem labore omnis cum qui. Voluptas consequatur ad quisquam quidem ut enim omnis.', 'alias', '1981-02-03', 2, 4, NULL, NULL),
(32, 'Non nisi non illo similique.', 'Mollitia maxime veniam ut voluptates eius saepe. Id tenetur reprehenderit earum labore velit laboriosam. In ut sunt vel distinctio sit perspiciatis placeat. Eveniet et velit eveniet porro est.', 'repellendus velit', '2017-03-29', 11, 2, NULL, NULL),
(33, 'Dolores velit est magnam molestias.', 'Iure repellendus est officiis tempore dolores qui et. Omnis eos quia impedit ut. Quia rerum aut hic et et unde aut. Quo totam voluptas quibusdam deleniti debitis.', 'laborum', '1982-11-05', 10, 4, NULL, NULL),
(34, 'Nemo sapiente suscipit.', 'In soluta totam tempora magni magni ab fugiat ea. Eveniet distinctio alias doloribus rem maiores reiciendis sed expedita. Et impedit nesciunt quis dolor provident. Doloribus dolores perspiciatis eveniet saepe vitae cumque.', 'excepturi', '1979-08-19', 4, 1, NULL, NULL),
(35, 'Vero modi accusamus facere beatae.', 'Odio qui omnis quia dolorem est saepe. Sint quaerat vel ea iste sed saepe. Reiciendis quidem voluptatum omnis eos. Tenetur doloribus ut voluptatem laboriosam.', 'consequatur', '1971-01-04', 8, 3, NULL, NULL),
(36, 'Quibusdam aut consequuntur qui.', 'Porro ullam voluptatem laudantium et nam. Quia dolores possimus aut voluptatem. Vel vel cumque earum laborum qui esse.', 'mollitia quos', '1993-03-22', 6, 2, NULL, NULL),
(37, 'Inventore voluptas dolorem voluptatibus omnis.', 'Dolores eum qui dolorum voluptates aliquid. Inventore facere sit et architecto. Voluptatem ut voluptas modi explicabo adipisci et.', 'non', '1976-10-15', 5, 2, NULL, NULL),
(38, 'Totam voluptatem et.', 'Et consectetur omnis quo. Ut placeat animi ipsa aliquid sunt. Praesentium hic voluptas quisquam officia quia. Quas aut ullam dolores iusto ipsa.', 'sunt eligendi', '1992-12-28', 10, 3, NULL, NULL),
(39, 'Dolorem tenetur alias.', 'Explicabo eius et iusto quibusdam fuga porro ratione iure. At quaerat possimus cum et itaque quia rerum. Recusandae voluptatum vel doloremque eum eligendi eius. Labore eveniet debitis sit voluptates vero.', 'eligendi nulla', '1995-11-27', 5, 4, NULL, NULL),
(40, 'Quae eum asperiores commodi est totam.', 'Sequi voluptatem tempora nulla ipsam vitae corporis possimus recusandae. At molestiae itaque voluptates quam sapiente corrupti minus. Corrupti sit iusto doloribus animi pariatur dignissimos maiores odit. Fuga architecto sint et reiciendis eos eum quos in.', 'autem possimus', '1979-12-08', 7, 2, NULL, NULL),
(41, 'Porro itaque aut consequatur.', 'Autem nihil praesentium animi corporis. Voluptas ut saepe officia similique sed sed sunt aspernatur. Architecto accusamus omnis minus et quibusdam. Est odio ipsum non sapiente aut.', 'tempora est', '1995-09-10', 6, 3, NULL, NULL),
(42, 'Et consequatur aspernatur ipsum velit.', 'Dolores commodi quisquam odit. Similique minima sunt ea est laudantium exercitationem officia. Aut est rerum animi aspernatur vero ipsam sed. Molestias reiciendis id harum consequatur est.', 'dicta ducimus', '2020-05-06', 4, 2, NULL, NULL),
(43, 'Quos aut aut deserunt ut.', 'Autem et consectetur explicabo eius animi voluptatem. Quo quaerat qui at aliquid et. Rerum adipisci eveniet voluptatum modi fugit unde.', 'sequi', '1975-11-10', 6, 1, NULL, NULL),
(44, 'Fugit odio natus.', 'Earum cum nesciunt qui. Soluta alias esse voluptas et vitae et. Occaecati deleniti rem odit animi enim.', 'qui', '1997-05-10', 7, 4, NULL, NULL),
(45, 'Rerum sint eligendi.', 'Temporibus maiores magni autem dolores id nihil est sequi. Magni nihil enim commodi suscipit. Et quis aspernatur dolores quasi.', 'facere voluptas', '2002-10-16', 9, 4, NULL, NULL),
(46, 'A laboriosam excepturi impedit hic.', 'Quidem aspernatur temporibus harum voluptas vero. Exercitationem aut ipsum hic adipisci sed similique. Sint facilis vero quis ut nisi ut fuga voluptatem. Sapiente incidunt accusamus sit magnam.', 'autem', '2007-10-11', 10, 2, NULL, NULL),
(47, 'Est aliquid corrupti dolor quo voluptas.', 'Dolor sed quia quos porro. Quo quia rerum natus animi incidunt et quasi. Omnis similique eos nemo aperiam. Ipsam perferendis deleniti explicabo rerum consequuntur officia provident maiores.', 'quam', '2000-06-24', 7, 3, NULL, NULL),
(48, 'Voluptate est non id.', 'Enim veritatis aperiam impedit rerum asperiores. Veniam qui quia sint sequi. Explicabo numquam ea odit consequatur.', 'dolores deleniti', '1990-08-20', 9, 4, NULL, NULL),
(49, 'Id laboriosam sit esse.', 'Id aut ut iusto dolore. Nostrum velit libero sed non magni aut repellat voluptatibus. Maxime eum iusto voluptatem hic. Repudiandae ipsam nostrum ut est ad.', 'nam quia', '1989-10-27', 7, 1, NULL, NULL),
(50, 'Velit maiores ullam exercitationem aliquam numquam.', 'Qui voluptas dolores minima veritatis. Eaque nostrum nobis occaecati autem nihil.', 'earum dolor', '1982-02-16', 7, 2, NULL, NULL),
(51, 'Molestiae recusandae dolorem mollitia facilis.', 'Inventore ducimus cupiditate nesciunt qui voluptatibus odit. Ipsam qui corporis accusantium incidunt repellat sit. Esse adipisci fugit dolores fuga non. Voluptate enim praesentium aut. Rerum tempora excepturi autem est magnam dolor hic.', 'nihil nisi', '2007-01-02', 3, 1, NULL, NULL),
(52, 'Temporibus eos recusandae.', 'Architecto consequatur nam dignissimos rerum veritatis. Provident omnis pariatur aliquam. Rerum sequi dignissimos fugiat distinctio et rem aspernatur.', 'facilis distinctio', '1987-07-05', 10, 4, NULL, NULL),
(53, 'Minima ut adipisci aut in et.', 'Fuga eos repellat quo voluptates. Vel tempora dolorem ut quia eius nisi est.', 'tempore eum', '2006-06-23', 9, 2, NULL, NULL),
(54, 'Molestias earum accusantium quibusdam.', 'Possimus ut at necessitatibus. Et fugit neque voluptatem reprehenderit quo officiis sit quasi. Ut possimus veniam sit dolores cum animi veritatis. Debitis mollitia soluta et qui.', 'et', '1985-06-29', 6, 4, NULL, NULL),
(55, 'Et ut aut.', 'Nam nihil eos sed alias culpa ullam incidunt. Consequatur repudiandae sunt voluptate quis rem. Illo neque velit amet natus amet et sequi.', 'nisi dolor', '2019-03-14', 3, 2, NULL, NULL),
(56, 'Doloremque et dignissimos modi eos.', 'Iusto asperiores molestiae repellat officia. Dolore fugiat sed hic unde voluptas doloribus qui. Consequatur earum libero sit blanditiis.', 'ea', '1974-04-30', 9, 3, NULL, NULL),
(57, 'Quia ratione hic assumenda.', 'Explicabo delectus laboriosam minima officiis occaecati vero voluptas quaerat. Sit laboriosam alias rem ut vel. Ex fuga eos molestias ut atque nulla commodi qui. Sapiente commodi eaque dolorem earum veritatis et aperiam.', 'in ut', '2014-10-18', 7, 3, NULL, NULL),
(58, 'Beatae veritatis harum aut.', 'Explicabo suscipit debitis quibusdam harum illum fuga. Voluptates alias eligendi numquam dolorum reiciendis. Voluptate deserunt fugit facilis. Quam iure excepturi culpa repudiandae maxime qui nisi ea.', 'optio suscipit', '2018-05-30', 11, 2, NULL, NULL),
(59, 'Dolores facere qui et cum.', 'Voluptatem nisi et autem aut. Sed architecto ea eaque quia. Possimus vitae expedita et nobis. Quo incidunt nam illo.', 'magnam architecto', '1973-11-08', 7, 2, NULL, NULL),
(60, 'Non animi aperiam voluptatem unde nam.', 'Et voluptates libero eaque sed eligendi modi cupiditate. Eligendi nulla debitis dicta aperiam molestias incidunt. Eos sed labore optio architecto tempore hic est. Nemo eum et quaerat dolorum a nam ullam. Mollitia labore quo omnis nihil velit sed dolorem ipsum.', 'dolorum', '1975-06-21', 5, 1, NULL, NULL),
(61, 'Voluptatibus minima minus dicta.', 'Et et incidunt rerum ea numquam. Beatae aperiam assumenda in accusantium.', 'nam sunt', '1978-05-10', 3, 3, NULL, NULL),
(62, 'Voluptatibus suscipit nemo.', 'Modi possimus modi iure omnis ipsa magni neque libero. Dolor inventore hic vel magnam dicta beatae. Sit aut sint incidunt delectus. Vero libero accusamus optio voluptas.', 'quia', '1983-03-16', 3, 1, NULL, NULL),
(63, 'Delectus voluptatem ut quibusdam.', 'Esse qui cupiditate ut quisquam neque. Et sit quis sed ipsum qui dolorem. Ut culpa est exercitationem quis atque et autem.', 'iusto', '2008-10-20', 10, 2, NULL, NULL),
(64, 'Enim qui molestiae dolorem nobis vitae.', 'Tenetur quia vel ea occaecati et architecto. Vitae tempore qui quia molestias. Voluptas eligendi velit voluptas. Temporibus saepe eius ut qui non est.', 'voluptas', '1986-04-11', 3, 4, NULL, NULL),
(65, 'Est omnis aut atque doloremque.', 'Sequi quis sit officia est. Autem nobis laboriosam rerum et corporis odit. Sit rerum ipsum ea ducimus.', 'iusto pariatur', '2013-07-09', 4, 4, NULL, NULL),
(66, 'Exercitationem ad fuga.', 'Sint modi laudantium adipisci praesentium aut. Id et accusantium omnis odio voluptatem ut omnis. Reprehenderit fuga natus dolores. Quisquam saepe non laudantium repellendus odit dolor autem.', 'eligendi', '2020-01-09', 10, 2, NULL, NULL),
(67, 'Provident explicabo consequatur et.', 'Voluptatibus fugiat molestiae quibusdam voluptatum reprehenderit. Ea hic temporibus fugit aut quibusdam non. Provident tenetur in vel. Non qui voluptate sequi hic velit necessitatibus.', 'consequatur', '1996-07-29', 2, 2, NULL, NULL),
(68, 'Facere quo alias voluptas molestias.', 'Quidem est commodi qui voluptas a. Dolor occaecati repudiandae iusto voluptates. Porro et sint tempora reprehenderit est.', 'ut', '1996-11-06', 2, 3, NULL, NULL),
(69, 'Pariatur odit illum quo distinctio.', 'Quibusdam incidunt quia aliquid at. Ex iusto veniam consequatur id ut nobis minima consequatur. Vel est sunt excepturi ipsum.', 'aut adipisci', '2017-08-05', 9, 3, NULL, NULL),
(70, 'Aperiam quia reiciendis.', 'Quis et quos sequi sint ut possimus. Voluptas ut et quo ducimus quia repudiandae. Sunt dolor veritatis asperiores repudiandae sapiente. Dolor ad molestias ea recusandae ratione tempora sapiente.', 'sit', '1986-11-22', 6, 2, NULL, NULL),
(71, 'Vel sit non.', 'Vel a qui sed et. Nihil ut et illum quia natus quia. Veniam ipsa animi sed velit. Rerum mollitia quisquam repellat nesciunt.', 'officia ipsa', '1972-09-29', 5, 2, NULL, NULL),
(72, 'Vero vitae sed eos non repudiandae.', 'Ipsam illo atque ut molestias. Aut fuga dolorem aut corporis et. Et non ipsam provident voluptatum.', 'sed', '1975-06-20', 8, 3, NULL, NULL),
(73, 'Deserunt sapiente fugit quisquam fugiat.', 'Enim quod et deleniti. Necessitatibus molestiae architecto est maiores optio fugit. Delectus adipisci perspiciatis ea eos autem delectus repellat dolor. Dolorem aut perspiciatis qui.', 'eos', '1991-01-20', 3, 3, NULL, NULL),
(74, 'Vel aspernatur totam qui sit veniam.', 'Facere minus quis magni expedita quo. Quos officia nam qui nihil qui ea et aliquam.', 'rerum quia', '2018-04-13', 11, 4, NULL, NULL),
(75, 'Voluptas expedita praesentium est.', 'Hic sint veritatis odit magni ratione et iure voluptatem. Illo sed voluptatem repellendus mollitia ipsa deserunt rerum. Officiis ut dolores cumque omnis non. Molestiae officia perspiciatis aut et dignissimos consequatur ipsum eaque.', 'tempora vel', '1979-02-16', 3, 3, NULL, NULL),
(76, 'Aut esse sunt architecto quis quis.', 'Fugit ullam alias voluptatem nesciunt voluptatem ad. Voluptatum impedit ea reprehenderit vel. Eum laborum rerum nihil. Maiores aut rerum sed. Quisquam perferendis sapiente velit explicabo aliquid.', 'nam', '1982-08-27', 7, 2, NULL, NULL),
(77, 'Ut rerum a consectetur quis.', 'Consectetur sit odit iste. Illo quia minus ut. Tempora aut doloribus ex ea ex atque.', 'est aut', '1993-08-24', 5, 3, NULL, NULL),
(78, 'Aut distinctio accusantium ut est sunt.', 'Maiores aspernatur ut maxime dignissimos facere impedit. Est similique dicta eum velit rem quaerat. Eos numquam praesentium ex deserunt ducimus saepe in.', 'quisquam iste', '1980-03-20', 4, 3, NULL, NULL),
(79, 'Et ut rem.', 'Nihil explicabo asperiores culpa aut. Nihil et velit sit deserunt. Doloremque non sed eos quia quisquam id.', 'sunt', '2018-09-10', 6, 1, NULL, NULL),
(80, 'Nostrum hic quo.', 'Eligendi voluptatem velit odit rerum inventore consequuntur. Incidunt hic et esse eum architecto. Vel eaque dolor enim ullam et quo. Aut assumenda dolor beatae.', 'eos est', '1988-04-20', 9, 3, NULL, NULL),
(81, 'Ipsa natus at voluptate.', 'Vel laudantium quia error sunt facilis. Nihil vel inventore enim. Qui quisquam ab vel qui ut eos atque. Pariatur earum rerum vel et sapiente nesciunt. Perferendis dicta sapiente ut totam nesciunt similique.', 'culpa sit', '2001-11-23', 5, 3, NULL, NULL),
(82, 'Vero velit optio saepe.', 'Autem neque dolore officia est iusto. Impedit ea veritatis quas dolore id nemo eos excepturi. Officia aut earum itaque possimus. Ipsam sunt rerum consequatur dolorem.', 'ipsam', '2015-09-25', 6, 3, NULL, NULL),
(83, 'Animi praesentium beatae.', 'Vel ab quia et aut. Quas cupiditate sunt dolores ad ea aperiam voluptas. Consequatur reprehenderit alias iusto quia in voluptatem. Nemo dolorem et animi voluptatem.', 'fugiat', '2005-12-16', 3, 3, NULL, NULL),
(84, 'Soluta est autem aliquam.', 'Architecto autem omnis qui. Et ullam sed natus cupiditate. Porro asperiores sequi tenetur.', 'ut sunt', '2019-09-17', 8, 4, NULL, NULL),
(85, 'Voluptatem ipsum unde at nostrum.', 'Exercitationem laboriosam cum eum ea deleniti ab. Delectus quaerat ex excepturi quaerat. Impedit quia placeat tempora officia eaque quos quibusdam. Autem temporibus dolorum quod id illum.', 'est', '1988-11-22', 4, 1, NULL, NULL),
(86, 'Voluptates dolorem occaecati.', 'Ut temporibus dignissimos rem voluptatem accusantium explicabo soluta iusto. Suscipit labore dolor repellendus aut qui sed sint. Autem harum excepturi nemo a nihil veritatis illum. Aut voluptas cupiditate qui necessitatibus.', 'minima praesentium', '2018-05-31', 10, 1, NULL, NULL),
(87, 'Eos qui ut minima.', 'Dignissimos fuga quia nesciunt nemo ut officiis sed. Delectus asperiores quos itaque consequatur iste delectus nostrum. Tempora sint aut voluptatem aut inventore quis recusandae. Ipsa dolorem voluptatem enim sed officia dolorem ut.', 'architecto et', '1991-03-23', 8, 4, NULL, NULL),
(88, 'Illum sit et ut similique.', 'Facere temporibus id voluptatem aut aspernatur consectetur sapiente. Deleniti et sequi eos tenetur voluptatibus. Sed velit sit rerum non quia maiores harum.', 'neque voluptatem', '1971-04-18', 5, 4, NULL, NULL),
(89, 'Omnis odit ratione molestiae.', 'Molestiae nostrum temporibus et non assumenda nostrum. Amet inventore aut non omnis. Velit temporibus aut tenetur dolorum ut. Itaque ea cupiditate id fuga sed in eius.', 'sit rem', '1999-12-28', 5, 3, NULL, NULL),
(90, 'Nihil consequatur in iste.', 'Non perspiciatis praesentium dolores quisquam quo dolorem sit. Dolorem aut nulla est omnis libero. Et vel in accusamus assumenda dolorem iusto.', 'quod', '2008-08-30', 9, 2, NULL, NULL),
(91, 'Nulla ipsum adipisci temporibus.', 'Et iure odit minus adipisci molestiae. Quia aut molestiae dolorum illo enim repellat ut recusandae. Cupiditate voluptatem ea dolorem facere. Aliquid quae voluptatem recusandae sed rerum.', 'esse', '1973-01-18', 10, 2, NULL, NULL),
(92, 'Officia voluptas laborum animi.', 'Voluptatem corporis ea voluptas. Reprehenderit ut quo quis ut illum. Dicta aliquid qui totam maiores dolor aut ipsam quibusdam. Libero dignissimos omnis qui dolore.', 'corporis', '2005-09-24', 3, 4, NULL, NULL),
(93, 'Sint assumenda hic eveniet voluptates.', 'Occaecati voluptatem delectus impedit eos distinctio assumenda. Ea ex dolor non architecto aut. Consequuntur eveniet dignissimos aut. Qui veritatis cupiditate id dolor.', 'est', '2011-06-03', 6, 3, NULL, NULL),
(94, 'Nulla ut accusamus.', 'Vitae modi enim rerum maiores. In non voluptas repellendus autem quo qui. Cumque ipsam sint aut fugit animi. Fugiat omnis cupiditate magnam soluta illo maiores.', 'voluptates', '1971-05-19', 5, 4, NULL, NULL),
(95, 'Distinctio magnam numquam voluptatem et.', 'Et aut unde reiciendis at quod impedit et. Maxime in quibusdam explicabo ea ad ea et. Id beatae illo numquam rerum. Autem ut magni quasi.', 'itaque sed', '1983-05-03', 3, 4, NULL, NULL),
(96, 'Labore molestiae est suscipit quibusdam.', 'Quas ut et modi laboriosam ipsa aspernatur aut ut. Voluptatem impedit vero in placeat est voluptas. Corrupti illum non similique explicabo non exercitationem et.', 'nobis', '2012-05-13', 6, 4, NULL, NULL),
(97, 'Ad necessitatibus corporis perferendis asperiores.', 'Dolores consequuntur aut quia dignissimos quod quaerat. Harum laudantium doloribus unde incidunt sit nesciunt repellat iure. Aut molestias omnis voluptatem.', 'omnis sit', '2013-09-15', 4, 3, NULL, NULL),
(98, 'Ducimus et repudiandae.', 'Animi quasi corporis aspernatur qui ducimus. Eaque consequatur dolore et libero similique culpa sunt. Porro nesciunt quia dolor quo recusandae. Reiciendis rerum voluptas itaque voluptates accusamus error debitis.', 'omnis sequi', '1978-02-06', 4, 2, NULL, NULL),
(99, 'Dolores magni sit consequatur minus esse.', 'Ex mollitia blanditiis non quibusdam repellendus. Optio ex velit porro accusamus cum. Quos velit doloribus labore aliquam et aut.', 'ut', '1982-08-05', 6, 2, NULL, NULL),
(100, 'Accusantium quia nihil architecto.', 'Magnam id qui mollitia quisquam magni. Consequatur eius voluptatem dolorum totam exercitationem. Iusto nesciunt eaque repellat facere possimus. Incidunt velit sed aut nihil optio labore quia.', 'fugit doloribus', '1984-07-14', 10, 3, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_id` int(10) UNSIGNED NOT NULL,
  `department_id` int(10) UNSIGNED NOT NULL,
  `category_id` int(10) UNSIGNED NOT NULL,
  `service_id` int(10) UNSIGNED NOT NULL,
  `status_id` int(10) UNSIGNED NOT NULL,
  `order_date` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `order_no`, `customer_id`, `department_id`, `category_id`, `service_id`, `status_id`, `order_date`, `created_at`, `updated_at`) VALUES
(1, 'ORD#123', 1, 1, 1, 1, 4, '2020-07-21 11:29:08', '2020-07-21 06:29:10', '2020-07-21 09:01:45'),
(3, 'ORD#123', 2, 1, 1, 1, 1, '2020-07-21 11:29:08', '2020-07-21 06:29:10', '2020-07-21 09:05:35'),
(4, 'ORD#123', 4, 1, 1, 1, 4, '2020-07-21 11:29:08', '2020-07-21 06:29:10', '2020-07-21 02:03:41'),
(5, 'ORD#123', 3, 1, 1, 1, 3, '2020-07-21 11:29:08', '2020-07-21 06:29:10', '2020-07-21 09:05:40'),
(6, 'ORD#123', 1, 1, 1, 1, 2, '2020-07-21 11:29:08', '2020-07-21 06:29:10', '2020-07-21 09:05:44'),
(7, 'ORD#123', 4, 1, 1, 1, 4, '2020-07-21 11:29:08', '2020-07-21 06:29:10', '2020-07-21 02:03:41'),
(8, 'ORD#123', 4, 1, 1, 1, 4, '2020-07-21 11:29:08', '2020-07-21 06:29:10', '2020-07-21 02:03:41');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'browse bread 1', 'web', '2020-07-20 02:17:32', '2020-07-20 02:17:32'),
(2, 'read bread 1', 'web', '2020-07-20 02:17:32', '2020-07-20 02:17:32'),
(3, 'edit bread 1', 'web', '2020-07-20 02:17:32', '2020-07-20 02:17:32'),
(4, 'add bread 1', 'web', '2020-07-20 02:17:32', '2020-07-20 02:17:32'),
(5, 'delete bread 1', 'web', '2020-07-20 02:17:33', '2020-07-20 02:17:33');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'web', '2020-07-20 02:17:21', '2020-07-20 02:17:21'),
(2, 'user', 'web', '2020-07-20 02:17:21', '2020-07-20 02:17:21'),
(3, 'guest', 'web', '2020-07-20 02:17:21', '2020-07-20 02:17:21');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 3),
(2, 3),
(3, 3),
(4, 3),
(5, 3);

-- --------------------------------------------------------

--
-- Table structure for table `role_hierarchy`
--

CREATE TABLE `role_hierarchy` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL,
  `hierarchy` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_hierarchy`
--

INSERT INTO `role_hierarchy` (`id`, `role_id`, `hierarchy`) VALUES
(1, 1, 1),
(2, 2, 2),
(3, 3, 3);

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fee` int(100) UNSIGNED NOT NULL,
  `category_id` int(10) UNSIGNED NOT NULL,
  `sub_category_id` int(10) UNSIGNED DEFAULT NULL,
  `department_id` int(10) UNSIGNED NOT NULL,
  `formbuilder_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `name`, `fee`, `category_id`, `sub_category_id`, `department_id`, `formbuilder_id`, `created_at`, `updated_at`) VALUES
(1, 'Service 1', 10000, 1, NULL, 1, 2, '2020-07-20 10:23:36', '2020-07-21 09:34:05'),
(4, 'Service 3', 0, 1, 4, 2, 0, '2020-07-20 11:19:58', '2020-07-20 11:25:14'),
(5, 'New CNIC Card', 500, 1, NULL, 6, 2, '2020-07-21 09:14:38', '2020-07-21 09:33:38');

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE `status` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `class` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`id`, `name`, `class`) VALUES
(1, 'pending', 'badge badge-pill badge-warning'),
(2, 'inprocess', 'badge badge-pill badge-secondary'),
(3, 'confirmed', 'badge badge-pill badge-primary'),
(4, 'completed', 'badge badge-pill badge-success'),
(5, 'cancelled', 'badge badge-pill badge-danger');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `menuroles` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `menuroles`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'admin', 'admin@admin.com', '2020-07-20 02:17:21', '$2y$10$mpR0JO/LUKAk2cUgFpMMmezGaOlO6YIIZxpTA6HZcWrU5ba12AkKe', 'user,admin', 'hihcOMMSRdVqsrbi0PC07beygY31OllT6NSiHvMF3meTrFCGGVBaVoHZREOH', '2020-07-20 02:17:21', '2020-07-21 04:44:33', NULL),
(2, 'Amina Hammes', 'tblick@example.org', '2020-07-20 02:17:21', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', '7fTpoyjfb8', '2020-07-20 02:17:21', '2020-07-20 02:17:21', NULL),
(3, 'Jerrell Mitchell', 'schaefer.peter@example.net', '2020-07-20 02:17:22', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', 'qjUbFeCsfF', '2020-07-20 02:17:22', '2020-07-20 02:17:22', NULL),
(4, 'Mr. Leo Botsford', 'gabriel62@example.com', '2020-07-20 02:17:22', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', 'n0U0rqQfli', '2020-07-20 02:17:22', '2020-07-20 02:17:22', NULL),
(5, 'Spencer Rodriguez Jr.', 'anabelle.abbott@example.net', '2020-07-20 02:17:22', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', '7YPAwIhPbY', '2020-07-20 02:17:22', '2020-07-20 02:17:22', NULL),
(6, 'Mr. Melvin Walsh Sr.', 'zcronin@example.com', '2020-07-20 02:17:22', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', 'zfO9dPrnW7', '2020-07-20 02:17:22', '2020-07-21 03:32:42', '2020-07-21 03:32:42'),
(7, 'Maximillia Windler', 'jeanne41@example.com', '2020-07-20 02:17:22', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', 'L1LcTHHZaY', '2020-07-20 02:17:22', '2020-07-21 03:32:41', '2020-07-21 03:32:41'),
(8, 'Brandyn Schmidt', 'anderson18@example.net', '2020-07-20 02:17:22', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', '1sHCjQyr2t', '2020-07-20 02:17:22', '2020-07-21 03:32:39', '2020-07-21 03:32:39'),
(9, 'Dr. Ashlynn Lueilwitz III', 'addie.barton@example.com', '2020-07-20 02:17:22', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', 'ZV5rjsIkyl', '2020-07-20 02:17:22', '2020-07-21 03:32:37', '2020-07-21 03:32:37'),
(10, 'Faustino Dickinson', 'langosh.annabel@example.org', '2020-07-20 02:17:22', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', 'JUVI89f42B', '2020-07-20 02:17:22', '2020-07-21 03:32:35', '2020-07-21 03:32:35'),
(11, 'Marshall Satterfield', 'mason.ryan@example.com', '2020-07-20 02:17:22', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', 'aLUfA6fpKh', '2020-07-20 02:17:22', '2020-07-21 03:32:33', '2020-07-21 03:32:33'),
(13, 'Test User', 'test@gmail.com', '2020-07-21 02:33:53', '$2y$10$3WAVllHKzRWJhR09As2HOunq0bU8oXTsIZoV5bM4JwmWWdogGbkcq', 'user', NULL, '2020-07-21 02:33:53', '2020-07-21 03:32:32', '2020-07-21 03:32:32');

-- --------------------------------------------------------

--
-- Table structure for table `websites`
--

CREATE TABLE `websites` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `website_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `website_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `service_id` int(10) UNSIGNED NOT NULL,
  `department_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `email_template`
--
ALTER TABLE `email_template`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `example`
--
ALTER TABLE `example`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `folder`
--
ALTER TABLE `folder`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `form`
--
ALTER TABLE `form`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `form_builders`
--
ALTER TABLE `form_builders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `form_field`
--
ALTER TABLE `form_field`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`),
  ADD KEY `media_model_type_model_id_index` (`model_type`,`model_id`);

--
-- Indexes for table `menulist`
--
ALTER TABLE `menulist`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu_role`
--
ALTER TABLE `menu_role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `role_hierarchy`
--
ALTER TABLE `role_hierarchy`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `websites`
--
ALTER TABLE `websites`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `email_template`
--
ALTER TABLE `email_template`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `example`
--
ALTER TABLE `example`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `folder`
--
ALTER TABLE `folder`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `form`
--
ALTER TABLE `form`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `form_builders`
--
ALTER TABLE `form_builders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `form_field`
--
ALTER TABLE `form_field`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `media`
--
ALTER TABLE `media`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `menulist`
--
ALTER TABLE `menulist`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `menu_role`
--
ALTER TABLE `menu_role`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=139;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `notes`
--
ALTER TABLE `notes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `role_hierarchy`
--
ALTER TABLE `role_hierarchy`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `status`
--
ALTER TABLE `status`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `websites`
--
ALTER TABLE `websites`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
