-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 23 juin 2026 à 08:55
-- Version du serveur : 11.8.2-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `markel_pharma`
--

-- --------------------------------------------------------

--
-- Structure de la table `audit_logs`
--

CREATE TABLE `audit_logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `action` varchar(255) DEFAULT NULL,
  `entity_type` varchar(100) DEFAULT NULL,
  `entity_id` int(11) DEFAULT NULL,
  `old_values` longtext DEFAULT NULL,
  `new_values` longtext DEFAULT NULL,
  `ip_address` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `created_at`) VALUES
(1, 'Spécialité', NULL, '2026-05-30 00:30:05'),
(2, 'Générique', NULL, '2026-05-30 00:30:05'),
(3, 'Parapharmacie', NULL, '2026-05-30 00:30:05'),
(4, 'Consommable médical', NULL, '2026-05-30 00:30:05'),
(5, 'Complément alimentaire', NULL, '2026-05-30 00:30:05');

-- --------------------------------------------------------

--
-- Structure de la table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `loyalty_points` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `customers`
--

INSERT INTO `customers` (`id`, `full_name`, `phone`, `email`, `address`, `loyalty_points`, `created_at`) VALUES
(1, 'elie', '09999928U2', NULL, NULL, 0, '2026-06-20 11:56:53'),
(2, 'ELIE', '000000999999', NULL, NULL, 0, '2026-06-22 06:36:57'),
(3, 'EL', '34324244', NULL, NULL, 0, '2026-06-22 06:40:25'),
(4, 'EL', '200000', NULL, NULL, 0, '2026-06-22 06:46:58'),
(5, 'ELIE', '09876353535', NULL, NULL, 0, '2026-06-22 07:20:44'),
(6, 'LOLY', '393993939', NULL, NULL, 0, '2026-06-22 07:22:34'),
(7, 'ENOCH', '387497', NULL, NULL, 0, '2026-06-22 11:59:23'),
(8, 'ENO', '88987897', NULL, NULL, 0, '2026-06-22 12:03:24'),
(9, 'eno', '34936647367343', NULL, NULL, 0, '2026-06-22 12:10:58'),
(10, 'ELLL', '877222882', NULL, NULL, 0, '2026-06-22 12:23:18'),
(11, 'dzd', '3223323233', NULL, NULL, 0, '2026-06-22 12:26:42'),
(12, 'ELIE', '229292929', NULL, NULL, 0, '2026-06-22 12:28:32'),
(13, 'EEU', '545543654', NULL, NULL, 0, '2026-06-22 15:23:49'),
(14, 'EZZEEE', '43545255', NULL, NULL, 0, '2026-06-22 15:25:00'),
(15, 'EFRE', '342425532', NULL, NULL, 0, '2026-06-22 15:41:40');

-- --------------------------------------------------------

--
-- Structure de la table `dosage_forms`
--

CREATE TABLE `dosage_forms` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `dosage_forms`
--

INSERT INTO `dosage_forms` (`id`, `name`, `created_at`) VALUES
(1, 'Comprimé', '2026-05-30 00:30:05'),
(2, 'Capsule', '2026-05-30 00:30:05'),
(3, 'Gélule', '2026-05-30 00:30:05'),
(4, 'Sirop', '2026-05-30 00:30:05'),
(5, 'Injectable', '2026-05-30 00:30:05'),
(6, 'Suppositoire', '2026-05-30 00:30:05'),
(7, 'Ovule', '2026-05-30 00:30:05'),
(8, 'Crème', '2026-05-30 00:30:05'),
(9, 'Gel', '2026-05-30 00:30:05'),
(10, 'Spray', '2026-05-30 00:30:05'),
(11, 'Collyre', '2026-05-30 00:30:05'),
(12, 'Solution buvable', '2026-05-30 00:30:05'),
(13, 'Sachet', '2026-05-30 00:30:05'),
(14, 'Ampoule', '2026-05-30 00:30:05');

-- --------------------------------------------------------

--
-- Structure de la table `inventory_batches`
--

CREATE TABLE `inventory_batches` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `batch_number` varchar(100) DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  `quantity` int(11) DEFAULT 0,
  `supplier` varchar(255) DEFAULT NULL,
  `purchase_price` decimal(10,2) DEFAULT 0.00,
  `selling_price` decimal(10,2) DEFAULT 0.00,
  `received_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `inventory_batches`
--

INSERT INTO `inventory_batches` (`id`, `product_id`, `batch_number`, `expiry_date`, `quantity`, `supplier`, `purchase_price`, `selling_price`, `received_at`) VALUES
(1, 1, 'PARA_20248_MARKEL', '2029-02-08', 100, 'Enoch', 20.00, 18.00, '2026-06-08 06:46:05'),
(7, 14, 'BB38', '2026-09-01', 100, 'Enoch', 1.05, 1.75, '2026-06-22 08:22:14');

-- --------------------------------------------------------

--
-- Structure de la table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(11) NOT NULL,
  `migration` varchar(255) NOT NULL,
  `executed_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `executed_at`) VALUES
(1, 'CreateAuditLogsTable', '2026-05-30 00:29:53'),
(2, 'CreateCategoriesTable', '2026-05-30 00:29:53'),
(3, 'CreateCustomersTable', '2026-05-30 00:29:53'),
(4, 'CreateDosageFormsTable', '2026-05-30 00:29:54'),
(5, 'CreateInventoryBatchesTable', '2026-05-30 00:29:54'),
(6, 'CreateNotificationsTable', '2026-05-30 00:29:54'),
(7, 'CreatePackagingUnitsTable', '2026-05-30 00:29:54'),
(8, 'CreatePermissionsTable', '2026-05-30 00:29:55'),
(9, 'CreateProductsTable', '2026-05-30 00:29:55'),
(10, 'CreatePurchaseItemsTable', '2026-05-30 00:29:55'),
(11, 'CreatePurchaseReceivingItemsTable', '2026-05-30 00:29:56'),
(12, 'CreatePurchaseReceivingsTable', '2026-05-30 00:29:56'),
(13, 'CreatePurchasesTable', '2026-05-30 00:29:56'),
(14, 'CreateReturnItemsTable', '2026-05-30 00:29:56'),
(15, 'CreateReturnsTable', '2026-05-30 00:29:56'),
(16, 'CreateRolePermissionsTable', '2026-05-30 00:29:57'),
(17, 'CreateRolesTable', '2026-05-30 00:29:57'),
(18, 'CreateSaleItemsTable', '2026-05-30 00:29:57'),
(19, 'CreateSalePaymentsTable', '2026-05-30 00:29:58'),
(20, 'CreateSalesTable', '2026-05-30 00:29:58'),
(21, 'CreateSettingsTable', '2026-05-30 00:29:58'),
(22, 'CreateStockAdjustmentsTable', '2026-05-30 00:29:58'),
(23, 'CreateStockMovementsTable', '2026-05-30 00:29:59'),
(24, 'CreateSupplierPaymentsTable', '2026-05-30 00:29:59'),
(25, 'CreateSuppliersTable', '2026-05-30 00:29:59'),
(26, 'CreateUserSessionsTable', '2026-05-30 00:29:59'),
(27, 'CreateUsersTable', '2026-05-30 00:30:00'),
(28, 'AlterProductsClassificationFields', '2026-05-30 00:30:02'),
(29, 'AlterProductsSafetyFields', '2026-05-30 00:30:04'),
(30, 'AlterPurchasesWorkflowFields', '2026-05-30 00:30:04');

-- --------------------------------------------------------

--
-- Structure de la table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `recipient_type` varchar(100) DEFAULT NULL,
  `recipient_id` int(11) DEFAULT NULL,
  `channel` varchar(100) DEFAULT NULL,
  `message` longtext DEFAULT NULL,
  `status` varchar(50) DEFAULT 'pending',
  `attempts` int(11) DEFAULT 0,
  `sent_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `packaging_units`
