-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 22, 2021 at 07:45 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `quiz`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email_address` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `c_date` datetime NOT NULL DEFAULT current_timestamp(),
  `status` enum('enable','disable') NOT NULL DEFAULT 'enable'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `email_address`, `password`, `c_date`, `status`) VALUES
(1, 'admin', 'admin@gmail.com', '12345', '2018-10-26 02:13:14', 'enable');

-- --------------------------------------------------------

--
-- Table structure for table `base_setting`
--

CREATE TABLE `base_setting` (
  `id` int(11) NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `base_setting`
--

INSERT INTO `base_setting` (`id`, `key`, `value`, `created_at`) VALUES
(1, 'Level', '344', '2021-08-09 08:24:11'),
(2, 'Registration', '1003', '2021-08-09 08:24:16'),
(3, 'Refer User', '200', '2021-05-08 03:58:29');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `image` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('enable','disable') NOT NULL DEFAULT 'enable'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`, `image`, `created_at`, `updated_at`, `status`) VALUES
(1, 'News', '1617332871.png', '2020-09-17 07:51:43', '2020-09-17 07:51:43', 'enable'),
(2, 'Science', '1617332882.png', '2020-09-17 07:52:09', '2020-09-17 07:52:09', 'enable'),
(3, 'Sports', '1617332896.png', '2020-09-17 07:52:23', '2020-09-17 07:52:23', 'enable'),
(4, 'Business', '1617332911.png', '2020-09-17 07:52:34', '2020-09-17 07:52:34', 'enable'),
(6, 'History', '1617332927.png', '2021-02-25 05:07:54', '2021-02-25 05:07:54', 'enable'),
(7, 'Bollywood', '1617332972.png', '2021-04-02 03:09:32', '2021-04-02 03:09:32', 'enable'),
(8, 'General knowledge', '1617333025.png', '2021-04-02 03:10:25', '2021-04-02 03:10:25', 'enable');

-- --------------------------------------------------------

--
-- Table structure for table `contest_leaderboard`
--

CREATE TABLE `contest_leaderboard` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `level_id` int(11) NOT NULL,
  `question_level_master_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `total_questions` varchar(255) NOT NULL,
  `questions_attended` varchar(255) NOT NULL,
  `correct_answers` varchar(255) NOT NULL,
  `score` float NOT NULL,
  `date` date DEFAULT NULL,
  `is_unlock` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `contest_master`
--

CREATE TABLE `contest_master` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `type` int(11) NOT NULL,
  `level_id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL,
  `no_of_user` int(11) NOT NULL,
  `no_of_user_prize` int(11) NOT NULL,
  `no_of_rank` int(11) NOT NULL,
  `total_prize` int(11) NOT NULL,
  `prize_json` text NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `contest_save_report`
--

CREATE TABLE `contest_save_report` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `contest_id` int(11) NOT NULL,
  `total_questions` varchar(255) NOT NULL,
  `questions_attended` varchar(255) NOT NULL,
  `correct_answers` varchar(255) NOT NULL,
  `score` float NOT NULL,
  `question_json` text NOT NULL,
  `date` date DEFAULT NULL,
  `is_unlock` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `earnpoint_setting`
--

