-- MySQL dump 10.13  Distrib 5.5.54, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: admin
-- ------------------------------------------------------
-- Server version	5.5.54-0ubuntu0.14.04.1

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
-- Current Database: `admin`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `xxxxxx` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `xxxxxx`;

--
-- Table structure for table `mob_admin`
--

DROP TABLE IF EXISTS `mob_admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mob_admin` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `username` varchar(65) NOT NULL DEFAULT '',
  `password` varchar(65) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mob_admin`
--

LOCK TABLES `mob_admin` WRITE;
/*!40000 ALTER TABLE `mob_admin` DISABLE KEYS */;
INSERT INTO `mob_admin` VALUES (1,'xxxxxx','We%*w123wdDS');
/*!40000 ALTER TABLE `mob_admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mob_banned`
--

DROP TABLE IF EXISTS `mob_banned`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mob_banned` (
  `b_id` int(255) NOT NULL AUTO_INCREMENT,
  `b_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `b_ip` varchar(20) NOT NULL DEFAULT '',
  `b_reason` text NOT NULL,
  `b_message` text NOT NULL,
  `b_link` text NOT NULL,
  PRIMARY KEY (`b_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mob_banned`
--

LOCK TABLES `mob_banned` WRITE;
/*!40000 ALTER TABLE `mob_banned` DISABLE KEYS */;
INSERT INTO `mob_banned` VALUES (4,'2017-07-31 02:33:08','','xxxx','','http://www.');
/*!40000 ALTER TABLE `mob_banned` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mob_categories`
--

DROP TABLE IF EXISTS `mob_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mob_categories` (
  `cat_id` int(255) NOT NULL AUTO_INCREMENT,
  `cat_name` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`cat_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mob_categories`
--

LOCK TABLES `mob_categories` WRITE;
/*!40000 ALTER TABLE `mob_categories` DISABLE KEYS */;
INSERT INTO `mob_categories` VALUES (1,'Men'),(2,'Woman');
/*!40000 ALTER TABLE `mob_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mob_comment`
--

DROP TABLE IF EXISTS `mob_comment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mob_comment` (
  `com_id` int(11) NOT NULL AUTO_INCREMENT,
  `com_img_id` int(11) NOT NULL DEFAULT '0',
  `com_poster_name` varchar(255) NOT NULL DEFAULT '',
  `com_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `com_message` text NOT NULL,
  `com_poster_ip` varchar(15) NOT NULL DEFAULT '',
  PRIMARY KEY (`com_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mob_comment`
--

LOCK TABLES `mob_comment` WRITE;
/*!40000 ALTER TABLE `mob_comment` DISABLE KEYS */;
/*!40000 ALTER TABLE `mob_comment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mob_images`
--

DROP TABLE IF EXISTS `mob_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mob_images` (
  `img_id` int(11) NOT NULL AUTO_INCREMENT,
  `img_name` varchar(255) NOT NULL DEFAULT '',
  `img_category` int(11) NOT NULL DEFAULT '0',
  `img_filename` varchar(255) NOT NULL DEFAULT '',
  `img_date` date NOT NULL DEFAULT '0000-00-00',
  `img_uploader` varchar(255) NOT NULL DEFAULT '',
  `img_uploader_ip` varchar(15) NOT NULL DEFAULT '',
  `img_total_votes` int(11) NOT NULL DEFAULT '0',
  `img_total_points` int(11) NOT NULL DEFAULT '0',
  `img_average` decimal(11,1) NOT NULL DEFAULT '0.0',
  `img_description` text NOT NULL,
  PRIMARY KEY (`img_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mob_images`
--

LOCK TABLES `mob_images` WRITE;
/*!40000 ALTER TABLE `mob_images` DISABLE KEYS */;
INSERT INTO `mob_images` VALUES (1,'Gerard Butler',1,'1_gerard_butler.jpg','2012-09-29','admin','12.34.56.789',0,0,0.0,''),(2,'Hugh Jackman',1,'2_hugh_jackman.jpg','2012-09-29','admin','12.34.56.789',0,0,0.0,''),(3,'Angelina Jolie',2,'3_angelina_jolie.jpg','2012-09-30','admin','12.34.56.789',0,0,0.0,''),(4,'Cameron Diaz',2,'4_cameron_diaz.jpg','2012-09-30','admin','84.82.13.133',0,0,0.0,'Cameron Michelle Diaz (born August 30, 1972) is an American actress and former model.\r\nShe rose to prominence during the 1990s with roles in the movies The Mask, My Best Friend\'s Wedding and There\'s Something About Mary. \r\nOther high-profile credits include the two Charlie\'s Angels films, voicing the character Princess Fiona in the Shrek series, The Holiday, The Green Hornet and Bad Teacher. \r\nDiaz received Golden Globe award nominations for her performances in the movies There\'s Something About Mary, Being John Malkovich, Vanilla Sky, and Gangs of New York. ');
/*!40000 ALTER TABLE `mob_images` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mob_potd`
--

DROP TABLE IF EXISTS `mob_potd`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mob_potd` (
  `potd_id` int(10) NOT NULL AUTO_INCREMENT,
  `potd_img_id` int(10) NOT NULL DEFAULT '0',
  `potd_date` date NOT NULL DEFAULT '0000-00-00',
  PRIMARY KEY (`potd_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mob_potd`
--

LOCK TABLES `mob_potd` WRITE;
/*!40000 ALTER TABLE `mob_potd` DISABLE KEYS */;
INSERT INTO `mob_potd` VALUES (1,2,'2017-07-31');
/*!40000 ALTER TABLE `mob_potd` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mob_settings`
--

DROP TABLE IF EXISTS `mob_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mob_settings` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `installed` int(1) NOT NULL DEFAULT '1',
  `pagename` varchar(255) NOT NULL DEFAULT '',
  `slogan` varchar(255) NOT NULL DEFAULT '',
  `script_url` varchar(255) NOT NULL DEFAULT '',
  `email` varchar(255) NOT NULL DEFAULT '',
  `filesize` int(200) NOT NULL DEFAULT '0',
  `template` text NOT NULL,
  `hitcounter` int(15) NOT NULL DEFAULT '0',
  `hitcounterimg` text NOT NULL,
  `total_votes` int(11) NOT NULL DEFAULT '0',
  `total_points` int(11) NOT NULL DEFAULT '0',
  `average` decimal(11,1) NOT NULL DEFAULT '0.0',
  `topimages` int(11) NOT NULL DEFAULT '0',
  `advertising` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mob_settings`
--

LOCK TABLES `mob_settings` WRITE;
/*!40000 ALTER TABLE `mob_settings` DISABLE KEYS */;
INSERT INTO `mob_settings` VALUES (1,1,'Make or Break','Vote or be voted','http://192.168.122.165/','your@email.com',250,'basic.css',10,'web1',0,0,0.0,10,'<center>\r\nHere you can show your advertising.<br>\r\nWhen you don\'t want to show it you can delete anything in the box. <br>\r\nYou can find this box in the admin menu -> Edit Settings -> Header advertising.\r\n</center>');
/*!40000 ALTER TABLE `mob_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mob_uploads`
--

DROP TABLE IF EXISTS `mob_uploads`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mob_uploads` (
  `upl_id` int(11) NOT NULL AUTO_INCREMENT,
  `upl_name` varchar(255) NOT NULL DEFAULT '',
  `upl_category` int(11) NOT NULL DEFAULT '0',
  `upl_filename` varchar(255) NOT NULL DEFAULT '',
  `upl_date` date NOT NULL DEFAULT '0000-00-00',
  `upl_uploader` varchar(255) NOT NULL DEFAULT '',
  `upl_email` varchar(255) NOT NULL DEFAULT '',
  `upl_ip` varchar(18) NOT NULL DEFAULT '',
  `upl_description` text NOT NULL,
  PRIMARY KEY (`upl_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mob_uploads`
--

LOCK TABLES `mob_uploads` WRITE;
/*!40000 ALTER TABLE `mob_uploads` DISABLE KEYS */;
/*!40000 ALTER TABLE `mob_uploads` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mob_votes`
--

DROP TABLE IF EXISTS `mob_votes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mob_votes` (
  `vote_id` int(11) NOT NULL AUTO_INCREMENT,
  `vote_ip` tinytext NOT NULL,
  `vote_date` date NOT NULL DEFAULT '0000-00-00',
  `vote_image_id` int(11) NOT NULL DEFAULT '0',
  `vote_points` decimal(11,1) NOT NULL DEFAULT '0.0',
  PRIMARY KEY (`vote_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mob_votes`
--

LOCK TABLES `mob_votes` WRITE;
/*!40000 ALTER TABLE `mob_votes` DISABLE KEYS */;
/*!40000 ALTER TABLE `mob_votes` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-07-31 10:45:32
