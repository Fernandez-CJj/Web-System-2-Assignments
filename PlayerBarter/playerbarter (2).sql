-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 11, 2026 at 11:06 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `playerbarter`
--

-- --------------------------------------------------------

--
-- Table structure for table `app_notifications`
--

CREATE TABLE `app_notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `link` varchar(255) DEFAULT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `app_notifications`
--

INSERT INTO `app_notifications` (`id`, `user_id`, `title`, `body`, `link`, `read_at`, `created_at`, `updated_at`) VALUES
(1, 8, 'New trade request', 'marj requested arcana.', 'http://127.0.0.1:8000/trades', '2026-04-27 23:14:42', '2026-04-27 22:37:35', '2026-04-27 23:14:42'),
(2, 9, 'Trade request accepted', 'Your request for arcana was accepted. Confirm completion after the trade is coordinated.', 'http://127.0.0.1:8000/trades', '2026-04-27 23:13:23', '2026-04-27 22:38:00', '2026-04-27 23:13:23'),
(3, 9, 'Trade request cancelled', 'The trade request for arcana was cancelled.', 'http://127.0.0.1:8000/trades', '2026-04-27 23:13:17', '2026-04-27 22:38:08', '2026-04-27 23:13:17'),
(4, 8, 'New trade request', 'marj requested arcana.', 'http://127.0.0.1:8000/trades', '2026-04-27 23:14:40', '2026-04-27 23:13:36', '2026-04-27 23:14:40'),
(5, 9, 'Trade request accepted', 'Your request for arcana was accepted. Confirm completion after the trade is coordinated.', 'http://127.0.0.1:8000/trades', '2026-04-27 23:14:00', '2026-04-27 23:13:50', '2026-04-27 23:14:00'),
(6, 9, 'Trade completed', 'Both players confirmed arcana.', 'http://127.0.0.1:8000/trades', '2026-04-28 00:27:03', '2026-04-27 23:14:03', '2026-04-28 00:27:03'),
(7, 8, 'Trade completed', 'Both players confirmed arcana.', 'http://127.0.0.1:8000/trades', '2026-04-27 23:14:37', '2026-04-27 23:14:03', '2026-04-27 23:14:37'),
(8, 10, 'New trade request', 'CJ requested 10,000 gold coins.', 'http://127.0.0.1:8000/trades', '2026-04-28 00:12:16', '2026-04-28 00:11:47', '2026-04-28 00:12:16'),
(9, 8, 'Trade request rejected', 'The trade request for 10,000 gold coins was rejected.', 'http://127.0.0.1:8000/trades', '2026-04-28 00:12:28', '2026-04-28 00:12:22', '2026-04-28 00:12:28'),
(10, 1, 'New moderation report', 'A player submitted a report for admin review.', 'http://127.0.0.1:8000/admin/reports', '2026-04-28 00:46:01', '2026-04-28 00:31:25', '2026-04-28 00:46:01'),
(11, 10, 'New trade request', 'CJ requested 10,000 gold coins.', 'http://127.0.0.1:8000/trades', '2026-04-28 00:42:38', '2026-04-28 00:41:54', '2026-04-28 00:42:38'),
(12, 8, 'Trade request accepted', 'Your request for 10,000 gold coins was accepted. Confirm completion after the trade is coordinated.', 'http://127.0.0.1:8000/trades', '2026-04-28 00:47:06', '2026-04-28 00:42:57', '2026-04-28 00:47:06'),
(13, 8, 'Trade message received', 'hahaha replied about 10,000 gold coins.', 'http://127.0.0.1:8000/trades', '2026-04-28 00:43:22', '2026-04-28 00:43:05', '2026-04-28 00:43:22'),
(14, 10, 'Moderation warning', 'An administrator reviewed a report involving your account and issued a warning. Please review your trade conduct.', 'http://127.0.0.1:8000/notifications', '2026-04-28 00:46:30', '2026-04-28 00:46:18', '2026-04-28 00:46:30'),
(15, 1, 'New moderation report', 'A player submitted a report for admin review.', 'http://127.0.0.1:8000/admin/reports', '2026-04-28 01:02:35', '2026-04-28 01:01:49', '2026-04-28 01:02:35'),
(16, 10, 'Moderation warning', 'An administrator reviewed a report involving your account and issued a warning. Please review your trade conduct.', 'http://127.0.0.1:8000/notifications', '2026-04-28 01:03:31', '2026-04-28 01:02:45', '2026-04-28 01:03:31'),
(17, 8, 'Report resolved', 'Your report status is now resolved. Admin note: resolved', 'http://127.0.0.1:8000/notifications', '2026-04-28 01:03:13', '2026-04-28 01:02:45', '2026-04-28 01:03:13'),
(18, 10, 'Moderation warning', 'An administrator reviewed a report involving your account and issued a warning. Please review your trade conduct.', 'http://127.0.0.1:8000/notifications', '2026-04-28 01:03:30', '2026-04-28 01:02:59', '2026-04-28 01:03:30'),
(19, 8, 'Report resolved', 'Your report status is now resolved. Admin note: resolved', 'http://127.0.0.1:8000/notifications', '2026-04-28 01:03:10', '2026-04-28 01:02:59', '2026-04-28 01:03:10'),
(20, 8, 'Trade request cancelled', 'The trade request for 10,000 gold coins was cancelled.', 'http://127.0.0.1:8000/trades', NULL, '2026-05-11 06:01:31', '2026-05-11 06:01:31'),
(21, 8, 'New trade request', 'hahaha requested damit ni totoy.', 'http://127.0.0.1:8000/trades', '2026-05-11 06:02:07', '2026-05-11 06:01:41', '2026-05-11 06:02:07'),
(22, 10, 'Trade message received', 'CJ replied about damit ni totoy.', 'http://127.0.0.1:8000/trades', '2026-05-11 06:02:34', '2026-05-11 06:02:18', '2026-05-11 06:02:34'),
(23, 8, 'New trade request', 'hahaha requested damit ni totoy.', 'http://127.0.0.1:8000/trades', NULL, '2026-05-11 06:16:40', '2026-05-11 06:16:40'),
(24, 8, 'Trade request cancelled', 'The trade request for damit ni totoy was cancelled.', 'http://127.0.0.1:8000/trades', NULL, '2026-05-11 06:20:41', '2026-05-11 06:20:41'),
(25, 8, 'Trade request cancelled', 'The trade request for damit ni totoy was cancelled.', 'http://127.0.0.1:8000/trades', NULL, '2026-05-11 06:20:43', '2026-05-11 06:20:43'),
(26, 8, 'New trade request', 'hahaha requested damit ni totoy.', 'http://127.0.0.1:8000/trades', NULL, '2026-05-11 06:20:49', '2026-05-11 06:20:49'),
(27, 8, 'Trade message received', 'hahaha replied about damit ni totoy.', 'http://127.0.0.1:8000/trades', '2026-05-11 06:21:25', '2026-05-11 06:20:53', '2026-05-11 06:21:25'),
(28, 10, 'Trade message received', 'CJ replied about damit ni totoy.', 'http://127.0.0.1:8000/trades', '2026-05-11 06:22:25', '2026-05-11 06:21:46', '2026-05-11 06:22:25'),
(29, 8, 'Trade message received', 'hahaha replied about damit ni totoy.', 'http://127.0.0.1:8000/trades', NULL, '2026-05-11 06:27:47', '2026-05-11 06:27:47');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
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
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_04_28_000001_create_playerbarter_tables', 1),
(5, '2026_04_28_030000_remove_name_from_users_table', 2),
(6, '2026_04_28_040000_create_trade_messages_table', 3),
(7, '2026_05_11_000000_add_profile_photos_and_trade_item_images', 4);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

CREATE TABLE `ratings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `trade_request_id` bigint(20) UNSIGNED NOT NULL,
  `rater_id` bigint(20) UNSIGNED NOT NULL,
  `rated_user_id` bigint(20) UNSIGNED NOT NULL,
  `score` tinyint(3) UNSIGNED NOT NULL,
  `comment` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ratings`
--

INSERT INTO `ratings` (`id`, `trade_request_id`, `rater_id`, `rated_user_id`, `score`, `comment`, `created_at`, `updated_at`) VALUES
(1, 2, 9, 8, 5, 'good', '2026-04-27 23:14:10', '2026-04-27 23:14:10'),
(2, 2, 8, 9, 2, 'madamot ayaw makipag-nego', '2026-04-27 23:14:31', '2026-04-28 00:12:46');

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `reporter_id` bigint(20) UNSIGNED NOT NULL,
  `reported_user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `trade_item_id` bigint(20) UNSIGNED DEFAULT NULL,
  `reason` varchar(255) NOT NULL,
  `details` text DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'open',
  `admin_notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`id`, `reporter_id`, `reported_user_id`, `trade_item_id`, `reason`, `details`, `status`, `admin_notes`, `created_at`, `updated_at`) VALUES
(1, 8, 10, NULL, 'harassment', 'not paying', 'resolved', 'resolved', '2026-04-28 00:31:25', '2026-04-28 00:31:57'),
(2, 8, 10, NULL, 'scam', NULL, 'resolved', 'resolved', '2026-04-28 01:01:49', '2026-04-28 01:02:45');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('0x0Ag4rTz1I7oYRzo1vW4whBiM221Vja7sVkfwJH', 9, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiaWdPb3dMSktNTUtjZWVGRGdmVGNka3BwMWU1b2FFSkNZaHNoR0xJSCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjk7fQ==', 1778509318),
('lNsR94UQxYLCtLjXEpZ768Q5uWjvltxVwTDYKWcM', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiU1ZYNUNzdno2bjNNbDFhMmVqWE9zeFFLSURETUZlRlZCTWdxd2Y2TSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7czo0OiJob21lIjt9fQ==', 1778509711),
('S3lVc0KjNOFBX1l3ZVeOQYJpOZYfVbQxJP8qgplI', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT; Windows NT 10.0; en-PH) WindowsPowerShell/5.1.19041.4648', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZHg0Y1IzN2tmREw5bk1RT2M1SnVBeExEQndhd1lNcm15TUFzVm1LbCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyODoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL3RyYWRlcyI7fXM6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjI4OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvdHJhZGVzIjtzOjU6InJvdXRlIjtzOjEyOiJ0cmFkZXMuaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1778506612);

-- --------------------------------------------------------

--
-- Table structure for table `trade_items`
--

CREATE TABLE `trade_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `game_category` varchar(255) NOT NULL,
  `rarity` varchar(255) NOT NULL DEFAULT 'common',
  `availability_status` varchar(255) NOT NULL DEFAULT 'available',
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `trade_items`
--