--

CREATE TABLE `packaging_units` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `abbreviation` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `packaging_units`
--

INSERT INTO `packaging_units` (`id`, `name`, `abbreviation`, `created_at`) VALUES
(1, 'Boîte', 'bt', '2026-05-30 00:30:05'),
(2, 'Plaquette', 'plq', '2026-05-30 00:30:05'),
(3, 'Flacon', 'fl', '2026-05-30 00:30:05'),
(4, 'Tube', 'tb', '2026-05-30 00:30:05'),
(5, 'Ampoule', 'amp', '2026-05-30 00:30:05'),
(6, 'Sachet', 'scht', '2026-05-30 00:30:05'),
(7, 'Pièce', 'pc', '2026-05-30 00:30:05');

-- --------------------------------------------------------

--
-- Structure de la table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `sku` varchar(100) DEFAULT NULL,
  `barcode` varchar(255) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `unit` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `cost_price` decimal(10,2) DEFAULT 0.00,
  `selling_price` decimal(10,2) DEFAULT 0.00,
  `minimum_stock` int(11) DEFAULT 0,
  `requires_prescription` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `category_id` int(11) DEFAULT NULL,
  `dosage_form_id` int(11) DEFAULT NULL,
  `packaging_unit_id` int(11) DEFAULT NULL,
  `strength` varchar(100) DEFAULT NULL,
  `purchase_price` decimal(10,2) DEFAULT 0.00,
  `prescription_required` tinyint(1) DEFAULT 0,
  `is_temperature_sensitive` tinyint(1) DEFAULT 0,
  `storage_temperature` varchar(100) DEFAULT NULL,
  `is_controlled_substance` tinyint(1) DEFAULT 0,
  `minimum_stock_level` int(11) DEFAULT 0,
  `product_type` enum('generic','brand') DEFAULT 'generic',
  `therapeutic_class` varchar(100) DEFAULT NULL,
  `active_ingredient` varchar(255) DEFAULT NULL,
  `manufacturer` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `products`
--

