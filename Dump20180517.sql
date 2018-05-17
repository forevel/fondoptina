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
INSERT INTO `menu` VALUES (5,'Главная',0,'main.php',0),(6,'Проекты',0,'projects.php',1),(8,'Контакты',0,'contacts.php',2),(9,'Православная гимназия г. Козельска',6,'projectpage.php?id=1',0),(10,'Школа с. Покровск',6,'projectpage.php?id=2',0);
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
  `deleted` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `news`
--

LOCK TABLES `news` WRITE;
/*!40000 ALTER TABLE `news` DISABLE KEYS */;
INSERT INTO `news` VALUES (1,'Запущен редактор новостей','В разделе администрирования особо приближённым доступна теперь возможность добавлять, редактировать и удалять новости для правой колонки. Очень надеюсь, что эта возможность будет весьма востребована нашими драгоценными редакторами.','2018-04-22','admin',0),(2,'Группа ВКонтакте','Вконтакте теперь есть группа нашего Фонда: <a href=\"https://vk.com/club159379276\">Благотворительный фонд Амвросия Оптинского</a>','2018-05-17','admin',0);
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
  `title` text COMMENT 'Ссылка на проект',
  `content` text,
  `deleted` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `id_2` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `projects`
--

LOCK TABLES `projects` WRITE;
/*!40000 ALTER TABLE `projects` DISABLE KEYS */;
INSERT INTO `projects` VALUES (1,'Православная гимназия г. Козельска',54.03750,35.78970,'Православная гимназия г. Козельска',3,'Православная гимназия г. Козельска','Негосударственное общеобразовательное учреждение «Православная гимназия в г. Козельске» является православным образовательным учреждением, реализующим программы начального, основного и среднего общего образования в соответствии с Федеральными Государственными Образовательными Стандартами, программы вероучительных дисциплин в соответствии со Стандартом Православного компонента, программы дополнительного образования, а также систему духовно-нравственного воспитания.\r\n\r\nГимназия имеет бессрочную лицензию и государственную аккредитацию образовательной деятельности сроком до 2026г.\r\n\r\nВ настоящее время в гимназии числится 131 учащийся, работают 24 сотрудника.\r\n\r\nКозельская православная гимназия была основана в 1997 году по благословению митрополита Калужского и Боровского Климента при содействии и духовной поддержке оптинского старца схиархимандрита Илия. С тех пор в гимназии непрерывно реализуется духовно-нравственное воспитание детей на основе традиционных для русского человека православных духовных ценностей, под благодатным покровом Оптиной Пустыни.\r\n\r\nВ гимназии имеются все классы с первого по одиннадцатый, выдаются государственные аттестаты. Максимальное количество учащихся в классе – 17 чел., минимальное – 6, среднее наполняемость класса – 12 человек.\r\n\r\nПреподаются все предметы общего образования в соответствии с базисным учебным планом.\r\n\r\nПравославный компонент общего образования представлен, в соответствии со Стандартом, учебными предметами «Основы Православной веры» (по 1 часу в неделю с 1 по 11 класс), «Церковнославянский язык» (по 1 часу в неделю в 7-10 классах) и «Церковное пение» (по 1 часу в неделю во 2-8 классах).\r\n\r\nВ рамках молитвенно-трудового воспитания организуется летняя трудовая практика на хозяйственных подворьях близлежащих монастырей, помощь по уборке урожая, волонтерские выезды к пенсионерам, инвалидам, молитвенно-трудовое окормление воинских захоронений, а также регулярные выезды на трудовые послушания в рамках акции «Поможем храму».\r\n\r\nНОУ \"Православная гимназия в г. Козельске\" нуждается в спонсорской помощи для полноценной реализации учебной и воспитательной работы. По причине сравнительно небольшого количества учащихся государственного финансирования не хватает для выплаты достойной зарплаты всем учителям и сотрудникам, трудящимся над духовно-нравственным воспитанием детей. Также имеется острая нехватка учебной площади. Гимназия располагается в старом столетнем деревянном здании, обложенном кирпичом, с кирпичной пристройкой. Для занятий имеются всего 7 кабинетов, 2 из которых вмещают по 18 чел., остальные – по 12-14. Нет спортивного зала, библиотеки, трудовых мастерских, отдельного компьютерного класса.\r\n\r\nВ настоящее время ведется работа над проектированием нового трехэтажного учебного корпуса. Однако средств для реализации этого дорогостоящего проекта у гимназии пока не имеется.',0),(2,'Школа с. Покровск',54.11460,35.62550,'Школа с. Покровск',3,'Школа с. Покровск','История Покровской школы начинается с 1898 года, когда в селе Покровск Костешовской волости Козельского уезда при церкви была открыта церковно-приходская школа. Помещалась она в собственном доме священника. С 1916 года в Покровской церковно-приходской школе начал учительствовать Беляев Иван Петрович. В 30-е годы Беляев И.П., желая сохранить Покровскую церковь от разрушения, добился создания в ней 7-летней школы. В 1960 году школа стала 8-летней.\r\n\r\nВ 1979 году в д. Покровск построили новую двухэтажную школу по типовому проекту. Строительство здания новой 8-летней школы шло, когда директором школы был Чеглаков Александр Егорович. К 1990 году назрела необходимость в полном среднем общем образовании, и по просьбе родителей, школа была преобразована в среднюю общеобразовательную школу. С 1 сентября 2008 года, в связи с комплексной прогроаммой модернизации образования, школа вновь стала основной общеобразовательной школой. Открыта группа предшкольной подготовки детей с 5,5 лет.\r\n\r\nС июля 2011 года название школы изменилось на Муниципальное бюджетное общеобразовательное учреждение, а с января 2012 года название школы стало Муниципальное казённое общеобразовательное учреждение.\r\n\r\nВ настоящее время в школе реализуются основная общеобразовательная программа начального общего образования, основная общеобразовательная программа основного общего образования, дополнительные программы следующих направленностей: художественно-эстетической; физкультурно-спортивной; социально-педагогической; военно-патриотической; научно-технической; подготовка детей к школе.',0);
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
INSERT INTO `staticpages` VALUES (1,'main','Фонд Оптина - Главная','Благотворительный образовательный фонд во имя Преподобного Амвросия Оптинского и всех старцев Оптинских создан в 2017 году для оказания материальной помощи многодетным и малоимущим семьям, а также сельским школам Козельского района Калужской области. Так же фонд оказывает постоянную помощь православной гимназии в г. Козельске и детскому культурно-оздоровительному центру имени Святых Флора и Лавра.',NULL,NULL,0),(2,'projects','Фонд Оптина - Проекты','',NULL,NULL,0),(3,'footer','Подвал','<p class=\"small\">&copy; <a href=\"https://vk.com/id1686076\" target=\"_blank\">Evel</a>, 2017-2018</p>',NULL,NULL,0),(4,'header','angel2.png','Благотворительный образовательный фонд помощи малоимущим, многодетным семьям и детям в трудной ситуации',NULL,NULL,0),(5,'contacts','Фонд Оптина - Контакты','<h1>Контакты</h1><h3>Телефоны для связи</h3><p>Куклина Марина Владимировна:    +7 910 864 43 31<br>Некрасова Елена Владимировна:    +7 985 922 15 46</p>',NULL,NULL,0);
/*!40000 ALTER TABLE `staticpages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `symbolpics`
--

DROP TABLE IF EXISTS `symbolpics`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `symbolpics` (
  `id` int(11) NOT NULL,
  `idcat` int(11) DEFAULT NULL,
  `url` text,
  `deleted` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `symbolpics`
--

LOCK TABLES `symbolpics` WRITE;
/*!40000 ALTER TABLE `symbolpics` DISABLE KEYS */;
INSERT INTO `symbolpics` VALUES (1,1,'heartg.png',0),(2,2,'heartp.png',0),(3,3,'building.png',0),(4,4,'christ.png',0);
/*!40000 ALTER TABLE `symbolpics` ENABLE KEYS */;
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
  `deleted` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idusers`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin','$2y$10$CL8vKzVU9CML3QCDTTisle4zF6MUU37OnQnH3sRnx0bnWX.XR0kiO',4,0);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `workpics`
--

DROP TABLE IF EXISTS `workpics`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `workpics` (
  `id` int(11) NOT NULL,
  `url` text,
  `idwork` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `workpics`
--

LOCK TABLES `workpics` WRITE;
/*!40000 ALTER TABLE `workpics` DISABLE KEYS */;
INSERT INTO `workpics` VALUES (1,'/img/christ.png',1);
/*!40000 ALTER TABLE `workpics` ENABLE KEYS */;
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
  `descr` text NOT NULL COMMENT 'Описание',
  `moneyneed` int(15) NOT NULL COMMENT 'Денег надо',
  `moneygot` int(15) NOT NULL COMMENT 'Денег собрано',
  `workprogress` int(5) NOT NULL COMMENT 'Процент выполнения работы',
  `moneystarted` date NOT NULL COMMENT 'Сбор средств начат',
  `moneyfinished` date NOT NULL COMMENT 'Сбор средств закончен',
  `workstarted` date NOT NULL COMMENT 'Работы начаты',
  `workfinished` date NOT NULL COMMENT 'Работы закончены',
  `pic` text,
  `picfull` text,
  `deleted` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_2` (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `works`
--

LOCK TABLES `works` WRITE;
/*!40000 ALTER TABLE `works` DISABLE KEYS */;
INSERT INTO `works` VALUES (1,2,'Спортзал','<h2>Спортзал</h2><p>Спортзал в школе находится в плачевном состоянии</p>',15000,7000,70,'2018-05-06','0000-00-00','0000-00-00','0000-00-00','/img/IMG_8168.png','/img/IMG_8168_full.JPG',0),(2,2,'Спортзал2','Спортзал2',3750,2000,25,'2018-05-07','0000-00-00','0000-00-00','0000-00-00','/img/IMG_9129.jpg','/img/IMG_9129_full.JPG',0);
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

-- Dump completed on 2018-05-17 13:02:41
