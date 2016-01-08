-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 11, 2015 at 08:23 PM
-- Server version: 10.1.8-MariaDB
-- PHP Version: 5.6.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `elearning`
--

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

CREATE TABLE `answers` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `QuestionID` int(11) NOT NULL,
  `Logical` tinyint(1) NOT NULL DEFAULT '0',
  `Detail` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `answers`
--

INSERT INTO `answers` (`id`, `created_at`, `updated_at`, `QuestionID`, `Logical`, `Detail`) VALUES
(1, '2015-12-10 03:26:52', '2015-12-10 03:26:52', 1, 1, 'Hihi'),
(2, '2015-12-10 03:27:51', '2015-12-10 03:27:51', 1, 0, 'hehe'),
(3, '2015-12-10 03:28:50', '2015-12-10 03:28:50', 1, 0, '342423'),
(4, '2015-12-10 07:56:24', '2015-12-10 07:56:24', 2, 1, 'Hihi'),
(5, '2015-12-10 07:57:03', '2015-12-10 07:57:03', 2, 0, 'aaaa'),
(6, '2015-12-10 07:57:06', '2015-12-10 07:57:06', 2, 0, '213123'),
(7, '2015-12-10 08:10:34', '2015-12-10 08:10:34', 3, 1, '11111'),
(8, '2015-12-10 08:10:36', '2015-12-10 08:10:36', 3, 0, '11111111'),
(9, '2015-12-10 08:10:38', '2015-12-10 08:10:38', 3, 0, 'a'),
(10, '2015-12-10 08:10:40', '2015-12-10 08:10:40', 3, 0, 'aas'),
(11, '2015-12-10 22:31:58', '2015-12-10 22:31:58', 4, 1, 'aaa'),
(12, '2015-12-10 22:32:45', '2015-12-10 22:32:45', 4, 0, 'aaaa'),
(13, '2015-12-11 01:06:06', '2015-12-11 01:06:06', 5, 0, 'a1'),
(14, '2015-12-11 01:06:06', '2015-12-11 01:06:06', 5, 0, 'a2'),
(15, '2015-12-11 01:06:06', '2015-12-11 01:06:06', 5, 0, 'a3'),
(16, '2015-12-11 01:06:06', '2015-12-11 01:06:06', 5, 1, 'a4'),
(17, '2015-12-11 01:08:10', '2015-12-11 01:08:10', 6, 0, 'a1'),
(18, '2015-12-11 01:08:10', '2015-12-11 01:08:10', 6, 0, 'a2'),
(19, '2015-12-11 01:08:10', '2015-12-11 01:08:10', 6, 1, 'a3'),
(20, '2015-12-11 01:08:10', '2015-12-11 01:08:10', 6, 0, 'a4'),
(21, '2015-12-11 01:15:08', '2015-12-11 01:15:08', 7, 0, 'a1'),
(22, '2015-12-11 01:15:08', '2015-12-11 01:15:08', 7, 1, 'a2'),
(23, '2015-12-11 01:15:08', '2015-12-11 01:15:08', 7, 0, 'a3'),
(24, '2015-12-11 09:27:56', '2015-12-11 09:27:56', 9, 0, 'aaa'),
(25, '2015-12-11 09:27:56', '2015-12-11 09:27:56', 9, 0, 'bbbb'),
(26, '2015-12-11 09:27:56', '2015-12-11 09:27:56', 9, 0, 'cccc'),
(27, '2015-12-11 09:27:57', '2015-12-11 09:27:57', 9, 1, 'ddd');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `Title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `TotalHours` int(11) NOT NULL DEFAULT '0',
  `NoOfUsers` int(11) NOT NULL DEFAULT '0',
  `NoOfPosts` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `created_at`, `updated_at`, `Title`, `Description`, `TotalHours`, `NoOfUsers`, `NoOfPosts`) VALUES
(1, '2015-12-10 03:24:04', '2015-12-10 03:24:04', 'Math', 'Toán học', 0, 0, 0),
(2, '2015-12-10 03:29:15', '2015-12-10 03:29:15', 'Physics', 'Lý Vật', 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `formats`
--

CREATE TABLE `formats` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `Title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Format` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `learning`
--

CREATE TABLE `learning` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `UserID` int(11) NOT NULL,
  `CourseID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2014_10_12_000000_create_users_table', 1),
