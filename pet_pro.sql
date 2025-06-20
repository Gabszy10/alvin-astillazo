-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 26, 2025 at 08:41 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pet_pro`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `appointment_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `pet_id` int(11) NOT NULL,
  `vet_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `appointment_date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `status` enum('scheduled','completed','cancelled','no-show') DEFAULT 'scheduled',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `appointment_types`
--

CREATE TABLE `appointment_types` (
  `type_id` int(11) NOT NULL,
  `type_name` varchar(50) NOT NULL,
  `pet_type` enum('dog','cat','bird','rabbit','reptile','small mammal','other') NOT NULL,
  `description` text DEFAULT NULL,
  `duration_minutes` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pets`
--

CREATE TABLE `pets` (
  `pet_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `pet_name` varchar(50) NOT NULL,
  `pet_type` enum('dog','cat','bird','rabbit','reptile','small mammal','other') NOT NULL,
  `breed` varchar(50) NOT NULL,
  `age` int(11) NOT NULL,
  `gender` enum('male','female','other') NOT NULL,
  `special_notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pet_breeds`
--

CREATE TABLE `pet_breeds` (
  `breed_id` int(11) NOT NULL,
  `pet_type` enum('dog','cat','bird','rabbit','reptile','small mammal','other') NOT NULL,
  `breed_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contact_number` varchar(20) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vets`
--

CREATE TABLE `vets` (
  `vet_id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `specialization` varchar(100) DEFAULT NULL,
  `contact_number` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vet_availability`
--

CREATE TABLE `vet_availability` (
  `availability_id` int(11) NOT NULL,
  `vet_id` int(11) NOT NULL,
  `day_of_week` enum('Monday','Tuesday','Wednesday','Thursday','Friday') NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `is_available` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`appointment_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `pet_id` (`pet_id`),
  ADD KEY `vet_id` (`vet_id`),
  ADD KEY `type_id` (`type_id`);

--
-- Indexes for table `appointment_types`
--
ALTER TABLE `appointment_types`
  ADD PRIMARY KEY (`type_id`),
  ADD KEY `type_name` (`type_name`);

--
-- Indexes for table `pets`
--
ALTER TABLE `pets`
  ADD PRIMARY KEY (`pet_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `pet_breeds`
--
ALTER TABLE `pet_breeds`
  ADD PRIMARY KEY (`breed_id`),
  ADD UNIQUE KEY `pet_type` (`pet_type`,`breed_name`);


--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

-- Indexes for table `admins`
ALTER TABLE `admins`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `vets`
--
ALTER TABLE `vets`
  ADD PRIMARY KEY (`vet_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `vet_availability`
--
ALTER TABLE `vet_availability`
  ADD PRIMARY KEY (`availability_id`),
  ADD KEY `vet_id` (`vet_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `appointment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `appointment_types`
--
ALTER TABLE `appointment_types`
  MODIFY `type_id` int(11) NOT NULL AUTO_INCREMENT;

-- Sample appointment reasons
INSERT INTO `appointment_types` (`type_name`, `pet_type`, `description`, `duration_minutes`) VALUES
('Wellness Exam', 'dog', 'Routine check-up for dogs', 30),
('Vaccination', 'dog', 'Standard vaccinations for dogs', 20),
('Dental Cleaning', 'dog', 'Dental cleaning for dogs', 45),
('Wellness Exam', 'cat', 'Routine check-up for cats', 30),
('Vaccination', 'cat', 'Standard vaccinations for cats', 20),
('Spay/Neuter Consultation', 'cat', 'Discussion of spay or neuter procedure', 20),
('Wing Trim', 'bird', 'Trimming of wings and nails', 20),
('Beak Check', 'bird', 'General health exam for birds', 30),
('Health Check', 'reptile', 'General health exam for reptiles', 30),
('Habitat Consultation', 'reptile', 'Advice on habitat and care', 25),
('Wellness Exam', 'rabbit', 'Routine check-up for rabbits', 25),
('Dental Check', 'rabbit', 'Dental exam for rabbits', 20),
('Check-up', 'small mammal', 'General exam for small mammals', 20),
('Nutrition Advice', 'small mammal', 'Diet consultation', 15),
('General Examination', 'other', 'General health exam', 30);

-- Table structure for table `admins`
CREATE TABLE `admins` (
  `admin_id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- AUTO_INCREMENT for table `pets`
--
ALTER TABLE `pets`
  MODIFY `pet_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pet_breeds`
--
ALTER TABLE `pet_breeds`
  MODIFY `breed_id` int(11) NOT NULL AUTO_INCREMENT;


--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;

-- AUTO_INCREMENT for table `admins`
ALTER TABLE `admins`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vets`
--
ALTER TABLE `vets`
  MODIFY `vet_id` int(11) NOT NULL AUTO_INCREMENT;
-- Sample veterinarians
INSERT INTO `vets` (`full_name`, `specialization`, `contact_number`, `email`, `password_hash`) VALUES
('Dr. Sarah Paws', 'Canine Medicine', '555-0101', 'sarah.paws@example.com', '$2b$12$3etSLk5uvC9r2AbA9ik/TO/WdWF/rmYWgrAIHAsGPokEo7IOL28qe'),
('Dr. Felix Whiskers', 'Feline Health', '555-0102', 'felix.whiskers@example.com', '$2b$12$C953LxnBuAWYPHnsfzQlAeWhKjDa521lINNc0ZqaV.viBX08HZpY2'),
('Dr. Polly Feathers', 'Avian Care', '555-0103', 'polly.feathers@example.com', '$2b$12$eljaq2MmBFl/pODYCBoCk.hX9jT0WM9j5AUv0aws8D62t/cKJzuJa'),
('Dr. Rex Scales', 'Reptile & Exotic Pets', '555-0104', 'rex.scales@example.com', '$2b$12$B46K9l/4iZXVTfv3mLOgX./jqppkkUKpsRSFlF/Bm9u3fPBbC8gv.');

--
-- AUTO_INCREMENT for table `vet_availability`
--
ALTER TABLE `vet_availability`
  MODIFY `availability_id` int(11) NOT NULL AUTO_INCREMENT;
-- Sample vet availability
INSERT INTO `vet_availability` (`vet_id`, `day_of_week`, `start_time`, `end_time`, `is_available`) VALUES
(1, 'Monday', '09:00:00', '12:00:00', 1),
(2, 'Tuesday', '09:00:00', '12:00:00', 1),
(3, 'Wednesday', '09:00:00', '12:00:00', 1),
(4, 'Thursday', '09:00:00', '12:00:00', 1);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `appointments_ibfk_2` FOREIGN KEY (`pet_id`) REFERENCES `pets` (`pet_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `appointments_ibfk_3` FOREIGN KEY (`vet_id`) REFERENCES `vets` (`vet_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `appointments_ibfk_4` FOREIGN KEY (`type_id`) REFERENCES `appointment_types` (`type_id`) ON DELETE CASCADE;

--
-- Constraints for table `pets`
--
ALTER TABLE `pets`
  ADD CONSTRAINT `pets_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `vet_availability`
--
ALTER TABLE `vet_availability`
  ADD CONSTRAINT `vet_availability_ibfk_1` FOREIGN KEY (`vet_id`) REFERENCES `vets` (`vet_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
