-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.8.4-MariaDB - MariaDB Server
-- Server OS:                    Linux
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for db_minigame
CREATE DATABASE IF NOT EXISTS `db_minigame` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */;
USE `db_minigame`;

-- Dumping structure for table db_minigame.comments
CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `target_id` int(11) NOT NULL,
  `profile_id` int(11) NOT NULL,
  `fullname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_minigame.comments: 0 rows
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
INSERT INTO `comments` (`id`, `target_id`, `profile_id`, `fullname`, `avatar`, `content`, `created_at`, `updated_at`) VALUES
	(19, 59, 81, 'Ngô Ngọc Nhi', 'https://static.gosucorp.vn/hrm/avatar/81/82d8afe2d9df4582aec10043ee34e215.jpg', 'wao wao', '2023-09-15 13:49:25', '2023-09-15 13:49:25'),
	(20, 59, 198, 'Nguyễn Thị Diễm Thư', 'https://static.gosucorp.vn/hrm/avatar/198/42890650def34a6ca57b4ea59c6d205c.jpg', 'hép pi \n<3', '2023-09-15 13:53:56', '2023-09-15 13:53:56'),
	(22, 59, 59, 'Phạm Bảo Châu', 'https://static.gosucorp.vn/hrm/avatar/59/9478a613bc624cacb659461cea768240.jpg', 'Chúc GOSU tuổi mới thành công mới', '2023-09-15 13:56:30', '2023-09-15 13:56:30'),
	(23, 60, 1319, 'Nguyễn Ngọc Hồng', 'https://static.gosucorp.vn/hrm/avatar/1319/ed5ad4277cc1418bad67e821229da77c.jpg', 'đẹp qáaaaaa', '2023-09-15 13:59:25', '2023-09-15 13:59:25'),
	(24, 63, 81, 'Ngô Ngọc Nhi', 'https://static.gosucorp.vn/hrm/avatar/81/82d8afe2d9df4582aec10043ee34e215.jpg', 'cho ké trà sữa', '2023-09-15 14:02:18', '2023-09-15 14:02:18'),
	(25, 66, 1725, 'Trần Hữu Hoàng', 'https://static.gosucorp.vn/hrm/avatar/1725/c94a0f4a51bb4f1b9e1ee42ffe4fd47d.jpg', 'chúc mừng chúc mừng', '2023-09-15 14:53:26', '2023-09-15 14:53:26');
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;

-- Dumping structure for table db_minigame.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_minigame.failed_jobs: ~0 rows (approximately)

-- Dumping structure for table db_minigame.log_activity
CREATE TABLE IF NOT EXISTS `log_activity` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) DEFAULT NULL,
  `reason` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `type` int(11) DEFAULT NULL COMMENT '1/ hoàn thành nhiệm vụ, 2/ tham gia sự kiện',
  `log_item` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

-- Dumping data for table db_minigame.log_activity: ~17 rows (approximately)
INSERT INTO `log_activity` (`id`, `user_id`, `reason`, `created_at`, `updated_at`, `type`, `log_item`) VALUES
	(1, 4, 'Tham gia thử thách Bài Trùng tại Nhà Thi Đấu Xoẹt Xoẹt.', '2023-09-15 06:59:17', '2023-09-15 06:59:17', 2, '[{"item_id":2,"record":2}]'),
	(2, 4, 'Tham gia thử thách Bài Trùng tại Nhà Thi Đấu Xoẹt Xoẹt.', '2023-09-15 06:59:47', '2023-09-15 06:59:47', 2, '[{"item_id":2,"record":2}]'),
	(3, 6, 'Nhận thưởng nhiệm vụ 1 tại bảng thử thách.', '2023-09-15 07:21:05', '2023-09-15 07:21:05', 2, '[{"item_id":2,"record":5}]'),
	(4, 6, 'Tham gia thử thách Tích Kỳ tại Thư Viện Toàn Tri.', '2023-09-15 07:21:56', '2023-09-15 07:21:56', 2, '[{"item_id":2,"record":-5}]'),
	(5, 6, 'Tham gia thử thách Tích Kỳ tại Thư Viện Toàn Tri.', '2023-09-15 07:22:15', '2023-09-15 07:22:15', 2, '[{"item_id":2,"record":-5}]'),
	(6, 6, 'Tham gia thử thách Tích Kỳ tại Thư Viện Toàn Tri.', '2023-09-15 07:22:18', '2023-09-15 07:22:18', 2, '[{"item_id":2,"record":-5}]'),
	(7, 6, 'Tham gia thử thách Tích Kỳ tại Thư Viện Toàn Tri.', '2023-09-15 07:22:21', '2023-09-15 07:22:21', 2, '[{"item_id":2,"record":-5}]'),
	(8, 6, 'Tham gia thử thách Tích Kỳ tại Thư Viện Toàn Tri.', '2023-09-15 07:22:24', '2023-09-15 07:22:24', 2, '[{"item_id":2,"record":-5}]'),
	(9, 6, 'Tham gia thử thách Tích Kỳ tại Thư Viện Toàn Tri.', '2023-09-15 07:22:27', '2023-09-15 07:22:27', 2, '[{"item_id":2,"record":-5}]'),
	(10, 6, 'Tham gia thử thách Tích Kỳ tại Thư Viện Toàn Tri.', '2023-09-15 07:22:30', '2023-09-15 07:22:30', 2, '[{"item_id":2,"record":-5}]'),
	(11, 6, 'Tham gia thử thách Tích Kỳ tại Thư Viện Toàn Tri.', '2023-09-15 07:22:33', '2023-09-15 07:22:33', 2, '[{"item_id":2,"record":-5}]'),
	(12, 6, 'Tham gia thử thách Tích Kỳ tại Thư Viện Toàn Tri.', '2023-09-15 07:22:35', '2023-09-15 07:22:35', 2, '[{"item_id":2,"record":-5}]'),
	(13, 6, 'Tham gia thử thách Tích Kỳ tại Thư Viện Toàn Tri.', '2023-09-15 07:22:37', '2023-09-15 07:22:37', 2, '[{"item_id":2,"record":-5}]'),
	(14, 10, 'Nhận thưởng nhiệm vụ 1 tại bảng thử thách.', '2023-09-15 08:03:32', '2023-09-15 08:03:32', 2, '[{"item_id":2,"record":5}]'),
	(15, 10, 'Tham gia thử thách Tích Kỳ tại Thư Viện Toàn Tri.', '2023-09-15 08:03:45', '2023-09-15 08:03:45', 2, '[{"item_id":2,"record":-5}]'),
	(16, 10, 'Tham gia thử thách Tích Kỳ tại Thư Viện Toàn Tri.', '2023-09-15 08:03:49', '2023-09-15 08:03:49', 2, '[{"item_id":2,"record":-5}]'),
	(17, 10, 'Tham gia thử thách Bài Trùng tại Nhà Thi Đấu Xoẹt Xoẹt.', '2023-09-15 08:03:59', '2023-09-15 08:03:59', 2, '[{"item_id":2,"record":2}]'),
	(18, 6, 'Nhận thưởng nhiệm vụ 9 tại bảng thử thách.', '2023-09-15 08:22:04', '2023-09-15 08:22:04', 2, '[{"item_id":2,"record":10}]'),
	(19, 6, 'Nhận thưởng nhiệm vụ 1 tại bảng thử thách.', '2023-09-15 08:22:15', '2023-09-15 08:22:15', 2, '[{"item_id":2,"record":5}]'),
	(20, 6, 'Tham gia thử thách Bài Trùng tại Nhà Thi Đấu Xoẹt Xoẹt.', '2023-09-15 08:28:37', '2023-09-15 08:28:37', 2, '[{"item_id":2,"record":2}]'),
	(21, 6, 'Tham gia thử thách Tích Kỳ tại Thư Viện Toàn Tri.', '2023-09-15 08:30:41', '2023-09-15 08:30:41', 2, '[{"item_id":2,"record":-5}]'),
	(22, 6, 'Tham gia thử thách Bài Trùng tại Nhà Thi Đấu Xoẹt Xoẹt.', '2023-09-15 08:30:49', '2023-09-15 08:30:49', 2, '[{"item_id":2,"record":2}]');

-- Dumping structure for table db_minigame.log_complete_all_quest
CREATE TABLE IF NOT EXISTS `log_complete_all_quest` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

-- Dumping data for table db_minigame.log_complete_all_quest: ~0 rows (approximately)
INSERT INTO `log_complete_all_quest` (`id`, `user_id`, `created_at`, `updated_at`) VALUES
	(4, 6, '2023-09-15 08:28:39', '2023-09-15 08:28:39');

-- Dumping structure for table db_minigame.log_item
CREATE TABLE IF NOT EXISTS `log_item` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) DEFAULT NULL,
  `old` int(11) DEFAULT NULL,
  `record` int(11) DEFAULT NULL,
  `new` int(11) DEFAULT NULL,
  `reason` varchar(255) DEFAULT NULL,
  `item_type` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table db_minigame.log_item: ~22 rows (approximately)
INSERT INTO `log_item` (`id`, `user_id`, `old`, `record`, `new`, `reason`, `item_type`, `created_at`, `updated_at`) VALUES
	(1, 4, 200, -2, 198, 'Tham gia thử thách Bài Trùng tại Nhà Thi Đấu Xoẹt Xoẹt.', 2, '2023-09-15 06:59:17', '2023-09-15 06:59:17'),
	(2, 4, 198, -2, 196, 'Tham gia thử thách Bài Trùng tại Nhà Thi Đấu Xoẹt Xoẹt.', 2, '2023-09-15 06:59:47', '2023-09-15 06:59:47'),
	(3, 6, 200, 5, 205, 'Nhận thưởng nhiệm vụ 1', 2, '2023-09-15 07:21:05', '2023-09-15 07:21:05'),
	(4, 6, 205, -5, 200, 'Tham gia thử thách Tích Kỳ tại Thư Viện Toàn Tri.', 2, '2023-09-15 07:21:56', '2023-09-15 07:21:56'),
	(5, 6, 200, 10, 210, 'Tham gia thử thách Tích Kỳ tại Thư Viện Toàn Tri.', 2, '2023-09-15 07:21:56', '2023-09-15 07:21:56'),
	(6, 6, 210, -5, 205, 'Tham gia thử thách Tích Kỳ tại Thư Viện Toàn Tri.', 2, '2023-09-15 07:22:15', '2023-09-15 07:22:15'),
	(7, 6, 205, -5, 200, 'Tham gia thử thách Tích Kỳ tại Thư Viện Toàn Tri.', 2, '2023-09-15 07:22:18', '2023-09-15 07:22:18'),
	(8, 6, 200, 10, 210, 'Tham gia thử thách Tích Kỳ tại Thư Viện Toàn Tri.', 2, '2023-09-15 07:22:18', '2023-09-15 07:22:18'),
	(9, 6, 210, -5, 205, 'Tham gia thử thách Tích Kỳ tại Thư Viện Toàn Tri.', 2, '2023-09-15 07:22:21', '2023-09-15 07:22:21'),
	(10, 6, 0, 1, 1, 'Tham gia thử thách Tích Kỳ tại Thư Viện Toàn Tri.', 3, '2023-09-15 07:22:21', '2023-09-15 07:22:21'),
	(11, 6, 205, -5, 200, 'Tham gia thử thách Tích Kỳ tại Thư Viện Toàn Tri.', 2, '2023-09-15 07:22:24', '2023-09-15 07:22:24'),
	(12, 6, 200, -5, 195, 'Tham gia thử thách Tích Kỳ tại Thư Viện Toàn Tri.', 2, '2023-09-15 07:22:27', '2023-09-15 07:22:27'),
	(13, 6, 195, -5, 190, 'Tham gia thử thách Tích Kỳ tại Thư Viện Toàn Tri.', 2, '2023-09-15 07:22:30', '2023-09-15 07:22:30'),
	(14, 6, 190, -5, 185, 'Tham gia thử thách Tích Kỳ tại Thư Viện Toàn Tri.', 2, '2023-09-15 07:22:33', '2023-09-15 07:22:33'),
	(15, 6, 185, -5, 180, 'Tham gia thử thách Tích Kỳ tại Thư Viện Toàn Tri.', 2, '2023-09-15 07:22:35', '2023-09-15 07:22:35'),
	(16, 6, 180, -5, 175, 'Tham gia thử thách Tích Kỳ tại Thư Viện Toàn Tri.', 2, '2023-09-15 07:22:37', '2023-09-15 07:22:37'),
	(17, 6, 0, 5, 5, 'Tham gia thử thách Tích Kỳ tại Thư Viện Toàn Tri.', 1, '2023-09-15 07:22:37', '2023-09-15 07:22:37'),
	(18, 10, 200, 5, 205, 'Nhận thưởng nhiệm vụ 1', 2, '2023-09-15 08:03:32', '2023-09-15 08:03:32'),
	(19, 10, 205, -5, 200, 'Tham gia thử thách Tích Kỳ tại Thư Viện Toàn Tri.', 2, '2023-09-15 08:03:45', '2023-09-15 08:03:45'),
	(20, 10, 200, -5, 195, 'Tham gia thử thách Tích Kỳ tại Thư Viện Toàn Tri.', 2, '2023-09-15 08:03:49', '2023-09-15 08:03:49'),
	(21, 10, 0, 1, 1, 'Tham gia thử thách Tích Kỳ tại Thư Viện Toàn Tri.', 3, '2023-09-15 08:03:49', '2023-09-15 08:03:49'),
	(22, 10, 195, -2, 193, 'Tham gia thử thách Bài Trùng tại Nhà Thi Đấu Xoẹt Xoẹt.', 2, '2023-09-15 08:03:59', '2023-09-15 08:03:59'),
	(23, 6, 175, 10, 185, 'Nhận thưởng nhiệm vụ 9', 2, '2023-09-15 08:22:04', '2023-09-15 08:22:04'),
	(24, 6, 185, 5, 190, 'Nhận thưởng nhiệm vụ 1', 2, '2023-09-15 08:22:15', '2023-09-15 08:22:15'),
	(25, 6, 190, -2, 188, 'Tham gia thử thách Bài Trùng tại Nhà Thi Đấu Xoẹt Xoẹt.', 2, '2023-09-15 08:28:37', '2023-09-15 08:28:37'),
	(26, 6, 188, -5, 183, 'Tham gia thử thách Tích Kỳ tại Thư Viện Toàn Tri.', 2, '2023-09-15 08:30:41', '2023-09-15 08:30:41'),
	(27, 6, 183, -2, 181, 'Tham gia thử thách Bài Trùng tại Nhà Thi Đấu Xoẹt Xoẹt.', 2, '2023-09-15 08:30:49', '2023-09-15 08:30:49');

-- Dumping structure for table db_minigame.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_minigame.migrations: ~10 rows (approximately)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2014_10_12_000000_create_users_table', 1),
	(2, '2014_10_12_100000_create_password_resets_table', 1),
	(3, '2019_08_19_000000_create_failed_jobs_table', 1),
	(25, '2016_06_01_000001_create_oauth_auth_codes_table', 2),
	(26, '2016_06_01_000002_create_oauth_access_tokens_table', 2),
	(27, '2016_06_01_000003_create_oauth_refresh_tokens_table', 2),
	(28, '2016_06_01_000004_create_oauth_clients_table', 2),
	(29, '2016_06_01_000005_create_oauth_personal_access_clients_table', 2),
	(30, '2019_12_14_000001_create_personal_access_tokens_table', 2),
	(31, '2021_07_23_180023_remove_unusable_columns_from_users_table', 2);

-- Dumping structure for table db_minigame.minigame
CREATE TABLE IF NOT EXISTS `minigame` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `list_flips` text DEFAULT NULL,
  `active_flips` text DEFAULT NULL,
  `flag` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table db_minigame.minigame: ~3 rows (approximately)
INSERT INTO `minigame` (`id`, `user_id`, `list_flips`, `active_flips`, `flag`, `created_at`, `updated_at`) VALUES
	(1, 4, '[{"active":0,"type":5},{"active":0,"type":5},{"active":0,"type":2},{"active":0,"type":1},{"active":0,"type":4},{"active":0,"type":3},{"active":0,"type":2},{"active":0,"type":1},{"active":0,"type":1},{"active":0,"type":4},{"active":0,"type":4},{"active":0,"type":3},{"active":0,"type":2},{"active":0,"type":2},{"active":0,"type":1},{"active":0,"type":3},{"active":0,"type":1},{"active":0,"type":4},{"active":0,"type":2},{"active":0,"type":3},{"active":0,"type":1},{"active":0,"type":4},{"active":0,"type":1},{"active":0,"type":1},{"active":0,"type":4},{"active":0,"type":5},{"active":0,"type":5},{"active":0,"type":5},{"active":0,"type":4},{"active":0,"type":5},{"active":0,"type":3},{"active":0,"type":5},{"active":0,"type":3},{"active":0,"type":1},{"active":0,"type":5},{"active":0,"type":2},{"active":0,"type":2},{"active":0,"type":4},{"active":0,"type":3},{"active":0,"type":2},{"active":0,"type":2},{"active":0,"type":4},{"active":0,"type":3},{"active":0,"type":3},{"active":0,"type":5}]', '{"active_flip":[{"active":0,"type":0},{"active":0,"type":0},{"active":2,"type":2,"color":"https:\\/\\/minigame.gosu.vn\\/images\\/sinhnhat11nam\\/thuvien-itemRed.png"},{"active":1,"type":1,"color":"https:\\/\\/minigame.gosu.vn\\/images\\/sinhnhat11nam\\/thuvien-itemPuple.png"},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":2,"type":1,"color":"https:\\/\\/minigame.gosu.vn\\/images\\/sinhnhat11nam\\/thuvien-itemPuple.png"},{"active":2,"type":1,"color":"https:\\/\\/minigame.gosu.vn\\/images\\/sinhnhat11nam\\/thuvien-itemPuple.png"},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":1,"type":2,"color":"https:\\/\\/minigame.gosu.vn\\/images\\/sinhnhat11nam\\/thuvien-itemRed.png"},{"active":2,"type":2,"color":"https:\\/\\/minigame.gosu.vn\\/images\\/sinhnhat11nam\\/thuvien-itemRed.png"},{"active":0,"type":0},{"active":1,"type":3,"color":"https:\\/\\/minigame.gosu.vn\\/images\\/sinhnhat11nam\\/thuvien-itemGreen.png"},{"active":0,"type":0},{"active":0,"type":0},{"active":2,"type":2,"color":"https:\\/\\/minigame.gosu.vn\\/images\\/sinhnhat11nam\\/thuvien-itemRed.png"},{"active":2,"type":3,"color":"https:\\/\\/minigame.gosu.vn\\/images\\/sinhnhat11nam\\/thuvien-itemGreen.png"},{"active":0,"type":0},{"active":1,"type":4,"color":"https:\\/\\/minigame.gosu.vn\\/images\\/sinhnhat11nam\\/thuvien-itemPink.png"},{"active":0,"type":0},{"active":2,"type":1,"color":"https:\\/\\/minigame.gosu.vn\\/images\\/sinhnhat11nam\\/thuvien-itemPuple.png"},{"active":0,"type":0},{"active":2,"type":5,"color":"https:\\/\\/minigame.gosu.vn\\/images\\/sinhnhat11nam\\/thuvien-itemYellow.png"},{"active":2,"type":5,"color":"https:\\/\\/minigame.gosu.vn\\/images\\/sinhnhat11nam\\/thuvien-itemYellow.png"},{"active":2,"type":5,"color":"https:\\/\\/minigame.gosu.vn\\/images\\/sinhnhat11nam\\/thuvien-itemYellow.png"},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":2,"type":5,"color":"https:\\/\\/minigame.gosu.vn\\/images\\/sinhnhat11nam\\/thuvien-itemYellow.png"},{"active":0,"type":0},{"active":2,"type":1,"color":"https:\\/\\/minigame.gosu.vn\\/images\\/sinhnhat11nam\\/thuvien-itemPuple.png"},{"active":0,"type":0},{"active":1,"type":2,"color":"https:\\/\\/minigame.gosu.vn\\/images\\/sinhnhat11nam\\/thuvien-itemRed.png"},{"active":0,"type":0},{"active":0,"type":0},{"active":2,"type":3,"color":"https:\\/\\/minigame.gosu.vn\\/images\\/sinhnhat11nam\\/thuvien-itemGreen.png"},{"active":0,"type":0},{"active":0,"type":0},{"active":2,"type":4,"color":"https:\\/\\/minigame.gosu.vn\\/images\\/sinhnhat11nam\\/thuvien-itemPink.png"},{"active":0,"type":0},{"active":2,"type":3,"color":"https:\\/\\/minigame.gosu.vn\\/images\\/sinhnhat11nam\\/thuvien-itemGreen.png"},{"active":2,"type":5,"color":"https:\\/\\/minigame.gosu.vn\\/images\\/sinhnhat11nam\\/thuvien-itemYellow.png"}],"choises":[],"waiting":[4,1,5,5],"save_waiting":[]}', 0, '2023-09-15 06:59:17', '2023-09-15 06:59:42'),
	(2, 4, '[{"active":0,"type":3},{"active":0,"type":4},{"active":0,"type":5},{"active":0,"type":2},{"active":0,"type":5},{"active":0,"type":2},{"active":0,"type":1},{"active":0,"type":2},{"active":0,"type":4},{"active":0,"type":3},{"active":0,"type":4},{"active":0,"type":5},{"active":0,"type":1},{"active":0,"type":2},{"active":0,"type":1},{"active":0,"type":3},{"active":0,"type":4},{"active":0,"type":5},{"active":0,"type":4},{"active":0,"type":5},{"active":0,"type":4},{"active":0,"type":5},{"active":0,"type":1},{"active":0,"type":3},{"active":0,"type":1},{"active":0,"type":3},{"active":0,"type":1},{"active":0,"type":4},{"active":0,"type":2},{"active":0,"type":5},{"active":0,"type":3},{"active":0,"type":2},{"active":0,"type":2},{"active":0,"type":5},{"active":0,"type":1},{"active":0,"type":3},{"active":0,"type":3},{"active":0,"type":1},{"active":0,"type":5},{"active":0,"type":2},{"active":0,"type":4},{"active":0,"type":3},{"active":0,"type":1},{"active":0,"type":2},{"active":0,"type":4}]', '{"active_flip":[{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":2,"type":5,"color":"https:\\/\\/minigame.gosu.vn\\/images\\/sinhnhat11nam\\/thuvien-itemYellow.png"},{"active":0,"type":0},{"active":0,"type":0},{"active":2,"type":2,"color":"https:\\/\\/minigame.gosu.vn\\/images\\/sinhnhat11nam\\/thuvien-itemRed.png"},{"active":0,"type":0},{"active":2,"type":3,"color":"https:\\/\\/minigame.gosu.vn\\/images\\/sinhnhat11nam\\/thuvien-itemGreen.png"},{"active":0,"type":0},{"active":0,"type":0},{"active":2,"type":1,"color":"https:\\/\\/minigame.gosu.vn\\/images\\/sinhnhat11nam\\/thuvien-itemPuple.png"},{"active":0,"type":0},{"active":2,"type":1,"color":"https:\\/\\/minigame.gosu.vn\\/images\\/sinhnhat11nam\\/thuvien-itemPuple.png"},{"active":2,"type":3,"color":"https:\\/\\/minigame.gosu.vn\\/images\\/sinhnhat11nam\\/thuvien-itemGreen.png"},{"active":2,"type":4,"color":"https:\\/\\/minigame.gosu.vn\\/images\\/sinhnhat11nam\\/thuvien-itemPink.png"},{"active":0,"type":0},{"active":0,"type":0},{"active":2,"type":5,"color":"https:\\/\\/minigame.gosu.vn\\/images\\/sinhnhat11nam\\/thuvien-itemYellow.png"},{"active":2,"type":4,"color":"https:\\/\\/minigame.gosu.vn\\/images\\/sinhnhat11nam\\/thuvien-itemPink.png"},{"active":0,"type":0},{"active":1,"type":1,"color":"https:\\/\\/minigame.gosu.vn\\/images\\/sinhnhat11nam\\/thuvien-itemPuple.png"},{"active":0,"type":0},{"active":0,"type":0},{"active":2,"type":3,"color":"https:\\/\\/minigame.gosu.vn\\/images\\/sinhnhat11nam\\/thuvien-itemGreen.png"},{"active":0,"type":0},{"active":2,"type":4,"color":"https:\\/\\/minigame.gosu.vn\\/images\\/sinhnhat11nam\\/thuvien-itemPink.png"},{"active":0,"type":0},{"active":0,"type":0},{"active":2,"type":3,"color":"https:\\/\\/minigame.gosu.vn\\/images\\/sinhnhat11nam\\/thuvien-itemGreen.png"},{"active":0,"type":0},{"active":0,"type":0},{"active":2,"type":5,"color":"https:\\/\\/minigame.gosu.vn\\/images\\/sinhnhat11nam\\/thuvien-itemYellow.png"},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":2,"type":1,"color":"https:\\/\\/minigame.gosu.vn\\/images\\/sinhnhat11nam\\/thuvien-itemPuple.png"},{"active":0,"type":0},{"active":0,"type":0},{"active":2,"type":4,"color":"https:\\/\\/minigame.gosu.vn\\/images\\/sinhnhat11nam\\/thuvien-itemPink.png"},{"active":1,"type":3,"color":"https:\\/\\/minigame.gosu.vn\\/images\\/sinhnhat11nam\\/thuvien-itemGreen.png"},{"active":0,"type":0},{"active":0,"type":0},{"active":2,"type":4,"color":"https:\\/\\/minigame.gosu.vn\\/images\\/sinhnhat11nam\\/thuvien-itemPink.png"}],"choises":[],"waiting":[2,4,4,3],"save_waiting":[]}', 0, '2023-09-15 06:59:47', '2023-09-15 07:00:14'),
	(3, 10, '[{"active":0,"type":1},{"active":0,"type":2},{"active":0,"type":1},{"active":0,"type":1},{"active":0,"type":5},{"active":0,"type":1},{"active":0,"type":2},{"active":0,"type":3},{"active":0,"type":4},{"active":0,"type":2},{"active":0,"type":4},{"active":0,"type":1},{"active":0,"type":5},{"active":0,"type":1},{"active":0,"type":3},{"active":0,"type":5},{"active":0,"type":5},{"active":0,"type":3},{"active":0,"type":2},{"active":0,"type":2},{"active":0,"type":2},{"active":0,"type":2},{"active":0,"type":4},{"active":0,"type":4},{"active":0,"type":4},{"active":0,"type":3},{"active":0,"type":4},{"active":0,"type":5},{"active":0,"type":2},{"active":0,"type":3},{"active":0,"type":4},{"active":0,"type":3},{"active":0,"type":4},{"active":0,"type":5},{"active":0,"type":5},{"active":0,"type":2},{"active":0,"type":5},{"active":0,"type":1},{"active":0,"type":1},{"active":0,"type":1},{"active":0,"type":3},{"active":0,"type":3},{"active":0,"type":3},{"active":0,"type":5},{"active":0,"type":4}]', '{"active_flip":[{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0}],"choises":[],"waiting":[]}', 0, '2023-09-15 08:03:59', '2023-09-15 08:03:59'),
	(4, 6, '[{"active":0,"type":1},{"active":0,"type":5},{"active":0,"type":1},{"active":0,"type":3},{"active":0,"type":2},{"active":0,"type":5},{"active":0,"type":4},{"active":0,"type":2},{"active":0,"type":5},{"active":0,"type":3},{"active":0,"type":2},{"active":0,"type":4},{"active":0,"type":1},{"active":0,"type":2},{"active":0,"type":3},{"active":0,"type":2},{"active":0,"type":3},{"active":0,"type":3},{"active":0,"type":5},{"active":0,"type":1},{"active":0,"type":4},{"active":0,"type":4},{"active":0,"type":2},{"active":0,"type":4},{"active":0,"type":3},{"active":0,"type":3},{"active":0,"type":5},{"active":0,"type":4},{"active":0,"type":2},{"active":0,"type":5},{"active":0,"type":5},{"active":0,"type":1},{"active":0,"type":1},{"active":0,"type":1},{"active":0,"type":4},{"active":0,"type":2},{"active":0,"type":4},{"active":0,"type":5},{"active":0,"type":3},{"active":0,"type":3},{"active":0,"type":4},{"active":0,"type":1},{"active":0,"type":2},{"active":0,"type":5},{"active":0,"type":1}]', '{"active_flip":[{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0}],"choises":[],"waiting":[]}', 0, '2023-09-15 08:28:37', '2023-09-15 08:28:37'),
	(5, 6, '[{"active":0,"type":3},{"active":0,"type":2},{"active":0,"type":2},{"active":0,"type":5},{"active":0,"type":3},{"active":0,"type":1},{"active":0,"type":3},{"active":0,"type":4},{"active":0,"type":1},{"active":0,"type":3},{"active":0,"type":2},{"active":0,"type":5},{"active":0,"type":1},{"active":0,"type":5},{"active":0,"type":4},{"active":0,"type":4},{"active":0,"type":5},{"active":0,"type":1},{"active":0,"type":2},{"active":0,"type":4},{"active":0,"type":5},{"active":0,"type":3},{"active":0,"type":4},{"active":0,"type":2},{"active":0,"type":1},{"active":0,"type":5},{"active":0,"type":5},{"active":0,"type":5},{"active":0,"type":5},{"active":0,"type":4},{"active":0,"type":3},{"active":0,"type":2},{"active":0,"type":1},{"active":0,"type":1},{"active":0,"type":3},{"active":0,"type":1},{"active":0,"type":3},{"active":0,"type":4},{"active":0,"type":1},{"active":0,"type":4},{"active":0,"type":4},{"active":0,"type":2},{"active":0,"type":2},{"active":0,"type":3},{"active":0,"type":2}]', '{"active_flip":[{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0}],"choises":[],"waiting":[]}', 0, '2023-09-15 08:30:49', '2023-09-15 08:30:49');

-- Dumping structure for table db_minigame.minigame_quests
CREATE TABLE IF NOT EXISTS `minigame_quests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `quests` text DEFAULT NULL,
  `date` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

