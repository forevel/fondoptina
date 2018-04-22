-- MySQL dump 10.13  Distrib 5.7.9, for Win32 (AMD64)
--
-- Host: localhost    Database: cr42072_0
-- ------------------------------------------------------
-- Server version	5.5.5-10.1.29-MariaDB

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
-- Table structure for table `content`
--

DROP TABLE IF EXISTS `content`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `content` (
  `id` int(11) NOT NULL,
  `content` text,
  `deleted` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `content`
--

LOCK TABLES `content` WRITE;
/*!40000 ALTER TABLE `content` DISABLE KEYS */;
INSERT INTO `content` VALUES (1,'<h2>ШКОЛА С. ПОКРОВСК КОЗЕЛЬСКОГО РАЙОНА КАЛУЖСКОЙ ОБЛ.</h2><p>История Покровской школы начинается с 1898 года, когда в селе Покровск Костешовской волости Козельского уезда при церкви была открыта церковно-приходская школа. Помещалась она в собственном доме священника. С 1916 года в Покровской церковно-приходской школе начал учительствовать Беляев Иван Петрович. В 30-е годы Беляев И.П., желая сохранить Покровскую церковь от разрушения, добился создания в ней 7-летней школы. В 1960 году школа стала 8-летней.</p><p>В 1979 году в д. Покровск построили новую двухэтажную школу по типовому проекту. Строительство здания новой 8-летней школы шло, когда директором школы был Чеглаков Александр Егорович. К 1990 году назрела необходимость в полном среднем общем образовании, и по просьбе родителей, школа была преобразована в среднюю общеобразовательную школу. С 1 сентября 2008 года, в связи с комплексной прогроаммой модернизации образования, школа вновь стала основной общеобразовательной школой. Открыта группа предшкольной подготовки детей с 5,5 лет.</p><p>С июля 2011 года название школы изменилось на Муниципальное бюджетное общеобразовательное учреждение, а с января 2012 года название школы стало Муниципальное казённое общеобразовательное учреждение.</p><p>В настоящее время в школе реализуются основная общебразовательная программа начального общего образования, основная общеобразовательная программа основного общего образования, дополнительные программы следующих направленностей: художественно-эстетической; физкультурно-спортивной; социально-педагогической; военно-патриотической; научно-технической; подготовка детей к школе.</p>',0);
/*!40000 ALTER TABLE `content` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menu`
--

DROP TABLE IF EXISTS `menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `idalias` int(11) NOT NULL DEFAULT '0',
  `url` varchar(511) DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu`
--

LOCK TABLES `menu` WRITE;
/*!40000 ALTER TABLE `menu` DISABLE KEYS */;
INSERT INTO `menu` VALUES (3,'Школа с. Покровск',6,'projectpage.php?id=1',0),(5,'Главная',0,'projectpage.php?id=2',0),(6,'Проекты',0,'#',1),(8,'Контакты',0,'contacts.php',2);
/*!40000 ALTER TABLE `menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `news`
--

DROP TABLE IF EXISTS `news`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `caption` varchar(45) DEFAULT NULL,
  `contents` text,
  `date` date DEFAULT NULL,
  `user` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `news`
--

LOCK TABLES `news` WRITE;
/*!40000 ALTER TABLE `news` DISABLE KEYS */;
INSERT INTO `news` VALUES (1,'Запущен редактор новостей','В разделе администрирования особо приближённым доступна теперь возможность добавлять, редактировать и удалять новости для правой колонки. Очень надеюсь, что эта возможность будет весьма востребована нашими драгоценными редакторами.','2018-04-22','admin');
/*!40000 ALTER TABLE `news` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `contents` text NOT NULL,
  `type` int(11) DEFAULT NULL,
  `img` varchar(511) DEFAULT NULL,
  `url` varchar(511) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `user` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posts`
--

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `projectimages`
--

DROP TABLE IF EXISTS `projectimages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `projectimages` (
  `id` int(11) NOT NULL,
  `url` varchar(1023) DEFAULT NULL,
  `projid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `projectimages`
--

LOCK TABLES `projectimages` WRITE;
/*!40000 ALTER TABLE `projectimages` DISABLE KEYS */;
INSERT INTO `projectimages` VALUES (1,'upload/18/01/28/476_n.jpg',2),(2,'upload/18/01/28/16.jpg',2);
/*!40000 ALTER TABLE `projectimages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `projects`
--

DROP TABLE IF EXISTS `projects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `projects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT 'Наименование проекта',
  `lat` decimal(10,5) NOT NULL COMMENT 'Широта',
  `log` decimal(10,5) NOT NULL COMMENT 'Долгота',
  `descr` varchar(255) DEFAULT NULL COMMENT 'Описание проекта',
  `cat` int(2) NOT NULL COMMENT 'Категория проекта',
  `idcontent` int(11) DEFAULT NULL COMMENT 'Ссылка на проект',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `id_2` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `projects`
--

LOCK TABLES `projects` WRITE;
/*!40000 ALTER TABLE `projects` DISABLE KEYS */;
INSERT INTO `projects` VALUES (1,'Православная гимназия г. Козельска',54.03750,35.78970,'Православная гимназия г. Козельска',0,0),(2,'Школа с. Покровск',54.11460,35.62550,'Школа с. Покровск',3,1),(3,'Семья Куклиных',54.03710,35.79800,'Семья Куклиных',1,0),(4,'Церковь Зачатия Иоанна Предтечи в Губино',53.99780,35.71650,'Церковь Зачатия Иоанна Предтечи в Губино',2,0),(5,'Девушка-студентка',54.01970,35.78300,'Девушка-студентка',0,0);
/*!40000 ALTER TABLE `projects` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `staticpages`
--

DROP TABLE IF EXISTS `staticpages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `staticpages` (
  `id` int(11) NOT NULL,
  `pagename` tinytext,
  `title` text,
  `contents` longtext,
  `style` longtext,
  `head` longtext,
  `deleted` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staticpages`
--

LOCK TABLES `staticpages` WRITE;
/*!40000 ALTER TABLE `staticpages` DISABLE KEYS */;
INSERT INTO `staticpages` VALUES (1,'main','Главная','Благотворительный образовательный фонд во имя Преподобного Амвросия Оптинского и всех старцев Оптинских создан в 2017 году для оказания материальной помощи многодетным и малоимущим семьям, а также сельским школам Козельского района Калужской области. Так же фонд оказывает постоянную помощь православной гимназии в г. Козельске и детскому культурно-оздоровительному центру имени Святых Флора и Лавра.',NULL,NULL,0),(3,'footer','Подвал','<p class=\"small\">&copy; <a href=\"https://vk.com/id1686076\" target=\"_blank\">Evel</a>, 2017</p>',NULL,NULL,0),(4,'header','angel.png','Благотворительный образовательный фонд помощи малоимущим, многодетным семьям и детям в трудной ситуации',NULL,NULL,0),(5,'contacts','Контакты','<h1>Контакты</h1><h3>Телефоны для связи</h3><p>Куклина Марина Владимировна:    +7 910 864 43 31<br>Некрасова Елена Владимировна:    +7 985 922 15 46</p>',NULL,NULL,0);
/*!40000 ALTER TABLE `staticpages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `idusers` int(11) NOT NULL,
  `user` varchar(45) DEFAULT NULL,
  `psw` varchar(255) DEFAULT NULL,
  `rights` int(11) DEFAULT NULL,
  PRIMARY KEY (`idusers`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin','$2y$10$CL8vKzVU9CML3QCDTTisle4zF6MUU37OnQnH3sRnx0bnWX.XR0kiO',4);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `works`
--

DROP TABLE IF EXISTS `works`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `works` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idprojects` int(4) NOT NULL,
  `name` varchar(128) NOT NULL COMMENT 'Наименование работы',
  `descr` int(11) NOT NULL COMMENT 'Описание',
  `moneyneed` int(15) NOT NULL COMMENT 'Денег надо',
  `moneygot` int(15) NOT NULL COMMENT 'Денег собрано',
  `workprogress` int(5) NOT NULL COMMENT 'Процент выполнения работы',
  `moneystarted` date NOT NULL COMMENT 'Сбор средств начат',
  `moneyfinished` date NOT NULL COMMENT 'Сбор средств закончен',
  `workstarted` date NOT NULL COMMENT 'Работы начаты',
  `workfinished` date NOT NULL COMMENT 'Работы закончены',
  `url` varchar(256) NOT NULL COMMENT 'Ссылка на работу',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_2` (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `works`
--

LOCK TABLES `works` WRITE;
/*!40000 ALTER TABLE `works` DISABLE KEYS */;
/*!40000 ALTER TABLE `works` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-04-22 22:50:39