INSERT INTO `trade_items` (`id`, `user_id`, `name`, `type`, `game_category`, `rarity`, `availability_status`, `description`, `created_at`, `updated_at`) VALUES
(13, 9, 'arcana', 'Cosmetic Item', 'dota 2', 'limited', 'traded', 'yeppp', '2026-04-27 22:36:15', '2026-04-27 23:14:03'),
(14, 10, '10,000 gold coins', 'Game Resource', 'Lost Ark', 'common', 'available', 'pay up front of 100$', '2026-04-28 00:11:18', '2026-05-11 06:01:31'),
(15, 8, 'dwa', 'Cosmetic Item', 'dwa', 'common', 'available', 'dwa', '2026-04-28 00:56:33', '2026-04-28 00:56:33'),
(16, 8, 'dwa', 'Cosmetic Item', 'dwa', 'common', 'available', 'daw', '2026-04-28 00:56:39', '2026-04-28 00:56:39'),
(17, 8, 'dwa', 'Cosmetic Item', 'dwa', 'common', 'available', 'dwa', '2026-04-28 00:56:44', '2026-04-28 00:56:44'),
(18, 8, 'dwa', 'Cosmetic Item', 'dwa', 'common', 'available', 'dwadaw', '2026-04-28 00:56:49', '2026-04-28 00:56:49'),
(19, 8, 'dwa', 'Cosmetic Item', 'daw', 'common', 'available', 'dwadaw', '2026-04-28 00:56:54', '2026-04-28 00:56:54'),
(20, 8, 'daw', 'Cosmetic Item', 'dwa', 'common', 'available', 'daw', '2026-04-28 00:57:00', '2026-04-28 00:57:00'),
(21, 8, 'dwa', 'Cosmetic Item', 'dwa', 'common', 'available', 'dwa', '2026-04-28 00:57:04', '2026-04-28 00:57:04'),
(22, 8, 'dwa', 'Cosmetic Item', 'dwa', 'common', 'available', 'dwa', '2026-04-28 00:57:09', '2026-04-28 00:57:09'),
(23, 8, 'dwa', 'Cosmetic Item', 'dwa', 'common', 'available', 'daw', '2026-04-28 00:57:13', '2026-04-28 00:57:13'),
(24, 8, 'dwa', 'Cosmetic Item', 'dwa', 'common', 'available', 'dwa', '2026-04-28 00:57:18', '2026-04-28 00:57:18'),
(25, 8, 'dwa', 'Cosmetic Item', 'daw', 'common', 'available', 'daw', '2026-04-28 00:57:32', '2026-04-28 00:57:32'),
(26, 8, 'dwa', 'Cosmetic Item', 'daw', 'common', 'available', 'daw', '2026-04-28 00:57:35', '2026-04-28 00:57:35'),
(27, 8, 'dwa', 'Cosmetic Item', 'dwa', 'common', 'available', 'daw', '2026-04-28 00:57:38', '2026-04-28 00:57:38'),
(28, 8, 'dwa', 'Cosmetic Item', 'daw', 'common', 'available', 'daw', '2026-04-28 00:57:40', '2026-04-28 00:57:40'),
(29, 8, 'damit ni totoy', 'Collectible Item', 'Counter-Strike 2', 'uncommon', 'available', 'mabango pa ito', '2026-05-11 05:59:42', '2026-05-11 05:59:42');