-- Dumping data for table db_minigame.minigame_quests: ~10 rows (approximately)
INSERT INTO `minigame_quests` (`id`, `user_id`, `quests`, `date`, `created_at`, `updated_at`) VALUES
	(1, 1, '[{"name":"\\u0110i\\u1ec3m danh \\u0111\\u1ebfn tr\\u01b0\\u1eddng h\\u00e0ng ng\\u00e0y 1","type":"0","total_attempts":1,"current_attempts":1,"is_reward":0,"diamond_reward":5},{"name":"M\\u1eddi 10 ph\\u00f9 th\\u1ee7y \\u0111i h\\u1ecdc chung","type":"1","total_attempts":10,"current_attempts":0,"is_reward":0,"diamond_reward":10},{"name":"\\u0110\\u01b0\\u1ee3c 10 ph\\u00f9 th\\u1ee7y kh\\u00e1c nhau r\\u1ee7 \\u0111i h\\u1ecdc chung","type":"2","total_attempts":10,"current_attempts":1,"is_reward":0,"diamond_reward":10},{"name":"Tham gia l\\u1edbp th\\u1ec3 thao ph\\u00f9 th\\u1ee7y t\\u1ea1i Nh\\u00e0 Thi \\u0110\\u1ea5u Xo\\u1eb9t Xo\\u1eb9t m\\u1ed7i ng\\u00e0y","type":"3","total_attempts":1,"current_attempts":0,"is_reward":0,"diamond_reward":5},{"name":"Chi\\u1ebfn th\\u1eafng th\\u1eed th\\u00e1ch t\\u1ea1i Nh\\u00e0 Thi \\u0110\\u1ea5u Xo\\u1eb9t Xo\\u1eb9t","type":"4","total_attempts":3,"current_attempts":0,"is_reward":0,"diamond_reward":15},{"name":"Gh\\u00e9 th\\u0103m Th\\u01b0 Vi\\u1ec7n To\\u00e0n Tri m\\u1ed7i ng\\u00e0y","type":"5","total_attempts":1,"current_attempts":0,"is_reward":0,"diamond_reward":5},{"name":"Ho\\u00e0n th\\u00e0nh 6 nhi\\u1ec7m v\\u1ee5 \\u0111\\u1ea7u ti\\u00ean","type":"6","total_attempts":1,"current_attempts":0,"is_reward":0,"diamond_reward":5},{"name":"Thu th\\u1eadp \\u0111\\u01b0\\u1ee3c 5 L\\u00f4ng Ph\\u01b0\\u1ee3ng Ho\\u00e0ng\\/ng\\u00e0y","type":"7","total_attempts":5,"current_attempts":0,"is_reward":0,"diamond_reward":5},{"name":"Thu th\\u1eadp \\u0111\\u01b0\\u1ee3c 15 L\\u00f4ng Ph\\u01b0\\u1ee3ng Ho\\u00e0ng\\/ng\\u00e0y","type":"8","total_attempts":15,"current_attempts":0,"is_reward":0,"diamond_reward":5},{"name":"\\u0110i\\u1ec3m danh 3 ng\\u00e0y trong kh\\u00f3a h\\u1ecdc \\u0111\\u1ec3 th\\u1eafp s\\u00e1ng 1 m\\u1ea3nh mosaic \\u1edf S\\u1ea3nh Tr\\u01b0\\u1eddng H\\u1ecdp H\\u1eb9p","type":"9","total_attempts":1,"current_attempts":0,"is_reward":0,"diamond_reward":10}]', NULL, '2023-09-15 05:55:29', '2023-09-15 07:35:22'),
	(2, 2, '[{"name":"\\u0110i\\u1ec3m danh \\u0111\\u1ebfn tr\\u01b0\\u1eddng h\\u00e0ng ng\\u00e0y 1","type":"0","total_attempts":1,"current_attempts":1,"is_reward":0,"diamond_reward":5},{"name":"M\\u1eddi 10 ph\\u00f9 th\\u1ee7y \\u0111i h\\u1ecdc chung","type":"1","total_attempts":10,"current_attempts":0,"is_reward":0,"diamond_reward":10},{"name":"\\u0110\\u01b0\\u1ee3c 10 ph\\u00f9 th\\u1ee7y kh\\u00e1c nhau r\\u1ee7 \\u0111i h\\u1ecdc chung","type":"2","total_attempts":10,"current_attempts":0,"is_reward":0,"diamond_reward":10},{"name":"Tham gia l\\u1edbp th\\u1ec3 thao ph\\u00f9 th\\u1ee7y t\\u1ea1i Nh\\u00e0 Thi \\u0110\\u1ea5u Xo\\u1eb9t Xo\\u1eb9t m\\u1ed7i ng\\u00e0y","type":"3","total_attempts":1,"current_attempts":0,"is_reward":0,"diamond_reward":5},{"name":"Chi\\u1ebfn th\\u1eafng th\\u1eed th\\u00e1ch t\\u1ea1i Nh\\u00e0 Thi \\u0110\\u1ea5u Xo\\u1eb9t Xo\\u1eb9t","type":"4","total_attempts":3,"current_attempts":0,"is_reward":0,"diamond_reward":15},{"name":"Gh\\u00e9 th\\u0103m Th\\u01b0 Vi\\u1ec7n To\\u00e0n Tri m\\u1ed7i ng\\u00e0y","type":"5","total_attempts":1,"current_attempts":0,"is_reward":0,"diamond_reward":5},{"name":"Ho\\u00e0n th\\u00e0nh 6 nhi\\u1ec7m v\\u1ee5 \\u0111\\u1ea7u ti\\u00ean","type":"6","total_attempts":1,"current_attempts":0,"is_reward":0,"diamond_reward":5},{"name":"Thu th\\u1eadp \\u0111\\u01b0\\u1ee3c 5 L\\u00f4ng Ph\\u01b0\\u1ee3ng Ho\\u00e0ng\\/ng\\u00e0y","type":"7","total_attempts":5,"current_attempts":0,"is_reward":0,"diamond_reward":5},{"name":"Thu th\\u1eadp \\u0111\\u01b0\\u1ee3c 15 L\\u00f4ng Ph\\u01b0\\u1ee3ng Ho\\u00e0ng\\/ng\\u00e0y","type":"8","total_attempts":15,"current_attempts":0,"is_reward":0,"diamond_reward":5},{"name":"\\u0110i\\u1ec3m danh 3 ng\\u00e0y trong kh\\u00f3a h\\u1ecdc \\u0111\\u1ec3 th\\u1eafp s\\u00e1ng 1 m\\u1ea3nh mosaic \\u1edf S\\u1ea3nh Tr\\u01b0\\u1eddng H\\u1ecdp H\\u1eb9p","type":"9","total_attempts":1,"current_attempts":0,"is_reward":0,"diamond_reward":10}]', NULL, '2023-09-15 06:47:12', '2023-09-15 06:47:12'),
	(3, 3, '[{"name":"\\u0110i\\u1ec3m danh \\u0111\\u1ebfn tr\\u01b0\\u1eddng h\\u00e0ng ng\\u00e0y 1","type":"0","total_attempts":1,"current_attempts":1,"is_reward":0,"diamond_reward":5},{"name":"M\\u1eddi 10 ph\\u00f9 th\\u1ee7y \\u0111i h\\u1ecdc chung","type":"1","total_attempts":10,"current_attempts":0,"is_reward":0,"diamond_reward":10},{"name":"\\u0110\\u01b0\\u1ee3c 10 ph\\u00f9 th\\u1ee7y kh\\u00e1c nhau r\\u1ee7 \\u0111i h\\u1ecdc chung","type":"2","total_attempts":10,"current_attempts":0,"is_reward":0,"diamond_reward":10},{"name":"Tham gia l\\u1edbp th\\u1ec3 thao ph\\u00f9 th\\u1ee7y t\\u1ea1i Nh\\u00e0 Thi \\u0110\\u1ea5u Xo\\u1eb9t Xo\\u1eb9t m\\u1ed7i ng\\u00e0y","type":"3","total_attempts":1,"current_attempts":0,"is_reward":0,"diamond_reward":5},{"name":"Chi\\u1ebfn th\\u1eafng th\\u1eed th\\u00e1ch t\\u1ea1i Nh\\u00e0 Thi \\u0110\\u1ea5u Xo\\u1eb9t Xo\\u1eb9t","type":"4","total_attempts":3,"current_attempts":0,"is_reward":0,"diamond_reward":15},{"name":"Gh\\u00e9 th\\u0103m Th\\u01b0 Vi\\u1ec7n To\\u00e0n Tri m\\u1ed7i ng\\u00e0y","type":"5","total_attempts":1,"current_attempts":0,"is_reward":0,"diamond_reward":5},{"name":"Ho\\u00e0n th\\u00e0nh 6 nhi\\u1ec7m v\\u1ee5 \\u0111\\u1ea7u ti\\u00ean","type":"6","total_attempts":1,"current_attempts":0,"is_reward":0,"diamond_reward":5},{"name":"Thu th\\u1eadp \\u0111\\u01b0\\u1ee3c 5 L\\u00f4ng Ph\\u01b0\\u1ee3ng Ho\\u00e0ng\\/ng\\u00e0y","type":"7","total_attempts":5,"current_attempts":0,"is_reward":0,"diamond_reward":5},{"name":"Thu th\\u1eadp \\u0111\\u01b0\\u1ee3c 15 L\\u00f4ng Ph\\u01b0\\u1ee3ng Ho\\u00e0ng\\/ng\\u00e0y","type":"8","total_attempts":15,"current_attempts":0,"is_reward":0,"diamond_reward":5},{"name":"\\u0110i\\u1ec3m danh 3 ng\\u00e0y trong kh\\u00f3a h\\u1ecdc \\u0111\\u1ec3 th\\u1eafp s\\u00e1ng 1 m\\u1ea3nh mosaic \\u1edf S\\u1ea3nh Tr\\u01b0\\u1eddng H\\u1ecdp H\\u1eb9p","type":"9","total_attempts":1,"current_attempts":0,"is_reward":0,"diamond_reward":10}]', NULL, '2023-09-15 06:50:45', '2023-09-15 06:50:45'),
	(4, 4, '[{"name":"\\u0110i\\u1ec3m danh \\u0111\\u1ebfn tr\\u01b0\\u1eddng h\\u00e0ng ng\\u00e0y 1","type":"0","total_attempts":1,"current_attempts":1,"is_reward":0,"diamond_reward":5},{"name":"M\\u1eddi 10 ph\\u00f9 th\\u1ee7y \\u0111i h\\u1ecdc chung","type":"1","total_attempts":10,"current_attempts":0,"is_reward":0,"diamond_reward":10},{"name":"\\u0110\\u01b0\\u1ee3c 10 ph\\u00f9 th\\u1ee7y kh\\u00e1c nhau r\\u1ee7 \\u0111i h\\u1ecdc chung","type":"2","total_attempts":10,"current_attempts":0,"is_reward":0,"diamond_reward":10},{"name":"Tham gia l\\u1edbp th\\u1ec3 thao ph\\u00f9 th\\u1ee7y t\\u1ea1i Nh\\u00e0 Thi \\u0110\\u1ea5u Xo\\u1eb9t Xo\\u1eb9t m\\u1ed7i ng\\u00e0y","type":"3","total_attempts":1,"current_attempts":1,"is_reward":0,"diamond_reward":5},{"name":"Chi\\u1ebfn th\\u1eafng th\\u1eed th\\u00e1ch t\\u1ea1i Nh\\u00e0 Thi \\u0110\\u1ea5u Xo\\u1eb9t Xo\\u1eb9t","type":"4","total_attempts":3,"current_attempts":0,"is_reward":0,"diamond_reward":15},{"name":"Gh\\u00e9 th\\u0103m Th\\u01b0 Vi\\u1ec7n To\\u00e0n Tri m\\u1ed7i ng\\u00e0y","type":"5","total_attempts":1,"current_attempts":0,"is_reward":0,"diamond_reward":5},{"name":"Ho\\u00e0n th\\u00e0nh 6 nhi\\u1ec7m v\\u1ee5 \\u0111\\u1ea7u ti\\u00ean","type":"6","total_attempts":1,"current_attempts":0,"is_reward":0,"diamond_reward":5},{"name":"Thu th\\u1eadp \\u0111\\u01b0\\u1ee3c 5 L\\u00f4ng Ph\\u01b0\\u1ee3ng Ho\\u00e0ng\\/ng\\u00e0y","type":"7","total_attempts":5,"current_attempts":0,"is_reward":0,"diamond_reward":5},{"name":"Thu th\\u1eadp \\u0111\\u01b0\\u1ee3c 15 L\\u00f4ng Ph\\u01b0\\u1ee3ng Ho\\u00e0ng\\/ng\\u00e0y","type":"8","total_attempts":15,"current_attempts":0,"is_reward":0,"diamond_reward":5},{"name":"\\u0110i\\u1ec3m danh 3 ng\\u00e0y trong kh\\u00f3a h\\u1ecdc \\u0111\\u1ec3 th\\u1eafp s\\u00e1ng 1 m\\u1ea3nh mosaic \\u1edf S\\u1ea3nh Tr\\u01b0\\u1eddng H\\u1ecdp H\\u1eb9p","type":"9","total_attempts":1,"current_attempts":0,"is_reward":0,"diamond_reward":10}]', NULL, '2023-09-15 06:50:56', '2023-09-15 06:59:17'),
	(5, 5, '[{"name":"\\u0110i\\u1ec3m danh \\u0111\\u1ebfn tr\\u01b0\\u1eddng h\\u00e0ng ng\\u00e0y 1","type":"0","total_attempts":1,"current_attempts":1,"is_reward":0,"diamond_reward":5},{"name":"M\\u1eddi 10 ph\\u00f9 th\\u1ee7y \\u0111i h\\u1ecdc chung","type":"1","total_attempts":10,"current_attempts":0,"is_reward":0,"diamond_reward":10},{"name":"\\u0110\\u01b0\\u1ee3c 10 ph\\u00f9 th\\u1ee7y kh\\u00e1c nhau r\\u1ee7 \\u0111i h\\u1ecdc chung","type":"2","total_attempts":10,"current_attempts":0,"is_reward":0,"diamond_reward":10},{"name":"Tham gia l\\u1edbp th\\u1ec3 thao ph\\u00f9 th\\u1ee7y t\\u1ea1i Nh\\u00e0 Thi \\u0110\\u1ea5u Xo\\u1eb9t Xo\\u1eb9t m\\u1ed7i ng\\u00e0y","type":"3","total_attempts":1,"current_attempts":0,"is_reward":0,"diamond_reward":5},{"name":"Chi\\u1ebfn th\\u1eafng th\\u1eed th\\u00e1ch t\\u1ea1i Nh\\u00e0 Thi \\u0110\\u1ea5u Xo\\u1eb9t Xo\\u1eb9t","type":"4","total_attempts":3,"current_attempts":0,"is_reward":0,"diamond_reward":15},{"name":"Gh\\u00e9 th\\u0103m Th\\u01b0 Vi\\u1ec7n To\\u00e0n Tri m\\u1ed7i ng\\u00e0y","type":"5","total_attempts":1,"current_attempts":0,"is_reward":0,"diamond_reward":5},{"name":"Ho\\u00e0n th\\u00e0nh 6 nhi\\u1ec7m v\\u1ee5 \\u0111\\u1ea7u ti\\u00ean","type":"6","total_attempts":1,"current_attempts":0,"is_reward":0,"diamond_reward":5},{"name":"Thu th\\u1eadp \\u0111\\u01b0\\u1ee3c 5 L\\u00f4ng Ph\\u01b0\\u1ee3ng Ho\\u00e0ng\\/ng\\u00e0y","type":"7","total_attempts":5,"current_attempts":0,"is_reward":0,"diamond_reward":5},{"name":"Thu th\\u1eadp \\u0111\\u01b0\\u1ee3c 15 L\\u00f4ng Ph\\u01b0\\u1ee3ng Ho\\u00e0ng\\/ng\\u00e0y","type":"8","total_attempts":15,"current_attempts":0,"is_reward":0,"diamond_reward":5},{"name":"\\u0110i\\u1ec3m danh 3 ng\\u00e0y trong kh\\u00f3a h\\u1ecdc \\u0111\\u1ec3 th\\u1eafp s\\u00e1ng 1 m\\u1ea3nh mosaic \\u1edf S\\u1ea3nh Tr\\u01b0\\u1eddng H\\u1ecdp H\\u1eb9p","type":"9","total_attempts":1,"current_attempts":0,"is_reward":0,"diamond_reward":10}]', NULL, '2023-09-15 06:51:28', '2023-09-15 06:51:28'),
	(7, 7, '[{"name":"\\u0110i\\u1ec3m danh \\u0111\\u1ebfn tr\\u01b0\\u1eddng h\\u00e0ng ng\\u00e0y 1","type":"0","total_attempts":1,"current_attempts":1,"is_reward":0,"diamond_reward":5},{"name":"M\\u1eddi 10 ph\\u00f9 th\\u1ee7y \\u0111i h\\u1ecdc chung","type":"1","total_attempts":10,"current_attempts":0,"is_reward":0,"diamond_reward":10},{"name":"\\u0110\\u01b0\\u1ee3c 10 ph\\u00f9 th\\u1ee7y kh\\u00e1c nhau r\\u1ee7 \\u0111i h\\u1ecdc chung","type":"2","total_attempts":10,"current_attempts":0,"is_reward":0,"diamond_reward":10},{"name":"Tham gia l\\u1edbp th\\u1ec3 thao ph\\u00f9 th\\u1ee7y t\\u1ea1i Nh\\u00e0 Thi \\u0110\\u1ea5u Xo\\u1eb9t Xo\\u1eb9t m\\u1ed7i ng\\u00e0y","type":"3","total_attempts":1,"current_attempts":0,"is_reward":0,"diamond_reward":5},{"name":"Chi\\u1ebfn th\\u1eafng th\\u1eed th\\u00e1ch t\\u1ea1i Nh\\u00e0 Thi \\u0110\\u1ea5u Xo\\u1eb9t Xo\\u1eb9t","type":"4","total_attempts":3,"current_attempts":0,"is_reward":0,"diamond_reward":15},{"name":"Gh\\u00e9 th\\u0103m Th\\u01b0 Vi\\u1ec7n To\\u00e0n Tri m\\u1ed7i ng\\u00e0y","type":"5","total_attempts":1,"current_attempts":0,"is_reward":0,"diamond_reward":5},{"name":"Ho\\u00e0n th\\u00e0nh 6 nhi\\u1ec7m v\\u1ee5 \\u0111\\u1ea7u ti\\u00ean","type":"6","total_attempts":1,"current_attempts":0,"is_reward":0,"diamond_reward":5},{"name":"Thu th\\u1eadp \\u0111\\u01b0\\u1ee3c 5 L\\u00f4ng Ph\\u01b0\\u1ee3ng Ho\\u00e0ng\\/ng\\u00e0y","type":"7","total_attempts":5,"current_attempts":0,"is_reward":0,"diamond_reward":5},{"name":"Thu th\\u1eadp \\u0111\\u01b0\\u1ee3c 15 L\\u00f4ng Ph\\u01b0\\u1ee3ng Ho\\u00e0ng\\/ng\\u00e0y","type":"8","total_attempts":15,"current_attempts":0,"is_reward":0,"diamond_reward":5},{"name":"\\u0110i\\u1ec3m danh 3 ng\\u00e0y trong kh\\u00f3a h\\u1ecdc \\u0111\\u1ec3 th\\u1eafp s\\u00e1ng 1 m\\u1ea3nh mosaic \\u1edf S\\u1ea3nh Tr\\u01b0\\u1eddng H\\u1ecdp H\\u1eb9p","type":"9","total_attempts":1,"current_attempts":0,"is_reward":0,"diamond_reward":10}]', NULL, '2023-09-15 06:53:36', '2023-09-15 06:53:36'),
	(8, 8, '[{"name":"\\u0110i\\u1ec3m danh \\u0111\\u1ebfn tr\\u01b0\\u1eddng h\\u00e0ng ng\\u00e0y 1","type":"0","total_attempts":1,"current_attempts":1,"is_reward":0,"diamond_reward":5},{"name":"M\\u1eddi 10 ph\\u00f9 th\\u1ee7y \\u0111i h\\u1ecdc chung","type":"1","total_attempts":10,"current_attempts":0,"is_reward":0,"diamond_reward":10},{"name":"\\u0110\\u01b0\\u1ee3c 10 ph\\u00f9 th\\u1ee7y kh\\u00e1c nhau r\\u1ee7 \\u0111i h\\u1ecdc chung","type":"2","total_attempts":10,"current_attempts":0,"is_reward":0,"diamond_reward":10},{"name":"Tham gia l\\u1edbp th\\u1ec3 thao ph\\u00f9 th\\u1ee7y t\\u1ea1i Nh\\u00e0 Thi \\u0110\\u1ea5u Xo\\u1eb9t Xo\\u1eb9t m\\u1ed7i ng\\u00e0y","type":"3","total_attempts":1,"current_attempts":0,"is_reward":0,"diamond_reward":5},{"name":"Chi\\u1ebfn th\\u1eafng th\\u1eed th\\u00e1ch t\\u1ea1i Nh\\u00e0 Thi \\u0110\\u1ea5u Xo\\u1eb9t Xo\\u1eb9t","type":"4","total_attempts":3,"current_attempts":0,"is_reward":0,"diamond_reward":15},{"name":"Gh\\u00e9 th\\u0103m Th\\u01b0 Vi\\u1ec7n To\\u00e0n Tri m\\u1ed7i ng\\u00e0y","type":"5","total_attempts":1,"current_attempts":0,"is_reward":0,"diamond_reward":5},{"name":"Ho\\u00e0n th\\u00e0nh 6 nhi\\u1ec7m v\\u1ee5 \\u0111\\u1ea7u ti\\u00ean","type":"6","total_attempts":1,"current_attempts":0,"is_reward":0,"diamond_reward":5},{"name":"Thu th\\u1eadp \\u0111\\u01b0\\u1ee3c 5 L\\u00f4ng Ph\\u01b0\\u1ee3ng Ho\\u00e0ng\\/ng\\u00e0y","type":"7","total_attempts":5,"current_attempts":0,"is_reward":0,"diamond_reward":5},{"name":"Thu th\\u1eadp \\u0111\\u01b0\\u1ee3c 15 L\\u00f4ng Ph\\u01b0\\u1ee3ng Ho\\u00e0ng\\/ng\\u00e0y","type":"8","total_attempts":15,"current_attempts":0,"is_reward":0,"diamond_reward":5},{"name":"\\u0110i\\u1ec3m danh 3 ng\\u00e0y trong kh\\u00f3a h\\u1ecdc \\u0111\\u1ec3 th\\u1eafp s\\u00e1ng 1 m\\u1ea3nh mosaic \\u1edf S\\u1ea3nh Tr\\u01b0\\u1eddng H\\u1ecdp H\\u1eb9p","type":"9","total_attempts":1,"current_attempts":0,"is_reward":0,"diamond_reward":10}]', NULL, '2023-09-15 06:54:37', '2023-09-15 06:54:37'),
	(9, 9, '[{"name":"\\u0110i\\u1ec3m danh \\u0111\\u1ebfn tr\\u01b0\\u1eddng h\\u00e0ng ng\\u00e0y 1","type":"0","total_attempts":1,"current_attempts":1,"is_reward":0,"diamond_reward":5},{"name":"M\\u1eddi 10 ph\\u00f9 th\\u1ee7y \\u0111i h\\u1ecdc chung","type":"1","total_attempts":10,"current_attempts":0,"is_reward":0,"diamond_reward":10},{"name":"\\u0110\\u01b0\\u1ee3c 10 ph\\u00f9 th\\u1ee7y kh\\u00e1c nhau r\\u1ee7 \\u0111i h\\u1ecdc chung","type":"2","total_attempts":10,"current_attempts":0,"is_reward":0,"diamond_reward":10},{"name":"Tham gia l\\u1edbp th\\u1ec3 thao ph\\u00f9 th\\u1ee7y t\\u1ea1i Nh\\u00e0 Thi \\u0110\\u1ea5u Xo\\u1eb9t Xo\\u1eb9t m\\u1ed7i ng\\u00e0y","type":"3","total_attempts":1,"current_attempts":0,"is_reward":0,"diamond_reward":5},{"name":"Chi\\u1ebfn th\\u1eafng th\\u1eed th\\u00e1ch t\\u1ea1i Nh\\u00e0 Thi \\u0110\\u1ea5u Xo\\u1eb9t Xo\\u1eb9t","type":"4","total_attempts":3,"current_attempts":0,"is_reward":0,"diamond_reward":15},{"name":"Gh\\u00e9 th\\u0103m Th\\u01b0 Vi\\u1ec7n To\\u00e0n Tri m\\u1ed7i ng\\u00e0y","type":"5","total_attempts":1,"current_attempts":0,"is_reward":0,"diamond_reward":5},{"name":"Ho\\u00e0n th\\u00e0nh 6 nhi\\u1ec7m v\\u1ee5 \\u0111\\u1ea7u ti\\u00ean","type":"6","total_attempts":1,"current_attempts":0,"is_reward":0,"diamond_reward":5},{"name":"Thu th\\u1eadp \\u0111\\u01b0\\u1ee3c 5 L\\u00f4ng Ph\\u01b0\\u1ee3ng Ho\\u00e0ng\\/ng\\u00e0y","type":"7","total_attempts":5,"current_attempts":0,"is_reward":0,"diamond_reward":5},{"name":"Thu th\\u1eadp \\u0111\\u01b0\\u1ee3c 15 L\\u00f4ng Ph\\u01b0\\u1ee3ng Ho\\u00e0ng\\/ng\\u00e0y","type":"8","total_attempts":15,"current_attempts":0,"is_reward":0,"diamond_reward":5},{"name":"\\u0110i\\u1ec3m danh 3 ng\\u00e0y trong kh\\u00f3a h\\u1ecdc \\u0111\\u1ec3 th\\u1eafp s\\u00e1ng 1 m\\u1ea3nh mosaic \\u1edf S\\u1ea3nh Tr\\u01b0\\u1eddng H\\u1ecdp H\\u1eb9p","type":"9","total_attempts":1,"current_attempts":0,"is_reward":0,"diamond_reward":10}]', NULL, '2023-09-15 07:10:16', '2023-09-15 07:10:16'),
	(10, 10, '[{"name":"\\u0110i\\u1ec3m danh \\u0111\\u1ebfn tr\\u01b0\\u1eddng h\\u00e0ng ng\\u00e0y 1","type":"0","total_attempts":1,"current_attempts":1,"is_reward":1,"diamond_reward":5},{"name":"M\\u1eddi 10 ph\\u00f9 th\\u1ee7y \\u0111i h\\u1ecdc chung","type":"1","total_attempts":10,"current_attempts":0,"is_reward":0,"diamond_reward":10},{"name":"\\u0110\\u01b0\\u1ee3c 10 ph\\u00f9 th\\u1ee7y kh\\u00e1c nhau r\\u1ee7 \\u0111i h\\u1ecdc chung","type":"2","total_attempts":10,"current_attempts":0,"is_reward":0,"diamond_reward":10},{"name":"Tham gia l\\u1edbp th\\u1ec3 thao ph\\u00f9 th\\u1ee7y t\\u1ea1i Nh\\u00e0 Thi \\u0110\\u1ea5u Xo\\u1eb9t Xo\\u1eb9t m\\u1ed7i ng\\u00e0y","type":"3","total_attempts":1,"current_attempts":1,"is_reward":0,"diamond_reward":5},{"name":"Chi\\u1ebfn th\\u1eafng th\\u1eed th\\u00e1ch t\\u1ea1i Nh\\u00e0 Thi \\u0110\\u1ea5u Xo\\u1eb9t Xo\\u1eb9t","type":"4","total_attempts":3,"current_attempts":0,"is_reward":0,"diamond_reward":15},{"name":"Gh\\u00e9 th\\u0103m Th\\u01b0 Vi\\u1ec7n To\\u00e0n Tri m\\u1ed7i ng\\u00e0y","type":"5","total_attempts":1,"current_attempts":1,"is_reward":0,"diamond_reward":5},{"name":"Ho\\u00e0n th\\u00e0nh 6 nhi\\u1ec7m v\\u1ee5 \\u0111\\u1ea7u ti\\u00ean","type":"6","total_attempts":1,"current_attempts":0,"is_reward":0,"diamond_reward":5},{"name":"Thu th\\u1eadp \\u0111\\u01b0\\u1ee3c 5 L\\u00f4ng Ph\\u01b0\\u1ee3ng Ho\\u00e0ng\\/ng\\u00e0y","type":"7","total_attempts":5,"current_attempts":0,"is_reward":0,"diamond_reward":5},{"name":"Thu th\\u1eadp \\u0111\\u01b0\\u1ee3c 15 L\\u00f4ng Ph\\u01b0\\u1ee3ng Ho\\u00e0ng\\/ng\\u00e0y","type":"8","total_attempts":15,"current_attempts":0,"is_reward":0,"diamond_reward":5},{"name":"\\u0110i\\u1ec3m danh 3 ng\\u00e0y trong kh\\u00f3a h\\u1ecdc \\u0111\\u1ec3 th\\u1eafp s\\u00e1ng 1 m\\u1ea3nh mosaic \\u1edf S\\u1ea3nh Tr\\u01b0\\u1eddng H\\u1ecdp H\\u1eb9p","type":"9","total_attempts":1,"current_attempts":0,"is_reward":0,"diamond_reward":10}]', NULL, '2023-09-15 08:03:08', '2023-09-15 08:03:59'),
	(11, 6, '[{"name":"\\u0110i\\u1ec3m danh \\u0111\\u1ebfn tr\\u01b0\\u1eddng h\\u00e0ng ng\\u00e0y 1","type":"0","total_attempts":1,"current_attempts":1,"is_reward":1,"diamond_reward":5},{"name":"M\\u1eddi 10 ph\\u00f9 th\\u1ee7y \\u0111i h\\u1ecdc chung","type":"1","total_attempts":10,"current_attempts":10,"is_reward":0,"diamond_reward":10},{"name":"\\u0110\\u01b0\\u1ee3c 10 ph\\u00f9 th\\u1ee7y kh\\u00e1c nhau r\\u1ee7 \\u0111i h\\u1ecdc chung","type":"2","total_attempts":10,"current_attempts":10,"is_reward":0,"diamond_reward":10},{"name":"Tham gia l\\u1edbp th\\u1ec3 thao ph\\u00f9 th\\u1ee7y t\\u1ea1i Nh\\u00e0 Thi \\u0110\\u1ea5u Xo\\u1eb9t Xo\\u1eb9t m\\u1ed7i ng\\u00e0y","type":"3","total_attempts":1,"current_attempts":1,"is_reward":0,"diamond_reward":5},{"name":"Chi\\u1ebfn th\\u1eafng th\\u1eed th\\u00e1ch t\\u1ea1i Nh\\u00e0 Thi \\u0110\\u1ea5u Xo\\u1eb9t Xo\\u1eb9t","type":"4","total_attempts":3,"current_attempts":3,"is_reward":0,"diamond_reward":15},{"name":"Gh\\u00e9 th\\u0103m Th\\u01b0 Vi\\u1ec7n To\\u00e0n Tri m\\u1ed7i ng\\u00e0y","type":"5","total_attempts":1,"current_attempts":1,"is_reward":0,"diamond_reward":5},{"name":"Ho\\u00e0n th\\u00e0nh 6 nhi\\u1ec7m v\\u1ee5 \\u0111\\u1ea7u ti\\u00ean","type":"6","total_attempts":1,"current_attempts":1,"is_reward":0,"diamond_reward":5},{"name":"Thu th\\u1eadp \\u0111\\u01b0\\u1ee3c 5 L\\u00f4ng Ph\\u01b0\\u1ee3ng Ho\\u00e0ng\\/ng\\u00e0y","type":"7","total_attempts":5,"current_attempts":5,"is_reward":0,"diamond_reward":5},{"name":"G\\u1eedi l\\u1eddi ch\\u00fac qua c\\u00e1c v\\u00ec sao","type":"8","total_attempts":1,"current_attempts":1,"is_reward":1,"diamond_reward":10},{"name":"\\u0110i\\u1ec3m danh 3 ng\\u00e0y trong kh\\u00f3a h\\u1ecdc \\u0111\\u1ec3 th\\u1eafp s\\u00e1ng 1 m\\u1ea3nh mosaic \\u1edf S\\u1ea3nh Tr\\u01b0\\u1eddng H\\u1ecdp H\\u1eb9p","type":"9","total_attempts":1,"current_attempts":0,"is_reward":0,"diamond_reward":10}]', NULL, '2023-09-15 08:20:09', '2023-09-15 08:30:49');

