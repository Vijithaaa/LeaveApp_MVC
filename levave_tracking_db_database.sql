-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: leave_tracking_db
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin` (
  `name` varchar(5) DEFAULT NULL,
  `pass` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin`
--

LOCK TABLES `admin` WRITE;
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` VALUES ('admin','admin');
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `employee_detail`
--

DROP TABLE IF EXISTS `employee_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `employee_detail` (
  `employee_id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_name` varchar(30) NOT NULL,
  `emp_email_id` varchar(40) DEFAULT NULL,
  `gender` varchar(6) DEFAULT NULL,
  `date_of_joining` date DEFAULT NULL,
  `status` enum('active','in_active') DEFAULT 'active',
  `role_id` int(11) DEFAULT NULL,
  `employee_image` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`employee_id`),
  UNIQUE KEY `emp_email_id` (`emp_email_id`),
  KEY `fk_role` (`role_id`),
  CONSTRAINT `fk_role` FOREIGN KEY (`role_id`) REFERENCES `role_detail` (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employee_detail`
--

LOCK TABLES `employee_detail` WRITE;
/*!40000 ALTER TABLE `employee_detail` DISABLE KEYS */;
INSERT INTO `employee_detail` VALUES (1,'viji','viji@gmail.com','female','2025-03-10','active',2,'assets/images/employees/emp_1.jpeg'),(2,'ken','ken@gmail.com','male','2025-06-13','active',1,'assets/images/employees/emp_2.jpeg'),(3,'vasanth','vasanth@gmail.com','male','2025-03-10','active',1,'assets/images/employees/emp_2.jpeg'),(4,'priya','priya@gmail.com','female','2024-12-16','active',4,'assets/images/employees/emp_3.jpeg'),(5,'divya','divya@gmail.com','female','2025-06-15','active',3,'assets/images/employees/emp_1.jpeg'),(6,'shaki','shaki@gmail.com','female','2025-01-28','active',2,'assets/images/employees/emp_1.jpeg'),(7,'moneeish','moneeish@gmail.com','male','2025-03-10','active',1,'assets/images/employees/emp_2.jpeg'),(8,'vm','vm@gmail.com','male','2025-03-16','active',1,'assets/images/employees/emp_4.jpeg'),(9,'sabitha','sabitha@gmail.com','female','2025-06-16','active',4,'assets/images/employees/emp_3.jpeg');
/*!40000 ALTER TABLE `employee_detail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `leave_application`
--

DROP TABLE IF EXISTS `leave_application`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `leave_application` (
  `application_id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) DEFAULT NULL,
  `leave_type_id` int(11) DEFAULT NULL,
  `leave_start_date` date DEFAULT NULL,
  `leave_end_date` date DEFAULT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `reqested_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `response_date` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`application_id`),
  KEY `fk_emp_id_app` (`employee_id`),
  KEY `fk_leave_type_app` (`leave_type_id`),
  CONSTRAINT `fk_emp_id_app` FOREIGN KEY (`employee_id`) REFERENCES `employee_detail` (`employee_id`),
  CONSTRAINT `fk_leave_type_app` FOREIGN KEY (`leave_type_id`) REFERENCES `leave_types` (`leave_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `leave_application`
--

LOCK TABLES `leave_application` WRITE;
/*!40000 ALTER TABLE `leave_application` DISABLE KEYS */;
INSERT INTO `leave_application` VALUES (1,2,1,'2025-06-13','2025-06-13','approved','2025-06-13 17:07:51','2025-06-14 06:37:18'),(2,1,1,'2025-06-28','2025-06-28','approved','2025-06-13 17:15:02','2025-06-15 05:43:17'),(4,2,2,'2025-06-13','2025-06-13','rejected','2025-06-13 17:35:23','2025-06-13 17:58:20'),(5,1,1,'2025-06-13','2025-06-13','approved','2025-06-13 17:57:51','2025-06-13 17:58:17'),(7,3,1,'2025-06-15','2025-06-15','approved','2025-06-15 05:43:40','0000-00-00 00:00:00'),(8,3,2,'2025-06-15','2025-06-16','approved','2025-06-15 05:43:50','2025-06-15 16:05:47'),(9,1,2,'2025-06-15','2025-06-15','approved','2025-06-15 16:18:47','2025-06-16 05:38:33'),(11,3,2,'2025-06-15','2025-06-18','approved','0000-00-00 00:00:00','0000-00-00 00:00:00'),(14,6,2,'2025-07-05','2025-07-05','rejected','0000-00-00 00:00:00','0000-00-00 00:00:00'),(16,6,1,'2025-06-16','2025-06-16','approved','2025-06-16 07:13:43','2025-06-16 05:38:29'),(17,6,1,'2025-06-16','2025-06-17','approved','2025-06-16 04:01:49','2025-06-16 05:38:24'),(18,1,1,'2025-06-16','2025-06-20','approved','2025-06-16 04:00:17','2025-06-16 05:38:26'),(19,8,1,'2025-06-16','2025-06-25','approved','2025-06-16 06:10:32','2025-06-16 06:11:28'),(21,8,1,'2025-06-16','2025-06-16','rejected','2025-06-16 09:42:54','2025-06-16 06:13:12'),(22,1,2,'2025-06-16','2025-06-16','pending','2025-06-16 14:12:35',NULL),(23,6,1,'2025-06-16','2025-06-17','approved','2025-06-16 08:12:30','2025-06-16 12:07:46'),(24,6,1,'2025-06-16','2025-06-16','pending','2025-06-16 11:28:08',NULL),(26,6,1,'2025-06-16','2025-06-16','pending','2025-06-16 11:41:09',NULL),(27,6,1,'2025-06-16','2025-06-16','pending','2025-06-16 11:42:41',NULL),(29,6,1,'2025-06-16','2025-06-16','pending','2025-06-16 11:51:12',NULL),(30,6,1,'2025-06-16','2025-06-16','pending','2025-06-16 11:51:20',NULL),(31,6,1,'2025-06-16','2025-06-16','pending','2025-06-16 11:51:36',NULL),(32,6,1,'2025-06-16','2025-06-16','pending','2025-06-16 11:51:54',NULL),(33,6,1,'2025-06-16','2025-06-16','pending','2025-06-16 11:52:05',NULL),(34,6,1,'2025-06-16','2025-06-16','pending','2025-06-16 11:52:24',NULL),(35,6,1,'2025-06-16','2025-06-16','pending','2025-06-16 11:52:50',NULL),(36,6,1,'2025-06-16','2025-06-16','rejected','2025-06-16 11:53:35','2025-06-16 09:36:43'),(37,NULL,1,'2025-06-16','2025-06-16','rejected','2025-06-16 12:08:23','2025-06-16 09:36:37'),(38,NULL,1,'2025-06-16','2025-06-16','rejected','2025-06-16 12:09:12','2025-06-16 09:36:40'),(39,NULL,1,'2025-06-16','2025-06-16','rejected','2025-06-16 12:09:26','2025-06-16 12:07:07'),(40,6,2,'2025-06-16','2025-06-16','pending','2025-06-16 12:11:15',NULL),(41,6,2,'2025-06-16','2025-06-16','pending','2025-06-16 12:11:26',NULL),(43,6,2,'2025-06-16','2025-06-16','pending','2025-06-16 12:24:16',NULL),(44,6,2,'2025-06-16','2025-06-16','pending','2025-06-16 12:25:45',NULL),(45,6,2,'2025-06-16','2025-06-16','pending','2025-06-16 12:28:01',NULL),(47,6,2,'2025-06-16','2025-06-16','pending','2025-06-16 12:29:10',NULL),(51,6,2,'2025-06-16','2025-06-16','pending','2025-06-16 12:33:24',NULL),(54,6,2,'2025-06-16','2025-06-16','pending','2025-06-16 12:36:34',NULL),(55,6,2,'2025-06-16','2025-06-16','pending','2025-06-16 12:37:56',NULL),(56,6,2,'2025-06-16','2025-06-16','pending','2025-06-16 12:37:58',NULL),(57,6,2,'2025-06-16','2025-06-16','pending','2025-06-16 12:38:00',NULL),(58,6,2,'2025-06-16','2025-06-16','approved','2025-06-16 12:38:05','2025-06-16 14:14:12'),(59,6,2,'2025-06-16','2025-06-16','pending','2025-06-16 12:38:07',NULL),(61,6,2,'2025-06-16','2025-06-16','rejected','2025-06-16 12:38:40','2025-06-16 14:14:18'),(62,6,2,'2025-06-16','2025-06-16','pending','2025-06-16 12:38:43',NULL),(63,6,2,'2025-06-16','2025-06-16','pending','2025-06-16 12:38:47',NULL),(64,6,2,'2025-06-16','2025-06-16','pending','2025-06-16 12:39:22',NULL),(65,6,2,'2025-06-16','2025-06-16','rejected','2025-06-16 12:41:54','2025-06-16 14:14:14'),(66,1,1,'2025-06-16','2025-06-16','pending','2025-06-16 15:28:37',NULL),(68,1,1,'2025-06-16','2025-06-16','rejected','2025-06-16 15:42:03','2025-06-16 14:53:54'),(70,9,2,'2025-06-16','2025-06-16','approved','2025-06-16 16:53:33','2025-06-16 13:24:05'),(71,9,1,'2025-06-17','2025-06-17','pending','2025-06-16 21:52:49',NULL),(72,9,2,'2025-06-16','2025-06-17','approved','2025-06-16 14:53:19','2025-06-16 14:53:50');
/*!40000 ALTER TABLE `leave_application` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `leave_tracking`
--

DROP TABLE IF EXISTS `leave_tracking`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `leave_tracking` (
  `employee_id` int(11) DEFAULT NULL,
  `leave_type_id` int(11) DEFAULT NULL,
  `leave_taken` int(11) DEFAULT NULL,
  KEY `fk_emp_id` (`employee_id`),
  KEY `fk_leave_typ_id` (`leave_type_id`),
  CONSTRAINT `fk_emp_id` FOREIGN KEY (`employee_id`) REFERENCES `employee_detail` (`employee_id`),
  CONSTRAINT `fk_leave_typ_id` FOREIGN KEY (`leave_type_id`) REFERENCES `leave_types` (`leave_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `leave_tracking`
--

LOCK TABLES `leave_tracking` WRITE;
/*!40000 ALTER TABLE `leave_tracking` DISABLE KEYS */;
INSERT INTO `leave_tracking` VALUES (1,1,1),(2,1,1),(1,1,1),(3,2,2),(3,1,1),(3,2,4),(6,1,2),(1,1,5),(6,1,1),(1,2,1),(8,1,10),(6,1,2),(9,2,1),(6,2,1),(9,2,2);
/*!40000 ALTER TABLE `leave_tracking` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `leave_types`
--

DROP TABLE IF EXISTS `leave_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `leave_types` (
  `leave_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `leave_name` varchar(30) DEFAULT NULL,
  `max_days_of_leave` int(11) DEFAULT NULL,
  PRIMARY KEY (`leave_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `leave_types`
--

LOCK TABLES `leave_types` WRITE;
/*!40000 ALTER TABLE `leave_types` DISABLE KEYS */;
INSERT INTO `leave_types` VALUES (1,'casual_leave',12),(2,'sick_leave',12);
/*!40000 ALTER TABLE `leave_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_detail`
--

DROP TABLE IF EXISTS `role_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `role_detail` (
  `role_id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_detail`
--

LOCK TABLES `role_detail` WRITE;
/*!40000 ALTER TABLE `role_detail` DISABLE KEYS */;
INSERT INTO `role_detail` VALUES (1,'developer'),(2,'manager'),(3,'hr'),(4,'tester');
/*!40000 ALTER TABLE `role_detail` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-06-17  7:48:06
