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
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;


/*!40000 ALTER TABLE `lmb_cms_user` DISABLE KEYS */;
INSERT INTO `lmb_cms_user` VALUES(
  NULL,
  'support@limb-project.com',
  'Admin',
  'b9fb54d1cf88c8c9141cdb01215969221899ff97', /* secret */
  NULL,
  'admin',
  'admin',
  1
);
/*!40000 ALTER TABLE `lmb_cms_user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;


/*!40000 ALTER TABLE `lmb_cms_seo` DISABLE KEYS */;
INSERT INTO `lmb_cms_seo` (`id`, `url`, `title`, `description`, `keywords`) VALUES(
  1,
  '/',
  'Главная страница',
  'Описание',
  'Ключевые слова'
);
/*!40000 ALTER TABLE `lmb_cms_seo` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;


/*!40000 ALTER TABLE `lmb_cms_document` DISABLE KEYS */;


INSERT INTO `lmb_cms_document` (`path`)
VALUES (
  '/1/'
);
INSERT INTO `lmb_cms_document` (`title`, `is_published`, `content`, `identifier`, `parent_id`, `level`, `path`, `priority`)
VALUES (
  'Contacts',
  1,
  'Contacts',
  'contacts',
  1,
  1,
  '/1/2/',
  10
);

/*!40000 ALTER TABLE `lmb_cms_document` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;


/*!40000 ALTER TABLE `lmb_cms_menu` DISABLE KEYS */;
INSERT INTO `lmb_cms_menu` ( `path`)
VALUES (
  '/1/'
);

INSERT INTO `lmb_cms_menu` ( `parent_id`, `title`, `is_published`, `identifier`, `url`, `level`, `path`, `priority`)
VALUES (
  1,
  'Главное меню',
  1,
  'main_menu',
  '',
  1,
  '/1/2/',
  10
),
(
  2,
  'Главная страница',
  1,
  'main_page',
  '/',
   2,
  '/1/2/3/',
  10
),
(
  2,
  'Контакты',
  1,
  'contacts',
  '/contacts',
   2,
  '/1/2/4/',
  20
);


INSERT INTO `counter` ( `title`, `is_published`, `code`, `priority`)
VALUES (
  'test_counter',
  1,
  '
<script type="text/javascript" src="/shared/js/js/limb.js?1" ></script>
<script type="text/javascript">
  var cookie_name = "test_counter";
  var visits = 1;
  if(Limb.cookie(cookie_name))
    visits = Limb.cookie(cookie_name)*1 + 1;
	  
  Limb.cookie(cookie_name, visits);
  document.write( "<b>" + visits + "</b>")
 
</script>
  ',
  10
);

INSERT INTO `catalog_category` ( `path`)
VALUES (
  '/1/'
);

/*!40000 ALTER TABLE `lmb_cms_menu` ENABLE KEYS */;
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
