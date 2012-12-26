-- MySQL dump 10.13  Distrib 5.1.66, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: limb_cms
-- ------------------------------------------------------
-- Server version	5.1.66-0ubuntu0.11.10.2

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
-- Table structure for table `schema_info`
--

DROP TABLE IF EXISTS `schema_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `schema_info` (
  `version` int(11) DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;


DROP TABLE IF EXISTS `lmb_cms_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE  `lmb_cms_user` (
  `id` int(11) NOT NULL auto_increment,
  `email` varchar(255) default NULL,
  `name` varchar(255) default NULL,
  `hashed_password` varchar(64) default NULL,
  `generated_password` varchar(64) default NULL,
  `login` varchar(50) default NULL,
  `role_type` varchar(10) NOT NULL default '0',
  `ctime` int(11) NOT NULL default 0,
  PRIMARY KEY  (`id`),
  KEY `login` (`login`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;


DROP TABLE IF EXISTS `lmb_cms_seo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lmb_cms_seo` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `url` varchar(255) collate utf8_unicode_ci NOT NULL,
  `title` varchar(255) collate utf8_unicode_ci NOT NULL,
  `description` text collate utf8_unicode_ci NOT NULL,
  `keywords` text collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;


DROP TABLE IF EXISTS `lmb_cms_document`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lmb_cms_document` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(255) NOT NULL default '',
  `description` varchar(255) NOT NULL default '',
  `keywords` varchar(255) NOT NULL default '',
  `content` text,
  `is_published` tinyint(1) default '0',
  `parent_id` int(11) NOT NULL default '0',
  `level` int(11) NOT NULL default '0',
  `identifier` varchar(128) NOT NULL default '',
  `priority` integer NOT NULL default 0,
  `path` varchar(255) NOT NULL default '',
  `ctime` int(11) NOT NULL default '0',
  `utime` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `level` (`level`),
  KEY `parent_id` (`parent_id`),
  KEY `id` (`id`,`parent_id`),
  KEY `identifier` (`identifier`,`level`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

DROP TABLE IF EXISTS `lmb_cms_text_block`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE  `lmb_cms_text_block` (
  `id` int(11) NOT NULL auto_increment,
  `identifier` varchar(255) default NULL,
  `title` varchar(255) default NULL,
  `content` longtext,
  PRIMARY KEY  (`id`),
  KEY `identifier` (`identifier`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;


DROP TABLE IF EXISTS `lmb_cms_menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lmb_cms_menu` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `is_published` tinyint(1) default '0',
  `parent_id` int(11) NOT NULL default '0',
  `level` int(11) NOT NULL default '0',
  `identifier` varchar(128) NOT NULL default '',
  `priority` integer NOT NULL default 0,
  `path` varchar(255) NOT NULL default '',
  `ctime` int(11) NOT NULL default '0',
  `utime` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `level` (`level`),
  KEY `parent_id` (`parent_id`),
  KEY `id` (`id`, `parent_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;


--
-- Structure for table `counter`
--
CREATE TABLE `counter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text,
  `code` longtext,
  `ctime` int(11) DEFAULT '0',
  `utime` int(11) DEFAULT '0',
  `priority` int(11) DEFAULT '0',
  `is_published` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `is_published` (`is_published`)
) ENGINE=InnoDB CHARSET=utf8;



--
-- Structure for table `catalog_category`
--
CREATE TABLE `catalog_category` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(255) DEFAULT NULL,
  `identifier` varchar(128) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `is_published` tinyint(1) DEFAULT 0,
  `parent_id` int(11) DEFAULT 0,
  `level` int(11) DEFAULT 0,
  `path` varchar(255) DEFAULT NULL,
  `priority` int(6) DEFAULT 0,
  `ctime` int(11) DEFAULT NULL,
  `utime` int(11) DEFAULT NULL,
  PRIMARY KEY  (`id`),
  KEY `level` (`level`),
  KEY `parent_id` (`parent_id`),
  KEY `id` (`id`,`parent_id`),
  KEY `identifier` (`identifier`,`level`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Structure for table `catalog_product`
--
CREATE TABLE `catalog_product` (
  `id` int(11) NOT NULL auto_increment,
  `category_id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image_ext` varchar(6) DEFAULT NULL,
  `price` decimal(11,0) DEFAULT NULL,
  `article` varchar(255) DEFAULT NULL,
  `is_published` tinyint(1) DEFAULT 0,
  `priority` int(6) DEFAULT 0,
  `ctime` int(11) DEFAULT NULL,
  `utime` int(11) DEFAULT NULL,
  PRIMARY KEY  (`id`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `user` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `reverse_id` int(11) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `password` varchar(40) DEFAULT NULL,
  `is_activated` tinyint(1) DEFAULT '0',
  `is_banned` tinyint(1) DEFAULT '0',
  `photo_ext` varchar(6) DEFAULT NULL,
  `ctime` int(11) DEFAULT NULL,
  `utime` int(11) DEFAULT NULL,
  `create_ip` int(11) DEFAULT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2012-11-19 20:18:01
-- MySQL dump 10.13  Distrib 5.1.66, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: limb_cms
-- ------------------------------------------------------
-- Server version	5.1.66-0ubuntu0.11.10.2

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
-- Dumping data for table `schema_info`
--

LOCK TABLES `schema_info` WRITE;
/*!40000 ALTER TABLE `schema_info` DISABLE KEYS */;
INSERT INTO `schema_info` (`version`) VALUES (1);
/*!40000 ALTER TABLE `schema_info` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2012-11-19 20:18:01
