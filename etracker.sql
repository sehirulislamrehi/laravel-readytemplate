-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 06, 2024 at 07:22 PM
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
-- Database: `etracker`
--

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
(1, '0001_01_01_000001_create_cache_table', 1),
(2, '0001_01_01_000002_create_jobs_table', 1),
(3, '2014_10_12_000000_create_users_table', 1),
(4, '2021_04_24_161700_create_modules_table', 1),
(5, '2021_04_24_161711_create_permissions_table', 1),
(6, '2021_04_24_161733_create_roles_table', 1),
(7, '2021_04_24_161734_create_permission_roles_table', 1),
(8, '2021_04_24_161742_create_sub_modules_table', 1),
(9, '2024_04_09_095226_create_sessions_table', 1),
(10, '2024_10_05_074454_create_tasks_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

CREATE TABLE `modules` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `key` varchar(255) NOT NULL,
  `icon` varchar(255) NOT NULL,
  `position` int(11) NOT NULL,
  `route` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `modules`
--

INSERT INTO `modules` (`id`, `name`, `key`, `icon`, `position`, `route`, `created_at`, `updated_at`) VALUES
(1, 'User Module', 'user_module', 'fas fa-users', 1, NULL, NULL, NULL),
(2, 'Task Module', 'task_module', 'fas fa-tasks', 2, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(255) NOT NULL,
  `display_name` varchar(255) NOT NULL,
  `module_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `key`, `display_name`, `module_id`, `created_at`, `updated_at`) VALUES
(1, 'user_module', 'User Module', 1, NULL, NULL),
(2, 'all_user', 'All User', 1, NULL, NULL),
(3, 'add_user', '-- Add User', 1, NULL, NULL),
(4, 'edit_user', '-- Edit User', 1, NULL, NULL),
(5, 'reset_password', '-- Reset Password', 1, NULL, NULL),
(6, 'task_module', 'Task Module', 2, NULL, NULL),
(7, 'task_list', 'Task List', 2, NULL, NULL),
(8, 'add_task', '-- Add Task', 2, NULL, NULL),
(9, 'edit_task', '-- Edit Task', 2, NULL, NULL),
(10, 'delete_task', '-- Delete Task', 2, NULL, NULL),
(11, 'roles', 'Roles', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `permission_role`
--

CREATE TABLE `permission_role` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permission_role`
--

INSERT INTO `permission_role` (`id`, `role_id`, `permission_id`, `created_at`, `updated_at`) VALUES
(124, 1, 1, '2024-10-06 11:21:21', '2024-10-06 11:21:21'),
(125, 1, 2, '2024-10-06 11:21:21', '2024-10-06 11:21:21'),
(126, 1, 3, '2024-10-06 11:21:21', '2024-10-06 11:21:21'),
(127, 1, 4, '2024-10-06 11:21:21', '2024-10-06 11:21:21'),
(128, 1, 5, '2024-10-06 11:21:21', '2024-10-06 11:21:21'),
(129, 1, 6, '2024-10-06 11:21:21', '2024-10-06 11:21:21'),
(130, 1, 7, '2024-10-06 11:21:21', '2024-10-06 11:21:21'),
(131, 1, 8, '2024-10-06 11:21:21', '2024-10-06 11:21:21'),
(132, 1, 9, '2024-10-06 11:21:21', '2024-10-06 11:21:21'),
(133, 1, 10, '2024-10-06 11:21:21', '2024-10-06 11:21:21');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 1, '2024-10-06 09:03:26', '2024-10-06 09:03:26');

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
('62oSclwIfg7uuhkes8vepNOFsoU6moLMSRVRvjnx', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiOXRKWHdOYTJvQWVIVUlMVTVMbXVpNnlqQ0pJdXFzQmZWc2dvNHFwSCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6OTk6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbmRhc2hib2FyZC9yZXBvcnQtbW9kdWxlL2Rhc2hib2FyZC1yZXBvcnQvaGlnaGVzdC1hdmVyYWdlLXRpbWUtdGFrZW4tdXNlciI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1728235356),
('TWY3MeNn9ltV6k02ugsW1w49NMfb4UGJm7f4V4Td', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36 Edg/129.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZlVWVFlWSnhJQXVsb2hMUERJTE1RUXdPc29SUm9WeXAyTEE2NFQwaSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6OTk6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbmRhc2hib2FyZC9yZXBvcnQtbW9kdWxlL2Rhc2hib2FyZC1yZXBvcnQvaGlnaGVzdC1hdmVyYWdlLXRpbWUtdGFrZW4tdXNlciI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI7fQ==', 1728235323);

-- --------------------------------------------------------

--
-- Table structure for table `sub_modules`
--

CREATE TABLE `sub_modules` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `key` varchar(255) NOT NULL,
  `position` int(11) NOT NULL,
  `route` varchar(255) NOT NULL,
  `module_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sub_modules`
--

INSERT INTO `sub_modules` (`id`, `name`, `key`, `position`, `route`, `module_id`, `created_at`, `updated_at`) VALUES
(1, 'All User', 'all_user', 1, 'user.all', 1, NULL, NULL),
(2, 'Roles', 'roles', 2, 'role.all', 1, NULL, NULL),
(3, 'Task List', 'task_list', 1, 'task.all', 2, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `status` enum('Pending','In-Progress','Complete') NOT NULL COMMENT 'Pending,In-Progress,Complete',
  `start_date` date NOT NULL,
  `due_date` date NOT NULL,
  `time_taken` varchar(255) NOT NULL DEFAULT '0' COMMENT 'value stored in sec.',
  `assigned_to` bigint(20) UNSIGNED NOT NULL,
  `assigned_by` bigint(20) UNSIGNED NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `name`, `description`, `status`, `start_date`, `due_date`, `time_taken`, `assigned_to`, `assigned_by`, `image`, `created_at`, `updated_at`) VALUES
(1, 'Add to cart functionality', 'Add to cart functionality', 'Complete', '2024-10-05', '2024-10-06', '86400', 1, 1, NULL, '2024-10-06 09:18:43', '2024-10-06 11:08:13'),
(2, 'Order Place functionality', 'Order Place functionality', 'Complete', '2024-10-03', '2024-10-05', '172800', 3, 1, NULL, '2024-10-06 09:19:07', '2024-10-06 11:15:32'),
(3, 'APP ui development', 'APP ui development', 'Complete', '2024-10-01', '2024-10-02', '86400', 2, 1, '25272_1728228019.jpg', '2024-10-06 09:19:27', '2024-10-06 11:07:17'),
(4, 'APP search function', 'APP search function', 'Pending', '2024-10-01', '2024-10-04', '259200', 4, 1, NULL, '2024-10-06 09:19:45', '2024-10-06 11:07:08');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role_id` bigint(20) UNSIGNED DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `is_super_admin` tinyint(1) NOT NULL DEFAULT 0,
  `remember_token` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `image`, `password`, `role_id`, `is_active`, `is_super_admin`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Md. Sehirul Islam Rehi', 'mdsehirulislamrehi@gmail.com', '01858361812', NULL, '$2y$12$/5V2XRxGxhuQt.UXaoQAXOoJuPOnjNWRVISJsTK3FdmlVIxlIh6py', NULL, 1, 1, NULL, NULL, NULL),
(2, 'Forkan', 'forkan@gmail.com', '11111111111', NULL, '$2y$12$DPkWYHyJxvLV9aYOYsu0pOlmBtWE6LmFAHssYnMbUbz1SnP6O2I3e', 1, 1, 0, 'J1EB6YoBn1H0iVlD9yi4uPCVHkqeTrqIYBtFzwIJKIkBiCYDtmzFf28n7qgP', '2024-10-06 09:03:44', '2024-10-06 09:03:44'),
(3, 'Hasan', 'hasan@gmail.com', '11111111111', NULL, '$2y$12$bjn/z/zlNa18CP1IGWaiZ./wPvKkX5NHJsmMwjmp8c810P54FqQV.', 1, 1, 0, NULL, '2024-10-06 09:03:50', '2024-10-06 09:03:50'),
(4, 'Shuvo', 'shuvo@gmail.com', '11111111111', NULL, '$2y$12$2ThjUfO9uQKeDZJWmCdCWeyDp9/hQO0G7xkLMn4yw0EqoC5Np./pa', 1, 1, 0, NULL, '2024-10-06 09:03:58', '2024-10-06 09:03:58');

--
-- Indexes for dumped tables
--

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
-- Indexes for table `modules`
--
ALTER TABLE `modules`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `modules_name_unique` (`name`),
  ADD UNIQUE KEY `modules_key_unique` (`key`),
  ADD UNIQUE KEY `modules_position_unique` (`position`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_key_unique` (`key`),
  ADD KEY `permissions_module_id_foreign` (`module_id`);

--
-- Indexes for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD PRIMARY KEY (`id`),
  ADD KEY `permission_role_role_id_foreign` (`role_id`),
  ADD KEY `permission_role_permission_id_foreign` (`permission_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_unique` (`name`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `sub_modules`
--
ALTER TABLE `sub_modules`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sub_modules_name_unique` (`name`),
  ADD UNIQUE KEY `sub_modules_key_unique` (`key`),
  ADD KEY `sub_modules_module_id_foreign` (`module_id`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tasks_assigned_to_foreign` (`assigned_to`),
  ADD KEY `tasks_assigned_by_foreign` (`assigned_by`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `modules`
--
ALTER TABLE `modules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `permission_role`
--
ALTER TABLE `permission_role`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=134;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sub_modules`
--
ALTER TABLE `sub_modules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `permissions`
--
ALTER TABLE `permissions`
  ADD CONSTRAINT `permissions_module_id_foreign` FOREIGN KEY (`module_id`) REFERENCES `modules` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sub_modules`
--
ALTER TABLE `sub_modules`
  ADD CONSTRAINT `sub_modules_module_id_foreign` FOREIGN KEY (`module_id`) REFERENCES `modules` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_assigned_by_foreign` FOREIGN KEY (`assigned_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tasks_assigned_to_foreign` FOREIGN KEY (`assigned_to`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
