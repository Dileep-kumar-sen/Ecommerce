-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 27, 2025 at 06:19 PM
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
-- Database: `ecommerces`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `email`, `password`, `name`, `created_at`, `updated_at`) VALUES
(1, 'admin@example.com', '$2y$12$HSROLWDF23Fhd.UljwYstubqP4/htgkErUNEHSNGUvuqtA7O4aLqq', 'john deo', '2025-10-30 15:43:28', '2025-11-06 17:54:04');

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

CREATE TABLE `banners` (
  `id` int(11) NOT NULL,
  `images` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`images`)),
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `banners`
--

INSERT INTO `banners` (`id`, `images`, `created_at`, `updated_at`) VALUES
(1, '[\"69286db5a04e6.jfif\",\"69286db5a140e.jfif\",\"69286db5a1838.jpg\"]', '2025-11-27 20:56:45', '2025-11-27 20:56:45');

-- --------------------------------------------------------

--
-- Table structure for table `businesses`
--

CREATE TABLE `businesses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `shop_name` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `latitude` varchar(255) NOT NULL,
  `profile` varchar(100) DEFAULT NULL,
  `longitude` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `businesses`
--

INSERT INTO `businesses` (`id`, `shop_name`, `name`, `email`, `password`, `phone`, `latitude`, `profile`, `longitude`, `location`, `status`, `created_at`, `updated_at`) VALUES
(5, 'Electronics', 'John Doe', 'sendileep55901@gmail.com', '$2y$12$1LUVVbHxH26yn9NENk2gCeX7nuGvxAOvFnECfcVS8F0wM0VLLpYSS', '6264269054', '23.28103727976461', '1764032967.jpg', '77.39815597851272', '1, Moti Quarter, Sri Nagar Colony, Bhopal, Madhya Pradesh 462100, India', 1, '2025-11-25 14:39:27', '2025-11-25 14:41:25');

-- --------------------------------------------------------

--
-- Table structure for table `business_membership_plan`
--

CREATE TABLE `business_membership_plan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `plan_tier` varchar(255) NOT NULL,
  `trial_days` int(11) DEFAULT NULL,
  `discount` int(11) NOT NULL DEFAULT 0,
  `active_offers` int(11) NOT NULL DEFAULT 0,
  `plan_price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `duration_months` int(11) NOT NULL DEFAULT 1,
  `visibility_level` enum('low','medium','high','top') NOT NULL DEFAULT 'low',
  `metrics_access` enum('none','basic','advanced') NOT NULL DEFAULT 'none',
  `highlight_banner` tinyint(1) NOT NULL DEFAULT 0,
  `push_notifications` tinyint(1) NOT NULL DEFAULT 0,
  `marketing_campaigns` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `business_plan_join`
--

CREATE TABLE `business_plan_join` (
  `id` int(11) NOT NULL,
  `business_id` int(100) DEFAULT NULL,
  `plan` int(100) DEFAULT NULL,
  `payment_id` int(100) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `business_plan_join`
--

INSERT INTO `business_plan_join` (`id`, `business_id`, `plan`, `payment_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, '2025-11-19 23:49:54', '2025-11-19 23:49:54'),
(2, 1, 3, NULL, '2025-11-19 23:50:59', '2025-11-19 23:50:59'),
(3, 1, 2, NULL, '2025-11-19 23:51:35', '2025-11-19 23:51:35'),
(4, 1, 1, NULL, '2025-11-21 21:07:48', '2025-11-21 21:07:48'),
(5, 1, 1, NULL, '2025-11-21 21:11:04', '2025-11-21 21:11:04'),
(6, 1, 3, NULL, '2025-11-21 21:11:29', '2025-11-21 21:11:29');

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
-- Table structure for table `campaigns`
--

CREATE TABLE `campaigns` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `campaign_name` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `categories` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `campaign_join`
--

CREATE TABLE `campaign_join` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `business_id` bigint(20) UNSIGNED NOT NULL,
  `campaign_id` bigint(20) UNSIGNED NOT NULL,
  `count_offer` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `campaign_offers`
