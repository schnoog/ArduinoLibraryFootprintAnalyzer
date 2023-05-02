-- MariaDB dump 10.19  Distrib 10.5.15-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: ArduLibTest
-- ------------------------------------------------------
-- Server version	10.5.15-MariaDB-0+deb11u1

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
-- Table structure for table `libs`
--

DROP TABLE IF EXISTS `libs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `libs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lib_name` varchar(255) DEFAULT NULL,
  `lib_url` varchar(1024) NOT NULL,
  `lib_version` varchar(32) DEFAULT NULL,
  `lib_depends` varchar(2048) DEFAULT NULL,
  `lib_architectures` varchar(2048) DEFAULT NULL,
  `lib_lastcheck` int(11) NOT NULL DEFAULT 0,
  `lib_minprogspace` int(11) NOT NULL DEFAULT 0,
  `lib_mindynspace` int(11) NOT NULL DEFAULT 0,
  `lib_platform` int(3) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UniqLibVer` (`lib_url`(255),`lib_version`) USING HASH
) ENGINE=InnoDB AUTO_INCREMENT=29824 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `platform`
--

DROP TABLE IF EXISTS `platform`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `platform` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `platform` varchar(255) NOT NULL,
  `platform_label` varchar(1024) NOT NULL,
  `platform_emptyprog` int(11) NOT NULL DEFAULT 0,
  `platform_emptydyn` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_pf` (`platform`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `testresults`
--

DROP TABLE IF EXISTS `testresults`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `testresults` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lib_id` int(11) NOT NULL,
  `platform_id` int(11) NOT NULL,
  `example` varchar(255) NOT NULL,
  `program_space` int(11) NOT NULL,
  `dynamic_space` int(11) NOT NULL,
  `test_valid` int(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_platform_example_test` (`lib_id`,`platform_id`,`example`)
) ENGINE=InnoDB AUTO_INCREMENT=7394 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;




LOCK TABLES `platform` WRITE;
/*!40000 ALTER TABLE `platform` DISABLE KEYS */;
INSERT INTO `platform` VALUES (1,'arduino:avr:micro','Arduino Micro',3462,149),(2,'esp32:esp32:d1_uno32','WEMOS D1 R32 - ESP32',0,0),(3,'esp8266:esp8266:d1_mini','LOLIN(WEMOS) D1 R2 & mini',0,0),(4,'esp32:esp32:lolin_s2_mini','LOLIN S2 Mini - ESP32-S2',0,0),(5,'esp32:esp32:lolin_s3','LOLIN S3 - ESP32-S3',0,0);
/*!40000 ALTER TABLE `platform` ENABLE KEYS */;
UNLOCK TABLES;





-- Dump completed on 2023-05-02 21:56:35
