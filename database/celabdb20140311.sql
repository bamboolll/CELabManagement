CREATE DATABASE  IF NOT EXISTS `celabdb` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `celabdb`;
-- MySQL dump 10.13  Distrib 5.5.35, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: celabdb
-- ------------------------------------------------------
-- Server version	5.5.35-0ubuntu0.12.04.2

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `DeviceName`
--

DROP TABLE IF EXISTS `DeviceName`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `DeviceName` (
  `device_id` int(11) NOT NULL,
  `device_name` varchar(80) DEFAULT NULL,
  `no_total` int(11) DEFAULT NULL,
  `no_available` int(11) DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`device_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `DeviceName`
--

LOCK TABLES `DeviceName` WRITE;
/*!40000 ALTER TABLE `DeviceName` DISABLE KEYS */;
INSERT INTO `DeviceName` VALUES (0,'Board DE2',40,40,'Altera'),(1,'Board PIC',20,20,'_'),(2,'PIC Extension Matrix Board',20,20,'_'),(3,'PIC LCD Board mini',20,20,'_'),(4,'PIC Extension LCD Board',20,20,'_'),(5,'PIC USB Cable',20,20,'_'),(6,'Board 8951',20,20,'_'),(7,'Com Cable 8951',20,20,'_'),(8,'USB Cable 8951',20,20,'_'),(9,'Real Time Clock 8951',20,20,'_'),(10,'Board H8',20,20,'_'),(11,'Board H8+Extension',1,1,'_'),(12,'T-Engine',37,37,'_'),(13,'LCD Touch Screen for DE2',5,5,'_'),(14,'Camera for DE2',10,10,'_'),(15,'Máy Tính',40,40,'_'),(16,'Màn Hình',40,40,'_'),(17,'Server IBM',1,1,'_'),(18,'Stellaris 3748',5,5,'Texas Instruments'),(19,'Stellaris 6965',5,5,'Texas Instruments');
/*!40000 ALTER TABLE `DeviceName` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `BorrowType`
--

DROP TABLE IF EXISTS `BorrowType`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `BorrowType` (
  `type_id` int(11) NOT NULL,
  `type_name` varchar(80) DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `BorrowType`
--

LOCK TABLES `BorrowType` WRITE;
/*!40000 ALTER TABLE `BorrowType` DISABLE KEYS */;
INSERT INTO `BorrowType` VALUES (0,'Tai phong','Muon va su dung trong phong lab'),(1,'Ve nha','Muon va su dung ngoai phong lab');
/*!40000 ALTER TABLE `BorrowType` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `LabLog`
--

DROP TABLE IF EXISTS `LabLog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `LabLog` (
  `log_id` int(11) NOT NULL,
  `unit_id` int(11) NOT NULL,
  `borrower_name` varchar(80) NOT NULL,
  `borrower_id` varchar(45) DEFAULT NULL,
  `receive_date` datetime NOT NULL,
  `return_date` datetime DEFAULT NULL,
  `borrow_type` int(11) NOT NULL,
  `status_id` int(11) DEFAULT NULL,
  `log_description` text,
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `LabLog`
--

LOCK TABLES `LabLog` WRITE;
/*!40000 ALTER TABLE `LabLog` DISABLE KEYS */;
/*!40000 ALTER TABLE `LabLog` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `session_log`
--

DROP TABLE IF EXISTS `session_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `session_log` (
  `session_id` varchar(50) NOT NULL DEFAULT '',
  `user_id` bigint(20) DEFAULT NULL,
  `remote_ip` varchar(100) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `start` datetime DEFAULT NULL,
  `last_access` datetime DEFAULT NULL,
  PRIMARY KEY (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `session_log`
--

LOCK TABLES `session_log` WRITE;
/*!40000 ALTER TABLE `session_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `session_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Device_Tag`
--

DROP TABLE IF EXISTS `Device_Tag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Device_Tag` (
  `unit_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  PRIMARY KEY (`unit_id`,`tag_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Device_Tag`
--

LOCK TABLES `Device_Tag` WRITE;
/*!40000 ALTER TABLE `Device_Tag` DISABLE KEYS */;
/*!40000 ALTER TABLE `Device_Tag` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Tag`
--

DROP TABLE IF EXISTS `Tag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Tag` (
  `tag_id` int(11) NOT NULL,
  `tag_name` varchar(80) DEFAULT NULL,
  `tag_description` text,
  PRIMARY KEY (`tag_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Tag`
--

LOCK TABLES `Tag` WRITE;
/*!40000 ALTER TABLE `Tag` DISABLE KEYS */;
/*!40000 ALTER TABLE `Tag` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(50) DEFAULT NULL,
  `pass` blob,
  `power` int(11) NOT NULL DEFAULT '2',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (0,'admin','vnhcmut',0),(1,'user','passuser',1),(2,'stranger','passstranger',2);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `BorrowStatus`
--

DROP TABLE IF EXISTS `BorrowStatus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `BorrowStatus` (
  `status_id` int(11) NOT NULL,
  `status_name` varchar(45) DEFAULT NULL,
  `status_description` text,
  PRIMARY KEY (`status_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `BorrowStatus`
--

LOCK TABLES `BorrowStatus` WRITE;
/*!40000 ALTER TABLE `BorrowStatus` DISABLE KEYS */;
INSERT INTO `BorrowStatus` VALUES (0,'Muon muon','Muon muon va dang cho duoc accept'),(1,'Dang muon','Dang muon va chua co y dinh tra'),(2,'Muon tra','Muon tra va dang cho duoc accept'),(3,'Da tra','Da tra mot cach thanh cong'),(5,'Reject','Do mot so van de, khong the cho muon');
/*!40000 ALTER TABLE `BorrowStatus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `DeviceUnit`
--

DROP TABLE IF EXISTS `DeviceUnit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `DeviceUnit` (
  `unit_id` int(11) NOT NULL,
  `device_id` int(11) DEFAULT NULL,
  `unit_code` varchar(45) DEFAULT NULL,
  `description` text,
  `status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`unit_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `DeviceUnit`
--

LOCK TABLES `DeviceUnit` WRITE;
/*!40000 ALTER TABLE `DeviceUnit` DISABLE KEYS */;
INSERT INTO `DeviceUnit` VALUES (0,0,'0 - 0','Board DE2 - Altera - 0',1),(1,0,'0 - 1','Board DE2 - Altera - 1',1),(2,0,'0 - 2','Board DE2 - Altera - 2',1),(3,0,'0 - 3','Board DE2 - Altera - 3',1),(4,0,'0 - 4','Board DE2 - Altera - 4',1),(5,0,'0 - 5','Board DE2 - Altera - 5',1),(6,0,'0 - 6','Board DE2 - Altera - 6',1),(7,0,'0 - 7','Board DE2 - Altera - 7',1),(8,0,'0 - 8','Board DE2 - Altera - 8',1),(9,0,'0 - 9','Board DE2 - Altera - 9',1),(10,0,'0 - 10','Board DE2 - Altera - 10',1),(11,0,'0 - 11','Board DE2 - Altera - 11',1),(12,0,'0 - 12','Board DE2 - Altera - 12',1),(13,0,'0 - 13','Board DE2 - Altera - 13',1),(14,0,'0 - 14','Board DE2 - Altera - 14',1),(15,0,'0 - 15','Board DE2 - Altera - 15',1),(16,0,'0 - 16','Board DE2 - Altera - 16',1),(17,0,'0 - 17','Board DE2 - Altera - 17',1),(18,0,'0 - 18','Board DE2 - Altera - 18',1),(19,0,'0 - 19','Board DE2 - Altera - 19',1),(20,0,'0 - 20','Board DE2 - Altera - 20',1),(21,0,'0 - 21','Board DE2 - Altera - 21',1),(22,0,'0 - 22','Board DE2 - Altera - 22',1),(23,0,'0 - 23','Board DE2 - Altera - 23',1),(24,0,'0 - 24','Board DE2 - Altera - 24',1),(25,0,'0 - 25','Board DE2 - Altera - 25',1),(26,0,'0 - 26','Board DE2 - Altera - 26',1),(27,0,'0 - 27','Board DE2 - Altera - 27',1),(28,0,'0 - 28','Board DE2 - Altera - 28',1),(29,0,'0 - 29','Board DE2 - Altera - 29',1),(30,0,'0 - 30','Board DE2 - Altera - 30',1),(31,0,'0 - 31','Board DE2 - Altera - 31',1),(32,0,'0 - 32','Board DE2 - Altera - 32',1),(33,0,'0 - 33','Board DE2 - Altera - 33',1),(34,0,'0 - 34','Board DE2 - Altera - 34',1),(35,0,'0 - 35','Board DE2 - Altera - 35',1),(36,0,'0 - 36','Board DE2 - Altera - 36',1),(37,0,'0 - 37','Board DE2 - Altera - 37',1),(38,0,'0 - 38','Board DE2 - Altera - 38',1),(39,0,'0 - 39','Board DE2 - Altera - 39',1),(40,1,'1 - 0','Board PIC - _ - 0',1),(41,1,'1 - 1','Board PIC - _ - 1',1),(42,1,'1 - 2','Board PIC - _ - 2',1),(43,1,'1 - 3','Board PIC - _ - 3',1),(44,1,'1 - 4','Board PIC - _ - 4',1),(45,1,'1 - 5','Board PIC - _ - 5',1),(46,1,'1 - 6','Board PIC - _ - 6',1),(47,1,'1 - 7','Board PIC - _ - 7',1),(48,1,'1 - 8','Board PIC - _ - 8',1),(49,1,'1 - 9','Board PIC - _ - 9',1),(50,1,'1 - 10','Board PIC - _ - 10',1),(51,1,'1 - 11','Board PIC - _ - 11',1),(52,1,'1 - 12','Board PIC - _ - 12',1),(53,1,'1 - 13','Board PIC - _ - 13',1),(54,1,'1 - 14','Board PIC - _ - 14',1),(55,1,'1 - 15','Board PIC - _ - 15',1),(56,1,'1 - 16','Board PIC - _ - 16',1),(57,1,'1 - 17','Board PIC - _ - 17',1),(58,1,'1 - 18','Board PIC - _ - 18',1),(59,1,'1 - 19','Board PIC - _ - 19',1),(60,2,'2 - 0','PIC Extension Matrix Board - _ - 0',1),(61,2,'2 - 1','PIC Extension Matrix Board - _ - 1',1),(62,2,'2 - 2','PIC Extension Matrix Board - _ - 2',1),(63,2,'2 - 3','PIC Extension Matrix Board - _ - 3',1),(64,2,'2 - 4','PIC Extension Matrix Board - _ - 4',1),(65,2,'2 - 5','PIC Extension Matrix Board - _ - 5',1),(66,2,'2 - 6','PIC Extension Matrix Board - _ - 6',1),(67,2,'2 - 7','PIC Extension Matrix Board - _ - 7',1),(68,2,'2 - 8','PIC Extension Matrix Board - _ - 8',1),(69,2,'2 - 9','PIC Extension Matrix Board - _ - 9',1),(70,2,'2 - 10','PIC Extension Matrix Board - _ - 10',1),(71,2,'2 - 11','PIC Extension Matrix Board - _ - 11',1),(72,2,'2 - 12','PIC Extension Matrix Board - _ - 12',1),(73,2,'2 - 13','PIC Extension Matrix Board - _ - 13',1),(74,2,'2 - 14','PIC Extension Matrix Board - _ - 14',1),(75,2,'2 - 15','PIC Extension Matrix Board - _ - 15',1),(76,2,'2 - 16','PIC Extension Matrix Board - _ - 16',1),(77,2,'2 - 17','PIC Extension Matrix Board - _ - 17',1),(78,2,'2 - 18','PIC Extension Matrix Board - _ - 18',1),(79,2,'2 - 19','PIC Extension Matrix Board - _ - 19',1),(80,3,'3 - 0','PIC LCD Board mini - _ - 0',1),(81,3,'3 - 1','PIC LCD Board mini - _ - 1',1),(82,3,'3 - 2','PIC LCD Board mini - _ - 2',1),(83,3,'3 - 3','PIC LCD Board mini - _ - 3',1),(84,3,'3 - 4','PIC LCD Board mini - _ - 4',1),(85,3,'3 - 5','PIC LCD Board mini - _ - 5',1),(86,3,'3 - 6','PIC LCD Board mini - _ - 6',1),(87,3,'3 - 7','PIC LCD Board mini - _ - 7',1),(88,3,'3 - 8','PIC LCD Board mini - _ - 8',1),(89,3,'3 - 9','PIC LCD Board mini - _ - 9',1),(90,3,'3 - 10','PIC LCD Board mini - _ - 10',1),(91,3,'3 - 11','PIC LCD Board mini - _ - 11',1),(92,3,'3 - 12','PIC LCD Board mini - _ - 12',1),(93,3,'3 - 13','PIC LCD Board mini - _ - 13',1),(94,3,'3 - 14','PIC LCD Board mini - _ - 14',1),(95,3,'3 - 15','PIC LCD Board mini - _ - 15',1),(96,3,'3 - 16','PIC LCD Board mini - _ - 16',1),(97,3,'3 - 17','PIC LCD Board mini - _ - 17',1),(98,3,'3 - 18','PIC LCD Board mini - _ - 18',1),(99,3,'3 - 19','PIC LCD Board mini - _ - 19',1),(100,4,'4 - 0','PIC Extension LCD Board - _ - 0',1),(101,4,'4 - 1','PIC Extension LCD Board - _ - 1',1),(102,4,'4 - 2','PIC Extension LCD Board - _ - 2',1),(103,4,'4 - 3','PIC Extension LCD Board - _ - 3',1),(104,4,'4 - 4','PIC Extension LCD Board - _ - 4',1),(105,4,'4 - 5','PIC Extension LCD Board - _ - 5',1),(106,4,'4 - 6','PIC Extension LCD Board - _ - 6',1),(107,4,'4 - 7','PIC Extension LCD Board - _ - 7',1),(108,4,'4 - 8','PIC Extension LCD Board - _ - 8',1),(109,4,'4 - 9','PIC Extension LCD Board - _ - 9',1),(110,4,'4 - 10','PIC Extension LCD Board - _ - 10',1),(111,4,'4 - 11','PIC Extension LCD Board - _ - 11',1),(112,4,'4 - 12','PIC Extension LCD Board - _ - 12',1),(113,4,'4 - 13','PIC Extension LCD Board - _ - 13',1),(114,4,'4 - 14','PIC Extension LCD Board - _ - 14',1),(115,4,'4 - 15','PIC Extension LCD Board - _ - 15',1),(116,4,'4 - 16','PIC Extension LCD Board - _ - 16',1),(117,4,'4 - 17','PIC Extension LCD Board - _ - 17',1),(118,4,'4 - 18','PIC Extension LCD Board - _ - 18',1),(119,4,'4 - 19','PIC Extension LCD Board - _ - 19',1),(120,5,'5 - 0','PIC USB Cable - _ - 0',1),(121,5,'5 - 1','PIC USB Cable - _ - 1',1),(122,5,'5 - 2','PIC USB Cable - _ - 2',1),(123,5,'5 - 3','PIC USB Cable - _ - 3',1),(124,5,'5 - 4','PIC USB Cable - _ - 4',1),(125,5,'5 - 5','PIC USB Cable - _ - 5',1),(126,5,'5 - 6','PIC USB Cable - _ - 6',1),(127,5,'5 - 7','PIC USB Cable - _ - 7',1),(128,5,'5 - 8','PIC USB Cable - _ - 8',1),(129,5,'5 - 9','PIC USB Cable - _ - 9',1),(130,5,'5 - 10','PIC USB Cable - _ - 10',1),(131,5,'5 - 11','PIC USB Cable - _ - 11',1),(132,5,'5 - 12','PIC USB Cable - _ - 12',1),(133,5,'5 - 13','PIC USB Cable - _ - 13',1),(134,5,'5 - 14','PIC USB Cable - _ - 14',1),(135,5,'5 - 15','PIC USB Cable - _ - 15',1),(136,5,'5 - 16','PIC USB Cable - _ - 16',1),(137,5,'5 - 17','PIC USB Cable - _ - 17',1),(138,5,'5 - 18','PIC USB Cable - _ - 18',1),(139,5,'5 - 19','PIC USB Cable - _ - 19',1),(140,6,'6 - 0','Board 8951 - _ - 0',1),(141,6,'6 - 1','Board 8951 - _ - 1',1),(142,6,'6 - 2','Board 8951 - _ - 2',1),(143,6,'6 - 3','Board 8951 - _ - 3',1),(144,6,'6 - 4','Board 8951 - _ - 4',1),(145,6,'6 - 5','Board 8951 - _ - 5',1),(146,6,'6 - 6','Board 8951 - _ - 6',1),(147,6,'6 - 7','Board 8951 - _ - 7',1),(148,6,'6 - 8','Board 8951 - _ - 8',1),(149,6,'6 - 9','Board 8951 - _ - 9',1),(150,6,'6 - 10','Board 8951 - _ - 10',1),(151,6,'6 - 11','Board 8951 - _ - 11',1),(152,6,'6 - 12','Board 8951 - _ - 12',1),(153,6,'6 - 13','Board 8951 - _ - 13',1),(154,6,'6 - 14','Board 8951 - _ - 14',1),(155,6,'6 - 15','Board 8951 - _ - 15',1),(156,6,'6 - 16','Board 8951 - _ - 16',1),(157,6,'6 - 17','Board 8951 - _ - 17',1),(158,6,'6 - 18','Board 8951 - _ - 18',1),(159,6,'6 - 19','Board 8951 - _ - 19',1),(160,7,'7 - 0','Com Cable 8951 - _ - 0',1),(161,7,'7 - 1','Com Cable 8951 - _ - 1',1),(162,7,'7 - 2','Com Cable 8951 - _ - 2',1),(163,7,'7 - 3','Com Cable 8951 - _ - 3',1),(164,7,'7 - 4','Com Cable 8951 - _ - 4',1),(165,7,'7 - 5','Com Cable 8951 - _ - 5',1),(166,7,'7 - 6','Com Cable 8951 - _ - 6',1),(167,7,'7 - 7','Com Cable 8951 - _ - 7',1),(168,7,'7 - 8','Com Cable 8951 - _ - 8',1),(169,7,'7 - 9','Com Cable 8951 - _ - 9',1),(170,7,'7 - 10','Com Cable 8951 - _ - 10',1),(171,7,'7 - 11','Com Cable 8951 - _ - 11',1),(172,7,'7 - 12','Com Cable 8951 - _ - 12',1),(173,7,'7 - 13','Com Cable 8951 - _ - 13',1),(174,7,'7 - 14','Com Cable 8951 - _ - 14',1),(175,7,'7 - 15','Com Cable 8951 - _ - 15',1),(176,7,'7 - 16','Com Cable 8951 - _ - 16',1),(177,7,'7 - 17','Com Cable 8951 - _ - 17',1),(178,7,'7 - 18','Com Cable 8951 - _ - 18',1),(179,7,'7 - 19','Com Cable 8951 - _ - 19',1),(180,8,'8 - 0','USB Cable 8951 - _ - 0',1),(181,8,'8 - 1','USB Cable 8951 - _ - 1',1),(182,8,'8 - 2','USB Cable 8951 - _ - 2',1),(183,8,'8 - 3','USB Cable 8951 - _ - 3',1),(184,8,'8 - 4','USB Cable 8951 - _ - 4',1),(185,8,'8 - 5','USB Cable 8951 - _ - 5',1),(186,8,'8 - 6','USB Cable 8951 - _ - 6',1),(187,8,'8 - 7','USB Cable 8951 - _ - 7',1),(188,8,'8 - 8','USB Cable 8951 - _ - 8',1),(189,8,'8 - 9','USB Cable 8951 - _ - 9',1),(190,8,'8 - 10','USB Cable 8951 - _ - 10',1),(191,8,'8 - 11','USB Cable 8951 - _ - 11',1),(192,8,'8 - 12','USB Cable 8951 - _ - 12',1),(193,8,'8 - 13','USB Cable 8951 - _ - 13',1),(194,8,'8 - 14','USB Cable 8951 - _ - 14',1),(195,8,'8 - 15','USB Cable 8951 - _ - 15',1),(196,8,'8 - 16','USB Cable 8951 - _ - 16',1),(197,8,'8 - 17','USB Cable 8951 - _ - 17',1),(198,8,'8 - 18','USB Cable 8951 - _ - 18',1),(199,8,'8 - 19','USB Cable 8951 - _ - 19',1),(200,9,'9 - 0','Real Time Clock 8951 - _ - 0',1),(201,9,'9 - 1','Real Time Clock 8951 - _ - 1',1),(202,9,'9 - 2','Real Time Clock 8951 - _ - 2',1),(203,9,'9 - 3','Real Time Clock 8951 - _ - 3',1),(204,9,'9 - 4','Real Time Clock 8951 - _ - 4',1),(205,9,'9 - 5','Real Time Clock 8951 - _ - 5',1),(206,9,'9 - 6','Real Time Clock 8951 - _ - 6',1),(207,9,'9 - 7','Real Time Clock 8951 - _ - 7',1),(208,9,'9 - 8','Real Time Clock 8951 - _ - 8',1),(209,9,'9 - 9','Real Time Clock 8951 - _ - 9',1),(210,9,'9 - 10','Real Time Clock 8951 - _ - 10',1),(211,9,'9 - 11','Real Time Clock 8951 - _ - 11',1),(212,9,'9 - 12','Real Time Clock 8951 - _ - 12',1),(213,9,'9 - 13','Real Time Clock 8951 - _ - 13',1),(214,9,'9 - 14','Real Time Clock 8951 - _ - 14',1),(215,9,'9 - 15','Real Time Clock 8951 - _ - 15',1),(216,9,'9 - 16','Real Time Clock 8951 - _ - 16',1),(217,9,'9 - 17','Real Time Clock 8951 - _ - 17',1),(218,9,'9 - 18','Real Time Clock 8951 - _ - 18',1),(219,9,'9 - 19','Real Time Clock 8951 - _ - 19',1),(220,10,'10 - 0','Board H8 - _ - 0',1),(221,10,'10 - 1','Board H8 - _ - 1',1),(222,10,'10 - 2','Board H8 - _ - 2',1),(223,10,'10 - 3','Board H8 - _ - 3',1),(224,10,'10 - 4','Board H8 - _ - 4',1),(225,10,'10 - 5','Board H8 - _ - 5',1),(226,10,'10 - 6','Board H8 - _ - 6',1),(227,10,'10 - 7','Board H8 - _ - 7',1),(228,10,'10 - 8','Board H8 - _ - 8',1),(229,10,'10 - 9','Board H8 - _ - 9',1),(230,10,'10 - 10','Board H8 - _ - 10',1),(231,10,'10 - 11','Board H8 - _ - 11',1),(232,10,'10 - 12','Board H8 - _ - 12',1),(233,10,'10 - 13','Board H8 - _ - 13',1),(234,10,'10 - 14','Board H8 - _ - 14',1),(235,10,'10 - 15','Board H8 - _ - 15',1),(236,10,'10 - 16','Board H8 - _ - 16',1),(237,10,'10 - 17','Board H8 - _ - 17',1),(238,10,'10 - 18','Board H8 - _ - 18',1),(239,10,'10 - 19','Board H8 - _ - 19',1),(240,11,'11 - 0','Board H8+Extension - _ - 0',1),(241,12,'12 - 0','T-Engine - _ - 0',1),(242,12,'12 - 1','T-Engine - _ - 1',1),(243,12,'12 - 2','T-Engine - _ - 2',1),(244,12,'12 - 3','T-Engine - _ - 3',1),(245,12,'12 - 4','T-Engine - _ - 4',1),(246,12,'12 - 5','T-Engine - _ - 5',1),(247,12,'12 - 6','T-Engine - _ - 6',1),(248,12,'12 - 7','T-Engine - _ - 7',1),(249,12,'12 - 8','T-Engine - _ - 8',1),(250,12,'12 - 9','T-Engine - _ - 9',1),(251,12,'12 - 10','T-Engine - _ - 10',1),(252,12,'12 - 11','T-Engine - _ - 11',1),(253,12,'12 - 12','T-Engine - _ - 12',1),(254,12,'12 - 13','T-Engine - _ - 13',1),(255,12,'12 - 14','T-Engine - _ - 14',1),(256,12,'12 - 15','T-Engine - _ - 15',1),(257,12,'12 - 16','T-Engine - _ - 16',1),(258,12,'12 - 17','T-Engine - _ - 17',1),(259,12,'12 - 18','T-Engine - _ - 18',1),(260,12,'12 - 19','T-Engine - _ - 19',1),(261,12,'12 - 20','T-Engine - _ - 20',1),(262,12,'12 - 21','T-Engine - _ - 21',1),(263,12,'12 - 22','T-Engine - _ - 22',1),(264,12,'12 - 23','T-Engine - _ - 23',1),(265,12,'12 - 24','T-Engine - _ - 24',1),(266,12,'12 - 25','T-Engine - _ - 25',1),(267,12,'12 - 26','T-Engine - _ - 26',1),(268,12,'12 - 27','T-Engine - _ - 27',1),(269,12,'12 - 28','T-Engine - _ - 28',1),(270,12,'12 - 29','T-Engine - _ - 29',1),(271,12,'12 - 30','T-Engine - _ - 30',1),(272,12,'12 - 31','T-Engine - _ - 31',1),(273,12,'12 - 32','T-Engine - _ - 32',1),(274,12,'12 - 33','T-Engine - _ - 33',1),(275,12,'12 - 34','T-Engine - _ - 34',1),(276,12,'12 - 35','T-Engine - _ - 35',1),(277,12,'12 - 36','T-Engine - _ - 36',1),(278,13,'13 - 0','LCD Touch Screen for DE2 - _ - 0',1),(279,13,'13 - 1','LCD Touch Screen for DE2 - _ - 1',1),(280,13,'13 - 2','LCD Touch Screen for DE2 - _ - 2',1),(281,13,'13 - 3','LCD Touch Screen for DE2 - _ - 3',1),(282,13,'13 - 4','LCD Touch Screen for DE2 - _ - 4',1),(283,14,'14 - 0','Camera for DE2 - _ - 0',1),(284,14,'14 - 1','Camera for DE2 - _ - 1',1),(285,14,'14 - 2','Camera for DE2 - _ - 2',1),(286,14,'14 - 3','Camera for DE2 - _ - 3',1),(287,14,'14 - 4','Camera for DE2 - _ - 4',1),(288,14,'14 - 5','Camera for DE2 - _ - 5',1),(289,14,'14 - 6','Camera for DE2 - _ - 6',1),(290,14,'14 - 7','Camera for DE2 - _ - 7',1),(291,14,'14 - 8','Camera for DE2 - _ - 8',1),(292,14,'14 - 9','Camera for DE2 - _ - 9',1),(293,15,'15 - 0','Máy Tính - _ - 0',1),(294,15,'15 - 1','Máy Tính - _ - 1',1),(295,15,'15 - 2','Máy Tính - _ - 2',1),(296,15,'15 - 3','Máy Tính - _ - 3',1),(297,15,'15 - 4','Máy Tính - _ - 4',1),(298,15,'15 - 5','Máy Tính - _ - 5',1),(299,15,'15 - 6','Máy Tính - _ - 6',1),(300,15,'15 - 7','Máy Tính - _ - 7',1),(301,15,'15 - 8','Máy Tính - _ - 8',1),(302,15,'15 - 9','Máy Tính - _ - 9',1),(303,15,'15 - 10','Máy Tính - _ - 10',1),(304,15,'15 - 11','Máy Tính - _ - 11',1),(305,15,'15 - 12','Máy Tính - _ - 12',1),(306,15,'15 - 13','Máy Tính - _ - 13',1),(307,15,'15 - 14','Máy Tính - _ - 14',1),(308,15,'15 - 15','Máy Tính - _ - 15',1),(309,15,'15 - 16','Máy Tính - _ - 16',1),(310,15,'15 - 17','Máy Tính - _ - 17',1),(311,15,'15 - 18','Máy Tính - _ - 18',1),(312,15,'15 - 19','Máy Tính - _ - 19',1),(313,15,'15 - 20','Máy Tính - _ - 20',1),(314,15,'15 - 21','Máy Tính - _ - 21',1),(315,15,'15 - 22','Máy Tính - _ - 22',1),(316,15,'15 - 23','Máy Tính - _ - 23',1),(317,15,'15 - 24','Máy Tính - _ - 24',1),(318,15,'15 - 25','Máy Tính - _ - 25',1),(319,15,'15 - 26','Máy Tính - _ - 26',1),(320,15,'15 - 27','Máy Tính - _ - 27',1),(321,15,'15 - 28','Máy Tính - _ - 28',1),(322,15,'15 - 29','Máy Tính - _ - 29',1),(323,15,'15 - 30','Máy Tính - _ - 30',1),(324,15,'15 - 31','Máy Tính - _ - 31',1),(325,15,'15 - 32','Máy Tính - _ - 32',1),(326,15,'15 - 33','Máy Tính - _ - 33',1),(327,15,'15 - 34','Máy Tính - _ - 34',1),(328,15,'15 - 35','Máy Tính - _ - 35',1),(329,15,'15 - 36','Máy Tính - _ - 36',1),(330,15,'15 - 37','Máy Tính - _ - 37',1),(331,15,'15 - 38','Máy Tính - _ - 38',1),(332,15,'15 - 39','Máy Tính - _ - 39',1),(333,16,'16 - 0','Màn Hình - _ - 0',1),(334,16,'16 - 1','Màn Hình - _ - 1',1),(335,16,'16 - 2','Màn Hình - _ - 2',1),(336,16,'16 - 3','Màn Hình - _ - 3',1),(337,16,'16 - 4','Màn Hình - _ - 4',1),(338,16,'16 - 5','Màn Hình - _ - 5',1),(339,16,'16 - 6','Màn Hình - _ - 6',1),(340,16,'16 - 7','Màn Hình - _ - 7',1),(341,16,'16 - 8','Màn Hình - _ - 8',1),(342,16,'16 - 9','Màn Hình - _ - 9',1),(343,16,'16 - 10','Màn Hình - _ - 10',1),(344,16,'16 - 11','Màn Hình - _ - 11',1),(345,16,'16 - 12','Màn Hình - _ - 12',1),(346,16,'16 - 13','Màn Hình - _ - 13',1),(347,16,'16 - 14','Màn Hình - _ - 14',1),(348,16,'16 - 15','Màn Hình - _ - 15',1),(349,16,'16 - 16','Màn Hình - _ - 16',1),(350,16,'16 - 17','Màn Hình - _ - 17',1),(351,16,'16 - 18','Màn Hình - _ - 18',1),(352,16,'16 - 19','Màn Hình - _ - 19',1),(353,16,'16 - 20','Màn Hình - _ - 20',1),(354,16,'16 - 21','Màn Hình - _ - 21',1),(355,16,'16 - 22','Màn Hình - _ - 22',1),(356,16,'16 - 23','Màn Hình - _ - 23',1),(357,16,'16 - 24','Màn Hình - _ - 24',1),(358,16,'16 - 25','Màn Hình - _ - 25',1),(359,16,'16 - 26','Màn Hình - _ - 26',1),(360,16,'16 - 27','Màn Hình - _ - 27',1),(361,16,'16 - 28','Màn Hình - _ - 28',1),(362,16,'16 - 29','Màn Hình - _ - 29',1),(363,16,'16 - 30','Màn Hình - _ - 30',1),(364,16,'16 - 31','Màn Hình - _ - 31',1),(365,16,'16 - 32','Màn Hình - _ - 32',1),(366,16,'16 - 33','Màn Hình - _ - 33',1),(367,16,'16 - 34','Màn Hình - _ - 34',1),(368,16,'16 - 35','Màn Hình - _ - 35',1),(369,16,'16 - 36','Màn Hình - _ - 36',1),(370,16,'16 - 37','Màn Hình - _ - 37',1),(371,16,'16 - 38','Màn Hình - _ - 38',1),(372,16,'16 - 39','Màn Hình - _ - 39',1),(373,17,'17 - 0','Server IBM - _ - 0',1),(374,18,'18 - 0','Stellaris 3748 - Texas Instruments - 0',1),(375,18,'18 - 1','Stellaris 3748 - Texas Instruments - 1',1),(376,18,'18 - 2','Stellaris 3748 - Texas Instruments - 2',1),(377,18,'18 - 3','Stellaris 3748 - Texas Instruments - 3',1),(378,18,'18 - 4','Stellaris 3748 - Texas Instruments - 4',1),(379,19,'19 - 0','Stellaris 6965 - Texas Instruments - 0',1),(380,19,'19 - 1','Stellaris 6965 - Texas Instruments - 1',1),(381,19,'19 - 2','Stellaris 6965 - Texas Instruments - 2',1),(382,19,'19 - 3','Stellaris 6965 - Texas Instruments - 3',1),(383,19,'19 - 4','Stellaris 6965 - Texas Instruments - 4',1);
/*!40000 ALTER TABLE `DeviceUnit` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-03-11 17:53:32