--

CREATE TABLE `campaign_offers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `business_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `campaign_id` int(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `expiry_datetime` datetime DEFAULT NULL,
  `stock_limit` int(11) NOT NULL DEFAULT 0,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `subcategory_id` bigint(20) UNSIGNED DEFAULT NULL,
  `price` decimal(12,2) NOT NULL DEFAULT 0.00,
  `discount` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `discount_price` decimal(12,2) NOT NULL DEFAULT 0.00,
  `voucher_code` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `campaign_offers`
--

INSERT INTO `campaign_offers` (`id`, `business_id`, `title`, `campaign_id`, `description`, `expiry_datetime`, `stock_limit`, `category_id`, `subcategory_id`, `price`, `discount`, `discount_price`, `voucher_code`, `image`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'nfe23', 3, 'nfe23', '2025-10-30 02:07:00', 100, 2, 2, 100.00, 20, 80.00, 'VC-OZYWC06T', '1761849492_profile.jpg', 1, '2025-10-30 18:38:12', '2025-10-30 18:38:12'),
(2, 1, 'krishna utsav', 6, 'krishna utsav', '2025-11-15 23:23:00', 10, 2, 3, 100.00, 50, 50.00, 'VC-QUSEP5J1', '1762620839_download2.jfif', 1, '2025-11-08 16:53:59', '2025-11-08 16:53:59'),
(3, 1, 'dsds', 6, 'kkkkkkk]', '2025-11-09 11:56:00', 10, 2, 2, 9.00, 30, 6.30, 'VC-X5LLATKV', '1762669625_download2.jfif', 1, '2025-11-09 06:27:05', '2025-11-09 06:27:05'),
(4, 1, 'ndsdsd', 7, 'ndsdsd', '2025-11-10 12:34:00', 19, 2, 2, 20.00, 22, 15.60, 'VC-O6WOYBHF', NULL, 1, '2025-11-09 07:05:25', '2025-11-09 07:05:25');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `icon` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `status`, `icon`, `created_at`, `updated_at`) VALUES
(11, 'Spa', 1, '1764035505_image1.jpg', '2025-11-25 15:21:45', '2025-11-25 15:21:45');

-- --------------------------------------------------------

--
-- Table structure for table `create_offers`
--

CREATE TABLE `create_offers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `business_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `expiry_datetime` datetime DEFAULT NULL,
  `stock_limit` int(11) NOT NULL DEFAULT 0,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `subcategory_id` bigint(20) UNSIGNED DEFAULT NULL,
  `price` decimal(12,2) NOT NULL DEFAULT 0.00,
  `discount` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `discount_price` decimal(12,2) NOT NULL DEFAULT 0.00,
  `voucher_code` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `create_offers`
--

INSERT INTO `create_offers` (`id`, `business_id`, `title`, `description`, `expiry_datetime`, `stock_limit`, `category_id`, `subcategory_id`, `price`, `discount`, `discount_price`, `voucher_code`, `image`, `status`, `created_at`, `updated_at`) VALUES
(31, 5, 'Spa And Saloon', 'A spa is a place that provides health, beauty, and relaxation services, often incorporating water treatments like mineral baths, massages, and saunas. The term originated from towns with natural mineral springs and now commonly refers to commercial establishments that offer a holistic approach to well-being', '2025-11-28 07:27:00', 10, 11, 10, 10000.00, 30, 7000.00, 'VC-6YIBGW5M', '[\"1764035874_spa4.jpeg\",\"1764035874_spa3.jpeg\",\"1764035874_spa2.jpeg\",\"1764035874_image1.jpg\"]', 1, '2025-11-25 15:27:54', '2025-11-25 15:27:54');

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
-- Table structure for table `membership_plans`
--