-- --------------------------------------------------------

--
-- Table structure for table `trade_item_images`
--

CREATE TABLE `trade_item_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `trade_item_id` bigint(20) UNSIGNED NOT NULL,
  `path` varchar(255) NOT NULL,
  `original_name` varchar(255) DEFAULT NULL,
  `sort_order` smallint(5) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `trade_item_images`
--

INSERT INTO `trade_item_images` (`id`, `trade_item_id`, `path`, `original_name`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 29, 'trade-items/O7heSIXTvny2ZtGj7tPSKjgV6VnxeLGtcl9JnJku.png', 'ChatGPT Image Apr 28, 2026, 11_49_32 PM.png', 1, '2026-05-11 05:59:42', '2026-05-11 05:59:42'),
(2, 29, 'trade-items/9tlU6s4jXN300pFqPHGOyriPjpxVF2lzivHS4sHg.png', 'ChatGPT Image Apr 28, 2026, 11_49_29 PM.png', 2, '2026-05-11 05:59:42', '2026-05-11 05:59:42');

-- --------------------------------------------------------

--
-- Table structure for table `trade_messages`
--

CREATE TABLE `trade_messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `trade_request_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `body` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `trade_messages`
--

INSERT INTO `trade_messages` (`id`, `trade_request_id`, `user_id`, `body`, `created_at`, `updated_at`) VALUES
(1, 1, 9, '1k', '2026-04-27 22:37:35', '2026-04-27 22:38:08'),
(2, 3, 8, 'how about 50$ mate?', '2026-04-28 00:11:47', '2026-04-28 00:12:22'),
(3, 4, 8, '1k', '2026-04-28 00:41:54', '2026-04-28 00:41:54'),
(4, 4, 10, 'pay through here', '2026-04-28 00:43:05', '2026-04-28 00:43:05'),
(5, 5, 10, '5k', '2026-05-11 06:01:41', '2026-05-11 06:01:41'),
(6, 5, 8, 'lels', '2026-05-11 06:02:18', '2026-05-11 06:02:18'),
(7, 6, 10, '5ol', '2026-05-11 06:16:40', '2026-05-11 06:16:40'),
(8, 7, 10, '5k', '2026-05-11 06:20:53', '2026-05-11 06:20:53'),
(9, 7, 8, '2k nalang masyadong malaki yan te', '2026-05-11 06:21:46', '2026-05-11 06:21:46'),
(10, 7, 10, 'oke', '2026-05-11 06:27:47', '2026-05-11 06:27:47');

-- --------------------------------------------------------

--
-- Table structure for table `trade_requests`
--

CREATE TABLE `trade_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `item_id` bigint(20) UNSIGNED NOT NULL,
  `requester_id` bigint(20) UNSIGNED NOT NULL,
  `owner_id` bigint(20) UNSIGNED NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `requester_confirmed` tinyint(1) NOT NULL DEFAULT 0,
  `owner_confirmed` tinyint(1) NOT NULL DEFAULT 0,
  `completed_at` timestamp NULL DEFAULT NULL,
  `message` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `trade_requests`
