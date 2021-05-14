-- MySQL dump 10.13  Distrib 8.0.23, for Linux (x86_64)
--
-- Host: localhost    Database: your_database_name
-- ------------------------------------------------------
-- Server version	8.0.23-0ubuntu0.20.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `activitys`
--

DROP TABLE IF EXISTS `activitys`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `activitys` (
  `activity_id` int NOT NULL AUTO_INCREMENT,
  `activity_description` varchar(255) NOT NULL,
  PRIMARY KEY (`activity_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activitys`
--

LOCK TABLES `activitys` WRITE;
/*!40000 ALTER TABLE `activitys` DISABLE KEYS */;
INSERT INTO `activitys` VALUES (1,'New lead assigned\r\n'),(2,'Lead was called\r\n'),(3,'GC Feedback updated\r\n'),(4,'Trial scheduled\r\n'),(5,'Trainer feedback updated'),(6,'Followup taken\r\n'),(7,'Followup date updated\r\n'),(8,'Deal value set\r\n'),(9,'Lead status- Manual update\r\n'),(10,'Converted Lead\r\n'),(11,'Rejected Lead\r\n');
/*!40000 ALTER TABLE `activitys` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `feedbacks`
--

DROP TABLE IF EXISTS `feedbacks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `feedbacks` (
  `feedbacks_id` int NOT NULL AUTO_INCREMENT,
  `feedback_lead_id` int NOT NULL,
  `feedback_title` text NOT NULL,
  `feedback_date` datetime NOT NULL,
  `feedback_enquiry` varchar(255) NOT NULL,
  `feedback_gcfeedback` varchar(255) NOT NULL,
  `feedback_trainer` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `feedback_trainerfeedback` varchar(255) NOT NULL,
  `feedback_leadstatus` varchar(255) NOT NULL,
  `feedback_leadvalue` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`feedbacks_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `feedbacks`
--

LOCK TABLES `feedbacks` WRITE;
/*!40000 ALTER TABLE `feedbacks` DISABLE KEYS */;
INSERT INTO `feedbacks` VALUES (1,6,'Trial set for 5pm','2021-05-06 16:08:18','English','Ready to enroll',NULL,'Intermediate to advance','Lead_Enrolled',5000),(2,1,'','2021-05-06 16:13:59','','',NULL,'','Not_responding',0),(3,7,'','2021-05-06 16:19:48','','',NULL,'','Not_Interested',0),(4,2,'','2021-05-06 16:23:08','','',NULL,'','',0),(5,3,'Call back requested','2021-05-06 16:23:13','','',NULL,'','Not_Interested',0),(6,8,'Trial booked for today','2021-05-06 20:05:23','Communication','Will enroll tomorrow',NULL,'Received','Lead_Enrolled',5000);
/*!40000 ALTER TABLE `feedbacks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `leads`
--

DROP TABLE IF EXISTS `leads`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `leads` (
  `lead_id` int NOT NULL AUTO_INCREMENT,
  `lead_user_id` int NOT NULL,
  `lead_assigned` varchar(255) NOT NULL,
  `lead_email` varchar(255) NOT NULL,
  `lead_name` varchar(255) NOT NULL,
  `lead_phonenumber` varchar(12) NOT NULL,
  `lead_jobtitle` varchar(255) NOT NULL,
  `lead_status` varchar(255) NOT NULL,
  `lead_callcount` int NOT NULL,
  `lead_date` date NOT NULL,
  `lead_trail_date` date NOT NULL,
  `lead_trail_time` time NOT NULL,
  `lead_followupdate` date NOT NULL,
  PRIMARY KEY (`lead_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `leads`
--

LOCK TABLES `leads` WRITE;
/*!40000 ALTER TABLE `leads` DISABLE KEYS */;
INSERT INTO `leads` VALUES (1,1,'bidhan','sibu@gmail.com','sibu','9657555482','software devoloper','form logicmistry',8,'2021-05-06','0000-00-00','00:00:00','0000-00-00'),(2,1,'ram','rohit@gmail.com','rohit','1254879658','teacher','none',5,'2021-05-06','0000-00-00','00:00:00','0000-00-00'),(3,1,'rajes','raju12@gmail.com','raju','9874562580','engineer','none',3,'2021-05-06','0000-00-00','00:00:00','0000-00-00'),(6,1,'OK','abc@gmail.com','abc','9875614752','non','active',1,'2021-05-06','2021-05-06','16:00:00','2021-05-06'),(7,1,'iii','fgd@gmail.com','ooo','9654485258','yy','yy',5,'2021-05-06','0000-00-00','00:00:00','2021-05-08'),(8,1,'Logicmystery','das@gmail.com','Banerjz','9083425578','njutj7t8olio','',0,'2021-05-06','2021-05-06','20:30:00','2021-05-06');
/*!40000 ALTER TABLE `leads` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mapleadactivity`
--

DROP TABLE IF EXISTS `mapleadactivity`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mapleadactivity` (
  `mapleadactivity_id` int NOT NULL AUTO_INCREMENT,
  `mapactivity_lead_id` int NOT NULL,
  `mapactivity_activity_id` int NOT NULL,
  `mapleadactivity_date` datetime NOT NULL,
  `mapleadactivity_value` varchar(200) NOT NULL,
  PRIMARY KEY (`mapleadactivity_id`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mapleadactivity`
--

LOCK TABLES `mapleadactivity` WRITE;
/*!40000 ALTER TABLE `mapleadactivity` DISABLE KEYS */;
INSERT INTO `mapleadactivity` VALUES (1,3,3,'2021-05-06 16:07:52','zgkzjg'),(2,6,1,'2021-05-06 16:08:18','Lead assigned'),(3,6,2,'2021-05-06 16:08:41','Lead was called'),(4,6,3,'2021-05-06 16:08:58','Trial set for 5pm'),(5,6,4,'2021-05-06 16:09:38','2021-05-06'),(6,6,4,'2021-05-06 16:09:38','17:00:00'),(7,6,4,'2021-05-06 16:09:52','22:00:00'),(8,6,4,'2021-05-06 16:10:45','16:00:00'),(9,6,5,'2021-05-06 16:11:18','Intermediate to advance'),(10,6,7,'2021-05-06 16:11:32','2021-05-07'),(11,6,2,'2021-05-06 16:11:47','Lead was called'),(12,6,6,'2021-05-06 16:12:00','Ready to enroll'),(13,6,8,'2021-05-06 16:12:17','5000'),(14,6,10,'2021-05-06 16:12:35','LeadEnrolled'),(15,1,1,'2021-05-06 16:13:59','Lead assigned'),(16,1,11,'2021-05-06 16:14:11','Status Manual update'),(17,1,9,'2021-05-06 16:14:52','Status Manual update'),(18,7,1,'2021-05-06 16:19:48','Lead assigned'),(19,7,7,'2021-05-06 16:20:01','2021-05-08'),(20,7,7,'2021-05-06 16:20:17','2021-05-08'),(21,2,1,'2021-05-06 16:23:08','Lead assigned'),(22,3,1,'2021-05-06 16:23:13','Lead assigned'),(23,3,2,'2021-05-06 16:24:52','Lead was called'),(24,3,3,'2021-05-06 16:25:11','Call back requested'),(25,3,7,'2021-05-06 16:25:23','2021-05-08'),(26,3,11,'2021-05-06 16:27:39','Status Manual update'),(27,7,7,'2021-05-06 16:45:10','2021-05-08'),(28,7,11,'2021-05-06 16:47:59','Status Manual update'),(29,8,1,'2021-05-06 20:05:23','Lead assigned'),(30,6,2,'2021-05-06 21:34:29','Lead was called'),(31,8,2,'2021-05-06 21:36:03','Lead was called'),(32,8,3,'2021-05-06 21:36:28','Not looking'),(33,8,2,'2021-05-06 21:36:44','Lead was called'),(34,8,3,'2021-05-06 21:36:59','Trial booked for today'),(35,8,4,'2021-05-06 21:37:33','2021-05-06'),(36,8,4,'2021-05-06 21:37:33','20:30:00'),(37,8,5,'2021-05-06 21:38:18','Received'),(38,8,2,'2021-05-06 21:38:41','Lead was called'),(39,8,6,'2021-05-06 21:39:00','Will enroll tomorrow'),(40,8,7,'2021-05-06 21:39:16','2021-05-07'),(41,8,7,'2021-05-06 21:39:55','2021-05-07'),(42,8,8,'2021-05-06 21:40:44','5000'),(43,8,10,'2021-05-06 21:40:55','LeadEnrolled');
/*!40000 ALTER TABLE `mapleadactivity` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `users_id` int NOT NULL AUTO_INCREMENT,
  `users_name` varchar(255) NOT NULL,
  `users_email` varchar(255) NOT NULL,
  `users_password` varchar(15) NOT NULL,
  PRIMARY KEY (`users_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'support','support@logicmystery.com','123'),(3,'sibaprasad','sibaprasad@logimystery.work','sibu'),(4,'banerjz','banerjz@gmail.com','banerjz');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'your_database_name'
--

--
-- Dumping routines for database 'your_database_name'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-05-14  5:21:40
