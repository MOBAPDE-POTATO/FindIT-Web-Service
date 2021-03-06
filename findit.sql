CREATE DATABASE  IF NOT EXISTS `findit` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `findit`;
-- MySQL dump 10.13  Distrib 5.6.17, for Win32 (x86)
--
-- Host: localhost    Database: findit
-- ------------------------------------------------------
-- Server version	5.6.19-log

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
-- Table structure for table `accounts`
--

DROP TABLE IF EXISTS `accounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accounts` (
  `acc_id` int(11) NOT NULL AUTO_INCREMENT,
  `f_name` mediumtext NOT NULL,
  `l_name` mediumtext NOT NULL,
  `password` tinytext NOT NULL,
  `email` varchar(45) NOT NULL,
  `acc_type` int(11) NOT NULL DEFAULT '1' COMMENT '1: Generic Account\n2: Admin Account',
  PRIMARY KEY (`acc_id`),
  UNIQUE KEY `acc_id_UNIQUE` (`acc_id`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `accounts`
--

LOCK TABLES `accounts` WRITE;
/*!40000 ALTER TABLE `accounts` DISABLE KEYS */;
INSERT INTO `accounts` VALUES (1,'Miko','Garcia','12345678','crymehonions@gmail.com',1),(2,'Joey','Adminston','admin','admin@dlsu.edu.ph',2),(3,'John','Lucas','plsplspls','thisisatest@gmail.com',1),(4,'booya','mahnigg','friedchicken','mahnigg@yahoo.com',1),(5,'John','Martin','lasalletaft','mlucas@yahoo.com',1),(6,'Danny','Cardaddy','whatislove','cardaddy@gmail.com',1),(7,'Denni','Cardenny','whatislove','dontforgetthistime@gmail.com',1),(8,'Martin','Lucas','spongebob','martinlucas@yahoo.com',1);
/*!40000 ALTER TABLE `accounts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `features`
--

DROP TABLE IF EXISTS `features`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `features` (
  `feat_id` int(11) NOT NULL AUTO_INCREMENT,
  `report_id` int(11) NOT NULL,
  `feature` mediumtext NOT NULL,
  PRIMARY KEY (`feat_id`),
  UNIQUE KEY `feature_id_UNIQUE` (`feat_id`),
  KEY `feat_report_idx` (`report_id`),
  CONSTRAINT `feat_report` FOREIGN KEY (`report_id`) REFERENCES `reports` (`report_id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `features`
--

LOCK TABLES `features` WRITE;
/*!40000 ALTER TABLE `features` DISABLE KEYS */;
INSERT INTO `features` VALUES (1,10,'Black'),(2,10,'Wool'),(3,6,'Green'),(4,6,'Fibrella'),(7,19,'color red'),(8,19,'version 1000');
/*!40000 ALTER TABLE `features` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reports`
--

DROP TABLE IF EXISTS `reports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reports` (
  `report_id` int(11) NOT NULL AUTO_INCREMENT,
  `acc_id` int(11) NOT NULL,
  `item_name` mediumtext NOT NULL,
  `item_type` int(11) NOT NULL DEFAULT '4' COMMENT '1: ID\n2: Wallet\\Money\n3: Gadget\n4: Others',
  `log_date` date NOT NULL,
  `report_place` longtext NOT NULL,
  `report_date` date NOT NULL COMMENT 'Date that the item was found or lost',
  `report_type` int(11) NOT NULL DEFAULT '1' COMMENT '1: Lost Report\n2: Found Report',
  `claimed` int(11) NOT NULL DEFAULT '0' COMMENT '0: Not claimed\n1: Claimed',
  PRIMARY KEY (`report_id`),
  UNIQUE KEY `report_id_UNIQUE` (`report_id`),
  KEY `acc_report_idx` (`acc_id`),
  CONSTRAINT `acc_report` FOREIGN KEY (`acc_id`) REFERENCES `accounts` (`acc_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reports`
--

LOCK TABLES `reports` WRITE;
/*!40000 ALTER TABLE `reports` DISABLE KEYS */;
INSERT INTO `reports` VALUES (3,1,'Nintendo 3DS',3,'2016-03-05','Gokongwei','2015-11-25',1,0),(4,2,'Game Console',3,'2016-03-05','Henry Sy.','2015-11-30',2,0),(5,2,'Nintendo 3DS',3,'2016-03-05','Gokongwei','2015-11-26',2,0),(6,1,'Umbrella',4,'2016-03-06','Gokongwei','2015-11-25',1,0),(10,1,'Beanie',4,'2016-03-07','Gokongwei','2014-09-25',1,0),(19,8,'sony psp',3,'2016-03-16','goks lobby','2016-03-02',1,0),(21,8,'The Art of War',4,'2016-03-16','andrew','2016-03-01',1,0);
/*!40000 ALTER TABLE `reports` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-03-17  7:14:45