CREATE TABLE `membership_plans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `plan_tier` varchar(255) NOT NULL DEFAULT 'Free',
  `trial_period_days` int(11) NOT NULL DEFAULT 0,
  `coupons_per_week` int(11) NOT NULL DEFAULT 0,
  `plan_icon` varchar(255) DEFAULT NULL,
  `month_year` varchar(255) DEFAULT NULL,
  `discount_limit` varchar(255) NOT NULL DEFAULT '0',
  `exclusive_offers_monthly` int(11) NOT NULL DEFAULT 0,
  `features` text DEFAULT NULL,
  `achievements` text DEFAULT NULL,
  `referral_bonus` text DEFAULT NULL,
  `plan_price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `description` text DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `membership_plans`
--

INSERT INTO `membership_plans` (`id`, `plan_tier`, `trial_period_days`, `coupons_per_week`, `plan_icon`, `month_year`, `discount_limit`, `exclusive_offers_monthly`, `features`, `achievements`, `referral_bonus`, `plan_price`, `description`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Free', 7, 0, NULL, NULL, '0', 0, NULL, NULL, NULL, 0.00, NULL, 0, NULL, NULL);

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
(4, '2025_10_13_112956_create_membership_plans_table', 1),
(5, '2025_10_14_034351_create_business_membership_plan_table', 1),
(6, '2025_10_14_122750_create_categories_table', 1),
(7, '2025_10_14_162142_create_businesses_table', 1),
(8, '2025_10_14_200227_create_subcategories_table', 1),
(9, '2025_10_14_212234_create_create_offers_table', 1),
(10, '2025_10_17_130529_create_user_payments_table', 1),
(11, '2025_10_19_204927_create_user_redeem_table', 1),
(12, '2025_10_23_230818_create_reviews_table', 2),
(13, '2025_10_28_184922_create_campaigns_table', 3),
(14, '2025_10_30_194404_create_campaign_join_table', 4),
(15, '2025_10_30_210734_create_admins_table', 5),
(16, '2025_10_30_235727_create__campaign_offers_table', 6),
(17, '2025_11_25_014921_add_qr_to_users_table', 7);

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
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `plan_id` bigint(20) UNSIGNED NOT NULL,
  `payment_type` varchar(255) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `currency` varchar(10) NOT NULL DEFAULT 'ARS',
  `payment_id` varchar(255) DEFAULT NULL,
  `expire_date` varchar(255) DEFAULT NULL,
  `membership_status` int(11) DEFAULT NULL,
  `status` enum('pending','success','failed') NOT NULL DEFAULT 'pending',
  `payment_method` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `offer_id` bigint(20) UNSIGNED NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`id`, `user_id`, `offer_id`, `description`, `created_at`, `updated_at`) VALUES
(1, 16, 31, 'niffdf', '2025-11-27 11:56:05', '2025-11-27 11:56:05');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `rating` tinyint(4) NOT NULL COMMENT '1 to 5',
  `offer_id` int(100) DEFAULT NULL,
  `campaign_id` int(100) DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
