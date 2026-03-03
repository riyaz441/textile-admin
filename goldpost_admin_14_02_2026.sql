-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 14, 2026 at 02:49 PM
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
-- Database: `goldpost_admin`
--

-- --------------------------------------------------------

--
-- Table structure for table `branches`
--

CREATE TABLE `branches` (
  `branch_id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `branch_code` varchar(50) NOT NULL,
  `branch_name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `branches`
--

INSERT INTO `branches` (`branch_id`, `company_id`, `branch_code`, `branch_name`, `email`, `phone`, `address`, `city`, `state`, `country`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'BR001', 'GoldPost Mumbai', 'mumbai@goldpost.com', '1234567890', '123 Gold Street', 'Mumbai', 'Maharashtra', 'India', 'Active', '2026-02-14 08:15:16', '2026-02-14 08:15:16'),
(2, 2, 'BR002', 'Gemstone Jaipur', 'jaipur@gemstonetraders.com', '9876543210', '456 Gem Avenue', 'Jaipur', 'Rajasthan', 'India', 'Active', '2026-02-14 08:15:16', '2026-02-14 08:15:16');

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
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `category_name` varchar(100) NOT NULL,
  `category_code` varchar(20) NOT NULL,
  `description` text DEFAULT NULL,
  `parent_category_id` int(11) NOT NULL DEFAULT 0,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `company_id`, `category_name`, `category_code`, `description`, `parent_category_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'Jewelry', 'JEW', 'Jewelry products', 0, 'Active', '2026-02-14 08:15:16', '2026-02-14 08:15:16'),
(2, 1, 'Gemstones', 'GEM', 'Gemstone products', 0, 'Active', '2026-02-14 08:15:16', '2026-02-14 08:15:16'),
(3, 2, 'Metals', 'MET', 'Metal products', 0, 'Active', '2026-02-14 08:15:16', '2026-02-14 08:15:16'),
(4, 2, 'Accessories', 'ACC', 'Accessory products', 0, 'Active', '2026-02-14 08:15:16', '2026-02-14 08:15:16');

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `company_code` varchar(50) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `gst_number` varchar(50) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`company_id`, `company_code`, `company_name`, `email`, `phone`, `address`, `city`, `state`, `country`, `gst_number`, `website`, `status`, `created_at`, `updated_at`) VALUES
(1, 'COMP001', 'GoldPost Ltd.', 'info@goldpost.com', '1234567890', '123 Gold Street', 'Mumbai', 'Maharashtra', 'India', '27AAACG1234A1Z5', 'https://goldpost.com', 'Active', '2026-02-14 08:15:16', '2026-02-14 08:15:16'),
(2, 'COMP002', 'Gemstone Traders', 'contact@gemstonetraders.com', '9876543210', '456 Gem Avenue', 'Jaipur', 'Rajasthan', 'India', '08AAACG5678B1Z6', 'https://gemstonetraders.com', 'Active', '2026-02-14 08:15:16', '2026-02-14 08:15:16');

-- --------------------------------------------------------

--
-- Table structure for table `component_types`
--

CREATE TABLE `component_types` (
  `type_id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `type_name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `component_types`
--

INSERT INTO `component_types` (`type_id`, `company_id`, `type_name`, `description`, `category`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'Setting', 'Main setting for gemstone or material', 'Mounting', 'Active', '2026-02-14 08:15:17', '2026-02-14 08:15:17'),
(2, 1, 'Shank', 'Band or shank of the ring', 'Band', 'Active', '2026-02-14 08:15:17', '2026-02-14 08:15:17'),
(3, 1, 'Head', 'Head or top part of the jewelry', 'Top', 'Active', '2026-02-14 08:15:17', '2026-02-14 08:15:17');

-- --------------------------------------------------------

--
-- Table structure for table `email_configs`
--

CREATE TABLE `email_configs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `protocol` varchar(255) NOT NULL,
  `mailtype` varchar(255) NOT NULL,
  `smtp_host` varchar(255) NOT NULL,
  `smtp_port` varchar(255) NOT NULL,
  `sender_email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `email_configs`
--

INSERT INTO `email_configs` (`id`, `protocol`, `mailtype`, `smtp_host`, `smtp_port`, `sender_email`, `password`, `created_at`, `updated_at`) VALUES
(1, 'smtp', 'html', 'smtp.gmail.com', '587', 'no-reply@goldpost.com', 'eyJpdiI6IkYwZUphVFZWZnhjNUdwM2IwcDNlZUE9PSIsInZhbHVlIjoid25Pb2FIeDRFMTJQd1lQNWp0R0FwZz09IiwibWFjIjoiOTAxNDdlODY5ZDE0OTIxNDMzMGZhZmQ2YzMxNWZhYzRiYzBjNGU5OGJiNzUyMGY5ZTA1MTQ0NDYwM2VmNDYzNyIsInRhZyI6IiJ9', '2026-02-14 08:15:17', '2026-02-14 08:15:17');

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
-- Table structure for table `gemstones`
--

CREATE TABLE `gemstones` (
  `gemstone_id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED NOT NULL,
  `gemstone_name` varchar(50) NOT NULL,
  `type` enum('diamond','ruby','sapphire','emerald','pearl','other') NOT NULL,
  `color` varchar(30) DEFAULT NULL,
  `clarity` varchar(30) DEFAULT NULL,
  `cut_grade` varchar(30) DEFAULT NULL,
  `default_carat_weight` decimal(6,3) DEFAULT NULL,
  `gemstone_code` varchar(50) DEFAULT NULL,
  `shape` varchar(50) DEFAULT NULL,
  `cut` varchar(50) DEFAULT NULL,
  `measurement_length` decimal(6,2) DEFAULT NULL,
  `measurement_width` decimal(6,2) DEFAULT NULL,
  `measurement_depth` decimal(6,2) DEFAULT NULL,
  `treatment` varchar(100) DEFAULT NULL,
  `origin` varchar(100) DEFAULT NULL,
  `fluorescence` varchar(50) DEFAULT NULL,
  `symmetry` varchar(50) DEFAULT NULL,
  `polish` varchar(50) DEFAULT NULL,
  `girdle` varchar(50) DEFAULT NULL,
  `culet` varchar(50) DEFAULT NULL,
  `table_percentage` decimal(5,2) DEFAULT NULL,
  `depth_percentage` decimal(5,2) DEFAULT NULL,
  `certification_lab` varchar(100) DEFAULT NULL,
  `certification_number` varchar(100) DEFAULT NULL,
  `certification_date` date DEFAULT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gemstones`
--

INSERT INTO `gemstones` (`gemstone_id`, `company_id`, `branch_id`, `gemstone_name`, `type`, `color`, `clarity`, `cut_grade`, `default_carat_weight`, `gemstone_code`, `shape`, `cut`, `measurement_length`, `measurement_width`, `measurement_depth`, `treatment`, `origin`, `fluorescence`, `symmetry`, `polish`, `girdle`, `culet`, `table_percentage`, `depth_percentage`, `certification_lab`, `certification_number`, `certification_date`, `status`, `created_at`, `updated_at`) VALUES
(1, 2, 2, 'Brilliant Diamond', 'diamond', 'White', 'VVS1', 'Excellent', 1.000, 'DIA001', 'Round', 'Brilliant', 6.50, 6.50, 4.00, NULL, 'South Africa', 'None', 'Excellent', 'Excellent', 'Medium', 'None', 57.00, 61.50, 'GIA', '123456789', '2025-01-15', 'Active', '2026-02-14 08:15:17', '2026-02-14 08:15:17'),
(2, 2, 2, 'Royal Ruby', 'ruby', 'Red', 'VS1', 'Very Good', 2.100, 'RUB001', 'Oval', 'Mixed', 8.00, 6.00, 4.50, 'Heated', 'Myanmar', 'Faint', 'Very Good', 'Very Good', 'Slightly Thick', 'None', 60.00, 62.00, 'IGI', '987654321', '2025-02-20', 'Active', '2026-02-14 08:15:17', '2026-02-14 08:15:17'),
(3, 2, 2, 'Emerald Green', 'emerald', 'Green', 'SI1', 'Good', 1.500, 'EME001', 'Emerald', 'Step', 7.00, 5.00, 3.50, 'Oiled', 'Colombia', 'None', 'Good', 'Good', 'Thick', 'None', 58.00, 65.00, 'GIA', '555666777', '2025-03-10', 'Active', '2026-02-14 08:15:17', '2026-02-14 08:15:17');

-- --------------------------------------------------------

--
-- Table structure for table `inventory_stocks`
--

CREATE TABLE `inventory_stocks` (
  `stock_id` int(10) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `location_id` bigint(20) UNSIGNED NOT NULL,
  `quantity_on_hand` int(11) NOT NULL DEFAULT 0,
  `quantity_allocated` int(11) NOT NULL DEFAULT 0,
  `quantity_available` int(11) GENERATED ALWAYS AS (`quantity_on_hand` - `quantity_allocated`) STORED,
  `reorder_point` int(11) NOT NULL DEFAULT 0,
  `reorder_quantity` int(11) DEFAULT NULL,
  `last_reorder_date` date DEFAULT NULL,
  `next_reorder_date` date DEFAULT NULL,
  `average_cost` decimal(12,2) NOT NULL DEFAULT 0.00,
  `total_value` decimal(12,2) GENERATED ALWAYS AS (`quantity_on_hand` * `average_cost`) STORED,
  `stock_turnover_rate` decimal(8,2) DEFAULT NULL,
  `days_in_stock` int(11) NOT NULL DEFAULT 0,
  `last_movement_date` date DEFAULT NULL,
  `safety_stock_level` int(11) NOT NULL DEFAULT 0,
  `minimum_stock_level` int(11) NOT NULL DEFAULT 0,
  `maximum_stock_level` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inventory_stocks`
--

INSERT INTO `inventory_stocks` (`stock_id`, `product_id`, `location_id`, `quantity_on_hand`, `quantity_allocated`, `reorder_point`, `reorder_quantity`, `last_reorder_date`, `next_reorder_date`, `average_cost`, `stock_turnover_rate`, `days_in_stock`, `last_movement_date`, `safety_stock_level`, `minimum_stock_level`, `maximum_stock_level`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 50, 12, 20, 40, '2026-01-31', '2026-03-02', 125.50, 4.75, 45, '2026-02-12', 10, 15, 120, '2026-02-14 08:15:17', '2026-02-14 08:15:17'),
(2, 1, 2, 30, 5, 10, 25, '2026-01-24', '2026-02-23', 124.00, 3.10, 62, '2026-02-10', 8, 12, 80, '2026-02-14 08:15:17', '2026-02-14 08:15:17');

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
-- Table structure for table `labors`
--

CREATE TABLE `labors` (
  `labor_id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `labor_code` varchar(50) NOT NULL,
  `labor_name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `base_cost` decimal(10,2) DEFAULT NULL,
  `cost_per_hour` decimal(10,2) DEFAULT NULL,
  `estimated_hours` decimal(5,2) DEFAULT NULL,
  `skill_level` enum('basic','intermediate','advanced','master') DEFAULT 'basic',
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `labors`
--

INSERT INTO `labors` (`labor_id`, `company_id`, `labor_code`, `labor_name`, `description`, `base_cost`, `cost_per_hour`, `estimated_hours`, `skill_level`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'LAB001', 'Goldsmith', 'Expert in gold jewelry making', 5000.00, 250.00, 40.00, 'master', 'Active', '2026-02-14 08:15:16', '2026-02-14 08:15:16'),
(2, 2, 'LAB002', 'Gem Cutter', 'Specialist in gemstone cutting', 3000.00, 180.00, 30.00, 'advanced', 'Active', '2026-02-14 08:15:16', '2026-02-14 08:15:16');

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `location_id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED NOT NULL,
  `location_code` varchar(50) NOT NULL,
  `location_name` varchar(100) NOT NULL,
  `location_type` enum('store','warehouse','display_case','safe','vault','counter','workshop','qc_area','quarantine') NOT NULL DEFAULT 'store',
  `parent_location_id` bigint(20) UNSIGNED DEFAULT NULL,
  `address` text DEFAULT NULL,
  `contact_person` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `capacity` int(11) DEFAULT NULL,
  `temperature_controlled` tinyint(1) NOT NULL DEFAULT 0,
  `humidity_controlled` tinyint(1) NOT NULL DEFAULT 0,
  `security_level` enum('low','medium','high','maximum') NOT NULL DEFAULT 'medium',
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`location_id`, `company_id`, `branch_id`, `location_code`, `location_name`, `location_type`, `parent_location_id`, `address`, `contact_person`, `phone`, `capacity`, `temperature_controlled`, `humidity_controlled`, `security_level`, `status`, `notes`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'LOC-STORE-001', 'Main Store', 'store', NULL, '123 Gold Street, Mumbai', 'Store Manager', '1111111111', 1000, 1, 1, 'high', 'Active', 'Primary retail location', '2026-02-14 08:15:16', '2026-02-14 08:15:16'),
(2, 1, 1, 'LOC-VAULT-001', 'Main Vault', 'vault', 1, '123 Gold Street, Mumbai', 'Security Officer', '2222222222', 500, 1, 1, 'maximum', 'Active', 'High-security vault', '2026-02-14 08:15:16', '2026-02-14 08:15:16'),
(3, 2, 1, 'LOC-WH-001', 'Central Warehouse', 'warehouse', NULL, '456 Gem Avenue, Jaipur', 'Warehouse Manager', '3333333333', 2000, 0, 0, 'medium', 'Active', 'Bulk storage', '2026-02-14 08:15:16', '2026-02-14 08:15:16');

-- --------------------------------------------------------

--
-- Table structure for table `materials`
--

CREATE TABLE `materials` (
  `material_id` bigint(20) UNSIGNED NOT NULL,
  `material_name` varchar(50) NOT NULL,
  `carat_purity` varchar(20) DEFAULT NULL,
  `density` decimal(8,4) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `materials`
--

INSERT INTO `materials` (`material_id`, `material_name`, `carat_purity`, `density`, `description`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Yellow Gold', '18K', 15.6000, 'Traditional gold alloy used in jewelry', 'Active', '2026-02-14 08:15:16', '2026-02-14 08:15:16'),
(2, 'White Gold', '14K', 14.7000, 'Gold alloy with a bright white finish', 'Active', '2026-02-14 08:15:16', '2026-02-14 08:15:16'),
(3, 'Sterling Silver', '925', 10.4900, 'Silver alloy with 92.5% purity', 'Active', '2026-02-14 08:15:16', '2026-02-14 08:15:16'),
(4, 'Platinum', '950', 21.4500, 'Premium metal with high purity and durability', 'Active', '2026-02-14 08:15:16', '2026-02-14 08:15:16');

-- --------------------------------------------------------

--
-- Table structure for table `measurements`
--

CREATE TABLE `measurements` (
  `measurement_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `UOM` varchar(45) DEFAULT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `measurements`
--

INSERT INTO `measurements` (`measurement_id`, `name`, `UOM`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Gram', 'g', 'Active', '2026-02-14 08:15:16', '2026-02-14 08:15:16'),
(2, 'Kilogram', 'kg', 'Active', '2026-02-14 08:15:16', '2026-02-14 08:15:16'),
(3, 'Carat', 'ct', 'Active', '2026-02-14 08:15:16', '2026-02-14 08:15:16'),
(4, 'Millimeter', 'mm', 'Active', '2026-02-14 08:15:16', '2026-02-14 08:15:16');

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
(4, '2025_03_28_075724_create_email_configs_table', 1),
(5, '2025_03_28_101013_create_payments_table', 1),
(6, '2025_03_29_042036_create_websettings_table', 1),
(7, '2026_01_30_100721_create_product_categories_table', 1),
(8, '2026_01_31_110000_create_materials_table', 1),
(9, '2026_02_01_070751_create_component_types_table', 1),
(10, '2026_02_02_000000_create_companies_table', 1),
(11, '2026_02_02_000001_create_branches_table', 1),
(12, '2026_02_02_100023_create_gemstones_table', 1),
(13, '2026_02_02_112211_create_suppliers_table', 1),
(14, '2026_02_02_125647_create_products_table', 1),
(15, '2026_02_04_055418_add_phone_number_address_profile_to_users_table', 1),
(16, '2026_02_04_080314_create_labors_table', 1),
(17, '2026_02_05_070608_create_product_components_table', 1),
(18, '2026_02_06_000001_create_measurements_table', 1),
(19, '2026_02_09_101002_create_location_masters_table', 1),
(20, '2026_02_09_123630_create_application_settings_table', 1),
(21, '2026_02_13_093407_create_inventory_stocks_table', 1),
(22, '2026_02_13_105607_create_product_labors_table', 1),
(23, '2026_02_14_102612_create_product_measurements_table', 1);

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
  `agent` varchar(255) NOT NULL,
  `merchant_id` varchar(255) NOT NULL,
  `api_key` varchar(255) NOT NULL,
  `status` enum('Test','Live') NOT NULL DEFAULT 'Test',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `agent`, `merchant_id`, `api_key`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Razorpay', 'rzp_merchant_001', 'change-me', 'Test', '2026-02-14 08:15:17', '2026-02-14 08:15:17');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `sku` varchar(50) NOT NULL,
  `barcode` varchar(100) DEFAULT NULL,
  `product_name` varchar(200) NOT NULL,
  `description` text DEFAULT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `material_id` bigint(20) UNSIGNED DEFAULT NULL,
  `gemstone_id` bigint(20) UNSIGNED DEFAULT NULL,
  `supplier_id` bigint(20) UNSIGNED DEFAULT NULL,
  `collection` varchar(100) DEFAULT NULL,
  `designer` varchar(100) DEFAULT NULL,
  `country_of_origin` varchar(50) DEFAULT NULL,
  `weight_grams` decimal(8,3) DEFAULT NULL,
  `metal_weight` decimal(8,3) DEFAULT NULL,
  `gemstone_weight` decimal(6,3) DEFAULT NULL,
  `gemstone_count` int(11) NOT NULL DEFAULT 0,
  `total_metal_weight` decimal(8,3) DEFAULT NULL,
  `total_gemstone_weight` decimal(8,3) DEFAULT NULL,
  `carat_purity` varchar(20) DEFAULT NULL,
  `size` varchar(20) DEFAULT NULL,
  `color` varchar(30) DEFAULT NULL,
  `style` varchar(50) DEFAULT NULL,
  `gender` enum('male','female','unisex') NOT NULL DEFAULT 'unisex',
  `cost_price` decimal(12,2) NOT NULL,
  `markup_percentage` decimal(5,2) DEFAULT NULL,
  `selling_price` decimal(12,2) NOT NULL,
  `wholesale_price` decimal(12,2) DEFAULT NULL,
  `discount_price` decimal(12,2) DEFAULT NULL,
  `quantity_in_stock` int(11) NOT NULL DEFAULT 0,
  `minimum_stock_level` int(11) NOT NULL DEFAULT 5,
  `reorder_quantity` int(11) DEFAULT NULL,
  `component_based` tinyint(1) NOT NULL DEFAULT 0,
  `is_set` tinyint(1) NOT NULL DEFAULT 0,
  `set_count` int(11) NOT NULL DEFAULT 1,
  `is_serialized` tinyint(1) NOT NULL DEFAULT 0,
  `track_individual_items` tinyint(1) NOT NULL DEFAULT 0,
  `serial_number_format` varchar(100) DEFAULT NULL,
  `serialized_count` int(11) NOT NULL DEFAULT 0,
  `last_serial_number` int(11) NOT NULL DEFAULT 0,
  `is_lot_based` tinyint(1) NOT NULL DEFAULT 0,
  `requires_certificate` tinyint(1) NOT NULL DEFAULT 0,
  `certificate_number` varchar(100) DEFAULT NULL,
  `certificate_issuer` varchar(100) DEFAULT NULL,
  `certificate_date` date DEFAULT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `company_id`, `sku`, `barcode`, `product_name`, `description`, `category_id`, `material_id`, `gemstone_id`, `supplier_id`, `collection`, `designer`, `country_of_origin`, `weight_grams`, `metal_weight`, `gemstone_weight`, `gemstone_count`, `total_metal_weight`, `total_gemstone_weight`, `carat_purity`, `size`, `color`, `style`, `gender`, `cost_price`, `markup_percentage`, `selling_price`, `wholesale_price`, `discount_price`, `quantity_in_stock`, `minimum_stock_level`, `reorder_quantity`, `component_based`, `is_set`, `set_count`, `is_serialized`, `track_individual_items`, `serial_number_format`, `serialized_count`, `last_serial_number`, `is_lot_based`, `requires_certificate`, `certificate_number`, `certificate_issuer`, `certificate_date`, `status`, `is_featured`, `created_at`, `updated_at`) VALUES
(1, 1, 'RING001', NULL, 'Gold Diamond Ring', NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'unisex', 100.00, NULL, 200.00, NULL, NULL, 10, 5, NULL, 0, 0, 1, 0, 0, NULL, 0, 0, 0, 0, NULL, NULL, NULL, 'Active', 0, '2026-02-14 08:15:17', '2026-02-14 08:15:17');

-- --------------------------------------------------------

--
-- Table structure for table `product_components`
--

CREATE TABLE `product_components` (
  `component_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `component_type_id` bigint(20) UNSIGNED DEFAULT NULL,
  `component_name` varchar(100) NOT NULL,
  `material_id` bigint(20) UNSIGNED DEFAULT NULL,
  `material_weight` decimal(8,3) DEFAULT NULL,
  `material_purity` varchar(20) DEFAULT NULL,
  `gemstone_id` bigint(20) UNSIGNED DEFAULT NULL,
  `gemstone_quantity` int(11) NOT NULL DEFAULT 1,
  `gemstone_weight` decimal(8,3) DEFAULT NULL,
  `gemstone_carat_weight` decimal(8,3) DEFAULT NULL,
  `gemstone_shape` varchar(50) DEFAULT NULL,
  `gemstone_color` varchar(50) DEFAULT NULL,
  `gemstone_clarity` varchar(50) DEFAULT NULL,
  `gemstone_cut_grade` varchar(50) DEFAULT NULL,
  `gemstone_certificate` varchar(100) DEFAULT NULL,
  `dimension_length` decimal(8,2) DEFAULT NULL,
  `dimension_width` decimal(8,2) DEFAULT NULL,
  `dimension_height` decimal(8,2) DEFAULT NULL,
  `diameter` decimal(8,2) DEFAULT NULL,
  `component_cost` decimal(10,2) DEFAULT NULL,
  `labor_cost` decimal(10,2) DEFAULT NULL,
  `setting_cost` decimal(10,2) DEFAULT NULL,
  `total_component_cost` decimal(10,2) GENERATED ALWAYS AS (`component_cost` + `labor_cost` + `setting_cost`) STORED,
  `position_order` int(11) NOT NULL DEFAULT 0,
  `position_description` varchar(200) DEFAULT NULL,
  `is_main_component` tinyint(1) NOT NULL DEFAULT 0,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_components`
--

INSERT INTO `product_components` (`component_id`, `product_id`, `component_type_id`, `component_name`, `material_id`, `material_weight`, `material_purity`, `gemstone_id`, `gemstone_quantity`, `gemstone_weight`, `gemstone_carat_weight`, `gemstone_shape`, `gemstone_color`, `gemstone_clarity`, `gemstone_cut_grade`, `gemstone_certificate`, `dimension_length`, `dimension_width`, `dimension_height`, `diameter`, `component_cost`, `labor_cost`, `setting_cost`, `position_order`, `position_description`, `is_main_component`, `notes`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Main Setting', 1, 2.500, '18K', 1, 1, 0.500, 0.500, 'Round', 'D', 'VVS1', 'Excellent', 'GIA123456', 5.00, 5.00, 3.00, 5.00, 100.00, 20.00, 10.00, 1, 'Center', 1, 'Sample component', '2026-02-14 08:15:17', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_labor`
--

CREATE TABLE `product_labor` (
  `product_labor_id` int(10) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `labor_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `actual_hours` decimal(5,2) DEFAULT NULL,
  `labor_cost` decimal(10,2) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_measurements`
--

CREATE TABLE `product_measurements` (
  `measurement_id` int(10) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `measurement_type` varchar(50) DEFAULT NULL,
  `unit` varchar(20) DEFAULT NULL,
  `value_decimal` decimal(8,2) DEFAULT NULL,
  `value_string` varchar(100) DEFAULT NULL,
  `position` varchar(100) DEFAULT NULL,
  `notes` text DEFAULT NULL,
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
('eNvwuEz4MpQStZrc02o1GfxhRHy2mcTPqFN8D5vG', NULL, '192.168.1.185', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiVnBwRzZFTUZtZkhsQjN3TUViZ0xLYWxFTjYxb2FWbzNLaE1ONHBHMCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xOTIuMTY4LjEuMTg1OjgwMDAvbG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjEwOiJjb21wYW55X2lkIjtzOjM6ImFsbCI7fQ==', 1771076799);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `setting_id` int(10) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED DEFAULT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `setting_key` varchar(100) NOT NULL,
  `setting_value` text DEFAULT NULL,
  `setting_type` enum('string','number','boolean','json') NOT NULL DEFAULT 'string',
  `category` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`setting_id`, `company_id`, `branch_id`, `setting_key`, `setting_value`, `setting_type`, `category`, `description`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, 'site.title', 'Gold Post', 'string', 'General', 'Application title displayed in the header and browser title.', '2026-02-14 08:15:17', '2026-02-14 08:15:17'),
(2, NULL, NULL, 'site.timezone', 'Asia/Kolkata', 'string', 'General', 'Default timezone used across the application.', '2026-02-14 08:15:17', '2026-02-14 08:15:17'),
(3, NULL, NULL, 'tax.enabled', 'true', 'boolean', 'Tax', 'Enable or disable tax calculations.', '2026-02-14 08:15:17', '2026-02-14 08:15:17'),
(4, NULL, NULL, 'tax.rate', '3.0', 'number', 'Tax', 'Default tax percentage rate.', '2026-02-14 08:15:17', '2026-02-14 08:15:17'),
(5, NULL, NULL, 'invoice.footer', 'Thank you for your business.', 'string', 'Invoice', 'Footer note printed on invoices.', '2026-02-14 08:15:17', '2026-02-14 08:15:17');

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `supplier_id` bigint(20) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED NOT NULL,
  `supplier_code` varchar(20) NOT NULL,
  `contact_person` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `mobile` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `state` varchar(50) DEFAULT NULL,
  `country` varchar(50) DEFAULT NULL,
  `tax_id` varchar(50) DEFAULT NULL,
  `payment_terms` varchar(100) DEFAULT NULL,
  `bank_details` text DEFAULT NULL,
  `rating` decimal(3,2) NOT NULL DEFAULT 0.00,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`supplier_id`, `company_id`, `supplier_code`, `contact_person`, `email`, `phone`, `mobile`, `address`, `city`, `state`, `country`, `tax_id`, `payment_terms`, `bank_details`, `rating`, `status`, `notes`, `created_at`, `updated_at`) VALUES
(1, 1, 'SUP001', 'Rajesh Kumar', 'rajesh@goldpost.com', '1234567890', '9876543210', '123 Gold Street, Mumbai', 'Mumbai', 'Maharashtra', 'India', '27AAACG1234A1Z5', '30 Days', 'ICICI Bank, A/C 123456789', 4.50, 'Active', 'Preferred supplier', '2026-02-14 08:15:16', '2026-02-14 08:15:16'),
(2, 2, 'SUP002', 'Anita Sharma', 'anita@gemstonetraders.com', '9876543210', '1234567890', '456 Gem Avenue, Jaipur', 'Jaipur', 'Rajasthan', 'India', '08AAACG5678B1Z6', '15 Days', 'SBI Bank, A/C 987654321', 4.00, 'Active', 'Reliable supplier', '2026-02-14 08:15:16', '2026-02-14 08:15:16');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `profile` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone_number`, `address`, `profile`, `email_verified_at`, `password`, `remember_token`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@mail.com', '9584685452', 'Address', '1771076786_69907cb25e1ae.png', '2026-02-14 08:15:18', '$2y$12$XTl2itM4.hJgz6kYA0e7EuVF/pk88xHpV/HQaJJxn5GIGJtS1KplG', 'hnHV5ZmQpBBWBxSxtjmM0NaIOlhAHe79aFYwdwrRRaW1NdViBW0V9bj7g3Iv', 'Active', '2026-02-14 08:15:19', '2026-02-14 08:16:26');

-- --------------------------------------------------------

--
-- Table structure for table `websettings`
--

CREATE TABLE `websettings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `site_name` varchar(255) NOT NULL,
  `site_url` varchar(255) NOT NULL,
  `contact_person` varchar(100) NOT NULL,
  `contact_email` varchar(255) NOT NULL,
  `contact_phone` varchar(255) NOT NULL,
  `sales_email` varchar(150) DEFAULT NULL,
  `address` text NOT NULL,
  `logo` varchar(100) DEFAULT NULL,
  `fav_icon` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `websettings`
--

INSERT INTO `websettings` (`id`, `site_name`, `site_url`, `contact_person`, `contact_email`, `contact_phone`, `sales_email`, `address`, `logo`, `fav_icon`, `created_at`, `updated_at`) VALUES
(1, 'GoldPost', 'http://localhost', 'Admin', 'admin@goldpost.com', '9854685484', 'goldpostsales@gmail.com', '123 Main Street, City', 'logo.png', 'fav_icon.png', '2026-02-14 08:15:17', '2026-02-14 08:15:17');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`branch_id`),
  ADD UNIQUE KEY `branches_branch_code_unique` (`branch_code`);

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
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`),
  ADD UNIQUE KEY `categories_category_code_unique` (`category_code`),
  ADD KEY `categories_company_id_index` (`company_id`),
  ADD KEY `categories_parent_category_id_index` (`parent_category_id`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`company_id`),
  ADD UNIQUE KEY `companies_company_code_unique` (`company_code`);

--
-- Indexes for table `component_types`
--
ALTER TABLE `component_types`
  ADD PRIMARY KEY (`type_id`),
  ADD KEY `component_types_company_id_index` (`company_id`);

--
-- Indexes for table `email_configs`
--
ALTER TABLE `email_configs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `gemstones`
--
ALTER TABLE `gemstones`
  ADD PRIMARY KEY (`gemstone_id`),
  ADD UNIQUE KEY `gemstones_gemstone_code_unique` (`gemstone_code`),
  ADD KEY `idx_type` (`type`),
  ADD KEY `gemstones_company_id_index` (`company_id`),
  ADD KEY `gemstones_branch_id_index` (`branch_id`);

--
-- Indexes for table `inventory_stocks`
--
ALTER TABLE `inventory_stocks`
  ADD PRIMARY KEY (`stock_id`),
  ADD KEY `inventory_stocks_product_id_index` (`product_id`),
  ADD KEY `inventory_stocks_location_id_index` (`location_id`),
  ADD KEY `inventory_stocks_last_movement_date_index` (`last_movement_date`);

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
-- Indexes for table `labors`
--
ALTER TABLE `labors`
  ADD PRIMARY KEY (`labor_id`),
  ADD UNIQUE KEY `labors_labor_code_unique` (`labor_code`);

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`location_id`),
  ADD UNIQUE KEY `locations_location_code_unique` (`location_code`),
  ADD KEY `locations_company_id_index` (`company_id`),
  ADD KEY `locations_branch_id_index` (`branch_id`);

--
-- Indexes for table `materials`
--
ALTER TABLE `materials`
  ADD PRIMARY KEY (`material_id`),
  ADD UNIQUE KEY `materials_material_name_unique` (`material_name`);

--
-- Indexes for table `measurements`
--
ALTER TABLE `measurements`
  ADD PRIMARY KEY (`measurement_id`);

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
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD UNIQUE KEY `products_sku_unique` (`sku`),
  ADD KEY `products_sku_index` (`sku`),
  ADD KEY `products_category_id_index` (`category_id`),
  ADD KEY `products_selling_price_index` (`selling_price`),
  ADD KEY `products_quantity_in_stock_index` (`quantity_in_stock`),
  ADD KEY `products_company_id_index` (`company_id`);

--
-- Indexes for table `product_components`
--
ALTER TABLE `product_components`
  ADD PRIMARY KEY (`component_id`),
  ADD KEY `idx_product` (`product_id`),
  ADD KEY `idx_type` (`component_type_id`);

--
-- Indexes for table `product_labor`
--
ALTER TABLE `product_labor`
  ADD PRIMARY KEY (`product_labor_id`),
  ADD KEY `idx_product_labor_product` (`product_id`),
  ADD KEY `idx_product_labor_labor` (`labor_id`);

--
-- Indexes for table `product_measurements`
--
ALTER TABLE `product_measurements`
  ADD PRIMARY KEY (`measurement_id`),
  ADD KEY `product_measurements_product_id_index` (`product_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`setting_id`),
  ADD KEY `settings_company_id_index` (`company_id`),
  ADD KEY `settings_branch_id_index` (`branch_id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`supplier_id`),
  ADD UNIQUE KEY `suppliers_supplier_code_unique` (`supplier_code`),
  ADD KEY `suppliers_company_id_index` (`company_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `websettings`
--
ALTER TABLE `websettings`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `branches`
--
ALTER TABLE `branches`
  MODIFY `branch_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `company_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `component_types`
--
ALTER TABLE `component_types`
  MODIFY `type_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `email_configs`
--
ALTER TABLE `email_configs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gemstones`
--
ALTER TABLE `gemstones`
  MODIFY `gemstone_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `inventory_stocks`
--
ALTER TABLE `inventory_stocks`
  MODIFY `stock_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `labors`
--
ALTER TABLE `labors`
  MODIFY `labor_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `location_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `materials`
--
ALTER TABLE `materials`
  MODIFY `material_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `measurements`
--
ALTER TABLE `measurements`
  MODIFY `measurement_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `product_components`
--
ALTER TABLE `product_components`
  MODIFY `component_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `product_labor`
--
ALTER TABLE `product_labor`
  MODIFY `product_labor_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_measurements`
--
ALTER TABLE `product_measurements`
  MODIFY `measurement_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `setting_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `supplier_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `websettings`
--
ALTER TABLE `websettings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