CREATE TABLE `earnpoint_setting` (
  `id` int(11) NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  `type` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `earnpoint_setting`
--

INSERT INTO `earnpoint_setting` (`id`, `key`, `value`, `type`, `created_at`) VALUES
(1, 'Level', '100', 1, '2021-10-02 14:47:14'),
(2, 'Registration', '100', 2, '2021-10-02 14:47:14'),
(3, 'ReferUser', '200', 3, '2021-10-02 14:47:14');

-- --------------------------------------------------------

--
-- Table structure for table `earn_point`
--

CREATE TABLE `earn_point` (
  `id` int(11) NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  `type` int(11) NOT NULL,
  `point_type` int(11) NOT NULL DEFAULT 1 COMMENT '1- Spin wheel , 2 - Daily Login point , 3- get free coin',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `earn_point`
--

INSERT INTO `earn_point` (`id`, `key`, `value`, `type`, `point_type`, `created_at`) VALUES
(1, '1', '100', 1, 1, '2021-10-02 14:39:31'),
(2, '2', '200', 2, 1, '2021-10-02 14:39:31'),
(3, '3', '400', 3, 1, '2021-10-02 14:39:31'),
(4, '4', '500', 4, 1, '2021-10-02 14:39:31'),
(5, '5', '700', 5, 1, '2021-10-02 14:39:31'),
(6, '6', '800', 6, 1, '2021-10-02 14:39:31'),
(7, 'Day-1', '100', 7, 2, '2021-10-02 14:39:19'),
(8, 'Day-2', '200', 8, 2, '2021-10-02 14:39:19'),
(9, 'Day-3', '300', 9, 2, '2021-10-02 14:39:19'),
(10, 'Day-4', '400', 10, 2, '2021-10-02 14:39:19'),
(11, 'Day-5', '500', 11, 2, '2021-10-02 14:39:19'),
(12, 'Day-6', '600', 12, 2, '2021-10-02 14:39:19'),
(13, 'Day-7', '700', 13, 2, '2021-10-02 14:39:19'),
(14, 'free-coin', '10', 14, 3, '2021-10-02 14:39:04');

-- --------------------------------------------------------

--
-- Table structure for table `earn_transaction`
--

CREATE TABLE `earn_transaction` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `contest_id` int(11) NOT NULL,
  `type` int(11) NOT NULL COMMENT '1- contest, normal quiz',
  `point` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `general_setting`
--

CREATE TABLE `general_setting` (
  `id` int(11) NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `general_setting`
--

INSERT INTO `general_setting` (`id`, `key`, `value`) VALUES
(1, 'host_email', 'support@divinetechs.com'),
(2, 'app_name', 'Quiz App'),
(3, 'app_desripation', ''),
(4, 'app_logo', '1624611971.png'),
(5, 'app_version', '1.0'),
(6, 'Author', 'DivineTechs'),
(7, 'contact', '+91 7984859403'),
(8, 'email', 'support@divinetechs.com'),
(9, 'website', 'www.divinetechs.com'),
(10, 'privacy_policy', ''),
(11, 'publisher_id', '1'),
(12, 'banner_ad', 'yes'),
(13, 'banner_adid', '1'),
(14, 'interstital_ad', 'yes'),
(15, 'interstital_adid', ''),
(16, 'interstital_adclick', '5'),
(17, 'onesignal_apid', ''),
(18, 'onesignal_rest_key', ''),
(19, 'reward_ad', 'yes'),
(20, 'reward_adid', '1'),
(21, 'reward_ad_fb', 'yes'),
(22, 'reward_placementid', ''),
(23, 'max_video_upload_size', '1503'),
(24, 'earning_point', '15000'),
(25, 'earning_amount', '1'),
(26, 'min_earning_point', '15000'),
(27, 'currency', 'USD'),
(28, 'instrucation', ''),
(29, 'total_score', '100'),
(30, 'total_score_point', '100'),
(31, 'native_ad', 'yes'),
(32, 'native_adid', '1'),
(33, 'package_name', ''),
(34, 'purchase_code', ''),
(35, 'fb_native_status', 'on'),
(36, 'fb_interstiatial_id', '1'),
(37, 'fb_rewardvideo_id', '1'),
(38, 'fb_native_id', '1'),
(39, 'fb_banner_id', '1'),
(40, 'fb_native_full_id', '1'),
(41, 'payment_1', 'Paypal'),
(42, 'payment_2', 'Paytm'),
(43, 'payment_3', 'Bitcoin'),
(44, 'payment_4', 'WireTransfer / Bank Details'),
(45, 'payment_5', 'Others'),
(46, 'payment_status_1', '1'),
(47, 'payment_status_2', '1'),
(48, 'payment_status_3', '1'),
(49, 'payment_status_4', '1'),
(50, 'payment_status_5', '1'),
(51, 'fb_banner_status', 'on'),
(52, 'fb_interstiatial_status', 'on'),
(53, 'fb_rewardvideo_status', 'on'),
(54, 'fb_native_full_status', 'on'),
(55, 'daily_refer_limit', '3'),
(56, 'wallet_withdraw_visibility', 'yes'),
(57, 'currency_code', '$');

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` int(11) NOT NULL,
  `language` varchar(64) CHARACTER SET utf8 NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `language`, `status`, `created_at`) VALUES
(2, 'English', 0, '2021-04-01 12:33:47'),
(3, 'Hindi', 0, '2021-04-01 12:33:47');

-- --------------------------------------------------------

--
-- Table structure for table `level`
--

CREATE TABLE `level` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `level_order` int(11) NOT NULL,
  `score` int(11) NOT NULL,
  `win_question_count` int(11) NOT NULL,
  `total_question` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('enable','disable') NOT NULL DEFAULT 'enable'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `level`
--

INSERT INTO `level` (`id`, `name`, `level_order`, `score`, `win_question_count`, `total_question`, `created_at`, `updated_at`, `status`) VALUES
(11, 'Level 1', 1, 50, 1, 10, '2021-05-31 05:06:38', '2021-05-31 05:06:38', 'enable'),
(13, 'Level 2', 2, 100, 1, 10, '2021-05-31 06:06:35', '2021-05-31 06:06:35', 'enable'),
(14, 'Level 5', 5, 250, 1, 10, '2021-05-31 08:34:16', '2021-05-31 08:34:16', 'enable'),
(15, 'Level 3', 3, 150, 1, 10, '2021-07-14 12:35:16', '2021-07-14 12:35:16', 'enable'),
(16, 'Level 4', 4, 200, 1, 10, '2021-07-22 11:33:34', '2021-07-22 11:33:34', 'enable');

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `link` varchar(100) NOT NULL,
  `icon` varchar(100) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `active_menu` varchar(255) NOT NULL,
  `order_no` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `id` int(11) NOT NULL,
  `app_id` varchar(255) NOT NULL,
  `included_segments` varchar(255) NOT NULL,
  `data` text NOT NULL,
  `headings` varchar(255) NOT NULL,
  `contents` text NOT NULL,
  `big_picture` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `plan_subscription`
--

CREATE TABLE `plan_subscription` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `price` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `currency_type` varchar(255) NOT NULL,
  `coin` varchar(25) NOT NULL,
  `product_package` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `update_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_delete` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `plan_subscription`
--

INSERT INTO `plan_subscription` (`id`, `name`, `price`, `image`, `currency_type`, `coin`, `product_package`, `status`, `created_at`, `update_at`, `is_delete`) VALUES
(1, 'Plan 3', 100, '1633505475.png', '$', '1000', 'android.test.purchased', 1, '2020-11-01 16:28:11', '2021-10-07 12:59:11', 0),
(2, 'Plan 2', 50, '1633505468.png', '$', '500', 'android.test.purchased', 1, '2021-05-04 11:08:53', '2021-10-07 12:59:20', 0),
(3, 'Plan 1', 10, '1633505459.png', '$', '100', 'android.test.purchased', 1, '2021-06-28 18:22:55', '2021-10-07 12:59:27', 0);

-- --------------------------------------------------------

--
-- Table structure for table `pratice_leaderboard`
--

CREATE TABLE `pratice_leaderboard` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `level_id` int(11) NOT NULL,
  `question_level_master_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `total_questions` varchar(255) NOT NULL,
  `questions_attended` varchar(255) NOT NULL,
  `correct_answers` varchar(255) NOT NULL,
  `score` float NOT NULL,
  `date` date DEFAULT NULL,
  `is_unlock` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `pratice_question`
--

CREATE TABLE `pratice_question` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `language_id` tinyint(4) NOT NULL DEFAULT 0,
  `level_id` int(11) NOT NULL,
  `question_level_master_id` int(11) NOT NULL DEFAULT 0,
  `image` varchar(512) CHARACTER SET utf8 NOT NULL,
  `question` text CHARACTER SET utf8 NOT NULL,
  `question_type` int(11) NOT NULL COMMENT '1= normal, 2= true/false',
  `option_a` text CHARACTER SET utf8 NOT NULL,
  `option_b` text CHARACTER SET utf8 NOT NULL,
  `option_c` text CHARACTER SET utf8 NOT NULL,
  `option_d` text CHARACTER SET utf8 NOT NULL,
  `optione` text CHARACTER SET utf8 DEFAULT NULL,
  `answer` text CHARACTER SET utf8 NOT NULL,
  `note` text CHARACTER SET utf8 NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `question`
--

CREATE TABLE `question` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `contest_id` int(11) NOT NULL,
  `language_id` tinyint(4) NOT NULL DEFAULT 0,
  `level_id` int(11) NOT NULL,
  `question_level_master_id` int(11) NOT NULL DEFAULT 0,
  `image` varchar(512) CHARACTER SET utf8 NOT NULL,
  `question` text CHARACTER SET utf8 NOT NULL,
  `question_type` int(11) NOT NULL COMMENT '1= normal, 2= true/false',
  `option_a` text CHARACTER SET utf8 NOT NULL,
  `option_b` text CHARACTER SET utf8 NOT NULL,
  `option_c` text CHARACTER SET utf8 NOT NULL,
  `option_d` text CHARACTER SET utf8 NOT NULL,
  `optione` text CHARACTER SET utf8 DEFAULT NULL,
  `answer` text CHARACTER SET utf8 NOT NULL,
  `note` text CHARACTER SET utf8 NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `question_level_master`
--

CREATE TABLE `question_level_master` (
  `id` int(11) NOT NULL,
  `level_order` int(11) NOT NULL,
  `level_name` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `question_level_master`
--

INSERT INTO `question_level_master` (`id`, `level_order`, `level_name`, `created_at`) VALUES
(1, 1, 'Easy', '2021-06-24 13:05:41'),
(2, 2, 'Medium', '2021-06-24 13:05:41'),
(3, 3, 'Hard', '2021-06-24 13:05:59'),
(4, 4, 'Difficult', '2021-06-24 13:05:59');

-- --------------------------------------------------------

--
-- Table structure for table `refer_earn_transaction`
--

CREATE TABLE `refer_earn_transaction` (
  `id` int(11) NOT NULL,
  `parent_user_id` int(11) NOT NULL,
  `child_user_id` int(11) NOT NULL,
  `reference_code` varchar(25) NOT NULL,
  `parent_user_referred_point` float(10,2) NOT NULL,
  `child_user_earned_point` float(10,2) NOT NULL,
  `earn_point_type` int(11) NOT NULL,
  `refered_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `reward_transaction`
--

CREATE TABLE `reward_transaction` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `reward_points` float(10,2) NOT NULL DEFAULT 0.00,
  `type` enum('0','1') NOT NULL DEFAULT '0' COMMENT '0-Daily,1-Spin to win',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `smtp_setting`
--

CREATE TABLE `smtp_setting` (
  `id` int(11) NOT NULL,
  `protocol` varchar(255) NOT NULL,
  `host` varchar(255) NOT NULL,
  `port` varchar(255) NOT NULL,
  `user` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `from_name` varchar(255) NOT NULL,
  `from_email` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `smtp_setting`
--

INSERT INTO `smtp_setting` (`id`, `protocol`, `host`, `port`, `user`, `pass`, `from_name`, `from_email`, `status`, `created_at`) VALUES
(1, 'smtp', 'ssl://smtp.gmail.com', '465', 'admin@gmail.com', '123456', 'DivineTechs', 'admin@gmail.com', 1, '2021-08-08 05:13:16');

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `plan_subscription_id` int(11) NOT NULL,
  `transaction_id` varchar(255) NOT NULL,
  `transaction_amount` varchar(255) NOT NULL,
  `coin` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fullname` varchar(255) CHARACTER SET utf8 NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `username` text NOT NULL,
  `email` varchar(255) NOT NULL,
  `profile_img` varchar(255) CHARACTER SET utf8 NOT NULL,
  `instagram_url` varchar(255) NOT NULL,
  `facebook_url` text NOT NULL,
  `twitter_url` text NOT NULL,
  `biodata` text NOT NULL,
  `address` text NOT NULL,
  `password` varchar(255) NOT NULL,
  `type` int(11) DEFAULT 1 COMMENT '1- normal , 2- facebook',
  `mobile_number` varchar(255) NOT NULL,
  `reference_code` varchar(255) NOT NULL,
  `parent_reference_code` int(11) NOT NULL,
  `pratice_quiz_score` float NOT NULL,
  `total_score` float NOT NULL,
  `total_points` int(11) NOT NULL,
  `device_token` text NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'enable',
  `is_updated` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_notification_tracking`
--

CREATE TABLE `user_notification_tracking` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `notification_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `wallet_transaction`
--

CREATE TABLE `wallet_transaction` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `contest_id` int(11) NOT NULL,
  `coin` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `winners`
--

CREATE TABLE `winners` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `contest_id` int(11) NOT NULL,
  `rank` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `score` varchar(255) NOT NULL,
  `percentage` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `withdrawal_request`
--

CREATE TABLE `withdrawal_request` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `point` varchar(255) NOT NULL,
  `total_amount` varchar(255) NOT NULL,
  `payment_type` varchar(255) NOT NULL COMMENT 'Paypal , Paytm , WireTransfer / Bank Details',
  `payment_detail` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0 COMMENT '0- pending , 1- completed',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `base_setting`
--
ALTER TABLE `base_setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contest_leaderboard`
--
ALTER TABLE `contest_leaderboard`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contest_master`
--
ALTER TABLE `contest_master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contest_save_report`
--
ALTER TABLE `contest_save_report`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `earnpoint_setting`
--
ALTER TABLE `earnpoint_setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `earn_point`
--
ALTER TABLE `earn_point`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `earn_transaction`
--
ALTER TABLE `earn_transaction`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `general_setting`
--
ALTER TABLE `general_setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `level`
--
ALTER TABLE `level`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `plan_subscription`
--
ALTER TABLE `plan_subscription`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pratice_leaderboard`
--
ALTER TABLE `pratice_leaderboard`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pratice_question`
--
ALTER TABLE `pratice_question`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category` (`category_id`);

--
-- Indexes for table `question`
--
ALTER TABLE `question`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category` (`category_id`);

--
-- Indexes for table `question_level_master`
--
ALTER TABLE `question_level_master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `refer_earn_transaction`
--
ALTER TABLE `refer_earn_transaction`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reward_transaction`
--
ALTER TABLE `reward_transaction`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `smtp_setting`
--
ALTER TABLE `smtp_setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_notification_tracking`
--
ALTER TABLE `user_notification_tracking`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wallet_transaction`
--
ALTER TABLE `wallet_transaction`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `winners`
--
ALTER TABLE `winners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `withdrawal_request`
--
ALTER TABLE `withdrawal_request`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `base_setting`
--
ALTER TABLE `base_setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `contest_leaderboard`
--
ALTER TABLE `contest_leaderboard`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contest_master`
--
ALTER TABLE `contest_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contest_save_report`
--
ALTER TABLE `contest_save_report`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `earnpoint_setting`
--
ALTER TABLE `earnpoint_setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `earn_point`
--
ALTER TABLE `earn_point`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `earn_transaction`
--
ALTER TABLE `earn_transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `general_setting`
--
ALTER TABLE `general_setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `level`
--
ALTER TABLE `level`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `plan_subscription`
--
ALTER TABLE `plan_subscription`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pratice_leaderboard`
--
ALTER TABLE `pratice_leaderboard`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pratice_question`
--
ALTER TABLE `pratice_question`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `question`
--
ALTER TABLE `question`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `question_level_master`
--
ALTER TABLE `question_level_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `refer_earn_transaction`
--
ALTER TABLE `refer_earn_transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reward_transaction`
--
ALTER TABLE `reward_transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `smtp_setting`
--
ALTER TABLE `smtp_setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_notification_tracking`
--
ALTER TABLE `user_notification_tracking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wallet_transaction`
--
ALTER TABLE `wallet_transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `winners`
--
ALTER TABLE `winners`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `withdrawal_request`
--
ALTER TABLE `withdrawal_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
