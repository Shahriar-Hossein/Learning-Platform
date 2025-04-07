-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
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


-- Dumping database structure for lms_db
CREATE DATABASE IF NOT EXISTS `lms_db` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `lms_db`;

-- Dumping structure for table lms_db.admin
CREATE TABLE IF NOT EXISTS `admin` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

-- Dumping data for table lms_db.admin: ~1 rows (approximately)
INSERT INTO `admin` (`id`, `name`, `email`, `password`) VALUES
	(1, 'Super Admin', 'admin@gmail.com', 'admin');

-- Dumping structure for table lms_db.course
CREATE TABLE IF NOT EXISTS `course` (
  `course_id` int NOT NULL AUTO_INCREMENT,
  `instructor_id` int NOT NULL,
  `course_name` text CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL,
  `course_desc` text CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL,
  `course_author` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL,
  `course_img` text CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL,
  `course_duration` int NOT NULL DEFAULT '0',
  `course_price` int NOT NULL,
  `rating` int DEFAULT NULL,
  `total_reviews` int(10) unsigned zerofill DEFAULT NULL,
  PRIMARY KEY (`course_id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

-- Dumping data for table lms_db.course: ~13 rows (approximately)
INSERT INTO `course` (`course_id`, `instructor_id`, `course_name`, `course_desc`, `course_author`, `course_img`, `course_duration`, `course_price`, `rating`, `total_reviews`) VALUES
	(17, 5, 'Learn React Native', ' This is react native for android and iso app development                        ', 'GeekyShows', '../image/courseimg/Machine.jpg', 2, 200, NULL, NULL),
	(18, 5, 'DevOps', 'lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum', 'Maria', '../image/courseimg/devops-course.png', 2, 15000, 5, 0000000001),
	(19, 2, 'Tailwind CSS Extensive Course', 'lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum', 'Reja', '../image/courseimg/tailwindcss-course.png', 1, 4000, 2, 0000000001),
	(20, 4, 'Laravel Full Stack Web Development', 'lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum', 'Ms. Anu', '../image/courseimg/laravel.jpg', 1, 6000, 3, 0000000001),
	(21, 1, 'Machine Learning For Beginners', 'lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum', 'Tanvir ', '../image/courseimg/machine-learning-course.webp', 3, 4500, NULL, NULL),
	(22, 5, 'VueJS Intermediate Level', 'lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum', 'Shihab', '../image/courseimg/vuejs-course.png', 2, 7500, NULL, NULL),
	(23, 4, 'Competitive Programming', 'An extensive course for the beginners to learn fundamentals of competitive programming', 'Maria', '../image/courseimg/Why-Should-You-Do-Competitive-Programming.png', 1, 1800, 4, 0000000001),
	(24, 1, 'Advanced Competitive Programming ', 'lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum', 'Reja', '../image/courseimg/Why-Should-You-Do-Competitive-Programming.png', 2, 4500, NULL, NULL),
	(25, 4, 'VueJS Advanced Level', 'lorerm ipsum lorerm ipsum lorerm ipsum lorerm ipsum lorerm ipsum lorerm ipsum lorerm ipsum lorerm ipsum lorerm ipsum lorerm ipsum lorerm ipsum lorerm ipsum lorerm ipsum lorerm ipsum lorerm ipsum lorerm ipsum lorerm ipsum lorerm ipsum lorerm ipsum lorerm ipsum lorerm ipsum lorerm ipsum lorerm ipsum lorerm ipsum lorerm ipsum', 'Shihab', '../image/courseimg/vuejs-course.png', 3, 13000, NULL, NULL),
	(27, 2, 'DevOps', 'lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum ', 'Maria', '../image/courseimg/devops-course.png', 2, 7500, NULL, NULL),
	(28, 2, 'Cake PHP', 'lorem ipsum', 'Solo', '../image/courseimg/360_F_424244819_wTtw2Yusw2DAbyUkAcIQHo7hgFv9W0tJ.jpg', 3, 4500, NULL, NULL),
	(29, 6, 'Basic Computer', 'lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum            ', 'instructor', '../image/courseimg/360_F_424244819_wTtw2Yusw2DAbyUkAcIQHo7hgFv9W0tJ.jpg', 2, 2000, NULL, NULL),
	(30, 6, 'Computer basics 2', 'lorem ipsum', 'instructor', '../image/courseimg/360_F_424244819_wTtw2Yusw2DAbyUkAcIQHo7hgFv9W0tJ.jpg', 3, 2999, NULL, NULL);

-- Dumping structure for table lms_db.courseorder
CREATE TABLE IF NOT EXISTS `courseorder` (
  `co_id` int NOT NULL AUTO_INCREMENT,
  `order_id` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL,
  `stu_email` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL,
  `course_id` int NOT NULL,
  `status` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL,
  `respmsg` text CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL,
  `amount` int NOT NULL,
  `order_date` date NOT NULL,
  PRIMARY KEY (`co_id`),
  UNIQUE KEY `order_id` (`order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

-- Dumping data for table lms_db.courseorder: ~16 rows (approximately)
INSERT INTO `courseorder` (`co_id`, `order_id`, `stu_email`, `course_id`, `status`, `respmsg`, `amount`, `order_date`) VALUES
	(3, 'ORDS98956453', 'ant@example.com', 10, 'TXN_SUCCESS', 'Txn Success', 800, '2019-09-12'),
	(7, 'ORDS57717951', 'jay@ischool.com', 14, 'TXN_SUCCESS', 'Txn Success', 400, '2019-09-13'),
	(8, 'ORDS22968322', 'mario@ischool.com', 10, 'TXN_SUCCESS', 'Txn Success', 800, '2019-09-13'),
	(9, 'ORDS78666589', 'ignou@ischool.com', 10, 'TXN_SUCCESS', 'Txn Success', 800, '2019-09-19'),
	(10, 'ORDS59885531', 'sonam@gmail.com', 10, 'TXN_SUCCESS', 'Txn Success', 800, '2020-07-04'),
	(12, 'ORD123', 'ana@gmail.com', 10, 'TXN_SUCCESS', '', 1650, '0000-00-00'),
	(13, 'ORD 456', 'ant@example.com', 9, 'TXN_SUCCESS', '', 700, '2024-05-16'),
	(41, 'ORDS20053252', 'student3@gmail.com', 18, 'TXN_SUCCESS', '', 15000, '2025-01-29'),
	(42, 'ORDS63847924', 'student3@gmail.com', 17, 'TXN_SUCCESS', '', 200, '2025-01-29'),
	(44, 'ORDS80548923', 'student3@gmail.com', 23, 'TXN_SUCCESS', '', 1800, '2025-01-29'),
	(46, 'ORDS10623019', 'student3@gmail.com', 21, 'TXN_SUCCESS', '', 4500, '2025-01-29'),
	(47, 'ORDS53345256', 'student3@gmail.com', 20, 'TXN_SUCCESS', '', 6000, '2025-01-29'),
	(49, 'ORDS21788066', 'student3@gmail.com', 19, 'TXN_SUCCESS', '', 4000, '2025-01-29'),
	(53, 'ORDS78046091', 'student3@gmail.com', 29, 'TXN_SUCCESS', '', 2000, '2025-01-29'),
	(54, 'ORDS64118108', 'student1@gmail.com', 29, 'TXN_SUCCESS', '', 2000, '2025-01-29'),
	(63, 'ORDS35306148', 'ant@example.com', 20, 'TXN_SUCCESS', '', 6000, '2025-01-10');

-- Dumping structure for table lms_db.course_rating
CREATE TABLE IF NOT EXISTS `course_rating` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `course_id` int unsigned NOT NULL,
  `student_id` int unsigned NOT NULL,
  `rating` tinyint unsigned NOT NULL,
  `review` longtext,
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `course_id_student_id` (`course_id`,`student_id`),
  KEY `course_id` (`course_id`),
  KEY `student_id` (`student_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table lms_db.course_rating: ~4 rows (approximately)
INSERT INTO `course_rating` (`id`, `course_id`, `student_id`, `rating`, `review`) VALUES
	(1, 20, 186, 3, ''),
	(6, 18, 186, 5, ''),
	(7, 23, 191, 4, ''),
	(8, 19, 191, 2, '');

-- Dumping structure for table lms_db.feedback
CREATE TABLE IF NOT EXISTS `feedback` (
  `f_id` int NOT NULL AUTO_INCREMENT,
  `f_content` text CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL,
  `stu_id` int NOT NULL,
  PRIMARY KEY (`f_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

-- Dumping data for table lms_db.feedback: ~5 rows (approximately)
INSERT INTO `feedback` (`f_id`, `f_content`, `stu_id`) VALUES
	(3, 'My life at Marias School made me stronger and took me a step ahead for being an independent women. I am thankful to all the teachers who supported us and corrected us throughout our career. I am very grateful to the iSchool for providing us the best of placement opportunities and finally I got placed in DC Marvel.', 171),
	(8, 'I am grateful to Maria\'s School- both the faculty and the Training & Placement Department. They have made efforts ensuring maximum number of placed students. Due to the efforts made by the faculty and placement cell. I was able to bag a job in the second company.', 172),
	(9, 'Maria\'s School is a place of learning, fun, culture, lore, literature and many such life preaching activities. Studying at the iSchool brought an added value to my life.', 173),
	(10, 'Think Magical, that is one thing that Maria\'s School urges in and to far extent succeed in teaching to its students which invariably helps to achieve what you need.', 174),
	(12, 'Knowledge is power. Information is liberating. Education is the premise of progress, in every society, in every family.', 180);

-- Dumping structure for table lms_db.instructors
CREATE TABLE IF NOT EXISTS `instructors` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL,
  `email` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL,
  `password` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL,
  `image` text CHARACTER SET utf8mb3 COLLATE utf8mb3_bin,
  `occupation` varchar(50) DEFAULT NULL,
  `bio` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `name` (`name`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table lms_db.instructors: ~2 rows (approximately)
INSERT INTO `instructors` (`id`, `name`, `email`, `password`, `image`, `occupation`, `bio`) VALUES
	(5, 'test user', 'tester@gmail.com', '123456', '../image/instructors/411331701_1471496270135739_6085586201562565726_n (1).jpg', 'tester', 'testing the sign up '),
	(6, 'instructor12', 'instructor1@gmail.com', '123456', '../image/instructors/1000_F_223613686_2LXNahDJdD6i7TBGi8qKWxNhbaJKD116.jpg', 'teacher', 'undergrad teacher');

-- Dumping structure for table lms_db.lesson
CREATE TABLE IF NOT EXISTS `lesson` (
  `lesson_id` int NOT NULL AUTO_INCREMENT,
  `course_id` int NOT NULL,
  `course_name` text CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL,
  `lesson_name` text CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL,
  `lesson_desc` text CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL,
  `lesson_link` text CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL,
  `lesson_detail` text CHARACTER SET utf8mb3 COLLATE utf8mb3_bin,
  PRIMARY KEY (`lesson_id`),
  KEY `course_id` (`course_id`)
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

-- Dumping data for table lms_db.lesson: ~22 rows (approximately)
INSERT INTO `lesson` (`lesson_id`, `course_id`, `course_name`, `lesson_name`, `lesson_desc`, `lesson_link`, `lesson_detail`) VALUES
	(32, 10, 'Learn Python A-Z', 'Introduction to Python ', 'Introduction to Python Desc', '../lessonvid/video2.mp4', ''),
	(33, 10, 'Learn Python A-Z', 'How Python Works', 'How Python Works Descc', '../lessonvid/video3.mp4', ''),
	(34, 10, 'Learn Python A-Z', 'Why Python is powerful', 'Why Python is powerful Desc', '../lessonvid/video9.mp4', ''),
	(35, 10, 'Learn Python A-Z', 'Everyone should learn Python ', 'Everyone should learn Python  Desccc', '../lessonvid/video1.mp4', ''),
	(36, 9, 'Complete PHP Bootcamp', 'Introduction to PHP', 'Introduction to PHP Desc', '../lessonvid/video4.mp4', ''),
	(37, 9, 'Complete PHP Bootcamp', 'How PHP works', 'How PHP works Desc', '../lessonvid/video5.mp4', 'How does PHP work internally? In simple terms, PHP works by tokenizing, parsing, compiling, and executing. Tokenize: In this step, PHP checks the source code character by character. Then it creates tokens that are basically a simplified data structure for the next steps.'),
	(38, 9, 'Complete PHP Bootcamp', 'is PHP really easy ?', 'is PHP really easy ? desc', '../lessonvid/video6.mp4', ''),
	(39, 8, 'Learn Guitar The Easy Way', 'Introduction to Guitar44', 'Introduction to Guitar desc1', '../lessonvid/video7.mp4', ''),
	(40, 8, 'Learn Guitar The Easy Way', 'Type of Guitar', 'Type of Guitar Desc2', '../lessonvid/video8.mp4', ''),
	(41, 11, 'Hands-on Artificial Intelligence', 'Intro Hands-on Artificial Intelligence', 'Intro Hands-on Artificial Intelligence desc', '../lessonvid/video10.mp4', ''),
	(42, 11, 'Hands-on Artificial Intelligence', 'How it works', 'How it works descccccc', '../lessonvid/video11.mp4', ''),
	(43, 12, 'Learn Vue JS', 'Inro Learn Vue JS', 'Inro Learn Vue JS desc', '../lessonvid/video12.mp4', ''),
	(44, 13, 'Angular JS', 'intro Angular JS', 'intro Angular JS desc', '../lessonvid/video13.mp4', ''),
	(48, 16, 'Python Complete', 'Intro to Python Complete', 'This is lesson number 1', '../lessonvid/video11.mp4', ''),
	(49, 17, 'Learn React Native', 'Introduction to React Native', 'This intro video of React native', '../lessonvid/video11.mp4', ''),
	(50, 8, 'Learn the Guitar Easy way', 'Basic Techniques', 'Finger Exercises: Basic warm-ups and strengthening exercises.\r\nStrumming Patterns: Downstrokes, upstrokes, and basic rhythm patterns.\r\nChords: Open chords (C, G, D, E, A, Am, Em, Dm).\r\nReading Tablature: Understanding guitar tabs and chord diagrams', '../lessonvid/5659592-uhd_2160_4096_25fps.mp4', ''),
	(51, 8, 'Learn the Guitar Easy Way', 'Basic Cords', 'Guitar Course Outline', '../lessonvid/Guitar-Course-outline-.pdf', ''),
	(52, 9, 'Complete PHP Bootcamp', 'Coding structure', 'This is how php code works', '../lessonvid/5473808-uhd_4096_2160_25fps.mp4', ''),
	(53, 9, 'Complete PHP Bootcamp', 'coding-1', 'Php coding', '../lessonvid/6963744-hd_1920_1080_25fps.mp4', ''),
	(54, 9, 'Complete PHP Bootcamp', 'coding-2', 'php coding class 2', '../lessonvid/6963744-hd_1920_1080_25fps.mp4', ''),
	(55, 21, 'Machine Learning For Beginners', 'Topic-1', 'Testing lesson upload', '../lessonvid/5473808-uhd_4096_2160_25fps.mp4', NULL),
	(57, 29, 'Basic Computer', 'Topic-1', 'lorem ipsum lorem ipsum lorem ipsum                        ', '../lessonvid/video4.mp4', NULL);

-- Dumping structure for table lms_db.quiz
CREATE TABLE IF NOT EXISTS `quiz` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `course_id` int unsigned NOT NULL,
  `description` longtext,
  `file_link` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `title` text,
  `time` int DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  UNIQUE KEY `id` (`id`),
  KEY `course_id` (`course_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table lms_db.quiz: ~4 rows (approximately)
INSERT INTO `quiz` (`id`, `course_id`, `description`, `file_link`, `title`, `time`, `created_at`, `updated_at`) VALUES
	(9, 29, 'lorem ipsum lorem ipsum ', '../quizfiles/hq720.jpg', NULL, 50, '2025-02-09 21:44:25', '2025-02-09 21:44:25'),
	(10, 29, 'lorem ipsum lorem ipsum', '../quizfiles/hq720.jpg', NULL, 60, '2025-02-10 14:02:33', '2025-02-10 14:02:33'),
	(11, 29, 'lorem ipsum lorem ipsum lorem ipsum ', '../quizfiles/hq720.jpg', NULL, 30, '2025-02-10 14:05:12', '2025-02-10 14:05:12'),
	(12, 29, 'lroem ipsum lorem ipsum  lroem ipsum lorem ipsum lroem ipsum lorem ipsum lroem ipsum lorem ipsum lroem ipsum lorem ipsum lroem ipsum lorem ipsum lroem ipsum lorem ipsum lroem ipsum lorem ipsum lroem ipsum lorem ipsum lroem ipsum lorem ipsum lroem ipsum lorem ipsum lroem ipsum lorem ipsum lroem ipsum lorem ipsum lroem ipsum lorem ipsum lroem ipsum lorem ipsum lroem ipsum lorem ipsum lroem ipsum lorem ipsum lroem ipsum lorem ipsum lroem ipsum lorem ipsum lroem ipsum lorem ipsum lroem ipsum lorem ipsum lroem ipsum lorem ipsum lroem ipsum lorem ipsum lroem ipsum lorem ipsum lroem ipsum lorem ipsum lroem ipsum lorem ipsum lroem ipsum lorem ipsum lroem ipsum lorem ipsum lroem ipsum lorem ipsum lroem ipsum lorem ipsum lroem ipsum lorem ipsum lroem ipsum lorem ipsum lroem ipsum lorem ipsum lroem ipsum lorem ipsum lroem ipsum lorem ipsum lroem ipsum lorem ipsum lroem ipsum lorem ipsum lroem ipsum lorem ipsum lroem ipsum lorem ipsum lroem ipsum lorem ipsum lroem ipsum lorem ipsum lroem ipsum lorem ipsum lroem ipsum lorem ipsum lroem ipsum lorem ipsum lroem ipsum lorem ipsum lroem ipsum lorem ipsum lroem ipsum lorem ipsum lroem ipsum lorem ipsum lroem ipsum lorem ipsum lroem ipsum lorem ipsum lroem ipsum lorem ipsum lroem ipsum lorem ipsum lroem ipsum lorem ipsum lroem ipsum lorem ipsum lroem ipsum lorem ipsum lroem ipsum lorem ipsum lroem ipsum lorem ipsum lroem ipsum lorem ipsum lroem ipsum lorem ipsum lroem ipsum lorem ipsum lroem ipsum lorem ipsum lroem ipsum lorem ipsum lroem ipsum lorem ipsum lroem ipsum lorem ipsum lroem ipsum lorem ipsum lroem ipsum lorem ipsum lroem ipsum lorem ipsum lroem ipsum lorem ipsum lroem ipsum lorem ipsum lroem ipsum lorem ipsum lroem ipsum lorem ipsum ', '../quizfiles/hq720.jpg', NULL, 50, '2025-02-10 16:22:51', '2025-02-10 16:22:51');

-- Dumping structure for table lms_db.quiz_files
CREATE TABLE IF NOT EXISTS `quiz_files` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `quiz_id` int unsigned NOT NULL,
  `student_id` int unsigned NOT NULL,
  `feedback` text,
  `file_link` text,
  `score` int DEFAULT NULL,
  `attempted` int DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  UNIQUE KEY `id` (`id`),
  KEY `quiz_id` (`quiz_id`),
  KEY `student_id` (`student_id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table lms_db.quiz_files: ~4 rows (approximately)
INSERT INTO `quiz_files` (`id`, `quiz_id`, `student_id`, `feedback`, `file_link`, `score`, `attempted`, `created_at`, `updated_at`) VALUES
	(13, 9, 189, NULL, NULL, NULL, NULL, '2025-02-10 14:22:37', '2025-02-10 14:22:37'),
	(16, 10, 189, NULL, NULL, NULL, NULL, '2025-02-10 20:02:40', '2025-02-10 20:02:40'),
	(21, 12, 189, 'Satisfactory', '../uploads/quiz_submissions/67aa2d4d339b79.98212341.pdf', 79, NULL, '2025-02-10 22:45:14', '2025-02-10 22:46:05'),
	(22, 11, 189, NULL, NULL, NULL, NULL, '2025-02-10 22:49:37', '2025-02-10 22:49:37');

-- Dumping structure for table lms_db.student
CREATE TABLE IF NOT EXISTS `student` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL,
  `occupation` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL DEFAULT 'Student',
  `bio` text CHARACTER SET utf8mb3 COLLATE utf8mb3_bin,
  `image` text CHARACTER SET utf8mb3 COLLATE utf8mb3_bin,
  `user_type` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=197 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

-- Dumping data for table lms_db.student: ~10 rows (approximately)
INSERT INTO `student` (`id`, `name`, `email`, `password`, `occupation`, `bio`, `image`, `user_type`) VALUES
	(171, 'Jack', 'jack@gmail.com', '123456', '  Web Designer', NULL, '../image/stu/images.jpg', 'user'),
	(172, 'Nazia', 'nazia@gmail.com', '123456', ' Web Developer', NULL, '../image/stu/student4.jpg', 'user'),
	(173, 'Reza', 'reza@gmail.com', '123456', ' Web Developer', NULL, '../image/stu/student1.jpg', 'user'),
	(174, 'maria', 'maria@gmail.com', '123456', 'Web Designer', NULL, '../image/stu/student3.jpg', 'user'),
	(178, 'Rahim Mia', 'rahim@gmail.com', '1234567', ' Web Dev', NULL, '../image/stu/super-mario-2690254_1280.jpg', 'user'),
	(182, ' sonam', 'sonam@gmail.com', '123456', ' Web Dev', NULL, '../image/stu/student2.jpg', 'user'),
	(183, ' Ananna', 'ana@gmail.com', '456', ' ', NULL, '../image/stu/garden-rose-red-pink-56866.jpeg', 'user'),
	(189, 'student 1 ', 'student1@gmail.com', '123456', 'Student', 'Pursuing bachelors', '../image/stu/360_F_640070383_9LJ3eTRSvOiwKyrmBYgcjhSlckDnNcxl.jpg', NULL),
	(190, 'student 2', 'student2@gmail.com', '123456', 'student', 'studennt', '../image/stu/istockphoto-1310533180-612x612.jpg', NULL),
	(191, 'student 3 ', 'student3@gmail.com', '12345', 'student under grad', 'BSc Student', '../image/stu/photo-1484515991647-c5760fcecfc7.jpg', NULL);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
