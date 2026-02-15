-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 15, 2026 at 03:11 PM
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
-- Database: `users`
--

-- --------------------------------------------------------

--
-- Table structure for table `anonymous_wall`
--

CREATE TABLE `anonymous_wall` (
  `comment_id` int(21) NOT NULL,
  `comment_text` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `anonymous_wall`
--

INSERT INTO `anonymous_wall` (`comment_id`, `comment_text`, `created_at`) VALUES
(1, 'commment_text', '2026-01-21 11:58:52'),
(2, 'message', '2026-01-21 11:59:36'),
(3, 'how are you', '2026-01-21 12:05:11'),
(4, 'im fine\r\n', '2026-01-21 12:05:17'),
(5, 'ecovents', '2026-01-21 12:09:47'),
(6, 'hellooo', '2026-01-22 05:46:41'),
(7, 'my name is eva', '2026-01-22 05:46:50'),
(8, 'hello\r\n', '2026-01-25 10:06:14'),
(9, 'hello\r\nhello', '2026-01-25 10:06:47'),
(10, 'helo', '2026-01-25 10:08:18'),
(11, 'im very happy', '2026-01-31 08:16:10'),
(12, 'im very tall', '2026-01-31 08:25:53'),
(13, 'hi', '2026-02-05 16:04:37');

-- --------------------------------------------------------

--
-- Table structure for table `badge`
--

CREATE TABLE `badge` (
  `badge_id` int(21) NOT NULL,
  `badge_name` varchar(255) NOT NULL,
  `badge_icon` varchar(255) NOT NULL,
  `requiredPoints` int(21) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `badge`
--

INSERT INTO `badge` (`badge_id`, `badge_name`, `badge_icon`, `requiredPoints`) VALUES
(1, 'Eco Starter', '../imagessssss/badge1.png', 50),
(2, 'Green Hero', '../imagessssss/badge2.png', 100),
(3, 'Earth Guardian', '../imagessssss/badge3.png', 200),
(4, 'Green Ambassador', '../imagessssss/badge4.png\r\n', 400),
(5, 'Sustainability Champion', '../imagessssss/badge5.png\r\n', 800);

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE `event` (
  `eventID` int(11) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `event_name` varchar(255) NOT NULL,
  `event_type` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `sustainability` varchar(255) NOT NULL,
  `maximum_participant` int(11) NOT NULL,
  `earns_point` int(11) NOT NULL,
  `registration_deadlines` date NOT NULL,
  `participant_categories` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `event_cost` int(11) NOT NULL,
  `location` varchar(255) NOT NULL,
  `transportation_plan` varchar(255) NOT NULL,
  `collaborator_email` varchar(100) NOT NULL,
  `collaborator_category` varchar(100) NOT NULL,
  `organizer_name` varchar(100) NOT NULL,
  `organizer_email` varchar(100) NOT NULL,
  `organizer_contact_no` int(11) NOT NULL,
  `carbon_reduction` int(11) NOT NULL,
  `status` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`eventID`, `user_id`, `event_name`, `event_type`, `description`, `start_date`, `end_date`, `start_time`, `end_time`, `sustainability`, `maximum_participant`, `earns_point`, `registration_deadlines`, `participant_categories`, `image`, `event_cost`, `location`, `transportation_plan`, `collaborator_email`, `collaborator_category`, `organizer_name`, `organizer_email`, `organizer_contact_no`, `carbon_reduction`, `status`, `created_at`, `updated_at`) VALUES
(3, '1', 'Awareness Protect Environment of School', 'seminar', 'Protect school environment.', '2026-01-14', '2026-01-26', '08:37:00', '21:37:00', 'local_sourcing, renewable_energy', 200, 100, '2026-01-27', 'student, faculty', 'event_1768891078_9651.png', 0, 'Auditorium', '', '', '', 'Alice', 'alicetan@gmail.com', 0, 32, 'approved', '0000-00-00 00:00:00', '2026-01-29 14:17:26'),
(5, '1', 'Workshop for Eco Friendly', 'workshop', 'This interactive workshop empowers participants with the knowledge and practical skills needed to adopt sustainable living habits that protect the planet.', '2026-02-03', '2026-02-02', '11:20:00', '13:20:00', '', 70, 50, '2026-01-30', 'student', 'event_1768915095_9427.png', 0, 'B-05-06', '', '', '', 'Alice Tan', 'alicetan@gmail.com', 0, 0, 'approved', '0000-00-00 00:00:00', '2026-01-20 16:32:43'),
(6, '1', 'Root & Reclaim: Community Eco-Fest', 'communitycleanup', '\"Root & Reclaim\" is a zero-waste, community-driven event designed to promote local biodiversity, sustainable living, and waste reduction. Instead of a traditional fair, this event focuses on a circular economy, encouraging participants to \"reclaim\" resources and \"root\" themselves in environmental stewardship.', '2026-01-30', '2026-02-10', '08:01:00', '14:01:00', '', 200, 30, '2026-01-27', '', 'event_1768928531_6236.png', 0, 'Cafeteria', '', '', '', 'Alice Tan', 'alicetan@gmail.com', 0, 0, 'approved', '2026-01-20 17:02:11', '2026-01-31 07:05:08'),
(8, '1', 'Vege Event', 'exhibition', 'Plant-Powered for the Planet Exhibition is a sustainability-focused vegetarian exhibition designed to raise awareness about the environmental and health benefits of plant-based diets.', '2026-01-30', '2026-02-07', '10:18:00', '20:18:00', 'reusable_materials', 1000, 100, '2026-01-29', 'student', 'event_1769502035_2190.jpg', 0, 'Pavilion Bukit Jalil Exhibition Centre', 'Free Bus', 'yhfishball@gmail.com', 'coordinator', 'Alice Tan', 'alicetan@gmail.com', 0, 10, 'approved', '2026-01-27 08:20:35', '2026-01-27 08:26:02'),
(9, '1', 'Plant Flower', 'workshop', 'Want to take a chance to learn how to plant flowers? Let\'s join us. ', '2026-01-07', '2026-01-22', '09:10:00', '11:00:00', 'renewable_energy', 100, 200, '2026-01-23', 'student', 'event_1769771384_4567.png', 12, 'Level 3 Atrium, APU', 'APU Bus', '', '', 'Alice Tan', 'alicetan@gmail.com', 0, 20, 'approved', '2026-01-30 11:09:44', '2026-01-31 06:16:39'),
(10, '1', 'Solar Future Talk', 'seminar', 'An educational seminar introducing solar energy technology and how renewable energy can reduce carbon emissions in daily life.', '2026-02-16', '2026-02-18', '11:00:00', '13:00:00', 'digital_first, renewable_energy', 70, 199, '2026-02-15', 'student, faculty', 'event_1769840967_7884.jpg', 5, 'S-08-03', '', '', '', 'Alice Tan', 'alicetan@gmail.com', 0, 28, 'pending', '2026-01-31 06:29:27', '2026-01-31 06:29:27'),
(11, '1', 'Plastic Campus Campaign', 'awarenesscampaign', 'A week-long awareness campaign encouraging students to eliminate single-use plastics through education booths and digital outreach.', '2026-02-07', '2026-02-08', '10:00:00', '12:00:00', 'zero_waste, digital_first', 150, 298, '2026-02-05', 'student, faculty', 'event_1769841279_4081.jpg', 0, 'Zone B CarPark', '', '', '', 'Alice Tan', 'alicetan@gmail.com', 0, 23, 'pending', '2026-01-31 06:34:39', '2026-01-31 07:05:42'),
(12, '1', 'Urban Tree Revival Program', 'treesplantation', 'A hands-on tree planting program focused on restoring green spaces within urban and campus environments.', '2026-02-02', '2026-02-04', '15:00:00', '16:00:00', 'local_sourcing, reusable_materials', 120, 400, '2026-02-02', 'student, faculty, staff, alumni, external', 'event_1769841774_1716.jpg', 0, 'Level 3 Atrium', '', '', '', 'Alice Tan', 'alicetan@gmail.com', 0, 22, 'pending', '2026-01-31 06:42:54', '2026-01-31 06:42:54'),
(13, '1', 'Sustainable Transport Day', 'awarenesscampaign', 'A green mobility initiative encouraging carpooling, cycling, and public transport to reduce transportation-related carbon emissions.', '2026-02-15', '2026-02-16', '17:00:00', '19:00:00', 'public_transport', 249, 500, '2026-02-14', 'student, faculty', 'event_1769842365_4107.jpeg', 50, 'APU', '', '', '', 'Alice Tan', 'alicetan@gmail.com', 0, 25, 'approved', '2026-01-31 06:52:45', '2026-01-31 07:05:02'),
(14, '1', 'Green Technology Showcase', 'exhibition', 'An exhibition featuring eco-friendly technologies, energy-saving devices, and sustainable innovations by local startups.', '2026-03-01', '2026-03-03', '21:00:00', '16:00:00', 'local_sourcing, renewable_energy', 400, 200, '2026-02-28', 'student, faculty', 'event_1769842482_3750.jpg', 0, 'Level 3 Atrium', '', '', '', 'Alice Tan', 'alicetan@gmail.com', 0, 32, 'pending', '2026-01-31 06:54:42', '2026-01-31 06:54:42'),
(15, '1', 'Eco Hackathon for Climate Action', 'other', 'A collaborative hackathon where participants design digital solutions addressing environmental and climate challenges.', '2026-02-09', '2026-02-27', '22:00:00', '17:00:00', 'digital_first', 400, 600, '2026-02-05', 'student', 'event_1769842552_9199.jpg', 0, 'S-08-01', '', '', '', 'Alice Tan', 'alicetan@gmail.com', 0, 8, 'pending', '2026-01-31 06:55:52', '2026-01-31 06:55:52'),
(16, '1', 'Eco Charity Fundraiser Dinner', 'fundraiser', 'A fundraising dinner aimed at supporting local environmental NGOs and sustainability projects.', '2026-02-23', '2026-02-23', '19:00:00', '22:00:00', 'zero_waste, local_sourcing', 200, 399, '2026-02-16', 'student, faculty, staff', 'event_1769842873_3100.jpeg', 70, 'Level 5 ', '', '', '', 'Alice Tan', 'alicetan@gmail.com', 0, 27, 'approved', '2026-01-31 07:01:13', '2026-01-31 07:04:58'),
(17, '1', 'Green Volunteer Orientation Day', 'communitycleanup', 'An orientation and training session for volunteers participating in upcoming environmental cleanup activities.', '2026-02-02', '2026-02-04', '10:00:00', '15:00:00', 'zero_waste, reusable_materials', 200, 600, '2026-02-01', 'student, faculty', 'event_1769842950_8802.jpg', 0, 'APU', '', '', '', 'Alice Tan', 'alicetan@gmail.com', 0, 25, 'approved', '2026-01-31 07:02:30', '2026-01-31 07:05:11');

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `newsID` int(21) NOT NULL,
  `user_id` int(21) NOT NULL,
  `news_title` varchar(255) NOT NULL,
  `news_content` varchar(2083) NOT NULL,
  `news_type` varchar(255) NOT NULL,
  `news_link` varchar(2083) NOT NULL,
  `news_created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`newsID`, `user_id`, `news_title`, `news_content`, `news_type`, `news_link`, `news_created_at`) VALUES
(1, 3, 'Climate change bill expected to be tabled this Dewan session. ', 'PARLIAMENT | The National Climate Change Bill is expected to be tabled for at least its first reading during the ongoing Parliament meeting as a crucial step towards strengthening climate change governance and supporting Malaysia’s carbon reduction commitments.', 'news', 'https://www.malaysiakini.com/news/766127', '2026-01-22 07:24:55'),
(2, 3, 'Warming temperatures are forcing some Antarctic penguins to breed earlier, study finds', 'Warming temperatures are forcing Antarctic penguins to breed earlier, posing a big problem for two of the cute tuxedoed species that face extinction by the end of the century, a study says.', 'news', 'https://www.cbsnews.com/news/antarctica-penguin-climate-change-breeding-habits/', '2026-01-22 07:54:54'),
(3, 3, '11 Tips for Saving Water', 'Taking a long hot shower is something many of us take for granted—just like turning on the tap when we need to drink, bathe, or cook. ', 'tips', 'https://www.rainforest-alliance.org/everyday-actions/11-tips-for-saving-water/', '2026-01-22 08:03:35'),
(4, 3, '21 simple zero waste living tips', 'How to Reduce Waste: 21 Practical Zero Waste Tips for Everyday Living', 'tips', 'https://onetreeplanted.org/blogs/stories/how-to-reduce-waste?g_adtype=&g_network=g&g_keyword=how%20to%20be%20more%20eco%20friendly&g_placement=&g_campaignid=22830480418&g_adid=765603942670&g_merchantid=&g_ifcreative=&g_locphysical=9066777&g_source={sourceid}&g_keywordid=kwd-10679125468&g_campaign=account&g_acctid=611-028-5007&g_partition=&g_productchannel=&g_productid=&g_ifproduct=&g_locinterest=&g_adgroupid=179832847101&gad_source=1&gad_campaignid=22830480418&gbraid=0AAAAACv-2CKrpZgzEZi5VQy4JG5t97chz&gclid=CjwKCAiAssfLBhBDEiwAcLpwfm42NYNdwMXMIBNs4dQagS9SHVi5Bgx_aza3GA3rtRJUXWvH1ylVgxoCoa4QAvD_BwE', '2026-01-22 08:23:51'),
(5, 3, '🌍 Join Our “Go Green” Campaign', 'Let’s work together to protect our environment! Our “Go Green” campaign encourages participants to reduce plastic usage and promote eco-friendly alternatives. Take part in our activities and earn eco points while making a positive impact.', 'announcement', 'https://news.uitm.edu.my/2024/01/go-green-campaign-small-initiative-big-impact/', '2026-01-29 12:47:25');

-- --------------------------------------------------------

--
-- Table structure for table `organizer_user`
--

CREATE TABLE `organizer_user` (
  `user_id` int(11) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `google_id` varchar(255) DEFAULT NULL,
  `profile_image` int(11) DEFAULT NULL,
  `event_id` int(11) DEFAULT NULL,
  `event_name` varchar(255) DEFAULT NULL,
  `acc_status` varchar(255) NOT NULL,
  `points` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `organizer_user`
--

INSERT INTO `organizer_user` (`user_id`, `password`, `name`, `email`, `role`, `google_id`, `profile_image`, `event_id`, `event_name`, `acc_status`, `points`) VALUES
(1, '$2y$10$D93WBX.MPRP7NC7pYV/UVOHhNm5/u9uROvNd25yIVQCfWgJBDxxla', 'Alice Tan', 'alicetan@gmail.com', 'Organizer', NULL, NULL, NULL, NULL, 'Approved', 0),
(3, 'admin1', 'admin1', 'admin1@gmail.com', 'Admin', NULL, NULL, NULL, NULL, '', 0),
(4, 'admin2', 'admin2', 'admin2@gmail.com', 'Admin', NULL, NULL, NULL, NULL, '', 0),
(5, '123', 'yhh', 'yhfishball@gmail.com', 'Participant', NULL, NULL, NULL, NULL, 'Approved', 100),
(8, '123', 'yh', 'yihwa.hiew@gmail.com', 'Participant', '', 0, 0, '', 'Approved', 0);

-- --------------------------------------------------------

--
-- Table structure for table `registration`
--

CREATE TABLE `registration` (
  `register_ID` int(21) NOT NULL,
  `eventID` int(21) NOT NULL,
  `user_id` int(21) NOT NULL,
  `registration_date` datetime NOT NULL,
  `registration_status` varchar(255) NOT NULL,
  `event_attendance` varchar(255) NOT NULL,
  `action` varchar(255) NOT NULL,
  `feedback` text DEFAULT NULL,
  `submitted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `registration`
--

INSERT INTO `registration` (`register_ID`, `eventID`, `user_id`, `registration_date`, `registration_status`, `event_attendance`, `action`, `feedback`, `submitted_at`) VALUES
(1, 3, 16, '2026-01-21 01:09:56', 'approved', 'attended', '0', 'This event is very good i like it very like very like hahhahahhha i hope to join this again i love APU', '2026-01-21 09:35:10'),
(2, 1, 16, '2026-01-21 17:36:43', 'approved', 'attended', '', 'THis is very good i love it so nice, the committee is so nice on helping us and answering our questions. ', '2026-01-21 09:38:30'),
(3, 8, 5, '2026-01-31 15:17:33', 'approved', 'attended', '', 'I am very happy to join this event\r\n', '2026-01-31 07:23:37'),
(4, 17, 5, '2026-01-31 15:24:03', 'approved', 'attended', '', 'im very happpy', '2026-01-31 08:24:59'),
(5, 13, 5, '2026-01-31 15:24:09', 'approved', 'attended', '', 'Im very happy to join this', '2026-01-31 08:14:42'),
(8, 6, 5, '2026-01-31 16:24:31', 'approved', '', '', NULL, NULL),
(9, 16, 5, '2026-02-06 10:31:05', 'pending', '', '', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `reward`
--

CREATE TABLE `reward` (
  `reward_id` int(21) NOT NULL,
  `reward_name` varchar(255) NOT NULL,
  `pointsRequired` int(21) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reward`
--

INSERT INTO `reward` (`reward_id`, `reward_name`, `pointsRequired`) VALUES
(1, 'Eco Water Bottle', 600),
(2, 'Eco Tote Bag', 400),
(3, 'Plant Seed Kit', 700),
(4, 'RM5 EcoShop Voucher', 500),
(5, 'Stainless Steel Straw Set', 1000),
(6, 'Recycled Paper Notebook', 700),
(7, 'Eco-Friendly Pen', 100);

-- --------------------------------------------------------

--
-- Table structure for table `user_badge`
--

CREATE TABLE `user_badge` (
  `user_badge_id` int(21) NOT NULL,
  `user_id` int(21) NOT NULL,
  `badge_id` int(21) NOT NULL,
  `claimed_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_badge`
--

INSERT INTO `user_badge` (`user_badge_id`, `user_id`, `badge_id`, `claimed_at`) VALUES
(1, 16, 1, '2026-01-21 14:22:01'),
(2, 5, 4, '2026-01-31 08:14:58'),
(3, 5, 3, '2026-01-31 08:25:12'),
(4, 5, 1, '2026-02-06 02:30:26');

-- --------------------------------------------------------

--
-- Table structure for table `user_reward`
--

CREATE TABLE `user_reward` (
  `user_reward_id` int(21) NOT NULL,
  `user_id` int(21) NOT NULL,
  `reward_id` int(21) NOT NULL,
  `reward_claimed_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_reward`
--

INSERT INTO `user_reward` (`user_reward_id`, `user_id`, `reward_id`, `reward_claimed_at`) VALUES
(1, 16, 7, '2026-01-21 15:54:31'),
(2, 5, 7, '2026-01-31 08:03:59'),
(4, 5, 2, '2026-01-31 08:25:23');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `anonymous_wall`
--
ALTER TABLE `anonymous_wall`
  ADD PRIMARY KEY (`comment_id`);

--
-- Indexes for table `badge`
--
ALTER TABLE `badge`
  ADD PRIMARY KEY (`badge_id`);

--
-- Indexes for table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`eventID`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`newsID`);

--
-- Indexes for table `organizer_user`
--
ALTER TABLE `organizer_user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `registration`
--
ALTER TABLE `registration`
  ADD PRIMARY KEY (`register_ID`);

--
-- Indexes for table `user_badge`
--
ALTER TABLE `user_badge`
  ADD PRIMARY KEY (`user_badge_id`),
  ADD UNIQUE KEY `unique_user_badge` (`user_id`,`badge_id`);

--
-- Indexes for table `user_reward`
--
ALTER TABLE `user_reward`
  ADD PRIMARY KEY (`user_reward_id`),
  ADD UNIQUE KEY `unique_user_reward` (`user_id`,`reward_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `anonymous_wall`
--
ALTER TABLE `anonymous_wall`
  MODIFY `comment_id` int(21) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `badge`
--
ALTER TABLE `badge`
  MODIFY `badge_id` int(21) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `event`
--
ALTER TABLE `event`
  MODIFY `eventID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `newsID` int(21) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `organizer_user`
--
ALTER TABLE `organizer_user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `registration`
--
ALTER TABLE `registration`
  MODIFY `register_ID` int(21) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `user_badge`
--
ALTER TABLE `user_badge`
  MODIFY `user_badge_id` int(21) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user_reward`
--
ALTER TABLE `user_reward`
  MODIFY `user_reward_id` int(21) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
