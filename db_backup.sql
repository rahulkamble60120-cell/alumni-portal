-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Jan 24, 2026 at 09:47 AM
-- Server version: 8.0.40
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `alumni_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` bigint UNSIGNED NOT NULL,
  `institution_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'student',
  `department_id` bigint UNSIGNED DEFAULT NULL,
  `chapter_id` bigint UNSIGNED DEFAULT NULL,
  `usn` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `graduation_year` year DEFAULT NULL,
  `status` enum('pending','approved','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `current_company` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `current_position` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `linkedin_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bio` text COLLATE utf8mb4_unicode_ci,
  `profile_picture` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `institution_id`, `name`, `email`, `password`, `role`, `department_id`, `chapter_id`, `usn`, `graduation_year`, `status`, `created_at`, `updated_at`, `current_company`, `current_position`, `linkedin_url`, `bio`, `profile_picture`) VALUES
(1, 1, 'Super Boss', 'admin@test.com', '$2y$12$OgtB2pKexK100MTg/cOyjeKFJGHkoHxCEoiWqf7m9vIH2NBxIo2Ki', 'super_admin', NULL, NULL, NULL, '2000', 'approved', '2026-01-12 03:22:35', '2026-01-12 03:22:35', NULL, NULL, NULL, NULL, NULL),
(2, 1, 'Steve Jobs', 'steve@apple.com', '$2y$12$WHEcEUY09fAfRXnqrKq1e.zCJjQtRAN/AujE.rke0cYffSpvrPM.2', 'student', NULL, NULL, NULL, '2024', 'approved', '2026-01-12 03:22:36', '2026-01-12 03:22:36', 'Apple', 'Founder', NULL, NULL, NULL),
(3, 1, 'Rahul', 'rahulkamble60120@gmail.com', '$2y$12$28rg1.qQnhvbeN8yLbYo5.sr5xmb1kDLQFOLchU5Sd1Gm8fUe31ky', 'chapter_admin', NULL, 2, 'CS001', '2020', 'approved', '2026-01-12 03:25:25', '2026-01-14 12:47:44', NULL, NULL, NULL, NULL, NULL),
(4, 1, 'Bangalore Head', 'bangalore@test.com', '$2y$12$I1mN5/9CQMM0SEO.33BB4.bijEmWoAV3K5tcR21KFihQpOjQNN4Rq', 'chapter_admin', NULL, NULL, NULL, NULL, 'approved', '2026-01-14 12:54:24', '2026-01-14 12:54:24', NULL, NULL, NULL, NULL, NULL),
(5, 1, 'Suraj Hamnmante', 'suraj@gmail.com', '$2y$12$LCqdPXaS6Cfe1utGUElrvedOLxa4JHoj7C9UjyzGF2vL3oy9OHkOC', 'alumnus', NULL, NULL, 'CS001', '2020', 'approved', '2026-01-15 06:24:51', '2026-01-15 06:25:20', NULL, NULL, NULL, NULL, NULL),
(6, 1, 'yogesh', 'yogesh@gmail.com', '$2y$12$JFzzQjm4/FB17eZLHPV4oeyUHZeUZRhOw7OBpb6IOxI384k8AhSAC', 'alumnus', NULL, NULL, 'CS001', '2020', 'approved', '2026-01-18 07:07:34', '2026-01-18 07:08:14', NULL, NULL, NULL, NULL, NULL),
(7, 1, 'rushi', 'rushi@gmail.com', '$2y$12$mA.YwPNaRMdaXXID1xm2EOHjh2LLYG1xkQTJqX.SzkdJ4gVXkTSpu', 'student', NULL, NULL, NULL, '2020', 'pending', '2026-01-23 10:18:50', '2026-01-23 10:18:50', NULL, NULL, NULL, NULL, NULL),
(8, 1, 'rohan', 'rohan@gmail.com', '$2y$12$OJyCw/1cpJk/annwX2QEaehZHj9nAx49uyP55BmnZB80YQizEBhca', 'student', NULL, NULL, NULL, '2020', 'pending', '2026-01-23 10:28:10', '2026-01-23 10:28:10', NULL, NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `users_institution_id_foreign` (`institution_id`),
  ADD KEY `users_department_id_foreign` (`department_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`department_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `users_institution_id_foreign` FOREIGN KEY (`institution_id`) REFERENCES `institutions` (`institution_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