--

INSERT INTO `trade_requests` (`id`, `item_id`, `requester_id`, `owner_id`, `status`, `requester_confirmed`, `owner_confirmed`, `completed_at`, `message`, `created_at`, `updated_at`) VALUES
(1, 13, 9, 8, 'cancelled', 0, 0, NULL, '1k', '2026-04-27 22:37:35', '2026-04-27 22:38:08'),
(2, 13, 9, 8, 'completed', 1, 1, '2026-04-27 23:14:03', NULL, '2026-04-27 23:13:36', '2026-04-27 23:14:03'),
(3, 14, 8, 10, 'rejected', 0, 0, NULL, 'how about 50$ mate?', '2026-04-28 00:11:47', '2026-04-28 00:12:22'),
(4, 14, 8, 10, 'cancelled', 0, 0, NULL, '1k', '2026-04-28 00:41:54', '2026-05-11 06:01:31'),
(5, 29, 10, 8, 'cancelled', 0, 0, NULL, '5k', '2026-05-11 06:01:41', '2026-05-11 06:20:41'),
(6, 29, 10, 8, 'cancelled', 0, 0, NULL, '5ol', '2026-05-11 06:16:40', '2026-05-11 06:20:43'),
(7, 29, 10, 8, 'pending', 0, 0, NULL, NULL, '2026-05-11 06:20:49', '2026-05-11 06:20:49');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'player',
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `preferred_games` varchar(255) DEFAULT NULL,
  `trading_preferences` text DEFAULT NULL,
  `profile_photo_path` varchar(255) DEFAULT NULL,
  `suspended_until` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `email_verified_at`, `password`, `role`, `status`, `preferred_games`, `trading_preferences`, `profile_photo_path`, `suspended_until`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@playerbarter.test', '2026-04-27 22:24:07', '$2y$12$PPJ8Tk3NXj6YXUJvJS710unewYRTcEEHjfXhFShyIQKd8mQ/AVWK2', 'admin', 'active', NULL, NULL, NULL, NULL, 'NqiQ5vBlD7RZvVlgiglBqkDinZrTvZbwT9C2J2T1vMJSuiwI1JC6qIVk2Sz4', '2026-04-27 22:24:07', '2026-04-27 22:24:07'),
