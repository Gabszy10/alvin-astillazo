-- Table structure for table `appointment_types`
CREATE TABLE `appointment_types` (
  `type_id` int(11) NOT NULL,
  `type_name` varchar(50) NOT NULL,
  `pet_type` enum('dog','cat','bird','rabbit','reptile','small mammal','other') NOT NULL,
  `description` text DEFAULT NULL,
  `duration_minutes` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Indexes for table `appointment_types`
ALTER TABLE `appointment_types`
  ADD PRIMARY KEY (`type_id`),
  ADD UNIQUE KEY `unique_type_pet` (`type_name`, `pet_type`);

-- AUTO_INCREMENT for table `appointment_types`
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
  `admin_id` int(11) NOT NULL AUTO_INCREMENT,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  PRIMARY KEY (`admin_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