('2014_10_12_100000_create_password_resets_table', 1),
('2015_12_06_104124_create_posts_table', 1),
('2015_12_06_105320_create_courses_table', 1),
('2015_12_06_105338_create_answers_table', 1),
('2015_12_06_105354_create_formats_table', 1),
('2015_12_06_105409_create_learning_table', 1),
('2015_12_10_090329_create_questions_table', 1),
('2014_10_12_000000_create_users_table', 1),
('2014_10_12_100000_create_password_resets_table', 1),
('2015_12_06_104124_create_posts_table', 1),
('2015_12_06_105320_create_courses_table', 1),
('2015_12_06_105338_create_answers_table', 1),
('2015_12_06_105354_create_formats_table', 1),
('2015_12_06_105409_create_learning_table', 1),
('2015_12_10_090329_create_questions_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `FormatID` int(11) NOT NULL,
  `CourseID` int(11) NOT NULL,
  `Title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Photo` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `Description` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `created_at`, `updated_at`, `FormatID`, `CourseID`, `Title`, `Photo`, `Description`) VALUES
(1, '2015-12-10 03:24:40', '2015-12-10 03:24:40', 1, 1, 'First Post', 'Post_1_1.jpg', 'Bài viết đầu tiên trong khóa Toán học'),
(2, '2015-12-10 03:29:50', '2015-12-10 03:29:50', 1, 2, 'First Post in Physics', 'Post_2_2.jpg', 'Lý vật Post 1');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `PostID` int(11) NOT NULL,
  `Question` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Photo` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `Description` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `created_at`, `updated_at`, `PostID`, `Question`, `Photo`, `Description`) VALUES
(1, '2015-12-10 03:25:05', '2015-12-10 03:25:05', 1, 'First Question', 'Question_1_1.jpg', 'First Question in Post 1'),
(2, '2015-12-10 03:30:12', '2015-12-10 03:30:12', 2, 'First Question', 'Question_2_2.jpg', 'First Question in Post 2'),
(3, '2015-12-10 08:06:55', '2015-12-10 08:06:55', 1, 'Second Question in Math', 'Question_1_3.jpg', 'Câu hỏ thứ 2 trong khóa Toán học'),
(4, '2015-12-10 22:23:18', '2015-12-10 22:23:19', 1, 'A', 'Question_1_4.jpg', 'aaaa'),
(5, '2015-12-10 22:34:51', '2015-12-10 22:34:51', 1, 'new', 'Question_1_5.jpg', 'mới'),
(6, '2015-12-11 01:07:08', '2015-12-11 01:07:08', 1, 'New New', 'Question_1_6.jpg', 'Test'),
(7, '2015-12-11 01:09:38', '2015-12-11 01:09:38', 2, 'New in Physics', 'Question_2_7.jpg', 'Lý Vật'),
(8, '2015-12-11 09:05:55', '2015-12-11 09:05:55', 2, '1', 'Question_2_8.jpg', '111111111111111111111'),
(9, '2015-12-11 09:06:28', '2015-12-11 09:06:28', 2, '1212', 'Question_2_9.jpg', '12121');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `admin` int(11) NOT NULL DEFAULT '0',
  `Type` int(11) NOT NULL DEFAULT '1',
  `TotalTime` int(11) NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `admin`, `Type`, `TotalTime`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'don', 'ngocdon127@gmail.com', '$2y$10$3UFCjUfmn/p.BEsZLS04GOMzgSKqTvZVlXlAlRlP3P2PW0blDTjKa', 1, 1, 0, '8h34a8Z2RG3sqhto3T6PWwHz7KggKZo14STLaR57C41RHMj9XwxQY0ZLhzyx', '2015-12-11 11:10:36', '2015-12-11 12:20:56');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `courses_title_unique` (`Title`);

--
-- Indexes for table `formats`
--
ALTER TABLE `formats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `learning`
--
ALTER TABLE `learning`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`),
  ADD KEY `password_resets_token_index` (`token`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `answers`
--
ALTER TABLE `answers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `formats`
--
ALTER TABLE `formats`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `learning`
--
ALTER TABLE `learning`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