-- Dumping structure for table db_minigame.minigame_tvtt
CREATE TABLE IF NOT EXISTS `minigame_tvtt` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `active_flip_tvtt` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `flag` tinyint(4) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

-- Dumping data for table db_minigame.minigame_tvtt: ~0 rows (approximately)
INSERT INTO `minigame_tvtt` (`id`, `user_id`, `active_flip_tvtt`, `created_at`, `updated_at`, `flag`) VALUES
	(1, 1, '[{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0}]', NULL, NULL, 0),
	(2, 2, '[{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0}]', NULL, NULL, 0),
	(3, 3, '[{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0}]', NULL, NULL, 0),
	(4, 4, '[{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0}]', NULL, NULL, 0),
	(5, 5, '[{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0}]', NULL, NULL, 0),
	(6, 6, '[{"active":1,"type":3,"color":"https:\\/\\/minigame.gosu.vn\\/images\\/sinhnhat11nam\\/thuvien-itemGreen.png"},{"active":1,"type":5,"color":"https:\\/\\/minigame.gosu.vn\\/images\\/sinhnhat11nam\\/thuvien-itemYellow.png"},{"active":1,"type":5,"color":"https:\\/\\/minigame.gosu.vn\\/images\\/sinhnhat11nam\\/thuvien-itemYellow.png"},{"active":1,"type":4,"color":"https:\\/\\/minigame.gosu.vn\\/images\\/sinhnhat11nam\\/thuvien-itemPink.png"},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":1,"type":4,"color":"https:\\/\\/minigame.gosu.vn\\/images\\/sinhnhat11nam\\/thuvien-itemPink.png"},{"active":1,"type":4,"color":"https:\\/\\/minigame.gosu.vn\\/images\\/sinhnhat11nam\\/thuvien-itemPink.png"},{"active":1,"type":3,"color":"https:\\/\\/minigame.gosu.vn\\/images\\/sinhnhat11nam\\/thuvien-itemGreen.png"},{"active":1,"type":1,"color":"https:\\/\\/minigame.gosu.vn\\/images\\/sinhnhat11nam\\/thuvien-itemPuple.png"},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":1,"type":4,"color":"https:\\/\\/minigame.gosu.vn\\/images\\/sinhnhat11nam\\/thuvien-itemPink.png"},{"active":1,"type":5,"color":"https:\\/\\/minigame.gosu.vn\\/images\\/sinhnhat11nam\\/thuvien-itemYellow.png"},{"active":1,"type":2,"color":"https:\\/\\/minigame.gosu.vn\\/images\\/sinhnhat11nam\\/thuvien-itemRed.png"},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0}]', NULL, '2023-09-15 08:30:41', 0),
	(7, 7, '[{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0}]', NULL, NULL, 0),
	(8, 8, '[{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0}]', NULL, NULL, 0),
	(9, 9, '[{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0}]', NULL, NULL, 0),
	(10, 10, '[{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":1,"type":5,"color":"https:\\/\\/minigame.gosu.vn\\/images\\/sinhnhat11nam\\/thuvien-itemYellow.png"},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":1,"type":1,"color":"https:\\/\\/minigame.gosu.vn\\/images\\/sinhnhat11nam\\/thuvien-itemPuple.png"},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0},{"active":0,"type":0}]', NULL, '2023-09-15 08:03:49', 0);

