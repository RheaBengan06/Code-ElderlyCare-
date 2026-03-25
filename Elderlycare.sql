SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `admin_picture` varchar(255) NOT NULL,
  `fn` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `admins` (`id`, `admin_picture`, `fn`, `position`, `email`, `password`, `created_at`) VALUES
(1, '', '', '', 'marteyy@gmail.com', 'qwe123', '2025-02-05 08:52:52')VALUES (5, '', '','', 'danii@gmail.com', 'asd123', '2025-04-27 10:01:26');

CREATE TABLE `caregivers` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` enum('Pending','Approved','Rejected') DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `caregivers` (`id`, `username`, `email`, `password`, `status`, `created_at`) VALUES
(1, 'marteyy12', 'valeriemartinez@gmail.com', '$2y$10$K1KTmJJDxsbyujC7B7qr.eBlLYWcK1iA.2IC5bu5wQ8rTdqZweW0i', 'Approved', '2025-02-05 08:20:40'),
(2, 'Rhea', 'Rhea@gmail.com', '$2y$10$BBPoyME2VaSVyK5jIn75a.Va7gq2sOA6Idyza6i3iB00paFQUdkwO', 'Approved', '2025-02-05 09:25:24'),
(3, 'mark', 'mark@gmail.com', '$2y$10$rsrMFTzpVhg94j4AAFj1vuuHyoTVSSWSMxDJqsGEdi18Rtbx965oK', 'Approved', '2025-02-11 07:24:32'),
(4, 'rhea', 'rhea123@gmail.com', '$2y$10$3DhZqhCZj/i6aoyCG5yIneQuRnBcDEZQcV2GCJrZ4j422U4zePtOS', 'Approved', '2025-02-12 00:14:21');

CREATE TABLE `patients` (
  `id` int(11) NOT NULL,
  `caregiver_id` int(11) DEFAULT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `middle_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `health_status` varchar(255) DEFAULT NULL,
  `emergency_contact` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `medications` text DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `profile_picture` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `patients` (`id`, `caregiver_id`, `first_name`, `middle_name`, `last_name`, `dob`, `health_status`, `emergency_contact`, `address`, `medications`, `notes`, `profile_picture`) VALUES
(13, 3, 'asdas', 'asdas', 'asdsa', '2023-10-08', 'aasda', 'asdas', 'asdasd', 'asdsad', 'asdas', '1739276568_67ab41183e41b_Screenshot 2025-02-03 185006.png'),
(16, 3, 'asd', 'asd', 'asd', '2024-06-19', 'aasda', 'asdas', 'asdasd', 'asdsad', 'asdas', '1739282589_67ab589d301aa_SlideEgg_13057-Agile Scrum PowerPoint Presentation.jpg'),
(17, 4, 'Rhea', 'Oliveros', 'Bengan', '2002-07-06', 'Sakto lang', 'Danilyn Tuala', 'Sa boarding house ya', 'biskan ano', 'diagnosed with can\'t-stop-eating disorder.', '1739319502_67abe8ce280cc_475196230_962943962121321_2698940666878693100_n.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `caregivers`
--
ALTER TABLE `caregivers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_caregiver` (`caregiver_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `caregivers`
--
ALTER TABLE `caregivers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `patients`
--
ALTER TABLE `patients`
  ADD CONSTRAINT `fk_caregiver` FOREIGN KEY (`caregiver_id`) REFERENCES `caregivers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `patients_ibfk_1` FOREIGN KEY (`caregiver_id`) REFERENCES `caregivers` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