INSERT INTO `products` (`id`, `name`, `sku`, `barcode`, `category`, `unit`, `description`, `cost_price`, `selling_price`, `minimum_stock`, `requires_prescription`, `created_at`, `updated_at`, `category_id`, `dosage_form_id`, `packaging_unit_id`, `strength`, `purchase_price`, `prescription_required`, `is_temperature_sensitive`, `storage_temperature`, `is_controlled_substance`, `minimum_stock_level`, `product_type`, `therapeutic_class`, `active_ingredient`, `manufacturer`) VALUES
(3, 'MEDROL ', NULL, '', NULL, NULL, NULL, 0.00, 0.00, 0, 0, '2026-06-19 06:28:19', '2026-06-19 06:28:19', NULL, NULL, NULL, NULL, 0.00, 0, 0, NULL, 0, 0, 'generic', NULL, NULL, NULL),
(4, 'BCG vaccine', NULL, NULL, NULL, NULL, NULL, 0.00, 0.00, 0, 0, '2026-06-19 10:04:10', '2026-06-19 10:04:10', NULL, NULL, NULL, 'All vaccines should comply with the WHO requirements for biological substances.', 0.00, 0, 0, NULL, 0, 10, 'generic', 'Immunologicals > Vaccines', 'BCG vaccine', NULL),
(5, 'Ebola vaccine', NULL, NULL, NULL, NULL, NULL, 0.00, 0.00, 0, 0, '2026-06-19 10:04:11', '2026-06-19 10:04:11', NULL, NULL, NULL, 'All vaccines should comply with the WHO requirements for biological substances.', 0.00, 0, 0, NULL, 0, 10, 'generic', 'Immunologicals > Vaccines', 'Ebola vaccine', NULL),
(6, 'Japanese encephalitis vaccine', NULL, NULL, NULL, NULL, NULL, 0.00, 0.00, 0, 0, '2026-06-19 10:04:11', '2026-06-19 10:04:11', NULL, NULL, NULL, 'All vaccines should comply with the WHO requirements for biological substances.', 0.00, 0, 0, NULL, 0, 10, 'generic', 'Immunologicals > Vaccines', 'Japanese encephalitis vaccine', NULL),
(7, 'Medicines for COVID-19', NULL, NULL, NULL, NULL, NULL, 0.00, 0.00, 0, 0, '2026-06-19 10:04:11', '2026-06-19 10:04:11', NULL, NULL, NULL, 'Refer to WHO living guidelines', 0.00, 0, 0, NULL, 0, 10, 'generic', 'Medicines for COVID-19', 'Medicines for COVID-19', NULL),
(8, 'abacavir', NULL, '', NULL, NULL, NULL, 0.00, 20.00, 0, 0, '2026-06-19 10:04:11', '2026-06-19 14:03:51', NULL, NULL, NULL, 'Oral > Solid: 300 mg tablet (as sulfate)', 16.00, 0, 0, NULL, 0, 10, 'generic', 'Antiretrovirals > Nucleoside/Nucleotide reverse transcriptase inhibitors', 'abacavir', NULL),
(9, 'abacavir + dolutegravir + lamivudine', NULL, NULL, NULL, NULL, NULL, 0.00, 0.00, 0, 0, '2026-06-19 10:04:11', '2026-06-19 10:04:11', NULL, NULL, NULL, 'Oral > Solid > tablet: 60 mg (as sulfate) + 5 mg + 30 mg (dispersible, scored)', 0.00, 0, 0, NULL, 0, 10, 'generic', 'Fixed-dose combinations of antiretrovirals', 'abacavir + dolutegravir + lamivudine', NULL),
(10, 'abacavir + lamivudine', NULL, NULL, NULL, NULL, NULL, 0.00, 0.00, 0, 0, '2026-06-19 10:04:11', '2026-06-19 10:04:11', NULL, NULL, NULL, 'Oral > Solid: 120 mg (as sulfate) + 60 mg tablet (dispersible, scored)', 0.00, 0, 0, NULL, 0, 10, 'generic', 'Fixed-dose combinations of antiretrovirals', 'abacavir + lamivudine', NULL),
(11, 'abacavir + lamivudine + lopinavir + ritonavir', NULL, NULL, NULL, NULL, NULL, 0.00, 0.00, 0, 0, '2026-06-19 10:04:11', '2026-06-19 10:04:11', NULL, NULL, NULL, 'Oral > Solid: 30 mg + 15 mg + 40 mg + 10 mg capsule containing oral granules', 0.00, 0, 0, NULL, 0, 10, 'generic', 'Fixed-dose combinations of antiretrovirals', 'abacavir + lamivudine + lopinavir + ritonavir', NULL),
(12, 'abemaciclib', NULL, NULL, NULL, NULL, NULL, 0.00, 0.00, 0, 0, '2026-06-19 10:04:11', '2026-06-19 10:04:11', NULL, NULL, NULL, NULL, 0.00, 0, 0, NULL, 0, 10, 'generic', 'Targeted therapies', 'abemaciclib', NULL),
(13, 'abiraterone', NULL, NULL, NULL, NULL, NULL, 0.00, 0.00, 0, 0, '2026-06-19 10:04:11', '2026-06-19 10:04:11', NULL, NULL, NULL, 'Oral > Solid: 250 mg; 500 mg', 0.00, 0, 0, NULL, 0, 10, 'generic', 'Hormones and antihormones', 'abiraterone', NULL),
(14, 'acamprosate calcium', NULL, NULL, NULL, NULL, NULL, 0.00, 1.75, 0, 0, '2026-06-19 10:04:11', '2026-06-22 08:22:14', NULL, NULL, NULL, 'Oral > Solid > tablet: 333 mg', 1.05, 0, 0, NULL, 0, 10, 'generic', 'Medicines for alcohol use disorders', 'acamprosate calcium', NULL),
(15, 'acenocoumarol', NULL, NULL, NULL, NULL, NULL, 0.00, 0.00, 0, 0, '2026-06-19 10:04:11', '2026-06-19 10:04:11', NULL, NULL, NULL, NULL, 0.00, 0, 0, NULL, 0, 10, 'generic', 'Medicines affecting coagulation', 'acenocoumarol', NULL),
(16, 'acenocoumarol', NULL, NULL, NULL, NULL, NULL, 0.00, 0.00, 0, 0, '2026-06-19 10:04:11', '2026-06-19 10:04:11', NULL, NULL, NULL, NULL, 0.00, 0, 0, NULL, 0, 10, 'generic', 'Medicines affecting coagulation', 'acenocoumarol', NULL),
(17, 'acenocoumarol', NULL, NULL, NULL, NULL, NULL, 0.00, 0.00, 0, 0, '2026-06-19 10:04:12', '2026-06-19 10:04:12', NULL, NULL, NULL, NULL, 0.00, 0, 0, NULL, 0, 10, 'generic', 'Medicines affecting coagulation', 'acenocoumarol', NULL),
(18, 'acenocoumarol', NULL, NULL, NULL, NULL, NULL, 0.00, 0.00, 0, 0, '2026-06-19 10:04:12', '2026-06-19 10:04:12', NULL, NULL, NULL, NULL, 0.00, 0, 0, NULL, 0, 10, 'generic', 'Medicines affecting coagulation', 'acenocoumarol', NULL),
(19, 'acetazolamide', NULL, NULL, NULL, NULL, NULL, 0.00, 0.00, 0, 0, '2026-06-19 10:04:12', '2026-06-19 10:04:12', NULL, NULL, NULL, 'Oral > Solid: 250 mg', 0.00, 0, 0, NULL, 0, 10, 'generic', 'Ophthalmological preparations > Miotics and antiglaucoma medicines', 'acetazolamide', NULL),
(20, 'acetic acid', NULL, NULL, NULL, NULL, NULL, 0.00, 0.00, 0, 0, '2026-06-19 10:04:12', '2026-06-19 10:04:12', NULL, NULL, NULL, 'Local > Otological > drops: 2% solution', 0.00, 0, 0, NULL, 0, 10, 'generic', 'Ear, nose and throat medicines [c]', 'acetic acid', NULL),
(21, 'acetylcysteine', NULL, NULL, NULL, NULL, NULL, 0.00, 0.00, 0, 0, '2026-06-19 10:04:12', '2026-06-19 10:04:12', NULL, NULL, NULL, 'Parenteral > General injections > IV: 200 mg per  mL in 10 mL ampoule\r\nOral > Liquid: 10%; 20%', 0.00, 0, 0, NULL, 0, 10, 'generic', 'Antidotes and other substances used in poisonings > Specific', 'acetylcysteine', NULL),
(22, 'acetylcysteine', NULL, NULL, NULL, NULL, NULL, 0.00, 0.00, 0, 0, '2026-06-19 10:04:12', '2026-06-19 10:04:12', NULL, NULL, NULL, 'Parenteral > General injections > IV: 200 mg per  mL in 10 mL ampoule\r\nOral > Liquid: 10%; 20%', 0.00, 0, 0, NULL, 0, 10, 'generic', 'Antidotes and other substances used in poisonings > Specific', 'acetylcysteine', NULL),
(23, 'acetylsalicylic acid', NULL, NULL, NULL, NULL, NULL, 0.00, 0.00, 0, 0, '2026-06-19 10:04:12', '2026-06-19 10:04:12', NULL, NULL, NULL, 'Oral > Solid: 300 to 500 mg', 0.00, 0, 0, NULL, 0, 10, 'generic', 'Medicines for acute migraine attacks', 'acetylsalicylic acid', NULL),
(24, 'acetylsalicylic acid', NULL, NULL, NULL, NULL, NULL, 0.00, 0.00, 0, 0, '2026-06-19 10:04:12', '2026-06-19 10:04:12', NULL, NULL, NULL, 'Oral > Solid: 100 mg', 0.00, 0, 0, NULL, 0, 10, 'generic', 'Anti-platelet medicines', 'acetylsalicylic acid', NULL),
(25, 'acetylsalicylic acid', NULL, NULL, NULL, NULL, NULL, 0.00, 0.00, 0, 0, '2026-06-19 10:04:12', '2026-06-19 10:04:12', NULL, NULL, NULL, 'Oral > Solid: 100 mg', 0.00, 0, 0, NULL, 0, 10, 'generic', 'Anti-platelet medicines', 'acetylsalicylic acid', NULL),
(26, 'acetylsalicylic acid', NULL, NULL, NULL, NULL, NULL, 0.00, 0.00, 0, 0, '2026-06-19 10:04:12', '2026-06-19 10:04:12', NULL, NULL, NULL, 'Oral > Solid: 100 to 500 mg\r\nLocal > Rectal > Suppository: 50 to 150 mg', 0.00, 0, 0, NULL, 0, 10, 'generic', 'Non-opioids and non-steroidal anti-inflammatory medicines (NSAIMs)', 'acetylsalicylic acid', NULL),
(27, 'acetylsalicylic acid + simvastatin + ramipril + atenolol + hydrochlorothiazide', NULL, NULL, NULL, NULL, NULL, 0.00, 0.00, 0, 0, '2026-06-19 10:04:12', '2026-06-19 10:04:12', NULL, NULL, NULL, 'Oral > Solid > tablet: 100 mg + 20 mg + 5 mg + 50 mg + 12.5 mg', 0.00, 0, 0, NULL, 0, 10, 'generic', 'Fixed-dose combinations for prevention of atherosclerotic cardiovascular disease', 'acetylsalicylic acid + simvastatin + ramipril + atenolol + hydrochlorothiazide', NULL),
(28, 'acetylsalicylic acid + simvastatin + ramipril + atenolol + hydrochlorothiazide', NULL, NULL, NULL, NULL, NULL, 0.00, 0.00, 0, 0, '2026-06-19 10:04:12', '2026-06-19 10:04:12', NULL, NULL, NULL, 'Oral > Solid > tablet: 100 mg + 20 mg + 5 mg + 50 mg + 12.5 mg', 0.00, 0, 0, NULL, 0, 10, 'generic', 'Fixed-dose combinations for prevention of atherosclerotic cardiovascular disease', 'acetylsalicylic acid + simvastatin + ramipril + atenolol + hydrochlorothiazide', NULL),
(29, 'acetylsalicylic acid + simvastatin + ramipril + atenolol + hydrochlorothiazide', NULL, NULL, NULL, NULL, NULL, 0.00, 0.00, 0, 0, '2026-06-19 10:04:12', '2026-06-19 10:04:12', NULL, NULL, NULL, 'Oral > Solid > tablet: 100 mg + 20 mg + 5 mg + 50 mg + 12.5 mg', 0.00, 0, 0, NULL, 0, 10, 'generic', 'Fixed-dose combinations for prevention of atherosclerotic cardiovascular disease', 'acetylsalicylic acid + simvastatin + ramipril + atenolol + hydrochlorothiazide', NULL),
(30, 'aciclovir', NULL, NULL, NULL, NULL, NULL, 0.00, 0.00, 0, 0, '2026-06-19 10:04:12', '2026-06-19 10:04:12', NULL, NULL, NULL, 'Local > Ophthalmological > Ointment: 3% w/w', 0.00, 0, 0, NULL, 0, 10, 'generic', 'Ophthalmological preparations > Anti-infective agents', 'aciclovir', NULL),
(31, 'aclidinium', NULL, NULL, NULL, NULL, NULL, 0.00, 0.00, 0, 0, '2026-06-19 10:04:12', '2026-06-19 10:04:12', NULL, NULL, NULL, NULL, 0.00, 0, 0, NULL, 0, 10, 'generic', 'Antiasthmatic and medicines for chronic obstructive pulmonary disease', 'aclidinium', NULL),
(32, 'activated charcoal', NULL, NULL, NULL, NULL, NULL, 0.00, 0.00, 0, 0, '2026-06-19 10:04:12', '2026-06-19 10:04:12', NULL, NULL, NULL, 'Oral > Liquid: 50 mg granules for oral suspension', 0.00, 0, 0, NULL, 0, 10, 'generic', 'Antidotes and other substances used in poisonings > Non-specific', 'activated charcoal', NULL),
(33, 'afatinib', NULL, NULL, NULL, NULL, NULL, 0.00, 0.00, 0, 0, '2026-06-19 10:04:12', '2026-06-19 10:04:12', NULL, NULL, NULL, NULL, 0.00, 0, 0, NULL, 0, 10, 'generic', 'Targeted therapies', 'afatinib', NULL),
(34, 'albendazole', NULL, NULL, NULL, NULL, NULL, 0.00, 0.00, 0, 0, '2026-06-19 10:04:12', '2026-06-19 10:04:12', NULL, NULL, NULL, 'Oral > Solid > tablet: 400 mg (chewable, scored)', 0.00, 0, 0, NULL, 0, 10, 'generic', 'Intestinal anthelminthics', 'albendazole', NULL),
(35, 'albendazole', NULL, NULL, NULL, NULL, NULL, 0.00, 0.00, 0, 0, '2026-06-19 10:04:12', '2026-06-19 10:04:12', NULL, NULL, NULL, 'Oral > Solid > tablet: 400 mg (chewable, scored)', 0.00, 0, 0, NULL, 0, 10, 'generic', 'Intestinal anthelminthics', 'albendazole', NULL),
(36, 'albendazole', NULL, NULL, NULL, NULL, NULL, 0.00, 0.00, 0, 0, '2026-06-19 10:04:12', '2026-06-19 10:04:12', NULL, NULL, NULL, 'Oral > Solid > tablet: 400 mg (chewable, scored)', 0.00, 0, 0, NULL, 0, 10, 'generic', 'Intestinal anthelminthics', 'albendazole', NULL),
(37, 'albendazole', NULL, NULL, NULL, NULL, NULL, 0.00, 0.00, 0, 0, '2026-06-19 10:04:12', '2026-06-19 10:04:12', NULL, NULL, NULL, 'Oral > Solid > tablet: 400 mg (chewable, scored)', 0.00, 0, 0, NULL, 0, 10, 'generic', 'Intestinal anthelminthics', 'albendazole', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `purchases`
--

CREATE TABLE `purchases` (
  `id` int(11) NOT NULL,
  `purchase_number` varchar(100) DEFAULT NULL,
  `supplier_id` int(11) NOT NULL,
  `subtotal` decimal(10,2) DEFAULT 0.00,
  `tax` decimal(10,2) DEFAULT 0.00,
  `discount` decimal(10,2) DEFAULT 0.00,
  `total` decimal(10,2) DEFAULT 0.00,
  `payment_status` varchar(50) DEFAULT 'pending',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `order_status` varchar(50) DEFAULT 'draft',
  `supplier_invoice_number` varchar(100) DEFAULT NULL,
  `due_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `purchase_items`
--

CREATE TABLE `purchase_items` (
  `id` int(11) NOT NULL,
  `purchase_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_cost` decimal(10,2) DEFAULT 0.00,
  `total_cost` decimal(10,2) DEFAULT 0.00,
  `expiry_date` date DEFAULT NULL,
  `batch_number` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `purchase_receivings`
--

CREATE TABLE `purchase_receivings` (
  `id` int(11) NOT NULL,
  `purchase_id` int(11) NOT NULL,
  `received_by` int(11) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `purchase_receiving_items`
--

CREATE TABLE `purchase_receiving_items` (
  `id` int(11) NOT NULL,
  `receiving_id` int(11) NOT NULL,
  `purchase_item_id` int(11) NOT NULL,
  `quantity_received` int(11) NOT NULL,
  `batch_number` varchar(100) DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `returns`
--

CREATE TABLE `returns` (
  `id` int(11) NOT NULL,
  `return_type` varchar(100) NOT NULL,
  `reference_type` varchar(100) DEFAULT NULL,
  `reference_id` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `total_amount` decimal(10,2) DEFAULT 0.00,
  `refund_type` varchar(100) DEFAULT NULL,
  `reason` text NOT NULL,
  `processed_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `return_items`
--

CREATE TABLE `return_items` (
  `id` int(11) NOT NULL,
  `return_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `batch_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` decimal(10,2) DEFAULT 0.00,
  `restocked` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `role_permissions`
--

CREATE TABLE `role_permissions` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `sales`
--

CREATE TABLE `sales` (
  `id` int(11) NOT NULL,
  `invoice_number` varchar(100) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `subtotal` decimal(10,2) DEFAULT 0.00,
  `discount` decimal(10,2) DEFAULT 0.00,
  `tax` decimal(10,2) DEFAULT 0.00,
  `total` decimal(10,2) DEFAULT 0.00,
  `payment_status` varchar(50) DEFAULT 'pending',
  `sale_status` varchar(50) DEFAULT 'completed',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `currency_mode` varchar(20) DEFAULT NULL,
  `exchange_rate` decimal(10,2) DEFAULT NULL,
  `amount_received_usd` decimal(10,2) DEFAULT 0.00,
  `amount_received_cdf` decimal(10,2) DEFAULT 0.00,
  `change_usd` decimal(10,2) DEFAULT 0.00,
  `change_cdf` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `sales`
--

INSERT INTO `sales` (`id`, `invoice_number`, `customer_id`, `user_id`, `subtotal`, `discount`, `tax`, `total`, `payment_status`, `sale_status`, `notes`, `created_at`, `currency_mode`, `exchange_rate`, `amount_received_usd`, `amount_received_cdf`, `change_usd`, `change_cdf`) VALUES
(1, 'INV-20260604-9313', NULL, NULL, 2012.00, 0.00, 0.00, 2012.00, 'paid', 'completed', NULL, '2026-06-04 20:51:38', NULL, NULL, 0.00, 0.00, 0.00, 0.00),
(2, 'INV-20260604-9326', NULL, NULL, 2012.00, 0.00, 0.00, 2012.00, 'paid', 'completed', NULL, '2026-06-04 21:10:25', NULL, NULL, 0.00, 0.00, 0.00, 0.00),
(3, 'INV-20260607-8193', NULL, NULL, 84.00, 0.00, 0.00, 84.00, 'paid', 'completed', NULL, '2026-06-07 17:51:43', NULL, NULL, 0.00, 0.00, 0.00, 0.00),
(4, 'INV-20260610-5593', NULL, NULL, 96.00, 0.00, 0.00, 96.00, 'paid', 'completed', NULL, '2026-06-10 04:59:16', NULL, NULL, 0.00, 0.00, 0.00, 0.00),
(5, 'INV-20260610-1198', NULL, NULL, 68.00, 0.00, 0.00, 68.00, 'paid', 'completed', NULL, '2026-06-10 05:01:06', NULL, NULL, 0.00, 0.00, 0.00, 0.00),
(6, 'INV-20260610-7991', NULL, NULL, 60.00, 0.00, 0.00, 60.00, 'paid', 'completed', NULL, '2026-06-10 05:34:12', NULL, NULL, 0.00, 0.00, 0.00, 0.00),
(7, 'INV-20260610-4650', NULL, NULL, 20.00, 0.00, 0.00, 20.00, 'paid', 'completed', NULL, '2026-06-10 05:35:01', NULL, NULL, 0.00, 0.00, 0.00, 0.00),
(8, 'INV-20260610-6105', NULL, 1, 20.00, 0.00, 0.00, 20.00, 'paid', 'completed', NULL, '2026-06-10 05:38:22', NULL, NULL, 0.00, 0.00, 0.00, 0.00),
(9, 'INV-20260610-4501', NULL, 1, 40.00, 0.00, 0.00, 40.00, 'paid', 'completed', NULL, '2026-06-10 05:38:47', NULL, NULL, 0.00, 0.00, 0.00, 0.00),
(10, 'INV-20260610-1425', NULL, NULL, 40.00, 0.00, 0.00, 40.00, 'paid', 'completed', NULL, '2026-06-10 05:41:04', NULL, NULL, 0.00, 0.00, 0.00, 0.00),
(11, 'INV-20260610-9295', NULL, NULL, 32.00, 0.00, 0.00, 32.00, 'paid', 'completed', NULL, '2026-06-10 05:41:46', NULL, NULL, 0.00, 0.00, 0.00, 0.00),
(12, 'INV-20260610-2415', NULL, NULL, 32.00, 0.00, 0.00, 32.00, 'paid', 'completed', NULL, '2026-06-10 05:42:54', NULL, NULL, 0.00, 0.00, 0.00, 0.00),
(13, 'INV-20260610-7236', NULL, NULL, 32.00, 0.00, 0.00, 32.00, 'paid', 'completed', NULL, '2026-06-10 05:43:53', NULL, NULL, 0.00, 0.00, 0.00, 0.00),
(14, 'INV-20260610-8621', NULL, NULL, 32.00, 0.00, 0.00, 32.00, 'paid', 'completed', NULL, '2026-06-10 05:46:51', NULL, NULL, 0.00, 0.00, 0.00, 0.00),
(15, 'INV-20260610-1555', NULL, NULL, 20.00, 0.00, 0.00, 20.00, 'paid', 'completed', NULL, '2026-06-10 07:39:01', NULL, NULL, 0.00, 0.00, 0.00, 0.00),
(16, 'INV-20260610-3892', NULL, NULL, 20.00, 0.00, 0.00, 20.00, 'paid', 'completed', NULL, '2026-06-10 07:56:05', NULL, NULL, 0.00, 0.00, 0.00, 0.00),
(17, 'INV-20260610-1125', NULL, NULL, 60.00, 0.00, 0.00, 60.00, 'paid', 'completed', NULL, '2026-06-10 07:56:44', NULL, NULL, 0.00, 0.00, 0.00, 0.00),
(18, 'INV-20260619-7665', NULL, NULL, 40.00, 0.00, 6.40, 46.40, 'paid', 'completed', NULL, '2026-06-19 14:05:20', NULL, NULL, 0.00, 0.00, 0.00, 0.00),
(19, 'INV-20260619-4709', NULL, NULL, 40.00, 0.00, 6.40, 46.40, 'paid', 'completed', NULL, '2026-06-19 14:05:55', NULL, NULL, 0.00, 0.00, 0.00, 0.00),
(20, 'INV-20260619-6922', NULL, NULL, 40.00, 0.00, 6.40, 46.40, 'paid', 'completed', NULL, '2026-06-19 14:06:17', NULL, NULL, 0.00, 0.00, 0.00, 0.00),
(21, 'INV-20260619-1996', NULL, NULL, 40.00, 0.00, 6.40, 46.40, 'paid', 'completed', NULL, '2026-06-19 14:06:35', NULL, NULL, 0.00, 0.00, 0.00, 0.00),
(22, 'INV-20260620-1462', NULL, NULL, 40.00, 0.00, 0.00, 40.00, 'paid', 'completed', NULL, '2026-06-20 11:56:54', NULL, NULL, 0.00, 0.00, 0.00, 0.00),
(23, 'INV-20260620-1360', NULL, NULL, 40.00, 0.00, 0.00, 40.00, 'paid', 'completed', NULL, '2026-06-20 11:56:58', NULL, NULL, 0.00, 0.00, 0.00, 0.00),
(24, 'INV-20260622-6484', NULL, NULL, 40.00, 0.00, 0.00, 40.00, 'paid', 'completed', NULL, '2026-06-21 22:49:45', NULL, NULL, 0.00, 0.00, 0.00, 0.00),
(25, 'INV-20260622-8364', NULL, NULL, 40.00, 0.00, 0.00, 40.00, 'paid', 'completed', NULL, '2026-06-21 22:49:54', NULL, NULL, 0.00, 0.00, 0.00, 0.00),
(26, 'INV-20260622-6836', NULL, NULL, 20.00, 0.00, 0.00, 20.00, 'paid', 'completed', NULL, '2026-06-21 23:37:46', NULL, NULL, 0.00, 0.00, 0.00, 0.00),
(27, 'INV-20260622-6964', NULL, NULL, 40.00, 0.00, 0.00, 40.00, 'paid', 'completed', NULL, '2026-06-22 06:18:39', NULL, NULL, 0.00, 0.00, 0.00, 0.00),
(28, 'INV-20260622-8776', NULL, NULL, 40.00, 0.00, 0.00, 40.00, 'paid', 'completed', NULL, '2026-06-22 06:18:43', NULL, NULL, 0.00, 0.00, 0.00, 0.00),
(29, 'INV-20260622-2934', NULL, NULL, 40.00, 0.00, 0.00, 40.00, 'paid', 'completed', NULL, '2026-06-22 06:18:43', NULL, NULL, 0.00, 0.00, 0.00, 0.00),
(30, 'INV-20260622-8902', NULL, NULL, 40.00, 0.00, 0.00, 40.00, 'paid', 'completed', NULL, '2026-06-22 06:24:13', NULL, NULL, 0.00, 0.00, 0.00, 0.00),
(31, 'INV-20260622-7169', NULL, NULL, 40.00, 0.00, 0.00, 40.00, 'paid', 'completed', NULL, '2026-06-22 06:24:17', NULL, NULL, 0.00, 0.00, 0.00, 0.00),
(32, 'INV-20260622-5787', NULL, NULL, 40.00, 0.00, 0.00, 40.00, 'paid', 'completed', NULL, '2026-06-22 06:36:57', NULL, NULL, 0.00, 0.00, 0.00, 0.00),
(33, 'INV-20260622-5219', NULL, NULL, 40.00, 0.00, 0.00, 40.00, 'paid', 'completed', NULL, '2026-06-22 06:40:25', NULL, NULL, 0.00, 0.00, 0.00, 0.00),
(34, 'INV-20260622-6842', 3, NULL, 40.00, 0.00, 0.00, 40.00, 'paid', 'completed', NULL, '2026-06-22 06:46:29', NULL, NULL, 0.00, 0.00, 0.00, 0.00),
(35, 'INV-20260622-7606', 4, NULL, 20.00, 0.00, 0.00, 20.00, 'paid', 'completed', NULL, '2026-06-22 06:46:58', NULL, NULL, 0.00, 0.00, 0.00, 0.00),
(36, 'INV-20260622-5059', 4, NULL, 20.00, 0.00, 0.00, 20.00, 'paid', 'completed', NULL, '2026-06-22 06:56:46', NULL, NULL, 0.00, 0.00, 0.00, 0.00),
(37, 'INV-20260622-7742', 4, NULL, 20.00, 0.00, 0.00, 20.00, 'paid', 'completed', NULL, '2026-06-22 07:06:47', NULL, NULL, 0.00, 0.00, 0.00, 0.00),
(38, 'INV-20260622-4299', 5, NULL, 40.00, 0.00, 0.00, 40.00, 'paid', 'completed', NULL, '2026-06-22 07:20:44', NULL, NULL, 0.00, 0.00, 0.00, 0.00),
(39, 'INV-20260622-6843', 6, NULL, 40.00, 0.00, 0.00, 40.00, 'paid', 'completed', NULL, '2026-06-22 07:22:34', NULL, NULL, 0.00, 0.00, 0.00, 0.00),
(40, 'INV-20260622-4323', 7, NULL, 21.75, 0.00, 0.00, 21.75, 'paid', 'completed', NULL, '2026-06-22 11:59:23', NULL, NULL, 0.00, 0.00, 0.00, 0.00),
(41, 'INV-20260622-8239', 8, NULL, 1.75, 0.00, 0.00, 1.75, 'paid', 'completed', NULL, '2026-06-22 12:03:24', NULL, NULL, 0.00, 0.00, 0.00, 0.00),
(42, 'INV-20260622-6740', 9, NULL, 20.00, 0.00, 0.00, 20.00, 'paid', 'completed', NULL, '2026-06-22 12:10:58', NULL, NULL, 0.00, 0.00, 0.00, 0.00),
(43, 'INV-20260622-1366', 10, NULL, 10.50, 0.00, 0.00, 10.50, 'paid', 'completed', NULL, '2026-06-22 12:23:18', NULL, NULL, 0.00, 0.00, 0.00, 0.00),
(44, 'INV-20260622-7782', 10, NULL, 10.50, 0.00, 0.00, 10.50, 'paid', 'completed', NULL, '2026-06-22 12:23:20', NULL, NULL, 0.00, 0.00, 0.00, 0.00),
(45, 'INV-20260622-1095', 10, NULL, 10.50, 0.00, 0.00, 10.50, 'paid', 'completed', NULL, '2026-06-22 12:23:21', NULL, NULL, 0.00, 0.00, 0.00, 0.00),
(46, 'INV-20260622-4852', 10, NULL, 10.50, 0.00, 0.00, 10.50, 'paid', 'completed', NULL, '2026-06-22 12:23:21', NULL, NULL, 0.00, 0.00, 0.00, 0.00),
(47, 'INV-20260622-7622', 10, NULL, 10.50, 0.00, 0.00, 10.50, 'paid', 'completed', NULL, '2026-06-22 12:25:35', NULL, NULL, 0.00, 0.00, 0.00, 0.00),
(48, 'INV-20260622-6060', 11, NULL, 17.50, 0.00, 0.00, 17.50, 'paid', 'completed', NULL, '2026-06-22 12:26:42', NULL, NULL, 0.00, 0.00, 0.00, 0.00),
(49, 'INV-20260622-1931', 11, NULL, 17.50, 0.00, 0.00, 17.50, 'paid', 'completed', NULL, '2026-06-22 12:26:49', NULL, NULL, 0.00, 0.00, 0.00, 0.00),
(50, 'INV-20260622-9747', 11, NULL, 17.50, 0.00, 0.00, 17.50, 'paid', 'completed', NULL, '2026-06-22 12:26:51', NULL, NULL, 0.00, 0.00, 0.00, 0.00),
(51, 'INV-20260622-2766', 12, NULL, 17.50, 0.00, 0.00, 17.50, 'paid', 'completed', NULL, '2026-06-22 12:28:32', NULL, NULL, 0.00, 0.00, 0.00, 0.00),
(52, 'INV-20260622-6988', 13, NULL, 32.25, 0.00, 0.00, 32.25, 'paid', 'completed', NULL, '2026-06-22 15:23:50', 'USD', 2350.00, 40.00, 0.00, 7.75, 18212.50),
(53, 'INV-20260622-9247', 14, NULL, 14.00, 0.00, 0.00, 14.00, 'paid', 'completed', NULL, '2026-06-22 15:25:00', 'USD', 2350.00, 20.00, 0.00, 6.00, 14100.00),
(54, 'INV-20260622-9408', 14, NULL, 14.00, 0.00, 0.00, 14.00, 'paid', 'completed', NULL, '2026-06-22 15:25:06', 'USD', 2350.00, 20.00, 0.00, 6.00, 14100.00),
(55, 'INV-20260622-9135', 14, NULL, 14.00, 0.00, 0.00, 14.00, 'paid', 'completed', NULL, '2026-06-22 15:25:06', 'USD', 2350.00, 20.00, 0.00, 6.00, 14100.00),
(56, 'INV-20260622-5193', 14, NULL, 14.00, 0.00, 0.00, 14.00, 'paid', 'completed', NULL, '2026-06-22 15:25:07', 'USD', 2350.00, 20.00, 0.00, 6.00, 14100.00),
(57, 'INV-20260622-9092', 14, NULL, 14.00, 0.00, 0.00, 14.00, 'paid', 'completed', NULL, '2026-06-22 15:25:07', 'USD', 2350.00, 20.00, 0.00, 6.00, 14100.00),
(58, 'INV-20260622-7770', 14, NULL, 14.00, 0.00, 0.00, 14.00, 'paid', 'completed', NULL, '2026-06-22 15:25:07', 'USD', 2350.00, 20.00, 0.00, 6.00, 14100.00),
(59, 'INV-20260622-6268', 14, NULL, 14.00, 0.00, 0.00, 14.00, 'paid', 'completed', NULL, '2026-06-22 15:25:07', 'USD', 2350.00, 20.00, 0.00, 6.00, 14100.00),
(60, 'INV-20260622-1546', 15, NULL, 14.00, 0.00, 0.00, 14.00, 'paid', 'completed', NULL, '2026-06-22 15:41:40', 'USD', 2350.00, 20.00, 0.00, 6.00, 14100.00);

-- --------------------------------------------------------

--
-- Structure de la table `sale_items`
--

CREATE TABLE `sale_items` (
  `id` int(11) NOT NULL,
  `sale_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `batch_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT 1,
  `unit_price` decimal(10,2) DEFAULT 0.00,
  `total_price` decimal(10,2) DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `sale_items`
--

INSERT INTO `sale_items` (`id`, `sale_id`, `product_id`, `batch_id`, `quantity`, `unit_price`, `total_price`, `created_at`) VALUES
(1, 2, 1, NULL, 1, 2000.00, 2000.00, '2026-06-04 21:10:25'),
(2, 2, 2, NULL, 1, 12.00, 12.00, '2026-06-04 21:10:25'),
(3, 3, 1, NULL, 3, 20.00, 60.00, '2026-06-07 17:51:43'),
(4, 3, 2, NULL, 2, 12.00, 24.00, '2026-06-07 17:51:43'),
(5, 4, 2, NULL, 3, 12.00, 36.00, '2026-06-10 04:59:17'),
(6, 4, 1, NULL, 3, 20.00, 60.00, '2026-06-10 04:59:17'),
(7, 5, 2, NULL, 4, 12.00, 48.00, '2026-06-10 05:01:06'),
(8, 5, 1, NULL, 1, 20.00, 20.00, '2026-06-10 05:01:06'),
(9, 6, 1, NULL, 3, 20.00, 60.00, '2026-06-10 05:34:13'),
(10, 7, 1, NULL, 1, 20.00, 20.00, '2026-06-10 05:35:01'),
(11, 8, 1, NULL, 1, 20.00, 20.00, '2026-06-10 05:38:22'),
(12, 9, 1, NULL, 2, 20.00, 40.00, '2026-06-10 05:38:47'),
(13, 10, 1, NULL, 2, 20.00, 40.00, '2026-06-10 05:41:04'),
(14, 11, 1, NULL, 1, 20.00, 20.00, '2026-06-10 05:41:46'),
(15, 11, 2, NULL, 1, 12.00, 12.00, '2026-06-10 05:41:46'),
(16, 12, 1, NULL, 1, 20.00, 20.00, '2026-06-10 05:42:54'),
(17, 12, 2, NULL, 1, 12.00, 12.00, '2026-06-10 05:42:54'),
(18, 13, 1, NULL, 1, 20.00, 20.00, '2026-06-10 05:43:53'),
(19, 13, 2, NULL, 1, 12.00, 12.00, '2026-06-10 05:43:53'),
(20, 14, 1, NULL, 1, 20.00, 20.00, '2026-06-10 05:46:51'),
(21, 14, 2, NULL, 1, 12.00, 12.00, '2026-06-10 05:46:51'),
(22, 15, 1, NULL, 1, 20.00, 20.00, '2026-06-10 07:39:01'),
(23, 16, 1, NULL, 1, 20.00, 20.00, '2026-06-10 07:56:05'),
(24, 17, 1, NULL, 3, 20.00, 60.00, '2026-06-10 07:56:44'),
(25, 36, 8, NULL, 1, 20.00, 20.00, '2026-06-22 06:56:46'),
(26, 37, 8, NULL, 1, 20.00, 20.00, '2026-06-22 07:06:47'),
(27, 38, 8, NULL, 2, 20.00, 40.00, '2026-06-22 07:20:44'),
(28, 39, 8, NULL, 2, 20.00, 40.00, '2026-06-22 07:22:34'),
(29, 40, 14, NULL, 1, 1.75, 1.75, '2026-06-22 11:59:23'),
(30, 40, 8, NULL, 1, 20.00, 20.00, '2026-06-22 11:59:23'),
(31, 41, 14, NULL, 1, 1.75, 1.75, '2026-06-22 12:03:24'),
(32, 42, 8, NULL, 1, 20.00, 20.00, '2026-06-22 12:10:58'),
(33, 43, 14, NULL, 6, 1.75, 10.50, '2026-06-22 12:23:18'),
(34, 44, 14, NULL, 6, 1.75, 10.50, '2026-06-22 12:23:20'),
(35, 45, 14, NULL, 6, 1.75, 10.50, '2026-06-22 12:23:21'),
(36, 46, 14, NULL, 6, 1.75, 10.50, '2026-06-22 12:23:21'),
(37, 47, 14, NULL, 6, 1.75, 10.50, '2026-06-22 12:25:35'),
(38, 48, 14, NULL, 10, 1.75, 17.50, '2026-06-22 12:26:42'),
(39, 49, 14, NULL, 10, 1.75, 17.50, '2026-06-22 12:26:50'),
(40, 50, 14, NULL, 10, 1.75, 17.50, '2026-06-22 12:26:51'),
(41, 51, 14, NULL, 10, 1.75, 17.50, '2026-06-22 12:28:32'),
(42, 52, 8, NULL, 1, 20.00, 20.00, '2026-06-22 15:23:50'),
(43, 52, 14, NULL, 7, 1.75, 12.25, '2026-06-22 15:23:50'),
(44, 53, 14, NULL, 8, 1.75, 14.00, '2026-06-22 15:25:00'),
(45, 54, 14, NULL, 8, 1.75, 14.00, '2026-06-22 15:25:06'),
(46, 55, 14, NULL, 8, 1.75, 14.00, '2026-06-22 15:25:06'),
(47, 56, 14, NULL, 8, 1.75, 14.00, '2026-06-22 15:25:07'),
(48, 57, 14, NULL, 8, 1.75, 14.00, '2026-06-22 15:25:07'),
(49, 58, 14, NULL, 8, 1.75, 14.00, '2026-06-22 15:25:07'),
(50, 59, 14, NULL, 8, 1.75, 14.00, '2026-06-22 15:25:07'),
(51, 60, 14, NULL, 8, 1.75, 14.00, '2026-06-22 15:41:40');

-- --------------------------------------------------------

--
-- Structure de la table `sale_payments`
--

CREATE TABLE `sale_payments` (
  `id` int(11) NOT NULL,
  `sale_id` int(11) NOT NULL,
  `payment_method` varchar(100) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT 0.00,
  `transaction_reference` varchar(255) DEFAULT NULL,
  `payment_status` varchar(50) DEFAULT 'paid',
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `sale_payments`
--

INSERT INTO `sale_payments` (`id`, `sale_id`, `payment_method`, `amount`, `transaction_reference`, `payment_status`, `created_at`) VALUES
(1, 2, 'cash', 2012.00, NULL, 'paid', '2026-06-04 21:10:25'),
(2, 3, 'cash', 84.00, NULL, 'paid', '2026-06-07 17:51:43'),
(3, 4, 'cash', 96.00, NULL, 'paid', '2026-06-10 04:59:17'),
(4, 5, 'cash', 68.00, NULL, 'paid', '2026-06-10 05:01:06'),
(5, 6, 'cash', 60.00, NULL, 'paid', '2026-06-10 05:34:13'),
(6, 7, 'cash', 20.00, NULL, 'paid', '2026-06-10 05:35:01'),
(7, 8, 'cash', 20.00, NULL, 'paid', '2026-06-10 05:38:22'),
(8, 9, 'cash', 40.00, NULL, 'paid', '2026-06-10 05:38:47'),
(9, 10, 'cash', 40.00, NULL, 'paid', '2026-06-10 05:41:04'),
(10, 11, 'cash', 32.00, NULL, 'paid', '2026-06-10 05:41:46'),
(11, 12, 'cash', 32.00, NULL, 'paid', '2026-06-10 05:42:54'),
(12, 13, 'cash', 32.00, NULL, 'paid', '2026-06-10 05:43:53'),
(13, 14, 'cash', 32.00, NULL, 'paid', '2026-06-10 05:46:51'),
(14, 15, 'cash', 20.00, NULL, 'paid', '2026-06-10 07:39:01'),
(15, 16, 'cash', 20.00, NULL, 'paid', '2026-06-10 07:56:05'),
(16, 17, 'cash', 60.00, NULL, 'paid', '2026-06-10 07:56:44'),
(17, 36, NULL, 20.00, NULL, 'paid', '2026-06-22 06:56:46'),
(18, 37, 'cash', 20.00, NULL, 'paid', '2026-06-22 07:06:47'),
(19, 38, 'cash', 40.00, NULL, 'paid', '2026-06-22 07:20:44'),
(20, 39, 'cash', 40.00, NULL, 'paid', '2026-06-22 07:22:34'),
(21, 52, 'cash', 32.25, NULL, 'paid', '2026-06-22 15:23:50'),
(22, 53, 'cash', 14.00, NULL, 'paid', '2026-06-22 15:25:00'),
(23, 54, 'cash', 14.00, NULL, 'paid', '2026-06-22 15:25:06'),
(24, 55, 'cash', 14.00, NULL, 'paid', '2026-06-22 15:25:07'),
(25, 56, 'cash', 14.00, NULL, 'paid', '2026-06-22 15:25:07'),
(26, 57, 'cash', 14.00, NULL, 'paid', '2026-06-22 15:25:07'),
(27, 58, 'cash', 14.00, NULL, 'paid', '2026-06-22 15:25:07'),
(28, 59, 'cash', 14.00, NULL, 'paid', '2026-06-22 15:25:07'),
(29, 60, 'cash', 14.00, NULL, 'paid', '2026-06-22 15:41:40');

-- --------------------------------------------------------

--
-- Structure de la table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `setting_key` varchar(150) DEFAULT NULL,
  `setting_value` text DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `settings`
--

INSERT INTO `settings` (`id`, `setting_key`, `setting_value`, `updated_at`) VALUES
(1, 'pharmacy_name', 'MALKEL PHARMA', '2026-06-02 21:54:50'),
(2, 'phone', '+243 974 114 994', '2026-06-02 21:54:51'),
(3, 'email', 'malkel-pharma@gmail.com', '2026-06-02 21:54:51'),
(4, 'address', 'GOLF', '2026-06-02 21:54:51'),
(5, 'primary_currency', 'USD', '2026-06-02 21:54:51'),
(6, 'exchange_rate', '2200', '2026-06-02 21:54:51'),
(7, 'theme_name', 'medical-blue', '2026-06-02 21:54:51');

-- --------------------------------------------------------

--
-- Structure de la table `stock_adjustments`
--

CREATE TABLE `stock_adjustments` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `batch_id` int(11) DEFAULT NULL,
  `adjustment_type` varchar(100) NOT NULL,
  `system_quantity` int(11) NOT NULL,
  `physical_quantity` int(11) NOT NULL,
  `difference_quantity` int(11) NOT NULL,
  `reason` text NOT NULL,
  `adjusted_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `stock_movements`
--

CREATE TABLE `stock_movements` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `batch_id` int(11) DEFAULT NULL,
  `movement_type` varchar(50) NOT NULL,
  `quantity` int(11) NOT NULL,
  `previous_stock` int(11) DEFAULT 0,
  `new_stock` int(11) DEFAULT 0,
  `reference_type` varchar(100) DEFAULT NULL,
  `reference_id` int(11) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `stock_movements`
--

INSERT INTO `stock_movements` (`id`, `product_id`, `batch_id`, `movement_type`, `quantity`, `previous_stock`, `new_stock`, `reference_type`, `reference_id`, `notes`, `created_by`, `created_at`) VALUES
(1, 1, 1, 'purchase', 100, 0, 0, NULL, NULL, 'Stock received', NULL, '2026-06-08 06:46:06'),
(2, 14, 7, 'purchase', 100, 0, 0, NULL, NULL, 'Stock received', NULL, '2026-06-22 08:22:14'),
(3, 14, 7, 'sale', 1, 0, 0, NULL, NULL, 'FEFO deduction', NULL, '2026-06-22 11:59:23'),
(4, 14, 7, 'sale', 1, 0, 0, NULL, NULL, 'FEFO deduction', NULL, '2026-06-22 12:03:24'),
(5, 14, 7, 'sale', 6, 0, 0, NULL, NULL, 'FEFO deduction', NULL, '2026-06-22 12:23:18'),
(6, 14, 7, 'sale', 6, 0, 0, NULL, NULL, 'FEFO deduction', NULL, '2026-06-22 12:23:20'),
(7, 14, 7, 'sale', 6, 0, 0, NULL, NULL, 'FEFO deduction', NULL, '2026-06-22 12:23:21'),
(8, 14, 7, 'sale', 6, 0, 0, NULL, NULL, 'FEFO deduction', NULL, '2026-06-22 12:23:21'),
(9, 14, 7, 'sale', 6, 0, 0, NULL, NULL, 'FEFO deduction', NULL, '2026-06-22 12:25:35'),
(10, 14, 7, 'sale', 10, 0, 0, NULL, NULL, 'FEFO deduction', NULL, '2026-06-22 12:26:42'),
(11, 14, 7, 'sale', 10, 0, 0, NULL, NULL, 'FEFO deduction', NULL, '2026-06-22 12:26:50'),
(12, 14, 7, 'sale', 10, 0, 0, NULL, NULL, 'FEFO deduction', NULL, '2026-06-22 12:26:51'),
(13, 14, 7, 'sale', 10, 0, 0, NULL, NULL, 'FEFO deduction', NULL, '2026-06-22 12:28:32'),
(14, 14, 7, 'sale', 7, 0, 0, NULL, NULL, 'FEFO deduction', NULL, '2026-06-22 15:23:50'),
(15, 14, 7, 'sale', 8, 0, 0, NULL, NULL, 'FEFO deduction', NULL, '2026-06-22 15:25:00'),
(16, 14, 7, 'sale', 8, 0, 0, NULL, NULL, 'FEFO deduction', NULL, '2026-06-22 15:25:06'),
(17, 14, 7, 'sale', 8, 0, 0, NULL, NULL, 'FEFO deduction', NULL, '2026-06-22 15:25:06'),
(18, 14, 7, 'sale', 8, 0, 0, NULL, NULL, 'FEFO deduction', NULL, '2026-06-22 15:25:07'),
(19, 14, 7, 'sale', 8, 0, 0, NULL, NULL, 'FEFO deduction', NULL, '2026-06-22 15:25:07'),
(20, 14, 7, 'sale', 8, 0, 0, NULL, NULL, 'FEFO deduction', NULL, '2026-06-22 15:25:07'),
(21, 14, 7, 'sale', 8, 0, 0, NULL, NULL, 'FEFO deduction', NULL, '2026-06-22 15:25:07'),
(22, 14, 7, 'sale', 8, 0, 0, NULL, NULL, 'FEFO deduction', NULL, '2026-06-22 15:41:40');

-- --------------------------------------------------------

--
-- Structure de la table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` int(11) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `contact_name` varchar(255) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `suppliers`
--

INSERT INTO `suppliers` (`id`, `company_name`, `contact_name`, `phone`, `email`, `address`, `notes`, `created_at`) VALUES
(1, 'TZ Pharmacie', 'ENOCH MWALIMU', '0995205331', 'enochmwalimu64@gmail.com', 'KABULAMENSHI\r\nTSHINYAMA', '', '2026-06-09 08:20:53');

-- --------------------------------------------------------

--
-- Structure de la table `supplier_payments`
--

CREATE TABLE `supplier_payments` (
  `id` int(11) NOT NULL,
  `purchase_id` int(11) NOT NULL,
  `payment_method` varchar(100) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_reference` varchar(255) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `paid_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(100) NOT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `full_name`, `email`, `password`, `role`, `is_active`, `created_at`) VALUES
(1, 'MARKEL Administrator', 'admin@markel.local', 'Kool2004', 'admin', 1, '2026-05-30 00:30:04');

-- --------------------------------------------------------

--
-- Structure de la table `user_sessions`
--

CREATE TABLE `user_sessions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `session_token` varchar(255) DEFAULT NULL,
  `ip_address` varchar(100) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `last_activity` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `dosage_forms`
--
ALTER TABLE `dosage_forms`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `inventory_batches`
--
ALTER TABLE `inventory_batches`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `migration` (`migration`);

--
-- Index pour la table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `packaging_units`
--
ALTER TABLE `packaging_units`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Index pour la table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sku` (`sku`);

--
-- Index pour la table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `purchase_number` (`purchase_number`);

--
-- Index pour la table `purchase_items`
--
ALTER TABLE `purchase_items`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `purchase_receivings`
--
ALTER TABLE `purchase_receivings`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `purchase_receiving_items`
--
ALTER TABLE `purchase_receiving_items`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `returns`
--
ALTER TABLE `returns`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `return_items`
--
ALTER TABLE `return_items`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Index pour la table `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `invoice_number` (`invoice_number`);

--
-- Index pour la table `sale_items`
--
ALTER TABLE `sale_items`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `sale_payments`
--
ALTER TABLE `sale_payments`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `setting_key` (`setting_key`);

--
-- Index pour la table `stock_adjustments`
--
ALTER TABLE `stock_adjustments`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `stock_movements`
--
ALTER TABLE `stock_movements`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `supplier_payments`
--
ALTER TABLE `supplier_payments`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Index pour la table `user_sessions`
--
ALTER TABLE `user_sessions`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `audit_logs`
--
ALTER TABLE `audit_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT pour la table `dosage_forms`
--
ALTER TABLE `dosage_forms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table `inventory_batches`
--
ALTER TABLE `inventory_batches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT pour la table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `packaging_units`
--
ALTER TABLE `packaging_units`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT pour la table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `purchase_items`
--
ALTER TABLE `purchase_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `purchase_receivings`
--
ALTER TABLE `purchase_receivings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `purchase_receiving_items`
--
ALTER TABLE `purchase_receiving_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `returns`
--
ALTER TABLE `returns`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `return_items`
--
ALTER TABLE `return_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `role_permissions`
--
ALTER TABLE `role_permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT pour la table `sale_items`
--
ALTER TABLE `sale_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT pour la table `sale_payments`
--
ALTER TABLE `sale_payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT pour la table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT pour la table `stock_adjustments`
--
ALTER TABLE `stock_adjustments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `stock_movements`
--
ALTER TABLE `stock_movements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT pour la table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `supplier_payments`
--
ALTER TABLE `supplier_payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `user_sessions`
--
ALTER TABLE `user_sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