-- Dumping structure for table db_minigame.personal_access_tokens
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_minigame.personal_access_tokens: ~0 rows (approximately)
INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `created_at`, `updated_at`) VALUES
	(1, 'App\\Models\\User', 1, 'phe.tran', 'ab2a335c2dc74fb5fd56e344ca7a622a2a0a74b163a72a5e664043f776107e0e', '["*"]', NULL, '2023-09-15 05:55:09', '2023-09-15 05:55:09'),
	(2, 'App\\Models\\User', 1, 'phe.tran', '8109fd29c5d431cecf1b77dc1654883006da96aacfe4220b2347f9cfcd9b8437', '["*"]', NULL, '2023-09-15 05:55:29', '2023-09-15 05:55:29'),
	(3, 'App\\Models\\User', 2, 'nhi.ngo', 'da57c73b1b909b1ff47262f6964616062c10af6e33cd433ffa8592bec08f94bf', '["*"]', NULL, '2023-09-15 06:47:12', '2023-09-15 06:47:12'),
	(4, 'App\\Models\\User', 3, 'phucuong.tran', 'ad04e1f49aa7d2e19cf69bdc102b1926c6775778c402eaee0e81525dca286154', '["*"]', NULL, '2023-09-15 06:50:44', '2023-09-15 06:50:44'),
	(5, 'App\\Models\\User', 4, 'baochau.pham', '99d4c65a63f5b63fc6a87c48b2a47dd22c5adcd1fb99c7d148a0d9bc39f1ab0c', '["*"]', NULL, '2023-09-15 06:50:55', '2023-09-15 06:50:55'),
	(6, 'App\\Models\\User', 5, 'diemthu.nguyen', '3b8c9875377c93c200bae4afb77c7496781a5717853cb2f40486f0a37124b07d', '["*"]', NULL, '2023-09-15 06:51:27', '2023-09-15 06:51:27'),
	(7, 'App\\Models\\User', 6, 'huuhoang.tran', '548a9d116d9608db68e2300ce9a603bb9862439e464ba3b083f95452dd7d4985', '["*"]', NULL, '2023-09-15 06:53:34', '2023-09-15 06:53:34'),
	(8, 'App\\Models\\User', 7, 'hong.nguyen', '5b49da06b0fcc44eb08779f0ec4901b545056443e3c0ea2f6b6cc07c3e9a71d0', '["*"]', NULL, '2023-09-15 06:53:35', '2023-09-15 06:53:35'),
	(9, 'App\\Models\\User', 8, 'dieutrinh.nguyen', 'd8a279c9d09a3a2178f06f14fdb2d934d13595d3241469a22554186277f175fc', '["*"]', NULL, '2023-09-15 06:54:37', '2023-09-15 06:54:37'),
	(10, 'App\\Models\\User', 6, 'huuhoang.tran', '79d91f9a9ac489b26dc9175beb62bbc58b9c34343665d71ca2be29aee778a2e5', '["*"]', NULL, '2023-09-15 06:57:09', '2023-09-15 06:57:09'),
	(11, 'App\\Models\\User', 9, 'yen.pham', '6ea1912b3e7f4e46f125a892e0da94f4eb54fc4e614e867e03bb25566ffdd932', '["*"]', NULL, '2023-09-15 07:10:16', '2023-09-15 07:10:16'),
	(12, 'App\\Models\\User', 6, 'huuhoang.tran', '5c7c325b7e0a5f199374063d2c7bcc0039666443277a673977da04a1629ba596', '["*"]', NULL, '2023-09-15 07:20:45', '2023-09-15 07:20:45'),
	(13, 'App\\Models\\User', 10, 'minhtam.nguyen', '19442b733459685754208490bb6a5e8a9db1ef11495acee3114946cbb0451a8d', '["*"]', NULL, '2023-09-15 08:03:07', '2023-09-15 08:03:07');

