-- MySQL dump 10.13  Distrib 5.7.16, for osx10.12 (x86_64)
--
-- Host: localhost    Database: admin
-- ------------------------------------------------------
-- Server version	5.7.16

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
-- Table structure for table `Admin`
--

DROP TABLE IF EXISTS `Admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `groupId` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `Admin_login_uindex` (`login`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Admin`
--

LOCK TABLES `Admin` WRITE;
/*!40000 ALTER TABLE `Admin` DISABLE KEYS */;
INSERT INTO `Admin` VALUES (1,'admin','2d9f7bfbc0b8744d57cc7ae0ec8d4532','Admin',1,2),(2,'moderator','2d9f7bfbc0b8744d57cc7ae0ec8d4532','moderator',1,3);
/*!40000 ALTER TABLE `Admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Admin_Group`
--

DROP TABLE IF EXISTS `Admin_Group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Admin_Group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Admin_Group`
--

LOCK TABLES `Admin_Group` WRITE;
/*!40000 ALTER TABLE `Admin_Group` DISABLE KEYS */;
INSERT INTO `Admin_Group` VALUES (2),(3);
/*!40000 ALTER TABLE `Admin_Group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Admin_Group_Lang`
--

DROP TABLE IF EXISTS `Admin_Group_Lang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Admin_Group_Lang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_group_id` int(11) NOT NULL,
  `lang` char(2) NOT NULL,
  `field` varchar(20) NOT NULL,
  `value` mediumtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Admin_Group_Lang`
--

LOCK TABLES `Admin_Group_Lang` WRITE;
/*!40000 ALTER TABLE `Admin_Group_Lang` DISABLE KEYS */;
INSERT INTO `Admin_Group_Lang` VALUES (1,2,'ru','name','Root'),(2,2,'en','name','Администратор'),(3,3,'ru','name','Администраторы'),(4,3,'en','name','Модератор');
/*!40000 ALTER TABLE `Admin_Group_Lang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Admin_Group_Permission`
--

DROP TABLE IF EXISTS `Admin_Group_Permission`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Admin_Group_Permission` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `groupId` int(11) DEFAULT NULL,
  `moduleId` varchar(100) NOT NULL,
  `permission` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=440 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Admin_Group_Permission`
--

LOCK TABLES `Admin_Group_Permission` WRITE;
/*!40000 ALTER TABLE `Admin_Group_Permission` DISABLE KEYS */;
INSERT INTO `Admin_Group_Permission` VALUES (404,2,'1',2),(405,2,'2',2),(406,2,'3',2),(407,2,'4',2),(408,2,'5',2),(409,2,'6',2),(410,2,'7',2),(411,2,'8',2),(412,2,'9',2),(413,2,'10',2),(414,2,'11',2),(415,2,'12',2),(416,2,'13',2),(417,2,'14',2),(418,2,'15',2),(419,2,'16',2),(420,2,'17',2),(421,2,'18',2),(422,3,'1',1),(423,3,'2',1),(424,3,'3',0),(425,3,'4',1),(426,3,'5',0),(427,3,'6',0),(428,3,'7',2),(429,3,'8',2),(430,3,'9',2),(431,3,'10',2),(432,3,'11',0),(433,3,'12',0),(434,3,'13',1),(435,3,'14',0),(436,3,'15',0),(437,3,'16',0),(438,3,'17',0),(439,3,'18',0);
/*!40000 ALTER TABLE `Admin_Group_Permission` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Cart`
--

DROP TABLE IF EXISTS `Cart`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Cart` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) DEFAULT NULL,
  `session` varchar(100) NOT NULL,
  `productId` int(11) NOT NULL,
  `count` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Cart`
--

LOCK TABLES `Cart` WRITE;
/*!40000 ALTER TABLE `Cart` DISABLE KEYS */;
INSERT INTO `Cart` VALUES (1,NULL,'rt618ja17e7j1kpjdar3uhieg0',1,1);
/*!40000 ALTER TABLE `Cart` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Catalog`
--

DROP TABLE IF EXISTS `Catalog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Catalog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(100) NOT NULL,
  `parent` int(11) DEFAULT NULL,
  `active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `Catalog_url_uindex` (`url`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Catalog`
--

LOCK TABLES `Catalog` WRITE;
/*!40000 ALTER TABLE `Catalog` DISABLE KEYS */;
INSERT INTO `Catalog` VALUES (1,'balls',0,1),(2,'discs',NULL,1);
/*!40000 ALTER TABLE `Catalog` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Catalog_Lang`
--

DROP TABLE IF EXISTS `Catalog_Lang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Catalog_Lang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `catalog_id` int(11) NOT NULL,
  `lang` char(2) NOT NULL,
  `field` varchar(20) NOT NULL,
  `value` mediumtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Catalog_Lang`
--

LOCK TABLES `Catalog_Lang` WRITE;
/*!40000 ALTER TABLE `Catalog_Lang` DISABLE KEYS */;
INSERT INTO `Catalog_Lang` VALUES (1,1,'ru','name','Мячи'),(2,1,'ru','text',''),(13,1,'en','name','Balls'),(14,1,'en','text',''),(15,2,'en','name','Discs'),(16,2,'en','text',''),(17,2,'ru','name','Диски'),(18,2,'ru','text','');
/*!40000 ALTER TABLE `Catalog_Lang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Catalog__FilterSet`
--

DROP TABLE IF EXISTS `Catalog__FilterSet`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Catalog__FilterSet` (
  `Catalog` int(11) NOT NULL,
  `FilterSet` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Catalog__FilterSet`
--

LOCK TABLES `Catalog__FilterSet` WRITE;
/*!40000 ALTER TABLE `Catalog__FilterSet` DISABLE KEYS */;
INSERT INTO `Catalog__FilterSet` VALUES (1,1),(1,8);
/*!40000 ALTER TABLE `Catalog__FilterSet` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Currency`
--

DROP TABLE IF EXISTS `Currency`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Currency` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `position` tinyint(4) NOT NULL DEFAULT '1',
  `symbol` varchar(100) NOT NULL,
  `basic` tinyint(4) NOT NULL DEFAULT '0',
  `rate` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Currency`
--

LOCK TABLES `Currency` WRITE;
/*!40000 ALTER TABLE `Currency` DISABLE KEYS */;
INSERT INTO `Currency` VALUES (1,1,'$',0,1),(3,2,'₴',1,27);
/*!40000 ALTER TABLE `Currency` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Currency_Lang`
--

DROP TABLE IF EXISTS `Currency_Lang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Currency_Lang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `currency_id` int(11) NOT NULL,
  `lang` char(2) NOT NULL,
  `field` varchar(20) NOT NULL,
  `value` mediumtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Currency_Lang`
--

LOCK TABLES `Currency_Lang` WRITE;
/*!40000 ALTER TABLE `Currency_Lang` DISABLE KEYS */;
INSERT INTO `Currency_Lang` VALUES (1,1,'ru','name','USD'),(2,1,'en','name','USD'),(5,3,'ru','name','UAH'),(6,3,'en','name','UAH');
/*!40000 ALTER TABLE `Currency_Lang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Filter`
--

DROP TABLE IF EXISTS `Filter`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Filter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `filterSetId` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Filter`
--

LOCK TABLES `Filter` WRITE;
/*!40000 ALTER TABLE `Filter` DISABLE KEYS */;
INSERT INTO `Filter` VALUES (1,1),(2,1),(4,8),(5,8);
/*!40000 ALTER TABLE `Filter` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `FilterSet`
--

DROP TABLE IF EXISTS `FilterSet`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `FilterSet` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `alias` varchar(10) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `FilterSet`
--

LOCK TABLES `FilterSet` WRITE;
/*!40000 ALTER TABLE `FilterSet` DISABLE KEYS */;
INSERT INTO `FilterSet` VALUES (1,'material'),(8,'diameter');
/*!40000 ALTER TABLE `FilterSet` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `FilterSet_Lang`
--

DROP TABLE IF EXISTS `FilterSet_Lang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `FilterSet_Lang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `filterset_id` int(11) NOT NULL,
  `lang` char(2) NOT NULL,
  `field` varchar(20) NOT NULL,
  `value` mediumtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `FilterSet_Lang`
--

LOCK TABLES `FilterSet_Lang` WRITE;
/*!40000 ALTER TABLE `FilterSet_Lang` DISABLE KEYS */;
INSERT INTO `FilterSet_Lang` VALUES (1,1,'ru','name','Материал'),(2,1,'ru','info','<p>Материал</p>\r\n'),(3,1,'en','name','Material'),(4,1,'en','info',''),(5,7,'en','name','dsg'),(6,7,'en','info','<p>dsgsdg</p>\r\n'),(7,8,'ru','name','Диаметр'),(8,8,'ru','info','<p>Диаметр мячика</p>\r\n'),(9,8,'en','name','Diameter'),(10,8,'en','info','<p>Ball diameter</p>\r\n');
/*!40000 ALTER TABLE `FilterSet_Lang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Filter_Lang`
--

DROP TABLE IF EXISTS `Filter_Lang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Filter_Lang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `filter_id` int(11) NOT NULL,
  `lang` char(2) NOT NULL,
  `field` varchar(20) NOT NULL,
  `value` mediumtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Filter_Lang`
--

LOCK TABLES `Filter_Lang` WRITE;
/*!40000 ALTER TABLE `Filter_Lang` DISABLE KEYS */;
INSERT INTO `Filter_Lang` VALUES (1,1,'ru','name','Резина'),(2,2,'ru','name','Каучук'),(3,1,'en','name','Rubber'),(4,2,'en','name','Gum elastic'),(5,3,'ru','name','Тест'),(6,4,'ru','name','8 см'),(7,4,'en','name','8 cm'),(8,5,'ru','name','15 см'),(9,5,'en','name','15 cm');
/*!40000 ALTER TABLE `Filter_Lang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `InfoBlock`
--

DROP TABLE IF EXISTS `InfoBlock`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `InfoBlock` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `alias` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `InfoBlock`
--

LOCK TABLES `InfoBlock` WRITE;
/*!40000 ALTER TABLE `InfoBlock` DISABLE KEYS */;
INSERT INTO `InfoBlock` VALUES (1,'register_success'),(2,'order_sent');
/*!40000 ALTER TABLE `InfoBlock` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `InfoBlock_Lang`
--

DROP TABLE IF EXISTS `InfoBlock_Lang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `InfoBlock_Lang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `infoblock_id` int(11) NOT NULL,
  `lang` char(2) NOT NULL,
  `field` varchar(20) NOT NULL,
  `value` mediumtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `InfoBlock_Lang`
--

LOCK TABLES `InfoBlock_Lang` WRITE;
/*!40000 ALTER TABLE `InfoBlock_Lang` DISABLE KEYS */;
INSERT INTO `InfoBlock_Lang` VALUES (1,1,'ru','name','Регистрация завершена'),(2,1,'ru','text','<p>Поздравляем!</p>\r\n\r\n<p>Регистрация завершена успешно.</p>\r\n\r\n<p>На указанный E-Mail отправлены логин, пароль.</p>\r\n'),(3,2,'ru','name','Ваш заказ отправлен'),(4,2,'ru','text','<p>Спасибо за заказ!</p>\r\n\r\n<p>Проверяйте почту</p>\r\n');
/*!40000 ALTER TABLE `InfoBlock_Lang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `MailTemplate`
--

DROP TABLE IF EXISTS `MailTemplate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `MailTemplate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `alias` varchar(100) NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `MailTemplate_alias_uindex` (`alias`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `MailTemplate`
--

LOCK TABLES `MailTemplate` WRITE;
/*!40000 ALTER TABLE `MailTemplate` DISABLE KEYS */;
INSERT INTO `MailTemplate` VALUES (1,'registration_success',1),(2,'new_order',1);
/*!40000 ALTER TABLE `MailTemplate` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `MailTemplate_Lang`
--

DROP TABLE IF EXISTS `MailTemplate_Lang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `MailTemplate_Lang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mailtemplate_id` int(11) NOT NULL,
  `lang` char(2) NOT NULL,
  `field` varchar(20) NOT NULL,
  `value` mediumtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `MailTemplate_Lang`
--

LOCK TABLES `MailTemplate_Lang` WRITE;
/*!40000 ALTER TABLE `MailTemplate_Lang` DISABLE KEYS */;
INSERT INTO `MailTemplate_Lang` VALUES (1,1,'ru','subject','Регистрация завершена'),(2,1,'ru','body','<p>Добрый день, <?= $vars[\'name\']; ?></p>\r\n\r\n<br/>\r\n\r\n<p>Вы успешно зарегистрированы на сайте <?= $vars[\'site\']; ?></p>\r\n\r\n<br/>\r\n\r\n<p>Login: <?= $vars[\'login\']; ?></p>\r\n<p>Password: <?= $vars[\'password\']; ?></p>\r\n'),(3,2,'ru','subject','Новый заказ'),(4,2,'ru','body','<p>Добрый день, <?= $vars[\'name\']; ?></p>\r\n</br>\r\n\r\n<p>Вы офомили заказ на сайте <?= $vars[\'site\']; ?></p>\r\n<br/>\r\n\r\n<p>Сумма: <?= $vars[\'order\'][\'sum\']; ?></p>\r\n\r\n<p><b>Детали заказа:</b></p>\r\n\r\n<p>Имя: <?= $vars[\'order\'][\'firstName\']; ?></p>\r\n<p>Фамилия: <?= $vars[\'order\'][\'lastName\']; ?></p>\r\n<p>Телефон: <?= $vars[\'order\'][\'phone\']; ?></p>\r\n<p>Адрес: <?= $vars[\'order\'][\'address\']; ?></p>\r\n<p>Комментарий:</p>\r\n\r\n<p><?= $vars[\'order\'][\'comment\']; ?></p>\r\n\r\n<br/>\r\n\r\n<p><b>Список товаров:</b></p>\r\n\r\n<table width=\"100%\" border=\"1\">\r\n	<thead>\r\n	<tr>\r\n		<th>ID</th>\r\n		<th><? __(\'Name\') ?></th>\r\n		<th><? __(\'Count\') ?></th>\r\n		<th><? __(\'Price\') ?></th>\r\n	</tr>\r\n	</thead>\r\n	<tbody>\r\n	<?php foreach ($vars[\'products\'] as $var) { ?>\r\n		<tr>\r\n			<td><?= $var[\'id\']; ?></td>\r\n			<td><?= $var[\'name\']; ?></td>\r\n			<td><?= $var[\'count\']; ?></td>\r\n			<td><?= number_format($var[\'price\'], 2); ?></td>\r\n		</tr>\r\n	<?php } ?>\r\n	</tbody>\r\n</table>\r\n');
/*!40000 ALTER TABLE `MailTemplate_Lang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Menu`
--

DROP TABLE IF EXISTS `Menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(100) NOT NULL,
  `type` tinyint(4) NOT NULL DEFAULT '1',
  `active` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `Menu_url_uindex` (`url`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Menu`
--

LOCK TABLES `Menu` WRITE;
/*!40000 ALTER TABLE `Menu` DISABLE KEYS */;
INSERT INTO `Menu` VALUES (1,'/',1,1),(3,'/catalog',1,1),(4,'/contacts',1,1),(5,'/photos',1,1);
/*!40000 ALTER TABLE `Menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Menu_Lang`
--

DROP TABLE IF EXISTS `Menu_Lang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Menu_Lang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_id` int(11) NOT NULL,
  `lang` char(2) NOT NULL,
  `field` varchar(20) NOT NULL,
  `value` mediumtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Menu_Lang`
--

LOCK TABLES `Menu_Lang` WRITE;
/*!40000 ALTER TABLE `Menu_Lang` DISABLE KEYS */;
INSERT INTO `Menu_Lang` VALUES (1,1,'en','name','Main Page'),(3,1,'ru','name','Главная'),(4,3,'ru','name','Каталог'),(5,3,'en','name','Catalog'),(6,4,'en','name','Contact Us'),(7,4,'ru','name','О сайте'),(8,5,'ru','name','Фото галерея'),(9,5,'en','name','Фото галерея');
/*!40000 ALTER TABLE `Menu_Lang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Meta`
--

DROP TABLE IF EXISTS `Meta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Meta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(100) NOT NULL,
  `type` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Meta`
--

LOCK TABLES `Meta` WRITE;
/*!40000 ALTER TABLE `Meta` DISABLE KEYS */;
INSERT INTO `Meta` VALUES (1,'/',1);
/*!40000 ALTER TABLE `Meta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Meta_Lang`
--

DROP TABLE IF EXISTS `Meta_Lang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Meta_Lang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `meta_id` int(11) NOT NULL,
  `lang` char(2) NOT NULL,
  `field` varchar(20) NOT NULL,
  `value` mediumtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Meta_Lang`
--

LOCK TABLES `Meta_Lang` WRITE;
/*!40000 ALTER TABLE `Meta_Lang` DISABLE KEYS */;
INSERT INTO `Meta_Lang` VALUES (1,1,'ru','title','Дог фризби'),(2,1,'ru','keywords','фризби, мячи, одесса, украина'),(3,1,'ru','description','Купить недорого с доставкой мячи для собак, фризби, дог фризби в Одессе, Украина'),(4,1,'en','title','Дог фризби'),(5,1,'en','keywords','фризби, мячи, одесса, украина'),(6,1,'en','description','Купить недорого с доставкой мячи для собак, фризби, дог фризби в Одессе, Украина');
/*!40000 ALTER TABLE `Meta_Lang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Module`
--

DROP TABLE IF EXISTS `Module`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Module` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(100) NOT NULL,
  `icon` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `Module_url_uindex` (`url`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Module`
--

LOCK TABLES `Module` WRITE;
/*!40000 ALTER TABLE `Module` DISABLE KEYS */;
INSERT INTO `Module` VALUES (1,'menu','fa-th-list'),(2,'page','fa-th'),(3,'infoblock','fa-info'),(4,'mail_template','fa-send'),(5,'admin','fa-exclamation-circle'),(6,'admin_group','fa-group'),(7,'catalog','fa-folder-open'),(8,'product','fa-edit'),(9,'filter','fa-filter'),(10,'order','fa-shopping-cart'),(11,'database','fa-database'),(12,'translation','fa-language'),(13,'user','fa-user'),(14,'meta','fa-tags'),(15,'setting','fa-dashboard'),(16,'module','fa-plug'),(17,'currency','fa-money'),(18,'photos','fa-camera');
/*!40000 ALTER TABLE `Module` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Module_Lang`
--

DROP TABLE IF EXISTS `Module_Lang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Module_Lang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module_id` int(11) NOT NULL,
  `lang` char(2) NOT NULL,
  `field` varchar(20) NOT NULL,
  `value` mediumtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Module_Lang`
--

LOCK TABLES `Module_Lang` WRITE;
/*!40000 ALTER TABLE `Module_Lang` DISABLE KEYS */;
INSERT INTO `Module_Lang` VALUES (1,1,'ru','name','Меню'),(2,1,'ru','description','<p>test</p>\r\n'),(3,1,'en','name','Меню'),(4,1,'en','description','<p>test</p>\r\n'),(5,2,'ru','name','Страницы'),(6,2,'ru','description',''),(7,2,'en','name','Страницы'),(8,2,'en','description',''),(9,3,'ru','name','Инфоблоки'),(10,3,'ru','description',''),(11,3,'en','name','Инфоблоки'),(12,3,'en','description',''),(13,4,'ru','name','Шаблоны писем'),(14,4,'ru','description',''),(15,4,'en','name','Шаблоны писем'),(16,4,'en','description',''),(17,5,'ru','name','Администраторы'),(18,5,'ru','description',''),(19,5,'en','name','Администраторы'),(20,5,'en','description',''),(21,6,'ru','name','Группы администраторов'),(22,6,'ru','description',''),(23,6,'en','name','Группы администраторов'),(24,6,'en','description',''),(25,7,'ru','name','Каталог'),(26,7,'ru','description',''),(27,7,'en','name','Каталог'),(28,7,'en','description',''),(29,8,'ru','name','Товары'),(30,8,'ru','description',''),(31,8,'en','name','Товары'),(32,8,'en','description',''),(33,9,'ru','name','Фильтры'),(34,9,'ru','description',''),(35,9,'en','name','Фильтры'),(36,9,'en','description',''),(37,10,'ru','name','Заказы'),(38,10,'ru','description',''),(39,10,'en','name','Заказы'),(40,10,'en','description',''),(41,11,'ru','name','База данных'),(42,11,'ru','description',''),(43,11,'en','name','База данных'),(44,11,'en','description',''),(45,12,'ru','name','Перевод'),(46,12,'ru','description',''),(47,12,'en','name','Перевод'),(48,12,'en','description',''),(49,13,'ru','name','Пользователи'),(50,13,'ru','description',''),(51,13,'en','name','Пользователи'),(52,13,'en','description',''),(53,14,'ru','name','Мета данные'),(54,14,'ru','description',''),(55,14,'en','name','Мета данные'),(56,14,'en','description',''),(57,15,'ru','name','Настройки'),(58,15,'ru','description',''),(59,15,'en','name','Настройки'),(60,15,'en','description',''),(61,16,'ru','name','Модули'),(62,16,'ru','description',''),(63,16,'en','name','Модули'),(64,16,'en','description',''),(65,17,'ru','name','Валюта'),(66,17,'ru','description',''),(67,17,'en','name','Currency'),(68,17,'en','description',''),(69,18,'ru','name','Фотогалерея'),(70,18,'ru','description','<p>Фотогалерея</p>\r\n'),(71,18,'en','name','Photo gallery'),(72,18,'en','description','<p>Фото галерея</p>\r\n');
/*!40000 ALTER TABLE `Module_Lang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Order`
--

DROP TABLE IF EXISTS `Order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `firstName` varchar(100) NOT NULL,
  `lastName` varchar(100) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `comment` text NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `sum` float NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `email` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Order`
--

LOCK TABLES `Order` WRITE;
/*!40000 ALTER TABLE `Order` DISABLE KEYS */;
INSERT INTO `Order` VALUES (2,1,'test','test','1434134134','Rabina 1','','2016-11-19 16:45:13',100,1,''),(10,10,'test','test','1434134134','Rabina 1','xui','2016-11-22 23:41:28',325,1,'vitfollower@gmail.com'),(11,10,'test','test','1434134134','Rabina 1','','2016-11-22 23:52:30',325,1,'vitfollower@gmail.com'),(12,10,'test','test','1434134134','Rabina 1','123','2016-11-22 23:58:53',345,1,'vitfollower@gmail.com'),(13,10,'test','test','1434134134','Rabina 1','123','2016-11-23 00:00:38',325,1,'vitfollower@gmail.com'),(15,10,'test','test','1434134134','Rabina 1','','2016-11-23 00:17:01',325,1,'vitfollower@gmail.com');
/*!40000 ALTER TABLE `Order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Order_Product`
--

DROP TABLE IF EXISTS `Order_Product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Order_Product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `productId` int(11) NOT NULL,
  `orderId` int(11) NOT NULL,
  `price` float NOT NULL DEFAULT '0',
  `count` float NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Order_Product`
--

LOCK TABLES `Order_Product` WRITE;
/*!40000 ALTER TABLE `Order_Product` DISABLE KEYS */;
INSERT INTO `Order_Product` VALUES (1,1,2,10,10),(6,1,5,325,2),(7,2,5,20,1),(8,1,6,325,2),(9,2,6,20,1),(10,1,7,325,2),(11,2,7,20,1),(12,1,8,325,2),(13,2,8,20,1),(14,1,9,325,2),(15,2,9,20,1),(16,1,10,325,1),(17,1,11,325,1),(18,1,12,325,1),(19,2,12,20,1),(20,1,13,325,1),(21,1,15,325,1);
/*!40000 ALTER TABLE `Order_Product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Order_Product_Lang`
--

DROP TABLE IF EXISTS `Order_Product_Lang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Order_Product_Lang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_product_id` int(11) NOT NULL,
  `lang` char(2) NOT NULL,
  `field` varchar(20) NOT NULL,
  `value` mediumtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Order_Product_Lang`
--

LOCK TABLES `Order_Product_Lang` WRITE;
/*!40000 ALTER TABLE `Order_Product_Lang` DISABLE KEYS */;
INSERT INTO `Order_Product_Lang` VALUES (1,1,'ru','name','Виталик'),(2,2,'ru','name','JW Сетчатый мяч 15 см - Зелёный'),(3,3,'ru','name','Test2'),(4,4,'ru','name','JW Сетчатый мяч 15 см - Зелёный'),(5,5,'ru','name','Test2'),(6,6,'ru','name','JW Сетчатый мяч 15 см - Зелёный'),(7,7,'ru','name','Test2'),(8,8,'ru','name','JW Сетчатый мяч 15 см - Зелёный'),(9,9,'ru','name','Test2'),(10,10,'ru','name','JW Сетчатый мяч 15 см - Зелёный'),(11,11,'ru','name','Test2'),(12,12,'ru','name','JW Сетчатый мяч 15 см - Зелёный'),(13,13,'ru','name','Test2'),(14,14,'ru','name','JW Сетчатый мяч 15 см - Зелёный'),(15,15,'ru','name','Test2'),(16,16,'ru','name','JW Сетчатый мяч 15 см - Зелёный'),(17,17,'ru','name','JW Сетчатый мяч 15 см - Зелёный'),(18,18,'ru','name','JW Сетчатый мяч 15 см - Зелёный'),(19,19,'ru','name','Test2'),(20,20,'ru','name','JW Сетчатый мяч 15 см - Зелёный'),(21,21,'ru','name','JW Сетчатый мяч 15 см - Зелёный');
/*!40000 ALTER TABLE `Order_Product_Lang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Page`
--

DROP TABLE IF EXISTS `Page`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Page` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(100) NOT NULL,
  `active` tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `Page_url_uindex` (`url`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Page`
--

LOCK TABLES `Page` WRITE;
/*!40000 ALTER TABLE `Page` DISABLE KEYS */;
INSERT INTO `Page` VALUES (2,'contacts',1),(4,'/',1);
/*!40000 ALTER TABLE `Page` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Page_Lang`
--

DROP TABLE IF EXISTS `Page_Lang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Page_Lang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_id` int(11) NOT NULL,
  `lang` char(2) NOT NULL,
  `field` varchar(20) NOT NULL,
  `value` mediumtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Page_Lang`
--

LOCK TABLES `Page_Lang` WRITE;
/*!40000 ALTER TABLE `Page_Lang` DISABLE KEYS */;
INSERT INTO `Page_Lang` VALUES (1,1,'ru','name','Test Page'),(2,1,'ru','text','<p>Abstract Factory (абстрактная фабрика) (93) Предоставляет интерфейс для создания семейств, связанных между собой, или независимых объектов, конкретные классы которых неизвестны. Adapter (адаптер) (141) Преобразует интерфейс класса в некоторый другой интерфейс, ожида- емый клиентами. Обеспечивает совместную работу классов, которая была бы невозможна без данного паттерна из-за несовместимости ин- терфейсов. Bridge (мост) (152) Отделяет абстракцию от реализации, благодаря чему появляется возмож- ность независимо изменять то и другое. Builder (строитель) (103) Отделяет конструирование сложного объекта от его представления, позво- ляя использовать один и тот же процесс конструирования для создания различных представлений. Chain of Responsibility (цепочка обязанностей) (217) Можно избежать жесткой зависимости отправителя запроса от его полу- чателя, при этом запросом начинает обрабатываться один из нескольких объектов. Объекты-получатели связываются в цепочку, и запрос переда- ется по цепочке, пока какой-то объект его не обработает. Command (команда) (226) Инкапсулирует запрос в виде объекта, позволяя тем самым параметризо- вывать клиентов типом запроса, устанавливать очередность запросов, про- токолировать их и поддерживать отмену выполнения операций.</p>\r\n'),(3,1,'en','name','Test Page'),(4,1,'en','text','<p>English version</p>\r\n'),(5,2,'en','name','Contact Us'),(6,2,'en','text','<p><strong>E-mail:</strong> <a href=\"mailto:salkova.yana@yandex.ua\">salkova.yana@yandex.ua</a></p>\r\n\r\n<p><strong>Phone:</strong> (066) 937-07-35<br />\r\n&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;(063) 655-05-03</p>\r\n\r\n<p><strong>Social:&nbsp;<a href=\"https://vk.com/emma_yana\" target=\"_blank\"><img alt=\"\" src=\"/storage/images/soc/v.png\" style=\"vertical-align:middle\" /></a>&nbsp;<a href=\"https://www.facebook.com/profile.php?id=100006609313772\" target=\"_blank\"><img alt=\"\" src=\"/storage/images/soc/f.png\" style=\"vertical-align:middle\" /></a></strong></p>\r\n'),(7,2,'ru','name','Контакты'),(8,2,'ru','text','<p><strong>E-mail:</strong> <a href=\"mailto:salkova.yana@yandex.ua\">salkova.yana@yandex.ua</a></p>\r\n\r\n<p><strong>Телефон:</strong> (066) 937-07-35<br />\r\n&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; (063) 655-05-03</p>\r\n\r\n<p><strong>Мы в соцсетях:&nbsp;<a href=\"https://vk.com/emma_yana\" target=\"_blank\"><img alt=\"\" src=\"/storage/images/soc/v.png\" style=\"vertical-align:middle\" /></a>&nbsp;<a href=\"https://www.facebook.com/profile.php?id=100006609313772\" target=\"_blank\"><img alt=\"\" src=\"/storage/images/soc/f.png\" style=\"vertical-align:middle\" /></a></strong></p>\r\n'),(9,3,'ru','name','Main'),(10,3,'ru','text','<p>Test</p>\r\n'),(11,4,'ru','name','Главная'),(12,4,'ru','text','<p>Добро пожаловать</p>\r\n'),(13,4,'en','name','Main'),(14,4,'en','text','<p>Welcome</p>\r\n');
/*!40000 ALTER TABLE `Page_Lang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Page_View`
--

DROP TABLE IF EXISTS `Page_View`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Page_View` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(100) NOT NULL,
  `pageId` int(11) DEFAULT NULL,
  `count` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Page_View`
--

LOCK TABLES `Page_View` WRITE;
/*!40000 ALTER TABLE `Page_View` DISABLE KEYS */;
/*!40000 ALTER TABLE `Page_View` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Page_View_Ip`
--

DROP TABLE IF EXISTS `Page_View_Ip`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Page_View_Ip` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pageViewId` int(11) NOT NULL,
  `ip` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Page_View_Ip`
--

LOCK TABLES `Page_View_Ip` WRITE;
/*!40000 ALTER TABLE `Page_View_Ip` DISABLE KEYS */;
/*!40000 ALTER TABLE `Page_View_Ip` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Photo`
--

DROP TABLE IF EXISTS `Photo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Photo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `albumId` int(11) NOT NULL,
  `resourceId` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Photo`
--

LOCK TABLES `Photo` WRITE;
/*!40000 ALTER TABLE `Photo` DISABLE KEYS */;
INSERT INTO `Photo` VALUES (3,1,93),(4,1,94);
/*!40000 ALTER TABLE `Photo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Photo_Album`
--

DROP TABLE IF EXISTS `Photo_Album`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Photo_Album` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(100) NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Photo_Album`
--

LOCK TABLES `Photo_Album` WRITE;
/*!40000 ALTER TABLE `Photo_Album` DISABLE KEYS */;
INSERT INTO `Photo_Album` VALUES (1,'dogs',1);
/*!40000 ALTER TABLE `Photo_Album` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Photo_Album_Lang`
--

DROP TABLE IF EXISTS `Photo_Album_Lang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Photo_Album_Lang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `photo_album_id` int(11) NOT NULL,
  `lang` char(2) NOT NULL,
  `field` varchar(20) NOT NULL,
  `value` mediumtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Photo_Album_Lang`
--

LOCK TABLES `Photo_Album_Lang` WRITE;
/*!40000 ALTER TABLE `Photo_Album_Lang` DISABLE KEYS */;
INSERT INTO `Photo_Album_Lang` VALUES (1,1,'ru','name','Собаки'),(2,1,'ru','description',''),(3,1,'en','name','Собаки'),(4,1,'en','description','');
/*!40000 ALTER TABLE `Photo_Album_Lang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Photo_Lang`
--

DROP TABLE IF EXISTS `Photo_Lang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Photo_Lang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `photo_id` int(11) NOT NULL,
  `lang` char(2) NOT NULL,
  `field` varchar(20) NOT NULL,
  `value` mediumtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Photo_Lang`
--

LOCK TABLES `Photo_Lang` WRITE;
/*!40000 ALTER TABLE `Photo_Lang` DISABLE KEYS */;
INSERT INTO `Photo_Lang` VALUES (5,3,'ru','name','photo2.jpg'),(6,3,'en','name','photo2.jpg'),(7,4,'ru','name','JW-Pet-Tough-By-Nature-Hol-ee-Roller-Assorted-Dog-Toy-88-cm-0-1.jpg'),(8,4,'en','name','JW-Pet-Tough-By-Nature-Hol-ee-Roller-Assorted-Dog-Toy-88-cm-0-1.jpg');
/*!40000 ALTER TABLE `Photo_Lang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Product`
--

DROP TABLE IF EXISTS `Product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(100) NOT NULL,
  `price` float(5,2) NOT NULL DEFAULT '0.00',
  `active` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `Product_url_uindex` (`url`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Product`
--

LOCK TABLES `Product` WRITE;
/*!40000 ALTER TABLE `Product` DISABLE KEYS */;
INSERT INTO `Product` VALUES (1,'jw-setchatyy-myach-15-sm-zelenyy',325.00,1),(2,'jw-setchatyy-myach-8-sm-sinii',300.00,1),(3,'jw-setchatyy-myach-15-sm-krasnyy',325.00,1),(4,'hyperflite-jawz--blue-',425.00,1),(5,'hyperflite-jawz--blue-_1',425.00,1),(6,'jw-setchatyy-myach-15-sm-krasnyy_1',325.00,1);
/*!40000 ALTER TABLE `Product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Product_Lang`
--

DROP TABLE IF EXISTS `Product_Lang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Product_Lang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `lang` char(2) NOT NULL,
  `field` varchar(20) NOT NULL,
  `value` mediumtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Product_Lang`
--

LOCK TABLES `Product_Lang` WRITE;
/*!40000 ALTER TABLE `Product_Lang` DISABLE KEYS */;
INSERT INTO `Product_Lang` VALUES (1,1,'ru','name','JW Сетчатый мяч 15 см - Зелёный'),(2,1,'ru','text','<p><em>Материал: каучук</em><br />\r\n<em>Размер: 15 см</em></p>\r\n\r\n<p>Сетчатый каучуковый мяч &quot;JW Hol-ee Roller&quot; - игрушка для собак из прочного эластичного каучука не позволит скучать вашему питомцу. Для большего интереса к игрушке, внутрь мяча можно поместить съедобное лакомство, косточку или любимую собакой вещь, подходящие по размеру. В этом случае питомец будет с интересом и инициативой продолжать игру.</p>\r\n'),(3,2,'ru','name','JW Сетчатый мяч 8 см - Синий'),(4,2,'ru','text',''),(5,1,'en','name','JW Holee-Roller 15cm - Green'),(6,1,'en','text',''),(7,2,'en','name','JW Holee-Roller 8 cm - Blue'),(8,2,'en','text',''),(9,3,'ru','name','JW Сетчатый мяч 15 см - Красный'),(10,3,'ru','text',''),(11,3,'en','name','JW Holee-Rolee 15cm - Red'),(12,3,'en','text',''),(13,4,'ru','name','Hyperflite Jawz (Blue)'),(14,4,'ru','text',''),(15,4,'en','name','Hyperflite Jawz (Blue)'),(16,4,'en','text',''),(17,5,'ru','name','Hyperflite Jawz (Blue)'),(18,5,'ru','text',''),(19,5,'en','name','Hyperflite Jawz (Blue)'),(20,5,'en','text',''),(21,6,'ru','name','JW Holee-Rolee 15cm - Red'),(22,6,'ru','text',''),(23,6,'en','name','JW Holee-Rolee 15cm - Red'),(24,6,'en','text','');
/*!40000 ALTER TABLE `Product_Lang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Product_Resource`
--

DROP TABLE IF EXISTS `Product_Resource`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Product_Resource` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `resourceId` int(11) NOT NULL,
  `productId` int(11) NOT NULL,
  `type` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=89 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Product_Resource`
--

LOCK TABLES `Product_Resource` WRITE;
/*!40000 ALTER TABLE `Product_Resource` DISABLE KEYS */;
INSERT INTO `Product_Resource` VALUES (75,77,1,2),(76,78,1,1),(81,83,2,2),(82,84,2,1),(83,85,3,2),(84,86,3,1),(87,89,4,2),(88,90,4,1);
/*!40000 ALTER TABLE `Product_Resource` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Product__Catalog`
--

DROP TABLE IF EXISTS `Product__Catalog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Product__Catalog` (
  `Catalog` int(11) NOT NULL,
  `Product` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Product__Catalog`
--

LOCK TABLES `Product__Catalog` WRITE;
/*!40000 ALTER TABLE `Product__Catalog` DISABLE KEYS */;
INSERT INTO `Product__Catalog` VALUES (1,1),(1,2),(1,3),(2,4),(2,5),(1,6);
/*!40000 ALTER TABLE `Product__Catalog` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Product__Filter`
--

DROP TABLE IF EXISTS `Product__Filter`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Product__Filter` (
  `Product` int(11) NOT NULL,
  `Filter` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Product__Filter`
--

LOCK TABLES `Product__Filter` WRITE;
/*!40000 ALTER TABLE `Product__Filter` DISABLE KEYS */;
INSERT INTO `Product__Filter` VALUES (2,2),(2,4),(1,2),(1,5),(3,2),(3,5),(6,2),(6,5);
/*!40000 ALTER TABLE `Product__Filter` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Resource`
--

DROP TABLE IF EXISTS `Resource`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Resource` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `src` varchar(100) NOT NULL,
  `storageId` tinyint(4) NOT NULL DEFAULT '1',
  `size` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=95 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Resource`
--

LOCK TABLES `Resource` WRITE;
/*!40000 ALTER TABLE `Resource` DISABLE KEYS */;
INSERT INTO `Resource` VALUES (77,'/storage/product/1/17.jpg',1,0),(78,'/storage/product/1/photo.jpg',1,0),(83,'/storage/product/2/JW-Pet-Tough-By-Nature-Hol-ee-Roller-Assorted-Dog-Toy-88-cm-0-1.jpg',1,0),(84,'/storage/product/2/photo.jpg',1,0),(85,'/storage/product/3/15.jpg',1,0),(86,'/storage/product/3/photo.jpg',1,0),(89,'/storage/product/4/XFJawzBLU.jpg',1,0),(90,'/storage/product/4/photo.jpg',1,0),(93,'/storage/photos/1/photo2.jpg',1,11365),(94,'/storage/photos/1/JW-Pet-Tough-By-Nature-Hol-ee-Roller-Assorted-Dog-Toy-88-cm-0-1.jpg',1,29948);
/*!40000 ALTER TABLE `Resource` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Setting`
--

DROP TABLE IF EXISTS `Setting`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(100) NOT NULL,
  `value` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Setting`
--

LOCK TABLES `Setting` WRITE;
/*!40000 ALTER TABLE `Setting` DISABLE KEYS */;
INSERT INTO `Setting` VALUES (1,'email','vitfollower@gmail.com'),(2,'sitename','Dog Frisbee');
/*!40000 ALTER TABLE `Setting` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Translation`
--

DROP TABLE IF EXISTS `Translation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Translation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `alias` varchar(100) NOT NULL,
  `type` varchar(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2212 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Translation`
--

LOCK TABLES `Translation` WRITE;
/*!40000 ALTER TABLE `Translation` DISABLE KEYS */;
INSERT INTO `Translation` VALUES (1,'Showing','admin'),(3,'of','admin'),(4,'entries','admin'),(5,'Translation','admin'),(6,'Add new catalog','admin'),(8,'Url','admin'),(9,'Active','admin'),(10,'Actions','admin'),(11,'Dashboard','admin'),(12,'Menu','admin'),(13,'Pages','admin'),(14,'Administrators','admin'),(15,'Catalog','admin'),(16,'Product','admin'),(17,'Database','admin'),(18,'Next','admin'),(19,'Are you sure you want to delete this item?','admin'),(20,'Are you sure you want to duplicate this item?','admin'),(21,'Edit','admin'),(22,'Duplicate','admin'),(23,'Delete','admin'),(24,'Previous','admin'),(26,'404','admin'),(27,'Not Found','admin'),(28,'Products','admin'),(29,'Add new product','admin'),(32,'Alias','admin'),(33,'Add new menu item','admin'),(35,'Type','admin'),(36,'Main Menu','admin'),(37,'Bottom Menu','admin'),(38,'Name','admin'),(39,'Add new page','admin'),(41,'Add new admin','admin'),(42,'Login','admin'),(43,'Export to file','admin'),(44,'User Profile','admin'),(45,'Settings','admin'),(46,'Logout','admin'),(881,'Add menu item','admin'),(882,'Save','admin'),(883,'Cancel','admin'),(920,'Text','admin'),(936,'Edit page','admin'),(942,'Edit administrator','admin'),(943,'Password','admin'),(949,'Add new administrator','admin'),(970,'Edit catalog','admin'),(991,'Edit product','admin'),(992,'Host','admin'),(993,'Username','admin'),(1094,'Add new translation','admin'),(1295,'Edit translation','admin'),(1550,'Edit menu item','admin'),(1943,'Site','admin'),(1944,'Edit','admin'),(2060,'Delete','admin'),(2076,'Filter','admin'),(2077,'Next page','admin'),(2078,'Previous page','admin'),(2079,'Login','app'),(2080,'Logout','app'),(2081,'Register','app'),(2082,'Password','app'),(2083,'Sign in','app'),(2084,'Users','admin'),(2085,'Add new user','admin'),(2086,'Edit user','admin'),(2087,'Profile','app'),(2088,'Photo','admin'),(2089,'Crop','admin'),(2090,'Information','admin'),(2091,'Photos','admin'),(2092,'Add to cart','app'),(2093,'Price','admin'),(2094,'Cart','app'),(2095,'Catalog','app'),(2096,'Name','app'),(2097,'Count','app'),(2098,'Price','app'),(2099,'Sum','app'),(2100,'Actions','app'),(2101,'Update cache','admin'),(2102,'Order','app'),(2103,'Save','app'),(2104,'First name','app'),(2105,'Last name','app'),(2106,'Phone','app'),(2107,'Address','app'),(2108,'Comment','app'),(2109,'remove','app'),(2110,'recalculate','app'),(2111,'First name','admin'),(2112,'Last name','admin'),(2113,'Phone','admin'),(2114,'Address','admin'),(2115,'Orders','admin'),(2116,'Add new order','admin'),(2117,'Edit order','admin'),(2118,'Sum','admin'),(2119,'Comment','admin'),(2120,'Date','admin'),(2121,'Count','admin'),(2122,'Cart is empty','app'),(2123,'Photo','app'),(2124,'Orders','app'),(2125,'Status','app'),(2126,'Date','app'),(2127,'Add new setting','admin'),(2128,'Key','admin'),(2129,'Value','admin'),(2130,'Edit setting','admin'),(2131,'E-Mail','app'),(2132,'Registration successfull','app'),(2133,'Registration successfull','app'),(2134,'Filters','admin'),(2135,'Add new filter set','admin'),(2136,'Description','admin'),(2137,'Edit filter set','admin'),(2138,'Infoblocks','admin'),(2141,'Products','app'),(2142,'Order details','app'),(2144,'details','app'),(2145,'New order','app'),(2146,'Mail templates','admin'),(2147,'Add new mail template','admin'),(2148,'Subject','admin'),(2149,'Body','admin'),(2150,'Edit template','admin'),(2151,'Add new filter','admin'),(2152,'Remove','admin'),(2153,'Group','admin'),(2159,'All categories','app'),(2160,'Sorting','app'),(2161,'default','app'),(2162,'from lower price','app'),(2163,'from higher price','app'),(2164,'Main','app'),(2165,'All','app'),(2166,'Authorization','app'),(2167,'Registration','app'),(2169,'UAH','app'),(2170,'Administrator groups','admin'),(2171,'Meta data','admin'),(2172,'Add new group','admin'),(2173,'Add group','admin'),(2174,'Edit group','admin'),(2175,'Modules','admin'),(2176,'Permissions','admin'),(2177,'Add new module','admin'),(2178,'Edit module','admin'),(2179,'Icon','admin'),(2180,'Deny','admin'),(2181,'View','admin'),(2182,'Manage','admin'),(2183,'Remember Me','admin'),(2184,'Symbol','admin'),(2185,'Rate','admin'),(2186,'Currency','admin'),(2187,'Add new currency','admin'),(2188,'Basic','admin'),(2189,'Symbol position','admin'),(2190,'Edit currency','admin'),(2191,'Left','admin'),(2192,'Right','admin'),(2193,'E-Mail','admin'),(2194,'Meta','admin'),(2195,'Add new meta','admin'),(2198,'Edit meta','admin'),(2199,'Yes','admin'),(2200,'No','admin'),(2202,'go to site','admin'),(2203,'Photo gallery','admin'),(2204,'Add new album','admin'),(2205,'Edit album','admin'),(2206,'Drop photos here','admin'),(2207,'удалить','admin'),(2208,'отмена','admin'),(2209,'Photos','app'),(2211,'Parent catalog','admin');
/*!40000 ALTER TABLE `Translation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Translation_Lang`
--

DROP TABLE IF EXISTS `Translation_Lang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Translation_Lang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `translation_id` int(11) NOT NULL,
  `lang` char(2) NOT NULL,
  `field` varchar(20) NOT NULL,
  `value` mediumtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=186 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Translation_Lang`
--

LOCK TABLES `Translation_Lang` WRITE;
/*!40000 ALTER TABLE `Translation_Lang` DISABLE KEYS */;
INSERT INTO `Translation_Lang` VALUES (1,16,'en','value','Product'),(2,16,'ru','value','Товар'),(3,1,'ru','value','Показано'),(4,2,'ru','value','до'),(5,4,'ru','value','записей'),(6,3,'ru','value','из'),(7,5,'ru','value','Перевод'),(8,6,'ru','value','Добавить новый каталог'),(9,8,'ru','value','Ссылка'),(10,9,'ru','value','Активен'),(11,10,'ru','value','Действия'),(12,11,'ru','value','Панель управления'),(13,12,'ru','value','Меню'),(14,13,'ru','value','Страницы'),(15,14,'ru','value','Администраторы'),(16,15,'ru','value','Каталог'),(17,17,'ru','value','База данных'),(18,18,'ru','value','Следующий'),(19,19,'ru','value','Вы уверены, что хотите удалить эту запись?'),(20,20,'ru','value','Вы уверены, что хотите дублировать эту запись?'),(21,21,'ru','value','Редактировать'),(22,22,'ru','value','Дублировать'),(23,23,'ru','value','Удалить'),(24,24,'ru','value','Предыдущий'),(25,26,'ru','value','404'),(26,27,'ru','value','Не найдено'),(27,28,'ru','value','Товары'),(28,29,'ru','value','Добавить новый товар'),(29,32,'ru','value','Алиас'),(30,33,'ru','value','Добавить новую запись'),(31,35,'ru','value','Тип'),(32,36,'ru','value','Главное меню'),(33,37,'ru','value','Нижнее меню'),(34,38,'ru','value','Имя'),(35,39,'ru','value','Добавить новую страницу'),(36,41,'ru','value','Добавить нового администратора'),(37,42,'ru','value','Логин'),(38,43,'ru','value','Экспортировать'),(39,44,'ru','value','Профиль'),(40,45,'ru','value','Настройки'),(41,46,'ru','value','Выйти'),(42,1295,'ru','value','Редактировать перевод'),(43,1094,'ru','value','Добавить перевод'),(44,993,'ru','value','Имя пользователя'),(45,992,'ru','value','Хост'),(46,991,'ru','value','Редактировать товар'),(47,970,'ru','value','Редактировать каталог'),(48,949,'ru','value','Добавить администратора'),(49,943,'ru','value','Пароль'),(50,942,'ru','value','Редактировать администратора'),(51,936,'ru','value','Редактировать страницу'),(52,920,'ru','value','Текст'),(53,883,'ru','value','Отмена'),(54,882,'ru','value','Сохранить'),(55,881,'ru','value','Добавить элемент меню'),(56,1550,'ru','value','Редактировать элемент меню'),(57,1944,'ru','value','Редактировать'),(58,2060,'ru','value','Удалить'),(59,1943,'ru','value','Сайт'),(60,2076,'ru','value','Фильтровать'),(61,2078,'ru','value','Назад'),(62,2077,'ru','value','Вперёд'),(63,2079,'ru','value','Логин'),(64,2080,'ru','value','Выйти'),(65,2081,'ru','value','Регистрация'),(66,2082,'ru','value','Пароль'),(67,2083,'ru','value','Войти'),(68,2084,'ru','value','Пользователи'),(69,2085,'ru','value','Добавить пользователя'),(70,2087,'ru','value','Профиль'),(71,2086,'ru','value','Редактировать пользователя'),(72,2088,'ru','value','Фото'),(73,2089,'ru','value','Кадрировать'),(74,2090,'ru','value','Информация'),(75,2091,'ru','value','Фото'),(76,2092,'ru','value','В корзину'),(77,2094,'ru','value','Корзина'),(78,2095,'ru','value','Каталог'),(79,2096,'ru','value','Имя'),(80,2097,'ru','value','Количество'),(81,2099,'ru','value','Сумма'),(82,2098,'ru','value','Цена'),(83,2100,'ru','value','Действия'),(84,2093,'ru','value','Цена'),(85,2101,'ru','value','Обновить кеш'),(86,2102,'ru','value','Заказать'),(87,2103,'ru','value','Сохранить'),(88,2104,'ru','value','Имя'),(89,2105,'ru','value','Фамилия'),(90,2106,'ru','value','Телефон'),(91,2107,'ru','value','Адрес'),(92,2108,'ru','value','Комментарий'),(93,2109,'ru','value','удалить'),(94,2110,'ru','value','пересчитать'),(95,2114,'ru','value','Адрес'),(96,2111,'ru','value','Имя'),(97,2112,'ru','value','Фамилия'),(98,2113,'ru','value','Телефон'),(99,2115,'ru','value','Заказы'),(100,2116,'ru','value','Добавить новый заказ'),(101,2117,'ru','value','Редактировать заказ'),(102,2118,'ru','value','Сумма'),(103,2119,'ru','value','Комментарий'),(104,2120,'ru','value','Дата'),(105,2121,'ru','value','Количество'),(106,2122,'ru','value','Корзина пуста'),(107,2123,'ru','value','Фото'),(108,2124,'ru','value','Заказы'),(109,2125,'ru','value','Статус'),(110,2126,'ru','value','Дата'),(111,2127,'ru','value','Добавить новый параметр'),(112,2128,'ru','value','Ключ'),(113,2129,'ru','value','Значение'),(114,2130,'ru','value','Редактировать параметр'),(115,2132,'ru','value','Регистрация завершена'),(116,2133,'ru','value','Регистрация завершена'),(117,2134,'ru','value','Фильтры'),(118,2135,'ru','value','Добавить группу фильтров'),(119,2136,'ru','value','Описание'),(120,2137,'ru','value','Редактировать набор фильтов'),(121,2138,'ru','value','Инфоблоки'),(122,2141,'ru','value','Товары'),(123,2142,'ru','value','Детали заказа'),(124,2144,'ru','value','подробнее'),(125,2145,'ru','value','Новый заказ'),(126,2150,'ru','value','Редактировать шаблон'),(127,2149,'ru','value','Тело'),(128,2148,'ru','value','Тема'),(129,2147,'ru','value','Добавить новый шаблон'),(130,2146,'ru','value','Шаблоны писем'),(131,2152,'ru','value','Удалить'),(132,2151,'ru','value','Добавить фильтр'),(133,2153,'ru','value','Группа'),(134,2154,'ru','value','by default'),(135,2155,'ru','value','from lower price'),(136,2156,'ru','value',''),(137,2157,'ru','value','Sorting'),(138,2158,'ru','value','All categories'),(139,2156,'en','value',''),(140,2159,'ru','value','Все категории'),(141,2160,'ru','value','Сортировка'),(142,2161,'ru','value','по-умолчанию'),(143,2162,'ru','value','от дешевых к дорогим'),(144,2163,'ru','value','от дорогих к дешевым'),(145,2164,'ru','value','Главная'),(146,2165,'ru','value','Все'),(147,2166,'ru','value','Авторизация'),(148,2167,'ru','value','Регистрация'),(149,2168,'ru','value','UAH'),(150,2169,'ru','value','грн'),(151,2170,'ru','value','Группы администраторов'),(152,2171,'ru','value','Мета данные'),(153,2146,'en','value',''),(154,2172,'ru','value','Добавить группу'),(155,2173,'ru','value','Добавить группу'),(156,2174,'ru','value','Редактировать группу'),(157,2176,'ru','value',' Права доступа'),(158,2177,'ru','value','Добавить модуль'),(159,2175,'ru','value','Модули'),(160,2178,'ru','value','Редактировать модуль'),(161,2179,'ru','value','Иконка'),(162,2180,'ru','value','Запретить'),(163,2181,'ru','value','Просмотр'),(164,2182,'ru','value','Управление'),(165,2183,'ru','value','Запомнить'),(166,2184,'ru','value','Символ'),(167,2185,'ru','value','Курс'),(168,2186,'ru','value','Валюта'),(169,2187,'ru','value','Добавить валюту'),(170,2188,'ru','value','Базовая'),(171,2189,'ru','value','Позиция символа'),(172,2190,'ru','value','Редактировать валюту'),(173,2191,'ru','value','Слева'),(174,2192,'ru','value','Справа'),(175,2194,'ru','value','Мета данные'),(176,2195,'ru','value','Добавить мета данные'),(177,2198,'ru','value','Редактировать мета данные'),(178,2199,'ru','value','Да'),(179,2200,'ru','value','Нет'),(180,2202,'ru','value','перейти на сайт'),(181,2203,'ru','value','Фотогалерея'),(182,2204,'ru','value','Добавить альбом'),(183,2205,'ru','value','Редактировать альбом'),(184,2209,'ru','value','Фото'),(185,2211,'ru','value','Родительский каталог');
/*!40000 ALTER TABLE `Translation_Lang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `User`
--

DROP TABLE IF EXISTS `User`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `User` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `User_login_uindex` (`login`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `User`
--

LOCK TABLES `User` WRITE;
/*!40000 ALTER TABLE `User` DISABLE KEYS */;
INSERT INTO `User` VALUES (1,'test_user','81dc9bdb52d04dc20036dbd8313ed055',1),(10,'vitaliy_daun','827ccb0eea8a706c4c34a16891f84e7b',1),(11,'test_reg','e10adc3949ba59abbe56e057f20f883e',1),(12,'test','81dc9bdb52d04dc20036dbd8313ed055',1);
/*!40000 ALTER TABLE `User` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `User_Info`
--

DROP TABLE IF EXISTS `User_Info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `User_Info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `email` varchar(50) NOT NULL DEFAULT '',
  `firstName` varchar(100) NOT NULL,
  `lastName` varchar(100) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `User_Info`
--

LOCK TABLES `User_Info` WRITE;
/*!40000 ALTER TABLE `User_Info` DISABLE KEYS */;
INSERT INTO `User_Info` VALUES (1,1,'vitfollower@gmail.com','test','test','1434134134','Rabina 1'),(10,10,'vitfollower@gmail.com','Виталий','Малышев','063 655 05 03','Рабина 14'),(11,11,'vitfollower@gmail.com','Анатолий','Вассерман','123','123'),(12,12,'vitfollower@gmail.com','Вася','Петин','25245','');
/*!40000 ALTER TABLE `User_Info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `User_Session`
--

DROP TABLE IF EXISTS `User_Session`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `User_Session` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `entity` varchar(100) NOT NULL,
  `hash` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `User_Session`
--

LOCK TABLES `User_Session` WRITE;
/*!40000 ALTER TABLE `User_Session` DISABLE KEYS */;
INSERT INTO `User_Session` VALUES (10,3,'User','abb23151ac82ddd79fe5705615d96547'),(11,4,'User','abb23151ac82ddd79fe5705615d96547'),(12,6,'User','abb23151ac82ddd79fe5705615d96547'),(16,9,'User','1ab597754eefe507567e4eac0c87cd75'),(18,11,'User','3a1f0d75a1133d6b8aec48b1cd55c0ae'),(19,2,'Admin','39f594f34ba6dfbf666aa8aca4153798'),(20,1,'Admin','106ebb14aea48e189224c2554b708dbb'),(21,12,'User','1ca1c147a1ecbeb2fe51954ffef31d17');
/*!40000 ALTER TABLE `User_Session` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-12-15 11:34:33
