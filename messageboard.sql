-- MySQL dump 10.13  Distrib 8.0.31, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: fdcjademarthy-nc-web
-- ------------------------------------------------------
-- Server version	8.0.31

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `message_details`
--

DROP TABLE IF EXISTS `message_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `message_details` (
  `id` int NOT NULL AUTO_INCREMENT,
  `message_id` int NOT NULL,
  `message` text NOT NULL,
  `sender_id` int NOT NULL,
  `recipient_id` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `message_details`
--

LOCK TABLES `message_details` WRITE;
/*!40000 ALTER TABLE `message_details` DISABLE KEYS */;
INSERT INTO `message_details` VALUES (1,1,'first message',1,2,'2024-03-12 14:50:07','2024-03-12 17:45:44'),(2,1,'Second Message',2,1,'2024-03-12 14:50:17','2024-03-12 17:45:44'),(3,1,'Third Message',2,1,'2024-03-12 14:51:52','2024-03-12 17:45:44'),(4,2,'1st message sa 2nd contact',3,2,'2024-03-12 14:54:06','2024-03-12 17:46:07'),(5,2,'second message 2nd contact',3,2,'2024-03-12 14:55:55','2024-03-12 17:46:07'),(6,2,'3rd',2,3,'2024-03-12 14:57:07','2024-03-12 17:46:07'),(7,5,'asdfasdf',1,3,'2024-03-12 15:29:12','2024-03-12 17:46:29'),(8,1,'last',1,2,'2024-03-12 15:30:28','2024-03-12 17:45:44'),(9,1,'wa jud',1,2,'2024-03-12 15:30:42','2024-03-12 17:45:44'),(10,5,'asdfgadsf',3,1,'2024-03-12 15:32:17','2024-03-12 17:46:29'),(11,1,'asdasdasdasgasdvzxcv',2,1,'2024-03-12 15:34:47','2024-03-12 17:45:44'),(12,1,'1',2,1,'2024-03-12 15:38:56','2024-03-12 17:45:44'),(13,2,'id 3 to id 2',3,2,'2024-03-12 15:39:52','2024-03-12 17:46:07'),(14,2,'id 2 to id 3',2,3,'2024-03-12 15:40:22','2024-03-12 17:46:07'),(15,9,'Hi Five!',3,5,'2024-03-12 17:42:51','2024-03-12 17:46:41'),(16,9,'Hi again five!',3,5,'2024-03-12 17:43:18','2024-03-12 17:46:41'),(17,9,'hi there three!',5,3,'2024-03-12 17:43:43','2024-03-12 17:46:41');
/*!40000 ALTER TABLE `message_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `messages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `first_user_id_in_thread` int NOT NULL,
  `second_user_id_in_thread` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messages`
--

LOCK TABLES `messages` WRITE;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
INSERT INTO `messages` VALUES (1,2,1,'2024-03-12 14:50:07','2024-03-12 15:38:56'),(2,3,2,'2024-03-12 14:54:06','2024-03-12 15:40:22'),(5,1,3,'2024-03-12 15:12:19','2024-03-12 15:12:19'),(9,3,5,'2024-03-12 17:42:51','2024-03-12 17:43:43');
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `profiles`
--

DROP TABLE IF EXISTS `profiles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `profiles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `name` varchar(30) NOT NULL,
  `profile_picture` text,
  `gender` enum('Male','Female') DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `hubby` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id_fk` (`user_id`),
  CONSTRAINT `user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `profiles`
--

LOCK TABLES `profiles` WRITE;
/*!40000 ALTER TABLE `profiles` DISABLE KEYS */;
INSERT INTO `profiles` VALUES (1,1,'Jade Test First','profile/profile-1-jade-test-first.png','Male','2000-03-12','asdf ','2024-03-12 08:07:41','2024-03-12 08:07:41'),(2,2,'jade test update','profile/profile-2-jade-test-update.png','Male','2000-03-12','My H','2024-03-12 08:07:41','2024-03-12 12:28:23'),(3,3,'Jade Test Three','profile/profile-pic.png',NULL,NULL,NULL,'2024-03-12 09:02:42','2024-03-12 09:02:42'),(4,4,'Jade Test Four','profile/profile-pic.png',NULL,NULL,NULL,'2024-03-12 17:32:56','2024-03-12 17:32:56'),(5,5,'Jade Test Five','profile/profile-5-jade-test-five.jpg','Male','2024-03-13','Just a hobby.','2024-03-12 17:38:04','2024-03-12 17:39:12');
/*!40000 ALTER TABLE `profiles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(30) NOT NULL,
  `password` text NOT NULL,
  `last_login_time` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'jadetest@test.com','$2a$10$S4qqxo2GuNpHDqqIXvS.Ge5D2EawIDflHCQuxYB1JS22KmApF0F/G',NULL,'2024-03-12 05:06:44','2024-03-12 05:06:44'),(2,'jadetest2@test.com','$2a$10$VjHuF6mSnyx07m0YjVeGc.vJI/WS8Rq/W9AqycI7SJp/ZqtdIOzuW','2024-03-13 00:35:59','2024-03-12 05:56:27','2024-03-12 16:35:59'),(3,'jadetest3@test.com','$2a$10$Vfti7otH4pFxlUV1dnRxyO/sRNdaHPsk614Gqv9l9PPNa8OxjoCqq','2024-03-12 23:39:27','2024-03-12 09:02:42','2024-03-12 15:39:27'),(4,'jadetest4@test.com','$2a$10$UhxK25G6nu9ladnXvd/a1O4eyMkXSEpamGWaX87sqBba/p8rJLdkq',NULL,'2024-03-12 17:32:56','2024-03-12 17:32:56'),(5,'jadetest5@test.com','$2a$10$S5tcSREzH6DlVQ36Ne3IAuaJp2vIW1lNMyg0rx8hz/ln6HStipS92',NULL,'2024-03-12 17:38:04','2024-03-12 17:38:04');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-03-13  1:53:59