-- Dumping structure for table db_minigame.sanh_hop_hep
CREATE TABLE IF NOT EXISTS `sanh_hop_hep` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `is_reward_quest` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_open` tinyint(4) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table db_minigame.sanh_hop_hep: ~0 rows (approximately)

-- Dumping structure for table db_minigame.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `diamond` int(11) NOT NULL DEFAULT 200,
  `feathers` int(11) NOT NULL DEFAULT 0,
  `profile_id` int(11) DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `decrement_diamon` tinyint(4) DEFAULT NULL,
  `user_code` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `the_tiem_long` int(11) DEFAULT 0,
  `read_instructions` tinyint(4) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_minigame.users: ~10 rows (approximately)
INSERT INTO `users` (`id`, `password`, `avatar`, `first_name`, `roles`, `name`, `email`, `email_verified_at`, `remember_token`, `created_at`, `updated_at`, `diamond`, `feathers`, `profile_id`, `last_name`, `decrement_diamon`, `user_code`, `the_tiem_long`, `read_instructions`) VALUES
	(1, '$2y$10$b2.cpuaz7c9tpn/RLv7t7ukes8VQed1sETAHH.ZuPpw/XzCG3dExa', 'https://static.gosucorp.vn/hrm/avatar/1724/68f6fa9e35ca4ea79375c4bfad19d364.jpg', 'Trần Duy', NULL, 'phe.tran', 'phe.tran@gosu.vn', NULL, NULL, '2023-09-15 05:55:09', '2023-09-15 06:41:51', 200, 0, 1724, 'Phê', NULL, 'MEFVNOHL', 0, 1),
	(2, '$2y$10$XPrHTllpNHRR5vXens6b5OIEmh.ZJCGZwYZkv.oaFpZ0VjdhrezNW', 'https://static.gosucorp.vn/hrm/avatar/81/82d8afe2d9df4582aec10043ee34e215.jpg', 'Ngô Ngọc', NULL, 'nhi.ngo', 'nhi.ngo@gosu.vn', NULL, NULL, '2023-09-15 06:47:12', '2023-09-15 06:47:12', 200, 0, 81, 'Nhi', NULL, 'TMMFVGKE', 0, 0),
	(3, '$2y$10$zCHt5k7h9S8Bs5r6yI70GOYftcLrLYY7yX7A/Ry8SqQhId0mHuj.G', 'https://static.gosucorp.vn/hrm/avatar/1470/5eb82c5e5a034f01a84c6761e6fea10e.jpg', 'Trần Phú', NULL, 'phucuong.tran', 'phucuong.tran@gosu.vn', NULL, NULL, '2023-09-15 06:50:44', '2023-09-15 06:50:44', 200, 0, 1470, 'Cường', NULL, 'SCJGJICT', 0, 0),
	(4, '$2y$10$5ajEiPClFiiKvtgkPsSo5ef3AlNnSUi6ZePTo.RMi2ODy0/jz9V.6', 'https://static.gosucorp.vn/hrm/avatar/59/9478a613bc624cacb659461cea768240.jpg', 'Phạm Bảo', NULL, 'baochau.pham', 'baochau.pham@gosu.vn', NULL, NULL, '2023-09-15 06:50:55', '2023-09-15 06:59:47', 196, 0, 59, 'Châu', NULL, 'PEVARHBY', 0, 0),
	(5, '$2y$10$XurYJpY.p7QGykI.FC60SuqspTQyajQvee8uziBjIhHcvlNK0nxIa', 'https://static.gosucorp.vn/hrm/avatar/198/42890650def34a6ca57b4ea59c6d205c.jpg', 'Nguyễn Thị Diễm', NULL, 'diemthu.nguyen', 'diemthu.nguyen@gosu.vn', NULL, NULL, '2023-09-15 06:51:27', '2023-09-15 06:52:23', 200, 0, 198, 'Thư', NULL, 'OBCIABEM', 0, 1),
	(6, '$2y$10$ih/QUUGDfBXt/eh7.nz6weacBtS0t5s82QRpCfuFk6nxxa3uS8TZ.', 'https://static.gosucorp.vn/hrm/avatar/1725/c94a0f4a51bb4f1b9e1ee42ffe4fd47d.jpg', 'Trần Hữu', NULL, 'huuhoang.tran', 'huuhoang.tran@gosu.vn', NULL, NULL, '2023-09-15 06:53:34', '2023-09-15 08:30:49', 181, 5, 1725, 'Hoàng', NULL, 'GYTFTXUT', 1, 1),
	(7, '$2y$10$A4ucApoDZ2fZOlVvQdSxyuL31aF34NiP1d8dzzs2FvX2Sc8p1YSWS', 'https://static.gosucorp.vn/hrm/avatar/1319/ed5ad4277cc1418bad67e821229da77c.jpg', 'Nguyễn Ngọc', NULL, 'hong.nguyen', 'hong.nguyen@gosu.vn', NULL, NULL, '2023-09-15 06:53:35', '2023-09-15 07:02:42', 200, 0, 1319, 'Hồng', NULL, 'TVUSCEFZ', 0, 1),
	(8, '$2y$10$XDA3mmk8CZJ4DxbMg.nRZeHIvhY.MS6fkq87T20xoS3VPTrQz5QBO', 'https://static.gosucorp.vn/hrm/avatar/1630/ce0f6aeddba14fb280ad4a0e0f1eab29.jpg', 'Nguyễn Thị Diệu', NULL, 'dieutrinh.nguyen', 'dieutrinh.nguyen@gosu.vn', NULL, NULL, '2023-09-15 06:54:36', '2023-09-15 06:54:36', 200, 0, 1630, 'Trinh', NULL, 'OGWWSQEE', 0, 0),
	(9, '$2y$10$z23Yzb93tVasYGUYa8t/zODsdDn/c61jzF6mofJdA2ApGMrFBxC0G', 'https://static.gosucorp.vn/hrm/avatar/146/9780cdca63524a4c9cbffce238180377.jpg', 'Phạm Thị', NULL, 'yen.pham', 'yen.pham@gosu.vn', NULL, NULL, '2023-09-15 07:10:16', '2023-09-15 07:10:16', 200, 0, 146, 'Yến', NULL, 'VMDMUOEL', 0, 0),
	(10, '$2y$10$Rl85v4kglHWFw8V55jntWezVcRj8exj2Hf/i0PpoJaMxnCriJ6nPS', 'https://static.gosucorp.vn/hrm/avatar/1721/1d05fe6046434303984c7a84f073e721.jpg', 'Nguyễn Minh', NULL, 'minhtam.nguyen', 'minhtam.nguyen@gosu.vn', NULL, NULL, '2023-09-15 08:03:07', '2023-09-15 08:03:59', 193, 0, 1721, 'Tâm', NULL, 'TPVNXEQK', 1, 1);

-- Dumping structure for table db_minigame.user_invite
CREATE TABLE IF NOT EXISTS `user_invite` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) DEFAULT NULL,
  `friend_id` bigint(20) DEFAULT NULL,
  `friend_code` varchar(50) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table db_minigame.user_invite: ~1 rows (approximately)
INSERT INTO `user_invite` (`id`, `user_id`, `friend_id`, `friend_code`, `updated_at`, `created_at`) VALUES
	(1, 6, 1, 'MEFVNOHL', '2023-09-15 07:23:24', '2023-09-15 07:23:24'),
	(2, 6, 2, 'TMMFVGKE', '2023-09-15 08:23:41', '2023-09-15 08:23:41');

-- Dumping structure for table db_minigame.wall
CREATE TABLE IF NOT EXISTS `wall` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `title` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_name` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `liked` int(11) DEFAULT NULL,
  `data_like` text COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'serialize',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=75 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_minigame.wall: 0 rows