(8, 'CJ', 'cj@gmail.com', NULL, '$2y$12$BrSQnmYS9BjsPmNf/htk1u94tcOjMCJ1Orrn6uSXuJ0fyGnijwEya', 'player', 'active', '', 'yep', 'profile-pictures/928AMHyyqMIG3rXLKwILby8MvA8ZASfrIahSAdJP.png', NULL, NULL, '2026-04-27 22:25:05', '2026-05-11 05:58:04'),
(9, 'marj', 'marj@gmail.com', NULL, '$2y$12$E5kPzaJntmHHOI3ysr.UBu2FWyUHqRHp8T78J4kqfltJaXxcdX.na', 'player', 'active', 'valorant', 'none', NULL, NULL, NULL, '2026-04-27 22:36:53', '2026-04-27 22:36:53'),
(10, 'hahaha', 'CF9407040@GMAIL.COM', NULL, '$2y$12$T3NQH5ly8aB1Nh8MRGFe8.unTJyuBUE.IPkcx4efZ/1Iw48ZjL.hi', 'player', 'warned', 'fortnite', 'none', 'profile-pictures/P3z7KlTTjtUj3mrviGXDGFmq9QlL8wBkW3Bh21s6.jpg', NULL, NULL, '2026-04-28 00:07:59', '2026-05-11 05:41:30'),
(11, 'CJ2', 'cj2@gmail.com', NULL, '$2y$12$BrSQnmYS9BjsPmNf/htk1u94tcOjMCJ1Orrn6uSXuJ0fyGnijwEya', 'player', 'active', 'dota 2', 'yep', NULL, NULL, NULL, '2026-04-27 22:25:05', '2026-04-27 22:34:57'),
(12, 'CJ3', 'cj3@gmail.com', NULL, '$2y$12$BrSQnmYS9BjsPmNf/htk1u94tcOjMCJ1Orrn6uSXuJ0fyGnijwEya', 'player', 'active', 'dota 2', 'yep', NULL, NULL, NULL, '2026-04-27 22:25:05', '2026-04-27 22:34:57'),
(13, 'CJ4', 'cj4@gmail.com', NULL, '$2y$12$BrSQnmYS9BjsPmNf/htk1u94tcOjMCJ1Orrn6uSXuJ0fyGnijwEya', 'player', 'active', 'dota 2', 'yep', NULL, NULL, NULL, '2026-04-27 22:25:05', '2026-04-27 22:34:57'),
(14, 'CJ5', 'cj5@gmail.com', NULL, '$2y$12$BrSQnmYS9BjsPmNf/htk1u94tcOjMCJ1Orrn6uSXuJ0fyGnijwEya', 'player', 'active', 'dota 2', 'yep', NULL, NULL, NULL, '2026-04-27 22:25:05', '2026-04-27 22:34:57'),
(15, 'CJ6', 'cj6@gmail.com', NULL, '$2y$12$BrSQnmYS9BjsPmNf/htk1u94tcOjMCJ1Orrn6uSXuJ0fyGnijwEya', 'player', 'active', 'dota 2', 'yep', NULL, NULL, NULL, '2026-04-27 22:25:05', '2026-04-27 22:34:57'),
(16, 'CJ7', 'cj7@gmail.com', NULL, '$2y$12$BrSQnmYS9BjsPmNf/htk1u94tcOjMCJ1Orrn6uSXuJ0fyGnijwEya', 'player', 'active', 'dota 2', 'yep', NULL, NULL, NULL, '2026-04-27 22:25:05', '2026-04-27 22:34:57'),
(17, 'CJ8', 'cj8@gmail.com', NULL, '$2y$12$BrSQnmYS9BjsPmNf/htk1u94tcOjMCJ1Orrn6uSXuJ0fyGnijwEya', 'player', 'active', 'dota 2', 'yep', NULL, NULL, NULL, '2026-04-27 22:25:05', '2026-04-27 22:34:57'),
(18, 'isobel18', 'tre83@example.org', '2026-04-28 00:59:50', '$2y$12$VjafPIlTVB9By9OIdf4Y4u07hdct.JIZpLA497XR38F4jiuB0YsJC', 'player', 'active', NULL, NULL, NULL, NULL, 'jOuXGBrnAd', '2026-04-28 00:59:50', '2026-04-28 00:59:50'),
(19, 'dorcas34', 'camila26@example.net', '2026-04-28 00:59:50', '$2y$12$VjafPIlTVB9By9OIdf4Y4u07hdct.JIZpLA497XR38F4jiuB0YsJC', 'player', 'active', NULL, NULL, NULL, NULL, '2vPEcuGmqP', '2026-04-28 00:59:50', '2026-04-28 00:59:50'),
(20, 'johns.scotty', 'grant.vilma@example.com', '2026-04-28 00:59:50', '$2y$12$VjafPIlTVB9By9OIdf4Y4u07hdct.JIZpLA497XR38F4jiuB0YsJC', 'player', 'active', NULL, NULL, NULL, NULL, 'h9Cs5ds27O', '2026-04-28 00:59:50', '2026-04-28 00:59:50'),
(21, 'rogahn.delta', 'hellen.fritsch@example.org', '2026-04-28 00:59:50', '$2y$12$VjafPIlTVB9By9OIdf4Y4u07hdct.JIZpLA497XR38F4jiuB0YsJC', 'player', 'active', NULL, NULL, NULL, NULL, 'HiYdAemPwX', '2026-04-28 00:59:50', '2026-04-28 00:59:50'),
(22, 'kelsi.schmidt', 'nlemke@example.org', '2026-04-28 00:59:50', '$2y$12$VjafPIlTVB9By9OIdf4Y4u07hdct.JIZpLA497XR38F4jiuB0YsJC', 'player', 'active', NULL, NULL, NULL, NULL, 'QNAu9O3wMI', '2026-04-28 00:59:50', '2026-04-28 00:59:50'),
(23, 'kenneth.wehner', 'keebler.jeanette@example.com', '2026-04-28 00:59:50', '$2y$12$VjafPIlTVB9By9OIdf4Y4u07hdct.JIZpLA497XR38F4jiuB0YsJC', 'player', 'active', NULL, NULL, NULL, NULL, 'uZ6z6fhjPm', '2026-04-28 00:59:50', '2026-04-28 00:59:50'),
(24, 'zoe44', 'obie06@example.com', '2026-04-28 00:59:50', '$2y$12$VjafPIlTVB9By9OIdf4Y4u07hdct.JIZpLA497XR38F4jiuB0YsJC', 'player', 'active', NULL, NULL, NULL, NULL, '5BHE8DAv3f', '2026-04-28 00:59:50', '2026-04-28 00:59:50'),
(25, 'janick75', 'talon.schmeler@example.org', '2026-04-28 00:59:50', '$2y$12$VjafPIlTVB9By9OIdf4Y4u07hdct.JIZpLA497XR38F4jiuB0YsJC', 'player', 'active', NULL, NULL, NULL, NULL, '3U45nF2olT', '2026-04-28 00:59:50', '2026-04-28 00:59:50'),
(26, 'ydickens', 'olin.thompson@example.net', '2026-04-28 00:59:50', '$2y$12$VjafPIlTVB9By9OIdf4Y4u07hdct.JIZpLA497XR38F4jiuB0YsJC', 'player', 'active', NULL, NULL, NULL, NULL, 'NJDaOVvgAC', '2026-04-28 00:59:50', '2026-04-28 00:59:50'),
(27, 'bryon.carroll', 'medhurst.brenden@example.com', '2026-04-28 00:59:50', '$2y$12$VjafPIlTVB9By9OIdf4Y4u07hdct.JIZpLA497XR38F4jiuB0YsJC', 'player', 'active', NULL, NULL, NULL, NULL, 'BDkNA1Sjsv', '2026-04-28 00:59:50', '2026-04-28 00:59:50');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `app_notifications`
--
ALTER TABLE `app_notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `app_notifications_user_id_foreign` (`user_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ratings_trade_request_id_rater_id_unique` (`trade_request_id`,`rater_id`),
  ADD KEY `ratings_rater_id_foreign` (`rater_id`),
  ADD KEY `ratings_rated_user_id_foreign` (`rated_user_id`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reports_reporter_id_foreign` (`reporter_id`),
  ADD KEY `reports_reported_user_id_foreign` (`reported_user_id`),
  ADD KEY `reports_trade_item_id_foreign` (`trade_item_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `trade_items`
--
ALTER TABLE `trade_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `trade_items_user_id_foreign` (`user_id`);

--
-- Indexes for table `trade_item_images`
--
ALTER TABLE `trade_item_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `trade_item_images_trade_item_id_foreign` (`trade_item_id`);

--
-- Indexes for table `trade_messages`
--
ALTER TABLE `trade_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `trade_messages_trade_request_id_foreign` (`trade_request_id`),
  ADD KEY `trade_messages_user_id_foreign` (`user_id`);

--
-- Indexes for table `trade_requests`
--
ALTER TABLE `trade_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `trade_requests_item_id_foreign` (`item_id`),
  ADD KEY `trade_requests_requester_id_foreign` (`requester_id`),
  ADD KEY `trade_requests_owner_id_foreign` (`owner_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `app_notifications`
--
ALTER TABLE `app_notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `ratings`
--
ALTER TABLE `ratings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `trade_items`
--
ALTER TABLE `trade_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `trade_item_images`
--
ALTER TABLE `trade_item_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `trade_messages`
--
ALTER TABLE `trade_messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `trade_requests`
--
ALTER TABLE `trade_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `app_notifications`
--
ALTER TABLE `app_notifications`
  ADD CONSTRAINT `app_notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ratings`
--
ALTER TABLE `ratings`
  ADD CONSTRAINT `ratings_rated_user_id_foreign` FOREIGN KEY (`rated_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ratings_rater_id_foreign` FOREIGN KEY (`rater_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ratings_trade_request_id_foreign` FOREIGN KEY (`trade_request_id`) REFERENCES `trade_requests` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reports`
--
ALTER TABLE `reports`
  ADD CONSTRAINT `reports_reported_user_id_foreign` FOREIGN KEY (`reported_user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `reports_reporter_id_foreign` FOREIGN KEY (`reporter_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reports_trade_item_id_foreign` FOREIGN KEY (`trade_item_id`) REFERENCES `trade_items` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `trade_items`
--
ALTER TABLE `trade_items`
  ADD CONSTRAINT `trade_items_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `trade_item_images`
--
ALTER TABLE `trade_item_images`
  ADD CONSTRAINT `trade_item_images_trade_item_id_foreign` FOREIGN KEY (`trade_item_id`) REFERENCES `trade_items` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `trade_messages`
--
ALTER TABLE `trade_messages`
  ADD CONSTRAINT `trade_messages_trade_request_id_foreign` FOREIGN KEY (`trade_request_id`) REFERENCES `trade_requests` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `trade_messages_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `trade_requests`
--
ALTER TABLE `trade_requests`
  ADD CONSTRAINT `trade_requests_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `trade_items` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `trade_requests_owner_id_foreign` FOREIGN KEY (`owner_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `trade_requests_requester_id_foreign` FOREIGN KEY (`requester_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