('2rHtcXz6DuDuo837AgWRr9cDIxdfyvKmUEbIROoJ', NULL, '127.0.0.1', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZXFBWU1pSFhTVVBxS2lTQWtVekpYSWpHdVVpOE9xMjBaOFg4Vk9lUiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTY6Imh0dHA6Ly92YWxlbmUtaW51bmRhbnQtaG95dC5uZ3Jvay1mcmVlLmRldi9zdWJjYXRlZ29yeS8xIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1760952688),
('9SpAKis0ZUEmFfgkvoQgtFkKBLfd15gsni2VScHN', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoieU5mcktmb1B5bGdKZEVnVkVHUlJsTTJ5SnZFSG54SURadEVFTnNWSyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjE6e2k6MDtzOjc6InN1Y2Nlc3MiO319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzkxOiJodHRwOi8vdmFsZW5lLWludW5kYW50LWhveXQubmdyb2stZnJlZS5kZXYvcGF5bWVudC1zdWNjZXNzP2NvbGxlY3Rpb25faWQ9MTMwNjA4OTE2ODM0JmNvbGxlY3Rpb25fc3RhdHVzPWFwcHJvdmVkJmV4dGVybmFsX3JlZmVyZW5jZT1udWxsJmlkPTIyJm1lcmNoYW50X2FjY291bnRfaWQ9bnVsbCZtZXJjaGFudF9vcmRlcl9pZD0zNDg4NjUzMzM1NSZtb250aG9yeWVhcj1Nb250aCZwYXltZW50X2lkPTEzMDYwODkxNjgzNCZwYXltZW50X3R5cGU9Y3JlZGl0X2NhcmQmcHJlZmVyZW5jZV9pZD0yOTI1MTY0MzA0LTFlZmYzMTU1LWQ2YmYtNDFmNy1iNmYwLTE4YTUxZjNmMjZiOSZwcm9jZXNzaW5nX21vZGU9YWdncmVnYXRvciZzaXRlX2lkPU1MQSZzdGF0dXM9YXBwcm92ZWQmdXNlcl9pZD0yIjt9czo3OiJzdWNjZXNzIjtzOjE5OiJQYXltZW50IFN1Y2Nlc3NmdWwhIjt9', 1760958629),
('bC9CyTjYHA6wEWZbVd9c3oflo74kTdGoZNdRjv4e', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNXFnOXNqY051MGNTT3hYb0Y0ZGduVnRpclEwODRUajNCYkloeEtjcCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1761195489),
('nTlU3Vig3VFfg37RJSv6QrEGKuLSKQRjUmqtmmh0', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiYjNJbWhjQUFvcUNRcU5BYURmbVVzYW8xUlVOSmo0SDRodEpBZzFTMiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI7fQ==', 1761045468),
('QwV0USmtj2c7obC3L3UhlD4NjB5R91JEJObCcVve', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNWVpYUF2MUFsUUpSa0FtNW9IOGl4QXhGZEt5MTFiRGFZbzNQWERDciI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1761044978),
('r8BTLxqFpM2TMQQzqmUXzT6ImzFY6q9IcphwfebK', 2, '127.0.0.1', 'Mozilla/5.0 (iPhone; CPU iPhone OS 15_0 like Mac OS X) AppleWebKit/603.1.30 (KHTML, like Gecko) Version/17.5 Mobile/15A5370a Safari/602.1', 'YTo4OntzOjY6Il90b2tlbiI7czo0MDoiNVo0aEluNTk1cXBSZ1cwUUdJWEwxMkp5UTNhQ0Z1bHA1NE1uVjdTcyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzk6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9idXNpbmVzcy9yZWdpc3RlciI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6OToic2hvcF9uYW1lIjtzOjE4OiJFbGVjdHJvbmljcyBDZW50ZXIiO3M6NDoibmFtZSI7czoxMDoiRGVuaWwgZmVvZSI7czo1OiJlbWFpbCI7czoyMzoic2VuZGlsZWVwNTU5MEBnbWFpbC5jb20iO3M6MTE6ImJ1c2luZXNzX2lkIjtpOjE7czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Mjt9', 1760963281),
('tAWBH1cEDsuUlP9thffD2IAgGR5oMjR70wgGKITg', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZXBwU09vaFF3cUNESmdPbUVqWnFJR1o5aG1BWmV2OUs5bExpYmFmRCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI7fQ==', 1761045506),
('uzCL3GFe4Lp1FzUmxViw48uuZ3aqWbkQGWrKvKzD', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:144.0) Gecko/20100101 Firefox/144.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiSGdZR2htUWQzcnhWMnU3OFA4STA1dTJId096WXpqZ1ZINk9IUjFXeiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjk6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hY2NvdW50Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1760952973);

-- --------------------------------------------------------

--
-- Table structure for table `subcategories`
--

CREATE TABLE `subcategories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subcategories`
--

INSERT INTO `subcategories` (`id`, `name`, `category_id`, `icon`, `created_at`, `updated_at`) VALUES
(10, 'Saloon', 11, '1764035572_spa3.jpeg', '2025-11-25 15:22:52', '2025-11-25 15:22:52');

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions`
--

CREATE TABLE `subscriptions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `plan_id` bigint(20) UNSIGNED NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `mp_subscription_id` varchar(255) DEFAULT NULL,
  `current_period_start` datetime DEFAULT NULL,
  `current_period_end` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subscriptions`
--

INSERT INTO `subscriptions` (`id`, `user_id`, `plan_id`, `status`, `mp_subscription_id`, `current_period_start`, `current_period_end`, `created_at`, `updated_at`) VALUES
(1, 17, 1, 'active', NULL, '2025-11-27 21:16:58', '2025-12-04 21:16:58', '2025-11-27 15:46:58', '2025-11-27 15:46:58');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `profile` varchar(100) DEFAULT NULL,
  `phone` varchar(100) NOT NULL,
  `latitude` varchar(255) NOT NULL,
  `longitude` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `membership_plan` varchar(255) NOT NULL DEFAULT '0',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `membership_id` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `profile`, `phone`, `latitude`, `longitude`, `location`, `status`, `membership_plan`, `remember_token`, `created_at`, `updated_at`, `membership_id`) VALUES
(17, 'Dileep Kumar Sen', 'sendileep559@gmail.com', NULL, '$2y$12$6mSW5Ph000I9AiZ5h3UwK.2LNkFRFp/fO2YInmn7Dp.Pm8BtYH4xO', '1764258418_6928727236d56.jpg', '06264269054', '28.642890895780432', '77.19206274064818', '17, Near Railway Dispensary, Railway Colony, Old Rajinder Nagar, Rajinder Nagar, New Delhi, Delhi, 110060, India', 1, '0', NULL, '2025-11-27 15:46:58', '2025-11-27 15:46:58', 'MBR-2025-00001-LQBQV5');

-- --------------------------------------------------------

--
-- Table structure for table `user_redeem`
--

CREATE TABLE `user_redeem` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `membership_id` varchar(1000) DEFAULT NULL,
  `qr_code` varchar(1000) DEFAULT NULL,
  `offer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` enum('claim','redeem') DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_redeem`
--

INSERT INTO `user_redeem` (`id`, `membership_id`, `qr_code`, `offer_id`, `status`, `created_at`, `updated_at`) VALUES
(4, 'MBR-2025-00001-WT47JY', 'qrcodes/LaUdrXMAkm.png', 31, 'redeem', '2025-11-27 09:52:26', '2025-11-27 11:25:43');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_email_unique` (`email`);

--
-- Indexes for table `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `businesses`
--
ALTER TABLE `businesses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `businesses_email_unique` (`email`);

--
-- Indexes for table `business_membership_plan`
--
ALTER TABLE `business_membership_plan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `business_plan_join`
--
ALTER TABLE `business_plan_join`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `campaign_join`
--
ALTER TABLE `campaign_join`
  ADD PRIMARY KEY (`id`),
  ADD KEY `campaign_join_business_id_foreign` (`business_id`),
  ADD KEY `campaign_join_campaign_id_foreign` (`campaign_id`);

--
-- Indexes for table `campaign_offers`
--
ALTER TABLE `campaign_offers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `campaign_offers_voucher_code_unique` (`voucher_code`),
  ADD KEY `campaign_offers_business_id_index` (`business_id`),
  ADD KEY `campaign_offers_category_id_index` (`category_id`),
  ADD KEY `campaign_offers_subcategory_id_index` (`subcategory_id`);

--
-- Indexes for table `create_offers`
--
ALTER TABLE `create_offers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `membership_plans`
--
ALTER TABLE `membership_plans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subscriptions_user_id_foreign` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_redeem`
--
ALTER TABLE `user_redeem`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `banners`
--
ALTER TABLE `banners`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `create_offers`
--
ALTER TABLE `create_offers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `membership_plans`
--
ALTER TABLE `membership_plans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `subscriptions`
--
ALTER TABLE `subscriptions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `user_redeem`
--
ALTER TABLE `user_redeem`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD CONSTRAINT `subscriptions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