/*!40000 ALTER TABLE `wall` DISABLE KEYS */;
INSERT INTO `wall` (`id`, `user_id`, `title`, `file_name`, `content`, `color`, `liked`, `data_like`, `created_at`, `updated_at`) VALUES
	(59, 1, 'Happy Birtday Gosu', 'logo-gosu-cam-3d-s1694757805.png', 'Chúc mừng sinh nhật', '238,216,255', 2, '[{"profile_id":81,"fullname":"Ng\\u00f4 Ng\\u1ecdc Nhi"},{"profile_id":1319,"fullname":"Nguy\\u1ec5n Ng\\u1ecdc H\\u1ed3ng"}]', '2023-09-15 13:03:25', '2023-09-15 13:57:14'),
	(60, 2, 'null', 'gosu11-11694760907.jpg', 'HCM nhá hàng :D', '222,255,221', 1, '[{"profile_id":1319,"fullname":"Nguy\\u1ec5n Ng\\u1ecdc H\\u1ed3ng"}]', '2023-09-15 13:55:07', '2023-09-15 15:27:17'),
	(61, 8, 'null', 'photo-2023-09-14-10-01-121694761004.jpg', 'Happy Birthday GOSU!', '255,244,206', 1, '[{"profile_id":81,"fullname":"Ng\\u00f4 Ng\\u1ecdc Nhi"}]', '2023-09-15 13:56:44', '2023-09-15 14:02:01'),
	(62, 4, 'null', 'vc8791694761022.jpg', 'Chúc mừng sinh nhật', 'null', 2, '[{"profile_id":59,"fullname":"Ph\\u1ea1m B\\u1ea3o Ch\\u00e2u"},{"profile_id":81,"fullname":"Ng\\u00f4 Ng\\u1ecdc Nhi"}]', '2023-09-15 13:57:02', '2023-09-15 14:02:03'),
	(63, 7, 'GOSU mãi đỉnh', 'screenshot-11694761024.png', 'Chúc GOSU mãi đỉnh', '255,218,218', 2, '[{"profile_id":1319,"fullname":"Nguy\\u1ec5n Ng\\u1ecdc H\\u1ed3ng"},{"profile_id":81,"fullname":"Ng\\u00f4 Ng\\u1ecdc Nhi"}]', '2023-09-15 13:57:04', '2023-09-15 14:02:04'),
	(64, 7, 'null', '', 'Happy bday GOSU', 'null', NULL, NULL, '2023-09-15 13:59:49', '2023-09-15 13:59:49'),
	(65, 7, 'null', '', 'GOSU GOSU', 'null', NULL, NULL, '2023-09-15 14:00:13', '2023-09-15 14:00:13'),
	(66, 2, 'GOSU 11', 'banner-gosu-xi-21694761487.png', 'Happy Birthday', '187,234,255', 0, '[]', '2023-09-15 14:04:47', '2023-09-15 15:27:18'),
	(67, 7, 'null', 'task-f1694761547.png', 'Nhân dịp sinh nhật, gợi nhớ cho toàn buôn làng :D', '222,255,221', NULL, NULL, '2023-09-15 14:05:47', '2023-09-15 14:05:47'),
	(68, 6, 'Chúc mừng sinh nhật Gosu 11 tuổi', '10451694764376.jpg', 'gosu gosu', '255,218,218', NULL, NULL, '2023-09-15 14:52:56', '2023-09-15 14:52:56'),
	(69, 5, 'null', '', 'Chúc mừng sinh nhật GOSU', 'null', NULL, NULL, '2023-09-15 15:09:14', '2023-09-15 15:09:14'),
	(70, 5, 'null', '', 'Chúc mừng sinh nhật', 'null', NULL, NULL, '2023-09-15 15:09:31', '2023-09-15 15:09:31'),
	(71, 6, 'chúc mừng gosu 11 tuổi', 'images1694765901.jpg', 'gosu gosu', 'null', NULL, NULL, '2023-09-15 15:18:21', '2023-09-15 15:18:21'),
	(72, 6, 'chúc mừng gosu 11 tuổi', 'images-11694766049.jpg', 'chúc mừng', '222,255,221', NULL, NULL, '2023-09-15 15:20:49', '2023-09-15 15:20:49'),
	(73, 6, 'chúc mừng gosu 11 tuổi', 'images-11694766051.jpg', 'chúc mừng', '222,255,221', NULL, NULL, '2023-09-15 15:20:51', '2023-09-15 15:20:51'),
	(74, 6, 'null', '', 'null', 'null', NULL, NULL, '2023-09-15 15:21:14', '2023-09-15 15:21:14');
/*!40000 ALTER TABLE `wall` ENABLE KEYS */;

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
